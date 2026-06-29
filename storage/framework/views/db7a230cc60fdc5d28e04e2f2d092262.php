<div>
    
    <div class="mb-6">
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-2xl font-bold text-gray-900">
                    <?php echo e($promotion_id ? 'Edit Promosi' : 'Buat Promosi Baru'); ?>

                </h1>
                <p class="text-gray-600 mt-1">Buat dan kelola promosi untuk meningkatkan penjualan</p>
            </div>
            <div class="flex space-x-3">
                <button type="button" wire:click="cancel" class="btn btn-danger">
                    <i class="fas fa-times mr-2"></i>Batal
                </button>
                <button type="button" wire:click="save" class="btn btn-primary">
                    <i class="fas fa-save mr-2"></i>Simpan
                </button>
            </div>
        </div>
    </div>

    <form wire:submit.prevent="save">
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            
            <div class="lg:col-span-2 space-y-6">

                
                <div class="bg-white rounded-xl shadow-sm border p-6">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4">
                        <i class="fas fa-info-circle text-blue-500 mr-2"></i>Informasi Dasar
                    </h3>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div class="md:col-span-2">
                            <label class="block text-sm font-medium text-gray-700 mb-2">
                                Nama Promosi <span class="text-red-500">*</span>
                            </label>
                            <input type="text" wire:model.lazy="name" class="form-control"
                                placeholder="Contoh: Flash Sale Akhir Tahun">
                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__errorArgs = ['name'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                <span class="text-red-500 text-xs"><?php echo e($message); ?></span>
                            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">
                                Kode Promosi <span class="text-red-500">*</span>
                            </label>
                            <div class="mt-1 flex rounded-md shadow-sm">
                                <input type="text" wire:model.lazy="code" class="form-control rounded-r-none"
                                    placeholder="KODEPROMO123">
                                <span wire:click="generateCode"
                                    class="inline-flex items-center rounded-r-md border border-r-0 border-gray-300 bg-gray-100 px-3 text-gray-500 text-sm">
                                    <i class="fas fa-refresh"></i>
                                </span>
                            </div>
                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__errorArgs = ['code'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                <span class="text-red-500 text-xs"><?php echo e($message); ?></span>
                            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">
                                Tipe Promosi <span class="text-red-500">*</span>
                            </label>
                            <select wire:model.lazy="type" class="form-control">
                                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__currentLoopData = $promotionTypes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $value => $label): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoopIteration(); ?><?php endif; ?>
                                    <option value="<?php echo e($value); ?>"><?php echo e($label); ?></option>
                                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
                            </select>
                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__errorArgs = ['type'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                <span class="text-red-500 text-xs"><?php echo e($message); ?></span>
                            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                        </div>

                        <div class="md:col-span-2">
                            <label class="block text-sm font-medium text-gray-700 mb-2">Deskripsi</label>
                            <textarea wire:model.lazy="description" class="form-control" rows="3"
                                placeholder="Jelaskan detail promosi ini..."></textarea>
                        </div>
                    </div>
                </div>

                
                <div class="bg-white rounded-xl shadow-sm border p-6">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4">
                        <i class="fas fa-cogs text-green-500 mr-2"></i>Konfigurasi Promosi
                    </h3>

                    
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($type): ?>
                        <div
                            class="mb-6 p-4 bg-gradient-to-r from-blue-50 to-cyan-50 border-l-4 border-blue-400 rounded-r-lg">
                            <div class="flex items-start">
                                <div class="flex-shrink-0">
                                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($type === 'discount'): ?>
                                        <i class="fas fa-percentage text-blue-500 text-xl"></i>
                                    <?php elseif($type === 'buy_x_get_y'): ?>
                                        <i class="fas fa-gift text-green-500 text-xl"></i>
                                    <?php elseif($type === 'bundle'): ?>
                                        <i class="fas fa-box text-purple-500 text-xl"></i>
                                    <?php elseif($type === 'special'): ?>
                                        <i class="fas fa-star text-yellow-500 text-xl"></i>
                                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                </div>
                                <div class="ml-3">
                                    <h4 class="text-sm font-medium text-gray-900">
                                        <?php echo e($promotionTypes[$type]); ?> - Panduan Penggunaan
                                    </h4>
                                    <div class="mt-2 text-sm text-gray-700">
                                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($type === 'discount'): ?>
                                            <p><strong>💰 Cara Kerja:</strong> Memberikan potongan harga langsung pada
                                                produk yang dipilih</p>
                                            <p><strong>🎯 Cocok untuk:</strong> Flash sale, clearance, diskon harian</p>
                                            <p><strong>⚡ Tips:</strong> Gunakan persentase untuk produk mahal, nominal
                                                untuk produk murah</p>
                                        <?php elseif($type === 'buy_x_get_y'): ?>
                                            <p><strong>🎁 Cara Kerja:</strong> Beli sejumlah produk, dapatkan produk
                                                gratis/diskon</p>
                                            <p><strong>🎯 Cocok untuk:</strong> Promosi produk slow-moving,
                                                cross-selling</p>
                                            <p><strong>⚡ Tips:</strong> Pilih produk gratis yang profitable dan menarik
                                            </p>
                                        <?php elseif($type === 'bundle'): ?>
                                            <p><strong>📦 Cara Kerja:</strong> Paket beberapa produk dengan harga khusus
                                            </p>
                                            <p><strong>🎯 Cocok untuk:</strong> Produk komplementer, paket hemat</p>
                                            <p><strong>⚡ Tips:</strong> Bundle produk yang sering dibeli bersamaan</p>
                                        <?php elseif($type === 'discount_product'): ?>
                                            <p><strong>🎯 Cara Kerja:</strong> Pilih produk dan beri diskon individual
                                                atau bulk</p>
                                            <p><strong>🎯 Cocok untuk:</strong> Flash sale, clearance, produk seasonal
                                            </p>
                                            <p><strong>⚡ Tips:</strong> Pilih beberapa produk dan atur diskon
                                                masing-masing secara cepat</p>
                                        <?php elseif($type === 'special'): ?>
                                            <p><strong>⭐ Cara Kerja:</strong> Promosi khusus seperti cashback</p>
                                            <p><strong>🎯 Cocok untuk:</strong> Customer retention, loyalty program</p>
                                            <p><strong>⚡ Tips:</strong> Sesuaikan dengan tipe pelanggan target</p>
                                        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

                    
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($type === 'discount'): ?>
                        <div class="space-y-4">
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2">
                                        Tipe Diskon <span class="text-red-500">*</span>
                                    </label>
                                    <select wire:model.lazy="discount_type" class="form-control">
                                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__currentLoopData = $discountTypes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $value => $label): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoopIteration(); ?><?php endif; ?>
                                            <option value="<?php echo e($value); ?>"><?php echo e($label); ?></option>
                                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
                                    </select>
                                </div>

                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2">
                                        Nilai Diskon <span class="text-red-500">*</span>
                                    </label>
                                    <div class="relative">
                                        <input type="number" wire:model.lazy="discount_value"
                                            class="form-control pr-12" placeholder="0" step="0.01" min="0"
                                            <?php if($discount_type === 'percentage'): ?> max="100" <?php endif; ?>>
                                        <div
                                            class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none">
                                            <span class="text-gray-500 text-sm">
                                                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($discount_type === 'percentage'): ?>
                                                    %
                                                <?php else: ?>
                                                    Rp
                                                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                            </span>
                                        </div>
                                    </div>
                                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__errorArgs = ['discount_value'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                        <span class="text-red-500 text-xs"><?php echo e($message); ?></span>
                                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                </div>

                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2">Minimal Pembelian
                                        (Rp)</label>
                                    <input type="number" wire:model.lazy="minimum_purchase" class="form-control"
                                        placeholder="0" step="0.01" min="0">
                                </div>

                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2">Maksimal Pembelian
                                        (Rp)</label>
                                    <input type="number" wire:model.lazy="max_discount" class="form-control"
                                        placeholder="Tidak terbatas" step="0.01" min="0">
                                    <p class="text-xs text-gray-500 mt-1">Kosongkan jika tidak ada batas maksimal
                                    </p>
                                </div>


                            </div>

                            
                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($discount_value > 0): ?>
                                <div
                                    class="bg-gradient-to-r from-green-50 to-blue-50 border border-green-200 rounded-lg p-4">
                                    <h5 class="font-semibold text-green-800 mb-3 flex items-center">
                                        <i class="fas fa-calculator mr-2"></i>Preview Contoh Perhitungan
                                    </h5>
                                    <div class="grid grid-cols-3 gap-4 text-sm">
                                        <?php
                                            $samplePrices = [50000, 100000, 250000];
                                        ?>
                                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__currentLoopData = $samplePrices; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $samplePrice): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoopIteration(); ?><?php endif; ?>
                                            <div class="text-center bg-white rounded-lg p-3 shadow-sm">
                                                <div class="text-gray-600 text-xs font-medium">Harga Rp
                                                    <?php echo e(number_format($samplePrice, 0, ',', '.')); ?></div>
                                                <?php
                                                    $finalPrice = $this->calculateFinalPrice($samplePrice);
                                                    $discountAmount = $samplePrice - $finalPrice;
                                                    $discountPercent =
                                                        $samplePrice > 0 ? ($discountAmount / $samplePrice) * 100 : 0;
                                                ?>
                                                <div class="text-red-600 font-medium">-Rp
                                                    <?php echo e(number_format($discountAmount, 0, ',', '.')); ?></div>
                                                <div class="text-green-600 font-bold text-lg">Rp
                                                    <?php echo e(number_format($finalPrice, 0, ',', '.')); ?></div>
                                                <div class="text-xs text-gray-500">Hemat
                                                    <?php echo e(number_format($discountPercent, 1)); ?>%</div>
                                            </div>
                                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
                                    </div>
                                </div>
                            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                        </div>
                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

                    
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($type === 'buy_x_get_y'): ?>
                        <div class="space-y-4">
                            
                            <div>
                                <div class="flex items-center justify-between mb-4">
                                    <h4 class="font-semibold text-lg">Aturan Beli X Dapat Y</h4>
                                    <button type="button" wire:click="addBuyXGetYRule"
                                        class="px-3 py-1 bg-purple-600 text-white rounded text-sm hover:bg-purple-700">
                                        <i class="fas fa-plus mr-1"></i>Tambah Aturan
                                    </button>
                                </div>

                                
                                

                                <div class="space-y-4">
                                    <?php
                                        // Initialize rules if empty
                                        if (empty($buy_x_get_y_rules)) {
                                            $this->initializeBuyXGetYRules();
                                        }

                                        // Filter out non-array items (like UUID strings)
                                        $validRules = array_filter($buy_x_get_y_rules, function ($item) {
                                            return is_array($item);
                                        });
                                        $validRules = array_values($validRules);
                                    ?>

                                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(!empty($validRules)): ?>
                                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__currentLoopData = $validRules; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $rule): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoopIteration(); ?><?php endif; ?>
                                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(is_array($rule)): ?>
                                                <div class="border border-gray-200 rounded-lg p-4 bg-gray-50">
                                                    <div class="flex items-center justify-between mb-3">
                                                        <span class="font-medium text-gray-700">Aturan
                                                            #<?php echo e($index + 1); ?></span>
                                                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(count($validRules) > 1): ?>
                                                            <button type="button"
                                                                wire:click="removeBuyXGetYRule(<?php echo e($index); ?>)"
                                                                class="text-red-600 hover:text-red-800">
                                                                <i class="fas fa-trash"></i>
                                                            </button>
                                                        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                                    </div>

                                                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                                        <div>
                                                            <label
                                                                class="block text-sm font-medium text-gray-700 mb-2">
                                                                Jumlah Beli <span class="text-red-500">*</span>
                                                            </label>
                                                            <input type="number"
                                                                wire:model="buy_x_get_y_rules.<?php echo e($index); ?>.buy_quantity"
                                                                class="form-control" placeholder="1" min="1">
                                                        </div>

                                                        <div>
                                                            <label
                                                                class="block text-sm font-medium text-gray-700 mb-2">
                                                                Jumlah Gratis <span class="text-red-500">*</span>
                                                            </label>
                                                            <input type="number"
                                                                wire:model="buy_x_get_y_rules.<?php echo e($index); ?>.get_quantity"
                                                                class="form-control" placeholder="1" min="1">
                                                        </div>

                                                        <div>
                                                            <label
                                                                class="block text-sm font-medium text-gray-700 mb-2">Produk
                                                                yang Dibeli</label>
                                                            <select
                                                                wire:model="buy_x_get_y_rules.<?php echo e($index); ?>.buy_product_id"
                                                                wire:change="$refresh" class="form-control">
                                                                <option value="">Pilih Produk</option>
                                                                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__currentLoopData = $products; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $product): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoopIteration(); ?><?php endif; ?>
                                                                    <option value="<?php echo e($product->id); ?>"
                                                                        <?php if(isset($rule['buy_product_id']) && $rule['buy_product_id'] == $product->id): ?> selected <?php endif; ?>>
                                                                        <?php echo e($product->name); ?>

                                                                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(isset($product->sku_number)): ?>
                                                                            - <?php echo e($product->sku_number); ?>

                                                                        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                                                    </option>
                                                                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
                                                            </select>
                                                        </div>

                                                        <div>
                                                            <label
                                                                class="block text-sm font-medium text-gray-700 mb-2">Produk
                                                                Gratis</label>
                                                            <select
                                                                wire:model="buy_x_get_y_rules.<?php echo e($index); ?>.get_product_id"
                                                                wire:change="$refresh" class="form-control">
                                                                <option value="">Pilih Produks
                                                                </option>
                                                                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__currentLoopData = $products; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $product): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoopIteration(); ?><?php endif; ?>
                                                                    <option value="<?php echo e($product->id); ?>"
                                                                        <?php if(isset($rule['get_product_id']) && $rule['get_product_id'] == $product->id): ?> selected <?php endif; ?>>
                                                                        <?php echo e($product->name); ?>

                                                                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(isset($product->sku_number)): ?>
                                                                            - <?php echo e($product->sku_number); ?>

                                                                        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                                                    </option>
                                                                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
                                                            </select>
                                                        </div>
                                                    </div>

                                                    
                                                    <div
                                                        class="mt-3 p-3 bg-purple-50 border border-purple-200 rounded">
                                                        <p class="text-sm text-purple-700">
                                                            🛒 <strong>Beli <?php echo e($rule['buy_quantity'] ?? 1); ?>

                                                                produk</strong>
                                                            → 🎁 <strong>Gratis <?php echo e($rule['get_quantity'] ?? 1); ?>

                                                                produk</strong>
                                                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(!empty($rule['buy_product_id'])): ?>
                                                                <?php
                                                                    $buyProduct = $products->firstWhere(
                                                                        'id',
                                                                        $rule['buy_product_id'],
                                                                    );
                                                                ?>
                                                                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($buyProduct): ?>
                                                                    <br>📦 Khusus produk: <?php echo e($buyProduct->name); ?>

                                                                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                                            <?php else: ?>
                                                                <br>📦 Berlaku untuk semua produk
                                                            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(!empty($rule['get_product_id'])): ?>
                                                                <?php
                                                                    $getProduct = $products->firstWhere(
                                                                        'id',
                                                                        $rule['get_product_id'],
                                                                    );
                                                                ?>
                                                                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($getProduct): ?>
                                                                    <br>🎁 Produk gratis: <?php echo e($getProduct->name); ?>

                                                                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                                            <?php else: ?>
                                                                <br>🎁 Gratis produk yang sama
                                                            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                                        </p>
                                                    </div>
                                                </div>
                                            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
                                    <?php else: ?>
                                        <div class="text-center py-4 text-gray-500">
                                            <p>Belum ada aturan Buy X Get Y. Klik "Tambah Aturan" untuk menambah aturan
                                                baru.</p>
                                        </div>
                                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                </div>
                            </div>

                            
                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(!empty($validRules)): ?>
                                <div
                                    class="bg-gradient-to-r from-purple-50 to-pink-50 border border-purple-200 rounded-lg p-4">
                                    <h5 class="font-semibold text-purple-800 mb-3 flex items-center">
                                        <i class="fas fa-gift mr-2"></i>Ringkasan Semua Aturan
                                        (<?php echo e(count($validRules)); ?> aturan)
                                    </h5>
                                    <div class="space-y-2">
                                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__currentLoopData = $validRules; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $rule): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoopIteration(); ?><?php endif; ?>
                                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(is_array($rule)): ?>
                                                <div class="text-sm text-purple-700 bg-white rounded p-2">
                                                    <strong>Aturan <?php echo e($index + 1); ?>:</strong>
                                                    Beli <?php echo e($rule['buy_quantity'] ?? 1); ?> → Gratis
                                                    <?php echo e($rule['get_quantity'] ?? 1); ?>

                                                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(!empty($rule['buy_product_id'])): ?>
                                                        <?php
                                                            $buyProduct = $products->firstWhere(
                                                                'id',
                                                                $rule['buy_product_id'],
                                                            );
                                                        ?>
                                                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($buyProduct): ?>
                                                            (<?php echo e($buyProduct->name); ?>)
                                                        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                                </div>
                                            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
                                    </div>
                                    <p class="text-xs text-purple-600 mt-3">
                                        💡 Pelanggan dapat memanfaatkan semua aturan yang berlaku sesuai dengan produk
                                        yang dibeli
                                    </p>
                                </div>
                            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                        </div>
                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

                    
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($type === 'bundle'): ?>
                        <div class="space-y-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">
                                    Harga Bundle (Rp) <span class="text-red-500">*</span>
                                </label>
                                <input type="number" wire:model.lazy="bundle_price" class="form-control"
                                    placeholder="0" step="0.01" min="0">
                                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__errorArgs = ['bundle_price'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                    <span class="text-red-500 text-xs"><?php echo e($message); ?></span>
                                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-3">Produk dalam Bundle</label>
                                <div class="border border-gray-200 rounded-lg p-4">
                                    <div class="space-y-3">
                                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__currentLoopData = $bundle_products; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $bundleProduct): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoopIteration(); ?><?php endif; ?>
                                            <div class="flex items-center space-x-3">
                                                <select
                                                    wire:model.lazy="bundle_products.<?php echo e($index); ?>.product_id"
                                                    class="form-control flex-1">
                                                    <option value="">Pilih Produk</option>
                                                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__currentLoopData = $availableProducts; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $id => $name): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoopIteration(); ?><?php endif; ?>
                                                        <option value="<?php echo e($id); ?>"><?php echo e($name); ?>

                                                        </option>
                                                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
                                                </select>
                                                <input type="number"
                                                    wire:model.lazy="bundle_products.<?php echo e($index); ?>.quantity"
                                                    class="form-control w-20" placeholder="1" min="1">
                                                <button type="button"
                                                    wire:click="removeBundleProduct(<?php echo e($index); ?>)"
                                                    class="btn btn-sm btn-outline text-red-600">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </div>
                                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
                                    </div>
                                    <button type="button" wire:click="addBundleProduct"
                                        class="btn btn-sm btn-primary mt-3">
                                        <i class="fas fa-plus mr-2"></i>Tambah Produk
                                    </button>
                                </div>
                            </div>

                            
                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($bundle_price > 0 && !empty($bundle_products)): ?>
                                <div
                                    class="bg-gradient-to-r from-indigo-50 to-purple-50 border border-indigo-200 rounded-lg p-4">
                                    <h5 class="font-semibold text-indigo-800 mb-2 flex items-center">
                                        <i class="fas fa-box mr-2"></i>Preview Bundle
                                    </h5>
                                    <div class="text-indigo-700">
                                        <p><strong>📦 Paket Bundle: Rp
                                                <?php echo e(number_format($bundle_price, 0, ',', '.')); ?></strong></p>
                                        <div class="mt-2 space-y-1">
                                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__currentLoopData = $bundle_products; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $bundleProduct): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoopIteration(); ?><?php endif; ?>
                                                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(!empty($bundleProduct['product_id']) && isset($availableProducts[$bundleProduct['product_id']])): ?>
                                                    <p class="text-sm">
                                                        • <?php echo e($bundleProduct['quantity']); ?>x
                                                        <?php echo e($availableProducts[$bundleProduct['product_id']]); ?>

                                                    </p>
                                                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
                                        </div>
                                    </div>
                                </div>
                            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                        </div>
                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

                    
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($type === 'discount_product'): ?>
                        <div class="bg-blue-50 p-4 rounded-lg">
                            <h4 class="font-semibold text-lg mb-4">Konfigurasi Diskon Produk</h4>

                            
                            <div class="mb-4">
                                <label class="block text-sm font-medium text-gray-700 mb-2">
                                    Pilih Produk
                                </label>
                                <div>
                                    <input type="search" wire:model.live='search' class="form-control mt-1"
                                        placeholder="Cari Produk ...">
                                </div>
                                <div
                                    class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-3 max-h-60 overflow-y-auto border rounded-lg p-3">
                                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__empty_1 = true; $__currentLoopData = $products; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $product): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoopIteration(); ?><?php endif; ?>
                                        <div class="border rounded p-2 <?php echo e(in_array($product->id, $selected_discount_products ?? []) ? 'border-blue-500 bg-blue-50' : 'border-gray-200'); ?>"
                                            <?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::$currentLoop['key'] = ''; ?>wire:key='<?php echo e($product->id); ?>'>
                                            <label class="flex items-center cursor-pointer">
                                                <input type="checkbox" wire:model.lazy="selected_discount_products"
                                                    value="<?php echo e($product->id); ?>" class="mr-2">
                                                <div class="flex-1">
                                                    <div class="font-medium text-sm"><?php echo e($product->name); ?></div>
                                                    <div class="text-xs text-gray-500">
                                                        Rp <?php echo e(number_format($this->getProductPrice($product->id))); ?>

                                                    </div>
                                                </div>
                                            </label>
                                        </div>
                                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
                                        <div class="text-center text-gray-500 text-sm py-4">
                                            Tidak ada produk yang tersedia.
                                        </div>
                                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                </div>
                                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(!empty($selected_discount_products)): ?>
                                    <div class="mt-2">
                                        <button type="button" wire:click="addSelectedDiscountProducts"
                                            class="px-3 py-1 bg-blue-600 text-white rounded text-sm hover:bg-blue-700">
                                            Tambah Produk Terpilih (<?php echo e(count($selected_discount_products)); ?>)
                                        </button>
                                    </div>
                                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                            </div>

                            
                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(!empty($discount_products)): ?>
                                <div class="mb-4 bg-gray-50 p-3 rounded">
                                    <h5 class="font-medium mb-2">Pengaturan Diskon Massal</h5>
                                    <div class="flex items-center gap-3">
                                        <div>
                                            <label class="block text-xs text-gray-600">Tipe Diskon</label>
                                            <select wire:model.lazy="bulk_discount_type"
                                                class="border rounded px-2 py-1 text-sm">
                                                <option value="percentage">Persentase (%)</option>
                                                <option value="fixed_amount">Nominal (Rp)</option>
                                            </select>
                                        </div>
                                        <div>
                                            <label class="block text-xs text-gray-600">Nilai Diskon</label>
                                            <input type="number" wire:model.lazy="bulk_discount_value"
                                                class="border rounded px-2 py-1 w-20 text-sm" min="0"
                                                step="0.01">
                                        </div>
                                        <div class="self-end">
                                            <button type="button" wire:click="applyBulkDiscount"
                                                class="px-3 py-1 bg-green-600 text-white rounded text-sm hover:bg-green-700">
                                                Terapkan ke Semua
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

                            
                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(!empty($discount_products)): ?>
                                <div class="mb-4">
                                    <h5 class="font-medium mb-2">Produk Terpilih (<?php echo e(count($discount_products)); ?>)
                                    </h5>
                                    <div class="space-y-2 max-h-40 overflow-y-auto">
                                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__currentLoopData = $discount_products; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $discountProduct): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoopIteration(); ?><?php endif; ?>
                                            <?php
                                                $product = $products->firstWhere('id', $discountProduct['product_id']);
                                                $originalPrice = $this->getProductPrice($discountProduct['product_id']);
                                                $finalPrice = $this->calculateFinalPriceFromArray(
                                                    $discountProduct,
                                                    $originalPrice,
                                                );
                                            ?>
                                            <div class="border rounded p-3 bg-white">
                                                <div class="flex items-center justify-between">
                                                    <div class="flex-1">
                                                        <div class="font-medium">
                                                            <?php echo e($product->product_name ?? 'Produk tidak ditemukan'); ?>

                                                        </div>
                                                        <div class="text-sm text-gray-600">
                                                            <div class="flex items-center gap-2">
                                                                <span>Harga Awal: <span class="font-medium">Rp
                                                                        <?php echo e(number_format($originalPrice)); ?></span></span>
                                                                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($finalPrice != $originalPrice): ?>
                                                                    <span class="text-green-600">→</span>
                                                                    <span class="text-green-600 font-medium">Rp
                                                                        <?php echo e(number_format($finalPrice)); ?></span>
                                                                    <span
                                                                        class="text-xs bg-green-100 text-green-800 px-1 rounded">
                                                                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(isset($discountProduct['discount_type']) && $discountProduct['discount_type'] === 'percentage'): ?>
                                                                            -<?php echo e($discountProduct['discount_value'] ?? 0); ?>%
                                                                        <?php else: ?>
                                                                            -Rp
                                                                            <?php echo e(number_format($discountProduct['discount_value'] ?? 0)); ?>

                                                                        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                                                    </span>
                                                                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                                            </div>
                                                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($finalPrice != $originalPrice): ?>
                                                                <div class="text-xs text-green-600 mt-1">
                                                                    Hemat: Rp
                                                                    <?php echo e(number_format($originalPrice - $finalPrice)); ?>

                                                                </div>
                                                            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                                        </div>
                                                    </div>
                                                    <div class="flex items-center gap-2">
                                                        <div class="flex items-center gap-1">
                                                            <select
                                                                wire:model.live="discount_products.<?php echo e($index); ?>.discount_type"
                                                                class="border rounded px-2 py-1 text-sm">
                                                                <option value="percentage">%</option>
                                                                <option value="fixed_amount">Rp</option>
                                                            </select>
                                                            <input type="number"
                                                                wire:model.live="discount_products.<?php echo e($index); ?>.discount_value"
                                                                class="border rounded px-2 py-1 w-20 text-sm"
                                                                min="0" step="0.01" placeholder="0">
                                                        </div>
                                                        <button type="button"
                                                            wire:click="removeDiscountProduct(<?php echo e($index); ?>)"
                                                            class="text-red-600 hover:text-red-800">
                                                            <svg class="w-4 h-4" fill="none" stroke="currentColor"
                                                                viewBox="0 0 24 24">
                                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                                    stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                                            </svg>
                                                        </button>
                                                    </div>
                                                </div>
                                            </div>
                                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
                                    </div>
                                </div>
                            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

                            
                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(!empty($discount_products)): ?>
                                <div class="bg-green-50 p-3 rounded">
                                    <h5 class="font-medium text-green-800 mb-1">Ringkasan Diskon</h5>
                                    <div class="text-sm text-green-700">
                                        <?php
                                            $totalOriginal = array_sum(
                                                array_map(function ($dp) {
                                                    return $this->getProductPrice($dp['product_id']);
                                                }, $discount_products),
                                            );
                                            $totalFinal = array_sum(
                                                array_map(function ($dp) {
                                                    $originalPrice = $this->getProductPrice($dp['product_id']);
                                                    return $this->calculateFinalPriceFromArray($dp, $originalPrice);
                                                }, $discount_products),
                                            );
                                            $totalSavings = $totalOriginal - $totalFinal;
                                        ?>
                                        Total Harga Awal: Rp <?php echo e(number_format($totalOriginal)); ?> <br>
                                        Total Setelah Diskon: Rp <?php echo e(number_format($totalFinal)); ?> <br>
                                        Total Penghematan: <span class="font-medium">Rp
                                            <?php echo e(number_format($totalSavings)); ?></span>
                                    </div>
                                </div>
                            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                        </div>
                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

                    
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($type === 'special'): ?>
                        <div class="space-y-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">
                                    Jenis Promosi Khusus <span class="text-red-500">*</span>
                                </label>
                                <select wire:model.lazy="special_type" class="form-control">
                                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__currentLoopData = $specialTypes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $value => $label): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoopIteration(); ?><?php endif; ?>
                                        <option value="<?php echo e($value); ?>"><?php echo e($label); ?></option>
                                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
                                </select>
                            </div>

                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($special_type === 'cashback'): ?>
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-2">Persentase Cashback
                                            (%)</label>
                                        <input type="number" wire:model.lazy="cashback_percentage"
                                            class="form-control" placeholder="0" step="0.1" min="0"
                                            max="100">
                                    </div>
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-2">Maksimal Cashback
                                            (Rp)</label>
                                        <input type="number" wire:model.lazy="max_cashback" class="form-control"
                                            placeholder="Tidak terbatas" step="0.01" min="0">
                                    </div>
                                </div>
                            <?php elseif($special_type === 'free_shipping'): ?>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2">Minimal Pembelian untuk
                                        Gratis Ongkir (Rp)</label>
                                    <input type="number" wire:model.lazy="free_shipping_min" class="form-control"
                                        placeholder="0" step="0.01" min="0">
                                </div>
                            <?php elseif($special_type === 'loyalty_points'): ?>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2">Multiplier Poin</label>
                                    <input type="number" wire:model.lazy="points_multiplier" class="form-control"
                                        placeholder="1" step="0.1" min="0">
                                    <p class="text-xs text-gray-500 mt-1">Contoh: 2 = poin ganda, 1.5 = poin 1.5x lipat
                                    </p>
                                </div>
                            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

                            
                            <div
                                class="bg-gradient-to-r from-yellow-50 to-orange-50 border border-yellow-200 rounded-lg p-4">
                                <h5 class="font-semibold text-yellow-800 mb-2 flex items-center">
                                    <i class="fas fa-star mr-2"></i>Preview Promosi Khusus
                                </h5>
                                <p class="text-yellow-700">
                                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($special_type === 'cashback'): ?>
                                        💸 <strong>Cashback <?php echo e($cashback_percentage); ?>%</strong>
                                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($max_cashback): ?>
                                            (maksimal Rp <?php echo e(number_format($max_cashback, 0, ',', '.')); ?>)
                                        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                    <?php elseif($special_type === 'free_shipping'): ?>
                                        🚚 <strong>Gratis Ongkir</strong> untuk pembelian minimal Rp
                                        <?php echo e(number_format($free_shipping_min, 0, ',', '.')); ?>

                                    <?php elseif($special_type === 'loyalty_points'): ?>
                                        ⭐ <strong>Poin <?php echo e($points_multiplier); ?>x Lipat</strong> untuk setiap pembelian
                                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                </p>
                            </div>
                        </div>
                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                </div>

                
                <div class="bg-white rounded-xl shadow-sm border p-6">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4">
                        <i class="fas fa-target text-orange-500 mr-2"></i>Target Tambahan (Opsional)
                    </h3>

                    <div class="space-y-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Berlaku Untuk Company</label>
                            <select wire:model.live="company_target_type" class="form-control">
                                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__currentLoopData = $companyTargetTypes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $value => $label): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoopIteration(); ?><?php endif; ?>
                                    <option value="<?php echo e($value); ?>"><?php echo e($label); ?></option>
                                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
                            </select>
                        </div>

                        
                        

                        
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($company_target_type === 'specific'): ?>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Pilih Company
                                    Tertentu</label>
                                <div <?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::$currentLoop['key'] = 'select-'.e(rand()).''; ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::$currentLoop['key'] = 'select-'.e(rand()).''; ?>wire:key="select-<?php echo e(rand()); ?>">
                                    <select multiple class="mt-1 form-control" x-data x-ref="input"
                                        x-init="$($refs.input).selectize({
                                            dropdownParent: 'body',
                                            allowClear: true,
                                            plugins: ['clear_button'],
                                            onChange: function(e) {
                                                window.Livewire.find('<?php echo e($_instance->getId()); ?>').set('selectedCompanies', e ? e : null);
                                            }
                                        });" wire:model.lazy="selectedCompanies"
                                        id="selectedCompanies">
                                        <option value="">-- Pilih Perusahaan --</option>
                                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__currentLoopData = $companies; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $company): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoopIteration(); ?><?php endif; ?>
                                            <option value="<?php echo e($company->id); ?>"><?php echo e($company->name); ?></option>
                                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
                                    </select>
                                </div>
                                <p class="text-xs text-gray-500 mt-1">Kosongkan untuk semua cabang</p>
                            </div>
                        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

                        
                        

                        
                        

                        
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Target User Tipe</label>
                            <div <?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::$currentLoop['key'] = 'select-'.e(rand()).''; ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::$currentLoop['key'] = 'select-'.e(rand()).''; ?>wire:key="select-<?php echo e(rand()); ?>">
                                <select multiple class="mt-1 form-control" x-data x-ref="input"
                                    x-init="$($refs.input).selectize({
                                        dropdownParent: 'body',
                                        allowClear: true,
                                        plugins: ['clear_button'],
                                        onChange: function(e) {
                                            window.Livewire.find('<?php echo e($_instance->getId()); ?>').set('selectedUserTypes', e ? e : null);
                                        }
                                    });" wire:model.lazy="selectedUserTypes"
                                    id="selectedUserTypes">
                                    <option value="">-- Pilih User Tipe --</option>
                                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__currentLoopData = $userTypes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $userType): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoopIteration(); ?><?php endif; ?>
                                        <option value="<?php echo e($userType->id); ?>"><?php echo e($userType->name); ?></option>
                                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
                                </select>
                            </div>
                            <p class="text-xs text-gray-500 mt-1">Kosongkan untuk semua tipe user</p>
                        </div>

                        
                        
                    </div>
                </div>

                
                <div class="bg-white rounded-xl shadow-sm border p-6">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4">
                        <i class="fas fa-calendar-clock text-purple-500 mr-2"></i>Jadwal & Kuota Promosi
                    </h3>

                    <div class="space-y-6">
                        
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-3">
                                <i class="fas fa-calendar-alt mr-1"></i>Periode Berlaku
                            </label>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div>
                                    <label class="block text-sm font-medium text-gray-600 mb-2">Tanggal Mulai</label>
                                    <input type="date" wire:model.lazy="start_date" class="form-control">
                                    <p class="text-xs text-gray-500 mt-1">Tanggal promosi mulai berlaku</p>
                                </div>

                                <div>
                                    <label class="block text-sm font-medium text-gray-600 mb-2">Tanggal
                                        Berakhir</label>
                                    <input type="date" wire:model.lazy="end_date" class="form-control">
                                    <p class="text-xs text-gray-500 mt-1">Tanggal promosi berakhir</p>
                                </div>
                            </div>

                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($start_date && $end_date): ?>
                                <div class="mt-3 p-3 bg-blue-50 border border-blue-200 rounded">
                                    <div class="text-sm text-blue-700">
                                        <i class="fas fa-calendar mr-1"></i>
                                        <strong>Periode:</strong> <?php echo e(date('d M Y', strtotime($start_date))); ?> -
                                        <?php echo e(date('d M Y', strtotime($end_date))); ?>

                                        <span class="ml-2 text-blue-600">
                                            (<?php echo e(abs(strtotime($end_date) - strtotime($start_date)) / (60 * 60 * 24) + 1); ?>

                                            hari)
                                        </span>
                                    </div>
                                </div>
                            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                        </div>

                        
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-3">
                                <i class="fas fa-clock mr-1"></i>Jadwal Aktif
                            </label>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-3">
                                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__currentLoopData = $scheduleTypes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $value => $label): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoopIteration(); ?><?php endif; ?>
                                    <label
                                        class="flex items-center p-3 border border-gray-200 rounded-lg hover:bg-gray-50 cursor-pointer transition-colors duration-200 <?php echo e($schedule_type === $value ? 'border-blue-500 bg-blue-50' : ''); ?>">
                                        <input type="radio" wire:model.live="schedule_type"
                                            value="<?php echo e($value); ?>"
                                            class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300">
                                        <div class="ml-3">
                                            <div class="text-sm font-medium text-gray-700"><?php echo e($label); ?></div>
                                            <div class="text-xs text-gray-500">
                                                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($value === 'always'): ?>
                                                    Promosi berlaku sepanjang waktu
                                                <?php elseif($value === 'days_only'): ?>
                                                    Hanya berlaku di hari-hari tertentu
                                                <?php elseif($value === 'time_only'): ?>
                                                    Berlaku setiap hari pada jam tertentu
                                                <?php elseif($value === 'days_and_time'): ?>
                                                    Berlaku di hari dan jam tertentu saja
                                                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                            </div>
                                        </div>
                                    </label>
                                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
                            </div>
                        </div>

                        
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($schedule_type === 'days_only' || $schedule_type === 'days_and_time'): ?>
                            <div class="bg-blue-50 border border-blue-200 rounded-lg p-4">
                                <label class="block text-sm font-medium text-gray-700 mb-3">
                                    <i class="fas fa-calendar-day mr-1"></i>Pilih Hari Berlaku
                                </label>
                                <div class="grid grid-cols-2 md:grid-cols-4 lg:grid-cols-7 gap-3">
                                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__currentLoopData = $dayOptions; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $value => $label): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoopIteration(); ?><?php endif; ?>
                                        <label
                                            class="flex items-center p-2 border border-gray-200 rounded hover:bg-gray-50 cursor-pointer transition-colors duration-200 <?php echo e(in_array($value, $specific_days ?? []) ? 'border-blue-500 bg-blue-100' : 'bg-white'); ?>">
                                            <input type="checkbox" wire:model.live="specific_days"
                                                value="<?php echo e($value); ?>"
                                                class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded">
                                            <span
                                                class="ml-2 text-sm font-medium text-gray-700"><?php echo e($label); ?></span>
                                        </label>
                                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
                                </div>

                                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(!empty($specific_days)): ?>
                                    <div class="mt-3 p-2 bg-white rounded border">
                                        <div class="text-xs text-blue-700">
                                            <strong>Hari terpilih:</strong>
                                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__currentLoopData = $specific_days; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $day): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoopIteration(); ?><?php endif; ?>
                                                <span
                                                    class="inline-block bg-blue-100 text-blue-800 px-2 py-1 rounded text-xs mr-1">
                                                    <?php echo e($dayOptions[$day] ?? $day); ?>

                                                </span>
                                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
                                        </div>
                                    </div>
                                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                            </div>
                        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

                        
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($schedule_type === 'time_only' || $schedule_type === 'days_and_time'): ?>
                            <div class="bg-orange-50 border border-orange-200 rounded-lg p-4">
                                <label class="block text-sm font-medium text-gray-700 mb-3">
                                    <i class="fas fa-clock mr-1"></i>Pengaturan Waktu
                                </label>

                                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-2">Jam Mulai</label>
                                        <input type="time" wire:model.live="specific_start_time"
                                            class="form-control">
                                        <p class="text-xs text-gray-500 mt-1">Waktu promosi mulai berlaku</p>
                                    </div>
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-2">Jam
                                            Berakhir</label>
                                        <input type="time" wire:model.live="specific_end_time"
                                            class="form-control">
                                        <p class="text-xs text-gray-500 mt-1">Waktu promosi berakhir</p>
                                    </div>
                                </div>

                                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($schedule_type === 'days_and_time'): ?>
                                    <div class="mt-4">
                                        <label class="flex items-center">
                                            <input type="checkbox" wire:model.live="apply_time_to_days"
                                                class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded">
                                            <span class="ml-2 text-sm text-gray-700">
                                                Terapkan waktu hanya pada hari yang dipilih
                                            </span>
                                        </label>
                                        <p class="text-xs text-gray-500 mt-1">
                                            Jika dicentang, jam berlaku hanya pada hari terpilih. Jika tidak, jam
                                            berlaku setiap hari tapi promosi hanya aktif pada hari terpilih.
                                        </p>
                                    </div>
                                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

                                
                                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($specific_start_time || $specific_end_time): ?>
                                    <div class="mt-3 p-2 bg-white rounded border">
                                        <div class="text-xs text-orange-700">
                                            <strong>Waktu aktif:</strong>
                                            <?php echo e($specific_start_time ?: '00:00'); ?> -
                                            <?php echo e($specific_end_time ?: '23:59'); ?>

                                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($schedule_type === 'time_only'): ?>
                                                (setiap hari)
                                            <?php elseif($schedule_type === 'days_and_time' && !empty($specific_days)): ?>
                                                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($apply_time_to_days): ?>
                                                    (hanya pada hari terpilih)
                                                <?php else: ?>
                                                    (jam ini setiap hari, tapi promosi hanya aktif pada hari terpilih)
                                                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                        </div>
                                    </div>
                                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                            </div>
                        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

                        
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-3">
                                <i class="fas fa-users mr-1"></i>Pengaturan Kuota
                            </label>
                            <div class="space-y-4">
                                <div>
                                    <label
                                        class="flex items-center p-3 border border-gray-200 rounded-lg hover:bg-gray-50 cursor-pointer">
                                        <input type="checkbox" wire:model.live="is_unlimited"
                                            class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded">
                                        <div class="ml-3">
                                            <div class="text-sm font-medium text-gray-700">Kuota Tidak Terbatas</div>
                                            <div class="text-xs text-gray-500">Promosi dapat digunakan tanpa batas
                                            </div>
                                        </div>
                                    </label>
                                </div>

                                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(!$is_unlimited): ?>
                                    <div class="bg-orange-50 border border-orange-200 rounded-lg p-4">
                                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                            <div>
                                                <label class="block text-sm font-medium text-gray-700 mb-2">Total
                                                    Kuota</label>
                                                <input type="number" wire:model.lazy="total_quota"
                                                    class="form-control" placeholder="Contoh: 100" min="1">
                                                <p class="text-xs text-gray-500 mt-1">Jumlah maksimal penggunaan
                                                    promosi</p>
                                            </div>

                                            <div>
                                                <label class="block text-sm font-medium text-gray-700 mb-2">Kuota per
                                                    Pelanggan</label>
                                                <input type="number" wire:model.lazy="quota_per_user"
                                                    class="form-control" placeholder="1" min="1">
                                                <p class="text-xs text-gray-500 mt-1">Maksimal penggunaan per pelanggan
                                                </p>
                                            </div>
                                        </div>

                                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($total_quota && $quota_per_user): ?>
                                            <div class="mt-3 p-2 bg-white border rounded">
                                                <div class="text-xs text-orange-700">
                                                    <strong>Estimasi:</strong> Maksimal
                                                    <?php echo e(floor($total_quota / $quota_per_user)); ?> pelanggan dapat
                                                    menggunakan promosi ini
                                                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($quota_per_user > 1): ?>
                                                        (masing-masing <?php echo e($quota_per_user); ?>x)
                                                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                                </div>
                                            </div>
                                        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                    </div>
                                <?php else: ?>
                                    <div class="bg-green-50 border border-green-200 rounded-lg p-3">
                                        <div class="flex items-center">
                                            <i class="fas fa-infinity text-green-600 mr-2"></i>
                                            <span class="text-sm text-green-800 font-medium">Kuota Unlimited</span>
                                        </div>
                                        <p class="text-xs text-green-600 mt-1">Semua pelanggan dapat menggunakan
                                            promosi tanpa batasan</p>
                                    </div>
                                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                            </div>
                        </div>

                        
                        <div
                            class="bg-gradient-to-r from-purple-50 to-blue-50 border border-purple-200 rounded-lg p-4">
                            <h5 class="font-semibold text-purple-800 mb-2 flex items-center">
                                <i class="fas fa-info-circle mr-2"></i>Ringkasan Jadwal & Kuota
                            </h5>
                            <div class="text-sm text-purple-700 space-y-1">
                                
                                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($start_date && $end_date): ?>
                                    <p>📅 <strong>Periode:</strong> <?php echo e(date('d M Y', strtotime($start_date))); ?> -
                                        <?php echo e(date('d M Y', strtotime($end_date))); ?></p>
                                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

                                
                                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($schedule_type === 'always'): ?>
                                    <p>🟢 <strong>Jadwal:</strong> Aktif 24/7 sepanjang periode</p>
                                <?php elseif($schedule_type === 'days_only'): ?>
                                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(!empty($specific_days)): ?>
                                        <p>📅 <strong>Jadwal:</strong> Aktif pada hari
                                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__currentLoopData = $specific_days; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $day): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoopIteration(); ?><?php endif; ?>
                                                <?php echo e($dayOptions[$day] ?? $day); ?><?php echo e(!$loop->last ? ', ' : ''); ?>

                                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
                                        </p>
                                    <?php else: ?>
                                        <p class="text-orange-600">⚠️ Pilih minimal satu hari untuk mengaktifkan
                                            promosi</p>
                                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                <?php elseif($schedule_type === 'time_only'): ?>
                                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($specific_start_time || $specific_end_time): ?>
                                        <p>⏰ <strong>Jadwal:</strong> Setiap hari jam
                                            <?php echo e($specific_start_time ?: '00:00'); ?> -
                                            <?php echo e($specific_end_time ?: '23:59'); ?></p>
                                    <?php else: ?>
                                        <p class="text-orange-600">⚠️ Tentukan jam mulai dan berakhir</p>
                                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                <?php elseif($schedule_type === 'days_and_time'): ?>
                                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(!empty($specific_days) && ($specific_start_time || $specific_end_time)): ?>
                                        <p>📅⏰ <strong>Jadwal:</strong>
                                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__currentLoopData = $specific_days; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $day): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoopIteration(); ?><?php endif; ?>
                                                <?php echo e($dayOptions[$day] ?? $day); ?><?php echo e(!$loop->last ? ', ' : ''); ?>

                                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
                                            jam <?php echo e($specific_start_time ?: '00:00'); ?> -
                                            <?php echo e($specific_end_time ?: '23:59'); ?>

                                        </p>
                                    <?php else: ?>
                                        <p class="text-orange-600">⚠️ Pilih hari dan tentukan jam untuk mengaktifkan
                                            promosi</p>
                                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

                                
                                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($is_unlimited): ?>
                                    <p>♾️ <strong>Kuota:</strong> Tidak terbatas</p>
                                <?php else: ?>
                                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($total_quota): ?>
                                        <p>🎫 <strong>Kuota:</strong> <?php echo e($total_quota); ?> total,
                                            <?php echo e($quota_per_user ?: 1); ?> per pelanggan</p>
                                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="space-y-6">
                
                <div class="bg-gradient-to-br from-blue-50 to-indigo-100 rounded-xl shadow-sm border p-6">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4">
                        <i class="fas fa-eye text-indigo-500 mr-2"></i>Preview Promosi
                    </h3>

                    <div class="bg-white rounded-lg p-4 shadow-sm">
                        <div class="text-center">
                            <h4 class="font-bold text-lg text-gray-900"><?php echo e($name ?: 'Nama Promosi'); ?></h4>
                            <p class="text-sm text-gray-600 mb-3"><?php echo e($code ?: 'KODE-PROMOSI'); ?></p>

                            <div class="bg-red-500 text-white rounded-lg p-3 mb-3">
                                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($type === 'discount'): ?>
                                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($discount_type === 'percentage'): ?>
                                        <div class="text-2xl font-bold"><?php echo e($discount_value); ?>% OFF</div>
                                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($max_discount): ?>
                                            <div class="text-xs">Maks. Rp
                                                <?php echo e(number_format($max_discount, 0, ',', '.')); ?></div>
                                        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                    <?php elseif($discount_type === 'fixed'): ?>
                                        <div class="text-2xl font-bold">Rp
                                            <?php echo e(number_format($discount_value, 0, ',', '.')); ?> OFF</div>
                                    <?php else: ?>
                                        <div class="text-2xl font-bold">Harga Spesial</div>
                                        <div class="text-sm">Rp <?php echo e(number_format($discount_value, 0, ',', '.')); ?>

                                        </div>
                                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                <?php elseif($type === 'buy_x_get_y'): ?>
                                    <div class="text-lg font-bold">Beli <?php echo e($buy_quantity); ?> Gratis
                                        <?php echo e($get_quantity); ?></div>
                                <?php elseif($type === 'bundle'): ?>
                                    <div class="text-lg font-bold">Paket Bundle</div>
                                    <div class="text-sm">Rp <?php echo e(number_format($bundle_price, 0, ',', '.')); ?></div>
                                <?php elseif($type === 'special'): ?>
                                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($special_type === 'cashback'): ?>
                                        <div class="text-lg font-bold">Cashback <?php echo e($cashback_percentage); ?>%</div>
                                    <?php elseif($special_type === 'free_shipping'): ?>
                                        <div class="text-lg font-bold">Gratis Ongkir</div>
                                    <?php elseif($special_type === 'loyalty_points'): ?>
                                        <div class="text-lg font-bold">Poin <?php echo e($points_multiplier); ?>x</div>
                                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                            </div>

                            

                            
                        </div>
                    </div>
                </div>

                
                <div class="bg-white rounded-xl shadow-sm border p-6">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4">
                        <i class="fas fa-file-contract text-green-500 mr-2"></i>Syarat & Ketentuan
                    </h3>

                    <div class="space-y-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">
                                Daftar Syarat & Ketentuan
                            </label>
                            <div id="terms-container" class="space-y-2">
                                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__currentLoopData = $terms_conditions; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $term): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoopIteration(); ?><?php endif; ?>
                                    <div class="flex items-center space-x-2">
                                        <input type="text" wire:model.lazy="terms_conditions.<?php echo e($index); ?>"
                                            class="form-control flex-1" placeholder="Masukkan syarat atau ketentuan">
                                        <button type="button" wire:click="removeTermCondition(<?php echo e($index); ?>)"
                                            class="text-red-500 hover:text-red-700">
                                            <i class="fas fa-times"></i>
                                        </button>
                                    </div>
                                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
                            </div>
                            <button type="button" wire:click="addTermCondition"
                                class="mt-2 text-blue-600 hover:text-blue-800 text-sm">
                                <i class="fas fa-plus mr-1"></i>Tambah Syarat & Ketentuan
                            </button>
                        </div>

                        
                    </div>
                </div>

                
                <div class="bg-white rounded-xl shadow-sm border p-6">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4">
                        <i class="fas fa-sliders-h text-gray-500 mr-2"></i>Pengaturan
                    </h3>

                    <div class="space-y-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Prioritas</label>
                            <input type="number" wire:model.lazy="priority" class="form-control" placeholder="1"
                                min="0">
                            <p class="text-xs text-gray-500 mt-1">Semakin tinggi semakin prioritas</p>
                        </div>

                        

                        

                        <div class="flex items-center">
                            <input type="checkbox" wire:model.lazy="is_active" class="form-checkbox" id="is_active">
                            <label for="is_active" class="ml-2 text-sm font-medium text-gray-700">
                                Aktif
                            </label>
                        </div>
                    </div>
                </div>

                
                

                
                
            </div>
        </div>
    </form>

    
    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(session()->has('message')): ?>
        <div class="fixed bottom-4 right-4 bg-green-500 text-white px-6 py-3 rounded-lg shadow-lg z-50">
            <?php echo e(session('message')); ?>

        </div>
    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

    
    <style>
        .form-control {
            @apply w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500;
        }

        .form-checkbox {
            @apply h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded;
        }

        .btn {
            @apply inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-offset-2;
        }

        .btn-primary {
            @apply text-white bg-blue-600 hover:bg-blue-700 focus:ring-blue-500;
        }

        .btn-outline {
            @apply text-gray-700 bg-white border-gray-300 hover:bg-gray-50 focus:ring-blue-500;
        }

        .btn-sm {
            @apply px-3 py-1 text-xs;
        }
    </style>
</div><?php /**PATH /Users/macbookair/Documents/mediction/mediction.id/resources/views/livewire/admin/promotion/create/admin-promotion-create-index.blade.php ENDPATH**/ ?>