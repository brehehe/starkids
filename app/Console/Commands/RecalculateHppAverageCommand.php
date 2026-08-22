<?php

namespace App\Console\Commands;

use App\Models\Product\Product;
use App\Models\Product\ProductPrice;
use App\Models\Product\ProductPriceHistory;
use App\Models\Product\ProductSellingPriceHistory;
use App\Models\Product\ProductStockHistory;
use App\Models\PurchaseOrder\PurchaseOrderItem;
use App\Models\PurchaseRequisition\PurchaseRequisition;
use App\Models\PurchaseRequisition\PurchaseRequisitionItem;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class RecalculateHppAverageCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'product:recalculate-hpp 
                            {--product= : Filter berdasarkan SKU atau Nama Produk}
                            {--update-prices : Hitung & perbarui juga harga jual aktif berdasarkan margin produk}
                            {--dry-run : Simulasi perhitungan tanpa menyimpan perubahan ke database}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Sinkronisasi menyeluruh database pembelian, potongan diskon faktur, HNA netto, dan kalkulasi HPP rata-rata produk';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $productFilter = $this->option('product');
        $updatePrices = $this->option('update-prices');
        $isDryRun = $this->option('dry-run');

        $this->info('========================================================================');
        $this->info('  SINKRONISASI DATABASE PEMBELIAN, DISKON FAKTUR & HNA RATA-RATA (HPP) ');
        $this->info('========================================================================');
        if ($isDryRun) {
            $this->warn(' [MODE SIMULASI / DRY-RUN: Data tidak akan diubah di database]');
        }

        DB::beginTransaction();
        try {
            // -------------------------------------------------------------
            // LANGKAH 1: Sinkronisasi Item Pembelian (purchase_order_items)
            // -------------------------------------------------------------
            $this->info('Langkah 1: Memverifikasi & Menghitung Net Total Item Pembelian (PO Items)...');
            
            $poQuery = PurchaseOrderItem::whereNull('deleted_at');
            if ($productFilter) {
                $poQuery->whereHas('product', function ($q) use ($productFilter) {
                    $q->where('sku_number', 'ILIKE', "%{$productFilter}%")
                      ->orWhere('name', 'ILIKE', "%{$productFilter}%");
                });
            }

            $poItems = $poQuery->get();
            $updatedPoCount = 0;

            foreach ($poItems as $item) {
                if ($item->quantity <= 0) continue;

                $unitGross = (float) ($item->hna_ppn > 0 ? $item->hna_ppn : ($item->price > 0 ? $item->price : $item->hna));
                $correctSubTotal = round($unitGross * (float) $item->quantity, 2);

                $discount = 0;
                if ($item->discount_type === 'percentage' && $item->discount_value > 0) {
                    $discount = round($correctSubTotal * ((float) $item->discount_value / 100), 2);
                } elseif ($item->discount > 0) {
                    $discount = min($correctSubTotal, (float) $item->discount);
                }

                $netTotal = max(0, $correctSubTotal - $discount);

                if (abs((float)$item->total - $netTotal) > 0.01 || abs((float)$item->discount - $discount) > 0.01 || abs((float)$item->sub_total - $correctSubTotal) > 0.01) {
                    if (!$isDryRun) {
                        $item->update([
                            'sub_total' => $correctSubTotal,
                            'discount' => $discount,
                            'total' => $netTotal,
                        ]);
                    }
                    $updatedPoCount++;
                }
            }
            $this->info("✓ Terverifikasi {$poItems->count()} item PO. {$updatedPoCount} item disinkronkan ke nilai bersih.");

            // -------------------------------------------------------------
            // LANGKAH 2: Sinkronisasi Grand Total Faktur (purchase_requisitions)
            // -------------------------------------------------------------
            $this->info('Langkah 2: Sinkronisasi Grand Total Faktur Pembelian (Purchase Requisitions)...');
            if (!$isDryRun && !$productFilter) {
                DB::statement("
                    UPDATE purchase_requisitions pr
                    SET grand_total = sub.calculated_total
                    FROM (
                        SELECT pri.purchase_requisition_id, COALESCE(SUM(poi.total), 0) as calculated_total
                        FROM purchase_requisition_items pri
                        JOIN purchase_order_items poi ON poi.purchase_requisition_item_id = pri.id
                        WHERE poi.deleted_at IS NULL
                        GROUP BY pri.purchase_requisition_id
                    ) sub
                    WHERE pr.id = sub.purchase_requisition_id;
                ");
                $this->info('✓ Grand total seluruh faktur pembelian berhasil disinkronkan.');
            }

            // -------------------------------------------------------------
            // LANGKAH 3: Sinkronisasi Riwayat Batch Harga (product_price_histories)
            // -------------------------------------------------------------
            $this->info('Langkah 3: Menyesuaikan Riwayat Batch Harga (Product Price Histories)...');
            
            $historyQuery = ProductPriceHistory::whereNotNull('purchase_order_item_id');
            if ($productFilter) {
                $historyQuery->whereHas('product', function ($q) use ($productFilter) {
                    $q->where('sku_number', 'ILIKE', "%{$productFilter}%")
                      ->orWhere('name', 'ILIKE', "%{$productFilter}%");
                });
            }

            $histories = $historyQuery->get();
            $updatedBatchCount = 0;

            foreach ($histories as $history) {
                $poi = PurchaseOrderItem::withTrashed()->find($history->purchase_order_item_id);
                if ($poi && $poi->quantity > 0) {
                    $unitPriceGross = (float) ($poi->hna_ppn > 0 ? $poi->hna_ppn : ($poi->price > 0 ? $poi->price : $poi->hna));
                    $grossSubTotal = $unitPriceGross * (float) $poi->quantity;
                    
                    $discount = 0;
                    if ($poi->discount_type === 'percentage' && $poi->discount_value > 0) {
                        $discount = $grossSubTotal * ((float) $poi->discount_value / 100);
                    } elseif ($poi->discount > 0) {
                        $discount = min($grossSubTotal, (float) $poi->discount);
                    }

                    $netTotal = max(0, $grossSubTotal - $discount);
                    $netUnitPrice = round($netTotal / (float) $poi->quantity, 2);

                    if (abs((float)$history->price - $netUnitPrice) > 0.01 || abs((float)$history->sub_total_price - $netTotal) > 0.01) {
                        if (!$isDryRun) {
                            $history->update([
                                'price' => $netUnitPrice,
                                'sub_total_price' => $netTotal,
                                'hpp_average' => $netUnitPrice,
                            ]);
                        }
                        $updatedBatchCount++;
                    }
                }
            }
            $this->info("✓ {$updatedBatchCount} batch riwayat harga disesuaikan dengan diskon pembelian.");

            // -------------------------------------------------------------
            // LANGKAH 4: Sinkronisasi Riwayat Mutasi Stok Masuk (product_stock_histories)
            // -------------------------------------------------------------
            $this->info('Langkah 4: Menyesuaikan Harga Masuk Riwayat Stok (Product Stock Histories)...');
            
            $stockHistQuery = ProductStockHistory::whereNotNull('purchase_order_item_id')->where('type', 'in');
            if ($productFilter) {
                $stockHistQuery->whereHas('product', function ($q) use ($productFilter) {
                    $q->where('sku_number', 'ILIKE', "%{$productFilter}%")
                      ->orWhere('name', 'ILIKE', "%{$productFilter}%");
                });
            }

            $stockHistories = $stockHistQuery->get();
            $updatedStockHistCount = 0;

            foreach ($stockHistories as $stkHist) {
                $poi = PurchaseOrderItem::withTrashed()->find($stkHist->purchase_order_item_id);
                if ($poi && $poi->quantity > 0) {
                    $unitPriceGross = (float) ($poi->hna_ppn > 0 ? $poi->hna_ppn : ($poi->price > 0 ? $poi->price : $poi->hna));
                    $grossSubTotal = $unitPriceGross * (float) $poi->quantity;
                    
                    $discount = 0;
                    if ($poi->discount_type === 'percentage' && $poi->discount_value > 0) {
                        $discount = $grossSubTotal * ((float) $poi->discount_value / 100);
                    } elseif ($poi->discount > 0) {
                        $discount = min($grossSubTotal, (float) $poi->discount);
                    }

                    $netTotal = max(0, $grossSubTotal - $discount);
                    $netUnitPrice = round($netTotal / (float) $poi->quantity, 2);

                    if (abs((float)$stkHist->price - $netUnitPrice) > 0.01 || abs((float)$stkHist->sub_total_price - $netTotal) > 0.01) {
                        if (!$isDryRun) {
                            $stkHist->update([
                                'price' => $netUnitPrice,
                                'sub_total_price' => $netTotal,
                            ]);
                        }
                        $updatedStockHistCount++;
                    }
                }
            }
            $this->info("✓ {$updatedStockHistCount} riwayat mutasi stok masuk disesuaikan dengan harga bersih.");

            // -------------------------------------------------------------
            // LANGKAH 5: Hitung Ulang HPP Rata-Rata per Produk (product_prices)
            // -------------------------------------------------------------
            $this->info('Langkah 5: Menghitung Ulang HNA (HPP Rata-rata) per Produk...');

            $query = Product::with(['productPrice', 'productCategory']);

            if ($productFilter) {
                $query->where(function ($q) use ($productFilter) {
                    $q->where('sku_number', 'ILIKE', "%{$productFilter}%")
                        ->orWhere('name', 'ILIKE', "%{$productFilter}%")
                        ->orWhereRaw('id::text ILIKE ?', ["%{$productFilter}%"]);
                });
            }

            $products = $query->get();
            $tableData = [];
            $updatedProductCount = 0;

            foreach ($products as $product) {
                $productPrice = $product->productPrice;
                if (! $productPrice) {
                    continue;
                }

                $oldHpp = (float) $productPrice->hpp_average;
                $oldPrice = (float) $productPrice->price;

                // Cari riwayat aktif
                $priceHistories = ProductPriceHistory::where('product_id', $product->id)->get();
                $oldHppGross = (float) ($productPrice->hpp_average_without_discount ?? 0);
                $sumQty = 0;
                $sumSubTotalNet = 0;
                $sumSubTotalGross = 0;

                if ($priceHistories->count() > 0) {
                    foreach ($priceHistories as $ph) {
                        $qty = (float) $ph->quantity;
                        if ($qty > 0) {
                            $sumQty += $qty;
                            $sumSubTotalNet += (float) $ph->sub_total_price;
                            
                            $poi = $ph->purchaseOrderItem;
                            $grossUnit = (float) ($poi?->hna_ppn ?: ($poi?->price ?: $ph->price));
                            $sumSubTotalGross += ($grossUnit * $qty);
                        }
                    }
                }

                // Fallback ke PurchaseOrderItem jika price history kosong
                if ($sumQty <= 0) {
                    $poItems = PurchaseOrderItem::where('product_id', $product->id)->whereNull('deleted_at')->get();
                    if ($poItems->count() > 0) {
                        foreach ($poItems as $item) {
                            if ($item->quantity > 0) {
                                $unitGross = (float) ($item->hna_ppn > 0 ? $item->hna_ppn : ($item->price > 0 ? $item->price : $item->hna));
                                $itemGross = $unitGross * (float) $item->quantity;
                                $itemDisc = 0;
                                if ($item->discount_type === 'percentage' && $item->discount_value > 0) {
                                    $itemDisc = $itemGross * ((float) $item->discount_value / 100);
                                } elseif ($item->discount > 0) {
                                    $itemDisc = min($itemGross, (float) $item->discount);
                                }
                                $itemNet = max(0, $itemGross - $itemDisc);
                                $sumQty += (float) $item->quantity;
                                $sumSubTotalNet += $itemNet;
                                $sumSubTotalGross += $itemGross;
                            }
                        }
                    }
                }

                $newHpp = $sumQty > 0 ? round($sumSubTotalNet / $sumQty, 2) : $oldHpp;
                $newHppGross = $sumQty > 0 ? round($sumSubTotalGross / $sumQty, 2) : ($oldHppGross > 0 ? $oldHppGross : $newHpp);

                $dataUpdated = false;

                if (abs($oldHpp - $newHpp) > 0.01 || abs($oldHppGross - $newHppGross) > 0.01) {
                    if (!$isDryRun) {
                        $productPrice->hpp_average = $newHpp;
                        $productPrice->hpp_average_without_discount = $newHppGross;
                    }
                    $dataUpdated = true;
                }

                $newPrice = $oldPrice;
                if ($updatePrices && $newHpp > 0) {
                    $margin = $product->normal > 0 ? $product->normal : ($product->productCategory?->normal ?? 0);
                    if ($margin > 0) {
                        $newPrice = round($newHpp + ($newHpp * $margin / 100), 2);
                        if (abs($oldPrice - $newPrice) > 0.01) {
                            if (!$isDryRun) {
                                $productPrice->price = $newPrice;
                                $productPrice->price_generate = $newPrice;
                                $productPrice->is_updated = true;

                                ProductSellingPriceHistory::create([
                                    'product_id' => $product->id,
                                    'product_price_id' => $productPrice->id,
                                    'branch_id' => $productPrice->branch_id,
                                    'company_id' => $productPrice->company_id,
                                    'user_id' => null,
                                    'old_price' => $oldPrice,
                                    'new_price' => $newPrice,
                                    'old_recipe' => $productPrice->recipe,
                                    'new_recipe' => $productPrice->recipe,
                                    'old_hpp_average' => $oldHpp,
                                    'new_hpp_average' => $newHpp,
                                    'margin' => $margin,
                                    'source' => 'Command: product:recalculate-hpp',
                                    'notes' => "Margin: +{$margin}% (Setelah diskon pembelian diterapkan)",
                                ]);
                            }
                            $dataUpdated = true;
                        }
                    }
                }

                if ($dataUpdated) {
                    if (!$isDryRun) {
                        $productPrice->save();
                    }
                    $updatedProductCount++;

                    $tableData[] = [
                        $product->sku_number ?? '-',
                        substr($product->name, 0, 30),
                        'Rp ' . number_format($oldHpp, 0, ',', '.'),
                        'Rp ' . number_format($newHpp, 0, ',', '.'),
                        'Rp ' . number_format($oldPrice, 0, ',', '.'),
                        'Rp ' . number_format($newPrice, 0, ',', '.'),
                    ];
                }
            }

            if ($isDryRun) {
                DB::rollBack();
            } else {
                DB::commit();
            }

            if (count($tableData) > 0) {
                $this->table(
                    ['SKU', 'Nama Produk', 'HNA Lama', 'HNA Baru (Net)', 'Harga Jual Lama', 'Harga Jual Baru'],
                    array_slice($tableData, 0, 50)
                );

                if (count($tableData) > 50) {
                    $this->info('... dan ' . (count($tableData) - 50) . ' produk lainnya.');
                }
            }

            $this->info('========================================================================');
            $this->info("✓ Selesai! Seluruh tabel database berhasil diaudit dan disinkronkan.");
            $this->info('========================================================================');

            return Command::SUCCESS;
        } catch (\Exception $e) {
            DB::rollBack();
            $this->error('Gagal melakukan sinkronisasi database: ' . $e->getMessage());
            Log::error('RecalculateHppAverageCommand failed: ' . $e->getMessage());

            return Command::FAILURE;
        }
    }
}
