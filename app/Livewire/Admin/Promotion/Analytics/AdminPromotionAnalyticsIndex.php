<?php

namespace App\Livewire\Admin\Promotion\Analytics;

use App\Services\PromotionAnalyticsService;
use Livewire\Component;
use Carbon\Carbon;

class AdminPromotionAnalyticsIndex extends Component
{
    public $dateRange = '30';
    public $selectedCompany = null;
    public $analytics = null;
    public $realTimeData = null;

    protected $listeners = ['refreshAnalytics' => 'loadAnalytics'];

    public function mount()
    {
        $this->selectedCompany = auth()->user()->company_id ?? null;
        $this->loadAnalytics();
    }

    public function updatedDateRange()
    {
        $this->loadAnalytics();
    }

    public function loadAnalytics()
    {
        $analyticsService = new PromotionAnalyticsService();

        $dateRange = $this->getDateRange();
        $this->analytics = $analyticsService->getPromotionAnalytics(null, $dateRange);
        $this->realTimeData = $analyticsService->getRealTimeDashboard();
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
            // Implementation for exporting analytics data
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
        return view('livewire.admin.promotion.analytics.admin-promotion-analytics-index')
            ->extends('layout.app')
            ->section('content');
    }
}
