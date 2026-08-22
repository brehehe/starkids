<?php

namespace App\Livewire\Admin\Sale\Price;

use App\Helpers\AlertHelper;
use App\Models\Product\ProductPrice;
use App\Models\Product\ProductSellingPriceHistory;
use App\Traits\Product\ProductPriceHistoryTrait;
use App\Traits\Product\ProductPriceTrait;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use Jantinnerezo\LivewireAlert\Facades\LivewireAlert;
use Livewire\Component;
use Livewire\WithPagination;

class AdminSalePriceIndex extends Component
{
    use ProductPriceHistoryTrait, ProductPriceTrait, WithPagination;

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
            Log::error('Generate gagal: '.$e->getMessage());

            return AlertHelper::error('Gagal', 'Gagal generate harga', $e->getMessage());
        }

        return AlertHelper::success('Berhasil', 'Generate harga selesai');
    }

    public function generatePriceById($productPriceId, $margin)
    {
        $productPrice = ProductPrice::find($productPriceId);
        if (! $productPrice) {
            return;
        }

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
            Log::error('Gagal generate product price: '.$e->getMessage());

            return AlertHelper::error('Gagal', 'Gagal generate product price', $e->getMessage());
        }

        return AlertHelper::success('Berhasil', 'Berhasil Menyimpan Harga Jual');
    }

    public function confirmUpdatePrice()
    {
        LivewireAlert::title('Simpan Semua Harga Jual?')
            ->text('Apakah Anda yakin ingin menerapkan dan menyimpan seluruh harga jual yang telah di-generate?')
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

    public $hpp_average_without_discount = 0;

    public function openModal($productPriceId)
    {
        $this->productPriceId = $productPriceId;
        $product = ProductPrice::with('product')->find($productPriceId);
        if ($product) {
            $rawHna = (float) $product->hpp_average;
            $rawHnaGross = (float) ($product->hpp_average_without_discount ?: $product->hpp_average);
            $rawPrice = (float) ($product->price_generate > 0 ? $product->price_generate : $product->price);
            $this->hpp_average = number_format($rawHna, 0, ',', '.');
            $this->hpp_average_without_discount = number_format($rawHnaGross, 0, ',', '.');
            $this->price_generate = number_format($rawPrice, 0, ',', '.');
            
            if ($rawHna > 0 && $rawPrice > 0) {
                $this->margin_normal = round((($rawPrice - $rawHna) / $rawHna) * 100, 2);
            } else {
                $this->margin_normal = $product->margin_normal ?: ($product->product->normal ?: ($product->product->productCategory?->normal ?? 0));
                if ($this->margin_normal > 0 && $rawHna > 0 && $rawPrice <= 0) {
                    $rawPrice = $rawHna + ($rawHna * $this->margin_normal / 100);
                    $this->price_generate = number_format($rawPrice, 0, ',', '.');
                }
            }

            $this->productSkuNumber = $product->product->sku_number;
            $this->productName = $product->product->name;
        }
        $this->dispatch('open-modal', ['id' => 'modal']);
    }

    public function closeModal()
    {
        $this->reset(['productPriceId', 'hpp_average', 'hpp_average_without_discount', 'price_generate', 'margin_normal', 'productSkuNumber', 'productName']);
        $this->dispatch('close-modal', ['id' => 'modal']);
    }

    public function save()
    {
        $rawHna = $this->hpp_average ? floatval(Str::replace('.', '', $this->hpp_average)) : 0;
        $rawMargin = $this->margin_normal ? floatval(Str::replace('.', '', $this->margin_normal)) : 0;
        $rawPrice = $this->price_generate ? floatval(Str::replace('.', '', $this->price_generate)) : 0;

        $this->validate([
            'price_generate' => 'required',
            'margin_normal' => 'required|numeric|min:0',
        ]);

        try {
            DB::beginTransaction();
            $productPrice = ProductPrice::find($this->productPriceId);
            if ($productPrice) {
                $oldPrice = (float) $productPrice->price;
                $oldRecipe = (float) $productPrice->recipe;
                $oldHna = (float) $productPrice->hpp_average;

                $newPrice = $rawPrice > 0 ? $rawPrice : ($rawHna + ($rawHna * $rawMargin / 100));
                $calculatedMargin = $rawHna > 0 ? round((($newPrice - $rawHna) / $rawHna) * 100, 2) : $rawMargin;

                $productPrice->update([
                    'hpp_average' => $rawHna,
                    'margin_normal' => $calculatedMargin,
                    'price_generate' => $newPrice,
                    'price' => $newPrice,
                    'is_updated' => true,
                ]);

                ProductSellingPriceHistory::create([
                    'product_id' => $productPrice->product_id,
                    'product_price_id' => $productPrice->id,
                    'branch_id' => $productPrice->branch_id,
                    'company_id' => $productPrice->company_id,
                    'user_id' => Auth::user()?->id,
                    'old_price' => $oldPrice,
                    'new_price' => $newPrice,
                    'old_recipe' => $oldRecipe,
                    'new_recipe' => $productPrice->recipe ?? 0,
                    'old_hpp_average' => $oldHna,
                    'new_hpp_average' => $rawHna,
                    'margin' => $calculatedMargin,
                    'source' => 'Update Harga Jual (Farmasi)',
                    'notes' => 'Margin: +'.$calculatedMargin.'%',
                ]);
            }
            DB::commit();
            $this->closeModal();

            return AlertHelper::success('Berhasil', 'Berhasil menyimpan harga jual');
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Gagal menyimpan harga jual: '.$e->getMessage());

            return AlertHelper::error('Gagal', 'Gagal menyimpan harga jual', $e->getMessage());
        }
    }

    public function updatedMargin()
    {
        $this->margin = $this->margin < 0 ? 0 : $this->margin;
    }

    public function updatedMarginNormal()
    {
        $this->margin_normal = $this->margin_normal < 0 ? 0 : $this->margin_normal;
        $rawHna = $this->hpp_average ? floatval(Str::replace('.', '', $this->hpp_average)) : 0;
        $calculated = $rawHna + ($rawHna * (floatval($this->margin_normal) / 100));
        $this->price_generate = number_format($calculated, 0, ',', '.');
    }

    public function updatedPriceGenerate()
    {
        $rawPrice = $this->price_generate ? floatval(Str::replace('.', '', $this->price_generate)) : 0;
        $rawHna = $this->hpp_average ? floatval(Str::replace('.', '', $this->hpp_average)) : 0;
        if ($rawHna > 0 && $rawPrice >= $rawHna) {
            $this->margin_normal = round((($rawPrice - $rawHna) / $rawHna) * 100, 2);
        }
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

