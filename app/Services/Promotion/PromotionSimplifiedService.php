<?php

namespace App\Services\Promotion;

use App\Models\Promotion\PromotionSimplified;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class PromotionSimplifiedService
{
    /**
     * Get available discount promotions for dropdown
     */
    public function getAvailableDiscountPromotions($companyId = null, $userType = null)
    {
        $companyId = $companyId ?? Auth::user()->company_id;
        $userType = $userType ?? Auth::user()->user_type_id;

        return PromotionSimplified::where('type', 'discount')
            // Remove the company_id filter - promotions can be created by any company
            // but applied to specific companies via applicable_companies
            ->active()
            ->inDateRange()
            ->inTimeRange()
            ->forToday()
            ->hasQuota()
            ->where(function ($query) use ($companyId) {
                // Company validation: if applicable_companies is null or empty, applies to all companies
                // If it contains companies, check if current company is included
                $query->whereNull('applicable_companies')
                    ->orWhereRaw("CAST(applicable_companies AS TEXT) = '[]'")
                    ->orWhereRaw("CAST(applicable_companies AS TEXT) = ''")
                    ->orWhereJsonContains('applicable_companies', $companyId);
            })
            ->where(function ($query) use ($userType) {
                // User type validation: if applicable_user_types is null or empty, applies to all user types
                // If it contains user types, check if current user type is included
                $query->whereNull('applicable_user_types')
                    ->orWhereRaw("CAST(applicable_user_types AS TEXT) = '[]'")
                    ->orWhereRaw("CAST(applicable_user_types AS TEXT) = ''")
                    ->orWhereJsonContains('applicable_user_types', $userType);
            })
            ->orderBy('name', 'asc')
            ->get()
            ->map(function ($promotion) {
                return [
                    'id' => $promotion->id,
                    'name' => $promotion->name,
                    'code' => $promotion->code,
                    'description' => $promotion->description,
                    'discount_text' => $this->getDiscountText($promotion),
                    'minimum_purchase' => $promotion->minimum_purchase,
                    'maximum_discount' => $promotion->max_discount,
                    'applicable_companies' => $promotion->applicable_companies,
                    'applicable_user_types' => $promotion->applicable_user_types,
                ];
            });
    }

    /**
     * Calculate discount from promotion
     */
    public function calculatePromotionDiscount($promotionId, $totalAmount, $companyId = null, $userType = null)
    {
        if (!$promotionId) {
            return [
                'eligible' => false,
                'discount_amount' => 0,
                'message' => '',
                'promotion' => null
            ];
        }

        $companyId = $companyId ?? Auth::user()->company_id;
        $userType = $userType ?? Auth::user()->type_user;

        try {
            $promotion = PromotionSimplified::find($promotionId);
        } catch (\Exception $e) {
            return [
                'eligible' => false,
                'discount_amount' => 0,
                'message' => 'ID promosi tidak valid',
                'promotion' => null
            ];
        }

        if (!$promotion || !$promotion->isValid()) {
            return [
                'eligible' => false,
                'discount_amount' => 0,
                'message' => 'Promosi tidak valid atau sudah berakhir',
                'promotion' => null
            ];
        }

        if ($promotion->type !== 'discount') {
            return [
                'eligible' => false,
                'discount_amount' => 0,
                'message' => 'Promosi bukan tipe discount',
                'promotion' => null
            ];
        }

        // Check company eligibility
        if (!$this->isCompanyEligible($promotion, $companyId)) {
            return [
                'eligible' => false,
                'discount_amount' => 0,
                'message' => 'Promosi tidak berlaku untuk perusahaan ini',
                'promotion' => $promotion
            ];
        }

        // Check user type eligibility
        if (!$this->isUserTypeEligible($promotion, $userType)) {
            return [
                'eligible' => false,
                'discount_amount' => 0,
                'message' => 'Promosi tidak berlaku untuk tipe user ini',
                'promotion' => $promotion
            ];
        }

        // Check minimum purchase
        if ($totalAmount < $promotion->minimum_purchase) {
            return [
                'eligible' => false,
                'discount_amount' => 0,
                'message' => 'Minimal pembelian Rp ' . number_format($promotion->minimum_purchase, 0, ',', '.'),
                'promotion' => $promotion
            ];
        }

        // Calculate discount
        $discountAmount = $this->calculateDiscount($promotion, $totalAmount);

        return [
            'eligible' => true,
            'discount_amount' => $discountAmount,
            'message' => 'Promosi berhasil diterapkan',
            'promotion' => $promotion
        ];
    }

    /**
     * Calculate actual discount amount
     */
    private function calculateDiscount($promotion, $amount)
    {
        switch ($promotion->discount_type) {
            case 'percentage':
                $discount = ($amount * $promotion->discount_value) / 100;
                if ($promotion->max_discount && $discount > $promotion->max_discount) {
                    $discount = $promotion->max_discount;
                }
                return $discount;

            case 'fixed':
                return min($promotion->discount_value, $amount);

            case 'fixed_price':
                return max(0, $amount - $promotion->discount_value);

            default:
                return 0;
        }
    }

    /**
     * Get discount text for display
     */
    private function getDiscountText($promotion)
    {
        switch ($promotion->discount_type) {
            case 'percentage':
                $text = $promotion->discount_value . '% OFF';
                if ($promotion->max_discount) {
                    $text .= ' (Maks. Rp ' . number_format($promotion->max_discount, 0, ',', '.') . ')';
                }
                return $text;

            case 'fixed':
                return 'Rp ' . number_format($promotion->discount_value, 0, ',', '.') . ' OFF';

            case 'fixed_price':
                return 'Harga Spesial Rp ' . number_format($promotion->discount_value, 0, ',', '.');

            default:
                return $promotion->name;
        }
    }

    /**
     * Validate promotion time restrictions
     */
    public function validateTimeRestrictions($promotion)
    {
        $now = Carbon::now();

        // Check date range
        if ($promotion->start_date && $promotion->start_date > $now) {
            return false;
        }

        if ($promotion->end_date && $promotion->end_date < $now) {
            return false;
        }

        // Check time range
        if ($promotion->start_time || $promotion->end_time) {
            $currentTime = $now->format('H:i:s');

            if ($promotion->start_time && $promotion->start_time > $currentTime) {
                return false;
            }

            if ($promotion->end_time && $promotion->end_time < $currentTime) {
                return false;
            }
        }

        // Check applicable days
        if ($promotion->applicable_days && !empty($promotion->applicable_days)) {
            $today = strtolower($now->format('l'));
            if (!in_array($today, $promotion->applicable_days)) {
                return false;
            }
        }

        return true;
    }

    /**
     * Apply promotion to transaction
     */
    public function applyPromotionToTransaction($transaction, $promotionId)
    {
        if (!$promotionId) {
            // Clear promotion
            $transaction->update([
                'promotion_simplified_id' => null,
                'promotion_real' => 0,
                'promotion' => 0,
                'promotion_type' => 'rupiah',
                'promotion_value' => 0,
            ]);
            return true;
        }

        $result = $this->calculatePromotionDiscount($promotionId, $transaction->sub_total_price);

        if (!$result['eligible']) {
            return false;
        }

        $promotion = $result['promotion'];

        // Update transaction with promotion
        $transaction->update([
            'promotion_simplified_id' => $promotion->id,
            'promotion_real' => $result['discount_amount'],
            'promotion' => $result['discount_amount'],
            'promotion_type' => $promotion->discount_type === 'percentage' ? 'percentage' : 'rupiah',
            'promotion_value' => $promotion->discount_value,
        ]);

        return true;
    }

    /**
     * Get promotion summary for display
     */
    public function getPromotionSummary($promotionId, $totalAmount)
    {
        if (!$promotionId) {
            return null;
        }

        $result = $this->calculatePromotionDiscount($promotionId, $totalAmount);

        if (!$result['eligible'] || !$result['promotion']) {
            return null;
        }

        $promotion = $result['promotion'];

        return [
            'name' => $promotion->name,
            'description' => $promotion->description,
            'discount_text' => $this->getDiscountText($promotion),
            'discount_amount' => $result['discount_amount'],
            'message' => $result['message'],
        ];
    }

    /**
     * Check if promotion is eligible for the given company
     */
    private function isCompanyEligible($promotion, $companyId)
    {
        // If applicable_companies is null or empty, promotion applies to all companies
        if (empty($promotion->applicable_companies)) {
            return true;
        }

        // If applicable_companies is a JSON array, check if company ID is in it
        $applicableCompanies = is_string($promotion->applicable_companies)
            ? json_decode($promotion->applicable_companies, true)
            : $promotion->applicable_companies;

        if (!is_array($applicableCompanies)) {
            return true; // If malformed, allow promotion to be safe
        }

        return in_array($companyId, $applicableCompanies);
    }

    /**
     * Check if promotion is eligible for the given user type
     */
    private function isUserTypeEligible($promotion, $userType)
    {
        // If applicable_user_types is null or empty, promotion applies to all user types
        if (empty($promotion->applicable_user_types)) {
            return true;
        }

        // If applicable_user_types is a JSON array, check if user type is in it
        $applicableUserTypes = is_string($promotion->applicable_user_types)
            ? json_decode($promotion->applicable_user_types, true)
            : $promotion->applicable_user_types;

        if (!is_array($applicableUserTypes)) {
            return true; // If malformed, allow promotion to be safe
        }

        return in_array($userType, $applicableUserTypes);
    }

    /**
     * Validate promotion eligibility for company and user type
     */
    public function validatePromotionEligibility($promotionId, $companyId = null, $userType = null)
    {
        $companyId = $companyId ?? Auth::user()->company_id;
        $userType = $userType ?? Auth::user()->type_user;

        $promotion = PromotionSimplified::find($promotionId);

        if (!$promotion) {
            return [
                'eligible' => false,
                'reasons' => ['Promosi tidak ditemukan']
            ];
        }

        $reasons = [];

        if (!$this->isCompanyEligible($promotion, $companyId)) {
            $reasons[] = 'Promosi tidak berlaku untuk perusahaan ini';
        }

        if (!$this->isUserTypeEligible($promotion, $userType)) {
            $reasons[] = 'Promosi tidak berlaku untuk tipe user ini';
        }

        if (!$promotion->isValid()) {
            $reasons[] = 'Promosi tidak valid atau sudah berakhir';
        }

        return [
            'eligible' => empty($reasons),
            'reasons' => $reasons,
            'promotion' => $promotion
        ];
    }
}
