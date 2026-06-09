<?php

namespace App\Livewire\Admin\Report\Medical;

use App\Models\Transaction\Transaction;
use App\Models\Transaction\TransactionDiagnosis;
use App\Models\Transaction\TransactionRecipe;
use App\Models\Transaction\TransactionPhysicalExamination;
use App\Models\Transaction\TransactionIcd9;
use App\Models\Transaction\TransactionIcd10;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Livewire\Component;
use Livewire\WithPagination;

class AdminReportMedicalIndex extends Component
{
    use WithPagination;
    
    protected $queryString = [
        'search' => ['except' => ''],
        'reportType' => ['except' => 'diagnosis'],
    ];
    
    public $search = '';
    public $perPage = 10;
    public $start_date;
    public $end_date;
    public $doctor_id = '';
    public $patient_id = '';
    public $reportType = 'diagnosis';
    
    // Data properties
    public $summaryData = [];
    public $doctors = [];
    public $patients = [];
    
    public function mount()
    {
        $this->start_date = now()->startOfMonth()->format('Y-m-d');
        $this->end_date = now()->endOfMonth()->format('Y-m-d');
        $this->loadFilterData();
        $this->generateSummaryData();
    }
    
    public function loadFilterData()
    {
        $companyId = auth()->user()->company_id;
        
        $this->doctors = User::whereHas('userCompanyRoles', function($query) use ($companyId) {
                $query->where('company_id', $companyId)
                      ->where('role', 'doctor');
            })
            ->select('id', 'name')
            ->orderBy('name')
            ->get();
            
        $this->patients = User::whereHas('userCompanyRoles', function($query) use ($companyId) {
                $query->where('company_id', $companyId)
                      ->where('role', 'patient');
            })
            ->select('id', 'name')
            ->orderBy('name')
            ->limit(100)
            ->get();
    }
    
    public function updatedStartDate()
    {
        $this->generateSummaryData();
        $this->resetPage();
    }
    
    public function updatedEndDate()
    {
        $this->generateSummaryData();
        $this->resetPage();
    }
    
    public function updatedReportType()
    {
        $this->generateSummaryData();
        $this->resetPage();
    }
    
    public function generateSummaryData()
    {
        $companyId = auth()->user()->company_id;
        
        $transactionQuery = Transaction::where('company_id', $companyId)
            ->where('status', 'completed');
        
        if ($this->start_date && $this->end_date) {
            $transactionQuery->whereBetween('created_at', [
                $this->start_date . ' 00:00:00',
                $this->end_date . ' 23:59:59'
            ]);
        }
        
        if ($this->doctor_id) {
            $transactionQuery->where('doctor_id', $this->doctor_id);
        }
        
        if ($this->patient_id) {
            $transactionQuery->where('patient_id', $this->patient_id);
        }
        
        $this->summaryData = [
            'total_consultations' => $transactionQuery->where('type', 'consultation')->count(),
            'total_diagnoses' => TransactionDiagnosis::whereHas('transaction', function($q) use ($transactionQuery) {
                $q->whereIn('id', $transactionQuery->pluck('id'));
            })->count(),
            'total_recipes' => TransactionRecipe::whereHas('transaction', function($q) use ($transactionQuery) {
                $q->whereIn('id', $transactionQuery->pluck('id'));
            })->count(),
            'total_examinations' => TransactionPhysicalExamination::whereHas('transaction', function($q) use ($transactionQuery) {
                $q->whereIn('id', $transactionQuery->pluck('id'));
            })->count(),
            'unique_patients' => $transactionQuery->distinct('patient_id')->count('patient_id'),
            'unique_doctors' => $transactionQuery->distinct('doctor_id')->count('doctor_id'),
        ];
    }
    
    public function getDiagnosisReportProperty()
    {
        $query = TransactionDiagnosis::with([
            'transaction:id,code,patient_name,doctor_id,created_at',
            'transaction.doctor:id,name',
            'transaction.patient:id,name'
        ])
        ->where('company_id', auth()->user()->company_id)
        ->whereHas('transaction', function($q) {
            $q->where('status', 'completed');
            
            if ($this->start_date && $this->end_date) {
                $q->whereBetween('created_at', [
                    $this->start_date . ' 00:00:00',
                    $this->end_date . ' 23:59:59'
                ]);
            }
            
            if ($this->doctor_id) {
                $q->where('doctor_id', $this->doctor_id);
            }
            
            if ($this->patient_id) {
                $q->where('patient_id', $this->patient_id);
            }
        });
        
        if ($this->search) {
            $query->where(function($q) {
                $q->where('diagnosis', 'ilike', "%{$this->search}%")
                  ->orWhere('notes', 'ilike', "%{$this->search}%")
                  ->orWhereHas('transaction', function($subQ) {
                      $subQ->where('code', 'ilike', "%{$this->search}%")
                           ->orWhere('patient_name', 'ilike', "%{$this->search}%");
                  });
            });
        }
        
        return $query->orderBy('created_at', 'desc');
    }
    
    public function getRecipeReportProperty()
    {
        $query = TransactionRecipe::with([
            'transaction:id,code,patient_name,doctor_id,created_at',
            'transaction.doctor:id,name',
            'product:id,name,sku_number'
        ])
        ->where('company_id', auth()->user()->company_id)
        ->whereHas('transaction', function($q) {
            $q->where('status', 'completed');
            
            if ($this->start_date && $this->end_date) {
                $q->whereBetween('created_at', [
                    $this->start_date . ' 00:00:00',
                    $this->end_date . ' 23:59:59'
                ]);
            }
            
            if ($this->doctor_id) {
                $q->where('doctor_id', $this->doctor_id);
            }
            
            if ($this->patient_id) {
                $q->where('patient_id', $this->patient_id);
            }
        });
        
        if ($this->search) {
            $query->where(function($q) {
                $q->where('product_name', 'ilike', "%{$this->search}%")
                  ->orWhere('dosage', 'ilike', "%{$this->search}%")
                  ->orWhere('usage_rules', 'ilike', "%{$this->search}%")
                  ->orWhereHas('transaction', function($subQ) {
                      $subQ->where('code', 'ilike', "%{$this->search}%")
                           ->orWhere('patient_name', 'ilike', "%{$this->search}%");
                  });
            });
        }
        
        return $query->orderBy('created_at', 'desc');
    }
    
    public function getExaminationReportProperty()
    {
        $query = TransactionPhysicalExamination::with([
            'transaction:id,code,patient_name,doctor_id,created_at',
            'transaction.doctor:id,name'
        ])
        ->where('company_id', auth()->user()->company_id)
        ->whereHas('transaction', function($q) {
            $q->where('status', 'completed');
            
            if ($this->start_date && $this->end_date) {
                $q->whereBetween('created_at', [
                    $this->start_date . ' 00:00:00',
                    $this->end_date . ' 23:59:59'
                ]);
            }
            
            if ($this->doctor_id) {
                $q->where('doctor_id', $this->doctor_id);
            }
            
            if ($this->patient_id) {
                $q->where('patient_id', $this->patient_id);
            }
        });
        
        if ($this->search) {
            $query->where(function($q) {
                $q->where('blood_pressure', 'ilike', "%{$this->search}%")
                  ->orWhere('heart_rate', 'ilike', "%{$this->search}%")
                  ->orWhere('temperature', 'ilike', "%{$this->search}%")
                  ->orWhereHas('transaction', function($subQ) {
                      $subQ->where('code', 'ilike', "%{$this->search}%")
                           ->orWhere('patient_name', 'ilike', "%{$this->search}%");
                  });
            });
        }
        
        return $query->orderBy('created_at', 'desc');
    }
    
    public function getIcdReportProperty()
    {
        $icd9Query = TransactionIcd9::with([
            'transaction:id,code,patient_name,doctor_id,created_at',
            'transaction.doctor:id,name'
        ])
        ->where('company_id', auth()->user()->company_id)
        ->whereHas('transaction', function($q) {
            $q->where('status', 'completed');
            
            if ($this->start_date && $this->end_date) {
                $q->whereBetween('created_at', [
                    $this->start_date . ' 00:00:00',
                    $this->end_date . ' 23:59:59'
                ]);
            }
            
            if ($this->doctor_id) {
                $q->where('doctor_id', $this->doctor_id);
            }
        })
        ->select('*', DB::raw("'ICD-9' as icd_type"));
        
        $icd10Query = TransactionIcd10::with([
            'transaction:id,code,patient_name,doctor_id,created_at',
            'transaction.doctor:id,name'
        ])
        ->where('company_id', auth()->user()->company_id)
        ->whereHas('transaction', function($q) {
            $q->where('status', 'completed');
            
            if ($this->start_date && $this->end_date) {
                $q->whereBetween('created_at', [
                    $this->start_date . ' 00:00:00',
                    $this->end_date . ' 23:59:59'
                ]);
            }
            
            if ($this->doctor_id) {
                $q->where('doctor_id', $this->doctor_id);
            }
        })
        ->select('*', DB::raw("'ICD-10' as icd_type"));
        
        return $icd9Query->union($icd10Query)->orderBy('created_at', 'desc');
    }
    
    public function exportData()
    {
        $this->dispatch('export-started');
    }
    
    public function render()
    {
        $data = [];
        
        switch ($this->reportType) {
            case 'recipe':
                $data['reportData'] = $this->recipeReport->paginate($this->perPage);
                break;
            case 'examination':
                $data['reportData'] = $this->examinationReport->paginate($this->perPage);
                break;
            case 'icd':
                $data['reportData'] = $this->icdReport->paginate($this->perPage);
                break;
            default:
                $data['reportData'] = $this->diagnosisReport->paginate($this->perPage);
                break;
        }
        
        return view('livewire.admin.report.medical.admin-report-medical-index', array_merge($data, [
            'summaryData' => $this->summaryData,
            'doctors' => $this->doctors,
            'patients' => $this->patients,
        ]))
        ->extends('layout.app')
        ->section('content');
    }
}