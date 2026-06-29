<?php

namespace App\Livewire\Admin\Promotion;

use App\Helpers\AlertHelper;
use App\Helpers\PromotionHelper;
use App\Models\Company\Company;
use App\Models\Promotion\PromotionSimplified;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Livewire\WithPagination;

class AdminPromotionIndex extends Component
{
    use WithPagination;

    public $search = '';

    public $filterStatus = 'all'; // all, active, inactive, expired

    public $filterType = 'all'; // all, percentage, fixed_amount, free_shipping, buy_x_get_y

    public $filterCompany = 'all'; // all, specific company id

    public $perPage = 10;

    // Company selection
    public $companies = [];

    protected $queryString = [
        'search' => ['except' => ''],
        'filterStatus' => ['except' => 'all'],
        'filterType' => ['except' => 'all'],
        'filterCompany' => ['except' => 'all'],
    ];

    public function mount()
    {
        $this->loadCompanies();
    }

    public function loadCompanies()
    {
        $this->companies = Company::select('id', 'name')
            ->orderBy('name')
            ->get();
    }

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function updatingFilterStatus()
    {
        $this->resetPage();
    }

    public function updatingFilterType()
    {
        $this->resetPage();
    }

    public function updatingFilterCompany()
    {
        $this->resetPage();
    }

    public function getPromotionsProperty()
    {
        $currentUserCompanyId = Auth::user()->company_id ?? null;

        $query = PromotionSimplified::query();

        // Company filter sederhana dulu
        if ($this->filterCompany === 'all') {
            // Show all promotions for current user's company
            $query->where('company_id', $currentUserCompanyId);
        } else {
            // Show promotions for specific company
            $query->where('company_id', $this->filterCompany);
        }

        // Search filter
        if ($this->search) {
            $query->where(function ($q) {
                $q->where('name', 'ilike', '%'.$this->search.'%')
                    ->orWhere('code', 'ilike', '%'.$this->search.'%')
                    ->orWhere('description', 'ilike', '%'.$this->search.'%');
            });
        }

        // Status filter
        if ($this->filterStatus === 'active') {
            $query->where('is_active', true)
                ->where(function ($q) {
                    $q->whereNull('end_date')
                        ->orWhere('end_date', '>=', now());
                });
        } elseif ($this->filterStatus === 'inactive') {
            $query->where('is_active', false);
        } elseif ($this->filterStatus === 'expired') {
            $query->where('end_date', '<', now());
        }

        // Type filter
        if ($this->filterType !== 'all') {
            $query->where('type', $this->filterType);
        }

        return $query->orderBy('name', 'asc')
            ->paginate($this->perPage);
    }

    public function toggleStatus($promotionId)
    {
        $promotion = PromotionSimplified::find($promotionId);
        if ($promotion) {
            $promotion->update(['is_active' => ! $promotion->is_active]);

            return AlertHelper::success('Berhasil', 'Status promosi berhasil diubah.');
        }
    }

    public function confirmDelete($promotionId)
    {
        return AlertHelper::confirmDelete('delete', 'Apakah Anda yakin ingin menghapus promosi ini?', $promotionId);
    }

    public function delete($promotionId)
    {
        $promotion = PromotionSimplified::find($promotionId[0]);
        if ($promotion) {
            // Reset discounts before deleting if it's a discount_product type
            if ($promotion->type === 'discount_product') {
                try {
                    PromotionHelper::processDiscountProductPromotion($promotion);
                } catch (\Exception $e) {
                    \Log::warning("Failed to reset discounts for promotion {$promotion->id}: ".$e->getMessage());
                    // Continue with deletion even if discount reset fails
                }
            }

            $promotion->delete();

            return AlertHelper::success('Berhasil', 'Promosi berhasil dihapus dan discount telah direset.');
        }

        return AlertHelper::error('Error', 'Promosi tidak ditemukan.');
    }

    public function render()
    {
        return view('livewire.admin.promotion.admin-promotion-index', [
            'promotions' => $this->promotions,
            'companies' => $this->companies,
            'promotionTypes' => [
                'percentage' => '💰 Persentase (%)',
                'fixed_amount' => '💵 Nominal Tetap',
                'free_shipping' => '� Gratis Ongkir',
                'buy_x_get_y' => '🎁 Beli X Dapat Y',
            ],
            'statusOptions' => [
                'all' => 'Semua Status',
                'active' => 'Aktif',
                'inactive' => 'Nonaktif',
                'expired' => 'Kedaluwarsa',
            ],
            'companyOptions' => [
                'all' => 'Semua Company',
            ] + $this->companies->pluck('name', 'id')->toArray(),
        ])
            ->extends('layout.app')
            ->section('content');
    }
}
