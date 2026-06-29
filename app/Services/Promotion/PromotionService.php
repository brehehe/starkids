<?php

namespace App\Services\Promotion;

use App\Models\Product\Product;
use App\Models\Product\ProductPrice;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class PromotionService
{
    // /**
    //  * Apply promotions to a product price
    //  */
    // public function applyPromotionsToProduct($productId, $quantity = 1, $userId = null, $companyId = null)
    // {
    //     try {
    //         $product = Product::with('productPrice')->find($productId);
    //         if (!$product || !$product->productPrice) {
    //             return [
    //                 'original_price' => 0,
    //                 'final_price' => 0,
    //                 'discount_amount' => 0,
    //                 'discount_percentage' => 0,
    //                 'applied_promotions' => []
    //             ];
    //         }

    //         $originalPrice = $product->productPrice->price * $quantity;
    //         $bestPromotion = $this->findBestPromotion($productId, $originalPrice, $userId, $companyId);

    //         if (!$bestPromotion) {
    //             return [
    //                 'original_price' => $originalPrice,
    //                 'final_price' => $originalPrice,
    //                 'discount_amount' => 0,
    //                 'discount_percentage' => 0,
    //                 'applied_promotions' => []
    //             ];
    //         }

    //         $discountAmount = $this->calculateDiscount($bestPromotion, $originalPrice, $quantity);
    //         $finalPrice = max(0, $originalPrice - $discountAmount);
    //         $discountPercentage = $originalPrice > 0 ? ($discountAmount / $originalPrice) * 100 : 0;

    //         return [
    //             'original_price' => $originalPrice,
    //             'final_price' => $finalPrice,
    //             'discount_amount' => $discountAmount,
    //             'discount_percentage' => $discountPercentage,
    //             'applied_promotions' => [$bestPromotion],
    //             'promotion_details' => [
    //                 'id' => $bestPromotion->id,
    //                 'name' => $bestPromotion->name,
    //                 'code' => $bestPromotion->code,
    //                 'type' => $bestPromotion->type,
    //                 'discount_type' => $bestPromotion->discount_type,
    //                 'discount_value' => $bestPromotion->discount_value
    //             ]
    //         ];

    //     } catch (\Exception $e) {
    //         Log::error('Error applying promotion to product: ' . $e->getMessage());
    //         return [
    //             'original_price' => 0,
    //             'final_price' => 0,
    //             'discount_amount' => 0,
    //             'discount_percentage' => 0,
    //             'applied_promotions' => []
    //         ];
    //     }
    // }

    // public

    //     // Check product eligibility
    //     if (!$this->isProductEligible($promotion, $products)) {
    //         return [
    //             'success' => false,
    //             'message' => 'Produk tidak memenuhi syarat promosi'
    //         ];
    //     }

    //     $discountResult = $promotion->calculateDiscount($orderAmount, $products);

    //     if (!$discountResult['eligible']) {
    //         return [
    //             'success' => false,
    //             'message' => $discountResult['message']
    //         ];
    //     }

    //     return [
    //         'success' => true,
    //         'promotion' => $promotion,
    //         'discount_amount' => $discountResult['discount_amount'],
    //         'final_amount' => $discountResult['final_amount'],
    //         'message' => $discountResult['message']
    //     ];
    // }

    // /**
    //  * Record promotion usage
    //  */
    // public function recordPromotionUsage($promotionId, $customerId, $orderAmount, $discountAmount, $appliedProducts = [], $orderId = null): PromotionUsageHistory
    // {
    //     $promotion = PromotionEvent::findOrFail($promotionId);

    //     return $promotion->recordUsage(
    //         $customerId,
    //         $orderAmount,
    //         $discountAmount,
    //         $appliedProducts,
    //         $orderId
    //     );
    // }

    // /**
    //  * Get auto-applicable promotions
    //  */
    // public function getAutoApplicablePromotions($customerId, $companyId, $orderAmount, $products = []): Collection
    // {
    //     $availablePromotions = $this->getAvailablePromotions($customerId, $companyId);

    //     return $availablePromotions->filter(function ($promotion) use ($orderAmount, $products) {
    //         if (!$promotion->auto_apply) {
    //             return false;
    //         }

    //         if (!$this->isProductEligible($promotion, $products)) {
    //             return false;
    //         }

    //         $discountResult = $promotion->calculateDiscount($orderAmount, $products);
    //         return $discountResult['eligible'];
    //     })->sortByDesc('discount_amount');
    // }

    // /**
    //  * Create new promotion
    //  */
    // public function createPromotion(array $data): PromotionEvent
    // {
    //     $data['code'] = $data['code'] ?? $this->generatePromotionCode();
    //     $data['created_by'] = auth()->id();
    //     $data['company_id'] = $data['company_id'] ?? auth()->user()->company_id;

    //     return PromotionEvent::create($data);
    // }

    // /**
    //  * Update promotion
    //  */
    // public function updatePromotion($promotionId, array $data): PromotionEvent
    // {
    //     $promotion = PromotionEvent::findOrFail($promotionId);
    //     $data['updated_by'] = auth()->id();

    //     $promotion->update($data);
    //     return $promotion;
    // }

    // /**
    //  * Get promotion analytics
    //  */
    // public function getPromotionAnalytics($promotionId): array
    // {
    //     $promotion = PromotionEvent::with('usageHistories')->findOrFail($promotionId);

    //     $totalUsage = $promotion->used_count;
    //     $totalDiscountGiven = $promotion->usageHistories->sum('discount_amount');
    //     $totalOrderValue = $promotion->usageHistories->sum('order_amount');
    //     $uniqueCustomers = $promotion->usageHistories->pluck('customer_id')->unique()->count();

    //     $usageByDate = $promotion->usageHistories
    //         ->groupBy(function ($item) {
    //             return Carbon::parse($item->used_at)->format('Y-m-d');
    //         })
    //         ->map(function ($group) {
    //             return [
    //                 'usage_count' => $group->count(),
    //                 'total_discount' => $group->sum('discount_amount'),
    //                 'total_order_value' => $group->sum('order_amount')
    //             ];
    //         });

    //     return [
    //         'promotion' => $promotion,
    //         'total_usage' => $totalUsage,
    //         'total_discount_given' => $totalDiscountGiven,
    //         'total_order_value' => $totalOrderValue,
    //         'unique_customers' => $uniqueCustomers,
    //         'average_order_value' => $totalUsage > 0 ? $totalOrderValue / $totalUsage : 0,
    //         'average_discount' => $totalUsage > 0 ? $totalDiscountGiven / $totalUsage : 0,
    //         'usage_by_date' => $usageByDate,
    //         'remaining_usage' => $promotion->remaining_usage,
    //         'usage_percentage' => $promotion->usage_percentage
    //     ];
    // }

    // /**
    //  * Get company promotion summary
    //  */
    // public function getCompanyPromotionSummary($companyId, $startDate = null, $endDate = null): array
    // {
    //     $query = PromotionEvent::where('company_id', $companyId);

    //     if ($startDate && $endDate) {
    //         $query->whereBetween('start_date', [$startDate, $endDate]);
    //     }

    //     $promotions = $query->with(['usageHistories' => function ($q) use ($startDate, $endDate) {
    //         if ($startDate && $endDate) {
    //             $q->whereBetween('used_at', [$startDate, $endDate]);
    //         }
    //     }])->get();

    //     $totalPromotions = $promotions->count();
    //     $activePromotions = $promotions->where('is_active', true)->count();
    //     $currentPromotions = $promotions->filter(function ($promo) {
    //         return $promo->is_current;
    //     })->count();

    //     $totalUsage = $promotions->sum('used_count');
    //     $totalDiscountGiven = $promotions->sum(function ($promo) {
    //         return $promo->usageHistories->sum('discount_amount');
    //     });

    //     $promotionsByType = $promotions->groupBy('type')->map->count();

    //     return [
    //         'total_promotions' => $totalPromotions,
    //         'active_promotions' => $activePromotions,
    //         'current_promotions' => $currentPromotions,
    //         'total_usage' => $totalUsage,
    //         'total_discount_given' => $totalDiscountGiven,
    //         'promotions_by_type' => $promotionsByType,
    //         'top_promotions' => $promotions->sortByDesc('used_count')->take(5)->values()
    //     ];
    // }

    // /**
    //  * Check if products are eligible for promotion
    //  */
    // private function isProductEligible(PromotionEvent $promotion, array $products): bool
    // {
    //     if ($promotion->applicable_to === 'all_products') {
    //         return true;
    //     }

    //     if ($promotion->applicable_to === 'specific_products') {
    //         $productIds = collect($products)->pluck('id')->toArray();
    //         $requiredProducts = $promotion->product_ids ?? [];

    //         return count(array_intersect($productIds, $requiredProducts)) > 0;
    //     }

    //     if ($promotion->applicable_to === 'categories') {
    //         $categoryIds = collect($products)->pluck('category_id')->toArray();
    //         $requiredCategories = $promotion->category_ids ?? [];

    //         return count(array_intersect($categoryIds, $requiredCategories)) > 0;
    //     }

    //     return false;
    // }

    // /**
    //  * Determine customer type
    //  */
    // private function determineCustomerType(User $customer): string
    // {
    //     // Logic to determine if customer is new, existing, VIP, etc.
    //     $orderCount = 0; // Get from orders table

    //     if ($orderCount === 0) {
    //         return 'new';
    //     } elseif ($orderCount >= 10) {
    //         return 'vip';
    //     } else {
    //         return 'existing';
    //     }
    // }

    // /**
    //  * Generate unique promotion code
    //  */
    // private function generatePromotionCode(): string
    // {
    //     do {
    //         $code = 'PROMO' . strtoupper(Str::random(6));
    //     } while (PromotionEvent::where('code', $code)->exists());

    //     return $code;
    // }

    // /**
    //  * Validate promotion dates
    //  */
    // public function validatePromotionDates($startDate, $endDate): array
    // {
    //     $errors = [];

    //     $start = Carbon::parse($startDate);
    //     $end = Carbon::parse($endDate);

    //     if ($start->gte($end)) {
    //         $errors[] = 'Tanggal berakhir harus setelah tanggal mulai';
    //     }

    //     if ($start->lt(Carbon::now()->startOfDay())) {
    //         $errors[] = 'Tanggal mulai tidak boleh di masa lalu';
    //     }

    //     return $errors;
    // }

    // /**
    //  * Clone promotion
    //  */
    // public function clonePromotion($promotionId, array $overrides = []): PromotionEvent
    // {
    //     $originalPromotion = PromotionEvent::findOrFail($promotionId);

    //     $clonedData = $originalPromotion->toArray();
    //     unset($clonedData['id'], $clonedData['created_at'], $clonedData['updated_at'], $clonedData['used_count']);

    //     $clonedData['code'] = $this->generatePromotionCode();
    //     $clonedData['name'] = $clonedData['name'] . ' (Copy)';
    //     $clonedData['used_count'] = 0;
    //     $clonedData['created_by'] = auth()->id();

    //     // Apply overrides
    //     $clonedData = array_merge($clonedData, $overrides);

    //     return PromotionEvent::create($clonedData);
    // }
}
