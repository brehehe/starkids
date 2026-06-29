<?php

namespace App\Livewire\Admin\Master\Promotion\Create;

use App\Models\Company\Company;
use App\Models\Product\Product;
use App\Models\Promotion\PromotionSimplified;
use App\Models\User;
use App\Models\User\UserType;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Livewire\Component;
use Livewire\WithPagination;

class AdminPromotionCreateIndex extends Component
{
    use WithPagination;

    // Basic promotion fields
    public $promotion_id = null;

    public $name = '';

    public $description = '';

    public $code = '';

    public $type = 'percentage';

    public $value = 0;

    public $minimum_purchase = 0;

    public $maximum_discount = null;

    public $usage_limit = null;

    public $usage_limit_per_user = null;

    public $start_date = '';

    public $end_date = '';

    public $is_active = true;

    // JSON targeting fields
    public $applicable_products = [];

    public $applicable_user_types = [];

    public $applicable_users = [];

    public $applicable_companies = [];

    // Terms and conditions
    public $terms_conditions = [''];

    // Select options data
    public $products = [];

    public $userTypes = [];

    public $users = [];

    public $companies = [];

    public $selectedProducts = [];

    public $selectedUserTypes = [];

    public $selectedUsers = [];

    public $selectedCompanies = [];

    protected $rules = [
        'name' => 'required|string|max:255',
        'description' => 'nullable|string',
        'code' => 'required|string|max:50|unique:promotions_simplified,code',
        'type' => 'required|in:percentage,fixed_amount,free_shipping,buy_x_get_y',
        'value' => 'required|numeric|min:0',
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
        'code.unique' => 'Kode promosi sudah digunakan.',
        'type.required' => 'Tipe promosi harus dipilih.',
        'value.required' => 'Nilai promosi harus diisi.',
        'start_date.required' => 'Tanggal mulai harus diisi.',
        'end_date.required' => 'Tanggal berakhir harus diisi.',
        'end_date.after' => 'Tanggal berakhir harus setelah tanggal mulai.',
    ];

    public function mount($id = null)
    {
        if ($id) {
            $this->promotion_id = $id;
            $this->loadPromotion();
        }

        $this->loadSelectOptions();
        $this->loadUserTypes();

        // Set default dates
        if (! $this->start_date) {
            $this->start_date = now()->format('Y-m-d');
        }
        if (! $this->end_date) {
            $this->end_date = now()->addMonth()->format('Y-m-d');
        }
    }

    public function loadPromotion()
    {
        $promotion = PromotionSimplified::find($this->promotion_id);
        if ($promotion) {
            $this->name = $promotion->name;
            $this->description = $promotion->description ?? '';
            $this->code = $promotion->code;
            $this->type = $promotion->type;
            $this->value = $promotion->value;
            $this->minimum_purchase = $promotion->minimum_purchase ?? 0;
            $this->maximum_discount = $promotion->maximum_discount;
            $this->usage_limit = $promotion->usage_limit;
            $this->usage_limit_per_user = $promotion->usage_limit_per_user;
            $this->start_date = $promotion->start_date ? Carbon::parse($promotion->start_date)->format('Y-m-d') : '';
            $this->end_date = $promotion->end_date ? Carbon::parse($promotion->end_date)->format('Y-m-d') : '';
            $this->is_active = $promotion->is_active;

            // Load JSON fields
            $this->applicable_products = $promotion->applicable_products ?? [];
            $this->applicable_user_types = $promotion->applicable_user_types ?? [];
            $this->applicable_users = $promotion->applicable_users ?? [];
            $this->applicable_companies = $promotion->applicable_companies ?? [];
            $this->terms_conditions = $promotion->terms_conditions ?? [''];

            // Set selected values for display
            $this->selectedProducts = $this->applicable_products;
            $this->selectedUserTypes = $this->applicable_user_types;
            $this->selectedUsers = $this->applicable_users;
            $this->selectedCompanies = $this->applicable_companies;
        }
    }

    public function loadSelectOptions()
    {
        $companyId = Auth::user()->company_id ?? null;

        $this->products = Product::where('company_id', $companyId)
            ->select('id', 'name', 'code')
            ->get();

        $this->users = User::where('company_id', $companyId)
            ->select('id', 'name', 'email')
            ->get();

        $this->companies = Company::select('id', 'name')
            ->get();
    }

    public function loadUserTypes()
    {
        $this->userTypes = UserType::select('id', 'name', 'description')
            ->get();
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

    public function updatedSelectedCompanies()
    {
        $this->applicable_companies = $this->selectedCompanies;
    }

    public function save()
    {
        $this->validate();

        try {
            DB::beginTransaction();

            // Filter empty terms and conditions
            $filteredTerms = array_filter($this->terms_conditions, function ($term) {
                return ! empty(trim($term));
            });

            $data = [
                'company_id' => Auth::user()->company_id ?? null,
                'name' => $this->name,
                'description' => $this->description,
                'code' => $this->code,
                'type' => $this->type,
                'value' => $this->value,
                'minimum_purchase' => $this->minimum_purchase ?: null,
                'maximum_discount' => $this->maximum_discount ?: null,
                'usage_limit' => $this->usage_limit ?: null,
                'usage_limit_per_user' => $this->usage_limit_per_user ?: null,
                'start_date' => $this->start_date,
                'end_date' => $this->end_date,
                'is_active' => $this->is_active,
                'applicable_products' => ! empty($this->applicable_products) ? $this->applicable_products : null,
                'applicable_user_types' => ! empty($this->applicable_user_types) ? $this->applicable_user_types : null,
                'applicable_users' => ! empty($this->applicable_users) ? $this->applicable_users : null,
                'applicable_companies' => ! empty($this->applicable_companies) ? $this->applicable_companies : null,
                'terms_conditions' => ! empty($filteredTerms) ? array_values($filteredTerms) : null,
            ];

            if ($this->promotion_id) {
                // Update existing promotion
                $promotion = PromotionSimplified::find($this->promotion_id);
                $promotion->update($data);
                $message = 'Promosi berhasil diperbarui.';
            } else {
                // Create new promotion
                PromotionSimplified::create($data);
                $message = 'Promosi berhasil dibuat.';
            }

            DB::commit();

            session()->flash('message', $message);

            return redirect()->route('promotions.index');
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Error saving promotion: '.$e->getMessage());

            session()->flash('error', 'Terjadi kesalahan saat menyimpan promosi: '.$e->getMessage());
        }
    }

    public function resetForm()
    {
        $this->reset([
            'name',
            'description',
            'code',
            'type',
            'value',
            'minimum_purchase',
            'maximum_discount',
            'usage_limit',
            'usage_limit_per_user',
            'start_date',
            'end_date',
            'is_active',
            'applicable_products',
            'applicable_user_types',
            'applicable_users',
            'applicable_companies',
            'terms_conditions',
            'selectedProducts',
            'selectedUserTypes',
            'selectedUsers',
            'selectedCompanies',
        ]);

        $this->terms_conditions = [''];
        $this->start_date = now()->format('Y-m-d');
        $this->end_date = now()->addMonth()->format('Y-m-d');
    }

    public function render()
    {
        return view('livewire.admin.master.promotion.create.admin-promotion-create-index', [
            'promotion_types' => [
                'percentage' => 'Persentase (%)',
                'fixed_amount' => 'Nominal Tetap (Rp)',
                'free_shipping' => 'Gratis Ongkir',
                'buy_x_get_y' => 'Beli X Dapat Y',
            ],
        ]);
    }
}
