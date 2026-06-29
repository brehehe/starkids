<div>
    
    <?php
        $blue = 'from-sky-400 via-sky-500 to-sky-600';
    ?>

    <div class="min-h-dvh bg-slate-100">
        
        <div class="relative overflow-hidden rounded-b-2xl bg-gradient-to-b <?php echo e($blue); ?>">
            
            <div class="pt-[max(env(safe-area-inset-top),1.25rem)] sm:pt-2 md:pt-4"></div>

            
            <div class="px-3 pt-2 pb-5">
                <div class="flex items-center gap-3">
                    
                    <img
                        src="<?php echo e(asset('asset/img/mobile/profile.png')); ?>"
                        alt="Avatar"
                        class="w-10 h-10 rounded-full object-cover ring-2 ring-white/70"
                        onerror="this.src='https://placehold.co/80x80/png';"
                    />

                    
                    <div class="flex-1">
                        <div class="relative">
                            <input
                                wire:model.live.debounce.300ms="search"
                                placeholder="Cari Nama Dokter dan Pelayanan"
                                class="w-full h-11 rounded-full bg-white/95 shadow
                                    pl-5 pr-12 text-sm text-slate-700 placeholder:text-slate-400
                                    outline-none focus:ring-4 focus:ring-sky-500/20"
                            />
                            <button type="button"
                                    class="absolute right-1.5 top-1/2 -translate-y-1/2
                                        w-9 h-9 rounded-full bg-sky-500 text-white flex items-center justify-center shadow">
                                <svg class="w-5 h-5" viewBox="0 0 24 24" fill="none">
                                    <circle cx="11" cy="11" r="7" stroke="currentColor" stroke-width="2"/>
                                    <path d="M20 20l-3.5-3.5" stroke="currentColor" stroke-width="2" stroke-linecap="round"/>
                                </svg>
                            </button>
                        </div>
                    </div>

                    
                    
                </div>

                
                <div class="mt-8 flex items-end gap-4">
                    <div class="flex-1 pb-2">
                        <h1 class="text-white text-5xl sm:text-8xl font-extrabold leading-none tracking-tight">
                            Yuk !
                        </h1>
                        <p class="mt-2 text-white/90 text-sm sm:text-lg">
                            Periksakan Kesehatan Anda
                        </p>
                    </div>

                    <img
                        src="<?php echo e(asset('asset/img/mobile/header-home.png')); ?>"
                        alt="Doctors"
                        class="w-48 sm:w-64 drop-shadow-xl"
                        onerror="this.src='https://placehold.co/400x300/png?text=Doctors';"
                    />
                </div>
            </div>

            
            <div class="absolute -bottom-20 -right-28 w-72 h-72 rounded-full bg-white/10"></div>
            <div class="absolute -top-24 -left-24 w-64 h-64 rounded-full bg-white/10"></div>
        </div>

        
        <div class="py-5 px-2 space-y-4">
            
            

            
            

            
            

            
            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($queueRegisters): ?>
                <section class="-mt-2" x-data="queueSlider()" x-init="init()">
                    <div
                        x-ref="track"
                        @scroll.debounce.50ms="syncIndex"
                        class="flex gap-4 overflow-x-auto scroll-smooth snap-x snap-mandatory scrollbar-hide px-1"
                    >
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__currentLoopData = $queueRegisters; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $i => $q): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoopIteration(); ?><?php endif; ?>
                            <div class="min-w-full snap-center" data-slide>
                                <a href="<?php echo e(route('mobile.queue.register.detail', $q['id'])); ?>">
                                    <div class="rounded-[28px] bg-white border border-slate-200 shadow-[0_10px_24px_rgba(15,23,42,0.08)] px-5 py-6">
                                        
                                        <div class="text-center">
                                            <div class="text-black font-extrabold text-[20px] leading-tight">
                                                Nama Pasien
                                            </div>
                                            <div class="mt-1 text-sky-400 font-extrabold text-[21px] sm:text-[24px] leading-tight truncate">
                                                <?php echo e($q['patient_name']); ?>

                                            </div>
                                        </div>

                                        
                                        <div class="mt-6 text-center">
                                            <span class="inline-block text-black font-extrabold text-[18px] sm:text-[20px] leading-tight border-b-[3px] border-sky-500 px-1">
                                                Nomor Antrian Anda
                                            </span>
                                        </div>

                                        
                                        <div class="mt-4 text-center text-sky-400 font-black tracking-tight text-[88px] sm:text-[110px] leading-none">
                                            <?php echo e($q['queue_number']); ?>

                                        </div>

                                        
                                        <div class="mt-7 grid grid-cols-3 gap-2 text-center">
                                            <div>
                                                <div class="text-slate-400 text-sm sm:text-sm leading-tight">
                                                    Jumlah Antrian
                                                </div>
                                                <div class="mt-2 text-sky-400 font-extrabold text-xl sm:text-4xl leading-none">
                                                    <?php echo e($q['total_queue']); ?>

                                                </div>
                                            </div>

                                            <div>
                                                <div class="text-slate-400 text-sm sm:text-sm leading-tight">
                                                    Antrian Dilayani
                                                </div>
                                                <div class="mt-2 text-teal-400 font-extrabold text-xl sm:text-4xl leading-none">
                                                    <?php echo e($q['current_queue']); ?>

                                                </div>
                                            </div>

                                            <div>
                                                <div class="text-slate-400 text-sm sm:text-sm leading-tight">
                                                    Tanggal Periksa
                                                </div>
                                                <div class="mt-2 text-sky-400 font-extrabold text-xl sm:text-4xl leading-none">
                                                    <?php echo e($q['check_date']); ?>

                                                </div>
                                            </div>
                                        </div>

                                        
                                        <div class="mt-8 h-px bg-sky-300"></div>

                                        
                                        
                                    </div>
                                </a>
                            </div>
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
                    </div>

                    
                    <div class="mt-4 flex items-center justify-center gap-2">
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__currentLoopData = $queueRegisters; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $i => $q): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoopIteration(); ?><?php endif; ?>
                            <button
                                type="button"
                                @click="goTo(<?php echo e($i); ?>)"
                                class="h-3 rounded-full transition-all duration-200"
                                :class="index === <?php echo e($i); ?> ? 'w-10 bg-sky-400' : 'w-3 bg-slate-300'"
                                aria-label="Slide <?php echo e($i + 1); ?>"
                            ></button>
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
                    </div>
                </section>
            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

            
            <section class="">
                <div class="flex items-center justify-between">
                    <h2 class="text-lg font-extrabold text-slate-900">Pelayanan</h2>
                    <a href="#" class="text-sm font-semibold text-sky-600">Lihat Semua</a>
                </div>

                <div class="mt-4 overflow-x-auto scrollbar-hide -mx-2 px-2 snap-x snap-mandatory">
                    <div class="flex gap-3 min-w-max">
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__currentLoopData = $polyclinics; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $polyclinic): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoopIteration(); ?><?php endif; ?>
                            <a href="#"
                            class="w-32 shrink-0 snap-start bg-white rounded-2xl shadow-sm border border-slate-100 p-4 text-center">
                                <div class="mx-auto w-full aspect-square rounded-xl bg-slate-50 flex items-center justify-center overflow-hidden">
                                    <img src="<?php echo e($polyclinic['icon']); ?>" class="w-full h-full object-contain" alt="<?php echo e($polyclinic['label']); ?>">
                                </div>
                                <div class="mt-2 text-[11px] font-semibold text-slate-800 leading-tight">
                                    <?php echo e($polyclinic['label']); ?>

                                </div>
                            </a>
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
                    </div>
                </div>
            </section>

            
            <section class="pt-2">
                <div class="flex items-center justify-between">
                    <h2 class="text-lg font-extrabold text-slate-900">Dokter Berpengalaman</h2>
                    <a href="#" class="text-sm font-semibold text-sky-600">Lihat Semua</a>
                </div>

                <div class="mt-4 grid grid-cols-2 md:grid-cols-3 gap-3">
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__currentLoopData = $doctors; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $doctor): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoopIteration(); ?><?php endif; ?>
                        <a href="#" class="bg-white rounded-2xl shadow border border-slate-100 p-4">
                            <div class="rounded-2xl bg-slate-50 overflow-hidden">
                                <img src="<?php echo e($doctor?->profile); ?>" alt="<?php echo e($doctor?->name); ?>" class="w-full h-28 object-contain">
                            </div>

                            <div class="mt-3">
                                <div class="text-sm font-extrabold text-sky-600 truncate"><?php echo e($doctor?->name); ?></div>
                                <div class="text-xs text-slate-500"><?php echo e($doctor?->typeDoctor); ?></div>
                            </div>
                        </a>
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
                </div>
            </section>

            
            <div class="h-6"></div>
        </div>
    </div>
</div>
<?php $__env->startPush('scripts'); ?>
<script>
    function queueSlider() {
        return {
            index: 0,

            init() {
                this.$nextTick(() => {
                    this.syncIndex();
                    window.addEventListener('resize', () => this.goTo(this.index, false));
                });
            },

            goTo(i, smooth = true) {
                const track = this.$refs.track;
                if (!track) return;

                const slides = track.querySelectorAll('[data-slide]');
                if (!slides.length) return;

                if (i < 0) i = 0;
                if (i > slides.length - 1) i = slides.length - 1;

                this.index = i;

                const left = slides[i].offsetLeft - track.offsetLeft;

                track.scrollTo({
                    left,
                    behavior: smooth ? 'smooth' : 'auto'
                });
            },

            syncIndex() {
                const track = this.$refs.track;
                if (!track) return;

                const slides = [...track.querySelectorAll('[data-slide]')];
                if (!slides.length) return;

                const center = track.scrollLeft + (track.clientWidth / 2);

                let closestIndex = 0;
                let minDistance = Infinity;

                slides.forEach((slide, i) => {
                    const slideCenter = slide.offsetLeft + (slide.clientWidth / 2);
                    const distance = Math.abs(center - slideCenter);

                    if (distance < minDistance) {
                        minDistance = distance;
                        closestIndex = i;
                    }
                });

                this.index = closestIndex;
            }
        }
    }
</script>
<?php $__env->stopPush(); ?><?php /**PATH /Users/macbookair/Documents/mediction/mediction.id/resources/views/livewire/mobile/home/home-index.blade.php ENDPATH**/ ?>