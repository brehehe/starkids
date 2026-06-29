<div>
    {{-- Header Section --}}
    <div class="mb-6">
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-2xl font-bold text-gray-900">Manajemen Promosi</h1>
                <p class="text-gray-600 mt-1">Kelola semua promosi dan penawaran khusus</p>
            </div>
            <div class="flex space-x-3">
                <a href="{{ route('promotions.create') }}" class="btn btn-primary">
                    <i class="fas fa-plus mr-2"></i>Tambah Promosi
                </a>
            </div>
        </div>
    </div>

    {{-- Filters Section --}}
    <div class="bg-white rounded-xl shadow-sm border p-6 mb-6">
        <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
            {{-- Search --}}
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Pencarian</label>
                <input type="text" wire:model.live="search" class="form-control"
                    placeholder="Cari nama, kode, atau deskripsi...">
            </div>

            {{-- Status Filter --}}
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Status</label>
                <select wire:model.live="filterStatus" class="form-control">
                    @foreach ($statusOptions as $value => $label)
                        <option value="{{ $value }}">{{ $label }}</option>
                    @endforeach
                </select>
            </div>

            {{-- Type Filter --}}
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Tipe Promosi</label>
                <select wire:model.live="filterType" class="form-control">
                    <option value="all">Semua Tipe</option>
                    @foreach ($promotionTypes as $value => $label)
                        <option value="{{ $value }}">{{ $label }}</option>
                    @endforeach
                </select>
            </div>

            {{-- Per Page --}}
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Per Halaman</label>
                <select wire:model.live="perPage" class="form-control">
                    <option value="10">10</option>
                    <option value="25">25</option>
                    <option value="50">50</option>
                </select>
            </div>
        </div>
    </div>

    {{-- Promotions List --}}
    <div class="bg-white rounded-xl shadow-sm border overflow-hidden">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Promosi
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Tipe & Nilai
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Target
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Periode
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Status
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Penggunaan
                        </th>
                        <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Aksi
                        </th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse($promotions as $promotion)
                        <tr class="hover:bg-gray-50">
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div>
                                    <div class="text-sm font-medium text-gray-900">{{ $promotion->name }}</div>
                                    <div class="text-sm text-gray-500">{{ $promotion->code }}</div>
                                    @if ($promotion->description)
                                        <div class="text-xs text-gray-400 mt-1">
                                            {{ Str::limit($promotion->description, 50) }}</div>
                                    @endif
                                </div>
                            </td>

                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="flex items-center">
                                    <span
                                        class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium {{ \App\Helpers\PromotionHelper::getPromotionBadgeClass($promotion) }}">
                                        {{ $promotionTypes[$promotion->type] ?? $promotion->type }}
                                    </span>
                                </div>
                                <div class="text-sm text-gray-600 mt-1">
                                    {{ \App\Helpers\PromotionHelper::formatPromotionDiscount($promotion) }}
                                </div>
                            </td>

                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm text-gray-900">
                                    @if ($promotion->applicable_products)
                                        <span class="text-blue-600">{{ count($promotion->applicable_products) }}
                                            Produk</span>
                                    @elseif($promotion->applicable_users)
                                        <span class="text-green-600">{{ count($promotion->applicable_users) }}
                                            User</span>
                                    @elseif($promotion->applicable_user_types)
                                        <span class="text-purple-600">{{ count($promotion->applicable_user_types) }}
                                            Tipe User</span>
                                    @else
                                        <span class="text-gray-600">Semua</span>
                                    @endif
                                </div>
                            </td>

                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm text-gray-900">
                                    @if ($promotion->start_date)
                                        {{ $promotion->start_date->format('d M Y') }}
                                    @else
                                        -
                                    @endif
                                </div>
                                <div class="text-sm text-gray-500">
                                    @if ($promotion->end_date)
                                        s/d {{ $promotion->end_date->format('d M Y') }}
                                    @else
                                        Tanpa batas
                                    @endif
                                </div>
                            </td>

                            <td class="px-6 py-4 whitespace-nowrap">
                                @php
                                    $status = \App\Helpers\PromotionHelper::getStatusBadge($promotion);
                                @endphp
                                <span
                                    class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium {{ $status['class'] }}">
                                    {{ $status['text'] }}
                                </span>
                            </td>

                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm text-gray-900">
                                    {{ $promotion->used_count }}
                                    @if (!$promotion->is_unlimited && $promotion->total_quota)
                                        / {{ $promotion->total_quota }}
                                    @endif
                                </div>
                                @if (!$promotion->is_unlimited && $promotion->total_quota)
                                    <div class="w-full bg-gray-200 rounded-full h-2 mt-1">
                                        <div class="bg-blue-600 h-2 rounded-full"
                                            style="width: {{ min(100, ($promotion->used_count / $promotion->total_quota) * 100) }}%">
                                        </div>
                                    </div>
                                @endif
                            </td>

                            <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                <div class="flex items-center justify-end space-x-2">
                                    {{-- Toggle Status --}}
                                    <button wire:click="toggleStatus('{{ $promotion->id }}')"
                                        class="text-indigo-600 hover:text-indigo-900"
                                        title="{{ $promotion->is_active ? 'Nonaktifkan' : 'Aktifkan' }}">
                                        <i class="fas fa-{{ $promotion->is_active ? 'toggle-on' : 'toggle-off' }}"></i>
                                    </button>

                                    {{-- Edit --}}
                                    <a href="{{ route('promotions.edit', $promotion->id) }}"
                                        class="text-indigo-600 hover:text-indigo-900" title="Edit">
                                        <i class="fas fa-edit"></i>
                                    </a>

                                    {{-- Detail --}}
                                    <a href="{{ route('promotions.detail') }}?id={{ $promotion->id }}"
                                        class="text-green-600 hover:text-green-900" title="Detail">
                                        <i class="fas fa-eye"></i>
                                    </a>

                                    {{-- Delete --}}
                                    <button wire:click="delete('{{ $promotion->id }}')"
                                        onclick="return confirm('Yakin ingin menghapus promosi ini?')"
                                        class="text-red-600 hover:text-red-900" title="Hapus">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="px-6 py-12 text-center">
                                <div class="text-gray-500">
                                    <i class="fas fa-tags text-4xl mb-4"></i>
                                    <h3 class="text-lg font-medium">Belum ada promosi</h3>
                                    <p class="mt-1">Mulai buat promosi pertama Anda untuk meningkatkan penjualan</p>
                                    <a href="{{ route('promotions.create') }}" class="btn btn-primary mt-4">
                                        <i class="fas fa-plus mr-2"></i>Buat Promosi
                                    </a>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{-- Pagination --}}
        @if ($promotions->hasPages())
            <div class="px-6 py-4 border-t border-gray-200">
                {{ $promotions->links() }}
            </div>
        @endif
    </div>

    {{-- Success Message --}}
    @if (session()->has('message'))
        <div class="fixed bottom-4 right-4 bg-green-500 text-white px-6 py-3 rounded-lg shadow-lg z-50">
            {{ session('message') }}
        </div>
    @endif

    {{-- Styles --}}
    <style>
        .form-control {
            @apply w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500;
        }

        .btn {
            @apply inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-offset-2;
        }

        .btn-primary {
            @apply text-white bg-blue-600 hover:bg-blue-700 focus:ring-blue-500;
        }
    </style>
</div>
