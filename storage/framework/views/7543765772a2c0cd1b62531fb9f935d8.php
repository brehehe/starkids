<div>
    <div class="mb-4">
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-2xl font-bold text-[#1E3A8A]">Arus Kas</h1>
            </div>
        </div>
    </div>

    
    <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-6">
        <div class="bg-gradient-to-br from-blue-500 to-blue-600 rounded-xl shadow-lg p-6 text-white">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-blue-100 text-sm font-medium">Arus Kas Operasi</p>
                    <h3 class="text-2xl font-bold mt-2">Rp <?php echo e(number_format($this->operatingCashFlow, 0, ',', '.')); ?></h3>
                </div>
                <div class="bg-white/20 rounded-full p-4">
                    <i class="fas fa-chart-line text-2xl"></i>
                </div>
            </div>
        </div>

        <div class="bg-gradient-to-br from-purple-500 to-purple-600 rounded-xl shadow-lg p-6 text-white">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-purple-100 text-sm font-medium">Arus Kas Investasi</p>
                    <h3 class="text-2xl font-bold mt-2">Rp <?php echo e(number_format($this->investingCashFlow, 0, ',', '.')); ?></h3>
                </div>
                <div class="bg-white/20 rounded-full p-4">
                    <i class="fas fa-money-bill-trend-up text-2xl"></i>
                </div>
            </div>
        </div>

        <div class="bg-gradient-to-br from-orange-500 to-orange-600 rounded-xl shadow-lg p-6 text-white">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-orange-100 text-sm font-medium">Arus Kas Pendanaan</p>
                    <h3 class="text-2xl font-bold mt-2">Rp <?php echo e(number_format($this->financingCashFlow, 0, ',', '.')); ?></h3>
                </div>
                <div class="bg-white/20 rounded-full p-4">
                    <i class="fas fa-hand-holding-usd text-2xl"></i>
                </div>
            </div>
        </div>

        <div class="bg-gradient-to-br from-green-500 to-green-600 rounded-xl shadow-lg p-6 text-white">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-green-100 text-sm font-medium">Arus Kas Bersih</p>
                    <h3 class="text-2xl font-bold mt-2">Rp <?php echo e(number_format($this->netCashFlow, 0, ',', '.')); ?></h3>
                </div>
                <div class="bg-white/20 rounded-full p-4">
                    <i class="fas fa-wallet text-2xl"></i>
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
        <div class="bg-gradient-to-r from-cyan-600 to-cyan-700 text-white px-6 py-4">
            <h2 class="text-xl font-bold">LAPORAN ARUS KAS</h2>
            <p class="text-sm text-cyan-100 mt-1">Periode: <?php echo e(\Carbon\Carbon::parse($start_date)->format('d/m/Y')); ?> - <?php echo e(\Carbon\Carbon::parse($end_date)->format('d/m/Y')); ?></p>
        </div>

        <div class="p-6">
            
            <div class="mb-8">
                <div class="bg-blue-50 px-4 py-3 rounded-lg mb-4">
                    <h3 class="font-bold text-blue-900 text-lg">ARUS KAS DARI AKTIVITAS OPERASI</h3>
                </div>

                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(isset($categoryAccounts['operasi'])): ?>
                    <div class="ml-4 space-y-2">
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__currentLoopData = $categoryAccounts['operasi']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $categoryAccount): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoopIteration(); ?><?php endif; ?>
                            <div class="border-l-2 border-blue-200 pl-4">
                                <div class="flex justify-between items-center py-2">
                                    <span class="font-semibold text-gray-700"><?php echo e($categoryAccount); ?></span>
                                    <span class="font-semibold text-gray-900">Rp <?php echo e(number_format(abs($categoryAccountTotals['operasi'][$key]['total'] ?? 0), 0, ',', '.')); ?></span>
                                </div>

                                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(isset($accounts['operasi'][$key])): ?>
                                    <div class="ml-4 space-y-1">
                                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__currentLoopData = $accounts['operasi'][$key]; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key_account => $account): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoopIteration(); ?><?php endif; ?>
                                            <div class="flex justify-between items-center text-sm py-1">
                                                <span class="text-gray-600"><?php echo e($account); ?></span>
                                                <span class="text-gray-700">Rp <?php echo e(number_format(abs($accountTotals['operasi'][$key][$key_account]['total'] ?? 0), 0, ',', '.')); ?></span>
                                            </div>
                                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
                                    </div>
                                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                            </div>
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
                    </div>
                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

                <div class="border-t-2 border-blue-600 mt-4 pt-3 pl-4">
                    <div class="flex justify-between items-center">
                        <h4 class="font-bold text-blue-700 text-lg">Arus Kas Bersih dari Aktivitas Operasi</h4>
                        <span class="font-bold text-blue-700 text-xl">Rp <?php echo e(number_format($this->operatingCashFlow, 0, ',', '.')); ?></span>
                    </div>
                </div>
            </div>

            
            <div class="mb-8">
                <div class="bg-purple-50 px-4 py-3 rounded-lg mb-4">
                    <h3 class="font-bold text-purple-900 text-lg">ARUS KAS DARI AKTIVITAS INVESTASI</h3>
                </div>

                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(isset($categoryAccounts['investasi'])): ?>
                    <div class="ml-4 space-y-2">
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__currentLoopData = $categoryAccounts['investasi']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $categoryAccount): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoopIteration(); ?><?php endif; ?>
                            <div class="border-l-2 border-purple-200 pl-4">
                                <div class="flex justify-between items-center py-2">
                                    <span class="font-semibold text-gray-700"><?php echo e($categoryAccount); ?></span>
                                    <span class="font-semibold text-gray-900">Rp <?php echo e(number_format(abs($categoryAccountTotals['investasi'][$key]['total'] ?? 0), 0, ',', '.')); ?></span>
                                </div>

                                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(isset($accounts['investasi'][$key])): ?>
                                    <div class="ml-4 space-y-1">
                                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__currentLoopData = $accounts['investasi'][$key]; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key_account => $account): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoopIteration(); ?><?php endif; ?>
                                            <div class="flex justify-between items-center text-sm py-1">
                                                <span class="text-gray-600"><?php echo e($account); ?></span>
                                                <span class="text-gray-700">Rp <?php echo e(number_format(abs($accountTotals['investasi'][$key][$key_account]['total'] ?? 0), 0, ',', '.')); ?></span>
                                            </div>
                                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
                                    </div>
                                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                            </div>
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
                    </div>
                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

                <div class="border-t-2 border-purple-600 mt-4 pt-3 pl-4">
                    <div class="flex justify-between items-center">
                        <h4 class="font-bold text-purple-700 text-lg">Arus Kas Bersih dari Aktivitas Investasi</h4>
                        <span class="font-bold text-purple-700 text-xl">Rp <?php echo e(number_format($this->investingCashFlow, 0, ',', '.')); ?></span>
                    </div>
                </div>
            </div>

            
            <div class="mb-8">
                <div class="bg-orange-50 px-4 py-3 rounded-lg mb-4">
                    <h3 class="font-bold text-orange-900 text-lg">ARUS KAS DARI AKTIVITAS PENDANAAN</h3>
                </div>

                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(isset($categoryAccounts['pendanaan'])): ?>
                    <div class="ml-4 space-y-2">
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__currentLoopData = $categoryAccounts['pendanaan']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $categoryAccount): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoopIteration(); ?><?php endif; ?>
                            <div class="border-l-2 border-orange-200 pl-4">
                                <div class="flex justify-between items-center py-2">
                                    <span class="font-semibold text-gray-700"><?php echo e($categoryAccount); ?></span>
                                    <span class="font-semibold text-gray-900">Rp <?php echo e(number_format(abs($categoryAccountTotals['pendanaan'][$key]['total'] ?? 0), 0, ',', '.')); ?></span>
                                </div>

                                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(isset($accounts['pendanaan'][$key])): ?>
                                    <div class="ml-4 space-y-1">
                                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__currentLoopData = $accounts['pendanaan'][$key]; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key_account => $account): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoopIteration(); ?><?php endif; ?>
                                            <div class="flex justify-between items-center text-sm py-1">
                                                <span class="text-gray-600"><?php echo e($account); ?></span>
                                                <span class="text-gray-700">Rp <?php echo e(number_format(abs($accountTotals['pendanaan'][$key][$key_account]['total'] ?? 0), 0, ',', '.')); ?></span>
                                            </div>
                                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
                                    </div>
                                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                            </div>
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
                    </div>
                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

                <div class="border-t-2 border-orange-600 mt-4 pt-3 pl-4">
                    <div class="flex justify-between items-center">
                        <h4 class="font-bold text-orange-700 text-lg">Arus Kas Bersih dari Aktivitas Pendanaan</h4>
                        <span class="font-bold text-orange-700 text-xl">Rp <?php echo e(number_format($this->financingCashFlow, 0, ',', '.')); ?></span>
                    </div>
                </div>
            </div>

            
            <div class="border-t-4 border-green-900 pt-6">
                <div class="bg-gradient-to-r from-green-50 to-green-100 px-6 py-4 rounded-lg">
                    <div class="flex justify-between items-center">
                        <div>
                            <h3 class="font-bold text-green-900 text-2xl">KENAIKAN (PENURUNAN) BERSIH KAS</h3>
                            <p class="text-sm text-green-700 mt-1">Total Arus Kas Periode Berjalan</p>
                        </div>
                        <div class="text-right">
                            <span class="font-bold text-green-900 text-3xl">
                                Rp <?php echo e(number_format($this->netCashFlow, 0, ',', '.')); ?>

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
                <p class="text-sm text-gray-600 mb-2">Aktivitas Operasi</p>
                <p class="font-bold text-2xl text-blue-600">Rp <?php echo e(number_format($this->operatingCashFlow, 0, ',', '.')); ?></p>
                <div class="mt-2 flex items-center justify-center gap-2">
                    <i class="fas fa-chart-line text-blue-500"></i>
                    <span class="text-xs text-blue-600"><?php echo e($this->netCashFlow > 0 ? number_format(($this->operatingCashFlow / $this->netCashFlow) * 100, 1) : 0); ?>%</span>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-xl shadow-lg border border-gray-100 p-6">
            <div class="text-center">
                <p class="text-sm text-gray-600 mb-2">Aktivitas Investasi</p>
                <p class="font-bold text-2xl text-purple-600">Rp <?php echo e(number_format($this->investingCashFlow, 0, ',', '.')); ?></p>
                <div class="mt-2 flex items-center justify-center gap-2">
                    <i class="fas fa-money-bill-trend-up text-purple-500"></i>
                    <span class="text-xs text-purple-600"><?php echo e($this->netCashFlow > 0 ? number_format(($this->investingCashFlow / $this->netCashFlow) * 100, 1) : 0); ?>%</span>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-xl shadow-lg border border-gray-100 p-6">
            <div class="text-center">
                <p class="text-sm text-gray-600 mb-2">Aktivitas Pendanaan</p>
                <p class="font-bold text-2xl text-orange-600">Rp <?php echo e(number_format($this->financingCashFlow, 0, ',', '.')); ?></p>
                <div class="mt-2 flex items-center justify-center gap-2">
                    <i class="fas fa-hand-holding-usd text-orange-500"></i>
                    <span class="text-xs text-orange-600"><?php echo e($this->netCashFlow > 0 ? number_format(($this->financingCashFlow / $this->netCashFlow) * 100, 1) : 0); ?>%</span>
                </div>
            </div>
        </div>
    </div>
</div><?php /**PATH /Users/macbookair/Documents/mediction/mediction.id/resources/views/livewire/admin/finance/cash-flow/admin-finance-cash-flow-index.blade.php ENDPATH**/ ?>