<?php

namespace App\Livewire\Admin\Report\Polyclinic;

use App\Models\Transaction\Transaction;
use App\Models\Location\Location;
use Illuminate\Support\Facades\DB;
use Livewire\Component;
use Livewire\WithPagination;
use Session;

class AdminReportPolyclinicIndex extends Component
{
    use WithPagination;

    public $location_id;
    public $perPage = 10;
    public $polyclinics = [];

    // Modal state
    public bool $showModal = false;
    public $modalPolyName    = '';
    public $modalDoctorName  = '';
    public $modalPatientName = '';
    public $modalTransactions = [];

    protected $queryString = [
        'location_id' => ['except' => ''],
    ];

    public function mount()
    {
        $this->polyclinics = Location::whereIn('id', Transaction::whereNotNull('location_id')->distinct()->pluck('location_id'))
            ->select('id', 'name')
            ->orderBy('name')
            ->get();
    }

    public function viewDetail(string $location_id, string $doctor_id, string $patient_id): void
    {
        $transactions = Transaction::query()
            ->where('location_id', $location_id)
            ->where('doctor_id',   $doctor_id)
            ->where('patient_id',  $patient_id)
            ->where('status', 'completed')
            ->with(['location:id,name', 'doctor:id,name', 'patient:id,name'])
            ->orderByDesc('date')
            ->get(['id', 'code', 'date', 'location_id', 'doctor_id', 'patient_id', 'status', 'grand_total_price']);

        $first = $transactions->first();
        $this->modalPolyName    = $first?->location?->name ?? '-';
        $this->modalDoctorName  = $first?->doctor?->name   ?? '-';
        $this->modalPatientName = $first?->patient?->name  ?? '-';
        $this->modalTransactions = $transactions->map(fn($t) => [
            'code'        => $t->code ?? '-',
            'date'        => $t->date ? \Carbon\Carbon::parse($t->date)->locale('id')->isoFormat('D MMMM Y') : '-',
            'total_price' => number_format($t->grand_total_price, 0, ',', '.'),
            'id'          => $t->id,
            'detail_url'  => route('user.consultation.history.detail', ['transaction_id' => $t->id]),
        ])->toArray();

        $this->showModal = true;
    }

    public function closeModal(): void
    {
        $this->showModal = false;
    }

    public function render()
    {
        $baseQuery = Transaction::query()
            ->whereNotNull('location_id')
            ->whereNotNull('doctor_id')
            ->whereNotNull('patient_id')
            ->where('status', 'completed')
            ->when($this->location_id, function ($query) {
                $query->where('location_id', $this->location_id);
            });

        $details = (clone $baseQuery)
            ->with(['location:id,name', 'doctor:id,name', 'patient:id,name'])
            ->select('location_id', 'doctor_id', 'patient_id', DB::raw('count(*) as total_visits'), DB::raw('MAX(date) as last_visit'))
            ->groupBy('location_id', 'doctor_id', 'patient_id')
            ->orderBy('location_id')
            ->paginate($this->perPage);

        return view('livewire.admin.report.polyclinic.admin-report-polyclinic-index', [
            'details' => $details
        ])->extends('layout.app')->section('content');
    }

    public function openTransactionDetail($trx_id) {
        Session::put('transaction_id', $trx_id);
        return redirect()->route('user.consultation.consultation.detail');
    }
}
