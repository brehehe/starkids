<?php

namespace App\Services\Promotion;

use App\Models\Product\Product;
use App\Models\Promotion\PromotionSimplified;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class PromotionServiceNew
{
    /**
     * Apply promotions to a product price
     */
    public function applyPromotionsToProduct($productId, $quantity = 1, $userId = null, $companyId = null)
    {
        try {
            $product = Product::with('productPrice')->find($productId);
            if (! $product || ! $product->productPrice) {
                return [
                    'original_price' => 0,
                    'final_price' => 0,
                    'discount_amount' => 0,
                    'discount_percentage' => 0,
                    'applied_promotions' => [],
                ];
            }

            $originalPrice = $product->productPrice->price * $quantity;
            $bestPromotion = $this->findBestPromotion($productId, $originalPrice, $userId, $companyId);

            if (! $bestPromotion) {
                return [
                    'original_price' => $originalPrice,
                    'final_price' => $originalPrice,
                    'discount_amount' => 0,
                    'discount_percentage' => 0,
                    'applied_promotions' => [],
                ];
            }

            $discountAmount = $this->calculateDiscount($bestPromotion, $originalPrice, $quantity);
            $finalPrice = max(0, $originalPrice - $discountAmount);
            $discountPercentage = $originalPrice > 0 ? ($discountAmount / $originalPrice) * 100 : 0;

            return [
                'original_price' => $originalPrice,
                'final_price' => $finalPrice,
                'discount_amount' => $discountAmount,
                'discount_percentage' => $discountPercentage,
                'applied_promotions' => [$bestPromotion],
                'promotion_details' => [
                    'id' => $bestPromotion->id,
                    'name' => $bestPromotion->name,
                    'code' => $bestPromotion->code,
                    'type' => $bestPromotion->type,
                    'discount_type' => $bestPromotion->discount_type,
                    'discount_value' => $bestPromotion->discount_value,
                ],
            ];
        } catch (\Exception $e) {
            Log::error('Error applying promotion to product: '.$e->getMessage());

            return [
                'original_price' => 0,
                'final_price' => 0,
                'discount_amount' => 0,
                'discount_percentage' => 0,
                'applied_promotions' => [],
            ];
        }
    }

    /**
     * Find the best applicable promotion for a product
     */
    public function findBestPromotion($productId, $totalAmount, $userId = null, $companyId = null)
    {
        $now = Carbon::now();
        $currentDay = strtolower($now->format('l'));
        $currentTime = $now->format('H:i:s');

        $promotions = PromotionSimplified::where('is_active', true)
            ->where('company_id', $companyId ?? Auth::user()->company_id ?? 1)
            ->where(function ($query) use ($now) {
                $query->whereNull('start_date')
                    ->orWhere('start_date', '<=', $now);
            })
            ->where(function ($query) use ($now) {
                $query->whereNull('end_date')
                    ->orWhere('end_date', '>=', $now);
            })
            ->where(function ($query) use ($currentTime) {
                $query->whereNull('start_time')
                    ->orWhere('start_time', '<=', $currentTime);
            })
            ->where(function ($query) use ($currentTime) {
                $query->whereNull('end_time')
                    ->orWhere('end_time', '>=', $currentTime);
            })
            ->where(function ($query) use ($currentDay) {
                $query->whereNull('applicable_days')
                    ->orWhereJsonContains('applicable_days', $currentDay);
            })
            ->where(function ($query) use ($totalAmount) {
                $query->where('minimum_purchase', '<=', $totalAmount)
                    ->orWhere('minimum_purchase', 0);
            })
            ->orderBy('priority', 'desc')
            ->get();

        $bestPromotion = null;
        $bestDiscount = 0;

        foreach ($promotions as $promotion) {
            // Check if promotion applies to this product
            if (! $this->isPromotionApplicableToProduct($promotion, $productId)) {
                continue;
            }

            // Check if promotion applies to this user
            if (! $this->isPromotionApplicableToUser($promotion, $userId)) {
                continue;
            }

            // Check quota limits
            if (! $this->isPromotionQuotaAvailable($promotion, $userId)) {
                continue;
            }

            // Calculate potential discount
            $discount = $this->calculateDiscount($promotion, $totalAmount, 1);

            if ($discount > $bestDiscount) {
                $bestDiscount = $discount;
                $bestPromotion = $promotion;
            }
        }

        return $bestPromotion;
    }

    /**
     * Check if promotion applies to specific product
     */
    private function isPromotionApplicableToProduct($promotion, $productId)
    {
        if ($promotion->target_type === 'all') {
            return true;
        }

        if ($promotion->target_type === 'products') {
            $selectedProducts = $promotion->selected_products ?? [];

            return in_array($productId, $selectedProducts);
        }

        return false;
    }

    /**
     * Check if promotion applies to specific user
     */
    private function isPromotionApplicableToUser($promotion, $userId)
    {
        if (! $userId || $promotion->target_type === 'all') {
            return true;
        }

        if ($promotion->target_type === 'users') {
            $selectedUsers = $promotion->selected_users ?? [];

            return in_array($userId, $selectedUsers);
        }

        if ($promotion->target_type === 'companies') {
            $user = User::find($userId);
            if ($user) {
                $selectedCompanies = $promotion->selected_companies ?? [];

                return in_array($user->company_id, $selectedCompanies);
            }
        }

        return false;
    }

    /**
     * Check if promotion quota is still available
     */
    private function isPromotionQuotaAvailable($promotion, $userId)
    {
        if ($promotion->is_unlimited) {
            return true;
        }

        // Check total quota
        if ($promotion->total_quota > 0 && $promotion->used_count >= $promotion->total_quota) {
            return false;
        }

        // Check per-user quota (would need a usage tracking table)
        // For now, we'll assume it's available
        return true;
    }

    /**
     * Calculate discount amount based on promotion type
     */
    public function calculateDiscount($promotion, $totalAmount, $quantity = 1)
    {
        switch ($promotion->type) {
            case 'discount':
                return $this->calculateDiscountPromotion($promotion, $totalAmount);
            case 'buy_x_get_y':
                return $this->calculateBuyXGetYPromotion($promotion, $totalAmount, $quantity);
            case 'bundle':
                return $this->calculateBundlePromotion($promotion, $totalAmount);
            case 'special':
                return $this->calculateSpecialPromotion($promotion, $totalAmount);
            default:
                return 0;
        }
    }

    /**
     * Calculate discount for regular discount promotion
     */
    private function calculateDiscountPromotion($promotion, $totalAmount)
    {
        switch ($promotion->discount_type) {
            case 'percentage':
                $discount = ($totalAmount * $promotion->discount_value) / 100;
                if ($promotion->max_discount && $discount > $promotion->max_discount) {
                    $discount = $promotion->max_discount;
                }

                return $discount;

            case 'fixed':
                return min($promotion->discount_value, $totalAmount);

            case 'fixed_price':
                return max(0, $totalAmount - $promotion->discount_value);

            default:
                return 0;
        }
    }

    /**
     * Calculate discount for buy X get Y promotion
     */
    private function calculateBuyXGetYPromotion($promotion, $totalAmount, $quantity)
    {
        $buyQuantity = $promotion->buy_quantity ?? 1;
        $getQuantity = $promotion->get_quantity ?? 1;

        $eligibleSets = floor($quantity / $buyQuantity);
        $freeItems = $eligibleSets * $getQuantity;

        // Assuming uniform price per item
        $pricePerItem = $quantity > 0 ? $totalAmount / $quantity : 0;

        return $freeItems * $pricePerItem;
    }

    /**
     * Calculate discount for bundle promotion
     */
    private function calculateBundlePromotion($promotion, $totalAmount)
    {
        // For bundle promotions, the discount is the difference between
        // normal total price and bundle price
        if ($promotion->bundle_price && $promotion->bundle_price < $totalAmount) {
            return $totalAmount - $promotion->bundle_price;
        }

        return 0;
    }

    /**
     * Calculate discount for special promotions (cashback, etc.)
     */
    private function calculateSpecialPromotion($promotion, $totalAmount)
    {
        switch ($promotion->special_type) {
            case 'cashback':
                $cashback = ($totalAmount * $promotion->cashback_percentage) / 100;
                if ($promotion->max_cashback && $cashback > $promotion->max_cashback) {
                    $cashback = $promotion->max_cashback;
                }

                return $cashback;

            case 'free_shipping':
                // This would be handled differently in the shipping calculation
                return 0;

            case 'loyalty_points':
                // This doesn't directly affect price
                return 0;

            default:
                return 0;
        }
    }

    /**
     * Apply promotion code manually
     */
    public function applyPromotionCode($code, $cartItems, $userId = null, $companyId = null)
    {
        $promotion = PromotionSimplified::where('code', $code)
            ->where('is_active', true)
            ->where('company_id', $companyId ?? Auth::user()->company_id ?? 1)
            ->first();

        if (! $promotion) {
            return [
                'success' => false,
                'message' => 'Kode promosi tidak valid atau sudah tidak aktif',
                'discount_amount' => 0,
            ];
        }

        // Check if promotion is currently valid
        if (! $this->isPromotionCurrentlyValid($promotion)) {
            return [
                'success' => false,
                'message' => 'Kode promosi sudah tidak berlaku',
                'discount_amount' => 0,
            ];
        }

        // Calculate total cart amount
        $totalAmount = 0;
        foreach ($cartItems as $item) {
            $totalAmount += $item['price'] * $item['quantity'];
        }

        // Check minimum purchase
        if ($promotion->minimum_purchase > 0 && $totalAmount < $promotion->minimum_purchase) {
            return [
                'success' => false,
                'message' => 'Minimal pembelian Rp '.number_format($promotion->minimum_purchase, 0, ',', '.').' untuk menggunakan kode ini',
                'discount_amount' => 0,
            ];
        }

        // Calculate discount
        $discountAmount = $this->calculateDiscount($promotion, $totalAmount, array_sum(array_column($cartItems, 'quantity')));

        return [
            'success' => true,
            'message' => 'Kode promosi berhasil diterapkan',
            'discount_amount' => $discountAmount,
            'promotion' => $promotion,
        ];
    }

    /**
     * Check if promotion is currently valid
     */
    private function isPromotionCurrentlyValid($promotion)
    {
        $now = Carbon::now();
        $currentDay = strtolower($now->format('l'));
        $currentTime = $now->format('H:i:s');

        // Check date range
        if ($promotion->start_date && $promotion->start_date > $now) {
            return false;
        }
        if ($promotion->end_date && $promotion->end_date < $now) {
            return false;
        }

        // Check time range
        if ($promotion->start_time && $promotion->start_time > $currentTime) {
            return false;
        }
        if ($promotion->end_time && $promotion->end_time < $currentTime) {
            return false;
        }

        // Check applicable days
        if ($promotion->applicable_days && ! in_array($currentDay, $promotion->applicable_days)) {
            return false;
        }

        return true;
    }

    /**
     * Update promotion usage count
     */
    public function updatePromotionUsage($promotionId, $userId = null)
    {
        try {
            $promotion = PromotionSimplified::find($promotionId);
            if ($promotion) {
                $promotion->increment('used_count');

                // Here you could also track individual user usage in a separate table
                // PromotionUsage::create([
                //     'promotion_id' => $promotionId,
                //     'user_id' => $userId,
                //     'used_at' => now()
                // ]);
            }
        } catch (\Exception $e) {
            Log::error('Error updating promotion usage: '.$e->getMessage());
        }
    }
}
