<?php

namespace App\Livewire\Admin\Sale\Price;

use App\Helpers\AlertHelper;
use App\Models\Product\Product;
use App\Models\Product\ProductPrice;
use App\Traits\Product\ProductPriceTrait;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Jantinnerezo\LivewireAlert\Facades\LivewireAlert;
use Livewire\Component;
use Livewire\WithPagination;
use Illuminate\Support\Str;

class AdminSalePriceIndex extends Component
{
    use WithPagination, ProductPriceTrait;
    protected $queryString = [
        // 'page' => ['except' => 1], // Ini akan menghapus ?page=1 dari URL
        'search' => ['except' => ''],
    ];
    public $search = '';
    public $perPage = 5;
    public $productPriceId;
    public $productSkuNumber = '';
    public $productName = '';
    public $margin = 0;
    public $margin_normal = 0;
    public $hpp_average;
    public $price_generate;
    public $selectedProducts = []; // array id productPrice yg dicentang

    public $selectAll = false;

    public function updatedSelectAll($value)
    {
        if ($value) {
            $this->selectedProducts = ProductPrice::pluck('id')->toArray();
        } else {
            $this->selectedProducts = [];
        }
    }

    public function generate()
    {
        $this->validate([
            'margin' => 'required|numeric|gt:0',
        ]);

        if (empty($this->selectedProducts)) {
            return AlertHelper::warning('Peringatan', 'Pilih minimal 1 produk terlebih dahulu.');
        }

        DB::beginTransaction();
        try {

            foreach ($this->selectedProducts as $id) {
                $this->generatePriceById($id, $this->margin);
            }

            $this->reset(['margin', 'selectedProducts', 'selectAll']);

            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Generate gagal: ' . $e->getMessage());
            return AlertHelper::error('Gagal', 'Gagal generate harga', $e->getMessage());
        }

        return AlertHelper::success('Berhasil', 'Generate harga selesai');
    }

    public function generatePriceById($productPriceId, $margin)
    {
        $productPrice = ProductPrice::find($productPriceId);
        if (!$productPrice) return;

        $price = $productPrice->hpp_average + ($productPrice->hpp_average * $margin / 100);

        $productPrice->update([
            // 'margin_normal' => $margin,
            'price_generate' => $price,
        ]);
    }

    public function updatePrice()
    {
        DB::beginTransaction();
        try {
            $this->generateFixedPrice();

            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Gagal generate product price: ' . $e->getMessage());
            return AlertHelper::error('Gagal', 'Gagal generate product price', $e->getMessage());
        }

        return AlertHelper::success('Berhasil', 'Berhasil Menyimpan Harga Jual');
    }

    public function confirmUpdatePrice()
    {
        LivewireAlert::title('Simpan Harga Jual?')
            ->text('Apakah Anda yakin ingin menyimpan harga jual ini?')
            ->withConfirmButton('Simpan', '#1E3A8A')
            ->withCancelButton('Batal')
            ->confirmButtonColor('#1E3A8A')
            ->denyButtonColor('#dc3545')
            ->withOptions([
                'customClass' => [
                    'title' => 'text-lg font-bold text-start',
                    'content' => 'text-start text-sm',
                    'popup' => 'text-left',
                ],
            ])
            ->onConfirm('updatePrice')
            ->show();
    }

    public function confirmDeleteProductPrice($productPriceId)
    {
        return AlertHelper::confirmDelete('deleteProductPrice', 'Apakah Anda yakin ingin menghapus harga jual ini?', $productPriceId);
    }

    public function deleteProductPrice($productPriceId)
    {
        $productPrice = ProductPrice::find($productPriceId[0]);
        if ($productPrice) {
            $productPrice->is_updated = true;
            $productPrice->save();
            return AlertHelper::success('Berhasil', 'Berhasil Menghapus Harga Jual');
        }
    }

    public function openModal($productPriceId)
    {
        $this->productPriceId = $productPriceId;
        $product = ProductPrice::with('product')->find($productPriceId);
        if ($product) {
            $this->hpp_average = number_format($product->hpp_average, 0, ',', '.');
            $this->price_generate = number_format($product->price_generate, 0, ',', '.');
            $this->productSkuNumber = $product->product->sku_number;
            $this->productName = $product->product->name;
        }
        $this->dispatch('open-modal', ['id' => 'modal']);
    }

    public function closeModal()
    {
        $this->reset(['productPriceId', 'hpp_average', 'price_generate', 'productSkuNumber', 'productName']);
        $this->dispatch('close-modal', ['id' => 'modal']);
    }

    public function save()
    {
        $this->hpp_average = $this->hpp_average ? intval(Str::replace('.', '', $this->hpp_average)) : 0;
        $this->margin_normal = $this->margin_normal ? intval(Str::replace('.', '', $this->margin_normal)) : 0;
        $this->price_generate = $this->price_generate ? intval(Str::replace('.', '', $this->price_generate)) : 0;

        $this->validate([
            'price_generate' => 'required|numeric|min:0|gte:hpp_average',
            'margin_normal' => 'required|numeric|min:0|lte:100',
        ]);

        try {
            DB::beginTransaction();
            ProductPrice::updateOrCreate(
                ['id' => $this->productPriceId],
                [
                    'hpp_average' => $this->hpp_average,
                    'margin_normal' => $this->margin_normal,
                    'price_generate' => $this->hpp_average + ($this->hpp_average * $this->margin_normal / 100),
                ]
            );
            DB::commit();
            $this->closeModal();
            return AlertHelper::success('Berhasil', 'Berhasil menyimpan harga jual');
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Gagal menyimpan harga jual: ' . $e->getMessage());
            return AlertHelper::error('Gagal', 'Gagal menyimpan harga jual', $e->getMessage());
        }
    }

    public function updatedMargin()
    {
        $this->margin = $this->margin > 100 ? 100 : ($this->margin < 0 ? 0 : $this->margin);
    }

    public function updatedMarginNormal()
    {
        $this->margin_normal = $this->margin_normal > 100 ? 100 : ($this->margin_normal < 0 ? 0 : $this->margin_normal);
    }

    public function render()
    {
        return view('livewire.admin.sale.price.admin-sale-price-index', [
            'productPrices' => $this->getProductPrices()->paginate($this->perPage),
        ])
            ->extends('layout.app')
            ->section('content');
    }
}
