<?php

namespace App\Livewire\Admin\Logistic\ExpiredDate;

use App\Helpers\AlertHelper;
use App\Models\Notification;
use App\Models\Product\Product;
use App\Models\Product\ProductExpiredDate;
use App\Traits\Report\HasReportExportTrait;
use Auth;
use Carbon\Carbon;
use Livewire\Component;
use Livewire\WithPagination;

class AdminLogisticExpiredDateIndex extends Component
{
    use HasReportExportTrait, WithPagination;

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
        $this->showOnlyNotified = ! $this->showOnlyNotified;
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

            if (! $productExpiredDate) {
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
                $expiredDateStr = Carbon::parse($productExpiredDate->expired_date)->format('Y-m-d');
                $query->whereRaw("data->>'expired_date' = ?", [$expiredDateStr]);
            }

            $deletedNotificationCount = $query->delete();

            AlertHelper::success('Berhasil', 'Notifikasi berhasil dihapus.');

        } catch (\Exception $e) {
            AlertHelper::error('Gagal', 'Terjadi kesalahan saat menghapus notifikasi: '.$e->getMessage());
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

            if (! $productExpiredDate) {
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
                $expiredDateStr = Carbon::parse($productExpiredDate->expired_date)->format('Y-m-d');
                $query->whereRaw("data->>'expired_date' = ?", [$expiredDateStr]);
            }

            $query->delete();

            $productExpiredDate->delete();

            AlertHelper::success('Berhasil', 'Data expired date berhasil dihapus.');

        } catch (\Exception $e) {
            AlertHelper::error('Gagal', 'Terjadi kesalahan saat menghapus data: '.$e->getMessage());
        }
    }

    public function changeTab($tab): void
    {
        $this->showOnlyNotified = $tab;
        $this->resetPage();
    }

    protected function getFilteredQuery()
    {
        $products = ProductExpiredDate::search($this->search)
            ->with('product:id,name,sku_number,unit_id', 'product.unit:id,name');

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

        return $products;
    }

    public function exportExcel()
    {
        $items = $this->getFilteredQuery()->get();
        $headings = ['No', 'SKU Number', 'Nama Produk', 'Tanggal Kadaluarsa', 'Batch Number', 'Quantity', 'Satuan', 'Status'];
        $rows = [];
        $today = Carbon::now();

        foreach ($items as $idx => $item) {
            $exp = $item->expired_date ? Carbon::parse($item->expired_date) : null;
            $status = 'Aman';
            if ($exp) {
                if ($exp->isPast()) {
                    $status = 'Kadaluarsa';
                } elseif ($exp->diffInMonths($today) <= 3) {
                    $status = 'Mendekati Kadaluarsa (<= 3 Bulan)';
                }
            }

            $rows[] = [
                $idx + 1,
                $item->product->sku_number ?? '-',
                $item->product->name ?? '-',
                $item->expired_date ? date('d/m/Y', strtotime($item->expired_date)) : '-',
                $item->batch_number ?? '-',
                $item->quantity ?? 0,
                $item->product->unit->name ?? '-',
                $status,
            ];
        }

        return $this->exportExcelResponse('logistic_expired_date', $headings, $rows, 'Kadaluarsa');
    }

    public function exportPDF()
    {
        $items = $this->getFilteredQuery()->get();
        $columns = [
            ['label' => 'No', 'align' => 'center', 'width' => '30px'],
            ['label' => 'SKU', 'align' => 'left', 'width' => '80px'],
            ['label' => 'Nama Produk', 'align' => 'left'],
            ['label' => 'Tgl Kadaluarsa', 'align' => 'center', 'width' => '85px'],
            ['label' => 'Batch', 'align' => 'center', 'width' => '70px'],
            ['label' => 'Qty', 'align' => 'right', 'width' => '50px'],
            ['label' => 'Satuan', 'align' => 'center', 'width' => '50px'],
            ['label' => 'Status', 'align' => 'center', 'width' => '90px'],
        ];

        $rows = [];
        $totalQty = 0;
        $today = Carbon::now();

        foreach ($items as $idx => $item) {
            $qty = (float) ($item->quantity ?? 0);
            $totalQty += $qty;

            $exp = $item->expired_date ? Carbon::parse($item->expired_date) : null;
            $status = '<span style="color: #16a34a; font-weight: bold;">Aman</span>';
            if ($exp) {
                if ($exp->isPast()) {
                    $status = '<span style="color: #dc2626; font-weight: bold;">Kadaluarsa</span>';
                } elseif ($exp->diffInMonths($today) <= 3) {
                    $status = '<span style="color: #d97706; font-weight: bold;">< 3 Bulan</span>';
                }
            }

            $rows[] = [
                $idx + 1,
                e($item->product->sku_number ?? '-'),
                e($item->product->name ?? '-'),
                $item->expired_date ? date('d/m/Y', strtotime($item->expired_date)) : '-',
                e($item->batch_number ?? '-'),
                number_format($qty),
                e($item->product->unit->name ?? '-'),
                $status,
            ];
        }

        $totals = ['Total', '', '', '', '', number_format($totalQty), '', ''];

        return $this->exportPDFResponse('logistic_expired_date', 'Laporan Tanggal Kadaluarsa Produk', $columns, $rows, 'portrait', $totals);
    }

    public function render()
    {
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
                $expiredDateStr = Carbon::parse($item->expired_date)->format('Y-m-d');
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
