<?php

namespace App\Http\Requests\Promotion;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StorePromotionRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return $this->user()->can('create promotions');
    }

    /**
     * Get the validation rules that apply to the request.
     */
    public function rules(): array
    {
        return [
            'code' => [
                'nullable',
                'string',
                'max:50',
                'unique:promotions,code',
                'regex:/^[A-Z0-9]+$/', // Only uppercase letters and numbers
            ],
            'name' => 'required|string|max:255',
            'description' => 'nullable|string|max:1000',
            'type' => [
                'required',
                Rule::in(['percentage', 'fixed_amount', 'buy_x_get_y', 'free_shipping', 'bundle', 'cashback', 'loyalty_points']),
            ],
            'start_date' => 'required|date|after_or_equal:today',
            'end_date' => 'required|date|after:start_date',

            // Discount settings
            'discount_value' => 'nullable|numeric|min:0|max:100',
            'minimum_purchase' => 'nullable|numeric|min:0',
            'maximum_discount' => 'nullable|numeric|min:0',

            // Usage limits
            'usage_limit' => 'nullable|integer|min:1',
            'usage_limit_per_customer' => 'nullable|integer|min:1|max:100',

            // Customer targeting
            'customer_type' => [
                'required',
                Rule::in(['all', 'new', 'existing', 'vip', 'specific']),
            ],
            'customer_ids' => 'nullable|array',
            'customer_ids.*' => 'exists:users,id',

            // Product applicability
            'applicable_to' => [
                'required',
                Rule::in(['all_products', 'specific_products', 'categories', 'services']),
            ],
            'product_ids' => 'nullable|array',
            'product_ids.*' => 'string', // UUID format
            'category_ids' => 'nullable|array',
            'category_ids.*' => 'string', // UUID format
            'service_ids' => 'nullable|array',
            'service_ids.*' => 'string', // UUID format

            // Buy X Get Y settings
            'buy_quantity' => 'nullable|integer|min:1|required_if:type,buy_x_get_y',
            'get_quantity' => 'nullable|integer|min:1|required_if:type,buy_x_get_y',
            'get_product_id' => 'nullable|string|required_if:type,buy_x_get_y',

            // Bundle settings
            'bundle_products' => 'nullable|array|required_if:type,bundle',
            'bundle_products.*.product_id' => 'required_with:bundle_products|string',
            'bundle_products.*.quantity' => 'required_with:bundle_products|integer|min:1',
            'bundle_price' => 'nullable|numeric|min:0|required_if:type,bundle',

            // Settings
            'auto_apply' => 'boolean',
            'is_featured' => 'boolean',
            'image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',

            // Terms and conditions
            'terms_conditions' => 'nullable|array',
            'terms_conditions.*' => 'string|max:500',
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
            'start_date.after_or_equal' => 'Tanggal mulai tidak boleh di masa lalu',
            'end_date.after' => 'Tanggal berakhir harus setelah tanggal mulai',
            'discount_value.max' => 'Nilai diskon persentase maksimal 100%',
            'customer_type.in' => 'Tipe customer tidak valid',
            'applicable_to.in' => 'Target produk tidak valid',
            'buy_quantity.required_if' => 'Jumlah beli wajib diisi untuk promosi Buy X Get Y',
            'get_quantity.required_if' => 'Jumlah gratis wajib diisi untuk promosi Buy X Get Y',
            'bundle_products.required_if' => 'Produk bundle wajib diisi untuk promosi bundle',
            'bundle_price.required_if' => 'Harga bundle wajib diisi untuk promosi bundle',
            'image.image' => 'File harus berupa gambar',
            'image.mimes' => 'Format gambar harus jpeg, png, atau jpg',
            'image.max' => 'Ukuran gambar maksimal 2MB',
        ];
    }

    /**
     * Configure the validator instance.
     */
    public function withValidator($validator)
    {
        $validator->after(function ($validator) {
            // Custom validation for percentage discount
            if ($this->type === 'percentage' && $this->discount_value > 100) {
                $validator->errors()->add('discount_value', 'Nilai diskon persentase tidak boleh lebih dari 100%');
            }

            // Validate minimum purchase vs maximum discount
            if ($this->minimum_purchase && $this->maximum_discount && $this->minimum_purchase < $this->maximum_discount) {
                $validator->errors()->add('minimum_purchase', 'Minimal pembelian harus lebih besar dari maksimal diskon');
            }

            // Validate customer_ids when customer_type is specific
            if ($this->customer_type === 'specific' && empty($this->customer_ids)) {
                $validator->errors()->add('customer_ids', 'Customer IDs wajib diisi ketika tipe customer adalah specific');
            }

            // Validate product targeting
            if (in_array($this->applicable_to, ['specific_products', 'categories', 'services'])) {
                $field = $this->applicable_to === 'specific_products' ? 'product_ids' : ($this->applicable_to === 'categories' ? 'category_ids' : 'service_ids');

                if (empty($this->$field)) {
                    $validator->errors()->add($field, 'Field ini wajib diisi untuk target yang dipilih');
                }
            }
        });
    }
}
