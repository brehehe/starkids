<?php

namespace App\Livewire\Admin\Hr\Payroll;

use App\Helpers\AlertHelper;
use App\Models\Hr\EmployeePayroll;
use App\Models\Hr\Payroll;
use App\Models\Hr\PayrollAdjustment;
use App\Models\User;
use App\Models\User\UserIncentive;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Livewire\Component;
use Livewire\WithPagination;

class AdminHrPayrollGenerateIndex extends Component
{
    use WithPagination;

    public $search = '';
    public $filterPeriod;
    public $perPage = 10;
    
    // View Details Modal
    public $selectedPayroll = null;

    protected $queryString = [
        'search' => ['except' => ''],
        'filterPeriod' => ['except' => ''],
        'page' => ['except' => 1]
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

    public function generatePayroll()
    {
        $companyId = Auth::user()->company->is_main ? Auth::user()->company->id : Auth::user()->company->company_id;

        // Fetch all active employees that have a master payroll setup
        $employees = User::where('type_user', 'employee')
            ->where('company_id', $companyId)
            ->where('is_active', true)
            ->whereHas('employeePayroll') 
            ->get();

        if ($employees->count() === 0) {
            AlertHelper::error('Gagal', 'Tidak ada pegawai dengan Master Gaji yang diatur.');
            return;
        }

        DB::beginTransaction();

        try {
            $generatedCount = 0;

            foreach ($employees as $emp) {
                // 1. Get Master Base
                $masterPayroll = EmployeePayroll::with('components.component')
                    ->where('user_id', $emp->id)
                    ->first();

                if (!$masterPayroll) continue;

                $basicSalary = (float) $masterPayroll->basic_salary;
                $totalAllowance = 0;
                $totalDeduction = 0;
                $detailsData = [];

                // 2. Map Master Components
                foreach ($masterPayroll->components as $empComp) {
                    $compName = $empComp->component->name ?? 'Unknown Component';
                    $compType = $empComp->component->type ?? 'allowance';
                    $compAmount = (float) $empComp->amount;

                    if ($compType === 'allowance') {
                        $totalAllowance += $compAmount;
                    } else {
                        $totalDeduction += $compAmount;
                    }

                    $detailsData[] = [
                        'name' => $compName . ' (Master)',
                        'type' => $compType,
                        'amount' => $compAmount,
                    ];
                }

                // 3. Get Adjustments for this Month
                $adjustments = PayrollAdjustment::where('user_id', $emp->id)
                    ->where('period', $this->filterPeriod)
                    ->get();

                foreach ($adjustments as $adj) {
                    $adjAmount = (float) $adj->amount;
                    
                    if ($adj->type === 'allowance') {
                        $totalAllowance += $adjAmount;
                    } else {
                        $totalDeduction += $adjAmount;
                    }

                    $detailsData[] = [
                        'name' => $adj->name . ' (Khusus)',
                        'type' => $adj->type,
                        'amount' => $adjAmount,
                    ];
                }

                // 4. Get User Incentives for this Month
                try {
                    $periodDate = Carbon::createFromFormat('Y-m', $this->filterPeriod);
                    $periodYear = $periodDate->format('Y');
                    $periodMonth = $periodDate->format('m');
                    
                    $incentives = UserIncentive::where('user_id', $emp->id)
                        ->where('year', $periodYear)
                        ->where('month', $periodMonth)
                        ->where('is_generate', false)
                        ->get();
                        
                    $totalIncAmount = 0;
                    foreach ($incentives as $incentive) {
                        $totalIncAmount += (float) $incentive->amount;
                    }
                    
                    if ($totalIncAmount > 0) {
                        $totalAllowance += $totalIncAmount;
                        
                        $detailsData[] = [
                            'name' => 'Insentif',
                            'type' => 'allowance',
                            'amount' => $totalIncAmount,
                        ];
                    }
                } catch (\Exception $e) {
                    // Ignore parsing errors or missing table issues
                }

                $netSalary = $basicSalary + $totalAllowance - $totalDeduction;

                // 5. Create or Update Payroll Header
                $payroll = Payroll::updateOrCreate(
                    [
                        'company_id' => $companyId,
                        'user_id' => $emp->id,
                        'period' => $this->filterPeriod,
                    ],
                    [
                        'basic_salary' => $basicSalary,
                        'total_allowance' => $totalAllowance,
                        'total_deduction' => $totalDeduction,
                        'net_salary' => $netSalary,
                        'status' => 'draft' // defaults to draft upon regen
                    ]
                );

                // 6. Sync Details (Drop old ones for this period, recreate)
                $payroll->details()->delete();
                
                foreach ($detailsData as $detail) {
                    $payroll->details()->create($detail);
                }

                // 7. Update Incentives to is_generate = true
                if (isset($incentives) && $incentives->count() > 0) {
                    UserIncentive::whereIn('id', $incentives->pluck('id'))
                        ->update(['is_generate' => true]);
                }

                $generatedCount++;
            }

            DB::commit();
            AlertHelper::success('Berhasil', "Berhasil me-generate {$generatedCount} slip gaji untuk periode {$this->filterPeriod}.");
        } catch (\Exception $e) {
            DB::rollback();
            AlertHelper::error('Gagal', 'Gagal generate gaji: ' . $e->getMessage());
        }
    }

    public function viewDetails($payrollId)
    {
        $this->selectedPayroll = Payroll::with(['user', 'details'])->findOrFail($payrollId);
        $this->dispatch('open-modal', ['id' => 'modal-details']);
    }

    public function closeDetails()
    {
        $this->selectedPayroll = null;
        $this->dispatch('close-modal', ['id' => 'modal-details']);
    }
    
    public function markAsPaid($payrollId)
    {
        try {
            $payroll = Payroll::findOrFail($payrollId);
            $payroll->update([
                'status' => 'paid',
                'payment_date' => now()
            ]);
            AlertHelper::success('Berhasil', 'Status gaji diperbarui menjadi Dibayar.');
        } catch (\Exception $e) {
            AlertHelper::error('Gagal', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    public function downloadPDF($payrollId)
    {
        $payroll = Payroll::with(['user', 'company', 'details'])->findOrFail($payrollId);
        
        $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadView('pdf.slip-gaji', ['payroll' => $payroll]);
        
        return response()->streamDownload(function () use ($pdf) {
            echo $pdf->output(); // Use output() instead of stream() for Livewire streamDownload
        }, 'Slip_Gaji_' . ($payroll->user->name ?? 'Pegawai') . '_' . $payroll->period . '.pdf');
    }

    public function render()
    {
        $companyId = Auth::user()->company->is_main ? Auth::user()->company->id : Auth::user()->company->company_id;

        $payrolls = Payroll::with(['user'])
            ->where('company_id', $companyId)
            ->where('period', $this->filterPeriod)
            ->where(function ($query) {
                $query->whereHas('user', function ($q) {
                    $q->where('name', 'like', '%' . $this->search . '%');
                });
            })
            ->orderBy('created_at', 'desc')
            ->paginate($this->perPage);

        return view('livewire.admin.hr.payroll.admin-hr-payroll-generate-index', [
            'payrolls' => $payrolls,
        ])->extends('layout.app')->section('content');
    }
}
