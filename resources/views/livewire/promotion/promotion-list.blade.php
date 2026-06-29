<div>
    <div class="mb-4">
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-2xl font-bold text-[#1E3A8A]">Promo</h1>
            </div>
            <div>
                <a href="{{ route('promotions.create') }}" class="btn btn-primary">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                    </svg>
                    Tambah Promo
                </a>
            </div>
        </div>
    </div>

    <!-- Filters and Search -->
    <div class="max-w-full">
        <div class="bg-white rounded-lg shadow-sm p-6 mb-6">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-4">
                <!-- Search -->
                <div class="md:col-span-2">
                    <label class="block text-sm font-medium text-gray-700 mb-2">Cari Promosi</label>
                    <input wire:model.live="search" type="text"
                        placeholder="Cari berdasarkan nama, kode, atau deskripsi..." class="form-control">
                </div>

                <!-- Type Filter -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Jenis Promosi</label>
                    <select wire:model.live="type" class="form-control">
                        <option value="">Semua Jenis</option>
                        @foreach ($promotionTypes as $typeOption)
                            <option value="{{ $typeOption['value'] }}">{{ $typeOption['label'] }}</option>
                        @endforeach
                    </select>
                </div>

                <!-- Status Filter -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Status</label>
                    <select wire:model.live="status" class="form-control">
                        <option value="">Semua Status</option>
                        <option value="active">Aktif</option>
                        <option value="inactive">Nonaktif</option>
                        <option value="expired">Expired</option>
                        <option value="upcoming">Akan Datang</option>
                    </select>
                </div>
            </div>

            <!-- Additional Filters -->
            <div class="flex flex-wrap items-center justify-between pt-4 border-t border-gray-200">
                <div class="flex items-center space-x-4">
                    <div class="flex items-center">
                        <label class="text-sm font-medium text-gray-700 mr-2">Tampilkan:</label>
                        <select wire:model.live="perPage" class="form-control">
                            <option value="10">10</option>
                            <option value="25">25</option>
                            <option value="50">50</option>
                            <option value="100">100</option>
                        </select>
                        <span class="ml-2 text-sm text-gray-500">per halaman</span>
                    </div>
                </div>

                <div class="flex items-center space-x-2">
                    <button wire:click="resetFilters" class="btn btn-warning">
                        <svg class="-ml-0.5 mr-1.5 h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15">
                            </path>
                        </svg>
                        Reset Filter
                    </button>
                </div>
            </div>
        </div>

        <!-- Promotions Table -->
        <div class="bg-white shadow-sm rounded-lg overflow-hidden">
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th wire:click="sortBy('name')"
                                class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider cursor-pointer hover:bg-gray-100">
                                <div class="flex items-center space-x-1">
                                    <span>Nama Promosi</span>
                                    @if ($sortBy === 'name')
                                        <svg class="w-4 h-4 {{ $sortDirection === 'asc' ? 'transform rotate-180' : '' }}"
                                            fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M19 9l-7 7-7-7"></path>
                                        </svg>
                                    @endif
                                </div>
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Jenis & Diskon
                            </th>
                            <th wire:click="sortBy('start_date')"
                                class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider cursor-pointer hover:bg-gray-100">
                                <div class="flex items-center space-x-1">
                                    <span>Periode</span>
                                    @if ($sortBy === 'start_date')
                                        <svg class="w-4 h-4 {{ $sortDirection === 'asc' ? 'transform rotate-180' : '' }}"
                                            fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M19 9l-7 7-7-7"></path>
                                        </svg>
                                    @endif
                                </div>
                            </th>
                            <th wire:click="sortBy('usage_count')"
                                class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider cursor-pointer hover:bg-gray-100">
                                <div class="flex items-center space-x-1">
                                    <span>Penggunaan</span>
                                    @if ($sortBy === 'usage_count')
                                        <svg class="w-4 h-4 {{ $sortDirection === 'asc' ? 'transform rotate-180' : '' }}"
                                            fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M19 9l-7 7-7-7"></path>
                                        </svg>
                                    @endif
                                </div>
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Status
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
                                    <div class="flex items-center">
                                        <div>
                                            <div class="text-sm font-medium text-gray-900">
                                                {{ $promotion->name }}
                                            </div>
                                            @if ($promotion->code)
                                                <div class="text-sm text-gray-500">
                                                    Kode: {{ $promotion->code }}
                                                </div>
                                            @endif
                                            @if ($promotion->description)
                                                <div class="text-xs text-gray-400 mt-1">
                                                    {{ Str::limit($promotion->description, 50) }}
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm text-gray-900">
                                        <span
                                            class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                            {{ ucfirst(str_replace('_', ' ', $promotion->type)) }}
                                        </span>
                                    </div>
                                    <div class="text-sm text-gray-500 mt-1">
                                        @if ($promotion->type === 'percentage')
                                            {{ $promotion->discount_value }}% off
                                        @elseif($promotion->type === 'fixed_amount')
                                            Rp {{ number_format($promotion->discount_value, 0, ',', '.') }} off
                                        @elseif($promotion->type === 'buy_x_get_y')
                                            Beli {{ $promotion->buy_quantity }} Gratis {{ $promotion->get_quantity }}
                                        @else
                                            {{ $promotion->type }}
                                        @endif
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                    <div>{{ $promotion->start_date->format('d M Y') }}</div>
                                    <div class="text-xs text-gray-500">sampai
                                        {{ $promotion->end_date->format('d M Y') }}</div>
                                    <div
                                        class="text-xs {{ $promotion->end_date->isPast() ? 'text-red-500' : 'text-green-500' }}">
                                        @if ($promotion->end_date->isPast())
                                            Expired
                                        @elseif($promotion->start_date->isFuture())
                                            {{ $promotion->start_date->diffForHumans() }}
                                        @else
                                            {{ $promotion->end_date->diffForHumans() }}
                                        @endif
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                    <div class="flex items-center">
                                        <div class="text-lg font-semibold">{{ $promotion->usage_histories_count }}
                                        </div>
                                        @if ($promotion->usage_limit)
                                            <div class="ml-2 text-xs text-gray-500">/ {{ $promotion->usage_limit }}
                                            </div>
                                        @endif
                                    </div>
                                    @if ($promotion->usage_limit)
                                        <div class="w-full bg-gray-200 rounded-full h-1.5 mt-1">
                                            <div class="bg-blue-600 h-1.5 rounded-full"
                                                style="width: {{ min(($promotion->usage_histories_count / $promotion->usage_limit) * 100, 100) }}%">
                                            </div>
                                        </div>
                                    @endif
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="flex flex-col space-y-1">
                                        @if ($promotion->is_active && $promotion->start_date->isPast() && $promotion->end_date->isFuture())
                                            <span
                                                class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                                Aktif
                                            </span>
                                        @elseif(!$promotion->is_active)
                                            <span
                                                class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-gray-100 text-gray-800">
                                                Nonaktif
                                            </span>
                                        @elseif($promotion->end_date->isPast())
                                            <span
                                                class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800">
                                                Expired
                                            </span>
                                        @else
                                            <span
                                                class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800">
                                                Akan Datang
                                            </span>
                                        @endif

                                        @if ($promotion->auto_apply)
                                            <span
                                                class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-purple-100 text-purple-800">
                                                Auto Apply
                                            </span>
                                        @endif
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                    <div class="flex items-center justify-end space-x-2">
                                        <!-- View Button -->
                                        {{-- <a href="{{ route('promotions.show', $promotion->id) }}"
                                            class="text-indigo-600 hover:text-indigo-900">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z">
                                                </path>
                                            </svg>
                                        </a> --}}

                                        <!-- Edit Button -->
                                        <a href="{{ route('user.promotion.edit', $promotion->id) }}"
                                            class="text-gray-600 hover:text-gray-900">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z">
                                                </path>
                                            </svg>
                                        </a>

                                        <!-- Toggle Status Button -->
                                        <button wire:click="toggleStatus({{ $promotion->id }})"
                                            class="text-{{ $promotion->is_active ? 'yellow' : 'green' }}-600 hover:text-{{ $promotion->is_active ? 'yellow' : 'green' }}-900">
                                            @if ($promotion->is_active)
                                                <svg class="w-5 h-5" fill="none" stroke="currentColor"
                                                    viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        stroke-width="2"
                                                        d="M10 9v6m4-6v6m7-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                                </svg>
                                            @else
                                                <svg class="w-5 h-5" fill="none" stroke="currentColor"
                                                    viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        stroke-width="2"
                                                        d="M14.828 14.828a4 4 0 01-5.656 0M9 10h1m4 0h1m-6 4h1m4 0h1m2-7a9 9 0 11-18 0 9 9 0 0118 0z">
                                                    </path>
                                                </svg>
                                            @endif
                                        </button>

                                        <!-- Delete Button -->
                                        <button wire:click="deletePromotion({{ $promotion->id }})"
                                            wire:confirm="Apakah Anda yakin ingin menghapus promosi ini?"
                                            class="text-red-600 hover:text-red-900">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16">
                                                </path>
                                            </svg>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="p-6">
                                    <div class="flex flex-col items-center">
                                        <svg class="w-12 h-12 text-gray-400 mb-4" fill="none"
                                            stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4">
                                            </path>
                                        </svg>
                                        <h3 class="text-lg font-medium text-gray-900 mb-2">Tidak ada promosi ditemukan
                                        </h3>
                                        <p class="text-gray-500 mb-4">Mulai dengan membuat promosi pertama Anda</p>
                                        <a href="{{ route('promotions.create') }}" class="btn btn-primary">
                                            Buat Promosi Baru
                                        </a>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            @if ($promotions->hasPages())
                <div class="bg-white px-4 py-3 border-t border-gray-200 sm:px-6">
                    {{ $promotions->links() }}
                </div>
            @endif
        </div>
    </div>
</div>

@push('scripts')
    <script>
        // Handle promotion events
        Livewire.on('promotion-updated', (data) => {
            // Show success notification
            showNotification(data[0].message, data[0].type);
        });

        Livewire.on('promotion-deleted', (data) => {
            showNotification(data[0].message, data[0].type);
        });

        Livewire.on('promotion-error', (data) => {
            showNotification(data[0].message, data[0].type);
        });

        function showNotification(message, type) {
            // Implement your notification system here
            alert(message);
        }
    </script>
@endpush
