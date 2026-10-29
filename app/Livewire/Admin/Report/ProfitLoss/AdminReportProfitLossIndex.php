<?php

namespace App\Livewire\Admin\Report\ProfitLoss;

use App\Models\Product\Product;
use App\Models\Transaction\TransactionProduct;
use App\Traits\Report\HasReportExportTrait;
use Livewire\Component;
use Livewire\WithPagination;

class AdminReportProfitLossIndex extends Component
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

    public $products = [];

    public $product_id;

    public function mount()
    {
        $this->start_date = now()->startOfMonth()->format('Y-m-d');
        $this->end_date = now()->endOfMonth()->format('Y-m-d');
        $this->products = Product::select('id', 'name', 'sku_number')
            ->where('company_id', auth()->user()->company_id)
            ->orderBy('name', 'asc')
            ->get()
            ->toArray();
    }

    public function hydrate()
    {
        $this->resetPage();
    }

    protected function getFilteredQuery()
    {
        return TransactionProduct::search($this->search)
            ->selectRaw('
                product_id,
                product_name,
                SUM(quantity) as total_quantity,
                SUM(price) as total_price,
                SUM(total) as total_penjualan,
                SUM(hpp_average) as total_hpp_average,
                SUM(hpp_total) as total_hpp_total,
                SUM(profit) as total_profit,
                AVG(margin) as average_margin
            ')
            ->where('company_id', auth()->user()->company_id)
            ->with('product:id,name,sku_number,product_type_id', 'product.productType:id,name')
            ->whereHas('transaction', function ($query) {
                $query->where('status', 'completed');

                if ($this->type) {
                    $query->where('type', $this->type);
                }
            })
            ->when($this->start_date && $this->end_date, function ($query) {
                $query->whereBetween('created_at', [
                    $this->start_date.' 00:00:00',
                    $this->end_date.' 23:59:59',
                ]);
            })
            ->when($this->product_id, function ($query) {
                $query->where('product_id', $this->product_id);
            })
            ->groupBy('product_id', 'product_name')
            ->orderBy('total_quantity', 'desc');
    }

    public function exportExcel()
    {
        $items = $this->getFilteredQuery()->get();
        $headings = ['No', 'Nama Produk', 'SKU Number', 'Tipe Produk', 'Total Penjualan', 'Total HPP', 'Total Quantity', 'Total Profit', 'Rata-rata Margin (%)'];
        $rows = [];

        foreach ($items as $idx => $item) {
            $rows[] = [
                $idx + 1,
                $item->product->name ?? ($item->product_name ?? '-'),
                $item->product->sku_number ?? '-',
                $item->product->productType->name ?? '-',
                $item->total_penjualan ?? 0,
                $item->total_hpp_total ?? 0,
                $item->total_quantity ?? 0,
                $item->total_profit ?? 0,
                round($item->average_margin ?? 0, 1),
            ];
        }

        return $this->exportExcelResponse('laporan_laba_rugi_penjualan', $headings, $rows, 'Laba Rugi');
    }

    public function exportPDF()
    {
        $items = $this->getFilteredQuery()->get();
        $columns = [
            ['label' => 'No', 'align' => 'center', 'width' => '30px'],
            ['label' => 'Nama Produk', 'align' => 'left'],
            ['label' => 'SKU', 'align' => 'left', 'width' => '75px'],
            ['label' => 'Tipe', 'align' => 'center', 'width' => '70px'],
            ['label' => 'Penjualan', 'align' => 'right', 'width' => '85px'],
            ['label' => 'Total HPP', 'align' => 'right', 'width' => '85px'],
            ['label' => 'Qty', 'align' => 'center', 'width' => '45px'],
            ['label' => 'Profit', 'align' => 'right', 'width' => '85px'],
            ['label' => 'Margin', 'align' => 'right', 'width' => '55px'],
        ];

        $rows = [];
        $sumSales = 0;
        $sumHpp = 0;
        $sumQty = 0;
        $sumProfit = 0;

        foreach ($items as $idx => $item) {
            $sales = (float) ($item->total_penjualan ?? 0);
            $hpp = (float) ($item->total_hpp_total ?? 0);
            $qty = (float) ($item->total_quantity ?? 0);
            $profit = (float) ($item->total_profit ?? 0);

            $sumSales += $sales;
            $sumHpp += $hpp;
            $sumQty += $qty;
            $sumProfit += $profit;

            $rows[] = [
                $idx + 1,
                e($item->product->name ?? ($item->product_name ?? '-')),
                e($item->product->sku_number ?? '-'),
                e($item->product->productType->name ?? '-'),
                'Rp '.number_format($sales),
                'Rp '.number_format($hpp),
                number_format($qty),
                'Rp '.number_format($profit),
                number_format($item->average_margin ?? 0, 1).'%',
            ];
        }

        $avgMargin = $sumSales > 0 ? round(($sumProfit / $sumSales) * 100, 1) : 0;
        $totals = ['Total', '', '', '', 'Rp '.number_format($sumSales), 'Rp '.number_format($sumHpp), number_format($sumQty), 'Rp '.number_format($sumProfit), $avgMargin.'%'];
        $period = ($this->start_date && $this->end_date) ? date('d/m/Y', strtotime($this->start_date)).' - '.date('d/m/Y', strtotime($this->end_date)) : null;

        return $this->exportPDFResponse('laporan_laba_rugi_penjualan', 'Laporan Laba Rugi Penjualan Produk', $columns, $rows, 'landscape', $totals, $period);
    }

    public function render()
    {

        $transactionProduct = TransactionProduct::search($this->search)
            ->selectRaw('
            product_id,
            product_name,
            SUM(quantity) as total_quantity,
            SUM(price) as total_price,
            SUM(total) as total_penjualan,
            SUM(hpp_average) as total_hpp_average,
            SUM(hpp_total) as total_hpp_total,
            SUM(profit) as total_profit,
            AVG(margin) as average_margin
        ')
            ->where('company_id', auth()->user()->company_id)
            ->with('product:id,name,sku_number,product_type_id', 'product.productType:id,name')
            ->whereHas('transaction', function ($query) {
                $query->where('status', 'completed');

                if ($this->type) {
                    $query->where('type', $this->type);
                }
            })
            ->when($this->start_date && $this->end_date, function ($query) {
                $query->whereBetween('created_at', [
                    $this->start_date.' 00:00:00',
                    $this->end_date.' 23:59:59',
                ]);
            })
            ->when($this->product_id, function ($query) {
                $query->where('product_id', $this->product_id);
            })
            ->groupBy('product_id', 'product_name')
            ->orderBy('total_quantity', 'desc');

        return view('livewire.admin.report.profit-loss.admin-report-profit-loss-index', [
            'transactionProducts' => $transactionProduct->paginate($this->perPage),
        ])
            ->extends('layout.app')
            ->section('content');
    }
}
