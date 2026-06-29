<div>
    <div class="mb-4">
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-2xl font-bold text-[#1E3A8A]">Laporan Kunjungan Pasien per Dokter</h1>
            </div>
        </div>
    </div>

    {{-- Filters --}}
    <div class="bg-white/80 backdrop-blur-sm rounded-xl shadow-lg border border-gray-100 p-4 mb-4">
        <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Dokter</label>
                <select wire:model.live="doctor_id" class="form-control">
                    <option value="">Semua Dokter</option>
                    @foreach($doctors as $doctor)
                        <option value="{{ $doctor->id }}">{{ $doctor->name }}</option>
                    @endforeach
                </select>
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
    </div>

    <div class="bg-white/80 backdrop-blur-sm rounded-xl shadow-lg border border-gray-100 overflow-hidden mb-6">
        <div class="table-container">
            <table class="table">
                <thead>
                    <tr>
                        <th class="w-1 center">No</th>
                        <th>Dokter</th>
                        <th>Pasien</th>
                        <th>Total Kunjungan</th>
                        <th>Kunjungan Terakhir</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($details as $index => $detail)
                        <tr>
                            <td class="center">{{ $details->firstItem() + $index }}</td>
                            <td>{{ $detail->doctor->name ?? '-' }}</td>
                            <td>{{ $detail->patient->name ?? '-' }}</td>
                            <td>
                                <span class="bg-blue-100 text-blue-800 text-xs font-semibold px-2.5 py-0.5 rounded">{{ $detail->total_visits }} Kali</span>
                            </td>
                            <td>{{ $detail->last_visit ? \Carbon\Carbon::parse($detail->last_visit)->locale('id')->isoFormat('D MMMM Y') : '-' }}</td>
                            <td>
                                <button
                                    wire:click="viewDetail('{{ $detail->doctor_id }}', '{{ $detail->patient_id }}')"
                                    wire:loading.attr="disabled"
                                    class="inline-flex items-center gap-1 px-3 py-1.5 text-xs font-semibold text-white bg-[#1E3A8A] hover:bg-blue-800 rounded-lg transition-colors">
                                    <i class="fa-solid fa-list-ul"></i>
                                    Lihat Detail
                                </button>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center text-gray-500 py-4">Data tidak ditemukan</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
       <div class="px-5 py-4 bg-gray-50/80 border-t border-gray-200">
            <div class="flex items-center justify-between">
                <div class="text-sm text-gray-700">
                    Menampilkan <span class="font-medium">{{ $details->firstItem() }}</span> sampai <span
                        class="font-medium">{{ $details->lastItem() }}</span> dari <span
                        class="font-medium">{{ $details->total() }}</span> hasil
                </div>
                <div>
                    <nav class="relative z-0 inline-flex rounded-md shadow-sm -space-x-px" aria-label="Pagination">
                        {{ $details->links('vendor.livewire.custom') }} <!-- Menampilkan pagination -->
                    </nav>
                </div>
            </div>
        </div>
    </div>

    {{-- Transaction Detail Modal --}}
    @if($showModal)
    <div class="fixed inset-0 z-50 flex items-center justify-center p-4" wire:click.self="closeModal">
        {{-- Backdrop --}}
        <div class="absolute inset-0 bg-black/40 backdrop-blur-sm"></div>

        {{-- Modal --}}
        <div class="relative bg-white rounded-2xl shadow-2xl w-full max-w-2xl max-h-[80vh] flex flex-col overflow-hidden">
            {{-- Header --}}
            <div class="flex items-center justify-between px-6 py-4 border-b border-gray-100 bg-gradient-to-r from-[#1E3A8A] to-blue-600">
                <div>
                    <h3 class="text-lg font-bold text-white">Riwayat Transaksi</h3>
                    <p class="text-blue-100 text-sm mt-0.5">
                        <span class="font-semibold">{{ $modalPatientName }}</span>
                        <span class="mx-1">•</span>
                        Dokter: <span class="font-semibold">{{ $modalDoctorName }}</span>
                    </p>
                </div>
                <button wire:click="closeModal" class="text-white/70 hover:text-white transition-colors">
                    <i class="fa-solid fa-xmark text-xl"></i>
                </button>
            </div>

            {{-- Body --}}
            <div class="overflow-y-auto flex-1">
                <table class="min-w-full text-sm">
                    <thead class="bg-gray-50 sticky top-0">
                        <tr>
                            <th class="px-4 py-3 text-left font-semibold text-gray-600">No</th>
                            <th class="px-4 py-3 text-left font-semibold text-gray-600">Kode Transaksi</th>
                            <th class="px-4 py-3 text-left font-semibold text-gray-600">Tanggal</th>
                            <th class="px-4 py-3 text-right font-semibold text-gray-600">Total</th>
                            <th class="px-4 py-3 text-center font-semibold text-gray-600">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        @forelse($modalTransactions as $i => $trx)
                            <tr class="hover:bg-blue-50/50 transition-colors">
                                <td class="px-4 py-3 text-gray-500">{{ $i + 1 }}</td>
                                <td class="px-4 py-3 font-mono font-semibold text-[#1E3A8A]">{{ $trx['code'] }}</td>
                                <td class="px-4 py-3 text-gray-700">{{ $trx['date'] }}</td>
                                <td class="px-4 py-3 text-right font-semibold text-gray-800">Rp {{ $trx['total_price'] }}</td>
                                <td class="px-4 py-3 text-center">
                                    <a href="javascript:void(0)" wire:click="openTransactionDetail('{{ $trx['id'] }}')"
                                       class="inline-flex items-center gap-1 px-2.5 py-1 text-xs font-semibold text-[#1E3A8A] border border-[#1E3A8A] rounded-lg hover:bg-[#1E3A8A] hover:text-white transition-colors">
                                        <i class="fa-solid fa-arrow-up-right-from-square"></i>
                                        Buka
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="px-4 py-6 text-center text-gray-400">Tidak ada transaksi ditemukan.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            {{-- Footer --}}
            <div class="px-6 py-3 border-t border-gray-100 flex justify-between items-center text-xs text-gray-500 bg-gray-50">
                <span>Total {{ count($modalTransactions) }} transaksi</span>
                <button wire:click="closeModal" class="px-4 py-1.5 bg-gray-200 hover:bg-gray-300 text-gray-700 rounded-lg font-semibold transition-colors">
                    Tutup
                </button>
            </div>
        </div>
    </div>
    @endif
</div>
