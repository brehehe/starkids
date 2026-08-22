<div>
    @include('livewire.admin.sale.price.admin-sale-price-modal')
    @include('livewire.admin.components.product-price-history-modal')

    <div class="mb-4">
        <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-3">
            <div>
                <h1 class="text-2xl font-bold text-[#1E3A8A]">Update Harga Jual</h1>
                <p class="text-sm text-gray-500 mt-0.5">Daftar produk yang memiliki HNA baru dan perlu penyesuaian harga jual</p>
            </div>
            <div class="flex items-center gap-2">
                <button wire:click="generate()" class="btn bg-yellow-500 text-white hover:bg-yellow-600 transition shadow-sm flex items-center gap-2">
                    <i class="fa-solid fa-calculator"></i>
                    Hitung Margin
                </button>
                <button wire:click="confirmUpdatePrice()" class="btn bg-blue-600 text-white hover:bg-blue-700 transition shadow-sm flex items-center gap-2">
                    <i class="fa-solid fa-floppy-disk"></i>
                    Simpan Semua Harga
                </button>
            </div>
        </div>
    </div>

    <div class="mb-4">
        <label for="margin" class="block text-sm font-medium text-gray-700">Margin Massal (%) <span
                class="text-red-600">*</span></label>
        <div class="flex items-center gap-3 mt-1">
            <input type="number" id="margin" wire:model.live="margin" {{ empty($selectedProducts) ? 'disabled' : '' }}
                placeholder="Masukkan persentase margin (misal: 20)" class="form-control max-w-xs">
            <span class="text-xs text-gray-500">Centang produk di tabel untuk mengaktifkan perhitungan massal</span>
        </div>
        @error('margin')
            <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
        @enderror
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
            <input type="text" class="mt-1 form-control-search" placeholder="Cari Sesuatu..." wire:model.live='search'>
            <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                <i class="fas fa-search h-3 w-3 text-gray-400"></i>
            </div>
        </div>
    </div>

    <div class="bg-white/80 backdrop-blur-sm rounded-xl shadow-lg border border-gray-100 overflow-hidden mb-6">
        <div class="table-container overflow-x-auto">
            <table class="table min-w-full">
                <thead>
                    <tr>
                        <th class="w-1 center">
                            <input type="checkbox" wire:model.live="selectAll">
                        </th>
                        <th class="w-1 center">No</th>
                        <th>Sku Number</th>
                        <th>Nama Produk</th>
                        <th>Margin Master</th>
                        <th class="text-right">HNA Bruto (Tanpa Diskon)</th>
                        <th class="text-right">HNA Netto (Dgn Diskon)</th>
                        <th class="text-right">Harga Jual Saat Ini</th>
                        <th class="text-right">Harga Generate</th>
                        <th class="w-1 center">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($productPrices as $index => $productPrice)
                        <tr class="hover:bg-gray-50/60 transition-colors">
                            <td class="center">
                                <input type="checkbox" wire:model.live="selectedProducts" value="{{ $productPrice->id }}"
                                    class="h-4 w-4 text-blue-600 border-gray-300 rounded">
                            </td>
                            <td class="center">{{ $productPrices->firstItem() + $index }}</td>
                            <td class="font-mono text-xs text-gray-600">{{ $productPrice->product?->sku_number ?? '-' }}</td>
                            <td class="font-semibold text-gray-800">{{ $productPrice->product?->name ?? '-' }}</td>
                            <td>
                                <span class="px-2 py-0.5 bg-blue-50 text-blue-700 rounded text-xs font-bold">
                                    {{ $productPrice->product?->normal ?? 0 }}%
                                </span>
                            </td>
                            <td class="text-right font-medium text-amber-800 whitespace-nowrap">
                                Rp @number($productPrice->hpp_average_without_discount ?: $productPrice->hpp_average)
                            </td>
                            <td class="text-right font-bold text-emerald-700 whitespace-nowrap">
                                Rp @number($productPrice->hpp_average)
                            </td>
                            <td class="text-right text-gray-500 font-medium">Rp @number($productPrice->price)</td>
                            <td class="text-right font-bold {{ $productPrice->price_generate > 0 ? 'text-emerald-600' : 'text-gray-400' }}">
                                <div class="flex items-center justify-end gap-1">
                                    <span>Rp @number($productPrice->price_generate > 0 ? $productPrice->price_generate : $productPrice->price)</span>
                                    @php
                                        $genP = (float) ($productPrice->price_generate > 0 ? $productPrice->price_generate : $productPrice->price);
                                        $effMargin = $productPrice->hpp_average > 0 ? round((($genP - $productPrice->hpp_average) / $productPrice->hpp_average) * 100, 1) : 0;
                                    @endphp
                                    @if ($genP > 0 && $productPrice->hpp_average > 0)
                                        <span class="text-[10px] font-semibold px-1 py-0.5 rounded {{ $effMargin >= 0 ? 'bg-emerald-50 text-emerald-700 border border-emerald-200' : 'bg-red-50 text-red-700' }}">
                                            +{{ $effMargin }}%
                                        </span>
                                    @endif
                                </div>
                            </td>
                            <td class="center">
                                <div class="flex items-center justify-center gap-1">
                                    <!-- History Button -->
                                    <button
                                        class="btn btn-icon text-indigo-600 hover:text-indigo-800 hover:bg-indigo-50 transition-colors"
                                        wire:click="showHistory('{{ $productPrice->product_id }}')"
                                        title="Lihat Histori Harga & HNA">
                                        <i class="fas fa-history text-sm"></i>
                                    </button>

                                    <!-- Edit Button -->
                                    <button
                                        class="btn btn-icon text-blue-600 hover:text-blue-800 hover:bg-blue-50 transition-colors edit-btn"
                                        wire:click="openModal('{{ $productPrice->id }}')"
                                        title="Ubah Harga Jual">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none"
                                            viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                        </svg>
                                    </button>

                                    <!-- Delete Button -->
                                    <button class="btn btn-icon text-red-600 hover:text-red-800 hover:bg-red-50 transition-colors edit-btn"
                                        wire:click="confirmDeleteProductPrice('{{ $productPrice->id }}')"
                                        title="Abaikan / Tandai Selesai">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none"
                                            viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                        </svg>
                                    </button>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="10" class="no-data py-8 text-center text-gray-400">
                                <div class="flex flex-col items-center justify-center">
                                    <i class="fa-solid fa-circle-check text-3xl mb-2 text-emerald-400"></i>
                                    <p class="font-medium text-gray-600">Semua harga jual sudah mutakhir</p>
                                    <p class="text-xs text-gray-400 mt-0.5">Tidak ada produk dengan HNA baru yang menunggu persetujuan harga</p>
                                </div>
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
                    Menampilkan <span class="font-medium">{{ $productPrices->firstItem() ?? 0 }}</span> sampai <span
                        class="font-medium">{{ $productPrices->lastItem() ?? 0 }}</span> dari <span
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