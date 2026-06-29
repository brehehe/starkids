<div>
    <?php echo $__env->make('livewire.admin.master.deposit.detail.admin-master-deposit-detail-modal', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
    <?php
        $totalPayments = collect($this->depositPayments)->sum('payment_real');
        $grandTotal = $this->deposit->grand_total_price ?? 0;
    ?>
    <div class="mb-4">
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-2xl font-bold text-[#1E3A8A]">
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($mode === 'create'): ?>
                        Buat Deposit Baru
                    <?php else: ?>
                        Detail Deposit
                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                </h1>
                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($mode === 'view' && !$isDepositEditable): ?>
                    <div class="mt-2">
                        <span
                            class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                            <svg class="-ml-0.5 mr-1.5 h-2 w-2 text-green-400" fill="currentColor" viewBox="0 0 8 8">
                                <circle cx="4" cy="4" r="3" />
                            </svg>
                            Deposit Sudah Lunas - Tidak Dapat Diubah
                        </span>
                    </div>
                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
            </div>
            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($mode === 'view' && $deposit): ?>
                <div class="flex items-center gap-4">
                    <button wire:click="redirectToDepositMenu()" class="btn btn-outline-primary">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                        </svg>
                        Kembali ke Menu
                    </button>
                    
                    <button wire:click="openAddPaymentModal()" class="btn btn-secondary">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                        </svg>
                        Tambah Pembayaran
                    </button>
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($totalPayments >= $grandTotal): ?>
                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                </div>
            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
        </div>
    </div>

    <!-- Deposit Information Card -->
    <div class="p-6 bg-white shadow rounded-lg mb-4">
        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($mode === 'create'): ?>
            <!-- Create Form -->
            <form wire:submit.prevent="createDeposit">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Kode Deposit</label>
                        <input type="text" wire:model.live="code" class="form-control mt-1" readonly>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Pasien <span
                                class="text-red-500">*</span></label>
                        <div <?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::$currentLoop['key'] = 'select-'.e(rand()).''; ?>wire:key="select-<?php echo e(rand()); ?>">
                            <select class="mt-1 form-control" x-data x-ref="input" x-init="$($refs.input).selectize({
                                dropdownParent: 'body',
                                allowClear: true,
                                plugins: ['clear_button'],
                                onChange: function(e) {
                                    window.Livewire.find('<?php echo e($_instance->getId()); ?>').set('patient_id', e ? e : null);
                                }
                            });"
                                wire:model.lazy="patient_id" id="patient_id">
                                <option value="">-- Pilih Pasien --</option>
                                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__currentLoopData = $patients; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $patient): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoopIteration(); ?><?php endif; ?>
                                    <option value="<?php echo e($patient['id']); ?>"><?php echo e($patient['name']); ?> <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($patient['phone']): ?>
                                            - <?php echo e($patient['phone']); ?>

                                        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                    </option>
                                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
                            </select>
                        </div>
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__errorArgs = ['patient_id'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                            <span class="text-red-500 text-sm"><?php echo e($message); ?></span>
                        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                    </div>
                    
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Quantity Request <span
                                class="text-red-500">*</span></label>
                        <input type="number" wire:model.live="quantity_request" class="form-control mt-1"
                            min="0">
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__errorArgs = ['quantity_request'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                            <span class="text-red-500 text-sm"><?php echo e($message); ?></span>
                        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Harga Per Unit</label>
                        <input type="number" wire:model.live="unit_price" class="form-control mt-1" readonly
                            min="0" step="0.01">
                        <small class="text-gray-500">Dihitung otomatis dari total deposit items / quantity
                            request</small>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Quantity Free</label>
                        <input type="number" wire:model.live="quantity_free" class="form-control mt-1" min="0">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Quantity</label>
                        <input type="number" wire:model.live="quantity" disabled class="form-control mt-1"
                            min="0" value="<?php echo e($quantity_request + $quantity_free); ?>">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Subtotal Kalkulasi</label>
                        <div class="p-3 bg-blue-50 border border-blue-200 rounded-lg mt-1">
                            <p class="text-lg font-bold text-blue-800">
                                Rp <?php echo e(number_format($quantity_request * $unit_price, 0, ',', '.')); ?>

                            </p>
                            <small class="text-blue-600"><?php echo e($quantity_request); ?> × Rp
                                <?php echo e(number_format($unit_price, 0, ',', '.')); ?></small>
                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($quantity_free > 0): ?>
                                <p class="text-sm text-green-600 mt-1">+ <?php echo e($quantity_free); ?> quantity gratis</p>
                            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                        </div>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Sisa Tagihan</label>
                        <div class="p-3 bg-yellow-50 border border-yellow-200 rounded-lg mt-1">
                            <p class="text-lg font-bold text-yellow-800">
                                Rp <?php echo e(number_format($remaining_bill, 0, ',', '.')); ?>

                            </p>
                            <small class="text-yellow-600">Subtotal - Total Pembayaran</small>
                        </div>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Kembalian</label>
                        <div class="p-3 bg-green-50 border border-green-200 rounded-lg mt-1">
                            <p class="text-lg font-bold text-green-800">
                                Rp <?php echo e(number_format($payment_change, 0, ',', '.')); ?>

                            </p>
                            <small class="text-green-600">Jika pembayaran lebih dari tagihan</small>
                        </div>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Judul</label>
                        <input type="text" wire:model.live="text" class="form-control mt-1">
                    </div>
                    <div class="md:col-span-2">
                        <label class="block text-sm font-medium text-gray-700">Deskripsi</label>
                        <textarea wire:model.live="description" class="form-control mt-1" rows="3"></textarea>
                    </div>
                </div>
                <div class="flex justify-between gap-2">
                    <button type="button" wire:click="redirectToDepositMenu()" class="btn btn-outline-secondary">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                        </svg>
                        Kembali
                    </button>
                    <div class="flex gap-2">
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($isDepositEditable): ?>
                            <button type="button" wire:click="openAddProductModal()" class="btn btn-secondary">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none"
                                    viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M12 4v16m8-8H4" />
                                </svg>
                                Tambah Produk
                            </button>
                            <button type="submit" class="btn btn-primary">
                                Buat Deposit
                            </button>
                        <?php else: ?>
                            <button type="button" class="btn btn-secondary" disabled>
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none"
                                    viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                                Deposit Sudah Lunas
                            </button>
                        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                    </div>
                </div>
            </form>

            <!-- Products in Create Mode -->
            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(count($tempItems) > 0): ?>
                <div class="mt-6 pt-6 border-t border-gray-200">
                    <h4 class="text-lg font-semibold text-gray-800 mb-4">Produk yang Ditambahkan</h4>
                    <div class="bg-gray-50 rounded-lg overflow-hidden">
                        <table class="w-full">
                            <thead class="bg-gray-100">
                                <tr>
                                    <th class="px-4 py-2 text-left text-sm font-medium text-gray-700">Produk</th>
                                    <th class="px-4 py-2 text-center text-sm font-medium text-gray-700">Qty</th>
                                    <th class="px-4 py-2 text-right text-sm font-medium text-gray-700">Harga</th>
                                    
                                    <th class="px-4 py-2 text-right text-sm font-medium text-gray-700">Subtotal</th>
                                    <th class="px-4 py-2 text-center text-sm font-medium text-gray-700">Aksi</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-200">
                                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__currentLoopData = $tempItems; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoopIteration(); ?><?php endif; ?>
                                    <tr class="bg-white">
                                        <td class="px-4 py-2">
                                            <p class="font-medium text-sm"><?php echo e($item['product_name']); ?></p>
                                            
                                        </td>
                                        <td class="px-4 py-2 text-center text-sm"><?php echo e($item['quantity']); ?></td>
                                        <td class="px-4 py-2 text-right text-sm">Rp
                                            <?php echo e(number_format($item['price'], 0, ',', '.')); ?></td>
                                        
                                        <td class="px-4 py-2 text-right text-sm font-semibold">
                                            Rp <?php echo e(number_format($item['sub_total_price'], 0, ',', '.')); ?>

                                        </td>
                                        <td class="px-4 py-2 text-center">
                                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($isDepositEditable): ?>
                                                <div class="flex items-center justify-center gap-1">
                                                    <button wire:click="editTempItem(<?php echo e($index); ?>)"
                                                        class="text-blue-600 hover:text-blue-800 p-1" title="Edit">
                                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4"
                                                            fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                                stroke-width="2"
                                                                d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                                        </svg>
                                                    </button>
                                                    <button wire:click="confirmremoveTempItem(<?php echo e($index); ?>)"
                                                        class="text-red-600 hover:text-red-800 p-1" title="Hapus">
                                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4"
                                                            fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                                stroke-width="2"
                                                                d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                                        </svg>
                                                    </button>
                                                </div>
                                            <?php else: ?>
                                                <span class="text-xs text-gray-500">Tidak dapat diubah</span>
                                            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                        </td>
                                    </tr>
                                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
                            </tbody>
                            <tfoot class="bg-gray-50">
                                <tr>
                                    <td colspan="3" class="px-4 py-2 text-right font-semibold text-sm">Total:</td>
                                    <td class="px-4 py-2 text-right font-bold text-sm">
                                        Rp
                                        <?php echo e(number_format(collect($tempItems)->sum('sub_total_price'), 0, ',', '.')); ?>

                                    </td>
                                    <td></td>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
        <?php else: ?>
            <!-- View Mode -->
            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($deposit): ?>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Kode Deposit</label>
                        <p class="mt-1 text-gray-900 font-semibold"><?php echo e($deposit->code); ?></p>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Status</label>
                        <p class="mt-1">
                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($deposit->status === 'waiting'): ?>
                                <span
                                    class="inline-flex px-2 py-1 text-xs font-semibold rounded-full bg-yellow-100 text-yellow-800">
                                    Menunggu
                                </span>
                            <?php elseif($deposit->status === 'partial'): ?>
                                <span
                                    class="inline-flex px-2 py-1 text-xs font-semibold rounded-full bg-blue-100 text-blue-800">
                                    Sebagian
                                </span>
                            <?php else: ?>
                                <span
                                    class="inline-flex px-2 py-1 text-xs font-semibold rounded-full bg-green-100 text-green-800">
                                    Selesai
                                </span>
                            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                        </p>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Tanggal</label>
                        <p class="mt-1 text-gray-900"><?php echo e($deposit->created_at->format('d/m/Y H:i')); ?></p>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Nama Pasien</label>
                        <p class="mt-1 text-gray-900"><?php echo e($deposit->patient->name ?? '-'); ?></p>
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($deposit->patient && $deposit->patient->phone): ?>
                            <p class="text-sm text-gray-500"><?php echo e($deposit->patient->phone); ?></p>
                        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                    </div>
                    
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Total Amount</label>
                        <p class="mt-1 text-2xl font-bold text-blue-600">
                            Rp <?php echo e(number_format($deposit->grand_total_price ?? 0, 0, ',', '.')); ?>

                        </p>
                    </div>
                </div>

                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($deposit->text || $deposit->description): ?>
                    <div class="mt-4 pt-4 border-t border-gray-200">
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($deposit->text): ?>
                            <div class="mb-2">
                                <label class="block text-sm font-medium text-gray-700">Judul</label>
                                <p class="mt-1 text-gray-900"><?php echo e($deposit->text); ?></p>
                            </div>
                        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($deposit->description): ?>
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Deskripsi</label>
                                <p class="mt-1 text-gray-900"><?php echo e($deposit->description); ?></p>
                            </div>
                        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                    </div>
                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

                <div class="mt-4 pt-4 border-t border-gray-200">
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Quantity Request</label>
                            <p class="mt-1 text-gray-900 font-semibold"><?php echo e($deposit->quantity_request); ?></p>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Quantity Free</label>
                            <p class="mt-1 text-gray-900 font-semibold"><?php echo e($deposit->quantity_free); ?></p>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Total Quantity</label>
                            <p class="mt-1 text-gray-900 font-semibold"><?php echo e($deposit->quantity); ?></p>
                        </div>
                    </div>
                </div>

                <!-- Sisa Tagihan dan Kembalian -->
                <div class="mt-4 pt-4 border-t border-gray-200">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Sisa Tagihan</label>
                            <div class="p-3 bg-yellow-50 border border-yellow-200 rounded-lg mt-1">
                                <?php
                                    $totalPayments = collect($depositPayments)->sum('payment_real');
                                    $remainingBill = ($deposit->grand_total_price ?? 0) - $totalPayments;
                                    $remainingBill = max(0, $remainingBill); // Tidak boleh negatif
                                ?>
                                <p class="text-lg font-bold text-yellow-800">
                                    Rp <?php echo e(number_format($remainingBill, 0, ',', '.')); ?>

                                </p>
                                <small class="text-yellow-600">Total Amount - Total Pembayaran</small>
                            </div>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Kembalian</label>
                            <div class="p-3 bg-green-50 border border-green-200 rounded-lg mt-1">
                                <?php
                                    $paymentChange = 0;
                                    if ($totalPayments > ($deposit->grand_total_price ?? 0)) {
                                        $paymentChange = $totalPayments - ($deposit->grand_total_price ?? 0);
                                    }
                                ?>
                                <p class="text-lg font-bold text-green-800">
                                    Rp <?php echo e(number_format($paymentChange, 0, ',', '.')); ?>

                                </p>
                                <small class="text-green-600">Jika pembayaran lebih dari total amount</small>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
    </div>

    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($mode === 'view' && $deposit): ?>
        <!-- Items Table -->
        <div class="bg-white/80 backdrop-blur-sm rounded-xl shadow-lg border border-gray-100 overflow-hidden mb-6">
            <div class="px-6 py-4 border-b border-gray-200">
                <h3 class="text-lg font-semibold text-gray-800">Item Deposit</h3>
            </div>
            <div class="table-container">
                <table class="table">
                    <thead>
                        <tr class="border-b">
                            <th>Produk</th>
                            <th class="center">Quantity</th>
                            <th class="right">Harga</th>
                            
                            <th class="right">Subtotal</th>
                            <th class="center w-8">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__empty_5 = true; $__currentLoopData = $depositItems; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_5 = false; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoopIteration(); ?><?php endif; ?>
                            <tr class="border-b">
                                <td class="py-2">
                                    <p class="font-medium"><?php echo e($item['product_name']); ?></p>
                                    
                                </td>
                                <td class="py-2 text-center"><?php echo e($item['quantity']); ?></td>
                                <td class="py-2 text-right">
                                    Rp <?php echo e(number_format($item['price'], 0, ',', '.')); ?>

                                </td>
                                
                                <td class="py-2 text-right font-semibold">
                                    Rp <?php echo e(number_format($item['sub_total_price'], 0, ',', '.')); ?>

                                </td>
                                <td class="py-2 text-center">
                                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($isDepositEditable): ?>
                                        <div class="flex items-center justify-center gap-2">
                                            <button wire:click="editItem('<?php echo e($item['id']); ?>')"
                                                class="text-blue-600 hover:text-blue-800" title="Edit">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4"
                                                    fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        stroke-width="2"
                                                        d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                                </svg>
                                            </button>
                                            <button wire:click="deleteItem('<?php echo e($item['id']); ?>')"
                                                class="text-red-600 hover:text-red-800"
                                                onclick="return confirm('Yakin ingin menghapus item ini?')"
                                                title="Hapus">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4"
                                                    fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        stroke-width="2"
                                                        d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                                </svg>
                                            </button>
                                        </div>
                                    <?php else: ?>
                                        <span class="text-xs text-gray-500">Tidak dapat diubah</span>
                                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                </td>
                            </tr>
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_5): ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
                            <tr>
                                <td colspan="6" class="py-8 text-center text-gray-500">
                                    <div class="flex flex-col items-center">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 text-gray-300 mb-2"
                                            fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" />
                                        </svg>
                                        <p>Belum ada item yang ditambahkan</p>
                                        <p class="text-sm">Klik "Tambah Item" untuk menambahkan item</p>
                                    </div>
                                </td>
                            </tr>
                        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                    </tbody>
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(count($depositItems) > 0): ?>
                        <tfoot class="bg-gray-50">
                            <tr>
                                <td colspan="3" class="py-3 px-4 text-right font-semibold">Total:</td>
                                <td class="py-3 px-4 text-right font-bold text-lg">
                                    Rp <?php echo e(number_format(collect($depositItems)->sum('sub_total_price'), 0, ',', '.')); ?>

                                </td>
                                
                            </tr>
                        </tfoot>
                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                </table>
            </div>
        </div>

        <!-- Payments Table -->
        <div class="bg-white/80 backdrop-blur-sm rounded-xl shadow-lg border border-gray-100 overflow-hidden mb-6">
            <div class="px-6 py-4 border-b border-gray-200">
                <h3 class="text-lg font-semibold text-gray-800">Pembayaran</h3>
            </div>
            <div class="table-container">
                <table class="table">
                    <thead>
                        <tr class="border-b">
                            <th>Metode Pembayaran</th>
                            
                            <th class="right">Amount</th>
                            
                            <th class="center">Tanggal</th>
                            <th class="center w-8">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__empty_5 = true; $__currentLoopData = $depositPayments; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $payment): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_5 = false; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoopIteration(); ?><?php endif; ?>
                            <tr class="border-b">
                                <td class="py-2">
                                    <p class="font-medium"><?php echo e($payment['payment_method_name']); ?></p>
                                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($payment['description']): ?>
                                        <p class="text-xs text-gray-500"><?php echo e($payment['description']); ?></p>
                                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($payment['is_single']): ?>
                                        <span
                                            class="inline-flex px-2 py-1 text-xs font-semibold rounded-full bg-blue-100 text-blue-800">
                                            Single Payment
                                        </span>
                                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                </td>
                                
                                <td class="py-2 text-right font-semibold">
                                    Rp <?php echo e(number_format($payment['payment_real'], 0, ',', '.')); ?>

                                </td>
                                
                                <td class="py-2 text-center"><?php echo e($payment['created_at']); ?></td>
                                <td class="py-2 text-center">
                                    <div class="flex items-center justify-center gap-2">
                                        <button wire:click="editPayment('<?php echo e($payment['id']); ?>')"
                                            class="text-blue-600 hover:text-blue-800" title="Edit">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none"
                                                viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                            </svg>
                                        </button>
                                        <button wire:click="deletePayment('<?php echo e($payment['id']); ?>')"
                                            class="text-red-600 hover:text-red-800"
                                            onclick="return confirm('Yakin ingin menghapus pembayaran ini?')"
                                            title="Hapus">
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
                                <td colspan="6" class="py-8 text-center text-gray-500">
                                    <div class="flex flex-col items-center">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 text-gray-300 mb-2"
                                            fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z" />
                                        </svg>
                                        <p>Belum ada pembayaran</p>
                                        <p class="text-sm">Klik "Tambah Pembayaran" untuk menambahkan pembayaran</p>
                                    </div>
                                </td>
                            </tr>
                        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                    </tbody>
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(count($depositPayments) > 0): ?>
                        <tfoot class="bg-gray-50">
                            <tr>
                                <td class="py-3 px-4 text-right font-semibold">Total Dibayar:</td>
                                <td class="py-3 px-4 text-right font-bold text-lg">
                                    Rp <?php echo e(number_format(collect($depositPayments)->sum('payment_real'), 0, ',', '.')); ?>

                                </td>
                                
                                <td colspan="2"></td>
                            </tr>
                        </tfoot>
                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                </table>
            </div>
        </div>

        <!-- Summary Card -->
        <div class="bg-gradient-to-r from-blue-500 to-blue-600 rounded-xl shadow-lg text-white p-6">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                <div class="text-center">
                    <p class="text-blue-100 text-sm">Total Amount</p>
                    <p class="text-2xl font-bold">Rp
                        <?php echo e(number_format($deposit->grand_total_price ?? 0, 0, ',', '.')); ?></p>
                </div>
                <div class="text-center">
                    <p class="text-blue-100 text-sm">Total Dibayar</p>
                    <p class="text-2xl font-bold">
                        Rp <?php echo e(number_format(collect($depositPayments)->sum('payment_real'), 0, ',', '.')); ?>

                    </p>
                </div>
                <div class="text-center">
                    <?php
                        $totalPayments = collect($depositPayments)->sum('payment_real');
                        $remaining = ($deposit->grand_total_price ?? 0) - $totalPayments;
                    ?>
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($remaining > 0): ?>
                        <p class="text-blue-100 text-sm">Sisa Tagihan</p>
                        <p class="text-2xl font-bold text-yellow-300">
                            Rp <?php echo e(number_format($remaining, 0, ',', '.')); ?>

                        </p>
                    <?php elseif($remaining < 0): ?>
                        <p class="text-blue-100 text-sm">Kembalian</p>
                        <p class="text-2xl font-bold text-green-300">
                            Rp <?php echo e(number_format(abs($remaining), 0, ',', '.')); ?>

                        </p>
                    <?php else: ?>
                        <p class="text-blue-100 text-sm">Status</p>
                        <p class="text-2xl font-bold text-green-300">LUNAS</p>
                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                </div>
            </div>
        </div>
    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
</div>

<script>
    document.addEventListener('livewire:initialized', () => {
        Livewire.on('redirect-after-delay', (data) => {
            setTimeout(() => {
                window.location.href = data[0].url;
            }, data[0].delay);
        });

        Livewire.on('deposit-created-success', (data) => {
            const depositId = data[0].depositId;

            Swal.fire({
                title: 'Deposit Berhasil Dibuat!',
                text: 'Pilih aksi selanjutnya:',
                icon: 'success',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#6c757d',
                confirmButtonText: 'Lihat Detail & Bayar',
                cancelButtonText: 'Kembali ke Menu',
                allowOutsideClick: false,
                allowEscapeKey: false
            }).then((result) => {
                if (result.isConfirmed) {
                    // Redirect to view mode (detail & payment)
                    window.location.href = `/user/master/deposit/detail/${depositId}`;
                } else {
                    // Redirect to deposit menu
                    window.location.href = '<?php echo e(route('user.master.deposit')); ?>';
                }
            });
        });
    });
</script><?php /**PATH /Users/macbookair/Documents/mediction/mediction.id/resources/views/livewire/admin/master/deposit/detail/admin-master-deposit-detail-index.blade.php ENDPATH**/ ?>