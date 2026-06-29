<?php

namespace App\Livewire\Admin\Sale\Pending\Print;

use App\Models\Transaction\TransactionPayment;
use Livewire\Component;

class AdminSalePendingPaymentReceiptIndex extends Component
{
    public $payment_id;

    public $payment;

    public function mount($payment_id)
    {
        $this->payment_id = $payment_id;
        $this->payment = TransactionPayment::with(['transaction.patient', 'paymentMethod'])->find($payment_id);

        if (! $this->payment) {
            abort(404, 'Payment not found');
        }
    }

    public function render()
    {
        return view('livewire.admin.sale.pending.print.payment-receipt')
            ->extends('layout.receipt.receipt')
            ->section('content');
    }
}
