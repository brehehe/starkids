<div>
    <div class="mb-4">
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-2xl font-bold text-[#1E3A8A]">History Konsultasi</h1>
            </div>
            <div>
                <button wire:click="clearFilters()" class="btn btn-primary">
                    <i class="fas fa-redo"></i> Reset Filter
                </button>
            </div>
        </div>
    </div>
    <div class="space-y-6 mb-6">
        <!-- SECTION 1: Informasi Umum Produk -->
        <div class="p-6 bg-white shadow rounded-lg">
            <div class="flex gap-4">
                <div class="flex-1">
                    <label class="block text-sm font-medium text-gray-700">Tgl Mulai</label>
                    <input type="date" class="mt-1 form-control w-full" wire:model.live='start_date'
                        placeholder="Pilih Tanggal">
                </div>
                <div class="flex-1">
                    <label class="block text-sm font-medium text-gray-700">Tgl Akhir</label>
                    <input type="date" class="mt-1 form-control w-full" wire:model.live='end_date'
                        placeholder="Pilih Tanggal">
                </div>
                <div class="flex-1">
                    <label class="block text-sm font-medium text-gray-700">Jam Mulai</label>
                    <input type="time" class="mt-1 form-control w-full" wire:model.live='start_time'
                        placeholder="Pilih Jam">
                </div>
                <div class="flex-1">
                    <label class="block text-sm font-medium text-gray-700">Jam Akhir</label>
                    <input type="time" class="mt-1 form-control w-full" wire:model.live='end_time'
                        placeholder="Pilih Jam">
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

    <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-6">
        <div class="bg-indigo-50 p-6 rounded-lg shadow-sm border border-indigo-100">
            <div class="text-sm font-bold text-indigo-600 uppercase tracking-wider">Total Transaksi</div>
            <div class="mt-2 text-3xl font-extrabold text-indigo-900">{{ $statusStats['total'] }}</div>
            <div class="mt-1 text-xs text-indigo-500 font-medium">Semua Data</div>
        </div>
        <div class="bg-yellow-50 p-6 rounded-lg shadow-sm border border-yellow-100">
            <div class="text-sm font-bold text-yellow-600 uppercase tracking-wider">Proses</div>
            <div class="mt-2 text-3xl font-extrabold text-yellow-900">{{ $statusStats['process'] }}</div>
            <div class="mt-1 text-xs text-yellow-500 font-medium">Sedang Berjalan</div>
        </div>
        <div class="bg-green-50 p-6 rounded-lg shadow-sm border border-green-100">
            <div class="text-sm font-bold text-green-600 uppercase tracking-wider">Berhasil</div>
            <div class="mt-2 text-3xl font-extrabold text-green-900">{{ $statusStats['completed'] }}</div>
            <div class="mt-1 text-xs text-green-500 font-medium">Selesai</div>
        </div>
        <div class="bg-red-50 p-6 rounded-lg shadow-sm border border-red-100">
            <div class="text-sm font-bold text-red-600 uppercase tracking-wider">Batal</div>
            <div class="mt-2 text-3xl font-extrabold text-red-900">{{ $statusStats['canceled'] }}</div>
            <div class="mt-1 text-xs text-red-500 font-medium">Dibatalkan</div>
        </div>
    </div>

    @if($peakHours && count($peakHours) > 0)
        <div class="mb-6 p-6 bg-white shadow rounded-lg">
            <h3 class="text-lg font-medium text-gray-900 mb-4">Statistik Kunjungan / Peak Hours</h3>
            <div class="flex space-x-4 overflow-x-auto pb-4 scrollbar-thin">
                @foreach($peakHours as $hour => $count)
                    <div class="flex-none w-48 bg-blue-50 rounded-lg p-4 text-center border border-blue-100">
                        <div class="text-sm font-medium text-gray-500">{{ $hour }} - {{ \Carbon\Carbon::parse($hour)->addHour()->format('H:00') }}</div>
                        <div class="mt-1 text-2xl font-semibold text-blue-600">{{ $count }}</div>
                        <div class="text-xs text-blue-400">Pasien</div>
                    </div>
                @endforeach
            </div>
        </div>
    @endif
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
    <div class="bg-white/80 backdrop-blur-sm rounded-xl shadow-lg border border-gray-100 overflow-x-auto scrollbar-thin mb-6">
        <div class="table-container overflow-x-auto scrollbar-thin">
            <table class="table">
                <thead>
                    <tr>
                        <th class="w-12 text-center">No</th>
                        <th class="whitespace-nowrap">Nomor Antrian</th>
                        <th class="whitespace-nowrap">Tgl Daftar</th>
                        <th class="whitespace-nowrap">Asuransi</th>
                        <th class="whitespace-nowrap">Pasien</th>
                        <th class="whitespace-nowrap">No. IHS</th>
                        <th class="whitespace-nowrap">Tgl Lahir</th>
                        <th class="whitespace-nowrap">Nomer HP</th>
                        <th class="whitespace-nowrap">Dokter</th>
                        <th class="whitespace-nowrap">Poli</th>
                        <th class="whitespace-nowrap">Status</th>
                        <th class="w-1 center">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($transactions as $index => $transaction)
                        <tr>
                            <td class="center">{{ $transactions->firstItem() + $index }}</td>
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
                                @if($transaction->patient?->patient?->OHPatient?->id_patient)
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-semibold bg-emerald-50 text-emerald-700 border border-emerald-200">
                                        {{ $transaction->patient->patient->OHPatient->id_patient }}
                                    </span>
                                @elseif($transaction->patient?->patient?->ihs_number)
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-semibold bg-emerald-50 text-emerald-700 border border-emerald-200">
                                        {{ $transaction->patient->patient->ihs_number }}
                                    </span>
                                @elseif($transaction->patient?->userDetail?->ihs_number)
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-semibold bg-emerald-50 text-emerald-700 border border-emerald-200">
                                        {{ $transaction->patient->userDetail->ihs_number }}
                                    </span>
                                @else
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-gray-50 text-gray-500 border border-gray-200">
                                        Belum Terhubung
                                    </span>
                                @endif
                            </td>
                            <td class="text-sm whitespace-nowrap">
                                {{ $transaction?->patient?->userDetail?->birth_date ? \Carbon\Carbon::parse($transaction->patient->userDetail->birth_date)->locale('id')->isoFormat('DD MMM YY') : '-' }}
                            </td>
                            <td class="text-sm whitespace-nowrap">{{ $transaction?->patient?->phone ?? '-' }}</td>
                            <td class="text-sm whitespace-nowrap">{{ $transaction?->doctor?->name ?? '-' }}</td>
                            <td class="text-sm whitespace-nowrap">{{ $transaction->location_name ?? '-' }}</td>
                            <td class="text-sm whitespace-nowrap">
                                @php
                                    $statusColors = [
                                        'waiting_consultation' => 'bg-gray-100 text-gray-800',
                                        'draft_consultation' => 'bg-gray-200 text-gray-900',
                                        'call_consultation' => 'bg-blue-100 text-blue-800',
                                        'confirmation_call' => 'bg-indigo-100 text-indigo-800',
                                        'consultation' => 'bg-green-100 text-green-800',
                                        'pharmacy' => 'bg-teal-100 text-teal-800',
                                        'call_pharmacy' => 'bg-cyan-100 text-cyan-800',
                                        'sale_pharmacy' => 'bg-purple-100 text-purple-800',
                                        'draft' => 'bg-gray-100 text-gray-800',
                                        'process' => 'bg-yellow-100 text-yellow-800',
                                        'take_medicine' => 'bg-orange-100 text-orange-800',
                                        'completed' => 'bg-green-200 text-green-900',
                                        'canceled' => 'bg-red-100 text-red-800',
                                    ];

                                    $label = [
                                        'waiting_consultation' => 'Menunggu Konsultasi',
                                        'draft_consultation' => 'Draft Konsultasi',
                                        'call_consultation' => 'Panggil Konsultasi',
                                        'confirmation_call' => 'Konfirmasi Panggilan',
                                        'consultation' => 'Konsultasi',
                                        'pharmacy' => 'Farmasi',
                                        'call_pharmacy' => 'Panggil Farmasi',
                                        'sale_pharmacy' => 'Penjualan Farmasi',
                                        'draft' => 'Draft',
                                        'process' => 'Proses',
                                        'take_medicine' => 'Ambil Obat',
                                        'completed' => 'Selesai',
                                        'canceled' => 'Dibatalkan',
                                    ];
                                @endphp

                                <span
                                    class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $statusColors[$transaction->status] ?? 'bg-gray-100 text-gray-800' }}">
                                    {{ $label[$transaction->status] ?? 'Selesai' }}
                                </span>
                            </td>
                            <td class="center">
                                <div class="flex items-center">
                                    @if ($transaction->status == 'canceled')
                                        <button
                                            class="btn btn-icon text-blue-600 hover:text-blue-800 transition-colors edit-btn"
                                            wire:click="confirmDetail('{{ $transaction->id }}')">
                                            <i class="fa-solid fa-eye"></i>
                                        </button>
                                    @else
                                        <button
                                            class="btn btn-icon text-blue-600 hover:text-blue-800 transition-colors edit-btn"
                                            wire:click="confirmDetail('{{ $transaction->id }}')">
                                            <i class="fa-solid fa-eye"></i>
                                        </button>
                                    @endif
                                    @if (in_array($transaction->status, [
                                            'waiting_consultation',
                                            'draft_consultation',
                                            'call_consultation',
                                            'confirmation_call',
                                        ]))
                                        <button
                                            class="btn btn-icon text-red-600 hover:text-red-800 transition-colors edit-btn"
                                            wire:click="confirmDelete('{{ $transaction->id }}')">
                                            <i class="fa-solid fa-trash"></i>
                                        </button>
                                    @endif
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="12" class="no-data">Tidak ada data
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
