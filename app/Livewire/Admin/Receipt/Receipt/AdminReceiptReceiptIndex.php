<?php

namespace App\Livewire\Admin\Receipt\Receipt;

use App\Models\Transaction\Transaction;
use App\Models\Transaction\TransactionDiagnosis;
use Livewire\Component;

class AdminReceiptReceiptIndex extends Component
{
    public $transaction_id;

    public $transaction;

    public $description;

    public $transactionDiagnosas;

    public function mount($transaction_id)
    {
        $this->transaction_id = $transaction_id;
        $this->transaction = Transaction::find($transaction_id);

        $this->description = $this->transaction->type == 'konsultasi' ? ($this->transaction->transactionDetails->count() > 0 ? 'Pembayaran Untuk Pemeriksaan dan Obat' : 'Pembayaran Untuk Pemeriksaan') : ($this->transaction->type == 'resep' ? 'Pembayaran Untuk Resep' : 'Pembayaran Untuk Obat');

        $this->transactionDiagnosas = TransactionDiagnosis::where('transaction_id', $transaction_id)->first();

        if (! $this->transaction) {
            abort(404, 'Transaction not found');
        }
    }

    public function render()
    {
        return view('livewire.admin.receipt.receipt.admin-receipt-receipt-index')
            ->extends('layout.receipt.receipt')
            ->section('content');
    }
}
