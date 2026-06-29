<?php

namespace App\Livewire\Admin\Consultation\DateControl;

use App\Helpers\AlertHelper;
use App\Models\Location\Location;
use App\Models\User;
use App\Models\User\UserControlSchedule;
use Livewire\Component;
use Livewire\WithPagination;

class AdminConsultationDateControlIndex extends Component
{
    use WithPagination;

    public $perPage = 5;

    public $search = '';

    public $doctors = [];

    public $patients = [];

    public $locations = [];

    public $filterDoctor = null;

    public $filterPatient = null;

    public $filterLocation = null;

    public $filterStartDate = null;

    public $filterEndDate = null;

    public $months = [];

    public $years = [];

    public $selectedMonth = null;

    public $selectedYear = null;

    public $statusFilter = 'all'; // all, draft, completed

    public function mount()
    {
        $this->months = [
            1 => 'Januari',
            2 => 'Februari',
            3 => 'Maret',
            4 => 'April',
            5 => 'Mei',
            6 => 'Juni',
            7 => 'Juli',
            8 => 'Agustus',
            9 => 'September',
            10 => 'Oktober',
            11 => 'November',
            12 => 'Desember',
        ];

        $this->years = range(date('Y') - 5, date('Y') + 5);

        $this->selectedMonth = date('n');
        $this->selectedYear = date('Y');

        $this->locations = Location::select('id', 'name')->get()->pluck('name', 'id')->toArray();

        // Populate doctors (users with role doctor)
        $this->doctors = User::where('company_id', auth()->user()->company_id)
            ->companyRole('Dokter', auth()->user()->company_id)
            ->select('id', 'name')
            ->get()
            ->pluck('name', 'id')
            ->toArray();

        // Populate patients (users with role patient or all users who have control schedules)
        $this->patients = User::where('company_id', auth()->user()->company_id)
            ->companyRole('Pasien', auth()->user()->company_id)
            ->select('id', 'name')
            ->distinct()
            ->orderBy('name')
            ->get()
            ->pluck('name', 'id')
            ->toArray();
    }

    private function getBaseQuery()
    {
        $query = UserControlSchedule::query()
            ->search($this->search)
            ->where('company_id', auth()->user()->company_id)
            ->with(['user', 'doctor', 'location', 'transaction']);

        // Filter by status
        if ($this->statusFilter === 'draft') {
            $query->where('status', 'draft');
        } elseif ($this->statusFilter === 'completed') {
            $query->where('status', 'completed');
        }
        // 'all' doesn't need additional filter

        if ($this->selectedMonth && $this->selectedYear) {
            $query->whereMonth('date', $this->selectedMonth)
                ->whereYear('date', $this->selectedYear);
        }

        if ($this->filterLocation) {
            $query->where('location_id', $this->filterLocation);
        }

        if ($this->filterDoctor) {
            $query->where('doctor_id', $this->filterDoctor);
        }

        if ($this->filterPatient) {
            $query->where('user_id', $this->filterPatient);
        }

        return $query->orderBy('date', 'desc');
    }

    public function render()
    {
        $userControlDoctors = $this->getBaseQuery();

        $paginated = $userControlDoctors->paginate($this->perPage);

        // hitung total produk dari hasil query
        $allProducts = collect();
        foreach ($paginated as $userControlSchedule) {
            // Only count products for draft status
            if ($userControlSchedule->transaction && in_array($userControlSchedule->status, ['draft', null])) {
                if (! empty($userControlSchedule->products)) {
                    $allProducts = $allProducts->merge($userControlSchedule->products);
                }
            }
        }

        $productTotals = $allProducts->countBy(); // contoh: ['Paracetamol' => 5, 'Vaksin A' => 3]

        return view('livewire.admin.consultation.date-control.admin-consultation-date-control-index', [
            'userControlDoctors' => $paginated,
            'productTotals' => $productTotals,
        ])
            ->extends('layout.app')
            ->section('content');
    }

    public function confirmDetail($id)
    {
        return AlertHelper::confirmSave('detail', 'Apakah anda Yakin merubah status bahwa pasien sudah melaksanakan konsultasi?', $id);
    }

    public function detail($id)
    {
        $transaction = UserControlSchedule::find($id[0]);
        if ($transaction) {
            $transaction->status = 'completed';
            $transaction->save();

            return AlertHelper::success('Berhasil', 'Berhasil merubah status bahwa pasien sudah melaksanakan konsultasi');
        } else {
            return AlertHelper::error('Gagal', 'Data tidak ditemukan');
        }
    }

    public function confirmBack($id)
    {
        return AlertHelper::confirmSave('back', 'Apakah anda Yakin merubah status bahwa pasien belum melaksanakan konsultasi?', $id);
    }

    public function back($id)
    {
        $transaction = UserControlSchedule::find($id[0]);
        if ($transaction) {
            $transaction->status = 'draft';
            $transaction->save();

            return AlertHelper::success('Berhasil', 'Berhasil merubah status bahwa pasien belum melaksanakan konsultasi');
        } else {
            return AlertHelper::error('Gagal', 'Data tidak ditemukan');
        }
    }
}
