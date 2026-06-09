<div>
    <div class="mb-4">
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-2xl font-bold text-[#1E3A8A]">Biaya Jasa</h1>
            </div>
        </div>
    </div>
    <div class="space-y-6 mb-6">
        <!-- SECTION 1: Informasi Umum Produk -->
        <div class="p-6 bg-white shadow rounded-lg">
            <div class="grid grid-cols-5 gap-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700">Tampil</label>
                    <select class="mt-1 form-control" wire:model.live='perPage'>
                        <option value="5">5</option>
                        <option value="10">10</option>
                        <option value="25">25</option>
                        <option value="50">50</option>
                        <option value="100">100</option>
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700">Dari Tanggal</label>
                    <input type="date" wire:model.live="start_date" placeholder="Contoh: Dari Tanggal"
                        class="mt-1 form-control" />
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700">Sampai Tanggal</label>
                    <input type="date" wire:model.live="end_date" placeholder="Contoh: Sampai Tanggal"
                        class="mt-1 form-control" />
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700">Jenis Resep</label>
                    <div wire:key="select-{{ rand() }}">

                        <select class="mt-1" x-data x-ref="input" x-init="$($refs.input).selectize({
                            dropdownParent: 'body',
                            allowClear: true,
                            plugins: ['clear_button'],
                            onChange: function(e) {
                                @this.set('medicine_type_id', e ? e : null);
                            }
                        });"
                            wire:model.live="medicine_type_id" id="medicine_type_id">
                            <option value="">-- Pilih Jenis Resep --</option>
                            @foreach ($medicine_types as $id => $name)
                                <option value="{{ $id }}">{{ $name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700">Pasien</label>
                    <div wire:key="select-{{ rand() }}">

                        <select class="mt-1" x-data x-ref="input" x-init="$($refs.input).selectize({
                            dropdownParent: 'body',
                            allowClear: true,
                            plugins: ['clear_button'],
                            onChange: function(e) {
                                @this.set('patient_id', e ? e : null);
                            }
                        });"
                            wire:model.live="patient_id" id="patient_id">
                            <option value="">-- Pilih Pasien --</option>
                            @foreach ($patients as $key_patient => $patient)
                                <option value="{{ $key_patient }}">{{ $patient }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="bg-white/80 backdrop-blur-sm rounded-xl shadow-lg border border-gray-100 overflow-hidden mb-6">
        <div class="table-container">
            <table class="table">
                <thead>
                    <tr>
                        <th class="w-1 center">No</th>
                        <th>Kode</th>
                        <th>Pasien</th>
                        <th>Jenis Resep</th>
                        <th>Biaya Jasa 1</th>
                        <th>Biaya Lainnya</th>
                        <th>Total Biaya</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($transactionRecipes as $index => $transactionRecipe)
                        <tr>
                            <td class="center">{{ $transactionRecipes->firstItem() + $index }}</td>
                            <td>{{ $transactionRecipe?->transaction?->code ?? '-' }}</td>
                            <td>{{ $transactionRecipe?->transaction?->patient?->name ?? ('Umum' ?? '-') }}</td>
                            <td>{{ $transactionRecipe?->medicineType?->name ?? '-' }}</td>
                            <td>Rp @number($transactionRecipe?->price_service_one)</td>
                            <td>Rp @number($transactionRecipe?->price_service_other)</td>
                            <td>Rp @number($transactionRecipe?->price_service_one + $transactionRecipe?->price_service_other)</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="no-data">Tidak ada data</td>
                        </tr>
                    @endforelse
                </tbody>
                <tfoot>
                    <tr>
                        <th colspan="4" class="font-medium" style="text-align: right; font-weight: bold;">Total</th>
                        <th>Rp @number($totalPriceOne)</th>
                        <th>Rp @number($totalPriceOther)</th>
                        <th>Rp @number($totalPrice)</th>
                    </tr>
                </tfoot>
            </table>
        </div>

        <!-- Pagination -->
        <div class="px-5 py-4 bg-gray-50/80 border-t border-gray-200">
            <div class="flex items-center justify-between">
                <div class="text-sm text-gray-700">
                    Menampilkan <span class="font-medium">{{ $transactionRecipes->firstItem() }}</span> sampai <span
                        class="font-medium">{{ $transactionRecipes->lastItem() }}</span> dari <span
                        class="font-medium">{{ $transactionRecipes->total() }}</span> hasil
                </div>
                <div>
                    <nav class="relative z-0 inline-flex rounded-md shadow-sm -space-x-px" aria-label="Pagination">
                        {{ $transactionRecipes->links('vendor.livewire.custom') }} <!-- Menampilkan pagination -->
                    </nav>
                </div>
            </div>
        </div>
    </div>
</div>
