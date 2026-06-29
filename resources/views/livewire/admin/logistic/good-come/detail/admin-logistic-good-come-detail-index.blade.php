<div>
    @include('livewire.admin.logistic.good-come.detail.admin-logistic-good-come-detail-modal')
    <div class="mb-4">
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-2xl font-bold text-[#1E3A8A]">Detail Penerimaan Barang</h1>
            </div>
            @if (!in_array($purchaseOrder->status, ['success', 'return']))
                <div>
                    <button class="btn btn-warning" wire:click="confirmSavePrice()">
                        <i class="fa-solid fa-circle-check mr-2"></i> Simpan Harga
                    </button>
                    <button class="btn btn-primary" wire:click="confirmSave()">
                        <i class="fa-solid fa-circle-check mr-2"></i> Akhiri Penerimaan Barang
                    </button>
                </div>
            @endif
        </div>
    </div>
    <div class="bg-white/80 backdrop-blur-sm rounded-xl p-5 shadow-lg border border-gray-100 mb-6">
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-2 gap-4">
            <div>
                <label class="block text-sm font-medium text-gray-700">Nomer SP <span
                        class="text-red-600">*</span></label>
                <input type="text" value="{{ $purchaseOrder->purchaseRequisition->number ?? '-' }}" disabled
                    class="mt-1 form-control" />
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700">Nomer PO <span
                        class="text-red-600">*</span></label>
                <input type="text" value="{{ $purchaseOrder->number ?? '-' }}" disabled class="mt-1 form-control" />
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700">Supplier <span
                        class="text-red-600">*</span></label>
                <input type="text" value="{{ $purchaseOrder->supplier->name ?? '-' }}" disabled
                    class="mt-1 form-control" />
            </div>
            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700">
                    Grand Total <span class="text-red-600">*</span>
                </label>
                <div class="mt-1 flex rounded-md shadow-sm">
                    <span
                        class="inline-flex items-center rounded-l-md border border-r-0 border-gray-300 bg-gray-100 px-3 text-gray-500 text-sm">
                        Rp
                    </span>
                    <input type="text" disabled value="@number($purchaseOrder->grand_total ?? 0)" class="form-control rounded-l-none"
                        placeholder="0" />
                </div>
            </div>
        </div>
    </div>
    <div class="bg-white/80 backdrop-blur-sm rounded-xl shadow-lg border border-gray-100 overflow-hidden mb-6">
        <div class="table-container">
            <table class="table">
                <thead>
                    <tr>
                        <th class="w-1 center" rowspan="2">No</th>
                        <th rowspan="2">Nama Produk</th>
                        <th rowspan="2">HNA</th>
                        <th rowspan="2">HNA PPN</th>
                        <th rowspan="2">Diskon</th>
                        <th rowspan="2">Total Diskon</th>
                        <th rowspan="2">Total</th>
                        <th colspan="3" class="center">Kuantitas</th>
                        <th rowspan="2" class="center">Status</th>
                        @if (!in_array($purchaseOrder->status, ['success', 'return']))
                            <th class="w-1 center" rowspan="2">Aksi</th>
                        @endif
                    </tr>
                    <tr>
                        <th class="center">Dipesan</th>
                        <th class="center">Diterima</th>
                        <th class="center">Satuan</th>
                    </tr>
                </thead>
                <tbody>
                    {{-- @php
                        $items = optional($purchaseOrder)->purchaseOrderItems
                            ? $purchaseOrder->purchaseOrderItems->sortBy('order')
                            : collect();
                    @endphp --}}
                    @forelse ($items as $index => $purchaseOrderItem)
                        <tr>
                            <td class="w-1 center">{{ $index + 1 }}</td>
                            <td style="width: 200px;">{{ $purchaseOrderItem['name_product'] }}</td>
                            <td>
                                <div style="width: 175px;" class="mt-1 flex rounded-md shadow-sm">
                                    <span
                                        class="inline-flex items-center rounded-l-md border border-l-0 border-gray-300 bg-gray-100 px-3 text-gray-500 text-sm">Rp</span>
                                    <input type="text" onkeyup="convertToRupiah(this);"
                                        wire:model.lazy='items.{{ $index }}.hna'
                                        {{ in_array($purchaseOrder->status, ['success', 'return']) ? 'disabled' : null }}
                                        class="form-control rounded-l-none" placeholder="0" />
                                </div>
                            </td>
                            <td>
                                <div style="width: 175px;" class="mt-1 flex rounded-md shadow-sm">
                                    <span
                                        class="inline-flex items-center rounded-l-md border border-l-0 border-gray-300 bg-gray-100 px-3 text-gray-500 text-sm">Rp</span>
                                    <input type="text" onkeyup="convertToRupiah(this);"
                                        wire:model.lazy='items.{{ $index }}.hna_ppn'
                                        {{ in_array($purchaseOrder->status, ['success', 'return']) ? 'disabled' : null }}
                                        class="form-control rounded-l-none" placeholder="0" />
                                </div>
                            </td>
                            <td>
                                <div style="width: 175px;" class="mt-1 flex rounded-md shadow-sm">
                                    <select wire:model.lazy='items.{{ $index }}.discount_type'
                                        class="inline-flex items-center rounded-l-md border border-l-0 border-gray-300 bg-gray-100 px-3 text-gray-500 text-sm">
                                        <option value="rupiah">RP</option>
                                        <option value="percentage">%</option>
                                    </select>
                                    @if ($items[$index]['discount_type'] == 'percentage')
                                        <input type="number"
                                            wire:model.lazy='items.{{ $index }}.discount_value' placeholder="0"
                                            class="form-control rounded-l-none"
                                            {{ in_array($purchaseOrder->status, ['success', 'return']) ? 'disabled' : null }} />
                                    @else
                                        <input type="text" onkeyup="convertToRupiah(this);"
                                            wire:model.lazy='items.{{ $index }}.discount_value'
                                            {{ in_array($purchaseOrder->status, ['success', 'return']) ? ' disabled' : null }}
                                            class="form-control rounded-l-none" placeholder="0" />
                                    @endif
                                </div>
                            </td>
                            <td>
                                <div style="width: 175px;" class="mt-1 flex rounded-md shadow-sm">
                                    <span
                                        class="inline-flex items-center rounded-l-md border border-l-0 border-gray-300 bg-gray-100 px-3 text-gray-500 text-sm">Rp</span>
                                    <input disabled type="text" onkeyup="convertToRupiah(this);"
                                        wire:model.lazy='items.{{ $index }}.discount'
                                        {{ in_array($purchaseOrder->status, ['success', 'return']) ? 'disabled' : null }}
                                        class="form-control rounded-l-none" placeholder="0" />
                                </div>
                            </td>
                            <td>
                                <div style="width: 175px;" class="mt-1 flex rounded-md shadow-sm">
                                    <span
                                        class="inline-flex items-center rounded-l-md border border-l-0 border-gray-300 bg-gray-100 px-3 text-gray-500 text-sm">Rp</span>
                                    <input disabled type="text" onkeyup="convertToRupiah(this);"
                                        wire:model.lazy='items.{{ $index }}.total'
                                        {{ in_array($purchaseOrder->status, ['success', 'return']) ? 'disabled' : null }}
                                        class="form-control rounded-l-none" placeholder="0" />
                                </div>
                            </td>
                            <td class="center">{{ $purchaseOrderItem['quantity'] }}</td>
                            <td class="center">{{ $purchaseOrderItem['quantity_accepted'] }}</td>
                            <td class="center">{{ $purchaseOrderItem['productUnit']['unit']['name'] }}</td>
                            <td class="center">
                                @if ($purchaseOrderItem['quantity_accepted'] == $purchaseOrderItem['quantity'])
                                    <span class="bg-green-500 text-white px-2 py-1 rounded-md text-sm">Selesai</span>
                                @elseif ($purchaseOrderItem['quantity_accepted'] != $purchaseOrderItem['quantity'])
                                    <span class="bg-yellow-500 text-white px-2 py-1 rounded-md text-sm">Sebagian</span>
                                @else
                                    <span class="bg-red-500 text-white px-2 py-1 rounded-md text-sm">Belum
                                        Selesai</span>
                                @endif
                            </td>
                            <td class="w-1 center">
                                @if (!in_array($purchaseOrder->status, ['success', 'return']))
                                    @if ($purchaseOrderItem['quantity_accepted'] < $purchaseOrderItem['quantity'])
                                        <button
                                            class="btn btn-icon text-yellow-600 hover:text-yellow-800 transition-colors edit-btn"
                                            wire:click="detail('{{ $purchaseOrderItem['id'] }}')"
                                            aria-label="Lihat Detail">
                                            <i class="fa-regular fa-memo-circle-info text-yellow-600 text-lg"></i>
                                            <!-- FontAwesome Eye Icon -->
                                        </button>
                                    @endif
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" class="center no-data">Tidak ada data</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
