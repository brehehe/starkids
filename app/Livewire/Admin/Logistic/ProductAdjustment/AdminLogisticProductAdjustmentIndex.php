<?php

namespace App\Livewire\Admin\Logistic\ProductAdjustment;

use App\Models\Product\Product;
use App\Models\Product\ProductPrice;
use App\Models\Product\ProductPriceHistory;
use App\Models\Product\ProductSellingPriceHistory;
use App\Models\Product\ProductStock;
use App\Models\Product\ProductStockHistory;
use App\Traits\Branch\BranchTrait;
use App\Traits\Product\ProductPriceHistoryTrait;
use App\Traits\Product\ProductStockTrait;
use App\Traits\Report\HasReportExportTrait;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Str;
use Livewire\Component;
use Livewire\WithPagination;

class AdminLogisticProductAdjustmentIndex extends Component
{
    use BranchTrait, HasReportExportTrait, ProductPriceHistoryTrait, ProductStockTrait, WithPagination;

    public $search = '';

    public $perPage = 10;

    // Modal Adjustment Properties
    public $selectedAdjustmentProductId = null;

    public $productName = '';

    public $productSku = '';

    public $productUnit = '';

    public $currentStock = 0;

    public $adjustedStock = 0;

    public $adjustedHna = 0;

    public $adjustedHnaGross = 0;

    public $margin_normal = 0;

    public $adjustedPrice = 0;

    public $adjustmentNotes = '';

    protected $queryString = [
        'search' => ['except' => ''],
    ];

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function openAdjustmentModal($productId)
    {
        $product = Product::with(['productStock', 'productPrice', 'unit', 'productCategory'])->find($productId);

        if (! $product) {
            $this->dispatch('notify', ['type' => 'error', 'message' => 'Produk tidak ditemukan']);

            return;
        }

        $this->selectedAdjustmentProductId = $product->id;
        $this->productName = $product->name;
        $this->productSku = $product->sku_number ?: 'NO-SKU';
        $this->productUnit = $product->unit?->name ?? '-';
        $this->currentStock = (float) ($product->productStock?->quantity ?? 0);
        $this->adjustedStock = (float) ($product->productStock?->quantity ?? 0);

        $rawHna = (float) ($product->productPrice?->hpp_average ?? 0);
        $rawHnaGross = (float) ($product->productPrice?->hpp_average_without_discount ?: ($product->productPrice?->hpp_average ?? 0));
        $rawPrice = (float) ($product->productPrice?->price ?? 0);

        $this->adjustedHna = number_format($rawHna, 0, ',', '.');
        $this->adjustedHnaGross = number_format($rawHnaGross, 0, ',', '.');
        $this->adjustedPrice = number_format($rawPrice, 0, ',', '.');

        if ($rawHna > 0 && $rawPrice > 0) {
            $this->margin_normal = round((($rawPrice - $rawHna) / $rawHna) * 100, 2);
        } else {
            $this->margin_normal = $product->normal ?: ($product->productCategory?->normal ?? 0);
            if ($this->margin_normal > 0 && $rawHna > 0 && $rawPrice <= 0) {
                $calcPrice = $rawHna + ($rawHna * $this->margin_normal / 100);
                $this->adjustedPrice = number_format($calcPrice, 0, ',', '.');
            }
        }

        $this->adjustmentNotes = 'Penyesuaian stok & harga manual';

        $this->dispatch('open-modal', ['id' => 'adjustment-modal']);
    }

    public function closeAdjustmentModal()
    {
        $this->reset([
            'selectedAdjustmentProductId',
            'productName',
            'productSku',
            'productUnit',
            'currentStock',
            'adjustedStock',
            'adjustedHna',
            'adjustedHnaGross',
            'margin_normal',
            'adjustedPrice',
            'adjustmentNotes',
        ]);
        $this->dispatch('close-modal', ['id' => 'adjustment-modal']);
    }

    public function updatedMarginNormal()
    {
        $this->margin_normal = $this->margin_normal < 0 ? 0 : $this->margin_normal;
        $rawHna = $this->adjustedHna ? floatval(Str::replace('.', '', $this->adjustedHna)) : 0;
        $calculated = $rawHna + ($rawHna * (floatval($this->margin_normal) / 100));
        $this->adjustedPrice = number_format($calculated, 0, ',', '.');
    }

    public function updatedAdjustedPrice()
    {
        $rawPrice = $this->adjustedPrice ? floatval(Str::replace('.', '', $this->adjustedPrice)) : 0;
        $rawHna = $this->adjustedHna ? floatval(Str::replace('.', '', $this->adjustedHna)) : 0;
        if ($rawHna > 0 && $rawPrice >= $rawHna) {
            $this->margin_normal = round((($rawPrice - $rawHna) / $rawHna) * 100, 2);
        }
    }

    public function updatedAdjustedHna()
    {
        $rawHna = $this->adjustedHna ? floatval(Str::replace('.', '', $this->adjustedHna)) : 0;
        if ($this->margin_normal > 0 && $rawHna > 0) {
            $calculated = $rawHna + ($rawHna * (floatval($this->margin_normal) / 100));
            $this->adjustedPrice = number_format($calculated, 0, ',', '.');
        }
    }

    /**
     * Save adjustment from modal
     */
    public function saveAdjustmentModal()
    {
        if (! $this->selectedAdjustmentProductId) {
            return;
        }

        $this->validate([
            'adjustedStock' => 'required|numeric|min:0',
            'adjustedHna' => 'required',
            'adjustedPrice' => 'required',
            'margin_normal' => 'required|numeric|min:0',
        ]);

        $productId = $this->selectedAdjustmentProductId;
        $product = Product::findOrFail($productId);
        $branch = $this->getBranchOne();
        $user = Auth::user();

        $newStock = floatval($this->adjustedStock);
        $newHna = floatval(Str::replace('.', '', $this->adjustedHna));
        $newHnaGross = $this->adjustedHnaGross ? floatval(Str::replace('.', '', $this->adjustedHnaGross)) : $newHna;
        $newPrice = floatval(Str::replace('.', '', $this->adjustedPrice));
        $rawMargin = floatval($this->margin_normal);

        try {
            DB::beginTransaction();

            // 1. Handle Stock Adjustment
            $stock = ProductStock::firstOrCreate([
                'product_id' => $productId,
                'branch_id' => $branch->id,
                'company_id' => $user->company_id,
            ]);

            $oldStock = (float) $stock->quantity;
            $diff = $newStock - $oldStock;

            if ($diff != 0) {
                $stock->quantity = $newStock;
                $stock->save();

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
                    'price' => $newHna,
                    'sub_total_price' => abs($diff) * $newHna,
                    'description' => "Penyesuaian stok manual dari {$oldStock} ke {$newStock} (".($this->adjustmentNotes ?: 'Penyesuaian').')',
                ]);
            }

            // 2. Handle Price/HNA Adjustment
            $price = ProductPrice::firstOrCreate([
                'product_id' => $productId,
                'branch_id' => $branch->id,
                'company_id' => $user->company_id,
            ], [
                'hpp_average' => 0,
                'hpp_average_without_discount' => 0,
                'price' => 0,
                'recipe' => 0,
            ]);

            $oldPrice = (float) $price->price;
            $oldHna = (float) $price->hpp_average;
            $oldRecipe = (float) ($price->recipe ?? 0);

            $calculatedMargin = $newHna > 0 ? round((($newPrice - $newHna) / $newHna) * 100, 2) : $rawMargin;

            $price->hpp_average = $newHna;
            if (Schema::hasColumn('product_prices', 'hpp_average_without_discount')) {
                $price->hpp_average_without_discount = $newHnaGross;
            }
            $price->price = $newPrice;
            $price->price_generate = $newPrice;
            $price->is_updated = true;
            $price->save();

            // Record into ProductSellingPriceHistory
            ProductSellingPriceHistory::create([
                'product_id' => $productId,
                'product_price_id' => $price->id,
                'branch_id' => $branch->id,
                'company_id' => $user->company_id,
                'user_id' => $user->id,
                'old_price' => $oldPrice,
                'new_price' => $newPrice,
                'old_recipe' => $oldRecipe,
                'new_recipe' => $price->recipe ?? 0,
                'old_hpp_average' => $oldHna,
                'new_hpp_average' => $newHna,
                'margin' => $calculatedMargin,
                'source' => 'Perbaikan Stok & Harga',
                'notes' => ($this->adjustmentNotes ?: 'Penyesuaian manual')." (Margin: +{$calculatedMargin}%)",
            ]);

            // Create Price History for moving average batch
            ProductPriceHistory::create([
                'product_id' => $productId,
                'product_price_id' => $price->id,
                'branch_id' => $branch->id,
                'company_id' => $user->company_id,
                'user_id' => $user->id,
                'price' => $newHna,
                'hpp_average' => $newHna,
                'quantity' => $newStock,
                'sub_total_price' => $newHna * $newStock,
                'is_updated' => true,
            ]);

            DB::commit();

            $this->closeAdjustmentModal();
            $this->dispatch('notify', ['type' => 'success', 'message' => 'Penyesuaian '.$product->name.' berhasil disimpan']);
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Gagal simpan adjustment: '.$e->getMessage());
            $this->dispatch('notify', ['type' => 'error', 'message' => 'Gagal menyimpan penyesuaian: '.$e->getMessage()]);
        }
    }

    public function exportExcel()
    {
        $products = $this->getProductStocksQuery()->get();
        $headings = ['No', 'SKU Number', 'Nama Produk', 'Satuan', 'Stok Saat Ini', 'HNA Netto (Dgn Diskon)', 'HNA Bruto (Tanpa Diskon)', 'Harga Jual Aktif'];
        $rows = [];

        foreach ($products as $idx => $product) {
            $hnaNetto = (float) ($product->productPrice?->hpp_average ?? 0);
            $hnaBruto = (float) ($product->productPrice?->hpp_average_without_discount ?: $hnaNetto);
            $price = (float) ($product->productPrice?->price ?? 0);

            $rows[] = [
                $idx + 1,
                $product->sku_number ?? '-',
                $product->name ?? '-',
                $product->unit->name ?? '-',
                $product->productStock->quantity ?? 0,
                $hnaNetto,
                $hnaBruto,
                $price,
            ];
        }

        return $this->exportExcelResponse('penyesuaian_stok_dan_harga', $headings, $rows, 'Penyesuaian');
    }

    public function exportPDF()
    {
        $products = $this->getProductStocksQuery()->get();
        $columns = [
            ['label' => 'No', 'align' => 'center', 'width' => '30px'],
            ['label' => 'SKU', 'align' => 'left', 'width' => '75px'],
            ['label' => 'Nama Produk', 'align' => 'left'],
            ['label' => 'Satuan', 'align' => 'center', 'width' => '50px'],
            ['label' => 'Stok', 'align' => 'right', 'width' => '55px'],
            ['label' => 'HNA Netto', 'align' => 'right', 'width' => '80px'],
            ['label' => 'HNA Bruto', 'align' => 'right', 'width' => '80px'],
            ['label' => 'Harga Jual', 'align' => 'right', 'width' => '80px'],
        ];

        $rows = [];
        $totalQty = 0;

        foreach ($products as $idx => $product) {
            $qty = (float) ($product->productStock->quantity ?? 0);
            $totalQty += $qty;
            $hnaNetto = (float) ($product->productPrice?->hpp_average ?? 0);
            $hnaBruto = (float) ($product->productPrice?->hpp_average_without_discount ?: $hnaNetto);
            $price = (float) ($product->productPrice?->price ?? 0);

            $rows[] = [
                $idx + 1,
                e($product->sku_number ?? '-'),
                e($product->name ?? '-'),
                e($product->unit->name ?? '-'),
                number_format($qty),
                'Rp '.number_format($hnaNetto),
                'Rp '.number_format($hnaBruto),
                'Rp '.number_format($price),
            ];
        }

        $totals = ['Total', '', '', '', number_format($totalQty), '', '', ''];

        return $this->exportPDFResponse('penyesuaian_stok_dan_harga', 'Laporan Penyesuaian Stok & Harga Logistik', $columns, $rows, 'landscape', $totals);
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
