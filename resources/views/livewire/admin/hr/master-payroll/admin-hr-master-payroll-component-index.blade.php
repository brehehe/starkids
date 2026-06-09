<div>
    <div class="mb-4">
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-2xl font-bold text-[#1E3A8A]">Komponen Gaji (Tipe)</h1>
            </div>
            <div>
                <button wire:click="openModal()" class="btn btn-primary">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                    </svg>
                    Tambah Komponen
                </button>
            </div>
        </div>
    </div>

    <!-- Table Controls -->
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
            <input type="text" class="mt-1 form-control-search" placeholder="Cari Nama Komponen..."
                wire:model.live.debounce.300ms='search'>
            <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                <i class="fas fa-search h-3 w-3 text-gray-400"></i>
            </div>
        </div>
    </div>

    <!-- Table Section -->
    <div class="bg-white/80 backdrop-blur-sm rounded-xl shadow-lg border border-gray-100 overflow-hidden mb-6">
        <div class="table-container">
            <table class="table">
                <thead>
                    <tr>
                        <th class="w-1 center">No</th>
                        <th>Nama Komponen</th>
                        <th class="center">Tipe</th>
                        <th class="center">Kena Pajak</th>
                        <th class="text-right">Nominal Default</th>
                        <th class="center">Status</th>
                        <th class="w-1 center">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($components as $index => $record)
                    <tr>
                        <td class="center">{{ $components->firstItem() + $index }}</td>
                        <td class="font-medium">{{ $record->name }}</td>
                        <td class="center">
                            @if($record->type == 'allowance')
                                <span class="px-2 py-1 bg-green-100 text-green-800 rounded text-xs font-semibold">Tunjangan</span>
                            @else
                                <span class="px-2 py-1 bg-red-100 text-red-800 rounded text-xs font-semibold">Potongan</span>
                            @endif
                        </td>
                        <td class="center">
                            @if($record->is_taxable)
                                <span class="text-blue-600"><i class="fas fa-check-circle"></i> Ya</span>
                            @else
                                <span class="text-gray-400"><i class="fas fa-times-circle"></i> Tidak</span>
                            @endif
                        </td>
                        <td class="text-right font-medium text-gray-700">Rp {{ number_format($record->default_amount, 0, ',', '.') }}</td>
                        <td class="center">
                            @if($record->is_active)
                                <span class="px-2 py-1 bg-blue-100 text-blue-800 rounded text-xs">Aktif</span>
                            @else
                                <span class="px-2 py-1 bg-gray-100 text-gray-800 rounded text-xs">Inaktif</span>
                            @endif
                        </td>
                        <td class="center">
                            <div class="flex items-center justify-center gap-2">
                                <button wire:click="edit('{{ $record->id }}')" class="btn-action btn-edit" title="Edit Komponen">
                                    <i class="fas fa-edit"></i>
                                </button>
                                <button wire:click="confirmDelete('{{ $record->id }}')" class="btn-action btn-delete" title="Hapus Komponen">
                                    <i class="fas fa-trash-alt"></i>
                                </button>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="no-data">Belum ada data komponen gaji.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        <div class="px-5 py-4 bg-gray-50/80 border-t border-gray-200">
            <div class="flex items-center justify-between">
                <div class="text-sm text-gray-700">
                    Menampilkan <span class="font-medium">{{ $components->firstItem() ?? 0 }}</span> sampai <span
                        class="font-medium">{{ $components->lastItem() ?? 0 }}</span> dari <span
                        class="font-medium">{{ $components->total() ?? 0 }}</span> komponen
                </div>
                <div>
                    <nav class="relative z-0 inline-flex rounded-md shadow-sm -space-x-px" aria-label="Pagination">
                        {{ $components->links('vendor.livewire.custom') }}
                    </nav>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Form -->
    <div wire:ignore.self id="modal-component"
        class="fixed inset-0 bg-overlay hidden items-center justify-center z-50 transition-opacity duration-300 ease-in-out">
        <div class="bg-white rounded-2xl shadow-2xl w-full transform transition-all scale-95 duration-300 ease-out animate-fade-in"
            style="max-width: 500px;">
            <!-- Header -->
            <div class="flex justify-between items-center p-6 border-b">
                <div class="flex items-center gap-2">
                    <svg class="w-6 h-6 text-blue-500" fill="none" stroke="currentColor" stroke-width="2"
                        viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                    </svg>
                    <h2 class="text-xl font-semibold text-gray-800">{{ $data_id ? 'Edit' : 'Tambah' }} Komponen Gaji</h2>
                </div>
                <button wire:click="closeModal()"
                    class="text-gray-500 hover:text-red-500 transition-colors text-2xl leading-none cursor-pointer">
                    &times;
                </button>
            </div>

            <!-- Body -->
            <div class="px-6 py-4 text-gray-600 overflow-auto" style="max-height: 500px;">
                <div class="grid grid-cols-1 gap-4 mb-4">
                    <div class="mb-4">
                        <label for="name" class="block text-sm font-medium text-gray-700">Nama Komponen <span class="text-red-600">*</span></label>
                        <input id="name" type="text" wire:model.defer="name" placeholder="Contoh: Tunjangan Makan" class="mt-1 form-control">
                        @error('name') <p class="text-sm text-red-600 mt-1">{{ $message }}</p> @enderror
                    </div>

                    <div class="mb-4">
                        <label for="type" class="block text-sm font-medium text-gray-700">Tipe <span class="text-red-600">*</span></label>
                        <select id="type" wire:model.defer="type" class="mt-1 form-control">
                            <option value="allowance">Tunjangan (+)</option>
                            <option value="deduction">Potongan (-)</option>
                        </select>
                        @error('type') <p class="text-sm text-red-600 mt-1">{{ $message }}</p> @enderror
                    </div>

                    <div class="mb-4">
                        <label for="default_amount" class="block text-sm font-medium text-gray-700">Nilai Default (Rp)</label>
                        <input id="default_amount" type="number" wire:model.defer="default_amount" placeholder="0" class="mt-1 form-control">
                        <p class="text-xs text-gray-500 mt-1">Isi 0 jika nominal bervariasi tiap pegawai.</p>
                        @error('default_amount') <p class="text-sm text-red-600 mt-1">{{ $message }}</p> @enderror
                    </div>

                    <div class="flex items-center gap-6 mt-2">
                        <div class="flex items-center">
                            <input wire:model.defer="is_taxable" type="checkbox" id="is_taxable" class="h-4 w-4 text-blue-600 border-gray-300 rounded focus:ring-blue-500 focus:border-blue-500">
                            <label for="is_taxable" class="ml-2 block text-sm text-gray-700 cursor-pointer">Kena Pajak</label>
                        </div>
                        <div class="flex items-center">
                            <input wire:model.defer="is_active" type="checkbox" id="is_active" class="h-4 w-4 text-blue-600 border-gray-300 rounded focus:ring-blue-500 focus:border-blue-500">
                            <label for="is_active" class="ml-2 block text-sm text-gray-700 cursor-pointer">Aktif</label>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Footer -->
            <div class="flex justify-end gap-2 px-6 py-4 border-t">
                <button wire:click="closeModal()" class="px-4 py-2 bg-gray-200 hover:bg-gray-300 text-gray-800 rounded-lg shadow transition cursor-pointer">
                    Batal
                </button>
                <button wire:click="save()" class="px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-lg shadow transition cursor-pointer" wire:loading.attr="disabled">
                    <span wire:loading.remove wire:target="save">Simpan Data</span>
                    <span wire:loading wire:target="save">Menyimpan...</span>
                </button>
            </div>
        </div>
    </div>
</div>
