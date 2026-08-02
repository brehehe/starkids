<div>
    <div class="mb-4">
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-2xl font-bold text-[#1E3A8A]">Stok Produk</h1>
            </div>
        </div>
    </div>

    <!-- Summary Cards -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">
        <!-- Total Products Card -->
        <div class="bg-gradient-to-br from-blue-500 to-blue-600 rounded-xl shadow-lg p-6 text-white">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-blue-100 text-sm font-medium mb-1">Total Produk</p>
                    <h3 class="text-3xl font-bold">{{ number_format($summaryStats['total_products']) }}</h3>
                    <p class="text-blue-100 text-xs mt-2">Jenis Produk</p>
                </div>
                <div class="bg-white/20 rounded-full p-4">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" />
                    </svg>
                </div>
            </div>
        </div>

        <!-- Total Quantity Card -->
        <div class="bg-gradient-to-br from-green-500 to-green-600 rounded-xl shadow-lg p-6 text-white">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-green-100 text-sm font-medium mb-1">Total Quantity</p>
                    <h3 class="text-3xl font-bold">{{ number_format($summaryStats['total_quantity']) }}</h3>
                    <p class="text-green-100 text-xs mt-2">Unit Tersedia</p>
                </div>
                <div class="bg-white/20 rounded-full p-4">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z" />
                    </svg>
                </div>
            </div>
        </div>

        <!-- Total Stock Value Card -->
        <div class="bg-gradient-to-br from-purple-500 to-purple-600 rounded-xl shadow-lg p-6 text-white">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-purple-100 text-sm font-medium mb-1">Total Nilai Persediaan</p>
                    <h3 class="text-2xl font-bold">Rp{{ number_format($summaryStats['total_stock_value'], 0, ',', '.') }}
                    </h3>
                    <p class="text-purple-100 text-xs mt-2">Berdasarkan HNA</p>
                </div>
                <div class="bg-white/20 rounded-full p-4">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </div>
            </div>
        </div>
    </div>

    <!-- Filters Section -->
    <div class="bg-white/80 backdrop-blur-sm rounded-xl shadow-lg border border-gray-100 p-5 mb-6">
        <div class="flex items-center mb-4">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-600 mr-2" fill="none"
                viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z" />
            </svg>
            <h3 class="text-md font-semibold text-gray-800">Filter Produk</h3>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
            <!-- Kategori Filter -->
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Kategori</label>
                <select wire:model.live="product_category_id" class="form-control">
                    <option value="">Semua Kategori</option>
                    @foreach ($productCategories as $category)
                        <option value="{{ $category->id }}">{{ $category->name }}</option>
                    @endforeach
                </select>
            </div>

            <!-- Pabrik Filter -->
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Pabrik</label>
                <select wire:model.live="product_factory_id" class="form-control">
                    <option value="">Semua Pabrik</option>
                    @foreach ($productFactories as $factory)
                        <option value="{{ $factory->id }}">{{ $factory->name }}</option>
                    @endforeach
                </select>
            </div>

            <!-- Rak Filter -->
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Rak</label>
                <select wire:model.live="product_rack_id" class="form-control">
                    <option value="">Semua Rak</option>
                    @foreach ($productRacks as $rack)
                        <option value="{{ $rack->id }}">{{ $rack->name }}</option>
                    @endforeach
                </select>
            </div>

            <!-- Tipe Filter -->
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Tipe Produk</label>
                <select wire:model.live="product_type_id" class="form-control">
                    <option value="">Semua Tipe</option>
                    @foreach ($productTypes as $type)
                        <option value="{{ $type->id }}">{{ $type->name }}</option>
                    @endforeach
                </select>
            </div>
        </div>

        <!-- Periode / Tanggal Filter Section -->
        <div class="border-t border-gray-200 pt-4 mt-4">
            <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3 mb-3">
                <div class="flex items-center gap-4">
                    <span class="text-sm font-semibold text-gray-700">Filter Periode:</span>
                    <label class="inline-flex items-center text-sm text-gray-700 cursor-pointer">
                        <input type="radio" wire:model.live="filter_type" value="monthly" class="form-radio text-blue-600">
                        <span class="ml-2">Per Bulan & Tahun</span>
                    </label>
                    <label class="inline-flex items-center text-sm text-gray-700 cursor-pointer">
                        <input type="radio" wire:model.live="filter_type" value="custom" class="form-radio text-blue-600">
                        <span class="ml-2">Custom Tanggal</span>
                    </label>
                </div>
                <button wire:click="resetFilter" type="button" class="text-xs text-red-600 hover:text-red-800 font-medium underline flex items-center gap-1">
                    <i class="fas fa-undo"></i> Reset Filter
                </button>
            </div>

            @if ($filter_type === 'monthly')
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Bulan</label>
                        <select wire:model.live="month" class="form-control">
                            <option value="">Semua Bulan</option>
                            @foreach ($this->months as $key => $name)
                                <option value="{{ $key }}">{{ $name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Tahun</label>
                        <select wire:model.live="year" class="form-control">
                            @foreach ($this->years as $y)
                                <option value="{{ $y }}">{{ $y }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
            @else
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Tanggal Mulai</label>
                        <input type="date" wire:model.live="start_date" class="form-control">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Tanggal Selesai</label>
                        <input type="date" wire:model.live="end_date" class="form-control">
                    </div>
                </div>
            @endif
        </div>
    </div>

    <!-- Table Controls -->
    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center mb-4 gap-4">
        <div class="flex items-center">
            <span class="text-sm text-gray-700 mr-2">Tampil</span>
            <select class="mt-1 form-control" wire:model.live='perPage'>
                <option value="5">5</option>
                <option value="10">10</option>
                <option value="25">25</option>
                <option value="50">50</option>
                <option value="100">100</option>
            </select>
            <span class="text-sm text-gray-700 ml-2">data</span>
        </div>

        <div class="relative w-full sm:w-64">
            <input type="text" class="mt-1 form-control-search" placeholder="Cari Sesuatu..."
                wire:model.live='search'>
            <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                <i class="fas fa-search h-3 w-3 text-gray-400"></i>
            </div>
        </div>
    </div>

    <!-- Table Section -->
    <div class="bg-white/80 backdrop-blur-sm rounded-xl shadow-lg border border-gray-100 overflow-hidden mb-6">
        <div class="table-container">
            <table class="table">
                <thead>
                    <tr>
                        <th class="w-1 center">No</th>
                        <th>Sku Number</th>
                        <th>Nama Produk</th>
                        <th>HNA</th>
                        <th>Quantity</th>
                        <th>Total Persediaan</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($products as $index => $product)
                        <tr>
                            <td class="center">{{ $products->firstItem() + $index }}</td>
                            <td>{{ $product?->sku_number ?? '-' }}</td>
                            <td>{{ $product?->name ?? '-' }}</td>
                            <td>Rp{{ number_format($product?->productPrice?->hpp_average ?? 0, 0, ',', '.') }}</td>
                            <td>
                                <div class="flex items-center gap-1">
                                    <span>@number($product?->productStock?->quantity ?? 0)</span>
                                    <span class="text-gray-500 text-sm">/{{ $product->unit->name ?? '-' }}</span>
                                </div>
                            </td>
                            <td>Rp
                                {{ number_format(($product?->productPrice?->hpp_average ?? 0) * ($product?->productStock?->quantity ?? 0), 0, ',', '.') }}
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="no-data">Tidak ada data
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        <div class="px-5 py-4 bg-gray-50/80 border-t border-gray-200">
            <div class="flex items-center justify-between">
                <div class="text-sm text-gray-700">
                    Menampilkan <span class="font-medium">{{ $products->firstItem() }}</span> sampai <span
                        class="font-medium">{{ $products->lastItem() }}</span> dari <span
                        class="font-medium">{{ $products->total() }}</span> hasil
                </div>
                <div>
                    <nav class="relative z-0 inline-flex rounded-md shadow-sm -space-x-px" aria-label="Pagination">
                        {{ $products->links('vendor.livewire.custom') }}
                    </nav>
                </div>
            </div>
        </div>

    </div>
</div>
