<?php

namespace App\Jobs;

use App\Helpers\PromotionHelper;
use App\Models\Promotion\PromotionSimplified;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;

class ProcessDiscountProductPromotion implements ShouldQueue
{
    use Queueable;

    protected $promotionId;

    protected $options;

    /**
     * The number of times the job may be attempted.
     */
    public $tries = 3;

    /**
     * The maximum number of seconds the job may run.
     */
    public $timeout = 60;

    /**
     * Create a new job instance.
     */
    public function __construct(string $promotionId, array $options = [])
    {
        $this->promotionId = $promotionId;
        $this->options = $options;

        // Set queue priority based on options
        if (isset($options['priority'])) {
            $this->onQueue($options['priority'] === 'high' ? 'high-priority' : 'default');
        }
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $startTime = microtime(true);

        try {
            // Check if this promotion was recently processed to avoid duplicate work
            $cacheKey = "promotion_processed_{$this->promotionId}";
            if (Cache::has($cacheKey) && ! ($this->options['force_reprocess'] ?? false)) {
                Log::debug('Promotion already processed recently, skipping', [
                    'promotion_id' => $this->promotionId,
                ]);

                return;
            }

            // Load only necessary fields to reduce memory usage
            $promotion = PromotionSimplified::select([
                'id',
                'type',
                'is_active',
                'company_id',
                'discount_products',
                'start_date',
                'end_date',
                'schedule_type',
                'specific_days',
                'specific_start_time',
                'specific_end_time',
                'code',
                'name',
            ])->find($this->promotionId);

            if (! $promotion) {
                Log::warning('Promotion not found for discount processing', [
                    'promotion_id' => $this->promotionId,
                ]);

                return;
            }

            // Quick validation before processing
            if (! $this->shouldProcessPromotion($promotion)) {
                Log::debug('Promotion validation failed, skipping processing', [
                    'promotion_id' => $this->promotionId,
                    'promotion_code' => $promotion->code,
                ]);

                return;
            }

            // Process the discount product promotion
            $result = PromotionHelper::processDiscountProductPromotion($promotion);

            if ($result) {
                // Cache the processed status to avoid duplicate processing
                Cache::put($cacheKey, true, now()->addMinutes(5));

                // Update last processed timestamp
                Cache::put('last_promotion_processed_at', now()->toISOString());

                $processingTime = round((microtime(true) - $startTime) * 1000, 2);

                Log::info('Discount product promotion processed successfully via job', [
                    'promotion_id' => $this->promotionId,
                    'promotion_code' => $promotion->code,
                    'processing_time_ms' => $processingTime,
                    'products_processed' => count($promotion->discount_products ?? []),
                ]);
            }
        } catch (\Exception $e) {
            $processingTime = round((microtime(true) - $startTime) * 1000, 2);

            Log::error('Failed to process discount product promotion via job', [
                'promotion_id' => $this->promotionId,
                'error' => $e->getMessage(),
                'processing_time_ms' => $processingTime,
                'attempt' => $this->attempts(),
            ]);

            // Only log full trace on final attempt to reduce log noise
            if ($this->attempts() >= $this->tries) {
                Log::error('Final attempt failed, full trace:', [
                    'promotion_id' => $this->promotionId,
                    'trace' => $e->getTraceAsString(),
                ]);
            }

            // Re-throw the exception to mark the job as failed
            throw $e;
        }
    }

    /**
     * Quick validation to avoid unnecessary processing
     */
    private function shouldProcessPromotion($promotion): bool
    {
        // Check basic requirements
        if ($promotion->type !== 'discount_product' || ! $promotion->is_active) {
            return false;
        }

        // Check if has discount products
        if (empty($promotion->discount_products)) {
            return false;
        }

        // Quick date validation (more detailed validation will be done in helper)
        $now = now();
        if ($promotion->start_date && $now->lt($promotion->start_date)) {
            return false;
        }

        if ($promotion->end_date && $now->gt($promotion->end_date)) {
            return false;
        }

        return true;
    }

    /**
     * Handle a job failure.
     */
    public function failed(\Throwable $exception): void
    {
        Log::error('ProcessDiscountProductPromotion job failed permanently', [
            'promotion_id' => $this->promotionId,
            'error' => $exception->getMessage(),
            'attempts' => $this->attempts(),
        ]);

        // Clear cache on permanent failure
        Cache::forget("promotion_processed_{$this->promotionId}");
    }

    /**
     * Calculate the number of seconds to wait before retrying the job.
     */
    public function backoff(): array
    {
        return [30, 60, 120]; // Wait 30s, then 1m, then 2m between retries
    }
}
