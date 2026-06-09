<div>
    <div class="mb-4">
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-2xl font-bold text-[#1E3A8A]">Deposit</h1>
            </div>
            <div>
                <button wire:click="createDeposit()" class="btn btn-primary">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                    </svg>
                    Tambah Deposit
                </button>
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
            <input type="text" class="mt-1 form-control-search" placeholder="Cari Sesuatu..."
                wire:model.live='search'>
            <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                <i class="fas fa-search h-3 w-3 text-gray-400"></i>
            </div>
        </div>
    </div>

    <!-- Deposits Table -->
    <!-- Table Section -->
    <div class="bg-white/80 backdrop-blur-sm rounded-xl shadow-lg border border-gray-100 overflow-hidden mb-6">
        <div class="table-container">
            <table class="table">
                <thead>
                    <tr>
                        <th class="w-1 center">No</th>
                        <th>Kode Deposit</th>
                        <th>Pasien</th>
                        <th>Tipe User</th>
                        <th>Total Amount</th>
                        <th>Terbayar</th>
                        <th>Sisa</th>
                        <th>Status</th>
                        <th>Tanggal</th>
                        <th class="w-1 center">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($deposits as $index => $deposit)
                        <tr>
                            <td class="center">{{ $deposits->firstItem() + $index }}</td>
                            <td>
                                <div class="fw-bold">{{ $deposit->code }}</div>
                                @if ($deposit->text)
                                    <small class="text-muted">{{ Str::limit($deposit->text, 30) }}</small>
                                @endif
                            </td>
                            <td>
                                <div class="fw-bold">{{ $deposit->patient->name ?? '-' }}</div>
                                @if ($deposit->patient?->phone)
                                    <small class="text-muted">{{ $deposit->patient->phone }}</small>
                                @endif
                            </td>
                            <td>
                                <span class="badge bg-info">{{ $deposit->userType->name ?? '-' }}</span>
                            </td>
                            <td class="text-end">
                                <span class="fw-bold">Rp
                                    {{ number_format($deposit->grand_total_price, 0, ',', '.') }}</span>
                            </td>
                            <td class="text-end">
                                @php
                                    $paid = $deposit->grand_total_price - $deposit->remaining_bill;
                                @endphp
                                <span class="text-success">Rp
                                    {{ number_format($paid, 0, ',', '.') }}</span>
                            </td>
                            <td class="text-end">
                                <span class="text-warning">Rp
                                    {{ number_format($deposit->remaining_bill, 0, ',', '.') }}</span>
                            </td>
                            <td>
                                @if ($deposit->remaining_bill <= 0)
                                    <span class="badge bg-success">Lunas</span>
                                @elseif($deposit->remaining_bill == $deposit->grand_total_price)
                                    <span class="badge bg-warning">Pending</span>
                                @else
                                    <span class="badge bg-info">Sebagian</span>
                                @endif
                            </td>
                            <td>
                                <div class="fw-bold">{{ $deposit->created_at->format('d/m/Y') }}</div>
                                <small class="text-muted">{{ $deposit->created_at->format('H:i') }}</small>
                            </td>
                            <td class="center">
                                <div class="flex items-center">
                                    @if ($deposit->status !== 'success')
                                        <button
                                            class="btn btn-icon text-blue-600 hover:text-blue-800 transition-colors edit-btn"
                                            wire:click="editDeposit('{{ $deposit->id }}')">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none"
                                                viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                            </svg>
                                        </button>
                                        <button
                                            class="btn btn-icon text-red-600 hover:text-red-800 transition-colors delete-btn"
                                            wire:click="confirmDelete('{{ $deposit->id }}')">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none"
                                                viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                            </svg>
                                        </button>
                                    @else
                                        <button
                                            class="btn btn-icon text-green-600 hover:text-green-800 transition-colors view-btn"
                                            wire:click="editDeposit('{{ $deposit->id }}')"
                                            title="Lihat Detail (Deposit Sudah Lunas)">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none"
                                                viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                            </svg>
                                        </button>
                                        <span class="text-xs text-green-600 ml-2">Lunas</span>
                                    @endif
                                    </svg>
                                    </button>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="10" class="no-data">Tidak ada data deposit</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        <div class="px-5 py-4 bg-gray-50/80 border-t border-gray-200">
            <div class="flex items-center justify-between">
                <div class="text-sm text-gray-700">
                    Menampilkan <span class="font-medium">{{ $deposits->firstItem() }}</span> sampai <span
                        class="font-medium">{{ $deposits->lastItem() }}</span> dari <span
                        class="font-medium">{{ $deposits->total() }}</span> hasil
                </div>
                <div>
                    <nav class="relative z-0 inline-flex rounded-md shadow-sm -space-x-px" aria-label="Pagination">
                        {{ $deposits->links('vendor.livewire.custom') }} <!-- Menampilkan pagination -->
                    </nav>
                </div>
            </div>
        </div>

    </div>
</div>
</div>

@push('scripts')
    <script>
        function confirmDelete(id, code) {
            Swal.fire({
                title: 'Konfirmasi Hapus',
                text: `Apakah Anda yakin ingin menghapus deposit "${code}"?`,
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3085d6',
                confirmButtonText: 'Ya, Hapus!',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    @this.deleteDeposit(id);
                }
            });
        }

        // Auto refresh statistics setiap 30 detik
        setInterval(function() {
            @this.loadStatistics();
        }, 30000);
    </script>
@endpush
