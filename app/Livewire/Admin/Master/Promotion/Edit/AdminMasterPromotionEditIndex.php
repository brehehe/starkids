<?php

namespace App\Livewire\Admin\Master\Promotion\Edit;

use App\Models\Promotion\PromotionEvent;
use App\Services\Promotion\PromotionService;
use Livewire\Component;
use Illuminate\Support\Str;

class AdminMasterPromotionEditIndex extends Component
{
    public $promotionId;
    public $promotion;

    // Form fields
    public $name = '';
    public $code = '';
    public $description = '';
    public $type = 'percentage';
    public $start_date = '';
    public $end_date = '';
    public $discount_value = '';
    public $minimum_purchase = '';
    public $maximum_discount = '';
    public $usage_limit = '';
    public $usage_limit_per_customer = '';
    public $customer_type = 'all';
    public $customer_ids = [];
    public $applicable_to = 'all_products';
    public $product_ids = [];
    public $category_ids = [];
    public $service_ids = [];
    public $buy_quantity = '';
    public $get_quantity = '';
    public $get_product_id = '';
    public $bundle_products = [];
    public $bundle_price = '';
    public $auto_apply = false;
    public $is_featured = false;
    public $current_image_path = '';
    public $terms_conditions = [];
    public $is_active = true;

    public function mount($id)
    {
        $this->promotionId = $id;
        $this->promotion = PromotionEvent::findOrFail($id);
        $this->loadPromotionData();
    }

    public function loadPromotionData()
    {
        $this->name = $this->promotion->name ?? '';
        $this->code = $this->promotion->code ?? '';
        $this->description = $this->promotion->description ?? '';
        $this->type = $this->promotion->type ?? 'percentage';
        $this->start_date = $this->promotion->start_date ? $this->promotion->start_date->format('Y-m-d') : '';
        $this->end_date = $this->promotion->end_date ? $this->promotion->end_date->format('Y-m-d') : '';
        $this->discount_value = $this->promotion->discount_value ?? '';
        $this->minimum_purchase = $this->promotion->minimum_purchase ?? '';
        $this->maximum_discount = $this->promotion->maximum_discount ?? '';
        $this->usage_limit = $this->promotion->usage_limit ?? '';
        $this->usage_limit_per_customer = $this->promotion->usage_limit_per_customer ?? '';
        $this->customer_type = $this->promotion->customer_type ?? 'all';
        $this->customer_ids = $this->promotion->customer_ids ?? [];
        $this->applicable_to = $this->promotion->applicable_to ?? 'all_products';
        $this->product_ids = $this->promotion->product_ids ?? [];
        $this->category_ids = $this->promotion->category_ids ?? [];
        $this->service_ids = $this->promotion->service_ids ?? [];
        $this->buy_quantity = $this->promotion->buy_quantity ?? '';
        $this->get_quantity = $this->promotion->get_quantity ?? '';
        $this->get_product_id = $this->promotion->get_product_id ?? '';
        $this->bundle_products = $this->promotion->bundle_products ?? [];
        $this->bundle_price = $this->promotion->bundle_price ?? '';
        $this->auto_apply = $this->promotion->auto_apply ?? false;
        $this->is_featured = $this->promotion->is_featured ?? false;
        $this->current_image_path = $this->promotion->image_path ?? '';
        $this->terms_conditions = $this->promotion->terms_conditions ?? [];
        $this->is_active = $this->promotion->is_active ?? true;
    }

    public function rules()
    {
        return [
            'name' => 'required|string|max:255',
            'code' => 'nullable|string|max:50|unique:promotions,code,' . $this->promotionId,
            'description' => 'nullable|string|max:1000',
            'type' => 'required|in:percentage,fixed_amount,buy_x_get_y,free_shipping,bundle,cashback,loyalty_points',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after:start_date',
            'discount_value' => 'nullable|numeric|min:0',
            'minimum_purchase' => 'nullable|numeric|min:0',
            'maximum_discount' => 'nullable|numeric|min:0',
            'usage_limit' => 'nullable|integer|min:1',
            'usage_limit_per_customer' => 'nullable|integer|min:1|max:100',
            'customer_type' => 'required|in:all,new,existing,vip,specific',
            'applicable_to' => 'required|in:all_products,specific_products,categories,services',
            'auto_apply' => 'boolean',
            'is_featured' => 'boolean',
            'is_active' => 'boolean',
        ];
    }

    public function generateCode()
    {
        $this->code = 'PROMO' . strtoupper(\Str::random(6));
    }

    public function addTerm()
    {
        $this->terms_conditions[] = '';
    }

    public function removeTerm($index)
    {
        unset($this->terms_conditions[$index]);
        $this->terms_conditions = array_values($this->terms_conditions);
    }

    public function addBundleProduct()
    {
        $this->bundle_products[] = [
            'product_id' => '',
            'quantity' => 1
        ];
    }

    public function removeBundleProduct($index)
    {
        unset($this->bundle_products[$index]);
        $this->bundle_products = array_values($this->bundle_products);
    }

    public function save()
    {
        $this->validate();

        try {
            $promotionService = new PromotionService();

            $data = [
                'name' => $this->name,
                'code' => $this->code,
                'description' => $this->description,
                'type' => $this->type,
                'start_date' => $this->start_date,
                'end_date' => $this->end_date,
                'discount_value' => $this->discount_value,
                'minimum_purchase' => $this->minimum_purchase,
                'maximum_discount' => $this->maximum_discount,
                'usage_limit' => $this->usage_limit,
                'usage_limit_per_customer' => $this->usage_limit_per_customer,
                'customer_type' => $this->customer_type,
                'customer_ids' => $this->customer_type === 'specific' ? $this->customer_ids : null,
                'applicable_to' => $this->applicable_to,
                'product_ids' => $this->applicable_to === 'specific_products' ? $this->product_ids : null,
                'category_ids' => $this->applicable_to === 'categories' ? $this->category_ids : null,
                'service_ids' => $this->applicable_to === 'services' ? $this->service_ids : null,
                'buy_quantity' => $this->type === 'buy_x_get_y' ? $this->buy_quantity : null,
                'get_quantity' => $this->type === 'buy_x_get_y' ? $this->get_quantity : null,
                'get_product_id' => $this->type === 'buy_x_get_y' ? $this->get_product_id : null,
                'bundle_products' => $this->type === 'bundle' ? $this->bundle_products : null,
                'bundle_price' => $this->type === 'bundle' ? $this->bundle_price : null,
                'auto_apply' => $this->auto_apply,
                'is_featured' => $this->is_featured,
                'is_active' => $this->is_active,
                'terms_conditions' => array_filter($this->terms_conditions),
            ];

            $promotion = $promotionService->updatePromotion($this->promotionId, $data);

            session()->flash('message', 'Promosi berhasil diperbarui');

            return redirect()->route('user.master.promotion');
        } catch (\Exception $e) {
            session()->flash('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    public function cancel()
    {
        return redirect()->route('user.master.promotion');
    }

    public function delete()
    {
        try {
            // Check if promotion has been used
            if ($this->promotion->usage_count > 0) {
                session()->flash('error', 'Promosi tidak dapat dihapus karena sudah pernah digunakan');
                return;
            }

            $this->promotion->delete();
            session()->flash('message', 'Promosi berhasil dihapus');

            return redirect()->route('user.master.promotion');
        } catch (\Exception $e) {
            session()->flash('error', 'Terjadi kesalahan saat menghapus promosi');
        }
    }

    public function render()
    {
        $promotionTypes = [
            'percentage' => 'Persentase (%)',
            'fixed_amount' => 'Nominal Tetap (Rp)',
            'buy_x_get_y' => 'Beli X Gratis Y',
            'free_shipping' => 'Gratis Ongkir',
            'bundle' => 'Paket Bundle',
            'cashback' => 'Cashback',
            'loyalty_points' => 'Poin Loyalitas'
        ];

        $customerTypes = [
            'all' => 'Semua Customer',
            'new' => 'Customer Baru',
            'existing' => 'Customer Lama',
            'vip' => 'Customer VIP',
            'specific' => 'Customer Tertentu'
        ];

        $applicableToOptions = [
            'all_products' => 'Semua Produk',
            'specific_products' => 'Produk Tertentu',
            'categories' => 'Kategori Tertentu',
            'services' => 'Layanan Tertentu'
        ];

        return view('livewire.admin.master.promotion.edit.admin-master-promotion-edit-index', [
            'promotionTypes' => $promotionTypes,
            'customerTypes' => $customerTypes,
            'applicableToOptions' => $applicableToOptions,
        ])->extends('layout.app')->section('content');
    }
}
