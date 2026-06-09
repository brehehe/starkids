<?php

namespace App\Livewire\Admin\Pharmacy\Sale\Detail;

use App\Helpers\AlertHelper;
use App\Models\Branch\Branch;
use App\Models\Company\Company;
use App\Models\PaymentMethod\PaymentMethod;
use App\Models\Product\Product;
use App\Models\Product\ProductPrice;
use App\Models\Product\ProductStock;
use App\Models\Transaction\Transaction;
use App\Models\Transaction\TransactionDetail;
use App\Models\Transaction\TransactionPayment;
use App\Models\Transaction\TransactionProduct;
use App\Models\Transaction\TransactionRecipe;
use App\Models\User;
use App\Services\Product\ProductService;
use App\Services\Product\syncQuantityLockService;
use App\Services\Promotion\PromotionSimplifiedService;
use App\Traits\Product\ProductTrait;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;
use Livewire\Component;
use Illuminate\Support\Str;
use Livewire\WithPagination;

class AdminPharmacySaleDetailIndex extends Component
{
    use ProductTrait, WithPagination;
    protected $queryString = [
        'pageProduct' => ['except' => 1], // Ini akan menghapus ?pageProduct=1 dari URL
        'searchProduct' => ['except' => ''],
    ];
    public $searchProduct = '';
    public $perPageProduct = 5;
    public $transaction_id, $transaction;
    public $search_sku;
    public $transaction_details = [], $discount, $discount_type;
    public $payment_method_id, $payment_amount, $is_single_payment, $admin_fee, $description, $is_narcotic, $user_asign_narcotic_id, $product_id, $product_name, $barcode, $username_or_email, $password;
    public $diagnosas, $immunization;
    public $promotion_simplified_id;
    private $validStatuses = [
        'draft_consultation',
        'waiting_consultation',
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
                if ($transaction->type == 'resep') {
                    return redirect()->route('user.pharmacy.sale.recipe');
                }

                $this->transaction = $transaction;
                $this->transaction_id = $transaction_id;
                $this->discount_type = $transaction->discount_type ?? 'rupiah';
                $this->discount = $this->discount_type == 'rupiah' ? number_format($transaction->discount, 0, ',', '.') : Str::replace(',', '.', $transaction->discount);
                $this->promotion_simplified_id = $transaction->promotion_simplified_id;
                $this->diagnosas = $transaction->diagnosas ?? '';
                $this->immunization = $transaction->immunization ?? '';

                $this->details();
            } else {
                return redirect()->route('user.pharmacy.sale');
            }
        } else {
            return redirect()->route('user.pharmacy.sale');
        }
    }

    public function updatedPromotionSimplifiedId()
    {
        // Apply promotion to transaction
        $transaction = Transaction::find($this->transaction_id);
        if ($transaction) {
            $promotionService = new PromotionSimplifiedService();
            $promotionService->applyPromotionToTransaction($transaction, $this->promotion_simplified_id);
        }
        $this->updateTotal();
    }

    public function updatedDiscountType()
    {
        $this->discount = 0;
        $this->updateTotal();
    }

    public function updatedDiscount()
    {
        if ($this->discount_type == 'percentage') {
            $discount = Str::replace(',', '.', $this->discount);
            $this->discount = $discount <= 0 ? 0 : ($discount > 100 ? 100 : $discount);
        } else {
            $this->discount = intval(str_replace('.', '', $this->discount));
        }

        $this->updateTotal();
    }

    public function updatedSearchSku()
    {
        $this->search_sku = ltrim($this->search_sku);
        $this->choiceProductChange();
    }

    public function choiceProductChange()
    {
        // Check if search_sku contains a space (format: "SKU NAME")
        if (strpos($this->search_sku, ' ') !== false) {
            $parts = explode(' ', $this->search_sku, 2);
            $sku = $parts[0];
            $name = $parts[1] ?? '';
            $product = Product::where('sku_number', $sku)->where('name', $name)->first();
        } else {
            $product = Product::where('sku_number', $this->search_sku)->first();
        }

        if ($product) {

            $productStock = ProductStock::where('product_id', $product->id)
                ->where('company_id', auth()->user()->company_id)
                ->where('branch_id', Branch::where('company_id', auth()->user()->company_id)->first()->id)
                ->first();


            if (!$product->is_non_stock) {
                if (!$productStock || $productStock->quantity <= 0) {
                    return AlertHelper::error('Gagal', 'Stok produk tidak ditemukan atau stok kosong.');
                }
            }

            $productPrice = ProductPrice::where('product_id', $product->id)
                ->where('company_id', auth()->user()->company_id)
                ->where('branch_id', Branch::where('company_id', auth()->user()->company_id)->first()->id)
                ->where('is_updated', true)
                ->first();

            if (!$productPrice) {
                return AlertHelper::error('Gagal', 'Harga produk tidak ditemukan.');
            }

            $transactionItem = TransactionDetail::where('transaction_id', $this->transaction_id)
                ->where('product_id', $product->id)
                ->whereNull('transaction_detail_id') // Only main items, not free items
                ->first();

            if ($transactionItem) {
                // Check stock availability before incrementing
                if (!$product->is_non_stock) {
                    // Calculate locked stock excluding current transaction detail
                    $lockedStock = TransactionDetail::where('product_id', $product->id)
                        ->whereHas('transaction', fn($query) => $query->whereIn('status', $this->validStatuses))
                        ->where('id', '!=', $transactionItem->id) // Exclude current transaction detail
                        ->sum('quantity');

                    $lockedStockRecipe = TransactionRecipe::where('product_id', $product->id)
                        ->whereHas('transaction', fn($query) => $query->whereIn('status', $this->validStatuses))
                        ->where('id', '!=', $transactionItem->id) // Exclude current transaction detail
                        ->sum('quantity');

                    $availableStock = $productStock->quantity - $lockedStock - $lockedStockRecipe;
                    $requestedQuantity = $transactionItem->quantity + 1;

                    if ($requestedQuantity > $availableStock) {
                        return AlertHelper::error(
                            'Gagal',
                            "Stok produk '{$product->name}' tidak mencukupi. Tersedia: {$availableStock}, Diminta: {$requestedQuantity}."
                        );
                    }
                }

                $transactionItem->increment('quantity', 1);
                $transactionItem->price = $productPrice->price;
                $transactionItem->price_discount = $productPrice->price_discount ?? 0;
                $transactionItem->sub_total_price = $transactionItem->price * $transactionItem->quantity;

                $transactionItem->save();
            } else {
                // Check stock availability for new item
                if (!$product->is_non_stock) {
                    $lockedStock = TransactionDetail::where('product_id', $product->id)
                        ->whereHas('transaction', fn($query) => $query->whereIn('status', $this->validStatuses))
                        ->sum('quantity');

                    $lockedStockRecipe = TransactionRecipe::where('product_id', $product->id)
                        ->whereHas('transaction', fn($query) => $query->whereIn('status', $this->validStatuses))
                        ->sum('quantity');

                    $availableStock = $productStock->quantity - $lockedStock - $lockedStockRecipe;

                    if (1 > $availableStock) {
                        return AlertHelper::error(
                            'Gagal',
                            "Stok produk '{$product->name}' tidak mencukupi. Tersedia: {$availableStock}, Diminta: 1."
                        );
                    }
                }

                if ($product->is_narcotic) {
                    if (!$this->user_asign_narcotic_id) {
                        $this->is_narcotic = true;
                        $this->product_id = $product->id;
                        $this->product_name = $product->name;

                        $this->dispatch('close-modal', ['id' => 'modalProduct']);
                        return $this->dispatch('open-modal', ['id' => 'modalNarcotic']);
                    }
                }

                TransactionDetail::create([
                    'transaction_id' => $this->transaction_id,
                    'product_id' => $product->id,
                    'quantity' => 1,
                    'price' => $productPrice->price,
                    'price_discount' => $productPrice->price_discount ?? 0,
                    'sub_total_price' => $productPrice->price,
                    'is_narcotic' => $this->is_narcotic ?? false,
                    'user_asign_narcotic_id' => $this->user_asign_narcotic_id,
                    'type_transaction' => 'medicine',
                ]);
            }

            // Apply Buy X Get Y promotions after adding/updating product
            $this->applyBuyXGetYPromotions();

            $this->details();
            $this->updateTotal();
            $this->reset('search_sku', 'is_narcotic', 'user_asign_narcotic_id', 'product_id', 'product_name', 'username_or_email', 'password');
            $this->closeModal();
            return AlertHelper::success('Berhasil', 'Produk berhasil ditambahkan ke keranjang.');
        } else {
            $this->reset('search_sku');
            return AlertHelper::error('Gagal', 'Produk tidak ditemukan.');
        }
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

        if (!$company) {
            return AlertHelper::error('Error', 'Perusahaan tidak ditemukan.');
        }

        // Find user with smart identity resolution
        $userResult = $this->findHeadUserWithIdentityResolution($company->id);

        if (!$userResult['success']) {
            return AlertHelper::error('Akses Ditolak', $userResult['message']);
        }

        $user = $userResult['user'];
        $loginMethod = $userResult['login_method'];

        // Check password
        if (!Hash::check($this->password, $user->password)) {
            return AlertHelper::error('Akses Ditolak', 'Password salah. Silakan periksa kembali atau hubungi administrator perusahaan.');
        }

        // Check if user is head in this company
        $isHead = $user->companyRoles()
            ->where('company_id', $company->id)
            ->where('is_head', true)
            ->where('is_active', true)
            ->exists();

        if (!$isHead) {
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
                'message' => 'Found via main fields'
            ];
        }

        // Strategy 2: Find by alternative contacts - Employee only
        $altUser = $this->findHeadByAlternativeContacts($identifier, $companyId);
        if ($altUser) {
            return [
                'success' => true,
                'user' => $altUser['user'],
                'login_method' => $altUser['method'],
                'message' => 'Found via alternative contacts'
            ];
        }

        // Strategy 3: Handle email sama tapi beda phone case - Employee only
        $conflictUser = $this->handleHeadEmailPhoneConflict($identifier, $companyId);
        if ($conflictUser) {
            return [
                'success' => true,
                'user' => $conflictUser['user'],
                'login_method' => $conflictUser['method'],
                'message' => 'Resolved identity conflict'
            ];
        }

        return [
            'success' => false,
            'user' => null,
            'login_method' => null,
            'message' => 'Username atau email tidak ditemukan, atau Anda bukan supervisor di perusahaan ini.'
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
                    'method' => $method
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
                return ($contact['value'] === $identifier && $contact['context'] == $companyId);
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
                    'method' => 'alternative_' . $contactType
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
        if (!filter_var($identifier, FILTER_VALIDATE_EMAIL)) {
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
                    'method' => 'email'
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
            'timestamp' => now()
        ]);
    }

    public function updatedTransactionDetails()
    {
        $branchId = Branch::where('company_id', auth()->user()->company_id)->first()?->id;

        foreach ($this->transaction_details as $key => $value) {
            if (empty($value['product_id'])) {
                continue;
            }

            $product = Product::find($value['product_id']);

            // Validasi quantity minimal
            if ($value['quantity'] <= 0) {
                $this->transaction_details[$key]['quantity'] = 1;
                AlertHelper::error('Gagal', 'Jumlah produk tidak boleh kurang dari 1.');
                continue;
            }

            if (!$product) {
                AlertHelper::error('Gagal', 'Produk tidak ditemukan.');
                continue;
            }

            if (!$product->is_non_stock) {
                $productStock = ProductStock::where('product_id', $product->id)
                    ->where('company_id', auth()->user()->company_id)
                    ->where('branch_id', $branchId)
                    ->first();

                if (!$productStock) {
                    $this->transaction_details[$key]['quantity'] = 1;
                    AlertHelper::error('Gagal', "Stok untuk produk {$product->name} tidak ditemukan.");
                    continue;
                }

                $inputQuantity = intval($value['quantity'] ?? 1); // Ambil dari Livewire input

                $currentTransactionDetail = TransactionDetail::find($value['id']);

                $productId = $currentTransactionDetail->product_id ?? $product->id;

                // Hitung locked stock dari transaksi aktif lainnya
                $lockedStock = TransactionDetail::where('product_id', $productId)
                    ->whereHas('transaction', fn($query) => $query->whereIn('status', $this->validStatuses))
                    ->when(
                        $currentTransactionDetail,
                        fn($query) =>
                        $query->where('id', '!=', $currentTransactionDetail->id)
                    )
                    ->sum('quantity');

                // Hitung locked stock dari resep aktif
                $lockedStockRecipe = TransactionRecipe::where('product_id', $productId)
                    ->whereHas('transaction', fn($query) => $query->whereIn('status', $this->validStatuses))
                    ->sum('quantity');

                // Hitung stok tersedia
                $available = $productStock->quantity - $lockedStock - $lockedStockRecipe;

                // Validasi stok
                if ($inputQuantity > $available) {
                    $this->transaction_details[$key]['quantity'] = $available;

                    if ($currentTransactionDetail) {
                        $currentTransactionDetail->quantity = $available;
                        $currentTransactionDetail->save();
                    }

                    return AlertHelper::error(
                        'Gagal',
                        "Stok produk '{$product->name}' tidak mencukupi. Tersedia: {$available}, Dibutuhkan: {$inputQuantity}."
                    );
                }
            }

            // Proses update ke DB (biarkan Observer handle stok dan sub_total_price)
            $transactionDetail = TransactionDetail::find($value['id']);

            if ($transactionDetail) {
                $transactionDetail->quantity = $this->transaction_details[$key]['quantity'];
                $transactionDetail->price = $value['price'];
                $transactionDetail->price_discount = $value['price_discount'] ?? 0;
                $transactionDetail->save(); // Observer akan hitung ulang sub_total dan update stock
            }
        }

        $this->applyBuyXGetYPromotions();
        $this->details();
        $this->updateTotal();
        $this->closeModal();
    }

    public function details()
    {
        $this->transaction_details = [];

        $transactionDetails = TransactionDetail::where('transaction_id', $this->transaction_id)
            ->with(['product', 'parentDetail'])
            ->orderBy('order', 'asc')
            ->get();

        // Group items by parent-child relationship
        $parentItems = $transactionDetails->where('transaction_detail_id', null);
        $childItems = $transactionDetails->where('transaction_detail_id', '!=', null);

        foreach ($parentItems as $key => $parentDetail) {
            // Add parent item
            $this->transaction_details[] = [
                'id' => $parentDetail->id,
                'product_id' => $parentDetail->product_id,
                'product_name' => $parentDetail->product->name,
                'quantity' => $parentDetail->quantity,
                'price' => $parentDetail->price,
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
                $this->transaction_details[] = [
                    'id' => $childDetail->id,
                    'product_id' => $childDetail->product_id,
                    'product_name' => $childDetail->product->name,
                    'quantity' => $childDetail->quantity,
                    'price' => $childDetail->price,
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

    /**
     * Extract promotion name from item name
     */
    private function extractPromotionFromName($itemName)
    {
        // Extract promotion name from patterns like "PRODUCT NAME (GRATIS - Promotion Name)"
        if (preg_match('/\(GRATIS - (.+)\)/', $itemName, $matches)) {
            return $matches[1];
        }
        return 'Promosi Buy X Get Y';
    }

    public function updateQuantity($transactionDetailId, $quantity)
    {
        // Ambil detail transaksi
        $transactionDetail = TransactionDetail::find($transactionDetailId);

        if (!$transactionDetail) {
            return AlertHelper::error('Gagal', 'Detail transaksi tidak ditemukan.');
        }

        // Check if this is a free item from Buy X Get Y promotion
        if ($transactionDetail->isFreeItem()) {
            return AlertHelper::error('Gagal', 'Item gratis dari promosi tidak dapat diubah secara manual.');
        }

        // Ambil produk terkait
        $product = Product::find($transactionDetail->product_id);
        if (!$product) {
            return AlertHelper::error('Gagal', 'Produk tidak ditemukan.');
        }

        // Ambil branch_id
        $branchId = $transactionDetail->transaction->branch_id
            ?? Branch::where('company_id', auth()->user()->company_id)->first()->id;

        // Ambil stok produk (jika produk adalah stockable)
        $productStock = !$product->is_non_stock
            ? ProductStock::where('product_id', $product->id)
            ->where('company_id', auth()->user()->company_id)
            ->where('branch_id', $branchId)
            ->first()
            : null;

        if (!$product->is_non_stock && !$productStock) {
            return AlertHelper::error('Gagal', 'Stok produk tidak ditemukan.');
        }

        if ($quantity === 'decrement') {
            if ($transactionDetail->quantity <= 1) {
                return AlertHelper::error('Gagal', 'Jumlah produk tidak boleh kurang dari 1.');
            }

            $transactionDetail->decrement('quantity');
        }

        if ($quantity === 'increment') {
            $productId = $currentTransactionDetail->product_id ?? $product->id;

            // Hitung locked stock dari transaksi aktif lainnya
            $lockedStock = TransactionDetail::where('product_id', $productId)
                ->whereHas('transaction', fn($query) => $query->whereIn('status', $this->validStatuses))
                ->when(
                    $transactionDetail,
                    fn($query) =>
                    $query->where('id', '!=', $transactionDetail->id)
                )
                ->sum('quantity');

            // Hitung locked stock dari resep aktif
            $lockedStockRecipe = TransactionRecipe::where('product_id', $productId)
                ->whereHas('transaction', fn($query) => $query->whereIn('status', $this->validStatuses))
                ->sum('quantity');

            // Hitung stok tersedia
            $available = !$product->is_non_stock
                ? $productStock->quantity - $lockedStock - $lockedStockRecipe
                : PHP_INT_MAX;

            $requestedQty = $transactionDetail->quantity + 1; // Quantity after increment

            if ($available >= $requestedQty) {
                $transactionDetail->increment('quantity');
            } else {
                $transactionDetail->quantity = $available; // Set to max available
                AlertHelper::error(
                    'Gagal',
                    "Stok produk '{$product->name}' tidak mencukupi. Tersedia: {$available}, Diminta: {$requestedQty}."
                );
                return;
            }
        }

        // Hitung ulang subtotal
        $transactionDetail->sub_total_price = $transactionDetail->price * $transactionDetail->quantity;
        $transactionDetail->save();

        // Apply Buy X Get Y promotions with automatic consolidation after quantity change
        $this->applyBuyXGetYPromotions();

        // Update ulang tampilan Livewire
        $this->details();
        $this->updateTotal();
    }

    private function getLockedQtyExcept($transactionDetail)
    {
        $validStatuses = [
            'draft_consultation',
            'call_consultation',
            'confirmation_call',
            'consultation',
            'pharmacy',
            'call_pharmacy',
            'sale_pharmacy',
            'draft',
            'process'
        ];

        return TransactionDetail::whereHas('transaction', function ($q) use ($validStatuses, $transactionDetail) {
            $q->whereIn('status', $validStatuses)
                ->where('branch_id', $transactionDetail->transaction->branch_id);
        })
            ->where('product_id', $transactionDetail->product_id)
            ->where('id', '!=', $transactionDetail->id) // exclude current baris
            ->sum('quantity');
    }

    public function confirmSaveTransaction($type)
    {
        $saveFunction = $type == 'draft' ? 'saveDraft' : ($type == 'process' ? 'saveTransaction' : 'saveSuccessTransaction');

        return AlertHelper::confirmSave($saveFunction, "Apakah Anda yakin ingin menyimpan transaksi " . Str::title($type) . " ini?");
    }

    public function saveDraft()
    {
        $transaction = Transaction::find($this->transaction_id);

        if ($transaction) {
            $transaction->status = 'draft';
            $transaction->diagnosas = $this->diagnosas;
            $transaction->immunization = $this->immunization;
            $transaction->save();

            AlertHelper::success('Berhasil', 'Transaksi berhasil disimpan sebagai draft.');
            return redirect()->route('user.pharmacy.sale');
        } else {
            AlertHelper::error('Gagal', 'Transaksi tidak ditemukan.');
            return redirect()->route('user.pharmacy.sale');
        }
    }

    public function saveTransaction()
    {
        $transaction = Transaction::find($this->transaction_id);
        $branchId = Branch::where('company_id', Auth::user()->company_id)->first()?->id;

        if (!$transaction) {
            return AlertHelper::error('Gagal', 'Transaksi tidak ditemukan.');
        }

        foreach ($transaction->transactionDetails as $detail) {
            if (!$detail->product_id) {
                continue;
            }

            $product = Product::find($detail->product_id);
            if (!$product || $product->is_non_stock) {
                continue;
            }

            $productStock = ProductStock::where('product_id', $detail->product_id)
                ->where('company_id', Auth::user()->company_id)
                ->where('branch_id', $branchId)
                ->first();

            if (!$productStock) {
                return AlertHelper::error('Gagal', "Stok tidak ditemukan untuk produk '{$product->name}'.");
            }

            $inputQuantity = intval($detail->quantity ?? 1); // Ambil dari Livewire input

            $productId = $detail->product_id ?? $product->id;

            // Hitung locked stock dari transaksi aktif lainnya
            $lockedStock = TransactionDetail::where('product_id', $productId)
                ->whereHas('transaction', fn($query) => $query->whereIn('status', $this->validStatuses))
                ->when(
                    $detail,
                    fn($query) =>
                    $query->where('id', '!=', $detail->id)
                )
                ->sum('quantity');

            // Hitung locked stock dari resep aktif
            $lockedStockRecipe = TransactionRecipe::where('product_id', $productId)
                ->whereHas('transaction', fn($query) => $query->whereIn('status', $this->validStatuses))
                ->sum('quantity');

            // Hitung stok tersedia
            $available = $productStock->quantity - $lockedStock - $lockedStockRecipe;

            // Validasi stok
            if ($inputQuantity > $available) {
                if ($detail) {
                    $detail->quantity = $available;
                    $detail->save();
                }

                return AlertHelper::error(
                    'Gagal',
                    "Stok produk '{$product->name}' tidak mencukupi. Tersedia: {$available}, Dibutuhkan: {$inputQuantity}."
                );
            }
        }

        $transaction->status = 'process';
        $transaction->save();

        session()->flash('saved', [
            'title' => 'Transaksi Berhasil!',
            'text' => 'Anda berhasil menyimpan transaksi sebagai proses.',
        ]);
        return redirect()->route('user.pharmacy.sale');
    }

    public function saveSuccessTransaction()
    {
        try {
            $transaction = Transaction::find($this->transaction_id);

            if (!$transaction) {
                return AlertHelper::error('Gagal', 'Transaksi tidak ditemukan.');
            }

            if ($transaction->transactionDetails()->count() <= 0) {
                return AlertHelper::error('Gagal', 'Transaksi tidak dapat disimpan, karena tidak ada item yang ditambahkan.');
            }

            if ((float) $transaction->remaining_bill > 0) {
                return AlertHelper::error('Gagal', 'Transaksi tidak dapat disimpan, karena masih ada sisa tagihan.');
            }

            DB::beginTransaction();

            $branchId = Branch::where('company_id', Auth::user()->company_id)->first()?->id;

            foreach ($transaction->transactionDetails as $detail) {
                $product = Product::find($detail->product_id);

                if (!$product || $product->is_non_stock) {
                    continue; // Tidak perlu validasi stok
                }

                $productStock = ProductStock::where('product_id', $detail->product_id)
                    ->where('company_id', Auth::user()->company_id)
                    ->where('branch_id', $branchId)
                    ->first();

                if (!$productStock) {
                    return AlertHelper::error('Gagal', "Stok tidak ditemukan untuk produk '{$product->name}'.");
                }

                $lockedStock = TransactionDetail::where('product_id', $detail->product_id)
                    ->whereHas('transaction', fn($query) => $query->whereIn('status', $this->validStatuses))
                    ->where('id', '!=', $detail->id) // Exclude current transaction detail
                    ->sum('quantity');

                $lockedStockRecipe = TransactionRecipe::where('product_id', $detail->product_id)
                    ->whereHas('transaction', fn($query) => $query->whereIn('status', $this->validStatuses))
                    ->where('id', '!=', $detail->id) // Exclude current transaction detail
                    ->sum('quantity');

                $availableStock = $productStock->quantity - $lockedStock - $lockedStockRecipe;

                if ($detail->quantity > $availableStock) {
                    return AlertHelper::error(
                        'Gagal',
                        "Stok produk '{$product->name}' tidak mencukupi. Tersedia: {$availableStock}, Dibutuhkan: {$detail->quantity}."
                    );
                }
            }

            // Proses pembayaran
            $this->processTransactionPayments($transaction);

            $productType = ProductType::where('type', 'take')->get()->pluck('id')->toArray();

            $product = Product::where('product_type_id', $productType)
                ->where('company_id', Auth::user()->company_id)
                ->get()
                ->pluck('id')
                ->toArray();

            $hasMedicine = TransactionDetail::whereIn('product_id', $product)->where('transaction_id', $this->transaction_id)
                ->exists();

            $transaction->update([
                'status' => $hasMedicine ? 'take_medicine' : 'completed',
                'is_take_medicine' => $hasMedicine,
                'cashier_id' => Auth::user()->id,
                'cashier_name' => Auth::user()->name,
                'diagnosas' => $this->diagnosas,
                'immunization' => $this->immunization,
            ]);

            DB::commit();

            session()->flash('saved', [
                'title' => 'Transaksi Berhasil!',
                'text' => 'Anda berhasil menyimpan transaksi!',
            ]);

            return redirect()->route('user.pharmacy.sale');
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            DB::rollBack();
            Log::error('Model tidak ditemukan: ' . $e->getMessage(), [
                'transaction_id' => $this->transaction_id,
                'user_id' => Auth::id()
            ]);
            return AlertHelper::error('Gagal', 'Data yang diperlukan tidak ditemukan.');
        } catch (\Illuminate\Database\QueryException $e) {
            DB::rollBack();
            Log::error('Database error: ' . $e->getMessage(), [
                'transaction_id' => $this->transaction_id,
                'user_id' => Auth::id(),
                'sql' => $e->getSql()
            ]);
            return AlertHelper::error('Gagal', 'Terjadi kesalahan database. Silakan coba lagi.');
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Transaction error: ' . $e->getMessage(), [
                'transaction_id' => $this->transaction_id,
                'user_id' => Auth::id(),
                'trace' => $e->getTraceAsString()
            ]);
            return AlertHelper::error('Gagal', 'Terjadi kesalahan saat menyimpan transaksi: ' . $e->getMessage());
        } catch (\Throwable $e) {
            DB::rollBack();
            Log::critical('Critical error in saveSuccessTransaction: ' . $e->getMessage(), [
                'transaction_id' => $this->transaction_id,
                'user_id' => Auth::id(),
                'trace' => $e->getTraceAsString()
            ]);
            return AlertHelper::error('Gagal', 'Terjadi kesalahan sistem. Silakan hubungi administrator.');
        }
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

    public function updateTotal()
    {
        $transaction = Transaction::find($this->transaction_id);

        if ($transaction) {
            $total = TransactionDetail::where('transaction_id', $this->transaction_id)
                ->sum('sub_total_price');

            $transaction->sub_total_price = $total;

            // Set sub_total_price_before_rounding
            $total = $transaction->sub_total_price_before_rounding = $total;

            // Validasi promotion simplified berdasarkan minimum_purchase dan max_discount
            if ($this->promotion_simplified_id) {
                $promotionService = new PromotionSimplifiedService();
                $promotionResult = $promotionService->calculatePromotionDiscount($this->promotion_simplified_id, $total);

                // Jika promotion tidak eligible (kurang dari minimum_purchase atau max_discount), hapus promotion
                if (!$promotionResult['eligible']) {
                    // Simpan nama promotion untuk notifikasi sebelum dihapus
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

                    // Berikan notifikasi kepada user
                    AlertHelper::warning(
                        'Peringatan',
                        "Promosi '{$promotionName}' tidak memenuhi syarat. Total transaksi kurang dari minimum pembelian atau diskon melebihi batas maksimum."
                    );
                }
            }

            // Hitung grand total dengan urutan pengurangan yang benar
            // 1. Mulai dari subtotal
            $grandTotal = $total;

            // 2. Kurangi promotion discount terlebih dahulu
            $totalPromotionDiscount = $transaction->promotion_real ?? 0;
            $grandTotal = $grandTotal - $totalPromotionDiscount;

            // 3. Hitung manual discount berdasarkan sisa setelah promotion
            $amountAfterPromotion = $grandTotal;

            if ($amountAfterPromotion >= 1) {
                if ($this->discount_type == 'percentage') {
                    $transaction->discount = Str::replace(',', '.', $this->discount);
                    $transaction->discount_value = ($amountAfterPromotion * $transaction->discount) / 100;
                } else {
                    $discount = intval(str_replace('.', '', $this->discount));
                    $discount = $amountAfterPromotion < $discount ? $amountAfterPromotion : $discount;
                    $transaction->discount = $discount;
                    $transaction->discount_value = $discount;
                }
            } else {
                $transaction->discount = 0;
                $transaction->discount_type = 'rupiah';
                $transaction->discount_value = 0;
            }

            $this->discount = $this->discount_type == 'rupiah'
                ? number_format($transaction->discount, 0, ',', '.')
                : Str::replace(',', '.', $this->discount);

            $transaction->discount_type = $this->discount_type;

            // 4. Kemudian kurangi manual discount dari hasil setelah promotion
            $totalManualDiscount = $transaction->discount_value ?? 0;

            // Pastikan manual discount tidak melebihi sisa amount setelah promotion
            if ($totalManualDiscount > $grandTotal) {
                $totalManualDiscount = $grandTotal;
                $transaction->discount_value = $totalManualDiscount;
            }

            $grandTotal = $grandTotal - $totalManualDiscount;

            // Pembulatan
            $rounding = 0;
            $roundedTotal = 0;
            $remainder = 0;

            if ($grandTotal <= 0) {
                $roundedTotal = 0;
                $rounding = -$grandTotal;
                $remainder = 0;
            } else {
                $remainder = $grandTotal % 1000;

                if ($remainder < 500) {
                    $roundedTotal = $grandTotal - $remainder + 500;
                    $rounding = 500 - $remainder;
                } else {
                    $roundedTotal = $grandTotal - $remainder + 1000;
                    $rounding = 1000 - $remainder;
                }
            }

            $transaction->rounding = $rounding;
            $transaction->grand_total_price = $roundedTotal;
            $transaction->rounding_remainder = $remainder; // ✅ disimpan di field baru
            $transaction->payment_amount = $transaction->transactionPayments()->sum('payment_amount');
            $transaction->payment_change = $transaction->payment_amount < $transaction->grand_total_price ? 0 : $transaction->payment_amount - $transaction->grand_total_price;
            $transaction->remaining_bill = $transaction->grand_total_price - $transaction->payment_amount;
            $transaction->remaining_bill = $transaction->remaining_bill < 0 ? 0 : $transaction->remaining_bill;
            $transaction->grand_total_price_admin_fee = $transaction->grand_total_price + $transaction->single_payment_admin_fee;
            $transaction->save();
            $this->reset('transaction');
            $this->transaction = $transaction;
        }
    }

    public function confirmDeleteTransactionDetail($transactionDetailId)
    {
        return AlertHelper::confirmDelete('deleteTransactionDetail', 'Apakah Anda yakin ingin menghapus item ini?', $transactionDetailId);
    }

    public function deleteTransactionDetail($transactionDetailId)
    {
        $transactionDetail = TransactionDetail::find($transactionDetailId[0]);

        if ($transactionDetail) {
            // Check if this is a free item from Buy X Get Y promotion
            if ($transactionDetail->price == 0 && $transactionDetail->transaction_detail_id) {
                AlertHelper::warning('Peringatan', 'Item gratis dari promosi akan dihapus otomatis jika item utama dihapus.');
            }

            // If this is a main item, also delete its child items (free items)
            if (!$transactionDetail->transaction_detail_id) {
                $childItems = TransactionDetail::where('transaction_detail_id', $transactionDetail->id)->get();
                foreach ($childItems as $childItem) {
                    $childItem->delete();
                }

                if ($childItems->count() > 0) {
                    AlertHelper::info('Info', "Item gratis terkait ({$childItems->count()} item) telah dihapus otomatis.");
                }
            }

            $transactionDetail->delete();

            // Re-apply Buy X Get Y promotions to adjust remaining free items
            $this->applyBuyXGetYPromotions();

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
        $this->reset(['searchProduct']);
        $this->resetPage('pageProduct');
        $this->dispatch('close-modal', ['id' => 'modalProduct']);
    }

    public function getProduct($product_id)
    {
        $product = Product::find($product_id);
        if ($product) {

            $productStock = ProductStock::where('product_id', $product->id)
                ->where('company_id', auth()->user()->company_id)
                ->where('branch_id', Branch::where('company_id', auth()->user()->company_id)->first()->id)
                ->first();


            if (!$product->is_non_stock) {
                if (!$productStock || $productStock->quantity <= 0) {
                    return AlertHelper::error('Gagal', 'Stok produk tidak ditemukan atau stok kosong.');
                }
            }

            $productPrice = ProductPrice::where('product_id', $product->id)
                ->where('company_id', auth()->user()->company_id)
                ->where('branch_id', Branch::where('company_id', auth()->user()->company_id)->first()->id)
                ->where('is_updated', true)
                ->first();

            if (!$productPrice) {
                return AlertHelper::error('Gagal', 'Harga produk tidak ditemukan.');
            }

            $transactionItem = TransactionDetail::where('transaction_id', $this->transaction_id)
                ->where('product_id', $product->id)
                ->whereNull('transaction_detail_id') // Only main items, not free items
                ->first();

            if ($transactionItem) {
                // Check stock availability before incrementing
                if (!$product->is_non_stock) {
                    // Calculate locked stock excluding current transaction detail
                    $lockedStock = TransactionDetail::where('product_id', $product->id)
                        ->whereHas('transaction', fn($query) => $query->whereIn('status', $this->validStatuses))
                        ->where('id', '!=', $transactionItem->id) // Exclude current transaction detail
                        ->sum('quantity');

                    $lockedStockRecipe = TransactionRecipe::where('product_id', $product->id)
                        ->whereHas('transaction', fn($query) => $query->whereIn('status', $this->validStatuses))
                        ->where('id', '!=', $transactionItem->id) // Exclude current transaction detail
                        ->sum('quantity');

                    $availableStock = $productStock->quantity - $lockedStock - $lockedStockRecipe;
                    $requestedQuantity = $transactionItem->quantity + 1;

                    if ($requestedQuantity > $availableStock) {
                        return AlertHelper::error(
                            'Gagal',
                            "Stok produk '{$product->name}' tidak mencukupi. Tersedia: {$availableStock}, Diminta: {$requestedQuantity}."
                        );
                    }
                }

                $transactionItem->increment('quantity', 1);
                $transactionItem->price = $productPrice->price;
                $transactionItem->price_discount = $productPrice->price_discount ?? 0;
                $transactionItem->sub_total_price = $transactionItem->price * $transactionItem->quantity;

                $transactionItem->save();
            } else {
                // Check stock availability for new item
                if (!$product->is_non_stock) {
                    $lockedStock = TransactionDetail::where('product_id', $product->id)
                        ->whereHas('transaction', fn($query) => $query->whereIn('status', $this->validStatuses))
                        ->sum('quantity');

                    $lockedStockRecipe = TransactionRecipe::where('product_id', $product->id)
                        ->whereHas('transaction', fn($query) => $query->whereIn('status', $this->validStatuses))
                        ->sum('quantity');

                    $availableStock = $productStock->quantity - $lockedStock - $lockedStockRecipe;

                    if (1 > $availableStock) {
                        return AlertHelper::error(
                            'Gagal',
                            "Stok produk '{$product->name}' tidak mencukupi. Tersedia: {$availableStock}, Diminta: 1."
                        );
                    }
                }

                if ($product->is_narcotic) {
                    if (!$this->user_asign_narcotic_id) {
                        $this->is_narcotic = true;
                        $this->product_id = $product->id;
                        $this->product_name = $product->name;

                        $this->dispatch('close-modal', ['id' => 'modalProduct']);
                        return $this->dispatch('open-modal', ['id' => 'modalNarcotic']);
                    }
                }

                TransactionDetail::create([
                    'transaction_id' => $this->transaction_id,
                    'product_id' => $product->id,
                    'quantity' => 1,
                    'price' => $productPrice->price,
                    'price_discount' => $productPrice->price_discount ?? 0,
                    'sub_total_price' => $productPrice->price,
                    'is_narcotic' => $this->is_narcotic ?? false,
                    'user_asign_narcotic_id' => $this->user_asign_narcotic_id,
                    'type_transaction' => 'medicine',
                ]);
            }

            // Apply Buy X Get Y promotions after adding product
            $this->applyBuyXGetYPromotions();

            $this->details();
            $this->updateTotal();
            $this->reset('search_sku', 'is_narcotic', 'user_asign_narcotic_id', 'product_id', 'product_name', 'username_or_email', 'password');
            $this->closeModal();
            return AlertHelper::success('Berhasil', 'Produk berhasil ditambahkan ke keranjang.');
        } else {
            $this->reset('search_sku');
            return AlertHelper::error('Gagal', 'Produk tidak ditemukan.');
        }
    }

    /**
     * Get Buy X Get Y promotion summary
     */
    public function getBuyXGetYPromotionSummary()
    {
        if (!$this->transaction || !$this->transaction_details) {
            return null;
        }

        $totalSavings = 0;
        $savings = [];
        $promotionGroups = [];

        foreach ($this->transaction_details as $detail) {
            if (isset($detail['is_free_item']) && $detail['is_free_item'] && isset($detail['promotion_text'])) {
                $promotionText = $detail['promotion_text'];
                $savedAmount = ($detail['price_discount'] ?? 0) * $detail['quantity'];

                if (!isset($promotionGroups[$promotionText])) {
                    $promotionGroups[$promotionText] = [
                        'description' => $promotionText,
                        'amount' => 0,
                        'items' => []
                    ];
                }

                $promotionGroups[$promotionText]['amount'] += $savedAmount;
                $promotionGroups[$promotionText]['items'][] = $detail['product_name'] . ' x' . $detail['quantity'];
                $totalSavings += $savedAmount;
            }
        }

        // Convert to indexed array for easier iteration in view
        foreach ($promotionGroups as $group) {
            $savings[] = $group;
        }

        return [
            'total_savings' => $totalSavings,
            'savings' => $savings,
            'has_promotions' => count($savings) > 0
        ];
    }

    /**
     * Apply Buy X Get Y promotions to current transaction
     */
    public function applyBuyXGetYPromotions()
    {
        try {
            $buyXGetYService = new BuyXGetYService();
            $result = $buyXGetYService->applyBuyXGetYPromotions($this->transaction_id, Auth::user()->company_id);

            if ($result['success'] && !empty($result['applied_promotions'])) {
                $promotionMessages = [];
                foreach ($result['applied_promotions'] as $promotion) {
                    $promotionMessages[] = $promotion['message'];
                }

                if (!empty($promotionMessages)) {
                    AlertHelper::success('Promosi Diterapkan!', implode('. ', $promotionMessages));
                }
            }
        } catch (\Exception $e) {
            Log::error('Error applying Buy X Get Y promotions: ' . $e->getMessage(), [
                'transaction_id' => $this->transaction_id,
                'trace' => $e->getTraceAsString()
            ]);
        }
    }

    /**
     * Validate and cleanup Buy X Get Y promotions
     */
    public function validateBuyXGetYPromotions()
    {
        try {
            $buyXGetYService = new BuyXGetYService();
            $result = $buyXGetYService->validateAndCleanupBuyXGetY($this->transaction_id, Auth::user()->company_id);

            if ($result['success'] && !empty($result['removed_items'])) {
                $removedMessages = [];
                foreach ($result['removed_items'] as $item) {
                    $removedMessages[] = "{$item['product_name']} (qty: {$item['quantity']}) - {$item['reason']}";
                }

                if (!empty($removedMessages)) {
                    AlertHelper::warning('Item Gratis Disesuaikan', implode('. ', $removedMessages));
                }
            }
        } catch (\Exception $e) {
            Log::error('Error validating Buy X Get Y promotions: ' . $e->getMessage(), [
                'transaction_id' => $this->transaction_id,
                'trace' => $e->getTraceAsString()
            ]);
        }
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
        $this->reset('payment_method_id', 'payment_amount', 'description', 'admin_fee', 'is_single_payment');
        $this->dispatch('close-modal', ['id' => 'modalPayment']);
    }

    public function submitPayment()
    {
        $this->validate([
            'payment_method_id' => 'required',
            'payment_amount' => 'required',
        ]);

        $payment_amount = intval(Str::replace('.', '', $this->payment_amount));

        if ($payment_amount <= 0) {
            return AlertHelper::error('Gagal', 'Jumlah pembayaran tidak boleh kurang dari 1.');
        }

        $admin_fee = intval(Str::replace('.', '', $this->admin_fee));

        TransactionPayment::create([
            'user_id' => $this->transaction->patient_id,
            'transaction_id' => $this->transaction_id,
            'payment_method_id' => $this->payment_method_id,
            'description' => $this->description,
            'payment_amount' => $payment_amount,
            'admin_fee' => $admin_fee,
            'payment_real' => $payment_amount + $admin_fee,
            'company_id' => Auth::user()->company_id,
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
        $payment_amount = intval(Str::replace('.', '', $this->payment_amount));
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

    /**
     * Get available discount promotions for dropdown
     */
    public function getAvailablePromotions()
    {
        $promotionService = new PromotionSimplifiedService();
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
        if (!$this->promotion_simplified_id || !$this->transaction) {
            return null;
        }

        $promotionService = new PromotionSimplifiedService();
        return $promotionService->getPromotionSummary(
            $this->promotion_simplified_id,
            $this->transaction->sub_total_price,
            Auth::user()->company_id,
            $this->transaction->user_type_id,
        );
    }

    public function render()
    {
        $products = Product::search($this->searchProduct)
            ->select('id', 'sku_number', 'name', 'description', 'company_id')
            ->with('company:id,name', 'productStock:id,product_id,quantity,quantity_lock,quantity_real', 'productPrice:id,product_id,price,recipe,price_discount')
            ->where('company_id', Auth::user()->company_id);

        $paymentMethod = PaymentMethod::where('company_id', Auth::user()->company_id);

        if ($this->transaction->transactionPayments()->where('is_single_payment', false)->exists()) {
            $paymentMethod->where('is_single_payment', false);
        }

        return view('livewire.admin.pharmacy.pharmacy.detail.admin-pharmacy-sale-detail-index', [
            'products' => $products->orderBy('name', 'asc')->paginate($this->perPageProduct, ['*'], 'pageProduct'),
            'paymentMethods' => $paymentMethod->orderBy('name', 'asc')->get(),
            'transactionPayments' => TransactionPayment::where('transaction_id', $this->transaction_id)
                ->orderBy('created_at', 'desc')
                ->get(),
            'availablePromotions' => $this->getAvailablePromotions(),
            'promotionSummary' => $this->getPromotionSummary(),
        ])
            ->extends('layout.app')
            ->section('content');
    }
}
