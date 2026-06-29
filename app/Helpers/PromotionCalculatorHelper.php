<?php

namespace App\Helpers;

use App\Models\Promotion\Promotion;
use Illuminate\Support\Collection;

class PromotionCalculatorHelper
{
    /**
     * Calculate the best applicable promotion for given products and customer
     */
    public static function calculateBestPromotion(
        array $products,
        float $orderAmount,
        $customerId = null,
        $companyId = null
    ): array {
        $availablePromotions = self::getAvailablePromotions($customerId, $companyId);
        $bestPromotion = null;
        $maxDiscount = 0;
        $applicablePromotions = [];

        foreach ($availablePromotions as $promotion) {
            $discountResult = self::calculatePromotionDiscount($promotion, $products, $orderAmount, $customerId);

            if ($discountResult['eligible'] && $discountResult['discount_amount'] > $maxDiscount) {
                $maxDiscount = $discountResult['discount_amount'];
                $bestPromotion = $discountResult;
                $bestPromotion['promotion'] = $promotion;
            }

            if ($discountResult['eligible']) {
                $applicablePromotions[] = $discountResult + ['promotion' => $promotion];
            }
        }

        return [
            'best_promotion' => $bestPromotion,
            'applicable_promotions' => $applicablePromotions,
            'total_savings' => $maxDiscount,
        ];
    }

    /**
     * Calculate discount for a specific promotion
     */
    public static function calculatePromotionDiscount(
        Promotion $promotion,
        array $products,
        float $orderAmount,
        $customerId = null
    ): array {
        if (! $promotion->isValid()) {
            return [
                'eligible' => false,
                'discount_amount' => 0,
                'message' => 'Promosi tidak aktif atau sudah berakhir',
                'details' => [],
            ];
        }

        // Check minimum purchase
        if ($promotion->minimum_purchase && $orderAmount < $promotion->minimum_purchase) {
            return [
                'eligible' => false,
                'discount_amount' => 0,
                'message' => 'Minimal pembelian Rp '.number_format($promotion->minimum_purchase, 0, ',', '.'),
                'details' => [],
            ];
        }

        // Check customer eligibility
        if (! self::isCustomerEligible($promotion, $customerId)) {
            return [
                'eligible' => false,
                'discount_amount' => 0,
                'message' => 'Promo tidak berlaku untuk customer ini',
                'details' => [],
            ];
        }

        switch ($promotion->type) {
            case 'percentage':
                return self::calculatePercentageDiscount($promotion, $orderAmount);

            case 'fixed_amount':
                return self::calculateFixedAmountDiscount($promotion, $orderAmount);

            case 'buy_x_get_y':
                return self::calculateBuyXGetYDiscount($promotion, $products);

            case 'bundle':
                return self::calculateBundleDiscount($promotion, $products);

            case 'product_specific':
                return self::calculateProductSpecificDiscount($promotion, $products);

            case 'tier_discount':
                return self::calculateTierDiscount($promotion, $orderAmount);

            case 'volume_discount':
                return self::calculateVolumeDiscount($promotion, $products);

            case 'cashback':
                return self::calculateCashback($promotion, $orderAmount);

            case 'free_shipping':
                return self::calculateFreeShipping($promotion, $orderAmount);

            case 'loyalty_points':
                return self::calculateLoyaltyPoints($promotion, $orderAmount);

            case 'membership_discount':
                return self::calculateMembershipDiscount($promotion, $orderAmount, $customerId);

            case 'seasonal_discount':
                return self::calculateSeasonalDiscount($promotion, $orderAmount);

            case 'first_time_buyer':
                return self::calculateFirstTimeBuyerDiscount($promotion, $orderAmount, $customerId);

            case 'category_discount':
                return self::calculateCategoryDiscount($promotion, $products);

            default:
                return [
                    'eligible' => false,
                    'discount_amount' => 0,
                    'message' => 'Jenis promosi tidak dikenali',
                    'details' => [],
                ];
        }
    }

    /**
     * Calculate percentage discount
     */
    private static function calculatePercentageDiscount(Promotion $promotion, float $orderAmount): array
    {
        $discountAmount = ($orderAmount * $promotion->promotion_value) / 100;

        if ($promotion->max_discount && $discountAmount > $promotion->max_discount) {
            $discountAmount = $promotion->max_discount;
        }

        return [
            'eligible' => true,
            'discount_amount' => $discountAmount,
            'final_amount' => $orderAmount - $discountAmount,
            'message' => "Diskon {$promotion->promotion_value}% - Hemat Rp ".number_format($discountAmount, 0, ',', '.'),
            'details' => [
                'type' => 'percentage',
                'percentage' => $promotion->promotion_value,
                'max_discount' => $promotion->max_discount,
            ],
        ];
    }

    /**
     * Calculate fixed amount discount
     */
    private static function calculateFixedAmountDiscount(Promotion $promotion, float $orderAmount): array
    {
        $discountAmount = min($promotion->promotion_value, $orderAmount);

        return [
            'eligible' => true,
            'discount_amount' => $discountAmount,
            'final_amount' => $orderAmount - $discountAmount,
            'message' => 'Potongan Rp '.number_format($discountAmount, 0, ',', '.'),
            'details' => [
                'type' => 'fixed_amount',
                'amount' => $promotion->promotion_value,
            ],
        ];
    }

    /**
     * Calculate tier discount
     */
    private static function calculateTierDiscount(Promotion $promotion, float $orderAmount): array
    {
        $tiers = $promotion->discount_tiers ?? [];
        $applicableTier = null;

        // Find the highest tier that customer qualifies for
        foreach ($tiers as $tier) {
            if ($orderAmount >= ($tier['min_amount'] ?? 0)) {
                if (! $applicableTier || ($tier['min_amount'] ?? 0) > ($applicableTier['min_amount'] ?? 0)) {
                    $applicableTier = $tier;
                }
            }
        }

        if (! $applicableTier) {
            return [
                'eligible' => false,
                'discount_amount' => 0,
                'message' => 'Tidak memenuhi tier minimum',
                'details' => [],
            ];
        }

        $discountAmount = ($orderAmount * ($applicableTier['discount_value'] ?? 0)) / 100;

        if (isset($applicableTier['max_discount']) && $discountAmount > $applicableTier['max_discount']) {
            $discountAmount = $applicableTier['max_discount'];
        }

        return [
            'eligible' => true,
            'discount_amount' => $discountAmount,
            'final_amount' => $orderAmount - $discountAmount,
            'message' => "Tier discount {$applicableTier['discount_value']}% - Hemat Rp ".number_format($discountAmount, 0, ',', '.'),
            'details' => [
                'type' => 'tier_discount',
                'tier' => $applicableTier,
                'tier_amount' => $applicableTier['min_amount'] ?? 0,
            ],
        ];
    }

    /**
     * Calculate product specific discount
     */
    private static function calculateProductSpecificDiscount(Promotion $promotion, array $products): array
    {
        $productDiscounts = $promotion->product_discounts ?? [];
        $totalDiscount = 0;
        $appliedProducts = [];

        foreach ($products as $product) {
            foreach ($productDiscounts as $discount) {
                if ($product['id'] == $discount['product_id']) {
                    $quantity = min($product['quantity'], $discount['max_quantity'] ?? PHP_INT_MAX);
                    $quantity = max($quantity, $discount['min_quantity'] ?? 1);

                    if ($quantity > 0) {
                        $productDiscount = self::calculateProductDiscount($discount, $product, $quantity);
                        $totalDiscount += $productDiscount;
                        $appliedProducts[] = [
                            'product_id' => $product['id'],
                            'quantity' => $quantity,
                            'discount' => $productDiscount,
                        ];
                    }
                }
            }
        }

        return [
            'eligible' => $totalDiscount > 0,
            'discount_amount' => $totalDiscount,
            'message' => $totalDiscount > 0 ? 'Diskon produk spesifik - Hemat Rp '.number_format($totalDiscount, 0, ',', '.') : 'Tidak ada produk yang memenuhi syarat',
            'details' => [
                'type' => 'product_specific',
                'applied_products' => $appliedProducts,
                'mode' => $promotion->product_discount_mode,
                'application' => $promotion->discount_application,
            ],
        ];
    }

    /**
     * Calculate product discount for individual product
     */
    private static function calculateProductDiscount(array $discount, array $product, int $quantity): float
    {
        $originalPrice = $product['price'];
        $discountValue = $discount['discount_value'] ?? 0;
        $discountType = $discount['discount_type'] ?? 'percentage';

        switch ($discountType) {
            case 'percentage':
                $unitDiscount = ($originalPrice * $discountValue) / 100;
                if (isset($discount['max_discount']) && $unitDiscount > $discount['max_discount']) {
                    $unitDiscount = $discount['max_discount'];
                }

                return $unitDiscount * $quantity;

            case 'fixed_amount':
                return min($discountValue, $originalPrice) * $quantity;

            case 'fixed_price':
                $unitDiscount = max(0, $originalPrice - $discountValue);

                return $unitDiscount * $quantity;

            default:
                return 0;
        }
    }

    /**
     * Calculate volume discount
     */
    private static function calculateVolumeDiscount(Promotion $promotion, array $products): array
    {
        $totalQuantity = array_sum(array_column($products, 'quantity'));
        $requiredQuantity = $promotion->buy_quantity ?? 1;

        if ($totalQuantity < $requiredQuantity) {
            return [
                'eligible' => false,
                'discount_amount' => 0,
                'message' => "Minimal beli {$requiredQuantity} item",
                'details' => [],
            ];
        }

        $totalValue = array_sum(array_map(fn ($p) => $p['price'] * $p['quantity'], $products));
        $discountAmount = ($totalValue * $promotion->promotion_value) / 100;

        return [
            'eligible' => true,
            'discount_amount' => $discountAmount,
            'final_amount' => $totalValue - $discountAmount,
            'message' => "Volume discount {$promotion->promotion_value}% untuk {$totalQuantity} item",
            'details' => [
                'type' => 'volume_discount',
                'total_quantity' => $totalQuantity,
                'required_quantity' => $requiredQuantity,
            ],
        ];
    }

    /**
     * Calculate cashback
     */
    private static function calculateCashback(Promotion $promotion, float $orderAmount): array
    {
        $cashbackAmount = ($orderAmount * ($promotion->cashback_percentage ?? 0)) / 100;

        if ($promotion->max_cashback && $cashbackAmount > $promotion->max_cashback) {
            $cashbackAmount = $promotion->max_cashback;
        }

        return [
            'eligible' => $cashbackAmount > 0,
            'discount_amount' => 0, // Cashback doesn't reduce order amount
            'cashback_amount' => $cashbackAmount,
            'final_amount' => $orderAmount,
            'message' => 'Cashback Rp '.number_format($cashbackAmount, 0, ',', '.'),
            'details' => [
                'type' => 'cashback',
                'cashback_percentage' => $promotion->cashback_percentage,
                'cashback_type' => $promotion->cashback_type,
                'max_cashback' => $promotion->max_cashback,
            ],
        ];
    }

    /**
     * Get available promotions for customer
     */
    private static function getAvailablePromotions($customerId, $companyId): Collection
    {
        return Promotion::where('company_id', $companyId)
            ->where('is_active', true)
            ->where(function ($query) {
                $query->whereNull('start_date')
                    ->orWhere('start_date', '<=', now());
            })
            ->where(function ($query) {
                $query->whereNull('end_date')
                    ->orWhere('end_date', '>=', now());
            })
            ->get();
    }

    /**
     * Check if customer is eligible for promotion
     */
    private static function isCustomerEligible(Promotion $promotion, $customerId): bool
    {
        // Check user type restrictions
        if ($promotion->user_types && $customerId) {
            // Implementation depends on your user type system
            // This is a placeholder
        }

        // Check specific user restrictions
        if ($promotion->user_ids && $customerId) {
            return in_array($customerId, $promotion->user_ids);
        }

        // Check first time buyer restriction
        if ($promotion->is_first_purchase_only && $customerId) {
            // Implementation depends on your order history system
            // This is a placeholder
        }

        return true;
    }

    /**
     * Apply product specific discount mode
     */
    public static function shouldApplyDiscount(Promotion $promotion, $context = 'cart'): bool
    {
        switch ($promotion->product_discount_mode) {
            case 'auto':
                return true;

            case 'manual':
                return $context === 'pos' || $context === 'manual';

            case 'selective':
                // Would need additional logic to check customer eligibility
                return false;

            default:
                return true;
        }
    }

    /**
     * Check when discount should be applied
     */
    public static function shouldApplyNow(Promotion $promotion, $context = 'cart'): bool
    {
        switch ($promotion->discount_application) {
            case 'immediate':
                return $context === 'cart' || $context === 'add_to_cart';

            case 'checkout':
                return $context === 'checkout';

            case 'coupon_required':
                return $context === 'coupon_applied';

            default:
                return true;
        }
    }
}
