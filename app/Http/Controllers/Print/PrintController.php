<?php

namespace App\Http\Controllers\Print;

use App\Http\Controllers\Controller;
use App\Models\Product\Product;
use App\Models\Product\ProductType;
use App\Models\Transaction\Transaction;
use App\Models\Transaction\TransactionDetail;
use App\Models\Transaction\TransactionRecipe;

class PrintController extends Controller
{
    //
    public function invoice($id)
    {
        $transaction_id = $id;
        $transaction = Transaction::findOrFail($id);

        return view('print.invoice', compact('transaction', 'transaction_id'));
    }

    public function invoiceTotal($id)
    {
        $transaction_id = $id;
        $transaction = Transaction::findOrFail($id);

        $productType = ProductType::where('name', 'Jasa')->first();

        $productServices = Product::where('product_type_id', $productType?->id)->get()->pluck('id')->toArray();

        $transactionService = TransactionDetail::where('transaction_id', $transaction->id)
            ->whereIn('product_id', $productServices)
            ->sum('sub_total_price');

        $transactionDetailNonService = TransactionDetail::where('transaction_id', $transaction->id)
            ->whereNotIn('product_id', $productServices)
            ->sum('sub_total_price');

        $transactionRecipes = TransactionRecipe::where('transaction_id', $transaction->id)
            ->selectRaw('SUM(sub_total_price + price_service_other + price_service_one) as total')
            ->value('total') ?? 0;

        return view('print.invoice-total', compact('transaction', 'transaction_id', 'transactionService', 'transactionDetailNonService', 'transactionRecipes'));
    }
}
