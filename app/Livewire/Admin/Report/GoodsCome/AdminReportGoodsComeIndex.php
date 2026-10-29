<?php

namespace App\Livewire\Admin\Report\GoodsCome;

use App\Models\Product\ProductStockHistory;
use App\Traits\Report\HasReportExportTrait;
use Livewire\Component;
use Livewire\WithPagination;

class AdminReportGoodsComeIndex extends Component
{
    use HasReportExportTrait, WithPagination;

    protected $queryString = [
        // 'page' => ['except' => 1], // Ini akan menghapus ?page=1 dari URL
        'search' => ['except' => ''],
    ];

    public $search = '';

    public $perPage = 5;

    public $start_date;

    public $end_date;

    public function mount()
    {
        $this->start_date = now()->startOfMonth()->format('Y-m-d');
        $this->end_date = now()->endOfMonth()->format('Y-m-d');
    }

    public function resetDates()
    {
        $this->reset(['start_date', 'end_date']);
    }

    protected function getFilteredQuery()
    {
        return ProductStockHistory::search($this->search)
            ->whereNotNull('purchase_order_item_id')
            ->with('product')
            ->when($this->start_date, function ($query, $start_date) {
                $query->whereDate('created_at', '>=', $start_date);
            })
            ->when($this->end_date, function ($query, $end_date) {
                $query->whereDate('created_at', '<=', $end_date);
            })
            ->where('type', 'in');
    }

    public function exportExcel()
    {
        $items = $this->getFilteredQuery()->get();
        $headings = ['No', 'Nama Produk', 'Kode', 'Deskripsi', 'Quantity'];
        $rows = [];

        foreach ($items as $idx => $item) {
            $rows[] = [
                $idx + 1,
                $item->product->name ?? '-',
                $item->code ?? '-',
                $item->description ?? '-',
                $item->quantity ?? 0,
            ];
        }

        return $this->exportExcelResponse('laporan_penerimaan_barang', $headings, $rows, 'Penerimaan Barang');
    }

    public function exportPDF()
    {
        $items = $this->getFilteredQuery()->get();
        $columns = [
            ['label' => 'No', 'align' => 'center', 'width' => '30px'],
            ['label' => 'Produk', 'align' => 'left'],
            ['label' => 'Kode', 'align' => 'left', 'width' => '90px'],
            ['label' => 'Deskripsi', 'align' => 'left'],
            ['label' => 'Quantity', 'align' => 'right', 'width' => '70px'],
        ];

        $rows = [];
        $totalQty = 0;

        foreach ($items as $idx => $item) {
            $qty = (float) ($item->quantity ?? 0);
            $totalQty += $qty;

            $rows[] = [
                $idx + 1,
                e($item->product->name ?? '-'),
                e($item->code ?? '-'),
                e($item->description ?? '-'),
                number_format($qty),
            ];
        }

        $totals = ['Total', '', '', '', number_format($totalQty)];

        return $this->exportPDFResponse('laporan_penerimaan_barang', 'Laporan Penerimaan Barang', $columns, $rows, 'portrait', $totals);
    }

    public function render()
    {
        $productStockHistorys = ProductStockHistory::search($this->search)
            ->whereNotNull('purchase_order_item_id')
            ->when($this->start_date, function ($query, $start_date) {
                $query->whereDate('created_at', '>=', $start_date);
            })
            ->when($this->end_date, function ($query, $end_date) {
                $query->whereDate('created_at', '<=', $end_date);
            })
            ->where('type', 'in');

        return view('livewire.admin.report.goods-come.admin-report-goods-come-index', [
            'productStockHistorys' => $productStockHistorys->paginate($this->perPage),
        ])
            ->extends('layout.app')
            ->section('content');
    }
}
