<div>
    <?php echo $__env->make('livewire.admin.logistic.good-come.detail.admin-logistic-good-come-detail-modal', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
    <div class="mb-4">
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-2xl font-bold text-[#1E3A8A]">Detail Penerimaan Barang</h1>
            </div>
            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(!in_array($purchaseOrder->status, ['success', 'return'])): ?>
                <div>
                    <button class="btn btn-warning" wire:click="confirmSavePrice()">
                        <i class="fa-solid fa-circle-check mr-2"></i> Simpan Harga
                    </button>
                    <button class="btn btn-primary" wire:click="confirmSave()">
                        <i class="fa-solid fa-circle-check mr-2"></i> Akhiri Penerimaan Barang
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
                        <th class="w-1 center" rowspan="2">No</th>
                        <th rowspan="2">Nama Produk</th>
                        <th rowspan="2">HNA</th>
                        <th rowspan="2">HNA PPN</th>
                        <th rowspan="2">Diskon</th>
                        <th rowspan="2">Total Diskon</th>
                        <th rowspan="2">Total</th>
                        <th colspan="3" class="center">Kuantitas</th>
                        <th rowspan="2" class="center">Status</th>
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(!in_array($purchaseOrder->status, ['success', 'return'])): ?>
                            <th class="w-1 center" rowspan="2">Aksi</th>
                        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                    </tr>
                    <tr>
                        <th class="center">Dipesan</th>
                        <th class="center">Diterima</th>
                        <th class="center">Satuan</th>
                    </tr>
                </thead>
                <tbody>
                    
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__empty_1 = true; $__currentLoopData = $items; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $purchaseOrderItem): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoopIteration(); ?><?php endif; ?>
                        <tr>
                            <td class="w-1 center"><?php echo e($index + 1); ?></td>
                            <td style="width: 200px;"><?php echo e($purchaseOrderItem['name_product']); ?></td>
                            <td>
                                <div style="width: 175px;" class="mt-1 flex rounded-md shadow-sm">
                                    <span
                                        class="inline-flex items-center rounded-l-md border border-l-0 border-gray-300 bg-gray-100 px-3 text-gray-500 text-sm">Rp</span>
                                    <input type="text" onkeyup="convertToRupiah(this);"
                                        wire:model.lazy='items.<?php echo e($index); ?>.hna'
                                        <?php echo e(in_array($purchaseOrder->status, ['success', 'return']) ? 'disabled' : null); ?>

                                        class="form-control rounded-l-none" placeholder="0" />
                                </div>
                            </td>
                            <td>
                                <div style="width: 175px;" class="mt-1 flex rounded-md shadow-sm">
                                    <span
                                        class="inline-flex items-center rounded-l-md border border-l-0 border-gray-300 bg-gray-100 px-3 text-gray-500 text-sm">Rp</span>
                                    <input type="text" onkeyup="convertToRupiah(this);"
                                        wire:model.lazy='items.<?php echo e($index); ?>.hna_ppn'
                                        <?php echo e(in_array($purchaseOrder->status, ['success', 'return']) ? 'disabled' : null); ?>

                                        class="form-control rounded-l-none" placeholder="0" />
                                </div>
                            </td>
                            <td>
                                <div style="width: 175px;" class="mt-1 flex rounded-md shadow-sm">
                                    <select wire:model.lazy='items.<?php echo e($index); ?>.discount_type'
                                        class="inline-flex items-center rounded-l-md border border-l-0 border-gray-300 bg-gray-100 px-3 text-gray-500 text-sm">
                                        <option value="rupiah">RP</option>
                                        <option value="percentage">%</option>
                                    </select>
                                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($items[$index]['discount_type'] == 'percentage'): ?>
                                        <input type="number"
                                            wire:model.lazy='items.<?php echo e($index); ?>.discount_value' placeholder="0"
                                            class="form-control rounded-l-none"
                                            <?php echo e(in_array($purchaseOrder->status, ['success', 'return']) ? 'disabled' : null); ?> />
                                    <?php else: ?>
                                        <input type="text" onkeyup="convertToRupiah(this);"
                                            wire:model.lazy='items.<?php echo e($index); ?>.discount_value'
                                            <?php echo e(in_array($purchaseOrder->status, ['success', 'return']) ? ' disabled' : null); ?>

                                            class="form-control rounded-l-none" placeholder="0" />
                                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                </div>
                            </td>
                            <td>
                                <div style="width: 175px;" class="mt-1 flex rounded-md shadow-sm">
                                    <span
                                        class="inline-flex items-center rounded-l-md border border-l-0 border-gray-300 bg-gray-100 px-3 text-gray-500 text-sm">Rp</span>
                                    <input disabled type="text" onkeyup="convertToRupiah(this);"
                                        wire:model.lazy='items.<?php echo e($index); ?>.discount'
                                        <?php echo e(in_array($purchaseOrder->status, ['success', 'return']) ? 'disabled' : null); ?>

                                        class="form-control rounded-l-none" placeholder="0" />
                                </div>
                            </td>
                            <td>
                                <div style="width: 175px;" class="mt-1 flex rounded-md shadow-sm">
                                    <span
                                        class="inline-flex items-center rounded-l-md border border-l-0 border-gray-300 bg-gray-100 px-3 text-gray-500 text-sm">Rp</span>
                                    <input disabled type="text" onkeyup="convertToRupiah(this);"
                                        wire:model.lazy='items.<?php echo e($index); ?>.total'
                                        <?php echo e(in_array($purchaseOrder->status, ['success', 'return']) ? 'disabled' : null); ?>

                                        class="form-control rounded-l-none" placeholder="0" />
                                </div>
                            </td>
                            <td class="center"><?php echo e($purchaseOrderItem['quantity']); ?></td>
                            <td class="center"><?php echo e($purchaseOrderItem['quantity_accepted']); ?></td>
                            <td class="center"><?php echo e($purchaseOrderItem['productUnit']['unit']['name']); ?></td>
                            <td class="center">
                                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($purchaseOrderItem['quantity_accepted'] == $purchaseOrderItem['quantity']): ?>
                                    <span class="bg-green-500 text-white px-2 py-1 rounded-md text-sm">Selesai</span>
                                <?php elseif($purchaseOrderItem['quantity_accepted'] != $purchaseOrderItem['quantity']): ?>
                                    <span class="bg-yellow-500 text-white px-2 py-1 rounded-md text-sm">Sebagian</span>
                                <?php else: ?>
                                    <span class="bg-red-500 text-white px-2 py-1 rounded-md text-sm">Belum
                                        Selesai</span>
                                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                            </td>
                            <td class="w-1 center">
                                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(!in_array($purchaseOrder->status, ['success', 'return'])): ?>
                                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($purchaseOrderItem['quantity_accepted'] < $purchaseOrderItem['quantity']): ?>
                                        <button
                                            class="btn btn-icon text-yellow-600 hover:text-yellow-800 transition-colors edit-btn"
                                            wire:click="detail('<?php echo e($purchaseOrderItem['id']); ?>')"
                                            aria-label="Lihat Detail">
                                            <i class="fa-regular fa-memo-circle-info text-yellow-600 text-lg"></i>
                                            <!-- FontAwesome Eye Icon -->
                                        </button>
                                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                            </td>
                        </tr>
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
                        <tr>
                            <td colspan="8" class="center no-data">Tidak ada data</td>
                        </tr>
                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div><?php /**PATH /Users/macbookair/Documents/mediction/mediction.id/resources/views/livewire/admin/logistic/good-come/detail/admin-logistic-good-come-detail-index.blade.php ENDPATH**/ ?>