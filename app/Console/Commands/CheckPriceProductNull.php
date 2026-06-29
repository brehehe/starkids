<?php

namespace App\Console\Commands;

use App\Models\Product\Product;
use App\Models\Product\ProductPrice;
use App\Models\Product\ProductPriceHistory;
use App\Models\PurchaseOrder\PurchaseOrderItem;
use App\Models\PurchaseRequisition\PurchaseRequisitionItem;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;

class CheckPriceProductNull extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'check:price-product-null';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $specialProducts = [
            'MUCOS SIRUP 60ML',
            'Mucos Drop 20ml 15mg/1ml',
        ];
        $specialProductsLower = array_map(function ($name) {
            return strtolower(trim($name));
        }, $specialProducts);

        $specialProductIds = Product::whereIn(\DB::raw('LOWER(TRIM(name))'), $specialProductsLower)->pluck('id')->toArray();

        $query = ProductPrice::withTrashed()->where(function ($q) use ($specialProductIds) {
            $q->where(function ($standard) {
                $standard->whereNull('deleted_at')
                    ->where('price', 0)
                    ->whereHas('product', function ($p) {
                        $p->where('is_non_stock', false);
                    });
            })->orWhereIn('product_id', $specialProductIds);
        });

        // Jika tidak ada data → stop
        if ($query->count() == 0) {
            return Command::SUCCESS;
        }

        Log::info("Cek Proses Product price Hpp dan price 0 : {$query->count()} rows found");

        $count = 0;
        foreach ($query->get() as $productPrice) {
            $isSpecialProduct = in_array(strtolower(trim($productPrice->product->name)), $specialProductsLower);

            $productPriceHistoryQuery = ProductPriceHistory::where('product_id', $productPrice->product_id);

            if ($isSpecialProduct) {
                $productPriceHistoryQuery->withTrashed();
            }

            $productPriceHistorys = $productPriceHistoryQuery->get();

            Log::info("Product {$productPrice->product->name} - ProductPriceHistory: {$productPriceHistorys->count()} rows");

            $sumQuantity = 0;
            $sumSubTotalPrice = 0;

            if ($productPriceHistorys->count() > 0) {
                $sumQuantity = $productPriceHistorys->sum('quantity');
                $sumSubTotalPrice = $productPriceHistorys->sum('sub_total_price');

                // Avoid division by zero
                if ($sumQuantity > 0) {
                    $hppAverage = $sumSubTotalPrice / $sumQuantity;
                    $productPrice->hpp_average = $hppAverage;
                }
            }

            if ($sumQuantity <= 0) {
                $purchaseOrderItemsQuery = PurchaseOrderItem::where('product_id', $productPrice->product_id)
                    ->where('company_id', $productPrice->company_id);

                if ($isSpecialProduct) {
                    $purchaseOrderItemsQuery->withTrashed();
                }

                $purchaseOrderItems = $purchaseOrderItemsQuery->get();

                if ($purchaseOrderItems->count() > 0) {
                    $sumQuantity = $purchaseOrderItems->sum('quantity');
                    $sumSubTotalPrice = $purchaseOrderItems->sum('sub_total');

                    if ($sumQuantity > 0) {
                        $hppAverage = $sumSubTotalPrice / $sumQuantity;
                        $productPrice->hpp_average = $hppAverage;
                    }
                }
            }

            if ($sumQuantity <= 0) {
                $purchaseRequisitionItemsQuery = PurchaseRequisitionItem::where('product_id', $productPrice->product_id)
                    ->where('company_id', $productPrice->company_id);

                if ($isSpecialProduct) {
                    $purchaseRequisitionItemsQuery->withTrashed();
                }

                $purchaseRequisitionItems = $purchaseRequisitionItemsQuery->get();

                if ($purchaseRequisitionItems->count() > 0) {
                    foreach ($purchaseRequisitionItems as $item) {
                        // For special products, we might need to fetch soft-deleted PurchaseOrderItem as well if relations are soft-deleted
                        // But relation retrieval usually respects soft deletes unless specified.
                        // Let's rely on the standard relationship first, or manual query if needed.
                        // However, if the PO item is also deleted, $item->purchaseOrderItem will be null unless we use withTrashed on the relation.

                        $poItem = $item->purchaseOrderItem;
                        if (! $poItem && $isSpecialProduct) {
                            $poItem = PurchaseOrderItem::withTrashed()
                                ->where('purchase_requisition_item_id', $item->id)
                                ->first();
                        }

                        if ($poItem) {
                            $sumQuantity += $item->quantity;
                            $sumSubTotalPrice += $poItem->sub_total;
                        }
                    }

                    if ($sumQuantity > 0) {
                        $hppAverage = $sumSubTotalPrice / $sumQuantity;
                        $productPrice->hpp_average = $hppAverage;
                    }
                }
            }

            Log::info($productPrice->product->name.' - HPP Average: '.$productPrice->hpp_average.' - Price: '.$productPrice->price.' - quantity: '.$sumQuantity.' - sub_total_price: '.$sumSubTotalPrice);

            if ($sumQuantity <= 0) {
                Log::info('Deleted ProductPrice for '.$productPrice->product->name);
                $productPrice->delete();
            } else {
                if ($productPrice->trashed()) {
                    $productPrice->restore();
                    Log::info('Restored ProductPrice for '.$productPrice->product->name);
                }
                $productPrice->is_updated = false;
                $productPrice->save();
            }

            $count++;
        }

        $affected = $count;

        Log::info("CheckPriceProductNull: {$affected} rows updated");
    }
}
