<?php

namespace App\Livewire\Admin\Report\SaleProduct;

use App\Models\Product\Product;
use App\Models\Product\ProductFactory;
use App\Models\Transaction\TransactionProduct;
use App\Traits\Product\ProductTrait;
use App\Traits\Report\HasReportExportTrait;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Livewire\Component;
use Livewire\WithPagination;

class AdminReportSaleProductIndex extends Component
{
    use HasReportExportTrait, ProductTrait, WithPagination;

    protected $queryString = [
        // 'page' => ['except' => 1], // Ini akan menghapus ?page=1 dari URL
        'search' => ['except' => ''],
    ];

    public $search = '';

    public $perPage = 5;

    public $factorys = [];

    public $factory_id;

    public $start_date;

    public $end_date;

    public $type;

    public $products = [];

    public $product_id;

    public $chartData = [];

    public function mount()
    {
        $this->start_date = Carbon::now()->subMonth()->startOfMonth()->format('Y-m-d');
        $this->end_date = Carbon::now()->subMonth()->endOfMonth()->format('Y-m-d');

        $this->products = Product::select('id', 'name', 'sku_number')
            ->where('company_id', Auth::user()->company_id)
            ->orderBy('name', 'asc')
            ->get()
            ->toArray();
        $this->factorys = ProductFactory::select('id', 'name')->where('company_id', Auth::user()->company_id)
            ->orderBy('name', 'asc')
            ->get()
            ->pluck('name', 'id')
            ->toArray();

        // Initialize chart data
        $this->chartData = $this->buildChartData();
    }

    public function hydrate()
    {
        $this->resetPage();
    }

    private function getTopProducts($limit = 10)
    {
        $query = TransactionProduct::select('product_id', 'product_name')
            ->selectRaw('SUM(quantity) as total_quantity')
            ->selectRaw('SUM(total) as total_sales')
            ->selectRaw('COUNT(*) as transaction_count')
            ->where('company_id', Auth::user()->company_id)
            ->with(['product:id,name,sku_number'])
            ->whereHas('transaction', function ($query) {
                $query->where('status', 'completed');

                if ($this->type) {
                    $query->where('type', $this->type);
                }
            })
            ->groupBy('product_id', 'product_name')
            ->orderBy('total_sales', 'desc');

        if ($this->start_date && $this->end_date) {
            $query->whereBetween('created_at', [
                $this->start_date.' 00:00:00',
                $this->end_date.' 23:59:59',
            ]);
        }

        if ($this->factory_id) {
            $product = Product::where('company_id', Auth::user()->company_id)
                ->where('product_factory_id', $this->factory_id)
                ->get()->pluck('id')->toArray();

            $query->whereIn('product_id', $product);
        }

        if ($this->product_id) {
            $query->where('product_id', $this->product_id);
        }

        return $query->limit($limit)->get();
    }

    private function buildChartData()
    {
        $topProducts = $this->getTopProducts(5); // Get top 5 for chart

        return [
            'labels' => $topProducts->pluck('product_name')->toArray(),
            'salesData' => $topProducts->pluck('total_sales')->toArray(),
            'quantityData' => $topProducts->pluck('total_quantity')->toArray(),
        ];
    }

    public function getChartData()
    {
        return $this->buildChartData();
    }

    protected function getFilteredQuery()
    {
        $transactionProduct = TransactionProduct::search($this->search)
            ->select('id', 'transaction_id', 'product_id', 'product_name', 'quantity', 'price', 'total', 'hpp_average', 'hpp_total', 'profit', 'margin', 'created_at')
            ->where('company_id', Auth::user()->company_id)
            ->with([
                'transaction:id,code,branch_id,company_id,patient_name,sub_total_price,discount_value,grand_total_price,type,status',
                'product:id,name,sku_number',
            ])
            ->whereHas('transaction', function ($query) {
                $query->where('status', 'completed');

                if ($this->type) {
                    $query->where('type', $this->type);
                }
            })
            ->orderBy('order', 'desc');

        if ($this->start_date && $this->end_date) {
            $transactionProduct->whereBetween('created_at', [
                $this->start_date.' 00:00:00',
                $this->end_date.' 23:59:59',
            ]);
        }

        if ($this->factory_id) {
            $product = Product::where('company_id', Auth::user()->company_id)
                ->where('product_factory_id', $this->factory_id)
                ->get()->pluck('id')->toArray();

            $transactionProduct->whereIn('product_id', $product);
        }

        if ($this->product_id) {
            $transactionProduct->where('product_id', $this->product_id);
        }

        return $transactionProduct;
    }

    public function exportExcel()
    {
        $items = $this->getFilteredQuery()->get();
        $headings = ['No', 'Nama Produk', 'SKU', 'Harga Satuan', 'Kode Transaksi', 'Tipe Transaksi', 'Quantity', 'Sub Total', 'Tanggal'];
        $rows = [];

        foreach ($items as $idx => $item) {
            $rows[] = [
                $idx + 1,
                $item->product->name ?? ($item->product_name ?? '-'),
                $item->product->sku_number ?? '-',
                $item->price ?? 0,
                $item->transaction->code ?? '-',
                Str::title(Str::replace('-', ' ', $item->transaction->type ?? '-')),
                $item->quantity ?? 0,
                $item->total ?? 0,
                $item->created_at ? $item->created_at->format('d/m/Y') : '-',
            ];
        }

        return $this->exportExcelResponse('laporan_penjualan_produk', $headings, $rows, 'Penjualan Produk');
    }

    public function exportPDF()
    {
        $items = $this->getFilteredQuery()->get();
        $columns = [
            ['label' => 'No', 'align' => 'center', 'width' => '30px'],
            ['label' => 'Nama Produk', 'align' => 'left'],
            ['label' => 'Harga', 'align' => 'right', 'width' => '75px'],
            ['label' => 'No Transaksi', 'align' => 'left', 'width' => '90px'],
            ['label' => 'Tipe', 'align' => 'center', 'width' => '70px'],
            ['label' => 'Qty', 'align' => 'center', 'width' => '45px'],
            ['label' => 'Total', 'align' => 'right', 'width' => '85px'],
        ];

        $rows = [];
        $totalQty = 0;
        $totalSum = 0;

        foreach ($items as $idx => $item) {
            $qty = (float) ($item->quantity ?? 0);
            $total = (float) ($item->total ?? 0);
            $totalQty += $qty;
            $totalSum += $total;

            $rows[] = [
                $idx + 1,
                e($item->product->name ?? ($item->product_name ?? '-')),
                'Rp '.number_format($item->price ?? 0),
                e($item->transaction->code ?? '-'),
                Str::title(Str::replace('-', ' ', $item->transaction->type ?? '-')),
                number_format($qty),
                'Rp '.number_format($total),
            ];
        }

        $totals = ['Total', '', '', '', '', number_format($totalQty), 'Rp '.number_format($totalSum)];
        $period = ($this->start_date && $this->end_date) ? date('d/m/Y', strtotime($this->start_date)).' - '.date('d/m/Y', strtotime($this->end_date)) : null;

        return $this->exportPDFResponse('laporan_penjualan_produk', 'Laporan Penjualan Produk', $columns, $rows, 'portrait', $totals, $period);
    }

    public function render()
    {
        $transactionProduct = TransactionProduct::search($this->search)
            ->select('id', 'transaction_id', 'product_id', 'product_name', 'quantity', 'price', 'total', 'hpp_average', 'hpp_total', 'profit', 'margin')
            ->where('company_id', Auth::user()->company_id)
            ->with([
                'transaction:id,code,branch_id,company_id,patient_name,sub_total_price,discount_value,grand_total_price,type,status',
                'product:id,name,sku_number',
            ])
            ->whereHas('transaction', function ($query) {
                $query->where('status', 'completed');

                if ($this->type) {
                    $query->where('type', $this->type);
                }
            })
            ->orderBy('order', 'desc');

        if ($this->start_date && $this->end_date) {
            $transactionProduct->whereBetween('created_at', [
                $this->start_date.' 00:00:00',
                $this->end_date.' 23:59:59',
            ]);
        }

        if ($this->factory_id) {
            $product = Product::where('company_id', Auth::user()->company_id)
                ->where('product_factory_id', $this->factory_id)
                ->get()->pluck('id')->toArray();

            $transactionProduct->whereIn('product_id', $product);
        }

        if ($this->product_id) {
            $transactionProduct->where('product_id', $this->product_id);
        }

        // Get top products data
        $topProducts = $this->getTopProducts();
        $this->chartData = $this->buildChartData();

        return view('livewire.admin.report.sale-product.admin-report-sale-product-index', [
            'transactionProducts' => $transactionProduct->paginate($this->perPage),
            'topProducts' => $topProducts,
            'chartData' => $this->chartData,
        ])
            ->extends('layout.app')
            ->section('content');
    }
}
