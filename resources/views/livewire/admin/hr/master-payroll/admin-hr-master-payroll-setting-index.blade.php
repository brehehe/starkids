<div>
    <div class="mb-4">
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-2xl font-bold text-[#1E3A8A]">Pengaturan Gaji Pegawai</h1>
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
                        <th>Pegawai & Divisi</th>
                        <th class="center">Tipe Gaji</th>
                        <th class="text-right">Gaji Pokok</th>
                        <th class="center">Komponen Tambahan</th>
                        <th class="text-right">Total Gaji</th>
                        <th class="w-1 center">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($employees as $index => $user)
                    @php
                        $payroll = \App\Models\Hr\EmployeePayroll::with(['components.component'])->where('user_id', $user->id)->first();
                        $totalGajih = 0;
                        if ($payroll) {
                            $totalGajih = $payroll->basic_salary;
                            foreach ($payroll->components as $empComp) {
                                if (($empComp->component->type ?? '') == 'allowance') {
                                    $totalGajih += $empComp->amount;
                                } else {
                                    $totalGajih -= $empComp->amount;
                                }
                            }
                        }
                    @endphp
                    <tr>
                        <td class="center">{{ $employees->firstItem() + $index }}</td>
                        <td>
                            <div class="font-medium text-gray-900">{{ $user->name }}</div>
                            <div class="text-xs text-gray-500">{{ $user->email ?? $user->phone }}</div>
                        </td>
                        <td class="center">
                            @if($payroll)
                                @if($payroll->payment_type == 'monthly')
                                    <span class="px-2 py-1 bg-blue-100 text-blue-800 rounded text-xs">Bulanan</span>
                                @elseif($payroll->payment_type == 'weekly')
                                    <span class="px-2 py-1 bg-indigo-100 text-indigo-800 rounded text-xs">Mingguan</span>
                                @else
                                    <span class="px-2 py-1 bg-yellow-100 text-yellow-800 rounded text-xs">Harian</span>
                                @endif
                            @else
                                <span class="px-2 py-1 bg-gray-100 text-gray-600 rounded text-xs">Belum Diatur</span>
                            @endif
                        </td>
                        <td class="text-right font-medium text-gray-800">
                            Rp {{ number_format($payroll ? $payroll->basic_salary : 0, 0, ',', '.') }}
                        </td>
                        <td class="center">
                            @if($payroll && $payroll->components->count() > 0)
                                <div x-data="{ open: false }" class="relative inline-block text-left" @mouseleave="open = false">
                                    <button @mouseenter="open = true" @click="open = !open" class="inline-flex items-center justify-center bg-blue-50 text-blue-700 hover:bg-blue-100 text-xs font-bold px-3 py-1.5 rounded-full border border-blue-200 transition-colors cursor-pointer">
                                        <i class="fas fa-list-ul mr-1"></i> {{ $payroll->components->count() }} Komponen
                                    </button>
                                    
                                    <div x-show="open" x-transition class="absolute z-10 w-64 mt-2 -right-10 sm:right-0 bg-white rounded-lg shadow-xl border border-gray-200" style="display: none;">
                                        <div class="p-3 border-b border-gray-100 bg-gray-50 rounded-t-lg text-left">
                                            <h4 class="text-xs font-bold text-gray-700 uppercase">Detail Komponen</h4>
                                        </div>
                                        <div class="p-3 max-h-48 overflow-y-auto text-left">
                                            <ul class="space-y-2">
                                                @foreach($payroll->components as $empComp)
                                                    <li class="flex justify-between items-center text-sm">
                                                        <span class="text-gray-600 truncate mr-2" title="{{ $empComp->component->name ?? '-' }}">{{ $empComp->component->name ?? '-' }}</span>
                                                        <span class="font-medium whitespace-nowrap {{ ($empComp->component->type ?? '') == 'allowance' ? 'text-green-600' : 'text-red-500' }}">
                                                            {{ ($empComp->component->type ?? '') == 'allowance' ? '+' : '-' }}Rp {{ number_format($empComp->amount, 0, ',', '.') }}
                                                        </span>
                                                    </li>
                                                @endforeach
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            @else
                                <span class="text-gray-400">-</span>
                            @endif
                        </td>
                        <td class="text-right font-bold text-blue-700">
                            Rp {{ number_format($totalGajih, 0, ',', '.') }}
                        </td>
                        <td class="center">
                            <button wire:click="edit('{{ $user->id }}')" class="btn-action btn-edit bg-green-50 text-green-600 hover:bg-green-100 hover:text-green-700" title="Atur Gaji Pegawai">
                                <i class="fas fa-coins border-r border-green-200 pr-2 mr-1"></i> Atur
                            </button>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="no-data">Belum ada pegawai atau hasil tidak ditemukan.</td>
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

    <!-- Modal Form -->
    <div wire:ignore.self id="modal-setting"
        class="fixed inset-0 bg-overlay hidden items-center justify-center z-50 transition-opacity duration-300 ease-in-out">
        <div class="bg-white rounded-2xl shadow-2xl w-full transform transition-all scale-95 duration-300 ease-out animate-fade-in"
            style="max-width: 650px;">
            <!-- Header -->
            <div class="flex justify-between items-center p-6 border-b bg-gray-50 rounded-t-2xl">
                <div class="flex items-center gap-2">
                    <div class="bg-blue-100 p-2 rounded-lg">
                        <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z" />
                        </svg>
                    </div>
                    <div>
                        <h2 class="text-xl font-bold text-gray-800">Assign Komponen Gaji</h2>
                        <p class="text-sm text-gray-500 font-medium whitespace-nowrap overflow-hidden text-ellipsis max-w-[300px]">{{ $user_name }}</p>
                    </div>
                </div>
                <button wire:click="closeModal()"
                    class="text-gray-400 hover:text-red-500 bg-white shadow-sm border p-1 rounded-md transition-colors text-2xl leading-none cursor-pointer">
                    &times;
                </button>
            </div>

            <!-- Body -->
            <div class="px-6 py-4 text-gray-600 overflow-auto bg-white" style="max-height: 550px;">
                <!-- Konfigurasi Utama -->
                <h3 class="text-md font-semibold text-gray-700 mb-3 border-b pb-2">Gaji Pokok & Periode</h3>
                <div class="grid grid-cols-1 gap-4 mb-6 bg-gray-50/50 p-4 rounded-xl border border-gray-100">
                    <div class="mb-2">
                        <label for="basic_salary" class="block text-sm font-medium text-gray-700">Gaji Pokok (Rp) <span class="text-red-600">*</span></label>
                        <input id="basic_salary" type="number" wire:model.defer="basic_salary" placeholder="Contoh: 5000000" class="mt-1 form-control bg-white font-medium text-gray-800">
                        @error('basic_salary') <p class="text-sm text-red-600 mt-1">{{ $message }}</p> @enderror
                    </div>

                    {{-- <div class="mb-2">
                        <label for="payment_type" class="block text-sm font-medium text-gray-700">Periode Pembayaran <span class="text-red-600">*</span></label>
                        <select id="payment_type" wire:model.defer="payment_type" class="mt-1 form-control bg-white font-medium text-gray-700">
                            <option value="monthly">Bulanan</option>
                            <option value="weekly">Mingguan</option>
                            <option value="daily">Harian</option>
                        </select>
                        @error('payment_type') <p class="text-sm text-red-600 mt-1">{{ $message }}</p> @enderror
                    </div> --}}
                </div>

                <!-- Pemetaan Komponen Tambahan -->
                <h3 class="text-md font-semibold text-gray-700 mb-3 border-b pb-2">Custom Komponen / Tunjangan Lainnya</h3>
                @if($allComponents->count() > 0)
                    <div class="space-y-3">
                        @foreach ($allComponents as $comp)
                            <div class="flex items-center justify-between p-3 rounded-xl border border-gray-200 hover:border-blue-300 hover:shadow-sm transition-all bg-white group">
                                <div class="flex items-center flex-1 gap-3">
                                    <div class="flex items-center h-5">
                                        <input wire:model.live="selected_components.{{ $comp->id }}" id="comp_{{ $comp->id }}" type="checkbox" class="w-5 h-5 text-blue-600 bg-white border-gray-300 rounded focus:ring-blue-500 cursor-pointer">
                                    </div>
                                    <div class="ml-2 flex-col">
                                        <label for="comp_{{ $comp->id }}" class="text-sm font-bold text-gray-800 cursor-pointer select-none">
                                            {{ $comp->name }}
                                        </label>
                                        <div class="text-xs {{ $comp->type == 'allowance' ? 'text-green-600' : 'text-red-500' }} font-medium">
                                            {{ $comp->type == 'allowance' ? 'Tunjangan (+)' : 'Potongan (-)' }}
                                            @if($comp->is_taxable) <span class="text-gray-400">| Kena Pajak</span> @endif
                                        </div>
                                    </div>
                                </div>
                                <div class="w-1/3 min-w-[150px]">
                                    @if(!empty($selected_components[$comp->id]))
                                        <div class="relative">
                                            <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                                                <span class="text-gray-500 sm:text-xs font-semibold">Rp</span>
                                            </div>
                                            <input type="number" wire:model.defer="component_amounts.{{ $comp->id }}" 
                                                class="bg-blue-50 border border-blue-200 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full pl-8 p-2 font-medium" 
                                                placeholder="{{ $comp->default_amount > 0 ? (int)$comp->default_amount : '0' }}">
                                        </div>
                                    @endif
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <div class="text-center py-6 bg-gray-50 rounded-lg border border-dashed border-gray-300">
                        <p class="text-sm text-gray-500">Belum ada data komponen gaji. Buat tipe komponen terlebih dahulu di menu <b>Komponen Gaji</b>.</p>
                    </div>
                @endif
            </div>

            <!-- Footer -->
            <div class="flex justify-end gap-2 px-6 py-4 border-t bg-gray-50 rounded-b-2xl">
                <button wire:click="closeModal()" class="px-5 py-2.5 bg-white border border-gray-300 hover:bg-gray-50 text-gray-700 font-medium rounded-xl shadow-sm transition-all focus:ring-2 focus:ring-gray-200 focus:outline-none cursor-pointer">
                    Batal
                </button>
                <button wire:click="save()" class="px-5 py-2.5 bg-blue-600 hover:bg-blue-700 text-white font-medium rounded-xl shadow-sm transition-all focus:ring-2 focus:ring-blue-500 focus:outline-none cursor-pointer flex items-center" wire:loading.attr="disabled">
                    <svg wire:loading wire:target="save" class="animate-spin -ml-1 mr-2 h-4 w-4 text-white" fill="none" viewBox="0 0 24 24">
                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                    </svg>
                    <span wire:loading.remove wire:target="save">Simpan Pengaturan</span>
                    <span wire:loading wire:target="save">Menyimpan...</span>
                </button>
            </div>
        </div>
    </div>
</div>
