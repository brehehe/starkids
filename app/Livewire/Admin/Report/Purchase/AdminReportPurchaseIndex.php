<?php

namespace App\Livewire\Admin\Report\Purchase;

use App\Models\PurchaseOrder\PurchaseOrder;
use App\Traits\Report\HasReportExportTrait;
use Illuminate\Support\Facades\Session;
use Livewire\Component;
use Livewire\WithPagination;

class AdminReportPurchaseIndex extends Component
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
        $this->start_date = date('Y-m-d');
        $this->end_date = date('Y-m-d');
    }

    public function resetDates()
    {
        $this->reset(['start_date', 'end_date']);
    }

    protected function getFilteredQuery()
    {
        return PurchaseOrder::where('company_id', auth()->user()->company_id)
            ->with('supplier')
            ->when($this->start_date, function ($query, $start_date) {
                $query->whereDate('created_at', '>=', $start_date);
            })
            ->when($this->end_date, function ($query, $end_date) {
                $query->whereDate('created_at', '<=', $end_date);
            })
            ->where('status', 'success')
            ->latest()
            ->orderBy('order', 'desc');
    }

    public function exportExcel()
    {
        $items = $this->getFilteredQuery()->get();
        $headings = ['No', 'Nomor PO', 'Tanggal', 'Supplier', 'Grand Total'];
        $rows = [];

        foreach ($items as $idx => $item) {
            $rows[] = [
                $idx + 1,
                $item->number ?? '-',
                $item->created_at ? $item->created_at->format('d/m/Y') : '-',
                $item->supplier->name ?? '-',
                $item->grand_total ?? 0,
            ];
        }

        return $this->exportExcelResponse('laporan_pembelian', $headings, $rows, 'Pembelian');
    }

    public function exportPDF()
    {
        $items = $this->getFilteredQuery()->get();
        $columns = [
            ['label' => 'No', 'align' => 'center', 'width' => '30px'],
            ['label' => 'Nomor PO', 'align' => 'left', 'width' => '110px'],
            ['label' => 'Tanggal', 'align' => 'center', 'width' => '80px'],
            ['label' => 'Supplier', 'align' => 'left'],
            ['label' => 'Grand Total', 'align' => 'right', 'width' => '100px'],
        ];

        $rows = [];
        $totalSum = 0;

        foreach ($items as $idx => $item) {
            $total = (float) ($item->grand_total ?? 0);
            $totalSum += $total;

            $rows[] = [
                $idx + 1,
                e($item->number ?? '-'),
                $item->created_at ? $item->created_at->format('d/m/Y') : '-',
                e($item->supplier->name ?? '-'),
                'Rp '.number_format($total),
            ];
        }

        $totals = ['Total', '', '', '', 'Rp '.number_format($totalSum)];

        return $this->exportPDFResponse('laporan_pembelian', 'Laporan Pembelian', $columns, $rows, 'portrait', $totals);
    }

    public function render()
    {
        $purchaseOrder = PurchaseOrder::where('company_id', auth()->user()->company_id)
            ->when($this->start_date, function ($query, $start_date) {
                $query->whereDate('created_at', '>=', $start_date);
            })
            ->when($this->end_date, function ($query, $end_date) {
                $query->whereDate('created_at', '<=', $end_date);
            })
            ->where('status', 'success')
            ->latest()
            ->orderBy('order', 'desc')
            ->paginate($this->perPage);

        $totalPurchase = PurchaseOrder::where('company_id', auth()->user()->company_id)
            ->when($this->start_date, function ($query, $start_date) {
                $query->whereDate('created_at', '>=', $start_date);
            })
            ->when($this->end_date, function ($query, $end_date) {
                $query->whereDate('created_at', '<=', $end_date);
            })
            ->where('status', 'success')
            ->sum('grand_total_real');

        return view('livewire.admin.report.purchase.admin-report-purchase-index', [
            'purchase_orders' => $purchaseOrder,
            'total_purchase' => $totalPurchase,
        ])
            ->extends('layout.app')
            ->section('content');
    }

    public function confirmDetail($id)
    {
        Session::put('purchase_order_id', $id);

        return redirect()->route('user.report.purchase.detail');
    }
}
