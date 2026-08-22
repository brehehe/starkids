<div>
    <div class="mb-4">
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-2xl font-bold text-[#1E3A8A]">Pembelian Langsung</h1>
            </div>
            @if (!$purchase_requisition_id)
                <div>
                    <button wire:click="confirmSubmit()" class="btn btn-primary">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                        </svg>
                        Simpan Pembelian Langsung
                    </button>
                </div>
            @else
                <div>
                    <button wire:click="confirmSubmit()" class="btn btn-success">
                        <i class="fa-solid fa-save me-1"></i>
                        Simpan Perubahan
                    </button>
                </div>
            @endif
        </div>
    </div>
    <div class="p-6 bg-white shadow rounded-lg mb-4">
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
            <div>
                <label for="number_purchase_order" class="block text-sm font-medium text-gray-700">Invoice Supplier
                    <span class="text-red-600">*</span></label>
                <input type="text" class="mt-1 form-control" wire:model.live='number_purchase_order'
                    id="number_purchase_order" placeholder="XXXXXXXXX" autocomplete="false">
                @error('number_purchase_order')
                    <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                @enderror
            </div>
            <div>
                <label for="supplier_id" class="block text-sm font-medium text-gray-700">Supplier <span
                        class="text-red-600">*</span></label>
                <div wire:key="select-{{ rand() }}">
                    <select class="mt-1 form-control" x-data x-ref="input" x-init="$($refs.input).selectize({
                        dropdownParent: 'body',
                        allowClear: true,
                        plugins: ['clear_button'],
                        onChange: function(e) {
                            @this.set('supplier_id', e ? e : null);
                        }
                    });"
                        wire:model.lazy="supplier_id" id="supplier_id">
                        <option value="">-- Pilih Supplier --</option>
                        @foreach ($suppliers as $key_supplier => $supplier)
                            <option value="{{ $key_supplier }}">{{ $supplier }}</option>
                        @endforeach
                    </select>
                </div>
                @error('supplier_id')
                    <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                @enderror
            </div>
            <div>
                <label for="grand_total" class="block text-sm font-medium text-gray-700">Total Biaya <span
                        class="text-red-600">*</span></label>
                <div class="mt-1 flex rounded-md shadow-sm">
                    <span
                        class="inline-flex items-center rounded-l-md border border-r-0 border-gray-300 bg-gray-100 px-3 text-gray-500 text-sm">
                        Rp
                    </span>
                    <input type="text" disabled wire:model='grand_total' class="form-control rounded-l-none"
                        placeholder="0" />
                </div>
                @error('grand_total')
                    <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                @enderror
            </div>
            <div class="md:col-span-3">
                <label for="notes" class="block text-sm font-medium text-gray-700">Catatan <span
                        class="text-red-600">*</span></label>
                <textarea name="notes" id="notes" wire:model="notes" class="mt-1 form-control" placeholder="Masukkan catatan..."></textarea>
                @error('notes')
                    <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                @enderror
            </div>
        </div>
    </div>
    <div class="mb-4">
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-2xl font-bold text-[#1E3A8A]">Detail Pembelian Langsung</h1>
            </div>
            <div>
                <button wire:click="addDetails()" class="btn btn-warning">
                    <!-- Font Awesome File Icon -->
                    <i class="fa-solid fa-circle-plus text-xl me-1"></i>
                    Tambah Transaksi
                </button>
            </div>
        </div>
    </div>
    <div class="bg-white/80 backdrop-blur-sm rounded-xl shadow-lg border border-gray-100 overflow-hidden mb-6">
        <div class="table-container">
            <table class="table">
                <thead>
                    <tr>
                        <th class="w-1 center">No</th>
                        <th>Nama Produk</th>
                        <th>Quantity</th>
                        <th>HNA</th>
                        <th>HNA PPN</th>
                        <th>Diskon</th>
                        <th>Total Diskon</th>
                        <th>Total</th>
                        <th class="w-1 center">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($details as $index => $detail)
                        <tr>
                            <td class="center">{{ $index + 1 }}</td>
                            <td>
                                <div wire:key="select-{{ rand() }}">
                                    <select style="width: 325px;" class="mt-1 form-control" x-data x-ref="input"
                                        x-init="$($refs.input).selectize({
                                            dropdownParent: 'body',
                                            allowClear: true,
                                            plugins: ['clear_button'],
                                            onChange: function(e) {
                                                @this.set('details.{{ $index }}.product_id', e ? e : null)
                                            }
                                        });"
                                        wire:model.live="details.{{ $index }}.product_id"
                                        id="details.{{ $index }}.product_id"
                                        {{ $purchase_requisition_id ? 'disabled' : '' }}>
                                        <option value="">-- Pilih Produk --</option>
                                        @foreach ($products as $key_product => $product)
                                            <option value="{{ $key_product }}">{{ $product }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                @error('details.' . $index . '.product_id')
                                    <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                                @enderror
                            </td>
                            <td>
                                <input type="text"
                                    onkeyup="convertToRupiah(this)"
                                    wire:model.live.debounce.300ms='details.{{ $index }}.quantity' class="form-control"
                                    placeholder="0" style="width: 175px;" />
                                @error('details.' . $index . '.quantity')
                                    <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                                @enderror
                            </td>
                            <td>
                                <div style="width: 175px;" class="mt-1 flex rounded-md shadow-sm">
                                    <span
                                        class="inline-flex items-center rounded-l-md border border-l-0 border-gray-300 bg-gray-100 px-3 text-gray-500 text-sm">Rp</span>
                                    <input type="text"
                                        onkeyup="convertToRupiah(this);"
                                        wire:model.live.debounce.300ms='details.{{ $index }}.hna'
                                        class="form-control rounded-l-none" placeholder="0" />
                                </div>
                            </td>
                            <td>
                                <div style="width: 175px;" class="mt-1 flex rounded-md shadow-sm">
                                    <span
                                        class="inline-flex items-center rounded-l-md border border-l-0 border-gray-300 bg-gray-100 px-3 text-gray-500 text-sm">Rp</span>
                                    <input type="text"
                                        onkeyup="convertToRupiah(this);"
                                        wire:model.live.debounce.300ms='details.{{ $index }}.hna_ppn'
                                        class="form-control rounded-l-none" placeholder="0" />
                                </div>
                            </td>
                            <td>
                                <div style="width: 175px;" class="mt-1 flex rounded-md shadow-sm">
                                    <select wire:model.live='details.{{ $index }}.discount_type'
                                        class="inline-flex items-center rounded-l-md border border-l-0 border-gray-300 bg-gray-100 px-3 text-gray-500 text-sm">
                                        <option value="rupiah">RP</option>
                                        <option value="percentage">%</option>
                                    </select>
                                    @if (($details[$index]['discount_type'] ?? 'percentage') == 'percentage')
                                        <input type="number"
                                            wire:model.live.debounce.300ms='details.{{ $index }}.discount_value'
                                            placeholder="0" class="form-control rounded-l-none" />
                                    @else
                                        <input type="text"
                                            onkeyup="convertToRupiah(this);"
                                            wire:model.live.debounce.300ms='details.{{ $index }}.discount_value'
                                            class="form-control rounded-l-none" placeholder="0" />
                                    @endif
                                </div>
                            </td>
                            <td>
                                <div style="width: 175px;" class="font-semibold text-gray-700">
                                    Rp {{ number_format(floatval(str_replace('.', '', $detail['discount'] ?? 0)), 0, ',', '.') }}
                                </div>
                            </td>
                            <td>
                                <div style="width: 175px;" class="font-bold text-blue-700">
                                    Rp {{ number_format(floatval(str_replace('.', '', $detail['total'] ?? 0)), 0, ',', '.') }}
                                </div>
                            </td>
                            <td class="center">
                                <button
                                    class="btn btn-icon text-red-600 hover:text-red-800 transition-colors delete-btn"
                                    wire:click="confirmDelete('{{ $index }}')">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none"
                                        viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                    </svg>
                                </button>
                            </td>
                        </tr>
                        {{-- Expired Date Section --}}
                        <tr class="bg-gray-50">
                            <td colspan="9" class="p-4">
                                <div class="border-l-4 border-blue-500 pl-4">
                                    <div class="flex items-center justify-between mb-3">
                                        <h4 class="font-semibold text-gray-700 flex items-center gap-2">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-blue-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                            </svg>
                                            Expired Date Management
                                        </h4>
                                        <button type="button" wire:click="addExpiredDate({{ $index }})"
                                                class="btn btn-sm btn-primary">
                                            <i class="fa-solid fa-plus mr-1"></i> Tambah Expired Date
                                        </button>
                                    </div>

                                    @if (isset($detail['expired_dates']) && count($detail['expired_dates']) > 0)
                                        {{-- Summary Badge --}}
                                        @php
                                            $productQty = $detail['quantity'] ? intval(Str::replace('.', '', $detail['quantity'])) : 0;
                                            $totalExpiredQty = 0;
                                            foreach ($detail['expired_dates'] as $exp) {
                                                $totalExpiredQty += isset($exp['stok']) && $exp['stok'] ? intval(Str::replace('.', '', $exp['stok'])) : 0;
                                            }
                                            $isValid = $totalExpiredQty <= $productQty;
                                            $badgeClass = $isValid ? 'bg-green-100 text-green-800 border-green-300' : 'bg-red-100 text-red-800 border-red-300';
                                        @endphp
                                        <div class="mb-3 p-2 border rounded {{ $badgeClass }}">
                                            <div class="flex items-center justify-between text-sm">
                                                <span class="font-medium">
                                                    @if ($isValid)
                                                        <i class="fa-solid fa-check-circle mr-1"></i> Valid
                                                    @else
                                                        <i class="fa-solid fa-exclamation-triangle mr-1"></i> Melebihi Kuantitas!
                                                    @endif
                                                </span>
                                                <span>
                                                    Total: <strong>{{ number_format($totalExpiredQty, 0, ',', '.') }}</strong> /
                                                    {{ number_format($productQty, 0, ',', '.') }}
                                                </span>
                                            </div>
                                        </div>

                                        {{-- Expired Dates Table --}}
                                        <div class="overflow-x-auto">
                                            <table class="min-w-full divide-y divide-gray-200 text-sm">
                                                <thead class="bg-gray-100">
                                                    <tr>
                                                        <th class="px-3 py-2 text-left text-xs font-medium text-gray-700">No</th>
                                                        <th class="px-3 py-2 text-left text-xs font-medium text-gray-700">Batch Number</th>
                                                        <th class="px-3 py-2 text-left text-xs font-medium text-gray-700">Expired Date</th>
                                                        <th class="px-3 py-2 text-left text-xs font-medium text-gray-700">Quantity</th>
                                                        <th class="px-3 py-2 text-center text-xs font-medium text-gray-700">Aksi</th>
                                                    </tr>
                                                </thead>
                                                <tbody class="bg-white divide-y divide-gray-200">
                                                    @foreach ($detail['expired_dates'] as $expIndex => $expiredDate)
                                                        <tr class="hover:bg-gray-50">
                                                            <td class="px-3 py-2">{{ $expIndex + 1 }}</td>
                                                            <td class="px-3 py-2">
                                                                <input type="text"
                                                                       wire:model.lazy="details.{{ $index }}.expired_dates.{{ $expIndex }}.batch_number"
                                                                       class="form-control form-control-sm"
                                                                       placeholder="BATCH001"
                                                                       style="width: 150px;">
                                                            </td>
                                                            <td class="px-3 py-2">
                                                                <input type="date"
                                                                       wire:model.lazy="details.{{ $index }}.expired_dates.{{ $expIndex }}.expired_date"
                                                                       class="form-control form-control-sm"
                                                                       style="width: 180px;">
                                                            </td>
                                                            <td class="px-3 py-2">
                                                                <input type="text"
                                                                       wire:model.lazy="details.{{ $index }}.expired_dates.{{ $expIndex }}.stok"
                                                                       onkeyup="convertToRupiah(this)"
                                                                       class="form-control form-control-sm"
                                                                       placeholder="0"
                                                                       style="width: 120px;">
                                                            </td>
                                                            <td class="px-3 py-2 text-center">
                                                                <button type="button"
                                                                        wire:click="removeExpiredDate({{ $index }}, {{ $expIndex }})"
                                                                        class="btn btn-sm btn-icon text-red-600 hover:text-red-800">
                                                                    <i class="fa-solid fa-trash"></i>
                                                                </button>
                                                            </td>
                                                        </tr>
                                                    @endforeach
                                                </tbody>
                                            </table>
                                        </div>
                                    @else
                                        <div class="text-center py-4 text-gray-500">
                                            <i class="fa-solid fa-inbox text-3xl mb-2"></i>
                                            <p>Belum ada expired date. Klik tombol "Tambah Expired Date" untuk menambahkan.</p>
                                        </div>
                                    @endif
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center">Tidak ada data paket.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
