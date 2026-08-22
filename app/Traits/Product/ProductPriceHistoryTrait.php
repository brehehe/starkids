<?php

namespace App\Traits\Product;

use App\Models\Product\Product;
use App\Models\Product\ProductPriceHistory;
use App\Models\Product\ProductSellingPriceHistory;
use Illuminate\Support\Facades\Auth;

trait ProductPriceHistoryTrait
{
    public $selectedProductId = null;

    public $selectedProductName = '';

    public $selectedProductHna = 0;

    public $selectedProductHnaGross = 0;

    public $selectedProductPrice = 0;

    public $selectedProductRecipe = 0;

    public $selectedProductStock = 0;

    public $selectedProductUnit = '-';

    public $historyTab = 'selling';

    public $sellingPriceHistory = [];

    public $priceHistory = [];

    public function showHistory($productId)
    {
        $this->selectedProductId = $productId;
        $product = Product::with(['productPrice', 'productStock', 'unit'])->find($productId);

        if ($product) {
            $this->selectedProductName = $product->name;
            $this->selectedProductHna = $product->productPrice?->hpp_average ?? 0;
            $this->selectedProductHnaGross = $product->productPrice?->hpp_average_without_discount ?? ($product->productPrice?->hpp_average ?? 0);
            $this->selectedProductPrice = $product->productPrice?->price ?? 0;
            $this->selectedProductRecipe = $product->productPrice?->recipe ?? 0;
            $this->selectedProductStock = $product->productStock?->quantity ?? 0;
            $this->selectedProductUnit = $product->unit?->name ?? '-';

            $companyId = Auth::user()?->company_id;

            $this->sellingPriceHistory = ProductSellingPriceHistory::with('user')
                ->where('product_id', $productId)
                ->when($companyId, fn ($q) => $q->where('company_id', $companyId))
                ->orderBy('created_at', 'desc')
                ->get();

            $this->priceHistory = ProductPriceHistory::with([
                'user',
                'purchaseOrderItem.purchaseOrder',
                'purchaseOrderItem.purchaseRequisitionItem.purchaseRequisition',
            ])
                ->where('product_id', $productId)
                ->when($companyId, fn ($q) => $q->where('company_id', $companyId))
                ->orderBy('created_at', 'desc')
                ->get();
        }

        $this->dispatch('open-modal', ['id' => 'history-modal']);
    }

    public function closeHistoryModal()
    {
        $this->reset([
            'selectedProductId',
            'selectedProductName',
            'selectedProductHna',
            'selectedProductHnaGross',
            'selectedProductPrice',
            'selectedProductRecipe',
            'selectedProductStock',
            'selectedProductUnit',
            'sellingPriceHistory',
            'priceHistory',
        ]);
        $this->dispatch('close-modal', ['id' => 'history-modal']);
    }

    public function setHistoryTab($tab)
    {
        $this->historyTab = $tab;
    }
}
