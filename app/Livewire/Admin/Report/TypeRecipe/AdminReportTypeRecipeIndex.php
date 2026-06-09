<?php

namespace App\Livewire\Admin\Report\TypeRecipe;

use App\Models\MedicineType\MedicineType;
use App\Models\Transaction\Transaction;
use App\Models\Transaction\TransactionRecipe;
use App\Models\User;
use Livewire\Component;
use Carbon\Carbon;
use Livewire\WithPagination;

class AdminReportTypeRecipeIndex extends Component
{
    use WithPagination;
    public $start_date, $end_date, $patients = [], $patient_id, $medicine_types = [], $medicine_type_id, $perPage = 5;

    public function mount()
    {
        $this->start_date = Carbon::now()->startOfMonth()->format('Y-m-d');
        $this->end_date = Carbon::now()->endOfMonth()->format('Y-m-d');
        $this->patients = User::role(['Pasien'])->select('id', 'name')->get()->pluck('name', 'id')->toArray();
        $this->medicine_types = MedicineType::select('id', 'name')->get()->pluck('name', 'id')->toArray();
    }

    public function render()
    {
        $transactionRecipes = TransactionRecipe::select('id', 'transaction_id', 'medicine_type_id', 'price_service_one', 'price_service_other', 'created_at')
            ->with(['transaction:id,patient_id,code_consultation,code', 'transaction.patient:id,name', 'medicineType:id,name'])
            ->orderBy('created_at', 'DESC');

        if ($this->start_date && $this->end_date) {
            $transactionRecipes->whereBetween('created_at', [$this->start_date, $this->end_date]);
        }

        if ($this->patient_id) {
            $transactions = Transaction::where('patient_id', $this->patient_id)->pluck('id')->toArray();
            $transactionRecipes->whereIn('transaction_id', $transactions);
        }

        $transactionRecipes->when(
            $this->medicine_type_id,
            fn($query) =>
            $query->where('medicine_type_id', $this->medicine_type_id)
        );

        $total = (clone $transactionRecipes)->count();
        $totalPriceOne = (clone $transactionRecipes)->sum('price_service_one');
        $totalPriceOther = (clone $transactionRecipes)->sum('price_service_other');

        return view('livewire.admin.report.type-recipe.admin-report-type-recipe-index', [
            'total' => $total,
            'totalPriceOne' => $totalPriceOne,
            'totalPriceOther' => $totalPriceOther,
            'totalPrice' => $totalPriceOne + $totalPriceOther,
            'transactionRecipes' => (clone $transactionRecipes)->paginate($this->perPage),
        ])
            ->extends('layout.app')
            ->section('content');
    }
}
