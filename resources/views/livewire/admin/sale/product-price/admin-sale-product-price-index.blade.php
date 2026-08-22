<div>
    @include('livewire.admin.sale.product-price.admin-sale-product-price-modal')
    <div class="mb-4">
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-2xl font-bold text-[#1E3A8A]">Harga Jual</h1>
            </div>
        </div>
    </div>

    <!-- Statistics Cards -->
    <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-6">
        <!-- Total Products -->
        <div class="bg-gradient-to-br from-blue-500 to-blue-600 rounded-xl shadow-lg p-6 text-white">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-blue-100 text-sm font-medium">Total Produk</p>
                    <h3 class="text-3xl font-bold mt-2">@number($totalProducts)</h3>
                </div>
                <div class="bg-white/20 rounded-full p-3">
                    <i class="fas fa-boxes text-2xl"></i>
                </div>
            </div>
        </div>

        <!-- Total Quantity -->
        <div class="bg-gradient-to-br from-green-500 to-green-600 rounded-xl shadow-lg p-6 text-white">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-green-100 text-sm font-medium">Total Quantity</p>
                    <h3 class="text-3xl font-bold mt-2">@number($totalQuantity)</h3>
                </div>
                <div class="bg-white/20 rounded-full p-3">
                    <i class="fas fa-cubes text-2xl"></i>
                </div>
            </div>
        </div>

        <!-- Total HNA -->
        <div class="bg-gradient-to-br from-orange-500 to-orange-600 rounded-xl shadow-lg p-6 text-white">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-orange-100 text-sm font-medium">Total HNA</p>
                    <h3 class="text-2xl font-bold mt-2">Rp @number($totalHNA)</h3>
                </div>
                <div class="bg-white/20 rounded-full p-3">
                    <i class="fas fa-money-bill-wave text-2xl"></i>
                </div>
            </div>
        </div>

        <!-- Total Price -->
        <div class="bg-gradient-to-br from-purple-500 to-purple-600 rounded-xl shadow-lg p-6 text-white">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-purple-100 text-sm font-medium">Total Harga Jual</p>
                    <h3 class="text-2xl font-bold mt-2">Rp @number($totalPrice)</h3>
                </div>
                <div class="bg-white/20 rounded-full p-3">
                    <i class="fas fa-hand-holding-usd text-2xl"></i>
                </div>
            </div>
        </div>
    </div>

    <!-- Filter Section -->
    <div class="bg-white rounded-xl shadow-lg border border-gray-100 p-6 mb-6">
        <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Kategori</label>
                <select class="form-control" wire:model.live="product_category_id">
                    <option value="">Semua Kategori</option>
                    @foreach ($categories as $category)
                        <option value="{{ $category['id'] }}">{{ $category['name'] }}</option>
                    @endforeach
                </select>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Pabrik</label>
                <select class="form-control" wire:model.live="product_factory_id">
                    <option value="">Semua Pabrik</option>
                    @foreach ($factories as $factory)
                        <option value="{{ $factory['id'] }}">{{ $factory['name'] }}</option>
                    @endforeach
                </select>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Rak</label>
                <select class="form-control" wire:model.live="product_rack_id">
                    <option value="">Semua Rak</option>
                    @foreach ($racks as $rack)
                        <option value="{{ $rack['id'] }}">{{ $rack['name'] }}</option>
                    @endforeach
                </select>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Tipe Produk</label>
                <select class="form-control" wire:model.live="product_type_id">
                    <option value="">Semua Tipe</option>
                    @foreach ($types as $type)
                        <option value="{{ $type['id'] }}">{{ $type['name'] }}</option>
                    @endforeach
                </select>
            </div>
        </div>
    </div>

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
    <div class="bg-white/80 backdrop-blur-sm rounded-xl shadow-lg border border-gray-100 overflow-hidden mb-6">
        <div class="table-container">
            <table class="table">
                <thead>
                    <tr>
                        <th class="w-1 center">No</th>
                        <th>Sku Number</th>
                        <th>Nama Produk</th>
                        <th>Tipe Produk</th>
                        <th>Stok</th>
                        <th>HNA</th>
                        <th>HNA Total</th>
                        <th>Harga</th>
                        <th>Harga Total</th>
                        {{-- <th>Harga Resep</th> --}}
                        <th class="w-1 center">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($productPrices as $index => $productPrice)
                        <tr class="hover:bg-gray-50/60 transition-colors">
                            <td class="center">{{ $productPrices->firstItem() + $index }}</td>
                            <td class="font-mono text-xs text-gray-600">{{ $productPrice->product?->sku_number ?? '-' }}</td>
                            <td class="font-semibold text-gray-800">{{ $productPrice->product?->name ?? '-' }}</td>
                            <td>{{ $productPrice->product?->productType?->name ?? '-' }}</td>
                            <td>@number($productPrice?->product?->productStock?->quantity ?? 0)</td>
                            <td>
                                <div class="font-bold text-emerald-700">Rp @number($productPrice->hpp_average)</div>
                                @if (($productPrice->hpp_average_without_discount ?? 0) > 0 && abs(($productPrice->hpp_average_without_discount ?? 0) - $productPrice->hpp_average) > 0.01)
                                    <div class="text-[10px] text-amber-800 font-medium" title="HNA Bruto (Tanpa Diskon)">
                                        Bruto: Rp @number($productPrice->hpp_average_without_discount)
                                    </div>
                                @endif
                            </td>
                            <td>Rp @number($productPrice->hpp_average * $productPrice?->product?->productStock?->quantity ?? 0)</td>
                            <td>
                                <div class="flex items-center gap-1.5">
                                    <span class="font-bold text-blue-700">Rp @number($productPrice->price)</span>
                                    @php
                                        $effMargin = $productPrice->hpp_average > 0 ? round((($productPrice->price - $productPrice->hpp_average) / $productPrice->hpp_average) * 100, 1) : 0;
                                    @endphp
                                    @if ($productPrice->price > 0 && $productPrice->hpp_average > 0)
                                        <span class="text-[10px] font-semibold px-1.5 py-0.5 rounded {{ $effMargin >= 0 ? 'bg-emerald-50 text-emerald-700 border border-emerald-200' : 'bg-red-50 text-red-700' }}">
                                            {{ $effMargin >= 0 ? '+' : '' }}{{ $effMargin }}%
                                        </span>
                                    @endif
                                </div>
                            </td>
                            <td class="font-semibold text-gray-700">Rp @number($productPrice->price * $productPrice?->product?->productStock?->quantity ?? 0)</td>
                            <td class="center">
                                <div class="flex items-center justify-center gap-1">
                                    <!-- History Button -->
                                    <button
                                        class="btn btn-icon text-indigo-600 hover:text-indigo-800 hover:bg-indigo-50 transition-colors"
                                        wire:click="showHistory('{{ $productPrice->product_id }}')"
                                        title="Lihat Histori Harga & HNA">
                                        <i class="fas fa-history text-sm"></i>
                                    </button>

                                    @if (Auth::user()->is_head)
                                        <!-- Edit Button -->
                                        <button
                                            class="btn btn-icon text-blue-600 hover:text-blue-800 hover:bg-blue-50 transition-colors edit-btn"
                                            wire:click="edit('{{ $productPrice->id }}')"
                                            title="Ubah Harga Jual">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none"
                                                viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                            </svg>
                                        </button>
                                    @endif
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="10" class="no-data">Tidak ada data</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        <div class="px-5 py-4 bg-gray-50/80 border-t border-gray-200">
            <div class="flex items-center justify-between">
                <div class="text-sm text-gray-700">
                    Menampilkan <span class="font-medium">{{ $productPrices->firstItem() }}</span> sampai <span
                        class="font-medium">{{ $productPrices->lastItem() }}</span> dari <span
                        class="font-medium">{{ $productPrices->total() }}</span> hasil
                </div>
                <div>
                    <nav class="relative z-0 inline-flex rounded-md shadow-sm -space-x-px" aria-label="Pagination">
                        {{ $productPrices->links('vendor.livewire.custom') }}
                    </nav>
                </div>
            </div>
        </div>
    </div>

    @include('livewire.admin.components.product-price-history-modal')
</div>
