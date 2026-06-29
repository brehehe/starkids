<div>
    <div class="mb-4">
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-2xl font-bold text-[#1E3A8A]">Jadwal Kontrol Dokter</h1>
            </div>
        </div>
    </div>

    {{-- Status Filter Tabs --}}
    <div class="mb-6">
        <div class="bg-white rounded-xl shadow-lg border border-gray-100 p-2">
            <div class="flex gap-2">
                <button wire:click="$set('statusFilter', 'all')"
                    class="flex-1 px-4 py-2.5 rounded-lg text-sm font-medium transition-all duration-200 {{ $statusFilter === 'all' ? 'bg-[#1E3A8A] text-white shadow-md' : 'text-gray-600 hover:bg-gray-100' }}">
                    <i class="fas fa-list mr-2"></i>
                    Semua
                </button>
                <button wire:click="$set('statusFilter', 'draft')"
                    class="flex-1 px-4 py-2.5 rounded-lg text-sm font-medium transition-all duration-200 {{ $statusFilter === 'draft' ? 'bg-[#F59E0B] text-white shadow-md' : 'text-gray-600 hover:bg-gray-100' }}">
                    <i class="fas fa-clock mr-2"></i>
                    Belum Datang
                </button>
                <button wire:click="$set('statusFilter', 'completed')"
                    class="flex-1 px-4 py-2.5 rounded-lg text-sm font-medium transition-all duration-200 {{ $statusFilter === 'completed' ? 'bg-[#4CAF50] text-white shadow-md' : 'text-gray-600 hover:bg-gray-100' }}">
                    <i class="fas fa-check-circle mr-2"></i>
                    Sudah Datang
                </button>
            </div>
        </div>
    </div>

    <div class="space-y-6 mb-6">
        <!-- SECTION 1: Informasi Umum Produk -->
        <div class="p-6 bg-white shadow rounded-lg">
            <div class="grid grid-cols-1 md:grid-cols-5 gap-4">
                <div>
                    <label for="selectedMonth" class="block text-sm font-medium text-gray-700">Bulan</label>
                    <div wire:key="select-{{ rand() }}">
                        <select class="mt-1 form-control" x-data x-ref="input" x-init="$($refs.input).selectize({
                            dropdownParent: 'body',
                            allowClear: true,
                            plugins: ['clear_button'],
                            onChange: function(e) {
                                @this.set('selectedMonth', e ? e : null);
                            }
                        });"
                            wire:model.lazy="selectedMonth" id="selectedMonth">
                            <option value="">-- Pilih Bulan --</option>
                            @foreach ($months as $key_month => $month)
                                <option value="{{ $key_month }}">{{ $month }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div>
                    <label for="selectedYear" class="block text-sm font-medium text-gray-700">Tahun</label>
                    <div wire:key="select-{{ rand() }}">
                        <select class="mt-1 form-control" x-data x-ref="input" x-init="$($refs.input).selectize({
                            dropdownParent: 'body',
                            allowClear: true,
                            plugins: ['clear_button'],
                            onChange: function(e) {
                                @this.set('selectedYear', e ? e : null);
                            }
                        });"
                            wire:model.lazy="selectedYear" id="selectedYear">
                            <option value="">-- Pilih Tahun --</option>
                            @foreach ($years as $year)
                                <option value="{{ $year }}">{{ $year }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div>
                    <label for="filterLocation" class="block text-sm font-medium text-gray-700">Lokasi</label>
                    <div wire:key="select-{{ rand() }}">
                        <select class="mt-1 form-control" x-data x-ref="input" x-init="$($refs.input).selectize({
                            dropdownParent: 'body',
                            allowClear: true,
                            plugins: ['clear_button'],
                            onChange: function(e) {
                                @this.set('filterLocation', e ? e : null);
                            }
                        });"
                            wire:model.lazy="filterLocation" id="filterLocation">
                            <option value="">-- Pilih Lokasi --</option>
                            @foreach ($locations as $key_location => $location)
                                <option value="{{ $key_location }}">{{ $location }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div>
                    <label for="filterDoctor" class="block text-sm font-medium text-gray-700">Dokter</label>
                    <div wire:key="select-{{ rand() }}">
                        <select class="mt-1 form-control" x-data x-ref="input" x-init="$($refs.input).selectize({
                            dropdownParent: 'body',
                            allowClear: true,
                            plugins: ['clear_button'],
                            onChange: function(e) {
                                @this.set('filterDoctor', e ? e : null);
                            }
                        });"
                            wire:model.lazy="filterDoctor" id="filterDoctor">
                            <option value="">-- Pilih Dokter --</option>
                            @foreach ($doctors as $key_doctor => $doctor)
                                <option value="{{ $key_doctor }}">{{ $doctor }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div>
                    <label for="filterPatient" class="block text-sm font-medium text-gray-700">Pasien</label>
                    <div wire:key="select-{{ rand() }}">
                        <select class="mt-1 form-control" x-data x-ref="input" x-init="$($refs.input).selectize({
                            dropdownParent: 'body',
                            allowClear: true,
                            plugins: ['clear_button'],
                            onChange: function(e) {
                                @this.set('filterPatient', e ? e : null);
                            }
                        });"
                            wire:model.lazy="filterPatient" id="filterPatient">
                            <option value="">-- Pilih Pasien --</option>
                            @foreach ($patients as $key_patient => $patient)
                                <option value="{{ $key_patient }}">{{ $patient }}</option>
                            @endforeach
                        </select>
                    </div>
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
                        <th>Pasien</th>
                        <th>Dokter</th>
                        <th>Poli</th>
                        <th>Tanggal</th>
                        <th>Deskripsi</th>
                        <th>Tindakan</th>
                        <th>Status</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($userControlDoctors as $index => $transaction)
                        <tr class="{{ $transaction->status == 'completed' ? 'bg-green-50' : '' }}">
                            <td class="center">{{ $userControlDoctors->firstItem() + $index }}</td>
                            <td class="whitespace-nowrap">
                                <p>{{ $transaction?->user?->name ?? '-' }}</p>
                            </td>
                            <td class="whitespace-nowrap">
                                <p>{{ $transaction?->doctor?->name ?? '-' }}</p>
                            </td>
                            <td class="whitespace-nowrap">
                                <p>{{ $transaction?->location?->name ?? '-' }}</p>
                            </td>
                            <td class="whitespace-nowrap">
                                <p>
                                    {{ $transaction?->date ? \Carbon\Carbon::parse($transaction->date)->translatedFormat('d F Y') : '-' }}
                                </p>
                            </td>
                            <td class="whitespace-nowrap">
                                <p>{{ $transaction?->description ?? '-' }}</p>
                            </td>
                            <td class="whitespace-nowrap">
                                @if (!empty($transaction->products))
                                    @foreach ($transaction?->products as $product)
                                        <p>- {{ $product ?? '-' }}</p>
                                    @endforeach
                                @else
                                    <p>-</p>
                                @endif
                            </td>
                            <td class="whitespace-nowrap">
                                <p>{{ $transaction?->status ?? '-' }}</p>
                            </td>
                            <td>
                                @if ($transaction->status == 'draft' || $transaction->status == null)
                                    <button
                                        class="btn btn-icon text-blue-600 hover:text-blue-800 transition-colors edit-btn"
                                        wire:click="confirmDetail('{{ $transaction->id }}')">
                                        <i class="fa-solid fa-circle-check"></i>
                                    </button>
                                @elseif ($transaction->status == 'completed')
                                    <span class="text-green-600 font-semibold text-sm">
                                        <i class="fa-solid fa-check-circle mr-1"></i>Selesai
                                    </span>
                                @endif
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
                    Menampilkan <span class="font-medium">{{ $userControlDoctors->firstItem() }}</span> sampai <span
                        class="font-medium">{{ $userControlDoctors->lastItem() }}</span> dari <span
                        class="font-medium">{{ $userControlDoctors->total() }}</span> hasil
                </div>
                <div>
                    <nav class="relative z-0 inline-flex rounded-md shadow-sm -space-x-px" aria-label="Pagination">
                        {{ $userControlDoctors->links('vendor.livewire.custom') }} <!-- Menampilkan pagination -->
                    </nav>
                </div>
            </div>
        </div>
    </div>
    <div class="bg-white/80 backdrop-blur-sm rounded-xl shadow-lg border border-gray-100 overflow-hidden mb-6">
        <h3 class="px-5 py-3 font-semibold text-gray-700 bg-gray-100 border-b">Total Obat / Vaksin Dibutuhkan</h3>
        <div class="table-container">
            <table class="table">
                <thead>
                    <tr>
                        <th class="w-1 center">No</th>
                        <th>Produk</th>
                        <th>Total</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($productTotals as $product => $total)
                        <tr>
                            <td class="center">{{ $loop->iteration }}</td>
                            <td>{{ $product }}</td>
                            <td>{{ $total }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="3" class="no-data">Tidak ada produk</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

</div>
