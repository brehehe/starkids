<div class="max-w-4xl mx-auto p-6">
    <!-- Header -->
    <div class="mb-6">
        <div class="flex items-center justify-between">
            <h1 class="text-3xl font-bold text-gray-900">Edit Promosi</h1>
            <div class="flex space-x-3">
                <button wire:click="cancel" class="px-4 py-2 text-gray-600 bg-gray-100 rounded-lg hover:bg-gray-200 transition-colors">
                    Batal
                </button>
                <button wire:click="save" class="px-6 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors">
                    Simpan Perubahan
                </button>
            </div>
        </div>
        <p class="text-gray-600 mt-2">Ubah detail promosi {{ $promotion->name }}</p>
    </div>

    @if (session()->has('message'))
        <div class="mb-6 p-4 bg-green-100 border border-green-400 text-green-700 rounded-lg">
            {{ session('message') }}
        </div>
    @endif

    @if ($errors->any())
        <div class="mb-6 p-4 bg-red-100 border border-red-400 text-red-700 rounded-lg">
            <ul class="list-disc list-inside">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form wire:submit.prevent="save" class="space-y-8">
        <!-- Basic Information -->
        <div class="bg-white rounded-lg border border-gray-200 p-6">
            <h3 class="text-lg font-semibold text-gray-900 mb-4">Informasi Dasar</h3>
<<<<<<< HEAD
            
=======

>>>>>>> starkids
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Nama Promosi *</label>
                    <input type="text" wire:model="name" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent" placeholder="Masukkan nama promosi">
                    @error('name') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Kode Promosi</label>
                    <div class="flex">
                        <input type="text" wire:model="code" class="flex-1 px-3 py-2 border border-gray-300 rounded-l-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent" placeholder="Kode promosi (opsional)">
                        <button type="button" wire:click="generateCode" class="px-4 py-2 bg-gray-100 border border-l-0 border-gray-300 rounded-r-lg hover:bg-gray-200 text-sm">
                            Generate
                        </button>
                    </div>
                    @error('code') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                </div>
            </div>

            <div class="mt-4">
                <label class="block text-sm font-medium text-gray-700 mb-2">Deskripsi</label>
                <textarea wire:model="description" rows="3" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent" placeholder="Deskripsi promosi"></textarea>
                @error('description') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
            </div>

            @if($current_image_path)
                <div class="mt-4">
                    <label class="block text-sm font-medium text-gray-700 mb-2">Gambar Saat Ini</label>
                    <img src="{{ Storage::url($current_image_path) }}" alt="Current promotion image" class="w-32 h-32 object-cover rounded-lg">
                </div>
            @endif

            <div class="mt-4">
                <label class="block text-sm font-medium text-gray-700 mb-2">Gambar Promosi Baru</label>
                <input type="file" wire:model="image" accept="image/*" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                @error('image') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                @if ($image)
                    <div class="mt-2">
                        <img src="{{ $image->temporaryUrl() }}" class="w-32 h-32 object-cover rounded-lg">
                    </div>
                @endif
            </div>
        </div>

        <!-- Promotion Type & Discount -->
        <div class="bg-white rounded-lg border border-gray-200 p-6">
            <h3 class="text-lg font-semibold text-gray-900 mb-4">Jenis & Nilai Promosi</h3>
<<<<<<< HEAD
            
=======

>>>>>>> starkids
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Jenis Promosi *</label>
                    <select wire:model="type" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                        @foreach($promotionTypes as $key => $label)
                            <option value="{{ $key }}">{{ $label }}</option>
                        @endforeach
                    </select>
                    @error('type') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                </div>

                @if(in_array($type, ['percentage', 'fixed_amount', 'cashback']))
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">
                            Nilai Diskon *
                            @if($type === 'percentage') (%) @elseif($type === 'fixed_amount') (Rp) @endif
                        </label>
                        <input type="number" wire:model="discount_value" step="0.01" min="0" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent" placeholder="0">
                        @error('discount_value') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                    </div>
                @endif
            </div>

            <!-- Buy X Get Y Configuration -->
            @if($type === 'buy_x_get_y')
                <div class="mt-6 p-4 bg-blue-50 rounded-lg">
                    <h4 class="font-medium text-blue-900 mb-3">Konfigurasi Beli X Gratis Y</h4>
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Jumlah Beli</label>
                            <input type="number" wire:model="buy_quantity" min="1" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Jumlah Gratis</label>
                            <input type="number" wire:model="get_quantity" min="1" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Produk Gratis</label>
                            <select wire:model="get_product_id" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                                <option value="">Pilih produk</option>
                                <!-- Add product options here -->
                            </select>
                        </div>
                    </div>
                </div>
            @endif

            <!-- Bundle Configuration -->
            @if($type === 'bundle')
                <div class="mt-6 p-4 bg-green-50 rounded-lg">
                    <h4 class="font-medium text-green-900 mb-3">Konfigurasi Bundle</h4>
                    <div class="space-y-3">
                        @foreach($bundle_products as $index => $bundle)
                            <div class="flex items-center space-x-3">
                                <select wire:model="bundle_products.{{ $index }}.product_id" class="flex-1 px-3 py-2 border border-gray-300 rounded-lg">
                                    <option value="">Pilih produk</option>
                                    <!-- Add product options here -->
                                </select>
                                <input type="number" wire:model="bundle_products.{{ $index }}.quantity" min="1" class="w-20 px-3 py-2 border border-gray-300 rounded-lg" placeholder="Qty">
                                <button type="button" wire:click="removeBundleProduct({{ $index }})" class="text-red-600 hover:text-red-800">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                    </svg>
                                </button>
                            </div>
                        @endforeach
                        <button type="button" wire:click="addBundleProduct" class="text-blue-600 hover:text-blue-800 text-sm">
                            + Tambah Produk Bundle
                        </button>
                        <div class="mt-3">
                            <label class="block text-sm font-medium text-gray-700 mb-1">Harga Bundle (Rp)</label>
                            <input type="number" wire:model="bundle_price" step="0.01" min="0" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                        </div>
                    </div>
                </div>
            @endif
        </div>

        <!-- Date Range -->
        <div class="bg-white rounded-lg border border-gray-200 p-6">
            <h3 class="text-lg font-semibold text-gray-900 mb-4">Periode Promosi</h3>
<<<<<<< HEAD
            
=======

>>>>>>> starkids
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Tanggal Mulai *</label>
                    <input type="date" wire:model="start_date" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                    @error('start_date') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Tanggal Selesai *</label>
                    <input type="date" wire:model="end_date" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                    @error('end_date') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                </div>
            </div>
        </div>

        <!-- Usage Limits -->
        <div class="bg-white rounded-lg border border-gray-200 p-6">
            <h3 class="text-lg font-semibold text-gray-900 mb-4">Batasan Penggunaan</h3>
<<<<<<< HEAD
            
=======

>>>>>>> starkids
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Minimal Pembelian (Rp)</label>
                    <input type="number" wire:model="minimum_purchase" step="0.01" min="0" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent" placeholder="0">
                    @error('minimum_purchase') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Maksimal Diskon (Rp)</label>
                    <input type="number" wire:model="maximum_discount" step="0.01" min="0" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent" placeholder="Tidak terbatas">
                    @error('maximum_discount') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Batas Total Penggunaan</label>
                    <input type="number" wire:model="usage_limit" min="1" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent" placeholder="Tidak terbatas">
                    @error('usage_limit') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                </div>
            </div>

            <div class="mt-4">
                <label class="block text-sm font-medium text-gray-700 mb-2">Batas Penggunaan per Customer</label>
                <input type="number" wire:model="usage_limit_per_customer" min="1" max="100" class="w-full md:w-1/3 px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent" placeholder="Tidak terbatas">
                @error('usage_limit_per_customer') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
            </div>
        </div>

        <!-- Target Customers -->
        <div class="bg-white rounded-lg border border-gray-200 p-6">
            <h3 class="text-lg font-semibold text-gray-900 mb-4">Target Customer</h3>
<<<<<<< HEAD
            
=======

>>>>>>> starkids
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Jenis Customer *</label>
                <select wire:model="customer_type" class="w-full md:w-1/2 px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                    @foreach($customerTypes as $key => $label)
                        <option value="{{ $key }}">{{ $label }}</option>
                    @endforeach
                </select>
                @error('customer_type') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
            </div>

            @if($customer_type === 'specific')
                <div class="mt-4">
                    <label class="block text-sm font-medium text-gray-700 mb-2">Pilih Customer</label>
                    <select wire:model="customer_ids" multiple class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent" size="5">
                        <!-- Add customer options here -->
                    </select>
                    <p class="text-sm text-gray-500 mt-1">Tahan Ctrl/Cmd untuk memilih multiple customer</p>
                </div>
            @endif
        </div>

        <!-- Applicable Products -->
        <div class="bg-white rounded-lg border border-gray-200 p-6">
            <h3 class="text-lg font-semibold text-gray-900 mb-4">Produk/Layanan yang Berlaku</h3>
<<<<<<< HEAD
            
=======

>>>>>>> starkids
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Berlaku untuk *</label>
                <select wire:model="applicable_to" class="w-full md:w-1/2 px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                    @foreach($applicableToOptions as $key => $label)
                        <option value="{{ $key }}">{{ $label }}</option>
                    @endforeach
                </select>
                @error('applicable_to') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
            </div>

            @if($applicable_to === 'specific_products')
                <div class="mt-4">
                    <label class="block text-sm font-medium text-gray-700 mb-2">Pilih Produk</label>
                    <select wire:model="product_ids" multiple class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent" size="5">
                        <!-- Add product options here -->
                    </select>
                </div>
            @endif

            @if($applicable_to === 'categories')
                <div class="mt-4">
                    <label class="block text-sm font-medium text-gray-700 mb-2">Pilih Kategori</label>
                    <select wire:model="category_ids" multiple class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent" size="5">
                        <!-- Add category options here -->
                    </select>
                </div>
            @endif

            @if($applicable_to === 'services')
                <div class="mt-4">
                    <label class="block text-sm font-medium text-gray-700 mb-2">Pilih Layanan</label>
                    <select wire:model="service_ids" multiple class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent" size="5">
                        <!-- Add service options here -->
                    </select>
                </div>
            @endif
        </div>

        <!-- Terms & Conditions -->
        <div class="bg-white rounded-lg border border-gray-200 p-6">
            <h3 class="text-lg font-semibold text-gray-900 mb-4">Syarat & Ketentuan</h3>
<<<<<<< HEAD
            
=======

>>>>>>> starkids
            <div class="space-y-3">
                @foreach($terms_conditions as $index => $term)
                    <div class="flex items-center space-x-3">
                        <input type="text" wire:model="terms_conditions.{{ $index }}" class="flex-1 px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent" placeholder="Masukkan syarat atau ketentuan">
                        <button type="button" wire:click="removeTerm({{ $index }})" class="text-red-600 hover:text-red-800">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                            </svg>
                        </button>
                    </div>
                @endforeach
                <button type="button" wire:click="addTerm" class="text-blue-600 hover:text-blue-800 text-sm">
                    + Tambah Syarat/Ketentuan
                </button>
            </div>
        </div>

        <!-- Settings -->
        <div class="bg-white rounded-lg border border-gray-200 p-6">
            <h3 class="text-lg font-semibold text-gray-900 mb-4">Pengaturan</h3>
<<<<<<< HEAD
            
=======

>>>>>>> starkids
            <div class="space-y-4">
                <div class="flex items-center">
                    <input type="checkbox" wire:model="auto_apply" id="auto_apply" class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded">
                    <label for="auto_apply" class="ml-2 block text-sm text-gray-700">
                        Terapkan otomatis (tanpa kode promosi)
                    </label>
                </div>

                <div class="flex items-center">
                    <input type="checkbox" wire:model="is_featured" id="is_featured" class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded">
                    <label for="is_featured" class="ml-2 block text-sm text-gray-700">
                        Tampilkan sebagai promosi unggulan
                    </label>
                </div>

                <div class="flex items-center">
                    <input type="checkbox" wire:model="is_active" id="is_active" class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded">
                    <label for="is_active" class="ml-2 block text-sm text-gray-700">
                        Status aktif
                    </label>
                </div>
            </div>
        </div>

        <!-- Action Buttons -->
        <div class="flex items-center justify-between">
            <button type="button" wire:click="delete" wire:confirm="Apakah Anda yakin ingin menghapus promosi ini?" class="px-4 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700 transition-colors">
                Hapus Promosi
            </button>
<<<<<<< HEAD
            
=======

>>>>>>> starkids
            <div class="flex space-x-3">
                <button type="button" wire:click="cancel" class="px-4 py-2 text-gray-600 bg-gray-100 rounded-lg hover:bg-gray-200 transition-colors">
                    Batal
                </button>
                <button type="submit" class="px-6 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors">
                    Simpan Perubahan
                </button>
            </div>
        </div>
    </form>
</div>

<script>
    document.addEventListener('livewire:init', () => {
        Livewire.on('promotion-updated', (event) => {
            // Handle success notification
            console.log(event.message);
        });

        Livewire.on('promotion-error', (event) => {
            // Handle error notification
            console.log(event.message);
        });

        Livewire.on('promotion-deleted', (event) => {
            // Handle deletion success
            console.log(event.message);
        });
    });
</script>
