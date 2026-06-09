<?php

namespace App\Livewire\Admin\Logistic\ExpiredDate;

use App\Helpers\AlertHelper;
use App\Models\Notification;
use App\Models\Product\Product;
use App\Models\Product\ProductExpiredDate;
use Auth;
use Livewire\Component;
use Livewire\WithPagination;

class AdminLogisticExpiredDateIndex extends Component
{

    use WithPagination;
    protected $queryString = [
        // 'page' => ['except' => 1], // Ini akan menghapus ?page=1 dari URL
        'search' => ['except' => ''],
        'showOnlyNotified' => ['except' => false],
    ];
    public $search = '';
    public $perPage = 5;
    public $start_date;
    public $end_date;
    public $products = [];
    public $product_id;
    public $showOnlyNotified = false;

    public function mount()
    {
        $this->start_date = now()->startOfMonth()->format('Y-m-d');
        $this->end_date = now()->endOfMonth()->format('Y-m-d');
        $this->products = Product::select('name', 'id')->where('company_id', Auth::user()->company_id)->get()->pluck('name', 'id');
    }

    public function resetDates()
    {
        $this->reset(['start_date', 'end_date']);
    }

    public function toggleNotificationFilter()
    {
        $this->showOnlyNotified = !$this->showOnlyNotified;
        $this->resetPage();
    }

    public function confirmDeleteNotification($productExpiredDateId)
    {
        return AlertHelper::confirmDelete('deleteNotification', 'Apakah Anda yakin ingin menghapus notifikasi ini?', $productExpiredDateId);
    }

    public function deleteNotification($productExpiredDateId)
    {
        try {
            $productExpiredDate = ProductExpiredDate::find($productExpiredDateId[0]);

            if (!$productExpiredDate) {
                AlertHelper::error('Gagal', 'Data expired date tidak ditemukan.');
                return;
            }

            // Build query to find matching notifications
            $query = Notification::where('type', 'product_expiry')
                ->whereRaw("data->>'product_id' = ?", [$productExpiredDate->product_id]);

            // Handle batch number (nullable)
            if ($productExpiredDate->batch_number) {
                $query->whereRaw("data->>'batch_number' = ?", [$productExpiredDate->batch_number]);
            } else {
                $query->whereRaw("(data->>'batch_number' IS NULL OR data->>'batch_number' = 'null')");
            }

            // Handle expired_date for precision
            if ($productExpiredDate->expired_date) {
                $expiredDateStr = \Carbon\Carbon::parse($productExpiredDate->expired_date)->format('Y-m-d');
                $query->whereRaw("data->>'expired_date' = ?", [$expiredDateStr]);
            }

            $deletedNotificationCount = $query->delete();

            AlertHelper::success('Berhasil', 'Notifikasi berhasil dihapus.');

        } catch (\Exception $e) {
            AlertHelper::error('Gagal', 'Terjadi kesalahan saat menghapus notifikasi: ' . $e->getMessage());
        }
    }

    public function confirmDeleteProductExpiredDate($productExpiredDateId)
    {
        return AlertHelper::confirmDelete('deleteProductExpiredDate', 'Apakah Anda yakin ingin menghapus data expired date ini?', $productExpiredDateId);
    }

    public function deleteProductExpiredDate($productExpiredDateId)
    {
        try {
            $productExpiredDate = ProductExpiredDate::find($productExpiredDateId[0]);

            if (!$productExpiredDate) {
                AlertHelper::error('Gagal', 'Data expired date tidak ditemukan.');
                return;
            }

            // Cleanup notifications
            // Cleanup notifications
            $query = Notification::where('type', 'product_expiry')
                ->whereRaw("data->>'product_id' = ?", [$productExpiredDate->product_id]);

            if ($productExpiredDate->batch_number) {
                 $query->whereRaw("data->>'batch_number' = ?", [$productExpiredDate->batch_number]);
            } else {
                 $query->whereRaw("(data->>'batch_number' IS NULL OR data->>'batch_number' = 'null')");
            }

            if ($productExpiredDate->expired_date) {
                $expiredDateStr = \Carbon\Carbon::parse($productExpiredDate->expired_date)->format('Y-m-d');
                $query->whereRaw("data->>'expired_date' = ?", [$expiredDateStr]);
            }

            $query->delete();

            $productExpiredDate->delete();

            AlertHelper::success('Berhasil', 'Data expired date berhasil dihapus.');

        } catch (\Exception $e) {
            AlertHelper::error('Gagal', 'Terjadi kesalahan saat menghapus data: ' . $e->getMessage());
        }
    }

    public function changeTab($tab): void
    {
        $this->showOnlyNotified = $tab;
        $this->resetPage();
    }

    public function render() {
        $products = ProductExpiredDate::search($this->search)
            ->with('product:id,name,sku_number,unit_id', 'company:id,name', 'branch:id,name', 'product.unit:id,name');

        // Filter by notification status if enabled
        if ($this->showOnlyNotified) {
            $products->whereHas('product', function ($query) {
                $query->whereRaw("id::text IN (
                    SELECT data->>'product_id'
                    FROM notifications
                    WHERE type = 'product_expiry'
                    AND is_read = false
                    AND deleted_at IS NULL
                )");
            });
        }

        if ($this->product_id) {
            $products->where('product_id', $this->product_id);
        }

        if ($this->start_date && $this->end_date) {
            $products->whereBetween('expired_date', [$this->start_date, $this->end_date]);
        }

        // Get notification data for each product
        $productExpiredDates = $products->paginate($this->perPage);

        // Attach notification info to each item
        foreach ($productExpiredDates as $item) {
            $query = Notification::where('type', 'product_expiry')
                ->whereRaw("data->>'product_id' = ?", [$item->product_id]);

            if ($item->batch_number) {
                $query->whereRaw("data->>'batch_number' = ?", [$item->batch_number]);
            } else {
                $query->whereRaw("(data->>'batch_number' IS NULL OR data->>'batch_number' = 'null')");
            }

            if ($item->expired_date) {
                $expiredDateStr = \Carbon\Carbon::parse($item->expired_date)->format('Y-m-d');
                $query->whereRaw("data->>'expired_date' = ?", [$expiredDateStr]);
            }

            $item->notification = $query->where('is_read', false)->first();
        }

        return view('livewire.admin.logistic.expired-date.admin-logistic-expired-date-index', [
            'productExpiredDates' => $productExpiredDates,
        ])
            ->extends('layout.app')
            ->section('content');
    }
}
