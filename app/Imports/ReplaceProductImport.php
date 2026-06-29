<?php

namespace App\Imports;

use App\Models\Product\Product;
use App\Models\Product\ProductFactory;
use App\Models\Product\ProductStock;
use App\Models\Product\ProductType;
use App\Models\Unit\Unit;
use Exception;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithBatchInserts;
use Maatwebsite\Excel\Concerns\WithChunkReading;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;

class ReplaceProductImport implements ToCollection, WithBatchInserts, WithChunkReading, WithHeadingRow, WithValidation
{
    private $results = [
        'total_rows' => 0,
        'processed' => 0,
        'updated' => 0,
        'skipped' => 0,
        'errors' => [],
        'created_products' => 0,
        'updated_stocks' => 0,
    ];

    /**
     * Process the imported collection
     *
     * @return void
     */
    public function collection(Collection $collection)
    {
        $this->results['total_rows'] = $collection->count();

        DB::transaction(function () use ($collection) {
            foreach ($collection as $index => $row) {
                try {
                    $this->processRow($row->toArray(), $index + 2); // +2 because heading row is 1, data starts from 2
                    $this->results['processed']++;
                } catch (Exception $e) {
                    $this->results['errors'][] = [
                        'row' => $index + 2,
                        'error' => $e->getMessage(),
                        'data' => $row->toArray(),
                    ];
                    $this->results['skipped']++;

                    Log::error('Error processing row in replace product import', [
                        'row' => $index + 2,
                        'error' => $e->getMessage(),
                        'data' => $row->toArray(),
                    ]);
                }
            }
        });
    }

    /**
     * Process a single row from the Excel file
     *
     * @return void
     */
    private function processRow(array $row, int $rowNumber)
    {
        // Normalize keys to handle different header formats
        $normalizedRow = $this->normalizeKeys($row);

        // Validate required fields
        $this->validateRowData($normalizedRow, $rowNumber);

        // Find or create product
        $product = $this->findOrCreateProduct($normalizedRow);

        if ($product) {
            // Update product stock
            $this->updateProductStock($product, $normalizedRow, $rowNumber);
            $this->results['updated']++;
        }
    }

    /**
     * Normalize array keys to handle different header formats
     */
    private function normalizeKeys(array $row): array
    {
        $normalized = [];
        $keyMap = [
            'sku_number' => ['sku_number', 'sku', 'kode_produk', 'product_code'],
            'product_name' => ['product_name', 'name', 'nama_produk', 'product'],
            'old_stock' => ['old_stock', 'stok_lama', 'current_stock', 'stok_sekarang'],
            'new_stock' => ['new_stock', 'stok_baru', 'target_stock', 'stok_target'],
            'reason' => ['reason', 'alasan', 'keterangan_alasan'],
            'notes' => ['notes', 'catatan', 'keterangan', 'note'],
            'principle' => ['principle', 'pabrik', 'manufacturer', 'factory'],
            'unit' => ['unit', 'satuan', 'unit_name'],
            'category' => ['category', 'kategori', 'product_type', 'tipe_produk'],
        ];

        foreach ($keyMap as $standardKey => $possibleKeys) {
            foreach ($possibleKeys as $key) {
                if (isset($row[$key])) {
                    $normalized[$standardKey] = $row[$key];
                    break;
                }
            }
        }

        return $normalized;
    }

    /**
     * Validate row data
     *
     * @return void
     *
     * @throws Exception
     */
    private function validateRowData(array $row, int $rowNumber)
    {
        $requiredFields = ['sku_number', 'product_name', 'new_stock'];

        foreach ($requiredFields as $field) {
            if (empty($row[$field])) {
                throw new Exception("Baris {$rowNumber}: Field '{$field}' wajib diisi");
            }
        }

        // Validate numeric fields
        if (! is_numeric($row['new_stock']) || $row['new_stock'] < 0) {
            throw new Exception("Baris {$rowNumber}: New stock harus berupa angka positif");
        }

        if (isset($row['old_stock']) && ! empty($row['old_stock'])) {
            if (! is_numeric($row['old_stock']) || $row['old_stock'] < 0) {
                throw new Exception("Baris {$rowNumber}: Old stock harus berupa angka positif");
            }
        }
    }

    /**
     * Find existing product or create new one
     */
    private function findOrCreateProduct(array $row): ?Product
    {
        // First, try to find by SKU number
        $product = Product::where('sku_number', $row['sku_number'])->first();

        if (! $product) {
            // Try to find by name
            $product = Product::where('name', 'LIKE', '%'.$row['product_name'].'%')->first();
        }

        if (! $product) {
            // Create new product
            $product = $this->createNewProduct($row);
            if ($product) {
                $this->results['created_products']++;
            }
        }

        return $product;
    }

    /**
     * Create a new product
     */
    private function createNewProduct(array $row): ?Product
    {
        try {
            // Get or create product factory
            $productFactory = $this->getOrCreateProductFactory($row['principle'] ?? 'Unknown');

            // Get or create unit
            $unit = $this->getOrCreateUnit($row['unit'] ?? 'Pcs');

            // Get or create product type
            $productType = $this->getOrCreateProductType($row['category'] ?? 'Obat');

            // Create product
            $product = Product::create([
                'company_id' => auth()->user()->company_id,
                'sku_number' => $row['sku_number'],
                'name' => $row['product_name'],
                'product_factory_id' => $productFactory->id,
                'unit_id' => $unit->id,
                'product_type_id' => $productType->id,
                'is_active' => true,
            ]);

            return $product;
        } catch (Exception $e) {
            Log::error('Failed to create new product in replace product import', [
                'error' => $e->getMessage(),
                'data' => $row,
            ]);

            return null;
        }
    }

    /**
     * Update product stock
     *
     * @return void
     */
    private function updateProductStock(Product $product, array $row, int $rowNumber)
    {
        try {
            $productStock = ProductStock::firstOrCreate(
                [
                    'product_id' => $product->id,
                    'company_id' => $product->company_id,
                ],
                [
                    'stock' => 0,
                    'minimum_stock' => 10,
                ]
            );

            // Update stock
            $oldStock = $productStock->stock;
            $newStock = (float) $row['new_stock'];
            $difference = $newStock - $oldStock;

            $productStock->update([
                'stock' => $newStock,
                'updated_at' => now(),
            ]);

            // Log stock change
            Log::info('Product stock updated via replace product import', [
                'product_id' => $product->id,
                'sku_number' => $product->sku_number,
                'old_stock' => $oldStock,
                'new_stock' => $newStock,
                'difference' => $difference,
                'reason' => $row['reason'] ?? 'Replace Product Import',
                'notes' => $row['notes'] ?? '',
                'row_number' => $rowNumber,
                'user_id' => auth()->id(),
            ]);

            $this->results['updated_stocks']++;
        } catch (Exception $e) {
            throw new Exception('Gagal mengupdate stock produk: '.$e->getMessage());
        }
    }

    /**
     * Get or create product factory
     */
    private function getOrCreateProductFactory(string $name): ProductFactory
    {
        return ProductFactory::firstOrCreate(
            [
                'name' => $name,
                'company_id' => auth()->user()->company_id,
            ],
            [
                'is_active' => true,
            ]
        );
    }

    /**
     * Get or create unit
     */
    private function getOrCreateUnit(string $name): Unit
    {
        return Unit::firstOrCreate(['name' => $name]);
    }

    /**
     * Get or create product type
     */
    private function getOrCreateProductType(string $name): ProductType
    {
        return ProductType::firstOrCreate(['name' => $name]);
    }

    /**
     * Get import results
     */
    public function getResults(): array
    {
        return $this->results;
    }

    /**
     * Validation rules for the import
     */
    public function rules(): array
    {
        return [
            'sku_number' => 'required|string|max:255',
            'product_name' => 'required|string|max:255',
            'new_stock' => 'required|numeric|min:0',
            'old_stock' => 'nullable|numeric|min:0',
            'reason' => 'nullable|string|max:500',
            'notes' => 'nullable|string|max:1000',
            'principle' => 'nullable|string|max:255',
            'unit' => 'nullable|string|max:50',
            'category' => 'nullable|string|max:100',
        ];
    }

    /**
     * Batch size for processing
     */
    public function batchSize(): int
    {
        return 100;
    }

    /**
     * Chunk size for reading
     */
    public function chunkSize(): int
    {
        return 500;
    }
}
