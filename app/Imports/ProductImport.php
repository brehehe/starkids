<?php

namespace App\Imports;

use App\Models\Branch\Branch;
use App\Models\Company\Company;
use App\Models\Product\Product;
use App\Models\Product\ProductFactory;
use App\Models\Product\ProductPrice;
use App\Models\Product\ProductStock;
use App\Models\Product\ProductType;
use App\Models\Unit\Unit;
use Exception;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithBatchInserts;
use Maatwebsite\Excel\Concerns\WithChunkReading;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;

class ProductImport implements ToCollection, WithBatchInserts, WithChunkReading, WithHeadingRow, WithValidation
{
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
        'errors' => [],
    ];

    public function __construct()
    {
        $this->initializeCache();
    }

    public function collection(Collection $collection)
    {
        foreach ($collection as $row) {
            $this->processProduct($row->toArray());
        }
    }

    public function rules(): array
    {
        return [
            'name' => 'required|string|max:255',
            'sku_number' => 'nullable|string|max:100',
            'principle' => 'nullable|string|max:255',
            'tipe_produk' => 'nullable|string|max:100',
            'quantity' => 'nullable|numeric|min:0',
            'hpp_average' => 'nullable|numeric|min:0',
            'selling_price' => 'nullable|numeric|min:0',
        ];
    }

    public function batchSize(): int
    {
        return 50;
    }

    public function chunkSize(): int
    {
        return 100;
    }

    /**
     * Initialize cache for frequently used data
     */
    private function initializeCache()
    {
        // Find a company that has branches
        $companiesWithBranches = DB::table('companies')
            ->join('branches', 'companies.id', '=', 'branches.company_id')
            ->select('companies.id')
            ->distinct()
            ->get();

        if ($companiesWithBranches->isNotEmpty()) {
            $this->company = Company::find($companiesWithBranches->first()->id);
            $this->branch = Branch::where('company_id', $this->company->id)->first();
        } else {
            $this->company = Company::first();
            $this->branch = Branch::first();

            if (! $this->company) {
                throw new Exception('No company found in database');
            }

            if (! $this->branch) {
                throw new Exception('No branch found in database');
            }
        }

        // Cache product types
        ProductType::all()->each(function ($type) {
            $this->productTypes[strtolower($type->name)] = $type;
        });

        // Cache units
        Unit::all()->each(function ($unit) {
            $this->units[strtolower($unit->name)] = $unit;
        });

        // Cache existing products
        Product::with(['productStock', 'productPrice', 'productFactory'])->get()->each(function ($product) {
            if ($product->sku_number) {
                $this->existingProducts[$product->sku_number] = $product;
            }
            if ($product->name && ! isset($this->existingProducts[$product->name])) {
                $this->existingProducts[$product->name] = $product;
            }
        });

        // Cache existing product factories
        ProductFactory::where('company_id', $this->company->id)->get()->each(function ($factory) {
            $this->productFactories[strtolower(trim($factory->name))] = $factory;
        });
    }

    /**
     * Process single product with comprehensive ecosystem handling
     */
    private function processProduct($row)
    {
        $skuNumber = trim($row['sku_number'] ?? '');
        $name = trim($row['name'] ?? '');
        $principle = trim($row['principle'] ?? '');

        if (empty($name)) {
            $this->counters['errors'][] = 'Product name is required';

            return ['action' => 'error', 'stock_operation' => false, 'price_operation' => false];
        }

        DB::beginTransaction();

        try {
            // Handle ProductFactory
            $productFactory = null;
            if (! empty($principle)) {
                $productFactory = $this->handleProductFactory($principle);
            }

            // Find existing product
            $existingProduct = $this->findExistingProduct($skuNumber, $name);

            if ($existingProduct) {
                // Update existing product
                $product = $this->updateExistingProduct($existingProduct, $row, $productFactory);
                $action = 'updated';
                $this->counters['products_updated']++;
            } else {
                // Create new product
                $product = $this->createNewProduct($row, $productFactory);
                $action = 'created';
                $this->counters['products_created']++;
            }

            // Handle stock and price
            $stockOperation = $this->handleProductStock($product, $row);
            $priceOperation = $this->handleProductPrice($product, $row);

            if ($stockOperation) {
                $this->counters['stock_operations']++;
            }
            if ($priceOperation) {
                $this->counters['price_operations']++;
            }

            DB::commit();

            return [
                'action' => $action,
                'stock_operation' => $stockOperation,
                'price_operation' => $priceOperation,
            ];
        } catch (Exception $e) {
            DB::rollBack();
            $this->counters['errors'][] = "Error processing {$name}: ".$e->getMessage();

            return ['action' => 'error', 'stock_operation' => false, 'price_operation' => false];
        }
    }

    /**
     * Handle ProductFactory (updateOrCreate based on Principle)
     */
    private function handleProductFactory($principle)
    {
        $principleKey = strtolower(trim($principle));

        if (isset($this->productFactories[$principleKey])) {
            return $this->productFactories[$principleKey];
        }

        $productFactory = ProductFactory::updateOrCreate(
            [
                'name' => $principle,
                'company_id' => $this->company->id,
            ],
            [
                'description' => "Factory for {$principle}",
                'address' => null,
                'phone' => null,
            ]
        );

        if ($productFactory->wasRecentlyCreated) {
            $this->counters['factories_created']++;
        } else {
            $this->counters['factories_updated']++;
        }

        $this->productFactories[$principleKey] = $productFactory;

        return $productFactory;
    }

    /**
     * Find existing product by SKU or name
     */
    private function findExistingProduct($skuNumber, $name)
    {
        if ($skuNumber && isset($this->existingProducts[$skuNumber])) {
            return $this->existingProducts[$skuNumber];
        }

        if ($skuNumber) {
            $product = Product::where('sku_number', $skuNumber)
                ->where('company_id', $this->company->id)
                ->first();
            if ($product) {
                $this->existingProducts[$skuNumber] = $product;

                return $product;
            }
        }

        if (empty($skuNumber) && $name && isset($this->existingProducts[$name])) {
            return $this->existingProducts[$name];
        }

        return null;
    }

    /**
     * Update existing product
     */
    private function updateExistingProduct($existingProduct, $row, $productFactory)
    {
        $skuNumber = trim($row['sku_number'] ?? '');
        $name = trim($row['name'] ?? '');
        $productTypeId = $this->getProductTypeId($row['tipe_produk'] ?? '');

        if (! $productTypeId) {
            $productTypeId = $existingProduct->product_type_id;
        }

        $updateData = [
            'product_type_id' => $productTypeId,
            'company_id' => $this->company->id,
            'branch_id' => $this->branch->id,
        ];

        if (! empty($name)) {
            $updateData['name'] = $name;
        }

        if (! empty($skuNumber)) {
            $updateData['sku_number'] = $skuNumber;
        }

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
        $skuNumber = trim($row['sku_number'] ?? '');
        $name = trim($row['name'] ?? '');
        $productTypeId = $this->getProductTypeId($row['tipe_produk'] ?? '');

        $unitId = null;
        $defaultUnit = $this->units['pcs'] ?? $this->units['pc'] ?? $this->units['piece'] ?? null;
        if ($defaultUnit) {
            $unitId = $defaultUnit->id;
        } else {
            $unitId = Unit::first()?->id;
        }

        $productData = [
            'name' => $name,
            'sku_number' => $skuNumber ?: null,
            'product_type_id' => $productTypeId,
            'unit_id' => $unitId,
            'company_id' => $this->company->id,
            'branch_id' => $this->branch->id,
            'product_factory_id' => $productFactory?->id,
            'description' => null,
            'is_active' => true,
            'is_non_stock' => false,
        ];

        $product = Product::create($productData);

        if ($skuNumber) {
            $this->existingProducts[$skuNumber] = $product;
        }
        if ($name && ! isset($this->existingProducts[$name])) {
            $this->existingProducts[$name] = $product;
        }

        return $product;
    }

    /**
     * Get product type ID from field with smart matching
     */
    private function getProductTypeId($tipeProduktValue)
    {
        if (empty($tipeProduktValue)) {
            return $this->productTypes['obat']?->id ?? ProductType::first()?->id;
        }

        $tipeProduktValue = strtolower(trim($tipeProduktValue));

        if (isset($this->productTypes[$tipeProduktValue])) {
            return $this->productTypes[$tipeProduktValue]->id;
        }

        $mappings = [
            'obat' => ['medicine', 'drug', 'pharmaceutical', 'farmasi'],
            'alat kesehatan' => ['medical device', 'device', 'equipment', 'alkes'],
            'konsumables' => ['consumable', 'supplies', 'habis pakai'],
            'jasa' => ['service', 'layanan'],
        ];

        foreach ($mappings as $typeKey => $variations) {
            if (in_array($tipeProduktValue, $variations) && isset($this->productTypes[$typeKey])) {
                return $this->productTypes[$typeKey]->id;
            }
        }

        foreach ($this->productTypes as $key => $productType) {
            if (str_contains($key, $tipeProduktValue) || str_contains($tipeProduktValue, $key)) {
                return $productType->id;
            }
        }

        return ProductType::first()?->id;
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

        ProductStock::updateOrCreate(
            [
                'product_id' => $product->id,
                'company_id' => $this->company->id,
                'branch_id' => $this->branch->id,
            ],
            [
                'quantity' => $quantity,
                'minimum_stock' => 0,
            ]
        );

        return true;
    }

    /**
     * Handle ProductPrice (create or update)
     */
    private function handleProductPrice($product, $row)
    {
        $hasPrice = isset($row['hpp_average']) || isset($row['selling_price']);

        if (! $hasPrice) {
            return false;
        }

        $hppAverage = $this->parseNumeric($row['hpp_average'] ?? '0');
        $sellingPrice = $this->parseNumeric($row['selling_price'] ?? '0');

        ProductPrice::updateOrCreate(
            [
                'product_id' => $product->id,
                'company_id' => $this->company->id,
                'branch_id' => $this->branch->id,
            ],
            [
                'hpp_average' => $hppAverage,
                'price' => $sellingPrice,
                'is_active' => true,
                'is_updated' => true,
            ]
        );

        return true;
    }

    /**
     * Parse numeric values (handle comma as decimal separator)
     */
    private function parseNumeric($value)
    {
        if (empty($value)) {
            return 0;
        }

        $value = str_replace(' ', '', $value);
        $value = str_replace(',', '.', $value);

        return (float) $value;
    }

    /**
     * Get import results
     */
    public function getResults()
    {
        return $this->counters;
    }
}
