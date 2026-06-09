<div>
    <div class="mb-4">
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-2xl font-bold text-[#1E3A8A]">System Updates</h1>
                <p class="text-gray-600 text-sm mt-1">Kelola informasi update sistem</p>
            </div>
            <button wire:click="createUpdate" class="btn btn-primary">
                <i class="fas fa-plus mr-2"></i>
                Buat Update Baru
            </button>
        </div>
    </div>

    {{-- Search & Filter --}}
    <div class="bg-white/80 backdrop-blur-sm rounded-xl shadow-lg border border-gray-100 p-4 mb-4">
        <div class="flex items-center justify-between gap-4">
            <div class="flex items-center">
                <span class="text-sm text-gray-700 mr-2">Tampil</span>
                <select class="form-control" wire:model.live='perPage'>
                    <option value="5">5</option>
                    <option value="10">10</option>
                    <option value="25">25</option>
                    <option value="50">50</option>
                </select>
                <span class="text-sm text-gray-700 ml-2">data</span>
            </div>
            <div class="relative flex-1 max-w-md">
                <input type="text" class="form-control pl-10" placeholder="Cari update..." wire:model.live='search'>
                <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                    <i class="fas fa-search text-gray-400"></i>
                </div>
            </div>
        </div>
    </div>

    {{-- Updates List --}}
    <div class="space-y-4 mb-6">
        @forelse ($updates as $update)
            <div class="bg-white rounded-xl shadow-lg border border-gray-100 overflow-hidden hover:shadow-xl transition-shadow">
                <div class="p-6">
                    <div class="flex items-start justify-between">
                        <div class="flex-1">
                            <div class="flex items-center gap-3 mb-3">
                                <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-{{ $update->typeColor }}-100 text-{{ $update->typeColor }}-800">
                                    <i class="fas {{ $update->typeIcon }} mr-2"></i>
                                    {{ $types[$update->type] ?? $update->type }}
                                </span>
                                @if($update->is_active)
                                    <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                        <i class="fas fa-check-circle mr-1"></i>
                                        Aktif
                                    </span>
                                @else
                                    <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-gray-100 text-gray-800">
                                        <i class="fas fa-times-circle mr-1"></i>
                                        Tidak Aktif
                                    </span>
                                @endif
                            </div>

                            <h3 class="text-lg font-semibold text-gray-900 mb-2">{{ $update->title }}</h3>
                            <p class="text-gray-600 mb-3">{{ Str::limit($update->content, 200) }}</p>

                            <div class="flex items-center text-sm text-gray-500">
                                <i class="far fa-calendar mr-2"></i>
                                Dipublikasi: {{ $update->published_at?->locale('id')->isoFormat('D MMMM Y, HH:mm') ?? '-' }}
                            </div>
                        </div>

                        <div class="flex items-center gap-2 ml-4">
                            <button
                                wire:click="toggleActive('{{ $update->id }}')"
                                class="btn btn-icon {{ $update->is_active ? 'text-gray-600' : 'text-green-600' }} hover:bg-gray-100"
                                title="{{ $update->is_active ? 'Nonaktifkan' : 'Aktifkan' }}">
                                <i class="fas fa-{{ $update->is_active ? 'eye-slash' : 'eye' }}"></i>
                            </button>
                            <button
                                wire:click="editUpdate('{{ $update->id }}')"
                                class="btn btn-icon text-blue-600 hover:bg-blue-50">
                                <i class="fas fa-edit"></i>
                            </button>
                            <button
                                wire:click="confirmDelete('{{ $update->id }}')"
                                class="btn btn-icon text-red-600 hover:bg-red-50">
                                <i class="fas fa-trash"></i>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        @empty
            <div class="bg-white rounded-xl shadow-lg border border-gray-100 p-12 text-center">
                <i class="fas fa-inbox text-gray-300 text-6xl mb-4"></i>
                <p class="text-gray-500 text-lg">Belum ada update sistem</p>
                <p class="text-gray-400 text-sm mt-2">Klik tombol "Buat Update Baru" untuk menambahkan</p>
            </div>
        @endforelse
    </div>

    {{-- Pagination --}}
    @if($updates->hasPages())
        <div class="bg-white rounded-xl shadow-lg border border-gray-100 p-5">
            <div class="flex items-center justify-between">
                <div class="text-sm text-gray-700">
                    Menampilkan <span class="font-medium">{{ $updates->firstItem() }}</span> sampai
                    <span class="font-medium">{{ $updates->lastItem() }}</span> dari
                    <span class="font-medium">{{ $updates->total() }}</span> hasil
                </div>
                <div>
                    <nav class="relative z-0 inline-flex rounded-md shadow-sm -space-x-px">
                        {{ $updates->links('vendor.livewire.custom') }}
                    </nav>
                </div>
            </div>
        </div>
    @endif
</div>
