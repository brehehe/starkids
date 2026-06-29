<?php

namespace App\Livewire\Admin\Finance\Ledger;

use App\Models\Account\Account;
use App\Models\Account\AccountTransaction;
use Livewire\Attributes\Computed;
use Livewire\Component;
use Livewire\WithPagination;

class AdminFinanceLedgerIndex extends Component
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

    public $account_id;

    public $accountOptions = [];

    public function mount()
    {
        $this->accountOptions = Account::where('company_id', auth()->user()->company_id)
            ->orderBy('code', 'asc')
            ->get()
            ->pluck('name', 'id')
            ->toArray();

        $this->start_date = now()->startOfMonth()->toDateString();
        $this->end_date = now()->endOfMonth()->toDateString();
    }

    public function hydrate()
    {
        $this->resetPage();
    }

    public function resetFilters()
    {
        $this->start_date = now()->startOfMonth()->toDateString();
        $this->end_date = now()->endOfMonth()->toDateString();
        $this->account_id = null;
        $this->search = '';
        $this->resetPage();
    }

    private function getAccountsQuery()
    {
        $query = Account::where('company_id', auth()->user()->company_id)
            ->whereHas('accountTransactions', function ($q) {
                if ($this->start_date && $this->end_date) {
                    $q->whereBetween('date', [$this->start_date, $this->end_date]);
                }
                if ($this->search) {
                    $q->search($this->search);
                }
            })
            ->with(['accountTransactions' => function ($q) {
                if ($this->start_date && $this->end_date) {
                    $q->whereBetween('date', [$this->start_date, $this->end_date]);
                }
                if ($this->search) {
                    $q->search($this->search);
                }
                $q->orderBy('date', 'desc');
            }]);

        if ($this->account_id) {
            $query->where('id', $this->account_id);
        }

        return $query;
    }

    private function getGlobalStatsQuery()
    {
        $query = AccountTransaction::where('company_id', auth()->user()->company_id);

        if ($this->start_date && $this->end_date) {
            $query->whereBetween('date', [$this->start_date, $this->end_date]);
        }

        if ($this->account_id) {
            $query->where('account_id', $this->account_id);
        }

        if ($this->search) {
            $query->search($this->search);
        }

        return $query;
    }

    #[Computed]
    public function totalTransactions()
    {
        return $this->getGlobalStatsQuery()->count();
    }

    #[Computed]
    public function totalDebit()
    {
        return $this->getGlobalStatsQuery()->sum('debit') ?? 0;
    }

    #[Computed]
    public function totalCredit()
    {
        return $this->getGlobalStatsQuery()->sum('credit') ?? 0;
    }

    #[Computed]
    public function balance()
    {
        return $this->totalDebit - $this->totalCredit;
    }

    public function render()
    {
        return view('livewire.admin.finance.ledger.admin-finance-ledger-index', [
            'accounts' => $this->getAccountsQuery()->paginate($this->perPage),
        ])
            ->extends('layout.app')
            ->section('content');
    }
}
