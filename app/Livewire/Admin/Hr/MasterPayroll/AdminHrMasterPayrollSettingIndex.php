<?php

namespace App\Livewire\Admin\Hr\MasterPayroll;

use App\Helpers\AlertHelper;
use App\Models\Hr\EmployeePayroll;
use App\Models\Hr\PayrollComponent;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Livewire\Component;
use Livewire\WithPagination;

class AdminHrMasterPayrollSettingIndex extends Component
{
    use WithPagination;

    public $search = '';

    public $perPage = 10;

    // Modal Edit Gaji Pegawai
    public $data_id;

    public $user_id;

    public $user_name;

    public $basic_salary = 0;

    public $payment_type = 'monthly';

    // Checkbox form dynamic components [id_component => amount]
    public $selected_components = [];

    public $component_amounts = [];

    protected $queryString = [
        'search' => ['except' => ''],
        'page' => ['except' => 1],
    ];

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function closeModal()
    {
        $this->dispatch('close-modal', ['id' => 'modal-setting']);
    }

    public function edit($userId)
    {
        $user = User::findOrFail($userId);

        $this->user_id = $user->id;
        $this->user_name = $user->name;

        // Load data from EmployeePayroll
        $payroll = EmployeePayroll::where('user_id', $userId)->first();

        $this->basic_salary = $payroll ? (float) $payroll->basic_salary : 0;
        $this->payment_type = $payroll ? $payroll->payment_type : 'monthly';
        $this->data_id = $payroll ? $payroll->id : null;

        // Load specific customized components
        $this->selected_components = [];
        $this->component_amounts = [];

        if ($payroll) {
            foreach ($payroll->components as $employeeComponent) {
                $comp_id = $employeeComponent->payroll_component_id;
                $this->selected_components[$comp_id] = true;
                $this->component_amounts[$comp_id] = (float) $employeeComponent->amount;
            }
        }

        $this->resetErrorBag();
        $this->dispatch('open-modal', ['id' => 'modal-setting']);
    }

    public function save()
    {
        $this->validate([
            'basic_salary' => 'required|numeric|min:0',
            'payment_type' => 'required|in:monthly,weekly,daily',
        ]);

        $companyId = Auth::user()->company->is_main ? Auth::user()->company->id : Auth::user()->company->company_id;

        DB::beginTransaction();

        try {
            // Update Base Configuration
            $payroll = EmployeePayroll::updateOrCreate(
                ['user_id' => $this->user_id],
                [
                    'company_id' => $companyId,
                    'basic_salary' => $this->basic_salary,
                    'payment_type' => $this->payment_type,
                ]
            );

            // Sync their Components
            $payroll->components()->delete(); // drop older linkages

            foreach ($this->selected_components as $compId => $isSelected) {
                if ($isSelected) {
                    $val = $this->component_amounts[$compId] ?? null;

                    if ($val === null || $val === '') {
                        $comp = PayrollComponent::find($compId);
                        $val = $comp ? $comp->default_amount : 0;
                    }

                    $payroll->components()->create([
                        'payroll_component_id' => $compId,
                        'amount' => $val,
                    ]);
                }
            }

            DB::commit();

            $this->closeModal();
            AlertHelper::success('Berhasil', 'Pengaturan gaji pegawai berhasil disimpan.');
        } catch (\Exception $e) {
            DB::rollback();
            AlertHelper::error('Gagal', 'Gagal mengatur gaji: '.$e->getMessage());
        }
    }

    public function render()
    {
        $companyId = Auth::user()->company->is_main ? Auth::user()->company->id : Auth::user()->company->company_id;

        $employees = User::where('type_user', 'employee')
            ->where('company_id', $companyId)
            ->where('is_active', true)
            ->where('name', 'like', '%'.$this->search.'%')
            ->orderBy('name')
            ->paginate($this->perPage);

        // Load all active general components for mapping
        $allComponents = PayrollComponent::where('company_id', $companyId)
            ->where('is_active', true)
            ->orderBy('type')
            ->get();

        return view('livewire.admin.hr.master-payroll.admin-hr-master-payroll-setting-index', [
            'employees' => $employees,
            'allComponents' => $allComponents,
        ])->extends('layout.app')->section('content');
    }
}
