<?php

namespace App\Livewire\Admin\Master\Promotion\Create;

use Livewire\Component;

class AdminMasterPromotionCreateIndex extends Component
{
    public function render()
    {
        return view('livewire.admin.master.promotion.create.admin-master-promotion-create-index')
            ->extends('layout.app')
            ->section('content');
    }
}
