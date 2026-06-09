<?php

namespace Database\Seeders;

use App\Models\Branch\Branch;
use App\Models\Company\Company;
use App\Models\Product\Product;
use App\Models\Product\ProductExpiredDate;
use App\Models\Product\ProductImportStock;
use App\Models\Product\ProductPrice;
use App\Models\Product\ProductPriceHistory;
use App\Models\Product\ProductStock;
use App\Models\Product\ProductStockHistory;
use App\Models\Product\ProductType;
use App\Models\Unit\Unit;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Exception;

class ProductSeeder extends Seeder
{
    private const BATCH_SIZE = 50;

    // Cache untuk data yang sering digunakan
    private $company;
    private $branch;
    private $productTypes = [];
    private $units = [];
    private $users = [];
    private $existingProducts = [];

    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $this->command->info('Starting optimized product seeding...');

        // Initialize cache
        $this->initializeCache();

        // Disable foreign key constraints for PostgreSQL

        // Parse CSV file
        $productCsvPath = __DIR__ . '/csvs/product.csv';
        if (!file_exists($productCsvPath)) {
            $this->command->error('CSV file not found: ' . $productCsvPath);
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

        $this->command->info('Product seeding completed successfully!');
    }

    /**
     * Initialize cache for frequently used data
     */
    private function initializeCache()
    {
        $this->company = Company::first();
        $this->branch = Branch::where('company_id', $this->company->id)->first();

        // Cache product types
        ProductType::all()->each(function ($type) {
            $this->productTypes[$type->name] = $type;
        });

        // Cache units
        Unit::all()->each(function ($unit) {
            $this->units[$unit->name] = $unit;
        });

        // Cache users
        $this->users = User::where('company_id', $this->company->id)->pluck('id')->toArray();

        // Cache existing products
        Product::all(['id', 'sku_number', 'name'])->each(function ($product) {
            $this->existingProducts[$product->sku_number] = $product;
            $this->existingProducts[$product->name] = $product;
        });

        $this->command->info('Cache initialized successfully');
    }

    /**
     * Process a batch of products
     */
    private function processBatch($batch, $batchNumber, $totalBatches)
    {
        $products = [];
        $importStocks = [];
        $stocks = [];
        $expiredDates = [];
        $stockHistories = [];
        $prices = [];
        $priceHistories = [];

        $today = date('ymd');
        $defaultExpiredDate = Carbon::now()->addYears(2)->format('Y-m-d');
        $defaultUnit = $this->units['Pcs'] ?? null;
        $defaultProductType = $this->productTypes['Obat'] ?? null;
        $defaultUser = $this->users[0] ?? null;

        foreach ($batch as $row) {
            // Skip if product already exists
            if (
                isset($this->existingProducts[$row['sku_number']]) ||
                isset($this->existingProducts[$row['name']])
            ) {
                continue;
            }

            $productId = Str::uuid();
            $quantity = $row['quantity'] ? intval(str_replace(['.', ','], '', $row['quantity'])) : 0;
            $hpp_average = $row['hpp_average'] ? intval((float)str_replace(',', '.', $row['hpp_average'])) : 0;
            $selling_price = $row['selling_price'] ? intval((float)str_replace(',', '.', $row['selling_price'])) : 0;
            $normal = (float)($row['margin'] ?? 0);
            $selling_price = $selling_price ? $selling_price : ($hpp_average + ($hpp_average * $normal / 100));

            $productTypeId = isset($row['tipe_produk']) && isset($this->productTypes[$row['tipe_produk']])
                ? $this->productTypes[$row['tipe_produk']]->id
                : $defaultProductType->id;

            // Create product data
            $products[] = [
                'id' => $productId,
                'sku_number' => $row['sku_number'],
                'product_type_id' => $productTypeId,
                'name' => $row['name'],
                'company_id' => $this->company->id,
                'registration_path' => 'import',
                'unit_id' => $defaultUnit->id,
                'normal' => $normal,
                'is_narcotics' => false,
                'created_at' => now(),
                'updated_at' => now(),
            ];

            // Add to cache
            $this->existingProducts[$row['sku_number']] = (object)['id' => $productId];
            $this->existingProducts[$row['name']] = (object)['id' => $productId];

            if ($quantity > 0 && $hpp_average > 0) {
                $batchNumber = 'BATCH-' . $row['sku_number'];
                $importStockId = Str::uuid();
                $stockId = Str::uuid();
                $expiredDateId = Str::uuid();
                $historyId = Str::uuid();
                $priceId = Str::uuid();
                $priceHistoryId = Str::uuid();

                // Import stock
                $importStocks[] = [
                    'id' => $importStockId,
                    'product_id' => $productId,
                    'product_type_id' => $productTypeId,
                    'batch_number' => $batchNumber,
                    'expired_date' => $defaultExpiredDate,
                    'quantity' => $quantity,
                    'hpp_average' => $hpp_average,
                    'selling_price' => $selling_price,
                    'selling_price_recipe' => $selling_price,
                    'branch_id' => $this->branch->id,
                    'company_id' => $this->company->id,
                    'created_at' => now(),
                    'updated_at' => now(),
                ];

                // Product stock
                $stocks[] = [
                    'id' => $stockId,
                    'product_id' => $productId,
                    'branch_id' => $this->branch->id,
                    'company_id' => $this->company->id,
                    'quantity' => $quantity,
                    'created_at' => now(),
                    'updated_at' => now(),
                ];

                // Expired date
                $expiredDates[] = [
                    'id' => $expiredDateId,
                    'product_stock_id' => $stockId,
                    'product_id' => $productId,
                    'branch_id' => $this->branch->id,
                    'company_id' => $this->company->id,
                    'expired_date' => $defaultExpiredDate,
                    'batch_number' => $batchNumber,
                    'quantity' => $quantity,
                    'user_id' => $defaultUser,
                    'created_at' => now(),
                    'updated_at' => now(),
                ];

                // Stock history with generated code
                $code = $this->generateStockCode($today);
                $description = "Barang masuk: {$quantity} unit pada " . date('d-m-Y') . " (Kode: {$code}), harga per unit: {$hpp_average}.";

                $stockHistories[] = [
                    'id' => $historyId,
                    'product_id' => $productId,
                    'product_stock_id' => $stockId,
                    'branch_id' => $this->branch->id,
                    'code' => $code,
                    'date' => Carbon::now(),
                    'product_import_stock_id' => $importStockId,
                    'description' => $description,
                    'company_id' => $this->company->id,
                    'quantity' => $quantity,
                    'price' => $hpp_average,
                    'sub_total_price' => $hpp_average * $quantity,
                    'type' => 'in',
                    'user_id' => $defaultUser,
                    'created_at' => now(),
                    'updated_at' => now(),
                ];

                // Product price
                $prices[] = [
                    'id' => $priceId,
                    'product_id' => $productId,
                    'branch_id' => $this->branch->id,
                    'company_id' => $this->company->id,
                    'price' => $selling_price,
                    'recipe' => $selling_price,
                    'hpp_average' => $hpp_average,
                    'is_updated' => true,
                    'created_at' => now(),
                    'updated_at' => now(),
                ];

                // Price history
                $priceHistories[] = [
                    'id' => $priceHistoryId,
                    'product_id' => $productId,
                    'product_price_id' => $priceId,
                    'branch_id' => $this->branch->id,
                    'company_id' => $this->company->id,
                    'price' => $hpp_average,
                    'quantity' => $quantity,
                    'sub_total_price' => $hpp_average * $quantity,
                    'hpp_average' => $hpp_average,
                    'is_updated' => false,
                    'user_id' => $defaultUser,
                    'created_at' => now(),
                    'updated_at' => now(),
                ];
            }
        }

        // Bulk insert all data
        $this->insertBatch($products, $importStocks, $stocks, $expiredDates, $stockHistories, $prices, $priceHistories);

        $this->command->info("Batch {$batchNumber}/{$totalBatches} completed - " . count($products) . " products processed");
    }

    /**
     * Parse CSV file efficiently
     */
    private function parseCSV($filePath)
    {
        $data = array_map('str_getcsv', file($filePath));
        $header = array_shift($data);

        $result = [];
        foreach ($data as $row) {
            if (count($row) === count($header)) {
                $result[] = array_combine($header, $row);
            }
        }

        return $result;
    }

    /**
     * Generate unique stock code efficiently
     */
    private static $codeCounter = 1;
    private function generateStockCode($today)
    {
        $prefix = 'IN/' . $today . '/';
        $code = $prefix . str_pad(self::$codeCounter, 4, '0', STR_PAD_LEFT);
        self::$codeCounter++;
        return $code;
    }

    /**
     * Insert data in batches for better performance
     */
    private function insertBatch($products, $importStocks, $stocks, $expiredDates, $stockHistories, $prices, $priceHistories)
    {
        DB::beginTransaction();

        try {
            // Insert products first
            if (!empty($products)) {
                DB::table('products')->insert($products);
            }

            // Insert related data
            if (!empty($importStocks)) {
                DB::table('product_import_stocks')->insert($importStocks);
            }

            if (!empty($stocks)) {
                DB::table('product_stocks')->insert($stocks);
            }

            if (!empty($expiredDates)) {
                DB::table('product_expired_dates')->insert($expiredDates);
            }

            if (!empty($stockHistories)) {
                DB::table('product_stock_histories')->insert($stockHistories);
            }

            if (!empty($prices)) {
                DB::table('product_prices')->insert($prices);
            }

            if (!empty($priceHistories)) {
                DB::table('product_price_histories')->insert($priceHistories);
            }

            DB::commit();
        } catch (\Exception $e) {
            DB::rollback();
            $this->command->error('Batch insert failed: ' . $e->getMessage());
            throw $e;
        }
    }
}
