<?php

namespace App\Livewire\Admin\Finance\StockOpname;

use App\Models\Finance\Finance;
use Livewire\Attributes\Computed;
use Livewire\Component;
use Livewire\WithPagination;
use Session;

class AdminFinanceStockOpnameIndex extends Component
{
    use WithPagination;

    protected $paginationTheme = 'bootstrap';

    protected $queryString = [
        'search' => ['except' => ''],
    ];

    public $search = '';

    public $perPage = 5;

    public $start_date;

    public $end_date;

    public function mount()
    {
        Session::forget('finance_stock_opname_id');
        $this->start_date = now()->startOfMonth()->toDateString();
        $this->end_date = now()->endOfMonth()->toDateString();
    }

    public function resetFilters()
    {
        $this->start_date = now()->startOfMonth()->toDateString();
        $this->end_date = now()->endOfMonth()->toDateString();
        $this->search = '';
        $this->resetPage();
    }

    private function getGlobalStatsQuery()
    {
        $query = Finance::where('company_id', auth()->user()->company_id)
            ->where('type', 'stock-opname');

        if ($this->start_date && $this->end_date) {
            $query->whereBetween('date', [$this->start_date, $this->end_date]);
        }

        if ($this->search) {
            $query->search($this->search);
        }

        return $query;
    }

    #[Computed]
    public function totalStockOpname()
    {
        return $this->getGlobalStatsQuery()->count();
    }

    #[Computed]
    public function totalLossValue()
    {
        return $this->getGlobalStatsQuery()->sum('total_loss_value') ?? 0;
    }

    #[Computed]
    public function totalExcessValue()
    {
        return $this->getGlobalStatsQuery()->sum('total_excess_value') ?? 0;
    }

    #[Computed]
    public function netValue()
    {
        // Net Value usually means (Excess - Loss) or just sum of diffs?
        // Assuming user wants Total Excess - Total Loss as a "Net Result"
        // OR simply sum of grand_total if grand_total represents the net value adjustment?
        // Let's stick to explicitly calculated Net: Excess - Loss
        return $this->totalExcessValue - $this->totalLossValue;
    }

    public function confirmDetail($financeId)
    {
        Session::put('finance_stock_opname_id', $financeId);

        return redirect()->route('user.finance.stock-opname.detail');
    }

    public function render()
    {
        $query = Finance::search($this->search)
            ->select('id', 'code', 'date', 'type', 'sub_total', 'discount', 'tax', 'grand_total', 'company_id', 'total_loss_value', 'total_excess_value')
            ->where('company_id', auth()->user()->company_id)
            ->where('type', 'stock-opname')
            ->orderBy('order', 'desc');

        if ($this->start_date && $this->end_date) {
            $query->whereBetween('date', [$this->start_date, $this->end_date]);
        }

        return view('livewire.admin.finance.stock-opname.admin-finance-stock-opname-index', [
            'finances' => $query->paginate($this->perPage),
        ])
            ->extends('layout.app')
            ->section('content');
    }
}
