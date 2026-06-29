<div>
    <div class="mb-4">
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-2xl font-bold text-[#1E3A8A]">Pengambilan Obat</h1>
            </div>
            <div class="flex items-center gap-4">
                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(in_array($status, ['take_medicine'])): ?>
                    <button wire:click="confirmSave()" class="btn btn-primary">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                        </svg>
                        Ambil Obat
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
                    <?php echo e($transaction?->doctor?->name ?? $transaction->doctor_name); ?></p>
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700">Tipe</label>
                <p class="mt-1 text-gray-900"><?php echo e(Str::title(Str::replace('-', ' ', $transaction->type)) ?? '-'); ?></p>
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700">Jam Praktik</label>
                <p class="mt-1 text-gray-900">
                    <?php echo e($transaction?->controlDoctor?->start_time_get . ' - ' . $transaction?->controlDoctor?->end_time_get ?? ($transaction?->controlDoctor?->start_time_get . ' - ' . $transaction?->controlDoctor?->end_time_get ?? '-')); ?>

                </p>
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
    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(in_array($status, ['pharmacy', 'call_pharmacy'])): ?>
        <div class="md:col-span-2 mb-4">
            <button wire:click="changeProduct()"
                class="px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-md w-full"><i
                    class="fa-solid fa-plus"></i> Tambahkan Obat</button>
        </div>
    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
    <div class="bg-white/80 backdrop-blur-sm rounded-xl shadow-lg border border-gray-100 overflow-hidden mb-6">
        <div class="table-container">
            <table class="table">
                <thead>
                    <tr class="border-b">
                        <th>Produk</th>
                        <th>Quantity Request</th>
                        <th class="center">Qty</th>
                        <th class="right">Subtotal</th>
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(in_array($status, ['pharmacy', 'call_pharmacy'])): ?>
                            <th class="py-2 w-8"></th>
                        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                        
                    </tr>
                </thead>
                <tbody>
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__currentLoopData = $recipes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key_recipe => $recipe): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoopIteration(); ?><?php endif; ?>
                        <tr class="border-t-4">
                            <td colspan="4" class="py-3 px-2">
                                <div class="flex items-center gap-2">
                                    <span class="font-medium text-blue-600"
                                        style="width: <?php echo e($recipe['is_single'] ? '10%' : '15%'); ?>;">/R-<?php echo e($key_recipe + 1); ?></span>
                                    <select disabled
                                        class="bg-gray-100 cursor-not-allowed text-sm border rounded px-2 py-1"
                                        wire:model.lazy='recipes.<?php echo e($key_recipe); ?>.medicine_type_id'
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
                                                    <?php echo e($supporting_product['product_stock']['quantity'] ?? 0); ?> - Rp
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
                                        
                                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                    
                                </div>
                                <div class="mt-2 text-sm text-gray-600">
                                    <input type="text" wire:model.lazy='recipes.<?php echo e($key_recipe); ?>.description'
                                        placeholder="Aturan Pakai"
                                        <?php echo e(in_array($status, ['pharmacy', 'call_pharmacy']) ? null : 'disabled'); ?>

                                        class="<?php echo e(in_array($status, ['pharmacy', 'call_pharmacy']) ? null : 'bg-gray-100 cursor-not-allowed'); ?> w-full border rounded px-2 py-1">
                                </div>
                            </td>
                        </tr>
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(!empty($recipe['details'])): ?>
                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__currentLoopData = $recipe['details']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index_detail => $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoopIteration(); ?><?php endif; ?>
                                <tr class="border-b">
                                    <td class="py-2" colspan="<?php echo e(!$recipe['is_single'] ? 2 : 2); ?>"
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
                                    <td class="py-2 text-center">
                                        <?php echo e($item['quantity']); ?>

                                    </td>
                                    <td class="py-2 text-right">
                                        Rp<?php echo e(number_format($item['sub_total_price'], 0, ',', '.')); ?></td>
                                    
                                </tr>
                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
                        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__currentLoopData = $medicines; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key_medicine => $medicine): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoopIteration(); ?><?php endif; ?>
                        <tr class="border-b bg-blue-50">
                            <td class="py-2" colspan="2">
                                <p class="font-medium"><?php echo e($medicine['product_name']); ?></p>
                                <p class="text-xs text-gray-500">
                                    @Rp<?php echo e(number_format($medicine['price'], 0, ',', '.')); ?></p>
                            </td>
                            <td class="py-2 text-center">
                                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(in_array($status, ['pharmacy', 'call_pharmacy'])): ?>
                                    <input type="number" wire:model.lazy="medicines.<?php echo e($key_medicine); ?>.quantity"
                                        placeholder="Qty" class="text-sm border rounded px-2 py-1 w-full"
                                        style="width: 100%;">
                                <?php else: ?>
                                    <span class="text-sm"><?php echo e($medicine['quantity']); ?></span>
                                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                            </td>
                            <td class="py-2 text-right">
                                Rp<?php echo e(number_format($medicine['sub_total_price'], 0, ',', '.')); ?>

                            </td>
                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(in_array($status, ['pharmacy', 'call_pharmacy'])): ?>
                                <td>
                                    <button wire:click="confirmDeleteMedicine('<?php echo e($medicine['id']); ?>')"
                                        class="text-red-500 hover:text-red-700"><i class="fas fa-trash"></i></button>
                                </td>
                            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                        </tr>
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
                </tbody>
                
            </table>
        </div>
    </div>
</div><?php /**PATH /Users/macbookair/Documents/mediction/mediction.id/resources/views/livewire/admin/pharmacy/take-medicine/detail/admin-pharmacy-take-medicine-detail-index.blade.php ENDPATH**/ ?>