<?php

namespace App\Livewire\Admin\Sale\ProductPrice;

use App\Helpers\AlertHelper;
use App\Models\Product\ProductPrice;
use App\Models\Product\ProductCategory;
use App\Models\Product\ProductFactory;
use App\Models\Product\ProductRack;
use App\Models\Product\ProductType;
use App\Traits\Product\ProductPriceTrait;
use Livewire\Component;
use Livewire\WithPagination;
use Illuminate\Support\Str;

class AdminSaleProductPriceIndex extends Component
{
    use WithPagination, ProductPriceTrait;
    protected $queryString = [
        // 'page' => ['except' => 1], // Ini akan menghapus ?page=1 dari URL
        'search' => ['except' => ''],
    ];
    public $search = '';
    public $perPage = 5;

    // Filter properties
    public $product_category_id;
    public $product_factory_id;
    public $product_rack_id;
    public $product_type_id;

    // Filter options loaded in mount
    public $categories = [];
    public $factories = [];
    public $racks = [];
    public $types = [];

    public $data_id;
    public $data_name;
    public $hpp_average;
    public $price;
    public $recipe;

    public function mount()
    {
        // Load filter options
        $this->categories = ProductCategory::where('company_id', auth()->user()->company_id)
            ->select('id', 'name')
            ->orderBy('name')
            ->get()
            ->toArray();

        $this->factories = ProductFactory::where('company_id', auth()->user()->company_id)
            ->select('id', 'name')
            ->orderBy('name')
            ->get()
            ->toArray();

        $this->racks = ProductRack::where('company_id', auth()->user()->company_id)
            ->select('id', 'name')
            ->orderBy('name')
            ->get()
            ->toArray();

        $this->types = ProductType::select('id', 'name')
            ->orderBy('name')
            ->get()
            ->toArray();
    }

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function edit($id)
    {
        $productPrice = ProductPrice::find($id);
        if ($productPrice) {
            $this->data_id = $productPrice->id;
            $this->data_name = $productPrice->product->name;
            $this->hpp_average = number_format($productPrice->hpp_average, 0, ',', '.');
            $this->price = number_format($productPrice->price, 0, ',', '.');
            $this->recipe = number_format($productPrice->recipe, 0, ',', '.');
        }
        $this->dispatch('open-modal', ['id' => 'modal']);
    }

    public function closeModal()
    {
        $this->reset(['data_id', 'data_name', 'hpp_average', 'price', 'recipe']);
        $this->dispatch('close-modal', ['id' => 'modal']);
    }

    public function save()
    {
        $this->validate([
            'data_id' => 'required|exists:product_prices,id',
            'hpp_average' => 'required',
            'price' => 'required',
            'recipe' => 'required',
        ]);

        $hpp_average = intval(Str::replace('.', '', $this->hpp_average));
        $price = intval(Str::replace('.', '', $this->price));
        $recipe = intval(Str::replace('.', '', $this->recipe));

        if ($hpp_average <= 0 || $price <= 0) {
            return AlertHelper::error('Gagal', 'Nilai HPP, Harga, dan Resep harus lebih besar dari 0.');
        }

        if ($price < $hpp_average) {
            return AlertHelper::error('Gagal', 'Harga tidak boleh lebih kecil dari HPP.');
        }

        $recipe = 0;

        $productPrice = ProductPrice::find($this->data_id);
        if ($productPrice) {
            $productPrice->update([
                'is_updated' => true,
                'hpp_average' => $hpp_average,
                'price' => $price,
                'recipe' => $recipe,
            ]);
        }

        $this->closeModal();
        return AlertHelper::success('Berhasil', 'Harga produk berhasil diperbarui.');
    }

    public function render()
    {
        // Get base query
        $query = $this->getProductPriceUpdates();

        // Apply filters
        if ($this->product_category_id) {
            $query->whereHas('product', function ($q) {
                $q->where('product_category_id', $this->product_category_id);
            });
        }

        if ($this->product_factory_id) {
            $query->whereHas('product', function ($q) {
                $q->where('product_factory_id', $this->product_factory_id);
            });
        }

        if ($this->product_rack_id) {
            $query->whereHas('product', function ($q) {
                $q->where('product_rack_id', $this->product_rack_id);
            });
        }

        if ($this->product_type_id) {
            $query->whereHas('product', function ($q) {
                $q->where('product_type_id', $this->product_type_id);
            });
        }

        // Calculate statistics
        $products = $query->get();
        $totalProducts = $products->count();
        $totalQuantity = $products->sum(function ($item) {
            return $item->product->productStock->quantity ?? 0;
        });
        $totalHNA = $products->sum(function ($item) {
            $quantity = $item->product->productStock->quantity ?? 0;
            return $item->hpp_average * $quantity;
        });
        $totalPrice = $products->sum(function ($item) {
            $quantity = $item->product->productStock->quantity ?? 0;
            return $item->price * $quantity;
        });

        return view('livewire.admin.sale.product-price.admin-sale-product-price-index', [
            'productPrices' => $query->paginate($this->perPage),
            'totalProducts' => $totalProducts,
            'totalQuantity' => $totalQuantity,
            'totalHNA' => $totalHNA,
            'totalPrice' => $totalPrice,
        ])
            ->extends('layout.app')
            ->section('content');
    }
}
