<div>
    <div class="mb-4">
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-2xl font-bold text-[#1E3A8A]">Stock Opname</h1>
            </div>
        </div>
    </div>

    
    <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-6">
        <div class="bg-gradient-to-br from-blue-500 to-blue-600 rounded-xl shadow-lg p-6 text-white">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-blue-100 text-sm font-medium">Total Stock Opname</p>
                    <h3 class="text-3xl font-bold mt-2"><?php echo e(number_format($this->totalStockOpname, 0, ',', '.')); ?></h3>
                </div>
                <div class="bg-white/20 rounded-full p-4">
                    <i class="fas fa-list text-2xl"></i>
                </div>
            </div>
        </div>

        <div class="bg-gradient-to-br from-red-500 to-red-600 rounded-xl shadow-lg p-6 text-white">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-red-100 text-sm font-medium">Total Loss Value</p>
                    <h3 class="text-2xl font-bold mt-2">Rp <?php echo e(number_format($this->totalLossValue, 0, ',', '.')); ?></h3>
                </div>
                <div class="bg-white/20 rounded-full p-4">
                    <i class="fas fa-minus-circle text-2xl"></i>
                </div>
            </div>
        </div>

        <div class="bg-gradient-to-br from-green-500 to-green-600 rounded-xl shadow-lg p-6 text-white">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-green-100 text-sm font-medium">Total Excess Value</p>
                    <h3 class="text-2xl font-bold mt-2">Rp <?php echo e(number_format($this->totalExcessValue, 0, ',', '.')); ?></h3>
                </div>
                <div class="bg-white/20 rounded-full p-4">
                    <i class="fas fa-plus-circle text-2xl"></i>
                </div>
            </div>
        </div>

        <div class="bg-gradient-to-br from-purple-500 to-purple-600 rounded-xl shadow-lg p-6 text-white">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-purple-100 text-sm font-medium">Net Value</p>
                    <h3 class="text-2xl font-bold mt-2">Rp <?php echo e(number_format($this->netValue, 0, ',', '.')); ?></h3>
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
            <div class="flex items-end md:col-start-4">
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
            <input type="text" class="mt-1 form-control-search" placeholder="Cari Sesuatu..."
                wire:model.live='search'>
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
                        <th>Tanggal</th>
                        <th>Total Loss Value</th>
                        <th>Total Excess Value</th>
                        <th>Total</th>
                        <th class="w-1 center">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__empty_5 = true; $__currentLoopData = $finances; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $finance): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_5 = false; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoopIteration(); ?><?php endif; ?>
                        <tr>
                            <td class="center"><?php echo e($finances->firstItem() + $index); ?></td>
                            <td><?php echo e($finance->code ?? '-'); ?></td>
                            <td><?php echo e($finance->date ? \Carbon\Carbon::parse($finance->date)->locale('id')->isoFormat('D MMMM Y') : '-'); ?>

                            </td>
                            <td><?php echo e($finance->total_loss_value ? 'Rp ' . number_format($finance->total_loss_value, 0, ',', '.') : '-'); ?>

                            </td>
                            <td><?php echo e($finance->total_excess_value ? 'Rp ' . number_format($finance->total_excess_value, 0, ',', '.') : '-'); ?>

                            </td>
                            <td><?php echo e($finance->grand_total ? 'Rp ' . number_format($finance->grand_total, 0, ',', '.') : '-'); ?>

                            </td>
                            <td class="center">
                                <div class="flex items-center">
                                    <button
                                        class="btn btn-icon text-blue-600 hover:text-blue-800 transition-colors edit-btn"
                                        wire:click="confirmDetail('<?php echo e($finance->id); ?>')">
                                        <i class="fa-solid fa-eye"></i>
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
                        class="font-medium"><?php echo e($finances->lastItem()); ?></span> dari <span
                        class="font-medium"><?php echo e($finances->total()); ?></span> hasil
                </div>
                <div>
                    <nav class="relative z-0 inline-flex rounded-md shadow-sm -space-x-px" aria-label="Pagination">
                        <?php echo e($finances->links('vendor.livewire.custom')); ?> <!-- Menampilkan pagination -->
                    </nav>
                </div>
            </div>
        </div>

    </div>
</div><?php /**PATH /Users/macbookair/Documents/mediction/mediction.id/resources/views/livewire/admin/finance/stock-opname/admin-finance-stock-opname-index.blade.php ENDPATH**/ ?>