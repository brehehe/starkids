<?php

namespace App\Livewire\Admin\Finance\GeneralJournal\Detail;

use App\Helpers\AlertHelper;
use App\Models\Account\Account;
use App\Models\Account\AccountTransaction;
use App\Models\Finance\Finance;
use App\Models\Journal\Journal;
use App\Models\Journal\JournalItem;
use Livewire\Component;

class AdminFinanceGeneralJournalDetailIndex extends Component
{
    public $journal_id;

    public $date;

    public $description;

    public $items = [];

    public function mount($id = null)
    {
        $this->journal_id = $id;

        if ($id) {
            $journal = Journal::with(['items.account', 'items.accountTransaction'])->findOrFail($id);
            $this->date = $journal->date;
            $this->description = $journal->description;

            foreach ($journal->items as $item) {
                $this->items[] = [
                    'id' => $item->id,
                    'account_id' => $item->account_id,
                    'debit' => $item->accountTransaction->debit ?? 0,
                    'credit' => $item->accountTransaction->credit ?? 0,
                ];
            }
        } else {
            $this->date = now()->format('Y-m-d');
            $this->addRow();
        }
    }

    public function addRow()
    {
        $this->items[] = [
            'id' => null,
            'account_id' => '',
            'debit' => 0,
            'credit' => 0,
        ];
    }

    public function removeRow($index)
    {
        unset($this->items[$index]);
        $this->items = array_values($this->items);
    }

    public function save()
    {
        $this->validate([
            'date' => 'required|date',
            'description' => 'required|string',
            'items' => 'required|array|min:2',
            'items.*.account_id' => 'required|exists:accounts,id',
            'items.*.debit' => 'required|numeric|min:0',
            'items.*.credit' => 'required|numeric|min:0',
        ]);

        // Validate balance
        $totalDebit = collect($this->items)->sum('debit');
        $totalCredit = collect($this->items)->sum('credit');

        if ($totalDebit != $totalCredit) {
            AlertHelper::error('Gagal', 'Total debit dan kredit harus sama');

            return;
        }

        try {
            \DB::transaction(function () {
                if ($this->journal_id) {
                    // Update existing journal
                    $journal = Journal::findOrFail($this->journal_id);
                    $journal->update([
                        'date' => $this->date,
                        'description' => $this->description,
                    ]);

                    // Delete old items and transactions
                    foreach ($journal->items as $item) {
                        $item->accountTransaction?->delete();
                        $item->delete();
                    }
                } else {
                    // Create new journal
                    $finance = Finance::where('company_id', auth()->user()->company_id)
                        ->whereDate('date', $this->date)
                        ->first();

                    if (! $finance) {
                        $finance = Finance::create([
                            'company_id' => auth()->user()->company_id,
                            'date' => $this->date,
                            'description' => 'Finance for '.$this->date,
                        ]);
                    }

                    $journal = Journal::create([
                        'finance_id' => $finance->id,
                        'journal_type' => 'general',
                        'date' => $this->date,
                        'description' => $this->description,
                        'company_id' => auth()->user()->company_id,
                    ]);
                }

                // Create new items and transactions
                foreach ($this->items as $itemData) {
                    $journalItem = JournalItem::create([
                        'journal_id' => $journal->id,
                        'finance_id' => $journal->finance_id,
                        'account_id' => $itemData['account_id'],
                        'company_id' => auth()->user()->company_id,
                    ]);

                    AccountTransaction::create([
                        'account_id' => $itemData['account_id'],
                        'finance_id' => $journal->finance_id,
                        'journal_item_id' => $journalItem->id,
                        'debit' => $itemData['debit'],
                        'credit' => $itemData['credit'],
                        'company_id' => auth()->user()->company_id,
                    ]);
                }
            });

            AlertHelper::success('Berhasil', 'Jurnal umum berhasil disimpan');

            return redirect()->route('user.finance.general-journal');
        } catch (\Exception $e) {
            AlertHelper::error('Gagal', 'Gagal menyimpan jurnal: '.$e->getMessage());
        }
    }

    public function render()
    {
        return view('livewire.admin.finance.general-journal.detail.admin-finance-general-journal-detail-index', [
            'accounts' => Account::where('company_id', auth()->user()->company_id)
                ->orderBy('name')
                ->get(),
        ])
            ->extends('layout.app')
            ->section('content');
    }
}
