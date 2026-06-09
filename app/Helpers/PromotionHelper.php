<?php

namespace App\Helpers;

use App\Models\Promotion\PromotionSimplified;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;

class PromotionHelper
{
    /**
     * Format promotion type untuk display
     */
    public static function formatPromotionType($type)
    {
        return match ($type) {
            'percentage' => 'Persentase (%)',
            'fixed_amount' => 'Nominal Tetap (Rp)',
            'free_shipping' => 'Gratis Ongkir',
            'buy_x_get_y' => 'Beli X Dapat Y',
            'discount' => 'Diskon',
            'bundle' => 'Paket Bundle',
            'special' => 'Promo Khusus',
            default => ucfirst($type)
        };
    }

    /**
     * Format promotion value untuk display
     */
    public static function formatPromotionValue($promotion)
    {
        if (!$promotion) return '-';

        switch ($promotion->type) {
            case 'percentage':
                return $promotion->value . '%';
            case 'fixed_amount':
                return 'Rp ' . number_format($promotion->value, 0, ',', '.');
            case 'free_shipping':
                return 'Gratis Ongkir';
            case 'buy_x_get_y':
                return "Beli {$promotion->buy_quantity} Dapat {$promotion->get_quantity}";
            default:
                return $promotion->value;
        }
    }

    /**
     * Format promotion discount untuk display
     */
    public static function formatPromotionDiscount($promotion)
    {
        if (!$promotion) return '-';

        switch ($promotion->type) {
            case 'percentage':
                return 'Diskon ' . $promotion->value . '%';
            case 'fixed_amount':
                return 'Diskon Rp ' . number_format($promotion->value, 0, ',', '.');
            case 'free_shipping':
                return 'Gratis Ongkos Kirim';
            case 'buy_x_get_y':
                return "Beli {$promotion->buy_quantity} Gratis {$promotion->get_quantity}";
            case 'discount':
                if ($promotion->value) {
                    return 'Diskon ' . ($promotion->discount_type === 'percentage' ? $promotion->value . '%' : 'Rp ' . number_format($promotion->value, 0, ',', '.'));
                }
                return 'Diskon Khusus';
            case 'bundle':
                return 'Paket Hemat';
            case 'special':
                return 'Promo Spesial';
            default:
                return 'Promo ' . ucfirst($promotion->type);
        }
    }

    /**
     * Get promotion status
     */
    public static function getPromotionStatus($promotion)
    {
        if (!$promotion->is_active) {
            return 'inactive';
        }

        $now = Carbon::now();
        $startDate = Carbon::parse($promotion->start_date);
        $endDate = Carbon::parse($promotion->end_date);

        if ($now->lt($startDate)) {
            return 'upcoming';
        } elseif ($now->gt($endDate)) {
            return 'expired';
        }

        return 'active';
    }

    /**
     * Format promotion status untuk display
     */
    public static function formatPromotionStatus($promotion)
    {
        $status = self::getPromotionStatus($promotion);

        return match ($status) {
            'active' => 'Aktif',
            'inactive' => 'Tidak Aktif',
            'upcoming' => 'Akan Datang',
            'expired' => 'Kedaluwarsa',
            default => ucfirst($status)
        };
    }

    /**
     * Get promotion status badge class
     */
    public static function getStatusBadgeClass($promotion)
    {
        $status = self::getPromotionStatus($promotion);

        return match ($status) {
            'active' => 'bg-green-100 text-green-800',
            'inactive' => 'bg-gray-100 text-gray-800',
            'upcoming' => 'bg-blue-100 text-blue-800',
            'expired' => 'bg-red-100 text-red-800',
            default => 'bg-gray-100 text-gray-800'
        };
    }

    /**
     * Get promotion badge class (alias for getStatusBadgeClass)
     */
    public static function getPromotionBadgeClass($promotion)
    {
        return self::getStatusBadgeClass($promotion);
    }

    /**
     * Get status badge with both class and text
     */
    public static function getStatusBadge($promotion)
    {
        $status = self::getPromotionStatus($promotion);

        return [
            'text' => self::formatPromotionStatus($promotion),
            'class' => self::getStatusBadgeClass($promotion)
        ];
    }

    /**
     * Check if promotion can be used
     */
    public static function canUsePromotion($promotion, $user = null, $totalAmount = 0)
    {
        if (!$promotion || !$promotion->is_active) {
            return false;
        }

        // Check date range
        $now = Carbon::now();
        if ($now->lt(Carbon::parse($promotion->start_date)) || $now->gt(Carbon::parse($promotion->end_date))) {
            return false;
        }

        // Check minimum purchase
        if ($promotion->minimum_purchase && $totalAmount < $promotion->minimum_purchase) {
            return false;
        }

        // Check usage limit
        if ($promotion->usage_limit && $promotion->usage_count >= $promotion->usage_limit) {
            return false;
        }

        // Check user-specific limits
        if ($user && $promotion->usage_limit_per_user) {
            $userUsageCount = $promotion->usages()->where('user_id', $user->id)->count();
            if ($userUsageCount >= $promotion->usage_limit_per_user) {
                return false;
            }
        }

        return true;
    }

    /**
     * Calculate discount amount
     */
    public static function calculateDiscount($promotion, $amount)
    {
        if (!$promotion) return 0;

        switch ($promotion->type) {
            case 'percentage':
                $discount = ($amount * $promotion->value) / 100;
                break;
            case 'fixed_amount':
                $discount = $promotion->value;
                break;
            default:
                $discount = 0;
        }

        // Apply maximum discount if set
        if ($promotion->maximum_discount && $discount > $promotion->maximum_discount) {
            $discount = $promotion->maximum_discount;
        }

        return min($discount, $amount); // Discount cannot exceed the original amount
    }

    /**
     * Get applicable companies for targeting
     */
    public static function getApplicableCompanies($promotion)
    {
        if (!$promotion || !$promotion->applicable_companies) {
            return [];
        }

        return is_array($promotion->applicable_companies)
            ? $promotion->applicable_companies
            : json_decode($promotion->applicable_companies, true) ?? [];
    }

    /**
     * Get applicable products for targeting
     */
    public static function getApplicableProducts($promotion)
    {
        if (!$promotion || !$promotion->applicable_products) {
            return [];
        }

        return is_array($promotion->applicable_products)
            ? $promotion->applicable_products
            : json_decode($promotion->applicable_products, true) ?? [];
    }

    /**
     * Get applicable users for targeting
     */
    public static function getApplicableUsers($promotion)
    {
        if (!$promotion || !$promotion->applicable_users) {
            return [];
        }

        return is_array($promotion->applicable_users)
            ? $promotion->applicable_users
            : json_decode($promotion->applicable_users, true) ?? [];
    }

    /**
     * Get applicable user types for targeting
     */
    public static function getApplicableUserTypes($promotion)
    {
        if (!$promotion || !$promotion->applicable_user_types) {
            return [];
        }

        return is_array($promotion->applicable_user_types)
            ? $promotion->applicable_user_types
            : json_decode($promotion->applicable_user_types, true) ?? [];
    }

    /**
     * Check if promotion applies to specific company
     */
    public static function appliesToCompany($promotion, $companyId)
    {
        $applicableCompanies = self::getApplicableCompanies($promotion);

        // If no specific companies set, applies to all
        if (empty($applicableCompanies)) {
            return true;
        }

        return in_array($companyId, $applicableCompanies);
    }

    /**
     * Check if promotion applies to specific user type
     */
    public static function appliesToUserType($promotion, $userTypeId)
    {
        $applicableUserTypes = self::getApplicableUserTypes($promotion);

        // If no specific user types set, applies to all
        if (empty($applicableUserTypes)) {
            return true;
        }

        return in_array($userTypeId, $applicableUserTypes);
    }

    /**
     * Get applicable days for targeting
     */
    public static function getApplicableDays($promotion)
    {
        if (!$promotion || !$promotion->applicable_days) {
            return [];
        }

        return is_array($promotion->applicable_days)
            ? $promotion->applicable_days
            : json_decode($promotion->applicable_days, true) ?? [];
    }

    /**
     * Check if promotion applies to specific day
     */
    public static function appliesToDay($promotion, $dayOfWeek = null)
    {
        $applicableDays = self::getApplicableDays($promotion);

        // If no specific days set, applies to all days
        if (empty($applicableDays)) {
            return true;
        }

        // If no day specified, use current day
        if ($dayOfWeek === null) {
            $dayOfWeek = strtolower(Carbon::now()->format('l'));
        }

        // Convert day names to consistent format
        $dayMapping = [
            'monday' => 'monday',
            'tuesday' => 'tuesday',
            'wednesday' => 'wednesday',
            'thursday' => 'thursday',
            'friday' => 'friday',
            'saturday' => 'saturday',
            'sunday' => 'sunday',
            'senin' => 'monday',
            'selasa' => 'tuesday',
            'rabu' => 'wednesday',
            'kamis' => 'thursday',
            'jumat' => 'friday',
            'sabtu' => 'saturday',
            'minggu' => 'sunday'
        ];

        $normalizedDay = $dayMapping[strtolower($dayOfWeek)] ?? strtolower($dayOfWeek);

        return in_array($normalizedDay, $applicableDays);
    }
    /**
     * Format terms and conditions for display
     */
    public static function formatTermsConditions($promotion)
    {
        if (!$promotion || !$promotion->terms_conditions) {
            return [];
        }

        return is_array($promotion->terms_conditions)
            ? $promotion->terms_conditions
            : json_decode($promotion->terms_conditions, true) ?? [];
    }

    /**
     * Get promotion types for selection
     */
    public static function getPromotionTypes()
    {
        return [
            'percentage' => 'Persentase (%)',
            'fixed_amount' => 'Nominal Tetap (Rp)',
            'free_shipping' => 'Gratis Ongkir',
            'buy_x_get_y' => 'Beli X Dapat Y',
        ];
    }

    /**
     * Validate promotion code uniqueness
     */
    public static function validatePromotionCode($code, $excludeId = null)
    {
        $query = PromotionSimplified::where('code', $code);

        if ($excludeId) {
            $query->where('id', '!=', $excludeId);
        }

        return $query->doesntExist();
    }

    /**
     * Calculate and accumulate discount for discount_product type promotions
     *
     * @param PromotionSimplified $promotion
     * @return bool
     */
    public static function processDiscountProductPromotion(PromotionSimplified $promotion): bool
    {
        try {
            // Check if promotion is discount_product type and active
            if ($promotion->type !== 'discount_product' || !$promotion->is_active) {
                return false;
            }

            // Check if promotion has discount products
            if (empty($promotion->discount_products)) {
                return false;
            }

            // Check if promotion is valid based on date, day, and time
            if (!self::isPromotionValidNow($promotion)) {
                return false;
            }

            // Process each discount product
            foreach ($promotion->discount_products as $discountProduct) {
                self::updateProductPriceDiscount($discountProduct, $promotion);
            }

            Log::info("Discount product promotion processed successfully", [
                'promotion_id' => $promotion->id,
                'promotion_code' => $promotion->code
            ]);

            return true;
        } catch (\Exception $e) {
            \Log::error("Failed to process discount product promotion", [
                'promotion_id' => $promotion->id,
                'error' => $e->getMessage()
            ]);
            return false;
        }
    }

    /**
     * Check if promotion is valid based on current date, day, and time
     *
     * @param PromotionSimplified $promotion
     * @return bool
     */
    public static function isPromotionValidNow(PromotionSimplified $promotion): bool
    {
        $now = Carbon::now();

        // Check date range
        if (!self::isDateValid($promotion, $now)) {
            return false;
        }

        // Check schedule type
        switch ($promotion->schedule_type) {
            case 'always':
                return true;

            case 'days_only':
                return self::isDayValid($promotion, $now);

            case 'time_only':
                return self::isTimeValid($promotion, $now);

            case 'days_and_time':
                return self::isDayValid($promotion, $now) && self::isTimeValid($promotion, $now);

            default:
                return true;
        }
    }

    /**
     * Check if current date is within promotion date range
     *
     * @param PromotionSimplified $promotion
     * @param Carbon $now
     * @return bool
     */
    private static function isDateValid(PromotionSimplified $promotion, Carbon $now): bool
    {
        $startDate = Carbon::parse($promotion->start_date)->startOfDay();
        $endDate = Carbon::parse($promotion->end_date)->endOfDay();

        return $now->between($startDate, $endDate);
    }

    /**
     * Check if current day is valid for promotion
     *
     * @param PromotionSimplified $promotion
     * @param Carbon $now
     * @return bool
     */
    private static function isDayValid(PromotionSimplified $promotion, Carbon $now): bool
    {
        if (empty($promotion->specific_days)) {
            return true;
        }

        $currentDay = strtolower($now->format('l')); // monday, tuesday, etc.
        return in_array($currentDay, $promotion->specific_days);
    }

    /**
     * Check if current time is valid for promotion
     *
     * @param PromotionSimplified $promotion
     * @param Carbon $now
     * @return bool
     */
    private static function isTimeValid(PromotionSimplified $promotion, Carbon $now): bool
    {
        if (empty($promotion->specific_start_time) || empty($promotion->specific_end_time)) {
            return true;
        }

        $currentTime = $now->format('H:i:s');
        $startTime = Carbon::parse($promotion->specific_start_time)->format('H:i:s');
        $endTime = Carbon::parse($promotion->specific_end_time)->format('H:i:s');

        // Handle time range that crosses midnight
        if ($startTime > $endTime) {
            return $currentTime >= $startTime || $currentTime <= $endTime;
        }

        return $currentTime >= $startTime && $currentTime <= $endTime;
    }

    /**
     * Update product price discount based on promotion
     *
     * @param array $discountProduct
     * @param PromotionSimplified $promotion
     * @return void
     */
    private static function updateProductPriceDiscount(array $discountProduct, PromotionSimplified $promotion): void
    {
        $productId = $discountProduct['product_id'];
        $discountType = $discountProduct['discount_type'] ?? 'percentage';
        $discountValue = $discountProduct['discount_value'] ?? 0;

        // Get current product price
        $productPrice = \App\Models\Product\ProductPrice::where('product_id', $productId)
            ->where('company_id', $promotion->company_id)
            ->latest()
            ->first();

        if (!$productPrice) {
            \Log::warning("Product price not found for discount processing", [
                'product_id' => $productId,
                'promotion_id' => $promotion->id
            ]);
            return;
        }

        // Calculate final discounted price
        $finalDiscountedPrice = self::calculateDiscountAmount(
            $productPrice->price,
            $discountType,
            $discountValue
        );

        // Calculate discount amount for logging
        $discountAmount = $productPrice->price - $finalDiscountedPrice;

        // Update product price_discount to the new discounted price
        $productPrice->update([
            'price_discount' => $finalDiscountedPrice
        ]);

        \Log::info("Product price discount applied", [
            'product_id' => $productId,
            'promotion_id' => $promotion->id,
            'original_price' => $productPrice->price,
            'discount_type' => $discountType,
            'discount_value' => $discountValue,
            'discount_amount' => $discountAmount,
            'final_price' => $finalDiscountedPrice,
            'savings' => $discountAmount
        ]);
    }

    /**
     * Calculate final price after discount (not discount amount)
     *
     * @param float $originalPrice
     * @param string $discountType
     * @param float $discountValue
     * @return float
     */
    private static function calculateDiscountAmount(float $originalPrice, string $discountType, float $discountValue): float
    {
        if ($discountType === 'percentage') {
            // Calculate discounted price: original price - (original price * percentage / 100)
            $discountAmount = ($originalPrice * $discountValue) / 100;
            return max(0, $originalPrice - $discountAmount);
        } else {
            // Fixed amount discount: original price - fixed amount
            return max(0, $originalPrice - $discountValue);
        }
    }

    /**
     * Reset product price discounts for a specific promotion
     * Sets price_discount back to original price (removes discount)
     *
     * @param PromotionSimplified $promotion
     * @return void
     */
    public static function resetPromotionDiscounts(PromotionSimplified $promotion): void
    {
        if (empty($promotion->discount_products)) {
            return;
        }

        foreach ($promotion->discount_products as $discountProduct) {
            $productId = $discountProduct['product_id'];

            // Get current product price
            $productPrice = \App\Models\Product\ProductPrice::where('product_id', $productId)
                ->where('company_id', $promotion->company_id)
                ->latest()
                ->first();

            if (!$productPrice) {
                continue;
            }

            // Reset price_discount to original price (remove discount)
            $originalDiscount = $productPrice->price_discount;
            $productPrice->update([
                'price_discount' => $productPrice->price
            ]);

            \Log::info("Product price discount reset for promotion", [
                'product_id' => $productId,
                'promotion_id' => $promotion->id,
                'original_price' => $productPrice->price,
                'previous_discounted_price' => $originalDiscount,
                'reset_to_price' => $productPrice->price
            ]);
        }
    }

    /**
     * Recalculate all active discount product promotions for all products
     * This can be used for maintenance or when schedule changes
     *
     * @return void
     */
    public static function recalculateAllDiscountPromotions(): void
    {
        // Reset all product price discounts to original price first
        \DB::statement('UPDATE product_prices SET price_discount = price WHERE price_discount != price');

        // Get all active discount_product promotions
        $activePromotions = PromotionSimplified::where('type', 'discount_product')
            ->where('is_active', true)
            ->get();

        foreach ($activePromotions as $promotion) {
            self::processDiscountProductPromotion($promotion);
        }

        \Log::info("Recalculated all discount product promotions", [
            'processed_promotions' => $activePromotions->count()
        ]);
    }

    /**
     * Get current discounted price for a product
     * Returns the actual selling price after all discounts
     *
     * @param string $productId
     * @param string $companyId
     * @return float
     */
    public static function getCurrentProductPrice(string $productId, string $companyId): float
    {
        $productPrice = \App\Models\Product\ProductPrice::where('product_id', $productId)
            ->where('company_id', $companyId)
            ->latest()
            ->first();

        if (!$productPrice) {
            return 0;
        }

        // If price_discount is set and different from price, use price_discount as the selling price
        if ($productPrice->price_discount && $productPrice->price_discount != $productPrice->price) {
            return $productPrice->price_discount;
        }

        // Otherwise return original price
        return $productPrice->price;
    }

    /**
     * Get discount amount for a product
     * Returns how much discount is applied
     *
     * @param string $productId
     * @param string $companyId
     * @return float
     */
    public static function getProductDiscountAmount(string $productId, string $companyId): float
    {
        $productPrice = \App\Models\Product\ProductPrice::where('product_id', $productId)
            ->where('company_id', $companyId)
            ->latest()
            ->first();

        if (!$productPrice) {
            return 0;
        }

        // Calculate discount amount: original price - discounted price
        if ($productPrice->price_discount && $productPrice->price_discount != $productPrice->price) {
            return $productPrice->price - $productPrice->price_discount;
        }

        return 0;
    }

    /**
     * Get discount percentage for a product
     * Returns discount percentage
     *
     * @param string $productId
     * @param string $companyId
     * @return float
     */
    public static function getProductDiscountPercentage(string $productId, string $companyId): float
    {
        $productPrice = \App\Models\Product\ProductPrice::where('product_id', $productId)
            ->where('company_id', $companyId)
            ->latest()
            ->first();

        if (!$productPrice || $productPrice->price <= 0) {
            return 0;
        }

        $discountAmount = self::getProductDiscountAmount($productId, $companyId);

        if ($discountAmount <= 0) {
            return 0;
        }

        return round(($discountAmount / $productPrice->price) * 100, 2);
    }

    /**
     * Get final selling price for a product (after discount)
     * Returns the actual price customer will pay
     *
     * @param string $productId
     * @param string $companyId
     * @return float
     */
    public static function getFinalProductPrice(string $productId, string $companyId): float
    {
        return self::getCurrentProductPrice($productId, $companyId);
    }

    /**
     * Get product price info (original, discount, final)
     * Returns array with complete price information
     *
     * @param string $productId
     * @param string $companyId
     * @return array
     */
    public static function getProductPriceInfo(string $productId, string $companyId): array
    {
        $productPrice = \App\Models\Product\ProductPrice::where('product_id', $productId)
            ->where('company_id', $companyId)
            ->latest()
            ->first();

        if (!$productPrice) {
            return [
                'original_price' => 0,
                'final_price' => 0,
                'discount_amount' => 0,
                'discount_percentage' => 0,
                'has_discount' => false
            ];
        }

        $originalPrice = $productPrice->price;

        // Fix: Only use price_discount if it's greater than 0 AND different from original price
        $finalPrice = ($productPrice->price_discount > 0 && $productPrice->price_discount != $productPrice->price)
            ? $productPrice->price_discount
            : $productPrice->price;

        $discountAmount = $originalPrice - $finalPrice;
        $discountPercentage = $originalPrice > 0 ? round(($discountAmount / $originalPrice) * 100, 2) : 0;

        return [
            'original_price' => $originalPrice,
            'final_price' => $finalPrice,
            'discount_amount' => $discountAmount,
            'discount_percentage' => $discountPercentage,
            'has_discount' => $discountAmount > 0 && $finalPrice < $originalPrice
        ];
    }
}
