<?php

namespace App\Services\Promotion;

use App\Helpers\PromotionHelper;
use App\Jobs\ProcessDiscountProductPromotion;
use App\Models\Promotion\Promotion;
use App\Models\Promotion\PromotionSimplified;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Queue;

/**
 * Class PromotionQuantityService.
 */
class PromotionQuantityService
{
    /**
     * Recalculate all discounts with lightweight approach
     *
     * @param  array  $options
     * @return void
     */
    public function recalculateAllDiscounts($options = [])
    {
        $batchSize = $options['batch_size'] ?? 10; // Process in smaller batches
        $useQueue = $options['use_queue'] ?? true;
        $validateTime = $options['validate_time'] ?? true;

        $query = PromotionSimplified::where('is_active', true)
            ->where('type', 'discount_product');

        // Add time validation to reduce unnecessary processing
        if ($validateTime) {
            $query = $this->addTimeValidationToQuery($query);
        }

        $promotions = $query->select('id', 'start_date', 'end_date', 'schedule_type', 'specific_start_time', 'specific_end_time', 'specific_days')
            ->get();

        if ($promotions->isEmpty()) {
            Log::info('No active discount_product promotions found for recalculation');

            return;
        }

        // Process in chunks to reduce memory usage
        $chunks = $promotions->chunk($batchSize);

        foreach ($chunks as $chunk) {
            if ($useQueue) {
                // Dispatch batch job for better performance
                $this->dispatchBatchJob($chunk);
            } else {
                // Process synchronously for immediate results
                $this->processSynchronously($chunk);
            }
        }

        Log::info("Dispatched {$promotions->count()} promotions for discount recalculation in ".$chunks->count().' batches');
    }

    /**
     * Quick validation without processing
     *
     * @return array
     */
    public function validateActivePromotions()
    {
        $promotions = PromotionSimplified::where('is_active', true)
            ->where('type', 'discount_product')
            ->select('id', 'name', 'code', 'start_date', 'end_date', 'schedule_type', 'specific_start_time', 'specific_end_time', 'specific_days')
            ->get();

        $results = [
            'total' => $promotions->count(),
            'valid_now' => 0,
            'invalid_time' => 0,
            'invalid_date' => 0,
            'details' => [],
        ];

        foreach ($promotions as $promotion) {
            $isValid = PromotionHelper::isPromotionValidNow($promotion);

            if ($isValid) {
                $results['valid_now']++;
            } else {
                // Check specific reason for invalidity
                if (! $this->isDateValid($promotion)) {
                    $results['invalid_date']++;
                } else {
                    $results['invalid_time']++;
                }
            }

            $results['details'][] = [
                'id' => $promotion->id,
                'code' => $promotion->code,
                'name' => $promotion->name,
                'is_valid' => $isValid,
            ];
        }

        return $results;
    }

    /**
     * Process specific promotion IDs only
     *
     * @param  bool  $useQueue
     * @return void
     */
    public function recalculateSpecificPromotions(array $promotionIds, $useQueue = true)
    {
        if (empty($promotionIds)) {
            return;
        }

        $promotions = PromotionSimplified::whereIn('id', $promotionIds)
            ->where('is_active', true)
            ->where('type', 'discount_product')
            ->select('id')
            ->get();

        foreach ($promotions as $promotion) {
            if ($useQueue) {
                ProcessDiscountProductPromotion::dispatch($promotion->id);
            } else {
                // Process immediately
                PromotionHelper::processDiscountProductPromotion($promotion);
            }
        }

        Log::info("Processed {$promotions->count()} specific promotions for discount recalculation");
    }

    /**
     * Light validation - only process promotions that are likely to be valid
     *
     * @return void
     */
    public function recalculateValidPromotionsOnly()
    {
        $promotions = PromotionSimplified::where('is_active', true)
            ->where('type', 'discount_product')
            ->where('start_date', '<=', now())
            ->where('end_date', '>=', now())
            ->select('id')
            ->get();

        foreach ($promotions as $promotion) {
            ProcessDiscountProductPromotion::dispatch($promotion->id);
        }

        Log::info("Dispatched {$promotions->count()} time-valid promotions for discount recalculation");
    }

    /**
     * Add time validation to query to reduce dataset
     *
     * @return mixed
     */
    private function addTimeValidationToQuery($query)
    {
        return $query->where('start_date', '<=', now())
            ->where('end_date', '>=', now());
    }

    /**
     * Dispatch batch job for multiple promotions
     *
     * @return void
     */
    private function dispatchBatchJob($promotions)
    {
        $promotionIds = $promotions->pluck('id')->toArray();

        // Dispatch with delay to spread load
        ProcessDiscountProductPromotion::dispatch($promotionIds[0])
            ->delay(now()->addSeconds(rand(1, 5)));

        // For remaining items, add incremental delay
        foreach (array_slice($promotionIds, 1) as $index => $promotionId) {
            ProcessDiscountProductPromotion::dispatch($promotionId)
                ->delay(now()->addSeconds(($index + 1) * 2));
        }
    }

    /**
     * Process promotions synchronously
     *
     * @return void
     */
    private function processSynchronously($promotions)
    {
        foreach ($promotions as $promotion) {
            try {
                // Load full promotion data only when needed
                $fullPromotion = PromotionSimplified::find($promotion->id);
                PromotionHelper::processDiscountProductPromotion($fullPromotion);
            } catch (\Exception $e) {
                Log::error("Failed to process promotion {$promotion->id}: ".$e->getMessage());
            }
        }
    }

    /**
     * Check if promotion date range is valid
     *
     * @return bool
     */
    private function isDateValid($promotion)
    {
        $now = now();
        $startDate = Carbon::parse($promotion->start_date)->startOfDay();
        $endDate = Carbon::parse($promotion->end_date)->endOfDay();

        return $now->between($startDate, $endDate);
    }

    /**
     * Get queue status for monitoring
     *
     * @return array
     */
    public function getQueueStatus()
    {
        return [
            'pending_jobs' => Queue::size(),
            'failed_jobs' => Queue::size('failed'),
            'last_processed' => cache()->get('last_promotion_processed_at'),
        ];
    }
}
