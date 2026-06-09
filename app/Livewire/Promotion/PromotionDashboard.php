<?php

namespace App\Livewire\Promotion;

use App\Models\PromotionEvent;
use App\Services\PromotionAnalyticsService;
use Livewire\Component;
use Carbon\Carbon;

class PromotionDashboard extends Component
{
    public $dateRange = '30';
    public $selectedMetric = 'revenue';
    public $refreshInterval = 30000; // 30 seconds

    protected $listeners = ['refreshDashboard' => 'loadDashboardData'];

    public function mount()
    {
        $this->loadDashboardData();
    }

    public function updatedDateRange()
    {
        $this->loadDashboardData();
    }

    public function updatedSelectedMetric()
    {
        $this->loadDashboardData();
    }

    public function loadDashboardData()
    {
        $analyticsService = new PromotionAnalyticsService();

        // Get date range
        $dateRange = $this->getDateRange();

        // Load analytics data
        $this->analytics = $analyticsService->getPromotionAnalytics(null, $dateRange);
        $this->realTimeData = $analyticsService->getRealTimeDashboard();

        $this->dispatch('dashboard-updated');
    }

    protected function getDateRange()
    {
        $end = Carbon::now();

        switch ($this->dateRange) {
            case '7':
                $start = Carbon::now()->subDays(7);
                break;
            case '30':
                $start = Carbon::now()->subDays(30);
                break;
            case '90':
                $start = Carbon::now()->subDays(90);
                break;
            case 'year':
                $start = Carbon::now()->subYear();
                break;
            default:
                $start = Carbon::now()->subDays(30);
        }

        return [
            'start' => $start->format('Y-m-d'),
            'end' => $end->format('Y-m-d')
        ];
    }

    public function exportAnalytics()
    {
        try {
            $analyticsService = new PromotionAnalyticsService();
            $dateRange = $this->getDateRange();
            $data = $analyticsService->getPromotionAnalytics(null, $dateRange);

            // Here you would implement export logic (CSV, Excel, PDF)
            $this->dispatch('export-started', [
                'message' => 'Export analytics dimulai...',
                'type' => 'info'
            ]);
        } catch (\Exception $e) {
            $this->dispatch('export-error', [
                'message' => 'Gagal mengexport data analytics',
                'type' => 'error'
            ]);
        }
    }

    public function render()
    {
        $topPromotions = PromotionEvent::withCount('usageHistories')
            ->orderBy('usage_histories_count', 'desc')
            ->limit(5)
            ->get();

        $recentPromotions = PromotionEvent::latest()
            ->limit(5)
            ->get();

        $expiringPromotions = PromotionEvent::expiringSoon()
            ->limit(5)
            ->get();

        return view('livewire.promotion.promotion-dashboard', [
            'topPromotions' => $topPromotions,
            'recentPromotions' => $recentPromotions,
            'expiringPromotions' => $expiringPromotions,
        ]);
    }
}
