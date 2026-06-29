<?php

namespace App\Livewire\Admin\Pharmacy\Consultation\Detail;

use App\Helpers\AlertHelper;
use App\Models\Branch\Branch;
use App\Models\Company\Company;
use App\Models\Encounter\Encounter;
use App\Models\HowToUse\HowToUse;
use App\Models\Master\CodeSystem\MedicationRequest\MasterMedicationRequestDosageRoute;
use App\Models\Medication\Medication;
use App\Models\MedicineType\MedicineType;
use App\Models\Patient\Patient;
use App\Models\Practitiont\Practitioner;
use App\Models\Product\Product;
use App\Models\Product\ProductPrice;
use App\Models\Product\ProductStock;
use App\Models\Product\ProductType;
use App\Models\Promotion\PromotionSimplified;
use App\Models\Transaction\Transaction;
use App\Models\Transaction\TransactionDetail;
use App\Models\Transaction\TransactionRecipe;
use App\Models\User;
use App\service\apiservice;
use App\Services\Promotion\BuyXGetYService;
use App\Services\Promotion\PromotionSimplifiedService;
use Auth;
use Cache;
use DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use Livewire\Component;
use Livewire\WithPagination;

class AdminPharmacyConsultationDetailIndex extends Component
{
    use WithPagination;

    public $search;

    public $perPage = 5;

    protected $queryString = [
        'search' => ['except' => ''],
    ];

    public $transaction_id;

    public $transaction;

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

    // Array
    public $recipes = [];

    public $actions = [];

    public $medicine_types = [];

    public $supporting_products = [];

    public $product_types = [];

    public $medicines = [];

    public $how_to_uses = [];

    public $master_medication_request_dosage_routes = [];

    // Variables
    public $transaction_detail_id;

    public $type;

    public $is_narcotic = false;

    public $user_asign_narcotic_id = null;

    public $product_id;

    public $product_name;

    public $username_or_email;

    public $password;

    public $barcode = false;

    public $discount;

    public $discount_type = 'percentage';

    public $discount_value = 0;

    public $is_admin_fee = false;

    public $admin_fee = 0;

    public $admin_fee_type = 'percentage';

    public $admin_fee_value = 0;

    public $is_outside_pharmacy = false;

    public $transaction_recipe_id;

    public $name_how_to_use;

    public $description_how_to_use;

    public $day_how_to_use;

    public $time_how_to_use;

    public $promotion_simplified_id = null;

    public function mount()
    {
        $this->transaction_id = session('transaction_id');
        if (! $this->transaction_id) {
            return redirect()->route('user.pharmacy.consultation');
        }

        $this->transaction = Transaction::find($this->transaction_id);
        if (! $this->transaction) {
            return redirect()->route('user.pharmacy.consultation');
        }

        $this->is_outside_pharmacy = $this->transaction->is_outside_pharmacy;

        $this->product_types = Cache::remember('product_types_tindakan_paket', 3600, function () {
            return ProductType::whereIn('name', ['Tindakan', 'Paket'])->pluck('id')->toArray();
        });

        $this->medicine_types = MedicineType::select('id', 'name')
            ->where('company_id', Auth::user()->company_id)
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
            //     // $query->where('quantity', '>', 0)
            //     $query->where('branch_id', Branch::where('company_id', Auth::user()->company_id)->first()->id); // atau 'Supporting Product' sesuai isi database
            // })
            ->select('id', 'name')
            ->with('productPrice:id,product_id,price,recipe', 'productStock:id,product_id,quantity')
            ->orderBy('name', 'asc')
            ->get()
            ->toArray();

        $this->how_to_uses = HowToUse::select('id', 'name', 'description')
            ->where('company_id', Auth::user()->company_id)
            ->get()
            ->pluck('name_display', 'id')
            ->toArray();

        $this->master_medication_request_dosage_routes = MasterMedicationRequestDosageRoute::select('code', 'display')
            ->get()
            ->pluck('code_display', 'code')
            ->toArray();
        $this->getActions();
        $this->getRecipes();
        $this->getMedicines();
    }

    public function getRecipes()
    {
        $this->recipes = [];

        $transactionDetails = $this->is_outside_pharmacy ? [] : TransactionRecipe::where('transaction_id', $this->transaction_id)
            ->orderBy('order', 'asc')
            ->get();

        foreach ($transactionDetails as $key => $transactionDetail) {
            $medicine_type = MedicineType::find($transactionDetail->medicine_type_id);
            $this->recipes[] = [
                'id' => $transactionDetail->id,
                'medicine_type_id' => $transactionDetail->medicine_type_id,
                'medicine_type_name' => $medicine_type ? $medicine_type->name : null,
                'is_single' => $medicine_type ? $medicine_type->is_single : false,
                'numero_recipe' => $transactionDetail->numero_recipe ?? null,
                'price_service_one' => number_format($medicine_type ? $medicine_type->service_price : 0, 0, ',', '.'),
                'price_service_other' => number_format($medicine_type ? $medicine_type->price_other : 0, 0, ',', '.'),
                'product_id' => $transactionDetail->product_id,
                'product_name' => $transactionDetail->product->name ?? '',
                'quantity' => $transactionDetail->quantity,
                'price' => number_format($transactionDetail->price, 0, ',', '.'),
                'sub_total_price' => number_format($transactionDetail->sub_total_price, 0, ',', '.'),
                'description' => $transactionDetail->description,
                'how_to_use_id' => $transactionDetail->how_to_use_id,
                'route_coding_code' => $transactionDetail->route_coding_code,
                'notes' => $transactionDetail->notes ?? '',
            ];

            foreach ($transactionDetail->transactionDetail as $detail) {
                $quantity_real = $this->parseFloatValue($detail->quantity_real ?? 0);
                $quantity = $medicine_type ? $medicine_type->is_single ? $transactionDetail->numero_recipe : $this->parseIntValue($quantity_real) : 0;
                $this->recipes[$key]['details'][] = [
                    'id' => $detail->id,
                    'product_id' => $detail->product_id,
                    'product_name' => $detail->product->name,
                    'quantity_real' => $detail->quantity_real,
                    'quantity' => $quantity,
                    'price' => $detail->price,
                    'sub_total_price' => $detail->price * $quantity,
                ];
            }
        }
        $this->updateTotal();
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
                'price' => $action->price,
                'sub_total_price' => $action->sub_total_price,
            ];
        }

        $this->updateTotal();
    }

    public function getMedicines()
    {
        $this->medicines = [];

        $transactionDetails = TransactionDetail::where('transaction_id', $this->transaction_id)
            ->with(['product', 'parentDetail'])
            ->whereIn('type_transaction', ['medicine'])
            ->orderBy('order', 'asc')
            ->get();

        $this->applyBuyXGetYPromotions();

        // Group items by parent-child relationship
        $parentItems = $transactionDetails->where('transaction_detail_id', null);
        $childItems = $transactionDetails->where('transaction_detail_id', '!=', null);

        foreach ($parentItems as $key => $parentDetail) {
            $this->medicines[] = [
                'id' => $parentDetail->id,
                'product_id' => $parentDetail->product_id,
                'product_name' => $parentDetail?->product?->name,
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
                $this->medicines[] = [
                    'id' => $childDetail->id,
                    'product_id' => $childDetail->product_id,
                    'product_name' => $childDetail?->product?->name,
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

    public function updatedMedicines()
    {
        $branchId = Branch::where('company_id', auth()->user()->company_id)->first()?->id;

        foreach ($this->medicines as $key => $value) {
            if (empty($value['product_id'])) {
                continue;
            }

            $product = Product::find($value['product_id']);

            // Validasi quantity minimal
            if ($value['quantity'] <= 0) {
                $this->medicines[$key]['quantity'] = 1;
                AlertHelper::error('Gagal', 'Jumlah produk tidak boleh kurang dari 1.');

                continue;
            }

            if (! $product) {
                AlertHelper::error('Gagal', 'Produk tidak ditemukan.');

                continue;
            }

            if (! $product->is_non_stock) {
                $productStock = ProductStock::where('product_id', $product->id)
                    ->where('company_id', auth()->user()->company_id)
                    ->where('branch_id', $branchId)
                    ->first();

                if (! $productStock) {
                    $this->medicines[$key]['quantity'] = 0;
                    AlertHelper::error('Gagal', "Stok untuk produk {$product->name} tidak ditemukan.");

                    continue;
                }
            }

            // Proses update ke DB (biarkan Observer handle stok dan sub_total_price)
            $transactionDetail = TransactionDetail::find($value['id']);

            if ($transactionDetail) {
                $transactionDetail->quantity = $this->medicines[$key]['quantity'];
                $transactionDetail->price = $value['price'];
                $transactionDetail->price_discount = $value['price_discount'] ?? 0;
                $transactionDetail->save(); // Observer akan hitung ulang sub_total dan update stock
            }
        }

        $this->applyBuyXGetYPromotions();
        $this->getMedicines();
        $this->updateTotal();
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

    public function updatedRecipes()
    {
        $companyId = auth()->user()->company_id;
        $branchId = Branch::where('company_id', $companyId)->first()?->id;

        foreach ($this->recipes as $key => $value) {
            $transactionRecipe = TransactionRecipe::find($value['id']);

            if (! $transactionRecipe) {
                AlertHelper::error('Gagal', 'Resep tidak ditemukan.');

                continue;
            }

            // Check if product_id is changing (before we save)
            $newProductId = ! empty($value['product_id']) ? $value['product_id'] : null;
            $productIdChanged = $transactionRecipe->product_id != $newProductId;

            // If product changed, fetch new price
            $price = intval(Str::replace('.', '', $value['price']));
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
            $transactionRecipe->numero_recipe = intval(Str::replace('.', '', $value['numero_recipe']));
            $transactionRecipe->quantity = intval(Str::replace('.', '', $value['quantity']));
            $transactionRecipe->price = $price;
            $transactionRecipe->sub_total_price = $transactionRecipe->quantity * $transactionRecipe->price;
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
                    $transactionDetail->quantity = $this->parseIntValue($detail['quantity_real']);
                    $transactionDetail->price = $detailPrice;
                    $transactionDetail->sub_total_price = $this->parseIntValue($detail['quantity_real']) * $detailPrice;
                    $transactionDetail->save(); // Observer akan validasi stok
                }
            }
        }

        $this->updateTransactionRecipe();
        $this->getRecipes();
        $this->updateTotal();
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
                $numeroRecipe = intval(Str::replace('.', '', $transactionRecipe->numero_recipe ?? 0));

                if (! $medicineType) {
                    AlertHelper::error('Gagal', 'Tipe Resep Pada /R'.($key + 1).' tidak ditemukan.');

                    continue;
                }

                $product = $transactionRecipe->product_id
                    ? Product::find($transactionRecipe->product_id)
                    : null;

                // Use existing price if available, otherwise fetch from database
                $price = 0;
                if ($transactionRecipe->price > 0) {
                    // Use existing stored price to preserve historical data
                    $price = $transactionRecipe->price;
                } else {
                    // Only fetch from database if price is not set (new record)
                    $productPrice = $product ? ProductPrice::where([
                        'product_id' => $product->id,
                        'company_id' => $companyId,
                        'branch_id' => $branchId,
                        'is_updated' => true,
                    ])->first() : null;
                    $price = $productPrice?->price ?? 0;
                }

                $quantity = $numeroRecipe > 0 ? $numeroRecipe : 0;

                // === Update TransactionRecipe utama ===
                if ($medicineType->is_single && $numeroRecipe > 0) {
                    // Jika single, reset ke 0
                    $transactionRecipe->fill([
                        'product_id' => null,
                        'quantity' => 0,
                        'price' => 0,
                        'sub_total_price' => 0,
                    ])->save();
                } else {
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
                }

                // === Update detail resep ===
                foreach ($transactionRecipe->transactionDetail as $detail) {
                    $productRecipe = Product::find($detail->product_id);
                    if (! $productRecipe) {
                        AlertHelper::error('Gagal', "Produk dengan ID {$detail->product_id} tidak ditemukan.");

                        continue;
                    }

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

                    $quantityRecipe = $medicineType->is_single ? $numeroRecipe : $detail->quantity_real;
                    $quantity = $this->parseIntValue($quantityRecipe);

                    $detail->fill([
                        'type' => $medicineType->is_single ? 'single' : ($detail->type ?? 'single'),
                        'dosage_doctor' => 0,
                        'dosage_drug' => 0,
                        'quantity_real' => $quantityRecipe,
                        'quantity' => $quantity,
                        'price' => $priceRecipe,
                        'sub_total_price' => $priceRecipe * $quantity,
                    ])->save();
                }
            }

            $this->getRecipes();
            $this->updateTotal();
            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            AlertHelper::error('Gagal', 'Terjadi kesalahan saat memperbarui resep: '.$e->getMessage());
            Log::error('Error updating transaction recipe: '.$e->getMessage());
        }
    }

    public function changeProduct($detailId = null)
    {
        $this->transaction_detail_id = $detailId;
        $this->transaction_recipe_id = TransactionDetail::find($detailId)?->transaction_recipe_id ?? null;
        $this->type = 'medicine';
        $this->dispatch('open-modal', ['id' => 'modalProduct']);
    }

    public function choiceProduct($id)
    {
        $companyId = auth()->user()->company_id;
        $branchId = Branch::where('company_id', $companyId)->value('id');

        // Ambil produk langsung
        $product = Product::find($id);

        if (! $product) {
            return false;
        }

        // Ambil harga produk (opsional, default 0)
        $productPrice = ProductPrice::where([
            'product_id' => $product->id,
            'company_id' => $companyId,
            'branch_id' => $branchId,
            'is_updated' => true,
        ])->first();

        if ($productPrice?->price == 0) {
            AlertHelper::error('Gagal', 'Harga produk tidak boleh 0.');

            return;
        }

        // Ambil atau buat transaction recipe
        $transactionRecipe = $this->transaction_recipe_id
            ? TransactionRecipe::find($this->transaction_recipe_id)
            : TransactionRecipe::create([
                'transaction_id' => $this->transaction_id,
                'company_id' => $companyId,
                'branch_id' => $branchId,
            ]);

        // Buat detail resep
        TransactionDetail::create([
            'transaction_recipe_id' => $transactionRecipe->id,
            'transaction_id' => $this->transaction_id,
            'product_id' => $product->id,
            'quantity' => 1,
            'price' => $productPrice?->price ?? 0,
            'sub_total_price' => $productPrice?->price ?? 0,
            'dosage_drug' => $product->medicine_dosage ?? 0,
            'type_transaction' => 'recipe',
        ]);

        $this->closeModalProduct();
        $this->getRecipes();

        return true;
    }

    public function closeModalProduct()
    {
        $this->dispatch('close-modal', ['id' => 'modalProduct']);
        $this->reset(['transaction_detail_id', 'type']);
    }

    public function render()
    {
        return view('livewire.admin.pharmacy.consultation.detail.admin-pharmacy-consultation-detail-index', [
            'products' => $this->getProductRenders(),
        ])
            ->extends('layout.app')
            ->section('content');
    }

    private function getProductRenders()
    {
        if ($this->type !== 'medicine') {
            return [];
        }

        return $this->getProducts(false);
    }

    private function getProducts($isAction = true)
    {
        $query = Product::search($this->search)
            ->select('id', 'sku_number', 'name', 'description', 'company_id')
            ->where('company_id', Auth::user()->company_id);

        // Optimasi: constraint dengan branch_id untuk relations
        $branchId = $this->getBranchId();

        $query->with([
            'company:id,name',
            'productStock' => function ($q) use ($branchId) {
                $q->select('id', 'product_id', 'quantity')
                    ->where('branch_id', $branchId);
            },
            'productPrice' => function ($q) use ($branchId) {
                $q->select('id', 'product_id', 'price', 'recipe')
                    ->where('branch_id', $branchId);
            },
        ]);

        if ($isAction) {
            $query->whereIn('product_type_id', $this->product_types);
        } else {
            $query->whereNotIn('product_type_id', $this->product_types);
        }

        return $query->paginate($this->perPage);
    }

    public function closeModalNarcotic()
    {
        $this->reset('is_narcotic', 'user_asign_narcotic_id', 'product_id', 'product_name', 'search_sku', 'username_or_email', 'password');
        $this->dispatch('close-modal', ['id' => 'modalNarcotic']);
        if ($this->barcode) {
            $this->changeProduct();
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
        $this->choiceProduct($this->product_id);
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

    private function getBranchId()
    {
        return Cache::remember('branch_id_'.Auth::user()->company_id, 3600, function () {
            return Branch::where('company_id', Auth::user()->company_id)->value('id');
        });
    }

    public function addDetail($transaction_recipe)
    {
        $this->transaction_recipe_id = $transaction_recipe;
        $this->type = 'medicine';
        $this->dispatch('open-modal', ['id' => 'modalProduct']);
    }

    public function confirmDeleteMedicine($id)
    {
        return AlertHelper::confirmDelete('deleteMedicine', 'Apakah Anda yakin ingin menghapus obat ini?', $id);
    }

    public function deleteMedicine($id)
    {
        $transactionDetail = TransactionDetail::find($id[0]);

        if (! $transactionDetail) {
            return AlertHelper::error('Gagal', 'Obat tidak ditemukan.');
        }

        // Hapus detail transaksi
        $transactionDetail->delete();

        // Refresh data
        $this->getMedicines();
        $this->getRecipes();

        return AlertHelper::success('Berhasil', 'Obat berhasil dihapus.');
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

                $transaction->discount_value = $totalManualDiscount;
                $transaction->discount_type = $this->discount_type ?? 'rupiah';
            } else {
                $transaction->discount = 0;
                $transaction->discount_type = 'rupiah';
                $transaction->discount_value = 0;
                $totalManualDiscount = 0;
            }

            // Update format display discount
            $this->discount = ($this->discount_type ?? 'rupiah') == 'rupiah'
                ? number_format($transaction->discount, 0, ',', '.')
                : number_format($transaction->discount, 2, ',', '.');

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

    public function updatedIsOutsidePharmacy()
    {
        $transaction = Transaction::find($this->transaction_id);
        if ($transaction) {
            $transaction->is_outside_pharmacy = $this->is_outside_pharmacy;
            $transaction->save();
            $this->getActions();
            $this->getRecipes();
            $this->getMedicines();
        }
    }

    public function confirmSave()
    {
        return AlertHelper::confirm('save', 'Apakah Anda yakin ingin menyimpan transaksi ini?');
    }

    public function save()
    {
        $transaction = Transaction::find($this->transaction_id);
        if (! $transaction) {
            return AlertHelper::error('Gagal', 'Transaksi tidak ditemukan.');
        }

        $recipes = $transaction->transactionRecipes;

        foreach ($recipes as $key_recipe => $recipe) {
            if ($recipe->medicine_type_id == null || $recipe->medicine_type_id == 0) {
                return AlertHelper::error('Gagal', 'Transaksi tidak dapat disimpan, karena tipe resep pada /R'.($key_recipe + 1).' belum dipilih.');
            }

            if ($recipe->numero_recipe <= 0) {
                return AlertHelper::error('Gagal', 'Transaksi tidak dapat disimpan, karena Quantity Resep pada /R'.($key_recipe + 1).' belum diisi.');
            }

            $medicine_type = MedicineType::find($recipe->medicine_type_id);

            if (! $medicine_type->is_single && $recipe->product_id == null) {
                return AlertHelper::error('Gagal', 'Transaksi tidak dapat disimpan, karena produk pendukung pada /R'.($key_recipe + 1).' belum dipilih.');
            }

            if ($recipe->transactionDetail()->count() <= 0) {
                return AlertHelper::error('Gagal', 'Detail Obat /R'.($key_recipe + 1).' belum diisi.');
            }
        }

        $details = $transaction->transactionDetails;

        foreach ($details as $key_detail => $detail) {
            if ($detail->product_id == null) {
                // Allow known non-product types (actions, others, odontogram) and specific names like "Biaya Konsultasi"
                $allowedTypes = ['action', 'other', 'odontogram_action', 'service'];

                if ($detail->name != 'Biaya Konsultasi' && ! in_array($detail->type_transaction, $allowedTypes)) {
                    return AlertHelper::error('Gagal', 'Transaksi tidak dapat disimpan, karena produk belum dipilih pada item: '.$detail->name);
                } else {
                    continue;
                }
            }

            if ($detail->quantity <= 0) {
                AlertHelper::warning('Perhatian', 'Quantity pada produk masih kosong (0).');

                return true;
            }
        }

        // Simpan transaksi
        $transaction->update([
            'status' => 'process',
            'pharmacy_id' => auth()->user()->id,
            'pharmacy_name' => auth()->user()->name,
        ]);

        session()->flash('saved', [
            'title' => 'Simpan Berhasil!',
            'text' => 'Data transaksi berhasil disimpan!',
        ]);

        return redirect()->route('user.pharmacy.consultation');
    }

    private function updateServiceTransactionRecipe($transaction)
    {
        $transactionRecipes = TransactionRecipe::where('transaction_id', $transaction->id)->get();

        $encounter = Encounter::where('transaction_id', $transaction->id)->first();
        $patient = Patient::where('user_id', $transaction->patient_id)->select('id')->first();
        $doctor = Practitioner::where('user_id', $transaction->doctor_id)->select('id')->first();

        foreach ($transactionRecipes as $transactionRecipe) {
            $transactionDetails = $transactionRecipe->transactionDetail;

            foreach ($transactionDetails as $index => $transactionDetail) {
                $validity = $this->getValidatyRequest($transactionDetail, $transactionRecipe);
                $medication = Medication::where('product_id', $transactionDetail->product_id)->first();

                if (! $medication) {
                    continue;
                }

                $data = [
                    'pending' => true,
                    'id' => null,
                    'transaction_detail_id' => $transactionDetail->id,
                    'company_id' => $transaction->company_id,
                    'patient_id' => $patient->id ?? null,
                    'encounter_id' => $encounter->id ?? null,
                    'medication_id' => $medication->id ?? null,
                    'requester_id' => $doctor->id ?? null,
                    'status' => 'active',
                    'intent' => 'order',
                    'category' => 'outpatient',
                    'priority' => 'routine',
                    'course_of_therapy' => 'continuous',
                    'dosage_instructions' => [
                        [
                            'sequence' => $index + 1,
                            'text' => $transactionRecipe->howToUse->name ?? '',
                            'additional_text' => $transactionRecipe->howToUse->description ?? '',
                            'patient_instruction' => $transactionRecipe->description ?? '',
                            'timing_repeat_frequency' => $transactionRecipe->howToUse->time ?? 1,
                            'timing_repeat_period' => $transactionRecipe->howToUse->day ?? 1,
                            'timing_repeat_period_unit' => 'd',
                            'route_coding_code' => $transactionRecipe->route_coding_code ?? null,
                            'dose_rate_type_coding_code' => 'ordered',
                            'dose_rate_quantity_value' => $transactionDetail->quantity ?? 0,
                            'dose_rate_quantity_code' => $transactionDetail->product->denominator_code ?? null,
                        ],
                    ],
                    'dispense_request' => [
                        'interval_value' => 1,
                        'interval_code' => 'd',
                        'validity_start' => $validity['validity_start'] ?? null,
                        'validity_end' => $validity['validity_end'] ?? null,
                        'number_repeat' => 0,
                        'quantity_value' => $transactionDetail->quantity ?? 0,
                        'quantity_code' => $transactionDetail->product->denominator_code ?? null,
                        'expect_value' => intval(Str::replace('.', '', number_format($validity['expect_value'] ?? 0, 0, ',', '.'))),
                        'expect_code' => 'd',
                    ],
                ];

                app(apiservice::class)->createMedicationRequest($data);
            }
        }
    }

    public function createMedicine()
    {
        $this->transaction_recipe_id = null; // Reset transaction_recipe_id
        $this->type = 'medicine';

        return $this->dispatch('open-modal', ['id' => 'modalProduct']);
    }

    private function getValidatyRequest($transactionDetail, $transactionRecipe): array
    {
        $total_obat = $transactionDetail->quantity ?? 0;
        $frekuensi_per_hari = $transactionRecipe->howToUse->time ?? 1;
        $interval_hari = $transactionRecipe->howToUse->day ?? 1;
        $tanggal_mulai = $transactionDetail->created_at?->format('Y-m-d') ?? now()->format('Y-m-d');

        $tanggal_mulai_obj = new \DateTime($tanggal_mulai);

        if ($interval_hari == 1) {
            // Harian
            $jumlah_hari = ceil($total_obat / $frekuensi_per_hari);
            $tanggal_habis = clone $tanggal_mulai_obj;
            $tanggal_habis->modify('+'.($jumlah_hari - 1).' days');
        } else {
            // Interval hari
            $jumlah_hari = ($total_obat - 1) * $interval_hari;
            $tanggal_habis = clone $tanggal_mulai_obj;
            $tanggal_habis->modify("+$jumlah_hari days");
        }

        return [
            'validity_start' => $tanggal_mulai_obj->format('Y-m-d'),
            'validity_end' => $tanggal_habis->format('Y-m-d'),
            'expect_value' => $jumlah_hari,
        ];
    }

    public function openModalHowToUse($transactionRecipeId)
    {
        $this->transaction_recipe_id = $transactionRecipeId;
        $this->dispatch('open-modal', ['id' => 'modalHowToUse']);
    }

    public function closeModalHowToUse()
    {
        $this->reset(['transaction_recipe_id', 'name_how_to_use', 'description_how_to_use', 'day_how_to_use', 'time_how_to_use']);
        $this->dispatch('close-modal', ['id' => 'modalHowToUse']);
    }

    public function saveHowToUse()
    {
        $this->validate([
            'name_how_to_use' => 'required|string|max:255',
            'description_how_to_use' => 'required|string|max:500',
            'day_how_to_use' => 'required|integer|min:1|max:30',
            'time_how_to_use' => 'required|integer|min:1|max:24',
        ]);

        $transactionRecipe = TransactionRecipe::find($this->transaction_recipe_id);
        if (! $transactionRecipe) {
            return AlertHelper::error('Gagal', 'Resep tidak ditemukan.');
        }

        $transactionRecipe->how_to_use_id = HowToUse::create([
            'name' => $this->name_how_to_use,
            'description' => $this->description_how_to_use,
            'day' => $this->day_how_to_use,
            'time' => $this->time_how_to_use,
        ])->id;

        $transactionRecipe->save();

        $this->closeModalHowToUse();
        $this->detailMedicine();

        return AlertHelper::success('Berhasil', 'Cara penggunaan berhasil disimpan.');
    }

    public function confirmDeleteTransactionRecipe($transactionRecipeId)
    {
        return AlertHelper::confirmDelete('deleteTransactionRecipe', 'Apakah Anda yakin ingin menghapus item ini?', $transactionRecipeId);
    }

    public function deleteTransactionRecipe($transactionRecipeId)
    {
        $transactionRecipe = TransactionRecipe::find($transactionRecipeId[0]);

        if ($transactionRecipe) {
            TransactionDetail::where('transaction_recipe_id', $transactionRecipe->id)
                ->where('transaction_id', $this->transaction_id)
                ->delete();

            $transactionRecipe->delete();
            $this->getRecipes();
            $this->updateTotal();
            AlertHelper::success('Berhasil', 'Item berhasil dihapus dari keranjang.');
        } else {
            AlertHelper::error('Gagal', 'Item tidak ditemukan.');
        }
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
}
