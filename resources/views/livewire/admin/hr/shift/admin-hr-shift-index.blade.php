<div>
    <div class="mb-4">
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-2xl font-bold text-[#1E3A8A]">Master Shift Kerja</h1>
            </div>
            <div>
                <button wire:click="openModal()" class="btn btn-primary">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                    </svg>
                    Tambah Shift
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
            </select>
            <span class="text-sm text-gray-700 ml-2">data</span>
        </div>

        <div class="relative w-full sm:w-64">
            <input type="text" class="mt-1 form-control-search" placeholder="Cari Nama Shift..."
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
                        <th>Nama Shift</th>
                        <th class="center">Jam Masuk</th>
                        <th class="center">Jam Keluar</th>
                        <th class="center">Status</th>
                        <th class="w-1 center">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($shifts as $index => $shift)
                    <tr wire:key="shift-{{ $shift->id }}">
                        <td class="center">{{ $shifts->firstItem() + $index }}</td>
                        <td class="font-medium">{{ $shift->name }}</td>
                        <td class="center">{{ \Carbon\Carbon::createFromFormat('H:i:s', $shift->start_time)->format('H:i') }}</td>
                        <td class="center">{{ \Carbon\Carbon::createFromFormat('H:i:s', $shift->end_time)->format('H:i') }}</td>
                        <td class="center">
                            @if($shift->is_active)
                                <span class="px-2 py-1 bg-blue-100 text-blue-800 rounded text-xs">Aktif</span>
                            @else
                                <span class="px-2 py-1 bg-gray-100 text-gray-800 rounded text-xs">Inaktif</span>
                            @endif
                        </td>
                        <td class="center">
                            <div class="flex items-center justify-center gap-2">
                                <button wire:click="edit('{{ $shift->id }}')" class="btn-action btn-edit" title="Edit Shift">
                                    <i class="fas fa-edit"></i>
                                </button>
                                <button wire:click="confirmDelete('{{ $shift->id }}')" class="btn-action btn-delete" title="Hapus Shift">
                                    <i class="fas fa-trash-alt"></i>
                                </button>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="no-data">Belum ada data shift kerja.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        <div class="px-5 py-4 bg-gray-50/80 border-t border-gray-200">
            <div class="flex items-center justify-between">
                <div class="text-sm text-gray-700">
                    Menampilkan <span class="font-medium">{{ $shifts->firstItem() ?? 0 }}</span> sampai <span
                        class="font-medium">{{ $shifts->lastItem() ?? 0 }}</span> dari <span
                        class="font-medium">{{ $shifts->total() ?? 0 }}</span> shift
                </div>
                <div>
                    <nav class="relative z-0 inline-flex rounded-md shadow-sm -space-x-px" aria-label="Pagination">
                        {{ $shifts->links('vendor.livewire.custom') }}
                    </nav>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Form -->
    <div wire:ignore.self id="modal-shift"
        class="fixed inset-0 bg-overlay hidden items-center justify-center z-50 transition-opacity duration-300 ease-in-out">
        <div class="bg-white rounded-2xl shadow-2xl w-full transform transition-all scale-95 duration-300 ease-out animate-fade-in"
            style="max-width: 500px;">
            <!-- Header -->
            <div class="flex justify-between items-center p-6 border-b">
                <div class="flex items-center gap-2">
                    <i class="fa-solid fa-clock text-blue-500 text-xl"></i>
                    <h2 class="text-xl font-semibold text-gray-800">{{ $data_id ? 'Edit' : 'Tambah' }} Shift Kerja</h2>
                </div>
                <button wire:click="closeModal()"
                    class="text-gray-500 hover:text-red-500 transition-colors text-2xl leading-none cursor-pointer">
                    &times;
                </button>
            </div>

            <!-- Body -->
            <div class="px-6 py-4 text-gray-600 overflow-auto" style="max-height: 500px;">
                <div class="grid grid-cols-1 gap-4">
                    <div>
                        <label for="name" class="block text-sm font-medium text-gray-700">Nama Shift <span class="text-red-600">*</span></label>
                        <input id="name" type="text" wire:model.defer="name" placeholder="Contoh: Shift Pagi" class="mt-1 form-control">
                        @error('name') <p class="text-sm text-red-600 mt-1">{{ $message }}</p> @enderror
                    </div>

                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label for="start_time" class="block text-sm font-medium text-gray-700">Jam Masuk <span class="text-red-600">*</span></label>
                            <input id="start_time" type="time" wire:model.defer="start_time" class="mt-1 form-control">
                            @error('start_time') <p class="text-sm text-red-600 mt-1">{{ $message }}</p> @enderror
                        </div>
                        <div>
                            <label for="end_time" class="block text-sm font-medium text-gray-700">Jam Keluar <span class="text-red-600">*</span></label>
                            <input id="end_time" type="time" wire:model.defer="end_time" class="mt-1 form-control">
                            @error('end_time') <p class="text-sm text-red-600 mt-1">{{ $message }}</p> @enderror
                        </div>
                    </div>

                    <div class="flex items-center mt-1">
                        <input wire:model.defer="is_active" type="checkbox" id="is_active" class="h-4 w-4 text-blue-600 border-gray-300 rounded focus:ring-blue-500">
                        <label for="is_active" class="ml-2 block text-sm text-gray-700 cursor-pointer">Shift Aktif</label>
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
