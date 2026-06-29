<div>
    <?php echo $__env->make('livewire.admin.logistic.good-come.detail.admin-logistic-good-come-detail-modal', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
    <div class="mb-4">
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-2xl font-bold text-[#1E3A8A]">Detail Pembelian</h1>
            </div>
            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($purchaseOrder->status != 'success'): ?>
                <div>
                    <button class="btn btn-primary" wire:click="confirmSave()">
                        <i class="fa-solid fa-circle-check mr-2"></i> Akhiri Pembelian
                    </button>
                </div>
            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
        </div>
    </div>
    <div class="bg-white/80 backdrop-blur-sm rounded-xl p-5 shadow-lg border border-gray-100 mb-6">
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-2 gap-4">
            <div>
                <label class="block text-sm font-medium text-gray-700">Nomer SP <span
                        class="text-red-600">*</span></label>
                <input type="text" value="<?php echo e($purchaseOrder->purchaseRequisition->number ?? '-'); ?>" disabled
                    class="mt-1 form-control" />
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700">Nomer PO <span
                        class="text-red-600">*</span></label>
                <input type="text" value="<?php echo e($purchaseOrder->number ?? '-'); ?>" disabled class="mt-1 form-control" />
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700">Supplier <span
                        class="text-red-600">*</span></label>
                <input type="text" value="<?php echo e($purchaseOrder->supplier->name ?? '-'); ?>" disabled
                    class="mt-1 form-control" />
            </div>
            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700">
                    Grand Total <span class="text-red-600">*</span>
                </label>
                <div class="mt-1 flex rounded-md shadow-sm">
                    <span
                        class="inline-flex items-center rounded-l-md border border-r-0 border-gray-300 bg-gray-100 px-3 text-gray-500 text-sm">
                        Rp
                    </span>
                    <input type="text" disabled value="<?php echo number_format($purchaseOrder->grand_total ?? 0, 0, ',', '.'); ?>" class="form-control rounded-l-none"
                        placeholder="0" />
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
                        <th>Nama Produk</th>
                        <th class="center">Kuantitas</th>
                        <th>Harga</th>
                        <th>Pajak</th>
                        <th>Total</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                        $items = optional($purchaseOrder)->purchaseOrderItems
                            ? $purchaseOrder->purchaseOrderItems->sortBy('order')
                            : collect();
                    ?>
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__empty_5 = true; $__currentLoopData = $items; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $purchaseOrderItem): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_5 = false; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoopIteration(); ?><?php endif; ?>
                        <tr>
                            <td class="w-1 center"><?php echo e($index + 1); ?></td>
                            <td><?php echo e($purchaseOrderItem->product->name); ?></td>
                            <td class="center"><?php echo e($purchaseOrderItem->quantity); ?></td>
                            <td>
                                Rp<?php echo e(number_format($purchaseOrderItem->hna ?? 0, 0, ',', '.')); ?>

                            </td>
                            <td>
                                Rp<?php echo e(number_format($purchaseOrderItem->ppn ?? 0, 0, ',', '.')); ?>

                            </td>
                            <td>
                                Rp<?php echo e(number_format($purchaseOrderItem->sub_total ?? 0, 0, ',', '.')); ?>

                            </td>
                        </tr>
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_5): ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
                        <tr>
                            <td colspan="8" class="center no-data">Tidak ada data</td>
                        </tr>
                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div><?php /**PATH /Users/macbookair/Documents/mediction/mediction.id/resources/views/livewire/admin/report/purchase/detail/admin-report-purchase-detail-index.blade.php ENDPATH**/ ?>