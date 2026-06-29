<div>
    <?php echo $__env->make('livewire.admin.logistic.stock-product.detail.admin-logistic-stock-product-detail-modal', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>

    <div class="mb-4">
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-2xl font-bold text-[#1E3A8A]">Detail Stok Opname</h1>
                
            </div>
            <div>
                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(!$status || $status == 'draft'): ?>
                    <button wire:click="confirmSave('draft')" class="btn btn-primary">
                        <span class="fa-solid fa-file-lines mr-1"></span>
                        Buat Draft
                    </button>
                    <button wire:click="confirmSave('process')" class="btn btn-warning">
                        <span class="fa-solid fa-gears mr-1"></span>
                        Buat Proses
                    </button>
                <?php elseif($status == 'process'): ?>
                    <button wire:click="confirmApprove('rejected')" class="btn btn-danger">
                        <span class="fa-solid fa-file-lines mr-1"></span>
                        Tolak
                    </button>

                    <button wire:click="confirmApprove('approve')" class="btn btn-success">
                        <span class="fa-solid fa-check mr-1"></span>
                        Setujui
                    </button>
                <?php else: ?>
                    <button wire:click="confirmApprove('approve')" class="btn btn-success">
                        <span class="fa-solid fa-check mr-1"></span>
                        Perbarui
                    </button>
                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
            </div>
        </div>
    </div>

    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(!$status || $status == 'draft'): ?>
        <div class="bg-white/80 backdrop-blur-sm rounded-xl p-5 shadow-lg border border-gray-100 mb-6">
            <div class="grid grid-cols-1 gap-4">
                <div>
                    <div class="flex items-center justify-between gap-4">
                        <input type="text" class="form-control-search" placeholder="Cari SKU Number..."
                            wire:model.live='search_sku'>
                        <div>
                            <button wire:click="openModal()"
                                class="inline-flex items-center px-4 py-2 bg-green-600 text-white text-sm font-medium rounded-md shadow hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500 w-full">
                                <span class="fa-solid fa-box mr-3"></span>
                                Produk
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
    <div class="space-y-6 mb-6">
        <!-- SECTION 1: Informasi Umum Produk -->
        <div class="p-6 bg-white shadow rounded-lg">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <!-- Kode -->
                <div>
                    <label class="block text-sm font-medium text-gray-700">Kode <span
                            class="text-red-600">*</span></label>
                    <input type="text" wire:model="code" placeholder="Contoh: Kode"
                        <?php echo e(!$status || $status == 'draft' ? null : 'disabled'); ?> class="mt-1 form-control" />
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__errorArgs = ['code'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                        <p class="text-sm text-red-600 mt-1"><?php echo e($message); ?></p>
                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                </div>

                <!-- Tanggal -->
                <div>
                    <label class="block text-sm font-medium text-gray-700">Tanggal <span
                            class="text-red-600">*</span></label>
                    <input type="date" wire:model="date" placeholder="Tanggal"
                        <?php echo e(!$status || $status == 'draft' ? null : 'disabled'); ?> class="mt-1 form-control" />
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__errorArgs = ['date'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                        <p class="text-sm text-red-600 mt-1"><?php echo e($message); ?></p>
                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                </div>

                <!-- Deskripsi -->
                <div class="md:col-span-2">
                    <label class="block text-sm font-medium text-gray-700">Deskripsi <span
                            class="text-red-600">*</span></label>
                    <textarea wire:model="description" placeholder="Deskripsi produk..."
                        <?php echo e(!$status || $status == 'draft' ? null : 'disabled'); ?> class="mt-1 form-control"></textarea>
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__errorArgs = ['description'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                        <p class="text-sm text-red-600 mt-1"><?php echo e($message); ?></p>
                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                </div>
            </div>
        </div>
    </div>
    <div class="bg-white/80 backdrop-blur-sm rounded-xl shadow-lg border border-gray-100 overflow-hidden mb-6">
        <div class="table-container">
            <table class="table">
                <thead>
                    <tr class="bg-gray-50">
                        <th class="w-1 text-center py-3 px-4">No</th>
                        <th class="py-3 px-4" style="width: 150px;">SKU Number</th>
                        <th class="py-3 px-4">Produk</th>
                        <th class="py-3 px-4">Detail</th>
                        <th>Deskripsi</th>
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($status == 'draft'): ?>
                            <th class="w-1 text-center py-3 px-4">Aksi</th>
                        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                    </tr>
                </thead>
                <tbody>
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__empty_1 = true; $__currentLoopData = $detailOpnames; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $detailOpname): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoopIteration(); ?><?php endif; ?>
                        <tr class="hover:bg-gray-50">
                            <td class="text-center align-top border-t py-4" rowspan="3"><?php echo e($index + 1); ?></td>
                            <td class="align-top border-t py-4" rowspan="3">
                                <?php echo e($detailOpname['sku_number']); ?>

                            </td>
                            <td class="align-top border-t py-4" rowspan="3" style="width: 150px">
                                <?php echo e($detailOpname['product_name']); ?>

                            </td>
                            <td class="border-t py-2">
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1"> Fisik <span
                                            class="text-red-500">*</span></label>
                                    <input type="text" wire:model.lazy="detailOpnames.<?php echo e($index); ?>.quantity"
                                        class="mt-1 form-control"
                                        <?php echo e(Auth::user()->hasCompanyRole(['Super Admin', 'Apoteker'], Auth::user()->company_id) ? null : (!$status || $status == 'draft' ? null : 'disabled')); ?>>
                                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__errorArgs = ["detailOpnames.$index.quantity"];
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
                            </td>
                            <td class="border-t py-2" rowspan="3">
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1">Description</label>
                                    <textarea wire:model.lazy="detailOpnames.<?php echo e($index); ?>.description" placeholder="Masukan Deskripsi"
                                        class="mt-1 form-control" <?php echo e(!$status || $status == 'draft' ? null : 'input-disabled'); ?> rows="10"
                                        cols="50" style="resize: none" <?php echo e(!$status || $status == 'draft' ? null : 'disabled'); ?>></textarea>
                                </div>
                            </td>
                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(!$status || $status == 'draft'): ?>
                                <td class="text-center align-top border-t py-4" rowspan="3">
                                    <div class="flex items-center justify-center space-x-2">
                                        <button class="p-2 text-red-600 hover:text-red-800 transition-colors"
                                            wire:click="confirmDelete('<?php echo e($detailOpname['id']); ?>')" title="Delete">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none"
                                                viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                            </svg>
                                        </button>
                                    </div>
                                </td>
                            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                        </tr>
                        <tr>
                            <td class="py-2">
                                <div class="grid grid-cols-2 gap-4">
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-1"> Sistem</label>
                                        <input type="text" value="<?php echo e($detailOpname['quantity_system']); ?>" disabled
                                            class="mt-1 form-control">
                                    </div>
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-1">Selisih </label>
                                        <input type="text" value="<?php echo e($detailOpname['quantity_difference']); ?>"
                                            disabled class="mt-1 form-control">
                                    </div>
                                </div>
                            </td>
                        </tr>
                        <tr class="border-b">
                            <td class="py-2">
                                <div class="grid grid-cols-3 gap-4">
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-1">HPP Average</label>
                                        <input type="text" value="<?php echo e($detailOpname['hpp_average']); ?>" disabled
                                            class="mt-1 form-control">
                                    </div>
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-1">Loss Value</label>
                                        <input type="text" value="<?php echo e($detailOpname['loss_value']); ?>" disabled
                                            class="mt-1 form-control">
                                    </div>
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-1">Excess
                                            Value</label>
                                        <input type="text" value="<?php echo e($detailOpname['excess_value']); ?>" disabled
                                            class="mt-1 form-control">
                                    </div>
                                </div>
                            </td>

                        </tr>
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
                        <tr>
                            <td colspan="5" class="text-center py-4 text-gray-500">Tidak ada data</td>
                        </tr>
                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div><?php /**PATH /Users/macbookair/Documents/mediction/mediction.id/resources/views/livewire/admin/logistic/stock-product/detail/admin-logistic-stock-product-detail-index.blade.php ENDPATH**/ ?>