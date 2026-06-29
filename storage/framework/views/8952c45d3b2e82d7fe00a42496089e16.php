<div>
    <div class="mb-4">
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-2xl font-bold text-[#1E3A8A]">Penjualan Detail</h1>
            </div>
            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($status == 'draft'): ?>
                <div>
                    <button wire:click="confirmSubmit()" class="btn btn-primary">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                        </svg>
                        Konfirmasi Penjualan
                    </button>
                </div>
            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
        </div>
    </div>
    <div class="p-6 bg-white shadow rounded-lg mb-4">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div>
                <label for="code" class="block text-sm font-medium text-gray-700">Kode</label>
                <input disabled type="text" class="mt-1 form-control" wire:model.live='code' id="code"
                    placeholder="Masukkan Kode" autocomplete="false">
            </div>
            <div>
                <label for="date" class="block text-sm font-medium text-gray-700">Tanggal</label>
                <input disabled type="date" class="mt-1 form-control" wire:model.live='date' id="date"
                    placeholder="Masukkan Tanggal" autocomplete="false">
            </div>
            <div>
                <label for="patient" class="block text-sm font-medium text-gray-700">Pasien</label>
                <input disabled type="text" class="mt-1 form-control"
                    value="<?php echo e($finance->transaction->patient_name); ?>" id="patient" placeholder="Masukkan Pasien"
                    autocomplete="false">
            </div>
            <div>
                <label for="type" class="block text-sm font-medium text-gray-700">Tipe</label>
                <input disabled type="type" class="mt-1 form-control"
                    value="<?php echo e(Str::replace('-', ' ', Str::title($finance->transaction->type))); ?>" id="type"
                    placeholder="Masukkan Tipe" autocomplete="false">
            </div>
            <div class="md:col-span-2">
                <label for="description" class="block text-sm font-medium text-gray-700">Deskripsi</label>
                <textarea rows="3" disabled class="mt-1 form-control" wire:model.live='description' id="description"
                    placeholder="Masukkan Deskripsi" autocomplete="false"></textarea>
            </div>
        </div>
    </div>
    <div class="mb-4">
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-2xl font-bold text-[#1E3A8A]">Transaksi Detail</h1>
            </div>
        </div>
    </div>
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
                        <th class="center">Qty</th>
                        <th class="right">Subtotal</th>
                    </tr>
                </thead>
                <tbody>
                    <tbody>
                        
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(count($details) > 0): ?>
                            <tr class="bg-gray-50 border-b">
                                <td colspan="7" class="py-2 px-4 font-semibold text-gray-700 bg-gray-100">
                                    🛒 Produk / Item Satuan
                                </td>
                            </tr>
                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__currentLoopData = $details; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key_detail => $detail): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoopIteration(); ?><?php endif; ?>
                                <tr class="border-b transition hover:bg-gray-50">
                                    <td class="py-3 px-4" colspan="5">
                                        <div class="flex flex-col">
                                            <span class="font-medium text-gray-900"><?php echo e($detail['product_name']); ?></span>
                                            <span class="text-xs text-gray-500">@Rp<?php echo e($detail['price']); ?></span>
                                        </div>
                                    </td>
                                    <td class="py-3 px-4 text-center font-medium"><?php echo e($detail['quantity']); ?></td>
                                    <td class="py-3 px-4 text-right font-medium">Rp<?php echo e($detail['sub_total']); ?></td>
                                </tr>
                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
                        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

                        
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__currentLoopData = $recipes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key_recipe => $recipe): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoopIteration(); ?><?php endif; ?>
                            
                            <tr class="bg-blue-50 border-l-4 border-blue-600">
                                <td colspan="7" class="py-3 px-4">
                                    <div class="flex flex-col gap-2">
                                        <div class="flex items-center justify-between">
                                            <div class="flex items-center gap-3">
                                                <span class="bg-blue-600 text-white text-xs font-bold px-2 py-1 rounded">
                                                    R-<?php echo e($key_recipe + 1); ?>

                                                </span>
                                                <span class="font-semibold text-blue-800 text-sm uppercase">
                                                    <?php echo e($recipe['medicine_type']); ?>

                                                </span>
                                                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(!$recipe['is_single']): ?>
                                                    <span class="text-gray-400">|</span>
                                                    <span class="font-medium text-gray-700 text-sm">
                                                        <?php echo e($recipe['product_name']); ?>

                                                    </span>
                                                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                            </div>
                                            <div class="flex items-center gap-4 text-sm">
                                                <div class="flex items-center gap-1">
                                                    <span class="text-gray-500 text-xs">Jasa:</span>
                                                    <span class="font-medium text-gray-700">Rp<?php echo e($recipe['price_service_one']); ?></span>
                                                </div>
                                                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(!$recipe['is_single']): ?>
                                                    <div class="flex items-center gap-1">
                                                        <span class="text-gray-500 text-xs">Subtotal Resep:</span>
                                                        <span class="font-medium text-gray-700">Rp<?php echo e($recipe['sub_total']); ?></span>
                                                    </div>
                                                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                            </div>
                                        </div>
                                        <div class="flex items-center gap-3 text-xs text-gray-600 grid grid-cols-3">
                                            <div class="flex items-center gap-1 bg-white/50 px-2 py-1 rounded">
                                                <span class="font-semibold">Aturan Pakai:</span>
                                                <span><?php echo e($recipe['how_to_use']); ?></span>
                                            </div>
                                            <div class="flex items-center gap-1 bg-white/50 px-2 py-1 rounded">
                                                <span class="font-semibold">Ket:</span>
                                                <span><?php echo e($recipe['description']); ?></span>
                                            </div>
                                            <div class="flex items-center gap-1 bg-white/50 px-2 py-1 rounded">
                                                <span class="font-semibold">Rute:</span>
                                                <span><?php echo e($recipe['route_coding_code']); ?></span>
                                            </div>
                                        </div>
                                    </div>
                                </td>
                            </tr>

                            
                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(!empty($recipe['details'])): ?>
                                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__currentLoopData = $recipe['details']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index_detail => $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoopIteration(); ?><?php endif; ?>
                                    <tr class="border-b hover:bg-gray-50">
                                        
                                        <td class="py-2 px-4 pl-8" colspan="<?php echo e(!$recipe['is_single'] ? 1 : 5); ?>">
                                            <div class="flex flex-col border-l-2 border-gray-200 pl-3">
                                                <span class="font-medium text-gray-800 text-sm"><?php echo e($item['product_name']); ?></span>
                                                <span class="text-xs text-gray-500">@Rp<?php echo e($item['price']); ?></span>
                                            </div>
                                        </td>
                                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(!$recipe['is_single']): ?>
                                            <td class="py-2 px-2 text-xs text-center text-gray-600"><?php echo e($item['type']); ?></td>
                                            <td class="py-2 px-2 text-xs text-center text-gray-600"><?php echo e($item['dosage_doctor'] ?? 0); ?></td>
                                            <td class="py-2 px-2 text-xs text-center text-gray-600"><?php echo e($item['doctor_dosage_gram'] ?? 0); ?></td>
                                            <td class="py-2 px-2 text-xs text-center text-gray-600"><?php echo e($item['dosage_drug'] ?? 0); ?></td>
                                        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                        <td class="py-2 px-4 text-center text-sm font-medium"><?php echo e($item['quantity']); ?></td>
                                        <td class="py-2 px-4 text-right text-sm font-medium">Rp<?php echo e($item['sub_total']); ?></td>
                                    </tr>
                                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
                            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>

                    
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(!empty($payments)): ?>
                        <tr>
                            <td colspan="7" class="py-3 px-2 bg-green-50" style="border-top: 5px solid #059669;">
                                <div class="flex items-center gap-2">
                                    <span class="font-medium text-green-600 text-lg">
                                        💳 PEMBAYARAN
                                    </span>
                                </div>
                            </td>
                        </tr>
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__currentLoopData = $payments; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key_payment => $payment): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoopIteration(); ?><?php endif; ?>
                            <tr class="bg-green-50/50">
                                <td class="py-2" colspan="5" style="width: 20%;">
                                    <p class="font-medium">
                                        <?php echo e($payment['payment_method']); ?>

                                    </p>
                                    <p class="text-xs text-gray-500">
                                        <?php echo e($payment['description'] ?? 'Pembayaran'); ?></p>
                                </td>
                                <td class="py-2 text-center">
                                    1
                                </td>
                                <td class="py-2 text-right font-semibold text-green-600">
                                    Rp<?php echo e($payment['amount']); ?>

                                </td>
                            </tr>
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

                    
                    <tr>
                        <td colspan="7" class="py-3 px-2 bg-blue-50" style="border-top: 5px solid #1E3A8A;">
                            <div class="flex items-center gap-2">
                                <span class="font-medium text-blue-600 text-lg">
                                    📊 RINGKASAN TOTAL
                                </span>
                            </div>
                        </td>
                    </tr>

                    <tr class="bg-blue-50/30">
                        <td class="py-2" colspan="6" style="width: 20%;">
                            <p class="font-medium text-gray-700">
                                Biaya Jasa 1
                            </p>
                        </td>
                        <td class="py-2 text-right font-medium">
                            Rp<?php echo e(number_format($finance->first_service_price ?? 0, 0, ',', '.')); ?>

                        </td>
                    </tr>
                    <tr class="bg-blue-50/30">
                        <td class="py-2" colspan="6" style="width: 20%;">
                            <p class="font-medium text-gray-700">
                                Biaya Produk Pendukung
                            </p>
                        </td>
                        <td class="py-2 text-right font-medium">
                            Rp<?php echo e(number_format($finance->transaction->price_product_price ?? 0, 0, ',', '.')); ?>

                        </td>
                    </tr>
                    <tr class="bg-blue-50/30">
                        <td class="py-2" colspan="6" style="width: 20%;">
                            <p class="font-medium text-gray-700">
                                Biaya Jasa 2
                            </p>
                        </td>
                        <td class="py-2 text-right font-medium">
                            Rp<?php echo e(number_format($finance->transaction->second_service_price ?? 0, 0, ',', '.')); ?>

                        </td>
                    </tr>

                    <tr class="bg-blue-50/30">
                        <td class="py-2" colspan="6" style="width: 20%;">
                            <p class="font-medium text-gray-700">
                                Embalage
                            </p>
                        </td>
                        <td class="py-2 text-right font-medium">
                            Rp<?php echo e(number_format($finance->transaction->embalage ?? 0, 0, ',', '.')); ?>

                        </td>
                    </tr>
                    <tr class="bg-blue-50/30">
                        <td class="py-2" colspan="6" style="width: 20%;">
                            <p class="font-medium text-gray-700">
                                Biaya Produk
                            </p>
                        </td>
                        <td class="py-2 text-right font-medium">
                            Rp<?php echo e(number_format($finance->transaction->product_price ?? 0, 0, ',', '.')); ?>

                        </td>
                    </tr>

                    
                    <tr class="bg-yellow-100 border-t-2 border-yellow-300">
                        <td class="py-3" colspan="6">
                            <p class="font-bold text-yellow-800 text-lg">
                                SUB TOTAL
                            </p>
                        </td>
                        <td class="py-3 text-right font-bold text-yellow-800 text-lg">
                            Rp<?php echo e(number_format($finance->transaction->sub_total_price ?? 0, 0, ',', '.')); ?>

                        </td>
                    </tr>

                    
                    <tr class="bg-red-100 border-t-2 border-red-300">
                        <td class="py-3" colspan="6">
                            <p class="font-bold text-red-800 text-lg">
                                PEMBULATAN
                            </p>
                        </td>
                        <td class="py-3 text-right font-bold text-red-800 text-lg">
                            Rp<?php echo e(number_format($finance->transaction->rounding ?? 0, 0, ',', '.')); ?>

                        </td>
                    </tr>

                    
                    <tr class="bg-blue-100 border-t-2 border-blue-300">
                        <td class="py-3" colspan="6">
                            <p class="font-bold text-blue-800 text-lg">
                                GRAND TOTAL
                            </p>
                        </td>
                        <td class="py-3 text-right font-bold text-blue-800 text-lg">
                            Rp<?php echo e(number_format($finance->grand_total, 0, ',', '.')); ?>

                        </td>
                    </tr>

                    
                    <tr class="bg-green-100">
                        <td class="py-2" colspan="6">
                            <p class="font-semibold text-green-800">
                                Total Pembayaran
                            </p>
                        </td>
                        <td class="py-2 text-right font-semibold text-green-800">
                            Rp<?php echo e(number_format($finance->transaction->payment_amount, 0, ',', '.')); ?>

                        </td>
                    </tr>

                    <?php
                        $balance = $finance->transaction->remaining_bill;
                    ?>

                    
                    <tr class="<?php echo e($balance >= 0 ? 'bg-green-100' : 'bg-red-100'); ?>">
                        <td class="py-2" colspan="6">
                            <p class="font-semibold <?php echo e($balance >= 0 ? 'text-green-800' : 'text-red-800'); ?>">
                                <?php echo e($balance >= 0 ? 'Kembalian' : 'Kurang Bayar'); ?>

                            </p>
                        </td>
                        <td
                            class="py-2 text-right font-semibold <?php echo e($balance >= 0 ? 'text-green-800' : 'text-red-800'); ?>">
                            Rp<?php echo e(number_format($finance->payment_change, 0, ',', '.')); ?>

                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</div><?php /**PATH /Users/macbookair/Documents/mediction/mediction.id/resources/views/livewire/admin/finance/sale/detail/admin-finance-sale-detail-index.blade.php ENDPATH**/ ?>