<?php

namespace App\Livewire\Admin\Sale\Pending;

use App\Helpers\AlertHelper;
use App\Models\PaymentMethod\PaymentMethod;
use App\Models\Transaction\Transaction;
use App\Models\Transaction\TransactionPayment;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Livewire\Component;
use Livewire\WithPagination;

class AdminSalePendingIndex extends Component
{
    use WithPagination;

    public $status_payment = 'draft';

    public $search = '';

    // Payment properties
    public $transaction_id;

    public $transaction;

    public $payment_method_id;

    public $payment_amount;

    public $admin_fee = 0;

    public $description;

    public $is_single_payment = true; // Default true as per user request "hanya satu saja"

    public $perPage = 10;

    protected $queryString = [
        'status_payment' => ['except' => 'draft'],
        'search' => ['except' => ''],
        'perPage' => ['except' => 10],
    ];

    public function setStatus($status)
    {
        $this->status_payment = $status;
        $this->resetPage();
    }

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function openModalPayment($id)
    {
        $this->transaction = Transaction::with('transactionPayments')->find($id);

        if (! $this->transaction) {
            return AlertHelper::error('Gagal', 'Transaksi tidak ditemukan.');
        }

        $this->transaction_id = $id;

        // Suggested payment amount
        $remaining = $this->transaction->grand_total_price - ($this->transaction->payment_amount ?? 0);

        if ($this->transaction->installment_count > 0 && $remaining > 0) {
            // Count payments that are NOT down payments
            $paidCount = $this->transaction->transactionPayments->where('is_down_payment', false)->count();
            $remainingTenor = max(1, $this->transaction->installment_count - $paidCount);

            // Suggest: Remaining bill divided by remaining installments
            $suggested = $remaining / $remainingTenor;
            $this->payment_amount = number_format($suggested, 0, ',', '.');
        } else {
            $this->payment_amount = number_format($remaining, 0, ',', '.');
        }

        $this->admin_fee = 0;
        $this->description = '';
        $this->payment_method_id = null;
        $this->is_single_payment = false; // Always false for pending payments as they are sequential

        $this->dispatch('open-modal', ['id' => 'modalPayment']);
    }

    public function closeModalPayment()
    {
        $this->reset(['transaction_id', 'transaction', 'payment_method_id', 'payment_amount', 'admin_fee', 'description']);
        $this->dispatch('close-modal', ['id' => 'modalPayment']);
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
            'user_id' => $this->transaction->patient_id ?? Auth::id(), // Fallback if patient_id null
            'transaction_id' => $this->transaction_id,
            'payment_method_id' => $this->payment_method_id,
            'description' => $this->description,
            'payment_amount' => $payment_amount,
            'admin_fee' => $admin_fee,
            'payment_real' => $payment_amount + $admin_fee,
            'company_id' => Auth::user()->company_id,
        ]);

        // Update transaction status and totals
        $transaction = Transaction::find($this->transaction_id);

        $transaction->payment_method_single_payment_id = null;
        $transaction->single_payment_admin_fee = 0;
        $transaction->single_payment_payment_amount = 0;
        $transaction->single_payment_payment_real = 0;
        $transaction->is_single_payment = false;

        $totalPaid = $transaction->transactionPayments()->sum('payment_amount');
        $transaction->payment_amount = $totalPaid;

        $transaction->payment_change = $totalPaid - $transaction->grand_total_price;
        if ($transaction->payment_change < 0) {
            $transaction->remaining_bill = abs($transaction->payment_change);
            $transaction->payment_change = 0;
            $transaction->status_payment = 'partial';
        } else {
            $transaction->remaining_bill = 0;
            $transaction->status_payment = 'paid';
            $transaction->is_pending_payment = false;
        }

        $transaction->save();

        // Update installments status
        $this->updateInstallmentsStatus($transaction, $payment_amount);

        $this->closeModalPayment();

        return AlertHelper::success('Berhasil', 'Pembayaran berhasil ditambahkan.');
    }

    public function render()
    {
        $transactions = Transaction::where('company_id', Auth::user()->company_id)
            ->where('status_payment', $this->status_payment)
            ->when($this->search, function ($query) {
                $query->where(function ($q) {
                    $q->where('code', 'ilike', '%'.$this->search.'%')
                        ->orWhere('patient_name', 'ilike', '%'.$this->search.'%');
                });
            })
            ->where('is_pending_payment', true)
            ->orderBy('created_at', 'desc')
            ->paginate($this->perPage);

        $paymentMethods = PaymentMethod::where('company_id', Auth::user()->company_id)
            ->get();

        return view('livewire.admin.sale.pending.admin-sale-pending-index', [
            'transactions' => $transactions,
            'paymentMethods' => $paymentMethods,
        ])
            ->extends('layout.app')
            ->section('content');
    }

    private function updateInstallmentsStatus($transaction, $paymentAmount)
    {
        $unpaidInstallments = $transaction->transactionInstallments()
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
}
