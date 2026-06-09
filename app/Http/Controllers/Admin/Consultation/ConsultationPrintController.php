<?php

namespace App\Http\Controllers\Admin\Consultation;

use App\Http\Controllers\Controller;
use App\Models\Transaction\Transaction;
use App\Models\Transaction\TransactionReference;
use Illuminate\Http\Request;

class ConsultationPrintController extends Controller
{
    public function printReferral($transactionId)
    {
        $transaction = Transaction::with(['patient.userDetail', 'doctor', 'company'])->findOrFail($transactionId);
        $reference = TransactionReference::where('transaction_id', $transactionId)->first();

        // If no reference created yet, we can either return empty or error
        if (!$reference) {
            $reference = new TransactionReference([
                'hospital' => '-',
                'doctor_name' => '-',
                'date_refer' => now()->format('Y-m-d'),
                'description' => '-'
            ]);
        }

        return view('layout.receipt.referral', compact('transaction', 'reference'));
    }

    public function printConsent($transactionId)
    {
        $transaction = Transaction::with([
            'patient.userDetail', 
            'doctor', 
            'company',
            'transactionDetails' => function ($query) {
                $query->where('type_transaction', 'action');
            }
        ])->findOrFail($transactionId);

        return view('layout.receipt.consent', compact('transaction'));
    }
}
