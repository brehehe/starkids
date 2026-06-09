<?php

namespace App\Livewire\Admin\Promotion\Create;

use App\Helpers\AlertHelper;
use Livewire\Component;
use App\Models\Promotion\PromotionSimplified;
use App\Models\Company\Company;
use App\Models\User;
use App\Models\User\UserType;
use App\Models\Product\Product;
use App\Models\Product\ProductPrice;
use App\Helpers\PromotionHelper;
use Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Collection;
use Carbon\Carbon;
use Livewire\WithFileUploads;

class AdminPromotionCreateIndex extends Component
{
    use WithFileUploads;
    // Basic promotion fields
    public $promotion_id = null;
    public $name = '';
    public $code = '';
    public $description = '';
    public $type = 'discount'; // percentage, fixed_amount, free_shipping, buy_x_get_y
    public $value = 0;
    public $minimum_purchase = 0;
    public $maximum_discount = null;
    public $usage_limit = null;
    public $usage_limit_per_user = null;
    public $start_date = '';
    public $end_date = '';
    public $start_time = '';
    public $end_time = '';
    public $is_active = true;
    public $is_unlimited = true;
    public $total_quota = null;
    public $quota_per_user = 1;
    public $search = null;

    // Additional promotion fields
    public $priority = 1;
    public $banner_text = '';
    public $image = null;
    public $can_combine_with_other = false;

    // Buy X Get Y fields
    public $buy_quantity = 1;
    public $get_quantity = 1;
    public $buy_product_id = null;
    public $get_product_id = null;

    // Multiple Buy X Get Y rules
    public $buy_x_get_y_rules = [];

    // Bundle fields
    public $bundle_price = 0;
    public $bundle_products = [];

    // Special promotion fields
    public $special_type = 'cashback';
    public $cashback_percentage = 0;
    public $max_cashback = null;
    public $free_shipping_min = 0;
    public $points_multiplier = 1;

    // Discount fields
    public $discount_type = 'percentage';
    public $discount_value = 0;
    public $max_discount = null;

    // Discount products for new discount_product type
    public $discount_products = [];
    public $selected_discount_products = [];
    public $bulk_discount_type = 'percentage';
    public $bulk_discount_value = 0;

    // COMPANY TARGETING (PRIORITAS UTAMA)
    public $company_target_type = 'current'; // current, all, specific
    public $applicable_companies = [];
    public $current_company_only = true;

    // Additional targeting
    public $applicable_products = [];
    public $applicable_user_types = [];
    public $applicable_users = [];
    public $applicable_days = []; // Array of days when promotion is applicable

    // Schedule type options
    public $schedule_type = 'always'; // always, days_only, time_only, days_and_time
    public $specific_days = []; // For days_only and days_and_time
    public $specific_start_time = '';
    public $specific_end_time = '';
    public $apply_time_to_days = false; // Apply time restrictions to specific days only

    // Terms and conditions
    public $terms_conditions = [''];

    // Selection arrays for UI
    public $selectedCompanies = [];
    public $selectedProducts = [];
    public $selectedUserTypes = [];
    public $selectedUsers = [];

    // Available options
    public $companies = [];
    public $products = [];
    public $userTypes = [];
    public $users = [];

    protected $rules = [
        'name' => 'required|string|max:255',
        'code' => 'required|string|max:50',
        'type' => 'required|in:discount,buy_x_get_y,special,discount_product',
        'minimum_purchase' => 'nullable|numeric|min:0',
        'maximum_discount' => 'nullable|numeric|min:0',
        'usage_limit' => 'nullable|integer|min:1',
        'usage_limit_per_user' => 'nullable|integer|min:1',
        'start_date' => 'required|date',
        'end_date' => 'required|date|after:start_date',
    ];

    protected $messages = [
        'name.required' => 'Nama promosi harus diisi.',
        'code.required' => 'Kode promosi harus diisi.',
        'type.required' => 'Tipe promosi harus dipilih.',
        'start_date.required' => 'Tanggal mulai harus diisi.',
        'end_date.required' => 'Tanggal berakhir harus diisi.',
        'end_date.after' => 'Tanggal berakhir harus setelah tanggal mulai.',
    ];

    public function mount($id = null)
    {
        // Initialize arrays to ensure they're always arrays
        $this->bundle_products = [['product_id' => '', 'quantity' => 1]];
        $this->terms_conditions = [''];
        $this->buy_x_get_y_rules = [];
        $this->discount_products = [];
        $this->applicable_companies = [];
        $this->applicable_products = [];
        $this->applicable_user_types = [];
        $this->applicable_users = [];
        $this->applicable_days = [];
        $this->specific_days = [];

        if ($id) {
            $this->promotion_id = $id;
            $this->loadPromotion();
        } else {
            // For new promotions, initialize Buy X Get Y rules if the type is already set
            if ($this->type === 'buy_x_get_y') {
                $this->initializeBuyXGetYRules();
            }
        }

        $this->loadOptions();
        $this->setupDefaultDates();
    }

    public function updatedSearch()
    {
        $this->loadOptions();
    }

    public function loadPromotion()
    {
        $promotion = PromotionSimplified::find($this->promotion_id);
        if ($promotion) {
            $this->name = $promotion->name;
            $this->code = $promotion->code;
            $this->description = $promotion->description ?? '';
            $this->type = $promotion->type;
            $this->value = $promotion->value;
            $this->minimum_purchase = $promotion->minimum_purchase ?? 0;
            $this->maximum_discount = $promotion->maximum_discount;
            $this->usage_limit = $promotion->usage_limit;
            $this->usage_limit_per_user = $promotion->usage_limit_per_user;
            $this->start_date = $promotion->start_date ? Carbon::parse($promotion->start_date)->format('Y-m-d') : '';
            $this->end_date = $promotion->end_date ? Carbon::parse($promotion->end_date)->format('Y-m-d') : '';
            $this->is_active = $promotion->is_active;

            // Load targeting data
            $this->applicable_companies = is_array($promotion->applicable_companies) ? $promotion->applicable_companies : (json_decode($promotion->applicable_companies, true) ?? []);
            $this->applicable_products = is_array($promotion->applicable_products) ? $promotion->applicable_products : (json_decode($promotion->applicable_products, true) ?? []);
            $this->applicable_user_types = is_array($promotion->applicable_user_types) ? $promotion->applicable_user_types : (json_decode($promotion->applicable_user_types, true) ?? []);
            $this->applicable_users = is_array($promotion->applicable_users) ? $promotion->applicable_users : (json_decode($promotion->applicable_users, true) ?? []);
            $this->applicable_days = is_array($promotion->applicable_days) ? $promotion->applicable_days : (json_decode($promotion->applicable_days, true) ?? []);
            $this->terms_conditions = is_array($promotion->terms_conditions) ? $promotion->terms_conditions : (json_decode($promotion->terms_conditions, true) ?? ['']);

            // Load schedule data
            $this->schedule_type = $promotion->schedule_type ?? 'always';
            $this->specific_days = is_array($promotion->specific_days) ? $promotion->specific_days : (json_decode($promotion->specific_days, true) ?? []);
            $this->specific_start_time = $promotion->specific_start_time ?? '';
            $this->specific_end_time = $promotion->specific_end_time ?? '';
            $this->apply_time_to_days = $promotion->apply_time_to_days ?? false;

            // Load promotion specific data
            if ($promotion->type === 'buy_x_get_y') {
                $this->buy_x_get_y_rules = is_array($promotion->buy_x_get_y_rules) ? $promotion->buy_x_get_y_rules : (json_decode($promotion->buy_x_get_y_rules, true) ?? []);
            }
            if ($promotion->type === 'discount_product') {
                $this->discount_products = is_array($promotion->discount_products) ? $promotion->discount_products : (json_decode($promotion->discount_products, true) ?? []);
            }
            if ($promotion->type === 'discount') {
                $this->discount_type = $promotion->discount_type ?? 'percentage';
                $this->discount_value = $promotion->discount_value ?? 0;
                $this->max_discount = $promotion->max_discount;
            }

            // Set UI selections
            $this->selectedCompanies = $this->applicable_companies;
            $this->selectedProducts = $this->applicable_products;
            $this->selectedUserTypes = $this->applicable_user_types;
            $this->selectedUsers = $this->applicable_users;

            // Determine company target type
            if (empty($this->applicable_companies)) {
                $this->company_target_type = 'all';
            } elseif (count($this->applicable_companies) == 1 && in_array(Auth::user()->company_id, $this->applicable_companies)) {
                $this->company_target_type = 'current';
                $this->current_company_only = true;
            } else {
                $this->company_target_type = 'specific';
            }
        }
    }

    public function loadOptions()
    {
        $currentCompanyId = Auth::user()->company_id ?? null;

        // Load companies
        $this->companies = Company::select('id', 'name')
            ->orderBy('name')
            ->get();

        // Load products from current company
        if ($currentCompanyId) {
            $this->products = [];

            $this->products = Product::where('company_id', $currentCompanyId)->search($this->search)
                ->select('id', 'name', 'sku_number')
                ->orderBy('name')
                ->get();
        }

        // Load user types
        $this->userTypes = UserType::select('id', 'name')
            ->orderBy('name')
            ->get();

        $users = User::select('id', 'name', 'email', 'company_id')
            ->with(['company:id,name',])
            ->orderBy('name');

        if ($this->selectedUserTypes) {
            $users->whereIn('user_type_id', $this->selectedUserTypes);
        }

        // if ($this->selectedCompanies) {
        //     $users->whereIn('company_id', $this->selectedCompanies);
        // }

        $this->users = $users->get();
    }

    public function setupDefaultDates()
    {
        if (!$this->start_date) {
            $this->start_date = now()->format('Y-m-d');
        }
        if (!$this->end_date) {
            $this->end_date = now()->addMonth()->format('Y-m-d');
        }
    }

    public function updatedCompanyTargetType()
    {
        if ($this->company_target_type === 'current') {
            $this->selectedCompanies = [Auth::user()->company_id ?? null];
            $this->current_company_only = true;
        } elseif ($this->company_target_type === 'all') {
            $companys = Company::select('id')->pluck('id')->toArray();
            $this->selectedCompanies = $companys;
            $this->current_company_only = false;
        } else {
            $this->current_company_only = false;
        }

        $this->loadOptions();
        $this->updateApplicableCompanies();
    }

    public function updatedCurrentCompanyOnly()
    {
        if ($this->current_company_only) {
            $this->company_target_type = 'current';
            $this->selectedCompanies = [Auth::user()->company_id ?? null];
        }

        $this->updateApplicableCompanies();
    }

    public function updatedSelectedCompanies()
    {
        $this->updateApplicableCompanies();
    }

    public function updatedSelectedProducts()
    {
        $this->applicable_products = $this->selectedProducts;
    }

    public function updatedSelectedUserTypes()
    {
        $this->applicable_user_types = $this->selectedUserTypes;
    }

    public function updatedSelectedUsers()
    {
        $this->applicable_users = $this->selectedUsers;
    }

    public function updateApplicableCompanies()
    {
        if ($this->company_target_type === 'all') {
            $this->applicable_companies = [];
        } else {
            $this->applicable_companies = $this->selectedCompanies;
        }
    }

    public function addTermCondition()
    {
        $this->terms_conditions[] = '';
    }

    public function removeTermCondition($index)
    {
        if (count($this->terms_conditions) > 1) {
            unset($this->terms_conditions[$index]);
            $this->terms_conditions = array_values($this->terms_conditions);
        }
    }

    public function generateCode()
    {
        $this->code = 'PROMO' . strtoupper(substr(md5(time()), 0, 6));
    }

    public function save()
    {
        // Custom validation for code uniqueness
        if ($this->promotion_id) {
            // For editing existing promotion
            $this->rules['code'] = 'required|string|max:50|unique:promotion_simplified,code,' . $this->promotion_id;
        } else {
            // For creating new promotion
            $this->rules['code'] = 'required|string|max:50|unique:promotion_simplified,code';
        }

        $this->validate();

        // Additional validation for buy_x_get_y type
        if ($this->type === 'buy_x_get_y') {
            // Fix array structure before validation
            $this->validateBuyXGetYRulesStructure();

            if (empty($this->buy_x_get_y_rules)) {
                return AlertHelper::error('Minimal satu aturan Buy X Get Y harus ditambahkan.');
            }

            foreach ($this->buy_x_get_y_rules as $index => $rule) {
                if (!is_array($rule)) {
                    return AlertHelper::error("Aturan #" . ($index + 1) . " memiliki format yang tidak valid.");
                }
                if (empty($rule['buy_quantity']) || $rule['buy_quantity'] < 1) {
                    return AlertHelper::error("Jumlah beli pada aturan #" . ($index + 1) . " harus minimal 1.");
                }
                if (empty($rule['get_quantity']) || $rule['get_quantity'] < 1) {
                    return AlertHelper::error("Jumlah gratis pada aturan #" . ($index + 1) . " harus minimal 1.");
                }
                if (empty($rule['buy_product_id']) || empty($rule['get_product_id'])) {
                    return AlertHelper::error("Produk beli dan produk gratis harus dipilih pada aturan #" . ($index + 1) . ".");
                }
            }
        }

        if ($this->type == 'discount_product') {
            if (empty($this->discount_products)) {
                return AlertHelper::error('Gagal', 'Minimal satu produk diskon harus ditambahkan.');
            }
        }

        // Additional validation for discount type
        if ($this->type === 'discount') {
            if (empty($this->discount_value) || $this->discount_value <= 0) {
                return AlertHelper::error('Nilai diskon harus diisi dan lebih dari 0.');
            }
            if ($this->discount_type === 'percentage' && $this->discount_value > 100) {
                return AlertHelper::error('Nilai diskon persentase tidak boleh lebih dari 100%.');
            }
        }

        if ($this->schedule_type) {
            if ($this->schedule_type === 'specific_days' && empty($this->specific_days)) {
                return AlertHelper::error('Hari tertentu harus dipilih.');
            } elseif ($this->schedule_type === 'days_and_time' && (empty($this->specific_days) || empty($this->specific_start_time) || empty($this->specific_end_time))) {
                return AlertHelper::error('Hari tertentu dan waktu harus diisi.');
            } elseif ($this->schedule_type === 'time_only' && (empty($this->specific_start_time) || empty($this->specific_end_time))) {
                return AlertHelper::error('Waktu mulai dan berakhir harus diisi.');
            } elseif ($this->schedule_type === 'days_only' && empty($this->specific_days)) {
                return AlertHelper::error('Hari tertentu harus dipilih.');
            }
        }

        try {
            DB::beginTransaction();

            // Filter empty terms and conditions
            $filteredTerms = array_filter($this->terms_conditions, function ($term) {
                return !empty(trim($term));
            });

            $data = [
                'company_id' => Auth::user()->company_id ?? null,
                'name' => $this->name,
                'code' => $this->code,
                'description' => $this->description,
                'type' => $this->type,
                'minimum_purchase' => $this->minimum_purchase ?: 0,
                'start_date' => $this->start_date,
                'end_date' => $this->end_date,
                'is_active' => $this->is_active,
                'total_quota' => $this->total_quota !== '' ? $this->total_quota : null,
                'quota_per_user' => $this->quota_per_user ?: 1,
                'used_count' => 0,
                'is_unlimited' => $this->is_unlimited,
                // Discount fields (only if type is discount)
                'discount_type' => $this->type === 'discount' ? $this->discount_type : null,
                'discount_value' => $this->type === 'discount' ? ($this->discount_value ?: 0) : null,
                'max_discount' => $this->type === 'discount'
                    ? ($this->max_discount !== '' ? $this->max_discount : null)
                    : null,
                // Buy X Get Y fields (only if type is buy_x_get_y)
                'buy_quantity' => $this->type === 'buy_x_get_y' ? ($this->buy_quantity ?: 1) : null,
                'get_quantity' => $this->type === 'buy_x_get_y' ? ($this->get_quantity ?: 1) : null,
                // Bundle fields (only if type is bundle)
                'bundle_price' => $this->type === 'bundle'
                    ? ($this->bundle_price !== '' ? $this->bundle_price : 0)
                    : null,
                'bundle_products' => $this->type === 'bundle' ? $this->bundle_products : null,
                // Special fields (only if type is special)
                'special_type' => $this->type === 'special' ? $this->special_type : null,
                'cashback_percentage' => $this->type === 'special'
                    ? ($this->cashback_percentage !== '' ? $this->cashback_percentage : 0)
                    : null,
                'points_multiplier' => $this->type === 'special'
                    ? ($this->points_multiplier !== '' ? $this->points_multiplier : 1)
                    : null,
                // Additional fields from migrations
                'applicable_companies' => !empty($this->applicable_companies) ? $this->applicable_companies : null,
                'applicable_products' => !empty($this->applicable_products) ? $this->applicable_products : null,
                'applicable_user_types' => !empty($this->applicable_user_types) ? $this->applicable_user_types : null,
                'applicable_users' => !empty($this->applicable_users) ? $this->applicable_users : null,
                'applicable_days' => !empty($this->applicable_days) ? $this->applicable_days : null,
                'schedule_type' => $this->schedule_type,
                'specific_days' => !empty($this->specific_days) ? $this->specific_days : null,
                'specific_start_time' => $this->specific_start_time ?: null,
                'specific_end_time' => $this->specific_end_time ?: null,
                'apply_time_to_days' => $this->apply_time_to_days,
                'terms_conditions' => !empty($filteredTerms) ? array_values($filteredTerms) : null,
                'buy_x_get_y_rules' => ($this->type === 'buy_x_get_y' && !empty($this->buy_x_get_y_rules)) ? $this->buy_x_get_y_rules : null,
                'discount_products' => ($this->type === 'discount_product' && !empty($this->discount_products)) ? $this->discount_products : null,
            ];

            if ($this->promotion_id) {
                $promotion = PromotionSimplified::find($this->promotion_id);
                $promotion->update($data);
                $message = 'Promosi berhasil diperbarui.';
            } else {
                PromotionSimplified::create($data);
                $message = 'Promosi berhasil dibuat.';
            }

            DB::commit();

            session()->flash('message', $message);
            return redirect()->route('admin.promotion.index');
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Error saving promotion: ' . $e->getMessage());

            return AlertHelper::error('Gagal menyimpan promosi: ' . $e->getMessage());
        }
    }

    public function addBundleProduct()
    {
        $this->bundle_products[] = ['product_id' => '', 'quantity' => 1];
    }

    public function removeBundleProduct($index)
    {
        if (count($this->bundle_products) > 1) {
            unset($this->bundle_products[$index]);
            $this->bundle_products = array_values($this->bundle_products);
        }
    }

    // Buy X Get Y Multiple Rules Methods
    public function addBuyXGetYRule()
    {
        $this->buy_x_get_y_rules[] = [
            'buy_quantity' => 1,
            'get_quantity' => 1,
            'buy_product_id' => '',
            'get_product_id' => ''
        ];
    }

    public function removeBuyXGetYRule($index)
    {
        $this->validateBuyXGetYRulesStructure();

        if (count($this->buy_x_get_y_rules) > 1) {
            unset($this->buy_x_get_y_rules[$index]);
            $this->buy_x_get_y_rules = array_values($this->buy_x_get_y_rules);
        }
    }

    public function forceFixBuyXGetYRules()
    {
        $this->validateBuyXGetYRulesStructure();
        // Force re-render by updating a timestamp or similar
        $this->setupDefaultDates();
    }

    public function initializeBuyXGetYRules()
    {
        if (empty($this->buy_x_get_y_rules) || !is_array($this->buy_x_get_y_rules)) {
            $this->buy_x_get_y_rules = [];
            $this->addBuyXGetYRule();
        }

        // Ensure all rules have proper structure
        foreach ($this->buy_x_get_y_rules as $index => $rule) {
            if (!is_array($rule)) {
                $this->buy_x_get_y_rules[$index] = [
                    'buy_quantity' => 1,
                    'get_quantity' => 1,
                    'buy_product_id' => '',
                    'get_product_id' => ''
                ];
            }
        }
    }

    // Handle updates to buy_x_get_y_rules array
    public function updatedBuyXGetYRules($value, $key)
    {
        // First, ensure array structure is intact
        $this->validateBuyXGetYRulesStructure();

        // Parse the key to identify which rule and which field was updated
        $keys = explode('.', $key);

        if (count($keys) >= 2) {
            $index = intval($keys[0]);
            $field = $keys[1];

            // Ensure the rule exists and has proper structure
            if (!isset($this->buy_x_get_y_rules[$index]) || !is_array($this->buy_x_get_y_rules[$index])) {
                $this->buy_x_get_y_rules[$index] = [
                    'buy_quantity' => 1,
                    'get_quantity' => 1,
                    'buy_product_id' => '',
                    'get_product_id' => ''
                ];
            }

            // Update the specific field
            $this->buy_x_get_y_rules[$index][$field] = $value;

            // Validate specific fields
            if ($field === 'buy_quantity' || $field === 'get_quantity') {
                $this->buy_x_get_y_rules[$index][$field] = max(1, intval($value));
            } elseif ($field === 'buy_product_id' || $field === 'get_product_id') {
                // Handle product selection - convert empty string to null
                $this->buy_x_get_y_rules[$index][$field] = empty($value) ? '' : $value;
            }
        }
    }

    // Method to validate and fix array structure
    public function validateBuyXGetYRulesStructure()
    {
        if (!is_array($this->buy_x_get_y_rules)) {
            $this->buy_x_get_y_rules = [];
            return;
        }

        // Remove any non-array elements (like UUID strings)
        $this->buy_x_get_y_rules = array_filter($this->buy_x_get_y_rules, function ($item) {
            return is_array($item);
        });

        // Re-index array
        $this->buy_x_get_y_rules = array_values($this->buy_x_get_y_rules);

        // If empty after filtering, add one default rule
        if (empty($this->buy_x_get_y_rules)) {
            $this->addBuyXGetYRule();
        }
    }

    // Listener for when promotion type changes
    public function updatedType($value)
    {
        $this->search = '';

        if ($value === 'buy_x_get_y') {
            // Reset and reinitialize with proper structure
            $this->buy_x_get_y_rules = [];
            $this->initializeBuyXGetYRules();
        }

        // Reset other type-specific data when type changes
        if ($value !== 'buy_x_get_y') {
            $this->buy_x_get_y_rules = [];
        }
        if ($value !== 'discount_product') {
            $this->discount_products = [];
        }
        if ($value !== 'bundle') {
            $this->bundle_products = [['product_id' => '', 'quantity' => 1]];
        }
    }

    public function calculateFinalPrice($originalPrice)
    {
        if ($this->discount_type === 'percentage') {
            $discount = ($originalPrice * $this->discount_value) / 100;
            if ($this->max_discount && $discount > $this->max_discount) {
                $discount = $this->max_discount;
            }
        } else {
            $discount = $this->discount_value;
        }

        return max(0, $originalPrice - $discount);
    }

    public function cancel()
    {
        return redirect()->route('admin.promotion.index');
    }

    public function addDiscountProduct($productId = null)
    {
        if ($productId) {
            // Add specific product
            $product = null;
            foreach ($this->products as $p) {
                if ($p->id == $productId) {
                    $product = $p;
                    break;
                }
            }

            if ($product) {
                // Check if product already exists
                $exists = false;
                foreach ($this->discount_products as $existingProduct) {
                    if ($existingProduct['product_id'] == $productId) {
                        $exists = true;
                        break;
                    }
                }

                if (!$exists) {
                    $originalPrice = $this->getProductPrice($product->id);
                    $this->discount_products[] = [
                        'product_id' => $product->id,
                        'product_name' => $product->name,
                        'sku_number' => $product->sku_number ?? '',
                        'original_price' => $originalPrice,
                        'discount_type' => 'percentage',
                        'discount_value' => 10, // Default 10% discount
                        'final_price' => $this->calculateProductFinalPrice($product->id, 'percentage', 10)
                    ];
                }
            }
        }
    }

    public function removeDiscountProduct($index)
    {
        if (isset($this->discount_products[$index])) {
            unset($this->discount_products[$index]);
            // Re-index array to prevent gaps
            $this->discount_products = array_values($this->discount_products);
        }
    }

    public function addSelectedDiscountProducts()
    {
        if (!empty($this->selected_discount_products)) {
            foreach ($this->selected_discount_products as $productId) {
                // Check if product is not already in discount_products
                $exists = false;
                foreach ($this->discount_products as $existingProduct) {
                    if ($existingProduct['product_id'] == $productId) {
                        $exists = true;
                        break;
                    }
                }

                if (!$exists) {
                    // Get product details
                    $product = null;
                    foreach ($this->products as $p) {
                        if ($p->id == $productId) {
                            $product = $p;
                            break;
                        }
                    }

                    if ($product) {
                        $originalPrice = $this->getProductPrice($productId);

                        $this->discount_products[] = [
                            'product_id' => $productId,
                            'product_name' => $product->name,
                            'sku_number' => $product->sku_number ?? '',
                            'original_price' => $originalPrice,
                            'discount_type' => 'percentage',
                            'discount_value' => 10, // Default 10% discount
                            'final_price' => $this->calculateProductFinalPrice($productId, 'percentage', 10)
                        ];
                    }
                }
            }

            // Clear selected products after adding
            $this->selected_discount_products = [];
        }
    }

    public function applyBulkDiscount()
    {
        $type = $this->bulk_discount_type;
        $value = floatval($this->bulk_discount_value);

        foreach ($this->discount_products as $index => &$discountProduct) {
            $discountProduct['discount_type'] = $type;
            $discountProduct['discount_value'] = $value;
            $discountProduct['final_price'] = $this->calculateProductFinalPrice($discountProduct['product_id'], $type, $value);
        }
    }

    public function updatedDiscountProducts($value, $key)
    {
        // Parse the key to get index and field (e.g., "0.discount_value")
        $keys = explode('.', $key);
        if (count($keys) >= 2) {
            $index = $keys[0];
            $field = $keys[1];

            if (in_array($field, ['discount_type', 'discount_value']) && isset($this->discount_products[$index])) {
                $product = $this->discount_products[$index];
                $productId = $product['product_id'];
                $discountType = $product['discount_type'] ?? 'percentage';
                $discountValue = floatval($product['discount_value'] ?? 0);

                // Update final price
                $this->discount_products[$index]['final_price'] = $this->calculateProductFinalPrice(
                    $productId,
                    $discountType,
                    $discountValue
                );
            }
        }
    }

    protected function getProductPrice($productId)
    {
        try {
            // Try to get price from ProductPrice model first
            $productPrice = ProductPrice::where('product_id', $productId)->latest()->first();
            if ($productPrice && $productPrice->price > 0) {
                return $productPrice->price;
            }

            // Fallback to product model price if exists
            $product = null;
            foreach ($this->products as $p) {
                if ($p->id == $productId) {
                    $product = $p;
                    break;
                }
            }
            if ($product && isset($product->price)) {
                return $product->price;
            }

            // Default fallback price for demo
            return rand(10000, 100000);
        } catch (\Exception $e) {
            // Log error but don't break the flow
            return rand(10000, 100000); // Sample price for demo if error
        }
    }

    protected function calculateProductFinalPrice($productId, $discountType, $discountValue)
    {
        $originalPrice = $this->getProductPrice($productId);

        if ($discountType === 'percentage') {
            $discount = ($originalPrice * $discountValue) / 100;
        } else {
            $discount = $discountValue;
        }

        return max(0, $originalPrice - $discount);
    }

    // Method for blade template compatibility
    public function calculateFinalPriceFromArray($discountProduct, $originalPrice)
    {
        if (!isset($discountProduct['discount_type']) || !isset($discountProduct['discount_value'])) {
            return $originalPrice;
        }

        $discountType = $discountProduct['discount_type'];
        $discountValue = floatval($discountProduct['discount_value']);

        if ($discountType === 'percentage') {
            $discount = ($originalPrice * $discountValue) / 100;
        } else {
            $discount = $discountValue;
        }

        $finalPrice = $originalPrice - $discount;
        return max(0, $finalPrice); // Ensure price doesn't go below 0
    }

    public function resetForm()
    {
        $this->reset([
            'name',
            'code',
            'description',
            'type',
            'value',
            'minimum_purchase',
            'maximum_discount',
            'usage_limit',
            'usage_limit_per_user',
            'start_date',
            'end_date',
            'is_active',
            'applicable_companies',
            'applicable_products',
            'applicable_user_types',
            'applicable_users',
            'applicable_days',
            'terms_conditions',
            'selectedCompanies',
            'selectedProducts',
            'selectedUserTypes',
            'selectedUsers',
            'buy_x_get_y_rules',
            'discount_products',
            'discount_type',
            'discount_value',
            'max_discount'
        ]);

        $this->terms_conditions = [''];
        $this->buy_x_get_y_rules = [];
        $this->discount_products = [];
        $this->company_target_type = 'current';
        $this->current_company_only = true;
        $this->setupDefaultDates();
    }

    public function render()
    {
        // Fix array structure before rendering
        $this->validateBuyXGetYRulesStructure();

        $availableProducts = [];
        if (is_array($this->products)) {
            foreach ($this->products as $product) {
                if (isset($product->id) && isset($product->name)) {
                    $availableProducts[$product->id] = $product->name;
                }
            }
        }

        return view('livewire.admin.promotion.create.admin-promotion-create-index', [
            'promotionTypes' => [
                // 'percentage' => 'Persentase (%)',
                // 'fixed_amount' => 'Nominal Tetap (Rp)',
                // 'free_shipping' => 'Gratis Ongkir',
                'discount' => 'Diskon',
                'buy_x_get_y' => 'Beli X Dapat Y',
                'discount_product' => 'Diskon Produk Spesifik',
                // 'bundle' => 'Paket Bundle',
                // 'special' => 'Promo Khusus'
            ],
            'companyTargetTypes' => [
                'current' => 'Company Saat Ini',
                'all' => 'Semua Company',
                'specific' => 'Company Tertentu'
            ],
            'discountTypes' => [
                'percentage' => 'Persentase (%)',
                'fixed' => 'Nominal (Rp)',
                // 'special_price' => 'Harga Khusus'
            ],
            'specialTypes' => [
                'cashback' => 'Cashback',
                // 'free_shipping' => 'Gratis Ongkir',
                // 'loyalty_points' => 'Poin Loyalitas'
            ],
            'dayOptions' => [
                'monday' => 'Senin',
                'tuesday' => 'Selasa',
                'wednesday' => 'Rabu',
                'thursday' => 'Kamis',
                'friday' => 'Jumat',
                'saturday' => 'Sabtu',
                'sunday' => 'Minggu'
            ],
            'scheduleTypes' => [
                'always' => 'Selalu Aktif (24/7)',
                'days_only' => 'Hanya Hari Tertentu',
                'time_only' => 'Hanya Waktu Tertentu',
                'days_and_time' => 'Hari dan Waktu Spesifik'
            ],
            'availableProducts' => $availableProducts
        ])
            ->extends('layout.app')
            ->section('content');
    }
}
