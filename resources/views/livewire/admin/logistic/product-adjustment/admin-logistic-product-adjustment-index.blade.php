<div>
    <!-- Header Section -->
    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4 mb-6">
        <div>
            <h1 class="text-2xl font-extrabold text-gray-900 tracking-tight">Perbaikan Stok & Harga</h1>
            <p class="text-sm text-gray-500 mt-1">Sesuaikan stok, HNA bruto/netto, dan harga jual produk melalui modal penyesuaian.</p>
        </div>
        <div class="flex items-center gap-3">
            <a href="{{ route('user.logistic.product-stock') }}" wire:navigate
                class="inline-flex items-center gap-2 px-4 py-2 bg-white border border-gray-200 rounded-xl text-sm font-semibold text-gray-700 hover:bg-gray-50 hover:border-gray-300 shadow-sm transition">
                <i class="fas fa-arrow-left text-xs"></i>
                Kembali ke Stok
            </a>
        </div>
    </div>

    <!-- Filter & Search Bar -->
    <div class="bg-white/80 backdrop-blur-sm rounded-xl shadow-sm border border-gray-100 p-4 mb-6">
        <div class="flex flex-col sm:flex-row justify-between items-center gap-4">
            <div class="flex items-center gap-2 w-full sm:w-auto">
                <span class="text-sm text-gray-500 font-medium">Tampil</span>
                <select wire:model.live="perPage" class="form-select text-sm py-1.5 px-3 rounded-lg border-gray-200">
                    <option value="10">10</option>
                    <option value="25">25</option>
                    <option value="50">50</option>
                    <option value="100">100</option>
                </select>
                <span class="text-sm text-gray-500 font-medium">data</span>
            </div>

            <div class="relative w-full sm:w-80">
                <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-gray-400">
                    <i class="fas fa-search text-sm"></i>
                </div>
                <input type="text" wire:model.live.debounce.300ms="search" placeholder="Cari nama produk, SKU..."
                    class="w-full pl-10 pr-4 py-2 bg-gray-50/50 border border-gray-200 rounded-xl text-sm focus:bg-white focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 transition" />
            </div>
        </div>
    </div>

    <!-- Table Section -->
    <div class="bg-white/80 backdrop-blur-sm rounded-xl shadow-lg border border-gray-100 overflow-hidden mb-6">
        <div class="table-container overflow-x-auto">
            <table class="table min-w-full">
                <thead>
                    <tr class="bg-gray-50/70 border-b border-gray-100">
                        <th class="w-1 text-center py-4 text-xs font-bold text-gray-500 uppercase tracking-wider">No</th>
                        <th class="py-4 text-xs font-bold text-gray-500 uppercase tracking-wider">Informasi Produk</th>
                        <th class="text-center py-4 text-xs font-bold text-gray-500 uppercase tracking-wider">Stok Saat Ini</th>
                        <th class="text-right py-4 text-xs font-bold text-gray-500 uppercase tracking-wider">HNA Netto (Dgn Diskon)</th>
                        <th class="text-right py-4 text-xs font-bold text-gray-500 uppercase tracking-wider">HNA Bruto (Tanpa Diskon)</th>
                        <th class="text-right py-4 text-xs font-bold text-gray-500 uppercase tracking-wider">Harga Jual Aktif</th>
                        <th class="text-center py-4 text-xs font-bold text-gray-500 uppercase tracking-wider w-36">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @forelse ($products as $index => $product)
                        <tr wire:key="product-{{ $product->id }}" class="hover:bg-blue-50/30 transition-colors">
                            <td class="text-center text-gray-500 font-mono text-xs">
                                {{ $products->firstItem() + $index }}
                            </td>
                            <td class="py-4">
                                <div class="font-bold text-[#1E3A8A] leading-tight text-sm">{{ $product->name }}</div>
                                <div class="flex items-center gap-2 mt-1">
                                    <span class="text-[10px] px-1.5 py-0.5 bg-gray-100 text-gray-600 rounded font-mono uppercase tracking-wider">
                                        {{ $product->sku_number ?: 'NO-SKU' }}
                                    </span>
                                    <span class="text-[10px] px-1.5 py-0.5 bg-blue-50 text-blue-700 rounded font-medium">
                                        {{ $product->unit->name ?? '-' }}
                                    </span>
                                </div>
                            </td>
                            <td class="text-center py-4 whitespace-nowrap">
                                <span class="px-2.5 py-1 bg-gray-100 text-gray-800 rounded-lg text-xs font-bold font-mono">
                                    {{ number_format($product->productStock->quantity ?? 0) }} {{ $product->unit->name ?? '' }}
                                </span>
                            </td>
                            <td class="text-right py-4 font-bold text-emerald-700 whitespace-nowrap">
                                Rp @number($product->productPrice?->hpp_average ?? 0)
                            </td>
                            <td class="text-right py-4 font-medium text-amber-800 whitespace-nowrap">
                                Rp @number($product->productPrice?->hpp_average_without_discount ?: ($product->productPrice?->hpp_average ?? 0))
                            </td>
                            <td class="text-right py-4 whitespace-nowrap">
                                <div class="flex items-center justify-end gap-1.5">
                                    <span class="font-bold text-blue-700">Rp @number($product->productPrice?->price ?? 0)</span>
                                    @php
                                        $currHna = (float) ($product->productPrice?->hpp_average ?? 0);
                                        $currPrice = (float) ($product->productPrice?->price ?? 0);
                                        $effMargin = $currHna > 0 ? round((($currPrice - $currHna) / $currHna) * 100, 1) : 0;
                                    @endphp
                                    @if ($currPrice > 0 && $currHna > 0)
                                        <span class="text-[10px] font-semibold px-1.5 py-0.5 rounded {{ $effMargin >= 0 ? 'bg-emerald-50 text-emerald-700 border border-emerald-200' : 'bg-red-50 text-red-700' }}">
                                            +{{ $effMargin }}%
                                        </span>
                                    @endif
                                </div>
                            </td>
                            <td class="text-center py-4">
                                <div class="flex items-center justify-center gap-1.5">
                                    <!-- Edit Adjustment Button -->
                                    <button type="button" wire:click="openAdjustmentModal('{{ $product->id }}')"
                                        class="px-3 py-1.5 bg-blue-600 hover:bg-blue-700 text-white rounded-lg text-xs font-semibold shadow-sm transition cursor-pointer flex items-center gap-1.5">
                                        <i class="fas fa-sliders-h text-[11px]"></i>
                                        <span>Sesuaikan</span>
                                    </button>

                                    <!-- History Button -->
                                    <button type="button" wire:click="showHistory('{{ $product->id }}')"
                                        title="Lihat Histori Harga & HNA"
                                        class="p-1.5 text-gray-500 hover:text-indigo-600 hover:bg-indigo-50 rounded-lg transition cursor-pointer">
                                        <i class="fas fa-history text-sm"></i>
                                    </button>
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
                                    <p class="text-gray-400 text-xs mt-0.5">Coba kata kunci pencarian yang lain.</p>
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
                    Menampilkan <span class="font-semibold text-gray-700">{{ $products->firstItem() ?? 0 }}</span> sampai
                    <span class="font-semibold text-gray-700">{{ $products->lastItem() ?? 0 }}</span> dari <span
                        class="font-semibold text-gray-700">{{ $products->total() ?? 0 }}</span> produk
                </div>
                <div>
                    {{ $products->links('vendor.livewire.custom') }}
                </div>
            </div>
        </div>
    </div>

    <!-- MODAL PENYESUAIAN STOK & HARGA -->
    <div wire:ignore.self id="adjustment-modal"
        class="fixed inset-0 bg-gray-900/50 backdrop-blur-sm hidden items-center justify-center z-50 transition-opacity duration-300 ease-in-out">
        <div
            class="bg-white rounded-2xl shadow-2xl max-w-xl w-full mx-4 transform transition-all scale-95 duration-300 ease-out animate-fade-in flex flex-col max-h-[90vh]">
            <!-- Header -->
            <div class="flex justify-between items-center p-5 sm:p-6 border-b border-gray-100 shrink-0">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 rounded-xl bg-blue-50 flex items-center justify-center text-blue-600 shrink-0">
                        <i class="fas fa-sliders-h text-lg"></i>
                    </div>
                    <div>
                        <h2 class="text-lg font-bold text-gray-900">Penyesuaian Stok & Harga</h2>
                        <p class="text-xs text-gray-500 font-medium line-clamp-1">{{ $productName }} ({{ $productSku }})</p>
                    </div>
                </div>
                <button type="button" wire:click="closeAdjustmentModal()"
                    onclick="document.getElementById('adjustment-modal').classList.add('hidden'); document.getElementById('adjustment-modal').classList.remove('flex');"
                    class="text-gray-400 hover:text-red-500 transition-colors text-2xl leading-none cursor-pointer p-1">
                    <i class="fas fa-times"></i>
                </button>
            </div>

            <!-- Body -->
            <div class="px-5 sm:px-6 py-4 overflow-y-auto grow space-y-4">
                <!-- Section 1: Stok -->
                <div class="bg-gray-50/70 p-3.5 rounded-xl border border-gray-200/80">
                    <div class="text-xs font-bold text-gray-700 uppercase tracking-wider mb-2.5 flex items-center gap-1.5">
                        <i class="fas fa-cubes text-blue-600"></i>
                        Penyesuaian Stok
                    </div>
                    <div class="grid grid-cols-2 gap-3">
                        <div>
                            <label class="block text-xs font-medium text-gray-500 mb-1">Stok Saat Ini</label>
                            <input type="text" disabled value="{{ number_format($currentStock) }} {{ $productUnit }}"
                                class="form-control bg-gray-100 font-bold text-gray-700 cursor-not-allowed text-sm">
                        </div>
                        <div>
                            <label class="block text-xs font-medium text-gray-700 mb-1">Stok Baru (Hasil Opname) <span class="text-red-500">*</span></label>
                            <input type="number" step="any" wire:model="adjustedStock" placeholder="0"
                                class="form-control font-bold text-blue-800 text-sm focus:ring-2 focus:ring-blue-500">
                            @error('adjustedStock') <p class="text-xs text-red-600 mt-1">{{ $message }}</p> @enderror
                        </div>
                    </div>
                </div>

                <!-- Section 2: HNA Bruto & Netto -->
                <div class="bg-gray-50/70 p-3.5 rounded-xl border border-gray-200/80">
                    <div class="text-xs font-bold text-gray-700 uppercase tracking-wider mb-2.5 flex items-center gap-1.5">
                        <i class="fas fa-coins text-emerald-600"></i>
                        HNA (Harga Pokok Pembelian)
                    </div>
                    <div class="grid grid-cols-2 gap-3">
                        <div>
                            <label class="block text-xs font-bold text-emerald-800 mb-1">HNA Netto (Dgn Diskon) <span class="text-red-500">*</span></label>
                            <div class="flex rounded-md shadow-sm">
                                <span class="inline-flex items-center rounded-l-md border border-r-0 border-emerald-200 bg-emerald-50 px-2.5 text-emerald-700 text-xs font-bold">
                                    Rp
                                </span>
                                <input type="text" onkeyup="convertToRupiah(this);" wire:model.live.debounce.300ms="adjustedHna"
                                    class="form-control rounded-l-none font-bold text-emerald-900 border-emerald-200 text-sm" />
                            </div>
                            @error('adjustedHna') <p class="text-xs text-red-600 mt-1">{{ $message }}</p> @enderror
                        </div>

                        <div>
                            <label class="block text-xs font-bold text-amber-800 mb-1">HNA Bruto (Tanpa Diskon)</label>
                            <div class="flex rounded-md shadow-sm">
                                <span class="inline-flex items-center rounded-l-md border border-r-0 border-amber-200 bg-amber-50 px-2.5 text-amber-700 text-xs font-bold">
                                    Rp
                                </span>
                                <input type="text" onkeyup="convertToRupiah(this);" wire:model="adjustedHnaGross"
                                    class="form-control rounded-l-none font-bold text-amber-900 border-amber-200 text-sm" />
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Section 3: Margin & Harga Jual -->
                <div class="bg-gray-50/70 p-3.5 rounded-xl border border-gray-200/80">
                    <div class="text-xs font-bold text-gray-700 uppercase tracking-wider mb-2.5 flex items-center gap-1.5">
                        <i class="fas fa-tags text-indigo-600"></i>
                        Margin & Harga Jual
                    </div>
                    <div class="grid grid-cols-2 gap-3">
                        <div>
                            <label class="block text-xs font-medium text-gray-700 mb-1">Margin (%) <span class="text-red-500">*</span></label>
                            <div class="flex rounded-md shadow-sm">
                                <input type="number" step="any" wire:model.live="margin_normal" placeholder="0"
                                    class="form-control rounded-r-none text-sm">
                                <span class="inline-flex items-center rounded-r-md border border-l-0 border-gray-300 bg-gray-100 px-3 text-gray-500 text-xs font-semibold">
                                    %
                                </span>
                            </div>
                            @error('margin_normal') <p class="text-xs text-red-600 mt-1">{{ $message }}</p> @enderror
                        </div>

                        <div>
                            <label class="block text-xs font-medium text-gray-700 mb-1">Harga Jual Baru <span class="text-red-500">*</span></label>
                            <div class="flex rounded-md shadow-sm">
                                <span class="inline-flex items-center rounded-l-md border border-r-0 border-gray-300 bg-gray-100 px-2.5 text-gray-500 text-xs font-semibold">
                                    Rp
                                </span>
                                <input type="text" onkeyup="convertToRupiah(this);" wire:model.live.debounce.400ms="adjustedPrice"
                                    class="form-control rounded-l-none font-bold text-blue-700 text-sm" />
                            </div>
                            @error('adjustedPrice') <p class="text-xs text-red-600 mt-1">{{ $message }}</p> @enderror
                        </div>
                    </div>
                </div>

                <!-- Section 4: Catatan -->
                <div>
                    <label class="block text-xs font-medium text-gray-700 mb-1">Catatan / Alasan Penyesuaian</label>
                    <input type="text" wire:model="adjustmentNotes" placeholder="Contoh: Koreksi fisik stock opname"
                        class="form-control text-sm">
                </div>
            </div>

            <!-- Footer -->
            <div class="flex justify-end gap-2 px-5 sm:px-6 py-3.5 border-t border-gray-100 bg-gray-50/50 rounded-b-2xl shrink-0">
                <button type="button" wire:click="closeAdjustmentModal()"
                    onclick="document.getElementById('adjustment-modal').classList.add('hidden'); document.getElementById('adjustment-modal').classList.remove('flex');"
                    class="px-4 py-2 bg-gray-200 hover:bg-gray-300 text-gray-700 text-sm font-semibold rounded-xl transition cursor-pointer">
                    Batal
                </button>
                <button type="button" wire:click="saveAdjustmentModal"
                    class="px-5 py-2 bg-blue-600 hover:bg-blue-700 text-white text-sm font-semibold rounded-xl shadow-sm transition cursor-pointer flex items-center gap-2">
                    <i class="fas fa-save"></i>
                    Simpan Penyesuaian
                </button>
            </div>
        </div>
    </div>

    <!-- Modal Histori Lengkap -->
    @include('livewire.admin.components.product-price-history-modal')

    <!-- Notification & Modal Script -->
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

        window.addEventListener('open-modal', event => {
            const modalId = event.detail.id || (event.detail[0] && event.detail[0].id);
            const modal = document.getElementById(modalId);
            if (modal) {
                modal.classList.remove('hidden');
                modal.classList.add('flex');
            }
        });

        window.addEventListener('close-modal', event => {
            const modalId = event.detail.id || (event.detail[0] && event.detail[0].id);
            const modal = document.getElementById(modalId);
            if (modal) {
                modal.classList.add('hidden');
                modal.classList.remove('flex');
            }
        });
    </script>
</div>