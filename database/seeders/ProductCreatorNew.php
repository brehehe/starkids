<?php

namespace Database\Seeders;

use App\Models\Branch\Branch;
use App\Models\Company\Company;
use App\Models\Product\Product;
use App\Models\Product\ProductPrice;
use App\Models\Product\ProductStock;
use App\Models\Product\ProductType;
use App\Models\Unit\Unit;
use Carbon\Carbon;
use Exception;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

/**
 * ProductCreatorNew - Seeder untuk membuat produk baru yang belum ada
 *
 * Seeder ini akan:
 * 1. Membaca data dari CSV file product_new.csv
 * 2. Hanya membuat produk yang belum ada berdasarkan SKU number atau name
 * 3. Tidak mengupdate produk yang sudah ada
 * 4. Membuat ProductStock dan ProductPrice untuk produk baru
 *
 * Cara menjalankan:
 * php artisan db:seed --class=ProductCreatorNew
 */
class ProductCreatorNew extends Seeder
{
    use WithoutModelEvents;

    private const BATCH_SIZE = 50;

    // Cache untuk data yang sering digunakan
    private $company;

    private $branch;

    private $productTypes = [];

    private $units = [];

    private $existingProducts = [];

    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $this->command->info('=== ProductCreatorNew - Create Missing Products Only ===');

        // Initialize cache first to get valid company
        $this->initializeCache();

        // Count products before processing
        $initialProductCount = Product::where('company_id', $this->company->id)->count();
        $this->command->info("📊 Initial product count: {$initialProductCount}");

        // Parse CSV file
        $productCsvPath = __DIR__.'/csvs/product_new.csv';
        if (! file_exists($productCsvPath)) {
            $this->command->error('CSV file not found: '.$productCsvPath);

            return;
        }

        $productData = $this->parseCSV($productCsvPath);
        $totalProducts = count($productData);
        $this->command->info("Processing {$totalProducts} products for creation...");

        $createdCount = 0;
        $skippedCount = 0;

        // Process in batches
        $batches = array_chunk($productData, self::BATCH_SIZE);

        foreach ($batches as $batchIndex => $batch) {
            $result = $this->processBatch($batch, $batchIndex + 1, count($batches));
            $createdCount += $result['created'];
            $skippedCount += $result['skipped'];
        }

        // Count products after processing
        $finalProductCount = Product::where('company_id', $this->company->id)->count();
        $productDifference = $finalProductCount - $initialProductCount;

        $this->command->info('=== Product Creation Completed ===');
        $this->command->info("✅ Created: {$createdCount} new products");
        $this->command->info("⚠️  Skipped (already exists): {$skippedCount} products");
        $this->command->info("📊 Product count: {$initialProductCount} → {$finalProductCount} (Δ {$productDifference})");

        if ($productDifference === $createdCount) {
            $this->command->info("✅ GOOD: {$productDifference} new products were created as expected");
        } else {
            $this->command->warn("⚠️  WARNING: Expected {$createdCount} but got {$productDifference} new products");
        }
    }

    /**
     * Initialize cache for frequently used data
     */
    private function initializeCache()
    {
        // Find a company that has branches - more robust approach
        $companiesWithBranches = DB::table('companies')
            ->join('branches', 'companies.id', '=', 'branches.company_id')
            ->select('companies.id')
            ->distinct()
            ->get();

        if ($companiesWithBranches->isNotEmpty()) {
            $this->company = Company::find($companiesWithBranches->first()->id);
            $this->branch = Branch::where('company_id', $this->company->id)->first();
        } else {
            // Fallback: get any company and any branch
            $this->company = Company::first();
            $this->branch = Branch::first();

            if (! $this->company) {
                throw new Exception('No Company found. Please ensure you have basic data setup.');
            }

            if (! $this->branch) {
                throw new Exception('No Branch found. Please ensure you have basic data setup.');
            }

            $this->command->warn("⚠️  Using fallback: Company ID {$this->company->id} with any available Branch ID {$this->branch->id}");
        }

        $this->command->info("🏢 Using Company: {$this->company->id} | Branch: {$this->branch->id}");

        // Cache product types
        ProductType::all()->each(function ($type) {
            $this->productTypes[strtolower($type->name)] = $type;
        });

        // Cache units
        Unit::all()->each(function ($unit) {
            $this->units[strtolower($unit->name)] = $unit;
        });

        // Cache existing products with both sku_number and name as keys
        $products = Product::where('company_id', $this->company->id)->get();
        $productCount = $products->count();

        $products->each(function ($product) {
            if ($product->sku_number) {
                $this->existingProducts[trim($product->sku_number)] = $product;
            }
            if ($product->name) {
                $this->existingProducts[trim($product->name)] = $product;
            }
        });

        $cacheReferences = count($this->existingProducts);
        $this->command->info("📦 Cache initialized - Found {$productCount} products, {$cacheReferences} cache references");
    }

    /**
     * Process a batch of products for creation only
     */
    private function processBatch($batch, $batchNumber, $totalBatches)
    {
        $createdCount = 0;
        $skippedCount = 0;

        foreach ($batch as $row) {
            $result = $this->processProduct($row);
            if ($result['status'] === 'created') {
                $createdCount++;
            } else {
                $skippedCount++;
            }
        }

        $this->command->info("📋 Batch {$batchNumber}/{$totalBatches} - Created: {$createdCount}, Skipped: {$skippedCount}");

        return [
            'created' => $createdCount,
            'skipped' => $skippedCount,
        ];
    }

    /**
     * Process single product - only create if doesn't exist
     */
    private function processProduct($row)
    {
        $skuNumber = trim($row['sku_number'] ?? '');
        $name = trim($row['name'] ?? '');

        // Check if product already exists
        $existingProduct = null;

        if ($skuNumber && isset($this->existingProducts[$skuNumber])) {
            $existingProduct = $this->existingProducts[$skuNumber];
        } elseif ($name && isset($this->existingProducts[$name])) {
            $existingProduct = $this->existingProducts[$name];
        }

        // Skip if product already exists
        if ($existingProduct) {
            $this->command->line("  ⚠️  Product already exists: {$name} (SKU: {$skuNumber}) - SKIPPING");

            return ['status' => 'skipped'];
        }

        // Validate required fields
        if (empty($name)) {
            $this->command->line('  ❌ Missing product name - SKIPPING');

            return ['status' => 'skipped'];
        }

        DB::beginTransaction();

        try {
            // Parse numeric values from CSV
            $quantity = $this->parseNumeric($row['quantity'] ?? '0');
            $hppAverage = $this->parseNumeric($row['hpp_average'] ?? '0');
            $sellingPrice = $this->parseNumeric($row['selling_price'] ?? '0');

            // Find or create product type
            $productTypeId = null;
            if (! empty($row['tipe_produk'])) {
                $productTypeName = strtolower(trim($row['tipe_produk']));
                if (isset($this->productTypes[$productTypeName])) {
                    $productTypeId = $this->productTypes[$productTypeName]->id;
                } else {
                    // Get first available product type as default
                    $productTypeId = ProductType::first()->id ?? null;
                }
            }

            // Create new product
            $product = Product::create([
                'company_id' => $this->company->id,
                'name' => $name,
                'sku_number' => $skuNumber ?: null,
                'product_type_id' => $productTypeId,
                'description' => 'Imported from CSV',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ]);

            $this->command->line("  ✅ Created product: {$name} (ID: {$product->id})");

            // Create ProductStock
            if ($quantity >= 0) {
                ProductStock::create([
                    'product_id' => $product->id,
                    'branch_id' => $this->branch->id,
                    'company_id' => $this->company->id,
                    'quantity' => $quantity,
                    'quantity_real' => $quantity,
                    'quantity_lock' => 0,
                    'created_at' => Carbon::now(),
                    'updated_at' => Carbon::now(),
                ]);
                $this->command->line("    📦 Created stock: {$quantity}");
            }

            // Create ProductPrice
            if ($hppAverage > 0 || $sellingPrice > 0) {
                $priceData = [
                    'product_id' => $product->id,
                    'branch_id' => $this->branch->id,
                    'company_id' => $this->company->id,
                    'is_updated' => true,
                    'created_at' => Carbon::now(),
                    'updated_at' => Carbon::now(),
                ];

                if ($hppAverage > 0) {
                    $priceData['hpp_average'] = $hppAverage;
                }
                if ($sellingPrice > 0) {
                    $priceData['price'] = $sellingPrice;
                    $priceData['recipe'] = $sellingPrice;
                }

                ProductPrice::create($priceData);
                $this->command->line("    💰 Created price: HPP={$hppAverage}, Price={$sellingPrice}");
            }

            // Add to cache to prevent duplicates in same run
            if ($skuNumber) {
                $this->existingProducts[$skuNumber] = $product;
            }
            $this->existingProducts[$name] = $product;

            DB::commit();

            return ['status' => 'created'];
        } catch (Exception $e) {
            DB::rollback();
            $this->command->error("❌ Error creating product {$name} (SKU: {$skuNumber}): ".$e->getMessage());

            return ['status' => 'skipped'];
        }
    }

    /**
     * Parse numeric values from CSV (handle comma as decimal separator)
     */
    private function parseNumeric($value)
    {
        if (empty($value)) {
            return 0;
        }

        // Remove any spaces and handle comma as decimal separator
        $value = str_replace(' ', '', $value);
        $value = str_replace(',', '.', $value);

        return (float) $value;
    }

    /**
     * Parse CSV file efficiently
     */
    private function parseCSV($filePath)
    {
        $handle = fopen($filePath, 'r');
        if (! $handle) {
            throw new Exception("Cannot open CSV file: {$filePath}");
        }

        $header = fgetcsv($handle);
        $data = [];

        while (($row = fgetcsv($handle)) !== false) {
            if (count($row) === count($header)) {
                $data[] = array_combine($header, $row);
            }
        }

        fclose($handle);

        return $data;
    }
}
