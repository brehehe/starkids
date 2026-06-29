<?php

namespace App\Livewire\Admin\Receipt\Recipe;

use App\Models\Transaction\Transaction;
use App\Models\Transaction\TransactionDiagnosis;
use App\Models\User;
use Livewire\Component;

class AdminReceiptRecipeIndex extends Component
{
    public $transaction_id;

    public $transaction;

    public $transactionDiagnosas;

    public function mount($transaction_id)
    {
        $this->transaction_id = $transaction_id;
        $this->transaction = Transaction::find($transaction_id);
        $this->transactionDiagnosas = TransactionDiagnosis::where('transaction_id', $transaction_id)->first();

        if (! $this->transaction) {
            abort(404, 'Transaction not found');
        }
    }

    public function render()
    {
        $user = User::role(['Apoteker'])->where('is_head', true)->first();

        if (! $user) {
            $user = User::find(Auth::user()->id);
        }

        return view('livewire.admin.receipt.recipe.admin-receipt-recipe-index', [
            'user' => $user,
        ])
            ->extends('layout.receipt.prescription')
            ->section('content');
    }
}
