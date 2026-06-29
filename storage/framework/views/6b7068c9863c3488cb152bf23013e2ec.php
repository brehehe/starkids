<div>
    <?php echo $__env->make('livewire.admin.pharmacy.consultation.detail.admin-pharmacy-consultation-detail-modal', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>

    
    <div wire:loading>
        <?php echo $__env->make('layout.loading', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
    </div>
    <?php
        $status = $transaction->status;
    ?>

    <div class="mb-4">
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-2xl font-bold text-[#1E3A8A]">Detail Resep Konsultasi </h1>
            </div>
            <div class="flex items-center gap-4">
                <div class="mt-1">
                    <label class="inline-flex items-center">
                        <input type="checkbox" <?php echo e(in_array($status, ['pharmacy', 'call_pharmacy']) ? null : 'disabled'); ?>

                            wire:model.lazy="is_outside_pharmacy" class="form-checkbox" />
                        <span class="ml-2">Apakah resep di ambil di luar klinik?</span>
                    </label>
                </div>
                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(in_array($status, ['pharmacy', 'call_pharmacy'])): ?>
                    <button wire:click="confirmSave()" class="btn btn-primary">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                        </svg>
                        Simpan
                    </button>
                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                <a href="<?php echo e(route('user.receipt.recipe', $transaction->id)); ?>" target="_blank" class="btn bg-green-600 hover:bg-green-700 text-white shadow-md transition-all flex items-center gap-2">
                    <i class="fa-solid fa-file-prescription"></i>
                    Cetak Copy Resep
                </a>
            </div>
        </div>
    </div>
    <div class="p-6 bg-white shadow rounded-lg mb-4">
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
            <div>
                <label class="block text-sm font-medium text-gray-700">Nama Dokter</label>
                <p class="mt-1 text-gray-900 font-semibold">
                    <?php echo e($transaction?->doctor?->name ?? $transaction->doctor_name); ?></p>
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700">Spesialisasi</label>
                <p class="mt-1 text-gray-900"><?php echo e($transaction->doctor->userDetail->specialization ?? '-'); ?></p>
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700">Jam Praktik</label>
                <p class="mt-1 text-gray-900">
                    <?php echo e($transaction?->controlDoctor?->start_time_get . ' - ' . $transaction?->controlDoctor?->end_time_get); ?>

                    WIB</p>
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700">Nomor Antrian Saat Ini</label>
                <p class="mt-1 text-2xl font-bold text-blue-600"><?php echo e($transaction->code_consultation); ?></p>
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
    
    <div class="md:col-span-2 mb-4">
        <button wire:click="createMedicine()"
            class="px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-md w-full"><i
                class="fa-solid fa-plus"></i> Tambahkan Resep</button>
    </div>
    <div class="bg-white/80 backdrop-blur-sm rounded-xl shadow-lg border border-gray-100 overflow-hidden mb-6">
        <div class="table-container">
            <table class="table">
                <thead>
                    <tr class="border-b">
                        <th>Produk</th>
                        <th>Quantity Request</th>
                        <th class="center">Quantity</th>
                        <th class="right">Subtotal</th>
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(in_array($status, ['pharmacy', 'call_pharmacy'])): ?>
                            <th class="py-2 w-8"></th>
                        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($status == 'draft'): ?>
                        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                    </tr>
                </thead>
                <tbody>
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__currentLoopData = $actions; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key_action => $action): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoopIteration(); ?><?php endif; ?>
                        <tr class="border-b">
                            <td class="py-2" colspan="2">
                                <p class="font-medium"><?php echo e($action['product_name']); ?></p>
                                <p class="text-xs text-gray-500">@Rp<?php echo e(number_format($action['price'], 0, ',', '.')); ?>

                                </p>
                            </td>
                            <td class="py-2 text-center">
                                <?php echo e($action['quantity']); ?>

                            </td>
                            <td class="py-2 text-right">Rp<?php echo e(number_format($action['sub_total_price'], 0, ',', '.')); ?>

                            </td>
                        </tr>
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__currentLoopData = $recipes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key_recipe => $recipe): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoopIteration(); ?><?php endif; ?>
                        <tr class="border-t-4">
                            <td colspan="4" class="py-3 px-2">
                                <div class="flex items-center gap-2">
                                    <span class="font-medium text-blue-600"
                                        style="width: <?php echo e($recipe['is_single'] ? '10%' : '15%'); ?>;">/R-<?php echo e($key_recipe + 1); ?></span>
                                    <select
                                        class="<?php echo e(in_array($transaction->status, ['pharmacy', 'call_pharmacy']) ? null : 'bg-gray-100 cursor-not-allowed'); ?> text-sm border rounded px-2 py-1"
                                        wire:model.lazy='recipes.<?php echo e($key_recipe); ?>.medicine_type_id'
                                        style="width: 50%;"
                                        <?php echo e(in_array($transaction->status, ['pharmacy', 'call_pharmacy']) ? null : 'disabled'); ?>>
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
                                            wire:model='recipes.<?php echo e($key_recipe); ?>.price_service_one'
                                            placeholder="Jasa 1"
                                            class="text-sm bg-gray-100 text-gray-500 focus:outline-none w-full cursor-not-allowed" />
                                    </div>
                                    <input type="text" wire:model.lazy='recipes.<?php echo e($key_recipe); ?>.numero_recipe'
                                        placeholder="Numero Resep"
                                        <?php echo e(in_array($status, ['pharmacy', 'call_pharmacy']) ? null : 'disabled'); ?>

                                        class="<?php echo e(in_array($status, ['pharmacy', 'call_pharmacy']) ? null : 'bg-gray-100 cursor-not-allowed'); ?> text-sm border rounded px-2 py-1"
                                        style="width: 50%;">
                                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(!$recipe['is_single']): ?>
                                        <select
                                            <?php echo e(in_array($status, ['pharmacy', 'call_pharmacy']) ? null : 'disabled'); ?>

                                            class="<?php echo e(in_array($status, ['pharmacy', 'call_pharmacy']) ? null : 'bg-gray-100 cursor-not-allowed'); ?> text-sm border rounded px-2 py-1"
                                            wire:model.lazy='recipes.<?php echo e($key_recipe); ?>.product_id'
                                            style="width: 100%;">
                                            <option value="">Jenis Produk Pendukung</option>
                                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__currentLoopData = $supporting_products; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $supporting_product): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoopIteration(); ?><?php endif; ?>
                                                <option value="<?php echo e($supporting_product['id']); ?>">
                                                    <?php echo e($supporting_product['name']); ?> -
                                                    <?php echo e($supporting_product['product_stock']['quantity'] ?? 0); ?> -
                                                    Rp
                                                    <?php echo e(number_format($supporting_product['product_price']['price'] ?? 0, 0, ',', '.')); ?>

                                                </option>
                                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
                                        </select>
                                        <div class="flex items-center border rounded px-2 py-1 bg-gray-100 cursor-not-allowed"
                                            style="width: 50%;">
                                            <span class="text-gray-500 mr-2 select-none">Rp</span>
                                            <input type="text" disabled
                                                wire:model='recipes.<?php echo e($key_recipe); ?>.sub_total_price'
                                                placeholder="Jasa 1"
                                                class="text-sm bg-gray-100 text-gray-500 focus:outline-none w-full cursor-not-allowed" />
                                        </div>
                                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(in_array($transaction->status, ['pharmacy', 'call_pharmacy'])): ?>
                                            <button class="text-blue-500 hover:text-blue-700"
                                                wire:click="addDetail('<?php echo e($recipe['id']); ?>')">
                                                <i class="fas fa-plus"></i>
                                            </button>
                                            <button class="text-red-600 hover:text-red-800 mx-1"
                                                wire:click="confirmDeleteTransactionRecipe('<?php echo e($recipe['id']); ?>')"
                                                title="Hapus">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                    <?php else: ?>
                                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(in_array($transaction->status, ['pharmacy', 'call_pharmacy'])): ?>
                                            <button class="text-red-600 hover:text-red-800 mx-1"
                                                wire:click="confirmDeleteTransactionRecipe('<?php echo e($recipe['id']); ?>')"
                                                title="Hapus">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                </div>
                                
                                <div class="mt-2 text-sm text-gray-600">
                                    <input type="text" wire:model.lazy='recipes.<?php echo e($key_recipe); ?>.description'
                                        placeholder="Informasi Tambahan Aturan Pakai"
                                        <?php echo e(in_array($status, ['pharmacy', 'call_pharmacy']) ? null : 'disabled'); ?>

                                        class="<?php echo e(in_array($status, ['pharmacy', 'call_pharmacy']) ? null : 'bg-gray-100 cursor-not-allowed'); ?> w-full border rounded px-2 py-1">
                                </div>
                                <div class="mt-2 text-sm text-gray-600">
                                    <input type="text" wire:model.lazy='recipes.<?php echo e($key_recipe); ?>.notes'
                                        placeholder="Catatan Resep"
                                        <?php echo e(in_array($status, ['pharmacy', 'call_pharmacy']) ? null : 'disabled'); ?>

                                        class="<?php echo e(in_array($status, ['pharmacy', 'call_pharmacy']) ? null : 'bg-gray-100 cursor-not-allowed'); ?> w-full border rounded px-2 py-1">
                                </div>
                                
                            </td>
                        </tr>
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(!empty($recipe['details'])): ?>
                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__currentLoopData = $recipe['details']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index_detail => $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoopIteration(); ?><?php endif; ?>
                                <tr class="border-b">
                                    <td class="py-2" colspan="<?php echo e(!$recipe['is_single'] ? 1 : 2); ?>"
                                        style="width: 20%;">
                                        <p class="font-medium">
                                            <?php echo e($item['product_name']); ?>

                                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(in_array($status, ['pharmacy', 'call_pharmacy'])): ?>
                                                <button wire:click="changeProduct('<?php echo e($item['id']); ?>')"
                                                    class="text-yellow-500 hover:text-yellow-700"><i
                                                        class="fas fa-pen"></i></button>
                                            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                        </p>
                                        <p class="text-xs text-gray-500">
                                            @Rp<?php echo e(number_format($item['price'], 0, ',', '.')); ?></p>
                                    </td>
                                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(!$recipe['is_single']): ?>
                                        <td class="py-2">
                                            <input
                                                wire:model.lazy="recipes.<?php echo e($key_recipe); ?>.details.<?php echo e($index_detail); ?>.quantity_real"
                                                type="text" placeholder="Dosis Obat"
                                                <?php echo e(in_array($status, ['pharmacy', 'call_pharmacy']) ? null : 'disabled'); ?>

                                                class="<?php echo e(in_array($status, ['pharmacy', 'call_pharmacy']) ? null : 'bg-gray-100 cursor-not-allowed'); ?> text-sm border rounded px-2 py-1"
                                                style="width: 100%;">
                                        </td>
                                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                    <td class="py-2 text-center">
                                        <?php echo e($item['quantity']); ?>

                                    </td>
                                    <td class="py-2 text-right">
                                        Rp<?php echo e(number_format($item['sub_total_price'], 0, ',', '.')); ?></td>
                                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(in_array($status, ['pharmacy', 'call_pharmacy'])): ?>
                                        <td class="py-2 text-center">
                                            <button wire:click="confirmDeleteMedicine('<?php echo e($item['id']); ?>')"
                                                class="text-red-500 hover:text-red-700"><i
                                                    class="fas fa-trash"></i></button>
                                        </td>
                                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                </tr>
                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
                        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__currentLoopData = $medicines; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key_medicine => $medicine): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoopIteration(); ?><?php endif; ?>
                        <tr
                            class="border-b <?php echo e(isset($medicine['is_free_item']) && $medicine['is_free_item'] ? 'bg-green-50' : ''); ?>">
                            <td class="py-2" colspan="2">
                                <div class="flex items-start justify-between">
                                    <div class="flex-1">
                                        
                                        <div
                                            class="<?php echo e(isset($medicine['is_parent']) && !$medicine['is_parent'] ? 'ml-6' : ''); ?>">
                                            
                                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(isset($medicine['is_parent']) && !$medicine['is_parent']): ?>
                                                <span class="text-gray-400 mr-2">└─</span>
                                            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

                                            <p
                                                class="font-medium <?php echo e(isset($medicine['is_free_item']) && $medicine['is_free_item'] ? 'text-green-700' : ''); ?>">
                                                <?php echo e($medicine['product_name']); ?>

                                                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(isset($medicine['is_free_item']) && $medicine['is_free_item']): ?>
                                                    <span
                                                        class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-green-100 text-green-800 ml-2">
                                                        <i class="fas fa-gift mr-1"></i>GRATIS
                                                    </span>
                                                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                            </p>
                                            <p class="text-xs text-gray-500 flex ">
                                                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($medicine['price_discount'] != $medicine['price']): ?>
                                                    <span class="line-through text-red-500 mr-2">
                                                        Rp<?php echo e(number_format($medicine['price_discount'], 0, ',', '.')); ?>

                                                    </span>
                                                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                                <span
                                                    class="<?php echo e(isset($medicine['is_free_item']) && $medicine['is_free_item'] ? 'text-green-600 font-medium' : ''); ?>">
                                                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(isset($medicine['is_free_item']) && $medicine['is_free_item']): ?>
                                                        GRATIS
                                                        (Rp<?php echo e(number_format($medicine['price_discount'] ?? 0, 0, ',', '.')); ?>)
                                                    <?php else: ?>
                                                        Rp<?php echo e(number_format($medicine['price'], 0, ',', '.')); ?>

                                                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                                </span>
                                            </p>
                                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(isset($medicine['promotion_text']) && $medicine['promotion_text']): ?>
                                                <p class="text-xs text-green-600 mt-1">
                                                    <i class="fas fa-tag mr-1"></i><?php echo e($medicine['promotion_text']); ?>

                                                </p>
                                            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                        </div>
                                    </div>
                                </div>
                            </td>
                            <td class="py-2 text-center">
                                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(in_array($transaction->status, ['pharmacy', 'call_pharmacy'])): ?>
                                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(isset($medicine['is_free_item']) && $medicine['is_free_item']): ?>
                                        
                                        <span
                                            class="text-green-600 font-medium"><?php echo e(number_format($medicine['quantity'], 0, ',', '.')); ?></span>
                                        <div class="text-xs text-green-500 mt-1">Auto</div>
                                    <?php else: ?>
                                        <div class="flex justify-center items-center gap-2">
                                            <input type="number"
                                                wire:model.lazy='medicines.<?php echo e($key_medicine); ?>.quantity'
                                                class="w-20 h-6 text-center border rounded" />
                                        </div>
                                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                <?php else: ?>
                                    <?php echo e(number_format($medicine['quantity'], 0, ',', '.')); ?>

                                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                            </td>
                            <td class="py-2 text-right">
                                <span
                                    class="<?php echo e(isset($medicine['is_free_item']) && $medicine['is_free_item'] ? 'text-green-600 font-medium' : ''); ?>">
                                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(isset($medicine['is_free_item']) && $medicine['is_free_item']): ?>
                                        GRATIS
                                    <?php else: ?>
                                        Rp<?php echo e(number_format($medicine['sub_total_price'], 0, ',', '.')); ?>

                                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                </span>
                            </td>
                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(in_array($transaction->status, ['pharmacy', 'call_pharmacy'])): ?>
                                <td class="py-2 text-center">
                                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(isset($medicine['is_free_item']) && $medicine['is_free_item']): ?>
                                        
                                        <i class="fas fa-info-circle text-green-500"
                                            title="Item gratis dari promosi"></i>
                                    <?php else: ?>
                                        <button wire:click="confirmDeleteMedicine('<?php echo e($medicine['id']); ?>')"
                                            class="text-red-500 hover:text-red-700"><i
                                                class="fas fa-trash"></i></button>
                                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                </td>
                            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                        </tr>
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
                </tbody>
                <tbody>
                    <tr>
                        <th colspan="3" class="right font-bold">
                            Total Produk
                        </th>
                        <th class="font-bold right">
                            Rp<?php echo e(number_format($transaction->product_price, 0, ',', '.')); ?>

                        </th>
                    </tr>
                    <tr>
                        <th colspan="3" class="right font-bold">
                            Embalage
                        </th>
                        <th class="font-bold right">
                            Rp<?php echo e(number_format($transaction->embalage, 0, ',', '.')); ?>

                        </th>
                    </tr>
                    <tr>
                        <th colspan="3" class="right font-bold">
                            Diskon
                        </th>
                        <th class="font-bold right">
                            Rp<?php echo e(number_format($transaction->discount_value, 0, ',', '.')); ?>

                        </th>
                    </tr>
                    <tr>
                        <th colspan="3" class="right font-bold">
                            Pembulatan
                        </th>
                        <th class="font-bold right">
                            Rp<?php echo e(number_format($transaction->rounding, 0, ',', '.')); ?>

                        </th>
                    </tr>
                    <tr>
                        <th colspan="3" class="right font-bold">
                            Total Pembayaran
                        </th>
                        <th class="font-bold right">
                            Rp<?php echo e(number_format($transaction->grand_total_price, 0, ',', '.')); ?>

                        </th>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</div><?php /**PATH /Users/macbookair/Documents/mediction/mediction.id/resources/views/livewire/admin/pharmacy/consultation/detail/admin-pharmacy-consultation-detail-index.blade.php ENDPATH**/ ?>