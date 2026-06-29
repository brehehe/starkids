<?php

namespace App\Livewire\Admin\Master\DoctorControl;

use App\Helpers\AlertHelper;
use App\Models\Location\Location;
use App\Models\User;
use App\Models\User\ControlDoctor;
use App\Traits\Company\CompanyTrait;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Livewire\WithPagination;

class AdminMasterDoctorControlIndex extends Component
{
    use CompanyTrait, WithPagination;

    protected $queryString = [
        'search' => ['except' => ''],
    ];

    public $search = '';

    public $perPage = 5;

    public $data_id;

    public $user_id;

    public $location_id;

    public $locations = [];

    public $getDays = [];

    public $getTimes = [];

    public $users = [];

    public $days = [];

    public $start_time;

    public $end_time;

    public $max_patients = 0;

    public $is_unlimited = false;

    public function mount()
    {
        $this->getDays = [
            'Senin',
            'Selasa',
            'Rabu',
            'Kamis',
            'Jumat',
            'Sabtu',
            'Minggu',
        ];

        $company_branches = $this->getCompanyBranches(Auth::user()?->company_id, ['id'])->pluck('id')->toArray();
        $this->locations = Location::select('id', 'name')
            ->whereIn('company_id', $company_branches)
            ->get()
            ->toArray();
        $this->users = User::select('id', 'name')->companyRole('Dokter', Auth::user()->company_id)->get()->toArray();
    }

    public function hydrate()
    {
        $this->resetPage();
    }

    public function openModal($modal)
    {
        $this->dispatch('open-modal', ['id' => $modal]);
    }

    public function closeModal($modal)
    {
        $this->dispatch('close-modal', ['id' => $modal]);

        return $this->reset([
            'data_id',
            'user_id',
            'days',
            'start_time',
            'end_time',
            'max_patients',
            'location_id',
            'is_unlimited',
        ]);
    }

    public function confirmDelete($id)
    {
        return AlertHelper::confirmDelete('delete', 'Anda Yakin Menghapus Data Ini?', $id);
    }

    public function delete($id)
    {
        $controlDoctor = ControlDoctor::findOrFail($id[0]);
        $controlDoctor->delete();
        AlertHelper::success('Kontrol Dokter Berhasil Dihapus');
    }

    public function edit($id)
    {

        $controlDoctor = ControlDoctor::findOrFail($id);
        $this->data_id = $controlDoctor->id;
        $this->user_id = $controlDoctor->user_id;
        $this->days = json_decode($controlDoctor->days, true);
        $this->start_time = Carbon::parse($controlDoctor->start_time)->format('H:i');
        $this->end_time = Carbon::parse($controlDoctor->end_time)->format('H:i');
        $this->max_patients = $controlDoctor->max_patients;
        $this->location_id = $controlDoctor->location_id;
        $this->is_unlimited = $controlDoctor->is_unlimited;

        return $this->openModal('modal');
    }

    public function updatedIsUnlimited($value)
    {
        $this->max_patients = 0; // Reset max_patients if unlimited is true
    }

    public function submit()
    {
        $this->validate([
            'user_id' => 'required',
            'location_id' => 'required',
            'days' => 'required',
            'start_time' => 'required',
            'end_time' => 'required',
            'max_patients' => $this->is_unlimited ? 'nullable' : 'required|integer|min:1',
        ]);

        ControlDoctor::updateOrCreate(
            ['id' => $this->data_id],
            [
                'location_id' => $this->location_id,
                'user_id' => $this->user_id,
                'days' => json_encode($this->days),
                'start_time' => $this->start_time,
                'end_time' => $this->end_time,
                'max_patients' => $this->max_patients,
                'company_id' => Auth::user()->company_id,
                'is_unlimited' => $this->is_unlimited,
            ]
        );

        AlertHelper::success('Kontrol Dokter Berhasil Disimpan');

        return $this->closeModal('modal');
    }

    public function render()
    {
        $controlDoctors = ControlDoctor::search($this->search)
            ->where('company_id', Auth::user()->company_id)
            ->orderBy('order', 'asc')
            ->paginate($this->perPage);

        return view('livewire.admin.master.doctor-control.admin-master-doctor-control-index', [
            'controlDoctors' => $controlDoctors,
        ])
            ->extends('layout.app')
            ->section('content');
    }
}
