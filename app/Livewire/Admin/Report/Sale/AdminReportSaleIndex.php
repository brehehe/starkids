<?php

namespace App\Livewire\Admin\Report\Sale;

use App\Models\Transaction\Transaction;
use App\Traits\Report\HasReportExportTrait;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Str;
use Livewire\Component;
use Livewire\WithPagination;

class AdminReportSaleIndex extends Component
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

    public $type;

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function updatedPerPage()
    {
        $this->resetPage();
    }

    public function mount()
    {
        $this->start_date = now()->startOfMonth()->format('Y-m-d');
        $this->end_date = now()->endOfMonth()->format('Y-m-d');
        Session::forget('transaction_id');
    }

    public function edit($id)
    {
        Session::put('transaction_id', $id);

        return redirect()->route('user.sale.report-sale.detail');
    }

    protected function getFilteredQuery()
    {
        $query = Transaction::search($this->search)
            ->where('company_id', auth()->user()->company_id)
            ->where('status', 'completed');

        if ($this->start_date && $this->end_date) {
            $query->whereBetween('created_at', [
                $this->start_date.' 00:00:00',
                $this->end_date.' 23:59:59',
            ]);
        }

        if ($this->type) {
            $query->where('type', $this->type);
        }

        return $query->orderBy('order', 'desc');
    }

    public function exportExcel()
    {
        $items = $this->getFilteredQuery()->get();
        $headings = ['No', 'Kode Transaksi', 'Pelanggan', 'Tipe', 'Sub Total', 'Diskon', 'Grand Total', 'Tanggal'];
        $rows = [];

        foreach ($items as $idx => $item) {
            $rows[] = [
                $idx + 1,
                $item->code ?? '-',
                $item->patient_name ?? '-',
                Str::title(Str::replace('-', ' ', $item->type)),
                $item->sub_total_price ?? 0,
                $item->discount_value ?? 0,
                $item->grand_total_price ?? 0,
                $item->created_at ? $item->created_at->format('d/m/Y') : '-',
            ];
        }

        return $this->exportExcelResponse('laporan_penjualan', $headings, $rows, 'Penjualan');
    }

    public function exportPDF()
    {
        $items = $this->getFilteredQuery()->get();
        $columns = [
            ['label' => 'No', 'align' => 'center', 'width' => '30px'],
            ['label' => 'Kode', 'align' => 'left', 'width' => '90px'],
            ['label' => 'Pelanggan', 'align' => 'left'],
            ['label' => 'Tipe', 'align' => 'center', 'width' => '75px'],
            ['label' => 'Sub Total', 'align' => 'right', 'width' => '85px'],
            ['label' => 'Diskon', 'align' => 'right', 'width' => '70px'],
            ['label' => 'Grand Total', 'align' => 'right', 'width' => '90px'],
        ];

        $rows = [];
        $totalSub = 0;
        $totalDisc = 0;
        $totalGrand = 0;

        foreach ($items as $idx => $item) {
            $sub = (float) ($item->sub_total_price ?? 0);
            $disc = (float) ($item->discount_value ?? 0);
            $grand = (float) ($item->grand_total_price ?? 0);
            $totalSub += $sub;
            $totalDisc += $disc;
            $totalGrand += $grand;

            $rows[] = [
                $idx + 1,
                e($item->code ?? '-'),
                e($item->patient_name ?? '-'),
                Str::title(Str::replace('-', ' ', $item->type)),
                'Rp '.number_format($sub),
                'Rp '.number_format($disc),
                'Rp '.number_format($grand),
            ];
        }

        $totals = ['Total', '', '', '', 'Rp '.number_format($totalSub), 'Rp '.number_format($totalDisc), 'Rp '.number_format($totalGrand)];
        $period = ($this->start_date && $this->end_date) ? date('d/m/Y', strtotime($this->start_date)).' - '.date('d/m/Y', strtotime($this->end_date)) : null;

        return $this->exportPDFResponse('laporan_penjualan', 'Laporan Penjualan', $columns, $rows, 'portrait', $totals, $period);
    }

    public function render()
    {
        $query = Transaction::search($this->search)
            ->where('company_id', auth()->user()->company_id)
            ->where('status', 'completed');

        if ($this->start_date && $this->end_date) {
            $query->whereBetween('created_at', [
                $this->start_date.' 00:00:00',
                $this->end_date.' 23:59:59',
            ]);
        }

        if ($this->type) {
            $query->where('type', $this->type);
        }

        $total_transactions = $query->count();
        $total_revenue = $query->sum('grand_total_price');

        $transactions = $query->select('id', 'code', 'branch_id', 'company_id', 'patient_name', 'sub_total_price', 'discount_value', 'grand_total_price', 'type', 'status')
            ->with(['branch:id,name', 'company:id,name'])
            ->orderBy('order', 'desc')
            ->paginate($this->perPage);

        return view('livewire.admin.report.sale.admin-report-sale-index', [
            'transactions' => $transactions,
            'total_transactions' => $total_transactions,
            'total_revenue' => $total_revenue,
        ])
            ->extends('layout.app')
            ->section('content');
    }
}
