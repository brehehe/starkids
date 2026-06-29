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
 * ProductSeederNew - Seeder untuk update produk yang sudah ada
 *
 * Seeder ini akan:
 * 1. Membaca data dari CSV file product_new.csv
 * 2. Hanya mengupdate produk yang sudah ada berdasarkan SKU number atau name
 * 3. Tidak membuat produk baru
 * 4. Update ProductStock jika quantity > 0
 * 5. Update ProductPrice jika hpp_average atau selling_price > 0
 *
 * Cara menjalankan:
 * php artisan db:seed --class=ProductSeederNew
 */
class ProductSeederNew extends Seeder
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
        $this->command->info('=== ProductSeederNew - Update Existing Products Only ===');

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
        $this->command->info("Processing {$totalProducts} products for updates...");

        $updatedCount = 0;
        $skippedCount = 0;
        $totalStockUpdates = 0;
        $totalPriceUpdates = 0;

        // Process in batches
        $batches = array_chunk($productData, self::BATCH_SIZE);

        foreach ($batches as $batchIndex => $batch) {
            $result = $this->processBatch($batch, $batchIndex + 1, count($batches));
            $updatedCount += $result['updated'];
            $skippedCount += $result['skipped'];
            $totalStockUpdates += $result['stock_updates'];
            $totalPriceUpdates += $result['price_updates'];
        }

        // Count products after processing
        $finalProductCount = Product::where('company_id', $this->company->id)->count();
        $productDifference = $finalProductCount - $initialProductCount;

        $this->command->info('=== Product Update Completed ===');
        $this->command->info("✅ Updated: {$updatedCount} products");
        $this->command->info("📦 Stock Updates: {$totalStockUpdates} products");
        $this->command->info("💰 Price Updates: {$totalPriceUpdates} products");
        $this->command->info("⚠️  Skipped (not found): {$skippedCount} products");
        $this->command->info("📊 Product count: {$initialProductCount} → {$finalProductCount} (Δ {$productDifference})");

        if ($productDifference > 0) {
            $this->command->error("🚨 WARNING: {$productDifference} new products were created! This should NOT happen!");
            $this->command->error('🚨 This seeder should only update existing products, never create new ones.');
        } else {
            $this->command->info('✅ GOOD: No new products were created (as expected)');
        }

        if ($skippedCount > 0) {
            $this->command->warn("Note: {$skippedCount} products were skipped because they don't exist in the database.");
            $this->command->warn("This seeder only updates existing products, it doesn't create new ones.");
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
        $products = Product::with(['productStock', 'productPrice'])->get();
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
     * Process a batch of products for updates only
     */
    private function processBatch($batch, $batchNumber, $totalBatches)
    {
        $updatedCount = 0;
        $skippedCount = 0;
        $stockUpdates = 0;
        $priceUpdates = 0;

        foreach ($batch as $row) {
            $result = $this->processProduct($row);
            if ($result['status'] === 'updated') {
                $updatedCount++;
                $stockUpdates += $result['stock_updated'] ? 1 : 0;
                $priceUpdates += $result['price_updated'] ? 1 : 0;
            } else {
                $skippedCount++;
            }
        }

        $this->command->info("📋 Batch {$batchNumber}/{$totalBatches} - Products: {$updatedCount} updated, {$skippedCount} skipped | Stock: {$stockUpdates} | Price: {$priceUpdates}");

        return [
            'updated' => $updatedCount,
            'skipped' => $skippedCount,
            'stock_updates' => $stockUpdates,
            'price_updates' => $priceUpdates,
        ];
    }

    /**
     * Process single product - only update if exists
     */
    private function processProduct($row)
    {
        $skuNumber = trim($row['sku number'] ?? ''); // Fixed: use 'sku number' with space
        $name = trim($row['name'] ?? '');

        // Find existing product by SKU number or name
        $existingProduct = null;

        if ($skuNumber && isset($this->existingProducts[$skuNumber])) {
            $existingProduct = $this->existingProducts[$skuNumber];
            $this->command->line("  🔍 Found by SKU: {$skuNumber}");
        } elseif ($name && isset($this->existingProducts[$name])) {
            $existingProduct = $this->existingProducts[$name];
            $this->command->line("  🔍 Found by Name: {$name}");
        }

        // Skip if product doesn't exist - CRITICAL: DO NOT CREATE NEW PRODUCTS
        if (! $existingProduct) {
            $this->command->line("  ❌ Product not found: SKU='{$skuNumber}', Name='{$name}' - SKIPPING");

            return [
                'status' => 'skipped',
                'stock_updated' => false,
                'price_updated' => false,
            ];
        }

        // SAFETY CHECK: Ensure we have a valid existing product with ID
        if (! $existingProduct->id) {
            $this->command->error("  ⚠️  Invalid product found - no ID: {$name}");

            return [
                'status' => 'skipped',
                'stock_updated' => false,
                'price_updated' => false,
            ];
        }

        DB::beginTransaction();

        try {
            // Parse numeric values from CSV
            $quantity = $this->parseNumeric($row['quantity'] ?? '0');
            $hppAverage = $this->parseNumeric($row['hpp average'] ?? '0'); // Fixed: use 'hpp average' with space
            $sellingPrice = $this->parseNumeric($row['selling price'] ?? '0'); // Fixed: use 'selling price' with space

            $stockUpdated = false;
            $priceUpdated = false;

            // Find product type
            $productTypeId = $existingProduct->product_type_id;
            if (! empty($row['tipe produk'])) { // Fixed: use 'tipe produk' with space
                $productTypeName = strtolower(trim($row['tipe produk']));
                if (isset($this->productTypes[$productTypeName])) {
                    $productTypeId = $this->productTypes[$productTypeName]->id;
                }
            }

            // Find unit if provided
            $unitId = $existingProduct->unit_id;
            if (! empty($row['unit'])) {
                $unitName = strtolower(trim($row['unit']));
                if (isset($this->units[$unitName])) {
                    $unitId = $this->units[$unitName]->id;
                }
            }

            // Update product basic info - ONLY UPDATE, NEVER CREATE
            // Always update sku_number and name if provided in CSV
            $updateData = [
                'product_type_id' => $productTypeId,
                'updated_at' => Carbon::now(),
            ];

            // Update name if provided and not empty
            if (! empty($name)) {
                $updateData['name'] = $name;
            }

            // Update sku_number if provided and not empty
            if (! empty($skuNumber)) {
                $updateData['sku_number'] = $skuNumber;
                $this->command->line("  🏷️  Updated SKU: {$skuNumber}");
            }

            // Update unit_id if found
            if ($unitId && $unitId !== $existingProduct->unit_id) {
                $updateData['unit_id'] = $unitId;
                $this->command->line("  📏 Updated Unit: {$unitId}");
            }

            $existingProduct->update($updateData);

            // Update or create ProductStock - Only for existing products
            // Update quantity if provided in CSV (allow 0 values)
            if (isset($row['quantity']) && $row['quantity'] !== '') {
                $productStock = $existingProduct->productStock;
                if ($productStock) {
                    $productStock->update([
                        'quantity' => $quantity,
                        'quantity_real' => $quantity, // Set real quantity same as quantity
                        'updated_at' => Carbon::now(),
                    ]);
                    $this->command->line("  📦 Updated stock: {$quantity}");
                } else {
                    // Create ProductStock for existing product that doesn't have one
                    ProductStock::create([
                        'product_id' => $existingProduct->id,
                        'branch_id' => $this->branch->id,
                        'company_id' => $this->company->id,
                        'quantity' => $quantity,
                        'quantity_real' => $quantity,
                        'quantity_lock' => 0,
                    ]);
                    $this->command->line("  📦 Created new stock: {$quantity}");
                }
                $stockUpdated = true;
            }

            // Update or create ProductPrice - Only for existing products
            // Update price if either hpp_average or selling_price is provided (allow 0 values)
            if (isset($row['hpp average']) || isset($row['selling price'])) {
                $productPrice = $existingProduct->productPrice;

                $priceData = [];

                // Always update hpp_average if provided in CSV
                if (isset($row['hpp average']) && $row['hpp average'] !== '') {
                    $priceData['hpp_average'] = $hppAverage;
                }

                // Always update selling price if provided in CSV
                if (isset($row['selling price']) && $row['selling price'] !== '') {
                    $priceData['price'] = $sellingPrice;
                    $priceData['recipe'] = $sellingPrice; // Recipe price same as selling price
                }

                if (! empty($priceData)) {
                    $priceData['is_updated'] = true;
                    $priceData['updated_at'] = Carbon::now();

                    if ($productPrice) {
                        $productPrice->update($priceData);
                        $this->command->line("  💰 Updated price: HPP={$hppAverage}, Price={$sellingPrice}");
                    } else {
                        // Create ProductPrice for existing product that doesn't have one
                        ProductPrice::create(array_merge($priceData, [
                            'product_id' => $existingProduct->id,
                            'branch_id' => $this->branch->id,
                            'company_id' => $this->company->id,
                        ]));
                        $this->command->line("  💰 Created new price: HPP={$hppAverage}, Price={$sellingPrice}");
                    }
                    $priceUpdated = true;
                }
            }

            DB::commit();

            return [
                'status' => 'updated',
                'stock_updated' => $stockUpdated,
                'price_updated' => $priceUpdated,
            ];
        } catch (Exception $e) {
            DB::rollback();
            $this->command->error("❌ Error updating product {$name} (SKU: {$skuNumber}): ".$e->getMessage());

            return [
                'status' => 'skipped',
                'stock_updated' => false,
                'price_updated' => false,
            ];
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
