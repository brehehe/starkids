<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Transaction\TransactionProduct;
use App\Models\Product\ProductPrice;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class UpdateTransactionProductHpp extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'update:transaction-product-hpp
                            {--transaction_id= : Specific transaction ID to update}
                            {--product_id= : Specific product ID to update}
                            {--company_id= : Specific company ID to update}
                            {--branch_id= : Specific branch ID to update}
                            {--start_date= : Start date (Y-m-d format)}
                            {--end_date= : End date (Y-m-d format)}
                            {--limit= : Limit number of records to process (default: 1000)}
                            {--dry-run : Show what would be updated without making changes}
                            {--force-zero : Also update records where hpp_average is currently 0}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Update hpp_average and hpp_total for TransactionProduct records';

    protected $processedCount = 0;
    protected $updatedCount = 0;
    protected $skippedCount = 0;
    protected $errorCount = 0;

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('Starting TransactionProduct HPP update...');

        $startTime = microtime(true);

        try {
            DB::beginTransaction();

            $this->updateTransactionProductHpp();

            if (!$this->option('dry-run')) {
                DB::commit();
                $this->info('Transaction committed successfully.');
            } else {
                DB::rollBack();
                $this->info('Dry run completed - no changes made to database.');
            }
        } catch (\Exception $e) {
            DB::rollBack();
            $this->error('Error occurred: ' . $e->getMessage());
            Log::error('TransactionProduct HPP update failed', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            return Command::FAILURE;
        }

        $endTime = microtime(true);
        $executionTime = round($endTime - $startTime, 2);

        $this->displaySummary($executionTime);

        return Command::SUCCESS;
    }

    /**
     * Update TransactionProduct HPP values
     */
    protected function updateTransactionProductHpp()
    {
        $this->info('Processing TransactionProduct records...');

        $query = TransactionProduct::with(['transaction'])
            ->whereNotNull('product_id')
            ->where('quantity', '>', 0);

        // Apply filters
        $this->applyFilters($query);

        // Get total count first
        $totalCount = $query->count();
        $this->info("Found {$totalCount} records to check");

        if ($totalCount === 0) {
            $this->warn('No records found matching the criteria.');
            return;
        }

        // Apply limit if specified
        $limit = $this->option('limit') ? (int)$this->option('limit') : 1000;
        if ($totalCount > $limit) {
            $this->warn("Processing only {$limit} records out of {$totalCount} total records.");
            $this->warn("Use --limit option to process more records.");
        }

        $records = $query->limit($limit)->get();

        $progressBar = $this->output->createProgressBar($records->count());
        $progressBar->start();

        foreach ($records as $transactionProduct) {
            try {
                $this->processTransactionProduct($transactionProduct);
                $progressBar->advance();
            } catch (\Exception $e) {
                $this->errorCount++;
                $this->error("\nError processing TransactionProduct ID {$transactionProduct->id}: " . $e->getMessage());
                Log::error('Error processing transaction product HPP', [
                    'transaction_product_id' => $transactionProduct->id,
                    'product_id' => $transactionProduct->product_id,
                    'error' => $e->getMessage()
                ]);
            }
        }

        $progressBar->finish();
        $this->line('');
    }

    /**
     * Process individual TransactionProduct
     */
    protected function processTransactionProduct(TransactionProduct $transactionProduct)
    {
        $this->processedCount++;

        $transaction = $transactionProduct->transaction;
        if (!$transaction) {
            $this->errorCount++;
            return;
        }

        // Skip if current hpp_average is not 0 and force-zero is not set
        if (!$this->option('force-zero') && $transactionProduct->hpp_average > 0) {
            $this->skippedCount++;
            return;
        }

        // Get current HPP price
        $newHppPrice = $this->getHppPrice(
            $transactionProduct->product_id,
            $transaction->company_id,
            $transaction->branch_id
        );

        $currentHppAverage = $transactionProduct->hpp_average;
        $currentHppTotal = $transactionProduct->hpp_total;

        // Calculate new hpp_total
        $newHppTotal = $newHppPrice * $transactionProduct->quantity;

        // Calculate new profit and margin
        $newProfit = ($transactionProduct->price - $newHppPrice) * $transactionProduct->quantity;
        $newMargin = $this->calculateMargin($newProfit, $transactionProduct->price, $transactionProduct->quantity);

        // Check if update is needed
        if ($currentHppAverage == $newHppPrice && $currentHppTotal == $newHppTotal) {
            $this->skippedCount++;
            return;
        }

        if ($this->option('dry-run')) {
            $this->line('');
            $this->info("Would update TransactionProduct ID: {$transactionProduct->id}");
            $this->line("  Product: {$transactionProduct->product_name}");
            $this->line("  HPP Average: {$currentHppAverage} → {$newHppPrice}");
            $this->line("  HPP Total: {$currentHppTotal} → {$newHppTotal}");
            $this->line("  Profit: {$transactionProduct->profit} → {$newProfit}");
            $this->line("  Margin: {$transactionProduct->margin}% → {$newMargin}%");
        } else {
            // Update the record
            $transactionProduct->update([
                'hpp_average' => $newHppPrice,
                'hpp_total' => $newHppTotal,
                'profit' => $newProfit,
                'margin' => $newMargin,
                'updated_at' => now()
            ]);
        }

        $this->updatedCount++;
    }

    /**
     * Get HPP Price for product
     */
    protected function getHppPrice($productId, $companyId, $branchId)
    {
        $productPrice = ProductPrice::where('product_id', $productId)
            ->where('company_id', $companyId)
            ->where('branch_id', $branchId)
            ->where('is_updated', true)
            ->orderBy('updated_at', 'desc')
            ->first();

        if (!$productPrice) {
            // Try without branch filter as fallback
            $productPrice = ProductPrice::where('product_id', $productId)
                ->where('company_id', $companyId)
                ->where('is_updated', true)
                ->orderBy('updated_at', 'desc')
                ->first();
        }

        if (!$productPrice) {
            return 0;
        }

        // Convert hpp_average to integer (remove dots/commas)
        $hppAverage = $productPrice->hpp_average;
        if (is_string($hppAverage)) {
            $hppAverage = (float) str_replace([',', '.'], ['', '.'], $hppAverage);
        }

        return (int) $hppAverage;
    }

    /**
     * Calculate margin with proper formatting
     */
    protected function calculateMargin($profit, $sellingPrice, $quantity)
    {
        if ($sellingPrice > 0 && $quantity > 0) {
            $totalRevenue = $sellingPrice * $quantity;
            $margin = ($profit / $totalRevenue) * 100;
        } else {
            $margin = 0;
        }

        // Limit margin to range -100 to 100, then round
        $margin = max(min($margin, 100), -100);
        return round($margin);
    }

    /**
     * Apply filters to query
     */
    protected function applyFilters($query)
    {
        if ($this->option('transaction_id')) {
            $query->where('transaction_id', $this->option('transaction_id'));
        }

        if ($this->option('product_id')) {
            $query->where('product_id', $this->option('product_id'));
        }

        if ($this->option('company_id')) {
            $query->where('company_id', $this->option('company_id'));
        }

        if ($this->option('branch_id')) {
            $query->whereHas('transaction', function ($q) {
                $q->where('branch_id', $this->option('branch_id'));
            });
        }

        if ($this->option('start_date') && $this->option('end_date')) {
            $startDate = $this->option('start_date') . ' 00:00:00';
            $endDate = $this->option('end_date') . ' 23:59:59';

            $query->whereBetween('created_at', [$startDate, $endDate]);
        }
    }

    /**
     * Display summary of operation
     */
    protected function displaySummary($executionTime)
    {
        $this->line('');
        $this->info('=== TRANSACTION PRODUCT HPP UPDATE SUMMARY ===');
        $this->line("Execution time: {$executionTime} seconds");
        $this->line("Processed records: {$this->processedCount}");
        $this->line("Updated records: {$this->updatedCount}");
        $this->line("Skipped records: {$this->skippedCount}");
        $this->line("Error records: {$this->errorCount}");

        if ($this->option('dry-run')) {
            $this->warn('This was a dry run - no changes were made to the database.');
        }

        $this->line('=== END SUMMARY ===');

        // Log summary
        Log::info('TransactionProduct HPP update completed', [
            'execution_time' => $executionTime,
            'processed' => $this->processedCount,
            'updated' => $this->updatedCount,
            'skipped' => $this->skippedCount,
            'errors' => $this->errorCount,
            'dry_run' => $this->option('dry-run'),
            'options' => [
                'transaction_id' => $this->option('transaction_id'),
                'product_id' => $this->option('product_id'),
                'company_id' => $this->option('company_id'),
                'branch_id' => $this->option('branch_id'),
                'start_date' => $this->option('start_date'),
                'end_date' => $this->option('end_date'),
                'limit' => $this->option('limit'),
                'force_zero' => $this->option('force-zero'),
            ]
        ]);
    }
}
