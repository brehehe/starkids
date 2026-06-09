<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Transaction\Transaction;
use App\Models\Transaction\TransactionDetail;
use App\Models\Transaction\TransactionRecipe;
use App\Models\Transaction\TransactionProduct;
use App\Models\Product\Product;
use App\Models\Product\ProductPrice;
use App\Models\Branch\Branch;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class GenerateTransactionProductReport extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'report:transaction-product
                            {--transaction_id= : Specific transaction ID to process}
                            {--company_id= : Specific company ID to process}
                            {--start_date= : Start date (Y-m-d format)}
                            {--end_date= : End date (Y-m-d format)}
                            {--force : Force recreate existing transaction products}
                            {--dry-run : Show what would be processed without creating records}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Generate TransactionProduct records from TransactionRecipe and TransactionDetail data';

    protected $processedCount = 0;
    protected $createdCount = 0;
    protected $skippedCount = 0;
    protected $errorCount = 0;

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('Starting TransactionProduct report generation...');

        $startTime = microtime(true);

        try {
            DB::beginTransaction();

            // Process TransactionRecipe data
            $this->processTransactionRecipes();

            // Process TransactionDetail data
            $this->processTransactionDetails();

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
            Log::error('TransactionProduct generation failed', [
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
     * Process TransactionRecipe data
     */
    protected function processTransactionRecipes()
    {
        $this->info('Processing TransactionRecipe data...');

        $query = TransactionRecipe::with(['transaction', 'product'])
            ->whereHas('transaction', function ($q) {
                $q->where('status', 'completed');
            })
            ->whereNotNull('product_id')
            ->where('quantity', '>', 0);

        $this->applyFilters($query, 'transaction');

        $recipes = $query->get();

        $this->info("Found {$recipes->count()} transaction recipes to process");

        $progressBar = $this->output->createProgressBar($recipes->count());
        $progressBar->start();

        foreach ($recipes as $recipe) {
            try {
                $this->processTransactionRecipe($recipe);
                $progressBar->advance();
            } catch (\Exception $e) {
                $this->errorCount++;
                $this->error("\nError processing recipe ID {$recipe->id}: " . $e->getMessage());
                Log::error('Error processing transaction recipe', [
                    'recipe_id' => $recipe->id,
                    'transaction_id' => $recipe->transaction_id,
                    'error' => $e->getMessage()
                ]);
            }
        }

        $progressBar->finish();
        $this->line('');
    }

    /**
     * Process TransactionDetail data
     */
    protected function processTransactionDetails()
    {
        $this->info('Processing TransactionDetail data...');

        $query = TransactionDetail::with(['transaction', 'product'])
            ->whereHas('transaction', function ($q) {
                $q->where('status', 'completed');
            })
            ->whereNotNull('product_id')
            ->where('quantity', '>', 0);

        $this->applyFilters($query, 'transaction');

        $details = $query->get();

        $this->info("Found {$details->count()} transaction details to process");

        $progressBar = $this->output->createProgressBar($details->count());
        $progressBar->start();

        foreach ($details as $detail) {
            try {
                $this->processTransactionDetail($detail);
                $progressBar->advance();
            } catch (\Exception $e) {
                $this->errorCount++;
                $this->error("\nError processing detail ID {$detail->id}: " . $e->getMessage());
                Log::error('Error processing transaction detail', [
                    'detail_id' => $detail->id,
                    'transaction_id' => $detail->transaction_id,
                    'error' => $e->getMessage()
                ]);
            }
        }

        $progressBar->finish();
        $this->line('');
    }

    /**
     * Process individual TransactionRecipe
     */
    protected function processTransactionRecipe(TransactionRecipe $recipe)
    {
        $this->processedCount++;

        // Check if TransactionProduct already exists
        $existingProduct = TransactionProduct::where('transaction_id', $recipe->transaction_id)
            ->where('transaction_recipe_id', $recipe->id)
            ->where('product_id', $recipe->product_id)
            ->first();

        if ($existingProduct && !$this->option('force')) {
            $this->skippedCount++;
            return;
        }

        if ($existingProduct && $this->option('force')) {
            if (!$this->option('dry-run')) {
                $existingProduct->delete();
            }
        }

        $transaction = $recipe->transaction;
        $product = $recipe->product;

        if (!$transaction || !$product) {
            $this->errorCount++;
            return;
        }

        // Get HPP Price
        $hppPrice = $this->getHppPrice($product->id, $transaction->company_id, $transaction->branch_id);

        // Calculate values
        $quantity = $recipe->quantity;
        $sellingPrice = $recipe->price;
        $subTotalPrice = $recipe->sub_total_price;

        $profit = ($sellingPrice - $hppPrice) * $quantity;
        $margin = $this->calculateMargin($profit, $sellingPrice, $quantity);

        $data = [
            'transaction_id' => $transaction->id,
            'user_id' => $transaction->patient_id,
            'user_name' => $transaction->patient_name ?? '',
            'transaction_recipe_id' => $recipe->id,
            'transaction_detail_id' => null,
            'product_id' => $product->id,
            'product_name' => $product->name,
            'quantity' => $quantity,
            'price' => $sellingPrice,
            'total' => $subTotalPrice,
            'hpp_average' => $hppPrice,
            'hpp_total' => $hppPrice * $quantity,
            'profit' => $profit,
            'margin' => $margin,
            'company_id' => $transaction->company_id,
            'order' => $recipe->order ?? 0,
            'created_at' => $recipe->created_at,
            'updated_at' => $recipe->updated_at,
        ];

        if (!$this->option('dry-run')) {
            TransactionProduct::create($data);
        }

        $this->createdCount++;
    }

    /**
     * Process individual TransactionDetail
     */
    protected function processTransactionDetail(TransactionDetail $detail)
    {
        $this->processedCount++;

        // Check if TransactionProduct already exists
        $existingProduct = TransactionProduct::where('transaction_id', $detail->transaction_id)
            ->where('transaction_detail_id', $detail->id)
            ->where('product_id', $detail->product_id)
            ->first();

        if ($existingProduct && !$this->option('force')) {
            $this->skippedCount++;
            return;
        }

        if ($existingProduct && $this->option('force')) {
            if (!$this->option('dry-run')) {
                $existingProduct->delete();
            }
        }

        $transaction = $detail->transaction;
        $product = $detail->product;

        if (!$transaction || !$product) {
            $this->errorCount++;
            return;
        }

        // Get HPP Price
        $hppPrice = $this->getHppPrice($product->id, $transaction->company_id, $transaction->branch_id);

        // Calculate values
        $quantity = $detail->quantity;
        $sellingPrice = $detail->price;
        $subTotalPrice = $detail->sub_total_price;

        $profit = ($sellingPrice - $hppPrice) * $quantity;
        $margin = $this->calculateMargin($profit, $sellingPrice, $quantity);

        $data = [
            'transaction_id' => $transaction->id,
            'user_id' => $transaction->patient_id,
            'user_name' => $transaction->patient_name ?? '',
            'transaction_recipe_id' => $detail->transaction_recipe_id,
            'transaction_detail_id' => $detail->id,
            'product_id' => $product->id,
            'product_name' => $product->name,
            'quantity' => $quantity,
            'price' => $sellingPrice,
            'total' => $subTotalPrice,
            'hpp_average' => $hppPrice,
            'hpp_total' => $hppPrice * $quantity,
            'profit' => $profit,
            'margin' => $margin,
            'company_id' => $transaction->company_id,
            'order' => $detail->order ?? 0,
            'created_at' => $detail->created_at,
            'updated_at' => $detail->updated_at,
        ];

        if (!$this->option('dry-run')) {
            TransactionProduct::create($data);
        }

        $this->createdCount++;
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
            ->first();

        if (!$productPrice) {
            return 0;
        }

        return intval(str_replace('.', '', number_format($productPrice->hpp_average, 0, ',', '.')));
    }

    /**
     * Calculate margin with proper formatting
     */
    protected function calculateMargin($profit, $sellingPrice, $quantity)
    {
        if ($sellingPrice > 0 && $quantity > 0) {
            $margin = ($profit / ($sellingPrice * $quantity)) * 100;
        } else {
            $margin = 0;
        }

        // Batasi margin ke rentang -100 s/d 100, lalu bulatkan
        $margin = max(min($margin, 100), -100);
        return round($margin);
    }

    /**
     * Apply filters to query
     */
    protected function applyFilters($query, $relationName = null)
    {
        if ($this->option('transaction_id')) {
            $query->where('transaction_id', $this->option('transaction_id'));
        }

        if ($this->option('company_id')) {
            if ($relationName) {
                $query->whereHas($relationName, function ($q) {
                    $q->where('company_id', $this->option('company_id'));
                });
            } else {
                $query->where('company_id', $this->option('company_id'));
            }
        }

        if ($this->option('start_date') && $this->option('end_date')) {
            $startDate = $this->option('start_date') . ' 00:00:00';
            $endDate = $this->option('end_date') . ' 23:59:59';

            if ($relationName) {
                $query->whereHas($relationName, function ($q) use ($startDate, $endDate) {
                    $q->whereBetween('created_at', [$startDate, $endDate]);
                });
            } else {
                $query->whereBetween('created_at', [$startDate, $endDate]);
            }
        }
    }

    /**
     * Display summary of operation
     */
    protected function displaySummary($executionTime)
    {
        $this->line('');
        $this->info('=== TRANSACTION PRODUCT GENERATION SUMMARY ===');
        $this->line("Execution time: {$executionTime} seconds");
        $this->line("Processed records: {$this->processedCount}");
        $this->line("Created records: {$this->createdCount}");
        $this->line("Skipped records: {$this->skippedCount}");
        $this->line("Error records: {$this->errorCount}");

        if ($this->option('dry-run')) {
            $this->warn('This was a dry run - no changes were made to the database.');
        }

        $this->line('=== END SUMMARY ===');

        // Log summary
        Log::info('TransactionProduct generation completed', [
            'execution_time' => $executionTime,
            'processed' => $this->processedCount,
            'created' => $this->createdCount,
            'skipped' => $this->skippedCount,
            'errors' => $this->errorCount,
            'dry_run' => $this->option('dry-run'),
            'options' => [
                'transaction_id' => $this->option('transaction_id'),
                'company_id' => $this->option('company_id'),
                'start_date' => $this->option('start_date'),
                'end_date' => $this->option('end_date'),
                'force' => $this->option('force'),
            ]
        ]);
    }
}
