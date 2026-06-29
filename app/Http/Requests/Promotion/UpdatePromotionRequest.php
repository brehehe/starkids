<?php

namespace App\Http\Requests\Promotion;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdatePromotionRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return $this->user()->can('update promotions');
    }

    /**
     * Get the validation rules that apply to the request.
     */
    public function rules(): array
    {
        $promotionId = $this->route('promotion');

        return [
            'code' => [
                'nullable',
                'string',
                'max:50',
                'unique:promotions,code,'.$promotionId,
                'regex:/^[A-Z0-9]+$/',
            ],
            'name' => 'sometimes|required|string|max:255',
            'description' => 'nullable|string|max:1000',
            'type' => [
                'sometimes|required',
                Rule::in(['percentage', 'fixed_amount', 'buy_x_get_y', 'free_shipping', 'bundle', 'cashback', 'loyalty_points']),
            ],
            'start_date' => 'sometimes|required|date',
            'end_date' => 'sometimes|required|date|after:start_date',

            // Discount settings
            'discount_value' => 'nullable|numeric|min:0|max:100',
            'minimum_purchase' => 'nullable|numeric|min:0',
            'maximum_discount' => 'nullable|numeric|min:0',

            // Usage limits
            'usage_limit' => 'nullable|integer|min:1',
            'usage_limit_per_customer' => 'nullable|integer|min:1|max:100',

            // Customer targeting
            'customer_type' => [
                'sometimes|required',
                Rule::in(['all', 'new', 'existing', 'vip', 'specific']),
            ],
            'customer_ids' => 'nullable|array',
            'customer_ids.*' => 'exists:users,id',

            // Product applicability
            'applicable_to' => [
                'sometimes|required',
                Rule::in(['all_products', 'specific_products', 'categories', 'services']),
            ],
            'product_ids' => 'nullable|array',
            'product_ids.*' => 'string',
            'category_ids' => 'nullable|array',
            'category_ids.*' => 'string',
            'service_ids' => 'nullable|array',
            'service_ids.*' => 'string',

            // Buy X Get Y settings
            'buy_quantity' => 'nullable|integer|min:1',
            'get_quantity' => 'nullable|integer|min:1',
            'get_product_id' => 'nullable|string',

            // Bundle settings
            'bundle_products' => 'nullable|array',
            'bundle_products.*.product_id' => 'required_with:bundle_products|string',
            'bundle_products.*.quantity' => 'required_with:bundle_products|integer|min:1',
            'bundle_price' => 'nullable|numeric|min:0',

            // Settings
            'auto_apply' => 'boolean',
            'is_featured' => 'boolean',
            'image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',

            // Terms and conditions
            'terms_conditions' => 'nullable|array',
            'terms_conditions.*' => 'string|max:500',

            // Status
            'is_active' => 'boolean',
        ];
    }

    /**
     * Get custom error messages
     */
    public function messages(): array
    {
        return [
            'code.regex' => 'Kode promosi hanya boleh berisi huruf besar dan angka',
            'type.in' => 'Tipe promosi tidak valid',
            'end_date.after' => 'Tanggal berakhir harus setelah tanggal mulai',
            'discount_value.max' => 'Nilai diskon persentase maksimal 100%',
            'customer_type.in' => 'Tipe customer tidak valid',
            'applicable_to.in' => 'Target produk tidak valid',
            'image.image' => 'File harus berupa gambar',
            'image.mimes' => 'Format gambar harus jpeg, png, atau jpg',
            'image.max' => 'Ukuran gambar maksimal 2MB',
        ];
    }
}
