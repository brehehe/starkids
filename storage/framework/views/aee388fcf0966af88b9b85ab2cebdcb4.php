<?php
    use App\Models\Company\Company;
    $company = Company::where('code', 'Strkds')->first();
?>
<div class="min-h-screen flex flex-col md:flex-row bg-white font-['Inter'] overflow-hidden">
    <!-- Left Side: Visual Experience (Desktop Only) -->
    <div class="relative hidden md:block md:w-1/2 lg:w-[60%] h-screen overflow-hidden">
        <img src="<?php echo e(asset('asset/img/auth/login_bg.png')); ?>" alt="Hospital"
            class="absolute inset-0 w-full h-full object-cover scale-105 animate-subtle-zoom">
        <div class="absolute inset-0 bg-gradient-to-tr from-blue-900/90 via-blue-900/50 to-transparent"></div>

        <div class="absolute inset-0 flex flex-col justify-between p-12 lg:p-16 text-white">
            <div class="flex items-center gap-4 animate-fade-in-down">
                <div class="p-3 bg-white rounded-2xl shadow-xl flex items-center justify-center min-w-[60px] h-14">
                    <img src="<?php echo e($company ? ($company->logo ? asset('storage/' . $company->logo) : asset('asset/img/logo.png')) : asset('asset/img/logo-starkids.png')); ?>z"
                        alt="Logo" class="h-10 w-auto object-contain">
                </div>
            </div>

            <div class="max-w-md animate-fade-in-up">
                <h1 class="text-5xl lg:text-7xl font-black leading-tight tracking-tighter">
                    Selamat <br>
                    <span class="text-blue-400">Datang.</span>
                </h1>
                <div class="mt-6 flex items-center gap-4">
                    <div class="h-[2px] w-12 bg-blue-500"></div>
                    <p class="text-lg font-medium text-blue-100/80 tracking-wide uppercase">
                        Healthcare Management System
                    </p>
                </div>
            </div>
        </div>
    </div>

    <!-- Right Side: Interaction -->
    <div
        class="w-full md:w-1/2 lg:w-[40%] min-h-screen flex flex-col justify-center px-6 sm:px-12 lg:px-16 py-12 bg-white relative">
        <!-- Background Decorations -->
        <div class="absolute top-0 right-0 p-8 opacity-20 pointer-events-none">
            <svg width="120" height="120" viewBox="0 0 120 120" fill="none" xmlns="http://www.w3.org/2000/svg">
                <circle cx="60" cy="60" r="58" stroke="currentColor" stroke-width="4" stroke-dasharray="10 10"
                    class="text-blue-100" />
            </svg>
        </div>

        <div class="max-w-md w-full mx-auto relative z-10">
            <!-- Branding & Welcome -->
            <div class="mb-10 text-center md:text-left">
                <div class="inline-flex items-center justify-center p-2 bg-blue-50 rounded-2xl mb-6 md:hidden">
                    <img src="<?php echo e($company ? ($company->logo ? asset('storage/' . $company->logo) : asset('asset/img/logo.png')) : asset('asset/img/logo-starkids.png')); ?>z"
                        alt="Logo" class="h-12 w-auto">
                </div>

                <h2 class="text-3xl font-black text-slate-900 mb-3 tracking-tight">
                    Selamat Datang <span class="text-blue-600 italic">Kembali!</span>
                </h2>
                <p class="text-slate-500 font-medium leading-relaxed">
                    Masuk ke dashboard medis Anda untuk memantau aktivitas dan kesehatan pasien hari ini.
                </p>
            </div>

            <form wire:submit.prevent="login" class="space-y-6">
                <!-- Username/Email -->
                <div class="space-y-2">
                    <label for="username_or_email"
                        class="text-xs font-black text-slate-400 uppercase tracking-[0.2em] ml-1">Kredensial
                        Akses</label>
                    <div class="relative group">
                        <div
                            class="absolute inset-y-0 left-0 pl-6 flex items-center pointer-events-none text-slate-400 group-focus-within:text-blue-600 transition-colors">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24"
                                stroke="currentColor" stroke-width="2.5">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                            </svg>
                        </div>
                        <input wire:model="username_or_email" autofocus type="text" id="username_or_email"
                            class="block w-full pl-16 pr-4 py-3 bg-slate-50 border-2 border-transparent ring-1 ring-slate-100 rounded-[28px] text-slate-900 font-medium placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-blue-600/20 focus:border-blue-600 focus:bg-white transition-all shadow-sm group-hover:bg-white group-hover:ring-slate-200"
                            placeholder="Username atau Email">
                    </div>
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__errorArgs = ['username_or_email'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <span
                            class="text-[10px] font-black text-red-500 uppercase tracking-widest ml-4 mt-1 flex items-center gap-1">
                            <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd"
                                    d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z"
                                    clip-rule="evenodd"></path>
                            </svg>
                            <?php echo e($message); ?>

                        </span>
                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                </div>

                <!-- Password -->
                <div class="space-y-2">
                    <div class="flex justify-between items-center px-1">
                        <label for="password" class="text-xs font-black text-slate-400 uppercase tracking-[0.2em]">Kata
                            Sandi</label>
                        <a href="#"
                            class="text-xs font-bold text-blue-600 hover:text-blue-700 hover:underline decoration-2 underline-offset-4 transition-all">Lupa
                            Password?</a>
                    </div>
                    <div class="relative group" x-data="{ show: false }">
                        <div
                            class="absolute inset-y-0 left-0 pl-6 flex items-center pointer-events-none text-slate-400 group-focus-within:text-blue-600 transition-colors">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24"
                                stroke="currentColor" stroke-width="2.5">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                            </svg>
                        </div>
                        <input wire:model="password" :type="show ? 'text' : 'password'" id="password"
                            class="block w-full pl-16 pr-14 py-3 bg-slate-50 border-2 border-transparent ring-1 ring-slate-100 rounded-[28px] text-slate-900 font-medium placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-blue-600/20 focus:border-blue-600 focus:bg-white transition-all shadow-sm group-hover:bg-white group-hover:ring-slate-200"
                            placeholder="••••••••">
                        <button type="button" @click="show = !show"
                            class="absolute inset-y-0 right-0 pr-6 flex items-center text-slate-400 hover:text-blue-600 transition-colors">
                            <template x-if="!show">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24"
                                    stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                </svg>
                            </template>
                            <template x-if="show">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24"
                                    stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.542-7a10.024 10.024 0 014.132-5.411m0 0L21 21m-2.102-2.102L15.807 15.807M17.942 12c.115.392.178.805.178 1.227 0 2.441-1.979 4.42-4.42 4.42-.422 0-.835-.063-1.227-.178m5.655-5.655l-2.039-2.039M15 12a3 3 0 11-6 0 3 3 0 016 0zm-6 0c0-.422.063-.835.178-1.227M12 5c4.478 0 8.268 2.943 9.542 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21" />
                                </svg>
                            </template>
                        </button>
                    </div>
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__errorArgs = ['password'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <span
                            class="text-[10px] font-black text-red-500 uppercase tracking-widest ml-4 mt-1 flex items-center gap-1">
                            <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd"
                                    d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z"
                                    clip-rule="evenodd"></path>
                            </svg>
                            <?php echo e($message); ?>

                        </span>
                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                </div>

                <!-- Remember Me & Extra Action -->
                <div class="flex items-center justify-between px-1">
                    <label class="relative flex items-center cursor-pointer group">
                        <input type="checkbox" wire:model="remember" class="sr-only peer">
                        <div
                            class="w-12 h-6 bg-slate-200 peer-focus:outline-none rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-slate-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-blue-600 shadow-inner">
                        </div>
                        <span
                            class="ml-3 text-sm font-bold text-slate-500 group-hover:text-slate-800 transition-colors">Ingat
                            Sesi Saya</span>
                    </label>
                </div>

                <!-- Submit Button -->
                <div class="pt-2">
                    <button type="submit" wire:loading.attr="disabled"
                        class="group relative w-full h-12 bg-blue-600 hover:bg-blue-700 text-white font-black rounded-[28px] shadow-[0_20px_40px_rgba(37,99,235,0.25)] active:scale-[0.98] transition-all overflow-hidden">
                        <div
                            class="absolute inset-0 w-full h-full bg-gradient-to-r from-blue-400/20 to-transparent transform -translate-x-full group-hover:translate-x-full transition-transform duration-1000">
                        </div>
                        <div class="relative flex items-center justify-center gap-3">
                            <span wire:loading.remove wire:target="login"
                                class="uppercase tracking-[0.2em] text-sm">Masuk Sekarang</span>
                            <span wire:loading wire:target="login">
                                <svg class="animate-spin h-6 w-6 text-white" xmlns="http://www.w3.org/2000/svg"
                                    fill="none" viewBox="0 0 24 24">
                                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor"
                                        stroke-width="4"></circle>
                                    <path class="opacity-75" fill="currentColor"
                                        d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z">
                                    </path>
                                </svg>
                            </span>
                            <svg wire:loading.remove wire:target="login" xmlns="http://www.w3.org/2000/svg"
                                class="h-5 w-5 transform group-hover:translate-x-1.5 transition-transform" fill="none"
                                viewBox="0 0 24 24" stroke="currentColor" stroke-width="3">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M14 5l7 7m0 0l-7 7m7-7H3" />
                            </svg>
                        </div>
                    </button>
                </div>
            </form>

            <!-- Divider -->
            <div class="my-10 flex items-center gap-4">
                <div class="h-[1px] grow bg-slate-100"></div>
                <span class="text-[10px] font-black text-slate-300 uppercase tracking-widest">Bantuan & Keamanan</span>
                <div class="h-[1px] grow bg-slate-100"></div>
            </div>

            <!-- Help Section -->
            <div class="grid grid-cols-2 gap-4">
                <a href="#"
                    class="flex items-center gap-3 p-4 bg-slate-50 rounded-2xl border border-transparent hover:border-blue-100 hover:bg-white transition-all group">
                    <div
                        class="p-2 bg-white rounded-xl shadow-sm text-blue-600 group-hover:bg-blue-600 group-hover:text-white transition-colors">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M18.364 5.636l-3.536 3.536m0 5.656l3.536 3.536M9.172 9.172L5.636 5.636m3.536 9.192l-3.536 3.536M21 12a9 9 0 11-18 0 9 9 0 0118 0zm-5 0a4 4 0 11-8 0 4 4 0 018 0z" />
                        </svg>
                    </div>
                    <span class="text-xs font-bold text-slate-600">Support</span>
                </a>
                <a href="#"
                    class="flex items-center gap-3 p-4 bg-slate-50 rounded-2xl border border-transparent hover:border-blue-100 hover:bg-white transition-all group">
                    <div
                        class="p-2 bg-white rounded-xl shadow-sm text-blue-600 group-hover:bg-blue-600 group-hover:text-white transition-colors">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                    <span class="text-xs font-bold text-slate-600">Panduan</span>
                </a>
            </div>

            <!-- Footer Navigation -->
            <div class="mt-12 text-center">
                <p class="text-[10px] font-bold text-slate-300 uppercase tracking-[0.3em] mb-4">
                    © 2025 <span class="text-slate-400"><?php echo e(config('app.name')); ?></span> • v2.0
                </p>
            </div>
        </div>
    </div>
</div>

<style>
    @keyframes subtle-zoom {
        0% {
            transform: scale(1.05);
        }

        50% {
            transform: scale(1.1);
        }

        100% {
            transform: scale(1.05);
        }
    }

    @keyframes fade-in-down {
        from {
            opacity: 0;
            transform: translateY(-30px);
        }

        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    @keyframes fade-in-up {
        from {
            opacity: 0;
            transform: translateY(30px);
        }

        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    .animate-subtle-zoom {
        animation: subtle-zoom 20s infinite ease-in-out;
    }

    .animate-fade-in-down {
        animation: fade-in-down 1s cubic-bezier(0.16, 1, 0.3, 1) both;
    }

    .animate-fade-in-up {
        animation: fade-in-up 1s cubic-bezier(0.16, 1, 0.3, 1) 0.3s both;
    }

    body {
        /* overflow: hidden; */
    }
</style><?php /**PATH /Users/macbookair/Documents/mediction/mediction.id/resources/views/livewire/auth/new-login/auth-new-login-index.blade.php ENDPATH**/ ?>