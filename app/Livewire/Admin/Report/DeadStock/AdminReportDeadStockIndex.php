<?php

namespace App\Livewire\Admin\Report\DeadStock;

use App\Models\DeadStock\DeadStock;
use App\Traits\Report\HasReportExportTrait;
use Livewire\Component;
use Livewire\WithPagination;

class AdminReportDeadStockIndex extends Component
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
        return DeadStock::search($this->search)
            ->with('product')
            ->when($this->start_date && $this->end_date, function ($query) {
                $query->whereBetween('created_at', [$this->start_date, $this->end_date]);
            })
            ->latest();
    }

    public function exportExcel()
    {
        $items = $this->getFilteredQuery()->get();
        $headings = ['No', 'Nama Produk', 'Kode', 'Deskripsi', 'Quantity Lama', 'Quantity', 'Harga', 'Total'];
        $rows = [];

        foreach ($items as $idx => $item) {
            $rows[] = [
                $idx + 1,
                $item->product->name ?? '-',
                $item->code ?? '-',
                $item->description ?? '-',
                $item->quantity_old ?? 0,
                $item->quantity ?? 0,
                $item->price ?? 0,
                $item->total ?? 0,
            ];
        }

        return $this->exportExcelResponse('laporan_dead_stock', $headings, $rows, 'Dead Stock');
    }

    public function exportPDF()
    {
        $items = $this->getFilteredQuery()->get();
        $columns = [
            ['label' => 'No', 'align' => 'center', 'width' => '30px'],
            ['label' => 'Produk', 'align' => 'left'],
            ['label' => 'Kode', 'align' => 'left', 'width' => '80px'],
            ['label' => 'Deskripsi', 'align' => 'left'],
            ['label' => 'Qty Lama', 'align' => 'right', 'width' => '55px'],
            ['label' => 'Qty', 'align' => 'right', 'width' => '50px'],
            ['label' => 'Harga', 'align' => 'right', 'width' => '75px'],
            ['label' => 'Total', 'align' => 'right', 'width' => '80px'],
        ];

        $rows = [];
        $totalSum = 0;
        $totalQty = 0;

        foreach ($items as $idx => $item) {
            $qty = (float) ($item->quantity ?? 0);
            $total = (float) ($item->total ?? 0);
            $totalQty += $qty;
            $totalSum += $total;

            $rows[] = [
                $idx + 1,
                e($item->product->name ?? '-'),
                e($item->code ?? '-'),
                e($item->description ?? '-'),
                number_format($item->quantity_old ?? 0),
                number_format($qty),
                'Rp '.number_format($item->price ?? 0),
                'Rp '.number_format($total),
            ];
        }

        $totals = ['Total', '', '', '', '', number_format($totalQty), '', 'Rp '.number_format($totalSum)];

        return $this->exportPDFResponse('laporan_dead_stock', 'Laporan Dead Stock', $columns, $rows, 'portrait', $totals);
    }

    public function render()
    {
        $deadStocks = DeadStock::search($this->search)
            ->when($this->start_date && $this->end_date, function ($query) {
                $query->whereBetween('created_at', [$this->start_date, $this->end_date]);
            })
            ->latest()
            ->paginate($this->perPage);

        return view('livewire.admin.report.dead-stock.admin-report-dead-stock-index', [
            'deadStocks' => $deadStocks,
        ])
            ->extends('layout.app')
            ->section('content');
    }
}
