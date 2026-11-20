<?php

namespace App\Livewire\Admin\Dashboard;

use App\Helpers\AlertHelper;
use App\Models\PaymentMethod\PaymentMethod;
use App\Models\Transaction\Transaction;
use App\Models\Transaction\TransactionDetail;
use App\Models\Transaction\TransactionPayment;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Livewire\Component;
use Livewire\WithPagination;

class AdminDashboardIndex extends Component
{
    use WithPagination;

    public function mount()
    {
        if (session()->has('saved')) {
            AlertHelper::success(session('saved.title'), session('saved.text'));
            session()->forget('saved');

            return;
        }
    }

    public function render()
    {
        // Get today's data
        $today = Carbon::today();
        $yesterday = Carbon::yesterday();
        $startOfMonth = Carbon::now()->startOfMonth();
        $lastMonth = Carbon::now()->subMonth();

        $user = Auth::user();
        $companyId = $user?->company_id;
        $isDoctor = $user && $user->hasRole('Dokter') && ! $user->hasRole('Super Admin');

        $baseTransactionQuery = function () use ($companyId, $isDoctor, $user) {
            $query = Transaction::query();
            if ($companyId) {
                $query->where('transactions.company_id', $companyId);
            }
            if ($isDoctor) {
                $query->where('transactions.doctor_id', $user->id);
            }

            return $query;
        };

        // Today's revenue & data
        $todayStats = $baseTransactionQuery()
            ->where('transactions.status', 'completed')
            ->whereDate('transactions.created_at', $today)
            ->selectRaw('count(*) as count, sum(transactions.grand_total_price) as revenue')
            ->first();

        $todayRevenue = $todayStats->revenue ?? 0;
        $todayTransactions = $todayStats->count ?? 0;

        // Yesterday's data
        $yesterdayStats = $baseTransactionQuery()
            ->where('transactions.status', 'completed')
            ->whereDate('transactions.created_at', $yesterday)
            ->selectRaw('count(*) as count, sum(transactions.grand_total_price) as revenue')
            ->first();

        $yesterdayRevenue = $yesterdayStats->revenue ?? 0;
        $yesterdayTransactions = $yesterdayStats->count ?? 0;

        // Calculate revenue growth
        $revenueGrowth = $yesterdayRevenue > 0
            ? (($todayRevenue - $yesterdayRevenue) / $yesterdayRevenue) * 100
            : 0;

        $transactionGrowth = $yesterdayTransactions > 0
            ? (($todayTransactions - $yesterdayTransactions) / $yesterdayTransactions) * 100
            : 0;

        // Average transaction value
        $avgTransaction = $todayTransactions > 0 ? $todayRevenue / $todayTransactions : 0;
        $yesterdayAvg = $yesterdayTransactions > 0 ? $yesterdayRevenue / $yesterdayTransactions : 0;

        $avgGrowth = $yesterdayAvg > 0
            ? (($avgTransaction - $yesterdayAvg) / $yesterdayAvg) * 100
            : 0;

        // Total customers this month
        $totalCustomers = $baseTransactionQuery()
            ->where('transactions.status', 'completed')
            ->distinct('transactions.patient_id')
            ->count('transactions.patient_id');

        $lastMonthCustomers = $baseTransactionQuery()
            ->where('transactions.status', 'completed')
            ->where('transactions.created_at', '<', $startOfMonth)
            ->distinct('transactions.patient_id')
            ->count('transactions.patient_id');

        $customerGrowth = $lastMonthCustomers > 0
            ? (($totalCustomers - $lastMonthCustomers) / $lastMonthCustomers) * 100
            : 0;

        // Monthly revenue data for chart (last 6 months)
        $monthlyQuery = $baseTransactionQuery()
            ->where('transactions.status', 'completed');

        if (DB::connection()->getDriverName() === 'sqlite') {
            $monthlyData = $monthlyQuery->select(
                DB::raw("cast(strftime('%Y', transactions.created_at) as integer) as year"),
                DB::raw("cast(strftime('%m', transactions.created_at) as integer) as month"),
                DB::raw('SUM(transactions.grand_total_price) as total_revenue')
            )
                ->groupBy(DB::raw("strftime('%Y', transactions.created_at)"), DB::raw("strftime('%m', transactions.created_at)"))
                ->orderBy('year', 'asc')
                ->orderBy('month', 'asc')
                ->get();
        } else {
            $monthlyData = $monthlyQuery->select(
                DB::raw('EXTRACT(YEAR FROM transactions.created_at) as year'),
                DB::raw('EXTRACT(MONTH FROM transactions.created_at) as month'),
                DB::raw('SUM(transactions.grand_total_price) as total_revenue')
            )
                ->groupBy('year', 'month')
                ->orderBy('year', 'asc')
                ->orderBy('month', 'asc')
                ->get();
        }

        $monthlyLabels = [];
        $monthlyRevenue = [];

        for ($i = 5; $i >= 0; $i--) {
            $date = Carbon::now()->subMonths($i);
            $monthlyLabels[] = $date->format('M Y');

            $revenue = $monthlyData->where('year', $date->year)
                ->where('month', $date->month)
                ->first();

            $monthlyRevenue[] = $revenue ? $revenue->total_revenue : 0;
        }

        // Transaction types data
        $transactionTypes = $baseTransactionQuery()
            ->where('transactions.status', 'completed')
            ->select('transactions.type', DB::raw('COUNT(*) as count'))
            ->groupBy('transactions.type')
            ->get();

        $transactionTypesLabels = $transactionTypes->pluck('type')->map(function ($type) {
            return ucfirst($type);
        })->toArray();
        $transactionTypesData = $transactionTypes->pluck('count')->toArray();

        // Daily transactions for last 7 days
        $dailyData = [];
        $dailyLabels = [];

        // Optimize: Fetch all daily counts in one query
        $startDate = Carbon::now()->subDays(6)->startOfDay();
        $endDate = Carbon::now()->endOfDay();

        $dailyCounts = $baseTransactionQuery()
            ->where('transactions.status', 'completed')
            ->whereBetween('transactions.created_at', [$startDate, $endDate])
            ->select(
                DB::raw('DATE(transactions.created_at) as date'),
                DB::raw('COUNT(*) as count')
            )
            ->groupBy(DB::raw('DATE(transactions.created_at)'))
            ->pluck('count', 'date');

        for ($i = 6; $i >= 0; $i--) {
            $date = Carbon::now()->subDays($i);
            $dateKey = $date->format('Y-m-d');

            $dailyLabels[] = $date->format('M d');
            // Use the fetched data or 0 if no transactions for that day
            $dailyData[] = $dailyCounts[$dateKey] ?? 0;
        }

        // Top selling products
        $topProductsQuery = TransactionDetail::select(
            'transaction_details.product_id',
            'products.name as product_name',
            DB::raw('SUM(transaction_details.quantity) as total_quantity'),
            DB::raw('SUM(transaction_details.sub_total_price) as total_revenue')
        )
            ->join('products', 'transaction_details.product_id', '=', 'products.id')
            ->join('transactions', 'transaction_details.transaction_id', '=', 'transactions.id')
            ->where('transactions.status', 'completed');

        if ($companyId) {
            $topProductsQuery->where('transactions.company_id', $companyId);
        }
        if ($isDoctor) {
            $topProductsQuery->where('transactions.doctor_id', $user->id);
        }

        $topProducts = $topProductsQuery->groupBy('transaction_details.product_id', 'products.name')
            ->orderBy('total_revenue', 'desc')
            ->limit(5)
            ->get();

        // Payment methods analysis from transaction_payments table
        $paymentMethodsQuery = TransactionPayment::select(
            'payment_methods.name as payment_method_name',
            DB::raw('COUNT(*) as transaction_count'),
            DB::raw('SUM(transaction_payments.payment_amount) as total_amount')
        )
            ->join('payment_methods', 'transaction_payments.payment_method_id', '=', 'payment_methods.id')
            ->join('transactions', 'transaction_payments.transaction_id', '=', 'transactions.id')
            ->where('transactions.status', 'completed');

        if ($companyId) {
            $paymentMethodsQuery->where('transactions.company_id', $companyId);
        }
        if ($isDoctor) {
            $paymentMethodsQuery->where('transactions.doctor_id', $user->id);
        }

        $paymentMethodsData = $paymentMethodsQuery->groupBy('payment_methods.id', 'payment_methods.name')
            ->orderBy('total_amount', 'desc')
            ->get();

        $paymentMethodsLabels = $paymentMethodsData->pluck('payment_method_name')->toArray();
        $paymentMethodsAmounts = $paymentMethodsData->pluck('total_amount')->toArray();
        $paymentMethodsCounts = $paymentMethodsData->pluck('transaction_count')->toArray();

        // Top patients analysis
        $topPatients = $baseTransactionQuery()
            ->where('transactions.status', 'completed')
            ->whereNotNull('transactions.patient_id')
            ->select(
                'transactions.patient_id',
                'transactions.patient_name',
                DB::raw('COUNT(*) as total_transactions'),
                DB::raw('SUM(transactions.grand_total_price) as total_spent')
            )
            ->groupBy('transactions.patient_id', 'transactions.patient_name')
            ->orderBy('total_spent', 'desc')
            ->limit(5)
            ->get();

        // Additional metrics
        $avgTransactionValue = $baseTransactionQuery()
            ->where('transactions.status', 'completed')
            ->avg('transactions.grand_total_price') ?? 0;

        $totalPaymentMethods = PaymentMethod::count();

        $mostUsedPaymentMethod = $paymentMethodsData->first();

        // Transaction completion rate
        $totalTransactions = $baseTransactionQuery()->count();
        $completedTransactions = $baseTransactionQuery()
            ->where('transactions.status', 'completed')
            ->count();
        $completionRate = $totalTransactions > 0 ? ($completedTransactions / $totalTransactions) * 100 : 0;

        // Recent transactions
        $recentTransactions = $baseTransactionQuery()
            ->with(['patient'])
            ->select('transactions.*', 'users.name as patient_name')
            ->leftJoin('users', 'transactions.patient_id', '=', 'users.id')
            ->where('transactions.status', 'completed')
            ->orderBy('transactions.created_at', 'desc')
            ->paginate(5);

        return view('livewire.admin.dashboard.admin-dashboard-index', [
            'isDoctor' => $isDoctor,
            'todayRevenue' => $todayRevenue,
            'revenueGrowth' => $revenueGrowth,
            'todayTransactions' => $todayTransactions,
            'transactionGrowth' => $transactionGrowth,
            'avgTransaction' => $avgTransaction,
            'avgGrowth' => $avgGrowth,
            'totalCustomers' => $totalCustomers,
            'customerGrowth' => $customerGrowth,
            'monthlyLabels' => $monthlyLabels,
            'monthlyRevenue' => $monthlyRevenue,
            'transactionTypesLabels' => $transactionTypesLabels,
            'transactionTypesData' => $transactionTypesData,
            'dailyLabels' => $dailyLabels,
            'dailyTransactions' => $dailyData,
            'topProducts' => $topProducts,
            'paymentMethodsLabels' => $paymentMethodsLabels,
            'paymentMethodsData' => $paymentMethodsAmounts,
            'paymentMethodsAmounts' => $paymentMethodsData,
            'paymentMethodsCounts' => $paymentMethodsCounts,
            'topPatients' => $topPatients,
            'avgTransactionValue' => $avgTransactionValue,
            'totalPaymentMethods' => $totalPaymentMethods,
            'mostUsedPaymentMethod' => $mostUsedPaymentMethod,
            'completionRate' => $completionRate,
            'recentTransactions' => $recentTransactions,
        ])
            ->extends('layout.app')
            ->section('content');
    }
}
