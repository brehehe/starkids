<?php

namespace App\Livewire\Admin\Receipt\Recipe;

use App\Models\Transaction\Transaction;
use App\Models\Transaction\TransactionDiagnosis;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class AdminReceiptRecipeIndex extends Component
{
    public $transaction_id;

    public $transaction;

    public $transactionDiagnosas;

    public function mount($transaction_id)
    {
        $this->transaction_id = $transaction_id;
        $this->transaction = Transaction::with(['company.companyDetail', 'doctor.userDetail', 'patient.userDetail', 'location', 'transactionRecipes.transactionDetail.product'])->find($transaction_id);
        $this->transactionDiagnosas = TransactionDiagnosis::where('transaction_id', $transaction_id)->first();

        if (! $this->transaction) {
            abort(404, 'Transaction not found');
        }
    }

    public function render()
    {
        $user = null;
        try {
            $user = User::role(['Apoteker'])->where('is_head', true)->first();
        } catch (\Throwable $e) {
            $user = null;
        }

        if (! $user && Auth::check()) {
            $user = User::find(Auth::id());
        }

        $company = $this->transaction?->company ?? Auth::user()?->company;

        return view('livewire.admin.receipt.recipe.admin-receipt-recipe-index', [
            'user' => $user,
            'company' => $company,
        ])
            ->extends('layout.receipt.prescription')
            ->section('content');
    }
}
