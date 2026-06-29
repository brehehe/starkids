<div>
    <div class="mb-4">
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-2xl font-bold text-[#1E3A8A]">Laporan Medis Komprehensif</h1>
                <p class="text-gray-600 mt-1">Analisis data medis: diagnosis, resep, pemeriksaan fisik, dan kode ICD</p>
            </div>
            <div class="flex space-x-2">
                <button wire:click="exportData" class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-lg transition-colors">
                    <i class="fas fa-download mr-2"></i>Export
                </button>
            </div>
        </div>
    </div>

    <!-- Summary Cards -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4 mb-6">
        <div class="bg-gradient-to-r from-blue-500 to-blue-600 rounded-xl shadow-lg p-6 text-white">
            <div class="flex items-center justify-between">
                <div>
                    <h3 class="text-sm font-medium opacity-90">Total Konsultasi</h3>
                    <p class="text-2xl font-bold">{{ number_format($summaryData['total_consultations'] ?? 0) }}</p>
                </div>
                <div class="w-12 h-12 bg-white bg-opacity-20 rounded-full flex items-center justify-center">
                    <i class="fas fa-user-md text-xl"></i>
                </div>
            </div>
        </div>

        <div class="bg-gradient-to-r from-green-500 to-green-600 rounded-xl shadow-lg p-6 text-white">
            <div class="flex items-center justify-between">
                <div>
                    <h3 class="text-sm font-medium opacity-90">Total Diagnosis</h3>
                    <p class="text-2xl font-bold">{{ number_format($summaryData['total_diagnoses'] ?? 0) }}</p>
                </div>
                <div class="w-12 h-12 bg-white bg-opacity-20 rounded-full flex items-center justify-center">
                    <i class="fas fa-stethoscope text-xl"></i>
                </div>
            </div>
        </div>

        <div class="bg-gradient-to-r from-purple-500 to-purple-600 rounded-xl shadow-lg p-6 text-white">
            <div class="flex items-center justify-between">
                <div>
                    <h3 class="text-sm font-medium opacity-90">Total Resep</h3>
                    <p class="text-2xl font-bold">{{ number_format($summaryData['total_recipes'] ?? 0) }}</p>
                </div>
                <div class="w-12 h-12 bg-white bg-opacity-20 rounded-full flex items-center justify-center">
                    <i class="fas fa-prescription-bottle-alt text-xl"></i>
                </div>
            </div>
        </div>

        <div class="bg-gradient-to-r from-orange-500 to-orange-600 rounded-xl shadow-lg p-6 text-white">
            <div class="flex items-center justify-between">
                <div>
                    <h3 class="text-sm font-medium opacity-90">Pemeriksaan Fisik</h3>
                    <p class="text-2xl font-bold">{{ number_format($summaryData['total_examinations'] ?? 0) }}</p>
                </div>
                <div class="w-12 h-12 bg-white bg-opacity-20 rounded-full flex items-center justify-center">
                    <i class="fas fa-heartbeat text-xl"></i>
                </div>
            </div>
        </div>

        <div class="bg-gradient-to-r from-teal-500 to-teal-600 rounded-xl shadow-lg p-6 text-white">
            <div class="flex items-center justify-between">
                <div>
                    <h3 class="text-sm font-medium opacity-90">Pasien Unik</h3>
                    <p class="text-2xl font-bold">{{ number_format($summaryData['unique_patients'] ?? 0) }}</p>
                </div>
                <div class="w-12 h-12 bg-white bg-opacity-20 rounded-full flex items-center justify-center">
                    <i class="fas fa-users text-xl"></i>
                </div>
            </div>
        </div>

        <div class="bg-gradient-to-r from-indigo-500 to-indigo-600 rounded-xl shadow-lg p-6 text-white">
            <div class="flex items-center justify-between">
                <div>
                    <h3 class="text-sm font-medium opacity-90">Dokter Aktif</h3>
                    <p class="text-2xl font-bold">{{ number_format($summaryData['unique_doctors'] ?? 0) }}</p>
                </div>
                <div class="w-12 h-12 bg-white bg-opacity-20 rounded-full flex items-center justify-center">
                    <i class="fas fa-user-friends text-xl"></i>
                </div>
            </div>
        </div>
    </div>

    <!-- Filters -->
    <div class="bg-white rounded-xl shadow-lg p-6 mb-6">
        <h3 class="text-lg font-semibold text-gray-800 mb-4">Filter Laporan Medis</h3>
        
        <!-- Report Type Selection -->
        <div class="mb-4">
            <label class="block text-sm font-medium text-gray-700 mb-2">Jenis Laporan</label>
            <div class="flex flex-wrap gap-2">
                <button wire:click="$set('reportType', 'diagnosis')" 
                    class="px-4 py-2 rounded-lg transition-colors {{ $reportType === 'diagnosis' ? 'bg-blue-600 text-white' : 'bg-gray-200 text-gray-700 hover:bg-gray-300' }}">
                    <i class="fas fa-stethoscope mr-1"></i>Diagnosis
                </button>
                <button wire:click="$set('reportType', 'recipe')" 
                    class="px-4 py-2 rounded-lg transition-colors {{ $reportType === 'recipe' ? 'bg-blue-600 text-white' : 'bg-gray-200 text-gray-700 hover:bg-gray-300' }}">
                    <i class="fas fa-prescription-bottle-alt mr-1"></i>Resep
                </button>
                <button wire:click="$set('reportType', 'examination')" 
                    class="px-4 py-2 rounded-lg transition-colors {{ $reportType === 'examination' ? 'bg-blue-600 text-white' : 'bg-gray-200 text-gray-700 hover:bg-gray-300' }}">
                    <i class="fas fa-heartbeat mr-1"></i>Pemeriksaan Fisik
                </button>
                <button wire:click="$set('reportType', 'icd')" 
                    class="px-4 py-2 rounded-lg transition-colors {{ $reportType === 'icd' ? 'bg-blue-600 text-white' : 'bg-gray-200 text-gray-700 hover:bg-gray-300' }}">
                    <i class="fas fa-code mr-1"></i>Kode ICD
                </button>
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
            <div>
                <label class="block text-sm font-medium text-gray-700">Dari Tanggal</label>
                <input type="date" wire:model.live="start_date" class="mt-1 form-control" />
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700">Sampai Tanggal</label>
                <input type="date" wire:model.live="end_date" class="mt-1 form-control" />
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700">Dokter</label>
                <select wire:model.live="doctor_id" class="mt-1 form-control">
                    <option value="">Semua Dokter</option>
                    @foreach($doctors as $doctor)
                        <option value="{{ $doctor->id }}">{{ $doctor->name }}</option>
                    @endforeach
                </select>
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700">Pencarian</label>
                <input type="text" wire:model.live="search" placeholder="Cari diagnosis, obat, kode..." class="mt-1 form-control" />
            </div>
        </div>
    </div>

    <!-- Table Controls -->
    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center mb-4 gap-4">
        <div class="flex items-center">
            <span class="text-sm text-gray-700 mr-2">Tampil</span>
            <select class="mt-1 form-control" wire:model.live='perPage'>
                <option value="10">10</option>
                <option value="25">25</option>
                <option value="50">50</option>
                <option value="100">100</option>
            </select>
            <span class="text-sm text-gray-700 ml-2">data</span>
        </div>
    </div>

    <!-- Data Table -->
    <div class="bg-white/80 backdrop-blur-sm rounded-xl shadow-lg border border-gray-100 overflow-hidden mb-6">
        <div class="table-container">
            @if($reportType === 'diagnosis')
                <!-- Diagnosis Report Table -->
                <table class="table">
                    <thead>
                        <tr>
                            <th class="w-1 center">No</th>
                            <th>Kode Transaksi</th>
                            <th>Tanggal</th>
                            <th>Pasien</th>
                            <th>Dokter</th>
                            <th>Diagnosis</th>
                            <th>Catatan</th>
                            <th>Tindak Lanjut</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($reportData as $index => $diagnosis)
                            <tr>
                                <td class="center">{{ $reportData->firstItem() + $index }}</td>
                                <td class="font-medium">{{ $diagnosis->transaction->code }}</td>
                                <td>{{ $diagnosis->created_at->format('d/m/Y H:i') }}</td>
                                <td>{{ $diagnosis->transaction->patient_name ?? $diagnosis->transaction->patient?->name ?? '-' }}</td>
                                <td>{{ $diagnosis->transaction->doctor?->name ?? '-' }}</td>
                                <td class="max-w-xs">
                                    <div class="truncate" title="{{ $diagnosis->diagnosis }}">
                                        {{ $diagnosis->diagnosis }}
                                    </div>
                                </td>
                                <td class="max-w-xs">
                                    <div class="truncate" title="{{ $diagnosis->notes }}">
                                        {{ $diagnosis->notes ?? '-' }}
                                    </div>
                                </td>
                                <td>{{ $diagnosis->follow_up ?? '-' }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="8" class="center text-gray-500 py-8">
                                    <i class="fas fa-stethoscope text-4xl mb-4 opacity-50"></i>
                                    <p>Tidak ada data diagnosis</p>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            @elseif($reportType === 'recipe')
                <!-- Recipe Report Table -->
                <table class="table">
                    <thead>
                        <tr>
                            <th class="w-1 center">No</th>
                            <th>Kode Transaksi</th>
                            <th>Tanggal</th>
                            <th>Pasien</th>
                            <th>Dokter</th>
                            <th>Obat</th>
                            <th>Dosis</th>
                            <th>Aturan Pakai</th>
                            <th>Qty</th>
                            <th>Narkotika</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($reportData as $index => $recipe)
                            <tr>
                                <td class="center">{{ $reportData->firstItem() + $index }}</td>
                                <td class="font-medium">{{ $recipe->transaction->code }}</td>
                                <td>{{ $recipe->created_at->format('d/m/Y H:i') }}</td>
                                <td>{{ $recipe->transaction->patient_name }}</td>
                                <td>{{ $recipe->transaction->doctor?->name ?? '-' }}</td>
                                <td>{{ $recipe->product_name }}</td>
                                <td>{{ $recipe->dosage ?? '-' }}</td>
                                <td class="max-w-xs">
                                    <div class="truncate" title="{{ $recipe->usage_rules }}">
                                        {{ $recipe->usage_rules ?? '-' }}
                                    </div>
                                </td>
                                <td class="center">{{ number_format($recipe->quantity) }}</td>
                                <td class="center">
                                    @if($recipe->is_narcotic)
                                        <span class="px-2 py-1 text-xs rounded-full bg-red-100 text-red-800">
                                            <i class="fas fa-exclamation-triangle mr-1"></i>Ya
                                        </span>
                                    @else
                                        <span class="px-2 py-1 text-xs rounded-full bg-green-100 text-green-800">
                                            Tidak
                                        </span>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="10" class="center text-gray-500 py-8">
                                    <i class="fas fa-prescription-bottle-alt text-4xl mb-4 opacity-50"></i>
                                    <p>Tidak ada data resep</p>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            @elseif($reportType === 'examination')
                <!-- Physical Examination Report Table -->
                <table class="table">
                    <thead>
                        <tr>
                            <th class="w-1 center">No</th>
                            <th>Kode Transaksi</th>
                            <th>Tanggal</th>
                            <th>Pasien</th>
                            <th>Dokter</th>
                            <th>Tekanan Darah</th>
                            <th>Detak Jantung</th>
                            <th>Suhu</th>
                            <th>Berat Badan</th>
                            <th>Tinggi Badan</th>
                            <th>Catatan</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($reportData as $index => $examination)
                            <tr>
                                <td class="center">{{ $reportData->firstItem() + $index }}</td>
                                <td class="font-medium">{{ $examination->transaction->code }}</td>
                                <td>{{ $examination->created_at->format('d/m/Y H:i') }}</td>
                                <td>{{ $examination->transaction->patient_name }}</td>
                                <td>{{ $examination->transaction->doctor?->name ?? '-' }}</td>
                                <td>{{ $examination->blood_pressure ?? '-' }}</td>
                                <td>{{ $examination->heart_rate ? $examination->heart_rate . ' bpm' : '-' }}</td>
                                <td>{{ $examination->temperature ? $examination->temperature . '°C' : '-' }}</td>
                                <td>{{ $examination->weight ? $examination->weight . ' kg' : '-' }}</td>
                                <td>{{ $examination->height ? $examination->height . ' cm' : '-' }}</td>
                                <td class="max-w-xs">
                                    <div class="truncate" title="{{ $examination->notes }}">
                                        {{ $examination->notes ?? '-' }}
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="11" class="center text-gray-500 py-8">
                                    <i class="fas fa-heartbeat text-4xl mb-4 opacity-50"></i>
                                    <p>Tidak ada data pemeriksaan fisik</p>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            @elseif($reportType === 'icd')
                <!-- ICD Report Table -->
                <table class="table">
                    <thead>
                        <tr>
                            <th class="w-1 center">No</th>
                            <th>Kode Transaksi</th>
                            <th>Tanggal</th>
                            <th>Pasien</th>
                            <th>Dokter</th>
                            <th>Tipe ICD</th>
                            <th>Kode</th>
                            <th>Deskripsi</th>
                            <th>Kategori</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($reportData as $index => $icd)
                            <tr>
                                <td class="center">{{ $reportData->firstItem() + $index }}</td>
                                <td class="font-medium">{{ $icd->transaction->code }}</td>
                                <td>{{ $icd->created_at->format('d/m/Y H:i') }}</td>
                                <td>{{ $icd->transaction->patient_name }}</td>
                                <td>{{ $icd->transaction->doctor?->name ?? '-' }}</td>
                                <td>
                                    <span class="px-2 py-1 text-xs rounded-full {{ $icd->icd_type === 'ICD-9' ? 'bg-blue-100 text-blue-800' : 'bg-purple-100 text-purple-800' }}">
                                        {{ $icd->icd_type }}
                                    </span>
                                </td>
                                <td class="font-mono">{{ $icd->code ?? '-' }}</td>
                                <td class="max-w-xs">
                                    <div class="truncate" title="{{ $icd->description }}">
                                        {{ $icd->description ?? '-' }}
                                    </div>
                                </td>
                                <td>{{ $icd->category ?? '-' }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="9" class="center text-gray-500 py-8">
                                    <i class="fas fa-code text-4xl mb-4 opacity-50"></i>
                                    <p>Tidak ada data kode ICD</p>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            @endif
        </div>
    </div>

    <!-- Pagination -->
    <div class="mt-6">
        {{ $reportData->links() }}
    </div>
</div>

@push('scripts')
<script>
    document.addEventListener('livewire:init', function() {
        Livewire.on('export-started', function() {
            Swal.fire({
                title: 'Mengekspor Data Medis...',
                text: 'Mohon tunggu sebentar',
                allowOutsideClick: false,
                showConfirmButton: false,
                willOpen: () => {
                    Swal.showLoading();
                }
            });
        });
    });
</script>
@endpush