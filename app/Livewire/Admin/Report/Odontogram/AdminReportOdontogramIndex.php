<?php

namespace App\Livewire\Admin\Report\Odontogram;

use App\Helpers\AlertHelper;
use App\Models\Transaction\Transaction;
use App\Models\Transaction\TransactionDetail;
use App\Models\User;
use Livewire\Component;
use Livewire\WithPagination;

class AdminReportOdontogramIndex extends Component
{
    use WithPagination;
    protected $paginationTheme = 'bootstrap';
    protected $queryString = [
        'patient_id' => ['except' => ''],
    ];

    public $patient_id;
    public $patients = [];
    public $odontogram_map = [];
    public $frequent_odontogram = null;
    public $perPage = 5;

    public function mount()
    {
        $this->patients = User::role('Pasien')
            ->where('company_id', auth()->user()->company_id)
            ->orderBy('name','asc')
            ->get();

        if ($this->patient_id) {
            $this->loadOdontogramData();
        }
    }

    public function updatedPatientId()
    {
        $this->resetPage();
        if ($this->patient_id) {
            $this->loadOdontogramData();
        } else {
            $this->reset(['odontogram_map', 'frequent_odontogram']);
        }
    }

    public function loadOdontogramData()
    {
        if (!$this->patient_id) return;

        // 1. Load Map (Current State)
        $details = TransactionDetail::whereHas('transaction', function ($query) {
            $query->where('patient_id', $this->patient_id);
        })
            ->whereNotNull('odontogram_code')
            ->orderBy('created_at', 'asc') // Replay history to get final state
            ->get();

        $this->odontogram_map = [];
        foreach ($details as $detail) {
            if ($detail->odontogram_code) {
                $this->odontogram_map[$detail->odontogram_code] = $detail->odontogram_color ?? '#3b82f6';
            }
        }

        // 2. Load Most Frequent
        $frequent = TransactionDetail::whereHas('transaction', function ($query) {
            $query->where('patient_id', $this->patient_id);
        })
            ->whereNotNull('odontogram_code')
            ->select('odontogram_code', \DB::raw('count(*) as total'))
            ->groupBy('odontogram_code')
            ->orderByDesc('total')
            ->take(5)
            ->get();

        $this->frequent_odontogram = $frequent;
    }

    public function render()
    {
        return view('livewire.admin.report.odontogram.admin-report-odontogram-index', [
            'historyOdontograms' => $this->getHistoryOdontograms(),
        ])
            ->extends('layout.app')
            ->section('content');
    }

    public function getHistoryOdontograms()
    {
        if (!$this->patient_id) {
            return collect();
        }

        return TransactionDetail::whereHas('transaction', function ($query) {
            $query->where('patient_id', $this->patient_id);
        })
            ->whereNotNull('odontogram_code')
            ->with(['transaction.doctor', 'product'])
            ->orderBy('created_at', 'desc')
            ->paginate($this->perPage);
    }
}
