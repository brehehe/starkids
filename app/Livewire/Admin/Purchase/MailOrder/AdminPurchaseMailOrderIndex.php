<?php

namespace App\Livewire\Admin\Purchase\MailOrder;

use App\Helpers\AlertHelper;
use App\Models\PurchaseRequisition\PurchaseRequisition;
use App\Traits\Purchase\PurchaseRequisitionTrait;
use App\Traits\Supplier\SupplierTrait;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;
use Jantinnerezo\LivewireAlert\Facades\LivewireAlert;
use Livewire\Component;
use Livewire\WithPagination;

class AdminPurchaseMailOrderIndex extends Component
{
    use PurchaseRequisitionTrait, SupplierTrait, WithPagination;

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

        return redirect()->route('user.purchase.mail-order.detail');
    }

    public function confirmDeletePermanent($id)
    {
        return AlertHelper::confirmDelete('deletePermanent', 'Apakah Anda yakin ingin menghapus data ini secara permanen?', $id);
    }

    public function deletePermanent($data)
    {
        $itemId = $data[0];

        try {
            DB::beginTransaction();

            $purchaseRequisition = PurchaseRequisition::findOrFail($itemId);
            if ($purchaseRequisition) {
                $purchaseRequisition->delete();

                DB::commit();
                return AlertHelper::success('Berhasil', 'Surat Pesanan Berhasil Di hapus.');
            }

            DB::rollBack();
            Log::error('Product category not found for deletion', ['id' => $itemId]);
            return AlertHelper::error('Gagal', 'Data tidak ditemukan.');
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Error deleting Purchase Requisition', [
                'id' => $itemId,
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            return AlertHelper::error('Gagal', 'Terjadi kesalahan saat menghapus data.');
        }
    }

    public function confirmDelete($id)
    {
        return AlertHelper::confirmDelete('delete', 'Apakah Anda yakin ingin membatalkan Surat Pesanan ini?', $id);
    }

    public function delete($data)
    {
        $itemId = $data[0];

        try {
            DB::beginTransaction();

            $purchaseRequisition = PurchaseRequisition::findOrFail($itemId);
            if ($purchaseRequisition) {
                $purchaseRequisition->status = 'reject';
                $purchaseRequisition->save();

                DB::commit();
                return AlertHelper::success('Berhasil', 'Data berhasil Dibatalkan Surat Pesanan.');
            }

            DB::rollBack();
            Log::error('Product category not found for deletion', ['id' => $itemId]);
            return AlertHelper::error('Gagal', 'Data tidak ditemukan.');
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Error deleting Purchase Requisition', [
                'id' => $itemId,
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            return AlertHelper::error('Gagal', 'Terjadi kesalahan saat menghapus data.');
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
        $query = $this->getPurchaseRequisitionPaginates();

        return view('livewire.admin.purchase.mail-order.admin-purchase-mail-order-index', [
            'purchaseRequisitions' => $query,
        ])
            ->extends('layout.app')
            ->section('content');
    }
}
