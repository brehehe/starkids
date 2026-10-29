<?php

namespace App\Livewire\Admin\Report\StockOut;

use App\Traits\Product\ProductStockTrait;
use App\Traits\Product\ProductTrait;
use App\Traits\Report\HasReportExportTrait;
use Livewire\Component;
use Livewire\WithPagination;

class AdminReportStockOutIndex extends Component
{
    use HasReportExportTrait, ProductStockTrait, ProductTrait, WithPagination;

    protected $queryString = [
        // 'page' => ['except' => 1], // Ini akan menghapus ?page=1 dari URL
        'search' => ['except' => ''],
    ];

    public $search = '';

    public $perPage = 5;

    public $start_date;

    public $end_date;

    public $product_id;

    public function resetDates()
    {
        $this->reset(['start_date', 'end_date']);
    }

    public function exportExcel()
    {
        $items = $this->getProductStockHistorysQuery('out')->get();
        $headings = ['No', 'SKU Number', 'Nama Produk', 'Kode', 'Deskripsi', 'Quantity', 'Satuan', 'Tanggal'];
        $rows = [];

        foreach ($items as $idx => $item) {
            $rows[] = [
                $idx + 1,
                $item->product->sku_number ?? '-',
                $item->product->name ?? '-',
                $item->code ?? '-',
                $item->description ?? '-',
                $item->quantity ?? 0,
                $item->product->unit->name ?? '-',
                $item->date ? date('d/m/Y', strtotime($item->date)) : '-',
            ];
        }

        return $this->exportExcelResponse('laporan_stok_keluar', $headings, $rows, 'Stok Keluar');
    }

    public function exportPDF()
    {
        $items = $this->getProductStockHistorysQuery('out')->get();
        $columns = [
            ['label' => 'No', 'align' => 'center', 'width' => '30px'],
            ['label' => 'SKU', 'align' => 'left', 'width' => '80px'],
            ['label' => 'Nama Produk', 'align' => 'left'],
            ['label' => 'Kode', 'align' => 'left', 'width' => '80px'],
            ['label' => 'Keterangan', 'align' => 'left'],
            ['label' => 'Qty', 'align' => 'right', 'width' => '50px'],
            ['label' => 'Satuan', 'align' => 'center', 'width' => '50px'],
            ['label' => 'Tanggal', 'align' => 'center', 'width' => '70px'],
        ];

        $rows = [];
        $totalQty = 0;

        foreach ($items as $idx => $item) {
            $qty = (float) ($item->quantity ?? 0);
            $totalQty += $qty;

            $rows[] = [
                $idx + 1,
                e($item->product->sku_number ?? '-'),
                e($item->product->name ?? '-'),
                e($item->code ?? '-'),
                e($item->description ?? '-'),
                number_format($qty),
                e($item->product->unit->name ?? '-'),
                $item->date ? date('d/m/Y', strtotime($item->date)) : '-',
            ];
        }

        $totals = ['Total', '', '', '', '', number_format($totalQty), '', ''];

        return $this->exportPDFResponse('laporan_stok_keluar', 'Laporan Stok Keluar', $columns, $rows, 'portrait', $totals);
    }

    public function render()
    {
        return view(
            'livewire.admin.report.stock-out.admin-report-stock-out-index',
            [
                'products' => $this->getProductSelects(),
                'productStockHistorys' => $this->getProductStockHistorys('out'),
            ]
        )
            ->extends('layout.app')
            ->section('content');
    }
}
