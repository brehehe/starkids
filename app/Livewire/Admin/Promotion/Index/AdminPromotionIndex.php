<?php

namespace App\Livewire\Admin\Promotion\Index;

use App\Livewire\Promotion\PromotionList;
use Livewire\Component;

class AdminPromotionIndex extends Component
{
    public function render()
    {
        return view('livewire.admin.promotion.index.admin-promotion-index')
            ->extends('layout.app')
            ->section('content');
    }
}
