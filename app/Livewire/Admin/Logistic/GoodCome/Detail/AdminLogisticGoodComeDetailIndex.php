<?php

namespace App\Livewire\Admin\Logistic\GoodCome\Detail;

use App\Helpers\AlertHelper;
use App\Models\PurchaseOrder\PurchaseOrder;
use App\Models\PurchaseOrder\PurchaseOrderItem;
use App\Models\SystemSetting\SystemSetting;
use App\Traits\Purchase\PurchaseOrderTrait;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Str;
use Livewire\Component;

class AdminLogisticGoodComeDetailIndex extends Component
{
    use PurchaseOrderTrait;

    public $purchase_order_id;

    public $purchase_order_item_id;

    public $purchase_order_item;

    public $quantity_arrival;

    public $hna;

    public $hna_ppn;

    public $price;

    public $sub_total;

    public $getQuantityAccepted;

    public $ppn;

    public $total;

    public $hna_old;

    public $hna_ppn_old;

    public $price_old;

    public $quantity_detail;

    public $ppn_old;

    public $discount;

    public $discount_type;

    public $discount_value;

    public $batch_numbers = [];

    public $items = [];

    public function mount()
    {
        $this->purchase_order_id = Session::get('purchase_order_id');
        $this->getDetails();
    }

    public function detail($id)
    {
        $this->purchase_order_item_id = $id;
        $this->purchase_order_item = $this->getPurchaseOrderItem($this->purchase_order_id, $this->purchase_order_item_id);
        $this->hna = number_format($this->purchase_order_item->hna, 0, '', '.');
        $this->hna_old = number_format($this->purchase_order_item->hna, 0, '', '.');
        $this->hna_ppn = number_format($this->purchase_order_item->hna_ppn, 0, '', '.');
        $this->hna_ppn_old = number_format($this->purchase_order_item->hna_ppn, 0, '', '.');
        $this->ppn = number_format($this->purchase_order_item->ppn, 0, '', '.');
        $this->ppn_old = number_format($this->purchase_order_item->ppn, 0, '', '.');
        $this->price = number_format($this->purchase_order_item->price, 0, '', '.');
        $this->price_old = number_format($this->purchase_order_item->price, 0, '', '.');
        $this->sub_total = number_format($this->purchase_order_item->sub_total, 0, '', '.');
        $this->discount = number_format($this->purchase_order_item->discount, 0, '', '.');
        $this->discount_type = $this->purchase_order_item->discount_type ?? 'percentage';
        $this->discount_value = $this->purchase_order_item->discount_value ?? 0;
        $this->total = number_format($this->purchase_order_item->total, 0, '', '.');
        $this->quantity_detail = $this->purchase_order_item->quantity;
        $this->dispatch('open-modal', ['id' => 'modalAccepted']);
    }

    public function closeModal()
    {
        $this->reset(['purchase_order_item_id', 'purchase_order_item', 'batch_numbers', 'quantity_arrival', 'hna', 'hna_ppn', 'price', 'sub_total', 'getQuantityAccepted', 'ppn', 'hna_old', 'hna_ppn_old', 'price_old', 'quantity_detail']);
        $this->dispatch('close-modal', ['id' => 'modalAccepted']);
    }

    public function updatedQuantityArrival()
    {
        $this->quantity_arrival = $this->quantity_arrival ?? 0;
        $this->quantity_arrival = intval($this->quantity_arrival);
        $this->quantity_arrival = $this->quantity_arrival < 0 ? 0 : ($this->quantity_arrival > $this->purchase_order_item->quantity_less ? $this->purchase_order_item->quantity_less : $this->quantity_arrival);

        if ($this->quantity_arrival > 0) {
            $this->addBatchNumber();
        } else {
            $this->reset(['batch_numbers']);
        }
    }

    public function updatedDiscountType()
    {
        $this->reset(['discount_value', 'discount']);
        $this->changePrice();
    }

    public function updatedDiscountValue()
    {
        $this->changePrice();
    }

    public function deleteBatchNumber($key)
    {
        unset($this->batch_numbers[$key]);
        $this->batch_numbers = array_values($this->batch_numbers);
        $this->updatedBatchNumbers();
    }

    public function addBatchNumber()
    {
        $this->batch_numbers[] = [
            'expired_date' => date('Y-m-d', strtotime('+360 days')),
            'batch_number' => null,
            'stok' => null,
        ];
    }

    public function updatedBatchNumbers()
    {
        $quantity_arrival = $this->quantity_arrival ? intval(Str::replace('.', '', $this->quantity_arrival)) : 0;

        $groupedBatches = [];
        $totalStok = 0;

        // Step 1: Group batch numbers by 'expired_date' and 'batch_number', while summing up 'stok'
        foreach ($this->batch_numbers as $batch) {
            $expiredDate = $batch['expired_date'];
            $batchNumber = $batch['batch_number'];
            $stok = $batch['stok'] ? $batch['stok'] : 0;

            // Jika total stok sudah melebihi $quantity_arrival, hentikan proses penambahan stok
            if ($totalStok + $stok > $quantity_arrival) {
                $stok = max(0, $quantity_arrival - $totalStok);
            }

            // Jika stok setelah penghitungan lebih dari nol, tambahkan ke groupedBatches
            if ($stok > 0) {
                if (! isset($groupedBatches[$expiredDate][$batchNumber])) {
                    $groupedBatches[$expiredDate][$batchNumber] = [
                        'expired_date' => $expiredDate,
                        'batch_number' => $batchNumber,
                        'stok' => 0,
                    ];
                }

                // Tambahkan stok ke batch yang sesuai
                $groupedBatches[$expiredDate][$batchNumber]['stok'] += $stok;
                $totalStok += $stok;
            }

            // Jika stok sudah mencapai batas $quantity_arrival, hentikan iterasi
            if ($totalStok >= $quantity_arrival) {
                break;
            }
        }

        // Step 2: Flatten groupedBatches into a single array
        $flattenedBatches = [];
        foreach ($groupedBatches as $batchesByDate) {
            foreach ($batchesByDate as $batch) {
                $flattenedBatches[] = $batch;
            }
        }

        // Step 3: Update class properties
        $this->batch_numbers = $flattenedBatches;
        $this->getQuantityAccepted = $totalStok;
    }

    public function updatedHna()
    {
        $this->changePrice();
    }

    public function updatedHnaPpn()
    {
        $this->changePrice();
    }

    public function updatedPrice()
    {
        $this->changePrice();
    }

    public function changePrice()
    {
        $hna = $this->hna ? intval(Str::replace('.', '', $this->hna)) : 0;
        $hna_old = $this->hna_old ? intval(Str::replace('.', '', $this->hna_old)) : 0;
        $ppn = $this->ppn ? intval(Str::replace('.', '', $this->ppn)) : 0;
        $ppn_old = $this->ppn_old ? intval(Str::replace('.', '', $this->ppn_old)) : 0;
        $hna_ppn = $this->hna_ppn ? intval(Str::replace('.', '', $this->hna_ppn)) : 0;
        $hna_ppn_old = $this->hna_ppn_old ? intval(Str::replace('.', '', $this->hna_ppn_old)) : 0;
        $quantity_detail = $this->quantity_detail ? intval(Str::replace('.', '', $this->quantity_detail)) : 0;

        $price = 0;

        $ppn_percentage = SystemSetting::where('company_id', Auth::user()->company_id)->first()->tax ?? 11; // Default to 11 if no tax is set

        if ($hna != $hna_old) {
            $hna_ppn = ($hna * ($ppn_percentage / 100)) + $hna; // Calculate HNA including PPN
            $ppn = $hna * ($ppn_percentage / 100);             // Calculate PPN
            $price = $hna_ppn;                                 // Use HNA including PPN as the price
        } else {
            if ($hna_ppn != $hna_ppn_old) {
                $hna = $hna_ppn / (1 + $ppn_percentage / 100); // Calculate HNA from HNA including PPN
                $ppn = $hna * ($ppn_percentage / 100);         // Calculate PPN
                $price = $hna_ppn;                             // Use HNA including PPN as the price
            } else {
                $price = $hna_ppn;                             // Use HNA including PPN as the price
            }
            $price = $hna_ppn; // Use HNA including PPN as the price
        }

        $this->hna = number_format($hna, 0, ',', '.');
        $this->hna_old = number_format($hna, 0, ',', '.');
        $this->hna_ppn = number_format($hna_ppn, 0, ',', '.');
        $this->hna_ppn_old = number_format($hna_ppn, 0, ',', '.');
        $this->ppn = number_format($ppn, 0, ',', '.');
        $this->ppn_old = number_format($ppn, 0, ',', '.');
        $this->price = number_format($price, 0, ',', '.');
        $this->price_old = number_format($price, 0, ',', '.');
        $this->discount = number_format($this->discount, 0, ',', '.');
        $this->discount_type = $this->discount_type ?? 'percentage';
        $this->discount_value = $this->discount_value ?? 0;
        $this->sub_total = number_format($price * $quantity_detail, 0, ',', '.');
        $sub_total = $price * $quantity_detail;
        $discount = 0;
        if ($this->discount_value) {
            $discount_value = $this->discount_value ? intval(Str::replace('.', '', $this->discount_value)) : 0;
            if ($this->discount_type == 'percentage') {
                if ($discount_value > 100) {
                    $this->discount_value = 100;
                    $this->discount = number_format(($sub_total * 100) / 100, 0, ',', '.');
                } elseif ($discount_value < 0) {
                    $this->discount_value = 0;
                    $this->discount = 0;
                } else {
                    $this->discount_value = $discount_value;
                    $this->discount = number_format(($sub_total * $discount_value) / 100, 0, ',', '.');
                }
            } else {
                $this->discount = $discount_value;
            }

            $discount = $this->discount ? intval(Str::replace('.', '', $this->discount)) : 0;
        }
        $this->total = $discount ? number_format($sub_total - $discount, 0, ',', '.') : number_format($sub_total, 0, ',', '.');
    }

    public function saveProduct()
    {
        $validation = $this->validateInputPurchaseOrder();
        if ($validation !== true) {
            // Jika validasi gagal, return error dan hentikan eksekusi berikutnya
            return $validation;
        }

        $this->hna = $this->hna ? intval(Str::replace('.', '', $this->hna)) : 0;
        $this->hna_ppn = $this->hna_ppn ? intval(Str::replace('.', '', $this->hna_ppn)) : 0;
        $this->price = $this->price ? intval(Str::replace('.', '', $this->price)) : 0;
        $this->sub_total = $this->sub_total ? intval(Str::replace('.', '', $this->sub_total)) : 0;
        $this->total = $this->total ? intval(Str::replace('.', '', $this->total)) : 0;
        $this->discount = $this->discount ? intval(Str::replace('.', '', $this->discount)) : 0;
        $this->discount_type = $this->discount_type ?? 'percentage';
        $this->discount_value = $this->discount_value ?? 0;
        $this->quantity_arrival = $this->quantity_arrival ? intval(Str::replace('.', '', $this->quantity_arrival)) : 0;

        DB::beginTransaction();
        try {
            $this->createGoodCome();

            $grand_total = 0;
            foreach ($this->items as $item) {
                $purchaseOrderItem = PurchaseOrderItem::find($item['id']);
                if ($purchaseOrderItem) {
                    $purchaseOrderItem->update([
                        'hna' => intval(Str::replace('.', '', $item['hna'])),
                        'hna_ppn' => intval(Str::replace('.', '', $item['hna_ppn'])),
                        'price' => intval(Str::replace('.', '', $item['price'])),
                        'sub_total' => intval(Str::replace('.', '', $item['sub_total'])),
                        'total' => intval(Str::replace('.', '', $item['total'])),
                        'ppn' => intval(Str::replace('.', '', $item['ppn'])),
                        'ppn_total' => intval(Str::replace('.', '', $item['ppn'])) * $purchaseOrderItem->quantity,
                        'hna_ppn_total' => intval(Str::replace('.', '', $item['hna_ppn'])) * $purchaseOrderItem->quantity,
                        'hna_total' => intval(Str::replace('.', '', $item['hna'])) * $purchaseOrderItem->quantity,
                        'discount' => intval(Str::replace('.', '', $item['discount'])),
                        'discount_type' => $item['discount_type'],
                        'discount_value' => intval(Str::replace('.', '', $item['discount_value'])),
                    ]);
                }
                $grand_total += intval(Str::replace('.', '', $item['total']));
            }
            $purchaseOrder = PurchaseOrder::where('id', $this->purchase_order_id)->first();
            $purchaseOrder->update([
                'grand_total' => $grand_total,
            ]);

            $this->getDetails();
            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Error saving product: '.$e->getMessage());

            return AlertHelper::error('Gagal', 'Terjadi kesalahan: '.$e->getMessage());
        }

        AlertHelper::success('Berhasil', 'Data berhasil disimpan');

        return $this->closeModal();
    }

    public function confirmSave()
    {
        return AlertHelper::confirmSave('save', 'Apakah Anda yakin ingin menyimpan data ini?');
    }

    public function save()
    {
        $grand_total = 0;
        foreach ($this->items as $item) {
            $purchaseOrderItem = PurchaseOrderItem::find($item['id']);
            if ($purchaseOrderItem) {
                $hna = $item['hna'] ? intval(Str::replace('.', '', $item['hna'])) : 0;
                $hna_ppn = $item['hna_ppn'] ? intval(Str::replace('.', '', $item['hna_ppn'])) : 0;
                $price = $item['price'] ? intval(Str::replace('.', '', $item['price'])) : 0;
                $sub_total = $item['sub_total'] ? intval(Str::replace('.', '', $item['sub_total'])) : 0;
                $total = $item['total'] ? intval(Str::replace('.', '', $item['total'])) : 0;
                $ppn = $item['ppn'] ? intval(Str::replace('.', '', $item['ppn'])) : 0;
                $discount = $item['discount'] ? intval(Str::replace('.', '', $item['discount'])) : 0;
                $discount_type = $item['discount_type'] ?? 'percentage';
                $discount_value = $item['discount_value'] ? intval(Str::replace('.', '', $item['discount_value'])) : 0;

                $purchaseOrderItem->update([
                    'hna' => $hna,
                    'hna_ppn' => $hna_ppn,
                    'price' => $price,
                    'sub_total' => $sub_total,
                    'total' => $total,
                    'ppn' => $ppn,
                    'ppn_total' => $ppn * $purchaseOrderItem->quantity,
                    'hna_ppn_total' => $hna_ppn * $purchaseOrderItem->quantity,
                    'hna_total' => $hna * $purchaseOrderItem->quantity,
                    'discount' => $discount,
                    'discount_type' => $discount_type,
                    'discount_value' => $discount_value,
                ]);
            }
            $grand_total += $total;
        }
        $purchaseOrder = PurchaseOrder::where('id', $this->purchase_order_id)->first();
        $purchaseOrder->update([
            'grand_total' => $grand_total,
        ]);

        $purchaseOrder = $this->getPurchaseOrder($this->purchase_order_id);
        $purchaseOrder->status = 'success';
        $purchaseOrder->save();

        AlertHelper::success('Berhasil', 'Data berhasil disimpan');

        sleep(2);

        return redirect()->route('user.logistic.good-come');
    }

    public function getDetails()
    {
        $this->items = [];

        $details = PurchaseOrderItem::where('purchase_order_id', $this->purchase_order_id)
            ->with(['product', 'productUnit.unit'])
            ->get();

        foreach ($details as $detail) {
            $this->items[] = [
                'id' => $detail->id,
                'name_product' => $detail->product->name,
                'quantity' => $detail->quantity,
                'quantity_accepted' => $detail->quantity_accepted,
                'hna' => number_format($detail->hna, 0, ',', '.'),
                'hna_old' => number_format($detail->hna, 0, ',', '.'),
                'hna_ppn' => number_format($detail->hna_ppn, 0, ',', '.'),
                'hna_ppn_old' => number_format($detail->hna_ppn, 0, ',', '.'),
                'price' => number_format($detail->price, 0, ',', '.'),
                'sub_total' => number_format($detail->sub_total, 0, ',', '.'),
                'total' => number_format($detail->total, 0, ',', '.'),
                'ppn' => number_format($detail->ppn, 0, ',', '.'),
                'ppn_old' => number_format($detail->ppn, 0, ',', '.'),
                'discount' => number_format($detail->discount, 0, ',', '.'),
                'discount_type' => $detail->discount_type,
                'discount_value' => number_format($detail->discount_value, 0, ',', '.'),
                'productUnit' => [
                    'unit' => [
                        'name' => $detail->productUnit->unit->name,
                    ],
                ],
            ];
        }
    }

    public function updatedItems()
    {
        foreach ($this->items as $index => $item) {
            $quantity_detail = $item['quantity'] ? intval(Str::replace('.', '', $item['quantity'])) : 0;
            $hna = $item['hna'] ? intval(Str::replace('.', '', $item['hna'])) : 0;
            $hna_old = $item['hna_old'] ? intval(Str::replace('.', '', $item['hna_old'])) : 0;
            $ppn = $item['ppn'] ? intval(Str::replace('.', '', $item['ppn'])) : 0;
            $ppn_old = $item['ppn_old'] ? intval(Str::replace('.', '', $item['ppn_old'])) : 0;
            $hna_ppn = $item['hna_ppn'] ? intval(Str::replace('.', '', $item['hna_ppn'])) : 0;
            $hna_ppn_old = $item['hna_ppn_old'] ? intval(Str::replace('.', '', $item['hna_ppn_old'])) : 0;
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
            $this->items[$index]['hna'] = number_format($hna, 0, ',', '.');
            $this->items[$index]['hna_old'] = number_format($hna, 0, ',', '.');
            $this->items[$index]['hna_ppn'] = number_format($hna_ppn, 0, ',', '.');
            $this->items[$index]['hna_ppn_old'] = number_format($hna_ppn, 0, ',', '.');
            $this->items[$index]['ppn'] = number_format($ppn, 0, ',', '.');
            $this->items[$index]['ppn_old'] = number_format($ppn, 0, ',', '.');
            $this->items[$index]['price'] = number_format($price, 0, ',', '.');
            $this->items[$index]['price_old'] = number_format($price, 0, ',', '.');

            // Hitung subtotal
            $sub_total = $price * $quantity_detail;
            $this->items[$index]['sub_total'] = number_format($sub_total, 0, ',', '.');

            // Diskon
            $discount = 0;
            $discount_type = $item['discount_type'] ?? 'percentage';
            $discount_value = intval(Str::replace('.', '', $item['discount_value'] ?? 0));

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
            $this->items[$index]['discount_type'] = $discount_type;
            $this->items[$index]['discount_value'] = number_format($discount_value, 0, ',', '.');
            $this->items[$index]['discount'] = number_format($discount, 0, ',', '.');
            $this->items[$index]['total'] = number_format($sub_total - $discount, 0, ',', '.');
        }
    }

    public function confirmSavePrice()
    {
        return AlertHelper::confirmSave('savePrice', 'Apakah Anda yakin ingin menyimpan harga ini?');
    }

    public function savePrice()
    {
        $this->validate([
            'items.*.hna' => 'required',
            'items.*.hna_ppn' => 'required',
            'items.*.price' => 'required',
            'items.*.sub_total' => 'required',
            'items.*.total' => 'required',
        ]);

        DB::beginTransaction();
        try {
            $grand_total = 0;
            foreach ($this->items as $item) {
                $purchaseOrderItem = PurchaseOrderItem::find($item['id']);
                if ($purchaseOrderItem) {
                    $purchaseOrderItem->update([
                        'hna' => intval(Str::replace('.', '', $item['hna'])),
                        'hna_ppn' => intval(Str::replace('.', '', $item['hna_ppn'])),
                        'price' => intval(Str::replace('.', '', $item['price'])),
                        'sub_total' => intval(Str::replace('.', '', $item['sub_total'])),
                        'total' => intval(Str::replace('.', '', $item['total'])),
                        'ppn' => intval(Str::replace('.', '', $item['ppn'])),
                        'ppn_total' => intval(Str::replace('.', '', $item['ppn'])) * $purchaseOrderItem->quantity,
                        'hna_ppn_total' => intval(Str::replace('.', '', $item['hna_ppn'])) * $purchaseOrderItem->quantity,
                        'hna_total' => intval(Str::replace('.', '', $item['hna'])) * $purchaseOrderItem->quantity,
                        'discount' => intval(Str::replace('.', '', $item['discount'])),
                        'discount_type' => $item['discount_type'],
                        'discount_value' => intval(Str::replace('.', '', $item['discount_value'])),
                    ]);
                }
                $grand_total += intval(Str::replace('.', '', $item['total']));
            }
            $purchaseOrder = PurchaseOrder::where('id', $this->purchase_order_id)->first();
            $purchaseOrder->update([
                'grand_total' => $grand_total,
            ]);
            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Error saving price: '.$e->getMessage());

            return AlertHelper::error('Gagal', 'Terjadi kesalahan: '.$e->getMessage());
        }

        $this->getDetails();
        AlertHelper::success('Berhasil', 'Harga berhasil disimpan');

    }

    public function render()
    {
        return view(
            'livewire.admin.logistic.good-come.detail.admin-logistic-good-come-detail-index',
            [
                'purchaseOrder' => $this->getPurchaseOrder($this->purchase_order_id),
            ]
        )
            ->extends('layout.app')
            ->section('content');
    }
}
