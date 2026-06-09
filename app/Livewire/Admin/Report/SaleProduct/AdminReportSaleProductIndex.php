<?php

namespace App\Livewire\Admin\Report\SaleProduct;

use App\Models\Product\Product;
use App\Models\Product\ProductFactory;
use App\Models\Transaction\TransactionPayment;
use App\Models\Transaction\TransactionProduct;
use App\Traits\Product\ProductTrait;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Livewire\WithPagination;

class AdminReportSaleProductIndex extends Component
{
    use WithPagination, ProductTrait;
    protected $queryString = [
        // 'page' => ['except' => 1], // Ini akan menghapus ?page=1 dari URL
        'search' => ['except' => ''],
    ];
    public $search = '';
    public $perPage = 5;
    public $factorys = [], $factory_id;
    public $start_date, $end_date, $type, $products = [], $product_id;

    public $chartData = [];

    public function mount()
    {
        $this->start_date = Carbon::now()->subMonth()->startOfMonth()->format('Y-m-d');
        $this->end_date   = Carbon::now()->subMonth()->endOfMonth()->format('Y-m-d');

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
                $this->start_date . ' 00:00:00',
                $this->end_date . ' 23:59:59'
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

    public function render()
    {
        $transactionProduct = TransactionProduct::search($this->search)
            ->select('id', 'transaction_id', 'product_id', 'product_name', 'quantity', 'price', 'total', 'hpp_average', 'hpp_total', 'profit', 'margin')
            ->where('company_id', Auth::user()->company_id)
            ->with([
                'transaction:id,code,branch_id,company_id,patient_name,sub_total_price,discount_value,grand_total_price,type,status',
                'product:id,name,sku_number'
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
                $this->start_date . ' 00:00:00',
                $this->end_date . ' 23:59:59'
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
            ->section('content')
        ;
    }
}
