<?php

namespace App\Livewire\Admin\Logistic\DirectPurchase\Detail;

use App\Helpers\AlertHelper;
use App\Models\Branch\Branch;
use App\Models\Product\Product;
use App\Models\Product\ProductExpiredDate;
use App\Models\Product\ProductPrice;
use App\Models\Product\ProductPriceHistory;
use App\Models\Product\ProductStock;
use App\Models\Product\ProductStockHistory;
use App\Models\Product\ProductUnit;
use App\Models\PurchaseOrder\PurchaseOrder;
use App\Models\PurchaseOrder\PurchaseOrderItem;
use App\Models\PurchaseRequisition\PurchaseRequisition;
use App\Models\PurchaseRequisition\PurchaseRequisitionItem;
use App\Models\Supplier\Supplier;
use App\Models\SystemSetting\SystemSetting;
use App\Models\Unit\Unit;
use App\Traits\Branch\BranchTrait;
use Auth;
use Carbon\Carbon;
use Exception;
use Illuminate\Support\Str;
use Livewire\Component;
use Log;

class AdminLogisticDirectPurchaseDetailIndex extends Component
{
    use BranchTrait;

    public $purchase_requisition_id = null;

    public $supplier_id = null;

    public $number_purchase_order = null;

    public $grand_total = null;

    public $details = [];

    public $products = [];

    public $suppliers = [];

    public $notes = null;

    public function mount()
    {
        $purchase_requisition_id = Session()->get('purchase_requisition_id');
        $this->purchase_requisition_id = $purchase_requisition_id;
        $this->products = Product::where('company_id', Auth::user()->company_id)->orderBy('name', 'asc')->select('id', 'name')->get()->pluck('name', 'id')->toArray();
        $this->suppliers = Supplier::where('company_id', Auth::user()->company_id)->orderBy('name', 'asc')->select('id', 'name')->get()->pluck('name', 'id')->toArray();
        if ($this->purchase_requisition_id) {
            $purchase_requisition = PurchaseRequisition::find($this->purchase_requisition_id);
            if ($purchase_requisition) {
                $this->supplier_id = $purchase_requisition->supplier_id;
                $this->number_purchase_order = $purchase_requisition->number;
                $this->grand_total = $purchase_requisition->grand_total;
                $this->notes = $purchase_requisition->notes;
                $this->getDetails();
            } else {
                return redirect()->route('admin.logistic.direct-purchase');
            }
        } else {
            $this->addDetails();
        }
    }

    public function getDetails()
    {
        $purchase_requisition = PurchaseRequisitionItem::where('purchase_requisition_id', $this->purchase_requisition_id)->get();
        if ($purchase_requisition) {
            foreach ($purchase_requisition as $item) {
                $this->details[] = [
                    'id' => $item->id,
                    'product_id' => $item->product_id,
                    'product_name' => $item?->product?->name,
                    'quantity' => $item->quantity,
                    'hna' => number_format($item?->purchaseOrderItem?->hna, 0, ',', '.'),
                    'hna_old' => number_format($item?->purchaseOrderItem?->hna, 0, ',', '.'),
                    'ppn' => number_format($item?->purchaseOrderItem?->ppn, 0, ',', '.'),
                    'ppn_old' => number_format($item?->purchaseOrderItem?->ppn, 0, ',', '.'),
                    'hna_ppn' => number_format($item?->purchaseOrderItem?->hna_ppn, 0, ',', '.'),
                    'hna_ppn_old' => number_format($item?->purchaseOrderItem?->hna_ppn, 0, ',', '.'),
                    'price' => number_format($item?->purchaseOrderItem?->price, 0, ',', '.'),
                    'price_old' => number_format($item?->purchaseOrderItem?->price, 0, ',', '.'),
                    'discount' => number_format($item?->purchaseOrderItem?->discount, 0, ',', '.'),
                    'discount_type' => $item?->purchaseOrderItem?->discount_type,
                    'discount_value' => ($item?->purchaseOrderItem?->discount_type == 'percentage')
                        ? number_format($item?->purchaseOrderItem?->discount_value, 2, '.', '')
                        : number_format($item?->purchaseOrderItem?->discount_value, 0, ',', '.'),
                    'sub_total' => $item?->purchaseOrderItem?->sub_total,
                    'total' => $item?->purchaseOrderItem?->total,
                ];
            }
            $this->updatedDetails();
        }
    }

    public function addDetails()
    {
        $this->details[] = [
            'id' => null,
            'product_id' => null,
            'product_name' => null,
            'quantity' => null,
            'hna' => null,
            'hna_old' => null,
            'ppn' => null,
            'ppn_old' => null,
            'hna_ppn' => null,
            'hna_ppn_old' => null,
            'price' => null,
            'price_old' => null,
            'discount' => null,
            'discount_type' => null,
            'discount_value' => null,
            'sub_total' => null,
            'total' => null,
            'expired_dates' => [
                [
                    'expired_date' => null,
                    'batch_number' => null,
                    'stok' => null,
                ],
            ],
        ];
    }

    public function updatedDetails()
    {
        foreach ($this->details as $key => $detail) {
            $quantity = $detail['quantity'] ? intval(Str::replace('.', '', $detail['quantity'])) : 0;
            $hna = $detail['hna'] ? intval(Str::replace('.', '', $detail['hna'])) : 0;
            $hna_old = $detail['hna_old'] ? intval(Str::replace('.', '', $detail['hna_old'])) : 0;
            $ppn = $detail['ppn'] ? intval(Str::replace('.', '', $detail['ppn'])) : 0;
            $ppn_old = $detail['ppn_old'] ? intval(Str::replace('.', '', $detail['ppn_old'])) : 0;
            $hna_ppn = $detail['hna_ppn'] ? intval(Str::replace('.', '', $detail['hna_ppn'])) : 0;
            $hna_ppn_old = $detail['hna_ppn_old'] ? intval(Str::replace('.', '', $detail['hna_ppn_old'])) : 0;
            $price = 0;

            $ppn_percentage = SystemSetting::where('company_id', Auth::user()->company_id)->first()->tax ?? 11;

            if ($hna != $hna_old) {
                $hna_ppn = ($hna * ($ppn_percentage / 100)) + $hna;
                $ppn = $hna * ($ppn_percentage / 100);
                $price = $hna_ppn;
            } elseif ($hna_ppn != $hna_ppn_old) {
                $hna = $hna_ppn / (1 + $ppn_percentage / 100);
                $ppn = $hna * ($ppn_percentage / 100);
                $price = $hna_ppn;
            } else {
                $price = $hna_ppn;
            }

            // Update nilai harga di items
            $this->details[$key]['hna'] = number_format($hna, 0, ',', '.');
            $this->details[$key]['hna_old'] = number_format($hna, 0, ',', '.');
            $this->details[$key]['hna_ppn'] = number_format($hna_ppn, 0, ',', '.');
            $this->details[$key]['hna_ppn_old'] = number_format($hna_ppn, 0, ',', '.');
            $this->details[$key]['ppn'] = number_format($ppn, 0, ',', '.');
            $this->details[$key]['ppn_old'] = number_format($ppn, 0, ',', '.');
            $this->details[$key]['price'] = number_format($price, 0, ',', '.');
            $this->details[$key]['price_old'] = number_format($price, 0, ',', '.');

            // Hitung subtotal
            $sub_total = $price * $quantity;
            $this->details[$key]['sub_total'] = $sub_total;

            $discount = 0;
            $discount_type = $detail['discount_type'] ?? 'percentage';
            $raw_discount_value = $detail['discount_value'] ?? 0;

            if ($discount_type == 'percentage') {
                $discount_value = floatval(str_replace(',', '.', $raw_discount_value));
            } else {
                $discount_value = intval(Str::replace('.', '', $raw_discount_value));
            }

            if ($discount_type == 'percentage') {
                if ($discount_value > 100) {
                    $discount_value = 100; // clamp max 100%
                } elseif ($discount_value < 0) {
                    $discount_value = 0;
                }
                $discount = ($sub_total * $discount_value) / 100;
            } else {
                if ($discount_value > $sub_total) {
                    $discount_value = $sub_total; // clamp max nominal ke subtotal
                } elseif ($discount_value < 0) {
                    $discount_value = 0;
                }
                $discount = $discount_value;
            }

            // Simpan hasil
            $this->details[$key]['discount_type'] = $discount_type;
            if ($discount_type == 'percentage') {
                // Remove trailing zeros for cleaner display, or stick to 2 decimals
                $this->details[$key]['discount_value'] = $discount_value; // Use raw float for number input
            } else {
                $this->details[$key]['discount_value'] = number_format($discount_value, 0, ',', '.');
            }
            $this->details[$key]['discount'] = number_format($discount, 0, ',', '.');
            $this->details[$key]['total'] = $sub_total - $discount;
        }
        $this->updateTotals();
    }

    public function updateTotals(): void
    {
        $this->grand_total = number_format(array_sum(array_column($this->details, 'total')), 0, ',', '.');
    }

    public function confirmDelete($id)
    {
        return AlertHelper::confirmDelete('delete', 'Apakah Anda Yakin Ingin Menghapus Item Ini?', $id);
    }

    public function delete($id)
    {
        $data = $id[0];
        $purchase_requisition_item_id = $this->details[$data]['id'];

        if ($purchase_requisition_item_id) {
            try {
                \DB::beginTransaction();
                $this->rollbackSingleItem($purchase_requisition_item_id);
                $purchase_requisition_item = PurchaseRequisitionItem::find($purchase_requisition_item_id);
                if ($purchase_requisition_item) {
                    PurchaseOrderItem::where('purchase_requisition_item_id', $purchase_requisition_item_id)->delete();
                    $purchase_requisition_item->delete();
                }
                \DB::commit();
            } catch (Exception $e) {
                \DB::rollBack();

                return AlertHelper::error('Gagal', 'Gagal menghapus item: '.$e->getMessage());
            }
        }

        unset($this->details[$data]);
        $this->details = array_values($this->details);
        $this->updateTotals();

        return AlertHelper::success('Berhasil', 'Item Berhasil Dihapus');
    }

    private function rollbackSingleItem($prItemId)
    {
        $companyId = Auth::user()->company_id;
        $branchId = $this->getBranchOne()->id;

        $prItem = PurchaseRequisitionItem::with('purchaseOrderItem')->find($prItemId);
        if (! $prItem) {
            return;
        }

        $poItem = $prItem->purchaseOrderItem;
        $productId = $prItem->product_id;

        if ($poItem) {
            /** ===========================================
             * 1. KEMBALIKAN STOCK
             * =========================================== */
            $productStock = ProductStock::where('product_id', $productId)
                ->where('company_id', $companyId)
                ->where('branch_id', $branchId)
                ->first();

            if ($productStock) {
                $productStock->quantity -= $poItem->quantity;
                $productStock->save();
            }

            /** ===========================================
             * 2. HAPUS STOCK HISTORY IN
             * =========================================== */
            ProductStockHistory::where('purchase_order_item_id', $poItem->id)
                ->where('company_id', $companyId)
                ->where('branch_id', $branchId)
                ->where('type', 'in')
                ->delete();

            /** ===========================================
             * 3. HAPUS PRODUCT PRICE HISTORY
             * =========================================== */
            ProductPriceHistory::where('purchase_order_item_id', $poItem->id)
                ->where('company_id', $companyId)
                ->where('branch_id', $branchId)
                ->delete();

            // Recalculate HPP Average
            $remainingHistories = ProductPriceHistory::where('product_id', $productId)
                ->where('company_id', $companyId)
                ->where('branch_id', $branchId)
                ->get();

            $newHppAverage = 0;
            if ($remainingHistories->count() > 0) {
                $sumQuantity = $remainingHistories->sum('quantity');
                $sumSubTotalPrice = $remainingHistories->sum('sub_total_price');
                $newHppAverage = $sumQuantity > 0 ? $sumSubTotalPrice / $sumQuantity : 0;
            }

            ProductPrice::where('product_id', $productId)
                ->where('company_id', $companyId)
                ->where('branch_id', $branchId)
                ->update([
                    'hpp_average' => $newHppAverage,
                    'price_generate' => 0,
                    'recipe_generate' => 0,
                    'is_updated' => false,
                ]);
        }
    }

    public function addExpiredDate($detailIndex)
    {
        if (! isset($this->details[$detailIndex]['expired_dates'])) {
            $this->details[$detailIndex]['expired_dates'] = [];
        }

        $this->details[$detailIndex]['expired_dates'][] = [
            'expired_date' => null,
            'batch_number' => null,
            'stok' => null,
        ];
    }

    public function removeExpiredDate($detailIndex, $expiredIndex)
    {
        if (isset($this->details[$detailIndex]['expired_dates'][$expiredIndex])) {
            unset($this->details[$detailIndex]['expired_dates'][$expiredIndex]);
            $this->details[$detailIndex]['expired_dates'] = array_values($this->details[$detailIndex]['expired_dates']);
        }
    }

    public function validateExpiredDates()
    {
        foreach ($this->details as $index => $detail) {
            if (! isset($detail['expired_dates']) || empty($detail['expired_dates'])) {
                continue;
            }

            $productQuantity = $detail['quantity'] ? intval(Str::replace('.', '', $detail['quantity'])) : 0;
            $totalExpiredQty = 0;

            foreach ($detail['expired_dates'] as $expired) {
                $expiredQty = $expired['stok'] ? intval(Str::replace('.', '', $expired['stok'])) : 0;
                $totalExpiredQty += $expiredQty;
            }

            if ($totalExpiredQty > $productQuantity) {
                return AlertHelper::error('Gagal', 'Total kuantitas expired date ('.number_format($totalExpiredQty, 0, ',', '.').') melebihi kuantitas produk ('.number_format($productQuantity, 0, ',', '.').') pada item #'.($index + 1));
            }
        }

        return true;
    }

    public function confirmSubmit()
    {
        return AlertHelper::confirmSave('submit', 'Apakah Anda Yakin Ingin Membuat Purchase Order Ini?');
    }

    public function submit()
    {
        if (! $this->supplier_id) {
            return AlertHelper::error('Gagal', 'Supplier Harus Diisi');
        }
        if (count($this->details) == 0) {
            return AlertHelper::error('Gagal', 'Item Harus Diisi');
        }

        if (! $this->notes) {
            return AlertHelper::error('Gagal', 'Catatan Harus Diisi');
        }
        foreach ($this->details as $key => $detail) {
            $hna = $detail['hna'] ? intval(Str::replace('.', '', $detail['hna'])) : 0;
            $hna_ppn = $detail['hna_ppn'] ? intval(Str::replace('.', '', $detail['hna_ppn'])) : 0;

            if (! $detail['product_id']) {
                return AlertHelper::error('Gagal', 'Produk Harus Diisi');
            }
            if (! $detail['quantity'] || intval(Str::replace('.', '', $detail['quantity'])) <= 0) {
                return AlertHelper::error('Gagal', 'Kuantitas Harus Diisi dan Lebih dari 0');
            }
            if ($hna <= 0 || $hna_ppn <= 0) {
                return AlertHelper::error('Gagal', 'HNA Harus Diisi dan Lebih dari 0');
            }
        }

        // Validate expired dates
        $validation = $this->validateExpiredDates();
        if ($validation !== true) {
            return $validation; // Return error message
        }

        try {
            \DB::beginTransaction();
            $this->saveToDatabase();
            \DB::commit();

            return redirect()->route('user.logistic.direct-purchase');
        } catch (Exception $e) {
            \DB::rollBack();
            Log::info('error : '.$e->getMessage());

            return AlertHelper::error('Gagal', $e->getMessage() ?? 'Terjadi Kesalahan');
        }
    }

    private function saveToDatabase()
    {
        $branchId = Branch::where('company_id', Auth::user()->company_id)->first()?->id;

        // Simpan PR
        $purchase_requisition = PurchaseRequisition::updateOrCreate(
            ['id' => $this->purchase_requisition_id],
            [
                'user_id' => Auth::id(),
                'supplier_id' => $this->supplier_id,
                'grand_total' => intval(Str::replace('.', '', $this->grand_total)),
                'type' => 'direct',
                'company_id' => Auth::user()->company_id,
                'branch_id' => $branchId,
                'status' => 'success',
                'notes' => $this->notes,
            ]
        );

        // Simpan / update PO
        $purchaseOrder = PurchaseOrder::updateOrCreate(
            ['id' => $purchase_requisition->purchase_order_id],
            [
                'user_id' => Auth::id(),
                'supplier_id' => $this->supplier_id,
                'grand_total' => $purchase_requisition->grand_total,
                'company_id' => Auth::user()->company_id,
                'branch_id' => $branchId,
                'status' => 'success',
                'number' => $this->number_purchase_order ?? 'PO-'.date('Ymd').'-'.Str::upper(Str::random(5)),
            ]
        );

        $purchase_requisition->purchase_order_id = $purchaseOrder->id;

        // Handle deleted items if in Edit mode
        if ($this->purchase_requisition_id) {
            $existingItemIds = PurchaseRequisitionItem::where('purchase_requisition_id', $this->purchase_requisition_id)->pluck('id')->toArray();
            $currentItemIds = array_filter(array_column($this->details, 'id'));
            $deletedItemIds = array_diff($existingItemIds, $currentItemIds);

            foreach ($deletedItemIds as $deletedId) {
                $this->rollbackSingleItem($deletedId);
                PurchaseRequisitionItem::where('id', $deletedId)->delete();
                PurchaseOrderItem::where('purchase_requisition_item_id', $deletedId)->delete();
            }
        }

        // Simpan items
        foreach ($this->details as $key => $detail) {
            $quantity = $detail['quantity'] ? intval(Str::replace('.', '', $detail['quantity'])) : 0;
            $hna = $detail['hna'] ? intval(Str::replace('.', '', $detail['hna'])) : 0;
            $ppn = $detail['ppn'] ? intval(Str::replace('.', '', $detail['ppn'])) : 0;
            $hna_ppn = $detail['hna_ppn'] ? intval(Str::replace('.', '', $detail['hna_ppn'])) : 0;
            $price = $detail['price'] ? intval(Str::replace('.', '', $detail['price'])) : 0;
            $discount = $detail['discount'] ? intval(Str::replace('.', '', $detail['discount'])) : 0;
            $discount_type = $detail['discount_type'] ?? 'percentage';

            if ($discount_type == 'percentage') {
                $discount_value = $detail['discount_value'] ? floatval(str_replace(',', '.', $detail['discount_value'])) : 0;
            } else {
                $discount_value = $detail['discount_value'] ? intval(Str::replace('.', '', $detail['discount_value'])) : 0;
            }
            $sub_total = $detail['sub_total'] ? intval(Str::replace('.', '', $detail['sub_total'])) : 0;
            $total = $detail['total'] ? intval(Str::replace('.', '', $detail['total'])) : 0;

            // If Edit, rollback OLD stock impact before saving new
            if ($detail['id']) {
                $this->rollbackSingleItem($detail['id']);
            }

            $purchase_requisition_item = PurchaseRequisitionItem::updateOrCreate(
                ['id' => $detail['id']],
                [
                    'purchase_requisition_id' => $purchase_requisition->id,
                    'product_id' => $detail['product_id'],
                    'product_name' => $detail['product_name'] ?? '-',
                    'quantity' => $quantity,
                    'quantity_real' => $quantity,
                    'company_id' => Auth::user()->company_id,
                    'branch_id' => $branchId,
                    'type' => 'purchase',
                ]
            );

            $productUnit = ProductUnit::where('company_id', Auth::user()->company_id)->where('product_id', $detail['product_id'])->first();

            if (! $productUnit) {
                $productUnit = ProductUnit::create([
                    'product_id' => $detail['product_id'],
                    'unit_id' => Product::find($detail['product_id'])?->unit_id ?? Unit::where('name', 'Pcs')->first()?->id,
                    'quantity' => 1,
                    'company_id' => Auth::user()->company_id,
                ]);
            }

            $netTotal = max(0, $sub_total - $discount);
            $netUnitPrice = $quantity > 0 ? ($netTotal / $quantity) : $price;

            $purchaseOrderItem = PurchaseOrderItem::updateOrCreate(
                ['purchase_requisition_item_id' => $purchase_requisition_item->id],
                [
                    'purchase_order_id' => $purchaseOrder->id,
                    'purchase_requisition_item_id' => $purchase_requisition_item->id,
                    'product_unit_id' => $productUnit->id,
                    'product_id' => $detail['product_id'],
                    'product_name' => $detail['product_name'] ?? '-',
                    'quantity' => $quantity,
                    'quantity_accepted' => $quantity,
                    'price' => $price,
                    'hna' => $hna,
                    'ppn' => $ppn,
                    'hna_ppn' => $hna_ppn,
                    'sub_total' => $sub_total,
                    'discount' => $discount,
                    'discount_type' => $discount_type,
                    'discount_value' => $discount_value,
                    'total' => $netTotal,
                    'company_id' => Auth::user()->company_id,
                ]
            );

            $this->getProductIncrement($purchaseOrderItem->product_id, $purchaseOrderItem->product_unit_id, $detail['expired_dates'] ?? [], $quantity, $netUnitPrice, $purchaseOrderItem->id, null, $quantity);
            $this->createProductPrice($purchaseOrderItem->product_id, $purchaseOrderItem->product_unit_id, $netUnitPrice, $quantity, $quantity, $purchaseOrderItem->id);
        }

        $calculatedGrandTotal = array_sum(array_column($this->details, 'total'));
        $purchase_requisition->grand_total = $calculatedGrandTotal;
        $purchase_requisition->save();

        if (isset($purchaseOrder)) {
            $purchaseOrder->grand_total = $calculatedGrandTotal;
            $purchaseOrder->save();
        }
    }

    public function render()
    {
        return view('livewire.admin.logistic.direct-purchase.detail.admin-logistic-direct-purchase-detail-index')
            ->extends('layout.app')
            ->section('content');
    }

    public function getProductIncrement($product_id, $product_unit_id, $batch_numbers, $quantity, $price, $purchase_order_item_id = null, $invoice_item_id = null, $product_unit_quantity = null)
    {
        $branch = $this->getBranchOne();
        $productUnit = ProductUnit::where('product_id', $product_id)->find($product_unit_id);

        $productUnitQuantity = $product_unit_quantity ? $product_unit_quantity : $quantity * $productUnit->quantity;

        $productUnitPrice = $price;

        $productStock = ProductStock::where('product_id', $product_id)
            ->where('company_id', Auth::user()->company_id)
            ->where('branch_id', $branch->id)
            ->first();

        if ($productStock) {
            $productStock->quantity += $productUnitQuantity;
            $productStock->save();
        } else {
            $productStock = new ProductStock;
            $productStock->product_id = $product_id;
            $productStock->branch_id = $branch->id;
            $productStock->company_id = Auth::user()->company_id;
            $productStock->quantity = $productUnitQuantity;
            $productStock->save();
        }

        if (! empty($batch_numbers)) {
            foreach ($batch_numbers as $key_batch_number => $batch_number) {
                // Validasi format tanggal expired_date
                try {
                    $formattedExpiredDate = Carbon::parse($batch_number['expired_date'])->format('Y-m-d');
                } catch (Exception $e) {
                    // Log error atau tambahkan lebih banyak informasi untuk debugging
                    throw new Exception("Invalid date format for batch number: {$batch_number['batch_number']} - {$e->getMessage()}");
                }

                // Query untuk mencari data yang sudah ada
                $productExpiredDate = ProductExpiredDate::where('product_id', $product_id)
                    ->where('branch_id', $branch->id)
                    ->where('company_id', Auth::user()->company_id)
                    ->where('batch_number', $batch_number['batch_number'])
                    ->where('product_stock_id', $productStock->id)
                    ->where('expired_date', $formattedExpiredDate)
                    ->first();

                if ($productExpiredDate) {
                    // Update jumlah stok jika data ditemukan
                    $productExpiredDate->quantity += $batch_number['stok'];
                    $productExpiredDate->save();
                } else {
                    // Buat data baru jika tidak ditemukan
                    ProductExpiredDate::create([
                        'product_stock_id' => $productStock->id,
                        'product_id' => $product_id,
                        'branch_id' => $branch->id,
                        'company_id' => Auth::user()->company_id,
                        'expired_date' => $formattedExpiredDate,
                        'batch_number' => $batch_number['batch_number'],
                        'quantity' => $batch_number['stok'],
                        'user_id' => Auth::user()->id,
                    ]);
                }
            }
        }

        // Generate code: IN/YYYYMMDD/00001
        $today = date('ymd'); // Tahun 2 digit
        $prefix = 'IN/'.$today.'/';

        $lastHistory = ProductStockHistory::where('code', 'ilike', $prefix.'%')
            ->where('company_id', Auth::user()->company_id)
            ->where('branch_id', $branch->id)
            ->orderBy('code', 'desc')
            ->first();

        if ($lastHistory && preg_match('/(\d{4})$/', $lastHistory->code, $matches)) {
            $lastNumber = intval($matches[1]);
            $nextNumber = str_pad($lastNumber + 1, 4, '0', STR_PAD_LEFT);
        } else {
            $nextNumber = '0001';
        }

        $code = $prefix.$nextNumber;

        $description = "Barang masuk: {$productUnitQuantity} unit pada ".date('d-m-Y')." (Kode: {$code}), harga per unit: {$productUnitPrice}.";

        ProductStockHistory::create([
            'product_id' => $product_id,
            'product_stock_id' => $productStock->id,
            'branch_id' => $branch->id,
            'code' => $code,
            'date' => Carbon::now(),
            'product_unit_id' => $product_unit_id,
            'purchase_order_item_id' => $purchase_order_item_id,
            'invoice_item_id' => $invoice_item_id,
            'description' => $description,
            'company_id' => Auth::user()->company_id,
            'quantity' => $productUnitQuantity,
            'price' => $productUnitPrice,
            'sub_total_price' => $productUnitPrice * $productUnitQuantity,
            'type' => 'in',
            'user_id' => Auth::user()->id,
        ]);
    }

    public function createProductPrice($product_id, $product_unit_id, $price, $quantity, $product_unit_quantity = null, $purchase_order_item_id = null)
    {
        $productUnit = ProductUnit::where('product_id', $product_id)->find($product_unit_id);

        $productUnitQuantity = $product_unit_quantity ? $product_unit_quantity : $quantity * $productUnit->quantity;

        $productUnitPrice = $price;

        $productPrice = ProductPrice::where('product_id', $product_id)->where('company_id', Auth::user()->company_id)->where('branch_id', $this->getBranchOne()->id)->first();

        if ($productPrice) {
            $productPrice->price_generate = 0;
            $productPrice->recipe_generate = 0;
            $productPrice->hpp_average = 0;
            $productPrice->is_updated = false;
            $productPrice->save();
        } else {
            $productPrice = new ProductPrice;
            $productPrice->product_id = $product_id;
            $productPrice->branch_id = $this->getBranchOne()->id;
            $productPrice->company_id = Auth::user()->company_id;
            $productPrice->price_generate = 0;
            $productPrice->recipe_generate = 0;
            $productPrice->hpp_average = 0;
            $productPrice->is_updated = false;
            $productPrice->save();
        }

        ProductPriceHistory::create([
            'product_id' => $product_id,
            'product_price_id' => $productPrice->id,
            'branch_id' => $this->getBranchOne()->id,
            'company_id' => Auth::user()->company_id,
            'price' => $productUnitPrice,
            'quantity' => $productUnitQuantity,
            'sub_total_price' => $productUnitPrice * $productUnitQuantity,
            'hpp_average' => ($productUnitPrice * $productUnitQuantity) / $productUnitQuantity,
            'is_updated' => false,
            'user_id' => Auth::user()->id,
            'purchase_order_item_id' => $purchase_order_item_id,
        ]);

        $productPriceHistorys = ProductPriceHistory::where('product_id', $product_id)->where('company_id', Auth::user()->company_id)->where('branch_id', $this->getBranchOne()->id)->get();

        $sumQuantity = $productPriceHistorys->sum('quantity');
        $sumSubTotalPrice = $productPriceHistorys->sum('sub_total_price');
        $hppAverage = $sumQuantity > 0 ? $sumSubTotalPrice / $sumQuantity : $productUnitPrice;

        $productPrice->hpp_average = $hppAverage;
        $productPrice->save();
    }
}
