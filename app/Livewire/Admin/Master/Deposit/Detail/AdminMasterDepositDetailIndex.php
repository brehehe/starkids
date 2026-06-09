<?php

namespace App\Livewire\Admin\Master\Deposit\Detail;

use App\Helpers\AlertHelper;
use App\Models\Deposit\Deposit;
use App\Models\Deposit\DepositItem;
use App\Models\Deposit\DepositPayment;
use App\Models\PaymentMethod\PaymentMethod;
use App\Models\Product\Product;
use App\Models\User;
use App\Models\User\UserType;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use Livewire\Component;
use Livewire\WithPagination;

class AdminMasterDepositDetailIndex extends Component
{
    use WithPagination;
    public $deposit_id;
    public $deposit;
    public $mode = 'view'; // 'create' or 'view'

    // Form variables for deposit
    public $code;
    public $patient_id;
    public $user_type_id;
    public $text;
    public $description;
    public $quantity_request = 0;
    public $quantity_free = 0;
    public $quantity = 0;
    public $status = 'waiting';
    public $unit_price = 0; // Akan dihitung dari total deposit items
    public $remaining_bill = 0; // Sisa tagihan
    public $payment_change = 0; // Kembalian

    // Arrays for dropdowns
    public $patients = [];
    public $userTypes = [];
    public $products = [];
    public $paymentMethods = [];

    // Modal states
    public $showAddItemModal = false;
    public $showAddPaymentModal = false;
    public $showAddProductModal = false;

    // Item form variables
    public $item_id;
    public $product_id;
    public $product_name;
    public $item_name;
    public $item_quantity = 1;
    public $item_price = 0;
    public $item_discount = 0;
    public $item_type = 'single';
    public $type_transaction = 'medicine';
    public $is_free_item = false;
    public $is_narcotic = false;
    public $item_description;

    // Payment form variables
    public $payment_id;
    public $payment_method_id;
    public $payment_amount = 0;
    public $payment_real = 0;
    public $admin_fee = 0;
    public $payment_description;
    public $is_single_payment = false;

    // Search variables
    public $searchProduct = '';
    public $productSearchResults = [];
    public $product_sku = '';

    // Items and payments arrays
    public $depositItems = [];
    public $depositPayments = [];
    public $tempItems = []; // For create mode temporary items

    // Edit states
    public $isEditItem = false;
    public $isEditPayment = false;
    public $isEditTempItem = false;
    public $editTempItemIndex = null;
    public $isDepositEditable = true; // Track if deposit can be edited

    public function mount($id = null)
    {
        // Determine mode based on route
        $routeName = request()->route()->getName();

        if ($routeName === 'user.master.deposit.create') {
            $this->mode = 'create';
            $this->mountCreateMode();
        } else {
            $this->mode = 'view';
            $this->mountViewMode($id);
        }

        // Check if deposit is editable after mounting
        $this->checkDepositEditable();
    }

    public function checkDepositEditable()
    {
        // In create mode, always editable
        if ($this->mode === 'create') {
            $this->isDepositEditable = true;
            return;
        }

        // In view mode, check deposit status
        if ($this->deposit && $this->deposit->status === 'success') {
            $this->isDepositEditable = false;
        } else {
            $this->isDepositEditable = true;
        }
    }

    public function mountCreateMode()
    {
        // Initialize for create mode
        $this->deposit_id = null;
        $this->deposit = null;
        $this->code = 'DEP-' . date('YmdHis');
        $this->loadDropdownData();

        // Initialize empty arrays
        $this->depositItems = [];
        $this->depositPayments = [];
        $this->tempItems = [];
    }

    public function mountViewMode($depositId = null)
    {
        // Use provided depositId or get from session
        $this->deposit_id = $depositId ?: session('deposit_id');

        if (!$this->deposit_id) {
            return redirect()->route('user.master.deposit');
        }

        $this->deposit = Deposit::with([
            'patient:id,name,phone',
            'userType:id,name',
            'depositItems.product:id,name,sku_number',
            'depositPayments.paymentMethod:id,name'
        ])->find($this->deposit_id);

        if ($this->deposit) {
            $this->loadFormData();
            $this->loadDropdownData();
            $this->getDepositItems();
            $this->getDepositPayments();
        }
    }

    public function loadFormData()
    {
        $this->code = $this->deposit->code;
        $this->patient_id = $this->deposit->patient_id;
        $this->user_type_id = $this->deposit->user_type_id;
        $this->text = $this->deposit->text;
        $this->description = $this->deposit->description;
        $this->quantity_request = $this->deposit->quantity_request;
        $this->quantity_free = $this->deposit->quantity_free;
        $this->quantity = $this->deposit->quantity;
        $this->remaining_bill = $this->deposit->remaining_bill ?? 0;
        $this->payment_change = $this->deposit->payment_change ?? 0;
        $this->status = $this->deposit->status;

        // Calculate unit_price: grand_total_price dibagi quantity_request (hanya yang berbayar)
        if ($this->quantity_request > 0 && $this->deposit->grand_total_price) {
            $this->unit_price = $this->deposit->grand_total_price / $this->quantity_request;
        }
    }

    public function loadDropdownData()
    {
        $companyId = Auth::user()->company_id;

        // Load patients - assuming you have a Patient model
        $this->patients = User::role(['Pasien'])
            ->where('company_id', $companyId)
            ->select('id', 'name', 'phone')
            ->get()
            ->toArray();

        // Load user types
        $this->userTypes = UserType::where('company_id', $companyId)
            ->select('id', 'name')
            ->get()
            ->toArray();

        // Load products
        $this->products = Product::where('company_id', $companyId)
            ->with('productPrice:id,product_id,price')
            ->select('id', 'name', 'sku_number')
            ->get()
            ->toArray();

        // Load payment methods
        $this->paymentMethods = PaymentMethod::where('company_id', $companyId)
            ->select('id', 'name')
            ->get()
            ->toArray();
    }

    public function getDepositItems()
    {
        $this->depositItems = [];

        $items = DepositItem::where('deposit_id', $this->deposit_id)
            ->with('product:id,name,sku_number')
            ->orderBy('created_at', 'asc')
            ->get();

        foreach ($items as $item) {
            $this->depositItems[] = [
                'id' => $item->id,
                'product_id' => $item->product_id,
                'product_name' => $item->product?->name ?? $item->name,
                'product_sku' => $item->product?->sku_number ?? '',
                'name' => $item->name,
                'quantity' => $item->quantity,
                'price' => $item->price,
                'discount' => $item->discount,
                'sub_total_price' => $item->sub_total_price,
                'type' => $item->type,
                'type_transaction' => $item->type_transaction,
                'is_free' => $item->is_free,
                'is_narcotic' => $item->is_narcotic,
                'description' => $item->description,
            ];
        }

        $this->updateTotals();
    }

    public function getDepositPayments()
    {
        $this->depositPayments = [];

        $payments = DepositPayment::where('deposit_id', $this->deposit_id)
            ->with('paymentMethod:id,name')
            ->orderBy('created_at', 'asc')
            ->get();

        foreach ($payments as $payment) {
            $this->depositPayments[] = [
                'id' => $payment->id,
                'payment_method_id' => $payment->payment_method_id,
                'payment_method_name' => $payment->paymentMethod?->name ?? '',
                'payment_amount' => $payment->payment_amount,
                'payment_real' => $payment->payment_real,
                'admin_fee' => $payment->admin_fee,
                'description' => $payment->description,
                'is_single' => $payment->is_single,
                'created_at' => $payment->created_at->format('d/m/Y H:i'),
            ];
        }

        $this->updateTotals();
    }

    public function updateTotals()
    {
        // Calculate total from items (harga barang per unit)
        $totalItems = collect($this->depositItems)->sum('sub_total_price');

        // Total quantity (request + free) untuk quantity total
        $totalQuantity = $this->quantity_request + $this->quantity_free;

        // Grand total = total items dikali HANYA quantity_request (quantity_free gratis)
        // Contoh: jika item_price = 5,000, quantity_request = 5, quantity_free = 2
        // maka grand_total = 5,000 x 5 = 25,000 (quantity_free tidak dihitung)
        $grandTotal = $totalItems * $this->quantity_request;

        // Calculate total payments
        $totalPayments = collect($this->depositPayments)->sum('payment_real');

        // Update deposit totals
        $this->deposit->grand_total_price = $grandTotal;
        $this->deposit->remaining_bill = $grandTotal - $totalPayments;

        // Update quantity
        $this->quantity = $totalQuantity;
    }

    public function openAddItemModal()
    {
        // Jangan reset form jika dipanggil dari selectProduct
        // Hanya reset jika benar-benar tambah item baru manual
        if (!$this->product_id) {
            $this->resetItemForm();
        }
        $this->showAddItemModal = true;
    }

    public function openAddItemModalFresh()
    {
        // Function terpisah untuk tambah item manual (bukan dari produk)
        $this->resetItemForm();
        $this->showAddItemModal = true;
    }

    public function closeAddItemModal()
    {
        $this->showAddItemModal = false;
        $this->resetItemForm();
    }

    public function resetItemForm()
    {
        $this->item_id = null;
        $this->product_id = null;
        $this->product_name = '';
        $this->item_name = '';
        $this->item_quantity = 1;
        $this->item_price = 0;
        $this->item_discount = 0;
        $this->item_type = 'single';
        $this->type_transaction = 'medicine';
        $this->is_free_item = false;
        $this->is_narcotic = false;
        $this->item_description = '';
        $this->isEditItem = false;
        $this->isEditTempItem = false;
        $this->editTempItemIndex = null;
    }

    public function editItem($itemId)
    {
        $item = collect($this->depositItems)->firstWhere('id', $itemId);

        if ($item) {
            $this->item_id = $item['id'];
            $this->product_id = $item['product_id'];
            $this->product_name = $item['product_name'];
            $this->item_name = $item['name'];
            $this->item_quantity = $item['quantity'];
            $this->item_price = $item['price'];
            $this->item_discount = $item['discount'];
            $this->item_type = $item['type'];
            $this->type_transaction = $item['type_transaction'];
            $this->is_free_item = $item['is_free'];
            $this->is_narcotic = $item['is_narcotic'];
            $this->item_description = $item['description'];
            $this->isEditItem = true;
            $this->showAddItemModal = true;
        }
    }

    public function saveItem()
    {
        // Check if deposit is editable
        if (!$this->isDepositEditable) {
            AlertHelper::error('error', 'Deposit yang sudah lunas tidak dapat diubah');
            return;
        }

        // For create mode, add to temporary items first
        if ($this->mode === 'create') {
            $this->addTempItem();
            return;
        }

        // For view mode, we need to create the deposit first if it doesn't exist
        if ($this->mode === 'view' && !$this->deposit_id) {
            $this->createDeposit();
            if (!$this->deposit_id) {
                return; // Failed to create deposit
            }
        }

        $this->validate([
            'item_name' => 'required|string|max:255',
            'item_quantity' => 'required|numeric|min:1',
            'item_price' => 'required|numeric|min:0',
            'item_discount' => 'nullable|numeric|min:0',
        ]);

        try {
            DB::beginTransaction();

            $subTotal = ($this->item_quantity * $this->item_price) - $this->item_discount;

            $data = [
                'deposit_id' => $this->deposit_id,
                'product_id' => $this->product_id,
                'name' => $this->item_name,
                'quantity' => $this->item_quantity,
                'price' => $this->item_price,
                'discount' => $this->item_discount ?? 0,
                'sub_total_price' => $subTotal,
                'type' => $this->item_type,
                'type_transaction' => $this->type_transaction,
                'is_free' => $this->is_free_item,
                'is_narcotic' => $this->is_narcotic,
                'description' => $this->item_description,
                'company_id' => Auth::user()->company_id,
            ];

            if ($this->isEditItem && $this->item_id) {
                DepositItem::where('id', $this->item_id)->update($data);
                AlertHelper::success('success', 'Item berhasil diperbarui');
            } else {
                DepositItem::create($data);
                AlertHelper::success('success', 'Item berhasil ditambahkan');
            }

            DB::commit();
            $this->closeAddItemModal();
            $this->getDepositItems();
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Error saving item: ' . $e->getMessage());
            AlertHelper::error('error', 'Terjadi kesalahan saat menyimpan item');
        }
    }

    public function deleteItem($itemId)
    {
        // Check if deposit is editable
        if (!$this->isDepositEditable) {
            AlertHelper::error('error', 'Deposit yang sudah lunas tidak dapat diubah');
            return;
        }

        try {
            DepositItem::where('id', $itemId)->delete();
            AlertHelper::success('success', 'Item berhasil dihapus');
            $this->getDepositItems();
        } catch (\Exception $e) {
            Log::error('Error deleting item: ' . $e->getMessage());
            AlertHelper::error('error', 'Terjadi kesalahan saat menghapus item');
        }
    }

    public function openAddPaymentModal()
    {
        $this->resetPaymentForm();
        $this->showAddPaymentModal = true;
    }

    public function closeAddPaymentModal()
    {
        $this->showAddPaymentModal = false;
        $this->resetPaymentForm();
    }

    public function resetPaymentForm()
    {
        $this->payment_id = null;
        $this->payment_method_id = null;
        $this->payment_amount = 0;
        $this->payment_real = 0;
        $this->admin_fee = 0;
        $this->payment_description = '';
        $this->is_single_payment = false;
        $this->isEditPayment = false;
    }

    public function editPayment($paymentId)
    {
        $payment = collect($this->depositPayments)->firstWhere('id', $paymentId);

        if ($payment) {
            $this->payment_id = $payment['id'];
            $this->payment_method_id = $payment['payment_method_id'];
            $this->payment_amount = $payment['payment_amount'];
            $this->payment_real = $payment['payment_real'];
            $this->admin_fee = $payment['admin_fee'];
            $this->payment_description = $payment['description'];
            $this->is_single_payment = $payment['is_single'];
            $this->isEditPayment = true;
            $this->showAddPaymentModal = true;
        }
    }

    public function savePayment()
    {
        // For create mode, we need to create the deposit first
        if ($this->mode === 'create' && !$this->deposit_id) {
            $this->createDeposit();
            if (!$this->deposit_id) {
                return; // Failed to create deposit
            }
        }

        // Check if deposit is editable (allow payment even for completed deposits to record overpayments or corrections)
        // But only allow editing existing payments if deposit is still editable
        // if ($this->isEditPayment && !$this->isDepositEditable) {
        //     AlertHelper::error('error', 'Pembayaran pada deposit yang sudah lunas tidak dapat diubah');
        //     return;
        // }

        $this->validate([
            'payment_method_id' => 'required|exists:payment_methods,id',
            'payment_amount' => 'required|numeric|min:0',
            'payment_real' => 'required|numeric|min:0',
        ]);

        try {
            DB::beginTransaction();

            $data = [
                'deposit_id' => $this->deposit_id,
                'payment_method_id' => $this->payment_method_id,
                'payment_amount' => $this->payment_amount,
                'payment_real' => $this->payment_real,
                'admin_fee' => $this->admin_fee ?? 0,
                'description' => $this->payment_description,
                'is_single_payment' => $this->is_single_payment ?? false,
                'company_id' => Auth::user()->company_id,
            ];

            if ($this->isEditPayment && $this->payment_id) {
                DepositPayment::where('id', $this->payment_id)->update($data);
                AlertHelper::success('success', 'Pembayaran berhasil diperbarui');
            } else {
                DepositPayment::create($data);
                AlertHelper::success('success', 'Pembayaran berhasil ditambahkan');
            }

            DB::commit();
            $this->closeAddPaymentModal();
            $this->getDepositPayments();

            // Check if deposit is fully paid after saving payment
            $this->checkDepositStatusAndRedirect();
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Error saving payment: ' . $e->getMessage());
            AlertHelper::error('error', 'Terjadi kesalahan saat menyimpan pembayaran');
        }
    }

    public function deletePayment($paymentId)
    {
        // Check if deposit is editable
        // if (!$this->isDepositEditable) {
        //     AlertHelper::error('error', 'Pembayaran pada deposit yang sudah lunas tidak dapat dihapus');
        //     return;
        // }

        try {
            DepositPayment::where('id', $paymentId)->delete();
            AlertHelper::success('success', 'Pembayaran berhasil dihapus');
            $this->getDepositPayments();
        } catch (\Exception $e) {
            Log::error('Error deleting payment: ' . $e->getMessage());
            AlertHelper::error('error', 'Terjadi kesalahan saat menghapus pembayaran');
        }
    }

    public function checkDepositStatusAndRedirect()
    {
        // Hitung total pembayaran
        $totalPayments = collect($this->depositPayments)->sum('payment_real');
        $grandTotal = $this->deposit->grand_total_price ?? 0;

        // Update status deposit berdasarkan pembayaran
        if ($totalPayments >= $grandTotal) {
            // Deposit sudah lunas atau lebih bayar
            $this->deposit->update([
                'status' => 'success',
                'remaining_bill' => 0,
                'payment_change' => $totalPayments > $grandTotal ? ($totalPayments - $grandTotal) : 0
            ]);

            // Update status editable after deposit becomes paid
            $this->checkDepositEditable();

            AlertHelper::success('success', 'Pembayaran telah lunas! Kembali ke menu deposit...');

            // Redirect ke menu deposit setelah 2 detik
            $this->dispatch('redirect-after-delay', [
                'url' => route('user.master.deposit'),
                'delay' => 2000
            ]);
        } elseif ($totalPayments > 0) {
            // Sebagian terbayar
            $this->deposit->update([
                'status' => 'partial',
                'remaining_bill' => $grandTotal - $totalPayments,
                'payment_change' => 0
            ]);
        }
    }

    public function redirectToDepositMenu()
    {
        return redirect()->route('user.master.deposit');
    }

    public function openAddProductModal()
    {
        $this->searchProduct = '';
        $this->productSearchResults = [];
        $this->showAddProductModal = true;
    }

    public function closeAddProductModal()
    {
        $this->showAddProductModal = false;
        $this->searchProduct = '';
        $this->productSearchResults = [];
    }

    public function searchProducts()
    {
        if (strlen($this->searchProduct) >= 2) {
            try {
                $this->productSearchResults = Product::where('company_id', Auth::user()->company_id)
                    ->where(function ($query) {
                        $query->where('name', 'ilike', '%' . $this->searchProduct . '%')
                            ->orWhere('sku_number', 'ilike', '%' . $this->searchProduct . '%');
                    })
                    ->with(['productPrice:id,product_id,price'])
                    ->select('id', 'name', 'sku_number')
                    ->limit(10)
                    ->get()
                    ->map(function ($product) {
                        return [
                            'id' => $product->id,
                            'name' => $product->name,
                            'sku_number' => $product->sku_number,
                            'product_price' => $product->productPrice ? [
                                'id' => $product->productPrice->id,
                                'product_id' => $product->productPrice->product_id,
                                'price' => $product->productPrice->price
                            ] : null
                        ];
                    })
                    ->toArray();
            } catch (\Exception $e) {
                Log::error('Error searching products: ' . $e->getMessage());
                $this->productSearchResults = [];
                AlertHelper::error('error', 'Terjadi kesalahan saat mencari produk');
            }
        } else {
            $this->productSearchResults = [];
        }
    }

    public function selectProduct($productId)
    {
        try {
            // Find product from search results
            $product = null;
            foreach ($this->productSearchResults as $searchProduct) {
                if ($searchProduct['id'] == $productId) {
                    $product = $searchProduct;
                    break;
                }
            }

            if ($product) {
                // Set product data FIRST, then reset only the fields we don't want to keep
                $this->product_id = $product['id'];
                $this->product_name = $product['name'];
                $this->item_name = $product['name'];

                // Set product SKU for temporary items
                if (isset($product['sku_number'])) {
                    $this->product_sku = $product['sku_number'];
                }

                // Set price if available - fix structure for hasOne relationship
                if (isset($product['product_price']) && $product['product_price'] !== null) {
                    $this->item_price = intval($product['product_price']['price'] ?? 0);
                } else {
                    $this->item_price = 0;
                }

                // Set default quantity and other fields
                $this->item_quantity = 1;
                $this->item_discount = 0;
                $this->item_description = '';
                $this->is_free_item = false;
                $this->is_narcotic = false;
                $this->isEditItem = false;
                $this->isEditTempItem = false;
                $this->editTempItemIndex = null;

                $this->closeAddProductModal();

                // Open item modal
                $this->openAddItemModal();

                AlertHelper::success('success', 'Produk ' . $product['name'] . ' berhasil dipilih');
            } else {
                AlertHelper::error('error', 'Produk tidak ditemukan');
            }
        } catch (\Exception $e) {
            Log::error('Error selecting product: ' . $e->getMessage());
            AlertHelper::error('error', 'Terjadi kesalahan saat memilih produk');
        }
    }

    public function createDeposit()
    {
        $this->validate([
            'patient_id' => 'required|exists:users,id',
            'quantity_request' => 'required|numeric|min:0',
        ]);

        try {
            DB::beginTransaction();

            $totalQuantity = $this->quantity_request + $this->quantity_free;

            // Hitung total dari semua deposit items (ini adalah total harga barang per unit)
            $tempItemsTotal = 0;
            if (!empty($this->tempItems)) {
                $tempItemsTotal = collect($this->tempItems)->sum('sub_total_price');
            }

            // Total harga barang dikali HANYA quantity_request (quantity_free gratis)
            // Contoh: jika item_price = 5,000, quantity_request = 5, quantity_free = 2
            // maka subtotal = 5,000 x 5 = 25,000 (quantity_free tidak dihitung)
            $subTotalPrice = $tempItemsTotal * $this->quantity_request;
            $grandTotalPrice = $subTotalPrice;

            // Unit price adalah subtotal dibagi quantity_request (untuk referensi saja)
            $this->unit_price = ($this->quantity_request > 0) ? ($subTotalPrice / $this->quantity_request) : 0;

            // Hitung remaining_bill (awalnya sama dengan grand_total_price)
            $this->remaining_bill = $grandTotalPrice;

            // payment_change awalnya 0 karena belum ada pembayaran
            $this->payment_change = 0;

            $depositData = [
                'code' => $this->code,
                'patient_id' => $this->patient_id,
                'user_type_id' => $this->user_type_id,
                'text' => $this->text,
                'description' => $this->description,
                'quantity_request' => $this->quantity_request,
                'quantity_free' => $this->quantity_free,
                'quantity' => $totalQuantity,
                'remaining_quantity' => 0, // Initially same as total quantity
                'sub_total_price' => $subTotalPrice,
                'grand_total_price' => $grandTotalPrice,
                'remaining_bill' => $this->remaining_bill,
                'payment_change' => $this->payment_change,
                'status' => $this->status,
                'company_id' => Auth::user()->company_id,
            ];

            $this->deposit = Deposit::create($depositData);
            $this->deposit_id = $this->deposit->id;

            // Save temporary items to database
            foreach ($this->tempItems as $tempItem) {
                $itemData = [
                    'deposit_id' => $this->deposit_id,
                    'product_id' => $tempItem['product_id'],
                    'name' => $tempItem['name'],
                    'quantity' => $tempItem['quantity'],
                    'price' => $tempItem['price'],
                    'discount' => $tempItem['discount'],
                    'sub_total_price' => $tempItem['sub_total_price'],
                    'type' => $tempItem['type'],
                    'type_transaction' => $tempItem['type_transaction'],
                    'is_free' => $tempItem['is_free'],
                    'is_narcotic' => $tempItem['is_narcotic'],
                    'description' => $tempItem['description'],
                    'company_id' => Auth::user()->company_id,
                ];

                DepositItem::create($itemData);
            }

            // Save deposit ID to session for future reference
            session(['deposit_id' => $this->deposit_id]);

            DB::commit();
            AlertHelper::success('success', 'Deposit berhasil dibuat');

            sleep(2);

            return redirect()->route('user.master.deposit.detail', ['id' => $this->deposit_id]);

            // Dispatch event to show success and allow navigation choices
            $this->dispatch('deposit-created-success', depositId: $this->deposit_id);
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Error creating deposit: ' . $e->getMessage());
            AlertHelper::error('error', 'Terjadi kesalahan saat membuat deposit');
        }
    }

    public function updateDeposit()
    {
        if ($this->mode === 'create') {
            $this->createDeposit();
            return;
        }

        // Check if deposit is editable
        if (!$this->isDepositEditable) {
            AlertHelper::error('error', 'Deposit yang sudah lunas tidak dapat diubah');
            return;
        }

        $this->validate([
            'patient_id' => 'required|exists:users,id',
            'quantity_request' => 'required|numeric|min:0',
        ]);

        try {
            DB::beginTransaction();

            $this->deposit->update([
                'patient_id' => $this->patient_id,
                'user_type_id' => $this->user_type_id,
                'text' => $this->text,
                'description' => $this->description,
                'quantity_request' => $this->quantity_request,
                'quantity_free' => $this->quantity_free,
                'quantity' => $this->quantity_request + $this->quantity_free,
                'status' => $this->status,
            ]);

            DB::commit();
            AlertHelper::success('success', 'Deposit berhasil diperbarui');
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Error updating deposit: ' . $e->getMessage());
            AlertHelper::error('error', 'Terjadi kesalahan saat memperbarui deposit');
        }
    }

    public function switchToCreateMode()
    {
        return redirect()->route('user.master.deposit.create');
    }

    public function switchToViewMode($depositId = null)
    {
        // Use provided depositId or current deposit_id
        $targetDepositId = $depositId ?: $this->deposit_id;

        if ($targetDepositId) {
            return redirect()->route('user.master.deposit.detail', ['id' => $targetDepositId]);
        }

        // If no deposit ID available, redirect to deposit menu
        return redirect()->route('user.master.deposit');
    }

    // Functions for temporary items in create mode
    public function addTempItem()
    {
        $this->validate([
            'item_name' => 'required|string|max:255',
            'item_quantity' => 'required|numeric|min:1',
            'item_price' => 'required|numeric|min:0',
            'item_discount' => 'nullable|numeric|min:0',
        ]);

        $subTotal = ($this->item_quantity * $this->item_price) - ($this->item_discount ?? 0);

        $tempItem = [
            'product_id' => $this->product_id,
            'product_name' => $this->product_name ?: $this->item_name,
            'product_sku' => '',
            'name' => $this->item_name,
            'quantity' => $this->item_quantity,
            'price' => $this->item_price,
            'discount' => $this->item_discount ?? 0,
            'sub_total_price' => $subTotal,
            'type' => $this->item_type,
            'type_transaction' => $this->type_transaction,
            'is_free' => $this->is_free_item,
            'is_narcotic' => $this->is_narcotic,
            'description' => $this->item_description,
        ];

        if ($this->isEditTempItem && $this->editTempItemIndex !== null) {
            $this->tempItems[$this->editTempItemIndex] = $tempItem;
            AlertHelper::success('success', 'Item berhasil diperbarui');
        } else {
            $this->tempItems[] = $tempItem;
            AlertHelper::success('success', 'Item berhasil ditambahkan');
        }

        // Recalculate deposit totals after adding/updating item
        $this->recalculateDeposit();

        $this->closeAddItemModal();
    }

    public function editTempItem($index)
    {
        if (isset($this->tempItems[$index])) {
            $item = $this->tempItems[$index];

            $this->product_id = $item['product_id'];
            $this->product_name = $item['product_name'];
            $this->item_name = $item['name'];
            $this->item_quantity = $item['quantity'];
            $this->item_price = $item['price'];
            $this->item_discount = $item['discount'];
            $this->item_type = $item['type'];
            $this->type_transaction = $item['type_transaction'];
            $this->is_free_item = $item['is_free'];
            $this->is_narcotic = $item['is_narcotic'];
            $this->item_description = $item['description'];

            $this->isEditTempItem = true;
            $this->editTempItemIndex = $index;
            $this->showAddItemModal = true;
        }
    }

    public function confirmremoveTempItem($index)
    {
        return AlertHelper::confirmDelete('removeTempItem', 'Apakah Anda yakin ingin menghapus item ini?', $index);
    }

    public function removeTempItem($index)
    {
        $index = $index[0];

        if (isset($this->tempItems[$index])) {
            unset($this->tempItems[$index]);
            $this->tempItems = array_values($this->tempItems); // Re-index array

            // Recalculate deposit totals after removing item
            $this->recalculateDeposit();

            AlertHelper::success('success', 'Item berhasil dihapus');
        }
    }

    public function updatedQuantityRequest()
    {
        $this->quantity_request = intval($this->quantity_request) ?? 0;

        // Automatically update quantity when quantity_request changes
        $this->quantity = $this->quantity_request + $this->quantity_free;
        // Update calculated values
        $this->recalculateDeposit();
    }

    public function updatedQuantityFree()
    {
        $this->quantity_free = intval($this->quantity_free) ?? 0;

        // Automatically update quantity when quantity_free changes
        $this->quantity = $this->quantity_request + $this->quantity_free;
        // Update calculated values
        $this->recalculateDeposit();
    }

    public function recalculateDeposit()
    {
        // Hitung total dari semua deposit items (ini adalah total harga barang per unit)
        $tempItemsTotal = 0;
        if (!empty($this->tempItems)) {
            $tempItemsTotal = collect($this->tempItems)->sum('sub_total_price');
        }

        // Total harga barang dikali HANYA quantity_request (quantity_free gratis)
        // Contoh: jika item_price = 5,000, quantity_request = 5, quantity_free = 2
        // maka subtotal = 5,000 x 5 = 25,000 (quantity_free tidak dihitung)
        $totalQuantity = $this->quantity_request + $this->quantity_free;
        $subTotal = $tempItemsTotal * $this->quantity_request;

        // Unit price adalah subtotal dibagi quantity_request (untuk referensi saja)
        $this->unit_price = ($this->quantity_request > 0) ? ($subTotal / $this->quantity_request) : 0;

        // Hitung remaining_bill (subtotal - total payments)
        $totalPayments = collect($this->depositPayments)->sum('payment_real');
        $this->remaining_bill = $subTotal - $totalPayments;

        // payment_change jika lebih bayar
        $this->payment_change = ($this->remaining_bill < 0) ? abs($this->remaining_bill) : 0;
        $this->remaining_bill = max(0, $this->remaining_bill);
    }

    public function calculateSubtotal()
    {
        // Hitung total dari semua deposit items (harga per unit)
        $tempItemsTotal = 0;
        if (!empty($this->tempItems)) {
            $tempItemsTotal = collect($this->tempItems)->sum('sub_total_price');
        }

        // Total harga barang dikali HANYA quantity_request (quantity_free gratis)
        // Contoh: jika item_price = 5,000, quantity_request = 5, quantity_free = 2
        // maka subtotal = 5,000 x 5 = 25,000 (quantity_free tidak dihitung)
        return $tempItemsTotal * $this->quantity_request;
    }

    public function render()
    {
        return view('livewire.admin.master.deposit.detail.admin-master-deposit-detail-index')
            ->extends('layout.app')
            ->section('content');
    }
}
