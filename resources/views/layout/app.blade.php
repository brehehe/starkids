<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="light" style="color-scheme: light;">

    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <title>{{config('app.name')}}</title>

        <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap"
            rel="stylesheet">
        <!-- Add Selectize CSS -->
        <link rel="stylesheet"
            href="https://cdnjs.cloudflare.com/ajax/libs/selectize.js/0.15.2/css/selectize.bootstrap5.min.css"
            integrity="sha512-Ars0BmSwpsUJnWMw+KoUKGKunT7+T8NGK0ORRKj+HT8naZzLSIQoOSIIM3oyaJljgLxFi0xImI5oZkAWEFARSA=="
            crossorigin="anonymous" referrerpolicy="no-referrer">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css"
            integrity="sha512-..." crossorigin="anonymous" referrerpolicy="no-referrer" />
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css">
        <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
        @php
            $companyIcon = Auth::user()?->company?->icon;
        @endphp
        @if ($companyIcon)
            <link rel="icon" href="{{ asset('storage/' . $companyIcon) }}">
        @else
            <link rel="icon" href="{{ asset('asset/img/icon.webp') }}">
        @endif

        <style>
            :root {
                color-scheme: light !important;
            }
            .shadow-top {
                box-shadow: 0 -1px 3px 0 rgba(0, 0, 0, 0.1);
            }
        </style>
        @stack('styles')
        @vite(['resources/css/app.css', 'resources/js/app.js'])
        @livewireStyles
        @fluxAppearance
        <script>
            document.documentElement.classList.remove('dark');
            document.documentElement.classList.add('light');
            try {
                localStorage.setItem('flux.appearance', 'light');
                if (window.Flux) {
                    window.Flux.applyAppearance('light');
                }
            } catch (e) {}
        </script>
    </head>

    <body class="bg-[#f8fafc] text-gray-800 antialiased min-h-screen">
        @include('layout.navbar')
        @include('layout.sidebar')

        <main id="main-content" class="ml-64 min-h-screen flex flex-col bg-[#f8fafc]">
            <!-- Wrapper konten utama dan footer -->
            <div class="flex flex-col flex-grow mt-16 bg-[#f8fafc]">

                <!-- Konten Utama -->
                <div class="flex-grow p-5">
                    @yield('content')
                </div>

                <!-- Footer -->
                <footer class="p-4 bg-white border-t border-gray-200 text-sm text-gray-500 text-center">
                    © 2025 Your {{config('app.name')}}. All rights reserved.
                </footer>

            </div>
        </main>

        @livewireScripts
        @fluxScripts
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
        <!-- Add jQuery -->
        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

        <!-- Add Selectize JS -->
        <script src="https://cdnjs.cloudflare.com/ajax/libs/selectize.js/0.15.2/js/selectize.min.js"
            integrity="sha512-IOebNkvA/HZjMM7MxL0NYeLYEalloZ8ckak+NDtOViP7oiYzG5vn6WVXyrJDiJPhl4yRdmNAG49iuLmhkUdVsQ=="
            crossorigin="anonymous" referrerpolicy="no-referrer"></script>
        <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
        <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
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
