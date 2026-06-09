<div>
    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center mb-6 gap-4">
        <div>
            <h1 class="text-2xl font-bold text-[#1E3A8A]">Notifikasi</h1>
            <p class="text-gray-500 text-sm mt-1">Kelola dan cek semua notifikasi sistem</p>
        </div>
        <div class="flex gap-2">
             <button wire:click="runCheck"
                class="flex items-center gap-2 px-4 py-2 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700 transition-colors shadow-sm text-sm font-medium">
                <i class="fas fa-sync-alt"></i>
                Cek Notifikasi Baru
            </button>
            <button wire:click="markAllRead"
                class="flex items-center gap-2 px-4 py-2 bg-white border border-gray-200 text-gray-700 rounded-lg hover:bg-gray-50 transition-colors shadow-sm text-sm font-medium">
                <i class="fas fa-check-double"></i>
                Tandai Semua Dibaca
            </button>
            <button wire:click="deleteAll"
                wire:confirm="Apakah Anda yakin ingin menghapus semua notifikasi? Tindakan ini tidak dapat dibatalkan."
                class="flex items-center gap-2 px-4 py-2 bg-white border border-red-200 text-red-600 rounded-lg hover:bg-red-50 transition-colors shadow-sm text-sm font-medium">
                <i class="fas fa-trash-alt"></i>
                Hapus Semua
            </button>
        </div>
    </div>

    @if (session()->has('message'))
        <div class="bg-green-100 border border-green-200 text-green-700 px-4 py-3 rounded relative mb-4" role="alert">
            <span class="block sm:inline">{{ session('message') }}</span>
        </div>
    @endif

    <div class="bg-white rounded-xl border border-gray-100 shadow-sm overflow-hidden">
        <!-- Tabs & Search -->
        <div class="p-4 border-b border-gray-100 flex flex-col sm:flex-row justify-between gap-4">
            <div class="flex space-x-1 bg-gray-50 p-1 rounded-lg self-start">
                <button wire:click="setStatus('unread')"
                    class="px-4 py-1.5 text-sm font-medium rounded-md transition-all duration-200 {{ $status === 'unread' ? 'bg-white text-[#1E3A8A] shadow-sm' : 'text-gray-500 hover:text-gray-700' }}">
                    Belum Dibaca
                </button>
                <button wire:click="setStatus('read')"
                    class="px-4 py-1.5 text-sm font-medium rounded-md transition-all duration-200 {{ $status === 'read' ? 'bg-white text-[#1E3A8A] shadow-sm' : 'text-gray-500 hover:text-gray-700' }}">
                    Sudah Dibaca
                </button>
                 <button wire:click="setStatus('all')"
                    class="px-4 py-1.5 text-sm font-medium rounded-md transition-all duration-200 {{ $status === 'all' ? 'bg-white text-[#1E3A8A] shadow-sm' : 'text-gray-500 hover:text-gray-700' }}">
                    Semua
                </button>
            </div>

            <div class="relative w-full sm:w-64">
                <input type="text" wire:model.live.debounce.300ms="search"
                    class="w-full pl-10 pr-4 py-2 rounded-lg border border-gray-200 focus:border-[#1E3A8A] focus:ring-0 text-sm"
                    placeholder="Cari notifikasi...">
                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                    <i class="fas fa-search text-gray-400"></i>
                </div>
            </div>
        </div>

        <!-- Notification List -->
        <div class="divide-y divide-gray-100">
            @forelse($notifications as $notification)
                <div class="p-4 hover:bg-gray-50 transition-colors {{ !$notification->is_read ? 'bg-blue-50/30' : '' }}">
                    <div class="flex items-start gap-4">
                        <div class="flex-shrink-0 mt-1">
                             @if($notification->type === 'product_expiry')
                                <div class="w-10 h-10 rounded-full bg-red-100 flex items-center justify-center text-red-600">
                                    <i class="fas fa-box"></i>
                                </div>
                             @elseif($notification->type === 'pending_payment')
                                <div class="w-10 h-10 rounded-full bg-orange-100 flex items-center justify-center text-orange-600">
                                    <i class="fas fa-file-invoice-dollar"></i>
                                </div>
                             @elseif($notification->type === 'defecta')
                                <div class="w-10 h-10 rounded-full bg-yellow-100 flex items-center justify-center text-yellow-600">
                                    <i class="fas fa-exclamation-triangle"></i>
                                </div>
                             @else
                                <div class="w-10 h-10 rounded-full bg-blue-100 flex items-center justify-center text-blue-600">
                                    <i class="fas fa-bell"></i>
                                </div>
                             @endif
                        </div>
                        <div class="flex-1 min-w-0">
                            <div class="flex justify-between items-start">
                                <h3 class="text-sm font-semibold text-gray-900 {{ !$notification->is_read ? 'text-[#1E3A8A]' : '' }}">
                                    {{ $notification->title }}
                                </h3>
                                <span class="text-xs text-gray-500 whitespace-nowrap ml-2">
                                    {{ $notification->created_at->diffForHumans() }}
                                </span>
                            </div>
                            <p class="text-sm text-gray-600 mt-1">
                                {{ $notification->message }}
                            </p>

                            <div class="mt-3 flex items-center gap-3">
                                @if(isset($notification->data['action_url']))
                                    <a href="{{ url($notification->data['action_url']) }}" class="text-xs font-medium text-blue-600 hover:text-blue-800 flex items-center gap-1">
                                        Lihat Detail <i class="fas fa-arrow-right"></i>
                                    </a>
                                @endif

                                @if(!$notification->is_read)
                                    <button wire:click="markAsRead('{{ $notification->id }}')" class="text-xs font-medium text-gray-500 hover:text-gray-700">
                                        Tandai Dibaca
                                    </button>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            @empty
                <div class="p-12 text-center">
                    <div class="w-16 h-16 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-4 text-gray-400">
                        <i class="fas fa-bell-slash text-2xl"></i>
                    </div>
                    <h3 class="text-lg font-medium text-gray-900">Tidak ada notifikasi</h3>
                    <p class="text-gray-500 mt-1">Belum ada notifikasi yang sesuai dengan filter ini.</p>
                </div>
            @endforelse
        </div>

        <!-- Pagination -->
        <div class="p-4 border-t border-gray-100">
            {{ $notifications->links() }}
        </div>
    </div>
</div>
