<?php

namespace App\Livewire\Admin\Logistic\StockMutation;

use App\Helpers\AlertHelper;
use App\Models\StockMutation\StockMutation;
use Livewire\Component;
use Livewire\WithPagination;
use Session;

class AdminLogisticStockMutationIndex extends Component
{
    use WithPagination;

    protected $queryString = [
        // 'page' => ['except' => 1], // Ini akan menghapus ?page=1 dari URL
        'search' => ['except' => ''],
    ];

    public $search = '';

    public $perPage = 5;

    public function mount()
    {
        Session::forget('stock_mutation_id');

        if (session()->has('saved')) {
            AlertHelper::success(session('saved.title'), session('saved.text'));
            session()->forget('saved');

            return;
        }
    }

    public function edit($id)
    {
        Session::put('stock_mutation_id', $id);

        return redirect()->route('user.logistic.stock-mutation.detail');
    }

    public function render()
    {
        $stockMutations = StockMutation::search($this->search)
            ->with(['company', 'companyMain', 'companyBranch'])
            ->where('company_id', auth()->user()->company_id)
            ->orderBy('order', 'asc')
            ->paginate($this->perPage);

        return view('livewire.admin.logistic.stock-mutation.admin-logistic-stock-mutation-index', [
            'stockMutations' => $stockMutations,
        ])
            ->extends('layout.app')
            ->section('content');
    }
}
