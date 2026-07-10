<?php

namespace App\Livewire\Promotion;

use App\Models\Promotion\PromotionEvent;
use Livewire\Component;
use Livewire\WithPagination;

class PromotionList extends Component
{
    use WithPagination;

    public $search = '';

    public $type = '';

    public $status = '';

    public $sortBy = 'created_at';

    public $sortDirection = 'desc';

    public $perPage = 10;

    protected $queryString = [
        'search' => ['except' => ''],
        'type' => ['except' => ''],
        'status' => ['except' => ''],
        'sortBy' => ['except' => 'created_at'],
        'sortDirection' => ['except' => 'desc'],
    ];

    public function mount()
    {
        $this->resetPage();
    }

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function updatingType()
    {
        $this->resetPage();
    }

    public function updatingStatus()
    {
        $this->resetPage();
    }

    public function sortBy($field)
    {
        if ($this->sortBy === $field) {
            $this->sortDirection = $this->sortDirection === 'asc' ? 'desc' : 'asc';
        } else {
            $this->sortBy = $field;
            $this->sortDirection = 'asc';
        }
    }

    public function resetFilters()
    {
        $this->search = '';
        $this->type = '';
        $this->status = '';
        $this->sortBy = 'created_at';
        $this->sortDirection = 'desc';
        $this->resetPage();
    }

    public function toggleStatus($promotionId)
    {
        $promotion = PromotionEvent::findOrFail($promotionId);
        $promotion->update(['is_active' => ! $promotion->is_active]);

        $this->dispatch('promotion-updated', [
            'message' => 'Status promosi berhasil diubah',
            'type' => 'success',
        ]);
    }

    public function deletePromotion($promotionId)
    {
        try {
            $promotion = PromotionEvent::findOrFail($promotionId);

            // Check if promotion has been used
            if ($promotion->usage_count > 0) {
                $this->dispatch('promotion-error', [
                    'message' => 'Promosi tidak dapat dihapus karena sudah pernah digunakan',
                    'type' => 'error',
                ]);

                return;
            }

            $promotion->delete();

            $this->dispatch('promotion-deleted', [
                'message' => 'Promosi berhasil dihapus',
                'type' => 'success',
            ]);
        } catch (\Exception $e) {
            $this->dispatch('promotion-error', [
                'message' => 'Terjadi kesalahan saat menghapus promosi',
                'type' => 'error',
            ]);
        }
    }

    public function render()
    {
        $query = PromotionEvent::query()
            ->withCount('usageHistories');

        // Apply search filter
        if ($this->search) {
            $query->where(function ($q) {
                $q->where('name', 'ilike', '%'.$this->search.'%')
                    ->orWhere('code', 'ilike', '%'.$this->search.'%')
                    ->orWhere('description', 'ilike', '%'.$this->search.'%');
            });
        }

        // Apply type filter
        if ($this->type) {
            $query->where('type', $this->type);
        }

        // Apply status filter
        if ($this->status) {
            switch ($this->status) {
                case 'active':
                    $query->active();
                    break;
                case 'inactive':
                    $query->where('is_active', false);
                    break;
                case 'expired':
                    $query->expired();
                    break;
                case 'upcoming':
                    $query->upcoming();
                    break;
            }
        }

        // Apply sorting
        $query->orderBy($this->sortBy, $this->sortDirection);

        $promotions = $query->paginate($this->perPage);

        // Get promotion types for filter dropdown
        $promotionTypes = PromotionEvent::select('type')
            ->distinct()
            ->pluck('type')
            ->map(function ($type) {
                return [
                    'value' => $type,
                    'label' => ucfirst(str_replace('_', ' ', $type)),
                ];
            });

        return view('livewire.promotion.promotion-list', [
            'promotions' => $promotions,
            'promotionTypes' => $promotionTypes,
        ]);
    }
}
