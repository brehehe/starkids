<?php

namespace App\Livewire\Admin\Report\Transaction;

use App\Models\Transaction\Transaction;
use App\Models\Transaction\TransactionDetail;
use App\Models\Transaction\TransactionPayment;
use App\Models\Transaction\TransactionRecipe;
use App\Models\Transaction\TransactionDiagnosis;
use App\Models\PaymentMethod\PaymentMethod;
use App\Models\Product\Product;
use App\Models\User;
use App\Models\Branch\Branch;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Livewire\Component;
use Livewire\WithPagination;

class AdminReportTransactionIndex extends Component
{
    use WithPagination;
    
    protected $queryString = [
        'search' => ['except' => ''],
        'reportType' => ['except' => 'summary'],
    ];
    
    public $search = '';
    public $perPage = 10;
    public $start_date;
    public $end_date;
    public $type = '';
    public $status = '';
    public $doctor_id = '';
    public $patient_id = '';
    public $payment_method_id = '';
    public $reportType = 'summary';
    
    // Data properties
    public $summaryData = [];
    public $paymentMethods = [];
    public $doctors = [];
    public $patients = [];
    public $branches = [];
    
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
        
        $this->paymentMethods = PaymentMethod::where('company_id', $companyId)
            ->select('id', 'name')
            ->orderBy('name')
            ->get();
            
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
            
        $this->branches = Branch::where('company_id', $companyId)
            ->select('id', 'name')
            ->orderBy('name')
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
    
    public function updatedType()
    {
        $this->generateSummaryData();
        $this->resetPage();
    }
    
    public function updatedStatus()
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
        $query = Transaction::where('company_id', auth()->user()->company_id);
        
        if ($this->start_date && $this->end_date) {
            $query->whereBetween('created_at', [
                $this->start_date . ' 00:00:00',
                $this->end_date . ' 23:59:59'
            ]);
        }
        
        if ($this->type) {
            $query->where('type', $this->type);
        }
        
        if ($this->status) {
            $query->where('status', $this->status);
        }
        
        if ($this->doctor_id) {
            $query->where('doctor_id', $this->doctor_id);
        }
        
        if ($this->patient_id) {
            $query->where('patient_id', $this->patient_id);
        }
        
        $this->summaryData = [
            'total_transactions' => $query->count(),
            'total_revenue' => $query->sum('grand_total_price'),
            'total_discount' => $query->sum('discount_value'),
            'avg_transaction' => $query->avg('grand_total_price'),
            'completed_transactions' => $query->where('status', 'completed')->count(),
            'pending_transactions' => $query->where('status', 'pending')->count(),
            'cancelled_transactions' => $query->where('status', 'cancelled')->count(),
        ];
    }
    
    public function getTransactionsProperty()
    {
        $query = Transaction::with([
            'patient:id,name',
            'doctor:id,name',
            'branch:id,name',
            'transactionPayments.paymentMethod:id,name',
            'transactionDetails.product:id,name',
        ])
        ->where('company_id', auth()->user()->company_id)
        ->search($this->search);
        
        if ($this->start_date && $this->end_date) {
            $query->whereBetween('created_at', [
                $this->start_date . ' 00:00:00',
                $this->end_date . ' 23:59:59'
            ]);
        }
        
        if ($this->type) {
            $query->where('type', $this->type);
        }
        
        if ($this->status) {
            $query->where('status', $this->status);
        }
        
        if ($this->doctor_id) {
            $query->where('doctor_id', $this->doctor_id);
        }
        
        if ($this->patient_id) {
            $query->where('patient_id', $this->patient_id);
        }
        
        if ($this->payment_method_id) {
            $query->whereHas('transactionPayments', function($q) {
                $q->where('payment_method_id', $this->payment_method_id);
            });
        }
        
        return $query->orderBy('created_at', 'desc');
    }
    
    public function getDetailedReportProperty()
    {
        $query = TransactionDetail::with([
            'transaction:id,code,patient_name,doctor_id,created_at,status,type',
            'transaction.doctor:id,name',
            'product:id,name,sku_number'
        ])
        ->where('company_id', auth()->user()->company_id)
        ->whereHas('transaction', function($q) {
            if ($this->start_date && $this->end_date) {
                $q->whereBetween('created_at', [
                    $this->start_date . ' 00:00:00',
                    $this->end_date . ' 23:59:59'
                ]);
            }
            
            if ($this->type) {
                $q->where('type', $this->type);
            }
            
            if ($this->status) {
                $q->where('status', $this->status);
            }
            
            if ($this->doctor_id) {
                $q->where('doctor_id', $this->doctor_id);
            }
        });
        
        if ($this->search) {
            $query->where(function($q) {
                $q->where('product_name', 'ilike', "%{$this->search}%")
                  ->orWhereHas('transaction', function($subQ) {
                      $subQ->where('code', 'ilike', "%{$this->search}%")
                           ->orWhere('patient_name', 'ilike', "%{$this->search}%");
                  });
            });
        }
        
        return $query->orderBy('created_at', 'desc');
    }
    
    public function getPaymentReportProperty()
    {
        $query = TransactionPayment::with([
            'transaction:id,code,patient_name,grand_total_price,created_at',
            'paymentMethod:id,name'
        ])
        ->where('company_id', auth()->user()->company_id)
        ->whereHas('transaction', function($q) {
            if ($this->start_date && $this->end_date) {
                $q->whereBetween('created_at', [
                    $this->start_date . ' 00:00:00',
                    $this->end_date . ' 23:59:59'
                ]);
            }
            
            if ($this->type) {
                $q->where('type', $this->type);
            }
            
            if ($this->status) {
                $q->where('status', $this->status);
            }
        });
        
        if ($this->payment_method_id) {
            $query->where('payment_method_id', $this->payment_method_id);
        }
        
        if ($this->search) {
            $query->whereHas('transaction', function($q) {
                $q->where('code', 'ilike', "%{$this->search}%")
                  ->orWhere('patient_name', 'ilike', "%{$this->search}%");
            });
        }
        
        return $query->orderBy('created_at', 'desc');
    }
    
    public function exportData()
    {
        // Implementation for export functionality
        $this->dispatch('export-started');
    }
    
    public function render()
    {
        $data = [];
        
        switch ($this->reportType) {
            case 'detailed':
                $data['reportData'] = $this->detailedReport->paginate($this->perPage);
                break;
            case 'payment':
                $data['reportData'] = $this->paymentReport->paginate($this->perPage);
                break;
            default:
                $data['reportData'] = $this->transactions->paginate($this->perPage);
                break;
        }
        
        return view('livewire.admin.report.transaction.admin-report-transaction-index', array_merge($data, [
            'summaryData' => $this->summaryData,
            'paymentMethods' => $this->paymentMethods,
            'doctors' => $this->doctors,
            'patients' => $this->patients,
            'branches' => $this->branches,
        ]))
        ->extends('layout.app')
        ->section('content');
    }
}