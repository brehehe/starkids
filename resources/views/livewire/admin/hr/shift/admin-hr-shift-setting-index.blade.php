<div>
    <div class="mb-4">
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-2xl font-bold text-[#1E3A8A]">Setting Shift Pegawai</h1>
                <p class="text-sm text-gray-500 mt-1">Atur jadwal shift kerja untuk setiap pegawai</p>
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
            <input type="text" class="mt-1 form-control-search" placeholder="Cari Nama / No. HP Pegawai..."
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
                        <th>Nama Pegawai</th>
                        <th>No. HP</th>
                        <th class="center">Shift Saat Ini</th>
                        <th class="center">Jam Kerja</th>
                        <th class="w-1 center">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($employees as $index => $employee)
                    <tr wire:key="emp-{{ $employee->id }}">
                        <td class="center">{{ $employees->firstItem() + $index }}</td>
                        <td>
                            <div class="flex items-center gap-2">
                                @if($employee->profile)
                                    <img src="{{ Storage::url($employee->profile) }}" class="w-8 h-8 rounded-full object-cover" alt="">
                                @else
                                    <div class="w-8 h-8 rounded-full bg-blue-100 text-blue-700 flex items-center justify-center text-xs font-bold">
                                        {{ strtoupper(substr($employee->name, 0, 2)) }}
                                    </div>
                                @endif
                                <span class="font-medium">{{ $employee->name }}</span>
                            </div>
                        </td>
                        <td class="text-gray-600">{{ $employee->phone ?? '-' }}</td>
                        <td class="center">
                            @if($employee->shift)
                                <span class="px-2 py-1 bg-blue-100 text-blue-800 rounded text-xs font-semibold">
                                    {{ $employee->shift->name }}
                                </span>
                            @else
                                <span class="px-2 py-1 bg-gray-100 text-gray-500 rounded text-xs">
                                    Belum diset
                                </span>
                            @endif
                        </td>
                        <td class="center text-sm text-gray-600">
                            @if($employee->shift)
                                {{ \Carbon\Carbon::createFromFormat('H:i:s', $employee->shift->start_time)->format('H:i') }}
                                &ndash;
                                {{ \Carbon\Carbon::createFromFormat('H:i:s', $employee->shift->end_time)->format('H:i') }}
                            @else
                                <span class="text-gray-400">-</span>
                            @endif
                        </td>
                        <td class="center">
                            <div class="flex items-center justify-center gap-2">
                                <button wire:click="openModal('{{ $employee->id }}')" class="btn-action btn-edit" title="Set Shift">
                                    <i class="fas fa-clock"></i>
                                </button>
                                @if($employee->shift)
                                    <button wire:click="clearShift('{{ $employee->id }}')" class="btn-action btn-delete" title="Hapus Shift">
                                        <i class="fas fa-times"></i>
                                    </button>
                                @endif
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="no-data">Belum ada data pegawai.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        <div class="px-5 py-4 bg-gray-50/80 border-t border-gray-200">
            <div class="flex items-center justify-between">
                <div class="text-sm text-gray-700">
                    Menampilkan <span class="font-medium">{{ $employees->firstItem() ?? 0 }}</span> sampai <span
                        class="font-medium">{{ $employees->lastItem() ?? 0 }}</span> dari <span
                        class="font-medium">{{ $employees->total() ?? 0 }}</span> pegawai
                </div>
                <div>
                    <nav class="relative z-0 inline-flex rounded-md shadow-sm -space-x-px" aria-label="Pagination">
                        {{ $employees->links('vendor.livewire.custom') }}
                    </nav>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Assign Shift -->
    <div wire:ignore.self id="modal-shift-setting"
        class="fixed inset-0 bg-overlay hidden items-center justify-center z-50 transition-opacity duration-300 ease-in-out">
        <div class="bg-white rounded-2xl shadow-2xl w-full transform transition-all scale-95 duration-300 ease-out animate-fade-in"
            style="max-width: 460px;">
            <!-- Header -->
            <div class="flex justify-between items-center p-6 border-b">
                <div class="flex items-center gap-2">
                    <i class="fa-solid fa-user-clock text-blue-500 text-xl"></i>
                    <h2 class="text-xl font-semibold text-gray-800">Set Shift Pegawai</h2>
                </div>
                <button wire:click="closeModal()"
                    class="text-gray-500 hover:text-red-500 transition-colors text-2xl leading-none cursor-pointer">
                    &times;
                </button>
            </div>

            <!-- Body -->
            <div class="px-6 py-5 text-gray-600">
                <div class="mb-4 p-3 bg-blue-50 rounded-lg border border-blue-100">
                    <p class="text-sm text-blue-700 font-medium">Pegawai: <span class="text-blue-900">{{ $employee_name }}</span></p>
                </div>

                <div>
                    <label for="shift_id" class="block text-sm font-medium text-gray-700 mb-1">Pilih Shift</label>
                    <select id="shift_id" wire:model.defer="shift_id" class="mt-1 form-control">
                        <option value="">-- Tidak Ada Shift --</option>
                        @foreach($shifts as $shift)
                            <option value="{{ $shift->id }}">
                                {{ $shift->name }}
                                ({{ \Carbon\Carbon::createFromFormat('H:i:s', $shift->start_time)->format('H:i') }}
                                &ndash;
                                {{ \Carbon\Carbon::createFromFormat('H:i:s', $shift->end_time)->format('H:i') }})
                            </option>
                        @endforeach
                    </select>
                    @error('shift_id') <p class="text-sm text-red-600 mt-1">{{ $message }}</p> @enderror
                    <p class="text-xs text-gray-400 mt-1">Pilih "Tidak Ada Shift" untuk mengosongkan shift pegawai ini.</p>
                </div>
            </div>

            <!-- Footer -->
            <div class="flex justify-end gap-2 px-6 py-4 border-t">
                <button wire:click="closeModal()" class="px-4 py-2 bg-gray-200 hover:bg-gray-300 text-gray-800 rounded-lg shadow transition cursor-pointer">
                    Batal
                </button>
                <button wire:click="save()" class="px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-lg shadow transition cursor-pointer" wire:loading.attr="disabled">
                    <span wire:loading.remove wire:target="save">Simpan</span>
                    <span wire:loading wire:target="save">Menyimpan...</span>
                </button>
            </div>
        </div>
    </div>
</div>
