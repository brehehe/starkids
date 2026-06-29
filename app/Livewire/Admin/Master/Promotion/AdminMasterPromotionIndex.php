<?php

namespace App\Livewire\Admin\Master\Promotion;

use App\Models\Promotion\PromotionSimplified;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Livewire\WithPagination;

class AdminMasterPromotionIndex extends Component
{
    use WithPagination;

    public $search = '';

    public $filterStatus = 'all'; // all, active, inactive, expired

    public $filterType = 'all'; // all, discount, buy_x_get_y, bundle, special

    public $perPage = 10;

    protected $queryString = [
        'search' => ['except' => ''],
        'filterStatus' => ['except' => 'all'],
        'filterType' => ['except' => 'all'],
    ];

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

    public function getPromotionsProperty()
    {
        $query = PromotionSimplified::query()
            ->where('company_id', Auth::user()->company_id ?? null);

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

        return $query->orderBy('created_at', 'desc')
            ->paginate($this->perPage);
    }

    public function toggleStatus($promotionId)
    {
        $promotion = PromotionSimplified::find($promotionId);
        if ($promotion) {
            $promotion->update(['is_active' => ! $promotion->is_active]);
            session()->flash('message', 'Status promosi berhasil diubah.');
        }
    }

    public function delete($promotionId)
    {
        $promotion = PromotionSimplified::find($promotionId);
        if ($promotion) {
            $promotion->delete();
            session()->flash('message', 'Promosi berhasil dihapus.');
        }
    }

    public function render()
    {
        return view('livewire.admin.master.promotion.admin-master-promotion-index', [
            'promotions' => $this->promotions,
            'promotionTypes' => [
                'discount' => '💰 Diskon',
                'buy_x_get_y' => '🎁 Beli X Dapat Y',
                'bundle' => '📦 Bundle',
                'special' => '⭐ Khusus',
            ],
            'statusOptions' => [
                'all' => 'Semua Status',
                'active' => 'Aktif',
                'inactive' => 'Nonaktif',
                'expired' => 'Kedaluwarsa',
            ],
        ])
            ->extends('layout.app')
            ->section('content');
    }
}
