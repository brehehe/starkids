<?php

namespace App\Livewire\Admin\Logistic\StockProduct;

use App\Helpers\AlertHelper;
use App\Models\StockOpname\StockOpname;
use App\Traits\Report\HasReportExportTrait;
use Illuminate\Support\Facades\Session;
use Livewire\Component;
use Livewire\WithPagination;

class AdminLogisticStockProductIndex extends Component
{
    use HasReportExportTrait, WithPagination;

    protected $queryString = [
        // 'page' => ['except' => 1], // Ini akan menghapus ?page=1 dari URL
        'search' => ['except' => ''],
    ];

    public $search = '';

    public $perPage = 5;

    public function mount()
    {
        Session::put('stock_opname_id', null);

        if (session()->has('saved')) {
            AlertHelper::success(session('saved.title'), session('saved.text'));
            session()->forget('saved');

            return;
        }
    }

    public function createOpname()
    {
        Session::put('stock_opname_id', null);

        return redirect()->route('user.logistic.stock-product.detail');
    }

    public function edit($stockOpnameId)
    {
        Session::put('stock_opname_id', $stockOpnameId);

        return redirect()->route('user.logistic.stock-product.detail');
    }

    public function confirmDelete($id)
    {
        return AlertHelper::confirmDelete('delete', 'Apakah Anda Yakin Menghapus Data?', $id);
    }

    public function delete($id)
    {
        $stockOpname = StockOpname::find($id[0]);
        if ($stockOpname) {
            $stockOpname->stockOpnameItems()->delete();

            $stockOpname->delete();
        }

        return AlertHelper::success('Berhasil', 'Data berhasil dihapus.');
    }

    public function exportExcel()
    {
        $items = StockOpname::with(['user', 'approvedBy'])
            ->search($this->search)
            ->latest()
            ->get();

        $headings = ['No', 'Kode', 'Tanggal', 'Pembuat', 'Approval', 'Total Kerugian', 'Total Kelebihan', 'Status'];
        $rows = [];

        foreach ($items as $idx => $item) {
            $rows[] = [
                $idx + 1,
                $item->code ?? '-',
                $item->date ? date('d/m/Y', strtotime($item->date)) : '-',
                $item->user->name ?? '-',
                $item->approvedBy->name ?? '-',
                $item->total_loss_value ?? 0,
                $item->total_excess_value ?? 0,
                ucfirst($item->status ?? '-'),
            ];
        }

        return $this->exportExcelResponse('logistic_stock_opname', $headings, $rows, 'Stock Opname');
    }

    public function exportPDF()
    {
        $items = StockOpname::with(['user', 'approvedBy'])
            ->search($this->search)
            ->latest()
            ->get();

        $columns = [
            ['label' => 'No', 'align' => 'center', 'width' => '30px'],
            ['label' => 'Kode', 'align' => 'left', 'width' => '90px'],
            ['label' => 'Tanggal', 'align' => 'center', 'width' => '75px'],
            ['label' => 'Pembuat', 'align' => 'left'],
            ['label' => 'Approval', 'align' => 'left'],
            ['label' => 'Kerugian', 'align' => 'right', 'width' => '85px'],
            ['label' => 'Kelebihan', 'align' => 'right', 'width' => '85px'],
            ['label' => 'Status', 'align' => 'center', 'width' => '65px'],
        ];

        $rows = [];
        $totalLoss = 0;
        $totalExcess = 0;

        foreach ($items as $idx => $item) {
            $loss = (float) ($item->total_loss_value ?? 0);
            $excess = (float) ($item->total_excess_value ?? 0);
            $totalLoss += $loss;
            $totalExcess += $excess;

            $rows[] = [
                $idx + 1,
                e($item->code ?? '-'),
                $item->date ? date('d/m/Y', strtotime($item->date)) : '-',
                e($item->user->name ?? '-'),
                e($item->approvedBy->name ?? '-'),
                'Rp '.number_format($loss),
                'Rp '.number_format($excess),
                ucfirst($item->status ?? '-'),
            ];
        }

        $totals = ['Total', '', '', '', '', 'Rp '.number_format($totalLoss), 'Rp '.number_format($totalExcess), ''];

        return $this->exportPDFResponse('logistic_stock_opname', 'Laporan Stock Opname Logistik', $columns, $rows, 'portrait', $totals);
    }

    public function render()
    {
        return view('livewire.admin.logistic.stock-product.admin-logistic-stock-product-index', [
            'stockOpnames' => StockOpname::with(['user', 'branch', 'approvedBy', 'company'])
                ->search($this->search)
                ->latest()
                ->paginate($this->perPage),
        ])
            ->extends('layout.app')
            ->section('content');
    }
}
