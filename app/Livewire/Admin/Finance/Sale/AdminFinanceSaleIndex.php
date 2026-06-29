<?php

namespace App\Livewire\Admin\Finance\Sale;

use App\Models\Finance\Finance;
use Livewire\Attributes\Computed;
use Livewire\Component;
use Livewire\WithPagination;
use Session;

class AdminFinanceSaleIndex extends Component
{
    use WithPagination;

    protected $paginationTheme = 'bootstrap';

    protected $queryString = [
        'search' => ['except' => ''],
        'date_from' => ['except' => ''],
        'date_to' => ['except' => ''],
    ];

    public $search = '';

    public $perPage = 5;

    public $get_statuss = ['draft', 'confirmed'];

    public $status;

    public $date_from = '';

    public $date_to = '';

    public function mount()
    {
        Session::forget('finance_sale_id');
        $this->changeStatus('draft');
    }

    public function changeStatus($status)
    {
        $this->status = $status;
        $this->resetPage();
    }

    public function updatedDateFrom()
    {
        $this->resetPage();
    }

    public function updatedDateTo()
    {
        $this->resetPage();
    }

    public function resetFilters()
    {
        $this->date_from = '';
        $this->date_to = '';
        $this->search = '';
        $this->resetPage();
    }

    public function editFinance($financeId)
    {
        Session::put('finance_sale_id', $financeId);

        return redirect()->route('user.finance.sale.detail');
    }

    private function getBaseQuery()
    {
        $query = Finance::where('company_id', auth()->user()->company_id)
            ->where('type', 'sale');

        if ($this->status) {
            $query->where('status', $this->status);
        }

        if ($this->date_from) {
            $query->whereDate('date', '>=', $this->date_from);
        }

        if ($this->date_to) {
            $query->whereDate('date', '<=', $this->date_to);
        }

        if ($this->search) {
            $query->search($this->search);
        }

        return $query;
    }

    #[Computed]
    public function totalCount()
    {
        return $this->getBaseQuery()->count();
    }

    #[Computed]
    public function totalGrandTotal()
    {
        return $this->getBaseQuery()->sum('grand_total') ?? 0;
    }

    #[Computed]
    public function averageTransaction()
    {
        $count = $this->totalCount;

        return $count > 0 ? $this->totalGrandTotal / $count : 0;
    }

    public function render()
    {
        $finance = $this->getBaseQuery()
            ->select('id', 'code', 'date', 'type', 'description', 'sub_total', 'discount', 'tax', 'grand_total', 'company_id', 'status')
            ->orderBy('order', 'desc');

        return view('livewire.admin.finance.sale.admin-finance-sale-index', [
            'finances' => $finance->paginate($this->perPage),
        ])
            ->extends('layout.app')
            ->section('content');
    }
}
