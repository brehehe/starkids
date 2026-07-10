<?php

namespace App\Livewire\Admin\Hr\Monitoring;

use App\Helpers\AlertHelper;
use App\Models\Attendance;
use App\Models\AttendanceHistory;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Livewire\WithPagination;

class AdminHrAttendanceMonitorIndex extends Component
{
    use WithPagination;

    public $search = '';

    public $perPage = 10;

    public $filterStatus = 'all';

    // Manual Entry Form Properties
    public $entry_user_id;

    public $entry_date;

    public $entry_clock_in;

    public $entry_clock_out;

    public $entry_status = 'present';

    public $entry_reason;

    public $usersList = [];

    public function mount()
    {
        $companyId = Auth::user()->company->is_main ? Auth::user()->company->id : Auth::user()->company->company_id;

        $this->usersList = User::where('type_user', 'employee')
            ->where('company_id', $companyId)
            ->where('is_active', true)
            ->select('id', 'name')
            ->orderBy('name')
            ->get();
    }

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function updatingFilterStatus()
    {
        $this->resetPage();
    }

    public function openModal()
    {
        $this->reset([
            'entry_user_id', 'entry_date', 'entry_clock_in',
            'entry_clock_out', 'entry_reason',
        ]);
        $this->entry_status = 'present';
        $this->resetErrorBag();
        $this->dispatch('open-modal', ['id' => 'modal-attendance']);
    }

    public function closeModal()
    {
        $this->dispatch('close-modal', ['id' => 'modal-attendance']);
    }

    public function saveAttendance()
    {
        $this->validate([
            'entry_user_id' => 'required',
            'entry_date' => 'required|date',
            'entry_clock_in' => 'nullable|date_format:H:i',
            'entry_clock_out' => 'nullable|date_format:H:i',
            'entry_status' => 'required|in:present,late,absent,left_early',
            'entry_reason' => 'nullable|string',
        ]);

        $company = Auth::user()->company;
        $latitude = $company->latitude ?? null;
        $longitude = $company->longitude ?? null;
        $address = $company->address ?? 'Lokasi Perusahaan (Manual Entry)';

        // Formatting times
        $clockInTime = $this->entry_clock_in ? $this->entry_clock_in.':00' : null;
        $clockOutTime = $this->entry_clock_out ? $this->entry_clock_out.':00' : null;

        // Save Main Attendance
        $attendance = Attendance::updateOrCreate(
            [
                'user_id' => $this->entry_user_id,
                'date' => $this->entry_date,
            ],
            [
                'clock_in_time' => $clockInTime,
                'clock_in_location_lat' => $latitude,
                'clock_in_location_long' => $longitude,
                'clock_in_location_address' => $clockInTime ? $address : null,
                'clock_out_time' => $clockOutTime,
                'clock_out_location_lat' => $clockOutTime ? $latitude : null,
                'clock_out_location_long' => $clockOutTime ? $longitude : null,
                'clock_out_location_address' => $clockOutTime ? $address : null,
                'status' => $this->entry_status,
                'reason' => $this->entry_reason ?: null,
            ]
        );

        // Save Clock In History explicitly if clock in is filled
        if ($clockInTime) {
            AttendanceHistory::create([
                'attendance_id' => $attendance->id,
                'user_id' => $this->entry_user_id,
                'type' => 'clock_in',
                'timestamp' => Carbon::parse($this->entry_date.' '.$clockInTime),
                'latitude' => $latitude,
                'longitude' => $longitude,
                'location_address' => $address,
                'reason' => $this->entry_reason ?: null,
            ]);
        }

        // Save Clock Out History explicitly if clock out is filled
        if ($clockOutTime) {
            AttendanceHistory::create([
                'attendance_id' => $attendance->id,
                'user_id' => $this->entry_user_id,
                'type' => 'clock_out',
                'timestamp' => Carbon::parse($this->entry_date.' '.$clockOutTime),
                'latitude' => $latitude,
                'longitude' => $longitude,
                'location_address' => $address,
                'reason' => $this->entry_reason ?: null,
            ]);
        }

        $this->closeModal();
        AlertHelper::success('Berhasil', 'Data absensi manual berhasil ditambahkan/diperbarui.');
    }

    public function render()
    {
        $attendances = AttendanceHistory::with(['user', 'attendance'])
            ->whereHas('user', function ($query) {
                $query->where('name', 'ilike', '%'.$this->search.'%');
            })
            ->when($this->filterStatus !== 'all', function ($query) {
                $query->whereHas('attendance', function ($q) {
                    $q->where('status', $this->filterStatus);
                });
            })
            ->latest('timestamp')
            ->paginate($this->perPage);

        return view('livewire.admin.hr.monitoring.admin-hr-attendance-monitor-index', [
            'attendances' => $attendances,
        ])->extends('layout.app')
            ->section('content');
    }
}
