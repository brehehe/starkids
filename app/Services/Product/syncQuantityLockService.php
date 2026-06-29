<?php

namespace App\Services\Product;

use App\Models\Product\Product;
use App\Models\Product\ProductStock;
use App\Models\Transaction\Transaction;
use App\Models\Transaction\TransactionDetail;
use App\Models\Transaction\TransactionDetailPackage;
use App\Models\Transaction\TransactionRecipe;

/**
 * Class syncQuantityLockService.
 */
class syncQuantityLockService
{
    public function syncQuantityLock($productId, $branchId)
    {
        $product = Product::find($productId);
        if (! $product || $product->is_non_stock) {
            return;
        }

        $validStatuses = [
            'draft_consultation',
            'waiting_consultation',
            'call_consultation',
            'confirmation_call',
            'consultation',
            'pharmacy',
            'call_pharmacy',
            'sale_pharmacy',
            'draft',
            'process',
            'take_medicine',
        ];

        $transactionIds = Transaction::whereIn('status', $validStatuses)
            ->where('branch_id', $branchId)
            ->pluck('id');

        $detailQty = TransactionDetail::whereIn('transaction_id', $transactionIds)
            ->where('branch_id', $branchId)
            ->whereNotNull('product_id')
            ->where('product_id', $productId)
            ->sum('quantity');

        $recipeQty = TransactionRecipe::whereIn('transaction_id', $transactionIds)
            ->where('branch_id', $branchId)
            ->whereNotNull('product_id')
            ->where('product_id', $productId)
            ->sum('quantity');

        $detailPackage = TransactionDetailPackage::whereIn('transaction_id', $transactionIds)
            ->where('branch_id', $branchId)
            ->whereNotNull('product_id')
            ->where('product_id', $productId)
            ->sum('quantity');

        $totalLocked = $detailQty + $recipeQty + $detailPackage;

        $productStock = ProductStock::where('product_id', $productId)
            ->where('branch_id', $branchId)
            ->first();

        if ($productStock) {
            $productStock->quantity_lock = $totalLocked;
            $productStock->quantity_real = $productStock->quantity - $totalLocked;
            $productStock->save();
        }
    }
}
