<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use App\Models\Product\ProductPrice;
use App\Models\Promotion\PromotionSimplified;
use App\Helpers\PromotionHelper;

class FixDiscountProductLogic extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'promotion:fix-discount-logic
                          {--dry-run : Show what would be fixed without actually fixing}
                          {--reset-all : Reset all discounts to original prices}
                          {--recalculate : Recalculate all active discount promotions}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Fix discount product logic to use correct price calculation';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $dryRun = $this->option('dry-run');
        $resetAll = $this->option('reset-all');
        $recalculate = $this->option('recalculate');

        $this->info('🔧 Fixing Discount Product Logic...');
        $this->newLine();

        if ($resetAll) {
            $this->handleResetAll($dryRun);
        } elseif ($recalculate) {
            $this->handleRecalculate($dryRun);
        } else {
            $this->handleFixLogic($dryRun);
        }

        $this->newLine();
        $this->info('✅ Command completed!');
    }

    /**
     * Fix the discount logic for existing data
     */
    private function handleFixLogic($dryRun)
    {
        $this->info('🔍 Analyzing existing product prices...');

        // Find products where price_discount might be using old logic (accumulation)
        $problematicPrices = ProductPrice::where('price_discount', '>', 0)
            ->where('price_discount', '<', 'price')
            ->get();

        if ($problematicPrices->isEmpty()) {
            $this->info('✅ No problematic data found. All prices seem to be using correct logic.');
            return;
        }

        $this->warn("Found {$problematicPrices->count()} product prices that might be using old logic:");

        $this->table(
            ['Product ID', 'Company ID', 'Original Price', 'Current price_discount', 'Possible Issue'],
            $problematicPrices->map(function ($price) {
                $discountAmount = $price->price - $price->price_discount;
                return [
                    substr($price->product_id, 0, 8) . '...',
                    substr($price->company_id, 0, 8) . '...',
                    'Rp ' . number_format($price->price, 0, ',', '.'),
                    'Rp ' . number_format($price->price_discount, 0, ',', '.'),
                    'Discount: Rp ' . number_format($discountAmount, 0, ',', '.')
                ];
            })->toArray()
        );

        if (!$dryRun) {
            if ($this->confirm('Do you want to reset these prices to original prices?')) {
                foreach ($problematicPrices as $price) {
                    $price->update(['price_discount' => $price->price]);
                }
                $this->info("✅ Reset {$problematicPrices->count()} product prices to original prices.");
            }
        } else {
            $this->info('🔍 DRY RUN: Would reset these prices to original prices.');
        }
    }

    /**
     * Reset all discounts to original prices
     */
    private function handleResetAll($dryRun)
    {
        $this->info('🔄 Resetting all product discounts to original prices...');

        $affectedCount = ProductPrice::where('price_discount', '!=', 'price')
            ->orWhereNull('price_discount')
            ->count();

        $this->info("Found {$affectedCount} products to reset.");

        if (!$dryRun) {
            if ($this->confirm('Are you sure you want to reset ALL product discounts?')) {
                ProductPrice::query()->update(['price_discount' => DB::raw('price')]);
                $this->info("✅ Reset all product discounts to original prices.");
            }
        } else {
            $this->info('🔍 DRY RUN: Would reset all product discounts to original prices.');
        }
    }

    /**
     * Recalculate all active discount promotions
     */
    private function handleRecalculate($dryRun)
    {
        $this->info('🔄 Recalculating active discount promotions...');

        $activePromotions = PromotionSimplified::where('type', 'discount_product')
            ->where('is_active', true)
            ->get();

        $this->info("Found {$activePromotions->count()} active discount promotions.");

        if ($activePromotions->isEmpty()) {
            $this->info('✅ No active discount promotions found.');
            return;
        }

        $this->table(
            ['Promotion ID', 'Code', 'Name', 'Products Count'],
            $activePromotions->map(function ($promotion) {
                $productsCount = is_array($promotion->discount_products)
                    ? count($promotion->discount_products)
                    : 0;
                return [
                    substr($promotion->id, 0, 8) . '...',
                    $promotion->code ?? 'N/A',
                    substr($promotion->name ?? 'N/A', 0, 30) . '...',
                    $productsCount
                ];
            })->toArray()
        );

        if (!$dryRun) {
            if ($this->confirm('Do you want to recalculate these promotions?')) {
                // First reset all to original prices
                ProductPrice::query()->update(['price_discount' => DB::raw('price')]);

                // Then apply active promotions
                foreach ($activePromotions as $promotion) {
                    $this->info("Processing promotion: {$promotion->code}");
                    PromotionHelper::processDiscountProductPromotion($promotion);
                }

                $this->info("✅ Recalculated {$activePromotions->count()} promotions.");
            }
        } else {
            $this->info('🔍 DRY RUN: Would recalculate all active promotions.');
        }
    }
}
