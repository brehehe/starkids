<?php

namespace App\Livewire\Admin\Report\Purchase\Detail;

use App\Traits\Purchase\PurchaseOrderTrait;
use Illuminate\Support\Facades\Session;
use Livewire\Component;

class AdminReportPurchaseDetailIndex extends Component
{
    use PurchaseOrderTrait;

    public $purchase_order_id;

    public $purchase_order_item_id;

    public $purchase_order_item;

    public $quantity_arrival;

    public $hna;

    public $hna_ppn;

    public $price;

    public $sub_total;

    public $getQuantityAccepted;

    public $ppn;

    public $hna_old;

    public $hna_ppn_old;

    public $price_old;

    public $quantity_detail;

    public $ppn_old;

    public $batch_numbers = [];

    public function mount()
    {
        $this->purchase_order_id = Session::get('purchase_order_id');
    }

    public function render()
    {
        return view('livewire.admin.report.purchase.detail.admin-report-purchase-detail-index', [
            'purchaseOrder' => $this->getPurchaseOrder($this->purchase_order_id),
        ])
            ->extends('layout.app')
            ->section('content');
    }
}
