<?php

namespace App\Livewire\Admin\Report\Action;

use App\Models\Product\Product;
use App\Models\Transaction\TransactionDetail;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Livewire\Component;
use Livewire\WithPagination;

class AdminReportActionIndex extends Component
{
    use WithPagination;

    public $nurse_id;

    public $doctor_id;

    public $product_id;

    public $perPage = 10;

    public $nurses = [];

    public $doctors = [];

    public $products = [];

    protected $queryString = [
        'nurse_id' => ['except' => ''],
        'doctor_id' => ['except' => ''],
        'product_id' => ['except' => ''],
    ];

    public function mount()
    {
        $this->nurses = User::whereIn('id', TransactionDetail::whereNotNull('nurse_id')->distinct()->pluck('nurse_id'))
            ->select('id', 'name')
            ->orderBy('name')
            ->get();

        $this->doctors = User::whereIn('id', TransactionDetail::whereNotNull('doctor_id')->distinct()->pluck('doctor_id'))
            ->select('id', 'name')
            ->orderBy('name')
            ->get();

        $this->products = Product::whereIn('id', TransactionDetail::whereNotNull('product_id')
            ->whereNull('transaction_recipe_id')
            ->whereNull('odontogram_code')
            ->distinct()
            ->pluck('product_id'))
            ->select('id', 'name')
            ->orderBy('name')
            ->get();
    }

    public function render()
    {
        $baseQuery = TransactionDetail::query()
            ->whereNull('transaction_recipe_id')
            ->whereNull('odontogram_code')
            ->when($this->nurse_id, function ($query) {
                $query->where('nurse_id', $this->nurse_id);
            })
            ->when($this->doctor_id, function ($query) {
                $query->where('doctor_id', $this->doctor_id);
            })
            ->when($this->product_id, function ($query) {
                $query->where('product_id', $this->product_id);
            });

        // 1. Pagination Details
        $details = (clone $baseQuery)
            ->with(['product:id,sku_number,name,description,company_id', 'nurse:id,name', 'doctor:id,name', 'transaction:id,code,created_at'])
            ->orderBy('created_at', 'desc')
            ->paginate($this->perPage);

        // 2. Chart Quantity
        $topQty = (clone $baseQuery)
            ->select('product_id', 'name', DB::raw('SUM(quantity) as total_quantity'))
            ->groupBy('product_id', 'name')
            ->orderByDesc('total_quantity')
            ->limit(10)
            ->with('product:id,name')
            ->get();
        $chartQtyLabels = $topQty->map(fn ($i) => $i->product->name ?? $i->name)->toArray();
        $chartQtyData = $topQty->map(fn ($i) => (int) $i->total_quantity)->toArray();

        // 3. Chart Revenue
        $topRev = (clone $baseQuery)
            ->select('product_id', 'name', DB::raw('SUM(sub_total_price) as total_revenue'))
            ->groupBy('product_id', 'name')
            ->orderByDesc('total_revenue')
            ->limit(10)
            ->with('product:id,name')
            ->get();
        $chartRevLabels = $topRev->map(fn ($i) => $i->product->name ?? $i->name)->toArray();
        $chartRevData = $topRev->map(fn ($i) => (float) $i->total_revenue)->toArray();

        // Pass event so Chart.js runs again
        $this->dispatch('update-charts', [
            'qtyLabels' => $chartQtyLabels,
            'qtyData' => $chartQtyData,
            'revLabels' => $chartRevLabels,
            'revData' => $chartRevData,
        ]);

        return view('livewire.admin.report.action.admin-report-action-index', [
            'details' => $details,
            'chartQtyLabels' => $chartQtyLabels,
            'chartQtyData' => $chartQtyData,
            'chartRevLabels' => $chartRevLabels,
            'chartRevData' => $chartRevData,
        ])
            ->extends('layout.app')
            ->section('content');
    }
}
