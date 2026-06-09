<div>
    <div class="mb-4">
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-2xl font-bold text-[#1E3A8A]">Monitor Pengajuan Cuti</h1>
            </div>
        </div>
    </div>

    <!-- Status Tabs -->
    <div class="mb-6 border-b border-gray-200">
        <ul class="flex flex-wrap -mb-px text-sm font-medium text-center text-gray-500">
            <li class="mr-2">
                <button wire:click="$set('filterStatus', 'all')" class="inline-flex p-4 border-b-2 rounded-t-lg group {{ $filterStatus === 'all' ? 'text-blue-600 border-blue-600 active' : 'border-transparent hover:text-gray-600 hover:border-gray-300' }}">Seluruh Data</button>
            </li>
            <li class="mr-2">
                <button wire:click="$set('filterStatus', 'pending')" class="inline-flex p-4 border-b-2 rounded-t-lg group {{ $filterStatus === 'pending' ? 'text-blue-600 border-blue-600 active' : 'border-transparent hover:text-gray-600 hover:border-gray-300' }}">Perlu Persetujuan (Pending)</button>
            </li>
            <li class="mr-2">
                <button wire:click="$set('filterStatus', 'approved')" class="inline-flex p-4 border-b-2 rounded-t-lg group {{ $filterStatus === 'approved' ? 'text-blue-600 border-blue-600 active' : 'border-transparent hover:text-gray-600 hover:border-gray-300' }}">Disetujui</button>
            </li>
            <li class="mr-2">
                <button wire:click="$set('filterStatus', 'rejected')" class="inline-flex p-4 border-b-2 rounded-t-lg group {{ $filterStatus === 'rejected' ? 'text-blue-600 border-blue-600 active' : 'border-transparent hover:text-gray-600 hover:border-gray-300' }}">Ditolak</button>
            </li>
        </ul>
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
            <input type="text" class="mt-1 form-control-search" placeholder="Cari Nama Pegawai..."
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
                        <th>Pegawai</th>
                        <th>Tipe</th>
                        <th>Mulai</th>
                        <th>Selesai</th>
                        <th>Alasan</th>
                        <th>Lampiran</th>
                        <th class="center">Status</th>
                        <th class="w-1 center">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($leaves as $index => $record)
                    <tr>
                        <td class="center">{{ $leaves->firstItem() + $index }}</td>
                        <td class="font-medium">{{ $record->user->name ?? '-' }}</td>
                        <td>{{ ucfirst($record->type) }}</td>
                        <td>{{ \Carbon\Carbon::parse($record->start_date)->format('d M Y') }}</td>
                        <td>{{ \Carbon\Carbon::parse($record->end_date)->format('d M Y') }}</td>
                        <td class="text-xs max-w-[200px] truncate" title="{{ $record->reason }}">{{ $record->reason }}</td>
                        <td class="center">
                            @if($record->attachment_path)
                            <a href="{{ Storage::url($record->attachment_path) }}" target="_blank" class="text-blue-600 hover:text-blue-800 transition-colors" title="Lihat Lampiran">
                                <i class="fas fa-file-alt"></i>
                            </a>
                            @else
                            -
                            @endif
                        </td>
                        <td class="center">
                            @php
                                $statusBadgeColors = [
                                    'pending' => 'bg-yellow-100 text-yellow-800 border border-yellow-200',
                                    'approved' => 'bg-green-100 text-green-800 border border-green-200',
                                    'rejected' => 'bg-red-100 text-red-800 border border-red-200',
                                ];
                            @endphp
                            <span class="px-3 py-1 rounded-full text-xs font-semibold {{ $statusBadgeColors[$record->status] ?? 'bg-gray-100 text-gray-800 border border-gray-200' }}">
                                {{ ucfirst($record->status) }}
                            </span>
                        </td>
                        <td class="center">
                            @if($record->status === 'pending')
                            <div class="flex items-center justify-center gap-1">
                                <button type="button" wire:click="approve('{{ $record->id }}')" onclick="confirm('Yakin ingin menyetujui?') || event.stopImmediatePropagation()" class="btn btn-icon text-green-600 hover:text-green-800 transition-colors" title="Setujui">
                                    <i class="fas fa-check-circle text-lg"></i>
                                </button>
                                <button type="button" wire:click="reject('{{ $record->id }}')" onclick="confirm('Yakin ingin menolak?') || event.stopImmediatePropagation()" class="btn btn-icon text-red-600 hover:text-red-800 transition-colors" title="Tolak">
                                    <i class="fas fa-times-circle text-lg"></i>
                                </button>
                            </div>
                            @else
                            -
                            @endif
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="9" class="no-data">Tidak ada data cuti.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        <div class="px-5 py-4 bg-gray-50/80 border-t border-gray-200">
            <div class="flex items-center justify-between">
                <div class="text-sm text-gray-700">
                    Menampilkan <span class="font-medium">{{ $leaves->firstItem() ?? 0 }}</span> sampai <span
                        class="font-medium">{{ $leaves->lastItem() ?? 0 }}</span> dari <span
                        class="font-medium">{{ $leaves->total() ?? 0 }}</span> hasil
                </div>
                <div>
                    <nav class="relative z-0 inline-flex rounded-md shadow-sm -space-x-px" aria-label="Pagination">
                        {{ $leaves->links('vendor.livewire.custom') }}
                    </nav>
                </div>
            </div>
        </div>
    </div>
</div>
