<div>
    @include('livewire.admin.purchase.draft.mail-order.admin-purchase-draft-mail-order-modal')
    <div class="mb-4">
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-2xl font-bold text-[#1E3A8A]">Draft Surat Pesanan</h1>
            </div>
            <div>
                <button wire:click="openModal('modal')" class="btn btn-warning">
                    <!-- Font Awesome Shopping Bag Icon -->
                    <i class="fa-solid fa-bag-shopping text-xl me-1"></i>
                    Pilih Produk
                </button>

                <button wire:click="save()" class="btn btn-primary">
                    <!-- Font Awesome File Icon -->
                    <i class="fa-solid fa-file-lines text-xl me-1"></i>
                    Buat Surat Pesanan
                </button>
            </div>
        </div>
    </div>

    <div class="bg-white/80 backdrop-blur-sm rounded-xl p-5 shadow-lg border border-gray-100 mb-6">
        <div class="grid grid-cols-1 gap-4">
            <div>
                <label class="block text-sm font-medium text-gray-700">
                    Supplier <span class="text-red-600">*</span>
                </label>

                <div class="flex items-center gap-2">
                    <div class="flex-1" wire:key="select-{{ rand() }}">
                        <select class="mt-1 form-control" x-data x-ref="input" x-init="$($refs.input).selectize({
                            dropdownParent: 'body',
                            allowClear: true,
                            plugins: ['clear_button'],
                            onChange: function(e) {
                                @this.set('supplier_id', e ? e : null);
                            }
                        });"
                            wire:model.live="supplier_id" id="supplier_id">
                            <option value="">-- Pilih Supplier --</option>
                            @foreach ($suppliers as $supplier)
                                <option value="{{ $supplier['id'] }}">{{ $supplier['name'] }}</option>
                            @endforeach
                        </select>
                    </div>
                    <!-- Tombol Buka Modal Supplier -->
                    <button type="button" wire:click="openModalSupplier()"
                        class="mt-1 px-4 py-2 h-965 bg-green-500 text-white rounded hover:bg-green-600 flex items-center gap-2">
                        <i class="fa-solid fa-plus text-white text-lg"></i> <!-- Icon Plus dari Font Awesome -->
                    </button>
                </div>

                @error('supplier_id')
                    <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                @enderror
            </div>
        </div>
    </div>

    <div class="bg-white/80 backdrop-blur-sm rounded-xl shadow-lg border border-gray-100 overflow-hidden mb-6">
        <div class="table-container">
            <table class="table">
                <thead>
                    <tr>
                        <th>Produk</th>
                        <th>Min Request Order</th>
                        <th>Satuan Order</th>
                        <th>Quantity Order</th>
                        <th>Quantity Diterima</th>
                        <th class="w-1 center">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($purchaseRequisitionItems as $index => $purchaseRequisitionItem)
                        @php
                            $itemId = $purchaseRequisitionItem->id; // UUID
                        @endphp
                        <tr>
                            <td>{{ $purchaseRequisitionItem->product_name }}</td>
                            <td>
                                <div class="flex items-center gap-1">
                                    <span>@number($purchaseRequisitionItem->quantity)</span>
                                    <span
                                        class="text-gray-500 text-sm">/{{ $purchaseRequisitionItem->product->unit->name ?? '-' }}</span>
                                </div>
                            </td>
                            <td>
                                <div class="flex items-center gap-1">
                                    <div wire:key="select-{{ rand() }}">
                                        <select class="mt-1 form-control" x-data x-ref="input" x-init="$nextTick(() => {
                                            $($refs.input).selectize({
                                                dropdownParent: 'body',
                                                allowClear: true,
                                                {{-- plugins: ['clear_button'], --}}
                                                onChange: function(value) {
                                                    @this.set('selectedUnitIds.{{ $itemId }}', value || null);
                                                    @this.call('updateSelectedUnit', '{{ $itemId }}', value);
                                                }
                                            });
                                        })"
                                            id="unit_id_{{ $itemId }}" style="width: 250px;">
                                            <option value="">-- Pilih Satuan Terkecil --</option>
                                            @foreach ($purchaseRequisitionItem->product->productUnits as $productUnit)
                                                <option value="{{ $productUnit->id }}" @selected(($selectedUnitIds[$itemId] ?? '') == $productUnit->id)>
                                                    {{ $productUnit->unit->name ?? '-' }} -
                                                    {{ $productUnit->quantity }} /
                                                    {{ $productUnit->product->unit->name }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <button type="button"
                                        wire:click="openModalProductUnit('{{ $purchaseRequisitionItem->id }}')"
                                        class="mt-1 px-4 py-2 h-965 bg-yellow-500 text-white rounded hover:bg-yellow-600 flex items-center">
                                        <i class="fa-solid fa-plus text-white text-lg"></i>
                                    </button>
                                </div>
                            </td>
                            <td>
                                <div class="flex items-center gap-1">
                                    <span>@number($purchaseRequisitionItem->quantity_detail)</span>
                                    <span
                                        class="text-gray-500 text-sm">/{{ $purchaseRequisitionItem->productUnit->unit->name ?? '-' }}</span>
                                </div>
                            </td>
                            <td>
                                <div class="flex items-center gap-1">
                                    <span>@number($purchaseRequisitionItem->quantity_real)</span>
                                    <span
                                        class="text-gray-500 text-sm">/{{ $purchaseRequisitionItem->product->unit->name ?? '-' }}</span>
                                </div>
                            </td>
                            <td class="center">
                                <div class="flex items-center">
                                    <button
                                        class="btn btn-icon text-red-600 hover:text-red-800 transition-colors delete-btn"
                                        wire:click="confirmDelete('{{ $purchaseRequisitionItem->id }}')">
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
                            <td colspan="10" class="no-data">Tidak ada data
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
    {{-- <div wire:loading wire:target='openModal'>
        @include('layout.loading')
    </div> --}}
</div>
