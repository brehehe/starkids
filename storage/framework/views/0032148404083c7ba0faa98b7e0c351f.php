<div>
    <?php echo $__env->make('livewire.admin.logistic.dead-stock.admin-logistic-dead-stock-modal', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
    <div class="mb-4">
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-2xl font-bold text-[#1E3A8A]">Dead Stock</h1>
            </div>
            <div>
                <button wire:click="confirmSave()" class="btn btn-primary">
                    <!-- Font Awesome File Icon -->
                    <i class="fa-solid fa-file-lines text-xl me-1"></i>
                    Simpan Dead Stock
                </button>
            </div>
        </div>
    </div>
    <div class="bg-white/80 backdrop-blur-sm rounded-xl p-5 shadow-lg border border-gray-100 mb-6">
        <div class="grid grid-cols-1 gap-4">
            <div>
                <div class="flex items-center justify-between gap-4">
                    <input type="text" class="mt-1 form-control" placeholder="Cari SKU Number..."
                        wire:model.live='search_sku'>
                    <div>
                        <button wire:click="openModal()"
                            class="inline-flex items-center px-4 py-2 bg-green-600 text-white text-sm font-medium rounded-md shadow hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500 w-full">
                            <span class="fa-solid fa-box mr-3"></span>
                            Produk
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="bg-white/80 backdrop-blur-sm rounded-xl shadow-lg border border-gray-100 overflow-hidden mb-6">
        <div class="table-container">
            <table class="table">
                <thead>
                    <tr>
                        <th class="w-1 center">No</th>
                        <th>Sku Number</th>
                        <th>Nama Produk</th>
                        <th>Quantity Saat Ini</th>
                        <th>Quantity Rusak</th>
                        <th>Harga</th>
                        <th>Total</th>
                        <th class="w-1 center">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__empty_1 = true; $__currentLoopData = $deadStocks; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $deadStock): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoopIteration(); ?><?php endif; ?>
                        <tr>
                            <td class="w-1 center"><?php echo e($index + 1); ?></td>
                            <td><?php echo e($deadStock['sku_number']); ?></td>
                            <td><?php echo e($deadStock['name']); ?></td>
                            <td><?php echo e($deadStock['quantity_old']); ?></td>
                            <td>
                                <input type="text" style="width: 150px;"
                                    wire:model.live='deadStocks.<?php echo e($index); ?>.quantity' class="mt-1 form-control">
                            </td>
                            <td>Rp<?php echo e(number_format($deadStock['price'], 0, ',', '.')); ?></td>
                            <td>Rp<?php echo e(number_format($deadStock['total'], 0, ',', '.')); ?></td>
                            <td class="center">
                                <div class="flex items-center">
                                    <!-- Tombol Detail -->
                                    <button
                                        class="btn btn-icon text-red-600 hover:text-red-800 transition-colors edit-btn"
                                        wire:click="confirmDelete('<?php echo e($deadStock['id']); ?>')" aria-label="Lihat Detail">
                                        <i class="fas fa-trash text-red-600 text-lg"></i> <!-- FontAwesome Eye Icon -->
                                    </button>
                                </div>
                            </td>
                        </tr>
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
                        <tr>
                            <td colspan="10" class="no-data">Tidak ada data
                            </td>
                        </tr>
                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div><?php /**PATH /Users/macbookair/Documents/mediction/mediction.id/resources/views/livewire/admin/logistic/dead-stock/admin-logistic-dead-stock-index.blade.php ENDPATH**/ ?>