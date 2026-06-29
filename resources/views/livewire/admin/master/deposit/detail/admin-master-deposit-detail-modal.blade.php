<!-- Modal Tambah/Edit Item -->
@if ($showAddItemModal)
    <div class="fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full z-50">
        <div class="relative top-20 mx-auto p-5 border w-11/12 md:w-2/3 lg:w-1/2 shadow-lg rounded-md bg-white">
            <div class="mt-3">
                <div class="flex justify-between items-center mb-4">
                    <h3 class="text-lg font-semibold text-gray-900">
                        {{ $isEditItem ? 'Edit Item' : 'Tambah Item Baru' }}
                    </h3>
                    <button wire:click="closeAddItemModal()" class="text-gray-400 hover:text-gray-600">
                        <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>

                <form wire:submit.prevent="saveItem">
                    {{-- <!-- Debug Info -->
                    <div class="mb-4 p-2 bg-gray-100 rounded text-xs">
                        <strong>Debug Info:</strong><br>
                        Product ID: {{ $product_id ?? 'null' }}<br>
                        Product Name: {{ $product_name ?? 'null' }}<br>
                        Item Name: {{ $item_name ?? 'null' }}<br>
                        Item Price: {{ $item_price ?? 'null' }}<br>
                        Item Quantity: {{ $item_quantity ?? 'null' }}<br>
                        Show Add Item Modal: {{ $showAddItemModal ? 'true' : 'false' }}<br>
                        Show Add Product Modal: {{ $showAddProductModal ? 'true' : 'false' }}
                    </div> --}}

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div class="md:col-span-2">
                            <button type="button" wire:click="openAddProductModal()"
                                class="w-full px-4 py-2 bg-blue-500 text-white rounded-md hover:bg-blue-600 mb-4">
                                <i class="fas fa-search mr-2"></i>Cari Produk
                            </button>
                        </div>

                        <div class="md:col-span-2" wire:key="item-name-{{ $item_name }}-{{ rand() }}">
                            <label class="block text-sm font-medium text-gray-700 mb-2">
                                Nama Item <span class="text-red-500">*</span>
                            </label>
                            <input type="text" wire:model.live="item_name" class="form-control disabled"
                                placeholder="Masukkan nama item" required>
                            @error('item_name')
                                <span class="text-red-500 text-xs">{{ $message }}</span>
                            @enderror
                        </div>

                        <div wire:key="quantity-{{ $item_quantity }}">
                            <label class="block text-sm font-medium text-gray-700 mb-2">
                                Quantity <span class="text-red-500">*</span>
                            </label>
                            <input type="number" wire:model.live="item_quantity" min="1" step="1"
                                class="form-control disabled" required>
                            @error('item_quantity')
                                <span class="text-red-500 text-xs">{{ $message }}</span>
                            @enderror
                        </div>
                        <div wire:key="price-{{ $item_price }}-{{ rand() }}">
                            <label class="block text-sm font-medium text-gray-700 mb-2">
                                Harga <span class="text-red-500">*</span>
                            </label>
                            <input type="number" disabled wire:model.live="item_price" min="0" step="0.01"
                                class="form-control disabled" required>
                            @error('item_price')
                                <span class="text-red-500 text-xs">{{ $message }}</span>
                            @enderror
                        </div>
                        {{--
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Diskon</label>
                            <input type="number" wire:model="item_discount" min="0" step="0.01"
                                class="form-control disabled">
                            @error('item_discount')
                                <span class="text-red-500 text-xs">{{ $message }}</span>
                            @enderror
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Tipe Item</label>
                            <select wire:model="item_type"
                                class="form-control disabled">
                                <option value="single">Single</option>
                                <option value="partial">Partial</option>
                                <option value="gramasi">Gramasi</option>
                            </select>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Tipe Transaksi</label>
                            <select wire:model="type_transaction"
                                class="form-control disabled">
                                <option value="medicine">Obat</option>
                                <option value="action">Tindakan</option>
                                <option value="recipe">Resep</option>
                                <option value="other">Lainnya</option>
                            </select>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Opsi</label>
                            <div class="space-y-2">
                                <label class="flex items-center">
                                    <input type="checkbox" wire:model="is_free_item" class="mr-2">
                                    <span class="text-sm">Item Gratis</span>
                                </label>
                                <label class="flex items-center">
                                    <input type="checkbox" wire:model="is_narcotic" class="mr-2">
                                    <span class="text-sm">Obat Narkotika</span>
                                </label>
                            </div>
                        </div>

                        <div class="md:col-span-2">
                            <label class="block text-sm font-medium text-gray-700 mb-2">Deskripsi</label>
                            <textarea wire:model="item_description" rows="3"
                                class="form-control disabled"
                                placeholder="Deskripsi item (opsional)"></textarea>
                        </div> --}}

                        @if ($item_quantity && $item_price)
                            <div class="md:col-span-2">
                                <div class="bg-blue-50 border border-blue-200 rounded-md p-3">
                                    <p class="text-sm text-blue-800">
                                        <strong>Subtotal: Rp
                                            {{ number_format($item_quantity * $item_price - ($item_discount ?? 0), 0, ',', '.') }}</strong>
                                    </p>
                                </div>
                            </div>
                        @endif
                    </div>

                    <div class="mt-6 flex justify-end gap-3">
                        <button type="button" wire:click="closeAddItemModal()"
                            class="px-4 py-2 bg-gray-300 text-gray-700 rounded-md hover:bg-gray-400">
                            Batal
                        </button>
                        <button type="submit" class="px-4 py-2 bg-blue-500 text-white rounded-md hover:bg-blue-600">
                            {{ $isEditItem ? 'Update Item' : 'Simpan Item' }}
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endif

<!-- Modal Tambah/Edit Pembayaran -->
@if ($showAddPaymentModal)
    <div class="fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full z-50">
        <div class="relative top-20 mx-auto p-5 border w-11/12 md:w-1/2 shadow-lg rounded-md bg-white">
            <div class="mt-3">
                <div class="flex justify-between items-center mb-4">
                    <h3 class="text-lg font-semibold text-gray-900">
                        {{ $isEditPayment ? 'Edit Pembayaran' : 'Tambah Pembayaran Baru' }}
                    </h3>
                    <button wire:click="closeAddPaymentModal()" class="text-gray-400 hover:text-gray-600">
                        <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>

                <form wire:submit.prevent="savePayment">
                    <div class="space-y-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">
                                Metode Pembayaran <span class="text-red-500">*</span>
                            </label>
                            <select wire:model="payment_method_id" class="form-control disabled" required>
                                <option value="">Pilih Metode Pembayaran</option>
                                @foreach ($paymentMethods as $method)
                                    <option value="{{ $method['id'] }}">{{ $method['name'] }}</option>
                                @endforeach
                            </select>
                            @error('payment_method_id')
                                <span class="text-red-500 text-xs">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            {{-- <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">
                                    Jumlah Pembayaran <span class="text-red-500">*</span>
                                </label>
                                <input type="number" wire:model="payment_amount" min="0" step="0.01"
                                    class="form-control disabled" required>
                                @error('payment_amount')
                                    <span class="text-red-500 text-xs">{{ $message }}</span>
                                @enderror
                            </div> --}}

                            <div class="md:col-span-2">
                                <label class="block text-sm font-medium text-gray-700 mb-2">
                                    Pembayaran <span class="text-red-500">*</span>
                                </label>
                                <input type="number" wire:model="payment_real" minz="0" step="0.01"
                                    class="form-control disabled" required>
                                @error('payment_real')
                                    <span class="text-red-500 text-xs">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                        {{--
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Biaya Admin</label>
                            <input type="number" wire:model="admin_fee" min="0" step="0.01"
                                class="form-control disabled">
                            @error('admin_fee')
                                <span class="text-red-500 text-xs">{{ $message }}</span>
                            @enderror
                        </div> --}}

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Deskripsi</label>
                            <textarea wire:model="payment_description" rows="3" class="form-control disabled"
                                placeholder="Deskripsi pembayaran (opsional)"></textarea>
                        </div>
                        {{--
                        <div>
                            <label class="flex items-center">
                                <input type="checkbox" wire:model="is_single_payment" class="mr-2">
                                <span class="text-sm">Pembayaran Tunggal</span>
                            </label>
                        </div> --}}
                    </div>

                    <div class="mt-6 flex justify-end gap-3">
                        <button type="button" wire:click="closeAddPaymentModal()"
                            class="px-4 py-2 bg-gray-300 text-gray-700 rounded-md hover:bg-gray-400">
                            Batal
                        </button>
                        <button type="submit" class="px-4 py-2 bg-blue-500 text-white rounded-md hover:bg-blue-600">
                            {{ $isEditPayment ? 'Update Pembayaran' : 'Simpan Pembayaran' }}
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endif

<!-- Modal Pilih Produk -->
@if ($showAddProductModal)
    <div class="fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full z-50">
        <div class="relative top-20 mx-auto p-5 border w-11/12 md:w-2/3 lg:w-1/2 shadow-lg rounded-md bg-white">
            <div class="mt-3">
                <div class="flex justify-between items-center mb-4">
                    <h3 class="text-lg font-semibold text-gray-900">Pilih Produk</h3>
                    <button wire:click="closeAddProductModal()" class="text-gray-400 hover:text-gray-600">
                        <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>

                <div class="mb-4">
                    <input type="text" wire:model.live="searchProduct" wire:keyup="searchProducts"
                        class="form-control disabled" placeholder="Cari produk berdasarkan nama atau SKU...">
                </div>

                <div class="max-h-64 overflow-y-auto">
                    @if (count($productSearchResults) > 0)
                        @foreach ($productSearchResults as $product)
                            <div class="flex justify-between items-center p-3 border-b hover:bg-gray-50">
                                <div>
                                    <div class="font-medium">{{ $product['name'] }}</div>
                                    <div class="text-sm text-gray-500">
                                        SKU: {{ $product['sku_number'] ?? 'No SKU' }}
                                    </div>
                                    @if (isset($product['product_price']) && $product['product_price'] !== null)
                                        <div class="text-sm text-green-600">
                                            Rp {{ number_format($product['product_price']['price'], 0, ',', '.') }}
                                        </div>
                                    @endif
                                </div>
                                <button type="button" wire:click="selectProduct('{{ $product['id'] }}')"
                                    class="bg-blue-500 text-white px-3 py-1 rounded-md text-sm hover:bg-blue-600">
                                    Pilih
                                </button>
                            </div>
                        @endforeach
                    @else
                        <div class="text-center py-8 text-gray-500">
                            @if (strlen($searchProduct) >= 2)
                                <p>Tidak ada produk ditemukan</p>
                            @else
                                <p>Ketik minimal 2 karakter untuk mencari produk</p>
                            @endif
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endif
