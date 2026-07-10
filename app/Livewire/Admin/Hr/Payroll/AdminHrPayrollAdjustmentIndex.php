<?php

namespace App\Livewire\Admin\Hr\Payroll;

use App\Helpers\AlertHelper;
use App\Models\Hr\PayrollAdjustment;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Livewire\WithPagination;

class AdminHrPayrollAdjustmentIndex extends Component
{
    use WithPagination;

    public $search = '';

    public $filterPeriod;

    public $perPage = 10;

    // Modal Variables
    public $data_id;

    public $user_id;

    public $name;

    public $type = 'allowance';

    public $amount;

    public $description;

    protected $queryString = [
        'search' => ['except' => ''],
        'filterPeriod' => ['except' => ''],
        'page' => ['except' => 1],
    ];

    public function mount()
    {
        $this->filterPeriod = date('Y-m'); // Default to current YYYY-MM
    }

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function updatingFilterPeriod()
    {
        $this->resetPage();
    }

    public function create()
    {
        $this->reset(['data_id', 'user_id', 'name', 'type', 'amount', 'description']);
        $this->resetErrorBag();
        $this->dispatch('open-modal', ['id' => 'modal-adjustment']);
    }

    public function edit($id)
    {
        $adjustment = PayrollAdjustment::findOrFail($id);

        $this->data_id = $adjustment->id;
        $this->user_id = $adjustment->user_id;
        $this->name = $adjustment->name;
        $this->type = $adjustment->type;
        $this->amount = (float) $adjustment->amount;
        $this->description = $adjustment->description;

        $this->resetErrorBag();
        $this->dispatch('open-modal', ['id' => 'modal-adjustment']);
    }

    public function save()
    {
        $this->validate([
            'user_id' => 'required',
            'name' => 'required|string|max:255',
            'type' => 'required|in:allowance,deduction',
            'amount' => 'required|numeric|min:0',
            'description' => 'nullable|string',
        ]);

        $companyId = Auth::user()->company->is_main ? Auth::user()->company->id : Auth::user()->company->company_id;

        try {
            PayrollAdjustment::updateOrCreate(
                ['id' => $this->data_id],
                [
                    'company_id' => $companyId,
                    'user_id' => $this->user_id,
                    'period' => $this->filterPeriod,
                    'name' => $this->name,
                    'type' => $this->type,
                    'amount' => $this->amount,
                    'description' => $this->description,
                ]
            );

            $this->closeModal();
            AlertHelper::success('Berhasil', 'Data Tambahan/Potongan Khusus berhasil disimpan.');
        } catch (\Exception $e) {
            AlertHelper::error('Gagal', 'Terjadi kesalahan: '.$e->getMessage());
        }
    }

    public function deleteConfirm($id)
    {
        $this->data_id = $id;
        $this->dispatch('open-modal', ['id' => 'modal-delete']);
    }

    public function delete()
    {
        try {
            $adjustment = PayrollAdjustment::findOrFail($this->data_id);
            $adjustment->delete();

            $this->closeModal();
            AlertHelper::success('Berhasil', 'Data berhasil dihapus.');
            $this->resetPage();
        } catch (\Exception $e) {
            AlertHelper::error('Gagal', 'Gagal menghapus data: '.$e->getMessage());
        }
    }

    public function closeModal()
    {
        $this->dispatch('close-modal', ['id' => 'modal-adjustment']);
        $this->dispatch('close-modal', ['id' => 'modal-delete']);
    }

    public function render()
    {
        $companyId = Auth::user()->company->is_main ? Auth::user()->company->id : Auth::user()->company->company_id;

        $adjustments = PayrollAdjustment::with('user')
            ->where('company_id', $companyId)
            ->where('period', $this->filterPeriod)
            ->where(function ($query) {
                $query->where('name', 'ilike', '%'.$this->search.'%')
                    ->orWhereHas('user', function ($q) {
                        $q->where('name', 'ilike', '%'.$this->search.'%');
                    });
            })
            ->orderBy('created_at', 'desc')
            ->paginate($this->perPage);

        $employees = User::where('type_user', 'employee')
            ->where('company_id', $companyId)
            ->where('is_active', true)
            ->orderBy('name')
            ->get();

        return view('livewire.admin.hr.payroll.admin-hr-payroll-adjustment-index', [
            'adjustments' => $adjustments,
            'employees' => $employees,
        ])->extends('layout.app')->section('content');
    }
}
