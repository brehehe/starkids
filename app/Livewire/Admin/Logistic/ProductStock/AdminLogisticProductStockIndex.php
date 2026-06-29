<?php

namespace App\Livewire\Admin\Logistic\ProductStock;

use App\Models\Product\ProductCategory;
use App\Models\Product\ProductFactory;
use App\Models\Product\ProductRack;
use App\Models\Product\ProductType;
use App\Traits\Product\ProductStockTrait;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Livewire\WithPagination;

class AdminLogisticProductStockIndex extends Component
{
    use ProductStockTrait, WithPagination;

    protected $queryString = [
        'search' => ['except' => ''],
        'product_category_id' => ['except' => ''],
        'product_factory_id' => ['except' => ''],
        'product_rack_id' => ['except' => ''],
        'product_type_id' => ['except' => ''],
    ];

    public $search = '';

    public $perPage = 5;

    // Filter properties
    public $product_category_id = '';

    public $product_factory_id = '';

    public $product_rack_id = '';

    public $product_type_id = '';

    // Reset pagination when filter changes
    public function updatedProductCategoryId()
    {
        $this->resetPage();
    }

    public function updatedProductFactoryId()
    {
        $this->resetPage();
    }

    public function updatedProductRackId()
    {
        $this->resetPage();
    }

    public function updatedProductTypeId()
    {
        $this->resetPage();
    }

    public function updatedSearch()
    {
        $this->resetPage();
    }

    /**
     * Get summary statistics
     */
    public function getSummaryStats()
    {
        $query = $this->getProductStocksQuery();

        $stats = [
            'total_products' => 0,
            'total_quantity' => 0,
            'total_stock_value' => 0,
        ];

        $products = $query->get();

        $stats['total_products'] = $products->count();

        foreach ($products as $product) {
            $quantity = $product->productStock->quantity ?? 0;
            $hppAverage = $product->productPrice->hpp_average ?? 0;

            $stats['total_quantity'] += $quantity;
            $stats['total_stock_value'] += ($quantity * $hppAverage);
        }

        return $stats;
    }

    public function render()
    {
        return view(
            'livewire.admin.logistic.product-stock.admin-logistic-product-stock-index',
            [
                'products' => $this->getProductStocks(),
                'summaryStats' => $this->getSummaryStats(),
                'productCategories' => ProductCategory::where('company_id', Auth::user()->company_id)
                    ->orderBy('name', 'asc')
                    ->get(),
                'productFactories' => ProductFactory::where('company_id', Auth::user()->company_id)
                    ->orderBy('name', 'asc')
                    ->get(),
                'productRacks' => ProductRack::where('company_id', Auth::user()->company_id)
                    ->orderBy('name', 'asc')
                    ->get(),
                'productTypes' => ProductType::orderBy('name', 'asc')->get(),
            ]
        )
            ->extends('layout.app')
            ->section('content');
    }
}
