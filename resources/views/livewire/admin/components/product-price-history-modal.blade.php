<div wire:ignore.self id="history-modal"
    class="fixed inset-0 bg-gray-900/50 backdrop-blur-sm hidden items-center justify-center z-50 transition-opacity duration-300 ease-in-out">
    <div
        class="bg-white rounded-2xl shadow-2xl max-w-5xl w-full mx-4 transform transition-all scale-95 duration-300 ease-out animate-fade-in flex flex-col max-h-[90vh]">
        <!-- Header -->
        <div class="flex justify-between items-center p-5 sm:p-6 border-b border-gray-100 shrink-0">
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 rounded-xl bg-blue-50 flex items-center justify-center text-blue-600 shrink-0">
                    <i class="fas fa-history text-lg"></i>
                </div>
                <div>
                    <h2 class="text-lg sm:text-xl font-bold text-gray-800">Histori Perubahan Harga & HNA Masuk</h2>
                    <p class="text-xs sm:text-sm text-gray-500 font-medium line-clamp-1">{{ $selectedProductName ?: 'Memuat data produk...' }}</p>
                </div>
            </div>
            <button wire:click="closeHistoryModal()"
                onclick="document.getElementById('history-modal').classList.add('hidden'); document.getElementById('history-modal').classList.remove('flex');"
                class="text-gray-400 hover:text-red-500 transition-colors text-2xl leading-none cursor-pointer p-1">
                <i class="fas fa-times"></i>
            </button>
        </div>

        <!-- Summary Cards -->
        <div class="grid grid-cols-2 sm:grid-cols-4 gap-3 px-5 sm:px-6 pt-4 shrink-0">
            <div class="bg-blue-50/60 rounded-xl p-3 border border-blue-100/80">
                <div class="text-[11px] text-blue-600 font-semibold uppercase tracking-wider">Harga Jual Aktif</div>
                <div class="text-base font-bold text-blue-900 mt-0.5">Rp {{ number_format($selectedProductPrice, 0, ',', '.') }}</div>
            </div>
            <div class="bg-emerald-50/60 rounded-xl p-3 border border-emerald-100/80">
                <div class="text-[11px] text-emerald-600 font-semibold uppercase tracking-wider">HNA Netto (Dgn Diskon)</div>
                <div class="text-base font-bold text-emerald-900 mt-0.5">Rp {{ number_format($selectedProductHna, 0, ',', '.') }}</div>
            </div>
            <div class="bg-amber-50/60 rounded-xl p-3 border border-amber-100/80">
                <div class="text-[11px] text-amber-600 font-semibold uppercase tracking-wider">HNA Bruto (Tanpa Diskon)</div>
                <div class="text-base font-bold text-amber-900 mt-0.5">Rp {{ number_format($selectedProductHnaGross, 0, ',', '.') }}</div>
            </div>
            <div class="bg-gray-50/80 rounded-xl p-3 border border-gray-200/80">
                <div class="text-[11px] text-gray-600 font-semibold uppercase tracking-wider">Total Stok Tersedia</div>
                <div class="text-base font-bold text-gray-900 mt-0.5">{{ number_format($selectedProductStock) }} <span class="text-xs font-normal text-gray-500">{{ $selectedProductUnit }}</span></div>
            </div>
        </div>

        <!-- Tab Navigation -->
        <div class="px-5 sm:px-6 pt-4 border-b border-gray-200 flex gap-4 text-sm font-semibold shrink-0">
            <button type="button" wire:click="setHistoryTab('purchase')"
                class="pb-3 border-b-2 transition-colors cursor-pointer {{ $historyTab === 'purchase' ? 'border-blue-600 text-blue-600' : 'border-transparent text-gray-500 hover:text-gray-700' }}">
                <i class="fas fa-boxes mr-1.5"></i> Riwayat Batch HNA & Diskon Masuk ({{ count($priceHistory) }})
            </button>
            <button type="button" wire:click="setHistoryTab('selling')"
                class="pb-3 border-b-2 transition-colors cursor-pointer {{ $historyTab === 'selling' ? 'border-blue-600 text-blue-600' : 'border-transparent text-gray-500 hover:text-gray-700' }}">
                <i class="fas fa-tags mr-1.5"></i> Riwayat Generate & Perubahan Harga Jual ({{ count($sellingPriceHistory) }})
            </button>
        </div>

        <!-- Body -->
        <div class="px-5 sm:px-6 py-4 overflow-y-auto grow">
            @if ($historyTab === 'selling')
                <!-- TAB 1: SELLING PRICE & GENERATE HISTORY -->
                <div class="table-container overflow-x-auto rounded-lg border border-gray-100">
                    <table class="table min-w-full text-sm">
                        <thead>
                            <tr class="bg-gray-50/80">
                                <th class="w-1 text-center py-3">No</th>
                                <th class="py-3">Tanggal & Waktu</th>
                                <th class="py-3">Sumber / Aksi Generate</th>
                                <th class="text-right py-3">Perubahan HNA (HPP)</th>
                                <th class="text-right py-3">Perubahan Harga Jual</th>
                                <th class="py-3">Keterangan / Margin</th>
                                <th class="py-3">Petugas</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100">
                            @forelse ($sellingPriceHistory as $idx => $sph)
                                <tr class="hover:bg-gray-50/50 transition-colors">
                                    <td class="text-center py-3 text-gray-500 text-xs font-mono">{{ $idx + 1 }}</td>
                                    <td class="py-3 font-medium text-gray-700 whitespace-nowrap">
                                        {{ $sph->created_at->format('d/m/Y') }}
                                        <span class="text-[11px] text-gray-400 font-mono ml-1">{{ $sph->created_at->format('H:i') }}</span>
                                    </td>
                                    <td class="py-3 whitespace-nowrap">
                                        <span class="px-2.5 py-1 bg-blue-50 text-blue-700 rounded-md text-xs font-semibold inline-flex items-center gap-1">
                                            <i class="fas fa-cog text-[10px]"></i>
                                            {{ $sph->source ?? 'Generate Harga Jual' }}
                                        </span>
                                    </td>
                                    <td class="text-right py-3 whitespace-nowrap">
                                        <div class="flex items-center justify-end gap-1.5 font-medium text-xs">
                                            <span class="text-gray-400 line-through">Rp {{ number_format($sph->old_hpp_average, 0, ',', '.') }}</span>
                                            <i class="fas fa-arrow-right text-[10px] text-gray-400"></i>
                                            <span class="text-emerald-700 font-bold">Rp {{ number_format($sph->new_hpp_average, 0, ',', '.') }}</span>
                                        </div>
                                    </td>
                                    <td class="text-right py-3 whitespace-nowrap">
                                        <div class="flex items-center justify-end gap-1.5 font-bold">
                                            <span class="text-gray-400 font-normal line-through text-xs">Rp {{ number_format($sph->old_price, 0, ',', '.') }}</span>
                                            <i class="fas fa-arrow-right text-[10px] text-gray-400"></i>
                                            <span class="text-blue-700">Rp {{ number_format($sph->new_price, 0, ',', '.') }}</span>
                                        </div>
                                    </td>
                                    <td class="py-3 text-xs text-gray-600">
                                        @if ($sph->margin > 0)
                                            <span class="px-2 py-0.5 bg-emerald-50 text-emerald-700 border border-emerald-200 rounded-md font-bold text-[11px] inline-block mr-1">
                                                +{{ number_format($sph->margin, 1) }}%
                                            </span>
                                        @endif
                                        <span class="text-gray-500">{{ $sph->notes ?: '-' }}</span>
                                    </td>
                                    <td class="py-3 text-gray-600 whitespace-nowrap text-xs">
                                        <i class="fas fa-user text-gray-400 mr-1"></i>
                                        {{ $sph->user->name ?? 'Sistem / Otomatis' }}
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7" class="py-8 text-center text-gray-400">
                                        <div class="flex flex-col items-center justify-center">
                                            <i class="fas fa-tags text-3xl mb-2 text-gray-300"></i>
                                            <p class="font-medium text-gray-500">Belum ada riwayat generate / perubahan harga jual</p>
                                            <p class="text-xs text-gray-400 mt-1">Setiap kali Anda menekan "Simpan Semua Harga" atau mengubah harga jual, riwayatnya akan muncul di sini.</p>
                                        </div>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            @else
                <!-- TAB 2: INCOMING BATCH HNA & DISCOUNT HISTORY -->
                <div class="table-container overflow-x-auto rounded-lg border border-gray-100">
                    <table class="table min-w-full text-sm">
                        <thead>
                            <tr class="bg-gray-50/80">
                                <th class="w-1 text-center py-3">No</th>
                                <th class="py-3">Tanggal & Faktur</th>
                                <th class="text-center py-3">Qty Masuk</th>
                                <th class="text-right py-3">HNA Bruto (Tanpa Diskon)</th>
                                <th class="text-center py-3">Diskon Faktur</th>
                                <th class="text-right py-3">HNA Netto (Dgn Diskon)</th>
                                <th class="text-right py-3">Total Biaya Bersih</th>
                                <th class="py-3">Petugas</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100">
                            @php
                                $totalBatchQty = 0;
                                $totalBatchCost = 0;
                                $totalBatchGrossCost = 0;
                            @endphp
                            @forelse ($priceHistory as $idx => $ph)
                                @php
                                    $poi = $ph->purchaseOrderItem;
                                    $prNumber = $poi?->purchaseRequisitionItem?->purchaseRequisition?->number 
                                                ?: ($poi?->purchaseOrder?->number ?: null);
                                    
                                    $grossUnit = (float) ($poi?->hna_ppn ?: ($poi?->price ?: $ph->price));
                                    $discountType = $poi?->discount_type;
                                    $discountVal = $poi?->discount_value;
                                    $discountNominal = (float) ($poi?->discount ?: 0);
                                    $netUnitPrice = (float) $ph->price;
                                    $netSubTotal = (float) $ph->sub_total_price;

                                    $totalBatchQty += (float) $ph->quantity;
                                    $totalBatchCost += $netSubTotal;
                                    $totalBatchGrossCost += ($grossUnit * (float) $ph->quantity);
                                @endphp
                                <tr class="hover:bg-gray-50/50 transition-colors">
                                    <td class="text-center py-3 text-gray-500 text-xs font-mono">{{ $idx + 1 }}</td>
                                    <td class="py-3 font-medium text-gray-700 whitespace-nowrap">
                                        <div class="font-semibold">{{ $ph->created_at->format('d/m/Y') }}</div>
                                        <div class="text-[11px] text-blue-600 font-mono">
                                            {{ $prNumber ?: 'Faktur Masuk' }}
                                        </div>
                                    </td>
                                    <td class="text-center py-3 whitespace-nowrap">
                                        <span class="px-2.5 py-0.5 bg-blue-50 text-blue-700 rounded-full text-xs font-bold">
                                            {{ number_format($ph->quantity) }} {{ $selectedProductUnit }}
                                        </span>
                                    </td>
                                    <td class="text-right py-3 text-gray-600 font-medium whitespace-nowrap">
                                        Rp {{ number_format($grossUnit, 0, ',', '.') }}
                                    </td>
                                    <td class="text-center py-3 whitespace-nowrap">
                                        @if ($discountNominal > 0 || $discountVal > 0)
                                            <span class="px-2 py-0.5 bg-amber-50 text-amber-700 border border-amber-200 rounded text-xs font-semibold">
                                                @if ($discountType === 'percentage' && $discountVal > 0)
                                                    {{ number_format($discountVal, 0) }}%
                                                @else
                                                    Rp {{ number_format($discountNominal, 0, ',', '.') }}
                                                @endif
                                            </span>
                                        @else
                                            <span class="text-gray-400 text-xs font-medium">0%</span>
                                        @endif
                                    </td>
                                    <td class="text-right py-3 font-bold text-emerald-700 whitespace-nowrap">
                                        Rp {{ number_format($netUnitPrice, 0, ',', '.') }}
                                    </td>
                                    <td class="text-right py-3 font-bold text-gray-800 whitespace-nowrap">
                                        Rp {{ number_format($netSubTotal, 0, ',', '.') }}
                                    </td>
                                    <td class="py-3 text-gray-500 whitespace-nowrap text-xs">
                                        {{ $ph->user->name ?? '-' }}
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="8" class="py-8 text-center text-gray-400">
                                        <div class="flex flex-col items-center justify-center">
                                            <i class="fas fa-boxes text-3xl mb-2 text-gray-300"></i>
                                            <p class="font-medium text-gray-500">Belum ada riwayat batch HNA masuk</p>
                                        </div>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                        @if (count($priceHistory) > 0)
                            <tfoot class="bg-gray-50/90 font-bold border-t-2 border-gray-200 text-gray-800">
                                <tr>
                                    <td colspan="2" class="py-3 text-right uppercase tracking-wider text-xs text-gray-600 font-bold">
                                        TOTAL KESELURUHAN :
                                    </td>
                                    <td class="text-center py-3 text-blue-700 font-bold">
                                        {{ number_format($totalBatchQty) }} {{ $selectedProductUnit }}
                                    </td>
                                    <td class="text-right py-3 text-amber-800 font-bold text-xs">
                                        Rata-rata: Rp {{ number_format($totalBatchQty > 0 ? ($totalBatchGrossCost / $totalBatchQty) : 0, 0, ',', '.') }}
                                    </td>
                                    <td class="text-center py-3 text-gray-500 text-xs font-normal">-</td>
                                    <td class="text-right py-3 text-emerald-700 font-bold text-xs">
                                        Rata-rata: Rp {{ number_format($totalBatchQty > 0 ? ($totalBatchCost / $totalBatchQty) : 0, 0, ',', '.') }}
                                    </td>
                                    <td class="text-right py-3 text-blue-900 font-black text-sm">
                                        Rp {{ number_format($totalBatchCost, 0, ',', '.') }}
                                    </td>
                                    <td class="py-3 text-gray-400 text-xs font-normal">-</td>
                                </tr>
                            </tfoot>
                        @endif
                    </table>
                </div>

                @if (count($priceHistory) > 0)
                    <!-- Calculation Formula Box -->
                    <div class="mt-3 grid grid-cols-1 sm:grid-cols-2 gap-3">
                        <div class="p-3 bg-emerald-50/70 border border-emerald-200/80 rounded-xl text-xs text-emerald-900">
                            <div class="flex items-center gap-2">
                                <i class="fas fa-check-circle text-emerald-600 text-base"></i>
                                <div>
                                    <div class="font-bold text-emerald-800">HNA Rata-rata DENGAN DISKON (Netto):</div>
                                    <div class="text-emerald-700 text-[11px]">Total Bersih (Rp {{ number_format($totalBatchCost, 0, ',', '.') }}) ÷ {{ number_format($totalBatchQty) }} unit</div>
                                </div>
                            </div>
                            <div class="font-black text-emerald-800 text-base mt-1.5 text-right">
                                = Rp {{ number_format($totalBatchQty > 0 ? ($totalBatchCost / $totalBatchQty) : 0, 0, ',', '.') }} / {{ $selectedProductUnit }}
                            </div>
                        </div>

                        <div class="p-3 bg-amber-50/70 border border-amber-200/80 rounded-xl text-xs text-amber-900">
                            <div class="flex items-center gap-2">
                                <i class="fas fa-info-circle text-amber-600 text-base"></i>
                                <div>
                                    <div class="font-bold text-amber-800">HNA Rata-rata TANPA DISKON (Bruto):</div>
                                    <div class="text-amber-700 text-[11px]">Total Bruto (Rp {{ number_format($totalBatchGrossCost, 0, ',', '.') }}) ÷ {{ number_format($totalBatchQty) }} unit</div>
                                </div>
                            </div>
                            <div class="font-black text-amber-800 text-base mt-1.5 text-right">
                                = Rp {{ number_format($totalBatchQty > 0 ? ($totalBatchGrossCost / $totalBatchQty) : 0, 0, ',', '.') }} / {{ $selectedProductUnit }}
                            </div>
                        </div>
                    </div>
                @endif
            @endif
        </div>

        <!-- Footer -->
        <div class="flex justify-end px-5 sm:px-6 py-3.5 border-t border-gray-100 bg-gray-50/50 rounded-b-2xl shrink-0">
            <button type="button" wire:click="closeHistoryModal()"
                onclick="document.getElementById('history-modal').classList.add('hidden'); document.getElementById('history-modal').classList.remove('flex');"
                class="px-4 py-2 bg-gray-200 hover:bg-gray-300 text-gray-700 text-sm font-semibold rounded-xl transition cursor-pointer">
                Tutup
            </button>
        </div>
    </div>
</div>
