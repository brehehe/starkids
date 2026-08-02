<?php

namespace App\Livewire\Admin\Sale\Pos\Detail;

use App\Helpers\AlertHelper;
use App\Models\Branch\Branch;
use App\Models\Company\Company;
use App\Models\PaymentMethod\PaymentMethod;
use App\Models\Product\Product;
use App\Models\Product\ProductPackage;
use App\Models\Product\ProductPrice;
use App\Models\Product\ProductStock;
use App\Models\Product\ProductType;
use App\Models\Promotion\PromotionSimplified;
use App\Models\Transaction\Transaction;
use App\Models\Transaction\TransactionDetail;
use App\Models\Transaction\TransactionPayment;
use App\Models\Transaction\TransactionRecipe;
use App\Models\User;
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

class AdminSalePosDetailIndex extends Component
{
    use ProductTrait, WithPagination;

    protected $queryString = [
        'pageProduct' => ['except' => 1], // Ini akan menghapus ?pageProduct=1 dari URL
        'searchProduct' => ['except' => ''],
    ];

    public $searchProduct = '';

    public $perPageProduct = 5;

    public $transaction_id;

    public $transaction;

    public $search_sku;

    public $transaction_details = [];

    public $discount;

    public $discount_type;

    public $payment_method_id;

    public $payment_amount;

    public $is_single_payment;

    public $admin_fee;

    public $description;

    public $is_narcotic;

    public $user_asign_narcotic_id;

    public $product_id;

    public $product_name;

    public $barcode;

    public $username_or_email;

    public $password;

    public $diagnosas;

    public $immunization;

    public $promotion_simplified_id;

    public $is_outside_pharmacy = false;

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

        $transaction_id = request()->query('id') ?? Session::get('transaction_id');

        if (request()->query('id')) {
            Session::put('transaction_id', $transaction_id);
        }

        if ($transaction_id) {
            $transaction = Transaction::find($transaction_id);

            if ($transaction) {
                if ($transaction->type == 'resep') {
                    return redirect()->route('user.sale.pos.recipe');
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
                return redirect()->route('user.sale.pos');
            }
        } else {
            return redirect()->route('user.sale.pos');
        }
    }

    public function updatedPromotionSimplifiedId()
    {
        // Apply promotion to transaction
        $transaction = Transaction::find($this->transaction_id);
        if ($transaction) {
            $promotionService = new PromotionSimplifiedService;
            $promotionService->applyPromotionToTransaction($transaction, $this->promotion_simplified_id);
        }
        $this->updateTotal();
    }

    public function updatedDiscountType()
    {
        $this->discount = '';
        $this->updateTotal();
    }

    public function updatedDiscount()
    {
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

    public function choiceProductChange()
    {
        $product = Product::where('sku_number', $this->search_sku)->first();

        if ($product) {

            $productStock = ProductStock::where('product_id', $product->id)
                ->where('company_id', auth()->user()->company_id)
                ->where('branch_id', Branch::where('company_id', auth()->user()->company_id)->first()->id)
                ->first();

            if (! $product->is_non_stock) {
                if (! $productStock || $productStock->quantity <= 0) {
                    return AlertHelper::error('Gagal', 'Stok produk tidak ditemukan atau stok kosong.');
                }
            }

            $productPrice = ProductPrice::where('product_id', $product->id)
                ->where('company_id', auth()->user()->company_id)
                ->where('branch_id', Branch::where('company_id', auth()->user()->company_id)->first()->id)
                ->where('is_updated', true)
                ->first();

            if (! $productPrice) {
                return AlertHelper::error('Gagal', 'Harga produk tidak ditemukan.');
            }

            if ($productPrice?->price == 0) {
                return AlertHelper::error('Gagal', 'Harga produk tidak boleh 0.');
            }

            $transactionItem = TransactionDetail::where('transaction_id', $this->transaction_id)
                ->where('product_id', $product->id)
                ->whereNull('transaction_detail_id') // Only main items, not free items
                ->first();

            if ($transactionItem) {
                // Item already exists - increment quantity and preserve existing price
                $transactionItem->increment('quantity', 1);
                // Do NOT update price here - preserve the original price
                // Only recalculate subtotal with existing price
                $transactionItem->sub_total_price = $transactionItem->price * $transactionItem->quantity;
                $transactionItem->save();
            } else {

                if ($product->is_narcotic) {
                    if (! $this->user_asign_narcotic_id) {
                        $this->is_narcotic = true;
                        $this->product_id = $product->id;
                        $this->product_name = $product?->name ?? '-';

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
                $value['quantity'] = 1;
                AlertHelper::error('Gagal', 'Jumlah produk tidak boleh kurang dari 1.');
            }

            if (! $product) {
                AlertHelper::error('Gagal', 'Produk tidak ditemukan.');

                continue;
            }

            $value['quantity'] = ceil($value['quantity']);

            // ❌ Hapus semua validasi kunci stok (productStock, lockedStock, available, dsb)

            // Proses update ke DB (biarkan Observer handle sub_total_price dsb)
            $transactionDetail = TransactionDetail::find($value['id']);

            if ($transactionDetail) {
                $transactionDetail->quantity = $value['quantity'];
                $transactionDetail->price = $value['price'];
                $transactionDetail->price_discount = $value['price_discount'] ?? 0;
                $transactionDetail->sub_total_price = $transactionDetail->price * $value['quantity'];
                $transactionDetail->save();
            }
        }

        $this->getDetailPackages();
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
                'product_name' => $parentDetail?->product?->name ?? '-',
                'quantity' => $parentDetail->quantity,
                'price' => $parentDetail->price,
                'price_discount' => $parentDetail->price_discount ?? 0,
                'sub_total_price' => $parentDetail->price * $parentDetail->quantity,
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
                    'product_name' => $childDetail?->product?->name ?? '-',
                    'quantity' => $childDetail->quantity,
                    'price' => $childDetail->price,
                    'price_discount' => $childDetail->price_discount ?? 0,
                    'sub_total_price' => $childDetail->price * $childDetail->quantity,
                    'is_parent' => false,
                    'is_free_item' => true,
                    'parent_id' => $parentDetail->id,
                    'promotion_text' => $childDetail->product_package_id ? 'Paket' : $this->extractPromotionFromName($childDetail->name),
                ];
            }
        }
        $this->updateTotal();
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

        if (! $transactionDetail) {
            return AlertHelper::error('Gagal', 'Detail transaksi tidak ditemukan.');
        }

        // Check if this is a free item from Buy X Get Y promotion
        if ($transactionDetail->isFreeItem()) {
            return AlertHelper::error('Gagal', 'Item gratis dari promosi tidak dapat diubah secara manual.');
        }

        // Ambil produk terkait
        $product = Product::find($transactionDetail->product_id);
        if (! $product) {
            return AlertHelper::error('Gagal', 'Produk tidak ditemukan.');
        }

        // Ambil branch_id
        $branchId = $transactionDetail->transaction->branch_id
            ?? Branch::where('company_id', auth()->user()->company_id)->first()->id;

        // Ambil stok produk (jika produk adalah stockable)
        $productStock = ! $product->is_non_stock
            ? ProductStock::where('product_id', $product->id)
                ->where('company_id', auth()->user()->company_id)
                ->where('branch_id', $branchId)
                ->first()
            : null;

        if (! $product->is_non_stock && ! $productStock) {
            return AlertHelper::error('Gagal', 'Stok produk tidak ditemukan.');
        }

        if ($quantity === 'decrement') {
            if ($transactionDetail->quantity <= 1) {
                return AlertHelper::error('Gagal', 'Jumlah produk tidak boleh kurang dari 1.');
            }

            $transactionDetail->decrement('quantity');
        }

        if ($quantity === 'increment') {
            $transactionDetail->increment('quantity');
        }

        // Hitung ulang subtotal
        $transactionDetail->sub_total_price = $transactionDetail->price * $transactionDetail->quantity;
        $transactionDetail->save();

        // Apply Buy X Get Y promotions with automatic consolidation after quantity change
        $this->applyBuyXGetYPromotions();
        $this->getDetailPackages();

        // Update ulang tampilan Livewire
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

        foreach ($transaction->transactionDetails as $detail) {
            if (! $detail->product_id) {
                continue;
            }

            $product = Product::find($detail->product_id);
            if (! $product || $product->is_non_stock) {
                continue;
            }

            $productStock = ProductStock::where('product_id', $detail->product_id)
                ->where('company_id', Auth::user()->company_id)
                ->where('branch_id', $branchId)
                ->first();

            if (! $productStock) {
                return AlertHelper::error('Gagal', "Stok tidak ditemukan untuk produk '{$product->name}'.");
            }

            // ❌ Bagian locked stock, available, dan validasi stok DIHAPUS
        }

        $transaction->status = 'process';
        $transaction->save();

        session()->flash('saved', [
            'title' => 'Transaksi Berhasil!',
            'text' => 'Anda berhasil menyimpan transaksi sebagai proses.',
        ]);

        return redirect()->route('user.sale.pos');
    }

    public function saveSuccessTransaction()
    {
        try {
            $transaction = Transaction::find($this->transaction_id);

            if (! $transaction) {
                return AlertHelper::error('Gagal', 'Transaksi tidak ditemukan.');
            }

            if ($transaction->transactionDetails()->count() <= 0) {
                return AlertHelper::error('Gagal', 'Transaksi tidak dapat disimpan, karena tidak ada item yang ditambahkan.');
            }

            DB::beginTransaction();

            // Proses pembayaran
            $this->processTransactionPayments($transaction);

            // Cek apakah ada produk obat (type = take)
            $productType = ProductType::where('type', 'take')->pluck('id')->toArray();

            $productIds = Product::whereIn('product_type_id', $productType)
                ->where('company_id', Auth::user()->company_id)
                ->pluck('id')
                ->toArray();

            $hasMedicine = TransactionDetail::whereIn('product_id', $productIds)
                ->where('transaction_id', $this->transaction_id)
                ->exists();

            // Update status transaksi
            $transaction->update([
                // 'status' => $hasMedicine ? (in_array($transaction->status, ['take_medicine', 'completed']) ? $transaction->status : 'take_medicine') : 'completed',
                'status' => 'take_medicine',
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

            return redirect()->route('user.sale.pos');
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Error saveSuccessTransaction: '.$e->getMessage(), [
                'transaction_id' => $this->transaction_id,
                'user_id' => Auth::id(),
                'trace' => $e->getTraceAsString(),
            ]);

            return AlertHelper::error('Gagal', 'Terjadi kesalahan saat menyimpan transaksi.');
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
            // 1. Hitung komponen dasar subtotal
            $first_service_price = $this->is_outside_pharmacy ? 0 : TransactionRecipe::where('transaction_id', $this->transaction_id)->sum('price_service_one');
            $service_other_price = $this->is_outside_pharmacy ? 0 : TransactionRecipe::where('transaction_id', $this->transaction_id)->sum('price_service_other');
            $price_product_price = $this->is_outside_pharmacy ? 0 : TransactionRecipe::where('transaction_id', $this->transaction_id)->sum('sub_total_price');
            $product_price = $this->is_outside_pharmacy ? TransactionDetail::whereIn('type_transaction', ['action', 'other'])->where('transaction_id', $this->transaction_id)
                ->sum('sub_total_price') : TransactionDetail::where('transaction_id', $this->transaction_id)
                ->sum('sub_total_price');

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
                $subtotal = $transaction->sub_total_price_before_rounding;
            }

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

                if ($remainder == 0) {
                    // Sudah bulat ribuan, biarkan apa adanya
                    $roundedTotal = $totalAfterPromotion;
                    $rounding = 0;
                } elseif ($remainder < 500) {
                    $roundedTotal = $totalAfterPromotion - $remainder + 500;
                    $rounding = 500 - $remainder;
                } else {
                    $roundedTotal = $totalAfterPromotion - $remainder + 1000;
                    $rounding = 1000 - $remainder;
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

                $transaction->discount_value = $totalManualDiscount;
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
            if (! $transactionDetail->transaction_detail_id) {
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

            if (! $product->is_non_stock) {
                if (! $productStock || $productStock->quantity <= 0) {
                    return AlertHelper::error('Gagal', 'Stok produk tidak ditemukan atau stok kosong.');
                }
            }

            $branchId = Branch::where('company_id', Auth::user()->company_id)->first()?->id;

            $productPrice = $product->productPrice()->where('company_id', Auth::user()->company_id)->where('branch_id', $branchId)->where('is_updated', true)->first();

            if (! $productPrice) {

                $productPrice = ProductPrice::where('product_id', $product->id)
                    ->where('company_id', Auth::user()->company_id)
                    // ->where('is_updated', false)
                    ->first();

                $productPrice?->update(['is_updated' => true]);
                $productPrice = ProductPrice::where('product_id', $product->id)
                    ->where('company_id', Auth::user()->company_id)
                    ->where('branch_id', $branchId)
                    ->where('is_updated', true)
                    ->first();

                AlertHelper::error('Gagal', 'Harga produk tidak ditemukan.');
            }
            $price = $productPrice?->price ?? 0;

            if ($price == 0) {
                AlertHelper::error('Gagal', 'Harga produk tidak boleh 0.');

                return;
            }

            $transactionItem = TransactionDetail::where('transaction_id', $this->transaction_id)
                ->where('product_id', $product->id)
                ->whereNull('transaction_detail_id') // Only main items, not free items
                ->first();

            if ($transactionItem) {
                // Item already exists - increment quantity and preserve existing price
                $transactionItem->increment('quantity', 1);
                // Do NOT update price here - preserve the original price
                // Only recalculate subtotal with existing price
                $transactionItem->sub_total_price = $transactionItem->price * $transactionItem->quantity;
                $transactionItem->save();
            } else {
                if ($product->is_narcotic) {
                    if (! $this->user_asign_narcotic_id) {
                        $this->is_narcotic = true;
                        $this->product_id = $product->id;
                        $this->product_name = $product?->name ?? '-';

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
            $this->applyBuyXGetYPromotions();
            $this->getDetailPackages();

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
        if (! $this->transaction || ! $this->transaction_details) {
            return null;
        }

        $totalSavings = 0;
        $savings = [];
        $promotionGroups = [];

        foreach ($this->transaction_details as $detail) {
            if (isset($detail['is_free_item']) && $detail['is_free_item'] && isset($detail['promotion_text'])) {
                $promotionText = $detail['promotion_text'];
                $savedAmount = ($detail['price_discount'] ?? 0) * $detail['quantity'];

                if (! isset($promotionGroups[$promotionText])) {
                    $promotionGroups[$promotionText] = [
                        'description' => $promotionText,
                        'amount' => 0,
                        'items' => [],
                    ];
                }

                $promotionGroups[$promotionText]['amount'] += $savedAmount;
                $promotionGroups[$promotionText]['items'][] = $detail['product_name'].' x'.$detail['quantity'];
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
            'has_promotions' => count($savings) > 0,
        ];
    }

    /**
     * Apply Buy X Get Y promotions to current transaction
     */
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

    /**
     * Validate and cleanup Buy X Get Y promotions
     */
    public function validateBuyXGetYPromotions()
    {
        try {
            $buyXGetYService = new BuyXGetYService;
            $result = $buyXGetYService->validateAndCleanupBuyXGetY($this->transaction_id, Auth::user()->company_id);

            if ($result['success'] && ! empty($result['removed_items'])) {
                $removedMessages = [];
                foreach ($result['removed_items'] as $item) {
                    $removedMessages[] = "{$item['product_name']} (qty: {$item['quantity']}) - {$item['reason']}";
                }

                if (! empty($removedMessages)) {
                    AlertHelper::warning('Item Gratis Disesuaikan', implode('. ', $removedMessages));
                }
            }
        } catch (\Exception $e) {
            Log::error('Error validating Buy X Get Y promotions: '.$e->getMessage(), [
                'transaction_id' => $this->transaction_id,
                'trace' => $e->getTraceAsString(),
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

    public function getDetailPackages()
    {
        $transactionDetails = TransactionDetail::where('transaction_id', $this->transaction_id)
            ->whereNull('transaction_detail_id')
            ->get();

        foreach ($transactionDetails as $detail) {
            $productPackages = ProductPackage::where('product_id', $detail->product_id)
                ->where('company_id', Auth::user()->company_id)
                ->get();

            foreach ($productPackages as $package) {
                $product = Product::find($package->product_child_id);

                $transactionItem = TransactionDetail::where('transaction_id', $this->transaction_id)
                    ->where('product_package_id', $package->id)
                    ->where('product_id', $package->product_child_id)
                    ->where('transaction_detail_id', $detail->id)
                    ->first();

                TransactionDetail::updateOrCreate(
                    [
                        'id' => $transactionItem->id ?? null,
                        'transaction_id' => $this->transaction_id,
                        'product_package_id' => $package->id,
                        'transaction_detail_id' => $detail->id,
                        'company_id' => $detail->company_id,
                        'branch_id' => $detail->branch_id,
                    ],
                    [
                        'product_id' => $package->product_child_id,
                        'quantity' => $detail->quantity * $package->quantity,
                        'price' => 0,
                        'sub_total_price' => 0,
                        'name' => $package->productChild->name,
                        'type' => 'single',
                        'type_transaction' => $detail->type_transaction ?? 'medicine',
                        'is_free_item' => true,
                        'created_at' => now(),
                        'updated_at' => now(),
                    ]
                );
            }
        }
    }

    public function render()
    {
        $products = Product::search($this->searchProduct)
            ->select('id', 'sku_number', 'name', 'description', 'company_id')
            ->with('company:id,name', 'productStock:id,product_id,quantity,quantity_lock,quantity_real', 'productPrice:id,product_id,price,recipe,price_discount', 'nearestExpiredDate')
            ->where('company_id', Auth::user()->company_id);

        $paymentMethod = PaymentMethod::where('company_id', Auth::user()->company_id);

        if ($this->transaction->transactionPayments()->where('is_single_payment', false)->exists()) {
            $paymentMethod->where('is_single_payment', false);
        }

        return view('livewire.admin.sale.pos.detail.admin-sale-pos-detail-index', [
            'products' => $products->orderBy('name', 'asc')->paginate($this->perPageProduct, ['*'], 'pageProduct'),
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
}
