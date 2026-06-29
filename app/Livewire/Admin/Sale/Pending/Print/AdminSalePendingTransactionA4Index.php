<?php

namespace App\Livewire\Admin\Sale\Pending\Print;

use App\Models\Transaction\Transaction;
use Livewire\Component;

class AdminSalePendingTransactionA4Index extends Component
{
    public $transaction_id;

    public $transaction;

    public function mount($transaction_id)
    {
        $this->transaction_id = $transaction_id;
        $this->transaction = Transaction::with([
            'patient',
            'transactionPayments.paymentMethod',
            'transactionInstallments',
            'transactionDetails.product',
            'transactionRecipes.product',
        ])->find($transaction_id);

        if (! $this->transaction) {
            abort(404, 'Transaction not found');
        }
    }

    public function render()
    {
        return view('livewire.admin.sale.pending.print.transaction-a4')
            ->extends('layout.receipt.a4')
            ->section('content');
    }
}
