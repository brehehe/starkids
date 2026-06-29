<?php

namespace App\Livewire\Admin\Hr\MasterPayroll;

use App\Helpers\AlertHelper;
use App\Models\Hr\PayrollComponent;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Livewire\WithPagination;

class AdminHrMasterPayrollComponentIndex extends Component
{
    use WithPagination;

    public $search = '';

    public $perPage = 10;

    // Modal properties
    public $data_id;

    public $name;

    public $type = 'allowance';

    public $is_taxable = false;

    public $is_active = true;

    public $default_amount = 0;

    protected $queryString = [
        'search' => ['except' => ''],
        'page' => ['except' => 1],
    ];

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function openModal()
    {
        $this->reset(['data_id', 'name', 'type', 'is_taxable', 'is_active', 'default_amount']);
        $this->type = 'allowance';
        $this->is_taxable = false;
        $this->is_active = true;
        $this->resetErrorBag();
        $this->dispatch('open-modal', ['id' => 'modal-component']);
    }

    public function closeModal()
    {
        $this->dispatch('close-modal', ['id' => 'modal-component']);
    }

    public function edit($id)
    {
        $component = PayrollComponent::findOrFail($id);
        $this->data_id = $component->id;
        $this->name = $component->name;
        $this->type = $component->type;
        $this->is_taxable = $component->is_taxable;
        $this->is_active = $component->is_active;
        $this->default_amount = $component->default_amount;

        $this->openModal();
    }

    public function save()
    {
        $this->validate([
            'name' => 'required|string|max:150',
            'type' => 'required|in:allowance,deduction',
            'is_taxable' => 'boolean',
            'is_active' => 'boolean',
            // Float parsing
            'default_amount' => 'numeric|min:0',
        ]);

        $companyId = Auth::user()->company->is_main ? Auth::user()->company->id : Auth::user()->company->company_id;

        PayrollComponent::updateOrCreate(
            ['id' => $this->data_id],
            [
                'company_id' => $companyId,
                'name' => $this->name,
                'type' => $this->type,
                'is_taxable' => $this->is_taxable,
                'is_active' => $this->is_active,
                'default_amount' => $this->default_amount,
            ]
        );

        $this->closeModal();
        AlertHelper::success('Berhasil', 'Data Komponen Gaji berhasil disimpan.');
    }

    public function confirmDelete($id)
    {
        return AlertHelper::confirmDelete('delete', 'Apakah Anda yakin ingin menghapus komponen penggajian ini?', $id);
    }

    public function delete($id)
    {
        $component = PayrollComponent::findOrFail($id[0]);
        $component->delete();
        AlertHelper::success('Komponen Berhasil Dihapus');
    }

    public function render()
    {
        $companyId = Auth::user()->company->is_main ? Auth::user()->company->id : Auth::user()->company->company_id;

        $components = PayrollComponent::where('company_id', $companyId)
            ->where('name', 'like', '%'.$this->search.'%')
            ->latest()
            ->paginate($this->perPage);

        return view('livewire.admin.hr.master-payroll.admin-hr-master-payroll-component-index', [
            'components' => $components,
        ])->extends('layout.app')->section('content');
    }
}
