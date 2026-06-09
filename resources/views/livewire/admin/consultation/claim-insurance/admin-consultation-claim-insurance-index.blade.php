<div>
    <div class="mb-4">
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-2xl font-bold text-[#1E3A8A]">Klaim Asuransi</h1>
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
                <div class="flex-1">
                    <label class="block text-sm font-medium text-gray-700">Pasien</label>
                    <select class="mt-1 form-control w-full" wire:model.live='patient_id'>
                        <option value="">Semua Pasien</option>
                        @foreach ($patients as $id => $name)
                            <option value="{{ $id }}">{{ $name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="flex-1">
                    <label class="block text-sm font-medium text-gray-700">Asuransi</label>
                    <select class="mt-1 form-control w-full" wire:model.live='insurance_id'>
                        <option value="">Semua Asuransi</option>
                        @foreach ($insurances as $id => $name)
                            <option value="{{ $id }}">{{ $name }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="flex-1">
                    <label class="block text-sm font-medium text-gray-700">Klaim</label>
                    <select class="mt-1 form-control w-full" wire:model.live='is_insurance_claim'>
                        <option value="">Semua Klaim</option>
                        <option value="false">Belum Klaim</option>
                        <option value="true">Sudah Klaim</option>
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
                        <th class="w-1 center">No</th>
                        <th>Nomor Antrian</th>
                        <th>Asuransi</th>
                        <th>Nomer Asuransi</th>
                        <th>Apakah Sudah Klaim?</th>
                        <th>Pasien</th>
                        <th>Dokter</th>
                        <th>Poli</th>
                        <th>Tanggal</th>
                        <th>Status</th>
                        <th class="w-1 center">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($transactions as $index => $transaction)
                        <tr>
                            <td class="center">{{ $transactions->firstItem() + $index }}</td>
                            <td>
                                <p>{{ $transaction->code_consultation ?? '-' }}</p>
                                <span class="text-xs text-gray-500">
                                    {{ $transaction?->controlDoctor?->start_time_get }}
                                    -
                                    {{ $transaction?->controlDoctor?->end_time_get }}
                                </span>
                            </td>
                            <td>{{ $transaction?->insurance?->name ?? '-' }}</td>
                            <td>{{ $transaction->insurance_number ?? '-' }}</td>
                            <td>
                                <span
                                    class="px-2 py-1 text-xs font-medium rounded-full {{ $transaction->is_insurance_claim ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                    {{ $transaction->is_insurance_claim ? 'Ya' : 'Belum' }}
                                </span>
                            </td>
                            <td>{{ $transaction->patient_name ?? '-' }}</td>
                            <td>{{ $transaction?->doctor?->name ?? '-' }}</td>
                            <td>{{ $transaction->location_name ?? '-' }}</td>
                            <td>
                                {{ $transaction->date ? \Carbon\Carbon::parse($transaction->date)->locale('id')->isoFormat('D MMMM Y') : '-' }}
                            </td>

                            <td>
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
                                    @if (!$transaction->is_insurance_claim)
                                        <button
                                            class="btn btn-icon text-green-600 hover:text-green-800 transition-colors edit-btn"
                                            wire:click="confirmInsuranceClaim('{{ $transaction->id }}')">
                                            <i class="fa-solid fa-check"></i>
                                        </button>
                                    @endif
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
