<?php

namespace App\Livewire\Admin\Report\Analytics;

use App\Models\Branch\Branch;
use App\Models\Patient\Patient;
use App\Models\PaymentMethod\PaymentMethod;
use App\Models\Product\Product;
use App\Models\Transaction\Transaction;
use App\Models\Transaction\TransactionDetail;
use App\Models\Transaction\TransactionPayment;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Livewire\Component;
use Livewire\WithPagination;

class AdminReportAnalyticsIndex extends Component
{
    use WithPagination;

    public $start_date;

    public $end_date;

    public $analytics_type = 'overview';

    public $doctor_id = '';

    public $branch_id = '';

    public $patient_id = '';

    public $product_id = '';

    public $payment_method_id = '';

    public $transaction_status = '';

    public $search = '';

    public $perPage = 25;

    public $period_type = 'daily'; // daily, weekly, monthly, yearly

    protected $queryString = [
        'start_date',
        'end_date',
        'analytics_type',
        'doctor_id',
        'branch_id',
        'patient_id',
        'product_id',
        'payment_method_id',
        'transaction_status',
        'search',
        'period_type',
    ];

    public function mount()
    {
        $this->start_date = now()->startOfMonth()->format('Y-m-d');
        $this->end_date = now()->format('Y-m-d');
    }

    public function updatedStartDate()
    {
        $this->resetPage();
    }

    public function updatedEndDate()
    {
        $this->resetPage();
    }

    public function updatedAnalyticsType()
    {
        $this->resetPage();
    }

    public function updatedDoctorId()
    {
        $this->resetPage();
    }

    public function updatedBranchId()
    {
        $this->resetPage();
    }

    public function updatedPatientId()
    {
        $this->resetPage();
    }

    public function updatedProductId()
    {
        $this->resetPage();
    }

    public function updatedPaymentMethodId()
    {
        $this->resetPage();
    }

    public function updatedTransactionStatus()
    {
        $this->resetPage();
    }

    public function updatedSearch()
    {
        $this->resetPage();
    }

    public function updatedPeriodType()
    {
        $this->resetPage();
    }

    public function getOverviewAnalyticsProperty()
    {
        $query = Transaction::where('company_id', auth()->user()->company_id);

        if ($this->start_date) {
            $query->whereDate('created_at', '>=', $this->start_date);
        }

        if ($this->end_date) {
            $query->whereDate('created_at', '<=', $this->end_date);
        }

        return [
            'total_transactions' => $query->count(),
            'total_revenue' => $query->sum('grand_total_price'),
            'total_profit' => $query->sum('grand_total_price') - $query->sum('price_product_price'),
            'average_transaction_value' => $query->avg('grand_total_price'),
            'completed_transactions' => $query->where('status', 'completed')->count(),
            'pending_transactions' => $query->whereIn('status', ['draft', 'process', 'waiting_consultation'])->count(),
            'cancelled_transactions' => $query->where('status', 'canceled')->count(),
            'consultation_transactions' => $query->where('type', 'konsultasi')->count(),
            'prescription_transactions' => $query->where('type', 'resep')->count(),
            'non_prescription_transactions' => $query->where('type', 'non-resep')->count(),
        ];
    }

    public function getRevenueAnalyticsProperty()
    {
        $query = Transaction::select(
            DB::raw($this->getDateGrouping().' as period'),
            DB::raw('COUNT(*) as transaction_count'),
            DB::raw('SUM(grand_total_price) as total_revenue'),
            DB::raw('SUM(price_product_price) as total_cost'),
            DB::raw('SUM(grand_total_price - price_product_price) as total_profit'),
            DB::raw('AVG(grand_total_price) as average_transaction')
        )
            ->where('company_id', auth()->user()->company_id)
            ->where('status', 'completed');

        if ($this->start_date) {
            $query->whereDate('created_at', '>=', $this->start_date);
        }

        if ($this->end_date) {
            $query->whereDate('created_at', '<=', $this->end_date);
        }

        return $query->groupBy('period')
            ->orderBy('period')
            ->get();
    }

    public function getProductAnalyticsProperty()
    {
        $query = TransactionDetail::select(
            'products.name as product_name',
            'products.sku_number',
            'product_categories.name as category_name',
            DB::raw('SUM(transaction_details.quantity) as total_quantity'),
            DB::raw('SUM(transaction_details.sub_total_price) as total_revenue'),
            DB::raw('SUM(transaction_details.sub_total_price_hpp) as total_cost'),
            DB::raw('SUM(transaction_details.sub_total_price - transaction_details.sub_total_price_hpp) as total_profit'),
            DB::raw('COUNT(DISTINCT transaction_details.transaction_id) as transaction_count')
        )
            ->join('transactions', 'transaction_details.transaction_id', '=', 'transactions.id')
            ->leftJoin('products', 'transaction_details.product_id', '=', 'products.id')
            ->leftJoin('product_categories', 'products.product_category_id', '=', 'product_categories.id')
            ->where('transactions.company_id', auth()->user()->company_id)
            ->where('transactions.status', 'completed');

        if ($this->start_date) {
            $query->whereDate('transactions.created_at', '>=', $this->start_date);
        }

        if ($this->end_date) {
            $query->whereDate('transactions.created_at', '<=', $this->end_date);
        }

        if ($this->product_id) {
            $query->where('transaction_details.product_id', $this->product_id);
        }

        if ($this->search) {
            $query->where(function ($q) {
                $q->where('products.name', 'like', '%'.$this->search.'%')
                    ->orWhere('products.sku_number', 'like', '%'.$this->search.'%')
                    ->orWhere('product_categories.name', 'like', '%'.$this->search.'%');
            });
        }

        return $query->groupBy('products.id', 'products.name', 'products.sku_number', 'product_categories.name')
            ->orderBy('total_revenue', 'desc')
            ->paginate($this->perPage);
    }

    public function getDoctorAnalyticsProperty()
    {
        $query = Transaction::select(
            'users.name as doctor_name',
            'users.email as doctor_email',
            DB::raw('COUNT(*) as total_consultations'),
            DB::raw('SUM(grand_total_price) as total_revenue'),
            DB::raw('AVG(grand_total_price) as average_consultation_value'),
            DB::raw('COUNT(CASE WHEN status = "completed" THEN 1 END) as completed_consultations'),
            DB::raw('COUNT(CASE WHEN status = "canceled" THEN 1 END) as cancelled_consultations')
        )
            ->leftJoin('users', 'transactions.doctor_id', '=', 'users.id')
            ->where('transactions.company_id', auth()->user()->company_id)
            ->whereNotNull('transactions.doctor_id');

        if ($this->start_date) {
            $query->whereDate('transactions.created_at', '>=', $this->start_date);
        }

        if ($this->end_date) {
            $query->whereDate('transactions.created_at', '<=', $this->end_date);
        }

        if ($this->doctor_id) {
            $query->where('transactions.doctor_id', $this->doctor_id);
        }

        if ($this->search) {
            $query->where(function ($q) {
                $q->where('users.name', 'like', '%'.$this->search.'%')
                    ->orWhere('users.email', 'like', '%'.$this->search.'%');
            });
        }

        return $query->groupBy('transactions.doctor_id', 'users.name', 'users.email')
            ->orderBy('total_revenue', 'desc')
            ->paginate($this->perPage);
    }

    public function getPatientAnalyticsProperty()
    {
        $query = Transaction::select(
            'transactions.patient_name',
            'patients.phone',
            'patients.email',
            DB::raw('COUNT(*) as total_visits'),
            DB::raw('SUM(grand_total_price) as total_spent'),
            DB::raw('AVG(grand_total_price) as average_visit_value'),
            DB::raw('MAX(transactions.created_at) as last_visit'),
            DB::raw('MIN(transactions.created_at) as first_visit')
        )
            ->leftJoin('patients', 'transactions.patient_id', '=', 'patients.id')
            ->where('transactions.company_id', auth()->user()->company_id)
            ->where('transactions.status', 'completed');

        if ($this->start_date) {
            $query->whereDate('transactions.created_at', '>=', $this->start_date);
        }

        if ($this->end_date) {
            $query->whereDate('transactions.created_at', '<=', $this->end_date);
        }

        if ($this->patient_id) {
            $query->where('transactions.patient_id', $this->patient_id);
        }

        if ($this->search) {
            $query->where(function ($q) {
                $q->where('transactions.patient_name', 'like', '%'.$this->search.'%')
                    ->orWhere('patients.phone', 'like', '%'.$this->search.'%')
                    ->orWhere('patients.email', 'like', '%'.$this->search.'%');
            });
        }

        return $query->groupBy('transactions.patient_id', 'transactions.patient_name', 'patients.phone', 'patients.email')
            ->orderBy('total_spent', 'desc')
            ->paginate($this->perPage);
    }

    public function getPaymentAnalyticsProperty()
    {
        $query = TransactionPayment::select(
            'payment_methods.name as payment_method_name',
            'payment_methods.type as payment_method_type',
            DB::raw('COUNT(*) as transaction_count'),
            DB::raw('SUM(payment_amount) as total_amount'),
            DB::raw('SUM(admin_fee) as total_admin_fee'),
            DB::raw('AVG(payment_amount) as average_amount')
        )
            ->join('transactions', 'transaction_payments.transaction_id', '=', 'transactions.id')
            ->join('payment_methods', 'transaction_payments.payment_method_id', '=', 'payment_methods.id')
            ->where('transactions.company_id', auth()->user()->company_id)
            ->where('transactions.status', 'completed');

        if ($this->start_date) {
            $query->whereDate('transactions.created_at', '>=', $this->start_date);
        }

        if ($this->end_date) {
            $query->whereDate('transactions.created_at', '<=', $this->end_date);
        }

        if ($this->payment_method_id) {
            $query->where('transaction_payments.payment_method_id', $this->payment_method_id);
        }

        return $query->groupBy('payment_methods.id', 'payment_methods.name', 'payment_methods.type')
            ->orderBy('total_amount', 'desc')
            ->paginate($this->perPage);
    }

    public function getBranchAnalyticsProperty()
    {
        $query = Transaction::select(
            'branches.name as branch_name',
            'branches.address as branch_address',
            DB::raw('COUNT(*) as total_transactions'),
            DB::raw('SUM(grand_total_price) as total_revenue'),
            DB::raw('AVG(grand_total_price) as average_transaction_value'),
            DB::raw('COUNT(CASE WHEN status = "completed" THEN 1 END) as completed_transactions')
        )
            ->leftJoin('branches', 'transactions.branch_id', '=', 'branches.id')
            ->where('transactions.company_id', auth()->user()->company_id);

        if ($this->start_date) {
            $query->whereDate('transactions.created_at', '>=', $this->start_date);
        }

        if ($this->end_date) {
            $query->whereDate('transactions.created_at', '<=', $this->end_date);
        }

        if ($this->branch_id) {
            $query->where('transactions.branch_id', $this->branch_id);
        }

        return $query->groupBy('transactions.branch_id', 'branches.name', 'branches.address')
            ->orderBy('total_revenue', 'desc')
            ->paginate($this->perPage);
    }

    private function getDateGrouping()
    {
        switch ($this->period_type) {
            case 'weekly':
                return "DATE_FORMAT(transactions.created_at, '%Y-%u')";
            case 'monthly':
                return "DATE_FORMAT(transactions.created_at, '%Y-%m')";
            case 'yearly':
                return "DATE_FORMAT(transactions.created_at, '%Y')";
            default: // daily
                return 'DATE(transactions.created_at)';
        }
    }

    public function getDoctorsProperty()
    {
        return User::where('company_id', auth()->user()->company_id)
            ->whereHas('roles', function ($query) {
                $query->where('name', 'doctor');
            })
            ->orderBy('name')
            ->get();
    }

    public function getBranchesProperty()
    {
        return Branch::where('company_id', auth()->user()->company_id)
            ->orderBy('name')
            ->get();
    }

    public function getPatientsProperty()
    {
        return Patient::where('company_id', auth()->user()->company_id)
            ->orderBy('name')
            ->limit(100)
            ->get();
    }

    public function getProductsProperty()
    {
        return Product::where('company_id', auth()->user()->company_id)
            ->orderBy('name')
            ->limit(100)
            ->get();
    }

    public function getPaymentMethodsProperty()
    {
        return PaymentMethod::where('company_id', auth()->user()->company_id)
            ->orderBy('name')
            ->get();
    }

    public function exportData()
    {
        $this->dispatch('export-started');
        // Export logic will be implemented here
    }

    public function render()
    {
        $analyticsData = null;

        switch ($this->analytics_type) {
            case 'revenue':
                $analyticsData = $this->revenueAnalytics;
                break;
            case 'product':
                $analyticsData = $this->productAnalytics;
                break;
            case 'doctor':
                $analyticsData = $this->doctorAnalytics;
                break;
            case 'patient':
                $analyticsData = $this->patientAnalytics;
                break;
            case 'payment':
                $analyticsData = $this->paymentAnalytics;
                break;
            case 'branch':
                $analyticsData = $this->branchAnalytics;
                break;
            default:
                $analyticsData = collect();
                break;
        }

        return view('livewire.admin.report.analytics.admin-report-analytics-index', [
            'overviewData' => $this->overviewAnalytics,
            'analyticsData' => $analyticsData,
            'doctors' => $this->doctors,
            'branches' => $this->branches,
            'patients' => $this->patients,
            'products' => $this->products,
            'paymentMethods' => $this->paymentMethods,
        ]);
    }
}
