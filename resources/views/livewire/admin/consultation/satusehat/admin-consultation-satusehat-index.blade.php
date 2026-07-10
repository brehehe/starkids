<div>
    <div class="mb-4">
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-2xl font-bold text-[#1E3A8A]">SatuSehat Sync Manager</h1>
                <p class="text-sm text-gray-500">Sinkronisasi data Pasien dan Kunjungan Medis ke platform SatuSehat Kemenkes.</p>
            </div>
        </div>
    </div>

    <!-- Status Cards -->
    <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-6">
        <div class="p-4 bg-white/85 backdrop-blur-sm shadow-md rounded-xl border-l-4 border-yellow-500">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-xs font-semibold text-gray-500 uppercase">Antrian Pending</p>
                    <h3 class="text-2xl font-bold text-gray-800">{{ $stats['pending'] }}</h3>
                </div>
                <div class="p-2 bg-yellow-100 rounded-full text-yellow-600">
                    <i class="fa-solid fa-clock-rotate-left text-xl"></i>
                </div>
            </div>
        </div>
        <div class="p-4 bg-white/85 backdrop-blur-sm shadow-md rounded-xl border-l-4 border-blue-500">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-xs font-semibold text-gray-500 uppercase">Sedang Diproses</p>
                    <h3 class="text-2xl font-bold text-gray-800">{{ $stats['process'] }}</h3>
                </div>
                <div class="p-2 bg-blue-100 rounded-full text-blue-600">
                    <i class="fa-solid fa-spinner fa-spin text-xl"></i>
                </div>
            </div>
        </div>
        <div class="p-4 bg-white/85 backdrop-blur-sm shadow-md rounded-xl border-l-4 border-green-500">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-xs font-semibold text-gray-500 uppercase">Sukses Terkirim</p>
                    <h3 class="text-2xl font-bold text-gray-800">{{ $stats['success'] }}</h3>
                </div>
                <div class="p-2 bg-green-100 rounded-full text-green-600">
                    <i class="fa-solid fa-circle-check text-xl"></i>
                </div>
            </div>
        </div>
        <div class="p-4 bg-white/85 backdrop-blur-sm shadow-md rounded-xl border-l-4 border-red-500">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-xs font-semibold text-gray-500 uppercase">Gagal Terkirim</p>
                    <h3 class="text-2xl font-bold text-gray-800">{{ $stats['failed'] }}</h3>
                </div>
                <div class="p-2 bg-red-100 rounded-full text-red-600">
                    <i class="fa-solid fa-triangle-exclamation text-xl"></i>
                </div>
            </div>
        </div>
    </div>

    <!-- Navigation Tabs -->
    <div class="mb-6">
        <div class="border-b border-gray-200">
            <nav class="flex gap-6" aria-label="Tabs">
                <button wire:click="changeTab('patient')"
                    class="py-4 px-1 border-b-2 font-medium text-sm transition-all {{ $tab === 'patient' ? 'border-[#1E3A8A] text-[#1E3A8A]' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300' }}">
                    <i class="fa-solid fa-user mr-2"></i>Pasien Belum Sinkron
                </button>
                <button wire:click="changeTab('encounter')"
                    class="py-4 px-1 border-b-2 font-medium text-sm transition-all {{ $tab === 'encounter' ? 'border-[#1E3A8A] text-[#1E3A8A]' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300' }}">
                    <i class="fa-solid fa-file-medical mr-2"></i>Kunjungan Belum Sinkron
                </button>
                <button wire:click="changeTab('outbox')"
                    class="py-4 px-1 border-b-2 font-medium text-sm transition-all {{ $tab === 'outbox' ? 'border-[#1E3A8A] text-[#1E3A8A]' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300' }}">
                    <i class="fa-solid fa-list-check mr-2"></i>Log Antrian (Outbox)
                </button>
            </nav>
        </div>
    </div>

    <!-- Controls Area -->
    <div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-4 gap-4 bg-white/50 backdrop-blur-sm p-4 rounded-xl border border-gray-100 shadow-sm">
        <!-- Left Section: Page Size & Status Filters -->
        <div class="flex flex-wrap items-center gap-3 w-full md:w-auto">
            <div class="flex items-center">
                <span class="text-sm text-gray-700 mr-2">Tampil</span>
                <select class="form-control" style="width: auto;" wire:model.live='perPage'>
                    <option value="5">5</option>
                    <option value="10">10</option>
                    <option value="25">25</option>
                    <option value="50">50</option>
                    <option value="100">100</option>
                </select>
                <span class="text-sm text-gray-700 ml-2">data</span>
            </div>

            @if ($tab === 'outbox')
                <div class="w-full sm:w-48">
                    <select class="form-control w-full" wire:model.live="outboxStatus">
                        <option value="">Semua Status Antrian</option>
                        <option value="pending">Pending</option>
                        <option value="process">Proses</option>
                        <option value="success">Sukses</option>
                        <option value="failed">Gagal</option>
                    </select>
                </div>
            @endif
        </div>

        <!-- Right Section: Search & Actions -->
        <div class="flex flex-col sm:flex-row items-stretch sm:items-center gap-3 w-full md:w-auto">
            <div class="relative w-full sm:w-64">
                <input type="text" class="form-control-search pl-10 w-full" placeholder="Cari kata kunci..."
                    wire:model.live.debounce.300ms="search">
                <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                    <i class="fas fa-search h-3 w-3 text-gray-400"></i>
                </div>
            </div>

            <div class="flex gap-2 justify-end">
                @if ($tab === 'patient')
                    <button wire:click="queueAllUnsyncedPatients" class="btn btn-primary whitespace-nowrap">
                        <i class="fa-solid fa-cloud-arrow-up mr-2"></i> Sinkron Semua Pasien (Max 100)
                    </button>
                @elseif ($tab === 'encounter')
                    <button wire:click="queueAllUnsyncedEncounters" class="btn btn-primary whitespace-nowrap" title="Sinkronkan hanya kunjungan yang belum pernah sinkron">
                        <i class="fa-solid fa-cloud-arrow-up mr-2"></i> Sinkron Kunjungan Baru (Max 100)
                    </button>
                    <button wire:click="queueAllSyncableEncounters" class="btn btn-success text-white whitespace-nowrap" title="Sinkronkan/Update ulang semua data kunjungan dari pasien yang sudah tersinkron">
                        <i class="fa-solid fa-arrows-rotate mr-2"></i> Update Ulang Semua Kunjungan (Max 100)
                    </button>
                @elseif ($tab === 'outbox')
                    <button wire:click="retryFailedTasks" class="btn btn-warning text-white whitespace-nowrap">
                        <i class="fa-solid fa-arrows-rotate mr-2"></i> Coba Lagi Gagal
                    </button>
                    <button wire:click="clearFailedTasks" class="btn btn-danger whitespace-nowrap">
                        <i class="fa-solid fa-trash-can mr-2"></i> Hapus Gagal
                    </button>
                @endif
            </div>
        </div>
    </div>

    <!-- Table Section -->
    <div class="bg-white/80 backdrop-blur-sm rounded-xl shadow-lg border border-gray-100 overflow-hidden mb-6">
        <div class="table-container">
            <table class="table">
                <thead>
                    @if ($tab === 'patient')
                        <tr>
                            <th class="w-1 center">No</th>
                            <th>Nama Pasien</th>
                            <th>NIK</th>
                            <th>Jenis Kelamin</th>
                            <th>Tanggal Lahir</th>
                            <th class="center">Status</th>
                            <th class="w-1 center">Aksi</th>
                        </tr>
                    @elseif ($tab === 'encounter')
                        <tr>
                            <th class="w-1 center">No</th>
                            <th>Kode Transaksi</th>
                            <th>Nama Pasien</th>
                            <th>Dokter</th>
                            <th>Tanggal Kunjungan</th>
                            <th class="center">Status</th>
                            <th class="w-1 center">Aksi</th>
                        </tr>
                    @elseif ($tab === 'outbox')
                        <tr>
                            <th class="w-1 center">No</th>
                            <th>Service / Method</th>
                            <th class="center">Status</th>
                            <th class="center">Percobaan</th>
                            <th>Tanggal Antrian</th>

                            <th class="w-1 center">Aksi</th>
                        </tr>
                    @endif
                </thead>
                <tbody>
                    @forelse ($dataList as $index => $item)
                        @if ($tab === 'patient')
                            <tr>
                                <td class="center">{{ $dataList->firstItem() + $index }}</td>
                                <td class="font-medium text-gray-900">{{ $item->name }}</td>
                                <td>{{ $item->userDetail->identity_card ?? '-' }}</td>
                                <td>{{ $item->userDetail->administrative_gender === 'male' ? 'Laki-laki' : ($item->userDetail->administrative_gender === 'female' ? 'Perempuan' : '-') }}</td>
                                <td>{{ $item->userDetail->birth_date ? \Carbon\Carbon::parse($item->userDetail->birth_date)->locale('id')->isoFormat('D MMMM Y') : '-' }}</td>
                                <td class="center">
                                    @php
                                        $task = $outboxStatuses[$item->patient?->OHPatient?->id ?? ''] ?? null;
                                    @endphp
                                    @if (!$task)
                                        <span class="px-2 py-1 text-xs font-medium rounded-full bg-gray-100 text-gray-800">Belum Sync</span>
                                    @elseif ($task->status === 'pending')
                                        <span class="px-2 py-1 text-xs font-medium rounded-full bg-yellow-100 text-yellow-800" title="Menunggu antrian">Antrian Pending</span>
                                    @elseif ($task->status === 'process')
                                        <span class="px-2 py-1 text-xs font-medium rounded-full bg-blue-100 text-blue-800" title="Sedang diproses"><i class="fa-solid fa-spinner fa-spin mr-1"></i>Memproses</span>
                                    @elseif ($task->status === 'failed')
                                        <span class="px-2 py-1 text-xs font-medium rounded-full bg-red-100 text-red-800 cursor-pointer" title="{{ $this->formatResponseBody($task->response_body) }}">Gagal Sync</span>
                                    @else
                                        <span class="px-2 py-1 text-xs font-medium rounded-full bg-green-100 text-green-800">Sukses</span>
                                    @endif
                                </td>
                                <td class="center">
                                    @php
                                        $isQueueing = $task && in_array($task->status, ['pending', 'process']);
                                    @endphp
                                    <div class="flex items-center justify-center gap-2">
                                        <button wire:click="queuePatient('{{ $item->id }}')" 
                                                class="btn btn-icon text-blue-600 hover:text-blue-800 disabled:text-gray-300" 
                                                title="Sinkronkan Pasien"
                                                @if($isQueueing) disabled @endif>
                                            <i class="fa-solid fa-cloud-arrow-up text-lg"></i>
                                        </button>
                                        @if ($task)
                                            <button wire:click="editTask('{{ $task->id }}')" 
                                                    class="btn btn-icon text-yellow-600 hover:text-yellow-800" 
                                                    title="Lihat/Edit Payload Antrian">
                                                <i class="fa-solid fa-pen-to-square text-lg"></i>
                                            </button>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                        @elseif ($tab === 'encounter')
                            <tr>
                                <td class="center">{{ $dataList->firstItem() + $index }}</td>
                                <td class="font-medium text-gray-900">{{ $item->transaction->code ?? '-' }}</td>
                                <td>{{ $item->transaction->patient_name ?? '-' }}</td>
                                <td>{{ $item->transaction->doctor_name ?? '-' }}</td>
                                <td>{{ $item->transaction->date ? \Carbon\Carbon::parse($item->transaction->date)->locale('id')->isoFormat('D MMMM Y') : '-' }}</td>
                                <td class="center">
                                    @php
                                        $task = $outboxStatuses[$item->OHEncounter?->id ?? ''] ?? null;
                                        $hasRemoteId = $item->OHEncounter?->id_encounter !== null;
                                        $patientSynced = $item->transaction->patient?->patient?->OHPatient?->id_patient !== null;
                                    @endphp
                                    @if (!$patientSynced)
                                        <span class="px-2 py-1 text-xs font-medium rounded-full bg-red-50 text-red-700 border border-red-200" title="Pasien belum memiliki ID SatuSehat. Sinkronisasi akan mendaftarkan pasien secara otomatis terlebih dahulu.">Pasien Belum Sync</span>
                                    @elseif ($task)
                                        @if ($task->status === 'pending')
                                            <span class="px-2 py-1 text-xs font-medium rounded-full bg-yellow-100 text-yellow-800" title="Menunggu antrian">Antrian Pending</span>
                                        @elseif ($task->status === 'process')
                                            <span class="px-2 py-1 text-xs font-medium rounded-full bg-blue-100 text-blue-800" title="Sedang diproses"><i class="fa-solid fa-spinner fa-spin mr-1"></i>Memproses</span>
                                        @elseif ($task->status === 'failed')
                                            <span class="px-2 py-1 text-xs font-medium rounded-full bg-red-100 text-red-800 cursor-pointer" title="{{ $this->formatResponseBody($task->response_body) }}">Gagal Sync</span>
                                        @else
                                            <span class="px-2 py-1 text-xs font-medium rounded-full bg-green-100 text-green-800">Sukses</span>
                                        @endif
                                    @else
                                        @if ($hasRemoteId)
                                            <span class="px-2 py-1 text-xs font-medium rounded-full bg-green-100 text-green-800" title="ID: {{ $item->OHEncounter?->id_encounter }}">Sukses Sync</span>
                                        @else
                                            <span class="px-2 py-1 text-xs font-medium rounded-full bg-gray-100 text-gray-800">Belum Sync</span>
                                        @endif
                                    @endif
                                </td>
                                <td class="center">
                                    @php
                                        $isQueueing = $task && in_array($task->status, ['pending', 'process']);
                                    @endphp
                                    <div class="flex items-center justify-center gap-2">
                                        @if (!$patientSynced)
                                            <button wire:click="queueEncounter('{{ $item->id }}')" 
                                                    class="btn btn-icon text-blue-600 hover:text-blue-800 disabled:text-gray-300" 
                                                    title="Sinkronkan Pasien & Kunjungan"
                                                    @if($isQueueing) disabled @endif>
                                                <i class="fa-solid fa-cloud-arrow-up text-lg"></i>
                                            </button>
                                        @elseif ($hasRemoteId)
                                            <button wire:click="queueEncounter('{{ $item->id }}')" 
                                                    class="btn btn-icon text-green-600 hover:text-green-800 disabled:text-gray-300" 
                                                    title="Update Status / Sync Ulang Kunjungan"
                                                    @if($isQueueing) disabled @endif>
                                                <i class="fa-solid fa-arrows-rotate text-lg"></i>
                                            </button>
                                        @else
                                            <button wire:click="queueEncounter('{{ $item->id }}')" 
                                                    class="btn btn-icon text-blue-600 hover:text-blue-800 disabled:text-gray-300" 
                                                    title="Sinkronkan Kunjungan"
                                                    @if($isQueueing) disabled @endif>
                                                <i class="fa-solid fa-cloud-arrow-up text-lg"></i>
                                            </button>
                                        @endif
                                        @if ($task)
                                            <button wire:click="editTask('{{ $task->id }}')" 
                                                    class="btn btn-icon text-yellow-600 hover:text-yellow-800" 
                                                    title="Lihat/Edit Payload Antrian">
                                                <i class="fa-solid fa-pen-to-square text-lg"></i>
                                            </button>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                        @elseif ($tab === 'outbox')
                            <tr>
                                <td class="center">{{ $dataList->firstItem() + $index }}</td>
                                <td class="font-medium text-gray-900">
                                    <p class="text-sm font-semibold">{{ class_basename($item->service_class) }}</p>
                                    <span class="text-xs text-gray-500 font-normal">Method: {{ $item->service_method }}</span>
                                </td>
                                <td class="center">
                                    @if ($item->status === 'success')
                                        <span class="px-2 py-1 text-xs font-medium rounded-full bg-green-100 text-green-800">Sukses</span>
                                    @elseif ($item->status === 'failed')
                                        <span class="px-2 py-1 text-xs font-medium rounded-full bg-red-100 text-red-800">Gagal</span>
                                    @elseif ($item->status === 'process')
                                        <span class="px-2 py-1 text-xs font-medium rounded-full bg-blue-100 text-blue-800">Proses</span>
                                    @else
                                        <span class="px-2 py-1 text-xs font-medium rounded-full bg-yellow-100 text-yellow-800">Pending</span>
                                    @endif
                                </td>
                                <td class="center">{{ $item->execution }} / 3</td>
                                <td>{{ $item->created_at ? $item->created_at->locale('id')->isoFormat('D MMMM Y HH:mm:s') : '-' }}</td>

                                <td class="center">
                                    @if ($item->status === 'failed')
                                        <button wire:click="retryFailedTasks" class="btn btn-icon text-yellow-600 hover:text-yellow-800" title="Coba Lagi">
                                            <i class="fa-solid fa-arrows-rotate"></i>
                                        </button>
                                    @else
                                        <span class="text-gray-300">-</span>
                                    @endif
                                </td>
                            </tr>
                        @endif
                    @empty
                        <tr>
                            <td colspan="6" class="p-8 text-center text-gray-400">
                                <i class="fa-solid fa-inbox text-3xl mb-2 block"></i>
                                Tidak ada data yang ditemukan.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        @if ($dataList instanceof \Illuminate\Pagination\LengthAwarePaginator && $dataList->hasPages())
            <div class="px-5 py-4 bg-gray-50/80 border-t border-gray-200">
                <div class="flex items-center justify-between">
                    <div class="text-sm text-gray-700">
                        Menampilkan <span class="font-medium">{{ $dataList->firstItem() }}</span> sampai <span
                            class="font-medium">{{ $dataList->lastItem() }}</span> dari <span
                            class="font-medium">{{ $dataList->total() }}</span> hasil
                    </div>
                    <div>
                        <nav class="relative z-0 inline-flex rounded-md shadow-sm -space-x-px" aria-label="Pagination">
                            {{ $dataList->links('vendor.livewire.custom') }} <!-- Menampilkan pagination -->
                        </nav>
                    </div>
                </div>
            </div>
        @endif
    </div>
</div>
