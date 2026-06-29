<div wire:ignore.self id="modalProduct"
    class="fixed inset-0 bg-overlay hidden items-center justify-center z-50 transition-opacity duration-300 ease-in-out">
    <div
        class="bg-white rounded-2xl shadow-2xl max-w-full w-full transform transition-all scale-95 duration-300 ease-out animate-fade-in">
        <!-- Header -->
        <div class="flex justify-between items-center p-6 border-b flex-none">
            <div class="flex items-center gap-2">
                <svg class="w-6 h-6 text-blue-500" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M13 16h-1v-4h-1m1-4h.01M12 20.5C6.753 20.5 2.5 16.247 2.5 11S6.753 1.5 12 1.5 21.5 5.753 21.5 11 17.247 20.5 12 20.5z" />
                </svg>
                <h2 class="text-xl font-semibold text-gray-800">Modal Produk</h2>
            </div>
            <button wire:click="closeModal()"
                class="text-gray-500 hover:text-red-500 transition-colors text-2xl leading-none cursor-pointer">
                &times;
            </button>
        </div>

        <div class="px-6 py-4 text-gray-600 space-y-4 overflow-y-auto flex-grow">
            <!-- Button Produk Baru dan Lama -->
            <!-- Search and Filter Section -->
            <div class="flex gap-4 mb-4">
                <select wire:model.live='perPageProduct'
                    class="px-4 py-2 border rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                    <option value="5">5</option>
                    <option value="10">10</option>
                    <option value="50">50</option>
                    <option value="100">100</option>
                    <option value="200">200</option>
                </select>
                <div class="relative flex-1">
                    <input type="text" wire:model.live='searchProduct' placeholder="Cari Obat..."
                        class="w-full pl-10 pr-4 py-2 border rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500" />
                    <i class="fas fa-search absolute left-3 top-1/2 -translate-y-1/2 text-gray-400"></i>
                </div>
            </div>
            <div class="flex-1 overflow-y-auto scrollbar-custom" style="max-height: 60vh;">
                <table class="w-full text-sm">
                    <thead class="sticky top-0 bg-white">
                        <tr class="bg-gray-50">
                            <th class="py-3 px-4 text-center font-medium">No</th>
                            <th class="py-3 px-4 text-left font-medium">Sku Number</th>
                            <th class="py-3 px-4 text-left font-medium">Nama Produk</th>
                            <th class="py-3 px-4 text-left font-medium">Deskripsi</th>
                            <th class="py-3 px-4 text-left font-medium">Stok</th>
                            <th class="py-3 px-4 text-left font-medium">Harga</th>
                            <th class="py-3 px-4 text-left font-medium">Diskon</th>
                            <th class="py-3 px-4 text-center font-medium">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__empty_5 = true; $__currentLoopData = $products; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $product): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_5 = false; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoopIteration(); ?><?php endif; ?>
                            <tr class="border-b hover:bg-gray-50">
                                <td class="py-3 px-4 text-center"><?php echo e($products->firstItem() + $index); ?></td>
                                <td class="py-3 px-4"><?php echo e($product->sku_number); ?></td>
                                <td class="py-3 px-4"><?php echo e($product->name); ?></td>
                                <td class="py-3 px-4"><?php echo e($product->description ?? '-'); ?></td>
                                <td class="py-3 px-4">
                                    <?php echo e($product->productStock?->quantity ?? 0); ?>

                                </td>
                                <td class="py-3 px-4">
                                    <?php if (isset($component)) { $__componentOriginal69db86c6e1fe890f389f29829c48024f = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal69db86c6e1fe890f389f29829c48024f = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.product-price','data' => ['product' => $product,'variant' => 'table']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('product-price'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['product' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($product),'variant' => 'table']); ?>
<?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::processComponentKey($component); ?>

<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal69db86c6e1fe890f389f29829c48024f)): ?>
<?php $attributes = $__attributesOriginal69db86c6e1fe890f389f29829c48024f; ?>
<?php unset($__attributesOriginal69db86c6e1fe890f389f29829c48024f); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal69db86c6e1fe890f389f29829c48024f)): ?>
<?php $component = $__componentOriginal69db86c6e1fe890f389f29829c48024f; ?>
<?php unset($__componentOriginal69db86c6e1fe890f389f29829c48024f); ?>
<?php endif; ?>
                                </td>
                                <td class="py-3 px-4">
                                    <?php if (isset($component)) { $__componentOriginaledb2dc88ff2516ef04359f83bbb5ed81 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginaledb2dc88ff2516ef04359f83bbb5ed81 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.product-discount','data' => ['product' => $product,'variant' => 'detailed']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('product-discount'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['product' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($product),'variant' => 'detailed']); ?>
<?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::processComponentKey($component); ?>

<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginaledb2dc88ff2516ef04359f83bbb5ed81)): ?>
<?php $attributes = $__attributesOriginaledb2dc88ff2516ef04359f83bbb5ed81; ?>
<?php unset($__attributesOriginaledb2dc88ff2516ef04359f83bbb5ed81); ?>
<?php endif; ?>
<?php if (isset($__componentOriginaledb2dc88ff2516ef04359f83bbb5ed81)): ?>
<?php $component = $__componentOriginaledb2dc88ff2516ef04359f83bbb5ed81; ?>
<?php unset($__componentOriginaledb2dc88ff2516ef04359f83bbb5ed81); ?>
<?php endif; ?>
                                </td>
                                <td class="py-3 px-4 text-center">
                                    <button class="text-blue-600 hover:text-blue-800 mx-1"
                                        wire:click="getProduct('<?php echo e($product->id); ?>')" title="Edit">
                                        <i class="fas fa-eye"></i>
                                    </button>
                                </td>
                            </tr>
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_5): ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
                            <tr>
                                <td colspan="10" class="py-3 px-4 text-center text-gray-500">Tidak ada data produk
                                </td>
                            </tr>
                        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                    </tbody>
                </table>
            </div>
            <div class="flex items-center justify-between border-t pt-4 mt-4">
                <div class="text-sm text-gray-500">
                    Menampilkan <?php echo e($products->firstItem()); ?> sampai <?php echo e($products->lastItem()); ?> dari
                    <?php echo e($products->total()); ?> data
                </div>

                <?php echo e($products->links('vendor.livewire.paginate-pos')); ?>

            </div>
        </div>
    </div>
</div>
<div wire:ignore.self id="modalPayment"
    class="fixed inset-0 bg-overlay hidden items-center justify-center z-50 transition-opacity duration-300 ease-in-out">
    <div
        class="bg-white rounded-2xl shadow-2xl max-w-4xl w-full transform transition-all scale-95 duration-300 ease-out animate-fade-in">
        <!-- Header -->
        <div class="flex justify-between items-center p-6 border-b">
            <div class="flex items-center gap-2">
                <svg class="w-6 h-6 text-blue-500" fill="none" stroke="currentColor" stroke-width="2"
                    viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M13 16h-1v-4h-1m1-4h.01M12 20.5C6.753 20.5 2.5 16.247 2.5 11S6.753 1.5 12 1.5 21.5 5.753 21.5 11 17.247 20.5 12 20.5z" />
                </svg>
                <h2 class="text-xl font-semibold text-gray-800">Modal Metode Bayar</h2>
            </div>
            <div class="flex items-center gap-4">
                
                <button wire:click="closeModalPayment()"
                    class="text-gray-500 hover:text-red-500 transition-colors text-2xl leading-none cursor-pointer">
                    &times;
                </button>
            </div>
        </div>
        <div class="px-6 py-4 text-gray-600">
            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700">Pilih Metode Bayar <span
                        class="text-red-600">*</span></label>
                <div <?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::$currentLoop['key'] = 'select-'.e(rand()).''; ?>wire:key="select-<?php echo e(rand()); ?>">
                    <select
                        class="mt-1 block w-full rounded-md border-gray-300 focus:border-blue-500 focus:ring-blue-500"
                        x-data x-ref="input" x-init="$($refs.input).selectize({
                            dropdownParent: 'body',
                            allowClear: true,
                            plugins: ['clear_button'],
                            onChange: function(e) {
                                window.Livewire.find('<?php echo e($_instance->getId()); ?>').set('payment_method_id', e ? e : null);
                            }
                        });" wire:model.live="payment_method_id"
                        id="payment_method_id">
                        <option value="">-- Pilih Metode Bayar --</option>
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__currentLoopData = $paymentMethods; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $paymentMethod): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoopIteration(); ?><?php endif; ?>
                            <option value="<?php echo e($paymentMethod->id); ?>"><?php echo e($paymentMethod->name); ?></option>
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
                    </select>
                </div>
                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__errorArgs = ['payment_method_id'];
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
            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700">
                    Total Pembayaran <span class="text-red-600">*</span>
                </label>
                <div class="mt-1 flex rounded-md shadow-sm">
                    <span
                        class="inline-flex items-center px-3 rounded-l-md border border-r-0 border-gray-300 bg-gray-50 text-gray-500 text-sm">
                        Rp
                    </span>
                    <input type="text" onkeyup="convertToRupiah(this)" wire:model.lazy="payment_amount"
                        placeholder="XXXXXXXXXXXX" <?php echo e($is_single_payment ? 'disabled' : null); ?>

                        class="<?php echo e($is_single_payment ? 'block w-full rounded-r-md border border-gray-300 bg-gray-100 text-gray-500 px-4 py-2 cursor-not-allowed focus:outline-none' : 'block w-full rounded-r-md border border-gray-300 px-4 py-2 focus:border-blue-500 focus:ring-blue-500'); ?>" />
                </div>
                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__errorArgs = ['payment_amount'];
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
            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($is_single_payment): ?>
                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700">Biaya Admin</label>
                    <div class="mt-1 flex rounded-md shadow-sm">
                        <span
                            class="inline-flex items-center px-3 rounded-l-md border border-r-0 border-gray-300 bg-gray-100 text-gray-500 text-sm">
                            Rp
                        </span>
                        <input type="text" onkeyup="convertToRupiah(this)" wire:model.lazt="admin_fee"
                            placeholder="XXXXXXXXXXXX" disabled
                            class="block w-full rounded-r-md border border-gray-300 bg-gray-100 text-gray-500 px-4 py-2 cursor-not-allowed focus:outline-none" />
                    </div>
                </div>
            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
            <!-- Notes -->
            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700">Catatan</label>
                <textarea wire:model.lazy='description' rows="3" placeholder="Tambahkan catatan jika diperlukan"
                    class="mt-1 block w-full rounded-md border-gray-300 px-4 py-2 shadow-sm focus:border-blue-500 focus:ring-blue-500"></textarea>
            </div>
        </div>
        <div class="flex justify-between items-center px-6 py-4 border-t bg-white">
            <div class="text-sm text-gray-500">
                
            </div>
            <div class="flex gap-2">
                <button wire:click="closeModalPayment()" wire:loading.attr="disabled" wire:target="submitPayment"
                    class="px-4 py-2 bg-gray-200 hover:bg-gray-300 text-gray-800 rounded-lg shadow transition cursor-pointer">
                    <i class="fas fa-times mr-2"></i>Batal
                </button>
                <button wire:click='submitPayment()' wire:loading.attr="disabled" wire:target="submitPayment"
                    class="px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-lg shadow transition">
                    <span wire:loading.remove wire:target="submitPayment">
                        <i class="fas fa-save mr-2"></i>Simpan
                    </span>
                    <span wire:loading wire:target="submitPayment">
                        <i class="fas fa-spinner fa-spin mr-2"></i>Menyimpan...
                    </span>
                </button>
            </div>
        </div>
    </div>
</div>


<div wire:ignore.self id="modalNarcotic"
    class="fixed inset-0 bg-overlay hidden items-center justify-center z-50 transition-opacity duration-300 ease-in-out">
    <div
        class="bg-white rounded-2xl shadow-2xl max-w-4xl w-full transform transition-all scale-95 duration-300 ease-out animate-fade-in">
        <!-- Header -->
        <div class="flex justify-between items-center p-6 border-b">
            <div class="flex items-center gap-2">
                <svg class="w-6 h-6 text-blue-500" fill="none" stroke="currentColor" stroke-width="2"
                    viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M13 16h-1v-4h-1m1-4h.01M12 20.5C6.753 20.5 2.5 16.247 2.5 11S6.753 1.5 12 1.5 21.5 5.753 21.5 11 17.247 20.5 12 20.5z" />
                </svg>
                <h2 class="text-xl font-semibold text-gray-800">Modal Produk Narkotika</h2>
            </div>
            <div class="flex items-center gap-4">
                <button wire:click="closeModalNarcotic()"
                    class="text-gray-500 hover:text-red-500 transition-colors text-2xl leading-none cursor-pointer">
                    &times;
                </button>
            </div>
        </div>
        <div class="px-6 py-4 text-gray-600">
            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700">
                    Produk
                </label>
                <input type="text" wire:model="product_name" placeholder="Masukan Produk"
                    class="block w-full rounded-r-md border border-gray-300 bg-gray-100 text-gray-500 px-4 py-2 cursor-not-allowed focus:outline-none" />
                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__errorArgs = ['product_name'];
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
            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700">
                    Username Or Email <span class="text-red-600">*</span>
                </label>
                <input type="text" wire:model="username_or_email" placeholder="Masukan Username Or Email"
                    class="block w-full rounded-r-md border border-gray-300 px-4 py-2 focus:border-blue-500 focus:ring-blue-500" />
                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__errorArgs = ['username_or_email'];
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
            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700">
                    Password <span class="text-red-600">*</span>
                </label>
                <div x-data="{ show: false }" class="mt-1 flex rounded-md shadow-sm">
                    <input :type="show ? 'text' : 'password'" wire:model="password" placeholder="Masukkan Password"
                        class="block w-full rounded-l-md border border-gray-300 px-4 py-2 focus:border-blue-500 focus:ring-blue-500 focus:outline-none" />
                    <button type="button" @click="show = !show"
                        class="inline-flex items-center px-3 rounded-r-md border border-l-0 border-gray-300 bg-gray-50 hover:bg-gray-100 text-gray-500 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors">
                        <i :class="show ? 'fas fa-eye' : 'fas fa-eye-slash'" class="text-sm"></i>
                    </button>
                </div>
                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__errorArgs = ['password'];
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
        <div class="flex justify-between items-center px-6 py-4 border-t bg-white">
            <div class="text-sm text-gray-500">
                
            </div>
            <div class="flex gap-2">
                <button wire:click="closeModalNarcotic()" wire:loading.attr="disabled" wire:target="submitNarcotic"
                    class="px-4 py-2 bg-gray-200 hover:bg-gray-300 text-gray-800 rounded-lg shadow transition cursor-pointer">
                    <i class="fas fa-times mr-2"></i>Batal
                </button>
                <button wire:click='submitNarcotic()' wire:loading.attr="disabled" wire:target="submitNarcotic"
                    class="px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-lg shadow transition">
                    <span wire:loading.remove wire:target="submitNarcotic">
                        <i class="fas fa-save mr-2"></i>Simpan
                    </span>
                    <span wire:loading wire:target="submitNarcotic">
                        <i class="fas fa-spinner fa-spin mr-2"></i>Menyimpan...
                    </span>
                </button>
            </div>
        </div>
    </div>
</div><?php /**PATH /Users/macbookair/Documents/mediction/mediction.id/resources/views/livewire/admin/pharmacy/sale/detail/admin-pharmacy-sale-detail-modal.blade.php ENDPATH**/ ?>