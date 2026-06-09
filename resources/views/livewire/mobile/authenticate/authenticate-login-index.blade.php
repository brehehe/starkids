<div>
    {{-- Success is as dangerous as failure. --}}
    {{-- <div class="w-full h-12 bg-sky-400"></div> --}}
    {{-- Karena layout mobile punya padding container, kita "full-bleed" --}}
    <div class=" min-h-dvh relative overflow-hidden">
        {{-- BACKGROUND BLUE --}}
        <div class="absolute inset-0 bg-gradient-to-b from-sky-400 via-sky-500 to-sky-600"></div>

        {{-- Watermark shapes (mirip mockup) --}}
        <div class="absolute top-0 -right-40 w-[40rem] h-[40rem] rounded-full">
            <img src="{{ asset('asset/img/mobile/logo-starkids-1.png') }}" alt="{{config('app.name')}}"
                class="mx-auto drop-shadow-md opacity-20" />
        </div>

        {{-- Bottom white curve --}}
        <div class="absolute bottom-0 left-1/2 -translate-x-1/2 w-[140%] h-[38%] bg-slate-100 rounded-t-[60%]"></div>

        {{-- CONTENT --}}
        <div class="relative min-h-dvh flex flex-col items-center">
            {{-- spacer top (status bar / safe area feel) --}}
            <div class="h-10"></div>

            {{-- LOGO AREA --}}
            <div class="px-6 text-center text-white mt-3">
                <img src="{{ asset('asset/img/mobile/logo-starkids-1.png') }}" alt="{{config('app.name')}}"
                    class="mx-auto w-40 sm:w-44 drop-shadow-md" />

                <h1 class="mt-3 text-2xl sm:text-3xl font-extrabold">Selamat Datang !</h1>
                <p class="mt-1 text-sm sm:text-base text-white/90">Masuk untuk lanjut</p>
            </div>

            {{-- FORM CARD --}}
            <div class="mt-6 sm:mt-8 w-full px-6">
                <div class="mx-auto w-full max-w-[400px] bg-white rounded-3xl shadow-2xl p-6 sm:p-8">
                    <h2 class="text-center text-lg sm:text-xl font-extrabold text-slate-900">
                        Masuk Akun
                    </h2>

                    <form wire:submit="login" class="mt-6 space-y-6">
                        {{-- Email --}}
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
                            @error('contect')
                                <p class="mt-2 text-xs text-rose-600">{{ $message }}</p>
                            @enderror
                        </div>

                        {{-- Password --}}
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

                            {{-- eye icon --}}
                            <button type="button" @click="show = !show"
                                class="absolute right-2 top-1/2 -translate-y-1/2 p-2 text-sky-500 hover:text-sky-600"
                                :aria-label="show ? 'Sembunyikan password' : 'Tampilkan password'">
                                {{-- Eye (password hidden) --}}
                                <svg x-show="!show" x-cloak class="w-5 h-5" viewBox="0 0 24 24" fill="none">
                                    <path d="M2 12s3.5-7 10-7 10 7 10 7-3.5 7-10 7S2 12 2 12Z" stroke="currentColor"
                                        stroke-width="2" />
                                    <path d="M12 15a3 3 0 1 0 0-6 3 3 0 0 0 0 6Z" stroke="currentColor"
                                        stroke-width="2" />
                                </svg>

                                {{-- Eye off (password visible) --}}
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

                            @error('password')
                                <p class="mt-2 text-xs text-rose-600">{{ $message }}</p>
                            @enderror
                        </div>

                        {{-- Button --}}
                        <button type="login"
                            class="w-full rounded-full bg-sky-400 hover:bg-sky-500 active:bg-sky-600 text-white font-bold py-3.5 transition shadow-md"
                            wire:loading.attr="disabled" wire:target="login">
                            <span wire:loading.remove wire:target="login">Masuk</span>
                            <span wire:loading wire:target="login">Memproses...</span>
                        </button>

                        {{-- Forgot --}}
                        <div class="text-center">
                            <a href="#" x-on:click="$modalOpen('modal-id')"
                                class="text-sm text-sky-500 hover:text-sky-600">
                                Lupa Password ?
                            </a>
                        </div>
                        {{-- @if (Route::has('password.request'))
                        @else
                        <div class="text-center">
                            <span class="text-sm text-sky-500">Lupa Password ?</span>
                        </div>
                        @endif --}}
                    </form>
                </div>

                {{-- Register small card --}}
                <div class="mx-auto w-full max-w-[400px] mt-5 bg-white rounded-2xl shadow-lg px-5 py-4 text-center">
                    <span class="text-sm text-slate-700">Belum punya akun ?</span>
                    <a href="{{ route('mobile.register') }}"
                        class="text-sm font-semibold text-sky-500 hover:text-sky-600">
                        Daftar Disini
                    </a>
                </div>

                {{-- Footer --}}
                <p class="mx-auto w-full max-w-[420px] mt-10 text-center text-xs text-slate-500">
                    © 2022 {{ config('app.name') }}. All rights reserved.
                </p>

                {{-- <x-button x-on:click="$modalOpen('modal-id')">
                    Open
                </x-button> --}}

            </div>
        </div>
    </div>
    <x-ts-modal id="modal-id" center>
        <form>

        </form>
    </x-ts-modal>
</div>