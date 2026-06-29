<?php

namespace App\Livewire\Admin\Dashboard;

use App\Helpers\AlertHelper;
use App\Models\PaymentMethod\PaymentMethod;
use App\Models\Transaction\Transaction;
use App\Models\Transaction\TransactionDetail;
use App\Models\Transaction\TransactionPayment;
use Carbon\Carbon;
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

        // Today's revenue
        // Today's data
        $todayStats = Transaction::where('status', 'completed')
            ->whereDate('created_at', $today)
            ->selectRaw('count(*) as count, sum(grand_total_price) as revenue')
            ->first();

        $todayRevenue = $todayStats->revenue ?? 0;
        $todayTransactions = $todayStats->count;

        // Yesterday's data
        $yesterdayStats = Transaction::where('status', 'completed')
            ->whereDate('created_at', $yesterday)
            ->selectRaw('count(*) as count, sum(grand_total_price) as revenue')
            ->first();

        $yesterdayRevenue = $yesterdayStats->revenue ?? 0;
        $yesterdayTransactions = $yesterdayStats->count;

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
        $totalCustomers = Transaction::distinct('patient_id')
            ->count('patient_id');

        $lastMonthCustomers = Transaction::distinct('patient_id')
            ->count('patient_id');

        $customerGrowth = $lastMonthCustomers > 0
            ? (($totalCustomers - $lastMonthCustomers) / $lastMonthCustomers) * 100
            : 0;

        // Monthly revenue data for chart (last 6 months)
        if (DB::connection()->getDriverName() === 'sqlite') {
            $monthlyData = Transaction::select(
                DB::raw("cast(strftime('%Y', created_at) as integer) as year"),
                DB::raw("cast(strftime('%m', created_at) as integer) as month"),
                DB::raw('SUM(grand_total_price) as total_revenue')
            )
                ->where('status', 'completed')
                ->groupBy(DB::raw("strftime('%Y', created_at)"), DB::raw("strftime('%m', created_at)"))
                ->orderBy('year', 'asc')
                ->orderBy('month', 'asc')
                ->get();
        } else {
            $monthlyData = Transaction::select(
                DB::raw('EXTRACT(YEAR FROM created_at) as year'),
                DB::raw('EXTRACT(MONTH FROM created_at) as month'),
                DB::raw('SUM(grand_total_price) as total_revenue')
            )
                ->where('status', 'completed')
                // ->where('created_at', '>=', Carbon::now()->subMonths(6))
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
        $transactionTypes = Transaction::select('type', DB::raw('COUNT(*) as count'))
            // ->whereMonth('created_at', Carbon::now()->month)
            ->groupBy('type')
            ->get();

        $transactionTypesLabels = $transactionTypes->pluck('type')->map(function ($type) {
            return ucfirst($type);
        })->toArray();
        $transactionTypesData = $transactionTypes->pluck('count')->toArray();

        // Daily transactions for last 7 days
        // Daily transactions for last 7 days
        $dailyData = [];
        $dailyLabels = [];

        // Optimize: Fetch all daily counts in one query
        $startDate = Carbon::now()->subDays(6)->startOfDay();
        $endDate = Carbon::now()->endOfDay();

        $dailyCounts = Transaction::select(
            DB::raw('DATE(created_at) as date'),
            DB::raw('COUNT(*) as count')
        )
            ->whereBetween('created_at', [$startDate, $endDate])
            ->groupBy(DB::raw('DATE(created_at)'))
            ->pluck('count', 'date');

        for ($i = 6; $i >= 0; $i--) {
            $date = Carbon::now()->subDays($i);
            $dateKey = $date->format('Y-m-d');

            $dailyLabels[] = $date->format('M d');
            // Use the fetched data or 0 if no transactions for that day
            $dailyData[] = $dailyCounts[$dateKey] ?? 0;
        }

        // Top selling products
        $topProducts = TransactionDetail::select(
            'transaction_details.product_id',
            'products.name as product_name',
            DB::raw('SUM(transaction_details.quantity) as total_quantity'),
            DB::raw('SUM(transaction_details.sub_total_price) as total_revenue')
        )
            ->join('products', 'transaction_details.product_id', '=', 'products.id')
            ->join('transactions', 'transaction_details.transaction_id', '=', 'transactions.id')
            ->where('transactions.status', 'completed')
            // ->whereMonth('transactions.created_at', Carbon::now()->month)
            ->groupBy('transaction_details.product_id', 'products.name')
            ->orderBy('total_revenue', 'desc')
            ->limit(5)
            ->get();

        // Payment methods analysis from transaction_payments table
        $paymentMethodsData = TransactionPayment::select(
            'payment_methods.name as payment_method_name',
            DB::raw('COUNT(*) as transaction_count'),
            DB::raw('SUM(transaction_payments.payment_amount) as total_amount')
        )
            ->join('payment_methods', 'transaction_payments.payment_method_id', '=', 'payment_methods.id')
            ->join('transactions', 'transaction_payments.transaction_id', '=', 'transactions.id')
            ->where('transactions.status', 'completed')
            // ->whereMonth('transactions.created_at', Carbon::now()->month)
            ->groupBy('payment_methods.id', 'payment_methods.name')
            ->orderBy('total_amount', 'desc')
            ->get();

        $paymentMethodsLabels = $paymentMethodsData->pluck('payment_method_name')->toArray();
        $paymentMethodsAmounts = $paymentMethodsData->pluck('total_amount')->toArray();
        $paymentMethodsCounts = $paymentMethodsData->pluck('transaction_count')->toArray();

        // Top patients analysis
        $topPatients = Transaction::select(
            'transactions.patient_id',
            'transactions.patient_name',
            DB::raw('COUNT(*) as total_transactions'),
            DB::raw('SUM(transactions.grand_total_price) as total_spent')
        )
            ->where('transactions.status', 'completed')
            // ->whereMonth('transactions.created_at', Carbon::now()->month)
            ->whereNotNull('transactions.patient_id')
            ->groupBy('transactions.patient_id', 'transactions.patient_name')
            ->orderBy('total_spent', 'desc')
            ->limit(5)
            ->get();

        // Additional metrics
        $avgTransactionValue = Transaction::where('status', 'completed')
            // ->whereMonth('created_at', Carbon::now()->month)
            ->avg('grand_total_price') ?? 0;

        $totalPaymentMethods = PaymentMethod::count();

        $mostUsedPaymentMethod = $paymentMethodsData->first();

        // Transaction completion rate
        $totalTransactions = Transaction::count();
        $completedTransactions = Transaction::where('status', 'completed')
            // ->whereMonth('created_at', Carbon::now()->month)
            ->count();
        $completionRate = $totalTransactions > 0 ? ($completedTransactions / $totalTransactions) * 100 : 0;

        // Recent transactions
        $recentTransactions = Transaction::with(['patient'])
            ->select('transactions.*', 'users.name as patient_name')
            ->leftJoin('users', 'transactions.patient_id', '=', 'users.id')
            ->orderBy('created_at', 'desc')
            ->where('transactions.status', 'completed')
            ->paginate(5);

        return view('livewire.admin.dashboard.admin-dashboard-index', [
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
