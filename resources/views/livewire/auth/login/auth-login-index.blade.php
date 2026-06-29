@php
    use App\Models\Company\Company;
    $company = Company::where('code', 'Strkds')->first();
@endphp
<div class="min-h-screen flex items-center justify-center p-4">
    <div class="bg-white/80 backdrop-blur-sm rounded-2xl shadow-2xl w-full max-w-lg p-6 relative overflow-hidden">
        <div class="absolute top-0 left-0 w-full h-1 bg-gradient-to-r from-[#1E3A8A] to-[#C3D4EC]"></div>

        <!-- Logo & Welcome -->
        <div class="flex flex-col items-center mb-6">
            <img src="{{ $company ? ($company->logo ? asset('storage/' . $company->logo) : asset('asset/img/logo.png')) : asset('asset/img/logo-starkids.png') }}"
                alt="Logo {{config('app.name')}}" class="h-12 drop-shadow-md mb-4">
            <h1 class="text-2xl font-bold text-[#1E3A8A]">Selamat Datang Kembali!</h1>
            <p class="text-gray-600 text-sm">Akses dashboard admin Anda dengan aman</p>
        </div>

        <!-- Login Form -->
        <!-- Form Login -->
        <form wire:submit.prevent="login" id="loginForm" class="space-y-4">
            @csrf

            {{-- <div>
                <div class="relative">
                    <input autocomplete="off" type="text" name="code" wire:model='code'
                        class="input-style w-full px-4 py-2.5 border border-gray-200 rounded-xl focus:ring-2 focus:ring-[#1E3A8A]/20 focus:border-[#1E3A8A] transition-all bg-white/50"
                        placeholder="Username or Email">
                    <div class="absolute inset-y-0 right-3 flex items-center text-gray-400">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                        </svg>
                    </div>
                </div>
                @error('code')
                <span class="text-sm text-red-500">{{ $message }}</span>
                @enderror
            </div> --}}

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
                @error('username_or_email')
                    <span class="text-sm text-red-500">{{ $message }}</span>
                @enderror
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
                @error('password')
                    <span class="text-sm text-red-500">{{ $message }}</span>
                @enderror
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
            {{-- <div class="mt-4 text-center">
                <p class="text-sm text-gray-600">
                    Belum punya akun?
                    <a href="{{ route('register') }}" class="text-[#1E3A8A] hover:underline font-semibold">Daftar di
                        sini</a>
                </p>
            </div> --}}
        </form>


        <!-- Footer -->
        <div class="mt-6 text-center text-xs text-gray-500">
            <p>© 2025 {{config('app.name')}}. All rights reserved.</p>
            <p class="mt-0.5">Secure login • Admin Portal</p>
        </div>
    </div>

    {{-- System Updates Popup - Bottom Left --}}
    @if($this->systemUpdates->count() > 0)
        <div x-data="{ expanded: false, show: true }" x-show="show" class="fixed bottom-4 left-4 z-50 max-w-sm">

            {{-- Collapsed State - Notification Badge --}}
            <div x-show="!expanded" @click="expanded = true"
                class="bg-gradient-to-r from-blue-600 to-blue-700 text-white rounded-full shadow-2xl px-5 py-3 cursor-pointer hover:shadow-xl transition-all duration-300 flex items-center gap-3 animate-bounce">
                <div class="relative">
                    <i class="fas fa-bullhorn text-xl"></i>
                    <span
                        class="absolute -top-1 -right-1 bg-red-500 text-white text-xs rounded-full w-5 h-5 flex items-center justify-center font-bold">
                        {{ $this->systemUpdates->count() }}
                    </span>
                </div>
                <span class="font-semibold">Update Sistem</span>
            </div>

            {{-- Expanded State - Updates List --}}
            <div x-show="expanded" x-transition:enter="transition ease-out duration-300"
                x-transition:enter-start="opacity-0 transform scale-95"
                x-transition:enter-end="opacity-100 transform scale-100"
                x-transition:leave="transition ease-in duration-200"
                x-transition:leave-start="opacity-100 transform scale-100"
                x-transition:leave-end="opacity-0 transform scale-95"
                class="bg-white rounded-2xl shadow-2xl overflow-hidden border border-gray-200 w-96">

                {{-- Header --}}
                <div
                    class="bg-gradient-to-r from-blue-600 to-blue-700 text-white px-4 py-3 flex items-center justify-between">
                    <div class="flex items-center gap-2">
                        <i class="fas fa-bullhorn"></i>
                        <h3 class="font-semibold">Update Sistem</h3>
                        <span
                            class="bg-white/20 text-xs px-2 py-0.5 rounded-full">{{ $this->systemUpdates->count() }}</span>
                    </div>
                    <button @click="expanded = false" class="hover:bg-white/10 rounded-full p-1 transition-colors">
                        <i class="fas fa-times"></i>
                    </button>
                </div>

                {{-- Updates List --}}
                <div class="max-h-96 overflow-y-auto p-4 space-y-3">
                    @foreach($this->systemUpdates as $update)
                        <div
                            class="bg-{{ $update->typeColor }}-50 border border-{{ $update->typeColor }}-200 rounded-lg p-3 hover:shadow-md transition-shadow">
                            <div class="flex items-start gap-2">
                                <i class="fas {{ $update->typeIcon }} text-{{ $update->typeColor }}-600 mt-0.5"></i>
                                <div class="flex-1">
                                    <h4 class="font-semibold text-{{ $update->typeColor }}-900 text-sm">{{ $update->title }}
                                    </h4>
                                    <p class="text-{{ $update->typeColor }}-700 text-xs mt-1 leading-relaxed">
                                        {{ $update->content }}</p>
                                    <p class="text-{{ $update->typeColor }}-600 text-xs mt-2 flex items-center gap-1">
                                        <i class="far fa-clock"></i>
                                        {{ $update->published_at->locale('id')->diffForHumans() }}
                                    </p>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>

                {{-- Footer --}}
                <div class="bg-gray-50 px-4 py-2 text-center">
                    <button @click="show = false" class="text-xs text-gray-600 hover:text-gray-800">
                        <i class="fas fa-times-circle mr-1"></i>
                        Tutup Notifikasi
                    </button>
                </div>
            </div>
        </div>
    @endif
</div>