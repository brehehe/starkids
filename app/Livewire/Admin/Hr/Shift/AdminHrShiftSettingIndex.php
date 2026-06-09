<?php

namespace App\Livewire\Admin\Hr\Shift;

use App\Helpers\AlertHelper;
use App\Models\Hr\Shift;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Livewire\WithPagination;

class AdminHrShiftSettingIndex extends Component
{
    use WithPagination;

    public string $search = '';

    public int $perPage = 10;

    // Modal fields
    public ?string $user_id = null;

    public ?string $shift_id = null;

    public string $employee_name = '';

    protected $queryString = [
        'search' => ['except' => ''],
        'page' => ['except' => 1],
    ];

    public function updatingSearch(): void
    {
        $this->resetPage();
    }

    public function openModal(string $userId): void
    {
        $user = User::with('shift')->findOrFail($userId);
        $this->user_id = $user->id;
        $this->employee_name = $user->name;
        $this->shift_id = $user->shift_id;
        $this->resetErrorBag();
        $this->dispatch('open-modal', ['id' => 'modal-shift-setting']);
    }

    public function closeModal(): void
    {
        $this->reset(['user_id', 'shift_id', 'employee_name']);
        $this->dispatch('close-modal', ['id' => 'modal-shift-setting']);
    }

    public function save(): void
    {
        $this->validate([
            'user_id' => 'required|exists:users,id',
            'shift_id' => 'nullable|exists:shifts,id',
        ]);

        User::where('id', $this->user_id)->update([
            'shift_id' => $this->shift_id ?: null,
        ]);

        $this->closeModal();
        AlertHelper::success('Berhasil', 'Shift pegawai berhasil diperbarui.');
    }

    public function clearShift(string $userId): void
    {
        User::where('id', $userId)->update(['shift_id' => null]);
        AlertHelper::success('Berhasil', 'Shift pegawai berhasil dikosongkan.');
    }

    public function render()
    {
        $companyId = Auth::user()->company->is_main
            ? Auth::user()->company->id
            : Auth::user()->company->company_id;

        $employees = User::with(['shift', 'companyRoles'])
            ->where('company_id', $companyId)
            ->where('type_user', 'employee')
            ->where(function ($q) {
                $q->where('name', 'like', '%'.$this->search.'%')
                    ->orWhere('phone', 'like', '%'.$this->search.'%');
            })
            ->orderBy('name')
            ->paginate($this->perPage);

        $shifts = Shift::where('company_id', $companyId)
            ->where('is_active', true)
            ->orderBy('start_time')
            ->get();

        return view('livewire.admin.hr.shift.admin-hr-shift-setting-index', [
            'employees' => $employees,
            'shifts' => $shifts,
        ])->extends('layout.app')->section('content');
    }
}
