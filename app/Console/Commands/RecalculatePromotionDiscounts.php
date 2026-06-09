<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Helpers\PromotionHelper;

class RecalculatePromotionDiscounts extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'promotion:recalculate-discounts
                            {--force : Force recalculation even if promotions are active}
                            {--batch-size=10 : Number of promotions to process per batch}
                            {--sync : Process synchronously without queue}
                            {--validate-only : Only validate promotions without processing}
                            {--specific-ids= : Comma-separated promotion IDs to process}
                            {--light : Use lightweight processing (only valid promotions)}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Recalculate all active discount product promotions and update product prices with optimized processing';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $service = new \App\Services\Promotion\PromotionQuantityService();

        // Validation only mode
        if ($this->option('validate-only')) {
            return $this->runValidationOnly($service);
        }

        // Specific IDs mode
        if ($this->option('specific-ids')) {
            return $this->processSpecificIds($service);
        }

        // Light processing mode
        if ($this->option('light')) {
            return $this->runLightProcessing($service);
        }

        // Full processing mode
        return $this->runFullProcessing($service);
    }

    /**
     * Run validation only
     */
    private function runValidationOnly($service)
    {
        $this->info('🔍 Validating active promotions...');

        $results = $service->validateActivePromotions();

        $this->info("📊 Validation Results:");
        $this->line("Total promotions: {$results['total']}");
        $this->line("Valid now: {$results['valid_now']}");
        $this->line("Invalid (date): {$results['invalid_date']}");
        $this->line("Invalid (time): {$results['invalid_time']}");

        return Command::SUCCESS;
    }

    /**
     * Process specific promotion IDs
     */
    private function processSpecificIds($service)
    {
        $ids = array_filter(explode(',', $this->option('specific-ids')));

        if (empty($ids)) {
            $this->error('No valid promotion IDs provided');
            return Command::FAILURE;
        }

        $this->info("🎯 Processing specific promotions: " . implode(', ', $ids));

        $useQueue = !$this->option('sync');
        $service->recalculateSpecificPromotions($ids, $useQueue);

        $this->info("✅ Dispatched " . count($ids) . " promotions for processing");

        return Command::SUCCESS;
    }

    /**
     * Run lightweight processing
     */
    private function runLightProcessing($service)
    {
        $this->info('⚡ Running lightweight recalculation (valid promotions only)...');

        if (!$this->option('force')) {
            if (!$this->confirm('This will process only time-valid promotions. Continue?')) {
                $this->info('Operation cancelled.');
                return Command::SUCCESS;
            }
        }

        $service->recalculateValidPromotionsOnly();

        $this->info('✅ Lightweight recalculation dispatched!');

        return Command::SUCCESS;
    }

    /**
     * Run full processing
     */
    private function runFullProcessing($service)
    {
        $this->info('🔄 Starting full promotion discount recalculation...');

        if (!$this->option('force')) {
            if (!$this->confirm('This will reset all product price discounts and recalculate based on active promotions. Continue?')) {
                $this->info('Operation cancelled.');
                return Command::SUCCESS;
            }
        }

        // Get options
        $options = [
            'batch_size' => (int) $this->option('batch-size'),
            'use_queue' => !$this->option('sync'),
            'validate_time' => true
        ];

        try {
            $service->recalculateAllDiscounts($options);
            $this->info('✅ Promotion discount recalculation initiated successfully!');
        } catch (\Exception $e) {
            $this->error('❌ Failed to recalculate promotion discounts: ' . $e->getMessage());
            return Command::FAILURE;
        }

        return Command::SUCCESS;
    }
}
