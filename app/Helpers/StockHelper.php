<?php

namespace App\Helpers;

use App\Models\Product\Product;
use App\Models\Product\ProductStock;
use App\Models\Transaction\Transaction;
use App\Models\Transaction\TransactionDetail;
use App\Models\Transaction\TransactionDetailPackage;
use App\Models\Transaction\TransactionRecipe;
// use App\Observers\TransactionObserver;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Throwable;

class StockHelper
{
    private $validStatuses = [
        'draft_consultation',
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

    public static function updateStockForTransaction(Transaction $transaction): bool
    {
        if (!self::shouldAffectStock($transaction)) {
            return true;
        }

        $products = self::aggregateTransactionProducts($transaction);

        try {
            DB::beginTransaction();

            foreach ($products as $productId => $qty) {
                $product = $transaction->company->products()->find($productId);

                if (!$product || $product->is_non_stock) continue;

                $stock = ProductStock::where('product_id', $productId)
                    ->where('branch_id', $transaction->branch_id)
                    ->where('company_id', $transaction->company_id)
                    ->lockForUpdate() // ⛔ prevent race condition
                    ->first();

                if (!$stock || $stock->quantity < $qty) {
                    DB::rollBack();
                    Log::warning("Insufficient stock for product ID: $productId in transaction {$transaction->id}");
                    return false;
                }

                $stock->decrement('quantity', $qty);
            }

            DB::commit();
            return true;
        } catch (Throwable $e) {
            DB::rollBack();
            Log::error("Stock update failed for transaction {$transaction->id}: " . $e->getMessage());
            return false;
        }
    }

    public static function rollbackStockForTransaction(Transaction $transaction): void
    {
        if (!self::shouldAffectStock($transaction)) {
            return;
        }

        $products = self::aggregateTransactionProducts($transaction);

        foreach ($products as $productId => $qty) {
            $product = $transaction->company->products()->find($productId);

            if (!$product || $product->is_non_stock) continue;

            $stock = ProductStock::where('product_id', $productId)
                ->where('branch_id', $transaction->branch_id)
                ->where('company_id', $transaction->company_id)
                ->first();

            if ($stock) {
                $stock->increment('quantity', $qty);
            }
        }
    }

    protected static function aggregateTransactionProducts(Transaction $transaction): array
    {
        $result = [];

        foreach ($transaction->transactionDetails as $item) {
            if ($item->product_id) {
                $result[$item->product_id] = ($result[$item->product_id] ?? 0) + $item->quantity;
            }
        }

        foreach ($transaction->transactionRecipes as $item) {
            if ($item->product_id) {
                $result[$item->product_id] = ($result[$item->product_id] ?? 0) + $item->quantity;
            }
        }

        foreach ($transaction->transactionDetailPackages as $item) {
            if ($item->product_id) {
                $result[$item->product_id] = ($result[$item->product_id] ?? 0) + $item->quantity;
            }
        }

        return $result;
    }

    public static function syncStockFromTransaction(Transaction $transaction): void
    {
        foreach ($transaction->transactionDetails as $detail) {
            if ($detail->product && !$detail->product->is_non_stock) {
                $productStock = ProductStock::firstOrCreate([
                    'product_id' => $detail->product_id,
                    'company_id' => $transaction->company_id,
                    'branch_id'  => $transaction->branch_id,
                ]);

                $lockedStock = TransactionDetail::where('product_id', $detail->product_id)
                    ->whereHas('transaction', function ($q) use ($transaction) {
                        $q->where('branch_id', $transaction->branch_id)
                            ->whereIn('status', self::validStatuses());
                    })
                    ->sum('quantity');

                $lockedStockRecipe = TransactionRecipe::where('product_id', $detail->product_id)
                    ->whereHas('transaction', function ($q) use ($transaction) {
                        $q->where('branch_id', $transaction->branch_id)
                            ->whereIn('status', self::validStatuses());
                    })
                    ->sum('quantity');

                $lockedStockDetailPackage = TransactionDetailPackage::where('product_id', $detail->product_id)
                    ->whereHas('transaction', function ($q) use ($transaction) {
                        $q->where('branch_id', $transaction->branch_id)
                            ->whereIn('status', self::validStatuses());
                    })
                    ->sum('quantity');

                $productStock->quantity_lock = $lockedStock + $lockedStockRecipe + $lockedStockDetailPackage;
                $productStock->save();
            }
        }
    }

    protected static function validStatuses(): array
    {
        return [
            'draft_consultation',
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
    }

    protected static function shouldAffectStock(Transaction $transaction): bool
    {
        return in_array($transaction->status, self::validStatuses());
    }

    public static function syncTransactionStock(Transaction $transaction): void
    {
        // Ambil semua product_id dari detail dan resep
        $productQuantities = collect();

        foreach ($transaction->transactionDetails as $detail) {
            if ($detail->product_id) {
                $productQuantities->push([
                    'product_id' => $detail->product_id,
                    'quantity' => $detail->quantity,
                ]);
            }
        }

        foreach ($transaction->transactionRecipes as $recipe) {
            if ($recipe->product_id) {
                $productQuantities->push([
                    'product_id' => $recipe->product_id,
                    'quantity' => $recipe->quantity,
                ]);
            }
        }

        // Aggregate dan update stok
        $grouped = $productQuantities->groupBy('product_id');

        foreach ($grouped as $productId => $items) {
            $totalQuantity = $items->sum('quantity');

            // Update stok (misalnya: hitung quantity_lock ulang)
            self::updateLockedStockForProduct($productId);
        }
    }

    public static function updateLockedStockForProduct($productId): void
    {
        $validStatuses = ['pending', 'approved']; // sesuaikan

        $locked = TransactionDetail::where('product_id', $productId)
            ->whereHas('transaction', fn($q) => $q->whereIn('status', $validStatuses))
            ->sum('quantity');

        $lockedStockRecipe = TransactionRecipe::where('product_id', $productId)
            ->whereHas('transaction', fn($q) => $q->whereIn('status', $validStatuses))
            ->sum('quantity');

        $lockedStockDetailPackage = TransactionDetailPackage::where('product_id', $productId)
            ->whereHas('transaction', fn($q) => $q->whereIn('status', $validStatuses))
            ->sum('quantity');

        $locked += $lockedStockRecipe + $lockedStockDetailPackage;

        // Update quantity_lock di ProductStock, bukan di Product
        ProductStock::where('product_id', $productId)->update(['quantity_lock' => $locked]);
    }
}
