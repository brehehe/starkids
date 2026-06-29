<div>
    <?php echo $__env->make('livewire.admin.pharmacy.sale.detail.admin-pharmacy-sale-detail-modal', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
    <?php
        $status = $transaction->status;
    ?>
    <div class="mb-4">
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-2xl font-bold text-[#1E3A8A]">Penjualan Detail</h1>
            </div>
            <div class="flex items-center gap-4">
                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(in_array($status, ['sale_pharmacy'])): ?>
                    <button wire:click="confirmSaveTransaction('process')" class="btn btn-primary">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                        </svg>
                        Simpan
                    </button>
                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
            </div>
        </div>
    </div>

    <div class="p-6 bg-white shadow rounded-lg mb-4">
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
            <div>
                <label class="block text-sm font-medium text-gray-700">Nama Dokter</label>
                <p class="mt-1 text-gray-900 font-semibold">
                    <?php echo e($transaction?->doctor?->name ?? ($transaction->doctor_name ?? '-')); ?></p>
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700">Tipe</label>
                <p class="mt-1 text-gray-900"><?php echo e(Str::title(Str::replace('-', ' ', $transaction->type)) ?? '-'); ?></p>
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700">Jam Praktik</label>
                <p class="mt-1 text-gray-900">
                    <?php echo e(optional($transaction->controlDoctor)->start_time && optional($transaction->controlDoctor)->end_time
                        ? \Carbon\Carbon::createFromFormat('H:i:s', $transaction->controlDoctor->start_time)->format('H:i') .
                            ' - ' .
                            \Carbon\Carbon::createFromFormat('H:i:s', $transaction->controlDoctor->end_time)->format('H:i') .
                            ' WIB'
                        : 'Waktu tidak tersedia'); ?>

                </p>
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700">Nomor Antrian Saat Ini</label>
                <p class="mt-1 text-2xl font-bold text-blue-600"><?php echo e($transaction->code_consultation ?? '-'); ?></p>
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700">Nama Pasien</label>
                <p class="mt-1 text-gray-900"><?php echo e($transaction->patient_name); ?></p>
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700">Poli</label>
                <p class="mt-1 text-orange-600 font-medium"><?php echo e($transaction->location->name ?? '-'); ?></p>
            </div>
        </div>
    </div>
    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(in_array($status, ['sale_pharmacy'])): ?>
        <div class="md:col-span-2 mb-4">
            <button wire:click="openModal()"
                class="px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-md w-full"><i
                    class="fa-solid fa-plus"></i> Tambahkan Resep</button>
        </div>
    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
    <div class="bg-white/80 backdrop-blur-sm rounded-xl shadow-lg border border-gray-100 overflow-hidden mb-6">
        <div class="table-container">
            <table class="table">
                <thead>
                    <tr class="border-b">
                        <th>Produk</th>
                        <th>Opsi Dosis</th>
                        <th>Dosis Dokter</th>
                        <th>Total Gramasi</th>
                        <th>Dosis Obat</th>
                        <th>Qty</th>
                        <th>Subtotal</th>
                        <th class="py-2 w-8"></th>
                        
                    </tr>
                </thead>
                <tbody>
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__empty_5 = true; $__currentLoopData = $transaction_details; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key_transaction_detail => $transaction_detail): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_5 = false; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoopIteration(); ?><?php endif; ?>
                        <tr class="border-t-4">
                            <td colspan="8" class="py-3 px-2">
                                <div class="flex items-center gap-2">
                                    <span class="font-medium text-blue-600"
                                        style="width: <?php echo e($transaction_detail['is_single'] ? '10%' : '15%'); ?>;">/R-<?php echo e($key_transaction_detail + 1); ?></span>
                                    <select <?php echo e($status == 'sale_pharmacy' ? '' : 'disabled'); ?>

                                        class="<?php echo e($status == 'sale_pharmacy' ? null : 'bg-gray-100 cursor-not-allowed'); ?> text-sm border rounded px-2 py-1"
                                        wire:model.lazy='transaction_details.<?php echo e($key_transaction_detail); ?>.medicine_type_id'
                                        style="width: 50%;">
                                        <option value="">Jenis Resep</option>
                                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__currentLoopData = $medicine_types; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $medicine_type): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoopIteration(); ?><?php endif; ?>
                                            <option value="<?php echo e($medicine_type['id']); ?>"><?php echo e($medicine_type['name']); ?>

                                            </option>
                                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
                                    </select>
                                    <div class="flex items-center border rounded px-2 py-1 bg-gray-100 cursor-not-allowed"
                                        style="width: 50%;">
                                        <span class="text-gray-500 mr-2 select-none">Rp</span>
                                        <input type="text" disabled
                                            wire:model='transaction_details.<?php echo e($key_transaction_detail); ?>.price_service_one'
                                            placeholder="Jasa 1"
                                            class="text-sm bg-gray-100 text-gray-500 focus:outline-none w-full cursor-not-allowed" />
                                    </div>
                                    <input type="text"
                                        wire:model.lazy='transaction_details.<?php echo e($key_transaction_detail); ?>.numero_recipe'
                                        placeholder="Numero Resep" <?php echo e($status == 'sale_pharmacy' ? null : 'disabled'); ?>

                                        class="<?php echo e($status == 'sale_pharmacy' ? null : 'bg-gray-100 cursor-not-allowed'); ?> text-sm border rounded px-2 py-1"
                                        style="width: 50%;">
                                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(!$transaction_detail['is_single']): ?>
                                        <select <?php echo e($status == 'sale_pharmacy' ? null : 'disabled'); ?>

                                            class="<?php echo e($status == 'sale_pharmacy' ? null : 'bg-gray-100 cursor-not-allowed'); ?> text-sm border rounded px-2 py-1"
                                            wire:model.lazy='transaction_details.<?php echo e($key_transaction_detail); ?>.product_id'
                                            style="width: 100%;">
                                            <option value="">Jenis Produk Pendukung</option>
                                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__currentLoopData = $supporting_products; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $supporting_product): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoopIteration(); ?><?php endif; ?>
                                                <option value="<?php echo e($supporting_product['id']); ?>">
                                                    <?php echo e($supporting_product['name']); ?> -
                                                    <?php echo e($supporting_product['product_stock']['quantity']); ?> - Rp
                                                    <?php echo e(number_format($supporting_product['product_price']['price'], 0, ',', '.')); ?>

                                                </option>
                                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
                                        </select>
                                        <div class="flex items-center border rounded px-2 py-1 bg-gray-100 cursor-not-allowed"
                                            style="width: 50%;">
                                            <span class="text-gray-500 mr-2 select-none">Rp</span>
                                            <input type="text" disabled
                                                wire:model='transaction_details.<?php echo e($key_transaction_detail); ?>.sub_total_price'
                                                placeholder="Jasa 1"
                                                class="text-sm bg-gray-100 text-gray-500 focus:outline-none w-full cursor-not-allowed" />
                                        </div>
                                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($status == 'sale_pharmacy'): ?>
                                            <button class="text-blue-500 hover:text-blue-700"
                                                wire:click="addDetail('<?php echo e($transaction_detail['id']); ?>')">
                                                <i class="fas fa-plus"></i>
                                            </button>
                                        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($status == 'sale_pharmacy'): ?>
                                        <button class="text-red-600 hover:text-red-800 mx-1"
                                            wire:click="confirmDeleteTransactionRecipe('<?php echo e($transaction_detail['id']); ?>')"
                                            title="Hapus">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                </div>
                                <div class="mt-2 text-sm text-gray-600">
                                    <input type="text"
                                        wire:model.lazy='transaction_details.<?php echo e($key_transaction_detail); ?>.description'
                                        placeholder="Aturan Pakai" <?php echo e($status == 'sale_pharmacy' ? null : 'disabled'); ?>

                                        class="<?php echo e($status == 'sale_pharmacy' ? null : 'bg-gray-100 cursor-not-allowed'); ?> w-full border rounded px-2 py-1">
                                </div>
                            </td>
                        </tr>
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(!empty($transaction_detail['details'])): ?>
                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__empty_6 = true; $__currentLoopData = $transaction_detail['details']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index_detail => $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_6 = false; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoopIteration(); ?><?php endif; ?>
                                <tr class="border-b">
                                    <td class="py-2" colspan="<?php echo e(!$transaction_detail['is_single'] ? 1 : 5); ?>">
                                        <p class="font-medium"><?php echo e($item['product_name']); ?></p>
                                        <p class="text-xs text-gray-500">
                                            @Rp<?php echo e(number_format($item['price'], 0, ',', '.')); ?></p>
                                    </td>
                                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(!$transaction_detail['is_single']): ?>
                                        <td class="py-2">
                                            <div class="flex items-center gap-2">
                                                <select
                                                    wire:model.lazy='transaction_details.<?php echo e($key_transaction_detail); ?>.details.<?php echo e($index_detail); ?>.type'
                                                    <?php echo e($status == 'sale_pharmacy' ? null : 'disabled'); ?>

                                                    class="<?php echo e($status == 'sale_pharmacy' ? null : 'bg-gray-100 cursor-not-allowed'); ?> text-sm border rounded px-2 py-1"
                                                    style="width: 100%;">
                                                    <option value="single">Opsi Dosis</option>
                                                    <option value="partial">Partial</option>
                                                    <option value="gramasi">Gramasi</option>
                                                </select>
                                            </div>
                                        </td>
                                        <td class="py-2">
                                            <input
                                                wire:model.lazy="transaction_details.<?php echo e($key_transaction_detail); ?>.details.<?php echo e($index_detail); ?>.dosage_doctor"
                                                type="text" placeholder="Dosis Dokter"
                                                <?php echo e($status == 'sale_pharmacy' ? null : 'disabled'); ?>

                                                class="<?php echo e($status == 'sale_pharmacy' ? null : 'bg-gray-100 cursor-not-allowed'); ?> text-sm border rounded px-2 py-1"
                                                style="width: 100%;">
                                        </td>
                                        <td class="py-2">
                                            <input type="text" disabled
                                                wire:model='transaction_details.<?php echo e($key_transaction_detail); ?>.details.<?php echo e($index_detail); ?>.doctor_dosage_gram'
                                                placeholder="Jasa 1"
                                                class="text-sm border rounded px-2 py-1  bg-gray-100 cursor-not-allowed"
                                                style="width: 100%;" />
                                        </td>
                                        <td class="py-2">
                                            <input
                                                wire:model.lazy="transaction_details.<?php echo e($key_transaction_detail); ?>.details.<?php echo e($index_detail); ?>.dosage_drug"
                                                type="text" placeholder="Dosis Obat"
                                                <?php echo e($status == 'sale_pharmacy' ? null : 'disabled'); ?>

                                                class="<?php echo e($status == 'sale_pharmacy' ? null : 'bg-gray-100 cursor-not-allowed'); ?> text-sm border rounded px-2 py-1"
                                                style="width: 100%;">
                                        </td>
                                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                    <td class="py-2 text-center">
                                        <?php echo e($item['quantity']); ?>

                                    </td>
                                    <td class="py-2 text-right">
                                        Rp<?php echo e(number_format($item['sub_total_price'], 0, ',', '.')); ?></td>
                                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($status == 'sale_pharmacy'): ?>
                                        <td class="py-2 text-center">
                                            <button wire:click="confirmDeleteTransactionDetail('<?php echo e($item['id']); ?>')"
                                                class="text-red-500 hover:text-red-700"><i
                                                    class="fas fa-trash"></i></button>
                                        </td>
                                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                </tr>
                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_6): ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
                                <tr class="border-b">
                                    <td colspan="7" class="py-2 text-center text-gray-500">Tidak ada detail produk
                                    </td>
                                </tr>
                            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_5): ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
                        <tr>
                            <td colspan="6" class="no-data">Tidak ada data</td>
                        </tr>
                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div><?php /**PATH /Users/macbookair/Documents/mediction/mediction.id/resources/views/livewire/admin/pharmacy/sale/recipe/admin-pharmacy-sale-recipe-index.blade.php ENDPATH**/ ?>