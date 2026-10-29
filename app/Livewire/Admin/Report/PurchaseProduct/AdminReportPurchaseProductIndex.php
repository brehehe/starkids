<?php

namespace App\Livewire\Admin\Report\PurchaseProduct;

use App\Models\PurchaseOrder\PurchaseOrderItem;
use App\Traits\Product\ProductStockTrait;
use App\Traits\Product\ProductTrait;
use App\Traits\Report\HasReportExportTrait;
use Livewire\Component;
use Livewire\WithPagination;

class AdminReportPurchaseProductIndex extends Component
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
        return PurchaseOrderItem::search($this->search)
            ->with(['product'])
            ->when($this->start_date, function ($query, $start_date) {
                $query->whereDate('created_at', '>=', $start_date);
            })
            ->when($this->end_date, function ($query, $end_date) {
                $query->whereDate('created_at', '<=', $end_date);
            });
    }

    public function exportExcel()
    {
        $items = $this->getFilteredQuery()->get();
        $headings = ['No', 'Nama Produk', 'Kuantitas', 'Harga (HNA)', 'Pajak (PPN)', 'Sub Total'];
        $rows = [];

        foreach ($items as $idx => $item) {
            $rows[] = [
                $idx + 1,
                $item->product->name ?? '-',
                $item->quantity ?? 0,
                $item->hna ?? 0,
                $item->ppn ?? 0,
                $item->sub_total ?? 0,
            ];
        }

        return $this->exportExcelResponse('laporan_pembelian_produk', $headings, $rows, 'Pembelian Produk');
    }

    public function exportPDF()
    {
        $items = $this->getFilteredQuery()->get();
        $columns = [
            ['label' => 'No', 'align' => 'center', 'width' => '30px'],
            ['label' => 'Nama Produk', 'align' => 'left'],
            ['label' => 'Kuantitas', 'align' => 'center', 'width' => '60px'],
            ['label' => 'Harga (HNA)', 'align' => 'right', 'width' => '85px'],
            ['label' => 'PPN', 'align' => 'right', 'width' => '75px'],
            ['label' => 'Sub Total', 'align' => 'right', 'width' => '90px'],
        ];

        $rows = [];
        $totalQty = 0;
        $totalSum = 0;

        foreach ($items as $idx => $item) {
            $qty = (float) ($item->quantity ?? 0);
            $subTotal = (float) ($item->sub_total ?? 0);
            $totalQty += $qty;
            $totalSum += $subTotal;

            $rows[] = [
                $idx + 1,
                e($item->product->name ?? '-'),
                number_format($qty),
                'Rp '.number_format($item->hna ?? 0),
                'Rp '.number_format($item->ppn ?? 0),
                'Rp '.number_format($subTotal),
            ];
        }

        $totals = ['Total', '', number_format($totalQty), '', '', 'Rp '.number_format($totalSum)];

        return $this->exportPDFResponse('laporan_pembelian_produk', 'Laporan Pembelian Produk', $columns, $rows, 'portrait', $totals);
    }

    public function render()
    {
        $purchaseProduct = PurchaseOrderItem::search($this->search)
            ->with(['product'])
            ->when($this->start_date, function ($query, $start_date) {
                $query->whereDate('created_at', '>=', $start_date);
            })
            ->when($this->end_date, function ($query, $end_date) {
                $query->whereDate('created_at', '<=', $end_date);
            })
            ->paginate($this->perPage);

        return view('livewire.admin.report.purchase-product.admin-report-purchase-product-index', [
            'purchaseProducts' => $purchaseProduct,
        ])
            ->extends('layout.app')
            ->section('content');
    }
}
