<?php

namespace Database\Seeders;

use App\Models\Branch\Branch;
use App\Models\Company\Company;
use App\Models\Product\Product;
use App\Models\Product\ProductFactory;
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
 * ProductNewAugustSeeder - Comprehensive seeder for Product ecosystem
 *
 * This seeder will:
 * 1. Read data from CSV file product_new_august.csv
 * 2. UpdateOrCreate ProductFactory based on Principle field
 * 3. For existing products (by sku_number or name): Update Product, ProductStock, ProductPrice
 * 4. For non-existing products: Create new Product with complete ecosystem
 * 5. Handle all relationships properly with validation
 *
 * Usage:
 * php artisan db:seed --class=ProductNewAugustSeeder
 */
class ProductNewAugustSeeder extends Seeder
{
    use WithoutModelEvents;

    private const BATCH_SIZE = 50;

    // Cache untuk data yang sering digunakan
    private $company;

    private $branch;

    private $productTypes = [];

    private $units = [];

    private $existingProducts = [];

    private $productFactories = [];

    // Tracking counters
    private $counters = [
        'products_created' => 0,
        'products_updated' => 0,
        'factories_created' => 0,
        'factories_updated' => 0,
        'stock_operations' => 0,
        'price_operations' => 0,
    ];

    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $this->command->info('=== ProductNewAugustSeeder - Comprehensive Product Management ===');

        // Initialize cache first to get valid company
        $this->initializeCache();

        // Count products before processing
        $initialProductCount = Product::where('company_id', $this->company->id)->count();
        $initialFactoryCount = ProductFactory::where('company_id', $this->company->id)->count();
        $this->command->info("📊 Initial counts - Products: {$initialProductCount}, Factories: {$initialFactoryCount}");

        // Parse CSV file
        $productCsvPath = __DIR__.'/csvs/product_new_august.csv';
        if (! file_exists($productCsvPath)) {
            $this->command->error('CSV file not found: '.$productCsvPath);

            return;
        }

        $productData = $this->parseCSV($productCsvPath);
        $totalProducts = count($productData);
        $this->command->info("Processing {$totalProducts} products...");

        // Process in batches
        $batches = array_chunk($productData, self::BATCH_SIZE);

        foreach ($batches as $batchIndex => $batch) {
            $this->processBatch($batch, $batchIndex + 1, count($batches));
        }

        // Count products after processing
        $finalProductCount = Product::where('company_id', $this->company->id)->count();
        $finalFactoryCount = ProductFactory::where('company_id', $this->company->id)->count();
        $productDifference = $finalProductCount - $initialProductCount;
        $factoryDifference = $finalFactoryCount - $initialFactoryCount;

        $this->displayResults($initialProductCount, $finalProductCount, $initialFactoryCount, $finalFactoryCount);
    }

    /**
     * Display comprehensive results
     */
    private function displayResults($initialProductCount, $finalProductCount, $initialFactoryCount, $finalFactoryCount)
    {
        $this->command->info('=== Processing Complete ===');
        $this->command->info("📦 Products Created: {$this->counters['products_created']}");
        $this->command->info("🔄 Products Updated: {$this->counters['products_updated']}");
        $this->command->info("🏭 Factories Created: {$this->counters['factories_created']}");
        $this->command->info("🔧 Factories Updated: {$this->counters['factories_updated']}");
        $this->command->info("📊 Stock Operations: {$this->counters['stock_operations']}");
        $this->command->info("💰 Price Operations: {$this->counters['price_operations']}");
        $this->command->info("📈 Product count: {$initialProductCount} → {$finalProductCount} (Δ ".($finalProductCount - $initialProductCount).')');
        $this->command->info("🏭 Factory count: {$initialFactoryCount} → {$finalFactoryCount} (Δ ".($finalFactoryCount - $initialFactoryCount).')');
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
        $this->command->info('📋 Available product types: '.implode(', ', array_keys($this->productTypes)));

        // Cache units
        Unit::all()->each(function ($unit) {
            $this->units[strtolower($unit->name)] = $unit;
        });
        $this->command->info('📏 Available units: '.implode(', ', array_keys($this->units)));

        // Cache existing products with SKU as primary key, name as secondary
        $products = Product::with(['productStock', 'productPrice', 'productFactory'])->get();
        $productCount = $products->count();

        $products->each(function ($product) {
            // SKU is always reliable - primary cache key
            if ($product->sku_number) {
                $this->existingProducts[trim($product->sku_number)] = $product;
            }

            // Name as secondary key ONLY if no SKU conflicts
            // This prevents overwriting when multiple products have same name
            if ($product->name) {
                $nameKey = trim($product->name);
                // Only cache by name if no existing product with this name, or if this product has no SKU
                if (! isset($this->existingProducts[$nameKey]) || empty($product->sku_number)) {
                    $this->existingProducts[$nameKey] = $product;
                }
            }
        });

        // Cache existing product factories
        ProductFactory::where('company_id', $this->company->id)->get()->each(function ($factory) {
            $this->productFactories[strtolower(trim($factory->name))] = $factory;
        });

        $cacheReferences = count($this->existingProducts);
        $factoryCount = count($this->productFactories);
        $this->command->info("📦 Cache initialized - Products: {$productCount} ({$cacheReferences} refs), Factories: {$factoryCount}");
    }

    /**
     * Process a batch of products
     */
    private function processBatch($batch, $batchNumber, $totalBatches)
    {
        $batchResults = [
            'created' => 0,
            'updated' => 0,
            'stock_ops' => 0,
            'price_ops' => 0,
        ];

        foreach ($batch as $row) {
            $result = $this->processProduct($row);
            if ($result['action'] === 'created') {
                $batchResults['created']++;
                $this->counters['products_created']++;
            } elseif ($result['action'] === 'updated') {
                $batchResults['updated']++;
                $this->counters['products_updated']++;
            }

            $batchResults['stock_ops'] += $result['stock_operation'] ? 1 : 0;
            $batchResults['price_ops'] += $result['price_operation'] ? 1 : 0;
        }

        $this->counters['stock_operations'] += $batchResults['stock_ops'];
        $this->counters['price_operations'] += $batchResults['price_ops'];

        $this->command->info("📋 Batch {$batchNumber}/{$totalBatches} - Created: {$batchResults['created']}, Updated: {$batchResults['updated']}, Stock: {$batchResults['stock_ops']}, Price: {$batchResults['price_ops']}");

        return $batchResults;
    }

    /**
     * Process single product with comprehensive ecosystem handling
     */
    private function processProduct($row)
    {
        $skuNumber = trim($row['sku number'] ?? '');
        $name = trim($row['name'] ?? '');
        $principle = trim($row['Principle'] ?? '');

        if (empty($name)) {
            $this->command->error('❌ Empty product name, skipping row');

            return ['action' => 'skipped', 'stock_operation' => false, 'price_operation' => false];
        }

        DB::beginTransaction();

        try {
            // 1. Handle ProductFactory first (updateOrCreate based on Principle)
            $productFactory = $this->handleProductFactory($principle);

            // 2. Find or determine if we need to create/update product
            $existingProduct = $this->findExistingProduct($skuNumber, $name);

            // 3. Process product (create or update)
            if ($existingProduct) {
                $product = $this->updateExistingProduct($existingProduct, $row, $productFactory);
                $action = 'updated';
                $this->command->line("  🔄 Updated: {$name} (SKU: {$skuNumber})");
            } else {
                $product = $this->createNewProduct($row, $productFactory);
                $action = 'created';
                $this->command->line("  ✨ Created: {$name} (SKU: {$skuNumber})");
            }

            // 4. Handle ProductStock
            $stockOperation = $this->handleProductStock($product, $row);

            // 5. Handle ProductPrice
            $priceOperation = $this->handleProductPrice($product, $row);

            DB::commit();

            return [
                'action' => $action,
                'stock_operation' => $stockOperation,
                'price_operation' => $priceOperation,
            ];
        } catch (Exception $e) {
            DB::rollback();
            $this->command->error("❌ Error processing product {$name} (SKU: {$skuNumber}): ".$e->getMessage());

            return ['action' => 'error', 'stock_operation' => false, 'price_operation' => false];
        }
    }

    /**
     * Handle ProductFactory (updateOrCreate based on Principle)
     */
    private function handleProductFactory($principle)
    {
        if (empty($principle)) {
            return null;
        }

        $principleKey = strtolower(trim($principle));

        // Check cache first
        if (isset($this->productFactories[$principleKey])) {
            return $this->productFactories[$principleKey];
        }

        // UpdateOrCreate ProductFactory
        $productFactory = ProductFactory::updateOrCreate(
            [
                'name' => $principle,
                'company_id' => $this->company->id,
            ],
            [
                'description' => "Factory for {$principle}",
                'updated_at' => Carbon::now(),
            ]
        );

        // Determine if it was created or updated
        if ($productFactory->wasRecentlyCreated) {
            $this->counters['factories_created']++;
            $this->command->line("  🏭 Created factory: {$principle}");
        } else {
            $this->counters['factories_updated']++;
            $this->command->line("  🔧 Updated factory: {$principle}");
        }

        // Update cache
        $this->productFactories[$principleKey] = $productFactory;

        return $productFactory;
    }

    /**
     * Find existing product by SKU or name
     */
    private function findExistingProduct($skuNumber, $name)
    {
        // PRIORITY 1: Try finding by SKU first (most reliable)
        if ($skuNumber && isset($this->existingProducts[$skuNumber])) {
            return $this->existingProducts[$skuNumber];
        }

        // PRIORITY 2: Direct database lookup by SKU to ensure accuracy
        if ($skuNumber) {
            $productBySku = Product::where('sku_number', $skuNumber)->first();
            if ($productBySku) {
                // Update cache and return
                $this->existingProducts[$skuNumber] = $productBySku;

                return $productBySku;
            }
        }

        // PRIORITY 3: Only use name lookup if SKU is empty AND we want to update existing by name
        // This prevents conflict when multiple products have same name but different SKUs
        if (empty($skuNumber) && $name && isset($this->existingProducts[$name])) {
            return $this->existingProducts[$name];
        }

        // RESULT: Return null = CREATE NEW PRODUCT
        // This ensures products with same name but different SKUs are created separately
        return null;
    }

    /**
     * Update existing product
     */
    private function updateExistingProduct($existingProduct, $row, $productFactory)
    {
        $skuNumber = trim($row['sku number'] ?? '');
        $name = trim($row['name'] ?? '');

        // Parse product type from CSV 'tipe produk' field
        $productTypeId = $this->getProductTypeId($row['tipe produk'] ?? '');

        // If no product type found from CSV, keep existing one
        if (! $productTypeId) {
            $productTypeId = $existingProduct->product_type_id;
        }

        // Update data
        $updateData = [
            'product_type_id' => $productTypeId,
            'is_non_stock' => false, // Set semua produk sebagai non-stock
            'updated_at' => Carbon::now(),
        ];

        // Update name if provided and not empty
        if (! empty($name)) {
            $updateData['name'] = $name;
        }

        // Update sku_number if provided and not empty
        if (! empty($skuNumber)) {
            $updateData['sku_number'] = $skuNumber;
        }

        // Update factory relationship
        if ($productFactory) {
            $updateData['product_factory_id'] = $productFactory->id;
        }

        $existingProduct->update($updateData);

        return $existingProduct;
    }

    /**
     * Create new product with complete ecosystem
     */
    private function createNewProduct($row, $productFactory)
    {
        $skuNumber = trim($row['sku number'] ?? '');
        $name = trim($row['name'] ?? '');

        // Parse product type from CSV 'tipe produk' field
        $productTypeId = $this->getProductTypeId($row['tipe produk'] ?? '');

        // Find default unit (PCS or first available)
        $unitId = null;
        $defaultUnit = $this->units['pcs'] ?? $this->units['pc'] ?? $this->units['piece'] ?? null;
        if ($defaultUnit) {
            $unitId = $defaultUnit->id;
        } else {
            // If no PCS/PC unit found, use first available unit
            $firstUnit = reset($this->units);
            if ($firstUnit) {
                $unitId = $firstUnit->id;
            }
        }

        // Create product data
        $productData = [
            'sku_number' => $skuNumber ?: null,
            'name' => $name,
            'description' => 'Product created from CSV import - '.($row['tipe produk'] ?? 'Unknown Type'),
            'product_type_id' => $productTypeId,
            'product_factory_id' => $productFactory ? $productFactory->id : null,
            'company_id' => $this->company->id,
            'unit_id' => $unitId,
            'is_non_stock' => false, // Set semua produk sebagai non-stock
            'minimun_stock' => 0, // Note: typo in database migration
            'safety_stock' => 0,
            'maximum_stock' => 1000,
        ];

        $product = Product::create($productData);

        // Update cache with new product - CRITICAL for handling subsequent similar names
        if ($skuNumber) {
            $this->existingProducts[$skuNumber] = $product;
        }
        // Only cache by name if no conflict risk
        if ($name && ! isset($this->existingProducts[$name])) {
            $this->existingProducts[$name] = $product;
        }

        return $product;
    }

    /**
     * Get product type ID from CSV field with smart matching
     */
    private function getProductTypeId($tipeProduktValue)
    {
        if (empty($tipeProduktValue)) {
            return null;
        }

        $tipeProduktValue = strtolower(trim($tipeProduktValue));

        // Direct match first
        if (isset($this->productTypes[$tipeProduktValue])) {
            return $this->productTypes[$tipeProduktValue]->id;
        }

        // Smart matching for common variations
        $mappings = [
            'obat' => ['obat', 'medicine', 'drug', 'medication'],
            'alkes' => ['alkes', 'alat kesehatan', 'medical device', 'device'],
            'suplemen' => ['suplemen', 'supplement', 'vitamin'],
            'kosmetik' => ['kosmetik', 'cosmetic', 'beauty'],
            'food' => ['food', 'makanan', 'nutrition'],
            'other' => ['other', 'lain', 'lainnya', 'others'],
        ];

        foreach ($mappings as $typeKey => $variations) {
            foreach ($variations as $variation) {
                if (strpos($tipeProduktValue, $variation) !== false) {
                    if (isset($this->productTypes[$typeKey])) {
                        return $this->productTypes[$typeKey]->id;
                    }
                }
            }
        }

        // If no match found, try to find the first product type that contains the search term
        foreach ($this->productTypes as $key => $productType) {
            if (strpos($key, $tipeProduktValue) !== false || strpos($tipeProduktValue, $key) !== false) {
                return $productType->id;
            }
        }

        return null;
    }

    /**
     * Handle ProductStock (create or update)
     */
    private function handleProductStock($product, $row)
    {
        if (! isset($row['quantity']) || $row['quantity'] === '') {
            return false;
        }

        $quantity = $this->parseNumeric($row['quantity']);

        // Find or create ProductStock
        $productStock = ProductStock::updateOrCreate(
            [
                'product_id' => $product->id,
                'branch_id' => $this->branch->id,
                'company_id' => $this->company->id,
            ],
            [
                'quantity' => $quantity,
                'quantity_real' => $quantity,
                'quantity_lock' => 0,
                'updated_at' => Carbon::now(),
            ]
        );

        if ($productStock->wasRecentlyCreated) {
            $this->command->line("    📦 Created stock: {$quantity}");
        } else {
            $this->command->line("    📦 Updated stock: {$quantity}");
        }

        return true;
    }

    /**
     * Handle ProductPrice (create or update)
     */
    private function handleProductPrice($product, $row)
    {
        $hasPrice = isset($row['hpp average']) || isset($row['selling price']);

        if (! $hasPrice) {
            return false;
        }

        $hppAverage = $this->parseNumeric($row['hpp average'] ?? '0');
        $sellingPrice = $this->parseNumeric($row['selling price'] ?? '0');

        // Find or create ProductPrice
        $productPrice = ProductPrice::updateOrCreate(
            [
                'product_id' => $product->id,
                'branch_id' => $this->branch->id,
                'company_id' => $this->company->id,
            ],
            [
                'hpp_average' => $hppAverage,
                'price' => $sellingPrice,
                'recipe' => $sellingPrice, // Recipe price same as selling price
                'is_updated' => true,
                'updated_at' => Carbon::now(),
            ]
        );

        if ($productPrice->wasRecentlyCreated) {
            $this->command->line("    💰 Created price: HPP={$hppAverage}, Price={$sellingPrice}");
        } else {
            $this->command->line("    💰 Updated price: HPP={$hppAverage}, Price={$sellingPrice}");
        }

        return true;
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
