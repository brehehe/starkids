<?php

namespace App\Livewire\Admin\Report\DoctorPatient;

use App\Models\Transaction\Transaction;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Livewire\Component;
use Livewire\WithPagination;
use Session;

class AdminReportDoctorPatientIndex extends Component
{
    use WithPagination;

    public $doctor_id;
    public $perPage = 10;
    public $doctors = [];

    // Modal state
    public bool $showModal = false;
    public $modalDoctorName = '';
    public $modalPatientName = '';
    public $modalTransactions = [];

    protected $queryString = [
        'doctor_id' => ['except' => ''],
    ];

    public function mount()
    {
        $this->doctors = User::whereIn('id', Transaction::whereNotNull('doctor_id')->distinct()->pluck('doctor_id'))
            ->select('id', 'name')
            ->orderBy('name')
            ->get();
    }

    public function viewDetail(string $doctor_id, string $patient_id): void
    {
        $transactions = Transaction::query()
            ->where('doctor_id', $doctor_id)
            ->where('patient_id', $patient_id)
            ->where('status', 'completed')
            ->with(['doctor:id,name', 'patient:id,name'])
            ->orderByDesc('date')
            ->get(['id', 'code', 'date', 'doctor_id', 'patient_id', 'status', 'grand_total_price']);

        $first = $transactions->first();
        $this->modalDoctorName  = $first?->doctor?->name  ?? '-';
        $this->modalPatientName = $first?->patient?->name ?? '-';
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
            ->whereNotNull('doctor_id')
            ->whereNotNull('patient_id')
            ->where('status', 'completed')
            ->when($this->doctor_id, function ($query) {
                $query->where('doctor_id', $this->doctor_id);
            });

        $details = (clone $baseQuery)
            ->with(['doctor:id,name', 'patient:id,name'])
            ->select('doctor_id', 'patient_id', DB::raw('count(*) as total_visits'), DB::raw('MAX(date) as last_visit'))
            ->groupBy('doctor_id', 'patient_id')
            ->orderBy('doctor_id')
            ->paginate($this->perPage);

        return view('livewire.admin.report.doctor-patient.admin-report-doctor-patient-index', [
            'details' => $details
        ])->extends('layout.app')->section('content');
    }

    public function openTransactionDetail($trx_id) {
        Session::put('transaction_id', $trx_id);
        return redirect()->route('user.consultation.consultation.detail');
    }
}
