<?php

namespace App\Livewire\Admin\Promotion\Dashboard;

use App\Models\Promotion\Promotion;
use App\Models\Promotion\PromotionUsage;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Carbon\Carbon;

class AdminPromotionDashboardIndex extends Component
{
    public $stats = [];
    public $chartData = [];

    public function mount()
    {
        $this->loadStats();
        $this->loadChartData();
    }

    public function loadStats()
    {
        $companyId = Auth::user()->company_id;

        $this->stats = [
            'total_promotions' => Promotion::where('company_id', $companyId)->count(),
            'active_promotions' => Promotion::where('company_id', $companyId)->where('is_active', true)->count(),
            'expired_promotions' => Promotion::where('company_id', $companyId)
                ->where('end_date', '<', Carbon::now())->count(),
            'total_usage' => PromotionUsage::whereHas('promotion', function ($query) use ($companyId) {
                $query->where('company_id', $companyId);
            })->count(),
            'total_discount_given' => PromotionUsage::whereHas('promotion', function ($query) use ($companyId) {
                $query->where('company_id', $companyId);
            })->sum('discount_amount'),
            'upcoming_promotions' => Promotion::where('company_id', $companyId)
                ->where('start_date', '>', Carbon::now())->count(),
        ];
    }

    public function loadChartData()
    {
        $companyId = Auth::user()->company_id;

        // Get usage data for the last 7 days
        $last7Days = collect();
        for ($i = 6; $i >= 0; $i--) {
            $date = Carbon::now()->subDays($i);
            $usage = PromotionUsage::whereHas('promotion', function ($query) use ($companyId) {
                $query->where('company_id', $companyId);
            })
                ->whereDate('created_at', $date)
                ->count();

            $last7Days->push([
                'date' => $date->format('M d'),
                'usage' => $usage
            ]);
        }

        $this->chartData = $last7Days->toArray();
    }

    public function render()
    {
        $recentPromotions = Promotion::where('company_id', Auth::user()->company_id)
            ->latest()
            ->take(5)
            ->get();

        $topPromotions = Promotion::where('company_id', Auth::user()->company_id)
            ->orderBy('used_count', 'desc')
            ->take(5)
            ->get();

        return view('livewire.admin.promotion.dashboard.admin-promotion-dashboard-index', [
            'recentPromotions' => $recentPromotions,
            'topPromotions' => $topPromotions,
        ])
            ->extends('layout.app')
            ->section('content');
    }
}
