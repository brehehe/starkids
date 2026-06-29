<div>
    <div class="mb-4">
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-2xl font-bold text-[#1E3A8A]">Mutasi Stok Detail</h1>
            </div>
            @if (!$data_id)
                <div>
                    <button wire:click="confirmSave()" class="btn btn-primary">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                        </svg>
                        Simpan Mutasi Stok Detail
                    </button>
                </div>
            @endif
        </div>
    </div>
    <div class="p-6 bg-white shadow rounded-lg mb-4">
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
            <div>
                <label for="code" class="block text-sm font-medium text-gray-700">Kode <span
                        class="text-red-600">*</span></label>
                <input type="text" class="mt-1 form-control" wire:model.live='code' id="code"
                    placeholder="Masukkan Kode" autocomplete="false" {{ $data_id ? 'disabled' : '' }}>
                @error('code')
                    <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                @enderror
            </div>
            <div>
                <label for="name" class="block text-sm font-medium text-gray-700">Judul <span
                        class="text-red-600">*</span></label>
                <input type="text" class="mt-1 form-control" wire:model.live='name' id="name"
                    placeholder="Masukkan Judul" autocomplete="false" {{ $data_id ? 'disabled' : '' }}>
                @error('name')
                    <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                @enderror
            </div>
            <div>
                <label for="company_id" class="block text-sm font-medium text-gray-700">Perusahaan <span
                        class="text-red-600">*</span></label>
                @if ($data_id)
                    <div wire:key="select-{{ rand() }}">
                        <select class="mt-1 form-control" x-data x-ref="input" x-init="$($refs.input).selectize({
                            dropdownParent: 'body',
                            allowClear: true,
                            onChange: function(e) {
                                @this.set('company_id', e ? e : null);
                            }
                        });"
                            wire:model.lazy="company_id" id="company_id" {{ $data_id ? 'disabled' : '' }}>
                            <option value="">-- Pilih Perusahaan --</option>
                            @foreach ($companys as $key_company => $company)
                                <option value="{{ $key_company }}">{{ $company }}</option>
                            @endforeach
                        </select>
                    </div>
                @else
                    <div wire:key="select-{{ rand() }}">
                        <select class="mt-1 form-control" x-data x-ref="input" x-init="$($refs.input).selectize({
                            dropdownParent: 'body',
                            allowClear: true,
                            plugins: ['clear_button'],
                            onChange: function(e) {
                                @this.set('company_id', e ? e : null);
                            }
                        });"
                            wire:model.lazy="company_id" id="company_id" {{ $data_id ? 'disabled' : '' }}>
                            <option value="">-- Pilih Perusahaan --</option>
                            @foreach ($companys as $key_company => $company)
                                <option value="{{ $key_company }}">{{ $company }}</option>
                            @endforeach
                        </select>
                    </div>
                @endif
                @error('company_id')
                    <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                @enderror
            </div>
            <div class="md:col-span-3">
                <label for="description" class="block text-sm font-medium text-gray-700">Deskripsi</label>
                <textarea class="mt-1 form-control" wire:model.live='description' id="description" placeholder="Masukkan Deskripsi"
                    {{ $data_id ? 'disabled' : '' }}></textarea>
                @error('description')
                    <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                @enderror
            </div>
        </div>
    </div>
    <div class="mb-4">
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-2xl font-bold text-[#1E3A8A]">Mutasi Stock</h1>
            </div>
            @if (!$data_id)
                <div>
                    <button wire:click="addDetail()" class="btn btn-warning">
                        <!-- Font Awesome File Icon -->
                        <i class="fa-solid fa-circle-plus text-xl me-1"></i>
                        Tambah Mutasi Stock
                    </button>
                </div>
            @endif
        </div>
    </div>
    <div class="bg-white/80 backdrop-blur-sm rounded-xl shadow-lg border border-gray-100 overflow-hidden mb-6">
        <div class="table-container">
            <table class="table">
                <thead>
                    <tr>
                        <th class="w-1 center">No</th>
                        <th>Produk</th>
                        <th>Quantity Fisik</th>
                        <th>Quantity</th>
                        @if (!$data_id)
                            <th class="w-1 center">Aksi</th>
                        @endif
                    </tr>
                </thead>
                <tbody>
                    @forelse ($details as $key_detail => $detail)
                        <tr>
                            <td class="center">{{ $key_detail + 1 }}</td>
                            <td>
                                @if ($data_id)
                                    <div wire:key="select-{{ rand() }}">
                                        <select class="form-control" x-data x-ref="input" x-init="$($refs.input).selectize({
                                            dropdownParent: 'body',
                                            allowClear: true,
                                            onChange: function(e) {
                                                @this.set('details.{{ $key_detail }}.product_id', e ? e : null);
                                            }
                                        });"
                                            wire:model.lazy="details.{{ $key_detail }}.product_id" id="product_id"
                                            disabled>
                                            <option value="">-- Pilih Produk --</option>
                                            @foreach ($products as $key_product => $product)
                                                <option value="{{ $key_product }}">{{ $product }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    @error('details.' . $key_detail . '.product_id')
                                        <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                                    @enderror
                                @else
                                    <div wire:key="select-{{ rand() }}">
                                        <select class="form-control" x-data x-ref="input" x-init="$($refs.input).selectize({
                                            dropdownParent: 'body',
                                            allowClear: true,
                                            plugins: ['clear_button'],
                                            onChange: function(e) {
                                                @this.set('details.{{ $key_detail }}.product_id', e ? e : null);
                                            }
                                        });"
                                            wire:model.lazy="details.{{ $key_detail }}.product_id" id="product_id">
                                            <option value="">-- Pilih Produk --</option>
                                            @foreach ($products as $key_product => $product)
                                                <option value="{{ $key_product }}">{{ $product }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    @error('details.' . $key_detail . '.product_id')
                                        <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                                    @enderror
                                @endif
                            </td>
                            <td>
                                <input type="number" class="form-control" disabled
                                    value="{{ $detail['quantity_system'] ?? 0 }}"
                                    id="quantity_system_{{ $key_detail }}" placeholder="Masukkan Quantity Sistem">
                                @error('details.' . $key_detail . '.quantity_system')
                                    <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                                @enderror
                            </td>
                            <td>
                                <input type="number" class="form-control"
                                    wire:model.live='details.{{ $key_detail }}.quantity'
                                    id="quantity_{{ $key_detail }}" placeholder="Masukkan Quantity"
                                    autocomplete="false" {{ $data_id ? 'disabled' : '' }}>
                                @error('details.' . $key_detail . '.quantity')
                                    <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                                @enderror
                            </td>
                            @if (!$data_id)
                                <td class="center">
                                    <button wire:click="confirmDelet({{ $key_detail }})"
                                        class="btn btn-danger btn-sm">
                                        <i class="fa-solid fa-trash"></i>
                                    </button>
                                </td>
                            @endif
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="text-center text-gray-500">Tidak ada data mutasi stok.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
