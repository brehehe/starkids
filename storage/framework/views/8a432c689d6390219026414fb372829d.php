<div>
    <div class="mb-4">
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-2xl font-bold text-[#1E3A8A]">Detail Penjualan</h1>
            </div>
        </div>
    </div>
    <div class="space-y-6 mb-6">
        <!-- SECTION 1: Informasi Umum Produk -->
        <div class="p-6 bg-white shadow rounded-lg">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700">Kode</label>
                    <input type="text" value="<?php echo e($transaction->code ?? ''); ?>" placeholder="Contoh: Kode" disabled class="mt-1 form-control" />
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700">Pasien</label>
                    <input type="text" value="<?php echo e($transaction->patient_name ?? ''); ?>" placeholder="Contoh: Pasien" disabled class="mt-1 form-control" />
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700">Tanggal</label>
                    <input type="text" value="<?php echo e($transaction->created_at->format('Y-m-d') ?? ''); ?>" placeholder="Contoh: Tanggal" disabled class="mt-1 form-control" />
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700">Tipe</label>
                    <input type="text" value="<?php echo e(Str::title(Str::replace('-', ' ', $transaction->type)) ?? ''); ?>" placeholder="Contoh: Tipe" disabled class="mt-1 form-control" />
                </div>
                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($transaction->type === 'resep'): ?>
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Nomer Resep</label>
                        <input type="text" value="<?php echo e($transaction->number_recipe ?? ''); ?>" placeholder="Contoh: Nomer Resep" disabled class="mt-1 form-control" />
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Dokter</label>
                        <input type="text" value="<?php echo e($transaction->doctor_name ?? ''); ?>" placeholder="Contoh: Dokter" disabled class="mt-1 form-control" />
                    </div>
                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
            </div>
        </div>
    </div>
    <div class="bg-white/80 backdrop-blur-sm rounded-xl shadow-lg border border-gray-100 overflow-hidden mb-6">
        <div class="table-container">
            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($transaction->type == 'non-resep'): ?>
                <table class="table">
                    <thead>
                        <tr>
                            
                            <th>Produk </th>
                            <th>Quantity</th>
                            <th>Total</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__currentLoopData = $transaction->transactionDetails; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoopIteration(); ?><?php endif; ?>
                            <tr>
                                
                                <td>
                                    <p class="font-medium"><?php echo e($item->product->name); ?></p>
                                    <p class="text-xs text-gray-500">@Rp<?php echo e(number_format($item->price, 0, ',', '.')); ?></p>
                                </td>
                                <td><?php echo e($item->quantity); ?></td>
                                <td>Rp<?php echo e(number_format($item->sub_total_price, 0, ',', '.')); ?></td>
                            </tr>
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
                    </tbody>
                    <tfoot>
                        <tr>
                            <th colspan="2" class="right font-bold">
                                Sub Total
                            </th>
                            <th class="font-bold">
                                Rp<?php echo e(number_format($transaction->sub_total_price, 0, ',', '.')); ?>

                            </th>
                        </tr>
                        <tr>
                            <th colspan="2" class="right font-bold">
                                Diskon
                            </th>
                            <th class="font-bold">
                                Rp<?php echo e(number_format($transaction->discount_value, 0, ',', '.')); ?>

                            </th>
                        </tr>
                        <tr>
                            <th colspan="2" class="right font-bold">
                                Grand Total
                            </th>
                            <th class="font-bold">
                                Rp<?php echo e(number_format($transaction->grand_total_price, 0, ',', '.')); ?>

                            </th>
                        </tr>
                        <tr>
                            <th colspan="2" class="right font-bold">
                                Total Pembayaran
                            </th>
                            <th class="font-bold">
                                Rp<?php echo e(number_format($transaction->payment_amount, 0, ',', '.')); ?>

                            </th>
                        </tr>
                        <tr>
                            <th colspan="2" class="right font-bold">
                                <div class="text-red-600">Kembali</div>
                            </th>
                            <th class="font-bold">
                                <div class="text-red-600">Rp<?php echo e(number_format($transaction->payment_change, 0, ',', '.')); ?></div>
                            </th>
                        </tr>
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__currentLoopData = $transaction->transactionPayments; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $payment): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoopIteration(); ?><?php endif; ?>
                            <tr>
                                <th colspan="6" class="right font-bold">
                                    Pembayaran <?php echo e($payment->paymentMethod->name); ?>

                                </th>
                                <th class="font-bold">
                                    Rp<?php echo e(number_format($payment->payment_amount, 0, ',', '.')); ?>

                                </th>
                            </tr>
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
                    </tfoot>
                </table>
            <?php elseif($transaction->type == 'resep'): ?>
                <table class="table">
                    <thead>
                        <tr>
                            
                            <th>Produk </th>
                            <th>Opsi Dosis</th>
                            <th>Dosis Dokter</th>
                            <th>Total Gramasi</th>
                            <th>Dosis Obat</th>
                            <th>Qty</th>
                            <th>Sub Total</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__currentLoopData = $transaction->transactionRecipes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $recipe): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoopIteration(); ?><?php endif; ?>
                            <tr>
                                <td colspan="7">
                                    <div class="flex items-center gap-2">
                                        /R <?php echo e($index + 1); ?>

                                        <input type="text" value="<?php echo e($recipe->medicineType->name ?? ''); ?>" placeholder="Contoh: Paten" disabled class="mt-1 form-control" />
                                        <div class="mt-1 flex rounded-md shadow-sm">
                                            <span class="inline-flex items-center rounded-l-md border border-r-0 border-gray-300 bg-gray-100 px-3 text-gray-500 text-sm">
                                                Rp
                                            </span>
                                            <input type="text" disabled value="<?php echo e(number_format($recipe->price_service_one ?? 0, 0, ',', '.')); ?>" class="form-control rounded-l-none" placeholder="0" />
                                        </div>
                                        <input type="text" value="<?php echo e(number_format($recipe->numero_recipe ?? 0, 0, ',', '.')); ?>" placeholder="Contoh: Harga" disabled class="mt-1 form-control" />
                                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(!$recipe->is_single): ?>
                                            <input type="text" value="<?php echo e($recipe->product->name ?? ''); ?> - Rp<?php echo e(number_format($recipe->product->productPrice->price, 0, ',', '.')); ?>" placeholder="Contoh: Paten" disabled class="mt-1 form-control" />
                                            <div class="mt-1 flex rounded-md shadow-sm">
                                                <span class="inline-flex items-center rounded-l-md border border-r-0 border-gray-300 bg-gray-100 px-3 text-gray-500 text-sm">
                                                    Rp
                                                </span>
                                                <input type="text" disabled value="<?php echo e(number_format($recipe->sub_total_price ?? 0, 0, ',', '.')); ?>" class="form-control rounded-l-none" placeholder="0" />
                                            </div>
                                        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                    </div>
                                </td>
                            </tr>
                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__currentLoopData = $recipe->transactionDetail; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoopIteration(); ?><?php endif; ?>
                                <tr>
                                    <td>
                                        <p class="font-medium"><?php echo e($item->product->name); ?></p>
                                        <p class="text-xs text-gray-500">@Rp<?php echo e(number_format($item->price, 0, ',', '.')); ?></p>
                                    </td>
                                    <td><?php echo e(Str::title($item->type)); ?></td>
                                    <td><?php echo e($item->dosage_doctor); ?></td>
                                    <td><?php echo e(number_format($item->doctor_dosage_gram, 2, ',', '.')); ?></td>
                                    <td><?php echo e($item->dosage_drug); ?></td>
                                    <td><?php echo e($item->quantity); ?></td>
                                    <td>Rp<?php echo e(number_format($item->sub_total_price, 0, ',', '.')); ?></td>
                                </tr>
                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
                    </tbody>
                    <tfoot>
                        <tr>
                            <th colspan="6" class="right font-bold">
                                Total Produk
                            </th>
                            <th class="font-bold">
                                Rp<?php echo e(number_format($transaction->product_price, 0, ',', '.')); ?>

                            </th>
                        </tr>
                        <tr>
                            <th colspan="6" class="right font-bold">
                                Embalage
                            </th>
                            <th class="font-bold">
                                Rp<?php echo e(number_format($transaction->embalage, 0, ',', '.')); ?>

                            </th>
                        </tr>
                        <tr>
                            <th colspan="6" class="right font-bold">
                                Sub Total
                            </th>
                            <th class="font-bold">
                                Rp<?php echo e(number_format($transaction->sub_total_price, 0, ',', '.')); ?>

                            </th>
                        </tr>
                        <tr>
                            <th colspan="6" class="right font-bold">
                                Diskon
                            </th>
                            <th class="font-bold">
                                Rp<?php echo e(number_format($transaction->discount_value, 0, ',', '.')); ?>

                            </th>
                        </tr>
                        <tr>
                            <th colspan="6" class="right font-bold">
                                Grand Total
                            </th>
                            <th class="font-bold">
                                Rp<?php echo e(number_format($transaction->grand_total_price, 0, ',', '.')); ?>

                            </th>
                        </tr>
                        <tr>
                            <th colspan="6" class="right font-bold">
                                Total Pembayaran
                            </th>
                            <th class="font-bold">
                                Rp<?php echo e(number_format($transaction->payment_amount, 0, ',', '.')); ?>

                            </th>
                        </tr>
                        <tr>
                            <th colspan="6" class="right font-bold">
                                <div class="text-red-600">Kembali</div>
                            </th>
                            <th class="font-bold">
                                <div class="text-red-600">Rp<?php echo e(number_format($transaction->payment_change, 0, ',', '.')); ?></div>
                            </th>
                        </tr>
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__currentLoopData = $transaction->transactionPayments; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $payment): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoopIteration(); ?><?php endif; ?>
                            <tr>
                                <th colspan="6" class="right font-bold">
                                    Pembayaran <?php echo e($payment->paymentMethod->name); ?>

                                </th>
                                <th class="font-bold">
                                    Rp<?php echo e(number_format($payment->payment_amount, 0, ',', '.')); ?>

                                </th>
                            </tr>
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
                    </tfoot>
                </table>
            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
        </div>
    </div>
</div><?php /**PATH /Users/macbookair/Documents/mediction/mediction.id/resources/views/livewire/admin/sale/report/detail/admin-sale-report-detail-index.blade.php ENDPATH**/ ?>