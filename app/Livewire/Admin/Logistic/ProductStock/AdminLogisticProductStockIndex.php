<?php

namespace App\Livewire\Admin\Logistic\ProductStock;

use App\Models\Product\ProductCategory;
use App\Models\Product\ProductFactory;
use App\Models\Product\ProductRack;
use App\Models\Product\ProductStockHistory;
use App\Models\Product\ProductType;
use App\Traits\Product\ProductStockTrait;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Livewire\WithPagination;

class AdminLogisticProductStockIndex extends Component
{
    use ProductStockTrait, WithPagination;

    protected $queryString = [
        'search' => ['except' => ''],
        'product_category_id' => ['except' => ''],
        'product_factory_id' => ['except' => ''],
        'product_rack_id' => ['except' => ''],
        'product_type_id' => ['except' => ''],
        'filter_type' => ['except' => 'monthly'],
        'month' => ['except' => ''],
        'year' => ['except' => ''],
        'start_date' => ['except' => ''],
        'end_date' => ['except' => ''],
    ];

    public $search = '';

    public $perPage = 5;

    // Filter properties
    public $product_category_id = '';

    public $product_factory_id = '';

    public $product_rack_id = '';

    public $product_type_id = '';

    // Date & Period Filter properties
    public $filter_type = 'monthly'; // 'monthly' or 'custom'

    public $month = '';

    public $year = '';

    public $start_date = '';

    public $end_date = '';

    public function mount()
    {
        // Default filter: tahun saat ini
        if (empty($this->year)) {
            $this->year = date('Y');
        }
    }

    // Reset pagination when filter changes
    public function updatedProductCategoryId()
    {
        $this->resetPage();
    }

    public function updatedProductFactoryId()
    {
        $this->resetPage();
    }

    public function updatedProductRackId()
    {
        $this->resetPage();
    }

    public function updatedProductTypeId()
    {
        $this->resetPage();
    }

    public function updatedSearch()
    {
        $this->resetPage();
    }

    public function updatedFilterType()
    {
        $this->resetPage();
    }

    public function updatedMonth()
    {
        $this->resetPage();
    }

    public function updatedYear()
    {
        $this->resetPage();
    }

    public function updatedStartDate()
    {
        $this->resetPage();
    }

    public function updatedEndDate()
    {
        $this->resetPage();
    }

    public function resetFilter()
    {
        $this->reset(['search', 'product_category_id', 'product_factory_id', 'product_rack_id', 'product_type_id', 'month', 'start_date', 'end_date']);
        $this->year = date('Y');
        $this->filter_type = 'monthly';
        $this->resetPage();
    }

    public function getDateRange(): array
    {
        if ($this->filter_type === 'monthly' && ! empty($this->month) && ! empty($this->year)) {
            $startDate = Carbon::createFromDate($this->year, $this->month, 1)->startOfMonth()->format('Y-m-d');
            $endDate = Carbon::createFromDate($this->year, $this->month, 1)->endOfMonth()->format('Y-m-d');

            return [$startDate, $endDate];
        } elseif ($this->filter_type === 'custom' && (! empty($this->start_date) || ! empty($this->end_date))) {
            $startDate = $this->start_date ? Carbon::parse($this->start_date)->format('Y-m-d') : null;
            $endDate = $this->end_date ? Carbon::parse($this->end_date)->format('Y-m-d') : null;

            return [$startDate, $endDate];
        }

        return [null, null];
    }

    public function getMonthsProperty(): array
    {
        return [
            '1' => 'Januari',
            '2' => 'Februari',
            '3' => 'Maret',
            '4' => 'April',
            '5' => 'Mei',
            '6' => 'Juni',
            '7' => 'Juli',
            '8' => 'Agustus',
            '9' => 'September',
            '10' => 'Oktober',
            '11' => 'November',
            '12' => 'Desember',
        ];
    }

    public function getYearsProperty(): array
    {
        $currentYear = (int) date('Y');
        $years = [];
        for ($y = $currentYear; $y >= $currentYear - 5; $y--) {
            $years[] = (string) $y;
        }

        return $years;
    }

    /**
     * Get summary statistics
     */
    public function getSummaryStats()
    {
        $query = $this->getProductStocksQuery();

        $stats = [
            'total_products' => 0,
            'total_quantity' => 0,
            'total_stock_value' => 0,
        ];

        $products = $query->get();

        $stats['total_products'] = $products->count();

        [$startDate, $endDate] = $this->getDateRange();

        foreach ($products as $product) {
            $quantity = $product->productStock->quantity ?? 0;
            $hppAverage = $product->productPrice->hpp_average ?? 0;

            // Jika filter tanggal/bulan aktif, hitung total persediaan stok di periode tersebut dari riwayat stok jika ada
            if ($startDate && $endDate) {
                $historyQty = ProductStockHistory::where('product_id', $product->id)
                    ->whereBetween('created_at', [$startDate.' 00:00:00', $endDate.' 23:59:59'])
                    ->selectRaw("SUM(CASE WHEN type = 'in' THEN quantity ELSE -quantity END) as net_qty")
                    ->value('net_qty');

                if ($historyQty !== null) {
                    $quantity = max(0, (int) $historyQty);
                }
            }

            $stats['total_quantity'] += $quantity;
            $stats['total_stock_value'] += ($quantity * $hppAverage);
        }

        return $stats;
    }

    public function render()
    {
        return view(
            'livewire.admin.logistic.product-stock.admin-logistic-product-stock-index',
            [
                'products' => $this->getProductStocks(),
                'summaryStats' => $this->getSummaryStats(),
                'productCategories' => ProductCategory::where('company_id', Auth::user()->company_id)
                    ->orderBy('name', 'asc')
                    ->get(),
                'productFactories' => ProductFactory::where('company_id', Auth::user()->company_id)
                    ->orderBy('name', 'asc')
                    ->get(),
                'productRacks' => ProductRack::where('company_id', Auth::user()->company_id)
                    ->orderBy('name', 'asc')
                    ->get(),
                'productTypes' => ProductType::orderBy('name', 'asc')->get(),
            ]
        )
            ->extends('layout.app')
            ->section('content');
    }
}
