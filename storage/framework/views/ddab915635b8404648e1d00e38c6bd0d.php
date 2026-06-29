<div>
    
    <div class="min-h-full flex flex-col justify-center py-12 sm:px-6 lg:px-8">
        <div class="sm:mx-auto sm:w-full sm:max-w-md">
            <div class="text-center">
                <h1 class="text-3xl font-bold text-gray-900-2">🏥 Clinic Health</h1>
                <h2 class="text-xl text-gray-600 mt-2">Daftar Antrian Online</h2>
            </div>
        </div>

        <div class="mt-8 sm:mx-auto sm:w-full sm:max-w-2xl">
            <div class="bg-white py-8 px-6 shadow-2xl sm:rounded-2xl sm:px-10 border border-gray-200 backdrop-blur-sm">
                <!-- Enhanced Step Indicator -->
                <div class="mb-10">
                    <!-- Progress Bar Background -->
                    <div class="relative mb-8">
                        <div
                            class="absolute top-1/2 left-0 w-full h-2 bg-gray-200 rounded-full transform -translate-y-1/2">
                        </div>
                        <div id="overall-progress"
                            class="absolute top-1/2 left-0 h-2 bg-blue-600 rounded-full transform -translate-y-1/2 transition-all duration-700 ease-out shadow-lg"
                            style="width: <?php echo e($progress_bar); ?>%"></div>
                    </div>

                    <!-- Step Indicators -->
                    <div class="flex items-center justify-between relative px-1 sm:px-2">
                        <div class="flex flex-col items-center group cursor-pointer min-w-0 flex-1">
                            <div id="step1-indicator"
                                class="flex items-center justify-center w-10 h-10 sm:w-12 sm:h-12 bg-gradient-to-br from-blue-500 to-blue-700 text-white rounded-full text-sm font-bold shadow-xl transform transition-all duration-300 group-hover:scale-110 group-hover:shadow-2xl border-2 sm:border-4 border-white">
                                
                                <svg  xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 sm:w-5 sm:h-5" viewBox="0 0 24 24"  fill="none"  stroke="currentColor"  stroke-width="2"  stroke-linecap="round"  stroke-linejoin="round"  class="icon icon-tabler icons-tabler-outline icon-tabler-sitemap">
                                    <path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M3 15m0 2a2 2 0 0 1 2 -2h2a2 2 0 0 1 2 2v2a2 2 0 0 1 -2 2h-2a2 2 0 0 1 -2 -2z" /><path d="M15 15m0 2a2 2 0 0 1 2 -2h2a2 2 0 0 1 2 2v2a2 2 0 0 1 -2 2h-2a2 2 0 0 1 -2 -2z" /><path d="M9 3m0 2a2 2 0 0 1 2 -2h2a2 2 0 0 1 2 2v2a2 2 0 0 1 -2 2h-2a2 2 0 0 1 -2 -2z" /><path d="M6 15v-1a2 2 0 0 1 2 -2h8a2 2 0 0 1 2 2v1" /><path d="M12 9l0 3" />
                                </svg>
                            </div>
                            <span id="step1-text"
                                class="mt-2 sm:mt-3 text-xs sm:text-sm font-bold text-blue-600 text-center leading-tight px-1">Pilih
                                Cabang</span>
                        </div>

                        <div class="flex flex-col items-center group cursor-pointer min-w-0 flex-1">
                            <div id="step1-indicator"
                                class="flex items-center justify-center w-10 h-10 sm:w-12 sm:h-12 <?php echo e($step >= 2 ? 'bg-gradient-to-br from-blue-500 to-blue-700 text-white' : 'bg-gray-300 text-gray-500'); ?> rounded-full text-sm font-bold shadow-xl transform transition-all duration-300 group-hover:scale-110 group-hover:shadow-2xl border-2 sm:border-4 border-white">
                                <svg class="w-4 h-4 sm:w-5 sm:h-5" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4">
                                    </path>
                                </svg>
                            </div>
                            <span id="step1-text"
                                class="mt-2 sm:mt-3 text-xs sm:text-sm font-bold <?php echo e($step >= 2 ? 'text-blue-600' : 'text-gray-500'); ?> text-center leading-tight px-1">Pilih
                                Poli</span>
                        </div>

                        <div class="flex flex-col items-center group cursor-pointer min-w-0 flex-1">
                            <div id="step2-indicator"
                                class="flex items-center justify-center w-10 h-10 sm:w-12 sm:h-12 <?php echo e($step >= 3 ? 'bg-gradient-to-br from-blue-500 to-blue-700 text-white' : 'bg-gray-300 text-gray-500'); ?> rounded-full text-sm font-bold shadow-lg transform transition-all duration-300 group-hover:scale-110 group-hover:shadow-xl border-2 sm:border-4 border-white">
                                <svg class="w-4 h-4 sm:w-5 sm:h-5" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                </svg>
                            </div>
                            <span id="step2-text"
                                class="mt-2 sm:mt-3 text-xs sm:text-sm font-semibold <?php echo e($step >= 3 ? 'text-blue-600' : 'text-gray-500'); ?> text-center leading-tight px-1">Pilih
                                Dokter</span>
                        </div>

                        <div class="flex flex-col items-center group cursor-pointer min-w-0 flex-1">
                            <div id="step3-indicator"
                                class="flex items-center justify-center w-10 h-10 sm:w-12 sm:h-12 <?php echo e($step >= 4 ? 'bg-gradient-to-br from-blue-500 to-blue-700 text-white' : 'bg-gray-300 text-gray-500'); ?> rounded-full text-sm font-bold shadow-lg transform transition-all duration-300 group-hover:scale-110 group-hover:shadow-xl border-2 sm:border-4 border-white">
                                <svg class="w-4 h-4 sm:w-5 sm:h-5" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z">
                                    </path>
                                </svg>
                            </div>
                            <span id="step3-text"
                                class="mt-2 sm:mt-3 text-xs sm:text-sm font-semibold <?php echo e($step >= 4 ? 'text-blue-600' : 'text-gray-500'); ?> text-center leading-tight px-1">Jadwal</span>
                        </div>

                        <div class="flex flex-col items-center group cursor-pointer min-w-0 flex-1">
                            <div id="step4-indicator"
                                class="flex items-center justify-center w-10 h-10 sm:w-12 sm:h-12 <?php echo e($step >= 5 ? 'bg-gradient-to-br from-blue-500 to-blue-700 text-white' : 'bg-gray-300 text-gray-500'); ?> rounded-full text-sm font-bold shadow-lg transform transition-all duration-300 group-hover:scale-110 group-hover:shadow-xl border-2 sm:border-4 border-white">
                                <svg class="w-4 h-4 sm:w-5 sm:h-5" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z">
                                    </path>
                                </svg>
                            </div>
                            <span id="step4-text"
                                class="mt-2 sm:mt-3 text-xs sm:text-sm font-semibold <?php echo e($step >= 5 ? 'text-blue-600' : 'text-gray-500'); ?> text-center leading-tight px-1">Data
                                Diri</span>
                        </div>
                    </div>
                </div>

                <form id="registration-form">
                    <?php echo csrf_field(); ?>
                    <input type="hidden" name="doctor_id" id="selected_doctor_id">
                    <input type="hidden" name="visit_time" id="selected_visit_time">

                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($step === 1): ?>
                        <!-- Step 1: Pilih Cabang -->
                        <div id="step2" class="step animate-fade-in">
                            <div class="text-center mb-6">
                                <h3 class="text-2xl font-bold text-gray-900-2">Pilih Cabang Klinik</h3>
                                <p class="text-gray-600">Silakan pilih cabang klinik yang dituju</p>
                            </div>
                            <div class="grid grid-cols-1 gap-4">
                                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__currentLoopData = $company_items; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $company_item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoopIteration(); ?><?php endif; ?>
                                    <label class="company-option cursor-pointer group"
                                        <?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::$currentLoop['key'] = ''; ?>wire:key='company-<?php echo e($company_item->id); ?>'>
                                        <input type="radio" wire:model.live="company"
                                            value="<?php echo e($company_item?->id); ?>" class="sr-only">
                                        <div
                                            class="flex company_items-center p-5 border-2 rounded-xl transition-all duration-300 group-hover:scale-[1.02] group-hover:bg-blue-50
                                            <?php echo e($company === $company_item?->id ? 'border-blue-500 bg-blue-50' : 'border-gray-200'); ?>">
                                            <div class="text-3xl mr-4 transition-transform duration-300">
                                                <div
                                                    class="bg-blue-500 text-white w-8 h-8 rounded-full font-semibold border border-blue-700 text-lg items-center flex justify-center">
                                                    <?php echo e($key + 1); ?>

                                                </div>
                                            </div>
                                            <div class="flex items-center">
                                                <div class="font-semibold text-gray-900-lg"><?php echo e($company_item?->name); ?>

                                                </div>
                                                
                                            </div>
                                        </div>
                                    </label>
                                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
                            </div>
                            <button type="button" id="next-step1" wire:click="nextStep()"
                                class="mt-8 w-full bg-gradient-to-r from-blue-600 to-blue-700 hover:from-blue-700 hover:to-blue-800 text-white py-3 px-6 rounded-xl font-semibold transition-all duration-300 disabled:opacity-50 disabled:cursor-not-allowed disabled:transform-none transform hover:scale-[1.02] shadow-lg hover:shadow-xl">
                                <span class="flex items-center justify-center">
                                    Lanjutkan
                                    <svg class="w-5 h-5 ml-2" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M13 7l5 5m0 0l-5 5m5-5H6"></path>
                                    </svg>
                                </span>
                            </button>
                        </div>
                    <?php elseif($step === 2): ?>
                        <!-- Step 1: Pilih Poli -->
                        <div id="step2" class="step animate-fade-in">
                            <div class="text-center mb-6">
                                <h3 class="text-2xl font-bold text-gray-900-2">Pilih Poli Klinik</h3>
                                <p class="text-gray-600">Silakan pilih jenis layanan kesehatan yang Anda butuhkan</p>
                            </div>
                            <div class="grid grid-cols-1 gap-4 mb-8">
                                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__currentLoopData = $poli_items; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $poli_item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoopIteration(); ?><?php endif; ?>
                                    <label class="poli-option cursor-pointer group"
                                        <?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::$currentLoop['key'] = ''; ?>wire:key='poli-<?php echo e($poli_item->id); ?>'>
                                        <input type="radio" wire:model.live="poli" value="<?php echo e($poli_item?->id); ?>"
                                            class="sr-only">
                                        <div
                                            class="flex poli_items-center p-5 border-2 rounded-xl transition-all duration-300 group-hover:scale-[1.02] group-hover:bg-blue-50
                                            <?php echo e($poli === $poli_item?->id ? 'border-blue-500 bg-blue-50' : 'border-gray-200'); ?>">
                                            
                                            <div class="text-3xl mr-4 transition-transform duration-300">🩺</div>
                                            <div class="flex-1">
                                                <div class="font-semibold text-gray-900-lg"><?php echo e($poli_item?->name); ?>

                                                </div>
                                                <div class="text-sm text-gray-500 mt-1"><?php echo e($poli_item?->description); ?>

                                                </div>
                                            </div>
                                            <div
                                                class="text-blue-500 <?php echo e($poli === $poli_item?->id ? 'opacity-100' : 'opacity-0'); ?> transition-opacity duration-300">
                                                <svg class="w-6 h-6" fill="none" stroke="currentColor"
                                                    viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        stroke-width="2" d="M9 5l7 7-7 7"></path>
                                                </svg>
                                            </div>
                                        </div>
                                    </label>
                                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
                            </div>
                            <div class="flex space-x-4">
                                <button type="button" id="prev-step2" wire:click="prevStep()"
                                    class="flex-1 bg-gray-100 hover:bg-gray-200-600 text-gray-700 py-3 px-6 rounded-xl font-semibold transition-all duration-300 transform hover:scale-[1.02] shadow-md hover:shadow-lg">
                                    <span class="flex items-center justify-center">
                                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M11 17l-5-5m0 0l5-5m-5 5h12"></path>
                                        </svg>
                                        Kembali
                                    </span>
                                </button>
                                <button type="button" id="next-step2" wire:click="nextStep()"
                                    class="flex-1 bg-gradient-to-r from-blue-600 to-blue-700 hover:from-blue-700 hover:to-blue-800 text-white py-3 px-6 rounded-xl font-semibold transition-all duration-300 disabled:opacity-50 disabled:cursor-not-allowed disabled:transform-none transform hover:scale-[1.02] shadow-lg hover:shadow-xl">
                                    <span class="flex items-center justify-center">
                                        Lanjutkan
                                        <svg class="w-5 h-5 ml-2" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M13 7l5 5m0 0l-5 5m5-5H6"></path>
                                        </svg>
                                    </span>
                                </button>
                            </div>
                        </div>
                    <?php elseif($step === 3): ?>
                        <!-- Step 2: Pilih Dokter -->
                        <div id="step3" class="step animate-fade-in">
                            <div class="text-center mb-6">
                                <h3 class="text-2xl font-bold text-gray-900-2">Pilih Dokter</h3>
                                <p class="text-gray-600">Pilih dokter yang tersedia untuk poli yang Anda pilih</p>
                            </div>
                            <div id="doctor-list" class="space-y-4 mb-8">
                                
                                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__currentLoopData = $doctors; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $doctor): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoopIteration(); ?><?php endif; ?>
                                    <?php
                                        $isFullyBooked = false;
                                        $availableSlots = 9999;
                                        $percentage = 1 * 100;
                                    ?>

                                    <label
                                        class="block border rounded-lg p-4 transition-all duration-200 <?php echo e($doctor?->id == $selected_doctor ? 'border-blue-500 bg-blue-50 ring-blue-500' : ''); ?>

                                            <?php echo e($isFullyBooked
                                                ? 'border-red-300 bg-red-50 dark:bg-red-900/20 dark:border-red-600 opacity-60 cursor-not-allowed'
                                                : 'border-gray-300 dark:border-slate-600 hover:border-blue-500 dark:hover:border-blue-400 hover:bg-blue-50 dark:hover:bg-blue-900 cursor-pointer'); ?>">
                                        <div class="flex items-center justify-between">
                                            <div class="flex items-center space-x-3">
                                                <input type="radio" name="doctor_id"
                                                    wire:model.live="selected_doctor" value="<?php echo e($doctor?->id); ?>"
                                                    class="w-4 h-4 text-blue-600 border-gray-300"
                                                    <?php echo e($isFullyBooked ? 'disabled' : ''); ?>>
                                                <div>
                                                    <h4 class="font-medium text-gray-900 dark:text-white">
                                                        <?php echo e($doctor->name); ?></h4>
                                                    <p
                                                        class="text-sm <?php echo e($isFullyBooked ? 'text-red-600 dark:text-red-400' : 'text-green-600 dark:text-green-400'); ?>">
                                                        <?php echo e($isFullyBooked ? 'Kuota Penuh' : "$availableSlots slot tersedia"); ?>

                                                    </p>
                                                </div>
                                            </div>
                                            
                                        </div>
                                    </label>
                                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
                            </div>
                            <div class="flex space-x-4">
                                <button type="button" id="prev-step2" wire:click="prevStep()"
                                    class="flex-1 bg-gray-100 hover:bg-gray-200-600 text-gray-700 py-3 px-6 rounded-xl font-semibold transition-all duration-300 transform hover:scale-[1.02] shadow-md hover:shadow-lg">
                                    <span class="flex items-center justify-center">
                                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M11 17l-5-5m0 0l5-5m-5 5h12"></path>
                                        </svg>
                                        Kembali
                                    </span>
                                </button>
                                <button type="button" id="next-step2" wire:click="nextStep()"
                                    class="flex-1 bg-gradient-to-r from-blue-600 to-blue-700 hover:from-blue-700 hover:to-blue-800 text-white py-3 px-6 rounded-xl font-semibold transition-all duration-300 disabled:opacity-50 disabled:cursor-not-allowed disabled:transform-none transform hover:scale-[1.02] shadow-lg hover:shadow-xl">
                                    <span class="flex items-center justify-center">
                                        Lanjutkan
                                        <svg class="w-5 h-5 ml-2" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M13 7l5 5m0 0l-5 5m5-5H6"></path>
                                        </svg>
                                    </span>
                                </button>
                            </div>
                        </div>
                    <?php elseif($step === 4): ?>
                        <!-- Step 3: Pilih Jadwal -->
                        <div id="step4" class="step animate-fade-in">
                            <div class="text-center mb-6">
                                <h3 class="text-2xl font-bold text-gray-900-2">Pilih Jadwal Kunjungan</h3>
                                <p class="text-gray-600">Tentukan tanggal dan waktu kunjungan Anda</p>
                            </div>

                            <div class="bg-gradient-to-r from-blue-50 to-indigo-50/20/20 rounded-xl p-6 mb-6">
                                <div class="mb-6">
                                    <label for="visit_date"
                                        class="block text-sm font-semibold text-gray-700 mb-3 flex items-center">
                                        <svg class="w-5 h-5 mr-2 text-blue-600" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z">
                                            </path>
                                        </svg>
                                        Pilih Tanggal
                                    </label>
                                    <input type="date" id="visit_date" wire:model.live="visit_date"
                                        name="visit_date"
                                        class="w-full px-4 py-3 border-2 border-gray-200 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500-all duration-300 hover:border-blue-300"
                                        min="<?php echo e(date('Y-m-d')); ?>">
                                </div>

                                <div class="mb-6">
                                    <label for="visit_time"
                                        class="block text-sm font-semibold text-gray-700 mb-3 flex items-center">
                                        <svg class="w-5 h-5 mr-2 text-blue-600" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                        </svg>
                                        Slot Waktu Tersedia
                                    </label>
                                    <div id="time-slots" class="grid grid-cols-2 gap-3">
                                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__currentLoopData = $time_slots; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $slot): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoopIteration(); ?><?php endif; ?>
                                            <?php
                                                $isFullyBooked = $slot['is_full'];
                                                $availableSlots = $slot['is_unlimited'] ? '♾️' : $slot['remaining_quota'];
                                                $percentage = $slot['is_unlimited'] ? 100 : ($slot['current_patients'] / $slot['max_patients']) * 100;
                                            ?>

                                            <label
                                                class="border rounded-lg p-3 cursor-pointer transition-all duration-200 <?php echo e($slot['id'] == $selected_time ? 'border-blue-500 bg-blue-50 ring-blue-500' : ''); ?>

                                                <?php echo e($isFullyBooked
                                                    ? 'border-red-300 bg-red-50 dark:bg-red-900/20 dark:border-red-600 opacity-60 cursor-not-allowed'
                                                    : 'border-gray-300 dark:border-slate-600 hover:border-blue-500 dark:hover:border-blue-400 hover:bg-blue-50 dark:hover:bg-blue-900/20'); ?>">
                                                <div class="flex items-center justify-between mb-2">
                                                    <div class="flex items-center space-x-2">
                                                        <input type="radio" name="visit_time"
                                                            value="<?php echo e($slot['id']); ?>"
                                                            wire:model.live="selected_time"
                                                            class="w-4 h-4 text-blue-600 border-gray-300"
                                                            <?php echo e($isFullyBooked ? 'disabled' : ''); ?>>
                                                        <span class="font-medium text-gray-900 dark:text-white">
                                                            <?php echo e($slot['start_time']); ?> - <?php echo e($slot['end_time']); ?>

                                                        </span>
                                                    </div>
                                                </div>
                                                <div class="flex items-center justify-between">
                                                    <span
                                                        class="text-xs <?php echo e($isFullyBooked ? 'text-red-600 dark:text-red-400' : 'text-green-600 dark:text-green-400'); ?>">
                                                        <?php echo e($isFullyBooked ? 'Penuh' : "$availableSlots tersisa"); ?>

                                                    </span>
                                                    <div class="flex items-center space-x-1">
                                                        <span class="text-xs text-gray-500 dark:text-gray-400">
                                                            <?php echo e($slot['current_patients']); ?>/<?php echo e($slot['max_patients']); ?>

                                                        </span>
                                                        <div class="w-8 bg-gray-200 dark:bg-gray-700 rounded-full h-1">
                                                            <div class="<?php echo e($isFullyBooked ? 'bg-red-500' : 'bg-green-500'); ?> h-1 rounded-full"
                                                                style="width: <?php echo e($percentage); ?>%">
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </label>
                                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
                                    </div>
                                    <div id="no-slots-message" class="hidden text-center py-8">
                                        <div class="text-gray-400">
                                            <svg class="w-12 h-12 mx-auto mb-3" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                            </svg>
                                            <p class="text-sm">Pilih tanggal untuk melihat slot waktu yang tersedia</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="flex space-x-4">
                                <button type="button" id="prev-step3" wire:click="prevStep()"
                                    class="flex-1 bg-gray-100 hover:bg-gray-200-600 text-gray-700 py-3 px-6 rounded-xl font-semibold transition-all duration-300 transform hover:scale-[1.02] shadow-md hover:shadow-lg">
                                    <span class="flex items-center justify-center">
                                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M11 17l-5-5m0 0l5-5m-5 5h12"></path>
                                        </svg>
                                        Kembali
                                    </span>
                                </button>
                                <button type="button" id="next-step3" wire:click="nextStep()"
                                    class="flex-1 bg-gradient-to-r from-blue-600 to-blue-700 hover:from-blue-700 hover:to-blue-800 text-white py-3 px-6 rounded-xl font-semibold transition-all duration-300 disabled:opacity-50 disabled:cursor-not-allowed disabled:transform-none transform hover:scale-[1.02] shadow-lg hover:shadow-xl">
                                    <span class="flex items-center justify-center">
                                        Lanjutkan
                                        <svg class="w-5 h-5 ml-2" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M13 7l5 5m0 0l-5 5m5-5H6"></path>
                                        </svg>
                                    </span>
                                </button>
                            </div>
                        </div>
                    <?php elseif($step === 5): ?>
                        <!-- Step 4: Data Pasien -->
                        <div id="step5" class="step animate-fade-in">
                            <div class="text-center mb-6">
                                <h3 class="text-2xl font-bold text-gray-900-2">Data Pasien</h3>
                                <p class="text-gray-600">Lengkapi data diri untuk menyelesaikan pendaftaran</p>
                            </div>

                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(!$open_form): ?>
                                <!-- NIK Search Section -->
                                <div id="nik-search-section"
                                    class="bg-gradient-to-r from-green-50 to-emerald-50/20/20 rounded-xl p-6 space-y-6">
                                    <div>
                                        <label for="nik"
                                            class="block text-sm font-semibold text-gray-700 mb-3 flex items-center">
                                            <svg class="w-5 h-5 mr-2 text-green-600" fill="none"
                                                stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M10 6H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V8a2 2 0 00-2-2h-5m-4 0V4a2 2 0 114 0v2m-4 0a2 2 0 104 0m-5 8a2 2 0 100-4 2 2 0 000 4zm0 0c1.306 0 2.417.835 2.83 2M9 14a3.001 3.001 0 00-2.83 2M15 11h3m-3 4h2">
                                                </path>
                                            </svg>
                                            NIK (Nomor Induk Kependudukan)
                                        </label>
                                        <div class="flex space-x-3">
                                            <input type="text" id="nik" name="nik"
                                                class="flex-1 px-4 py-3 border-2 border-gray-200 rounded-xl focus:ring-2 focus:ring-green-500 focus:border-green-500-all duration-300 hover:border-green-300"
                                                placeholder="Masukkan 16 digit NIK" maxlength="16">
                                            <button type="button" id="search-nik"
                                                class="px-6 py-3 bg-gradient-to-r from-green-600 to-green-700 hover:from-green-700 hover:to-green-800 text-white rounded-xl font-semibold transition-all duration-300 transform hover:scale-[1.02] shadow-lg hover:shadow-xl">
                                                <span class="flex items-center">
                                                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor"
                                                        viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            stroke-width="2"
                                                            d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                                                    </svg>
                                                    Cari
                                                </span>
                                            </button>
                                        </div>
                                        <p class="text-sm text-gray-600 mt-2 flex items-center">
                                            <svg class="w-4 h-4 mr-1 text-blue-500" fill="none"
                                                stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z">
                                                </path>
                                            </svg>
                                            Masukkan NIK untuk mencari data pasien yang sudah terdaftar
                                        </p>
                                    </div>

                                    <div class="text-center">
                                        <div class="relative">
                                            <div class="absolute inset-0 flex items-center">
                                                <div class="w-full border-t border-gray-300"></div>
                                            </div>
                                            <div class="relative flex justify-center text-sm">
                                                <span
                                                    class="px-4 bg-gradient-to-r from-green-50 to-emerald-50/20/20 text-gray-500 font-medium">atau</span>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="text-center">
                                        <button type="button" id="new-patient-btn" wire:click='formAddPatient()'
                                            class="px-8 py-3 bg-gradient-to-r from-gray-600 to-gray-700 hover:from-gray-700 hover:to-gray-800 text-white rounded-xl font-semibold transition-all duration-300 transform hover:scale-[1.02] shadow-lg hover:shadow-xl">
                                            <span class="flex items-center justify-center">
                                                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor"
                                                    viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                                                </svg>
                                                Pasien Baru
                                            </span>
                                        </button>
                                    </div>
                                </div>
                            <?php else: ?>
                                <!-- Patient Data Form (Hidden initially) -->
                                <div id="patient-form-section" class="space-y-6 animate-fade-in">
                                    

                                    <div class="bg-gradient-to-r from-purple-50 to-purple-50 rounded-xl p-6 space-y-6">
                                        <div>
                                            <label for="name"
                                                class="block text-sm font-semibold text-gray-700 mb-3 flex items-center">
                                                <svg class="w-5 h-5 mr-2 text-purple-600" fill="none"
                                                    stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        stroke-width="2"
                                                        d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z">
                                                    </path>
                                                </svg>
                                                Nama Lengkap <span class="text-red-500">*</span>
                                            </label>
                                            <input type="text" id="name" name="name"
                                                class="w-full px-4 py-3 border-2 border-gray-200 rounded-xl focus:ring-2 focus:ring-purple-500 focus:border-purple-500-all duration-300 hover:border-purple-300"
                                                placeholder="Masukkan nama lengkap" wire:model.defer="name">
                                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__errorArgs = ['name'];
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

                                        <div>
                                            <label for="identity_card"
                                                class="block text-sm font-semibold text-gray-700 mb-3 flex items-center">
                                                <i class="ti ti-id mr-2 text-purple-600 text-xl"></i>
                                                NIK <span class="text-red-500">*</span>
                                            </label>
                                            <input type="number" id="identity_card" name="identity_card"
                                                class="w-full px-4 py-3 border-2 border-gray-200 rounded-xl focus:ring-2 focus:ring-purple-500 focus:border-purple-500-all duration-300 hover:border-purple-300"
                                                placeholder="xxxxxxxxxxxxxxxx" wire:model.defer="identity_card">
                                            <label for="toggle" class="inline-flex items-center cursor-pointer mt-2">
                                                <div class="relative">
                                                    <input type="checkbox" id="toggle" name="is_active" value="true" class="sr-only peer">
                                                    <div class="w-11 h-6 bg-gray-200 rounded-full peer peer-checked:bg-blue-600 transition"></div>
                                                    <div class="absolute top-0.5 left-0.5 w-5 h-5 bg-white rounded-full transition peer-checked:translate-x-full peer-checked:left-0.5"></div>
                                                </div>
                                                <span class="ml-3 text-sm font-medium text-gray-900">NIK Ibu ?</span>
                                            </label>
                                            <input type="hidden" name="identity_card_mother" wire:model.defer="identity_card_mother" value="false">
                                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__errorArgs = ['identity_card'];
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
                                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                            <div>
                                                <label for="phone" class="block text-sm font-semibold text-gray-700 mb-3 flex items-center">
                                                    <svg class="w-5 h-5 mr-2 text-purple-600" fill="none"
                                                        stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            stroke-width="2"
                                                            d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z">
                                                        </path>
                                                    </svg>
                                                    Nomor Telepon <span class="text-red-500">*</span>
                                                </label>
                                                <input type="tel" id="phone" name="phone"
                                                    class="w-full px-4 py-3 border-2 border-gray-200 rounded-xl focus:ring-2 focus:ring-purple-500 focus:border-purple-500-all duration-300 hover:border-purple-300"
                                                    placeholder="08xxxxxxxxxx" wire:model.defer="phone">
                                                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__errorArgs = ['phone'];
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
                                            <div>
                                                <label for="email" class="block text-sm font-semibold text-gray-700 mb-3 flex items-center">
                                                    <i class="ti ti-mail mr-2 text-purple-600 text-xl"></i>
                                                    Alamat Email
                                                </label>
                                                <input type="email" id="email" name="email" class="w-full px-4 py-3 border-2 border-gray-200 rounded-xl focus:ring-2 focus:ring-purple-500 focus:border-purple-500-all duration-300 hover:border-purple-300"
                                                placeholder="user@gmail.com" wire:model.defer='email'>
                                                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__errorArgs = ['email'];
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

                                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                            <div>
                                                <label for="province_code" class="block text-sm font-semibold text-gray-700 mb-3 flex items-center">
                                                    <i class="ti ti-map-pin mr-2 text-purple-600 text-xl"></i>
                                                    Provinsi <span class="text-red-500">*</span>
                                                </label>
                                                <div <?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::$currentLoop['key'] = 'select-'.e(rand()).''; ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::$currentLoop['key'] = 'select-'.e(rand()).''; ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::$currentLoop['key'] = 'select-'.e(rand()).''; ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::$currentLoop['key'] = 'select-'.e(rand()).''; ?>wire:key="select-<?php echo e(rand()); ?>">
                                                    <select class="w-full px-4 py-3 border-2 border-gray-200 rounded-xl focus:ring-2 focus:ring-purple-500 focus:border-purple-500-all duration-300 hover:border-purple-300"
                                                        wire:model.lazy="province_code" id="province_code">
                                                        <option value="">-- Pilih Provinsi --</option>
                                                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__currentLoopData = $provinces; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $province): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoopIteration(); ?><?php endif; ?>
                                                            <option value="<?php echo e($province['code']); ?>"><?php echo e($province['name']); ?></option>
                                                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
                                                    </select>
                                                </div>
                                                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__errorArgs = ['province_code'];
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
                                            <div>
                                                <label for="city_code" class="block text-sm font-semibold text-gray-700 mb-3 flex items-center">
                                                    <i class="ti ti-map-pin mr-2 text-purple-600 text-xl"></i>
                                                    Kota / Kabupaten <span class="text-red-500">*</span>
                                                </label>
                                                <div <?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::$currentLoop['key'] = 'select-'.e(rand()).''; ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::$currentLoop['key'] = 'select-'.e(rand()).''; ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::$currentLoop['key'] = 'select-'.e(rand()).''; ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::$currentLoop['key'] = 'select-'.e(rand()).''; ?>wire:key="select-<?php echo e(rand()); ?>">
                                                    <select class="w-full px-4 py-3 border-2 border-gray-200 rounded-xl focus:ring-2 focus:ring-purple-500 focus:border-purple-500-all duration-300 hover:border-purple-300"
                                                        wire:model.lazy="city_code" id="city_code">
                                                        <option value="">-- Pilih Kota --</option>
                                                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__currentLoopData = $cities; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $city): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoopIteration(); ?><?php endif; ?>
                                                            <option value="<?php echo e($city['code']); ?>"><?php echo e($city['name']); ?></option>
                                                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
                                                    </select>
                                                </div>
                                                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__errorArgs = ['city_code'];
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
                                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                            <div>
                                                <label for="district_code" class="block text-sm font-semibold text-gray-700 mb-3 flex items-center">
                                                    <i class="ti ti-map-pin mr-2 text-purple-600 text-xl"></i>
                                                    Kecamatan <span class="text-red-500">*</span>
                                                </label>
                                                <div <?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::$currentLoop['key'] = 'select-'.e(rand()).''; ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::$currentLoop['key'] = 'select-'.e(rand()).''; ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::$currentLoop['key'] = 'select-'.e(rand()).''; ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::$currentLoop['key'] = 'select-'.e(rand()).''; ?>wire:key="select-<?php echo e(rand()); ?>">
                                                    <select class="w-full px-4 py-3 border-2 border-gray-200 rounded-xl focus:ring-2 focus:ring-purple-500 focus:border-purple-500-all duration-300 hover:border-purple-300"
                                                        wire:model.lazy="district_code" id="district_code">
                                                        <option value="">-- Pilih Kecamatan --</option>
                                                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__currentLoopData = $districts; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $district): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoopIteration(); ?><?php endif; ?>
                                                            <option value="<?php echo e($district['code']); ?>"><?php echo e($district['name']); ?></option>
                                                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
                                                    </select>
                                                </div>
                                                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__errorArgs = ['district_code'];
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
                                            <div>
                                                <label for="sub_district_code" class="block text-sm font-semibold text-gray-700 mb-3 flex items-center">
                                                    <i class="ti ti-map-pin mr-2 text-purple-600 text-xl"></i>
                                                    Kelurahan <span class="text-red-500">*</span>
                                                </label>
                                                <div <?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::$currentLoop['key'] = 'select-'.e(rand()).''; ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::$currentLoop['key'] = 'select-'.e(rand()).''; ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::$currentLoop['key'] = 'select-'.e(rand()).''; ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::$currentLoop['key'] = 'select-'.e(rand()).''; ?>wire:key="select-<?php echo e(rand()); ?>">
                                                    <select class="w-full px-4 py-3 border-2 border-gray-200 rounded-xl focus:ring-2 focus:ring-purple-500 focus:border-purple-500-all duration-300 hover:border-purple-300"
                                                        wire:model.lazy="sub_district_code" id="sub_district_code">
                                                        <option value="">-- Pilih Kelurahan --</option>
                                                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__currentLoopData = $subDistricts; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $sub_district): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoopIteration(); ?><?php endif; ?>
                                                            <option value="<?php echo e($sub_district['code']); ?>"><?php echo e($sub_district['name']); ?></option>
                                                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
                                                    </select>
                                                </div>
                                                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__errorArgs = ['sub_district_code'];
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
                                        <div>
                                            <label for="address" class="block text-sm font-semibold text-gray-700 mb-3 flex items-center">
                                                <i class="ti ti-mail mr-2 text-purple-600 text-xl"></i>
                                                Alamat <span class="text-red-500">*</span>
                                            </label>
                                            
                                            <textarea name="address" id="" cols="30" rows="2" wire:model.defer="address" class="w-full px-4 py-3 border-2 border-gray-200 rounded-xl focus:ring-2 focus:ring-purple-500 focus:border-purple-500-all duration-300 hover:border-purple-300"></textarea>
                                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__errorArgs = ['address'];
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
                                        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                                            <div>
                                                <label for="postal_code"
                                                    class="block text-sm font-semibold text-gray-700 mb-3 flex items-center">
                                                    <svg class="w-5 h-5 mr-2 text-purple-600" fill="none"
                                                        stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            stroke-width="2"
                                                            d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z">
                                                        </path>
                                                    </svg>
                                                    Kode Pos <span class="text-red-500">*</span>
                                                </label>
                                                <input type="number" id="postal_code" name="postal_code"
                                                    class="w-full px-4 py-3 border-2 border-gray-200 rounded-xl focus:ring-2 focus:ring-purple-500 focus:border-purple-500-all duration-300 hover:border-purple-300"
                                                    placeholder="Masukkan kode pos" min="1" max="120" wire:model.defer="postal_code">
                                                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__errorArgs = ['address'];
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
                                            <div>
                                                <label for="rt"
                                                    class="block text-sm font-semibold text-gray-700 mb-3 flex items-center">
                                                    <svg class="w-5 h-5 mr-2 text-purple-600" fill="none"
                                                        stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            stroke-width="2"
                                                            d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z">
                                                        </path>
                                                    </svg>
                                                    RT <span class="text-red-500">*</span>
                                                </label>
                                                <input type="number" id="rt" name="rt"
                                                    class="w-full px-4 py-3 border-2 border-gray-200 rounded-xl focus:ring-2 focus:ring-purple-500 focus:border-purple-500-all duration-300 hover:border-purple-300"
                                                    placeholder="Masukkan nomor RT" min="1" max="120" wire:model.defer="rt_code">
                                                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__errorArgs = ['rt_code'];
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
                                            <div>
                                                <label for="rw"
                                                    class="block text-sm font-semibold text-gray-700 mb-3 flex items-center">
                                                    <svg class="w-5 h-5 mr-2 text-purple-600" fill="none"
                                                        stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            stroke-width="2"
                                                            d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z">
                                                        </path>
                                                    </svg>
                                                    RW <span class="text-red-500">*</span>
                                                </label>
                                                <input type="number" id="rw" name="rw"
                                                    class="w-full px-4 py-3 border-2 border-gray-200 rounded-xl focus:ring-2 focus:ring-purple-500 focus:border-purple-500-all duration-300 hover:border-purple-300"
                                                    placeholder="Masukkan nomor RW" min="1" max="120" wire:model.defer="rw_code">
                                                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__errorArgs = ['rw_code'];
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
                                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                            <div>
                                                <label for="blood_group" class="block text-sm font-semibold text-gray-700 mb-3 flex items-center">
                                                    <i class="ti ti-droplets mr-2 text-purple-600 text-xl"></i>
                                                    Golongan Darah
                                                </label>
                                                <select id="blood_group" name="blood_group"  wire:model='blood_group'
                                                    class="w-full px-4 py-3 border-2 border-gray-200 rounded-xl focus:ring-2 focus:ring-purple-500 focus:border-purple-500-all duration-300 hover:border-purple-300">
                                                    <option value="">Pilih Golongan Darah</option>
                                                    <option value="A">A</option>
                                                    <option value="B">B</option>
                                                    <option value="AB">AB</option>
                                                    <option value="O">O</option>
                                                    <option value="Tidak Tahu">Tidak Tahu</option>
                                                </select>
                                                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__errorArgs = ['blood_group'];
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
                                            <div>
                                                <label for="administrative_gender" class="block text-sm font-semibold text-gray-700 mb-3 flex items-center">
                                                    <i class="ti ti-gender-bigender mr-2 text-purple-600 text-xl"></i>
                                                    Jenis Kelamin <span class="text-red-500">*</span>
                                                </label>
                                                <select id="administrative_gender" name="administrative_gender" wire:model.defer='administrative_gender'
                                                    class="w-full px-4 py-3 border-2 border-gray-200 rounded-xl focus:ring-2 focus:ring-purple-500 focus:border-purple-500-all duration-300 hover:border-purple-300">
                                                    <option value="">Pilih jenis kelamin</option>
                                                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__currentLoopData = $administrativeGenderDetails; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $administrativeGenderDetail): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoopIteration(); ?><?php endif; ?>
                                                        <option value="<?php echo e($administrativeGenderDetail['code']); ?>">
                                                            <?php echo e($administrativeGenderDetail['display']); ?></option>
                                                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
                                                </select>
                                                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__errorArgs = ['administrative_gender'];
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
                                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                            <div>
                                                <label for="marital_status" class="block text-sm font-semibold text-gray-700 mb-3 flex items-center">
                                                    <i class="ti ti-hierarchy mr-2 text-purple-600 text-xl"></i>
                                                    Status Perkawinan <span class="text-red-500">*</span>
                                                </label>
                                                <select id="marital_status" name="marital_status" wire:model.defer="marital_status"
                                                    class="w-full px-4 py-3 border-2 border-gray-200 rounded-xl focus:ring-2 focus:ring-purple-500 focus:border-purple-500-all duration-300 hover:border-purple-300">
                                                    <option value="">Pilih status perkawinan</option>
                                                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__currentLoopData = $maritalStatusDetails; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $maritalStatusDetail): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoopIteration(); ?><?php endif; ?>
                                                        <option value="<?php echo e($maritalStatusDetail['code']); ?>">
                                                            <?php echo e($maritalStatusDetail['display_ind']); ?></option>
                                                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
                                                </select>
                                                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__errorArgs = ['marital_status'];
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
                                            <div>
                                                <label for="birth_date" class="block text-sm font-semibold text-gray-700 mb-3 flex items-center">
                                                    <i class="ti ti-cake mr-2 text-purple-600 text-xl"></i>
                                                    Tanggal Lahir <span class="text-red-500">*</span>
                                                </label>
                                                <input type="date" id="birth_date" name="birth_date" wire:model.defer="birth_date"
                                                    class="w-full px-4 py-3 border-2 border-gray-200 rounded-xl focus:ring-2 focus:ring-purple-500 focus:border-purple-500-all duration-300 hover:border-purple-300"
                                                    placeholder="Masukkan nomor RW" min="1" max="120">
                                                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__errorArgs = ['birth_code'];
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
                                        <div>
                                            <label for="complaint"
                                                class="block text-sm font-semibold text-gray-700 mb-3 flex items-center">
                                                <svg class="w-5 h-5 mr-2 text-purple-600" fill="none"
                                                    stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        stroke-width="2"
                                                        d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z">
                                                    </path>
                                                </svg>
                                                Keluhan (Opsional)
                                            </label>
                                            <textarea id="complaint" name="complaint" rows="4" wire:model.defer='patient_complaint'
                                                class="w-full px-4 py-3 border-2 border-gray-200 rounded-xl focus:ring-2 focus:ring-purple-500 focus:border-purple-500-all duration-300 hover:border-purple-300 resize-none"
                                                placeholder="Jelaskan keluhan Anda ..."></textarea>
                                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__errorArgs = ['complaint'];
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

                                        <div class="text-center pt-3">
                                            <button type="button" id="back-to-search" wire:click='formAddPatient()'
                                                class="px-6 py-3 bg-gradient-to-r from-gray-500 to-gray-600 hover:from-gray-600 hover:to-gray-700 text-white rounded-xl font-semibold transition-all duration-300 transform hover:scale-[1.02] shadow-lg hover:shadow-xl">
                                                <span class="flex items-center justify-center">
                                                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor"
                                                        viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                                                    </svg>
                                                    Kembali ke Pencarian NIK
                                                </span>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                            <div class="flex space-x-4 mt-8">
                                <button type="button" id="prev-step4" wire:click="prevStep()"
                                    class="flex-1 bg-gradient-to-r from-gray-400 to-gray-500 hover:from-gray-500 hover:to-gray-600 text-white py-4 px-6 rounded-xl font-semibold transition-all duration-300 transform hover:scale-[1.02] shadow-lg hover:shadow-xl">
                                    <span class="flex items-center justify-center">
                                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                                        </svg>
                                        Kembali
                                    </span>
                                </button>
                                <a wire:click='regisQueue()'
                                    class="flex-1 bg-gradient-to-r from-green-600 to-green-700 hover:from-green-700 hover:to-green-800 text-white py-4 px-6 rounded-xl font-semibold transition-all duration-300 transform hover:scale-[1.02] shadow-lg hover:shadow-xl disabled:opacity-50 disabled:cursor-not-allowed disabled:transform-none">
                                    <span class="flex items-center justify-center">
                                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                        </svg>
                                        Daftar Antrian
                                    </span>
                                </a>
                            </div>
                        </div>
                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                </form>
            </div>
        </div>

        <div class="mt-8 text-center">
            <a href="<?php echo e(route('queue')); ?>" class="text-blue-600 hover:text-blue-800-300 font-medium">
                ← Kembali ke Halaman Antrian
            </a>
        </div>
    </div>
</div><?php /**PATH /Users/macbookair/Documents/mediction/mediction.id/resources/views/livewire/queue/queue-register.blade.php ENDPATH**/ ?>