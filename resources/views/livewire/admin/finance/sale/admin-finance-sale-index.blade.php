<div>
    <div class="mb-4">
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-2xl font-bold text-[#1E3A8A]">Penjualan</h1>
            </div>
        </div>
    </div>

    {{-- Statistics Cards --}}
    <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-6">
        <div class="bg-gradient-to-br from-blue-500 to-blue-600 rounded-xl shadow-lg p-6 text-white">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-blue-100 text-sm font-medium">Total Transaksi</p>
                    <h3 class="text-3xl font-bold mt-2">{{ number_format($this->totalCount, 0, ',', '.') }}</h3>
                </div>
                <div class="bg-white/20 rounded-full p-4">
                    <i class="fas fa-receipt text-2xl"></i>
                </div>
            </div>
        </div>

        <div class="bg-gradient-to-br from-green-500 to-green-600 rounded-xl shadow-lg p-6 text-white">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-green-100 text-sm font-medium">Total Penjualan</p>
                    <h3 class="text-2xl font-bold mt-2">Rp {{ number_format($this->totalGrandTotal, 0, ',', '.') }}</h3>
                </div>
                <div class="bg-white/20 rounded-full p-4">
                    <i class="fas fa-money-bill-wave text-2xl"></i>
                </div>
            </div>
        </div>

        <div class="bg-gradient-to-br from-purple-500 to-purple-600 rounded-xl shadow-lg p-6 text-white">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-purple-100 text-sm font-medium">Rata-rata Transaksi</p>
                    <h3 class="text-2xl font-bold mt-2">Rp {{ number_format($this->averageTransaction, 0, ',', '.') }}</h3>
                </div>
                <div class="bg-white/20 rounded-full p-4">
                    <i class="fas fa-chart-line text-2xl"></i>
                </div>
            </div>
        </div>
    </div>

    {{-- Filters --}}
    <div class="bg-white/80 backdrop-blur-sm rounded-xl shadow-lg border border-gray-100 p-4 mb-4">
        <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Tanggal Dari</label>
                <input type="date" class="form-control" wire:model.live="date_from">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Tanggal Sampai</label>
                <input type="date" class="form-control" wire:model.live="date_to">
            </div>
            <div class="flex items-end">
                <button wire:click="resetFilters" class="btn btn-secondary w-full">
                    <i class="fas fa-redo mr-2"></i> Reset Filter
                </button>
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
            <input type="text" class="mt-1 form-control-search" placeholder="Cari Sesuatu..." wire:model.live='search'>
            <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                <i class="fas fa-search h-3 w-3 text-gray-400"></i>
            </div>
        </div>
    </div>
    <div class="mb-4">
        <div class="overflow-x-auto  w-full">
            <nav class="flex w-full gap-2 px-2" aria-label="Tabs">
                @foreach ($get_statuss as $get_status)
                <button wire:click="changeStatus('{{ $get_status }}')"
                    class="text-center px-4 py-2 text-sm font-medium transition-all duration-300 cursor-pointer rounded-2xl
                               {{ $status === $get_status ? 'bg-blue-600 text-white shadow-md' : 'bg-gray-100 text-gray-600 hover:bg-gray-200 hover:text-black' }}">
                    {{ Str::title(Str::replace('-', ' ', $get_status)) }}
                </button>
                @endforeach
            </nav>
        </div>
    </div>
    <div class="bg-white/80 backdrop-blur-sm rounded-xl shadow-lg border border-gray-100 overflow-hidden mb-6">
        <div class="table-container">
            <table class="table">
                <thead>
                    <tr>
                        <th class="w-1 center">No</th>
                        <th style="width: 10%">Kode</th>
                        <th style="width: 40%">Deskripsi</th>
                        <th>Tanggal</th>
                        <th>Total</th>
                        <th class="w-1 center">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($finances as $index => $finance)
                    <tr>
                        <td class="center">{{ $finances->firstItem() + $index }}</td>
                        <td>{{ $finance->code ?? '-' }}</td>
                        <td>{{ $finance->description ?? '-' }}</td>
                        <td>{{ $finance->date ? \Carbon\Carbon::parse($finance->date)->locale('id')->isoFormat('D MMMM
                            Y') : '-' }}
                        </td>
                        <td>{{ $finance->grand_total ? 'Rp ' . number_format($finance->grand_total, 0, ',', '.') : '-'
                            }}
                        </td>
                        <td class="center">
                            <div class="flex items-center">
                                <button
                                    class="btn btn-icon text-blue-600 hover:text-blue-800 transition-colors edit-btn"
                                    wire:click="editFinance('{{ $finance->id }}')">
                                    <i class="fa-solid fa-eye"></i>
                                </button>
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
                    Menampilkan <span class="font-medium">{{ $finances->firstItem() }}</span> sampai <span
                        class="font-medium">{{ $finances->lastItem() }}</span> dari <span class="font-medium">{{
                        $finances->total() }}</span> hasil
                </div>
                <div>
                    <nav class="relative z-0 inline-flex rounded-md shadow-sm -space-x-px" aria-label="Pagination">
                        {{ $finances->links('vendor.livewire.custom') }}
                        <!-- Menampilkan pagination -->
                    </nav>
                </div>
            </div>
        </div>

    </div>
</div>
