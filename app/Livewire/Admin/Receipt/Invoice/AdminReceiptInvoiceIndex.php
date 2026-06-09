<?php

namespace App\Livewire\Admin\Receipt\Invoice;

use App\Models\Transaction\Transaction;
use Livewire\Component;

class AdminReceiptInvoiceIndex extends Component
{
    public $transaction_id, $transaction;

    public function mount($transaction_id)
    {
        $this->transaction_id = $transaction_id;
        $this->transaction = Transaction::find($transaction_id);
    }

    public function render()
    {
        return view('livewire.admin.receipt.invoice.admin-receipt-invoice-index')
            ->extends('layout.receipt.invoice')
            ->section('content');
    }
}
