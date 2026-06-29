<?php

namespace App\Livewire\Admin\Finance\GeneralJournal;

use App\Models\Journal\Journal;
use Livewire\Attributes\Computed;
use Livewire\Component;
use Livewire\WithPagination;

class AdminFinanceGeneralJournalIndex extends Component
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
        $this->start_date = now()->startOfMonth()->format('Y-m-d');
        $this->end_date = now()->endOfMonth()->format('Y-m-d');
    }

    public function hydrate()
    {
        $this->resetPage();
    }

    public function resetFilters()
    {
        $this->start_date = now()->startOfMonth()->format('Y-m-d');
        $this->end_date = now()->endOfMonth()->format('Y-m-d');
        $this->search = '';
        $this->resetPage();
    }

    public function delete($id)
    {
        try {
            $journal = Journal::findOrFail($id);

            // Delete journal items and their account transactions
            foreach ($journal->items as $item) {
                $item->accountTransaction?->delete();
                $item->delete();
            }

            $journal->delete();

            $this->dispatch('success', message: 'Jurnal umum berhasil dihapus');
        } catch (\Exception $e) {
            $this->dispatch('error', message: 'Gagal menghapus jurnal: '.$e->getMessage());
        }
    }

    private function getBaseQuery()
    {
        $query = Journal::general()
            ->search($this->search)
            ->where('company_id', auth()->user()->company_id)
            ->select([
                'id',
                'code',
                'date',
                'description',
            ])
            ->with(['items' => function ($query) {
                $query->select([
                    'id',
                    'journal_id',
                    'account_id',
                ]);
            }, 'items.account', 'items.accountTransaction'])
            ->orderBy('order', 'desc');

        if ($this->start_date && $this->end_date) {
            $query->whereBetween('date', [$this->start_date, $this->end_date]);
        }

        return $query;
    }

    #[Computed]
    public function totalJournals()
    {
        return $this->getBaseQuery()->count();
    }

    #[Computed]
    public function totalDebit()
    {
        $journals = $this->getBaseQuery()->get();

        return $journals->sum(fn ($journal) => $journal->items->sum(fn ($item) => $item->accountTransaction->debit ?? 0));
    }

    #[Computed]
    public function totalCredit()
    {
        $journals = $this->getBaseQuery()->get();

        return $journals->sum(fn ($journal) => $journal->items->sum(fn ($item) => $item->accountTransaction->credit ?? 0));
    }

    #[Computed]
    public function balance()
    {
        return $this->totalDebit - $this->totalCredit;
    }

    public function render()
    {
        return view('livewire.admin.finance.general-journal.admin-finance-general-journal-index', [
            'journals' => $this->getBaseQuery()->paginate($this->perPage),
        ])
            ->extends('layout.app')
            ->section('content');
    }
}
