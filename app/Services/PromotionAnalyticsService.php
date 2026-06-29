<?php

namespace App\Services;

use App\Models\PromotionEvent;
use App\Models\PromotionUsageHistory;
use Carbon\Carbon;

class PromotionAnalyticsService
{
    /**
     * Get promotion performance analytics
     */
    public function getPromotionAnalytics($promotionId = null, $dateRange = null): array
    {
        $query = PromotionEvent::query();

        if ($promotionId) {
            $query->where('id', $promotionId);
        }

        if ($dateRange) {
            $query->whereBetween('created_at', [
                Carbon::parse($dateRange['start']),
                Carbon::parse($dateRange['end']),
            ]);
        }

        $promotions = $query->with(['usageHistories'])->get();

        return [
            'overview' => $this->getOverviewMetrics($promotions),
            'revenue_impact' => $this->getRevenueImpact($promotions),
            'customer_engagement' => $this->getCustomerEngagement($promotions),
            'product_performance' => $this->getProductPerformance($promotions),
            'time_analysis' => $this->getTimeAnalysis($promotions),
            'conversion_metrics' => $this->getConversionMetrics($promotions),
        ];
    }

    /**
     * Get overview metrics
     */
    protected function getOverviewMetrics($promotions): array
    {
        $totalPromotions = $promotions->count();
        $activePromotions = $promotions->where('is_active', true)->count();
        $totalUsage = $promotions->sum('usage_count');
        $totalRevenue = $promotions->sum(function ($promotion) {
            return $promotion->usageHistories->sum('final_amount');
        });
        $totalSavings = $promotions->sum(function ($promotion) {
            return $promotion->usageHistories->sum('discount_amount');
        });

        return [
            'total_promotions' => $totalPromotions,
            'active_promotions' => $activePromotions,
            'inactive_promotions' => $totalPromotions - $activePromotions,
            'total_usage' => $totalUsage,
            'total_revenue' => $totalRevenue,
            'total_savings' => $totalSavings,
            'average_usage_per_promotion' => $totalPromotions > 0 ? round($totalUsage / $totalPromotions, 2) : 0,
            'average_savings_per_use' => $totalUsage > 0 ? round($totalSavings / $totalUsage, 2) : 0,
        ];
    }

    /**
     * Get revenue impact analysis
     */
    protected function getRevenueImpact($promotions): array
    {
        $revenueByType = [];
        $savingsByType = [];
        $roiByPromotion = [];

        foreach ($promotions as $promotion) {
            $type = $promotion->type;
            $revenue = $promotion->usageHistories->sum('final_amount');
            $savings = $promotion->usageHistories->sum('discount_amount');
            $originalRevenue = $promotion->usageHistories->sum('original_amount');

            if (! isset($revenueByType[$type])) {
                $revenueByType[$type] = 0;
                $savingsByType[$type] = 0;
            }

            $revenueByType[$type] += $revenue;
            $savingsByType[$type] += $savings;

            // Calculate ROI (assuming the promotion cost is the discount given)
            $roi = $savings > 0 ? (($revenue - $savings) / $savings) * 100 : 0;
            $roiByPromotion[] = [
                'promotion_id' => $promotion->id,
                'promotion_name' => $promotion->name,
                'type' => $type,
                'revenue' => $revenue,
                'savings' => $savings,
                'roi_percentage' => round($roi, 2),
            ];
        }

        return [
            'revenue_by_type' => $revenueByType,
            'savings_by_type' => $savingsByType,
            'roi_by_promotion' => collect($roiByPromotion)->sortByDesc('roi_percentage')->values()->all(),
            'best_performing_type' => collect($revenueByType)->sortDesc()->keys()->first(),
            'most_cost_effective_type' => collect($savingsByType)->sort()->keys()->first(),
        ];
    }

    /**
     * Get customer engagement metrics
     */
    protected function getCustomerEngagement($promotions): array
    {
        $allUsages = collect();
        foreach ($promotions as $promotion) {
            $allUsages = $allUsages->merge($promotion->usageHistories);
        }

        $uniqueCustomers = $allUsages->pluck('customer_id')->unique()->count();
        $repeatCustomers = $allUsages->groupBy('customer_id')
            ->filter(function ($usages) {
                return $usages->count() > 1;
            })->count();

        $customerSegments = $this->analyzeCustomerSegments($allUsages);
        $loyaltyMetrics = $this->calculateLoyaltyMetrics($allUsages);

        return [
            'unique_customers' => $uniqueCustomers,
            'repeat_customers' => $repeatCustomers,
            'customer_retention_rate' => $uniqueCustomers > 0 ? round(($repeatCustomers / $uniqueCustomers) * 100, 2) : 0,
            'average_promotions_per_customer' => $uniqueCustomers > 0 ? round($allUsages->count() / $uniqueCustomers, 2) : 0,
            'customer_segments' => $customerSegments,
            'loyalty_metrics' => $loyaltyMetrics,
        ];
    }

    /**
     * Analyze customer segments
     */
    protected function analyzeCustomerSegments($usages): array
    {
        $customerSpending = $usages->groupBy('customer_id')->map(function ($customerUsages) {
            return [
                'total_spent' => $customerUsages->sum('final_amount'),
                'total_saved' => $customerUsages->sum('discount_amount'),
                'usage_count' => $customerUsages->count(),
            ];
        });

        $totalSpent = $customerSpending->pluck('total_spent');
        $avgSpending = $totalSpent->avg();

        return [
            'high_value' => $customerSpending->filter(function ($customer) use ($avgSpending) {
                return $customer['total_spent'] > $avgSpending * 2;
            })->count(),
            'medium_value' => $customerSpending->filter(function ($customer) use ($avgSpending) {
                return $customer['total_spent'] >= $avgSpending && $customer['total_spent'] <= $avgSpending * 2;
            })->count(),
            'low_value' => $customerSpending->filter(function ($customer) use ($avgSpending) {
                return $customer['total_spent'] < $avgSpending;
            })->count(),
        ];
    }

    /**
     * Calculate loyalty metrics
     */
    protected function calculateLoyaltyMetrics($usages): array
    {
        $customerFrequency = $usages->groupBy('customer_id')->map->count();

        return [
            'most_loyal_customer_uses' => $customerFrequency->max(),
            'average_frequency' => round($customerFrequency->avg(), 2),
            'frequency_distribution' => [
                'one_time' => $customerFrequency->filter(fn ($count) => $count == 1)->count(),
                'occasional' => $customerFrequency->filter(fn ($count) => $count >= 2 && $count <= 5)->count(),
                'frequent' => $customerFrequency->filter(fn ($count) => $count >= 6 && $count <= 10)->count(),
                'super_loyal' => $customerFrequency->filter(fn ($count) => $count > 10)->count(),
            ],
        ];
    }

    /**
     * Get product performance metrics
     */
    protected function getProductPerformance($promotions): array
    {
        $productMetrics = [];

        foreach ($promotions as $promotion) {
            foreach ($promotion->usageHistories as $usage) {
                if ($usage->product_ids) {
                    foreach ($usage->product_ids as $productId) {
                        if (! isset($productMetrics[$productId])) {
                            $productMetrics[$productId] = [
                                'usage_count' => 0,
                                'total_revenue' => 0,
                                'total_savings' => 0,
                            ];
                        }

                        $productMetrics[$productId]['usage_count']++;
                        $productMetrics[$productId]['total_revenue'] += $usage->final_amount;
                        $productMetrics[$productId]['total_savings'] += $usage->discount_amount;
                    }
                }
            }
        }

        // Sort by usage count
        uasort($productMetrics, function ($a, $b) {
            return $b['usage_count'] - $a['usage_count'];
        });

        return [
            'top_promoted_products' => array_slice($productMetrics, 0, 10, true),
            'product_performance_summary' => [
                'total_products_promoted' => count($productMetrics),
                'most_popular_product_id' => array_key_first($productMetrics),
                'average_usage_per_product' => count($productMetrics) > 0 ? round(array_sum(array_column($productMetrics, 'usage_count')) / count($productMetrics), 2) : 0,
            ],
        ];
    }

    /**
     * Get time-based analysis
     */
    protected function getTimeAnalysis($promotions): array
    {
        $usageByHour = [];
        $usageByDay = [];
        $usageByMonth = [];

        foreach ($promotions as $promotion) {
            foreach ($promotion->usageHistories as $usage) {
                $hour = $usage->used_at->format('H');
                $day = $usage->used_at->format('l');
                $month = $usage->used_at->format('Y-m');

                $usageByHour[$hour] = ($usageByHour[$hour] ?? 0) + 1;
                $usageByDay[$day] = ($usageByDay[$day] ?? 0) + 1;
                $usageByMonth[$month] = ($usageByMonth[$month] ?? 0) + 1;
            }
        }

        return [
            'peak_hour' => $usageByHour ? array_keys($usageByHour, max($usageByHour))[0] : null,
            'peak_day' => $usageByDay ? array_keys($usageByDay, max($usageByDay))[0] : null,
            'usage_by_hour' => $usageByHour,
            'usage_by_day' => $usageByDay,
            'monthly_trend' => $usageByMonth,
        ];
    }

    /**
     * Get conversion metrics
     */
    protected function getConversionMetrics($promotions): array
    {
        $totalPromotions = $promotions->count();
        $usedPromotions = $promotions->filter(function ($promotion) {
            return $promotion->usage_count > 0;
        })->count();

        $conversionRates = [];
        foreach ($promotions as $promotion) {
            if ($promotion->usage_limit) {
                $conversionRate = ($promotion->usage_count / $promotion->usage_limit) * 100;
                $conversionRates[] = [
                    'promotion_id' => $promotion->id,
                    'promotion_name' => $promotion->name,
                    'conversion_rate' => round($conversionRate, 2),
                ];
            }
        }

        return [
            'overall_utilization_rate' => $totalPromotions > 0 ? round(($usedPromotions / $totalPromotions) * 100, 2) : 0,
            'conversion_by_promotion' => collect($conversionRates)->sortByDesc('conversion_rate')->values()->all(),
            'average_conversion_rate' => collect($conversionRates)->avg('conversion_rate'),
            'best_converting_promotion' => collect($conversionRates)->sortByDesc('conversion_rate')->first(),
        ];
    }

    /**
     * Get real-time analytics dashboard data
     */
    public function getRealTimeDashboard(): array
    {
        $today = Carbon::today();
        $thisWeek = Carbon::now()->startOfWeek();
        $thisMonth = Carbon::now()->startOfMonth();

        return [
            'today' => $this->getDashboardMetrics($today),
            'this_week' => $this->getDashboardMetrics($thisWeek),
            'this_month' => $this->getDashboardMetrics($thisMonth),
            'active_promotions' => PromotionEvent::active()->count(),
            'expiring_soon' => PromotionEvent::expiringSoon()->count(),
            'recent_activities' => $this->getRecentActivities(),
        ];
    }

    /**
     * Get dashboard metrics for a period
     */
    protected function getDashboardMetrics($startDate): array
    {
        $usages = PromotionUsageHistory::where('used_at', '>=', $startDate)->get();

        return [
            'total_uses' => $usages->count(),
            'total_revenue' => $usages->sum('final_amount'),
            'total_savings' => $usages->sum('discount_amount'),
            'unique_customers' => $usages->pluck('customer_id')->unique()->count(),
        ];
    }

    /**
     * Get recent promotion activities
     */
    protected function getRecentActivities(): array
    {
        return PromotionUsageHistory::with(['promotion', 'customer'])
            ->latest('used_at')
            ->limit(10)
            ->get()
            ->map(function ($usage) {
                return [
                    'customer_name' => $usage->customer->name ?? 'Unknown',
                    'promotion_name' => $usage->promotion->name,
                    'discount_amount' => $usage->discount_amount,
                    'used_at' => $usage->used_at->diffForHumans(),
                ];
            })
            ->toArray();
    }
}
