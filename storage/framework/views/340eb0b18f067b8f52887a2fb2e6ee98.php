<div>
    <?php echo $__env->make('livewire.admin.sale.pos.detail.admin-sale-pos-detail-modal', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
    <main class="max-w-full mx-auto p-4 pt-16 grid grid-cols-1 lg:grid-cols-4 gap-6" style="margin-top: 50px;">


        <div class="bg-white rounded-xl shadow-md p-4 flex flex-col md:col-span-3">
            <!-- Header with Cart Title and DateTime/User Info -->
            <div class="flex justify-between items-center mb-4">
                <h2 class="font-semibold text-lg">
                    <i class="fas fa-shopping-cart mr-2"></i>Keranjang
                </h2>
                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(in_array($transaction->status, ['draft', 'process', 'take_medicine', 'completed'])): ?>
                    <div class="text-sm text-gray-500 flex flex-col items-end">
                        <div class="flex gap-2 w-full">
                            <div class="relative flex-1 md:w-94">
                                <input wire:model.live='search_sku' type="text" id="skuInput"
                                    placeholder="Masukkan SKU / Scan Barcode"
                                    class="w-full pl-10 pr-4 py-2 bg-blue-50 border border-blue-200 rounded-lg focus:ring-2 focus:ring-[#1E3A8A] focus:outline-none"
                                    autocomplete="off" />
                                <i class="fas fa-barcode absolute left-3 top-1/2 -translate-y-1/2 text-[#1E3A8A]"></i>
                            </div>
                            <!-- Right side buttons -->
                            <div class="flex gap-2">
                                <button
                                    class="px-4 py-2 bg-yellow-500 text-white rounded-lg hover:bg-yellow-900 whitespace-nowrap transition-colors duration-150"
                                    wire:click="openModal()">
                                    <i class="fas fa-search mr-2"></i>Pilih Produk
                                </button>
                            </div>
                        </div>
                    </div>
                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
            </div>

            <div class="flex-1 overflow-y-auto scrollbar-custom">
                <table class="w-full text-sm">
                    <thead>
                        <tr class="border-b">
                            <th class="py-2 text-left">Produk</th>
                            <th class="py-2 text-center">Qty</th>
                            <th class="py-2 text-right">Subtotal</th>
                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(in_array($transaction->status, ['draft', 'process', 'take_medicine', 'completed'])): ?>
                                <th class="py-2 w-8"></th>
                            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__empty_5 = true; $__currentLoopData = $transaction_details; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key_transaction_detail => $transaction_detail): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_5 = false; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoopIteration(); ?><?php endif; ?>
                            <tr
                                class="border-b <?php echo e(isset($transaction_detail['is_free_item']) && $transaction_detail['is_free_item'] ? 'bg-green-50' : ''); ?>">
                                <td class="py-2">
                                    <div class="flex items-start justify-between">
                                        <div class="flex-1">
                                            
                                            <div
                                                class="<?php echo e(isset($transaction_detail['is_parent']) && !$transaction_detail['is_parent'] ? 'ml-6' : ''); ?>">
                                                
                                                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(isset($transaction_detail['is_parent']) && !$transaction_detail['is_parent']): ?>
                                                    <span class="text-gray-400 mr-2">└─</span>
                                                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

                                                <p
                                                    class="font-medium <?php echo e(isset($transaction_detail['is_free_item']) && $transaction_detail['is_free_item'] ? 'text-green-700' : ''); ?>">
                                                    <?php echo e($transaction_detail['product_name']); ?>

                                                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(isset($transaction_detail['is_free_item']) && $transaction_detail['is_free_item']): ?>
                                                        <span
                                                            class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-green-100 text-green-800 ml-2">
                                                            <i class="fas fa-gift mr-1"></i>GRATIS
                                                        </span>
                                                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                                </p>
                                                <p class="text-xs text-gray-500 flex ">
                                                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($transaction_detail['price_discount'] != $transaction_detail['price']): ?>
                                                        <span class="line-through text-red-500 mr-2">
                                                            Rp<?php echo e(number_format($transaction_detail['price_discount'], 0, ',', '.')); ?>

                                                        </span>
                                                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                                    <span
                                                        class="<?php echo e(isset($transaction_detail['is_free_item']) && $transaction_detail['is_free_item'] ? 'text-green-600 font-medium' : ''); ?>">
                                                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(isset($transaction_detail['is_free_item']) && $transaction_detail['is_free_item']): ?>
                                                            GRATIS
                                                            (Rp<?php echo e(number_format($transaction_detail['price_discount'] ?? 0, 0, ',', '.')); ?>)
                                                        <?php else: ?>
                                                            Rp<?php echo e(number_format($transaction_detail['price'], 0, ',', '.')); ?>

                                                        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                                    </span>
                                                </p>
                                                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(isset($transaction_detail['promotion_text']) && $transaction_detail['promotion_text']): ?>
                                                    <p class="text-xs text-green-600 mt-1">
                                                        <i
                                                            class="fas fa-tag mr-1"></i><?php echo e($transaction_detail['promotion_text']); ?>

                                                    </p>
                                                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                            </div>
                                        </div>
                                    </div>
                                </td>
                                <td class="py-2 text-center">
                                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(in_array($transaction->status, ['draft', 'process', 'take_medicine', 'completed'])): ?>
                                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(isset($transaction_detail['is_free_item']) && $transaction_detail['is_free_item']): ?>
                                            
                                            <span
                                                class="text-green-600 font-medium"><?php echo e(number_format($transaction_detail['quantity'], 0, ',', '.')); ?></span>
                                            <div class="text-xs text-green-500 mt-1">Auto</div>
                                        <?php else: ?>
                                            <div class="flex justify-center items-center gap-2">
                                                <button
                                                    wire:click="updateQuantity('<?php echo e($transaction_detail['id']); ?>','decrement')"
                                                    class="w-6 h-6 bg-gray-100 rounded-full hover:bg-gray-200"><i
                                                        class="fas fa-minus text-xs"></i></button>
                                                <input type="number"
                                                    wire:model.lazy='transaction_details.<?php echo e($key_transaction_detail); ?>.quantity'
                                                    class="w-20 h-6 text-center border rounded" />
                                                <button
                                                    wire:click="updateQuantity('<?php echo e($transaction_detail['id']); ?>','increment')"
                                                    class="w-6 h-6 bg-gray-100 rounded-full hover:bg-gray-200"><i
                                                        class="fas fa-plus text-xs"></i></button>
                                            </div>
                                        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                    <?php else: ?>
                                        <?php echo e(number_format($transaction_detail['quantity'], 0, ',', '.')); ?>

                                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                </td>
                                <td class="py-2 text-right">
                                    <span
                                        class="<?php echo e(isset($transaction_detail['is_free_item']) && $transaction_detail['is_free_item'] ? 'text-green-600 font-medium' : ''); ?>">
                                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(isset($transaction_detail['is_free_item']) && $transaction_detail['is_free_item']): ?>
                                            GRATIS
                                        <?php else: ?>
                                            Rp<?php echo e(number_format($transaction_detail['sub_total_price'], 0, ',', '.')); ?>

                                        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                    </span>
                                </td>
                                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(in_array($transaction->status, ['draft', 'process', 'take_medicine', 'completed'])): ?>
                                    <td class="py-2 text-center">
                                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(isset($transaction_detail['is_free_item']) && $transaction_detail['is_free_item']): ?>
                                            
                                            <i class="fas fa-info-circle text-green-500"
                                                title="Item gratis dari promosi"></i>
                                        <?php else: ?>
                                            <button
                                                wire:click="confirmDeleteTransactionDetail('<?php echo e($transaction_detail['id']); ?>')"
                                                class="text-red-500 hover:text-red-700"><i
                                                    class="fas fa-trash"></i></button>
                                        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                    </td>
                                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                            </tr>
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_5): ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
                            <tr>
                                <td colspan="4" class="py-2 text-center text-gray-500">Tidak ada produk dalam
                                    keranjang</td>
                            </tr>
                        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                    </tbody>
                </table>
            </div>

        </div>

        <div class="bg-white rounded-xl shadow-md p-4 flex flex-col">
            <!-- Header Section -->
            <div class="flex justify-between items-center mb-4">
                <h2 class="font-semibold text-lg"><i class="fas fa-credit-card mr-2"></i>Pembayaran</h2>
            </div>

            <!-- Transaction Info Section -->
            <div class="bg-gray-50 rounded-lg p-3 mb-4">
                <div class="grid grid-cols-1 gap-4">
                    <div class="space-y-1">
                        <div class="flex items-center text-sm">
                            <i class="fas fa-receipt text-gray-500 w-5"></i>
                            <span class="text-gray-600"><?php echo e($transaction->code); ?></span>
                        </div>
                        <div class="flex items-center text-sm">
                            <i class="fas fa-user text-gray-500 w-5"></i>
                            <span class="font-medium"><?php echo e($transaction->patient_name); ?></span>
                        </div>
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($transaction->type == 'resep'): ?>
                            <div class="flex items-center text-sm">
                                <i class="fas fa-user-md text-gray-500 w-5"></i>
                                <span class="text-gray-600"><?php echo e($transaction->doctor_name ?? '-'); ?></span>
                            </div>
                            <div class="flex items-center text-sm">
                                <i class="fas fa-id-badge text-gray-500 w-5"></i>
                                <span class="text-gray-600"><?php echo e($transaction->number_recipe ?? '-'); ?></span>
                            </div>
                        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                        <div class="flex items-center text-sm">
                            <i class="fas fa-tag text-gray-500 w-5"></i>
                            <span class="text-gray-600"><?php echo e(Str::title($transaction->type)); ?></span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Main Content -->
            <div class="flex-1 space-y-4">
                <!-- Bill and Discount Section -->
                <div class="grid grid-cols-1 gap-3">
                    
                    <div>
                        <label class="block text-sm font-medium mb-1">Total Tagihan</label>
                        <div class="px-3 py-2 bg-gray-50 border border-gray-200 rounded-lg text-lg font-semibold">
                            Rp <?php echo e(number_format($transaction->grand_total_price, 0, ',', '.')); ?>

                        </div>
                    </div>

                    <!-- Promotion Selection -->
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(in_array($transaction->status, ['draft', 'process', 'take_medicine', 'completed'])): ?>
                        <div>
                            <label class="block text-sm font-medium mb-1">Promosi Diskon</label>
                            <select wire:model.live='promotion_simplified_id'
                                class="w-full px-3 py-2 border border-gray-200 rounded-lg focus:ring-2 focus:ring-[#1E3A8A] focus:outline-none <?php echo e(in_array($transaction->status, ['draft', 'process', 'take_medicine', 'completed']) ? null : 'bg-gray-100 cursor-not-allowed'); ?>">
                                <option value="">Pilih Promosi (Opsional)</option>
                                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__currentLoopData = $availablePromotions; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $promotion): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoopIteration(); ?><?php endif; ?>
                                    <option value="<?php echo e($promotion['id']); ?>">
                                        <?php echo e($promotion['name']); ?> - <?php echo e($promotion['discount_text']); ?>

                                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($promotion['minimum_purchase'] > 0): ?>
                                            (Min. Rp <?php echo e(number_format($promotion['minimum_purchase'], 0, ',', '.')); ?>)
                                        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                    </option>
                                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
                            </select>
                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($promotionSummary): ?>
                                <div class="mt-2 p-2 bg-green-50 border border-green-200 rounded text-sm">
                                    <div class="flex items-center text-green-700">
                                        <i class="fas fa-tag mr-2"></i>
                                        <span class="font-medium"><?php echo e($promotionSummary['name']); ?></span>
                                    </div>
                                    <div class="text-green-600 mt-1">
                                        Hemat: Rp
                                        <?php echo e(number_format($promotionSummary['discount_amount'], 0, ',', '.')); ?>

                                    </div>
                                </div>
                            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                        </div>
                    <?php elseif($transaction->promotion_simplified_id): ?>
                        <div>
                            <label class="block text-sm font-medium mb-1">Promosi Diterapkan</label>
                            <div class="px-3 py-2 bg-green-50 border border-green-200 rounded-lg">
                                <div class="flex items-center text-green-700">
                                    <i class="fas fa-tag mr-2"></i>
                                    <span
                                        class="font-medium"><?php echo e($promotionSummary['name'] ?? 'Promosi Aktif'); ?></span>
                                </div>
                                <div class="text-green-600 text-sm mt-1">
                                    Hemat: Rp <?php echo e(number_format($transaction->promotion_real ?? 0, 0, ',', '.')); ?>

                                </div>
                            </div>
                        </div>
                    <?php else: ?>
                        <div>
                            <label class="block text-sm font-medium mb-1">Promosi Diskon</label>
                            <select wire:model.live='promotion_simplified_id' disabled
                                class="w-full px-3 py-2 border border-gray-200 rounded-lg focus:ring-2 focus:ring-[#1E3A8A] focus:outline-none">
                                <option value="">Pilih Promosi (Opsional)</option>
                                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__currentLoopData = $availablePromotions; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $promotion): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoopIteration(); ?><?php endif; ?>
                                    <option value="<?php echo e($promotion['id']); ?>">
                                        <?php echo e($promotion['name']); ?> - <?php echo e($promotion['discount_text']); ?>

                                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($promotion['minimum_purchase'] > 0): ?>
                                            (Min. Rp <?php echo e(number_format($promotion['minimum_purchase'], 0, ',', '.')); ?>)
                                        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                    </option>
                                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
                            </select>
                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($promotionSummary): ?>
                                <div class="mt-2 p-2 bg-green-50 border border-green-200 rounded text-sm">
                                    <div class="flex items-center text-green-700">
                                        <i class="fas fa-tag mr-2"></i>
                                        <span class="font-medium"><?php echo e($promotionSummary['name']); ?></span>
                                    </div>
                                    <div class="text-green-600 mt-1">
                                        Hemat: Rp
                                        <?php echo e(number_format($promotionSummary['discount_amount'], 0, ',', '.')); ?>

                                    </div>
                                </div>
                            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                        </div>
                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

                    <div>
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(in_array($transaction->status, ['draft', 'process', 'take_medicine', 'completed'])): ?>
                            <label class="block text-sm font-medium mb-1">Diskon</label>
                            <div class="relative">
                                <select wire:model.live='discount_type'
                                    <?php echo e(in_array($transaction->status, ['draft', 'process', 'take_medicine', 'completed']) ? null : 'disabled'); ?>

                                    class="absolute left-0 top-0 h-full w-16 border-r border-gray-200 rounded-l-lg text-sm text-center appearance-none bg-gray-50 hover:bg-gray-100 focus:ring-2 focus:ring-[#1E3A8A] focus:outline-none">
                                    <option value="rupiah">Rp</option>
                                    <option value="percentage">%</option>
                                </select>
                                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($discount_type == 'percentage'): ?>
                                    <input type="number" wire:model.lazy='discount' placeholder="Diskon (%)"
                                        <?php echo e(in_array($transaction->status, ['draft', 'process', 'take_medicine', 'completed']) ? null : 'disabled'); ?>

                                        class="w-full pl-18 px-3 py-2 border border-gray-200 rounded-lg focus:ring-2 focus:ring-[#1E3A8A] focus:outline-none" />
                                <?php else: ?>
                                    <input type="text" onkeyup="convertToRupiah(this)" wire:model.lazy='discount'
                                        <?php echo e(in_array($transaction->status, ['draft', 'process', 'take_medicine', 'completed']) ? null : 'disabled'); ?>

                                        class="w-full pl-18 px-3 py-2 border border-gray-200 rounded-lg focus:ring-2 focus:ring-[#1E3A8A] focus:outline-none"
                                        placeholder="0" />
                                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                            </div>
                        <?php else: ?>
                            <label class="block text-sm font-medium mb-1">Diskon</label>
                            <div class="px-3 py-2 bg-gray-50 border border-gray-200 rounded-lg text-lg font-semibold">
                                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($transaction->discount_type == 'percentage'): ?>
                                    <?php echo e($transaction->discount); ?> %
                                <?php else: ?>
                                    Rp <?php echo e(number_format($transaction->discount, 0, ',', '.')); ?>

                                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                            </div>
                        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                    </div>
                </div>
                <!-- Payment Methods Section -->
                <div class="space-y-3">
                    <div class="flex justify-between items-center">
                        <label class="block text-sm font-medium">Metode Pembayaran</label>
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(in_array($transaction->status, ['draft', 'process', 'take_medicine', 'completed'])): ?>
                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if((float) $transaction->remaining_bill > 0): ?>
                                <button class="text-sm text-blue-600 hover:text-blue-800"
                                    wire:click="openModalPayment()">
                                    <i class="fas fa-plus-circle mr-1"></i>Tambah Metode
                                </button>
                            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                    </div>
                </div>
                <!-- Summary Section -->
                <div class="bg-gray-50 rounded-lg p-3">
                    
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(method_exists($this, 'getBuyXGetYPromotionSummary')): ?>
                        <?php $promotionSummary = $this->getBuyXGetYPromotionSummary(); ?>
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($promotionSummary && count($promotionSummary['savings']) > 0): ?>
                            <div class="mb-2 p-2 bg-green-50 rounded border border-green-200">
                                <div class="flex items-center mb-1">
                                    <i class="fas fa-gift text-green-600 mr-2"></i>
                                    <span class="text-sm font-medium text-green-800">Promosi Buy X Get Y</span>
                                </div>
                                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__currentLoopData = $promotionSummary['savings']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $saving): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoopIteration(); ?><?php endif; ?>
                                    <div class="flex justify-between items-center text-xs">
                                        <span class="text-green-700"><?php echo e($saving['description']); ?></span>
                                        <span class="font-medium text-green-800">Hemat
                                            Rp<?php echo e(number_format($saving['amount'], 0, ',', '.')); ?></span>
                                    </div>
                                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
                                <div
                                    class="flex justify-between items-center text-sm font-semibold border-t border-green-300 pt-1 mt-1">
                                    <span class="text-green-800">Total Hemat</span>
                                    <span
                                        class="text-green-800">Rp<?php echo e(number_format($promotionSummary['total_savings'], 0, ',', '.')); ?></span>
                                </div>
                            </div>
                        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

                    
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($transaction->promotion_simplified_id && $transaction->promotion_real > 0): ?>
                        <div class="mb-2 p-2 bg-blue-50 rounded border border-blue-200">
                            <div class="flex items-center mb-1">
                                <i class="fas fa-percentage text-blue-600 mr-2"></i>
                                <span class="text-sm font-medium text-blue-800">Promosi Diskon</span>
                            </div>
                            <div class="flex justify-between items-center text-xs">
                                <span class="text-blue-700"><?php echo e($promotionSummary['name'] ?? 'Promosi Aktif'); ?></span>
                                <span class="font-medium text-blue-800">Hemat
                                    Rp<?php echo e(number_format($transaction->promotion_real, 0, ',', '.')); ?></span>
                            </div>
                        </div>
                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

                    <div class="flex justify-between items-center">
                        <span class="text-sm text-gray-600">Promosi</span>
                        <span class="text-sm font-semibold text-[#1E3A8A]">Rp
                            <?php echo e(number_format($transaction->promotion_real ?? 0, 0, ',', '.')); ?></span>
                    </div>
                    <div class="flex justify-between items-center">
                        <span class="text-sm text-gray-600">Diskon</span>
                        <span class="text-sm font-semibold text-[#1E3A8A]">Rp
                            <?php echo e(number_format($transaction->discount_value, 0, ',', '.')); ?></span>
                    </div>
                    <div class="flex justify-between items-center">
                        <span class="text-sm text-gray-600">Pembulatan</span>
                        <span class="text-sm font-semibold text-[#1E3A8A]">Rp
                            <?php echo e(number_format($transaction->rounding, 0, ',', '.')); ?></span>
                    </div>
                    <div class="flex justify-between items-center">
                        <span class="text-sm text-gray-600">Total Pembayaran</span>
                        <span class="text-sm font-semibold text-[#1E3A8A]">Rp
                            <?php echo e(number_format($transaction->grand_total_price, 0, ',', '.')); ?></span>
                    </div>
                    <hr class="my-1">
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__currentLoopData = $transactionPayments; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $transactionPayment): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoopIteration(); ?><?php endif; ?>
                        <div class="flex justify-between items-center">
                            <span class="text-sm text-gray-600"><?php echo e($transactionPayment->paymentMethod->name); ?></span>
                            <span class="text-sm font-semibold text-[#1E3A8A]">Rp
                                <?php echo e(number_format($transactionPayment->payment_amount, 0, ',', '.')); ?>

                                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(in_array($transaction->status, ['draft', 'process', 'take_medicine', 'completed'])): ?>
                                    <button
                                        wire:click="confirmDeleteTransactionPayment('<?php echo e($transactionPayment->id); ?>')"
                                        class="text-red-500 hover:text-red-700"><i class="fas fa-trash"></i></button>
                                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                            </span>
                        </div>
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
                    <hr class="my-1">
                    <div class="flex justify-between items-center">
                        <span class="text-sm text-gray-600">Total Terbayar</span>
                        <span class="text-sm font-semibold text-[#1E3A8A]">Rp
                            <?php echo e(number_format($transaction->payment_amount, 0, ',', '.')); ?></span>
                    </div>
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($transaction->is_single_payment): ?>
                        <div class="flex justify-between items-center">
                            <span class="text-sm text-gray-600">Biaya Admin</span>
                            <span class="text-sm font-semibold text-[#1E3A8A]">Rp
                                <?php echo e(number_format($transaction->single_payment_admin_fee, 0, ',', '.')); ?></span>
                        </div>
                        <div class="flex justify-between items-center">
                            <span class="text-sm text-gray-600">Total</span>
                            <span class="text-sm font-semibold text-[#1E3A8A]">Rp
                                <?php echo e(number_format($transaction->grand_total_price_admin_fee, 0, ',', '.')); ?></span>
                        </div>
                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                    <div class="flex justify-between items-center">
                        <span class="text-sm text-gray-600">Sisa Tagihan</span>
                        <span class="text-sm font-semibold text-red-500">Rp
                            <?php echo e(number_format($transaction->remaining_bill, 0, ',', '.')); ?></span>
                    </div>
                    <div class="flex justify-between items-center">
                        <span class="text-sm text-gray-600">Kembalian</span>
                        <span class="text-sm font-semibold text-red-500">Rp
                            <?php echo e(number_format($transaction->payment_change, 0, ',', '.')); ?></span>
                    </div>
                </div>
            </div>

            <!-- Action Buttons -->
            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($transaction->status == 'draft'): ?>
                <div class="grid grid-cols-3 gap-3 mt-4">
                    <button wire:click='confirmResetTransaction()' type="button"
                        class="px-4 py-2 border border-gray-200 rounded-lg hover:bg-gray-50 flex items-center justify-center gap-2">
                        <i class="fas fa-trash"></i>
                        <span>Reset</span>
                    </button>
                    <button wire:click="confirmSaveTransaction('draft')" type="button"
                        class="px-4 py-2 bg-green-500 text-white rounded-lg hover:bg-green-600 flex items-center justify-center gap-2">
                        <i class="fas fa-file-lines"></i>
                        <span>Draft</span>
                    </button>
                    <button wire:click="confirmSaveTransaction('process')" type="button"
                        class="px-4 py-2 bg-[#1E3A8A] text-white rounded-lg hover:bg-blue-900 flex items-center justify-center gap-2">
                        <i class="fas fa-check"></i>
                        <span>Proses</span>
                    </button>
                </div>
            <?php elseif(in_array($transaction->status, ['process', 'take_medicine', 'completed'])): ?>
                <div class="grid grid-cols-2 gap-3 mt-4">
                    <button wire:click="confirmDeleteTransaction()" type="button"
                        class="px-4 py-2 bg-red-500 text-white rounded-lg hover:bg-red-600 flex items-center justify-center gap-2">
                        <i class="fas fa-trash"></i>
                        <span>Batalkan</span>
                    </button>
                    <button wire:click="confirmSaveTransaction('completed')" type="button"
                        class="px-4 py-2 bg-green-500 text-white rounded-lg hover:bg-green-600 flex items-center justify-center gap-2">
                        <i class="fas fa-file-lines"></i>
                        <span>Selesai</span>
                    </button>
                </div>
                
            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
        </div>
    </main>
</div>

    <?php
        $__scriptKey = '2670377074-0';
        ob_start();
    ?>
    <script>
        // Listen for promotion-removed event
        $wire.on('promotion-removed', (event) => {
            const data = event[0] || event;

            // Show toast notification using Livewire Alert (if available)
            if (window.LivewireAlert) {
                window.LivewireAlert.alert('warning', data.message, {
                    timer: 5000,
                    timerProgressBar: true,
                    showConfirmButton: false,
                    position: 'top-end',
                    toast: true
                });
            } else {
                // Fallback to browser alert
                alert('⚠️ ' + data.message);
            }

            console.log('Promotion removed:', data.message);
        });
    </script>
    <?php
        $__output = ob_get_clean();

        \Livewire\store($this)->push('scripts', $__output, $__scriptKey)
    ?><?php /**PATH /Users/macbookair/Documents/mediction/mediction.id/resources/views/livewire/admin/sale/pos/detail/admin-sale-pos-detail-index.blade.php ENDPATH**/ ?>