<div>
    <?php echo $__env->make('livewire.admin.purchase.draft.mail-order.admin-purchase-draft-mail-order-modal', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
    <div class="mb-4">
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-2xl font-bold text-[#1E3A8A]">Draft Surat Pesanan</h1>
            </div>
            <div>
                <button wire:click="openModal('modal')" class="btn btn-warning">
                    <!-- Font Awesome Shopping Bag Icon -->
                    <i class="fa-solid fa-bag-shopping text-xl me-1"></i>
                    Pilih Produk
                </button>

                <button wire:click="save()" class="btn btn-primary">
                    <!-- Font Awesome File Icon -->
                    <i class="fa-solid fa-file-lines text-xl me-1"></i>
                    Buat Surat Pesanan
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
                        <th class="w-1 center">
                            <input type="checkbox" wire:model.live="selectAll">
                        </th>
                        <th>Produk</th>
                        <th>Min Request Order</th>
                        <th>Satuan Order</th>
                        <th>Quantity Order</th>
                        <th>Quantity Diterima</th>
                        <th class="w-1 center">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__empty_5 = true; $__currentLoopData = $purchaseRequisitionItems; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $purchaseRequisitionItem): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_5 = false; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoopIteration(); ?><?php endif; ?>
                        <?php
                            $itemId = $purchaseRequisitionItem->id; // UUID
                        ?>
                        <tr>
                            <td class="center">
                                <input type="checkbox" value="<?php echo e($purchaseRequisitionItem->id); ?>"
                                    wire:model.live="selected">
                            </td>
                            <td><?php echo e($purchaseRequisitionItem->product_name); ?></td>
                            <td>
                                <div class="flex items-center gap-1">
                                    <span><?php echo number_format($purchaseRequisitionItem->quantity, 0, ',', '.'); ?></span>
                                    <span
                                        class="text-gray-500 text-sm">/<?php echo e($purchaseRequisitionItem->product->unit->name ?? '-'); ?></span>
                                </div>
                            </td>
                            <td>
                                <div class="flex items-center gap-1">
                                    <div <?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::$currentLoop['key'] = 'select-'.e(rand()).''; ?>wire:key="select-<?php echo e(rand()); ?>">
                                        <select class="mt-1 form-control" x-data x-ref="input" x-init="$nextTick(() => {
                                            $($refs.input).selectize({
                                                dropdownParent: 'body',
                                                allowClear: true,
                                                
                                                onChange: function(value) {
                                                    window.Livewire.find('<?php echo e($_instance->getId()); ?>').set('selectedUnitIds.<?php echo e($itemId); ?>', value || null);
                                                    window.Livewire.find('<?php echo e($_instance->getId()); ?>').call('updateSelectedUnit', '<?php echo e($itemId); ?>', value);
                                                }
                                            });
                                        })"
                                            id="unit_id_<?php echo e($itemId); ?>" style="width: 250px;">
                                            <option value="">-- Pilih Satuan Terkecil --</option>
                                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__currentLoopData = $purchaseRequisitionItem->product->productUnits; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $productUnit): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoopIteration(); ?><?php endif; ?>
                                                <option value="<?php echo e($productUnit->id); ?>" <?php if(($selectedUnitIds[$itemId] ?? '') == $productUnit->id): echo 'selected'; endif; ?>>
                                                    <?php echo e($productUnit->unit->name ?? '-'); ?> -
                                                    <?php echo e($productUnit->quantity); ?> /
                                                    <?php echo e($productUnit->product->unit->name); ?>

                                                </option>
                                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
                                        </select>
                                    </div>
                                    <button type="button"
                                        wire:click="openModalProductUnit('<?php echo e($purchaseRequisitionItem->id); ?>')"
                                        class="mt-1 px-4 py-2 h-965 bg-yellow-500 text-white rounded hover:bg-yellow-600 flex items-center">
                                        <i class="fa-solid fa-plus text-white text-lg"></i>
                                    </button>
                                </div>
                            </td>
                            <td>
                                <div class="flex items-center gap-1">
                                    <span><?php echo number_format($purchaseRequisitionItem->quantity_detail, 0, ',', '.'); ?></span>
                                    <span
                                        class="text-gray-500 text-sm">/<?php echo e($purchaseRequisitionItem->productUnit->unit->name ?? '-'); ?></span>
                                </div>
                            </td>
                            <td>
                                <div class="flex items-center gap-1">
                                    <span><?php echo number_format($purchaseRequisitionItem->quantity_real, 0, ',', '.'); ?></span>
                                    <span
                                        class="text-gray-500 text-sm">/<?php echo e($purchaseRequisitionItem->product->unit->name ?? '-'); ?></span>
                                </div>
                            </td>
                            <td class="center">
                                <div class="flex items-center">
                                    <button
                                        class="btn btn-icon text-red-600 hover:text-red-800 transition-colors delete-btn"
                                        wire:click="confirmDelete('<?php echo e($purchaseRequisitionItem->id); ?>')">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none"
                                            viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                        </svg>
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
        <div class="px-5 py-4 bg-gray-50/80 border-t border-gray-200">
            <div class="flex items-center justify-between">
                <div class="text-sm text-gray-700">
                    Menampilkan <span class="font-medium"><?php echo e($purchaseRequisitionItems->firstItem()); ?></span> sampai
                    <span class="font-medium"><?php echo e($purchaseRequisitionItems->lastItem()); ?></span> dari <span
                        class="font-medium"><?php echo e($purchaseRequisitionItems->total()); ?></span> hasil
                </div>
                <div>
                    <nav class="relative z-0 inline-flex rounded-md shadow-sm -space-x-px" aria-label="Pagination">
                        <?php echo e($purchaseRequisitionItems->links('vendor.livewire.custom')); ?>

                        <!-- Menampilkan pagination -->
                    </nav>
                </div>
            </div>
        </div>
    </div>
    
</div><?php /**PATH /Users/macbookair/Documents/mediction/mediction.id/resources/views/livewire/admin/purchase/draft/mail-order/admin-purchase-draft-mail-order-index.blade.php ENDPATH**/ ?>