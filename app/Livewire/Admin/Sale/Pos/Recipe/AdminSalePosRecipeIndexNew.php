<?php

namespace App\Livewire\Admin\Sale\Pos\Recipe;

use App\Helpers\AlertHelper;
use App\Models\Branch\Branch;
use App\Models\Company\Company;
use App\Models\Deposit\Deposit;
use App\Models\Encounter\Encounter;
use App\Models\MedicineType\MedicineType;
use App\Models\Patient\Patient;
use App\Models\PaymentMethod\PaymentMethod;
use App\Models\Practitiont\Practitioner;
use App\Models\Product\Product;
use App\Models\Product\ProductPrice;
use App\Models\Product\ProductStock;
use App\Models\Promotion\PromotionSimplified;
use App\Models\Transaction\Transaction;
use App\Models\Transaction\TransactionAction;
use App\Models\Transaction\TransactionDetail;
use App\Models\Transaction\TransactionPayment;
use App\Models\Transaction\TransactionProduct;
use App\Models\Transaction\TransactionRecipe;
use App\Models\TransactionInstallment;
use App\Models\User;
use App\service\apiservice;
use App\Services\Product\ProductService;
use App\Services\Promotion\BuyXGetYService;
use App\Services\Promotion\PromotionSimplifiedService;
use App\Traits\Product\ProductTrait;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Str;
use Livewire\Component;
use Livewire\WithPagination;

class AdminSalePosRecipeIndexNew extends Component
{
    use ProductTrait, WithPagination;

    protected $queryString = [
        'pageProduct' => ['except' => 1], // Ini akan menghapus ?pageProduct=1 dari URL
        'searchProduct' => ['except' => ''],
    ];

    public $searchProduct = '';

    public $perPageProduct = 5;

    public $perPage = 5;

    public $transaction_id;

    public $transaction;

    public $search_sku;

    public $transaction_details = [];

    public $discount;

    public $discount_type;

    public $medicine_types = [];

    public $supporting_products = [];

    public $payment_method_id;

    public $payment_amount;

    public $is_single_payment;

    public $admin_fee;

    public $description;

    public $transaction_recipe_id;

    public $is_narcotic = false;

    public $user_asign_narcotic_id;

    public $product_id;

    public $product_name;

    public $barcode;

    public $username_or_email;

    public $password;

    public $is_outside_pharmacy = false;

    public $actions = [];

    public $medicines = [];

    public $is_pending_payment = false;

    public $installment_count;

    public $installment_period;

    public $is_down_payment = false;

    public $diagnosas;

    public $immunization;

    public $promotion_simplified_id;

    public $has_deposit = false;

    public $deposit_discount_amount = 0;

    private $validStatuses = [
        'draft_consultation',
        'call_consultation',
        'confirmation_call',
        'consultation',
        'pharmacy',
        'call_pharmacy',
        'sale_pharmacy',
        'draft',
        'process',
        'take_medicine',
    ];

    public $is_insurance_claim = false;

    public $is_insurance = false;

    public $insurance_number = '';

    public $is_editable_price_pos = false;

    public function mount()
    {
        if (session()->has('saved')) {
            AlertHelper::success(session('saved.title'), session('saved.text'));
            session()->forget('saved');
        }
        $transaction_id = Session::get('transaction_id');

        if ($transaction_id) {
            $transaction = Transaction::find($transaction_id);

            if ($transaction) {
                if ($transaction->type == 'non-resep') {
                    return redirect()->route('user.sale.pos.detail');
                }

                $this->transaction = $transaction;
                $this->is_insurance = $transaction->is_insurance ?? false;
                $this->is_pending_payment = $transaction->is_pending_payment ?? false;
                $this->installment_count = $transaction->installment_count ?? null;
                $this->installment_period = $transaction->installment_period ?? null;
                $this->transaction_id = $transaction_id;
                $this->discount_type = $transaction->discount_type ?? 'rupiah';
                $this->discount = $this->discount_type == 'percentage' ? $transaction->discount : number_format($transaction->discount, 0, ',', '.');
                $this->diagnosas = $transaction->diagnosas ?? '';
                $this->immunization = $transaction->immunization ?? '';
                $this->is_insurance_claim = $transaction->is_insurance_claim ?? false;
                $this->is_insurance = $transaction->is_insurance ?? false;
                $this->insurance_number = $transaction->insurance_number ?? '';
                $this->is_editable_price_pos = Auth::user()->company->is_editable_price_pos ?? false;

                $this->medicine_types = MedicineType::where('company_id', Auth::user()->company_id)
                    ->select('id', 'name')
                    ->orderBy('name', 'asc')
                    ->get()
                    ->toArray();
                $this->supporting_products = Product::where('company_id', Auth::user()->company_id)
                    ->whereHas('productType', function ($query) {
                        $query->where('name', 'Produk Pendukung'); // atau 'Supporting Product' sesuai isi database
                    })
                    ->whereHas('productPrice', function ($query) {
                        $query->where('price', '>', 0)
                            ->where('branch_id', Branch::where('company_id', Auth::user()->company_id)->first()->id);
                    })
                    // ->whereHas('productStock', function ($query) {
                    //     $query->where('branch_id', Branch::where('company_id', Auth::user()->company_id)->first()->id); // atau 'Supporting Product' sesuai isi database
                    // })
                    ->select('id', 'name')
                    ->with('productPrice:id,product_id,price,recipe', 'productStock:id,product_id,quantity')
                    ->orderBy('name', 'asc')
                    ->get()
                    ->toArray();

                $this->is_outside_pharmacy = $transaction->is_outside_pharmacy ?? false;

                // Check if transaction has deposit and set up discount
                $this->checkDepositDiscount();

                $this->details();
                $this->getActions();
                $this->getMedicines();
                $this->updateTotal();
            } else {
                return redirect()->route('user.sale.pos');
            }
        } else {
            return redirect()->route('user.sale.pos');
        }
    }

    /**
     * Check if transaction has deposit and setup automatic discount
     */
    public function checkDepositDiscount()
    {
        if ($this->transaction && $this->transaction->deposit_id) {
            $deposit = $this->transaction->deposit;
            if ($deposit && $this->transaction->grand_total_price > 0) {
                $this->has_deposit = true;
                $this->deposit_discount_amount = $this->transaction->grand_total_price;

                // Set discount as rupiah amount equal to deposit total
                $this->discount_type = 'rupiah';
                $this->discount = number_format($this->deposit_discount_amount, 0, ',', '.');

                // Disable promotion selection since deposit takes priority
                $this->promotion_simplified_id = null;

                Log::info('Deposit discount applied', [
                    'transaction_id' => $this->transaction_id,
                    'deposit_id' => $this->transaction->deposit_id,
                    'deposit_amount' => $this->deposit_discount_amount,
                ]);
            }
        }
    }

    public function updatedDiscountType()
    {
        // Prevent changing discount type when deposit is present
        if ($this->has_deposit) {
            $this->discount_type = 'rupiah';

            return;
        }

        $this->discount = '';
        $this->updateTotal();
    }

    public function updatedDiscount()
    {
        // Prevent manual discount changes when deposit is present
        if ($this->has_deposit) {
            $this->discount = number_format($this->deposit_discount_amount, 0, ',', '.');

            return;
        }

        if ($this->discount === '') {
            $this->updateTotal();

            return;
        }

        if ($this->discount_type == 'percentage') {
            $discount = Str::replace(',', '.', strval($this->discount));
            $this->discount = $discount <= 0 ? 0 : ($discount > 100 ? 100 : $discount);
        } else {
            $this->discount = intval(str_replace('.', '', strval($this->discount)));
        }

        $this->updateTotal();
    }

    public function updatedSearchSku()
    {
        $this->search_sku = ltrim($this->search_sku);

        $this->choiceProductChange();
    }

    public function getActions()
    {
        $this->reset(['actions']);

        $actions = TransactionDetail::where('transaction_id', $this->transaction_id)
            ->whereIn('type_transaction', ['action', 'other'])
            ->with('product:id,sku_number,name,description,company_id')
            ->orderBy('order', 'asc')
            ->get();

        foreach ($actions as $action) {
            $this->actions[] = [
                'id' => $action->id,
                'product_id' => $action->product_id,
                'product_name' => $action->product?->name ?? $action->name,
                'description' => $action->description,
                'quantity' => $action->quantity,
                'price' => intval($action->price),
                'discount' => intval($action->discount ?? 0),
                'discount_input' => intval($action->discount ?? 0),
                'discount_type' => $action->discount_type,
                'sub_total_price' => $action->sub_total_price,
            ];
        }
    }

    public function getMedicines()
    {
        $this->medicines = [];

        $this->applyBuyXGetYPromotions();

        $transactionDetails = TransactionDetail::where('transaction_id', $this->transaction_id)
            ->with(['product', 'parentDetail'])
            ->whereIn('type_transaction', ['medicine'])
            ->orderBy('order', 'asc')
            ->get();

        // Group items by parent-child relationship
        $parentItems = $transactionDetails->where('transaction_detail_id', null);
        $childItems = $transactionDetails->where('transaction_detail_id', '!=', null);

        foreach ($parentItems as $key => $parentDetail) {
            // Add parent item
            $this->medicines[] = [
                'id' => $parentDetail->id,
                'product_id' => $parentDetail->product_id,
                'product_name' => $parentDetail->product->name,
                'quantity' => $parentDetail->quantity,
                'price' => intval($parentDetail->price),
                'discount' => intval($parentDetail->discount ?? 0),
                'discount_input' => intval($parentDetail->discount ?? 0),
                'discount_type' => 'nominal',
                'price_discount' => $parentDetail->price_discount ?? 0,
                'sub_total_price' => $parentDetail->sub_total_price,
                'is_parent' => true,
                'is_free_item' => false,
                'parent_id' => null,
                'promotion_text' => null,
            ];

            // Add child items (free items) for this parent
            $children = $childItems->where('transaction_detail_id', $parentDetail->id);
            foreach ($children as $childDetail) {
                $this->medicines[] = [
                    'id' => $childDetail->id,
                    'product_id' => $childDetail->product_id,
                    'product_name' => $childDetail->product->name,
                    'quantity' => $childDetail->quantity,
                    'price' => intval($childDetail->price),
                    'discount' => intval($childDetail->discount ?? 0),
                    'discount_input' => intval($childDetail->discount ?? 0),
                    'discount_type' => $childDetail->discount_type,
                    'price_discount' => $childDetail->price_discount ?? 0,
                    'sub_total_price' => $childDetail->sub_total_price,
                    'is_parent' => false,
                    'is_free_item' => true,
                    'parent_id' => $parentDetail->id,
                    'promotion_text' => $this->extractPromotionFromName($childDetail->name),
                ];
            }
        }
    }

    private function extractPromotionFromName($itemName)
    {
        // Extract promotion name from patterns like "PRODUCT NAME (GRATIS - Promotion Name)"
        if (preg_match('/\(GRATIS - (.+)\)/', $itemName, $matches)) {
            return $matches[1];
        }

        return 'Promosi Buy X Get Y';
    }

    public function choiceProductChange()
    {
        // Get authenticated user's company and branch once
        $companyId = auth()->user()->company_id;
        $branchId = Branch::where('company_id', $companyId)->value('id');

        // Find product with related data in one query
        $getProduct = Product::with(['productStock', 'productPrice']);

        if ($this->search_sku) {
            // Check if search_sku contains a space (format: "SKU NAME")
            if (strpos($this->search_sku, ' ') !== false) {
                // Split by space if it exists
                $parts = explode(' ', $this->search_sku, 2); // Limit to 2 parts
                $sku = $parts[0];
                $name = $parts[1] ?? '';

                // Search by both SKU and name for more precise matching
                $getProduct->where('sku_number', $sku)->where('name', $name);
            } else {
                // If no space, search only by SKU (backward compatibility)
                $getProduct->where('sku_number', $this->search_sku);
            }
        }

        if ($this->product_id) {
            $getProduct->where('id', $this->product_id);
        }

        $product = $getProduct->first();

        if (! $product) {
            $this->reset('search_sku');

            return AlertHelper::error('Gagal', 'Produk tidak ditemukan.');
        }

        if (! $product->is_non_stock) {
            // Check stock
            $productStock = $product->productStock()
                ->where('company_id', $companyId)
                ->where('branch_id', $branchId)
                ->first();

            // if (!$productStock || $productStock->quantity <= 0) {
            //     return AlertHelper::error('Gagal', 'Stok produk tidak ditemukan atau stok kosong.');
            // }
        }

        // Check price
        $productPrice = $product->productPrice()
            ->where('company_id', $companyId)
            ->where('branch_id', $branchId)
            // ->where('is_updated', true)
            ->first();

        if (! $productPrice) {
            return AlertHelper::error('Gagal', 'Harga produk tidak ditemukan.');
        }

        if ($productPrice?->price == 0) {
            return AlertHelper::error('Gagal', 'Harga produk tidak boleh 0.');
        }

        if ($product->is_narcotic) {
            if (! $this->user_asign_narcotic_id) {
                $this->is_narcotic = true;
                $this->product_id = $product->id;
                $this->product_name = $product->name;

                $this->dispatch('close-modal', ['id' => 'modalProduct']);

                return $this->dispatch('open-modal', ['id' => 'modalNarcotic']);
            }
        }

        // Get or create transaction recipe
        $transactionRecipe = $this->transaction_recipe_id
            ? TransactionRecipe::find($this->transaction_recipe_id)
            : TransactionRecipe::create([
                'transaction_id' => $this->transaction_id,
                'company_id' => $companyId,
                'branch_id' => $branchId,
            ]);

        // Create transaction detail
        TransactionDetail::create([
            'transaction_recipe_id' => $transactionRecipe->id,
            'transaction_id' => $this->transaction_id,
            'product_id' => $product->id,
            'quantity' => 1,
            'price' => $productPrice->price,
            'sub_total_price' => $productPrice->price,
            'dosage_drug' => $product->medicine_dosage ?? 0,
            'type_transaction' => 'recipe',
        ]);

        // Clean up and return success
        $this->details();
        $this->updateTotal();
        $this->reset('search_sku', 'product_id');
        $this->closeModal();

        return AlertHelper::success('Berhasil', 'Produk berhasil ditambahkan ke keranjang.');
    }

    public function closeModalNarcotic()
    {
        $this->reset('is_narcotic', 'user_asign_narcotic_id', 'product_id', 'product_name', 'search_sku', 'username_or_email', 'password');
        $this->dispatch('close-modal', ['id' => 'modalNarcotic']);
        if ($this->barcode) {
            $this->openModal();
            $this->reset('barcode');
        }
    }

    public function submitNarcotic()
    {
        $this->validate([
            'username_or_email' => 'required',
            'password' => 'required',
        ]);

        $company = Company::find(Auth::user()->company_id);

        if (! $company) {
            return AlertHelper::error('Error', 'Perusahaan tidak ditemukan.');
        }

        // Find user with smart identity resolution
        $userResult = $this->findHeadUserWithIdentityResolution($company->id);

        if (! $userResult['success']) {
            return AlertHelper::error('Akses Ditolak', $userResult['message']);
        }

        $user = $userResult['user'];
        $loginMethod = $userResult['login_method'];

        // Check password
        if (! Hash::check($this->password, $user->password)) {
            return AlertHelper::error('Akses Ditolak', 'Password salah. Silakan periksa kembali atau hubungi administrator perusahaan.');
        }

        // Check if user is head in this company
        $isHead = $user->companyRoles()
            ->where('company_id', $company->id)
            ->where('is_head', true)
            ->where('is_active', true)
            ->exists();

        if (! $isHead) {
            return AlertHelper::error('Akses Ditolak', 'Anda bukan supervisor di perusahaan ini.');
        }

        // Success - user is authenticated and is head
        $this->user_asign_narcotic_id = $user->id;
        $this->choiceProductChange();

        $this->reset('barcode');

        $this->closeModalNarcotic();

        // Log head verification activity
        $this->logHeadVerificationActivity($user, $company, $loginMethod);
    }

    /**
     * Find user with smart identity resolution and head validation
     */
    protected function findHeadUserWithIdentityResolution($companyId)
    {
        $identifier = $this->username_or_email;

        // Strategy 1: Find by main fields (email, username, phone) - Employee only
        $mainUser = $this->findHeadByMainFields($identifier, $companyId);
        if ($mainUser) {
            return [
                'success' => true,
                'user' => $mainUser['user'],
                'login_method' => $mainUser['method'],
                'message' => 'Found via main fields',
            ];
        }

        // Strategy 2: Find by alternative contacts - Employee only
        $altUser = $this->findHeadByAlternativeContacts($identifier, $companyId);
        if ($altUser) {
            return [
                'success' => true,
                'user' => $altUser['user'],
                'login_method' => $altUser['method'],
                'message' => 'Found via alternative contacts',
            ];
        }

        // Strategy 3: Handle email sama tapi beda phone case - Employee only
        $conflictUser = $this->handleHeadEmailPhoneConflict($identifier, $companyId);
        if ($conflictUser) {
            return [
                'success' => true,
                'user' => $conflictUser['user'],
                'login_method' => $conflictUser['method'],
                'message' => 'Resolved identity conflict',
            ];
        }

        return [
            'success' => false,
            'user' => null,
            'login_method' => null,
            'message' => 'Username atau email tidak ditemukan, atau Anda bukan supervisor di perusahaan ini.',
        ];
    }

    /**
     * Find user by main fields (email, username, phone) - Employee only with head check
     */
    protected function findHeadByMainFields($identifier, $companyId)
    {
        // Cari user berdasarkan email, username, atau phone (hanya employee)
        $users = User::where('type_user', 'employee')
            ->where(function ($query) use ($identifier) {
                $query->where('username', $identifier)
                    ->orWhere('email', $identifier)
                    ->orWhere('phone', $identifier);
            })->get();

        // Filter users yang punya akses ke company ini dan is_head
        foreach ($users as $user) {
            if ($user->companyRoles()
                ->where('company_id', $companyId)
                ->where('is_active', true)
                ->where('is_head', true)
                ->exists()
            ) {

                // Determine which field matched
                $method = $this->determineMatchedField($user, $identifier);

                return [
                    'user' => $user,
                    'method' => $method,
                ];
            }
        }

        return null;
    }

    /**
     * Find user by alternative contacts - Employee only with head check
     */
    protected function findHeadByAlternativeContacts($identifier, $companyId)
    {
        // Cari di alternative contacts dengan context company ini (hanya employee)
        $users = User::where('type_user', 'employee')
            ->whereJsonContains('alternative_contacts', function ($contact) use ($identifier, $companyId) {
                return $contact['value'] === $identifier && $contact['context'] == $companyId;
            })->get();

        foreach ($users as $user) {
            if ($user->companyRoles()
                ->where('company_id', $companyId)
                ->where('is_active', true)
                ->where('is_head', true)
                ->exists()
            ) {

                // Get contact type from alternative contacts
                $contacts = $user->alternative_contacts ?? [];
                $contactType = null;

                foreach ($contacts as $contact) {
                    if ($contact['value'] === $identifier && $contact['context'] == $companyId) {
                        $contactType = $contact['type'];
                        break;
                    }
                }

                return [
                    'user' => $user,
                    'method' => 'alternative_'.$contactType,
                ];
            }
        }

        return null;
    }

    /**
     * Handle case email sama tapi phone beda - Employee only with head check
     */
    protected function handleHeadEmailPhoneConflict($identifier, $companyId)
    {
        // Check if identifier is email
        if (! filter_var($identifier, FILTER_VALIDATE_EMAIL)) {
            return null;
        }

        // Find users with same email but may not have access to this company (hanya employee)
        $usersWithSameEmail = User::where('type_user', 'employee')
            ->where('email', $identifier)
            ->get();

        foreach ($usersWithSameEmail as $user) {
            // Check if user has head role in this company
            if ($user->companyRoles()
                ->where('company_id', $companyId)
                ->where('is_active', true)
                ->where('is_head', true)
                ->exists()
            ) {

                return [
                    'user' => $user,
                    'method' => 'email',
                ];
            }
        }

        return null;
    }

    /**
     * Log head verification activity
     */
    protected function logHeadVerificationActivity($user, $company, $loginMethod)
    {
        \Log::info('Head verification for narcotic', [
            'user_id' => $user->id,
            'user_type' => $user->type_user,
            'company_id' => $company->id,
            'verification_method' => $loginMethod,
            'identifier_used' => $this->username_or_email,
            'ip_address' => request()->ip(),
            'user_agent' => request()->userAgent(),
            'timestamp' => now(),
        ]);
    }

    public function details()
    {
        $this->transaction_details = [];

        $transactionDetails = $this->is_outside_pharmacy ? [] : TransactionRecipe::where('transaction_id', $this->transaction_id)
            ->orderBy('order', 'asc')
            ->get();

        foreach ($transactionDetails as $key => $transactionDetail) {
            $medicine_type = MedicineType::find($transactionDetail->medicine_type_id);
            $this->transaction_details[] = [
                'id' => $transactionDetail->id,
                'medicine_type_id' => $transactionDetail->medicine_type_id,
                'medicine_type_name' => $medicine_type ? $medicine_type->name : null,
                'is_single' => $medicine_type ? $medicine_type->is_single : false,
                'numero_recipe' => $transactionDetail->numero_recipe,
                'price_service_one' => number_format($transactionDetail->price_service_one ?? 0, 0, ',', '.'),
                'price_service_other' => number_format($transactionDetail->price_service_other ?? 0, 0, ',', '.'),
                'product_id' => $transactionDetail->product_id,
                'product_name' => $transactionDetail->product->name ?? '',
                'quantity' => $transactionDetail->quantity,
                'price' => number_format($transactionDetail->price, 0, ',', '.'),
                'sub_total_price' => number_format($transactionDetail->sub_total_price, 0, ',', '.'),
                'description' => $transactionDetail->description,
                'notes' => $transactionDetail->notes,
            ];

            foreach ($transactionDetail->transactionDetail as $detail) {
                // Gunakan quantity_real sebagai tampilan karena quantity mungkin sudah terlanjur
                // di-clamp ke 0 oleh stock check sebelumnya. quantity_real = permintaan asli dokter.
                $displayQty = ($detail->quantity > 0)
                    ? $detail->quantity
                    : intval($detail->quantity_real);
                $this->transaction_details[$key]['details'][] = [
                    'id' => $detail->id,
                    'product_id' => $detail->product_id,
                    'product_name' => $detail->product->name,
                    'quantity_real' => $detail->quantity_real,
                    'quantity' => $displayQty,
                    'price' => intval($detail->price),
                    'discount_value' => floatval($detail->discount_value ?? 0),
                    'discount' => floatval($detail->discount ?? 0),
                    'discount_input' => floatval($detail->discount ?? 0),
                    'discount_type' => $detail->discount_type ?? 'nominal',
                    'sub_total_price' => $detail->sub_total_price,
                ];
            }
        }

        // Jangan panggil updateTransactionRecipe() di sini — itu akan menimpa
        // data historis (quantity, harga) dengan nilai sistem terkini setiap kali halaman dibuka.
        // updateTransactionRecipe() hanya dipanggil saat user melakukan perubahan eksplisit.
    }

    /**
     * Triggered by wire:blur on child detail inputs, AFTER wire:model.blur has already
     * synced the new value into $this->transaction_details state. Reading from state here
     * is safe because wire:model.blur and wire:blur merge into a single Livewire request.
     */
    public function changedDetailField(int|string $parentKey, int|string $childIndex, string $field, $value = null): void
    {
        // If value was not passed directly, read from already-synced state
        $resolvedValue = $value ?? ($this->transaction_details[$parentKey]['details'][$childIndex][$field] ?? null);
        $this->updatedTransactionDetails($resolvedValue, "{$parentKey}.details.{$childIndex}.{$field}");
    }

    public function updatedTransactionDetails($value = null, $key = null)
    {

        if ($key) {
            // $key pattern: "{key}.details.{index}.price", "{key}.details.{index}.discount_input", "{key}.details.{index}.discount_type"
            $parts = explode('.', $key);
            if (count($parts) == 4 && $parts[1] === 'details') {
                $parentIndex = $parts[0];
                $childIndex = $parts[2];
                $field = $parts[3];

                if (isset($this->transaction_details[$parentIndex]['details'][$childIndex])) {
                    $detail = $this->transaction_details[$parentIndex]['details'][$childIndex];
                    $transactionDetailId = $detail['id'];

                    $transactionDetail = TransactionDetail::find($transactionDetailId);
                    if ($transactionDetail) {
                        if ($field === 'quantity' || $field === 'quantity_real') {
                            if ($field === 'quantity') {
                                $newQty = max(1, intval(preg_replace('/[^0-9]/', '', strval($value))));
                                $transactionDetail->quantity = $newQty;
                            } else {
                                $transactionDetail->quantity_real = floatval(preg_replace('/[^0-9.]/', '', strval($value)));
                            }
                            $currentPrice = intval($transactionDetail->price);
                            $currentQty = intval($transactionDetail->quantity);
                            // Recalculate discount value based on updated quantity
                            if (($transactionDetail->discount_type ?? 'nominal') === 'percentage') {
                                $percentage = floatval($transactionDetail->discount ?? 0);
                                $transactionDetail->discount_value = round((($currentPrice * $currentQty) * $percentage) / 100);
                            } else {
                                $transactionDetail->discount_value = floatval($transactionDetail->discount ?? 0);
                                $maxDiscountAllowed = $currentPrice * $currentQty;
                                if ($transactionDetail->discount_value > $maxDiscountAllowed) {
                                    $transactionDetail->discount_value = $maxDiscountAllowed;
                                }
                            }
                            $currentDiscountValue = floatval($transactionDetail->discount_value ?? 0);
                            $transactionDetail->sub_total_price = max(0, ($currentPrice * $currentQty) - $currentDiscountValue);
                            $transactionDetail->save();
                            $this->details();
                            $this->updateTotal();

                            return;
                        } elseif ($field === 'price') {
                            $transactionDetail->price = intval(preg_replace('/[^0-9]/', '', strval($value)));
                            if ($detail['discount_type'] === 'percentage') {
                                $percentage = floatval(preg_replace('/,/', '.', strval($detail['discount_input'])));
                                $percentage = $percentage > 100 ? 100 : ($percentage < 0 ? 0 : $percentage);
                                $transactionDetail->discount = $percentage;
                                $transactionDetail->discount_value = round((($transactionDetail->price * $transactionDetail->quantity) * $percentage) / 100);
                            } else {
                                $transactionDetail->discount = intval(preg_replace('/[^0-9]/', '', strval($detail['discount_input'] ?? 0)));
                                $transactionDetail->discount_value = $transactionDetail->discount;
                                $maxDiscountAllowed = $transactionDetail->price * $transactionDetail->quantity;
                                if ($transactionDetail->discount_value > $maxDiscountAllowed) {
                                    $transactionDetail->discount_value = $maxDiscountAllowed;
                                    $transactionDetail->discount = $maxDiscountAllowed;
                                }
                            }
                        } elseif ($field === 'discount_input' || $field === 'discount_type') {
                            $inputType = $field === 'discount_type' ? $value : $detail['discount_type'];
                            $inputValue = $field === 'discount_input' ? $value : $detail['discount_input'];

                            if ($field === 'discount_type') {
                                $inputValue = '';
                            }

                            $transactionDetail->discount_type = $inputType;
                            if ($inputType === 'percentage') {
                                $percentage = floatval(preg_replace('/,/', '.', strval($inputValue)));
                                $percentage = $percentage > 100 ? 100 : ($percentage < 0 ? 0 : $percentage);
                                $transactionDetail->discount = $percentage;
                                $transactionDetail->discount_value = round((($transactionDetail->price * $transactionDetail->quantity) * $percentage) / 100);
                            } else {
                                $transactionDetail->discount = intval(preg_replace('/[^0-9]/', '', strval($inputValue ?? 0)));
                                $transactionDetail->discount_value = $transactionDetail->discount;
                                $maxDiscountAllowed = $transactionDetail->price * $transactionDetail->quantity;
                                if ($transactionDetail->discount_value > $maxDiscountAllowed) {
                                    $transactionDetail->discount_value = $maxDiscountAllowed;
                                    $transactionDetail->discount = $maxDiscountAllowed;
                                }
                            }
                        }

                        $currentPrice = intval($transactionDetail->price);
                        $currentDiscountValue = floatval($transactionDetail->discount_value ?? 0);

                        $transactionDetail->sub_total_price = ($currentPrice * $transactionDetail->quantity) - $currentDiscountValue;
                        $transactionDetail->save();

                        $this->details(); // re-runs details loader

                        $inputType = $detail['discount_type'];
                        if ($field === 'discount_type') {
                            $inputType = $value;
                        }

                        if ($field === 'discount_type' || ($field === 'discount_input' && strval($value) === '')) {
                            $this->transaction_details[$parentIndex]['details'][$childIndex]['discount_input'] = '';
                        } else {
                            if ($inputType === 'percentage') {
                                $this->transaction_details[$parentIndex]['details'][$childIndex]['discount_input'] = floatval($transactionDetail->discount);
                            } else {
                                $this->transaction_details[$parentIndex]['details'][$childIndex]['discount_input'] = intval($transactionDetail->discount);
                            }
                        }
                        $this->transaction_details[$parentIndex]['details'][$childIndex]['discount_type'] = $inputType;

                        $this->updateTotal();

                        return; // Stop blanket update
                    }
                }
            }
        }

        $companyId = auth()->user()->company_id;
        $branchId = Branch::where('company_id', $companyId)->first()?->id;

        foreach ($this->transaction_details as $key => $value) {
            $transactionRecipe = TransactionRecipe::find($value['id']);

            if (! $transactionRecipe) {
                AlertHelper::error('Gagal', 'Resep tidak ditemukan.');

                continue;
            }

            // Check if product_id is changing (before we save)
            $newProductId = ! empty($value['product_id']) ? $value['product_id'] : null;
            $productIdChanged = $transactionRecipe->product_id != $newProductId;

            // If product changed, fetch new price
            $price = intval(preg_replace('/[^0-9]/', '', strval($value['price'])));
            if ($productIdChanged && $newProductId) {
                $product = Product::find($newProductId);
                if ($product) {
                    $productPrice = ProductPrice::where([
                        'product_id' => $product->id,
                        'company_id' => $companyId,
                        'branch_id' => $branchId,
                        'is_updated' => true,
                    ])->first();
                    $price = $productPrice?->price ?? $price;
                }
            }

            // Validasi dan assign field
            $transactionRecipe->medicine_type_id = $value['medicine_type_id'] ?? null;
            $transactionRecipe->price_service_one = $value['price_service_one'] ? Str::replace('.', '', $value['price_service_one']) : 0;
            $transactionRecipe->price_service_other = $value['price_service_other'] ? Str::replace('.', '', $value['price_service_other']) : 0;
            $transactionRecipe->product_id = $newProductId;
            $transactionRecipe->numero_recipe = intval(preg_replace('/[^0-9]/', '', strval($value['numero_recipe'])));
            $transactionRecipe->quantity = intval(preg_replace('/[^0-9]/', '', strval($value['quantity'])));
            $transactionRecipe->price = $price;
            $transactionRecipe->sub_total_price = intval(preg_replace('/[^0-9]/', '', strval($value['sub_total_price'])));
            $transactionRecipe->description = $value['description'] ?? null;
            $transactionRecipe->notes = $value['notes'] ?? null;
            $transactionRecipe->save(); // Observer akan handle

            if (! empty($value['details'])) {
                foreach ($value['details'] as $detail) {
                    $transactionDetail = TransactionDetail::find($detail['id']);

                    if (! $transactionDetail || empty($detail['product_id'])) {
                        continue;
                    }

                    // Check if detail product_id is changing
                    $newDetailProductId = $detail['product_id'];
                    $detailProductIdChanged = $transactionDetail->product_id != $newDetailProductId;

                    // If product changed, fetch new price
                    $detailPrice = $this->parseFloatValue($detail['price']);
                    if ($detailProductIdChanged) {
                        $productRecipe = Product::find($newDetailProductId);
                        if ($productRecipe) {
                            $productPriceRecipe = ProductPrice::where([
                                'product_id' => $productRecipe->id,
                                'company_id' => $companyId,
                                'branch_id' => $branchId,
                                'is_updated' => true,
                            ])->first();
                            $detailPrice = $productPriceRecipe?->price ?? $detailPrice;
                        }
                    }

                    $transactionDetail->product_id = $newDetailProductId;
                    $transactionDetail->quantity_real = $this->parseFloatValue($detail['quantity_real'] ?? 0);
                    $transactionDetail->quantity = $this->parseIntValue($detail['quantity']);
                    $transactionDetail->discount = $this->parseFloatValue($detail['discount'] ?? 0);
                    $transactionDetail->discount_type = $detail['discount_type'] ?? 'nominal';

                    if ($transactionDetail->discount_type === 'percentage') {
                        $transactionDetail->discount_value = round((($detailPrice * $transactionDetail->quantity) * $transactionDetail->discount) / 100);
                    } else {
                        $transactionDetail->discount_value = $transactionDetail->discount;
                        $maxDiscountAllowed = $detailPrice * $transactionDetail->quantity;
                        if ($transactionDetail->discount_value > $maxDiscountAllowed) {
                            $transactionDetail->discount_value = $maxDiscountAllowed;
                            $transactionDetail->discount = $maxDiscountAllowed;
                        }
                    }

                    $transactionDetail->price = $detailPrice;
                    $transactionDetail->sub_total_price = ($transactionDetail->price * $transactionDetail->quantity) - floatval($transactionDetail->discount_value);
                    if ($transactionDetail->sub_total_price < 0) {
                        $transactionDetail->sub_total_price = 0;
                    }
                    $transactionDetail->save(); // Observer akan validasi stok
                }
            }
        }

        $this->updateTransactionRecipe();
        $this->details();
        $this->updateTotal();
        $this->closeModal();
    }

    public function updateTransactionRecipe()
    {

        try {
            DB::beginTransaction();

            $companyId = auth()->user()->company_id;
            $branchId = Branch::where('company_id', $companyId)->first()?->id;

            $transactionRecipes = TransactionRecipe::where('transaction_id', $this->transaction_id)
                ->orderBy('order', 'asc')
                ->get();

            foreach ($transactionRecipes as $key => $transactionRecipe) {
                $medicineType = MedicineType::find($transactionRecipe->medicine_type_id);
                $numeroRecipe = intval(preg_replace('/[^0-9]/', '', strval($transactionRecipe->numero_recipe ?? 0)));

                if (! $medicineType) {
                    AlertHelper::error('Gagal', 'Tipe Resep pada /R'.($key + 1).' tidak ditemukan.');

                    continue;
                }

                $product = $transactionRecipe->product_id ? Product::find($transactionRecipe->product_id) : null;
                $productStock = $product ? ProductStock::where([
                    'product_id' => $product->id,
                    'company_id' => $companyId,
                    'branch_id' => $branchId,
                ])->first() : null;

                // Always use current product price from ProductPrice when product is set.
                // Fall back to the stored recipe price only if ProductPrice is not found.
                $price = 0;
                if ($product) {
                    $productPrice = ProductPrice::where([
                        'product_id' => $product->id,
                        'company_id' => $companyId,
                        'branch_id' => $branchId,
                        'is_updated' => true,
                    ])->first();
                    $price = $productPrice?->price ?? $transactionRecipe->price;
                } elseif ($transactionRecipe->price > 0) {
                    $price = $transactionRecipe->price;
                }

                $quantity = 0;

                if ($numeroRecipe > 0) {
                    if ($medicineType->is_single) {
                        $transactionRecipe->product_id = null;
                    } else {
                        if ($product && $product->is_non_stock) {
                            $quantity = $numeroRecipe;
                        } elseif (! $product || ! $productStock) {
                            $quantity = $numeroRecipe;
                        } else {
                            $quantity = $numeroRecipe;
                        }
                    }

                    $transactionRecipe->fill([
                        'medicine_type_id' => $transactionRecipe->medicine_type_id,
                        'price_service_one' => $medicineType->service_price ?? 0,
                        'price_service_other' => $medicineType->price_other ?? 0,
                        'numero_recipe' => $numeroRecipe,
                        'quantity' => $quantity,
                        'price' => $price,
                        'sub_total_price' => $price * $quantity,
                        'description' => $transactionRecipe->description ?? null,
                    ])->save();

                    // === UPDATE RECIPE DETAILS ===
                    foreach ($transactionRecipe->transactionDetail as $detail) {
                        $productRecipe = Product::find($detail->product_id);

                        if (! $productRecipe) {
                            AlertHelper::error('Gagal', "Produk dengan ID {$detail->product_id} tidak ditemukan.");

                            continue;
                        }

                        $productStockRecipe = ProductStock::where([
                            'product_id' => $productRecipe->id,
                            'company_id' => $companyId,
                            'branch_id' => $branchId,
                        ])->first();

                        // Use existing price if available, otherwise fetch from database
                        $priceRecipe = 0;
                        if ($detail->price > 0) {
                            // Use existing stored price to preserve historical data
                            $priceRecipe = $detail->price;
                        } else {
                            // Only fetch from database if price is not set (new record)
                            $productPriceRecipe = ProductPrice::where([
                                'product_id' => $productRecipe->id,
                                'company_id' => $companyId,
                                'branch_id' => $branchId,
                                'is_updated' => true,
                            ])->first();
                            $priceRecipe = $productPriceRecipe?->price ?? 0;
                        }

                        if ($priceRecipe == 0) {
                            AlertHelper::error('Gagal', 'Harga produk tidak boleh 0.');

                            return;
                        }

                        if ($medicineType->is_single) {
                            // === SINGLE ===
                            if ($productRecipe->is_non_stock) {
                                $quantityRecipe = $numeroRecipe;
                            } elseif (! $productStockRecipe) {
                                $quantityRecipe = $numeroRecipe;
                            } else {
                                // Simplified stock check
                                $quantityRecipe = $numeroRecipe;
                            }

                            $detail->fill([
                                'type' => 'single',
                                'dosage_doctor' => 0,
                                'dosage_drug' => 0,
                                'quantity_real' => $quantityRecipe,
                                'quantity' => $quantityRecipe,
                                'price' => $priceRecipe,
                                'sub_total_price' => (isset($detail->discount) && $detail->discount > 0) ? ($priceRecipe * $quantityRecipe) - $detail->discount : $priceRecipe * $quantityRecipe,
                                'discount_type' => $detail->discount_type ?? 'nominal',
                            ])->save();
                        } else {
                            $currentQty = $detail->quantity;

                            $detail->fill([
                                'type' => $detail->type ?? 'single',
                                'dosage_doctor' => 0,
                                'dosage_drug' => 0,
                                'quantity_real' => $detail->quantity_real,
                                'quantity' => $currentQty,
                                'price' => $priceRecipe,
                                'sub_total_price' => (isset($detail->discount) && $detail->discount > 0) ? ($priceRecipe * $currentQty) - $detail->discount : $priceRecipe * $currentQty,
                                'discount_type' => $detail->discount_type ?? 'nominal',
                            ])->save();

                        }
                    }

                    // sub_total_price cukup dihitung dari price * quantity milik recipe itu sendiri
                    $transactionRecipe->sub_total_price = $transactionRecipe->price * $transactionRecipe->quantity;
                    $transactionRecipe->save();
                }
            }

            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            AlertHelper::error('Gagal', 'Terjadi kesalahan saat memperbarui resep: '.$e->getMessage());
            Log::error('Error updating transaction recipe: '.$e->getMessage());
        }
    }

    public function updatedActions($value, $key)
    {
        // $key pattern: "0.price", "0.discount_input", "0.discount_type"
        $parts = explode('.', $key);
        if (count($parts) == 2) {
            $index = $parts[0];
            $field = $parts[1];

            if (isset($this->actions[$index])) {
                $action = $this->actions[$index];
                $transactionDetailId = $action['id'];

                $transactionDetail = TransactionDetail::find($transactionDetailId);
                if ($transactionDetail) {
                    if ($field === 'price') {
                        $transactionDetail->price = intval(preg_replace('/[^0-9]/', '', strval($value)));
                        // recalculate discount based on new price and explicit previous input
                        if ($action['discount_type'] === 'percentage') {
                            $percentage = floatval(preg_replace('/,/', '.', strval($action['discount_input'])));
                            $percentage = $percentage > 100 ? 100 : ($percentage < 0 ? 0 : $percentage);
                            $transactionDetail->discount = $percentage;
                            $transactionDetail->discount_value = round((($transactionDetail->price * $transactionDetail->quantity) * $percentage) / 100);
                        } else {
                            $transactionDetail->discount = intval(preg_replace('/[^0-9]/', '', strval($action['discount_input'] ?? 0)));
                            $transactionDetail->discount_value = $transactionDetail->discount;
                            $maxDiscountAllowed = $transactionDetail->price * $transactionDetail->quantity;
                            if ($transactionDetail->discount_value > $maxDiscountAllowed) {
                                $transactionDetail->discount_value = $maxDiscountAllowed;
                                $transactionDetail->discount = $maxDiscountAllowed;
                            }
                        }
                    } elseif ($field === 'discount_input' || $field === 'discount_type') {
                        $inputType = $field === 'discount_type' ? $value : $action['discount_type'];
                        $inputValue = $field === 'discount_input' ? $value : $action['discount_input'];

                        if ($field === 'discount_type') {
                            $inputValue = '';
                        }

                        $transactionDetail->discount_type = $inputType;
                        if ($inputType === 'percentage') {
                            $percentage = floatval(preg_replace('/,/', '.', strval($inputValue)));
                            $percentage = $percentage > 100 ? 100 : ($percentage < 0 ? 0 : $percentage);
                            $transactionDetail->discount = $percentage;
                            $transactionDetail->discount_value = round((($transactionDetail->price * $transactionDetail->quantity) * $percentage) / 100);
                        } else {
                            $transactionDetail->discount = intval(preg_replace('/[^0-9]/', '', strval($inputValue ?? 0)));
                            $transactionDetail->discount_value = $transactionDetail->discount;
                            $maxDiscountAllowed = $transactionDetail->price * $transactionDetail->quantity;
                            if ($transactionDetail->discount_value > $maxDiscountAllowed) {
                                $transactionDetail->discount_value = $maxDiscountAllowed;
                                $transactionDetail->discount = $maxDiscountAllowed;
                            }
                        }
                    }

                    $currentPrice = intval($transactionDetail->price);
                    $currentDiscountValue = floatval($transactionDetail->discount_value ?? 0);

                    $transactionDetail->sub_total_price = ($currentPrice * $transactionDetail->quantity) - $currentDiscountValue;
                    $transactionDetail->save();

                    $this->getActions();

                    $inputType = $action['discount_type'];
                    if ($field === 'discount_type') {
                        $inputType = $value;
                    }

                    if ($field === 'discount_type' || ($field === 'discount_input' && strval($value) === '')) {
                        $this->actions[$index]['discount_input'] = '';
                    } else {
                        if ($inputType === 'percentage') {
                            $this->actions[$index]['discount_input'] = floatval($transactionDetail->discount);
                        } else {
                            $this->actions[$index]['discount_input'] = intval($transactionDetail->discount);
                        }
                    }
                    $this->actions[$index]['discount_type'] = $inputType;

                    $this->updateTotal();
                }
            }
        }
    }

    public function updatedMedicines($value, $key)
    {
        // $key pattern: "0.price", "0.discount_input", "0.discount_type"
        $parts = explode('.', $key);
        if (count($parts) == 2) {
            $index = $parts[0];
            $field = $parts[1];

            if (isset($this->medicines[$index])) {
                $medicine = $this->medicines[$index];
                $transactionDetailId = $medicine['id'];

                $transactionDetail = TransactionDetail::find($transactionDetailId);
                if ($transactionDetail) {
                    if ($field === 'price') {
                        $transactionDetail->price = intval(preg_replace('/[^0-9]/', '', strval($value)));
                        // recalculate discount based on new price and explicit previous input
                        if ($medicine['discount_type'] === 'percentage') {
                            $percentage = floatval(preg_replace('/,/', '.', strval($medicine['discount_input'])));
                            $percentage = $percentage > 100 ? 100 : ($percentage < 0 ? 0 : $percentage);
                            $transactionDetail->discount = $percentage;
                            $transactionDetail->discount_value = round((($transactionDetail->price * $transactionDetail->quantity) * $percentage) / 100);
                        } else {
                            $transactionDetail->discount = intval(preg_replace('/[^0-9]/', '', strval($medicine['discount_input'] ?? 0)));
                            $transactionDetail->discount_value = $transactionDetail->discount;
                            $maxDiscountAllowed = $transactionDetail->price * $transactionDetail->quantity;
                            if ($transactionDetail->discount_value > $maxDiscountAllowed) {
                                $transactionDetail->discount_value = $maxDiscountAllowed;
                                $transactionDetail->discount = $maxDiscountAllowed;
                            }
                        }
                    } elseif ($field === 'discount_input' || $field === 'discount_type') {
                        $inputType = $field === 'discount_type' ? $value : $medicine['discount_type'];
                        $inputValue = $field === 'discount_input' ? $value : $medicine['discount_input'];

                        if ($field === 'discount_type') {
                            $inputValue = '';
                        }

                        $transactionDetail->discount_type = $inputType;
                        if ($inputType === 'percentage') {
                            $percentage = floatval(preg_replace('/,/', '.', strval($inputValue)));
                            $percentage = $percentage > 100 ? 100 : ($percentage < 0 ? 0 : $percentage);
                            $transactionDetail->discount = $percentage;
                            $transactionDetail->discount_value = round((($transactionDetail->price * $transactionDetail->quantity) * $percentage) / 100);
                        } else {
                            $transactionDetail->discount = intval(preg_replace('/[^0-9]/', '', strval($inputValue ?? 0)));
                            $transactionDetail->discount_value = $transactionDetail->discount;
                            $maxDiscountAllowed = $transactionDetail->price * $transactionDetail->quantity;
                            if ($transactionDetail->discount_value > $maxDiscountAllowed) {
                                $transactionDetail->discount_value = $maxDiscountAllowed;
                                $transactionDetail->discount = $maxDiscountAllowed;
                            }
                        }
                    }

                    $currentPrice = intval($transactionDetail->price);
                    $currentDiscountValue = floatval($transactionDetail->discount_value ?? 0);

                    $transactionDetail->sub_total_price = ($currentPrice * $transactionDetail->quantity) - $currentDiscountValue;
                    $transactionDetail->save();

                    $this->getMedicines();

                    $inputType = $medicine['discount_type'];
                    if ($field === 'discount_type') {
                        $inputType = $value;
                    }
                    if ($field === 'discount_type' || ($field === 'discount_input' && strval($value) === '')) {
                        $this->medicines[$index]['discount_input'] = '';
                    } else {
                        if ($inputType === 'percentage') {
                            $this->medicines[$index]['discount_input'] = floatval($transactionDetail->discount);
                        } else {
                            $this->medicines[$index]['discount_input'] = intval($transactionDetail->discount_value);
                        }
                    }
                    $this->medicines[$index]['discount_type'] = $inputType;

                    $this->updateTotal();
                }
            }
        }
    }

    public function updateQuantity($transactionDetailId, $quantity)
    {
        $transactionDetail = TransactionDetail::find($transactionDetailId);

        if (! $transactionDetail) {
            return AlertHelper::error('Gagal', 'Detail transaksi tidak ditemukan.');
        }

        if ($quantity === 'decrement') {
            if ($transactionDetail->quantity <= 1) {
                $transactionDetail->quantity = 1;
                $transactionDetail->save();

                return AlertHelper::error('Gagal', 'Jumlah produk tidak boleh kurang dari 1.');
            }

            $transactionDetail->decrement('quantity');
        }

        if ($quantity === 'increment') {
            $transactionDetail->increment('quantity');
        }

        if (isset($transactionDetail->discount) && $transactionDetail->discount > 0) {
            $transactionDetail->sub_total_price = ($transactionDetail->price * $transactionDetail->quantity) - $transactionDetail->discount;
            // Prevent negative sub total just in case
            if ($transactionDetail->sub_total_price < 0) {
                $transactionDetail->sub_total_price = 0;
            }
        } else {
            $transactionDetail->sub_total_price = $transactionDetail->price * $transactionDetail->quantity;
        }
        $transactionDetail->save();

        $this->details();
        $this->updateTotal();
    }

    public function confirmSaveTransaction($type)
    {
        $saveFunction = $type == 'draft' ? 'saveDraft' : ($type == 'process' ? 'saveTransaction' : 'saveSuccessTransaction');

        return AlertHelper::confirmSave($saveFunction, 'Apakah Anda yakin ingin menyimpan transaksi '.Str::title($type).' ini?');
    }

    public function saveDraft()
    {
        $transaction = Transaction::find($this->transaction_id);

        if ($transaction) {
            $transaction->status = 'draft';
            $transaction->diagnosas = $this->diagnosas;
            $transaction->immunization = $this->immunization;
            $transaction->is_insurance = $this->is_insurance ? true : false;
            $transaction->insurance_number = $this->insurance_number;

            if ($this->is_pending_payment) {
                $transaction->is_pending_payment = true;
                $transaction->status_payment = 'draft';
            }
            $transaction->save();

            AlertHelper::success('Berhasil', 'Transaksi berhasil disimpan sebagai draft.');

            return redirect()->route('user.sale.pos');
        } else {
            AlertHelper::error('Gagal', 'Transaksi tidak ditemukan.');

            return redirect()->route('user.sale.pos');
        }
    }

    public function saveTransaction()
    {
        $transaction = Transaction::find($this->transaction_id);
        $branchId = Branch::where('company_id', Auth::user()->company_id)->first()?->id;

        if (! $transaction) {
            return AlertHelper::error('Gagal', 'Transaksi tidak ditemukan.');
        }

        // Validasi data dasar TransactionRecipes (tanpa kunci stok)
        foreach ($transaction->transactionRecipes as $key => $recipe) {
            $no = $key + 1;

            if (! $recipe->medicine_type_id || $recipe->medicine_type_id == 0) {
                return AlertHelper::error('Gagal', "Tipe resep pada /R{$no} belum dipilih.");
            }

            if ($recipe->numero_recipe <= 0) {
                return AlertHelper::error('Gagal', "Jumlah resep pada /R{$no} belum diisi.");
            }

            $medicineType = MedicineType::find($recipe->medicine_type_id);

            if (! $medicineType->is_single && ! $recipe->product_id) {
                return AlertHelper::error('Gagal', "Produk pendukung pada /R{$no} belum dipilih.");
            }

            $recipeProduct = Product::find($recipe->product_id);
            if (! $recipeProduct) {
                continue;
            }

            if ($recipe->transactionDetail->count() <= 0) {
                return AlertHelper::error('Gagal', "Detail resep /R{$no} belum diisi.");
            }
        }

        $transactionDetails = TransactionDetail::where('transaction_id', $this->transaction_id)->get();

        // Validasi data dasar TransactionDetails (tanpa kunci stok)
        foreach ($transactionDetails as $transactionDetail) {
            if (! $transactionDetail->product_id) {
                continue;
            }

            $product = Product::find($transactionDetail->product_id);
            if (! $product) {
                continue;
            }
        }

        $transaction->is_insurance = $this->is_insurance ? true : false;
        $transaction->insurance_number = $this->insurance_number;
        $transaction->status = 'process';

        if ($this->is_pending_payment) {
            $transaction->is_pending_payment = true;
            $transaction->status_payment = 'draft';
            $transaction->installment_count = $this->installment_count;
            $transaction->installment_period = $this->installment_period;
        } else {
            $transaction->is_pending_payment = false;
            $transaction->installment_count = null;
            $transaction->installment_period = null;
        }

        $transaction->save();

        session()->flash('saved', [
            'title' => 'Berhasil!',
            'text' => 'Transaksi berhasil diproses!',
        ]);

        return redirect()->route('user.sale.pos');
    }

    public function confirmDeleteTransaction()
    {
        return AlertHelper::confirmDelete('deleteTransaction', 'Apakah Anda yakin ingin menghapus transaksi ini?', $this->transaction_id);
    }

    public function deleteTransaction($id)
    {
        try {
            DB::beginTransaction();

            $transaction = Transaction::find($id[0]);
            if ($transaction) {
                $transaction->status = 'canceled';
                $transaction->save();
                DB::commit();
                AlertHelper::success('Berhasil', 'Transaksi berhasil dihapus.');
            } else {
                AlertHelper::error('Gagal', 'Transaksi tidak ditemukan.');
            }
        } catch (\Throwable $e) {
            DB::rollBack();
            Log::error('Gagal menghapus transaksi: '.$e->getMessage(), [
                'file' => $e->getFile(),
                'line' => $e->getLine(),
            ]);
            AlertHelper::error('Gagal', 'Terjadi kesalahan saat menghapus transaksi.');
        }

        return redirect()->route('user.sale.pos');
    }

    public function saveSuccessTransaction()
    {
        $transaction = Transaction::with(['transactionDetails', 'transactionRecipes.transactionDetail'])
            ->find($this->transaction_id);

        $branchId = Branch::where('company_id', Auth::user()->company_id)->first()?->id;

        if (! $transaction) {
            return AlertHelper::error('Gagal', 'Transaksi tidak ditemukan.');
        }

        if ($transaction->type === 'resep' && $transaction->transactionRecipes->count() <= 0) {
            return AlertHelper::error('Gagal', 'Transaksi tidak dapat disimpan, karena tidak ada item resep yang ditambahkan.');
        }

        // if ((float)$transaction->remaining_bill > 0) {
        //     return AlertHelper::error('Gagal', 'Transaksi tidak dapat disimpan, karena masih ada sisa tagihan.');
        // }

        // Validasi dasar TransactionRecipes (tanpa kunci stok)
        foreach ($transaction->transactionRecipes as $key => $recipe) {
            $no = $key + 1;

            if (! $recipe->medicine_type_id || $recipe->medicine_type_id == 0) {
                return AlertHelper::error('Gagal', "Tipe resep pada /R{$no} belum dipilih.");
            }

            if ($recipe->numero_recipe <= 0) {
                return AlertHelper::error('Gagal', "Jumlah resep pada /R{$no} belum diisi.");
            }

            $medicineType = MedicineType::find($recipe->medicine_type_id);

            if (! $medicineType->is_single && ! $recipe->product_id) {
                return AlertHelper::error('Gagal', "Produk pendukung pada /R{$no} belum dipilih.");
            }

            $recipeProduct = Product::find($recipe->product_id);
            if (! $recipeProduct) {
                continue;
            }

            if ($recipe->transactionDetail->count() <= 0) {
                return AlertHelper::error('Gagal', "Detail resep /R{$no} belum diisi.");
            }
        }

        $transactionDetails = TransactionDetail::where('transaction_id', $this->transaction_id)->get();

        // Validasi dasar TransactionDetails (tanpa kunci stok)
        foreach ($transactionDetails as $transactionDetail) {
            if (! $transactionDetail->product_id) {
                continue;
            }

            $product = Product::find($transactionDetail->product_id);
            if (! $product) {
                continue;
            }
        }

        try {
            DB::beginTransaction();

            $this->processTransactionPayments($transaction);

            if ($this->is_outside_pharmacy) {
                if ($transaction->consultation === 'yes') {
                    $encounter = Encounter::firstOrNew(['transaction_id' => $transaction->id]);

                    $patient = Patient::where('user_id', $transaction->patient_id)->first();
                    $doctor = Practitioner::where('user_id', $transaction->doctor_id)->first();

                    $data = [
                        'pending' => true,
                        'id' => $encounter->id ?? null,
                        'transaction_id' => $transaction->id,
                        'company_id' => $transaction->company_id,
                        'location_id' => $transaction->location_id,
                        'patient_id' => $patient?->id,
                        'practitioner_id' => $doctor?->id,
                        'type' => 'outpatient',
                        'status' => 'finished',
                        'class_code' => 'AMB',
                    ];

                    app(apiservice::class)->createTransaction($data);
                }

                $updateData = [
                    'insurance_number' => $this->insurance_number,
                    'is_insurance' => $this->is_insurance ? true : false,
                    'status' => 'completed',
                ];

                if ($this->is_pending_payment) {
                    $updateData['is_pending_payment'] = true;
                    $updateData['status_payment'] = 'draft';
                    $updateData['installment_count'] = $this->installment_count;
                    $updateData['installment_period'] = $this->installment_period;
                }

                $transaction->update($updateData);
            } else {
                $transactionDetailsCount = $transaction->transactionDetails()
                    ->whereIn('type_transaction', ['medicine', 'recipe'])
                    ->count();

                $statusData = [
                    'cashier_id' => Auth::id(),
                    'cashier_name' => Auth::user()->name,
                    'diagnosas' => $this->diagnosas,
                    'immunization' => $this->immunization,
                ];

                if ($transactionDetailsCount <= 0) {
                    // Start: Process products for Actions/Odontogram even if skipping Pharmacy
                    $productService = new ProductService;
                    $actionDetails = $transaction->transactionDetails()
                        ->whereIn('type_transaction', ['action', 'other', 'odontogram_action']) // Include relevant types
                        ->whereNotNull('product_id')
                        ->get();

                    foreach ($actionDetails as $detail) {
                        $product = Product::find($detail->product_id);
                        if ($product) {
                            $productPrice = ProductPrice::where('product_id', $product->id)
                                ->where('company_id', $transaction->company_id)
                                ->where('branch_id', $branchId)
                                ->first();

                            $hppPrice = $productPrice ? intval(preg_replace('/[^0-9]/', '', number_format($productPrice->hpp_average, 0, ',', '.'))) : 0;
                            $quantity = $detail->quantity;
                            $sellingPrice = $detail->price; // Assuming price is already clean or needs cleaning? Typically clean in DB.

                            // Update Detail with HPP
                            $detail->update([
                                'price_hpp' => $hppPrice,
                                'sub_total_price_hpp' => $hppPrice * $quantity,
                            ]);

                            // Create Transaction Product
                            $this->createTransactionProduct($transaction, $detail, $product, $hppPrice, $quantity, $sellingPrice);

                            // Decrement Stock
                            $productService->createProductDecrement($product->id, $quantity, null, null, $sellingPrice, null, null, null, null, null);
                        }
                    }
                    // End: Process products

                    if ($transaction->consultation === 'yes') {
                        $encounter = Encounter::firstOrNew(['transaction_id' => $transaction->id]);

                        $patient = Patient::where('user_id', $transaction->patient_id)->first();
                        $doctor = Practitioner::where('user_id', $transaction->doctor_id)->first();

                        $data = [
                            'pending' => true,
                            'id' => $encounter->id ?? null,
                            'transaction_id' => $transaction->id,
                            'company_id' => $transaction->company_id,
                            'location_id' => $transaction->location_id,
                            'patient_id' => $patient?->id,
                            'practitioner_id' => $doctor?->id,
                            'type' => 'outpatient',
                            'status' => 'finished',
                            'class_code' => 'AMB',
                        ];

                        app(apiservice::class)->createTransaction($data);
                    }

                    $updateData = array_merge(['status' => 'completed'], $statusData);
                    if ($this->is_pending_payment) {
                        $updateData['is_pending_payment'] = true;
                        $updateData['status_payment'] = 'draft';
                        $updateData['installment_count'] = $this->installment_count;
                        $updateData['installment_period'] = $this->installment_period;
                    }
                    $transaction->update($updateData);
                } else {
                    $status = in_array($transaction->status, ['take_medicine', 'completed']) ? $transaction->status : 'take_medicine';

                    $updateData = array_merge([
                        'insurance_number' => $this->insurance_number,
                        'is_insurance' => $this->is_insurance ? true : false,
                        'status' => $status,
                        'is_take_medicine' => true,
                        'date_prepare' => now()->format('Y-m-d'),
                    ], $statusData);

                    if ($this->is_pending_payment) {
                        $updateData['is_pending_payment'] = true;
                        $updateData['status_payment'] = 'draft';
                        $updateData['installment_count'] = $this->installment_count;
                        $updateData['installment_period'] = $this->installment_period;
                    }

                    $transaction->update($updateData);
                }

                if ($this->is_pending_payment) {
                    $this->saveTransactionInstallments($transaction);
                }
            }

            DB::commit();

            session()->flash('saved', [
                'title' => 'Transaksi Berhasil!',
                'text' => 'Transaksi berhasil disimpan sebagai pengambilan obat.',
            ]);

            return redirect()->route('user.sale.pos');
        } catch (\Exception $e) {
            DB::rollBack();

            return $this->handleError($e);
        }
    }

    private function processTransactionDetails($transaction)
    {
        $productService = new ProductService;
        $companyId = Auth::user()->company_id;
        $branch = Branch::where('company_id', $companyId)->firstOrFail();

        foreach ($this->transaction_details as $transactionDetailData) {
            $this->processRecipeLevel($transaction, $transactionDetailData, $productService, $companyId, $branch->id);
            $this->processDetailLevel($transaction, $transactionDetailData, $productService, $companyId, $branch->id);
        }
    }

    private function processRecipeLevel($transaction, $data, $productService, $companyId, $branchId)
    {
        $transactionRecipe = TransactionRecipe::findOrFail($data['id']);
        $product = Product::findOrFail($data['product_id']);

        // Use existing HPP if available, otherwise fetch from database
        $hppPrice = 0;
        if ($transactionRecipe->price_hpp > 0) {
            // Use existing stored HPP to preserve historical cost data
            $hppPrice = $transactionRecipe->price_hpp;
        } else {
            // Only fetch from database if HPP is not set (new record)
            $productPrice = ProductPrice::where('product_id', $product->id)
                ->where('company_id', $companyId)
                ->where('branch_id', $branchId)
                ->first();
            $hppPrice = $productPrice ? intval(preg_replace('/[^0-9]/', '', number_format($productPrice->hpp_average, 0, ',', '.'))) : 0;
            $data['hpp_price'] = $hppPrice;
        }
        $quantity = $data['quantity'];
        $sellingPrice = intval(preg_replace('/[^0-9]/', '', strval($data['price'])));
        $data['sub_total_price'] = intval(preg_replace('/[^0-9]/', '', strval($data['sub_total_price'])));
        $transactionRecipe->update([
            'price_hpp' => $hppPrice,
            'sub_total_price_hpp' => $hppPrice * $quantity,
        ]);

        $this->createTransactionProduct($transaction, $data, $product, $hppPrice, $quantity, $sellingPrice);
        $productService->createProductDecrement($product->id, $quantity, null, null, $sellingPrice, null, null, null, $data['id'], null);
    }

    private function processDetailLevel($transaction, $data, $productService, $companyId, $branchId)
    {
        if (! isset($data['details']) || ! is_array($data['details'])) {
            return;
        }

        foreach ($data['details'] as $detailData) {
            $transactionDetail = TransactionDetail::findOrFail($detailData['id']);
            $productRecipe = Product::findOrFail($detailData['product_id']);

            // Use existing HPP if available, otherwise fetch from database
            $hppPrice = 0;
            if ($transactionDetail->price_hpp > 0) {
                // Use existing stored HPP to preserve historical cost data
                $hppPrice = $transactionDetail->price_hpp;
            } else {
                // Only fetch from database if HPP is not set (new record)
                $productPriceRecipe = ProductPrice::where('product_id', $productRecipe->id)
                    ->where('company_id', $companyId)
                    ->where('branch_id', $branchId)
                    ->first();
                $hppPrice = $productPriceRecipe ? intval(preg_replace('/[^0-9]/', '', number_format($productPriceRecipe->hpp_average, 0, ',', '.'))) : 0;
                $detailData['hpp_price'] = $hppPrice;
            }
            $quantity = $detailData['quantity'];
            $sellingPrice = intval(preg_replace('/[^0-9]/', '', number_format($detailData['price'], 0, ',', '.')));
            $data['sub_total_price'] = intval(preg_replace('/[^0-9]/', '', number_format($data['sub_total_price'], 0, ',', '.')));

            $transactionDetail->update([
                'price_hpp' => $hppPrice,
                'sub_total_price_hpp' => $hppPrice * $quantity,
            ]);

            $this->createTransactionProduct($transaction, $detailData, $productRecipe, $hppPrice, $quantity, $sellingPrice);

            $productService->createProductDecrement($productRecipe->id, $quantity, null, null, $sellingPrice, null, null, $detailData['id'], null, null);
        }
    }

    private function createTransactionProduct($transaction, $data, $product, $hppPrice, $quantity, $sellingPrice)
    {
        $profit = ($sellingPrice - $hppPrice) * $quantity;

        if ($sellingPrice > 0 && $quantity > 0) {
            $margin = ($profit / ($sellingPrice * $quantity)) * 100;
        } else {
            $margin = 0;
        }

        // Batasi margin ke rentang -100 s/d 100, lalu bulatkan
        $margin = max(min($margin, 100), -100);
        $margin = round($margin);

        TransactionProduct::create([
            'transaction_id' => $transaction->id,
            'transaction_detail_id' => $data['id'],
            'product_id' => $product->id,
            'product_name' => $product->name,
            'quantity' => $quantity,
            'price' => $sellingPrice,
            'total' => $data['sub_total_price'],
            'hpp_average' => $hppPrice,
            'hpp_total' => $hppPrice * $quantity,
            'profit' => $profit,
            'margin' => $margin, // Sekarang integer
        ]);
    }

    private function errorResponse($message)
    {
        return AlertHelper::error('Gagal', $message);
    }

    public function processTransactionPayments($transaction)
    {
        $payments = $transaction->transactionPayments;

        $lastPayment = $payments->last();

        foreach ($payments as $payment) {
            if ($payment->is($lastPayment)) {
                $payment->payment_real = $payment->payment_amount - $transaction->payment_change;
            } else {
                $payment->payment_real = $payment->payment_amount;
            }

            $payment->save();
        }
    }

    private function handleError(\Exception $e)
    {
        Log::error('Error dalam saveSuccessTransaction: '.$e->getMessage(), [
            'transaction_id' => $this->transaction_id,
            'user_id' => Auth::id(),
            'trace' => $e->getTraceAsString(),
        ]);

        AlertHelper::error('Gagal', 'Terjadi kesalahan saat menyimpan transaksi: '.$e->getMessage());
        // return redirect()->route('user.sale.pos');

    }

    public function updateTotal()
    {
        $transaction = Transaction::find($this->transaction_id);

        if ($transaction) {
            // 1. Hitung komponen dasar subtotal
            $first_service_price = $this->is_outside_pharmacy ? 0 : TransactionRecipe::where('transaction_id', $this->transaction_id)->sum('price_service_one');
            $service_other_price = $this->is_outside_pharmacy ? 0 : TransactionRecipe::where('transaction_id', $this->transaction_id)->sum('price_service_other');
            $price_product_price = $this->is_outside_pharmacy ? 0 : TransactionRecipe::where('transaction_id', $this->transaction_id)->sum('sub_total_price');
            $product_price = $this->is_outside_pharmacy
                ? TransactionDetail::whereIn('type_transaction', ['action', 'other'])->where('transaction_id', $this->transaction_id)->sum('sub_total_price')
                : TransactionDetail::where('transaction_id', $this->transaction_id)->sum('sub_total_price');

            // Set komponen dasar transaksi
            $transaction->sub_total_price_embalage = $first_service_price + $price_product_price + $product_price;
            $transaction->second_service_price = 0;
            $transaction->first_service_price = $first_service_price;
            $transaction->service_other_price = $service_other_price;
            $transaction->price_product_price = $price_product_price;
            $transaction->product_price = $product_price;
            $transaction->embalage = $transaction->second_service_price + $first_service_price + $price_product_price + $service_other_price;

            // 2. Hitung subtotal awal sebelum promosi dan diskon
            $subtotal = $transaction->embalage + $product_price;

            // Gunakan sub_total_price_before_rounding jika tersedia, jika tidak gunakan subtotal yang dihitung
            if (! empty($transaction->sub_total_price_before_rounding) && $transaction->sub_total_price_before_rounding > 0) {
                // dd($transaction->sub_total_price_before_rounding);
                $subtotal = $subtotal;
            }
            // dd($subtotal);

            // 3. Validasi dan terapkan promotion simplified
            if ($this->promotion_simplified_id) {
                $promotionService = new PromotionSimplifiedService;
                $promotionResult = $promotionService->calculatePromotionDiscount($this->promotion_simplified_id, $subtotal);

                // Jika promotion tidak eligible, hapus promotion
                if (! $promotionResult['eligible']) {
                    $promotionName = '';
                    try {
                        $promotion = PromotionSimplified::find($this->promotion_simplified_id);
                        $promotionName = $promotion ? $promotion->name : 'Promosi';
                    } catch (\Exception $e) {
                        $promotionName = 'Promosi';
                    }

                    $this->promotion_simplified_id = null;
                    $transaction->promotion_simplified_id = null;
                    $transaction->promotion_real = 0;
                    $transaction->promotion = 0;
                    $transaction->promotion_type = 'rupiah';
                    $transaction->promotion_value = 0;

                    AlertHelper::warning(
                        'Peringatan',
                        "Promosi '{$promotionName}' tidak memenuhi syarat. Total transaksi kurang dari minimum pembelian atau diskon melebihi batas maksimum."
                    );
                }
            }

            // 4. Hitung total setelah promosi
            $totalAfterPromotion = $subtotal;
            // dd($totalAfterPromotion);
            $totalPromotionDiscount = $transaction->promotion_real ?? 0;
            $totalAfterPromotion = $totalAfterPromotion - $totalPromotionDiscount;

            // 5. Aplikasikan pembulatan SEBELUM manual discount
            $rounding = 0;
            $roundedTotal = 0;
            $remainder = 0;

            if ($totalAfterPromotion <= 0) {
                $roundedTotal = 0;
                $rounding = -$totalAfterPromotion;
                $remainder = 0;
            } else {
                $totalAfterPromotion = (int) round($totalAfterPromotion);
                $remainder = $totalAfterPromotion % 1000;

                if ($remainder > 1 && $remainder <= 499) {
                    $roundedTotal = $totalAfterPromotion - $remainder + 500;
                    $rounding = 500 - $remainder;
                } elseif ($remainder >= 500 && $remainder < 1000) {
                    $roundedTotal = $totalAfterPromotion - $remainder + 1000;
                    $rounding = 1000 - $remainder;
                } else {
                    $roundedTotal = $totalAfterPromotion;
                    $rounding = 0;
                }
            }

            // 6. Hitung dan terapkan manual discount berdasarkan total setelah rounding
            $totalManualDiscount = 0;

            if ($roundedTotal >= 1) {
                if ($this->discount_type == 'percentage') {
                    $discountPercentage = floatval(str_replace(',', '.', $this->discount ?? '0'));
                    $totalManualDiscount = ($roundedTotal * $discountPercentage) / 100;
                    $transaction->discount = $discountPercentage;
                } else {
                    $discountAmount = intval(str_replace('.', '', $this->discount ?? '0'));
                    // Pastikan diskon tidak melebihi total setelah rounding
                    $totalManualDiscount = min($discountAmount, $roundedTotal);
                    $transaction->discount = $totalManualDiscount;
                }

                $transaction->discount_value = $totalManualDiscount + TransactionDetail::where('transaction_id', $this->transaction_id)->sum('discount_value') + TransactionAction::where('transaction_id', $this->transaction_id)->sum('discount_value');
                $transaction->discount_type = $this->discount_type ?? 'rupiah';
            } else {
                $transaction->discount = 0;
                $transaction->discount_type = 'rupiah';
                $transaction->discount_value = 0;
                $totalManualDiscount = 0;
            }

            // Update format display discount
            if ($this->discount !== '') {
                $this->discount = ($this->discount_type ?? 'rupiah') == 'rupiah'
                    ? number_format($transaction->discount, 0, ',', '.')
                    : number_format($transaction->discount, 2, ',', '.');
            }

            // 7. Hitung grand total final setelah manual discount
            $grandTotal = $roundedTotal - $totalManualDiscount;

            // Pastikan grand total tidak negatif
            if ($grandTotal < 0) {
                $grandTotal = 0;
                // Adjust discount jika menyebabkan total negatif
                $totalManualDiscount = $roundedTotal;
                $transaction->discount_value = $totalManualDiscount;
            }

            $transaction->sub_total_price = $roundedTotal;

            // 8. Set nilai final ke transaksi
            $transaction->rounding = $rounding;
            $transaction->grand_total_price = $grandTotal;
            $transaction->rounding_remainder = $remainder;

            // 9. Hitung pembayaran dan kembalian
            $transaction->payment_amount = $transaction->transactionPayments()->sum('payment_amount');
            $transaction->payment_change = $transaction->payment_amount < $transaction->grand_total_price ? 0 : $transaction->payment_amount - $transaction->grand_total_price;
            $transaction->remaining_bill = $transaction->grand_total_price - $transaction->payment_amount;
            $transaction->remaining_bill = $transaction->remaining_bill < 0 ? 0 : $transaction->remaining_bill;
            $transaction->grand_total_price_admin_fee = $transaction->grand_total_price + ($transaction->single_payment_admin_fee ?? 0);

            // 10. Simpan transaksi dan refresh data
            $transaction->save();

            $this->reset('transaction');
            $this->transaction = $transaction;
            if ($this->discount !== '') {
                $this->discount = $this->discount_type == 'percentage' ? $transaction->discount : number_format($transaction->discount, 0, ',', '.');
            }
        }
    }

    public function addDetail($transaction_recipe)
    {
        $this->transaction_recipe_id = $transaction_recipe;
        $this->dispatch('open-modal', ['id' => 'modalProduct']);
    }

    public function confirmDeleteTransactionRecipe($transactionRecipeId)
    {
        return AlertHelper::confirmDelete('deleteTransactionRecipe', 'Apakah Anda yakin ingin menghapus item ini?', $transactionRecipeId);
    }

    public function confirmDeleteTransactionDetail($transactionDetailId)
    {
        return AlertHelper::confirmDelete('deleteTransactionDetail', 'Apakah Anda yakin ingin menghapus item ini?', $transactionDetailId);
    }

    public function deleteTransactionDetail($transactionDetailId)
    {
        $transactionDetail = TransactionDetail::find($transactionDetailId[0]);

        if ($transactionDetail) {
            $transactionDetail->delete();
            $this->details();
            $this->updateTotal();
            AlertHelper::success('Berhasil', 'Item berhasil dihapus dari keranjang.');
        } else {
            AlertHelper::error('Gagal', 'Item tidak ditemukan.');
        }
    }

    public function deleteTransactionRecipe($transactionRecipeId)
    {
        $transactionRecipe = TransactionRecipe::find($transactionRecipeId[0]);

        if ($transactionRecipe) {
            TransactionDetail::where('transaction_recipe_id', $transactionRecipe->id)
                ->where('transaction_id', $this->transaction_id)
                ->delete();

            $transactionRecipe->delete();
            $this->details();
            $this->updateTotal();
            AlertHelper::success('Berhasil', 'Item berhasil dihapus dari keranjang.');
        } else {
            AlertHelper::error('Gagal', 'Item tidak ditemukan.');
        }
    }

    public function confirmResetTransaction()
    {
        return AlertHelper::confirmDelete('resetTransaction', 'Apakah Anda yakin ingin mereset transaksi ini?', $this->transaction_id);
    }

    public function resetTransaction()
    {
        $transaction = Transaction::find($this->transaction_id);

        if ($transaction) {
            $transaction->sub_total_price = 0;
            $transaction->discount = 0;
            $transaction->discount_value = 0;
            $transaction->discount_type = 'rupiah';
            $transaction->grand_total_price = 0;
            $transaction->payment_amount = 0;
            $transaction->payment_change = 0;
            $transaction->remaining_bill = 0;
            $transaction->rounding = 0;
            $transaction->rounding_remainder = 0; // ✅ disimpan di field baru
            $transaction->save();
            $transaction->transactionPayments()->delete();
            $transaction->transactionDetails()->delete();
            $this->details();
            $this->updateTotal();
            AlertHelper::success('Berhasil', 'Transaksi berhasil direset.');
        } else {
            AlertHelper::error('Gagal', 'Transaksi tidak ditemukan.');
        }
    }

    public function openModal()
    {
        $this->dispatch('open-modal', ['id' => 'modalProduct']);
    }

    public function closeModal()
    {
        $this->reset('searchProduct', 'transaction_recipe_id');
        $this->resetPage('pageProduct');
        $this->dispatch('close-modal', ['id' => 'modalProduct']);
    }

    public function getProduct($product_id)
    {
        $product = Product::find($product_id);
        $this->product_id = $product->id;
        $this->search_sku = $product->sku_number.' '.$product->name;
        $this->barcode = true;
        $this->choiceProductChange();
    }

    public function updatedSearchProduct()
    {
        $this->resetPage('pageProduct');
    }

    public function updatedPerPageProduct()
    {
        $this->resetPage('pageProduct');
    }

    public function openModalPayment()
    {
        $this->dispatch('open-modal', ['id' => 'modalPayment']);
    }

    public function closeModalPayment()
    {
        $this->reset('payment_method_id', 'payment_amount', 'description', 'admin_fee', 'is_single_payment', 'is_down_payment');
        $this->dispatch('close-modal', ['id' => 'modalPayment']);
    }

    public function submitPayment()
    {
        $this->validate([
            'payment_method_id' => 'required',
            'payment_amount' => 'required',
        ]);

        $payment_amount = intval(preg_replace('/[^0-9]/', '', strval($this->payment_amount)));
        $admin_fee = 0;

        $paymentMethod = PaymentMethod::find($this->payment_method_id);
        $payment_type = $paymentMethod ? $paymentMethod->type : null;

        if ($payment_type == 'debit_card' || $payment_type == 'credit_card' || $payment_type == 'qris') {
            if ($this->admin_fee == '') {
                $this->addError('admin_fee', 'Biaya Admin harus diisi.');

                return;
            }
            $admin_fee = intval(preg_replace('/[^0-9]/', '', strval($this->admin_fee)));
        }

        TransactionPayment::create([
            'user_id' => $this->transaction->patient_id,
            'transaction_id' => $this->transaction_id,
            'payment_method_id' => $this->payment_method_id,
            'description' => $this->description,
            'payment_amount' => $payment_amount,
            'admin_fee' => $admin_fee,
            'payment_real' => $payment_amount + $admin_fee,
            'company_id' => Auth::user()->company_id,
            'is_down_payment' => $this->is_down_payment ? true : false,
        ]);

        $transaction = Transaction::find($this->transaction_id);
        if ($this->is_single_payment) {
            $transaction->payment_method_single_payment_id = $this->payment_method_id;
            $transaction->single_payment_admin_fee = $admin_fee;
            $transaction->single_payment_payment_amount = $payment_amount;
            $transaction->single_payment_payment_real = $payment_amount + $admin_fee;
            $transaction->is_single_payment = true;
        } else {
            $transaction->payment_method_single_payment_id = null;
            $transaction->single_payment_admin_fee = 0;
            $transaction->single_payment_payment_amount = 0;
            $transaction->single_payment_payment_real = 0;
            $transaction->is_single_payment = false;
        }
        $transaction->save();

        $this->closeModalPayment();
        $this->updateTotal();

        return AlertHelper::success('Berhasil', 'Pembayaran berhasil ditambahkan.');
    }

    public function confirmDeleteTransactionPayment($transactionPaymentId)
    {
        return AlertHelper::confirmDelete('deleteTransactionPayment', 'Apakah Anda yakin ingin menghapus pembayaran ini?', $transactionPaymentId);
    }

    public function updatedPaymentMethodId()
    {
        $paymentMethod = PaymentMethod::find($this->payment_method_id);
        if ($paymentMethod->is_single_payment) {
            $this->is_single_payment = true;
            $this->payment_amount = number_format($this->transaction->remaining_bill, 0, ',', '.');
            $this->updatePaymentSinglePayment();
        } else {
            $this->payment_amount = 0;
            $this->is_single_payment = false;
        }
    }

    public function deleteTransactionPayment($transactionPaymentId)
    {
        $transactionPayment = TransactionPayment::find($transactionPaymentId[0]);

        if ($transactionPayment) {
            $transaction = Transaction::find($this->transaction_id);
            if ($transaction->is_single_payment) {
                $transaction->payment_method_single_payment_id = null;
                $transaction->single_payment_admin_fee = 0;
                $transaction->single_payment_payment_amount = 0;
                $transaction->single_payment_payment_real = 0;
                $transaction->is_single_payment = false;
                $transaction->save();
            }

            $transactionPayment->delete();
            $this->updateTotal();
            AlertHelper::success('Berhasil', 'Pembayaran berhasil dihapus.');
        } else {
            AlertHelper::error('Gagal', 'Pembayaran tidak ditemukan.');
        }
    }

    public function updatedPaymentAmount()
    {
        $this->updatePaymentSinglePayment();
    }

    public function updatePaymentSinglePayment()
    {
        $payment_amount = intval(preg_replace('/[^0-9]/', '', strval($this->payment_amount)));
        $this->payment_amount = number_format($payment_amount, 0, ',', '.');
        if ($this->is_single_payment) {
            $paymentMethod = PaymentMethod::find($this->payment_method_id);
            if ($paymentMethod->type_admin_fee == 'percentage') {
                $this->admin_fee = number_format($payment_amount ? $payment_amount * ($paymentMethod->percentage / 100) : 0, 0, ',', '.');
            } else {
                $this->admin_fee = number_format($payment_amount ? $paymentMethod->value_admin_fee : 0, 0, ',', '.');
            }
        } else {
            $this->admin_fee = 0;
        }
    }

    public function getInstallmentBreakdownProperty()
    {
        if (! $this->is_pending_payment || ! $this->installment_count || ! $this->installment_period) {
            return [];
        }

        $grandTotal = (float) ($this->transaction->grand_total_price ?? 0);
        $totalPaid = 0;

        // Count payments already in database for this transaction
        if ($this->transaction && $this->transaction->id) {
            $totalPaid = (float) $this->transaction->transactionPayments()->where('is_down_payment', true)->sum('payment_amount');
        }

        $remaining = max(0, $grandTotal - $totalPaid);

        if ($remaining <= 0 || $this->installment_count <= 0) {
            return [];
        }

        $amountPerTenor = floor($remaining / $this->installment_count);
        $breakdown = [];
        $currentDate = now();

        for ($i = 1; $i <= $this->installment_count; $i++) {
            if ($this->installment_period === 'weekly') {
                $currentDate = $currentDate->copy()->addWeek();
            } elseif ($this->installment_period === 'monthly') {
                $currentDate = $currentDate->copy()->addMonth();
            }

            // Adjust last installment to cover rounding
            $currentAmount = ($i == $this->installment_count)
                ? $remaining - ($amountPerTenor * ($this->installment_count - 1))
                : $amountPerTenor;

            $breakdown[] = [
                'tenor' => $i,
                'date' => $currentDate->format('d/m/Y'),
                'amount' => $currentAmount,
            ];
        }

        return $breakdown;
    }

    public function render()
    {
        $products = Product::search($this->searchProduct)
            ->select('id', 'sku_number', 'name', 'description', 'company_id')
            // ->whereHas('productType', function ($query) {
            //     $query->where('name', 'Obat'); // atau 'Supporting Product' sesuai isi database
            // })
            ->with('company:id,name', 'productStock:id,product_id,quantity,quantity_lock', 'productPrice:id,product_id,price,recipe', 'productType:id,name')
            ->where('company_id', Auth::user()->company_id);
        $paymentMethod = PaymentMethod::where('company_id', Auth::user()->company_id);

        if ($this->transaction->transactionPayments()->where('is_single_payment', false)->exists()) {
            $paymentMethod->where('is_single_payment', false);
        }

        return view('livewire.admin.sale.pos.recipe.admin-sale-pos-recipe-index-new', [
            'products' => $products->orderBy('name', 'asc')->paginate($this->perPage),
            'paymentMethods' => $paymentMethod->orderBy('name', 'asc')->get(),
            'transactionPayments' => TransactionPayment::where('transaction_id', $this->transaction_id)
                ->orderBy('created_at', 'desc')
                ->get(),
            'availablePromotions' => $this->getAvailablePromotions(),
            'promotionSummary' => $this->getPromotionSummary(),
        ])
            ->extends('layout.pos.app')
            ->section('content');
    }

    /**
     * Get available discount promotions for dropdown
     */
    public function getAvailablePromotions()
    {
        $promotionService = new PromotionSimplifiedService;

        return $promotionService->getAvailableDiscountPromotions(
            Auth::user()->company_id,
            $this->transaction->user_type_id,
        );
    }

    /**
     * Get promotion summary for display
     */
    public function getPromotionSummary()
    {
        if (! $this->promotion_simplified_id || ! $this->transaction) {
            return null;
        }

        $promotionService = new PromotionSimplifiedService;

        return $promotionService->getPromotionSummary(
            $this->promotion_simplified_id,
            $this->transaction->sub_total_price,
            Auth::user()->company_id,
            $this->transaction->user_type_id,
        );
    }

    public function applyBuyXGetYPromotions()
    {
        try {
            $buyXGetYService = new BuyXGetYService;
            $result = $buyXGetYService->applyBuyXGetYPromotions($this->transaction_id, Auth::user()->company_id);

            if ($result['success'] && ! empty($result['applied_promotions'])) {
                $promotionMessages = [];
                foreach ($result['applied_promotions'] as $promotion) {
                    $promotionMessages[] = $promotion['message'];
                }

                if (! empty($promotionMessages)) {
                    AlertHelper::success('Promosi Diterapkan!', implode('. ', $promotionMessages));
                }
            }
        } catch (\Exception $e) {
            Log::error('Error applying Buy X Get Y promotions: '.$e->getMessage(), [
                'transaction_id' => $this->transaction_id,
                'trace' => $e->getTraceAsString(),
            ]);
        }
    }

    public function updatedPromotionSimplifiedId()
    {
        // Prevent promotion changes when deposit is present
        if ($this->has_deposit) {
            $this->promotion_simplified_id = null;
            AlertHelper::warning('Peringatan', 'Promosi tidak dapat digunakan bersamaan dengan deposit. Diskon deposit sudah diterapkan otomatis.');

            return;
        }

        // Apply promotion to transaction
        $transaction = Transaction::find($this->transaction_id);
        if ($transaction) {
            $promotionService = new PromotionSimplifiedService;
            $promotionService->applyPromotionToTransaction($transaction, $this->promotion_simplified_id);
        }
        $this->updateTotal();
    }

    /**
     * Helper function to safely parse numeric values from formatted strings
     */
    private function parseNumericValue($value, $isFloat = false)
    {
        if (is_null($value) || $value === '') {
            return 0;
        }

        // Convert to string
        $value = (string) $value;

        // Jika ada koma dan titik, asumsikan titik = ribuan, koma = desimal
        if (strpos($value, ',') !== false && strpos($value, '.') !== false) {
            $value = str_replace('.', '', $value); // hapus pemisah ribuan
            $value = str_replace(',', '.', $value); // ubah desimal ke dot
        }
        // Jika hanya ada koma → anggap itu desimal
        elseif (strpos($value, ',') !== false) {
            $value = str_replace(',', '.', $value);
        }
        // Jika hanya ada titik → biarkan

        // ✅ pastikan konversi ke float dulu
        $numericValue = floatval($value);

        return $isFloat ? $numericValue : (int) ceil($numericValue);
    }

    /**
     * Helper function to safely parse float values
     */
    private function parseFloatValue($value)
    {
        return $this->parseNumericValue($value, true);
    }

    /**
     * Helper function to safely parse integer values
     */
    private function parseIntValue($value)
    {
        return $this->parseNumericValue($value, false);
    }

    private function saveTransactionInstallments($transaction)
    {
        // Delete existing installments if any (re-saving)
        $transaction->transactionInstallments()->delete();

        $breakdown = $this->installment_breakdown;

        foreach ($breakdown as $item) {
            TransactionInstallment::create([
                'transaction_id' => $transaction->id,
                'tenor' => $item['tenor'],
                'due_date' => \Carbon\Carbon::createFromFormat('d/m/Y', $item['date'])->format('Y-m-d'),
                'amount' => $item['amount'],
                'status' => 'unpaid',
            ]);
        }
    }
}
