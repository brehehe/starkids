<?php

namespace App\Livewire\Admin\Report\TypeRecipe;

use App\Models\MedicineType\MedicineType;
use App\Models\Transaction\Transaction;
use App\Models\Transaction\TransactionRecipe;
use App\Models\User;
use App\Traits\Report\HasReportExportTrait;
use Carbon\Carbon;
use Livewire\Component;
use Livewire\WithPagination;

class AdminReportTypeRecipeIndex extends Component
{
    use HasReportExportTrait, WithPagination;

    public $start_date;

    public $end_date;

    public $patients = [];

    public $patient_id;

    public $medicine_types = [];

    public $medicine_type_id;

    public $perPage = 5;

    public function mount()
    {
        $this->start_date = Carbon::now()->startOfMonth()->format('Y-m-d');
        $this->end_date = Carbon::now()->endOfMonth()->format('Y-m-d');
        $this->patients = User::role(['Pasien'])->select('id', 'name')->get()->pluck('name', 'id')->toArray();
        $this->medicine_types = MedicineType::select('id', 'name')->get()->pluck('name', 'id')->toArray();
    }

    protected function getFilteredQuery()
    {
        $transactionRecipes = TransactionRecipe::select('id', 'transaction_id', 'medicine_type_id', 'price_service_one', 'price_service_other', 'created_at')
            ->with(['transaction:id,patient_id,code_consultation,code', 'transaction.patient:id,name', 'medicineType:id,name'])
            ->orderBy('created_at', 'DESC');

        if ($this->start_date && $this->end_date) {
            $transactionRecipes->whereBetween('created_at', [$this->start_date.' 00:00:00', $this->end_date.' 23:59:59']);
        }

        if ($this->patient_id) {
            $transactions = Transaction::where('patient_id', $this->patient_id)->pluck('id')->toArray();
            $transactionRecipes->whereIn('transaction_id', $transactions);
        }

        $transactionRecipes->when(
            $this->medicine_type_id,
            fn ($query) => $query->where('medicine_type_id', $this->medicine_type_id)
        );

        return $transactionRecipes;
    }

    public function exportExcel()
    {
        $items = $this->getFilteredQuery()->get();
        $headings = ['No', 'Kode Transaksi', 'Pasien', 'Jenis Resep', 'Biaya Jasa 1', 'Biaya Lainnya', 'Total Biaya', 'Tanggal'];
        $rows = [];

        foreach ($items as $idx => $item) {
            $p1 = (float) ($item->price_service_one ?? 0);
            $pOther = (float) ($item->price_service_other ?? 0);
            $rows[] = [
                $idx + 1,
                $item->transaction->code ?? '-',
                $item->transaction->patient->name ?? 'Umum',
                $item->medicineType->name ?? '-',
                $p1,
                $pOther,
                $p1 + $pOther,
                $item->created_at ? $item->created_at->format('d/m/Y') : '-',
            ];
        }

        return $this->exportExcelResponse('laporan_biaya_jasa', $headings, $rows, 'Biaya Jasa');
    }

    public function exportPDF()
    {
        $items = $this->getFilteredQuery()->get();
        $columns = [
            ['label' => 'No', 'align' => 'center', 'width' => '30px'],
            ['label' => 'Kode Transaksi', 'align' => 'left', 'width' => '90px'],
            ['label' => 'Pasien', 'align' => 'left'],
            ['label' => 'Jenis Resep', 'align' => 'left', 'width' => '90px'],
            ['label' => 'Biaya Jasa 1', 'align' => 'right', 'width' => '80px'],
            ['label' => 'Biaya Lainnya', 'align' => 'right', 'width' => '80px'],
            ['label' => 'Total Biaya', 'align' => 'right', 'width' => '85px'],
        ];

        $rows = [];
        $totalP1 = 0;
        $totalPOther = 0;
        $totalAll = 0;

        foreach ($items as $idx => $item) {
            $p1 = (float) ($item->price_service_one ?? 0);
            $pOther = (float) ($item->price_service_other ?? 0);
            $pSum = $p1 + $pOther;
            $totalP1 += $p1;
            $totalPOther += $pOther;
            $totalAll += $pSum;

            $rows[] = [
                $idx + 1,
                e($item->transaction->code ?? '-'),
                e($item->transaction->patient->name ?? 'Umum'),
                e($item->medicineType->name ?? '-'),
                'Rp '.number_format($p1),
                'Rp '.number_format($pOther),
                'Rp '.number_format($pSum),
            ];
        }

        $totals = ['Total', '', '', '', 'Rp '.number_format($totalP1), 'Rp '.number_format($totalPOther), 'Rp '.number_format($totalAll)];
        $period = ($this->start_date && $this->end_date) ? date('d/m/Y', strtotime($this->start_date)).' - '.date('d/m/Y', strtotime($this->end_date)) : null;

        return $this->exportPDFResponse('laporan_biaya_jasa', 'Laporan Biaya Jasa', $columns, $rows, 'portrait', $totals, $period);
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
            fn ($query) => $query->where('medicine_type_id', $this->medicine_type_id)
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
