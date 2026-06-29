<div>
    
    <div class="px-5 sm:px-6 py-6 space-y-5">
        
        <section class="space-y-2">
            <h1 class="text-xl font-extrabold text-slate-900">Daftar Pasien</h1>
            <h2 class="text-md text-slate-800">Pilih Pasien</h2>

            <div class="space-y-4">
                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__currentLoopData = $patients; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $p): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoopIteration(); ?><?php endif; ?>
                    <?php $isActive = $selectedPatientId === $p['id']; ?>

                    <button type="button"
                            <?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::$currentLoop['key'] = 'patient-'.e($p['id']).''; ?>wire:key="patient-<?php echo e($p['id']); ?>"
                            
                            wire:click="selectPatient(<?php echo \Illuminate\Support\Js::from($p['id'])->toHtml() ?>)"
                            class="relative w-full text-left rounded-2xl bg-white p-3 flex gap-2 items-start
                                border-2 border-slate-100 shadow-sm transition
                                [-webkit-tap-highlight-color:transparent]
                                focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-sky-300 focus-visible:ring-offset-2
                                <?php echo e($isActive ? 'bg-sky-50' : ''); ?>">

                        
                        <span class="pointer-events-none absolute inset-0 rounded-2xl
                                    <?php echo e($isActive
                                        ? 'shadow-[inset_0_0_0_2px_rgba(14,165,233,1)]'
                                        : 'shadow-[inset_0_0_0_0_rgba(0,0,0,0)]'); ?>"></span>

                        
                        <img src="<?php echo e($p['avatar']); ?>"
                            class="w-16 h-16 rounded-xl object-cover bg-slate-100"
                            alt="<?php echo e($p['name']); ?>"/>

                        
                        <div class="flex-1 min-w-0">
                            <div class="text-sky-600 font-bold text-md leading-tight truncate">
                                <?php echo e($p['name']); ?>

                            </div>

                            <div class="mt-1 flex items-center justify-between gap-3">
                                <div class="text-slate-800 font-medium text-sm">No. RM</div>
                                <div class="font-bold text-slate-900 text-sm"><?php echo e($p['rm']); ?></div>
                            </div>

                            <div class="mt-1">
                                <span class="inline-flex items-center rounded-full px-2 py-0.5 text-xs font-light <?php echo e($p['tagClass']); ?>">
                                    <?php echo e($p['tag']); ?>

                                </span>
                            </div>
                        </div>

                        
                        <div class="pt-6">
                            <div class="w-6 h-6 rounded-lg flex items-center justify-center
                                        <?php echo e($isActive ? 'bg-sky-500 text-white' : 'bg-white border-2 border-slate-200 text-transparent'); ?>">
                                <svg class="w-5 h-5" viewBox="0 0 24 24" fill="none">
                                    <path d="M20 6L9 17l-5-5"
                                        stroke="currentColor" stroke-width="2.5"
                                        stroke-linecap="round" stroke-linejoin="round"/>
                                </svg>
                            </div>
                        </div>
                    </button>
                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
            </div>

            
            <a href="<?php echo e(route('mobile.queue.register.create-patient')); ?>" type="button" class="w-full h-10 rounded-full bg-sky-400 text-white font-extrabold text-md mt-3 flex items-center justify-center gap-2">
                <span class="text-2xl leading-none">+</span>
                <span>Tambah Pasien</span>
            </a>
        </section>

        
        <section class="space-y-2.5">
            <h2 class="text-2xl font-bold text-slate-900">Jadwal Praktek</h2>

            
            <div class="overflow-x-auto scrollbar-hide -mx-5 sm:-mx-6 px-5 sm:px-6">
                <div class="flex items-center gap-2.5 min-w-max py-1">
                    <?php $lastMonth = null; ?>

                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__currentLoopData = $dates; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $d): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoopIteration(); ?><?php endif; ?>
                        <?php
                            $active = $selectedDateKey === $d['key'];
                            $monthChanged = $lastMonth !== $d['month'];
                        ?>

                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($monthChanged): ?>
                            
                            <div class="ml-1 mr-1 flex items-center gap-2">
                                <span class="text-xs font-extrabold text-slate-600"><?php echo e($d['month']); ?></span>
                                <span class="h-6 w-px bg-slate-200"></span>
                            </div>
                            <?php $lastMonth = $d['month']; ?>
                        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

                        <button type="button"
                                <?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::$currentLoop['key'] = 'date-'.e($d['key']).''; ?>wire:key="date-<?php echo e($d['key']); ?>"
                                wire:click="selectDate('<?php echo e($d['key']); ?>')"
                                class="w-16 h-16 rounded-2xl flex flex-col items-center justify-center
                                    font-extrabold shadow-sm transition
                                    [-webkit-tap-highlight-color:transparent]
                                    <?php echo e($active ? 'bg-sky-400 text-white shadow-[0_12px_25px_rgba(14,165,233,0.25)]' : 'bg-slate-400/60 text-white/95'); ?>"
                        >
                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($d['is_today']): ?>
                                <div class="text-[11px] leading-none">Hari</div>
                                <div class="text-[11px] leading-none mt-0.5">ini</div>
                            <?php else: ?>
                                <div class="text-sm"><?php echo e($d['dow']); ?></div>
                                <div class="text-base leading-none"><?php echo e($d['day']); ?></div>
                            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                        </button>
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
                </div>
            </div>


            
            <div class="grid grid-cols-2 gap-3">
                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__currentLoopData = $polyclinics; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $c): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoopIteration(); ?><?php endif; ?>
                    <?php $active = $selectedPolyclinic === $c['key']; ?>

                    <button type="button"
                            <?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::$currentLoop['key'] = 'cat-'.e($c['key']).''; ?>wire:key="cat-<?php echo e($c['key']); ?>"
                            wire:click="selectPolyclinic(<?php echo \Illuminate\Support\Js::from($c['key'])->toHtml() ?>)"
                            class="relative isolate w-full rounded-2xl p-4 text-left transition
                                bg-white shadow-sm
                                appearance-none focus:outline-none
                                [-webkit-tap-highlight-color:transparent]
                                active:scale-[0.99]
                                <?php echo e($active ? 'bg-sky-50' : ''); ?>">

                        
                        <span class="pointer-events-none absolute inset-0 rounded-2xl border-2
                                    <?php echo e($active ? 'border-sky-500' : 'border-slate-200'); ?>"></span>

                        <div class="flex items-center gap-3 relative">
                            <div class="w-10 h-10 rounded-xl flex items-center justify-center">
                                <img src="<?php echo e($c['icon']); ?>" alt="">
                            </div>
                            <div class="min-w-0">
                                <div class="font-extrabold text-slate-900 text-sm leading-tight truncate">
                                    <?php echo e($c['label']); ?>

                                </div>
                                <div class="text-xs text-slate-500">Pilih layanan</div>
                            </div>
                        </div>
                    </button>
                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
            </div>

            
            <div class="space-y-2.5 pt-2">
                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__currentLoopData = $doctorSchedules; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $s): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoopIteration(); ?><?php endif; ?>
                    <?php $isSelected = $selectedScheduleId === $s['id']; ?>

                    
                    <div class="rounded-3xl shadow-[0_12px_30px_rgba(15,23,42,0.10)]">
                        <button type="button"
                                <?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::$currentLoop['key'] = 'schedule-'.e($s['id']).''; ?>wire:key="schedule-<?php echo e($s['id']); ?>"
                                wire:click="selectSchedule(<?php echo \Illuminate\Support\Js::from($s['id'])->toHtml() ?>)"
                                class="relative w-full text-left rounded-3xl bg-white p-3 flex gap-3 items-center transition
                                    overflow-hidden
                                    [-webkit-tap-highlight-color:transparent]
                                    focus:outline-none"
                        >
                            
                            <span class="pointer-events-none absolute inset-0 rounded-3xl
                                        <?php echo e($isSelected
                                            ? 'shadow-[inset_0_0_0_2px_rgba(14,165,233,1)]'
                                            : 'shadow-[inset_0_0_0_2px_rgba(226,232,240,1)]'); ?>"></span>

                            <img src="<?php echo e($s['avatar']); ?>"
                                class="w-24 h-24 rounded-2xl object-cover bg-slate-100"
                                alt="<?php echo e($s['doctor']); ?>">

                            <div class="flex-1 min-w-0 relative">
                                <div class="text-sky-600 font-bold text-md truncate">
                                    <?php echo e($s['doctor']); ?>

                                </div>

                                <div class="mt-1 text-slate-700 text-sm leading-snug line-clamp-2">
                                    <?php echo e($s['desc']); ?>

                                </div>

                                
                                <div class="mt-2 inline-flex items-center gap-2 rounded-full px-3 py-1 text-xs font-bold bg-sky-100 text-sky-700">
                                    <svg class="w-4 h-4" viewBox="0 0 24 24" fill="none">
                                        <path d="M12 7v5l3 2" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                        <path d="M12 22a10 10 0 1 0-10-10 10 10 0 0 0 10 10Z" stroke="currentColor" stroke-width="2"/>
                                    </svg>
                                    <span><?php echo e($s['time']); ?></span>
                                </div>
                            </div>

                            
                            <div class="shrink-0 relative">
                                <div class="w-6 h-6 rounded-2xl flex items-center justify-center transition
                                            <?php echo e($isSelected
                                                ? 'bg-sky-500 text-white shadow-[0_10px_25px_rgba(14,165,233,0.25)]'
                                                : 'bg-white shadow-[inset_0_0_0_2px_rgba(226,232,240,1)] text-slate-300'); ?>">
                                    <svg class="w-4 h-4" viewBox="0 0 24 24" fill="none">
                                        <path d="M20 6L9 17l-5-5" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"/>
                                    </svg>
                                </div>
                            </div>
                        </button>
                    </div>
                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
            </div>
        </section>

        
        <div class="fixed inset-x-0 bottom-[5.25rem] sm:bottom-[5.25rem] z-[50]">
            <div class="pb-[max(env(safe-area-inset-bottom),0.5rem)]"></div>

            <div class="px-3 sm:px-4">
                <div class="mx-auto w-full max-w-[430px] sm:max-w-[640px] md:max-w-[800px] <?php echo e(!$buttonCreate ? 'hidden' : ''); ?>">
                    <button
                        type="button"
                        x-data
                        wire:click="openModal"
                        class="w-full h-10 rounded-2xl bg-sky-400 text-white font-bold
                            shadow-[0_18px_40px_rgba(14,165,233,0.28)]
                            active:scale-[0.99] transition"
                    > Ambil Antrian </button>
                </div>
            </div>
        </div>
        <div class="h-6"></div>
    </div>

    
    <div wire:ignore.self id="modal" class="fixed inset-0 bg-overlay hidden items-center justify-center z-50 transition-opacity duration-300 ease-in-out">
        <div class="bg-white rounded-2xl shadow-2xl max-w-lg w-full transform transition-all scale-95 duration-300 ease-out animate-fade-in">
            <!-- Header -->
            <div class="flex justify-between items-center p-6 border-b">
                <div class="flex items-center gap-2">
                    <svg class="w-6 h-6 text-sky-500" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M13 16h-1v-4h-1m1-4h.01M12 20.5C6.753 20.5 2.5 16.247 2.5 11S6.753 1.5 12 1.5 21.5 5.753 21.5 11 17.247 20.5 12 20.5z" />
                    </svg>
                    <h2 class="text-xl font-semibold text-gray-800">Pemberitahuan</h2>
                </div>
                <button wire:click="closeModal()" class="text-gray-500 hover:text-red-500 transition-colors text-2xl leading-none cursor-pointer">
                    &times;
                </button>
            </div>

            <!-- Body -->
            <div class="px-6 py-4 text-gray-700 font-medium">
                <p>Silakan konfirmasi untuk melanjutkan pengambilan antrian.</p>
            </div>

            <!-- Footer -->
            <div class="flex justify-end gap-2 px-6 py-4 border-t">
                <button wire:click="closeModal()" class="px-4 py-2 bg-gray-200 hover:bg-gray-300 text-gray-800 rounded-lg shadow transition cursor-pointer">
                    Batal
                </button>
                <button wire:click='submit' class="px-4 py-2 bg-sky-500 hover:bg-sky-600 text-white rounded-lg shadow transition">
                    Simpan
                </button>
            </div>
        </div>
    </div>
</div><?php /**PATH /Users/macbookair/Documents/mediction/mediction.id/resources/views/livewire/mobile/queue-register/queue-register-index.blade.php ENDPATH**/ ?>