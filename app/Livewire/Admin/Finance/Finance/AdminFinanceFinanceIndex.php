<?php

namespace App\Livewire\Admin\Finance\Finance;

use App\Helpers\AlertHelper;
use App\Models\Account\Account;
use App\Models\Account\AccountTransaction;
use App\Models\Finance\Finance;
use App\Models\Finance\FinanceItem;
use App\Models\Finance\FinancePayment;
use App\Models\Journal\Journal;
use Livewire\Component;
use Livewire\Attributes\Computed;
use Session;
use Livewire\WithPagination;

class AdminFinanceFinanceIndex extends Component
{
    use WithPagination;
    protected $paginationTheme = 'bootstrap';
    protected $queryString = [
        'search' => ['except' => ''],
        'date_from' => ['except' => ''],
        'date_to' => ['except' => ''],
        'type_filter' => ['except' => ''],
    ];
    public $search = '';
    public $perPage = 5;
    public $date_from = '';
    public $date_to = '';
    public $type_filter = '';
    public $finance_types = [
        'expenditure' => 'Pengeluaran',
        'reception' => 'Penerimaan',
        'fund-transfer' => 'Pemindahan Dana'
    ];

    public function mount()
    {
        Session::forget('finance_finance_id');
    }

    public function updatedDateFrom()
    {
        $this->resetPage();
    }

    public function updatedDateTo()
    {
        $this->resetPage();
    }

    public function updatedTypeFilter()
    {
        $this->resetPage();
    }

    public function resetFilters()
    {
        $this->date_from = '';
        $this->date_to = '';
        $this->type_filter = '';
        $this->search = '';
        $this->resetPage();
    }

    public function createFinance()
    {
        return redirect()->route('user.finance.finance.detail');
    }

    public function editFinance($financeId)
    {
        Session::put('finance_finance_id', $financeId);
        return redirect()->route('user.finance.finance.detail');
    }

    public function confirmDelete($financeId)
    {
        return AlertHelper::confirmDelete('delete', 'Apakah Anda yakin ingin menghapus data ini?', $financeId);
    }

    public function delete($id)
    {
        $finance = Finance::findOrFail($id[0]);

        $journal = Journal::where('finance_id', $finance->id)->first();
        if ($journal) {
            $journalItems = $journal->items;
            foreach ($journalItems as $journalItem) {
                $journalItem->delete();
            }
            $journal->delete();
        }

        $financePayments = FinancePayment::where('finance_id', $finance->id)->get();
        foreach ($financePayments as $financePayment) {
            $financePayment->delete();
        }

        $financeItems = FinanceItem::where('finance_id', $finance->id)->get();
        foreach ($financeItems as $financeItem) {
            $financeItem->delete();
        }

        $accountTransactions = AccountTransaction::where('finance_id', $finance->id)->get();
        foreach ($accountTransactions as $accountTransaction) {
            $accountTransaction->delete();
        }

        $finance->delete();

        return AlertHelper::success('Data berhasil dihapus.');
    }

    private function getBaseQuery()
    {
        $query = Finance::where('company_id', auth()->user()->company_id)
            ->whereIn('type', ['expenditure', 'reception', 'fund-transfer']);

        if ($this->date_from) {
            $query->whereDate('date', '>=', $this->date_from);
        }

        if ($this->date_to) {
            $query->whereDate('date', '<=', $this->date_to);
        }

        if ($this->type_filter) {
            $query->where('type', $this->type_filter);
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
    public function totalExpenditure()
    {
        return $this->getBaseQuery()
            ->where('type', 'expenditure')
            ->sum('grand_total') ?? 0;
    }

    #[Computed]
    public function totalReception()
    {
        return $this->getBaseQuery()
            ->where('type', 'reception')
            ->sum('grand_total') ?? 0;
    }

    #[Computed]
    public function totalFundTransfer()
    {
        return $this->getBaseQuery()
            ->where('type', 'fund-transfer')
            ->sum('grand_total') ?? 0;
    }

    public function render()
    {
        $finance = $this->getBaseQuery()
            ->select('id', 'code', 'date', 'type', 'description', 'sub_total', 'discount', 'tax', 'grand_total', 'company_id')
            ->orderBy('order', 'desc');

        return view('livewire.admin.finance.finance.admin-finance-finance-index', [
            'finances' => $finance->paginate($this->perPage)
        ])
            ->extends('layout.app')
            ->section('content');
    }
}
