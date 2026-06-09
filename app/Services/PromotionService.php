<?php

namespace App\Services;

use App\Models\Product\Product;
use App\Models\Promotion;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class PromotionService
{
    /**
     * Calculate Buy X Get Y promotion
     */
    public function calculateBuyXGetY($promotion, $cartItems, $userProfile = null)
    {
        $discount = 0;
        $appliedDiscounts = [];

        switch ($promotion->buy_get_mode) {
            case 'same_product':
                $discount = $this->calculateSameProductBuyXGetY($promotion, $cartItems);
                break;

            case 'different_product':
                $discount = $this->calculateDifferentProductBuyXGetY($promotion, $cartItems);
                break;

            case 'category_based':
                $discount = $this->calculateCategoryBasedBuyXGetY($promotion, $cartItems);
                break;
        }

        return [
            'discount' => $discount,
            'applied_discounts' => $appliedDiscounts,
            'promotion_type' => 'buy_x_get_y'
        ];
    }

    /**
     * Calculate same product Buy X Get Y (e.g., Buy 2 Get 1 Free)
     */
    private function calculateSameProductBuyXGetY($promotion, $cartItems)
    {
        $totalDiscount = 0;

        foreach ($cartItems as $item) {
            $quantity = $item['quantity'];
            $price = $item['price'];

            // Calculate how many cycles of buy X get Y apply
            $cycles = floor($quantity / ($promotion->buy_quantity + $promotion->get_quantity));

            // Calculate free items
            $freeItems = $cycles * $promotion->get_quantity;

            // Calculate discount (price of free items)
            $totalDiscount += $freeItems * $price;
        }

        return $totalDiscount;
    }

    /**
     * Calculate different product Buy X Get Y
     */
    private function calculateDifferentProductBuyXGetY($promotion, $cartItems)
    {
        $totalDiscount = 0;
        $buyProducts = $promotion->buy_products ?? [];
        $getProducts = $promotion->get_products ?? [];

        // Check if buy requirements are met
        $buyRequirementsMet = $this->checkBuyRequirements($buyProducts, $cartItems);

        if ($buyRequirementsMet) {
            // Apply get discounts
            foreach ($getProducts as $getProduct) {
                $cartItem = null;
                foreach ($cartItems as $item) {
                    if ($item['product_id'] == $getProduct['product_id']) {
                        $cartItem = $item;
                        break;
                    }
                }
                if ($cartItem) {
                    $quantity = min($cartItem['quantity'], $getProduct['quantity']);
                    $itemPrice = $cartItem['price'];

                    switch ($getProduct['discount_type']) {
                        case 'free':
                            $totalDiscount += $quantity * $itemPrice;
                            break;

                        case 'percentage':
                            $totalDiscount += $quantity * $itemPrice * ($getProduct['discount_value'] / 100);
                            break;

                        case 'fixed':
                            $totalDiscount += $quantity * $getProduct['discount_value'];
                            break;
                    }
                }
            }
        }

        return $totalDiscount;
    }

    /**
     * Calculate category-based Buy X Get Y
     */
    private function calculateCategoryBasedBuyXGetY($promotion, $cartItems)
    {
        $totalDiscount = 0;
        $targetCategories = $promotion->target_categories ?? [];

        // Group items by category (simplified - assuming we have category info in cart)
        $categoryItems = [];
        foreach ($cartItems as $item) {
            if (isset($item['category_id']) && in_array($item['category_id'], $targetCategories)) {
                $categoryItems[] = $item;
            }
        }

        // Sort by price descending (cheapest items get free)
        usort($categoryItems, function ($a, $b) {
            return $b['price'] <=> $a['price'];
        });

        $totalQuantity = array_sum(array_column($categoryItems, 'quantity'));
        $cycles = floor($totalQuantity / ($promotion->buy_quantity + $promotion->get_quantity));
        $freeItems = $cycles * $promotion->get_quantity;

        // Apply discount to cheapest items
        $remainingFreeItems = $freeItems;
        foreach ($categoryItems as $item) {
            if ($remainingFreeItems <= 0) break;

            $freeQuantity = min($remainingFreeItems, $item['quantity']);
            $totalDiscount += $freeQuantity * $item['price'];
            $remainingFreeItems -= $freeQuantity;
        }

        return $totalDiscount;
    }

    /**
     * Calculate bundle promotion
     */
    public function calculateBundle($promotion, $cartItems)
    {
        $bundleProducts = $promotion->bundle_products ?? [];
        $bundlePrice = $promotion->bundle_price ?? 0;
        $bundleDiscount = $promotion->bundle_discount ?? 0;

        // Check if all bundle products are in cart
        $bundleAvailable = true;
        $bundleItems = [];

        foreach ($bundleProducts as $bundleProduct) {
            $cartItem = null;
            foreach ($cartItems as $item) {
                if ($item['product_id'] == $bundleProduct['product_id']) {
                    $cartItem = $item;
                    break;
                }
            }

            if (!$cartItem || $cartItem['quantity'] < $bundleProduct['quantity']) {
                $bundleAvailable = false;
                break;
            }

            $bundleItems[] = [
                'product_id' => $bundleProduct['product_id'],
                'quantity' => $bundleProduct['quantity'],
                'original_price' => $cartItem['price'],
                'bundle_price' => $bundleProduct['price']
            ];
        }

        if (!$bundleAvailable) {
            return ['discount' => 0, 'bundle_applied' => false];
        }

        // Calculate bundle discount
        $originalTotal = array_sum(array_map(function ($item) {
            return $item['quantity'] * $item['original_price'];
        }, $bundleItems));

        $bundleTotal = $bundlePrice ?: array_sum(array_map(function ($item) {
            return $item['quantity'] * $item['bundle_price'];
        }, $bundleItems));

        $totalDiscount = $originalTotal - $bundleTotal + $bundleDiscount;

        return [
            'discount' => max(0, $totalDiscount),
            'bundle_applied' => true,
            'bundle_items' => $bundleItems
        ];
    }

    /**
     * Calculate cashback promotion
     */
    public function calculateCashback($promotion, $cartTotal, $userProfile = null)
    {
        $cashbackPercentage = $promotion->cashback_percentage ?? 0;
        $maxCashback = $promotion->max_cashback;
        $cashbackType = $promotion->cashback_type ?? 'instant';

        $cashbackAmount = $cartTotal * ($cashbackPercentage / 100);

        if ($maxCashback && $cashbackAmount > $maxCashback) {
            $cashbackAmount = $maxCashback;
        }

        return [
            'cashback_amount' => $cashbackAmount,
            'cashback_type' => $cashbackType,
            'cashback_percentage' => $cashbackPercentage
        ];
    }

    /**
     * Calculate tier-based discounts
     */
    public function calculateTierDiscount($promotion, $cartTotal)
    {
        $discountTiers = $promotion->discount_tiers ?? [];
        $applicableTier = null;

        // Find the highest applicable tier
        foreach ($discountTiers as $tier) {
            if ($cartTotal >= $tier['min_amount']) {
                if (!$applicableTier || $tier['min_amount'] > $applicableTier['min_amount']) {
                    $applicableTier = $tier;
                }
            }
        }

        if (!$applicableTier) {
            return ['discount' => 0, 'tier_applied' => false];
        }

        $discount = 0;

        if ($promotion->discount_type === 'percentage') {
            $discount = $cartTotal * ($applicableTier['discount_value'] / 100);

            if (isset($applicableTier['max_discount']) && $discount > $applicableTier['max_discount']) {
                $discount = $applicableTier['max_discount'];
            }
        } else {
            $discount = $applicableTier['discount_value'];
        }

        return [
            'discount' => $discount,
            'tier_applied' => true,
            'applied_tier' => $applicableTier
        ];
    }

    /**
     * Calculate product-specific discounts
     */
    public function calculateProductDiscounts($promotion, $cartItems)
    {
        $productDiscounts = $promotion->product_discounts ?? [];
        $totalDiscount = 0;
        $appliedDiscounts = [];

        foreach ($cartItems as $item) {
            $productId = $item['product_id'];

            if (isset($productDiscounts[$productId])) {
                $discountConfig = $productDiscounts[$productId];
                $quantity = $item['quantity'];
                $price = $item['price'];

                $itemDiscount = 0;

                switch ($discountConfig['type']) {
                    case 'percentage':
                        $itemDiscount = $quantity * $price * ($discountConfig['value'] / 100);
                        break;

                    case 'fixed_per_item':
                        $itemDiscount = $quantity * $discountConfig['value'];
                        break;

                    case 'fixed_total':
                        $itemDiscount = $discountConfig['value'];
                        break;
                }

                if (isset($discountConfig['max_discount']) && $itemDiscount > $discountConfig['max_discount']) {
                    $itemDiscount = $discountConfig['max_discount'];
                }

                $totalDiscount += $itemDiscount;
                $appliedDiscounts[] = [
                    'product_id' => $productId,
                    'discount' => $itemDiscount,
                    'type' => $discountConfig['type']
                ];
            }
        }

        return [
            'discount' => $totalDiscount,
            'applied_discounts' => $appliedDiscounts
        ];
    }

    /**
     * Calculate loyalty points
     */
    public function calculateLoyaltyPoints($promotion, $cartTotal)
    {
        $pointsMultiplier = $promotion->points_multiplier ?? 1;
        $bonusPoints = $promotion->bonus_points ?? 0;

        // Assuming 1 point per 1000 rupiah as base
        $basePoints = floor($cartTotal / 1000);
        $totalPoints = ($basePoints * $pointsMultiplier) + $bonusPoints;

        return [
            'points_earned' => $totalPoints,
            'base_points' => $basePoints,
            'bonus_points' => $bonusPoints,
            'multiplier' => $pointsMultiplier
        ];
    }

    /**
     * Check if buy requirements are met for Buy X Get Y
     */
    private function checkBuyRequirements($buyProducts, $cartItems)
    {
        foreach ($buyProducts as $buyProduct) {
            $cartItem = null;
            foreach ($cartItems as $item) {
                if ($item['product_id'] == $buyProduct['product_id']) {
                    $cartItem = $item;
                    break;
                }
            }

            if (!$cartItem || $cartItem['quantity'] < $buyProduct['quantity']) {
                return false;
            }
        }

        return true;
    }

    /**
     * Apply all applicable promotions to cart
     */
    public function applyPromotions($cartItems, $cartTotal, $userProfile = null)
    {
        $activePromotions = Promotion::where('is_active', true)
            ->where('start_date', '<=', Carbon::now())
            ->where('end_date', '>=', Carbon::now())
            ->get();

        $totalDiscount = 0;
        $appliedPromotions = [];
        $earnedPoints = 0;
        $cashbackAmount = 0;

        foreach ($activePromotions as $promotion) {
            // Check usage limits
            if (!$this->checkUsageLimits($promotion, $userProfile)) {
                continue;
            }

            $result = [];

            switch ($promotion->type) {
                case 'buy_x_get_y':
                    $result = $this->calculateBuyXGetY($promotion, $cartItems, $userProfile);
                    break;

                case 'bundle':
                    $result = $this->calculateBundle($promotion, $cartItems);
                    break;

                case 'cashback':
                    $result = $this->calculateCashback($promotion, $cartTotal, $userProfile);
                    $cashbackAmount += $result['cashback_amount'] ?? 0;
                    break;

                case 'minimum_purchase_discount':
                    $result = $this->calculateTierDiscount($promotion, $cartTotal);
                    break;

                case 'product_discount':
                    $result = $this->calculateProductDiscounts($promotion, $cartItems);
                    break;

                case 'loyalty_points':
                    $result = $this->calculateLoyaltyPoints($promotion, $cartTotal);
                    $earnedPoints += $result['points_earned'] ?? 0;
                    break;

                case 'free_shipping':
                    if ($cartTotal >= ($promotion->free_shipping_threshold ?? 0)) {
                        $result = ['shipping_discount' => true];
                    }
                    break;
            }

            if (!empty($result) && ($result['discount'] ?? 0) > 0) {
                $totalDiscount += $result['discount'];
                $appliedPromotions[] = [
                    'promotion' => $promotion,
                    'result' => $result
                ];
            }
        }

        return [
            'total_discount' => $totalDiscount,
            'applied_promotions' => $appliedPromotions,
            'earned_points' => $earnedPoints,
            'cashback_amount' => $cashbackAmount,
            'final_total' => max(0, $cartTotal - $totalDiscount)
        ];
    }

    /**
     * Check usage limits for promotion
     */
    private function checkUsageLimits($promotion, $userProfile)
    {
        // Check total usage limit
        if ($promotion->max_usage && $promotion->current_usage >= $promotion->max_usage) {
            return false;
        }

        // Check per-user usage limit
        if ($promotion->max_usage_per_user && $userProfile) {
            // This would need to check against a promotion_usage table
            // For now, return true
        }

        // Check first-time buyer restriction
        if ($promotion->is_first_purchase_only && $userProfile) {
            // This would need to check if user has made purchases before
            // For now, return true
        }

        return true;
    }

    /**
     * Generate promotion description for display
     */
    public function generatePromotionDescription($promotion)
    {
        switch ($promotion->type) {
            case 'buy_x_get_y':
                if ($promotion->buy_get_mode === 'same_product') {
                    return "Beli {$promotion->buy_quantity} Gratis {$promotion->get_quantity}";
                } else {
                    return "Beli produk tertentu, dapatkan produk gratis/diskon";
                }

            case 'bundle':
                return "Paket Bundle - Hemat dengan membeli produk dalam satu paket";

            case 'cashback':
                return "Cashback {$promotion->cashback_percentage}%" .
                    ($promotion->max_cashback ? " (Max Rp " . number_format($promotion->max_cashback) . ")" : "");

            case 'minimum_purchase_discount':
                return "Diskon bertingkat berdasarkan total pembelian";

            case 'free_shipping':
                return "Gratis ongkir untuk pembelian min Rp " . number_format($promotion->free_shipping_threshold ?? 0);

            case 'loyalty_points':
                return "Dapatkan poin loyalitas " . ($promotion->points_multiplier ?? 1) . "x lipat";

            default:
                return $promotion->name;
        }
    }
}
