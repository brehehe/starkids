<?php

namespace App\Livewire\Admin\Logistic\DirectPurchase;

use App\Helpers\AlertHelper;
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
use App\Traits\Branch\BranchTrait;
use App\Traits\Purchase\PurchaseRequisitionTrait;
use App\Traits\Supplier\SupplierTrait;
use Auth;
use Carbon\Carbon;
use DB;
use Exception;
use Livewire\Component;
use Livewire\WithPagination;
use Log;
use Session;

class AdminLogisticDirectPurchaseIndex extends Component
{
    use BranchTrait, PurchaseRequisitionTrait, SupplierTrait, WithPagination;

    protected $queryString = [
        // 'page' => ['except' => 1], // Ini akan menghapus ?page=1 dari URL
        'search' => ['except' => ''],
    ];

    public $search = '';

    public $perPage = 5;

    // Supplier
    public $suppliers;

    public function mount()
    {
        Session::forget('purchase_requisition_id');

        $this->suppliers = $this->getSuppliers();

        if (session()->has('saved')) {
            AlertHelper::success(session('saved.title'), session('saved.text'));
            session()->forget('saved');

            return;
        }
    }

    public function detail($id)
    {
        Session::put('purchase_requisition_id', $id);

        return redirect()->route('user.logistic.direct-purchase.detail');
    }

    public function confirmDelete($id)
    {
        return AlertHelper::confirmDelete('delete', 'Apakah Anda Yakin Menghapus Item Ini?', $id);
    }

    public function rollbackPurchaseRequisition($id)
    {
        $companyId = Auth::user()->company_id;
        $branchId = $this->getBranchOne()->id;

        $pr = PurchaseRequisition::with([
            'purchaseRequisitionItems',
            'purchaseOrder.purchaseOrderItems',
        ])->find($id);

        if (! $pr) {
            throw new Exception('Data PR tidak ditemukan.');
        }

        $po = $pr->purchaseOrder;

        foreach ($pr->purchaseRequisitionItems as $item) {

            $productId = $item->product_id;

            $poItem = $po && $po->purchaseOrderItems
                ? $po->purchaseOrderItems->where('purchase_requisition_item_id', $item->id)->first()
                : null;

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

                /** ===========================================
                 * 4. REKALKULASI HPP AVERAGE
                 * =========================================== */
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
                        'is_updated' => true,
                    ]);
            }
        }

        /** ===========================================
         * 5. HAPUS PO ITEM
         * =========================================== */
        PurchaseOrderItem::whereIn(
            'purchase_requisition_item_id',
            $pr->purchaseRequisitionItems->pluck('id')
        )->delete();

        /** ===========================================
         * 6. HAPUS PO
         * =========================================== */
        if ($pr->purchase_order_id) {
            PurchaseOrder::where('id', $pr->purchase_order_id)->delete();
        }

        /** ===========================================
         * 7. HAPUS PR ITEM & PR
         * =========================================== */
        PurchaseRequisitionItem::where('purchase_requisition_id', $id)->delete();
        PurchaseRequisition::where('id', $id)->delete();
    }

    public function getProductDecrement(
        $product_id,
        $product_unit_id,
        $batch_numbers,
        $quantity,
        $price,
        $sales_item_id = null,
        $invoice_item_id = null,
        $product_unit_quantity = null
    ) {
        $branch = $this->getBranchOne();
        $productUnit = ProductUnit::where('product_id', $product_id)->find($product_unit_id);

        // Hitung quantity dalam unit dasar
        $productUnitQuantity = $product_unit_quantity
            ? $product_unit_quantity
            : $quantity * $productUnit->quantity;

        $productUnitPrice = $price;

        // Ambil stock utama
        $productStock = ProductStock::where('product_id', $product_id)
            ->where('company_id', Auth::user()->company_id)
            ->where('branch_id', $branch->id)
            ->first();

        if (! $productStock) {
            throw new Exception("Stok tidak ditemukan untuk produk ID: {$product_id}");
        }

        // 🔻 Kurangi stock utama
        if ($productStock->quantity < $productUnitQuantity) {
            throw new Exception('Stok produk tidak cukup untuk dikurangi.');
        }

        $productStock->quantity -= $productUnitQuantity;
        $productStock->save();

        // 🔻 Kurangi Stock per BATCH (FIFO atau Manual Input)
        if (! empty($batch_numbers)) {
            foreach ($batch_numbers as $batch) {

                try {
                    $formattedExpiredDate = Carbon::parse($batch['expired_date'])->format('Y-m-d');
                } catch (Exception $e) {
                    throw new Exception("Invalid expired_date for batch: {$batch['batch_number']}");
                }

                $productExpired = ProductExpiredDate::where('product_id', $product_id)
                    ->where('branch_id', $branch->id)
                    ->where('company_id', Auth::user()->company_id)
                    ->where('batch_number', $batch['batch_number'])
                    ->where('product_stock_id', $productStock->id)
                    ->where('expired_date', $formattedExpiredDate)
                    ->first();

                if (! $productExpired) {
                    throw new Exception("Batch tidak ditemukan: {$batch['batch_number']}");
                }

                if ($productExpired->quantity < $batch['stok']) {
                    throw new Exception("Stok batch {$batch['batch_number']} tidak mencukupi.");
                }

                $productExpired->quantity -= $batch['stok'];
                $productExpired->save();
            }
        }

        // Generate code: OUT/YYYYMMDD/00001
        $today = date('ymd');
        $prefix = 'OUT/'.$today.'/';

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

        // Deskripsi
        $description = "Barang keluar: {$productUnitQuantity} unit pada ".date('d-m-Y')." (Kode: {$code})";

        // Simpan history OUT
        ProductStockHistory::create([
            'product_id' => $product_id,
            'product_stock_id' => $productStock->id,
            'branch_id' => $branch->id,
            'code' => $code,
            'date' => Carbon::now(),
            'product_unit_id' => $product_unit_id,
            'sales_item_id' => $sales_item_id,
            'invoice_item_id' => $invoice_item_id,
            'description' => $description,
            'company_id' => Auth::user()->company_id,
            'quantity' => $productUnitQuantity,
            'price' => $productUnitPrice,
            'sub_total_price' => $productUnitPrice * $productUnitQuantity,
            'type' => 'out', // ⬅⬅ TYPE DECREMENT
            'user_id' => Auth::user()->id,
        ]);

    }

    public function delete($data)
    {
        $itemId = $data[0];

        try {
            DB::beginTransaction();

            // rollback semua efek stock, price, history
            $this->rollbackPurchaseRequisition($itemId);

            DB::commit();

            return AlertHelper::success('Berhasil', 'Data berhasil dihapus & rollback stok.');
        } catch (Exception $e) {
            DB::rollBack();
            Log::error('Gagal rollback PR', [
                'id' => $itemId,
                'error' => $e->getMessage(),
            ]);

            return AlertHelper::error('Gagal', 'Error rollback data.');
        }
    }

    public function updatedStartDate($value)
    {
        $this->reset(['end_date']);
    }

    public function resetDates()
    {
        $this->reset(['start_date', 'end_date']);
    }

    public function render()
    {
        $purchaseRequisitions = PurchaseRequisition::search($this->search)
            ->select('id', 'number', 'status', 'company_id', 'grand_total', 'supplier_id', 'purchase_order_id', 'created_at', 'notes')
            ->with('company:id,name', 'supplier:id,name', 'purchaseOrder:id,number,status,grand_total')
            ->where('company_id', Auth::user()->company_id)
            ->where('type', 'direct');

        if ($this->supplier_id) {
            $purchaseRequisitions->where('supplier_id', $this->supplier_id);
        }

        if ($this->start_date) {
            $purchaseRequisitions->where('created_at', '>=', $this->start_date.' 00:00:00');
        }

        if ($this->end_date) {
            $purchaseRequisitions->where('created_at', '<=', $this->end_date.' 23:59:59');
        }

        // ⬇️ FIX: simpan hasil paginate
        $purchaseRequisitions = $purchaseRequisitions
            ->orderBy('order', 'desc')
            ->paginate($this->perPage);

        return view('livewire.admin.logistic.direct-purchase.admin-logistic-direct-purchase-index', [
            'purchaseRequisitions' => $purchaseRequisitions,
        ])
            ->extends('layout.app')
            ->section('content');
    }
}
