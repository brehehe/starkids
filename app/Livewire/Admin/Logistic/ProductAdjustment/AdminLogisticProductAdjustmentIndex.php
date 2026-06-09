<?php

namespace App\Livewire\Admin\Logistic\ProductAdjustment;

use App\Models\Product\Product;
use App\Models\Product\ProductPrice;
use App\Models\Product\ProductPriceHistory;
use App\Models\Product\ProductStock;
use App\Models\Product\ProductStockHistory;
use App\Traits\Branch\BranchTrait;
use App\Traits\Product\ProductStockTrait;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Livewire\WithPagination;

class AdminLogisticProductAdjustmentIndex extends Component
{
    use BranchTrait, ProductStockTrait, WithPagination;

    public $search = '';

    public $perPage = 10;

    // Arrays for editing
    public $editingStocks = [];

    public $editingHnas = [];

    public $editingPrices = [];

    // History modal properties
    public $selectedProductId = null;

    public $selectedProductName = '';

    public $priceHistory = [];

    protected $queryString = [
        'search' => ['except' => ''],
    ];

    public function updatedSearch()
    {
        $this->resetPage();
    }

    /**
     * Save adjustment for a specific product
     */
    public function saveAdjustment($productId)
    {
        $product = Product::findOrFail($productId);
        $branch = $this->getBranchOne();
        $user = Auth::user();

        $newStock = isset($this->editingStocks[$productId]) && $this->editingStocks[$productId] !== '' ? (float) $this->editingStocks[$productId] : null;
        $newHna = isset($this->editingHnas[$productId]) && $this->editingHnas[$productId] !== '' ? (float) $this->editingHnas[$productId] : null;
        $newPrice = isset($this->editingPrices[$productId]) && $this->editingPrices[$productId] !== '' ? (float) $this->editingPrices[$productId] : null;

        if ($newStock === null && $newHna === null && $newPrice === null) {
            return;
        }

        // Handle Stock Adjustment
        if ($newStock !== null) {
            $stock = ProductStock::firstOrCreate([
                'product_id' => $productId,
                'branch_id' => $branch->id,
                'company_id' => $user->company_id,
            ]);

            $oldStock = $stock->quantity;
            $diff = $newStock - $oldStock;

            if ($diff != 0) {
                $stock->quantity = $newStock;
                $stock->save();

                // Create Stock History
                ProductStockHistory::create([
                    'product_id' => $productId,
                    'product_stock_id' => $stock->id,
                    'branch_id' => $branch->id,
                    'company_id' => $user->company_id,
                    'user_id' => $user->id,
                    'date' => Carbon::now(),
                    'code' => 'ADJ/'.date('ymd').'/'.strtoupper(substr(uniqid(), -4)),
                    'type' => $diff > 0 ? 'in' : 'out',
                    'quantity' => abs($diff),
                    'price' => $product->productPrice->hpp_average ?? 0,
                    'sub_total_price' => abs($diff) * ($product->productPrice->hpp_average ?? 0),
                    'description' => "Penyesuaian stok manual dari {$oldStock} ke {$newStock}",
                ]);
            }
        }

        // Handle Price/HNA Adjustment
        if ($newHna !== null || $newPrice !== null) {
            $price = ProductPrice::firstOrCreate([
                'product_id' => $productId,
                'branch_id' => $branch->id,
                'company_id' => $user->company_id,
            ], [
                'hpp_average' => 0,
                'price' => 0,
            ]);

            if ($newHna !== null) {
                $price->hpp_average = $newHna;
            }
            if ($newPrice !== null) {
                $price->price = $newPrice;
            }

            $price->is_updated = true;
            $price->save();

            // Create Price History
            ProductPriceHistory::create([
                'product_id' => $productId,
                'product_price_id' => $price->id,
                'branch_id' => $branch->id,
                'company_id' => $user->company_id,
                'user_id' => $user->id,
                'price' => $price->price,
                'hpp_average' => $price->hpp_average,
                'quantity' => $newStock ?? ($product->productStock->quantity ?? 0),
                'sub_total_price' => ($newHna ?? $price->hpp_average) * ($newStock ?? ($product->productStock->quantity ?? 0)),
                'is_updated' => true,
            ]);
        }

        $this->dispatch('notify', ['type' => 'success', 'message' => 'Penyesuaian '.$product->name.' berhasil disimpan']);

        // Clear inputs for this product
        unset($this->editingStocks[$productId]);
        unset($this->editingHnas[$productId]);
        unset($this->editingPrices[$productId]);
    }

    /**
     * Show history for a product
     */
    public function showHistory($productId)
    {
        $product = Product::findOrFail($productId);
        $this->selectedProductId = $productId;
        $this->selectedProductName = $product->name;

        $this->priceHistory = ProductPriceHistory::with('user')
            ->where('product_id', $productId)
            ->where('company_id', Auth::user()->company_id)
            ->orderBy('created_at', 'desc')
            ->get();

        $this->dispatch('open-modal', ['id' => 'history-modal']);
    }

    public function render()
    {
        $products = $this->getProductStocks();

        return view('livewire.admin.logistic.product-adjustment.admin-logistic-product-adjustment-index', [
            'products' => $products,
        ])
            ->extends('layout.app')
            ->section('content');
    }
}
