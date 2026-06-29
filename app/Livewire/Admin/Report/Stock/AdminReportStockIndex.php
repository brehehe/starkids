<?php

namespace App\Livewire\Admin\Report\Stock;

use App\Models\Product\Product;
use App\Traits\Product\ProductStockTrait;
use Livewire\Component;
use Livewire\WithPagination;

class AdminReportStockIndex extends Component
{
    use ProductStockTrait, WithPagination;

    protected $queryString = [
        'start_date' => ['except' => ''],
        'end_date' => ['except' => ''],
        // 'page' => ['except' => 1], // Ini akan menghapus ?page=1 dari URL
        'search' => ['except' => ''],
    ];

    public $start_date;

    public $end_date;

    public $search = '';

    public $perPage = 5;

    public function mount()
    {
        $this->start_date = date('Y-m-d');
        $this->end_date = date('Y-m-d');
    }

    public function resetDates()
    {
        $this->reset(['start_date', 'end_date']);
    }

    public function getProductStocks()
    {
        return Product::search($this->search)
            ->with(['productStock' => function ($query) {
                $query->where('company_id', auth()->user()->company_id)
                    ->when($this->start_date, function ($query) {
                        $query->whereDate('created_at', '>=', $this->start_date);
                    })
                    ->when($this->end_date, function ($query) {
                        $query->whereDate('created_at', '<=', $this->end_date);
                    });
            }])
            ->paginate($this->perPage);
    }

    public function render()
    {
        return view(
            'livewire.admin.report.stock.admin-report-stock-index',
            [
                'products' => $this->getProductStocks(),
            ]
        )
            ->extends('layout.app')
            ->section('content');
    }
}
