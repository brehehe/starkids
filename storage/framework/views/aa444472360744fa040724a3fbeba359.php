<div>
    
    <div class="min-h-screen">
        <!-- Header -->
        <nav class="bg-white shadow-lg border-b border-gray-200">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex justify-between h-16">
                    <div class="flex items-center">
                        <div class="flex-shrink-0">
                            <h1 class="text-2xl font-bold text-blue-600 ">🏥 Antrian Klinik</h1>
                        </div>
                    </div>
                    <div class="flex items-center space-x-2">
                        <a href="<?php echo e(route('queue.register')); ?>"
                            class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg font-medium transition-colors duration-200 flex items-center space-x-2">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                            </svg>
                            <span>Daftar Antrian</span>
                        </a>
                        <a href="#"
                            class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-lg font-medium transition-colors duration-200">
                            Dashboard Admin
                        </a>
                        <button id="theme-toggle" type="button"
                            class="text-gray-500  hover:bg-gray-100 dark:hover:bg-gray-700 focus:outline-none focus:ring-4 focus:ring-gray-200 dark:focus:ring-gray-700 rounded-lg text-sm p-2.5">
                            <svg id="theme-toggle-dark-icon" class="hidden w-5 h-5" fill="currentColor"
                                viewBox="0 0 20 20">
                                <path d="M17.293 13.293A8 8 0 016.707 2.707a8.001 8.001 0 1010.586 10.586z"></path>
                            </svg>
                            <svg id="theme-toggle-light-icon" class="hidden w-5 h-5" fill="currentColor"
                                viewBox="0 0 20 20">
                                <path
                                    d="M10 2a1 1 0 011 1v1a1 1 0 11-2 0V3a1 1 0 011-1zm4 8a4 4 0 11-8 0 4 4 0 018 0zm-.464 4.95l.707.707a1 1 0 001.414-1.414l-.707-.707a1 1 0 00-1.414 1.414zm2.12-10.607a1 1 0 010 1.414l-.706.707a1 1 0 11-1.414-1.414l.707-.707a1 1 0 011.414 0zM17 11a1 1 0 100-2h-1a1 1 0 100 2h1zm-7 4a1 1 0 011 1v1a1 1 0 11-2 0v-1a1 1 0 011-1zM5.05 5.05A1 1 0 016.465 3.636l.707.707a1 1 0 01-1.414 1.414l-.707-.707a1 1 0 010-1.414zM5 11a1 1 0 100-2H4a1 1 0 100 2h1zM8 16a1 1 0 011 1v1a1 1 0 11-2 0v-1a1 1 0 011-1z">
                                </path>
                            </svg>
                        </button>
                    </div>
                </div>
            </div>
        </nav>

        <!-- Main Content -->
        <main class="max-w-7xl mx-auto py-6 sm:px-6 lg:px-8">
            <!-- Branch Selection -->
            <div class="mb-8">
                <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg border border-gray-200">
                    <div class="p-6">
                        <h2 class="text-2xl font-bold text-gray-900 mb-6">Pilih Cabang Klinik</h2>
                        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__currentLoopData = $branches; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $branch): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoopIteration(); ?><?php endif; ?>
                                <div class="bg-white border border-gray-200 rounded-lg shadow-md hover:shadow-lg transition-shadow duration-300 cursor-pointer <?php echo e($selectedBranch == $branch['id'] ? 'ring-2 ring-blue-500' : ''); ?>"
                                    wire:click="selectBranch('<?php echo e($branch['id']); ?>')">
                                    <div class="relative">
                                        <img src="<?php echo e(asset('asset/img/no-image.png')); ?>" alt="<?php echo e($branch['name']); ?>"
                                            class="w-full h-48 object-cover rounded-t-lg"
                                            onerror="this.src='<?php echo e(asset('img/default-clinic.jpg')); ?>'">
                                    </div>
                                    <div class="p-4">
                                        <h3 class="text-lg font-semibold text-gray-900 mb-2"><?php echo e($branch['name']); ?></h3>
                                        <p class="text-sm text-gray-600 mb-2"><?php echo e($branch['city']); ?></p>
                                        <p class="text-sm text-gray-500 mb-3 flex items-center">
                                            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z">
                                                </path>
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                            </svg>
                                            <?php echo e($branch['address']); ?>

                                        </p>
                                        <div class="flex items-center justify-between text-sm text-gray-500 mb-3">
                                            <span class="flex items-center">
                                                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor"
                                                    viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        stroke-width="2"
                                                        d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z">
                                                    </path>
                                                </svg>
                                                <?php echo e($branch['phone']); ?>

                                            </span>
                                            
                                        </div>
                                        <div class="flex flex-wrap gap-1 mb-3">
                                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__currentLoopData = $branch['specialties']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $specialty): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoopIteration(); ?><?php endif; ?>
                                                <span
                                                    class="bg-blue-100 text-blue-800 text-xs font-medium px-2 py-1 rounded-full">
                                                    <?php echo e($specialty); ?>

                                                </span>
                                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
                                        </div>
                                        
                                        <div class="grid grid-cols-3 gap-2 text-center">
                                            <div class="bg-gray-50 rounded p-2">
                                                <div class="text-lg font-bold text-blue-600">
                                                    <?php echo e($branch['current_queue']); ?></div>
                                                <div class="text-xs text-gray-500">Sedang Dilayani</div>
                                            </div>
                                            <div class="bg-gray-50 rounded p-2">
                                                <div class="text-lg font-bold text-yellow-600">
                                                    <?php echo e($branch['waiting_queue']); ?></div>
                                                <div class="text-xs text-gray-500">Menunggu</div>
                                            </div>
                                            <div class="bg-gray-50 rounded p-2">
                                                <div class="text-lg font-bold text-green-600">
                                                    <?php echo e($branch['total_queue']); ?></div>
                                                <div class="text-xs text-gray-500">Total Hari Ini</div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>

            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($selectedBranch && $selectedBranchData): ?>
                <!-- Poli Selection for Selected Branch -->
                <div class="mb-8">
                    <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg border border-gray-200">
                        <div class="p-6">
                            <h2 class="text-2xl font-bold text-gray-900 mb-2">Poli di <?php echo e($selectedBranchData['name']); ?>

                            </h2>
                            <p class="text-gray-600 mb-6">Pilih poli untuk melihat informasi antrian</p>
                            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__currentLoopData = $polies; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $poli): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoopIteration(); ?><?php endif; ?>
                                    <div class="bg-white border border-gray-200 rounded-lg p-4 hover:shadow-md transition-shadow duration-300 cursor-pointer <?php echo e($selectedPoly == $poli['id'] ? 'ring-2 ring-blue-500' : ''); ?>"
                                        wire:click="selectPoly(<?php echo e($poli['id']); ?>)">
                                        <div class="flex items-center mb-3">
                                            <div class="bg-blue-100 p-2 rounded-lg mr-3">
                                                <i class="<?php echo e($poli['icon']); ?> text-blue-600 text-xl"></i>
                                            </div>
                                            <div>
                                                <h3 class="font-semibold text-gray-900"><?php echo e($poli['name']); ?></h3>
                                                <p class="text-sm text-gray-500"><?php echo e($poli['description']); ?></p>
                                            </div>
                                        </div>
                                        <div class="text-sm text-gray-600 mb-3">
                                            <strong>Dokter:</strong> <?php echo e($poli['doctor']); ?>

                                        </div>
                                        <div class="grid grid-cols-3 gap-2 text-center">
                                            <div class="bg-blue-50 rounded p-2">
                                                <div class="text-sm font-bold text-blue-600">
                                                    <?php echo e($poli['current_queue']); ?></div>
                                                <div class="text-xs text-gray-500">Sekarang</div>
                                            </div>
                                            <div class="bg-yellow-50 rounded p-2">
                                                <div class="text-sm font-bold text-yellow-600">
                                                    <?php echo e($poli['waiting_count']); ?></div>
                                                <div class="text-xs text-gray-500">Menunggu</div>
                                            </div>
                                            <div class="bg-green-50 rounded p-2">
                                                <div class="text-sm font-bold text-green-600">
                                                    <?php echo e($poli['served_today']); ?></div>
                                                <div class="text-xs text-gray-500">Selesai</div>
                                            </div>
                                        </div>
                                    </div>
                                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($selectedPoly): ?>
                <!-- Current Queue Display for Selected Poli -->
                <div class="mb-8">
                    <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg border border-gray-200">
                        <div class="p-6 text-center">
                            <?php
                                $selectedPoliData = collect($polies)->firstWhere('id', $selectedPoly);
                            ?>
                            <h2 class="text-3xl font-bold text-gray-900 mb-4">Antrian
                                <?php echo e($selectedPoliData['name'] ?? 'Poli'); ?></h2>
                            <div class="bg-blue-50 border border-blue-200 rounded-lg p-8 mb-4">
                                <div class="text-6xl font-bold text-blue-600 mb-2">
                                    <?php echo e($selectedPoliData['current_queue'] ?? '000'); ?></div>
                                <div class="text-xl text-gray-700"><?php echo e($selectedPoliData['doctor'] ?? 'Dokter'); ?></div>
                                <div class="text-sm text-gray-500 mt-2">Sedang Dilayani</div>
                            </div>

                            <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mt-6">
                                <div class="bg-yellow-50 border border-yellow-200 rounded-lg p-4">
                                    <div class="text-2xl font-bold text-yellow-600">
                                        <?php echo e($selectedPoliData['waiting_count'] ?? 0); ?></div>
                                    <div class="text-sm text-yellow-700">Antrian Menunggu</div>
                                </div>
                                <div class="bg-green-50 border border-green-200 rounded-lg p-4">
                                    <div class="text-2xl font-bold text-green-600">
                                        <?php echo e($selectedPoliData['served_today'] ?? 0); ?></div>
                                    <div class="text-sm text-green-700">Selesai Hari Ini</div>
                                </div>
                                <div class="bg-blue-50 border border-blue-200 rounded-lg p-4">
                                    <div class="text-2xl font-bold text-blue-600">
                                        <?php echo e(($selectedPoliData['served_today'] ?? 0) + ($selectedPoliData['waiting_count'] ?? 0) + 1); ?>

                                    </div>
                                    <div class="text-sm text-blue-700">Total Hari Ini</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            <?php else: ?>
                <!-- Default Current Queue Display -->
                
            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

            <!-- Queue List -->
            
        </main>
    </div>

    <!-- JavaScript for Enhanced Interactions -->
    
</div><?php /**PATH /Users/macbookair/Documents/mediction/mediction.id/resources/views/livewire/queue/queue-index.blade.php ENDPATH**/ ?>