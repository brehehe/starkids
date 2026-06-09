<!doctype html>
<html lang="id">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, viewport-fit=cover">

        <title>{{ $title ?? config('app.name') }}</title>
        <style>
            /* Hide scrollbar but keep scroll */
                * {
                -ms-overflow-style: none;  /* IE/Edge lama */
                scrollbar-width: none;     /* Firefox */
                }

                *::-webkit-scrollbar {
                display: none;             /* Chrome/Safari */
                }
        </style>

        @stack('styles')
        @vite(['resources/css/app.css', 'resources/js/app.js'])
        @livewireStyles
    </head>

    @php
        // default config layout
        $showHeader = $showHeader ?? true;
        $showBottom = $showBottom ?? false;

        // container width responsif (hp -> tablet)
        $containerClass = $containerClass ?? 'max-w-[430px] sm:max-w-[640px] md:max-w-[770px]';

        // background global (bisa override dari component)
        $bodyClass = $bodyClass ?? 'bg-slate-100';

        // ✅ biar tidak undefined
        $activeTab = $activeTab ?? 'home';

        // ✅ helper safe route (kalau route belum ada -> '#')
        $safeRoute = function (string $name) {
            return \Illuminate\Support\Facades\Route::has($name) ? route($name) : '#';
        };
    @endphp

    <body class="min-h-dvh {{ $bodyClass }}">
        <div class="min-h-dvh flex flex-col">

            {{-- SAFE AREA TOP --}}
            <div class="pt-[max(env(safe-area-inset-top),0px)]"></div>

            {{-- TOPBAR --}}
            @if($showHeader)
                <header class="sticky top-0 z-40 bg-white/90 backdrop-blur border-b border-slate-200">
                    <div class="mx-auto w-full {{ $containerClass }}">
                        <div class="h-14 flex items-center gap-3 px-4 sm:px-6">
                            {{-- left action slot --}}
                            <div class="w-10 flex items-center justify-start">
                                @stack('mobile_header_left')
                            </div>

                            {{-- title --}}
                            <div class="flex-1 text-center">
                                <div class="text-base sm:text-lg font-semibold text-slate-900 truncate">
                                    {{ $title ?? '' }}
                                </div>
                            </div>

                            {{-- right action slot --}}
                            <div class="w-10 flex items-center justify-end">
                                @stack('mobile_header_right')
                            </div>
                        </div>
                    </div>
                </header>
            @endif

            {{-- MAIN CONTENT --}}
            {{-- <main class="flex-1 {{ $showBottom ? 'has-bottom-nav' : '' }}">
                <div class="mx-auto w-full {{ $containerClass }}">
                    {{ $slot }}
                </div>
            </main> --}}
            <main class="flex-1 min-h-0 {{ $showBottom ? 'has-bottom-nav' : '' }}">
                <div class="mx-auto w-full h-full min-h-0 {{ $containerClass }}">
                    {{ $slot }}
                </div>
            </main>

            {{-- BOTTOM NAV --}}
            @if($showBottom)
                <footer class="fixed left-0 right-0 bottom-0 z-[40] pb-[max(env(safe-area-inset-bottom),0.5rem)]">
                    <div class="px-2 sm:px-6">
                        {{-- nav max width biar tetap “mobile look” di tablet --}}
                        <div class="mx-auto w-full max-w-[520px] relative">

                            {{-- alas bulat di belakang tombol tengah --}}
                            <div class="absolute left-1/2 -translate-x-1/2 -top-7 w-[74px] h-[74px]
                                        rounded-full bg-white shadow-[0_-10px_30px_rgba(15,23,42,0.14)]
                                        border border-slate-100"></div>

                            {{-- bar pill --}}
                            <nav class="relative h-16 bg-white rounded-[28px]
                                        shadow-[0_-10px_30px_rgba(15,23,42,0.12)]
                                        border border-slate-100">
                                <div class="grid grid-cols-5 h-full items-center px-3">
                                    {{-- Home --}}
                                    <a href="{{ route('mobile.home') }}" class="flex flex-col items-center justify-center gap-0.5">
                                        <div class="{{ $activeTab === 'home' ? 'text-sky-500' : 'text-slate-300' }}">
                                            <svg class="w-6 h-6" viewBox="0 0 24 24" fill="none">
                                                <path d="M4 10.5l8-7 8 7V20a1 1 0 0 1-1 1h-5v-7H10v7H5a1 1 0 0 1-1-1v-9.5Z"
                                                    stroke="currentColor" stroke-width="2" stroke-linejoin="round"/>
                                            </svg>
                                        </div>
                                        <span class="text-[11px] font-semibold {{ $activeTab === 'home' ? 'text-sky-500' : 'text-slate-300' }}">
                                            Beranda
                                        </span>
                                    </a>

                                    {{-- RM --}}
                                    <a href="#" class="flex flex-col items-center justify-center gap-0.5">
                                        <div class="{{ $activeTab === 'rm' ? 'text-sky-500' : 'text-slate-100' }}">
                                            <svg class="w-6 h-6" viewBox="0 0 24 24" fill="none">
                                                <path d="M7 3h7l3 3v15a1 1 0 0 1-1 1H7a1 1 0 0 1-1-1V4a1 1 0 0 1 1-1Z"
                                                    stroke="currentColor" stroke-width="2" stroke-linejoin="round"/>
                                                <path d="M14 3v4h4" stroke="currentColor" stroke-width="2" stroke-linejoin="round"/>
                                                <path d="M8.5 12h6" stroke="currentColor" stroke-width="2" stroke-linecap="round"/>
                                                <path d="M8.5 15h6" stroke="currentColor" stroke-width="2" stroke-linecap="round"/>
                                            </svg>
                                        </div>
                                        <span class="text-[11px] font-semibold {{ $activeTab === 'rm' ? 'text-sky-500' : 'text-slate-100' }}">
                                            Cek RM
                                        </span>
                                    </a>

                                    {{-- spacer --}}
                                    <div></div>

                                    {{-- Artikel --}}
                                    <a href="#" class="flex flex-col items-center justify-center gap-0.5">
                                        <div class="{{ $activeTab === 'artikel' ? 'text-sky-500' : 'text-slate-100' }}">
                                            <svg class="w-6 h-6" viewBox="0 0 24 24" fill="none">
                                                <path d="M6 4h12a1 1 0 0 1 1 1v14a1 1 0 0 1-1 1H6a1 1 0 0 1-1-1V5a1 1 0 0 1 1-1Z"
                                                    stroke="currentColor" stroke-width="2"/>
                                                <path d="M8 8h8" stroke="currentColor" stroke-width="2" stroke-linecap="round"/>
                                                <path d="M8 12h8" stroke="currentColor" stroke-width="2" stroke-linecap="round"/>
                                                <path d="M8 16h5" stroke="currentColor" stroke-width="2" stroke-linecap="round"/>
                                            </svg>
                                        </div>
                                        <span class="text-[11px] font-semibold {{ $activeTab === 'artikel' ? 'text-sky-500' : 'text-slate-100' }}">
                                            Artikel
                                        </span>
                                    </a>

                                    {{-- Profil --}}
                                    <a href="{{ route('mobile.profile') }}" class="flex flex-col items-center justify-center gap-0.5">
                                        <div class="{{ $activeTab === 'profile' ? 'text-sky-500' : 'text-slate-300' }}">
                                            <svg class="w-6 h-6" viewBox="0 0 24 24" fill="none">
                                                <path d="M20 21a8 8 0 0 0-16 0" stroke="currentColor" stroke-width="2" stroke-linecap="round"/>
                                                <path d="M12 12a4 4 0 1 0-4-4 4 4 0 0 0 4 4Z"
                                                    stroke="currentColor" stroke-width="2"/>
                                            </svg>
                                        </div>
                                        <span class="text-[11px] font-semibold {{ $activeTab === 'profile' ? 'text-sky-500' : 'text-slate-300' }}">
                                            Profil
                                        </span>
                                    </a>
                                </div>
                            </nav>

                            {{-- tombol tengah --}}
                            <a href="{{ route('mobile.queue.register') }}"
                            class="absolute left-1/2 -translate-x-1/2 -top-7
                                    w-20 h-20 rounded-full bg-white border border-slate-100
                                    shadow-[0_12px_25px_rgba(15,23,42,0.18)]
                                    flex items-center justify-center"
                            aria-label="Checkup">
                                <div class="w-13 h-13 rounded-full flex items-center justify-center {{ $activeTab == 'queue-register' ? 'bg-sky-500 text-white'  : 'bg-gray-200/50  text-sky-500'}} ">
                                    <svg class="w-9 h-9" viewBox="0 0 24 24" fill="none">
                                        <path d="M6 3v6a4 4 0 0 0 8 0V3" stroke="currentColor" stroke-width="2" stroke-linecap="round"/>
                                        <path d="M10 13v1a6 6 0 0 0 12 0v-1" stroke="currentColor" stroke-width="2" stroke-linecap="round" transform="translate(-4 0)"/>
                                        <path d="M18 10a2 2 0 1 0 0.01 0" stroke="currentColor" stroke-width="2" stroke-linecap="round"/>
                                    </svg>
                                </div>
                            </a>
                        </div>
                    </div>
                </footer>

                <style>
                    .has-bottom-nav { padding-bottom: 110px; }
                </style>
            @else
                {{-- SAFE AREA BOTTOM (kalau tanpa footer) --}}
                <div class="pb-[max(env(safe-area-inset-bottom),0px)]"></div>
            @endif

        </div>

        <tallstackui:script />
        @livewireScripts
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
        @stack('scripts')
         <script>
            if ('serviceWorker' in navigator) {
                window.addEventListener('load', () => {
                    navigator.serviceWorker.register('/sw.js');
                });
            }
        </script>
    </body>
</html>
