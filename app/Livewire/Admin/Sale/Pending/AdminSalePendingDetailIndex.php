<?php

namespace App\Livewire\Admin\Sale\Pending;

use App\Helpers\AlertHelper;
use App\Models\PaymentMethod\PaymentMethod;
use App\Models\Transaction\Transaction;
use App\Models\Transaction\TransactionPayment;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Livewire\Component;

class AdminSalePendingDetailIndex extends Component
{
    public $transaction_id;

    public $transaction;

    public $payment_method_id;

    public $payment_amount;

    public $admin_fee = 0;

    public $description;

    public function mount($transaction_id)
    {
        $this->transaction_id = $transaction_id;
        $this->loadTransaction();
        $this->suggestPayment();
    }

    public function loadTransaction()
    {
        $this->transaction = Transaction::with([
            'transactionPayments.paymentMethod',
            'transactionInstallments',
            'patient',
        ])->find($this->transaction_id);

        if (! $this->transaction) {
            return redirect()->route('user.sale.pending')->with('error', 'Transaksi tidak ditemukan.');
        }
    }

    public function suggestPayment()
    {
        $remaining = $this->transaction->remaining_bill;

        if ($this->transaction->installment_count > 0 && $remaining > 0) {
            $paidCount = $this->transaction->transactionPayments->where('is_down_payment', false)->count();
            $remainingTenor = max(1, $this->transaction->installment_count - $paidCount);
            $suggested = $remaining / $remainingTenor;
            $this->payment_amount = number_format($suggested, 0, ',', '.');
        } else {
            $this->payment_amount = number_format($remaining, 0, ',', '.');
        }
    }

    public function submitPayment()
    {
        $this->validate([
            'payment_method_id' => 'required',
            'payment_amount' => 'required',
        ]);

        $payment_amount = intval(Str::replace('.', '', $this->payment_amount));

        if ($payment_amount <= 0) {
            return AlertHelper::error('Gagal', 'Jumlah pembayaran tidak boleh kurang dari 1.');
        }

        $admin_fee = intval(Str::replace('.', '', $this->admin_fee));

        TransactionPayment::create([
            'user_id' => $this->transaction->patient_id ?? Auth::id(),
            'transaction_id' => $this->transaction_id,
            'payment_method_id' => $this->payment_method_id,
            'description' => $this->description,
            'payment_amount' => $payment_amount,
            'admin_fee' => $admin_fee,
            'payment_real' => $payment_amount + $admin_fee,
            'company_id' => Auth::user()->company_id,
        ]);

        // Update transaction logic (re-sync from Index component)
        $this->transaction->refresh();
        $totalPaid = $this->transaction->transactionPayments()->sum('payment_amount');

        $updateData = [
            'payment_amount' => $totalPaid,
            'payment_change' => max(0, $totalPaid - $this->transaction->grand_total_price),
            'remaining_bill' => max(0, $this->transaction->grand_total_price - $totalPaid),
        ];

        if ($updateData['remaining_bill'] <= 0) {
            $updateData['status_payment'] = 'paid';
            $updateData['is_pending_payment'] = false;
        } else {
            $updateData['status_payment'] = 'partial';
        }

        $this->transaction->update($updateData);

        // Update installments status
        $this->updateInstallmentsStatus($payment_amount);

        $this->loadTransaction();
        $this->suggestPayment();
        $this->reset(['payment_method_id', 'description', 'admin_fee']);

        return AlertHelper::success('Berhasil', 'Pembayaran berhasil ditambahkan.');
    }

    private function updateInstallmentsStatus($paymentAmount)
    {
        $unpaidInstallments = $this->transaction->transactionInstallments()
            ->where('status', 'unpaid')
            ->orderBy('tenor', 'asc')
            ->get();

        $remainingToAllocate = $paymentAmount;

        foreach ($unpaidInstallments as $installment) {
            if ($remainingToAllocate >= $installment->amount) {
                $installment->update([
                    'status' => 'paid',
                    'paid_at' => now(),
                ]);
                $remainingToAllocate -= $installment->amount;
            } else {
                break;
            }
        }
    }

    public function render()
    {
        $paymentMethods = PaymentMethod::where('company_id', Auth::user()->company_id)->get();

        return view('livewire.admin.sale.pending.admin-sale-pending-detail-index', [
            'paymentMethods' => $paymentMethods,
        ])
            ->extends('layout.app')
            ->section('content');
    }
}
