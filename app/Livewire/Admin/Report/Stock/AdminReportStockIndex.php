<?php

namespace App\Livewire\Admin\Report\Stock;

use App\Models\Product\Product;
use App\Traits\Product\ProductStockTrait;
use App\Traits\Report\HasReportExportTrait;
use Livewire\Component;
use Livewire\WithPagination;

class AdminReportStockIndex extends Component
{
    use HasReportExportTrait, ProductStockTrait, WithPagination;

    protected $queryString = [
        'start_date' => ['except' => ''],
        'end_date' => ['except' => ''],
        // 'page' => ['except' => 1], // Ini akan menghapus ?page=1 dari URL
        'search' => ['except' => ''],
    ];

    public $start_date;

    public $end_date;

    public $search = '';

    public $perPage = 5;

    public function mount()
    {
        $this->start_date = date('Y-m-d');
        $this->end_date = date('Y-m-d');
    }

    public function resetDates()
    {
        $this->reset(['start_date', 'end_date']);
    }

    public function getProductStocks()
    {
        return Product::search($this->search)
            ->with(['productStock' => function ($query) {
                $query->where('company_id', auth()->user()->company_id)
                    ->when($this->start_date, function ($query) {
                        $query->whereDate('created_at', '>=', $this->start_date);
                    })
                    ->when($this->end_date, function ($query) {
                        $query->whereDate('created_at', '<=', $this->end_date);
                    });
            }])
            ->paginate($this->perPage);
    }

    public function exportExcel()
    {
        $products = Product::search($this->search)
            ->with(['productStock', 'unit'])
            ->where('company_id', auth()->user()->company_id)
            ->orderBy('name', 'asc')
            ->get();

        $headings = ['No', 'SKU Number', 'Nama Produk', 'Minimum Stock', 'Safety Stock', 'Maximum Stock', 'Satuan', 'Quantity'];
        $rows = [];

        foreach ($products as $idx => $product) {
            $rows[] = [
                $idx + 1,
                $product->sku_number ?? '-',
                $product->name ?? '-',
                $product->minimun_stock ?? 0,
                $product->safety_stock ?? 0,
                $product->maximum_stock ?? 0,
                $product->unit->name ?? '-',
                $product->productStock?->quantity ?? 0,
            ];
        }

        return $this->exportExcelResponse('laporan_stok', $headings, $rows, 'Laporan Stok');
    }

    public function exportPDF()
    {
        $products = Product::search($this->search)
            ->with(['productStock', 'unit'])
            ->where('company_id', auth()->user()->company_id)
            ->orderBy('name', 'asc')
            ->get();

        $columns = [
            ['label' => 'No', 'align' => 'center', 'width' => '30px'],
            ['label' => 'SKU Number', 'align' => 'left', 'width' => '90px'],
            ['label' => 'Nama Produk', 'align' => 'left'],
            ['label' => 'Min', 'align' => 'center', 'width' => '40px'],
            ['label' => 'Safety', 'align' => 'center', 'width' => '45px'],
            ['label' => 'Max', 'align' => 'center', 'width' => '40px'],
            ['label' => 'Satuan', 'align' => 'center', 'width' => '50px'],
            ['label' => 'Quantity', 'align' => 'right', 'width' => '65px'],
        ];

        $rows = [];
        $totalQty = 0;

        foreach ($products as $idx => $product) {
            $qty = (float) ($product->productStock?->quantity ?? 0);
            $totalQty += $qty;

            $rows[] = [
                $idx + 1,
                e($product->sku_number ?? '-'),
                e($product->name ?? '-'),
                number_format($product->minimun_stock ?? 0),
                number_format($product->safety_stock ?? 0),
                number_format($product->maximum_stock ?? 0),
                e($product->unit->name ?? '-'),
                number_format($qty),
            ];
        }

        $totals = ['Total', '', '', '', '', '', '', number_format($totalQty)];

        return $this->exportPDFResponse('laporan_stok', 'Laporan Stok Produk', $columns, $rows, 'portrait', $totals);
    }

    public function render()
    {
        return view(
            'livewire.admin.report.stock.admin-report-stock-index',
            [
                'products' => $this->getProductStocks(),
            ]
        )
            ->extends('layout.app')
            ->section('content');
    }
}
