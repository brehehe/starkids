<div>
    <div class="mb-6">
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-2xl font-bold text-[#1E3A8A]">Perbaikan Stok & Harga</h1>
                <p class="text-gray-500 text-sm">Sesuaikan stok, HNA, dan harga jual produk secara langsung jika terjadi
                    kesalahan data.</p>
            </div>
            <div class="flex gap-2">
                <flux:button variant="ghost" icon="arrow-left" href="{{ route('user.logistic.product-stock') }}">
                    Kembali ke Stok
                </flux:button>
            </div>
        </div>
    </div>

    <!-- Table Controls -->
    <div class="bg-white/80 backdrop-blur-sm rounded-xl shadow-lg border border-gray-100 p-4 mb-6">
        <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
            <div class="flex items-center">
                <span class="text-sm text-gray-700 mr-2">Tampil</span>
                <select class="form-control h-10 py-1" wire:model.live='perPage'>
                    <option value="5">5</option>
                    <option value="10">10</option>
                    <option value="25">25</option>
                    <option value="50">50</option>
                </select>
                <span class="text-sm text-gray-700 ml-2">data</span>
            </div>

            <div class="relative w-full sm:w-80">
                <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                    <i class="fas fa-search text-gray-400"></i>
                </div>
                <input type="text" class="form-control-search pl-10" placeholder="Cari Nama Produk atau SKU..."
                    wire:model.live.debounce.300ms='search'>
            </div>
        </div>
    </div>

    <!-- Table Section -->
    <div class="bg-white/80 backdrop-blur-sm rounded-xl shadow-lg border border-gray-100 overflow-hidden mb-6">
        <div class="table-container overflow-x-auto">
            <table class="table min-w-full">
                <thead>
                    <tr class="bg-gray-50/50">
                        <th class="w-1 text-center py-4">No</th>
                        <th class="py-4">Informasi Produk</th>
                        <th class="text-right py-4">Stok Saat Ini</th>
                        <th class="py-4">Penyesuaian Stok</th>
                        <th class="py-4">HNA (HPP Rata-rata)</th>
                        <th class="py-4">Harga Jual</th>
                        <th class="text-center py-4">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @forelse ($products as $index => $product)
                        <tr wire:key="product-{{ $product->id }}" class="hover:bg-blue-50/30 transition-colors">
                            <td class="text-center text-gray-500 font-medium">
                                {{ $products->firstItem() + $index }}
                            </td>
                            <td class="py-4">
                                <div class="font-bold text-[#1E3A8A] leading-tight">{{ $product->name }}</div>
                                <div class="flex items-center gap-2 mt-1">
                                    <span
                                        class="text-[10px] px-1.5 py-0.5 bg-gray-100 text-gray-600 rounded font-mono uppercase tracking-wider">
                                        {{ $product->sku_number ?: 'NO-SKU' }}
                                    </span>
                                    <span class="text-[10px] px-1.5 py-0.5 bg-blue-50 text-blue-600 rounded font-medium">
                                        {{ $product->unit->name ?? '-' }}
                                    </span>
                                </div>
                            </td>
                            <td class="text-right py-4 font-semibold text-gray-700">
                                {{ number_format($product->productStock->quantity ?? 0) }}
                            </td>
                            <td class="py-4">
                                <div class="relative max-w-[140px]">
                                    <flux:input type="number" wire:model="editingStocks.{{ $product->id }}"
                                        placeholder="{{ $product->productStock->quantity ?? 0 }}" class="!h-9 text-sm" />
                                </div>
                            </td>
                            <td class="py-4">
                                <div class="relative max-w-[160px]">
                                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none z-10">
                                        <span class="text-gray-400 text-xs font-medium">Rp</span>
                                    </div>
                                    <flux:input type="number" wire:model="editingHnas.{{ $product->id }}"
                                        placeholder="{{ number_format($product->productPrice->hpp_average ?? 0, 0, '', '') }}"
                                        class="!h-9 pl-8 text-sm" />
                                </div>
                            </td>
                            <td class="py-4">
                                <div class="relative max-w-[160px]">
                                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none z-10">
                                        <span class="text-gray-400 text-xs font-medium">Rp</span>
                                    </div>
                                    <flux:input type="number" wire:model="editingPrices.{{ $product->id }}"
                                        placeholder="{{ number_format($product->productPrice->price ?? 0, 0, '', '') }}"
                                        class="!h-9 pl-8 text-sm" />
                                </div>
                            </td>
                            <td class="text-center py-4">
                                <div class="flex items-center justify-center gap-2">
                                    <flux:button variant="primary" size="sm"
                                        wire:click="saveAdjustment('{{ $product->id }}')" wire:loading.attr="disabled"
                                        class="!py-1.5">
                                        Simpan
                                    </flux:button>
                                    <flux:button variant="ghost" size="sm" icon="clock"
                                        wire:click="showHistory('{{ $product->id }}')" class="!py-1.5 !px-2"
                                        title="Lihat Histori" />
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="text-center py-12">
                                <div class="flex flex-col items-center">
                                    <div class="bg-gray-50 rounded-full p-4 mb-3">
                                        <i class="fas fa-box-open text-3xl text-gray-300"></i>
                                    </div>
                                    <p class="text-gray-500 font-medium">Tidak ada data produk ditemukan.</p>
                                    <p class="text-gray-400 text-xs">Coba kata kunci pencarian yang lain.</p>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        <div class="px-6 py-4 bg-gray-50/50 border-t border-gray-100">
            <div class="flex flex-col sm:flex-row items-center justify-between gap-4">
                <div class="text-sm text-gray-500">
                    Menampilkan <span class="font-semibold text-gray-700">{{ $products->firstItem() }}</span> sampai
                    <span class="font-semibold text-gray-700">{{ $products->lastItem() }}</span> dari <span
                        class="font-semibold text-gray-700">{{ $products->total() }}</span> produk
                </div>
                <div>
                    {{ $products->links('vendor.livewire.custom') }}
                </div>
            </div>
        </div>
    </div>

    <!-- History Modal -->
    <!-- History Modal -->
    <div wire:ignore.self id="history-modal"
        class="fixed inset-0 bg-gray-900/50 backdrop-blur-sm hidden items-center justify-center z-50 transition-opacity duration-300 ease-in-out">
        <div
            class="bg-white rounded-2xl shadow-2xl max-w-4xl w-full transform transition-all scale-95 duration-300 ease-out animate-fade-in">
            <!-- Header -->
            <div class="flex justify-between items-center p-6 border-b">
                <div class="flex items-center gap-4">
                    <i class="fas fa-history text-blue-500 text-xl"></i>
                    <div>
                        <h2 class="text-xl font-semibold text-gray-800">Histori Harga & HNA</h2>
                        <p class="text-sm text-gray-500">{{ $selectedProductName }}</p>
                    </div>
                </div>
                <button onclick="document.getElementById('history-modal').classList.add('hidden'); document.getElementById('history-modal').classList.remove('flex');"
                    class="text-gray-400 hover:text-red-500 transition-colors text-2xl leading-none cursor-pointer">
                    <i class="fas fa-times"></i>
                </button>
            </div>

            <!-- Body -->
            <div class="px-6 py-4" style="max-height: 70vh; overflow-y: auto;">
                <div class="table-container overflow-x-auto rounded-lg border border-gray-100">
                    <table class="table min-w-full text-sm">
                        <thead>
                            <tr class="bg-gray-50">
                                <th class="py-3">Tanggal</th>
                                <th class="text-right py-3">Harga Jual</th>
                                <th class="text-right py-3">HNA (HPP)</th>
                                <th class="text-center py-3">Stok Saat Itu</th>
                                <th class="py-3">Petugas</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100">
                            @forelse ($priceHistory as $history)
                                <tr class="hover:bg-gray-50/50 transition-colors">
                                    <td class="py-3 font-medium text-gray-600">
                                        {{ $history->created_at->format('d/m/Y') }}
                                        <div class="text-[10px] text-gray-400">{{ $history->created_at->format('H:i') }}</div>
                                    </td>
                                    <td class="text-right py-3 font-bold text-blue-600">
                                        Rp {{ number_format($history->price, 0, ',', '.') }}
                                    </td>
                                    <td class="text-right py-3 font-semibold text-gray-700">
                                        Rp {{ number_format($history->hpp_average, 0, ',', '.') }}
                                    </td>
                                    <td class="text-center py-3">
                                        <span class="px-2 py-0.5 bg-gray-100 text-gray-600 rounded-full text-xs font-medium">
                                            {{ number_format($history->quantity) }}
                                        </span>
                                    </td>
                                    <td class="py-3 text-gray-500">
                                        {{ $history->user->name ?? '-' }}
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="text-center py-8 text-gray-400 italic">
                                        Belum ada histori harga untuk produk ini.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Footer -->
            <div class="flex justify-end items-center px-6 py-4 border-t bg-gray-50 rounded-b-2xl">
                <button onclick="document.getElementById('history-modal').classList.add('hidden'); document.getElementById('history-modal').classList.remove('flex');"
                    class="px-6 py-2 bg-gray-200 hover:bg-gray-300 text-gray-800 rounded-lg shadow-sm transition font-medium cursor-pointer">
                    Tutup
                </button>
            </div>
        </div>
    </div>

    <!-- Notification Scripts -->
    <script>
        window.addEventListener('notify', event => {
            const data = event.detail[0] || event.detail;
            Swal.fire({
                icon: data.type,
                title: data.message,
                toast: true,
                position: 'top-end',
                showConfirmButton: false,
                timer: 3000,
                timerProgressBar: true,
            });
        });
    </script>
</div>