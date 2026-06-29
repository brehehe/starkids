<div>
    
    
    
    <div class=" min-h-dvh relative overflow-hidden">
        
        <div class="absolute inset-0 bg-gradient-to-b from-sky-400 via-sky-500 to-sky-600"></div>

        
        <div class="absolute top-0 -right-40 w-[40rem] h-[40rem] rounded-full">
            <img src="<?php echo e(asset('asset/img/mobile/logo-starkids-1.png')); ?>" alt="<?php echo e(config('app.name')); ?>"
                class="mx-auto drop-shadow-md opacity-20" />
        </div>

        
        <div class="absolute bottom-0 left-1/2 -translate-x-1/2 w-[140%] h-[38%] bg-slate-100 rounded-t-[60%]"></div>

        
        <div class="relative min-h-dvh flex flex-col items-center">
            
            <div class="h-10"></div>

            
            <div class="px-6 text-center text-white mt-3">
                <img src="<?php echo e(asset('asset/img/mobile/logo-starkids-1.png')); ?>" alt="<?php echo e(config('app.name')); ?>"
                    class="mx-auto w-40 sm:w-44 drop-shadow-md" />

                <h1 class="mt-3 text-2xl sm:text-3xl font-extrabold">Selamat Datang !</h1>
                <p class="mt-1 text-sm sm:text-base text-white/90">Masuk untuk lanjut</p>
            </div>

            
            <div class="mt-6 sm:mt-8 w-full px-6">
                <div class="mx-auto w-full max-w-[400px] bg-white rounded-3xl shadow-2xl p-6 sm:p-8">
                    <h2 class="text-center text-lg sm:text-xl font-extrabold text-slate-900">
                        Masuk Akun
                    </h2>

                    <form wire:submit="login" class="mt-6 space-y-6">
                        
                        <div>
                            <label class="sr-only" for="contect">Email atau No. RM</label>
                            <input id="contect" type="contect" wire:model.defer="contect"
                                placeholder="Email atau No. RM" autocomplete="contect" class="w-full rounded-2xl bg-white px-4 py-3 text-slate-900
                                        border border-slate-200
                                        placeholder:text-slate-400
                                        transition duration-200
                                        focus:placeholder-transparent
                                        focus:outline-none focus-visible:outline-none
                                        focus:ring-4 focus:ring-sky-500/20
                                        focus:border-slate-200" />
                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__errorArgs = ['contect'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                <p class="mt-2 text-xs text-rose-600"><?php echo e($message); ?></p>
                            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                        </div>

                        
                        <div x-data="{ show:false }" class="relative">
                            <label class="sr-only" for="password">Password</label>
                            <input id="password" :type="show ? 'text' : 'password'" wire:model.defer="password"
                                placeholder="Password" autocomplete="current-password" class="w-full rounded-2xl bg-white px-4 py-3 pr-12 text-slate-900
                                        border border-slate-200
                                        placeholder:text-slate-400
                                        transition duration-200
                                        focus:placeholder-transparent
                                        focus:outline-none focus-visible:outline-none
                                        focus:ring-4 focus:ring-sky-500/20
                                        focus:border-slate-200" />

                            
                            <button type="button" @click="show = !show"
                                class="absolute right-2 top-1/2 -translate-y-1/2 p-2 text-sky-500 hover:text-sky-600"
                                :aria-label="show ? 'Sembunyikan password' : 'Tampilkan password'">
                                
                                <svg x-show="!show" x-cloak class="w-5 h-5" viewBox="0 0 24 24" fill="none">
                                    <path d="M2 12s3.5-7 10-7 10 7 10 7-3.5 7-10 7S2 12 2 12Z" stroke="currentColor"
                                        stroke-width="2" />
                                    <path d="M12 15a3 3 0 1 0 0-6 3 3 0 0 0 0 6Z" stroke="currentColor"
                                        stroke-width="2" />
                                </svg>

                                
                                <svg x-show="show" x-cloak class="w-5 h-5" viewBox="0 0 24 24" fill="none">
                                    <path d="M3 3l18 18" stroke="currentColor" stroke-width="2"
                                        stroke-linecap="round" />
                                    <path d="M10.6 10.6a3 3 0 0 0 4.24 4.24" stroke="currentColor" stroke-width="2"
                                        stroke-linecap="round" />
                                    <path
                                        d="M9.88 5.08A10.1 10.1 0 0 1 12 4.8c6.5 0 10 7.2 10 7.2a18.3 18.3 0 0 1-4.1 5.3"
                                        stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                        stroke-linejoin="round" />
                                    <path d="M6.1 6.1C3.4 8.2 2 12 2 12s3.5 7.2 10 7.2c1.4 0 2.7-.3 3.9-.8"
                                        stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                        stroke-linejoin="round" />
                                </svg>
                            </button>

                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__errorArgs = ['password'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                <p class="mt-2 text-xs text-rose-600"><?php echo e($message); ?></p>
                            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                        </div>

                        
                        <button type="login"
                            class="w-full rounded-full bg-sky-400 hover:bg-sky-500 active:bg-sky-600 text-white font-bold py-3.5 transition shadow-md"
                            wire:loading.attr="disabled" wire:target="login">
                            <span wire:loading.remove wire:target="login">Masuk</span>
                            <span wire:loading wire:target="login">Memproses...</span>
                        </button>

                        
                        <div class="text-center">
                            <a href="#" x-on:click="$modalOpen('modal-id')"
                                class="text-sm text-sky-500 hover:text-sky-600">
                                Lupa Password ?
                            </a>
                        </div>
                        
                    </form>
                </div>

                
                <div class="mx-auto w-full max-w-[400px] mt-5 bg-white rounded-2xl shadow-lg px-5 py-4 text-center">
                    <span class="text-sm text-slate-700">Belum punya akun ?</span>
                    <a href="<?php echo e(route('mobile.register')); ?>"
                        class="text-sm font-semibold text-sky-500 hover:text-sky-600">
                        Daftar Disini
                    </a>
                </div>

                
                <p class="mx-auto w-full max-w-[420px] mt-10 text-center text-xs text-slate-500">
                    © 2022 <?php echo e(config('app.name')); ?>. All rights reserved.
                </p>

                

            </div>
        </div>
    </div>
    <?php if (isset($component)) { $__componentOriginal93360b397272e82c601608cfc5cba0d9 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal93360b397272e82c601608cfc5cba0d9 = $attributes; } ?>
<?php $component = TallStackUi\View\Components\Modal::resolve(['id' => 'modal-id','center' => true] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('ts-modal'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\TallStackUi\View\Components\Modal::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
<?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::processComponentKey($component); ?>

        <form>

        </form>
     <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal93360b397272e82c601608cfc5cba0d9)): ?>
<?php $attributes = $__attributesOriginal93360b397272e82c601608cfc5cba0d9; ?>
<?php unset($__attributesOriginal93360b397272e82c601608cfc5cba0d9); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal93360b397272e82c601608cfc5cba0d9)): ?>
<?php $component = $__componentOriginal93360b397272e82c601608cfc5cba0d9; ?>
<?php unset($__componentOriginal93360b397272e82c601608cfc5cba0d9); ?>
<?php endif; ?>
</div><?php /**PATH /Users/macbookair/Documents/mediction/mediction.id/resources/views/livewire/mobile/authenticate/authenticate-login-index.blade.php ENDPATH**/ ?>