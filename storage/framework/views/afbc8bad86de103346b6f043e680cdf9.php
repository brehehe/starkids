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

    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(session()->has('message')): ?>
        <div class="bg-green-100 border border-green-200 text-green-700 px-4 py-3 rounded relative mb-4" role="alert">
            <span class="block sm:inline"><?php echo e(session('message')); ?></span>
        </div>
    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

    <div class="bg-white rounded-xl border border-gray-100 shadow-sm overflow-hidden">
        <!-- Tabs & Search -->
        <div class="p-4 border-b border-gray-100 flex flex-col sm:flex-row justify-between gap-4">
            <div class="flex space-x-1 bg-gray-50 p-1 rounded-lg self-start">
                <button wire:click="setStatus('unread')"
                    class="px-4 py-1.5 text-sm font-medium rounded-md transition-all duration-200 <?php echo e($status === 'unread' ? 'bg-white text-[#1E3A8A] shadow-sm' : 'text-gray-500 hover:text-gray-700'); ?>">
                    Belum Dibaca
                </button>
                <button wire:click="setStatus('read')"
                    class="px-4 py-1.5 text-sm font-medium rounded-md transition-all duration-200 <?php echo e($status === 'read' ? 'bg-white text-[#1E3A8A] shadow-sm' : 'text-gray-500 hover:text-gray-700'); ?>">
                    Sudah Dibaca
                </button>
                 <button wire:click="setStatus('all')"
                    class="px-4 py-1.5 text-sm font-medium rounded-md transition-all duration-200 <?php echo e($status === 'all' ? 'bg-white text-[#1E3A8A] shadow-sm' : 'text-gray-500 hover:text-gray-700'); ?>">
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
            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__empty_5 = true; $__currentLoopData = $notifications; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $notification): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_5 = false; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoopIteration(); ?><?php endif; ?>
                <div class="p-4 hover:bg-gray-50 transition-colors <?php echo e(!$notification->is_read ? 'bg-blue-50/30' : ''); ?>">
                    <div class="flex items-start gap-4">
                        <div class="flex-shrink-0 mt-1">
                             <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($notification->type === 'product_expiry'): ?>
                                <div class="w-10 h-10 rounded-full bg-red-100 flex items-center justify-center text-red-600">
                                    <i class="fas fa-box"></i>
                                </div>
                             <?php elseif($notification->type === 'pending_payment'): ?>
                                <div class="w-10 h-10 rounded-full bg-orange-100 flex items-center justify-center text-orange-600">
                                    <i class="fas fa-file-invoice-dollar"></i>
                                </div>
                             <?php elseif($notification->type === 'defecta'): ?>
                                <div class="w-10 h-10 rounded-full bg-yellow-100 flex items-center justify-center text-yellow-600">
                                    <i class="fas fa-exclamation-triangle"></i>
                                </div>
                             <?php else: ?>
                                <div class="w-10 h-10 rounded-full bg-blue-100 flex items-center justify-center text-blue-600">
                                    <i class="fas fa-bell"></i>
                                </div>
                             <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                        </div>
                        <div class="flex-1 min-w-0">
                            <div class="flex justify-between items-start">
                                <h3 class="text-sm font-semibold text-gray-900 <?php echo e(!$notification->is_read ? 'text-[#1E3A8A]' : ''); ?>">
                                    <?php echo e($notification->title); ?>

                                </h3>
                                <span class="text-xs text-gray-500 whitespace-nowrap ml-2">
                                    <?php echo e($notification->created_at->diffForHumans()); ?>

                                </span>
                            </div>
                            <p class="text-sm text-gray-600 mt-1">
                                <?php echo e($notification->message); ?>

                            </p>

                            <div class="mt-3 flex items-center gap-3">
                                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(isset($notification->data['action_url'])): ?>
                                    <a href="<?php echo e(url($notification->data['action_url'])); ?>" class="text-xs font-medium text-blue-600 hover:text-blue-800 flex items-center gap-1">
                                        Lihat Detail <i class="fas fa-arrow-right"></i>
                                    </a>
                                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

                                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(!$notification->is_read): ?>
                                    <button wire:click="markAsRead('<?php echo e($notification->id); ?>')" class="text-xs font-medium text-gray-500 hover:text-gray-700">
                                        Tandai Dibaca
                                    </button>
                                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                            </div>
                        </div>
                    </div>
                </div>
            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_5): ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
                <div class="p-12 text-center">
                    <div class="w-16 h-16 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-4 text-gray-400">
                        <i class="fas fa-bell-slash text-2xl"></i>
                    </div>
                    <h3 class="text-lg font-medium text-gray-900">Tidak ada notifikasi</h3>
                    <p class="text-gray-500 mt-1">Belum ada notifikasi yang sesuai dengan filter ini.</p>
                </div>
            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
        </div>

        <!-- Pagination -->
        <div class="p-4 border-t border-gray-100">
            <?php echo e($notifications->links()); ?>

        </div>
    </div>
</div><?php /**PATH /Users/macbookair/Documents/mediction/mediction.id/resources/views/livewire/admin/notification/admin-notification-index.blade.php ENDPATH**/ ?>