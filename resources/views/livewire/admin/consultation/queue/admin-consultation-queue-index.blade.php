<div>
    @include('livewire.admin.consultation.consultation.admin-consultation-consultation-modal')
    <div class="mb-4">
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-2xl font-bold text-[#1E3A8A]">Antrian</h1>
            </div>
        </div>
    </div>
     <div class="space-y-6 mb-6">
        <!-- SECTION 1: Informasi Umum Produk -->
        <div class="p-6 bg-white shadow rounded-lg">
            <div class="flex gap-4">
                <div class="flex-1">
                    <label class="block text-sm font-medium text-gray-700">Tanggal Konsultasi</label>
                    <input type="date" class="mt-1 form-control w-full" wire:model.live='date'
                        placeholder="Pilih Tanggal">
                </div>
                <div class="flex-1">
                    <label class="block text-sm font-medium text-gray-700">Lokasi</label>
                    <select class="mt-1 form-control w-full" wire:model.live='location_id'>
                        <option value="">Semua Lokasi</option>
                        @foreach ($locations as $id => $name)
                            <option value="{{ $id }}">{{ $name }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
        </div>
    </div>
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
            <input type="text" class="mt-1 form-control-search" placeholder="Cari Sesuatu..."
                wire:model.live='search'>
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
                        <th class="w-12 text-center">No</th>
                        <th class="whitespace-nowrap">Nomor Antrian</th>
                        <th class="whitespace-nowrap">Tgl Daftar</th>
                        <th class="whitespace-nowrap">Asuransi</th>
                        <th class="whitespace-nowrap">Pasien</th>
                        <th class="whitespace-nowrap">Tgl Lahir</th>
                        <th class="whitespace-nowrap">Nomer HP</th>
                        <th class="whitespace-nowrap">Dokter</th>
                        <th class="whitespace-nowrap">Poli</th>
                        <th class="whitespace-nowrap">Status</th>
                        <th class="w-24 text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($transactions as $index => $transaction)
                        <tr>
                            <td class="text-center">{{ $transactions->firstItem() + $index }}</td>
                            <td>
                                <div class="flex flex-col">
                                    <span class="font-medium text-gray-900">{{ $transaction->code_consultation ?? '-' }}</span>
                                    <span class="text-xs text-gray-500 ml-1">
                                        {{ $transaction?->controlDoctor?->start_time_get }} - {{ $transaction?->controlDoctor?->end_time_get }}
                                    </span>
                                </div>
                            </td>
                            <td class="text-sm whitespace-nowrap">
                                {{ $transaction->created_at ? \Carbon\Carbon::parse($transaction->created_at)->locale('id')->isoFormat('DD MMMM YYYY HH:mm') : '-' }}
                            </td>
                            <td class="text-sm whitespace-nowrap">
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $transaction->is_insurance ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">{{$transaction->is_insurance ? 'Ya' : 'Tidak'}}</span>
                            </td>
                            <td class="font-medium text-gray-900 whitespace-nowrap">{{ $transaction->patient_name ?? '-' }}</td>
                            <td class="text-sm whitespace-nowrap">
                                {{ $transaction?->patient?->userDetail?->birth_date ? \Carbon\Carbon::parse($transaction->patient->userDetail->birth_date)->locale('id')->isoFormat('DD MMM YY') : '-' }}
                            </td>
                            <td class="text-sm whitespace-nowrap">{{ $transaction?->patient?->phone ?? '-' }}</td>
                            <td class="text-sm whitespace-nowrap">{{ $transaction?->doctor?->name ?? '-' }}</td>
                            <td class="text-sm whitespace-nowrap">{{ $transaction->location_name ?? '-' }}</td>
                            <td>
                                @if ($transaction->status == 'waiting_consultation')
                                    <span
                                        class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800">
                                        Menunggu Kedatangan Pasien
                                    </span>
                                @elseif ($transaction->status == 'call_consultation')
                                    <span
                                        class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                        Panggilan
                                    </span>
                                @elseif ($transaction->status == 'confirmation_call')
                                    <span
                                        class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                        Konfirmasi
                                    </span>
                                @elseif ($transaction->status == 'consultation')
                                    <span
                                        class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                        Konsultasi
                                    </span>
                                @else
                                    <span
                                        class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-gray-100 text-gray-800">
                                        Selesai
                                    </span>
                                @endif
                            </td>
                            <td class="center">
                                <div class="flex items-center">
                                    @if (!$transaction->transactionPhysicalExamination)
                                        <button
                                            class="btn btn-icon text-green-600 hover:text-green-800 transition-colors edit-btn"
                                            wire:click="createPhysicalExam('{{ $transaction->id }}')">
                                            <i class="fa-solid fa-file-medical"></i>
                                        </button>
                                    @endif
                                    @if ($transaction->status == 'waiting_consultation')
                                        <button
                                            class="btn btn-icon text-yellow-600 hover:text-yellow-800 transition-colors edit-btn"
                                            wire:click="confirmWaitingConfirmation('{{ $transaction->id }}')">
                                            <i class="fa-solid fa-user-check"></i>
                                        </button>
                                        {{-- <button class="btn btn-icon text-blue-600 hover:text-blue-800 transition-colors edit-btn" wire:click="konsultasi('{{ $transaction->id }}')">
                                            <i class="fa-solid fa-stethoscope"></i>
                                        </button> --}}
                                        <button
                                            class="btn btn-icon text-red-600 hover:text-red-800 transition-colors edit-btn"
                                            wire:click="confirmCancelled('{{ $transaction->id }}')">
                                            <i class="fa-solid fa-trash"></i>
                                        </button>
                                    @elseif ($transaction->status == 'call_consultation')
                                        <button
                                            class="btn btn-icon text-yellow-600 hover:text-yellow-800 transition-colors edit-btn"
                                            wire:click="confirmCall('{{ $transaction->id }}')">
                                            <i class="fa-solid fa-phone"></i>
                                        </button>
                                        {{-- <button class="btn btn-icon text-blue-600 hover:text-blue-800 transition-colors edit-btn" wire:click="konsultasi('{{ $transaction->id }}')">
                                            <i class="fa-solid fa-stethoscope"></i>
                                        </button> --}}
                                        <button
                                            class="btn btn-icon text-red-600 hover:text-red-800 transition-colors edit-btn"
                                            wire:click="confirmCancelled('{{ $transaction->id }}')">
                                            <i class="fa-solid fa-trash"></i>
                                        </button>
                                    @elseif ($transaction->status == 'confirmation_call')
                                        <button
                                            class="btn btn-icon text-green-600 hover:text-green-800 transition-colors edit-btn"
                                            wire:click="confirmConsultation('{{ $transaction->id }}')">
                                            <i class="fa-solid fa-stethoscope"></i>
                                        </button>
                                        <button
                                            class="btn btn-icon text-red-600 hover:text-red-800 transition-colors edit-btn"
                                            wire:click="confirmCancelled('{{ $transaction->id }}')">
                                            <i class="fa-solid fa-trash"></i>
                                        </button>
                                    @elseif ($transaction->status == 'consultation')
                                        <button
                                            class="btn btn-icon text-green-600 hover:text-green-800 transition-colors edit-btn"
                                            wire:click="confirmConsultation('{{ $transaction->id }}')">
                                            <i class="fa-solid fa-stethoscope"></i>
                                        </button>
                                        <button
                                            class="btn btn-icon text-red-600 hover:text-red-800 transition-colors edit-btn"
                                            wire:click="confirmCancelled('{{ $transaction->id }}')">
                                            <i class="fa-solid fa-trash"></i>
                                        </button>
                                    @else
                                        <button
                                            class="btn btn-icon text-blue-600 hover:text-blue-800 transition-colors edit-btn"
                                            wire:click="confirmDetail('{{ $transaction->id }}')">
                                            <i class="fa-solid fa-eye"></i>
                                        </button>
                                    @endif
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

        <!-- Pagination -->
        <div class="px-5 py-4 bg-gray-50/80 border-t border-gray-200">
            <div class="flex items-center justify-between">
                <div class="text-sm text-gray-700">
                    Menampilkan <span class="font-medium">{{ $transactions->firstItem() }}</span> sampai <span
                        class="font-medium">{{ $transactions->lastItem() }}</span> dari <span
                        class="font-medium">{{ $transactions->total() }}</span> hasil
                </div>
                <div>
                    <nav class="relative z-0 inline-flex rounded-md shadow-sm -space-x-px" aria-label="Pagination">
                        {{ $transactions->links('vendor.livewire.custom') }} <!-- Menampilkan pagination -->
                    </nav>
                </div>
            </div>
        </div>

    </div>
</div>
