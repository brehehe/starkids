<?php

namespace App\Livewire\Admin\Receipt\MailOrder;

use App\Models\PurchaseOrder\PurchaseOrder;
use App\Models\PurchaseRequisition\PurchaseRequisition;
use Livewire\Component;

class AdminReceiptMailOrderIndex extends Component
{
    public $purchase_order;

    public function mount($purchase_order_id)
    {
        $this->purchase_order = PurchaseRequisition::find($purchase_order_id);
    }

    public function render()
    {
        return view('livewire.admin.receipt.mail-order.admin-receipt-mail-order-index')
            ->extends('layout.receipt.mail-order')
            ->section('content');
    }
}
