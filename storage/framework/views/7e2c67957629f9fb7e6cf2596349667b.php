<?php
    use App\Models\Company\Company;
    $company = Company::where('code', 'Strkds')->first();
?>
<div class="min-h-screen flex items-center justify-center p-4">
    <div class="bg-white/80 backdrop-blur-sm rounded-2xl shadow-2xl w-full max-w-lg p-6 relative overflow-hidden">
        <div class="absolute top-0 left-0 w-full h-1 bg-gradient-to-r from-[#1E3A8A] to-[#C3D4EC]"></div>

        <!-- Logo & Welcome -->
        <div class="flex flex-col items-center mb-6">
            <img src="<?php echo e($company ? ($company->logo ? asset('storage/' . $company->logo) : asset('asset/img/logo.png')) : asset('asset/img/logo-starkids.png')); ?>"
                alt="Logo <?php echo e(config('app.name')); ?>" class="h-12 drop-shadow-md mb-4">
            <h1 class="text-2xl font-bold text-[#1E3A8A]">Selamat Datang Kembali!</h1>
            <p class="text-gray-600 text-sm">Akses dashboard admin Anda dengan aman</p>
        </div>

        <!-- Login Form -->
        <!-- Form Login -->
        <form wire:submit.prevent="login" id="loginForm" class="space-y-4">
            <?php echo csrf_field(); ?>

            

            <!-- Email -->
            <div>
                <div class="relative">
                    <input autocomplete="off" type="text" name="username_or_email" wire:model='username_or_email'
                        class="input-style w-full px-4 py-2.5 border border-gray-200 rounded-xl focus:ring-2 focus:ring-[#1E3A8A]/20 focus:border-[#1E3A8A] transition-all bg-white/50"
                        placeholder="Username or Email">
                    <div class="absolute inset-y-0 right-3 flex items-center text-gray-400">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                        </svg>
                    </div>
                </div>
                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__errorArgs = ['username_or_email'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                    <span class="text-sm text-red-500"><?php echo e($message); ?></span>
                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
            </div>

            <!-- Password dengan Toggle -->
            <div x-data="{ showPassword: false }">
                <div class="relative">
                    <input :type="showPassword ? 'text' : 'password'" name="password" wire:model="password"
                        class="input-style w-full px-4 py-2.5 border border-gray-200 rounded-xl focus:ring-2 focus:ring-[#1E3A8A]/20 focus:border-[#1E3A8A] transition-all bg-white/50"
                        placeholder="kata sandi">
                    <button type="button" @click="showPassword = !showPassword"
                        class="absolute inset-y-0 right-3 flex items-center text-gray-400 hover:text-gray-600 focus:outline-none transition-colors duration-200">
                        <svg class="w-5 h-5 eye-icon-show"
                            :class="{ 'visible-password': showPassword, 'hidden-password': !showPassword }" fill="none"
                            stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                            <path class="eye-line" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M3 3l18 18" :style="showPassword ? 'opacity: 0' : 'opacity: 1'" />
                        </svg>
                    </button>
                </div>
                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__errorArgs = ['password'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                    <span class="text-sm text-red-500"><?php echo e($message); ?></span>
                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
            </div>

            <div>
                <div class="flex gap-3">
                    <input autocomplete="off" type="text" name="captcha" wire:model='captchaInput'
                        class="input-style flex-1 px-4 py-2.5 border border-gray-200 rounded-xl focus:ring-2 focus:ring-[#1E3A8A]/20 focus:border-[#1E3A8A] transition-all bg-white/50"
                        placeholder="Captcha">
                    <div class="flex items-center px-3 py-2 border border-[#1E3A8A]/30 rounded-xl bg-white shadow-sm"
                        wire:ignore>
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__currentLoopData = str_split($captchaCode); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $char): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoopIteration(); ?><?php endif; ?>
                            <?php
                                $randomColor =
                                    '#' .
                                    str_pad(dechex(rand(0, 255)), 2, '0', STR_PAD_LEFT) .
                                    str_pad(dechex(rand(0, 255)), 2, '0', STR_PAD_LEFT) .
                                    str_pad(dechex(rand(0, 255)), 2, '0', STR_PAD_LEFT);
                            ?>
                            <span class="font-bold tracking-wider select-none" style="color: <?php echo e($randomColor); ?>;"
                                oncontextmenu="return false" onselectstart="return false"><?php echo e($char); ?></span>
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
                    </div>
                </div>
                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__errorArgs = ['captchaInput'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                    <span class="text-sm text-red-500"><?php echo e($message); ?></span>
                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
            </div>

            <!-- Ingat Saya -->
            <div class="flex items-center justify-between">
                <label class="flex items-center">
                    <input autocomplete="off" type="checkbox" name="remember"
                        class="rounded border-gray-300 text-[#1E3A8A] focus:ring-[#1E3A8A]/20" wire:model='remember'>
                    <span class="ml-2 text-sm text-gray-600">Ingat saya</span>
                </label>
                <a href="#" class="text-sm text-[#1E3A8A] hover:text-[#2563EB] transition-colors">Lupa kata
                    sandi?</a>
            </div>

            <!-- Tombol Login -->
            <button type="submit"
                class="w-full bg-gradient-to-r from-[#1E3A8A] to-[#2563EB] hover:from-[#1E3A8A] hover:to-[#1E3A8A] text-white font-semibold py-2.5 px-4 rounded-xl transition-all duration-300 shadow-lg hover:shadow-xl mt-2 cursor-pointer">
                Masuk
            </button>

            <!-- Tombol ke Register -->
            
        </form>


        <!-- Footer -->
        <div class="mt-6 text-center text-xs text-gray-500">
            <p>© 2025 <?php echo e(config('app.name')); ?>. All rights reserved.</p>
            <p class="mt-0.5">Secure login • Admin Portal</p>
        </div>
    </div>
</div><?php /**PATH /Users/macbookair/Documents/mediction/mediction.id/resources/views/livewire/auth/login/auth-login-index-old.blade.php ENDPATH**/ ?>