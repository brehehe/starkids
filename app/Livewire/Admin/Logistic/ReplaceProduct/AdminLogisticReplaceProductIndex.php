<?php

namespace App\Livewire\Admin\Logistic\ReplaceProduct;

use App\Helpers\AlertHelper;
use App\Imports\ProductImport;
use App\Models\Product\Product;
use App\Models\Product\ProductStock;
use App\Traits\Product\ProductStockTrait;
use Illuminate\Support\Facades\DB;
use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\WithPagination;
use Log;
use Maatwebsite\Excel\Facades\Excel;

class AdminLogisticReplaceProductIndex extends Component
{
    use ProductStockTrait, WithFileUploads, WithPagination;

    protected $queryString = [
        // 'page' => ['except' => 1], // Ini akan menghapus ?page=1 dari URL
        'search' => ['except' => ''],
    ];

    public $search = '';

    public $perPage = 5;

    public $import;

    // Stock update modal
    public $selectedProductId;

    public $newQuantity;

    public $updateReason;

    public function openModal()
    {
        return $this->dispatch('open-modal', ['id' => 'modal']);
    }

    public function closeModal()
    {
        $this->reset(['import']);

        return $this->dispatch('close-modal', ['id' => 'modal']);
    }

    public function openUpdateStockModal($productId)
    {
        $this->reset(['newQuantity', 'updateReason']);
        $this->selectedProductId = $productId;

        // Load current product data
        $product = Product::with(['productStock'])->find($productId);
        if ($product && $product->productStock) {
            $this->newQuantity = $product->productStock->quantity;
        }

        return $this->dispatch('open-modal', ['id' => 'update-stock-modal']);
    }

    public function closeUpdateStockModal()
    {
        $this->reset(['selectedProductId', 'newQuantity', 'updateReason']);

        return $this->dispatch('close-modal', ['id' => 'update-stock-modal']);
    }

    public function updateStock()
    {
        $this->validate([
            'newQuantity' => 'required|numeric|min:0',
            'updateReason' => 'nullable|string|min:5',
        ], [
            'newQuantity.required' => 'Kuantitas harus diisi',
            'newQuantity.numeric' => 'Kuantitas harus berupa angka',
            'newQuantity.min' => 'Kuantitas tidak boleh negatif',
            'updateReason.required' => 'Alasan perubahan harus diisi',
            'updateReason.min' => 'Alasan minimal 5 karakter',
        ]);

        try {
            DB::beginTransaction();

            $product = Product::with(['productStock'])->find($this->selectedProductId);

            if (! $product) {
                throw new \Exception('Produk tidak ditemukan');
            }

            $oldQuantity = $product->productStock ? $product->productStock->quantity : 0;

            // Update stock
            if ($product->productStock) {
                $product->productStock->update(['quantity' => $this->newQuantity]);
            } else {
                ProductStock::create([
                    'product_id' => $product->id,
                    'quantity' => $this->newQuantity,
                    'company_id' => auth()->user()->company_id,
                ]);
            }

            // Log the stock update
            Log::info('Stock updated manually', [
                'product_id' => $product->id,
                'product_name' => $product->name,
                'old_quantity' => $oldQuantity,
                'new_quantity' => $this->newQuantity,
                'reason' => $this->updateReason,
                'user_id' => auth()->id(),
            ]);

            DB::commit();
            $this->closeUpdateStockModal();
            AlertHelper::success('Berhasil', 'Stok produk berhasil diperbarui!');

        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Stock update failed', [
                'error' => $e->getMessage(),
                'product_id' => $this->selectedProductId,
                'user_id' => auth()->id(),
            ]);
            AlertHelper::error('Gagal', 'Terjadi kesalahan saat memperbarui stok.');
        }
    }

    public function saveImport()
    {
        $this->validate([
            'import' => 'required|file|mimes:xlsx,xls|max:10240', // Max 10MB
        ]);

        try {
            DB::beginTransaction();
            $file = $this->import;
            $import = new ProductImport;
            Excel::import($import, $file);
            $results = $import->getResults();
            DB::commit();
            $this->closeModal();
            AlertHelper::success('Berhasil', 'Sesuaikan Produk Berhasil!');

            return;
        } catch (\Exception $e) {
            DB::rollBack();
            AlertHelper::error('Gagal', 'Terjadi kesalahan saat mengimpor data. Silakan coba lagi.');
            Log::error('Replace Product Import failed', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
                'user_id' => auth()->id(),
            ]);

            return;
        }
    }

    public function render()
    {
        return view(
            'livewire.admin.logistic.replace-product.admin-logistic-replace-product-index',
            [
                'products' => $this->getProductStocks(),
            ]
        )
            ->extends('layout.app')
            ->section('content');
    }
}
