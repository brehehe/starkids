<?php

namespace App\Traits\Transaction;

use App\Models\Product\ProductPrice;
use App\Models\Transaction\Transaction;
use App\Models\Transaction\TransactionProduct;
use App\Services\Product\ProductService;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

trait ReversesTransactionStock
{
    /**
     * Kembalikan stok semua produk yang sudah pernah dikurangi
     * berdasarkan catatan TransactionProduct.
     *
     * Logika:
     * - TransactionProduct dibuat bersamaan dengan createProductDecrement()
     * - Jika tidak ada TransactionProduct → stok belum pernah dikurangi → aman
     * - Produk is_non_stock = true tidak memiliki stok fisik → dilewati
     */
    protected function reverseStockForTransaction(Transaction $transaction): void
    {
        $transactionProducts = TransactionProduct::where('transaction_id', $transaction->id)
            ->with('product')
            ->get();

        if ($transactionProducts->isEmpty()) {
            return;
        }

        $productService = new ProductService;

        foreach ($transactionProducts as $tp) {
            $product = $tp->product;

            if (! $product || $product->is_non_stock) {
                continue;
            }

            $hppPrice = $tp->hpp_average ?? 0;

            if ($hppPrice <= 0) {
                $productPrice = ProductPrice::where('product_id', $product->id)
                    ->where('company_id', Auth::user()->company_id)
                    ->first();
                $hppPrice = $productPrice?->hpp_average ?? 0;
            }

            try {
                $productService->createProductIncrement(
                    $product->id,
                    $tp->quantity,
                    null,
                    null,
                    $hppPrice,
                    null,
                    null,
                    null,
                    null,
                    null
                );
            } catch (\Exception $e) {
                Log::error('Gagal mengembalikan stok saat pembatalan transaksi', [
                    'transaction_id' => $transaction->id,
                    'product_id' => $product->id,
                    'quantity' => $tp->quantity,
                    'error' => $e->getMessage(),
                ]);
            }
        }
    }
}
