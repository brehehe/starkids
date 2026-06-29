<?php

namespace App\Livewire\Admin\Master\Promotion\Analytics;

use Livewire\Component;

class AdminMasterPromotionAnalyticsIndex extends Component
{
    public function render()
    {
        return view('livewire.admin.master.promotion.analytics.admin-master-promotion-analytics-index')
            ->extends('layout.app')
            ->section('content');
    }
}
