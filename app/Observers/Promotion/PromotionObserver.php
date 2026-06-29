<?php

namespace App\Observers\Promotion;

use App\Helpers\PromotionHelper;
use App\Jobs\ProcessDiscountProductPromotion;
use App\Models\Promotion\Promotion;
use App\Models\Promotion\PromotionSimplified;

class PromotionObserver
{
    // Observer ini akan menangani event pada model PromotionSimplified ketika dibuat atau diperbarui.
    public function saved(PromotionSimplified $promotion)
    {
        // Set default values for new promotions
        if (is_null($promotion->start_date)) {
            $promotion->start_date = now();
        }
        if (is_null($promotion->end_date)) {
            $promotion->end_date = now()->addMonth();
        }
        if (is_null($promotion->is_active)) {
            $promotion->is_active = true;
        }

        // Process discount product promotion if applicable
        $this->processDiscountProductPromotion($promotion);
    }

    public function updating(PromotionSimplified $promotion)
    {
        // Ensure that the promotion code is unique
        $existingPromotion = PromotionSimplified::where('code', $promotion->code)
            ->where('id', '!=', $promotion->id)
            ->first();

        if ($existingPromotion) {
            throw new \Exception('Promotion code must be unique.');
        }

        // Reset discounts for the old promotion data before updating
        if ($promotion->isDirty(['type', 'is_active', 'discount_products'])) {
            $originalPromotion = PromotionSimplified::find($promotion->id);
            if ($originalPromotion && $originalPromotion->type === 'discount_product') {
                PromotionHelper::resetPromotionDiscounts($originalPromotion);
            }
        }
    }

    public function updated(PromotionSimplified $promotion)
    {
        // Process discount product promotion after update
        $this->processDiscountProductPromotion($promotion);
    }

    public function deleting(PromotionSimplified $promotion)
    {
        // Reset discounts when promotion is deleted
        if ($promotion->type === 'discount_product') {
            PromotionHelper::resetPromotionDiscounts($promotion);
        }
    }

    /**
     * Process discount product promotion
     *
     * @return void
     */
    private function processDiscountProductPromotion(PromotionSimplified $promotion)
    {
        if ($promotion->type === 'discount_product' && $promotion->is_active) {
            // Dispatch job to process discount in background
            ProcessDiscountProductPromotion::dispatch($promotion->id);
        }
    }
}
