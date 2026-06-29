<div>
    <div class="mb-4">
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-2xl font-bold text-[#1E3A8A]">Jurnal Umum</h1>
            </div>
            <div>
                <a href="<?php echo e(route('user.finance.general-journal.detail')); ?>" class="btn btn-primary">
                    <i class="fas fa-plus mr-2"></i> Tambah Jurnal Umum
                </a>
            </div>
        </div>
    </div>

    
    <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-6">
        <div class="bg-gradient-to-br from-blue-500 to-blue-600 rounded-xl shadow-lg p-6 text-white">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-blue-100 text-sm font-medium">Total Jurnal</p>
                    <h3 class="text-3xl font-bold mt-2"><?php echo e(number_format($this->totalJournals, 0, ',', '.')); ?></h3>
                </div>
                <div class="bg-white/20 rounded-full p-4">
                    <i class="fas fa-book text-2xl"></i>
                </div>
            </div>
        </div>

        <div class="bg-gradient-to-br from-green-500 to-green-600 rounded-xl shadow-lg p-6 text-white">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-green-100 text-sm font-medium">Total Debit</p>
                    <h3 class="text-2xl font-bold mt-2">Rp <?php echo e(number_format($this->totalDebit, 0, ',', '.')); ?></h3>
                </div>
                <div class="bg-white/20 rounded-full p-4">
                    <i class="fas fa-plus-circle text-2xl"></i>
                </div>
            </div>
        </div>

        <div class="bg-gradient-to-br from-red-500 to-red-600 rounded-xl shadow-lg p-6 text-white">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-red-100 text-sm font-medium">Total Kredit</p>
                    <h3 class="text-2xl font-bold mt-2">Rp <?php echo e(number_format($this->totalCredit, 0, ',', '.')); ?></h3>
                </div>
                <div class="bg-white/20 rounded-full p-4">
                    <i class="fas fa-minus-circle text-2xl"></i>
                </div>
            </div>
        </div>

        <div class="bg-gradient-to-br from-purple-500 to-purple-600 rounded-xl shadow-lg p-6 text-white">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-purple-100 text-sm font-medium">Saldo</p>
                    <h3 class="text-2xl font-bold mt-2">Rp <?php echo e(number_format($this->balance, 0, ',', '.')); ?></h3>
                </div>
                <div class="bg-white/20 rounded-full p-4">
                    <i class="fas fa-balance-scale text-2xl"></i>
                </div>
            </div>
        </div>
    </div>

    
    <div class="bg-white/80 backdrop-blur-sm rounded-xl shadow-lg border border-gray-100 p-4 mb-4">
        <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Dari Tanggal</label>
                <input type="date" wire:model.live="start_date" class="form-control" />
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Sampai Tanggal</label>
                <input type="date" wire:model.live="end_date" class="form-control" />
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Cari</label>
                <div class="relative">
                    <input type="text" class="form-control pl-10" placeholder="Cari kode atau deskripsi..." wire:model.live='search'>
                    <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                        <i class="fas fa-search text-gray-400"></i>
                    </div>
                </div>
            </div>
            <div class="flex items-end">
                <button wire:click="resetFilters" class="btn btn-secondary w-full">
                    <i class="fas fa-redo mr-2"></i> Reset Filter
                </button>
            </div>
        </div>
    </div>

    
    <div class="flex items-center justify-between mb-4">
        <div class="flex items-center">
            <span class="text-sm text-gray-700 mr-2">Tampil</span>
            <select class="form-control" wire:model.live='perPage'>
                <option value="5">5</option>
                <option value="10">10</option>
                <option value="25">25</option>
                <option value="50">50</option>
                <option value="100">100</option>
            </select>
            <span class="text-sm text-gray-700 ml-2">data</span>
        </div>
        <div class="text-sm text-gray-700">
            Total: <span class="font-medium"><?php echo e($journals->total()); ?></span> jurnal
        </div>
    </div>

    
    <div class="space-y-4 mb-6">
        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__empty_5 = true; $__currentLoopData = $journals; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $journal): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_5 = false; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoopIteration(); ?><?php endif; ?>
            <div x-data="{ expanded: false }" class="bg-white rounded-xl shadow-lg border border-gray-100 overflow-hidden transition-all duration-300 hover:shadow-xl">
                
                <div @click="expanded = !expanded" class="cursor-pointer p-6 hover:bg-gray-50 transition-colors">
                    <div class="flex items-center justify-between">
                        <div class="flex-1 grid grid-cols-1 md:grid-cols-4 gap-4">
                            
                            <div class="flex items-center space-x-3">
                                <div class="flex-shrink-0 w-10 h-10 bg-blue-100 rounded-full flex items-center justify-center">
                                    <span class="text-blue-600 font-bold text-sm"><?php echo e($journals->firstItem() + $index); ?></span>
                                </div>
                                <div>
                                    <p class="text-xs text-gray-500">Kode Jurnal</p>
                                    <p class="font-semibold text-gray-900"><?php echo e($journal->code ?? '-'); ?></p>
                                </div>
                            </div>

                            
                            <div>
                                <p class="text-xs text-gray-500">Tanggal</p>
                                <p class="font-medium text-gray-900">
                                    <i class="far fa-calendar text-gray-400 mr-1"></i>
                                    <?php echo e($journal->date ? \Carbon\Carbon::parse($journal->date)->locale('id')->isoFormat('D MMM Y') : '-'); ?>

                                </p>
                            </div>

                            
                            <div class="md:col-span-1">
                                <p class="text-xs text-gray-500">Deskripsi</p>
                                <p class="font-medium text-gray-900 truncate" title="<?php echo e($journal->description ?? '-'); ?>">
                                    <?php echo e($journal->description ?? '-'); ?>

                                </p>
                            </div>

                            
                            <div>
                                <p class="text-xs text-gray-500">Total Transaksi</p>
                                <div class="flex items-center space-x-2">
                                    <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                        <i class="fas fa-arrow-up mr-1"></i>
                                        Rp<?php echo e(number_format($journal->items->sum(fn($item) => $item->accountTransaction->debit ?? 0), 0, ',', '.')); ?>

                                    </span>
                                    <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-red-100 text-red-800">
                                        <i class="fas fa-arrow-down mr-1"></i>
                                        Rp<?php echo e(number_format($journal->items->sum(fn($item) => $item->accountTransaction->credit ?? 0), 0, ',', '.')); ?>

                                    </span>
                                </div>
                            </div>
                        </div>

                        
                        <div class="ml-4">
                            <i :class="expanded ? 'fa-chevron-up' : 'fa-chevron-down'" class="fas text-gray-400 transition-transform duration-300"></i>
                        </div>
                    </div>
                </div>

                
                <div x-show="expanded"
                     x-collapse
                     class="border-t border-gray-200 bg-gray-50">
                    <div class="p-6">
                        <div class="flex justify-between items-center mb-4">
                            <h4 class="text-sm font-semibold text-gray-700 flex items-center">
                                <i class="fas fa-list-ul mr-2 text-blue-600"></i>
                                Detail Transaksi
                            </h4>
                            <div class="flex gap-2">
                                <a href="<?php echo e(route('user.finance.general-journal.detail', ['id' => $journal->id])); ?>" class="btn btn-sm btn-warning">
                                    <i class="fas fa-edit mr-1"></i> Edit
                                </a>
                                <button wire:click="delete('<?php echo e($journal->id); ?>')"
                                        wire:confirm="Apakah Anda yakin ingin menghapus jurnal ini?"
                                        class="btn btn-sm btn-danger">
                                    <i class="fas fa-trash mr-1"></i> Hapus
                                </button>
                            </div>
                        </div>

                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($journal->items->count() > 0): ?>
                            <div class="space-y-3">
                                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__currentLoopData = $journal->items; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoopIteration(); ?><?php endif; ?>
                                    <div class="bg-white rounded-lg p-4 shadow-sm border border-gray-200 hover:border-blue-300 transition-colors">
                                        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                                            
                                            <div class="md:col-span-1">
                                                <p class="text-xs text-gray-500 mb-1">Akun</p>
                                                <p class="font-medium text-gray-900">
                                                    <i class="fas fa-wallet text-blue-500 mr-2"></i>
                                                    <?php echo e($item->account->name ?? '-'); ?>

                                                </p>
                                            </div>

                                            
                                            <div>
                                                <p class="text-xs text-gray-500 mb-1">Debit</p>
                                                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($item->accountTransaction->debit): ?>
                                                    <p class="font-semibold text-green-600">
                                                        <i class="fas fa-plus-circle mr-1"></i>
                                                        Rp <?php echo e(number_format($item->accountTransaction->debit, 0, ',', '.')); ?>

                                                    </p>
                                                <?php else: ?>
                                                    <p class="text-gray-400">-</p>
                                                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                            </div>

                                            
                                            <div>
                                                <p class="text-xs text-gray-500 mb-1">Kredit</p>
                                                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($item->accountTransaction->credit): ?>
                                                    <p class="font-semibold text-red-600">
                                                        <i class="fas fa-minus-circle mr-1"></i>
                                                        Rp <?php echo e(number_format($item->accountTransaction->credit, 0, ',', '.')); ?>

                                                    </p>
                                                <?php else: ?>
                                                    <p class="text-gray-400">-</p>
                                                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                            </div>
                                        </div>
                                    </div>
                                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
                            </div>

                            
                            <div class="mt-4 pt-4 border-t border-gray-300">
                                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                                    <div class="md:col-span-1">
                                        <p class="font-semibold text-gray-700">Total</p>
                                    </div>
                                    <div>
                                        <p class="font-bold text-green-700 text-lg">
                                            Rp<?php echo e(number_format($journal->items->sum(fn($item) => $item->accountTransaction->debit ?? 0), 0, ',', '.')); ?>

                                        </p>
                                    </div>
                                    <div>
                                        <p class="font-bold text-red-700 text-lg">
                                            Rp<?php echo e(number_format($journal->items->sum(fn($item) => $item->accountTransaction->credit ?? 0), 0, ',', '.')); ?>

                                        </p>
                                    </div>
                                </div>
                            </div>
                        <?php else: ?>
                            <p class="text-gray-500 text-center py-4">Tidak ada detail transaksi</p>
                        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                    </div>
                </div>
            </div>
        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_5): ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
            <div class="bg-white rounded-xl shadow-lg border border-gray-100 p-12 text-center">
                <i class="fas fa-inbox text-gray-300 text-6xl mb-4"></i>
                <p class="text-gray-500 text-lg">Tidak ada data jurnal umum</p>
                <p class="text-gray-400 text-sm mt-2">Coba ubah filter atau rentang tanggal</p>
            </div>
        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
    </div>

    
    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($journals->hasPages()): ?>
        <div class="bg-white rounded-xl shadow-lg border border-gray-100 p-5">
            <div class="flex items-center justify-between">
                <div class="text-sm text-gray-700">
                    Menampilkan <span class="font-medium"><?php echo e($journals->firstItem()); ?></span> sampai
                    <span class="font-medium"><?php echo e($journals->lastItem()); ?></span> dari
                    <span class="font-medium"><?php echo e($journals->total()); ?></span> hasil
                </div>
                <div>
                    <nav class="relative z-0 inline-flex rounded-md shadow-sm -space-x-px" aria-label="Pagination">
                        <?php echo e($journals->links('vendor.livewire.custom')); ?>

                    </nav>
                </div>
            </div>
        </div>
    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
</div><?php /**PATH /Users/macbookair/Documents/mediction/mediction.id/resources/views/livewire/admin/finance/general-journal/admin-finance-general-journal-index.blade.php ENDPATH**/ ?>