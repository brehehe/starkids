<?php

namespace App\Livewire\Admin\Hr\Shift;

use App\Helpers\AlertHelper;
use App\Models\Hr\Shift;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Livewire\WithPagination;

class AdminHrShiftIndex extends Component
{
    use WithPagination;

    public string $search = '';

    public int $perPage = 10;

    // Form fields
    public ?string $data_id = null;

    public string $name = '';

    public string $start_time = '';

    public string $end_time = '';

    public bool $is_active = true;

    protected $queryString = [
        'search' => ['except' => ''],
        'page' => ['except' => 1],
    ];

    public function updatingSearch(): void
    {
        $this->resetPage();
    }

    public function openModal(): void
    {
        $this->reset(['data_id', 'name', 'start_time', 'end_time']);
        $this->is_active = true;
        $this->resetErrorBag();
        $this->dispatch('open-modal', ['id' => 'modal-shift']);
    }

    public function closeModal(): void
    {
        $this->dispatch('close-modal', ['id' => 'modal-shift']);
    }

    public function edit(string $id): void
    {
        $shift = Shift::findOrFail($id);
        $this->data_id = $shift->id;
        $this->name = $shift->name;
        $this->start_time = $shift->start_time;
        $this->end_time = $shift->end_time;
        $this->is_active = $shift->is_active;
        $this->dispatch('open-modal', ['id' => 'modal-shift']);
    }

    public function save(): void
    {
        $this->validate([
            'name' => 'required|string|max:100',
            'start_time' => 'required',
            'end_time' => 'required',
            'is_active' => 'boolean',
        ]);

        $companyId = Auth::user()->company->is_main
            ? Auth::user()->company->id
            : Auth::user()->company->company_id;

        Shift::updateOrCreate(
            ['id' => $this->data_id],
            [
                'company_id' => $companyId,
                'name' => $this->name,
                'start_time' => $this->start_time,
                'end_time' => $this->end_time,
                'is_active' => $this->is_active,
            ]
        );

        $this->closeModal();
        AlertHelper::success('Berhasil', 'Data shift berhasil disimpan.');
    }

    public function confirmDelete(string $id): void
    {
        AlertHelper::confirmDelete('delete', 'Apakah Anda yakin ingin menghapus shift ini?', $id);
    }

    public function delete(array $id): void
    {
        Shift::findOrFail($id[0])->delete();
        AlertHelper::success('Shift Berhasil Dihapus');
    }

    public function render()
    {
        $companyId = Auth::user()->company->is_main
            ? Auth::user()->company->id
            : Auth::user()->company->company_id;

        $shifts = Shift::where('company_id', $companyId)
            ->where('name', 'like', '%'.$this->search.'%')
            ->orderBy('start_time')
            ->paginate($this->perPage);

        return view('livewire.admin.hr.shift.admin-hr-shift-index', [
            'shifts' => $shifts,
        ])->extends('layout.app')->section('content');
    }
}
