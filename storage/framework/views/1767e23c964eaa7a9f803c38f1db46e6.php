<div>
    <div class="mb-4">
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-2xl font-bold text-[#1E3A8A]">Laba Rugi</h1>
            </div>
        </div>
    </div>

    
    <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-6">
        <div class="bg-gradient-to-br from-green-500 to-green-600 rounded-xl shadow-lg p-6 text-white">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-green-100 text-sm font-medium">Total Pendapatan</p>
                    <h3 class="text-2xl font-bold mt-2">Rp <?php echo e(number_format($this->totalRevenue, 0, ',', '.')); ?></h3>
                </div>
                <div class="bg-white/20 rounded-full p-4">
                    <i class="fas fa-arrow-up text-2xl"></i>
                </div>
            </div>
        </div>

        <div class="bg-gradient-to-br from-red-500 to-red-600 rounded-xl shadow-lg p-6 text-white">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-red-100 text-sm font-medium">Total Beban</p>
                    <h3 class="text-2xl font-bold mt-2">Rp <?php echo e(number_format($this->totalExpenses, 0, ',', '.')); ?></h3>
                </div>
                <div class="bg-white/20 rounded-full p-4">
                    <i class="fas fa-arrow-down text-2xl"></i>
                </div>
            </div>
        </div>

        <div class="bg-gradient-to-br from-<?php echo e($this->netProfit >= 0 ? 'blue' : 'orange'); ?>-500 to-<?php echo e($this->netProfit >= 0 ? 'blue' : 'orange'); ?>-600 rounded-xl shadow-lg p-6 text-white">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-white/90 text-sm font-medium"><?php echo e($this->netProfit >= 0 ? 'Laba Bersih' : 'Rugi Bersih'); ?></p>
                    <h3 class="text-2xl font-bold mt-2">Rp <?php echo e(number_format(abs($this->netProfit), 0, ',', '.')); ?></h3>
                </div>
                <div class="bg-white/20 rounded-full p-4">
                    <i class="fas fa-<?php echo e($this->netProfit >= 0 ? 'chart-line' : 'chart-line-down'); ?> text-2xl"></i>
                </div>
            </div>
        </div>

        <div class="bg-gradient-to-br from-purple-500 to-purple-600 rounded-xl shadow-lg p-6 text-white">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-purple-100 text-sm font-medium">Margin Laba</p>
                    <h3 class="text-2xl font-bold mt-2"><?php echo e(number_format($this->profitMargin, 2, ',', '.')); ?>%</h3>
                </div>
                <div class="bg-white/20 rounded-full p-4">
                    <i class="fas fa-percentage text-2xl"></i>
                </div>
            </div>
        </div>
    </div>

    
    <div class="bg-white/80 backdrop-blur-sm rounded-xl shadow-lg border border-gray-100 p-4 mb-4">
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Dari Tanggal</label>
                <input type="date" wire:model.live="start_date" class="form-control" />
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Sampai Tanggal</label>
                <input type="date" wire:model.live="end_date" class="form-control" />
            </div>
            <div class="flex items-end">
                <button wire:click="resetFilters" class="btn btn-secondary w-full">
                    <i class="fas fa-redo mr-2"></i> Reset Filter
                </button>
            </div>
        </div>
    </div>

    
    <div class="bg-white rounded-xl shadow-lg border border-gray-100 overflow-hidden mb-6">
        <div class="bg-gradient-to-r from-green-600 to-green-700 text-white px-6 py-4">
            <h2 class="text-xl font-bold">LAPORAN LABA RUGI</h2>
            <p class="text-sm text-green-100 mt-1">Periode: <?php echo e(\Carbon\Carbon::parse($start_date)->format('d/m/Y')); ?> - <?php echo e(\Carbon\Carbon::parse($end_date)->format('d/m/Y')); ?></p>
        </div>

        <div class="p-6">
            
            <div class="mb-8">
                <div class="bg-green-50 px-4 py-3 rounded-lg mb-4">
                    <h3 class="font-bold text-green-900 text-lg">PENDAPATAN</h3>
                </div>

                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__currentLoopData = $detailCategoryAccounts; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $detailCategoryAccount): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoopIteration(); ?><?php endif; ?>
                    <?php
                        $categoryName = strtolower($detailCategoryAccount);
                    ?>

                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(strpos($categoryName, 'pendapatan') !== false): ?>
                        <div class="mb-4 ml-4">
                            <div class="flex justify-between items-center py-2">
                                <h4 class="font-bold text-gray-800"><?php echo e($detailCategoryAccount); ?></h4>
                                <span class="font-bold text-gray-900">Rp <?php echo e(number_format(abs($detailCategoryTotals[$index]['balance'] ?? 0), 0, ',', '.')); ?></span>
                            </div>

                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(isset($categoryAccounts[$index])): ?>
                                <div class="ml-4 space-y-2">
                                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__currentLoopData = $categoryAccounts[$index]; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $categoryAccount): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoopIteration(); ?><?php endif; ?>
                                        <div class="border-l-2 border-green-200 pl-4">
                                            <div class="flex justify-between items-center py-2">
                                                <span class="font-semibold text-gray-700"><?php echo e($categoryAccount); ?></span>
                                                <span class="font-semibold text-gray-900">Rp <?php echo e(number_format(abs($categoryAccountTotals[$index][$key]['balance'] ?? 0), 0, ',', '.')); ?></span>
                                            </div>

                                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(isset($accounts[$index][$key])): ?>
                                                <div class="ml-4 space-y-1">
                                                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__currentLoopData = $accounts[$index][$key]; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key_account => $account): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoopIteration(); ?><?php endif; ?>
                                                        <div class="flex justify-between items-center text-sm py-1">
                                                            <span class="text-gray-600"><?php echo e($account); ?></span>
                                                            <span class="text-gray-700">Rp <?php echo e(number_format(abs($accountTotals[$index][$key][$key_account]['balance'] ?? 0), 0, ',', '.')); ?></span>
                                                        </div>
                                                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
                                                </div>
                                            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                        </div>
                                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
                                </div>
                            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                        </div>
                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>

                
                <div class="border-t-2 border-green-600 mt-4 pt-3 pl-4">
                    <div class="flex justify-between items-center">
                        <h4 class="font-bold text-green-700 text-lg">TOTAL PENDAPATAN</h4>
                        <span class="font-bold text-green-700 text-xl">Rp <?php echo e(number_format(abs($this->totalRevenue), 0, ',', '.')); ?></span>
                    </div>
                </div>
            </div>

            
            <div class="mb-8">
                <div class="bg-red-50 px-4 py-3 rounded-lg mb-4">
                    <h3 class="font-bold text-red-900 text-lg">BEBAN</h3>
                </div>

                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__currentLoopData = $detailCategoryAccounts; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $detailCategoryAccount): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoopIteration(); ?><?php endif; ?>
                    <?php
                        $categoryName = strtolower($detailCategoryAccount);
                    ?>

                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(strpos($categoryName, 'beban') !== false || strpos($categoryName, 'biaya') !== false): ?>
                        <div class="mb-4 ml-4">
                            <div class="flex justify-between items-center py-2">
                                <h4 class="font-bold text-gray-800"><?php echo e($detailCategoryAccount); ?></h4>
                                <span class="font-bold text-gray-900">Rp <?php echo e(number_format(abs($detailCategoryTotals[$index]['balance'] ?? 0), 0, ',', '.')); ?></span>
                            </div>

                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(isset($categoryAccounts[$index])): ?>
                                <div class="ml-4 space-y-2">
                                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__currentLoopData = $categoryAccounts[$index]; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $categoryAccount): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoopIteration(); ?><?php endif; ?>
                                        <div class="border-l-2 border-red-200 pl-4">
                                            <div class="flex justify-between items-center py-2">
                                                <span class="font-semibold text-gray-700"><?php echo e($categoryAccount); ?></span>
                                                <span class="font-semibold text-gray-900">Rp <?php echo e(number_format(abs($categoryAccountTotals[$index][$key]['balance'] ?? 0), 0, ',', '.')); ?></span>
                                            </div>

                                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(isset($accounts[$index][$key])): ?>
                                                <div class="ml-4 space-y-1">
                                                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__currentLoopData = $accounts[$index][$key]; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key_account => $account): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoopIteration(); ?><?php endif; ?>
                                                        <div class="flex justify-between items-center text-sm py-1">
                                                            <span class="text-gray-600"><?php echo e($account); ?></span>
                                                            <span class="text-gray-700">Rp <?php echo e(number_format(abs($accountTotals[$index][$key][$key_account]['balance'] ?? 0), 0, ',', '.')); ?></span>
                                                        </div>
                                                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
                                                </div>
                                            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                        </div>
                                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
                                </div>
                            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                        </div>
                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>

                
                <div class="border-t-2 border-red-600 mt-4 pt-3 pl-4">
                    <div class="flex justify-between items-center">
                        <h4 class="font-bold text-red-700 text-lg">TOTAL BEBAN</h4>
                        <span class="font-bold text-red-700 text-xl">Rp <?php echo e(number_format(abs($this->totalExpenses), 0, ',', '.')); ?></span>
                    </div>
                </div>
            </div>

            
            <div class="border-t-4 border-<?php echo e($this->netProfit >= 0 ? 'green' : 'red'); ?>-900 pt-6">
                <div class="bg-gradient-to-r from-<?php echo e($this->netProfit >= 0 ? 'green' : 'red'); ?>-50 to-<?php echo e($this->netProfit >= 0 ? 'green' : 'red'); ?>-100 px-6 py-4 rounded-lg">
                    <div class="flex justify-between items-center">
                        <div>
                            <h3 class="font-bold text-<?php echo e($this->netProfit >= 0 ? 'green' : 'red'); ?>-900 text-2xl">
                                <?php echo e($this->netProfit >= 0 ? 'LABA BERSIH' : 'RUGI BERSIH'); ?>

                            </h3>
                            <p class="text-sm text-<?php echo e($this->netProfit >= 0 ? 'green' : 'red'); ?>-700 mt-1">
                                Margin: <?php echo e(number_format(abs($this->profitMargin), 2, ',', '.')); ?>%
                            </p>
                        </div>
                        <div class="text-right">
                            <span class="font-bold text-<?php echo e($this->netProfit >= 0 ? 'green' : 'red'); ?>-900 text-3xl">
                                Rp <?php echo e(number_format(abs($this->netProfit), 0, ',', '.')); ?>

                            </span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    
    <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-6">
        <div class="bg-white rounded-xl shadow-lg border border-gray-100 p-6">
            <div class="text-center">
                <p class="text-sm text-gray-600 mb-2">Total Pendapatan</p>
                <p class="font-bold text-2xl text-green-600">Rp <?php echo e(number_format(abs($this->totalRevenue), 0, ',', '.')); ?></p>
                <div class="mt-2 flex items-center justify-center gap-2">
                    <i class="fas fa-arrow-up text-green-500"></i>
                    <span class="text-xs text-green-600">100%</span>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-xl shadow-lg border border-gray-100 p-6">
            <div class="text-center">
                <p class="text-sm text-gray-600 mb-2">Total Beban</p>
                <p class="font-bold text-2xl text-red-600">Rp <?php echo e(number_format(abs($this->totalExpenses), 0, ',', '.')); ?></p>
                <div class="mt-2 flex items-center justify-center gap-2">
                    <i class="fas fa-arrow-down text-red-500"></i>
                    <span class="text-xs text-red-600"><?php echo e($this->totalRevenue > 0 ? number_format((abs($this->totalExpenses) / abs($this->totalRevenue)) * 100, 1) : 0); ?>%</span>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-xl shadow-lg border border-gray-100 p-6">
            <div class="text-center">
                <p class="text-sm text-gray-600 mb-2"><?php echo e($this->netProfit >= 0 ? 'Laba' : 'Rugi'); ?> Bersih</p>
                <p class="font-bold text-2xl text-<?php echo e($this->netProfit >= 0 ? 'green' : 'red'); ?>-600">
                    Rp <?php echo e(number_format(abs($this->netProfit), 0, ',', '.')); ?>

                </p>
                <div class="mt-2 flex items-center justify-center gap-2">
                    <i class="fas fa-<?php echo e($this->netProfit >= 0 ? 'check-circle' : 'exclamation-triangle'); ?> text-<?php echo e($this->netProfit >= 0 ? 'green' : 'red'); ?>-500"></i>
                    <span class="text-xs text-<?php echo e($this->netProfit >= 0 ? 'green' : 'red'); ?>-600">Margin: <?php echo e(number_format(abs($this->profitMargin), 2)); ?>%</span>
                </div>
            </div>
        </div>
    </div>
</div><?php /**PATH /Users/macbookair/Documents/mediction/mediction.id/resources/views/livewire/admin/finance/profit-loss/admin-finance-profit-loss-index.blade.php ENDPATH**/ ?>