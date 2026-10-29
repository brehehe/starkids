<?php

namespace App\Livewire\Admin\Report\StockOpnameProduct;

use App\Models\StockOpname\StockOpnameItem;
use App\Traits\Report\HasReportExportTrait;
use Livewire\Component;
use Livewire\WithPagination;

class AdminReportStockOpnameProductIndex extends Component
{
    use HasReportExportTrait, WithPagination;

    protected $queryString = [
        // 'page' => ['except' => 1], // Ini akan menghapus ?page=1 dari URL
        'search' => ['except' => ''],
    ];

    public $search = '';

    public $perPage = 5;

    public $startDate;

    public $endDate;

    protected function getFilteredQuery()
    {
        return StockOpnameItem::search($this->search)
            ->when($this->startDate, function ($query) {
                $query->whereDate('created_at', '>=', $this->startDate);
            })
            ->when($this->endDate, function ($query) {
                $query->whereDate('created_at', '<=', $this->endDate);
            })
            ->with(['stockOpname', 'product', 'productExpiredDate'])
            ->latest();
    }

    public function exportExcel()
    {
        $items = $this->getFilteredQuery()->get();
        $headings = ['No', 'Nama Produk', 'Quantity Fisik', 'Quantity Sistem', 'Selisih', 'HPP Rata-rata', 'Nilai Kerugian', 'Nilai Kelebihan'];
        $rows = [];

        foreach ($items as $idx => $item) {
            $rows[] = [
                $idx + 1,
                $item->product->name ?? '-',
                $item->quantity ?? 0,
                $item->quantity_system ?? 0,
                $item->quantity_difference ?? 0,
                $item->hpp_average ?? 0,
                $item->loss_value ?? 0,
                $item->excess_value ?? 0,
            ];
        }

        return $this->exportExcelResponse('laporan_stock_opname_produk', $headings, $rows, 'SO Produk');
    }

    public function exportPDF()
    {
        $items = $this->getFilteredQuery()->get();
        $columns = [
            ['label' => 'No', 'align' => 'center', 'width' => '30px'],
            ['label' => 'Nama Produk', 'align' => 'left'],
            ['label' => 'Qty Fisik', 'align' => 'right', 'width' => '55px'],
            ['label' => 'Qty Sistem', 'align' => 'right', 'width' => '55px'],
            ['label' => 'Selisih', 'align' => 'right', 'width' => '50px'],
            ['label' => 'HPP', 'align' => 'right', 'width' => '75px'],
            ['label' => 'Kerugian', 'align' => 'right', 'width' => '80px'],
            ['label' => 'Kelebihan', 'align' => 'right', 'width' => '80px'],
        ];

        $rows = [];
        $totalLoss = 0;
        $totalExcess = 0;

        foreach ($items as $idx => $item) {
            $loss = (float) ($item->loss_value ?? 0);
            $excess = (float) ($item->excess_value ?? 0);
            $totalLoss += $loss;
            $totalExcess += $excess;

            $rows[] = [
                $idx + 1,
                e($item->product->name ?? '-'),
                number_format($item->quantity ?? 0),
                number_format($item->quantity_system ?? 0),
                number_format($item->quantity_difference ?? 0),
                'Rp '.number_format($item->hpp_average ?? 0),
                'Rp '.number_format($loss),
                'Rp '.number_format($excess),
            ];
        }

        $totals = ['Total', '', '', '', '', '', 'Rp '.number_format($totalLoss), 'Rp '.number_format($totalExcess)];

        return $this->exportPDFResponse('laporan_stock_opname_produk', 'Laporan Stock Opname Produk', $columns, $rows, 'portrait', $totals);
    }

    public function render()
    {
        $stockOpnameItems = StockOpnameItem::search($this->search)
            ->when($this->startDate, function ($query) {
                $query->whereDate('created_at', '>=', $this->startDate);
            })
            ->when($this->endDate, function ($query) {
                $query->whereDate('created_at', '<=', $this->endDate);
            })
            ->with(['stockOpname', 'product', 'productExpiredDate'])
            ->latest()
            ->paginate($this->perPage);

        return view('livewire.admin.report.stock-opname-product.admin-report-stock-opname-product-index', [
            'stockOpnameItems' => $stockOpnameItems,
        ])->extends('layout.app')
            ->section('content');
    }
}
