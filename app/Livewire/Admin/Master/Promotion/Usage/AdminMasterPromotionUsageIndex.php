<?php

namespace App\Livewire\Admin\Master\Promotion\Usage;

use App\Models\Promotion\PromotionUsageHistory;
use Livewire\Component;
use Livewire\WithPagination;

class AdminMasterPromotionUsageIndex extends Component
{
    use WithPagination;

    public $search = '';
    public $promotionFilter = '';
    public $dateFilter = '';
    public $perPage = 10;

    protected $queryString = [
        'search' => ['except' => ''],
        'promotionFilter' => ['except' => ''],
        'dateFilter' => ['except' => ''],
    ];

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function updatingPromotionFilter()
    {
        $this->resetPage();
    }

    public function updatingDateFilter()
    {
        $this->resetPage();
    }

    public function render()
    {
        $query = PromotionUsageHistory::with(['promotion', 'customer'])
            ->latest('used_at');

        // Apply search filter
        if ($this->search) {
            $query->whereHas('promotion', function ($q) {
                $q->where('name', 'like', '%' . $this->search . '%')
                    ->orWhere('code', 'like', '%' . $this->search . '%');
            });
        }

        // Apply promotion filter
        if ($this->promotionFilter) {
            $query->where('promotion_id', $this->promotionFilter);
        }

        // Apply date filter
        if ($this->dateFilter) {
            $query->whereDate('used_at', $this->dateFilter);
        }

        $usageHistories = $query->paginate($this->perPage);

        // Get promotions for filter dropdown
        $promotions = \App\Models\Promotion\PromotionEvent::select('id', 'name')->get();

        return view('livewire.admin.master.promotion.usage.admin-master-promotion-usage-index', [
            'usageHistories' => $usageHistories,
            'promotions' => $promotions,
        ])->extends('layout.app')->section('content');
    }
}
