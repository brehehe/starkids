<div>
    <?php echo $__env->make('livewire.admin.sale.pos.detail.admin-sale-pos-detail-modal', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
    <main class="max-w-full mx-auto p-4 pt-16 grid grid-cols-1 lg:grid-cols-4 gap-6" style="margin-top: 50px;">


        <div class="bg-white rounded-xl shadow-md p-4 flex flex-col md:col-span-3">
            <!-- Header with Cart Title and DateTime/User Info -->
            <div class="flex justify-between items-center mb-4">
                <h2 class="font-semibold text-lg">
                    <i class="fas fa-shopping-cart mr-2"></i>Keranjang
                </h2>
                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(in_array($transaction->status, ['draft', 'process'])): ?>
                    <div class="text-sm text-gray-500 flex flex-col items-end">
                        <div class="flex gap-2 w-full">
                            <div class="relative flex-1 md:w-94">
                                <input wire:model.lazy='search_sku' type="text" id="skuInput"
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
                            <th class="py-2 text-left">Quantity Request</th>
                            <th class="py-2 text-center">Quantity</th>
                            <th class="py-2 text-right">Subtotal</th>
                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(in_array($transaction->status, ['draft', 'process'])): ?>
                                <th class="py-2 w-8"></th>
                            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__currentLoopData = $actions; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key_action => $action): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoopIteration(); ?><?php endif; ?>
                            <tr class="border-b">
                                <td class="py-2" colspan="2">
                                    <p class="font-medium"><?php echo e($action['product_name']); ?></p>
                                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($is_editable_price_pos && in_array($transaction->status,['draft','process'])): ?>
                                        <div class="flex gap-2 mt-2">
                                            <div class="flex items-center border rounded px-2 py-1 bg-white" title="Harga Awal">
                                                <span class="text-gray-500 mr-1 text-xs select-none">Rp</span>
                                                <input type="text" onkeyup="convertToRupiah(this)"
                                                    wire:model.lazy='actions.<?php echo e($key_action); ?>.price'
                                                    class="text-xs bg-transparent text-gray-700 focus:outline-none w-24" placeholder="Harga" />
                                            </div>
                                            <div class="flex items-center border rounded bg-white overflow-hidden" title="Tipe & Nominal Diskon">
                                                <select wire:model='actions.<?php echo e($key_action); ?>.discount_type' class="text-xs bg-gray-50 border-r py-1 px-1 focus:outline-none text-gray-600 appearance-none font-medium text-center cursor-pointer">
                                                    <option value="nominal">Rp</option>
                                                    <option value="percentage">%</option>
                                                </select>
                                                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(($action['discount_type'] ?? 'nominal') == 'percentage'): ?>
                                                    <input type="text"
                                                        wire:model.lazy='actions.<?php echo e($key_action); ?>.discount_input'
                                                        class="text-xs bg-transparent text-red-500 focus:outline-none w-24 px-2 py-1" placeholder="0" />
                                                <?php else: ?>
                                                    <input type="text" onkeyup="convertToRupiah(this)"
                                                        wire:model.lazy='actions.<?php echo e($key_action); ?>.discount_input'
                                                        class="text-xs bg-transparent text-red-500 focus:outline-none w-24 px-2 py-1" placeholder="0" />
                                                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                            </div>
                                        </div>
                                    <?php else: ?>
                                        <p class="text-xs text-gray-500">
                                            @Rp<?php echo e(number_format($action['price'], 0, ',', '.')); ?>

                                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(isset($action['discount']) && $action['discount'] > 0): ?>
                                                <span class="text-red-500 ml-1">(-Rp<?php echo e(number_format($action['discount'], 0, ',', '.')); ?>)</span>
                                            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                        </p>
                                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                </td>
                                <td class="py-2 text-center">
                                    <?php echo e($action['quantity']); ?>

                                </td>
                                <td class="py-2 text-right">
                                    Rp<?php echo e(number_format($action['sub_total_price'], 0, ',', '.')); ?></td>
                            </tr>
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__currentLoopData = $transaction_details; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $transaction_detail): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoopIteration(); ?><?php endif; ?>
                            <tr class="border-t-4">
                                <td colspan="3" class="py-3 px-2">
                                    <div class="flex items-center gap-2">
                                        <span class="font-medium text-blue-600">/R-<?php echo e($key + 1); ?></span>
                                        <select
                                            <?php echo e(in_array($transaction->status, ['draft', 'process']) ? null : 'disabled'); ?>

                                            class="<?php echo e(in_array($transaction->status, ['draft', 'process']) ? null : 'bg-gray-100 cursor-not-allowed'); ?> text-sm border rounded px-2 py-1"
                                            wire:model.lazy='transaction_details.<?php echo e($key); ?>.medicine_type_id'>
                                            <option value="">Jenis Resep</option>
                                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__currentLoopData = $medicine_types; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $medicine_type): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoopIteration(); ?><?php endif; ?>
                                                <option value="<?php echo e($medicine_type['id']); ?>"><?php echo e($medicine_type['name']); ?>

                                                </option>
                                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
                                        </select>
                                        <div
                                            class="flex items-center border rounded px-2 py-1 w-30 bg-gray-100 cursor-not-allowed">
                                            <span class="text-gray-500 mr-2 select-none">Rp</span>
                                            <input type="text" disabled
                                                wire:model='transaction_details.<?php echo e($key); ?>.price_service_one'
                                                placeholder="Jasa 1"
                                                class="text-sm bg-gray-100 text-gray-500 focus:outline-none w-full cursor-not-allowed" />
                                        </div>
                                        <input type="text"
                                            <?php echo e(in_array($transaction->status, ['draft', 'process']) ? null : 'disabled'); ?>

                                            wire:model.lazy='transaction_details.<?php echo e($key); ?>.numero_recipe'
                                            placeholder="Numero Resep"
                                            class="<?php echo e(in_array($transaction->status, ['draft', 'process']) ? null : 'bg-gray-100 cursor-not-allowed'); ?> text-sm border rounded px-2 py-1 w-30">
                                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(!$transaction_detail['is_single']): ?>
                                            <select
                                                <?php echo e(in_array($transaction->status, ['draft', 'process']) ? null : 'disabled'); ?>

                                                class="<?php echo e(in_array($transaction->status, ['draft', 'process']) ? null : 'bg-gray-100 cursor-not-allowed'); ?> text-sm border rounded px-2 py-1"
                                                wire:model.lazy='transaction_details.<?php echo e($key); ?>.product_id'>
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
                                            <div
                                                class="flex items-center border rounded px-2 py-1 w-30 bg-gray-100 cursor-not-allowed">
                                                <span class="text-gray-500 mr-2 select-none">Rp</span>
                                                <input type="text" disabled
                                                    wire:model='transaction_details.<?php echo e($key); ?>.sub_total_price'
                                                    placeholder="Jasa 1"
                                                    class="text-sm bg-gray-100 text-gray-500 focus:outline-none w-full cursor-not-allowed" />
                                            </div>
                                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(in_array($transaction->status, ['draft', 'process'])): ?>
                                                <button class="text-blue-500 hover:text-blue-700"
                                                    wire:click="addDetail('<?php echo e($transaction_detail['id']); ?>')">
                                                    <i class="fas fa-plus"></i>
                                                </button>
                                            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(in_array($transaction->status, ['draft', 'process'])): ?>
                                            <button class="text-red-600 hover:text-red-800 mx-1"
                                                wire:click="confirmDeleteTransactionRecipe('<?php echo e($transaction_detail['id']); ?>')"
                                                title="Hapus">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                    </div>
                                    <div class="mt-2 text-sm text-gray-600">
                                        <input type="text"
                                            <?php echo e(in_array($transaction->status, ['draft', 'process']) ? null : 'disabled'); ?>

                                            wire:model.lazy='transaction_details.<?php echo e($key); ?>.description'
                                            placeholder="Aturan Pakai"
                                            class="<?php echo e(in_array($transaction->status, ['draft', 'process']) ? null : 'bg-gray-100 cursor-not-allowed'); ?> w-full border rounded px-2 py-1">
                                    </div>
                                    <div class="mt-2 text-sm text-gray-600">
                                        <input type="text"
                                            <?php echo e(in_array($transaction->status, ['draft', 'process']) ? null : 'disabled'); ?>

                                            wire:model.lazy='transaction_details.<?php echo e($key); ?>.notes'
                                            placeholder="Catatan Resep"
                                            class="<?php echo e(in_array($transaction->status, ['draft', 'process']) ? null : 'bg-gray-100 cursor-not-allowed'); ?> w-full border rounded px-2 py-1">
                                    </div>
                                </td>
                            </tr>
                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(!empty($transaction_detail['details'])): ?>
                                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__currentLoopData = $transaction_detail['details']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoopIteration(); ?><?php endif; ?>
                                    <tr class="border-b">
                                        <td class="py-2" colspan="<?php echo e(!$transaction_detail['is_single'] ? 1 : 2); ?>">
                                            <p class="font-medium"><?php echo e($item['product_name']); ?></p>
                                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($is_editable_price_pos && in_array($transaction->status,['draft','process']) && (!isset($item['is_free_item']) || !$item['is_free_item'])): ?>
                                                <div class="flex gap-2 mt-2">
                                                    <div class="flex items-center border rounded px-2 py-1 bg-white" title="Harga Awal">
                                                        <span class="text-gray-500 mr-1 text-xs select-none">Rp</span>
                                                        <input type="text" onkeyup="convertToRupiah(this)"
                                                            wire:model.blur='transaction_details.<?php echo e($key); ?>.details.<?php echo e($index); ?>.price'
                                                            wire:blur="changedDetailField('<?php echo e($key); ?>', '<?php echo e($index); ?>', 'price')"
                                                            class="text-xs bg-transparent text-gray-700 focus:outline-none w-24" placeholder="Harga" />
                                                    </div>
                                                    <div class="flex items-center border rounded bg-white overflow-hidden" title="Tipe & Nominal Diskon">
                                                        <select
                                                            wire:model.blur='transaction_details.<?php echo e($key); ?>.details.<?php echo e($index); ?>.discount_type'
                                                            wire:blur="changedDetailField('<?php echo e($key); ?>', '<?php echo e($index); ?>', 'discount_type')"
                                                            class="text-xs bg-gray-50 border-r py-1 px-1 focus:outline-none text-gray-600 appearance-none font-medium text-center cursor-pointer">
                                                            <option value="nominal" <?php echo e(($item['discount_type'] ?? 'nominal') == 'nominal' ? 'selected' : ''); ?>>Rp</option>
                                                            <option value="percentage" <?php echo e(($item['discount_type'] ?? 'nominal') == 'percentage' ? 'selected' : ''); ?>>%</option>
                                                        </select>
                                                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(($item['discount_type'] ?? 'nominal') == 'percentage'): ?>
                                                            <input type="text"
                                                                wire:model.blur='transaction_details.<?php echo e($key); ?>.details.<?php echo e($index); ?>.discount_input'
                                                                wire:blur="changedDetailField('<?php echo e($key); ?>', '<?php echo e($index); ?>', 'discount_input')"
                                                                class="text-xs bg-transparent text-red-500 focus:outline-none w-24 px-2 py-1" placeholder="0" />
                                                        <?php else: ?>
                                                            <input type="text" onkeyup="convertToRupiah(this)"
                                                                wire:model.blur='transaction_details.<?php echo e($key); ?>.details.<?php echo e($index); ?>.discount_input'
                                                                wire:blur="changedDetailField('<?php echo e($key); ?>', '<?php echo e($index); ?>', 'discount_input')"
                                                                class="text-xs bg-transparent text-red-500 focus:outline-none w-24 px-2 py-1" placeholder="0" />
                                                        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                                    </div>
                                                </div>
                                            <?php else: ?>
                                                <p class="text-xs text-gray-500 flex ">
                                                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(isset($item['price_discount']) && $item['price_discount'] != $item['price']): ?>
                                                        <span class="line-through text-red-500 mr-2">
                                                            Rp<?php echo e(number_format($item['price_discount'], 0, ',', '.')); ?>

                                                        </span>
                                                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                                    <span
                                                        class="<?php echo e(isset($item['is_free_item']) && $item['is_free_item'] ? 'text-green-600 font-medium' : ''); ?>">
                                                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(isset($item['is_free_item']) && $item['is_free_item']): ?>
                                                            GRATIS
                                                            (Rp<?php echo e(number_format($item['price_discount'] ?? 0, 0, ',', '.')); ?>)
                                                        <?php else: ?>
                                                            Rp<?php echo e(number_format($item['price'], 0, ',', '.')); ?>

                                                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(isset($item['discount']) && $item['discount'] > 0): ?>
                                                                <span class="text-red-500 ml-1">(-Rp<?php echo e(number_format($item['discount'], 0, ',', '.')); ?>)</span>
                                                            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                                        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                                    </span>
                                                </p>
                                            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                        </td>
                                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(!$transaction_detail['is_single']): ?>
                                            <td class="py-2">
                                                <input
                                                    wire:model.blur="transaction_details.<?php echo e($key); ?>.details.<?php echo e($index); ?>.quantity"
                                                    wire:blur="changedDetailField('<?php echo e($key); ?>', '<?php echo e($index); ?>', 'quantity')"
                                                    type="text" placeholder="Quantity Permintaan"
                                                    <?php echo e(in_array($transaction->status, ['draft', 'process']) ? null : 'disabled'); ?>

                                                    class="<?php echo e(in_array($transaction->status, ['draft', 'process']) ? null : 'bg-gray-100 cursor-not-allowed'); ?> text-sm border rounded px-2 py-1 w-48">
                                            </td>
                                        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                        <td class="py-2 text-center">
                                            <?php echo e($item['quantity']); ?>

                                        </td>
                                        <td class="py-2 text-right">
                                            Rp<?php echo e(number_format($item['sub_total_price'], 0, ',', '.')); ?></td>
                                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(in_array($transaction->status, ['draft', 'process'])): ?>
                                            <td class="py-2 text-center">
                                                <button
                                                    wire:click="confirmDeleteTransactionDetail('<?php echo e($item['id']); ?>')"
                                                    class="text-red-500 hover:text-red-700"><i
                                                        class="fas fa-trash"></i></button>
                                            </td>
                                        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                    </tr>
                                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
                            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__empty_2 = true; $__currentLoopData = $medicines; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key_medicine => $medicine): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_2 = false; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoopIteration(); ?><?php endif; ?>
                            <tr
                                class="border-b <?php echo e(isset($medicine['is_free_item']) && $medicine['is_free_item'] ? 'bg-green-50' : 'border-t-4'); ?>">
                                <td class="py-2" colspan="5">
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
                                                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($is_editable_price_pos && in_array($transaction->status,['draft','process']) && (!isset($medicine['is_free_item']) || !$medicine['is_free_item'])): ?>
                                                    <div class="flex gap-2 mt-2">
                                                        <div class="flex items-center border rounded px-2 py-1 bg-white" title="Harga Awal">
                                                            <span class="text-gray-500 mr-1 text-xs select-none">Rp</span>
                                                            <input type="text" onkeyup="convertToRupiah(this)"
                                                                wire:model.lazy='medicines.<?php echo e($key_medicine); ?>.price'
                                                                class="text-xs bg-transparent text-gray-700 focus:outline-none w-24" placeholder="Harga" />
                                                        </div>
                                                        <div class="flex items-center border rounded bg-white overflow-hidden" title="Tipe & Nominal Diskon">
                                                            <select wire:model='medicines.<?php echo e($key_medicine); ?>.discount_type' class="text-xs bg-gray-50 border-r py-1 px-1 focus:outline-none text-gray-600 appearance-none font-medium text-center cursor-pointer">
                                                                <option value="nominal">Rp</option>
                                                                <option value="percentage">%</option>
                                                            </select>
                                                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(($medicine['discount_type'] ?? 'nominal') == 'percentage'): ?>
                                                                <input type="text"
                                                                    wire:model.lazy='medicines.<?php echo e($key_medicine); ?>.discount_input'
                                                                    class="text-xs bg-transparent text-red-500 focus:outline-none w-24 px-2 py-1" placeholder="0" />
                                                            <?php else: ?>
                                                                <input type="text" onkeyup="convertToRupiah(this)"
                                                                    wire:model.lazy='medicines.<?php echo e($key_medicine); ?>.discount_input'
                                                                    class="text-xs bg-transparent text-red-500 focus:outline-none w-24 px-2 py-1" placeholder="0" />
                                                            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                                        </div>
                                                    </div>
                                                <?php else: ?>
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

                                                                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(isset($medicine['discount']) && $medicine['discount'] > 0): ?>
                                                                    <span class="text-red-500 ml-1">(-Rp<?php echo e(number_format($medicine['discount'], 0, ',', '.')); ?>)</span>
                                                                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                                            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                                        </span>
                                                    </p>
                                                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(isset($medicine['promotion_text']) && $medicine['promotion_text']): ?>
                                                    <p class="text-xs text-green-600 mt-1">
                                                        <i
                                                            class="fas fa-tag mr-1"></i><?php echo e($medicine['promotion_text']); ?>

                                                    </p>
                                                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                            </div>
                                        </div>
                                    </div>
                                </td>
                                <td class="py-2 text-center">
                                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($transaction->status == 'draft'): ?>
                                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(isset($medicine['is_free_item']) && $medicine['is_free_item']): ?>
                                            
                                            <span
                                                class="text-green-600 font-medium"><?php echo e(number_format($medicine['quantity'], 0, ',', '.')); ?></span>
                                            <div class="text-xs text-green-500 mt-1">Auto</div>
                                        <?php else: ?>
                                            <div class="flex justify-center items-center gap-2">
                                                <button
                                                    wire:click="updateQuantity('<?php echo e($medicine['id']); ?>','decrement')"
                                                    class="w-6 h-6 bg-gray-100 rounded-full hover:bg-gray-200"><i
                                                        class="fas fa-minus text-xs"></i></button>
                                                <input type="number"
                                                    wire:model.lazy='medicines.<?php echo e($key_medicine); ?>.quantity'
                                                    class="w-20 h-6 text-center border rounded" />
                                                <button
                                                    wire:click="updateQuantity('<?php echo e($medicine['id']); ?>','increment')"
                                                    class="w-6 h-6 bg-gray-100 rounded-full hover:bg-gray-200"><i
                                                        class="fas fa-plus text-xs"></i></button>
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
                                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($transaction->status == 'draft'): ?>
                                    <td class="py-2 text-center">
                                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(isset($medicine['is_free_item']) && $medicine['is_free_item']): ?>
                                            
                                            <i class="fas fa-info-circle text-green-500"
                                                title="Item gratis dari promosi"></i>
                                        <?php else: ?>
                                            <button
                                                wire:click="confirmDeleteTransactionDetail('<?php echo e($medicine['id']); ?>')"
                                                class="text-red-500 hover:text-red-700"><i
                                                    class="fas fa-trash"></i></button>
                                        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                    </td>
                                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                            </tr>
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
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
                            Rp <?php echo e(number_format($transaction->sub_total_price, 0, ',', '.')); ?>

                        </div>
                    </div>
                    <!-- Promotion Selection -->
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(in_array($transaction->status, ['draft', 'process'])): ?>
                        <div>
                            <label class="block text-sm font-medium mb-1">
                                Promosi Diskon
                                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($has_deposit): ?>
                                    <span class="text-xs text-orange-600">(Nonaktif - Menggunakan Deposit)</span>
                                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                            </label>
                            <select wire:model.live='promotion_simplified_id' <?php echo e($has_deposit ? 'disabled' : ''); ?>

                                class="w-full px-3 py-2 border border-gray-200 rounded-lg focus:ring-2 focus:ring-[#1E3A8A] focus:outline-none <?php echo e($has_deposit ? 'bg-gray-100 cursor-not-allowed' : ''); ?>">
                                <option value="">
                                    <?php echo e($has_deposit ? 'Nonaktif karena deposit' : 'Pilih Promosi (Opsional)'); ?>

                                </option>
                                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(!$has_deposit): ?>
                                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__currentLoopData = $availablePromotions; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $promotion): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoopIteration(); ?><?php endif; ?>
                                        <option value="<?php echo e($promotion['id']); ?>">
                                            <?php echo e($promotion['name']); ?> - <?php echo e($promotion['discount_text']); ?>

                                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($promotion['minimum_purchase'] > 0): ?>
                                                (Min. Rp
                                                <?php echo e(number_format($promotion['minimum_purchase'], 0, ',', '.')); ?>)
                                            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                        </option>
                                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
                                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                            </select>
                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($has_deposit): ?>
                                <div class="mt-2 p-2 bg-orange-50 border border-orange-200 rounded text-sm">
                                    <div class="flex items-center text-orange-700">
                                        <i class="fas fa-money-bill-wave mr-2"></i>
                                        <span class="font-medium">Menggunakan Deposit</span>
                                    </div>
                                    <div class="text-orange-600 mt-1">
                                        Diskon otomatis: Rp <?php echo e(number_format($deposit_discount_amount, 0, ',', '.')); ?>

                                    </div>
                                </div>
                            <?php elseif($promotionSummary): ?>
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
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(in_array($transaction->status, ['draft', 'process'])): ?>
                            <label class="block text-sm font-medium mb-1">
                                Diskon
                                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($has_deposit): ?>
                                    <span class="text-xs text-orange-600">(Otomatis dari Deposit)</span>
                                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                            </label>
                            <div class="relative">
                                <select wire:model.lazy='discount_type' <?php echo e($has_deposit ? 'disabled' : ''); ?>

                                    class="absolute left-0 top-0 h-full w-16 border-r border-gray-200 rounded-l-lg text-sm text-center appearance-none <?php echo e($has_deposit ? 'bg-gray-100 cursor-not-allowed' : 'bg-gray-50 hover:bg-gray-100'); ?> focus:ring-2 focus:ring-[#1E3A8A] focus:outline-none">
                                    <option value="rupiah">Rp</option>
                                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(!$has_deposit): ?>
                                        <option value="percentage">%</option>
                                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                </select>
                                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($discount_type == 'percentage' && !$has_deposit): ?>
                                    <input type="number" wire:model.lazy='discount' placeholder="Diskon (%)"
                                        class="w-full pl-18 px-3 py-2 border border-gray-200 rounded-lg focus:ring-2 focus:ring-[#1E3A8A] focus:outline-none" />
                                <?php else: ?>
                                    <input type="text" onkeyup="convertToRupiah(this)" wire:model.lazy='discount'
                                        <?php echo e($has_deposit ? 'readonly' : ''); ?>

                                        class="w-full pl-18 px-3 py-2 border border-gray-200 rounded-lg focus:ring-2 focus:ring-[#1E3A8A] focus:outline-none <?php echo e($has_deposit ? 'bg-gray-100 cursor-not-allowed' : ''); ?>"
                                        placeholder="<?php echo e($has_deposit ? 'Diskon otomatis dari deposit' : '0'); ?>" />
                                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                            </div>
                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($has_deposit): ?>
                                <div class="mt-1 text-xs text-orange-600">
                                    <i class="fas fa-info-circle mr-1"></i>
                                    Diskon diatur otomatis sesuai nilai deposit
                                </div>
                            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                        <?php else: ?>
                            <label class="block text-sm font-medium mb-1">Diskon</label>
                            <div class="px-3 py-2 bg-gray-50 border border-gray-200 rounded-lg text-lg font-semibold">
                                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($transaction->discount_type == 'percentage'): ?>
                                    <?php echo e($transaction->discount); ?> %
                                <?php else: ?>
                                    Rp <?php echo e(number_format($transaction->discount, 0, ',', '.')); ?>

                                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($has_deposit): ?>
                                    <span class="text-xs text-orange-600 ml-2">(Dari Deposit)</span>
                                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                            </div>
                        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                    </div>
                </div>
                <!-- Toggle Switches Section -->
                <div class="grid grid-cols-2 gap-3">
                    <!-- Insurance Toggle -->
                    <div class="flex items-center justify-between p-3 bg-gray-50 rounded-lg border border-gray-200 hover:border-blue-300 transition-colors">
                        <div class="flex items-center gap-2">
                            <i class="fas fa-shield-alt text-blue-600"></i>
                            <div>
                                <label class="text-sm font-medium text-gray-700 cursor-pointer">Asuransi</label>
                                <p class="text-xs text-gray-500"><?php echo e($is_insurance ? 'Aktif' : 'Nonaktif'); ?></p>
                            </div>
                        </div>
                        <label class="relative inline-flex items-center cursor-pointer">
                            <input type="checkbox" wire:model.live="is_insurance" class="sr-only peer">
                            <div class="w-11 h-6 bg-gray-300 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-blue-300 rounded-full peer peer-checked:after:translate-x-full rtl:peer-checked:after:-translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:start-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-blue-600"></div>
                        </label>
                    </div>

                    <!-- Pending Payment Toggle -->
                    <div class="flex items-center justify-between p-3 bg-gray-50 rounded-lg border border-gray-200 hover:border-orange-300 transition-colors">
                        <div class="flex items-center gap-2">
                            <i class="fas fa-clock text-orange-600"></i>
                            <div>
                                <label class="text-sm font-medium text-gray-700 cursor-pointer">Pending</label>
                                <p class="text-xs text-gray-500"><?php echo e($is_pending_payment ? 'Aktif' : 'Nonaktif'); ?></p>
                            </div>
                        </div>
                        <label class="relative inline-flex items-center cursor-pointer">
                            <input type="checkbox" wire:model.live="is_pending_payment" class="sr-only peer">
                            <div class="w-11 h-6 bg-gray-300 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-orange-300 rounded-full peer peer-checked:after:translate-x-full rtl:peer-checked:after:-translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:start-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-orange-600"></div>
                        </label>
                    </div>
                </div>
                <!-- Installment Options Section -->
                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($is_pending_payment): ?>
                    <div class="p-3 bg-orange-50 rounded-lg border border-orange-200 mt-3">
                        <label class="block text-sm font-semibold text-orange-800 mb-2">Pengaturan Cicilan</label>
                        <div class="grid grid-cols-2 gap-3">
                            <div>
                                <label class="block text-xs font-medium text-gray-700 mb-1">Berapa Kali Cicilan</label>
                                <input type="number" wire:model.live.debounce.500ms="installment_count" min="1" placeholder="Misal: 3" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-orange-300 focus:outline-none text-sm" />
                            </div>
                            <div>
                                <label class="block text-xs font-medium text-gray-700 mb-1">Periode Cicilan</label>
                                <select wire:model.live="installment_period" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-orange-300 focus:outline-none text-sm bg-white">
                                    <option value="">-- Pilih Periode --</option>
                                    <option value="weekly">Perminggu</option>
                                    <option value="monthly">Perbulan</option>
                                </select>
                            </div>
                        </div>
                    </div>

                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(!empty($this->installment_breakdown)): ?>
                        <div class="mt-3 p-3 bg-blue-50 rounded-lg border border-blue-200">
                            <label class="block text-sm font-semibold text-blue-800 mb-2">Rincian Cicilan</label>
                            <div class="overflow-x-auto">
                                <table class="w-full text-xs text-left">
                                    <thead>
                                        <tr class="text-gray-500 border-b border-blue-200">
                                            <th class="pb-1">#</th>
                                            <th class="pb-1">Tgl. Jth Tempo</th>
                                            <th class="pb-1 text-right">Nominal</th>
                                        </tr>
                                    </thead>
                                    <tbody class="divide-y divide-blue-100">
                                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__currentLoopData = $this->installment_breakdown; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoopIteration(); ?><?php endif; ?>
                                            <tr>
                                                <td class="py-1.5"><?php echo e($item['tenor']); ?>x</td>
                                                <td class="py-1.5"><?php echo e($item['date']); ?></td>
                                                <td class="py-1.5 text-right font-medium">Rp <?php echo e(number_format($item['amount'], 0, ',', '.')); ?></td>
                                            </tr>
                                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
                                    </tbody>
                                </table>
                            </div>
                            <div class="mt-2 pt-2 border-t border-blue-200 flex justify-between items-center text-xs">
                                <span class="text-gray-600">Sisa Tagihan (setelah DP)</span>
                                <span class="font-bold text-blue-700">Rp <?php echo e(number_format(max(0, ($transaction->grand_total_price ?? 0) - ($transaction->payment_amount ?? 0)), 0, ',', '.')); ?></span>
                            </div>
                        </div>
                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                <!-- Payment Methods Section -->
                <div class="space-y-3 mt-3">
                    <div class="flex justify-between items-center">
                        <label class="block text-sm font-medium">Metode Pembayaran <?php echo e($is_pending_payment ? '(Down Payment)' : ''); ?></label>
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(in_array($transaction->status, ['draft', 'process'])): ?>
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
                    
                    <div class="flex justify-between items-center">
                        <span class="text-sm text-gray-600">Produk</span>
                        <span class="text-sm font-semibold text-[#1E3A8A]">Rp
                            <?php echo e(number_format($transaction->product_price, 0, ',', '.')); ?></span>
                    </div>
                    <div class="flex justify-between items-center">
                        <span class="text-sm text-gray-600">Embalage</span>
                        <span class="text-sm font-semibold text-[#1E3A8A]">Rp
                            <?php echo e(number_format($transaction->embalage, 0, ',', '.')); ?></span>
                    </div>
                    
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

                                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(in_array($transaction->status, ['draft', 'process'])): ?>
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
            <?php elseif(in_array($transaction->status, ['process'])): ?>
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
</div><?php /**PATH /Users/macbookair/Documents/mediction/mediction.id/resources/views/livewire/admin/sale/pos/recipe/admin-sale-pos-recipe-index-new.blade.php ENDPATH**/ ?>