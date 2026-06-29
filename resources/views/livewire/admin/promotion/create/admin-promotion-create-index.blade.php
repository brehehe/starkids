<div>
    {{-- Header Section --}}
    <div class="mb-6">
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-2xl font-bold text-gray-900">
                    {{ $promotion_id ? 'Edit Promosi' : 'Buat Promosi Baru' }}
                </h1>
                <p class="text-gray-600 mt-1">Buat dan kelola promosi untuk meningkatkan penjualan</p>
            </div>
            <div class="flex space-x-3">
                <button type="button" wire:click="cancel" class="btn btn-danger">
                    <i class="fas fa-times mr-2"></i>Batal
                </button>
                <button type="button" wire:click="save" class="btn btn-primary">
                    <i class="fas fa-save mr-2"></i>Simpan
                </button>
            </div>
        </div>
    </div>

    <form wire:submit.prevent="save">
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            {{-- Main Content --}}
            <div class="lg:col-span-2 space-y-6">

                {{-- Basic Information --}}
                <div class="bg-white rounded-xl shadow-sm border p-6">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4">
                        <i class="fas fa-info-circle text-blue-500 mr-2"></i>Informasi Dasar
                    </h3>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div class="md:col-span-2">
                            <label class="block text-sm font-medium text-gray-700 mb-2">
                                Nama Promosi <span class="text-red-500">*</span>
                            </label>
                            <input type="text" wire:model.lazy="name" class="form-control"
                                placeholder="Contoh: Flash Sale Akhir Tahun">
                            @error('name')
                                <span class="text-red-500 text-xs">{{ $message }}</span>
                            @enderror
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">
                                Kode Promosi <span class="text-red-500">*</span>
                            </label>
                            <div class="mt-1 flex rounded-md shadow-sm">
                                <input type="text" wire:model.lazy="code" class="form-control rounded-r-none"
                                    placeholder="KODEPROMO123">
                                <span wire:click="generateCode"
                                    class="inline-flex items-center rounded-r-md border border-r-0 border-gray-300 bg-gray-100 px-3 text-gray-500 text-sm">
                                    <i class="fas fa-refresh"></i>
                                </span>
                            </div>
                            @error('code')
                                <span class="text-red-500 text-xs">{{ $message }}</span>
                            @enderror
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">
                                Tipe Promosi <span class="text-red-500">*</span>
                            </label>
                            <select wire:model.lazy="type" class="form-control">
                                @foreach ($promotionTypes as $value => $label)
                                    <option value="{{ $value }}">{{ $label }}</option>
                                @endforeach
                            </select>
                            @error('type')
                                <span class="text-red-500 text-xs">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="md:col-span-2">
                            <label class="block text-sm font-medium text-gray-700 mb-2">Deskripsi</label>
                            <textarea wire:model.lazy="description" class="form-control" rows="3"
                                placeholder="Jelaskan detail promosi ini..."></textarea>
                        </div>
                    </div>
                </div>

                {{-- Promotion Configuration --}}
                <div class="bg-white rounded-xl shadow-sm border p-6">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4">
                        <i class="fas fa-cogs text-green-500 mr-2"></i>Konfigurasi Promosi
                    </h3>

                    {{-- 🎯 INFO BOX - Promotion Type Guide --}}
                    @if ($type)
                        <div
                            class="mb-6 p-4 bg-gradient-to-r from-blue-50 to-cyan-50 border-l-4 border-blue-400 rounded-r-lg">
                            <div class="flex items-start">
                                <div class="flex-shrink-0">
                                    @if ($type === 'discount')
                                        <i class="fas fa-percentage text-blue-500 text-xl"></i>
                                    @elseif($type === 'buy_x_get_y')
                                        <i class="fas fa-gift text-green-500 text-xl"></i>
                                    @elseif($type === 'bundle')
                                        <i class="fas fa-box text-purple-500 text-xl"></i>
                                    @elseif($type === 'special')
                                        <i class="fas fa-star text-yellow-500 text-xl"></i>
                                    @endif
                                </div>
                                <div class="ml-3">
                                    <h4 class="text-sm font-medium text-gray-900">
                                        {{ $promotionTypes[$type] }} - Panduan Penggunaan
                                    </h4>
                                    <div class="mt-2 text-sm text-gray-700">
                                        @if ($type === 'discount')
                                            <p><strong>💰 Cara Kerja:</strong> Memberikan potongan harga langsung pada
                                                produk yang dipilih</p>
                                            <p><strong>🎯 Cocok untuk:</strong> Flash sale, clearance, diskon harian</p>
                                            <p><strong>⚡ Tips:</strong> Gunakan persentase untuk produk mahal, nominal
                                                untuk produk murah</p>
                                        @elseif($type === 'buy_x_get_y')
                                            <p><strong>🎁 Cara Kerja:</strong> Beli sejumlah produk, dapatkan produk
                                                gratis/diskon</p>
                                            <p><strong>🎯 Cocok untuk:</strong> Promosi produk slow-moving,
                                                cross-selling</p>
                                            <p><strong>⚡ Tips:</strong> Pilih produk gratis yang profitable dan menarik
                                            </p>
                                        @elseif($type === 'bundle')
                                            <p><strong>📦 Cara Kerja:</strong> Paket beberapa produk dengan harga khusus
                                            </p>
                                            <p><strong>🎯 Cocok untuk:</strong> Produk komplementer, paket hemat</p>
                                            <p><strong>⚡ Tips:</strong> Bundle produk yang sering dibeli bersamaan</p>
                                        @elseif($type === 'discount_product')
                                            <p><strong>🎯 Cara Kerja:</strong> Pilih produk dan beri diskon individual
                                                atau bulk</p>
                                            <p><strong>🎯 Cocok untuk:</strong> Flash sale, clearance, produk seasonal
                                            </p>
                                            <p><strong>⚡ Tips:</strong> Pilih beberapa produk dan atur diskon
                                                masing-masing secara cepat</p>
                                        @elseif($type === 'special')
                                            <p><strong>⭐ Cara Kerja:</strong> Promosi khusus seperti cashback</p>
                                            <p><strong>🎯 Cocok untuk:</strong> Customer retention, loyalty program</p>
                                            <p><strong>⚡ Tips:</strong> Sesuaikan dengan tipe pelanggan target</p>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endif

                    {{-- Discount Configuration --}}
                    @if ($type === 'discount')
                        <div class="space-y-4">
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2">
                                        Tipe Diskon <span class="text-red-500">*</span>
                                    </label>
                                    <select wire:model.lazy="discount_type" class="form-control">
                                        @foreach ($discountTypes as $value => $label)
                                            <option value="{{ $value }}">{{ $label }}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2">
                                        Nilai Diskon <span class="text-red-500">*</span>
                                    </label>
                                    <div class="relative">
                                        <input type="number" wire:model.lazy="discount_value"
                                            class="form-control pr-12" placeholder="0" step="0.01" min="0"
                                            @if ($discount_type === 'percentage') max="100" @endif>
                                        <div
                                            class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none">
                                            <span class="text-gray-500 text-sm">
                                                @if ($discount_type === 'percentage')
                                                    %
                                                @else
                                                    Rp
                                                @endif
                                            </span>
                                        </div>
                                    </div>
                                    @error('discount_value')
                                        <span class="text-red-500 text-xs">{{ $message }}</span>
                                    @enderror
                                </div>

                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2">Minimal Pembelian
                                        (Rp)</label>
                                    <input type="number" wire:model.lazy="minimum_purchase" class="form-control"
                                        placeholder="0" step="0.01" min="0">
                                </div>

                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2">Maksimal Pembelian
                                        (Rp)</label>
                                    <input type="number" wire:model.lazy="max_discount" class="form-control"
                                        placeholder="Tidak terbatas" step="0.01" min="0">
                                    <p class="text-xs text-gray-500 mt-1">Kosongkan jika tidak ada batas maksimal
                                    </p>
                                </div>


                            </div>

                            {{-- 📊 Real-time Preview untuk Discount --}}
                            @if ($discount_value > 0)
                                <div
                                    class="bg-gradient-to-r from-green-50 to-blue-50 border border-green-200 rounded-lg p-4">
                                    <h5 class="font-semibold text-green-800 mb-3 flex items-center">
                                        <i class="fas fa-calculator mr-2"></i>Preview Contoh Perhitungan
                                    </h5>
                                    <div class="grid grid-cols-3 gap-4 text-sm">
                                        @php
                                            $samplePrices = [50000, 100000, 250000];
                                        @endphp
                                        @foreach ($samplePrices as $samplePrice)
                                            <div class="text-center bg-white rounded-lg p-3 shadow-sm">
                                                <div class="text-gray-600 text-xs font-medium">Harga Rp
                                                    {{ number_format($samplePrice, 0, ',', '.') }}</div>
                                                @php
                                                    $finalPrice = $this->calculateFinalPrice($samplePrice);
                                                    $discountAmount = $samplePrice - $finalPrice;
                                                    $discountPercent =
                                                        $samplePrice > 0 ? ($discountAmount / $samplePrice) * 100 : 0;
                                                @endphp
                                                <div class="text-red-600 font-medium">-Rp
                                                    {{ number_format($discountAmount, 0, ',', '.') }}</div>
                                                <div class="text-green-600 font-bold text-lg">Rp
                                                    {{ number_format($finalPrice, 0, ',', '.') }}</div>
                                                <div class="text-xs text-gray-500">Hemat
                                                    {{ number_format($discountPercent, 1) }}%</div>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            @endif
                        </div>
                    @endif

                    {{-- Buy X Get Y Configuration --}}
                    @if ($type === 'buy_x_get_y')
                        <div class="space-y-4">
                            {{-- Multiple Rules Section --}}
                            <div>
                                <div class="flex items-center justify-between mb-4">
                                    <h4 class="font-semibold text-lg">Aturan Beli X Dapat Y</h4>
                                    <button type="button" wire:click="addBuyXGetYRule"
                                        class="px-3 py-1 bg-purple-600 text-white rounded text-sm hover:bg-purple-700">
                                        <i class="fas fa-plus mr-1"></i>Tambah Aturan
                                    </button>
                                </div>

                                {{-- Debug Info --}}
                                {{-- @if (config('app.debug'))
                                    <div class="mb-4 p-2 bg-yellow-50 border border-yellow-200 rounded text-xs">
                                        <strong>Debug Info:</strong><br>
                                        Jumlah Rules: {{ count($buy_x_get_y_rules) }}<br>
                                        Rules Data: {{ json_encode($buy_x_get_y_rules) }}<br>
                                        @if (!empty($buy_x_get_y_rules) && !is_array(array_values($buy_x_get_y_rules)[0] ?? null))
                                            <span class="text-red-600 font-bold">⚠️ Array corrupt detected!</span><br>
                                            <button type="button" wire:click="forceFixBuyXGetYRules"
                                                class="mt-1 px-2 py-1 bg-red-500 text-white text-xs rounded">
                                                Fix Array Structure
                                            </button>
                                        @endif
                                    </div>
                                @endif --}}

                                <div class="space-y-4">
                                    @php
                                        // Initialize rules if empty
                                        if (empty($buy_x_get_y_rules)) {
                                            $this->initializeBuyXGetYRules();
                                        }

                                        // Filter out non-array items (like UUID strings)
                                        $validRules = array_filter($buy_x_get_y_rules, function ($item) {
                                            return is_array($item);
                                        });
                                        $validRules = array_values($validRules);
                                    @endphp

                                    @if (!empty($validRules))
                                        @foreach ($validRules as $index => $rule)
                                            @if (is_array($rule))
                                                <div class="border border-gray-200 rounded-lg p-4 bg-gray-50">
                                                    <div class="flex items-center justify-between mb-3">
                                                        <span class="font-medium text-gray-700">Aturan
                                                            #{{ $index + 1 }}</span>
                                                        @if (count($validRules) > 1)
                                                            <button type="button"
                                                                wire:click="removeBuyXGetYRule({{ $index }})"
                                                                class="text-red-600 hover:text-red-800">
                                                                <i class="fas fa-trash"></i>
                                                            </button>
                                                        @endif
                                                    </div>

                                                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                                        <div>
                                                            <label
                                                                class="block text-sm font-medium text-gray-700 mb-2">
                                                                Jumlah Beli <span class="text-red-500">*</span>
                                                            </label>
                                                            <input type="number"
                                                                wire:model="buy_x_get_y_rules.{{ $index }}.buy_quantity"
                                                                class="form-control" placeholder="1" min="1">
                                                        </div>

                                                        <div>
                                                            <label
                                                                class="block text-sm font-medium text-gray-700 mb-2">
                                                                Jumlah Gratis <span class="text-red-500">*</span>
                                                            </label>
                                                            <input type="number"
                                                                wire:model="buy_x_get_y_rules.{{ $index }}.get_quantity"
                                                                class="form-control" placeholder="1" min="1">
                                                        </div>

                                                        <div>
                                                            <label
                                                                class="block text-sm font-medium text-gray-700 mb-2">Produk
                                                                yang Dibeli</label>
                                                            <select
                                                                wire:model="buy_x_get_y_rules.{{ $index }}.buy_product_id"
                                                                wire:change="$refresh" class="form-control">
                                                                <option value="">Pilih Produk</option>
                                                                @foreach ($products as $product)
                                                                    <option value="{{ $product->id }}"
                                                                        @if (isset($rule['buy_product_id']) && $rule['buy_product_id'] == $product->id) selected @endif>
                                                                        {{ $product->name }}
                                                                        @if (isset($product->sku_number))
                                                                            - {{ $product->sku_number }}
                                                                        @endif
                                                                    </option>
                                                                @endforeach
                                                            </select>
                                                        </div>

                                                        <div>
                                                            <label
                                                                class="block text-sm font-medium text-gray-700 mb-2">Produk
                                                                Gratis</label>
                                                            <select
                                                                wire:model="buy_x_get_y_rules.{{ $index }}.get_product_id"
                                                                wire:change="$refresh" class="form-control">
                                                                <option value="">Pilih Produks
                                                                </option>
                                                                @foreach ($products as $product)
                                                                    <option value="{{ $product->id }}"
                                                                        @if (isset($rule['get_product_id']) && $rule['get_product_id'] == $product->id) selected @endif>
                                                                        {{ $product->name }}
                                                                        @if (isset($product->sku_number))
                                                                            - {{ $product->sku_number }}
                                                                        @endif
                                                                    </option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                    </div>

                                                    {{-- Rule Preview --}}
                                                    <div
                                                        class="mt-3 p-3 bg-purple-50 border border-purple-200 rounded">
                                                        <p class="text-sm text-purple-700">
                                                            🛒 <strong>Beli {{ $rule['buy_quantity'] ?? 1 }}
                                                                produk</strong>
                                                            → 🎁 <strong>Gratis {{ $rule['get_quantity'] ?? 1 }}
                                                                produk</strong>
                                                            @if (!empty($rule['buy_product_id']))
                                                                @php
                                                                    $buyProduct = $products->firstWhere(
                                                                        'id',
                                                                        $rule['buy_product_id'],
                                                                    );
                                                                @endphp
                                                                @if ($buyProduct)
                                                                    <br>📦 Khusus produk: {{ $buyProduct->name }}
                                                                @endif
                                                            @else
                                                                <br>📦 Berlaku untuk semua produk
                                                            @endif
                                                            @if (!empty($rule['get_product_id']))
                                                                @php
                                                                    $getProduct = $products->firstWhere(
                                                                        'id',
                                                                        $rule['get_product_id'],
                                                                    );
                                                                @endphp
                                                                @if ($getProduct)
                                                                    <br>🎁 Produk gratis: {{ $getProduct->name }}
                                                                @endif
                                                            @else
                                                                <br>🎁 Gratis produk yang sama
                                                            @endif
                                                        </p>
                                                    </div>
                                                </div>
                                            @endif
                                        @endforeach
                                    @else
                                        <div class="text-center py-4 text-gray-500">
                                            <p>Belum ada aturan Buy X Get Y. Klik "Tambah Aturan" untuk menambah aturan
                                                baru.</p>
                                        </div>
                                    @endif
                                </div>
                            </div>

                            {{-- Overall Preview --}}
                            @if (!empty($validRules))
                                <div
                                    class="bg-gradient-to-r from-purple-50 to-pink-50 border border-purple-200 rounded-lg p-4">
                                    <h5 class="font-semibold text-purple-800 mb-3 flex items-center">
                                        <i class="fas fa-gift mr-2"></i>Ringkasan Semua Aturan
                                        ({{ count($validRules) }} aturan)
                                    </h5>
                                    <div class="space-y-2">
                                        @foreach ($validRules as $index => $rule)
                                            @if (is_array($rule))
                                                <div class="text-sm text-purple-700 bg-white rounded p-2">
                                                    <strong>Aturan {{ $index + 1 }}:</strong>
                                                    Beli {{ $rule['buy_quantity'] ?? 1 }} → Gratis
                                                    {{ $rule['get_quantity'] ?? 1 }}
                                                    @if (!empty($rule['buy_product_id']))
                                                        @php
                                                            $buyProduct = $products->firstWhere(
                                                                'id',
                                                                $rule['buy_product_id'],
                                                            );
                                                        @endphp
                                                        @if ($buyProduct)
                                                            ({{ $buyProduct->name }})
                                                        @endif
                                                    @endif
                                                </div>
                                            @endif
                                        @endforeach
                                    </div>
                                    <p class="text-xs text-purple-600 mt-3">
                                        💡 Pelanggan dapat memanfaatkan semua aturan yang berlaku sesuai dengan produk
                                        yang dibeli
                                    </p>
                                </div>
                            @endif
                        </div>
                    @endif

                    {{-- Bundle Configuration --}}
                    @if ($type === 'bundle')
                        <div class="space-y-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">
                                    Harga Bundle (Rp) <span class="text-red-500">*</span>
                                </label>
                                <input type="number" wire:model.lazy="bundle_price" class="form-control"
                                    placeholder="0" step="0.01" min="0">
                                @error('bundle_price')
                                    <span class="text-red-500 text-xs">{{ $message }}</span>
                                @enderror
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-3">Produk dalam Bundle</label>
                                <div class="border border-gray-200 rounded-lg p-4">
                                    <div class="space-y-3">
                                        @foreach ($bundle_products as $index => $bundleProduct)
                                            <div class="flex items-center space-x-3">
                                                <select
                                                    wire:model.lazy="bundle_products.{{ $index }}.product_id"
                                                    class="form-control flex-1">
                                                    <option value="">Pilih Produk</option>
                                                    @foreach ($availableProducts as $id => $name)
                                                        <option value="{{ $id }}">{{ $name }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                                <input type="number"
                                                    wire:model.lazy="bundle_products.{{ $index }}.quantity"
                                                    class="form-control w-20" placeholder="1" min="1">
                                                <button type="button"
                                                    wire:click="removeBundleProduct({{ $index }})"
                                                    class="btn btn-sm btn-outline text-red-600">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </div>
                                        @endforeach
                                    </div>
                                    <button type="button" wire:click="addBundleProduct"
                                        class="btn btn-sm btn-primary mt-3">
                                        <i class="fas fa-plus mr-2"></i>Tambah Produk
                                    </button>
                                </div>
                            </div>

                            {{-- Bundle Preview --}}
                            @if ($bundle_price > 0 && !empty($bundle_products))
                                <div
                                    class="bg-gradient-to-r from-indigo-50 to-purple-50 border border-indigo-200 rounded-lg p-4">
                                    <h5 class="font-semibold text-indigo-800 mb-2 flex items-center">
                                        <i class="fas fa-box mr-2"></i>Preview Bundle
                                    </h5>
                                    <div class="text-indigo-700">
                                        <p><strong>📦 Paket Bundle: Rp
                                                {{ number_format($bundle_price, 0, ',', '.') }}</strong></p>
                                        <div class="mt-2 space-y-1">
                                            @foreach ($bundle_products as $bundleProduct)
                                                @if (!empty($bundleProduct['product_id']) && isset($availableProducts[$bundleProduct['product_id']]))
                                                    <p class="text-sm">
                                                        • {{ $bundleProduct['quantity'] }}x
                                                        {{ $availableProducts[$bundleProduct['product_id']] }}
                                                    </p>
                                                @endif
                                            @endforeach
                                        </div>
                                    </div>
                                </div>
                            @endif
                        </div>
                    @endif

                    {{-- Discount Product Configuration --}}
                    @if ($type === 'discount_product')
                        <div class="bg-blue-50 p-4 rounded-lg">
                            <h4 class="font-semibold text-lg mb-4">Konfigurasi Diskon Produk</h4>

                            {{-- Product Selection --}}
                            <div class="mb-4">
                                <label class="block text-sm font-medium text-gray-700 mb-2">
                                    Pilih Produk
                                </label>
                                <div>
                                    <input type="search" wire:model.live='search' class="form-control mt-1"
                                        placeholder="Cari Produk ...">
                                </div>
                                <div
                                    class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-3 max-h-60 overflow-y-auto border rounded-lg p-3">
                                    @forelse ($products as $product)
                                        <div class="border rounded p-2 {{ in_array($product->id, $selected_discount_products ?? []) ? 'border-blue-500 bg-blue-50' : 'border-gray-200' }}"
                                            wire:key='{{ $product->id }}'>
                                            <label class="flex items-center cursor-pointer">
                                                <input type="checkbox" wire:model.lazy="selected_discount_products"
                                                    value="{{ $product->id }}" class="mr-2">
                                                <div class="flex-1">
                                                    <div class="font-medium text-sm">{{ $product->name }}</div>
                                                    <div class="text-xs text-gray-500">
                                                        Rp {{ number_format($this->getProductPrice($product->id)) }}
                                                    </div>
                                                </div>
                                            </label>
                                        </div>
                                    @empty
                                        <div class="text-center text-gray-500 text-sm py-4">
                                            Tidak ada produk yang tersedia.
                                        </div>
                                    @endforelse
                                </div>
                                @if (!empty($selected_discount_products))
                                    <div class="mt-2">
                                        <button type="button" wire:click="addSelectedDiscountProducts"
                                            class="px-3 py-1 bg-blue-600 text-white rounded text-sm hover:bg-blue-700">
                                            Tambah Produk Terpilih ({{ count($selected_discount_products) }})
                                        </button>
                                    </div>
                                @endif
                            </div>

                            {{-- Bulk Discount Controls --}}
                            @if (!empty($discount_products))
                                <div class="mb-4 bg-gray-50 p-3 rounded">
                                    <h5 class="font-medium mb-2">Pengaturan Diskon Massal</h5>
                                    <div class="flex items-center gap-3">
                                        <div>
                                            <label class="block text-xs text-gray-600">Tipe Diskon</label>
                                            <select wire:model.lazy="bulk_discount_type"
                                                class="border rounded px-2 py-1 text-sm">
                                                <option value="percentage">Persentase (%)</option>
                                                <option value="fixed_amount">Nominal (Rp)</option>
                                            </select>
                                        </div>
                                        <div>
                                            <label class="block text-xs text-gray-600">Nilai Diskon</label>
                                            <input type="number" wire:model.lazy="bulk_discount_value"
                                                class="border rounded px-2 py-1 w-20 text-sm" min="0"
                                                step="0.01">
                                        </div>
                                        <div class="self-end">
                                            <button type="button" wire:click="applyBulkDiscount"
                                                class="px-3 py-1 bg-green-600 text-white rounded text-sm hover:bg-green-700">
                                                Terapkan ke Semua
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            @endif

                            {{-- Selected Products List --}}
                            @if (!empty($discount_products))
                                <div class="mb-4">
                                    <h5 class="font-medium mb-2">Produk Terpilih ({{ count($discount_products) }})
                                    </h5>
                                    <div class="space-y-2 max-h-40 overflow-y-auto">
                                        @foreach ($discount_products as $index => $discountProduct)
                                            @php
                                                $product = $products->firstWhere('id', $discountProduct['product_id']);
                                                $originalPrice = $this->getProductPrice($discountProduct['product_id']);
                                                $finalPrice = $this->calculateFinalPriceFromArray(
                                                    $discountProduct,
                                                    $originalPrice,
                                                );
                                            @endphp
                                            <div class="border rounded p-3 bg-white">
                                                <div class="flex items-center justify-between">
                                                    <div class="flex-1">
                                                        <div class="font-medium">
                                                            {{ $product->product_name ?? 'Produk tidak ditemukan' }}
                                                        </div>
                                                        <div class="text-sm text-gray-600">
                                                            <div class="flex items-center gap-2">
                                                                <span>Harga Awal: <span class="font-medium">Rp
                                                                        {{ number_format($originalPrice) }}</span></span>
                                                                @if ($finalPrice != $originalPrice)
                                                                    <span class="text-green-600">→</span>
                                                                    <span class="text-green-600 font-medium">Rp
                                                                        {{ number_format($finalPrice) }}</span>
                                                                    <span
                                                                        class="text-xs bg-green-100 text-green-800 px-1 rounded">
                                                                        @if (isset($discountProduct['discount_type']) && $discountProduct['discount_type'] === 'percentage')
                                                                            -{{ $discountProduct['discount_value'] ?? 0 }}%
                                                                        @else
                                                                            -Rp
                                                                            {{ number_format($discountProduct['discount_value'] ?? 0) }}
                                                                        @endif
                                                                    </span>
                                                                @endif
                                                            </div>
                                                            @if ($finalPrice != $originalPrice)
                                                                <div class="text-xs text-green-600 mt-1">
                                                                    Hemat: Rp
                                                                    {{ number_format($originalPrice - $finalPrice) }}
                                                                </div>
                                                            @endif
                                                        </div>
                                                    </div>
                                                    <div class="flex items-center gap-2">
                                                        <div class="flex items-center gap-1">
                                                            <select
                                                                wire:model.live="discount_products.{{ $index }}.discount_type"
                                                                class="border rounded px-2 py-1 text-sm">
                                                                <option value="percentage">%</option>
                                                                <option value="fixed_amount">Rp</option>
                                                            </select>
                                                            <input type="number"
                                                                wire:model.live="discount_products.{{ $index }}.discount_value"
                                                                class="border rounded px-2 py-1 w-20 text-sm"
                                                                min="0" step="0.01" placeholder="0">
                                                        </div>
                                                        <button type="button"
                                                            wire:click="removeDiscountProduct({{ $index }})"
                                                            class="text-red-600 hover:text-red-800">
                                                            <svg class="w-4 h-4" fill="none" stroke="currentColor"
                                                                viewBox="0 0 24 24">
                                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                                    stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                                            </svg>
                                                        </button>
                                                    </div>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            @endif

                            {{-- Summary --}}
                            @if (!empty($discount_products))
                                <div class="bg-green-50 p-3 rounded">
                                    <h5 class="font-medium text-green-800 mb-1">Ringkasan Diskon</h5>
                                    <div class="text-sm text-green-700">
                                        @php
                                            $totalOriginal = array_sum(
                                                array_map(function ($dp) {
                                                    return $this->getProductPrice($dp['product_id']);
                                                }, $discount_products),
                                            );
                                            $totalFinal = array_sum(
                                                array_map(function ($dp) {
                                                    $originalPrice = $this->getProductPrice($dp['product_id']);
                                                    return $this->calculateFinalPriceFromArray($dp, $originalPrice);
                                                }, $discount_products),
                                            );
                                            $totalSavings = $totalOriginal - $totalFinal;
                                        @endphp
                                        Total Harga Awal: Rp {{ number_format($totalOriginal) }} <br>
                                        Total Setelah Diskon: Rp {{ number_format($totalFinal) }} <br>
                                        Total Penghematan: <span class="font-medium">Rp
                                            {{ number_format($totalSavings) }}</span>
                                    </div>
                                </div>
                            @endif
                        </div>
                    @endif

                    {{-- Special Promotion Configuration --}}
                    @if ($type === 'special')
                        <div class="space-y-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">
                                    Jenis Promosi Khusus <span class="text-red-500">*</span>
                                </label>
                                <select wire:model.lazy="special_type" class="form-control">
                                    @foreach ($specialTypes as $value => $label)
                                        <option value="{{ $value }}">{{ $label }}</option>
                                    @endforeach
                                </select>
                            </div>

                            @if ($special_type === 'cashback')
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-2">Persentase Cashback
                                            (%)</label>
                                        <input type="number" wire:model.lazy="cashback_percentage"
                                            class="form-control" placeholder="0" step="0.1" min="0"
                                            max="100">
                                    </div>
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-2">Maksimal Cashback
                                            (Rp)</label>
                                        <input type="number" wire:model.lazy="max_cashback" class="form-control"
                                            placeholder="Tidak terbatas" step="0.01" min="0">
                                    </div>
                                </div>
                            @elseif($special_type === 'free_shipping')
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2">Minimal Pembelian untuk
                                        Gratis Ongkir (Rp)</label>
                                    <input type="number" wire:model.lazy="free_shipping_min" class="form-control"
                                        placeholder="0" step="0.01" min="0">
                                </div>
                            @elseif($special_type === 'loyalty_points')
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2">Multiplier Poin</label>
                                    <input type="number" wire:model.lazy="points_multiplier" class="form-control"
                                        placeholder="1" step="0.1" min="0">
                                    <p class="text-xs text-gray-500 mt-1">Contoh: 2 = poin ganda, 1.5 = poin 1.5x lipat
                                    </p>
                                </div>
                            @endif

                            {{-- Special Promotion Preview --}}
                            <div
                                class="bg-gradient-to-r from-yellow-50 to-orange-50 border border-yellow-200 rounded-lg p-4">
                                <h5 class="font-semibold text-yellow-800 mb-2 flex items-center">
                                    <i class="fas fa-star mr-2"></i>Preview Promosi Khusus
                                </h5>
                                <p class="text-yellow-700">
                                    @if ($special_type === 'cashback')
                                        💸 <strong>Cashback {{ $cashback_percentage }}%</strong>
                                        @if ($max_cashback)
                                            (maksimal Rp {{ number_format($max_cashback, 0, ',', '.') }})
                                        @endif
                                    @elseif($special_type === 'free_shipping')
                                        🚚 <strong>Gratis Ongkir</strong> untuk pembelian minimal Rp
                                        {{ number_format($free_shipping_min, 0, ',', '.') }}
                                    @elseif($special_type === 'loyalty_points')
                                        ⭐ <strong>Poin {{ $points_multiplier }}x Lipat</strong> untuk setiap pembelian
                                    @endif
                                </p>
                            </div>
                        </div>
                    @endif
                </div>

                {{-- Additional Targeting --}}
                <div class="bg-white rounded-xl shadow-sm border p-6">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4">
                        <i class="fas fa-target text-orange-500 mr-2"></i>Target Tambahan (Opsional)
                    </h3>

                    <div class="space-y-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Berlaku Untuk Company</label>
                            <select wire:model.live="company_target_type" class="form-control">
                                @foreach ($companyTargetTypes as $value => $label)
                                    <option value="{{ $value }}">{{ $label }}</option>
                                @endforeach
                            </select>
                        </div>

                        {{-- Current Company Only Checkbox --}}
                        {{-- @if ($company_target_type === 'current')
                            <div class="bg-blue-50 border border-blue-200 rounded-lg p-4">
                                <div class="flex items-center">
                                    <input type="checkbox" wire:model.live="current_company_only"
                                        id="current_company_only"
                                        class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded">
                                    <label for="current_company_only" class="ml-2 text-sm text-blue-800">
                                        Hanya untuk company saat ini
                                    </label>
                                </div>
                                <p class="text-xs text-blue-600 mt-1">Promosi hanya akan berlaku untuk company Anda
                                    saat ini</p>
                            </div>
                        @endif --}}

                        {{-- Specific Companies Selection --}}
                        @if ($company_target_type === 'specific')
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Pilih Company
                                    Tertentu</label>
                                <div wire:key="select-{{ rand() }}">
                                    <select multiple class="mt-1 form-control" x-data x-ref="input"
                                        x-init="$($refs.input).selectize({
                                            dropdownParent: 'body',
                                            allowClear: true,
                                            plugins: ['clear_button'],
                                            onChange: function(e) {
                                                @this.set('selectedCompanies', e ? e : null);
                                            }
                                        });" wire:model.lazy="selectedCompanies"
                                        id="selectedCompanies">
                                        <option value="">-- Pilih Perusahaan --</option>
                                        @foreach ($companies as $company)
                                            <option value="{{ $company->id }}">{{ $company->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <p class="text-xs text-gray-500 mt-1">Kosongkan untuk semua cabang</p>
                            </div>
                        @endif

                        {{-- All Companies Info --}}
                        {{-- @if ($company_target_type === 'all')
                            <div class="bg-green-50 border border-green-200 rounded-lg p-4">
                                <div class="flex items-center">
                                    <i class="fas fa-globe text-green-600 mr-2"></i>
                                    <span class="text-sm text-green-800 font-medium">Promosi Global</span>
                                </div>
                                <p class="text-xs text-green-600 mt-1">Promosi ini akan berlaku untuk semua company</p>
                            </div>
                        @endif --}}

                        {{-- Products Selection --}}
                        {{-- <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Target Produk</label>
                            <select wire:model.live="selectedProducts" class="form-control" multiple
                                style="min-height: 100px;">
                                @foreach ($products as $product)
                                    <option value="{{ $product->id }}">{{ $product->name }}
                                        ({{ $product->sku_number }})
                                    </option>
                                @endforeach
                            </select>
                            <p class="text-xs text-gray-500 mt-1">Kosongkan untuk semua produk</p>
                        </div> --}}

                        {{-- User Types Selection --}}
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Target User Tipe</label>
                            <div wire:key="select-{{ rand() }}">
                                <select multiple class="mt-1 form-control" x-data x-ref="input"
                                    x-init="$($refs.input).selectize({
                                        dropdownParent: 'body',
                                        allowClear: true,
                                        plugins: ['clear_button'],
                                        onChange: function(e) {
                                            @this.set('selectedUserTypes', e ? e : null);
                                        }
                                    });" wire:model.lazy="selectedUserTypes"
                                    id="selectedUserTypes">
                                    <option value="">-- Pilih User Tipe --</option>
                                    @foreach ($userTypes as $userType)
                                        <option value="{{ $userType->id }}">{{ $userType->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <p class="text-xs text-gray-500 mt-1">Kosongkan untuk semua tipe user</p>
                        </div>

                        {{-- Users Selection --}}
                        {{-- <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Target Pasien</label>
                            <div wire:key="select-{{ rand() }}">
                                <select multiple class="mt-1 form-control" x-data x-ref="input"
                                    x-init="$($refs.input).selectize({
                                        dropdownParent: 'body',
                                        allowClear: true,
                                        plugins: ['clear_button'],
                                        onChange: function(e) {
                                            @this.set('selectedUsers', e ? e : null);
                                        }
                                    });" wire:model.lazy="selectedUsers" id="selectedUsers">
                                    <option value="">-- Pilih Pasien --</option>
                                    @foreach ($users as $user)
                                        <option value="{{ $user->id }}">{{ $user->name }}
                                            ({{ $user->email }})
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <p class="text-xs text-gray-500 mt-1">Kosongkan untuk semua user</p>
                        </div> --}}
                    </div>
                </div>

                {{-- Schedule & Quota Configuration --}}
                <div class="bg-white rounded-xl shadow-sm border p-6">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4">
                        <i class="fas fa-calendar-clock text-purple-500 mr-2"></i>Jadwal & Kuota Promosi
                    </h3>

                    <div class="space-y-6">
                        {{-- Period Range --}}
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-3">
                                <i class="fas fa-calendar-alt mr-1"></i>Periode Berlaku
                            </label>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div>
                                    <label class="block text-sm font-medium text-gray-600 mb-2">Tanggal Mulai</label>
                                    <input type="date" wire:model.lazy="start_date" class="form-control">
                                    <p class="text-xs text-gray-500 mt-1">Tanggal promosi mulai berlaku</p>
                                </div>

                                <div>
                                    <label class="block text-sm font-medium text-gray-600 mb-2">Tanggal
                                        Berakhir</label>
                                    <input type="date" wire:model.lazy="end_date" class="form-control">
                                    <p class="text-xs text-gray-500 mt-1">Tanggal promosi berakhir</p>
                                </div>
                            </div>

                            @if ($start_date && $end_date)
                                <div class="mt-3 p-3 bg-blue-50 border border-blue-200 rounded">
                                    <div class="text-sm text-blue-700">
                                        <i class="fas fa-calendar mr-1"></i>
                                        <strong>Periode:</strong> {{ date('d M Y', strtotime($start_date)) }} -
                                        {{ date('d M Y', strtotime($end_date)) }}
                                        <span class="ml-2 text-blue-600">
                                            ({{ abs(strtotime($end_date) - strtotime($start_date)) / (60 * 60 * 24) + 1 }}
                                            hari)
                                        </span>
                                    </div>
                                </div>
                            @endif
                        </div>

                        {{-- Schedule Type Selection --}}
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-3">
                                <i class="fas fa-clock mr-1"></i>Jadwal Aktif
                            </label>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-3">
                                @foreach ($scheduleTypes as $value => $label)
                                    <label
                                        class="flex items-center p-3 border border-gray-200 rounded-lg hover:bg-gray-50 cursor-pointer transition-colors duration-200 {{ $schedule_type === $value ? 'border-blue-500 bg-blue-50' : '' }}">
                                        <input type="radio" wire:model.live="schedule_type"
                                            value="{{ $value }}"
                                            class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300">
                                        <div class="ml-3">
                                            <div class="text-sm font-medium text-gray-700">{{ $label }}</div>
                                            <div class="text-xs text-gray-500">
                                                @if ($value === 'always')
                                                    Promosi berlaku sepanjang waktu
                                                @elseif($value === 'days_only')
                                                    Hanya berlaku di hari-hari tertentu
                                                @elseif($value === 'time_only')
                                                    Berlaku setiap hari pada jam tertentu
                                                @elseif($value === 'days_and_time')
                                                    Berlaku di hari dan jam tertentu saja
                                                @endif
                                            </div>
                                        </div>
                                    </label>
                                @endforeach
                            </div>
                        </div>

                        {{-- Days Selection (for days_only and days_and_time) --}}
                        @if ($schedule_type === 'days_only' || $schedule_type === 'days_and_time')
                            <div class="bg-blue-50 border border-blue-200 rounded-lg p-4">
                                <label class="block text-sm font-medium text-gray-700 mb-3">
                                    <i class="fas fa-calendar-day mr-1"></i>Pilih Hari Berlaku
                                </label>
                                <div class="grid grid-cols-2 md:grid-cols-4 lg:grid-cols-7 gap-3">
                                    @foreach ($dayOptions as $value => $label)
                                        <label
                                            class="flex items-center p-2 border border-gray-200 rounded hover:bg-gray-50 cursor-pointer transition-colors duration-200 {{ in_array($value, $specific_days ?? []) ? 'border-blue-500 bg-blue-100' : 'bg-white' }}">
                                            <input type="checkbox" wire:model.live="specific_days"
                                                value="{{ $value }}"
                                                class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded">
                                            <span
                                                class="ml-2 text-sm font-medium text-gray-700">{{ $label }}</span>
                                        </label>
                                    @endforeach
                                </div>

                                @if (!empty($specific_days))
                                    <div class="mt-3 p-2 bg-white rounded border">
                                        <div class="text-xs text-blue-700">
                                            <strong>Hari terpilih:</strong>
                                            @foreach ($specific_days as $day)
                                                <span
                                                    class="inline-block bg-blue-100 text-blue-800 px-2 py-1 rounded text-xs mr-1">
                                                    {{ $dayOptions[$day] ?? $day }}
                                                </span>
                                            @endforeach
                                        </div>
                                    </div>
                                @endif
                            </div>
                        @endif

                        {{-- Time Selection (for time_only and days_and_time) --}}
                        @if ($schedule_type === 'time_only' || $schedule_type === 'days_and_time')
                            <div class="bg-orange-50 border border-orange-200 rounded-lg p-4">
                                <label class="block text-sm font-medium text-gray-700 mb-3">
                                    <i class="fas fa-clock mr-1"></i>Pengaturan Waktu
                                </label>

                                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-2">Jam Mulai</label>
                                        <input type="time" wire:model.live="specific_start_time"
                                            class="form-control">
                                        <p class="text-xs text-gray-500 mt-1">Waktu promosi mulai berlaku</p>
                                    </div>
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-2">Jam
                                            Berakhir</label>
                                        <input type="time" wire:model.live="specific_end_time"
                                            class="form-control">
                                        <p class="text-xs text-gray-500 mt-1">Waktu promosi berakhir</p>
                                    </div>
                                </div>

                                @if ($schedule_type === 'days_and_time')
                                    <div class="mt-4">
                                        <label class="flex items-center">
                                            <input type="checkbox" wire:model.live="apply_time_to_days"
                                                class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded">
                                            <span class="ml-2 text-sm text-gray-700">
                                                Terapkan waktu hanya pada hari yang dipilih
                                            </span>
                                        </label>
                                        <p class="text-xs text-gray-500 mt-1">
                                            Jika dicentang, jam berlaku hanya pada hari terpilih. Jika tidak, jam
                                            berlaku setiap hari tapi promosi hanya aktif pada hari terpilih.
                                        </p>
                                    </div>
                                @endif

                                {{-- Time Preview --}}
                                @if ($specific_start_time || $specific_end_time)
                                    <div class="mt-3 p-2 bg-white rounded border">
                                        <div class="text-xs text-orange-700">
                                            <strong>Waktu aktif:</strong>
                                            {{ $specific_start_time ?: '00:00' }} -
                                            {{ $specific_end_time ?: '23:59' }}
                                            @if ($schedule_type === 'time_only')
                                                (setiap hari)
                                            @elseif($schedule_type === 'days_and_time' && !empty($specific_days))
                                                @if ($apply_time_to_days)
                                                    (hanya pada hari terpilih)
                                                @else
                                                    (jam ini setiap hari, tapi promosi hanya aktif pada hari terpilih)
                                                @endif
                                            @endif
                                        </div>
                                    </div>
                                @endif
                            </div>
                        @endif

                        {{-- Quota Settings --}}
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-3">
                                <i class="fas fa-users mr-1"></i>Pengaturan Kuota
                            </label>
                            <div class="space-y-4">
                                <div>
                                    <label
                                        class="flex items-center p-3 border border-gray-200 rounded-lg hover:bg-gray-50 cursor-pointer">
                                        <input type="checkbox" wire:model.live="is_unlimited"
                                            class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded">
                                        <div class="ml-3">
                                            <div class="text-sm font-medium text-gray-700">Kuota Tidak Terbatas</div>
                                            <div class="text-xs text-gray-500">Promosi dapat digunakan tanpa batas
                                            </div>
                                        </div>
                                    </label>
                                </div>

                                @if (!$is_unlimited)
                                    <div class="bg-orange-50 border border-orange-200 rounded-lg p-4">
                                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                            <div>
                                                <label class="block text-sm font-medium text-gray-700 mb-2">Total
                                                    Kuota</label>
                                                <input type="number" wire:model.lazy="total_quota"
                                                    class="form-control" placeholder="Contoh: 100" min="1">
                                                <p class="text-xs text-gray-500 mt-1">Jumlah maksimal penggunaan
                                                    promosi</p>
                                            </div>

                                            <div>
                                                <label class="block text-sm font-medium text-gray-700 mb-2">Kuota per
                                                    Pelanggan</label>
                                                <input type="number" wire:model.lazy="quota_per_user"
                                                    class="form-control" placeholder="1" min="1">
                                                <p class="text-xs text-gray-500 mt-1">Maksimal penggunaan per pelanggan
                                                </p>
                                            </div>
                                        </div>

                                        @if ($total_quota && $quota_per_user)
                                            <div class="mt-3 p-2 bg-white border rounded">
                                                <div class="text-xs text-orange-700">
                                                    <strong>Estimasi:</strong> Maksimal
                                                    {{ floor($total_quota / $quota_per_user) }} pelanggan dapat
                                                    menggunakan promosi ini
                                                    @if ($quota_per_user > 1)
                                                        (masing-masing {{ $quota_per_user }}x)
                                                    @endif
                                                </div>
                                            </div>
                                        @endif
                                    </div>
                                @else
                                    <div class="bg-green-50 border border-green-200 rounded-lg p-3">
                                        <div class="flex items-center">
                                            <i class="fas fa-infinity text-green-600 mr-2"></i>
                                            <span class="text-sm text-green-800 font-medium">Kuota Unlimited</span>
                                        </div>
                                        <p class="text-xs text-green-600 mt-1">Semua pelanggan dapat menggunakan
                                            promosi tanpa batasan</p>
                                    </div>
                                @endif
                            </div>
                        </div>

                        {{-- Schedule Summary --}}
                        <div
                            class="bg-gradient-to-r from-purple-50 to-blue-50 border border-purple-200 rounded-lg p-4">
                            <h5 class="font-semibold text-purple-800 mb-2 flex items-center">
                                <i class="fas fa-info-circle mr-2"></i>Ringkasan Jadwal & Kuota
                            </h5>
                            <div class="text-sm text-purple-700 space-y-1">
                                {{-- Period Summary --}}
                                @if ($start_date && $end_date)
                                    <p>📅 <strong>Periode:</strong> {{ date('d M Y', strtotime($start_date)) }} -
                                        {{ date('d M Y', strtotime($end_date)) }}</p>
                                @endif

                                {{-- Schedule Summary --}}
                                @if ($schedule_type === 'always')
                                    <p>🟢 <strong>Jadwal:</strong> Aktif 24/7 sepanjang periode</p>
                                @elseif($schedule_type === 'days_only')
                                    @if (!empty($specific_days))
                                        <p>📅 <strong>Jadwal:</strong> Aktif pada hari
                                            @foreach ($specific_days as $day)
                                                {{ $dayOptions[$day] ?? $day }}{{ !$loop->last ? ', ' : '' }}
                                            @endforeach
                                        </p>
                                    @else
                                        <p class="text-orange-600">⚠️ Pilih minimal satu hari untuk mengaktifkan
                                            promosi</p>
                                    @endif
                                @elseif($schedule_type === 'time_only')
                                    @if ($specific_start_time || $specific_end_time)
                                        <p>⏰ <strong>Jadwal:</strong> Setiap hari jam
                                            {{ $specific_start_time ?: '00:00' }} -
                                            {{ $specific_end_time ?: '23:59' }}</p>
                                    @else
                                        <p class="text-orange-600">⚠️ Tentukan jam mulai dan berakhir</p>
                                    @endif
                                @elseif($schedule_type === 'days_and_time')
                                    @if (!empty($specific_days) && ($specific_start_time || $specific_end_time))
                                        <p>📅⏰ <strong>Jadwal:</strong>
                                            @foreach ($specific_days as $day)
                                                {{ $dayOptions[$day] ?? $day }}{{ !$loop->last ? ', ' : '' }}
                                            @endforeach
                                            jam {{ $specific_start_time ?: '00:00' }} -
                                            {{ $specific_end_time ?: '23:59' }}
                                        </p>
                                    @else
                                        <p class="text-orange-600">⚠️ Pilih hari dan tentukan jam untuk mengaktifkan
                                            promosi</p>
                                    @endif
                                @endif

                                {{-- Quota Summary --}}
                                @if ($is_unlimited)
                                    <p>♾️ <strong>Kuota:</strong> Tidak terbatas</p>
                                @else
                                    @if ($total_quota)
                                        <p>🎫 <strong>Kuota:</strong> {{ $total_quota }} total,
                                            {{ $quota_per_user ?: 1 }} per pelanggan</p>
                                    @endif
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            {{-- Sidebar --}}
            <div class="space-y-6">
                {{-- Preview Card --}}
                <div class="bg-gradient-to-br from-blue-50 to-indigo-100 rounded-xl shadow-sm border p-6">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4">
                        <i class="fas fa-eye text-indigo-500 mr-2"></i>Preview Promosi
                    </h3>

                    <div class="bg-white rounded-lg p-4 shadow-sm">
                        <div class="text-center">
                            <h4 class="font-bold text-lg text-gray-900">{{ $name ?: 'Nama Promosi' }}</h4>
                            <p class="text-sm text-gray-600 mb-3">{{ $code ?: 'KODE-PROMOSI' }}</p>

                            <div class="bg-red-500 text-white rounded-lg p-3 mb-3">
                                @if ($type === 'discount')
                                    @if ($discount_type === 'percentage')
                                        <div class="text-2xl font-bold">{{ $discount_value }}% OFF</div>
                                        @if ($max_discount)
                                            <div class="text-xs">Maks. Rp
                                                {{ number_format($max_discount, 0, ',', '.') }}</div>
                                        @endif
                                    @elseif($discount_type === 'fixed')
                                        <div class="text-2xl font-bold">Rp
                                            {{ number_format($discount_value, 0, ',', '.') }} OFF</div>
                                    @else
                                        <div class="text-2xl font-bold">Harga Spesial</div>
                                        <div class="text-sm">Rp {{ number_format($discount_value, 0, ',', '.') }}
                                        </div>
                                    @endif
                                @elseif($type === 'buy_x_get_y')
                                    <div class="text-lg font-bold">Beli {{ $buy_quantity }} Gratis
                                        {{ $get_quantity }}</div>
                                @elseif($type === 'bundle')
                                    <div class="text-lg font-bold">Paket Bundle</div>
                                    <div class="text-sm">Rp {{ number_format($bundle_price, 0, ',', '.') }}</div>
                                @elseif($type === 'special')
                                    @if ($special_type === 'cashback')
                                        <div class="text-lg font-bold">Cashback {{ $cashback_percentage }}%</div>
                                    @elseif($special_type === 'free_shipping')
                                        <div class="text-lg font-bold">Gratis Ongkir</div>
                                    @elseif($special_type === 'loyalty_points')
                                        <div class="text-lg font-bold">Poin {{ $points_multiplier }}x</div>
                                    @endif
                                @endif
                            </div>

                            {{-- @if ($minimum_purchase > 0)
                                <p class="text-xs text-gray-600">
                                    Min. pembelian Rp {{ number_format($minimum_purchase, 0, ',', '.') }}
                                </p>
                            @endif --}}

                            {{-- @if ($start_date && $end_date)
                                <p class="text-xs text-gray-600 mt-2">
                                    {{ date('d M Y', strtotime($start_date)) }} -
                                    {{ date('d M Y', strtotime($end_date)) }}
                                </p>
                            @endif --}}
                        </div>
                    </div>
                </div>

                {{-- Terms & Conditions --}}
                <div class="bg-white rounded-xl shadow-sm border p-6">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4">
                        <i class="fas fa-file-contract text-green-500 mr-2"></i>Syarat & Ketentuan
                    </h3>

                    <div class="space-y-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">
                                Daftar Syarat & Ketentuan
                            </label>
                            <div id="terms-container" class="space-y-2">
                                @foreach ($terms_conditions as $index => $term)
                                    <div class="flex items-center space-x-2">
                                        <input type="text" wire:model.lazy="terms_conditions.{{ $index }}"
                                            class="form-control flex-1" placeholder="Masukkan syarat atau ketentuan">
                                        <button type="button" wire:click="removeTermCondition({{ $index }})"
                                            class="text-red-500 hover:text-red-700">
                                            <i class="fas fa-times"></i>
                                        </button>
                                    </div>
                                @endforeach
                            </div>
                            <button type="button" wire:click="addTermCondition"
                                class="mt-2 text-blue-600 hover:text-blue-800 text-sm">
                                <i class="fas fa-plus mr-1"></i>Tambah Syarat & Ketentuan
                            </button>
                        </div>

                        {{-- <div class="flex items-center">
                            <input type="checkbox" wire:model.lazy="can_combine_with_other" class="form-checkbox"
                                id="can_combine">
                            <label for="can_combine" class="ml-2 text-sm font-medium text-gray-700">
                                Dapat digabung dengan promosi lain
                            </label>
                        </div> --}}
                    </div>
                </div>

                {{-- Settings --}}
                <div class="bg-white rounded-xl shadow-sm border p-6">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4">
                        <i class="fas fa-sliders-h text-gray-500 mr-2"></i>Pengaturan
                    </h3>

                    <div class="space-y-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Prioritas</label>
                            <input type="number" wire:model.lazy="priority" class="form-control" placeholder="1"
                                min="0">
                            <p class="text-xs text-gray-500 mt-1">Semakin tinggi semakin prioritas</p>
                        </div>

                        {{-- <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Banner Text</label>
                            <input type="text" wire:model.lazy="banner_text" class="form-control"
                                placeholder="Teks untuk banner promosi">
                        </div> --}}

                        {{-- <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Gambar Promosi</label>
                            <input type="file" wire:model.lazy="image" class="form-control" accept="image/*">
                            @if ($image)
                                <p class="text-xs text-green-600 mt-1">✓ Gambar siap diupload</p>
                            @endif
                        </div> --}}

                        <div class="flex items-center">
                            <input type="checkbox" wire:model.lazy="is_active" class="form-checkbox" id="is_active">
                            <label for="is_active" class="ml-2 text-sm font-medium text-gray-700">
                                Aktif
                            </label>
                        </div>
                    </div>
                </div>

                {{-- Action Buttons --}}
                {{-- <div class="bg-white rounded-xl shadow-sm border p-6">
                    <div class="space-y-3">
                        <button type="button" wire:click="save" class="btn btn-primary w-full">
                            <i class="fas fa-save mr-2"></i>
                            {{ $promotion_id ? 'Update Promosi' : 'Simpan Promosi' }}
                        </button>
                        <button type="button" wire:click="cancel" class="btn btn-danger w-full">
                            <i class="fas fa-times mr-2"></i>Batal
                        </button>
                    </div>
                </div> --}}

                {{-- Quick Guide --}}
                {{-- <div class="bg-yellow-50 rounded-xl border border-yellow-200 p-6">
                    <h3 class="text-lg font-semibold text-yellow-800 mb-3">
                        <i class="fas fa-lightbulb mr-2"></i>Tips Promosi Efektif
                    </h3>
                    <ul class="text-sm text-yellow-700 space-y-2">
                        <li>💡 <strong>Nama jelas:</strong> Gunakan nama yang mudah dipahami customer</li>
                        <li>🎯 <strong>Target tepat:</strong> Sesuaikan dengan audience yang diinginkan</li>
                        <li>⏰ <strong>Waktu tepat:</strong> Jadwalkan saat traffic tinggi</li>
                        <li>📊 <strong>Pantau performa:</strong> Monitor penggunaan promosi secara berkala</li>
                        <li>🔄 <strong>A/B Testing:</strong> Coba variasi untuk hasil optimal</li>
                    </ul>
                </div> --}}
            </div>
        </div>
    </form>

    {{-- Success/Error Messages --}}
    @if (session()->has('message'))
        <div class="fixed bottom-4 right-4 bg-green-500 text-white px-6 py-3 rounded-lg shadow-lg z-50">
            {{ session('message') }}
        </div>
    @endif

    {{-- Internal Styles --}}
    <style>
        .form-control {
            @apply w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500;
        }

        .form-checkbox {
            @apply h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded;
        }

        .btn {
            @apply inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-offset-2;
        }

        .btn-primary {
            @apply text-white bg-blue-600 hover:bg-blue-700 focus:ring-blue-500;
        }

        .btn-outline {
            @apply text-gray-700 bg-white border-gray-300 hover:bg-gray-50 focus:ring-blue-500;
        }

        .btn-sm {
            @apply px-3 py-1 text-xs;
        }
    </style>
</div>
