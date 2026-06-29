<div>
    <div class="mb-6">
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-2xl font-bold text-[#1E3A8A]">Detail Promosi</h1>
                <p class="text-gray-600">{{ $promotion->name }}</p>
            </div>
            <div class="flex items-center space-x-3">
                <button wire:click="toggleStatus"
                    class="btn {{ $promotion->is_active ? 'btn-secondary' : 'btn-primary' }}">
                    {{ $promotion->is_active ? 'Nonaktifkan' : 'Aktifkan' }}
                </button>
                <button wire:click="duplicatePromotion" class="btn btn-outline">
                    Duplikasi
                </button>
                <a href="{{ route('admin.promotion.index') }}" class="btn btn-secondary">
                    Kembali
                </a>
            </div>
        </div>
    </div>

    <!-- Promotion Info -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-6">
        <!-- Basic Information -->
        <div class="lg:col-span-2">
            <div class="bg-white/80 backdrop-blur-sm rounded-xl shadow-lg border border-gray-100 p-6">
                <h3 class="text-lg font-semibold text-gray-900 mb-4">Informasi Promosi</h3>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Nama</label>
                        <p class="mt-1 text-sm text-gray-900">{{ $promotion->name }}</p>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700">Kode</label>
                        <p class="mt-1">
                            <span
                                class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                {{ $promotion->code }}
                            </span>
                        </p>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700">Tipe</label>
                        <p class="mt-1 text-sm text-gray-900">{{ ucfirst(str_replace('_', ' ', $promotion->type)) }}</p>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700">Nilai</label>
                        <p class="mt-1 text-sm text-gray-900">
                            @if ($promotion->promotion_type === 'persen')
                                {{ $promotion->promotion_value }}%
                            @else
                                Rp {{ number_format($promotion->promotion_value, 0, ',', '.') }}
                            @endif
                        </p>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700">Minimal Pembelian</label>
                        <p class="mt-1 text-sm text-gray-900">
                            Rp {{ number_format($promotion->minimum_purchase, 0, ',', '.') }}
                        </p>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700">Status</label>
                        <p class="mt-1">
                            @if ($promotion->is_active)
                                @if ($promotion->end_date && $promotion->end_date < now())
                                    <span
                                        class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800">
                                        Kadaluarsa
                                    </span>
                                @elseif($promotion->start_date && $promotion->start_date > now())
                                    <span
                                        class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800">
                                        Akan Datang
                                    </span>
                                @else
                                    <span
                                        class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                        Aktif
                                    </span>
                                @endif
                            @else
                                <span
                                    class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-gray-100 text-gray-800">
                                    Tidak Aktif
                                </span>
                            @endif
                        </p>
                    </div>
                </div>

                @if ($promotion->description)
                    <div class="mt-4">
                        <label class="block text-sm font-medium text-gray-700">Deskripsi</label>
                        <p class="mt-1 text-sm text-gray-900">{{ $promotion->description }}</p>
                    </div>
                @endif
            </div>
        </div>

        <!-- Statistics -->
        <div>
            <div class="bg-white/80 backdrop-blur-sm rounded-xl shadow-lg border border-gray-100 p-6">
                <h3 class="text-lg font-semibold text-gray-900 mb-4">Statistik</h3>

                <div class="space-y-4">
                    <div>
                        <div class="flex items-center justify-between">
                            <span class="text-sm font-medium text-gray-600">Total Penggunaan</span>
                            <span class="text-lg font-bold text-blue-600">{{ $analytics['total_usage'] }}</span>
                        </div>
                    </div>

                    <div>
                        <div class="flex items-center justify-between">
                            <span class="text-sm font-medium text-gray-600">Sisa Kuota</span>
                            <span class="text-lg font-bold text-green-600">{{ $analytics['remaining_quota'] }}</span>
                        </div>
                    </div>

                    <div>
                        <div class="flex items-center justify-between">
                            <span class="text-sm font-medium text-gray-600">Total Diskon</span>
                            <span class="text-lg font-bold text-purple-600">
                                Rp {{ number_format($analytics['total_discount_given'], 0, ',', '.') }}
                            </span>
                        </div>
                    </div>

                    @if (!$promotion->is_unlimited)
                        <div>
                            <div class="flex items-center justify-between mb-2">
                                <span class="text-sm font-medium text-gray-600">Progress</span>
                                <span class="text-sm text-gray-500">
                                    {{ $promotion->used_count }}/{{ $promotion->total_quota }}
                                </span>
                            </div>
                            <div class="w-full bg-gray-200 rounded-full h-2">
                                <div class="bg-blue-600 h-2 rounded-full"
                                    style="width: {{ $promotion->total_quota > 0 ? ($promotion->used_count / $promotion->total_quota) * 100 : 0 }}%">
                                </div>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <!-- Period Information -->
    <div class="bg-white/80 backdrop-blur-sm rounded-xl shadow-lg border border-gray-100 p-6 mb-6">
        <h3 class="text-lg font-semibold text-gray-900 mb-4">Periode Berlaku</h3>

        <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
            <div>
                <label class="block text-sm font-medium text-gray-700">Tanggal Mulai</label>
                <p class="mt-1 text-sm text-gray-900">
                    {{ $promotion->start_date ? $promotion->start_date->format('d/m/Y') : 'Tidak dibatasi' }}
                </p>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700">Tanggal Selesai</label>
                <p class="mt-1 text-sm text-gray-900">
                    {{ $promotion->end_date ? $promotion->end_date->format('d/m/Y') : 'Tidak dibatasi' }}
                </p>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700">Jam Mulai</label>
                <p class="mt-1 text-sm text-gray-900">
                    {{ $promotion->start_time ?: 'Sepanjang hari' }}
                </p>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700">Jam Selesai</label>
                <p class="mt-1 text-sm text-gray-900">
                    {{ $promotion->end_time ?: 'Sepanjang hari' }}
                </p>
            </div>
        </div>

        @if ($promotion->applicable_days && count($promotion->applicable_days) > 0)
            <div class="mt-4">
                <label class="block text-sm font-medium text-gray-700 mb-2">Hari Berlaku</label>
                <div class="flex flex-wrap gap-2">
                    @php
                        $dayLabels = [
                            'monday' => 'Senin',
                            'tuesday' => 'Selasa',
                            'wednesday' => 'Rabu',
                            'thursday' => 'Kamis',
                            'friday' => 'Jumat',
                            'saturday' => 'Sabtu',
                            'sunday' => 'Minggu',
                        ];
                    @endphp
                    @foreach ($promotion->applicable_days as $day)
                        <span
                            class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-gray-100 text-gray-800">
                            {{ $dayLabels[$day] ?? $day }}
                        </span>
                    @endforeach
                </div>
            </div>
        @endif
    </div>

    <!-- Usage History -->
    <div class="bg-white/80 backdrop-blur-sm rounded-xl shadow-lg border border-gray-100 overflow-hidden">
        <div class="px-6 py-4 border-b border-gray-200">
            <h3 class="text-lg font-semibold text-gray-900">Riwayat Penggunaan</h3>
        </div>

        <div class="table-container">
            <table class="table">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Pengguna</th>
                        <th>Tanggal</th>
                        <th>Diskon</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($usages as $index => $usage)
                        <tr>
                            <td>{{ $usages->firstItem() + $index }}</td>
                            <td>{{ $usage->user->name ?? 'N/A' }}</td>
                            <td>{{ $usage->created_at->format('d/m/Y H:i') }}</td>
                            <td>Rp {{ number_format($usage->discount_amount, 0, ',', '.') }}</td>
                            <td>
                                <span
                                    class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                    Berhasil
                                </span>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="no-data">Belum ada penggunaan</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if ($usages->hasPages())
            <div class="px-5 py-4 bg-gray-50/80 border-t border-gray-200">
                <div class="flex items-center justify-between">
                    <div class="text-sm text-gray-700">
                        Menampilkan <span class="font-medium">{{ $usages->firstItem() }}</span> sampai <span
                            class="font-medium">{{ $usages->lastItem() }}</span> dari <span
                            class="font-medium">{{ $usages->total() }}</span> hasil
                    </div>
                    <div>
                        <nav class="relative z-0 inline-flex rounded-md shadow-sm -space-x-px" aria-label="Pagination">
                            {{ $usages->links('vendor.livewire.custom') }}
                        </nav>
                    </div>
                </div>
            </div>
        @endif
    </div>
</div>
