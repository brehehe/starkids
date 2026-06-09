<?php

namespace App\Helpers;

use App\Models\Promotion\Promotion;
use App\Models\Product\ProductPrice;
use App\Models\Product\Product;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class EnhancedPromotionHelper
{
    /**
     * Get product price with automatic promotion integration
     */
    public static function getProductPriceWithPromotion(
        $productId,
        $branchId = null,
        $companyId = null,
        $customerId = null,
        $quantity = 1
    ): array {
        // Get base price from ProductPrice
        $productPrice = ProductPrice::getProductPrice($productId, $branchId, $companyId);

        if (!$productPrice) {
            return [
                'original_price' => 0,
                'final_price' => 0,
                'discount_amount' => 0,
                'promotion' => null,
                'error' => 'Product price not found'
            ];
        }

        $originalPrice = $productPrice->price;

        // Get applicable promotions for this product
        $applicablePromotions = self::getProductPromotions($productId, $companyId, $customerId);

        $bestDiscount = 0;
        $bestPromotion = null;

        foreach ($applicablePromotions as $promotion) {
            $discountResult = self::calculateProductPromotion($promotion, $productPrice, $quantity, $customerId);

            if ($discountResult['eligible'] && $discountResult['discount_amount'] > $bestDiscount) {
                $bestDiscount = $discountResult['discount_amount'];
                $bestPromotion = $promotion;
            }
        }

        $finalPrice = max(0, $originalPrice - $bestDiscount);

        return [
            'original_price' => $originalPrice,
            'final_price' => $finalPrice,
            'discount_amount' => $bestDiscount,
            'discount_percentage' => $originalPrice > 0 ? ($bestDiscount / $originalPrice) * 100 : 0,
            'promotion' => $bestPromotion,
            'product_price' => $productPrice,
            'quantity' => $quantity,
            'total_original' => $originalPrice * $quantity,
            'total_final' => $finalPrice * $quantity,
            'total_savings' => $bestDiscount * $quantity
        ];
    }

    /**
     * Get promotions applicable to specific product
     */
    public static function getProductPromotions($productId, $companyId = null, $customerId = null): Collection
    {
        $now = Carbon::now();

        return Promotion::where('company_id', $companyId)
            ->where('is_active', true)
            ->where(function ($query) use ($now) {
                $query->whereNull('start_date')
                    ->orWhere('start_date', '<=', $now);
            })
            ->where(function ($query) use ($now) {
                $query->whereNull('end_date')
                    ->orWhere('end_date', '>=', $now);
            })
            ->where(function ($query) use ($productId) {
                // Product specific promotions
                $query->where('type', 'product_specific')
                    ->whereJsonContains('product_discounts', [['product_id' => $productId]])
                    // Or general promotions that can apply to any product
                    ->orWhereIn('type', [
                        'percentage',
                        'fixed_amount',
                        'membership_discount',
                        'volume_discount',
                        'seasonal_discount'
                    ])
                    // Or promotions targeting this product specifically
                    ->orWhereJsonContains('product_ids', $productId);
            })
            ->orderBy('priority', 'desc')
            ->get();
    }

    /**
     * Calculate promotion discount for specific product
     */
    public static function calculateProductPromotion(
        Promotion $promotion,
        ProductPrice $productPrice,
        int $quantity = 1,
        $customerId = null
    ): array {
        if (!$promotion->isValid()) {
            return [
                'eligible' => false,
                'discount_amount' => 0,
                'message' => 'Promotion not valid'
            ];
        }

        // Check customer eligibility
        if (!self::isCustomerEligible($promotion, $customerId)) {
            return [
                'eligible' => false,
                'discount_amount' => 0,
                'message' => 'Customer not eligible'
            ];
        }

        switch ($promotion->type) {
            case 'product_specific':
                return self::calculateProductSpecificDiscount($promotion, $productPrice, $quantity);

            case 'percentage':
                return self::calculatePercentageDiscount($promotion, $productPrice->price, $quantity);

            case 'fixed_amount':
                return self::calculateFixedAmountDiscount($promotion, $productPrice->price, $quantity);

            case 'volume_discount':
                return self::calculateVolumeDiscount($promotion, $productPrice, $quantity);

            case 'membership_discount':
                return self::calculateMembershipDiscount($promotion, $productPrice, $customerId);

            default:
                return [
                    'eligible' => false,
                    'discount_amount' => 0,
                    'message' => 'Promotion type not supported for individual products'
                ];
        }
    }

    /**
     * Calculate product specific discount
     */
    private static function calculateProductSpecificDiscount(
        Promotion $promotion,
        ProductPrice $productPrice,
        int $quantity
    ): array {
        $productDiscounts = $promotion->product_discounts ?? [];

        foreach ($productDiscounts as $discount) {
            if ($discount['product_id'] == $productPrice->product_id) {
                // Check quantity limits
                $minQty = $discount['min_quantity'] ?? 1;
                $maxQty = $discount['max_quantity'] ?? PHP_INT_MAX;

                if ($quantity < $minQty || $quantity > $maxQty) {
                    return [
                        'eligible' => false,
                        'discount_amount' => 0,
                        'message' => "Quantity must be between {$minQty} and {$maxQty}"
                    ];
                }

                $discountType = $discount['discount_type'] ?? 'percentage';
                $discountValue = $discount['discount_value'] ?? 0;
                $originalPrice = $productPrice->price;

                switch ($discountType) {
                    case 'percentage':
                        $unitDiscount = ($originalPrice * $discountValue) / 100;
                        if (isset($discount['max_discount']) && $unitDiscount > $discount['max_discount']) {
                            $unitDiscount = $discount['max_discount'];
                        }
                        break;

                    case 'fixed_amount':
                        $unitDiscount = min($discountValue, $originalPrice);
                        break;

                    case 'fixed_price':
                        $unitDiscount = max(0, $originalPrice - $discountValue);
                        break;

                    default:
                        $unitDiscount = 0;
                }

                return [
                    'eligible' => true,
                    'discount_amount' => $unitDiscount,
                    'discount_type' => $discountType,
                    'discount_value' => $discountValue,
                    'message' => "Product specific discount applied"
                ];
            }
        }

        return [
            'eligible' => false,
            'discount_amount' => 0,
            'message' => 'Product not found in promotion'
        ];
    }

    /**
     * Calculate percentage discount
     */
    private static function calculatePercentageDiscount(
        Promotion $promotion,
        float $price,
        int $quantity
    ): array {
        $unitDiscount = ($price * $promotion->promotion_value) / 100;

        if ($promotion->max_discount && $unitDiscount > $promotion->max_discount) {
            $unitDiscount = $promotion->max_discount;
        }

        return [
            'eligible' => true,
            'discount_amount' => $unitDiscount,
            'discount_type' => 'percentage',
            'discount_value' => $promotion->promotion_value,
            'message' => "Discount {$promotion->promotion_value}%"
        ];
    }

    /**
     * Calculate fixed amount discount
     */
    private static function calculateFixedAmountDiscount(
        Promotion $promotion,
        float $price,
        int $quantity
    ): array {
        $unitDiscount = min($promotion->promotion_value, $price);

        return [
            'eligible' => true,
            'discount_amount' => $unitDiscount,
            'discount_type' => 'fixed_amount',
            'discount_value' => $promotion->promotion_value,
            'message' => "Fixed discount Rp " . number_format($unitDiscount, 0, ',', '.')
        ];
    }

    /**
     * Calculate volume discount
     */
    private static function calculateVolumeDiscount(
        Promotion $promotion,
        ProductPrice $productPrice,
        int $quantity
    ): array {
        $requiredQuantity = $promotion->buy_quantity ?? 1;

        if ($quantity < $requiredQuantity) {
            return [
                'eligible' => false,
                'discount_amount' => 0,
                'message' => "Minimum quantity required: {$requiredQuantity}"
            ];
        }

        $unitDiscount = ($productPrice->price * $promotion->promotion_value) / 100;

        return [
            'eligible' => true,
            'discount_amount' => $unitDiscount,
            'discount_type' => 'volume',
            'discount_value' => $promotion->promotion_value,
            'message' => "Volume discount {$promotion->promotion_value}% for {$quantity} items"
        ];
    }

    /**
     * Calculate membership discount
     */
    private static function calculateMembershipDiscount(
        Promotion $promotion,
        ProductPrice $productPrice,
        $customerId
    ): array {
        // Check if customer has eligible membership level
        if (!$customerId) {
            return [
                'eligible' => false,
                'discount_amount' => 0,
                'message' => 'Customer login required'
            ];
        }

        // This would need to be implemented based on your user system
        // For now, we'll assume the customer is eligible
        $unitDiscount = ($productPrice->price * $promotion->promotion_value) / 100;

        if ($promotion->max_discount && $unitDiscount > $promotion->max_discount) {
            $unitDiscount = $promotion->max_discount;
        }

        return [
            'eligible' => true,
            'discount_amount' => $unitDiscount,
            'discount_type' => 'membership',
            'discount_value' => $promotion->promotion_value,
            'message' => "Member discount {$promotion->promotion_value}%"
        ];
    }

    /**
     * Check customer eligibility
     */
    private static function isCustomerEligible(Promotion $promotion, $customerId): bool
    {
        // Check user type restrictions
        if ($promotion->user_types && $customerId) {
            // Implementation depends on your user type system
        }

        // Check specific user restrictions
        if ($promotion->user_ids && $customerId) {
            return in_array($customerId, $promotion->user_ids);
        }

        // Check first time buyer restriction
        if ($promotion->is_first_purchase_only && $customerId) {
            // Implementation depends on your order history system
        }

        return true;
    }

    /**
     * Apply promotion mode check - simplified for production
     */
    public static function shouldApplyPromotion(Promotion $promotion, string $context = 'cart'): bool
    {
        // For product_specific promotions, check if auto-apply is enabled
        if ($promotion->type === 'product_specific') {
            return $promotion->is_auto_apply ?? true;
        }

        return true;
    }

    /**
     * Check application timing - simplified for production
     */
    public static function shouldApplyNow(Promotion $promotion, string $context = 'cart'): bool
    {
        // If requires code, only apply when code context
        if ($promotion->requires_code) {
            return in_array($context, ['coupon', 'promo_code']);
        }

        return true;
    }

    /**
     * Update product price with promotion in ProductPrice table
     */
    public static function updateProductPriceWithPromotion(
        $productId,
        $branchId,
        $promotionId,
        $companyId = null
    ): array {
        $promotion = Promotion::find($promotionId);
        $productPrice = ProductPrice::getProductPrice($productId, $branchId, $companyId);

        if (!$promotion || !$productPrice) {
            return [
                'success' => false,
                'message' => 'Promotion or product price not found'
            ];
        }

        $discountResult = self::calculateProductPromotion($promotion, $productPrice);

        if (!$discountResult['eligible']) {
            return [
                'success' => false,
                'message' => $discountResult['message']
            ];
        }

        $newPrice = $productPrice->price - $discountResult['discount_amount'];

        // Update the price in database
        $productPrice->update([
            'price' => $newPrice,
            'is_updated' => true
        ]);

        return [
            'success' => true,
            'original_price' => $productPrice->price + $discountResult['discount_amount'],
            'new_price' => $newPrice,
            'discount_amount' => $discountResult['discount_amount'],
            'promotion' => $promotion
        ];
    }

    /**
     * Get comprehensive product pricing information
     */
    public static function getComprehensiveProductInfo($productId, $branchId = null, $companyId = null, $customerId = null): array
    {
        $priceInfo = self::getProductPriceWithPromotion($productId, $branchId, $companyId, $customerId, 1);

        if (!$priceInfo['product_price']) {
            return $priceInfo;
        }

        $productPrice = $priceInfo['product_price'];

        return [
            'product_id' => $productId,
            'branch_id' => $branchId,
            'company_id' => $companyId,
            'base_price' => $productPrice->price,
            'sale_price' => $priceInfo['final_price'],
            'discount_amount' => $priceInfo['discount_amount'],
            'discount_percentage' => $priceInfo['discount_percentage'],
            'has_promotion' => $priceInfo['promotion'] !== null,
            'promotion_details' => $priceInfo['promotion'],
            'cost_price' => $productPrice->cost_price ?? 0,
            'profit_margin' => $productPrice->getProfitMargin(),
            'updated_at' => $productPrice->updated_at,
            'pricing_notes' => [
                'Base price from ProductPrice model',
                'Automatic promotion calculation applied',
                'Real-time discount calculation',
                'Customer-specific pricing if applicable'
            ]
        ];
    }
}
