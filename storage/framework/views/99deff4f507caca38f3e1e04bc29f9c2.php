<div>
    <div class="mb-4">
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-2xl font-bold text-[#1E3A8A]">Keuangan</h1>
            </div>
            <div>
                <button wire:click="createFinance()" class="btn btn-primary">
                    <!-- Font Awesome File Icon -->
                    <i class="fa-solid fa-file-lines text-xl me-1"></i>
                    Buat Keuangan
                </button>
            </div>
        </div>
    </div>

    
    <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-6">
        <div class="bg-gradient-to-br from-blue-500 to-blue-600 rounded-xl shadow-lg p-6 text-white">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-blue-100 text-sm font-medium">Total Transaksi</p>
                    <h3 class="text-3xl font-bold mt-2"><?php echo e(number_format($this->totalCount, 0, ',', '.')); ?></h3>
                </div>
                <div class="bg-white/20 rounded-full p-4">
                    <i class="fas fa-receipt text-2xl"></i>
                </div>
            </div>
        </div>

        <div class="bg-gradient-to-br from-red-500 to-red-600 rounded-xl shadow-lg p-6 text-white">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-red-100 text-sm font-medium">Total Pengeluaran</p>
                    <h3 class="text-2xl font-bold mt-2">Rp <?php echo e(number_format($this->totalExpenditure, 0, ',', '.')); ?></h3>
                </div>
                <div class="bg-white/20 rounded-full p-4">
                    <i class="fas fa-arrow-down text-2xl"></i>
                </div>
            </div>
        </div>

        <div class="bg-gradient-to-br from-green-500 to-green-600 rounded-xl shadow-lg p-6 text-white">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-green-100 text-sm font-medium">Total Penerimaan</p>
                    <h3 class="text-2xl font-bold mt-2">Rp <?php echo e(number_format($this->totalReception, 0, ',', '.')); ?></h3>
                </div>
                <div class="bg-white/20 rounded-full p-4">
                    <i class="fas fa-arrow-up text-2xl"></i>
                </div>
            </div>
        </div>

        <div class="bg-gradient-to-br from-purple-500 to-purple-600 rounded-xl shadow-lg p-6 text-white">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-purple-100 text-sm font-medium">Pemindahan Dana</p>
                    <h3 class="text-2xl font-bold mt-2">Rp <?php echo e(number_format($this->totalFundTransfer, 0, ',', '.')); ?></h3>
                </div>
                <div class="bg-white/20 rounded-full p-4">
                    <i class="fas fa-exchange-alt text-2xl"></i>
                </div>
            </div>
        </div>
    </div>

    
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
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Tipe Transaksi</label>
                <select class="form-control" wire:model.live="type_filter">
                    <option value="">Semua Tipe</option>
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__currentLoopData = $finance_types; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $value): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoopIteration(); ?><?php endif; ?>
                        <option value="<?php echo e($key); ?>"><?php echo e($value); ?></option>
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
                </select>
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
    <div class="bg-white/80 backdrop-blur-sm rounded-xl shadow-lg border border-gray-100 overflow-hidden mb-6">
        <div class="table-container">
            <table class="table">
                <thead>
                    <tr>
                        <th class="w-1 center">No</th>
                        <th>Kode</th>
                        <th>Akun Biaya</th>
                        <th>Deskripsi</th>
                        <th>Tanggal</th>
                        <th>Total</th>
                        <th>Tipe</th>
                        <th class="w-1 center">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__empty_5 = true; $__currentLoopData = $finances; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $finance): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_5 = false; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoopIteration(); ?><?php endif; ?>
                    <tr>
                        <td class="center"><?php echo e($finances->firstItem() + $index); ?></td>
                        <td><?php echo e($finance->code ?? '-'); ?></td>
                        <td><?php echo e($finance->payments()->orderBy('order', 'asc')->first()->accountPayment->name ?? '-'); ?>

                        </td>
                        <td><?php echo e($finance->description ?? '-'); ?></td>
                        <td><?php echo e($finance->date ? \Carbon\Carbon::parse($finance->date)->locale('id')->isoFormat('D MMMM
                            Y') : '-'); ?>

                        </td>
                        <td><?php echo e($finance->grand_total ? 'Rp ' . number_format($finance->grand_total, 0, ',', '.') : '-'); ?>

                        </td>
                        <td><?php echo e($finance->type == 'expenditure' ? 'Pengeluaran' : ($finance->type == 'reception' ?
                            'Penerimaan' : 'Pemindahaan Dana')); ?>

                        </td>
                        <td class="center">
                            <div class="flex items-center">
                                <button
                                    class="btn btn-icon text-blue-600 hover:text-blue-800 transition-colors edit-btn"
                                    wire:click="editFinance('<?php echo e($finance->id); ?>')">
                                    <i class="fa-solid fa-eye"></i>
                                </button>
                                <button class="btn btn-icon text-red-600 hover:text-red-800 transition-colors edit-btn"
                                    wire:click="confirmDelete('<?php echo e($finance->id); ?>')">
                                    <i class="fa-solid fa-trash"></i>
                                </button>
                            </div>
                        </td>
                    </tr>
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_5): ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
                    <tr>
                        <td colspan="10" class="no-data">Tidak ada data
                        </td>
                    </tr>
                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        <div class="px-5 py-4 bg-gray-50/80 border-t border-gray-200">
            <div class="flex items-center justify-between">
                <div class="text-sm text-gray-700">
                    Menampilkan <span class="font-medium"><?php echo e($finances->firstItem()); ?></span> sampai <span
                        class="font-medium"><?php echo e($finances->lastItem()); ?></span> dari <span class="font-medium"><?php echo e($finances->total()); ?></span> hasil
                </div>
                <div>
                    <nav class="relative z-0 inline-flex rounded-md shadow-sm -space-x-px" aria-label="Pagination">
                        <?php echo e($finances->links('vendor.livewire.custom')); ?>

                        <!-- Menampilkan pagination -->
                    </nav>
                </div>
            </div>
        </div>

    </div>
</div><?php /**PATH /Users/macbookair/Documents/mediction/mediction.id/resources/views/livewire/admin/finance/finance/admin-finance-finance-index.blade.php ENDPATH**/ ?>