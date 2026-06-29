<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PromotionResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'code' => $this->code,
            'name' => $this->name,
            'description' => $this->description,
            'type' => $this->type,
            'type_display' => $this->getTypeDisplayAttribute(),

            // Date information
            'start_date' => $this->start_date->format('Y-m-d H:i:s'),
            'end_date' => $this->end_date->format('Y-m-d H:i:s'),
            'is_active_period' => $this->isActivePeriod(),
            'days_remaining' => $this->daysRemaining(),

            // Discount information
            'discount_value' => $this->discount_value,
            'discount_display' => $this->getDiscountDisplayAttribute(),
            'minimum_purchase' => $this->minimum_purchase,
            'maximum_discount' => $this->maximum_discount,

            // Usage information
            'usage_count' => $this->usage_count,
            'usage_limit' => $this->usage_limit,
            'usage_remaining' => $this->usage_limit ? $this->usage_limit - $this->usage_count : null,
            'usage_limit_per_customer' => $this->usage_limit_per_customer,
            'usage_percentage' => $this->getUsagePercentageAttribute(),

            // Customer targeting
            'customer_type' => $this->customer_type,
            'customer_type_display' => $this->getCustomerTypeDisplayAttribute(),
            'customer_ids' => $this->customer_ids,

            // Product applicability
            'applicable_to' => $this->applicable_to,
            'applicable_to_display' => $this->getApplicableToDisplayAttribute(),
            'product_ids' => $this->product_ids,
            'category_ids' => $this->category_ids,
            'service_ids' => $this->service_ids,

            // Special settings
            'buy_quantity' => $this->when($this->type === 'buy_x_get_y', $this->buy_quantity),
            'get_quantity' => $this->when($this->type === 'buy_x_get_y', $this->get_quantity),
            'get_product_id' => $this->when($this->type === 'buy_x_get_y', $this->get_product_id),
            'bundle_products' => $this->when($this->type === 'bundle', $this->bundle_products),
            'bundle_price' => $this->when($this->type === 'bundle', $this->bundle_price),

            // Settings
            'auto_apply' => $this->auto_apply,
            'is_featured' => $this->is_featured,
            'is_active' => $this->is_active,
            'status' => $this->getStatusAttribute(),
            'status_color' => $this->getStatusColorAttribute(),

            // Media
            'image_url' => $this->getImageUrlAttribute(),

            // Terms and conditions
            'terms_conditions' => $this->terms_conditions,

            // Calculated fields
            'can_be_used' => $this->canBeUsed(),
            'eligibility_message' => $this->getEligibilityMessage(),

            // Timestamps
            'created_at' => $this->created_at->format('Y-m-d H:i:s'),
            'updated_at' => $this->updated_at->format('Y-m-d H:i:s'),

            // Conditional relationships
            'usage_histories' => $this->whenLoaded('usageHistories', function () {
                return PromotionUsageResource::collection($this->usageHistories);
            }),

            // Statistics (when requested)
            'statistics' => $this->when($request->include_statistics, function () {
                return [
                    'total_revenue' => $this->getTotalRevenueAttribute(),
                    'total_savings' => $this->getTotalSavingsAttribute(),
                    'unique_customers' => $this->getUniqueCustomersCountAttribute(),
                    'conversion_rate' => $this->getConversionRateAttribute(),
                    'average_order_value' => $this->getAverageOrderValueAttribute(),
                ];
            }),
        ];
    }

    /**
     * Get additional data for admin users
     */
    public function withAdminData(): array
    {
        return array_merge($this->toArray(request()), [
            'admin_notes' => $this->admin_notes,
            'created_by' => $this->creator?->name,
            'last_modified_by' => $this->modifier?->name,
            'performance_metrics' => [
                'click_through_rate' => $this->getClickThroughRateAttribute(),
                'redemption_rate' => $this->getRedemptionRateAttribute(),
                'roi' => $this->getROIAttribute(),
            ],
        ]);
    }
}
