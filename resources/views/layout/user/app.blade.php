<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Klinik Sehat Mandiri') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <!-- Font Awesome -->
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

        <!-- Tailwind CSS -->
        <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>

        <!-- Favicon -->
        <link rel="icon" type="image/x-icon" href="{{ asset('favicon.ico') }}">

        <!-- SEO Meta Tags -->
        <meta name="description"
            content="Klinik kesehatan terpercaya dengan pelayanan medis profesional dan booking online yang mudah">
        <meta name="keywords" content="klinik, kesehatan, dokter, booking online, konsultasi medis">
        <meta name="author" content="{{ config('app.name') }}">

        <!-- Open Graph Meta Tags -->
        <meta property="og:title" content="{{ config('app.name') }} - Kesehatan Terpercaya">
        <meta property="og:description"
            content="Pelayanan kesehatan terbaik dengan teknologi modern dan tenaga medis berpengalaman">
        <meta property="og:image" content="{{ asset('img/og-image.jpg') }}">
        <meta property="og:url" content="{{ url()->current() }}">
        <meta property="og:type" content="website">

        <!-- Additional Styles -->
        @stack('styles')
        @livewireStyles

        <style>
            /* Custom animations */
            @keyframes fadeInUp {
                from {
                    opacity: 0;
                    transform: translateY(30px);
                }

                to {
                    opacity: 1;
                    transform: translateY(0);
                }
            }

            @keyframes pulse {

                0%,
                100% {
                    transform: scale(1);
                }

                50% {
                    transform: scale(1.05);
                }
            }

            .animate-fadeInUp {
                animation: fadeInUp 0.6s ease-out;
            }

            .animate-pulse-slow {
                animation: pulse 2s ease-in-out infinite;
            }

            /* Smooth scroll */
            html {
                scroll-behavior: smooth;
            }

            /* Loading spinner */
            .loading-spinner {
                border: 3px solid #f3f3f3;
                border-top: 3px solid #3498db;
                border-radius: 50%;
                width: 40px;
                height: 40px;
                animation: spin 1s linear infinite;
            }

            @keyframes spin {
                0% {
                    transform: rotate(0deg);
                }

                100% {
                    transform: rotate(360deg);
                }
            }

            /* Custom scrollbar */
            ::-webkit-scrollbar {
                width: 8px;
            }

            ::-webkit-scrollbar-track {
                background: #f1f1f1;
            }

            ::-webkit-scrollbar-thumb {
                background: #c1c1c1;
                border-radius: 4px;
            }

            ::-webkit-scrollbar-thumb:hover {
                background: #a8a8a8;
            }

            /* Floating action button */
            .fab {
                position: fixed;
                bottom: 20px;
                right: 20px;
                z-index: 1000;
            }

            /* Notification styles */
            .notification {
                position: fixed;
                top: 20px;
                right: 20px;
                z-index: 1000;
                min-width: 300px;
                max-width: 500px;
            }

            /* Background patterns */
            .bg-pattern {
                background-image:
                    radial-gradient(circle at 25px 25px, rgba(255, 255, 255, 0.1) 2px, transparent 0),
                    radial-gradient(circle at 75px 75px, rgba(255, 255, 255, 0.1) 2px, transparent 0);
                background-size: 100px 100px;
            }
        </style>
    </head>

    <body class="font-sans antialiased">
        <!-- Loading Screen -->
        <div id="loading-screen" class="fixed inset-0 bg-white z-50 flex items-center justify-center">
            <div class="text-center">
                <div class="loading-spinner mx-auto mb-4"></div>
                <div class="text-gray-600">Memuat...</div>
            </div>
        </div>

        <!-- Page Content -->
        <main>
            @yield('content')
            {{ $slot ?? '' }}
        </main>

        <!-- Floating WhatsApp Button -->
        <div class="fab">
            <a href="https://wa.me/6281234567890" target="_blank"
                class="bg-green-500 hover:bg-green-600 text-white p-4 rounded-full shadow-lg transition duration-300 transform hover:scale-110 flex items-center justify-center">
                <i class="fab fa-whatsapp text-2xl"></i>
            </a>
        </div>

        <!-- Scroll to Top Button -->
        <button id="scrollToTop"
            class="fixed bottom-20 right-20 bg-blue-600 hover:bg-blue-700 text-white p-3 rounded-full shadow-lg transition duration-300 transform hover:scale-110 opacity-0 pointer-events-none">
            <i class="fas fa-arrow-up"></i>
        </button>

        <!-- Notification Container -->
        <div id="notification-container" class="notification"></div>

        <!-- Back to Top Button -->
        <div id="back-to-top"
            class="fixed bottom-4 right-4 opacity-0 pointer-events-none transition-opacity duration-300">
            <button
                class="bg-blue-600 hover:bg-blue-700 text-white p-3 rounded-full shadow-lg transition duration-300 transform hover:scale-110">
                <i class="fas fa-chevron-up"></i>
            </button>
        </div>

        <!-- Mobile Menu Overlay -->
        <div id="mobile-menu-overlay" class="fixed inset-0 bg-black bg-opacity-50 z-40 hidden">
            <div id="mobile-menu"
                class="fixed top-0 right-0 h-full w-80 bg-white shadow-xl transform translate-x-full transition-transform duration-300 ease-in-out">
                <div class="p-6">
                    <div class="flex justify-between items-center mb-8">
                        <h2 class="text-xl font-bold text-gray-800">Menu</h2>
                        <button id="close-mobile-menu" class="text-gray-600 hover:text-gray-800">
                            <i class="fas fa-times text-xl"></i>
                        </button>
                    </div>
                    <nav class="space-y-4">
                        <a href="#home"
                            class="block py-3 px-4 text-gray-700 hover:bg-blue-50 hover:text-blue-600 rounded-lg transition duration-300">
                            <i class="fas fa-home mr-3"></i>Beranda
                        </a>
                        <a href="#services"
                            class="block py-3 px-4 text-gray-700 hover:bg-blue-50 hover:text-blue-600 rounded-lg transition duration-300">
                            <i class="fas fa-heartbeat mr-3"></i>Layanan
                        </a>
                        <a href="#doctors"
                            class="block py-3 px-4 text-gray-700 hover:bg-blue-50 hover:text-blue-600 rounded-lg transition duration-300">
                            <i class="fas fa-user-md mr-3"></i>Dokter
                        </a>
                        <a href="#booking"
                            class="block py-3 px-4 text-gray-700 hover:bg-blue-50 hover:text-blue-600 rounded-lg transition duration-300">
                            <i class="fas fa-calendar-plus mr-3"></i>Booking
                        </a>
                        <a href="#contact"
                            class="block py-3 px-4 text-gray-700 hover:bg-blue-50 hover:text-blue-600 rounded-lg transition duration-300">
                            <i class="fas fa-phone mr-3"></i>Kontak
                        </a>
                    </nav>
                    <div class="mt-8 pt-6 border-t border-gray-200">
                        <a href="/login"
                            class="block w-full bg-blue-600 text-white text-center py-3 rounded-lg hover:bg-blue-700 transition duration-300">
                            <i class="fas fa-sign-in-alt mr-2"></i>Login
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <!-- Scripts -->
        <script src="https://cdnjs.cloudflare.com/ajax/libs/alpinejs/3.13.3/cdn.min.js" defer></script>
        @livewireScripts

        <script>
            document.addEventListener('DOMContentLoaded', function() {
                // Hide loading screen
                setTimeout(() => {
                    document.getElementById('loading-screen').style.display = 'none';
                }, 1000);

                // Mobile menu functionality
                const mobileMenuBtn = document.getElementById('mobile-menu-btn');
                const mobileMenuOverlay = document.getElementById('mobile-menu-overlay');
                const mobileMenu = document.getElementById('mobile-menu');
                const closeMobileMenu = document.getElementById('close-mobile-menu');

                function openMobileMenu() {
                    mobileMenuOverlay.classList.remove('hidden');
                    setTimeout(() => {
                        mobileMenu.classList.remove('translate-x-full');
                    }, 10);
                }

                function closeMobileMenuHandler() {
                    mobileMenu.classList.add('translate-x-full');
                    setTimeout(() => {
                        mobileMenuOverlay.classList.add('hidden');
                    }, 300);
                }

                if (mobileMenuBtn) {
                    mobileMenuBtn.addEventListener('click', openMobileMenu);
                }

                if (closeMobileMenu) {
                    closeMobileMenu.addEventListener('click', closeMobileMenuHandler);
                }

                if (mobileMenuOverlay) {
                    mobileMenuOverlay.addEventListener('click', function(e) {
                        if (e.target === mobileMenuOverlay) {
                            closeMobileMenuHandler();
                        }
                    });
                }

                // Smooth scrolling for anchor links
                document.querySelectorAll('a[href^="#"]').forEach(anchor => {
                    anchor.addEventListener('click', function(e) {
                        e.preventDefault();
                        const target = document.querySelector(this.getAttribute('href'));
                        if (target) {
                            target.scrollIntoView({
                                behavior: 'smooth',
                                block: 'start'
                            });
                            // Close mobile menu if open
                            closeMobileMenuHandler();
                        }
                    });
                });

                // Scroll to top functionality
                const scrollToTopBtn = document.getElementById('scrollToTop');
                const backToTopBtn = document.getElementById('back-to-top');

                function toggleScrollButton() {
                    if (window.pageYOffset > 300) {
                        if (scrollToTopBtn) {
                            scrollToTopBtn.style.opacity = '1';
                            scrollToTopBtn.style.pointerEvents = 'auto';
                        }
                        if (backToTopBtn) {
                            backToTopBtn.style.opacity = '1';
                            backToTopBtn.style.pointerEvents = 'auto';
                        }
                    } else {
                        if (scrollToTopBtn) {
                            scrollToTopBtn.style.opacity = '0';
                            scrollToTopBtn.style.pointerEvents = 'none';
                        }
                        if (backToTopBtn) {
                            backToTopBtn.style.opacity = '0';
                            backToTopBtn.style.pointerEvents = 'none';
                        }
                    }
                }

                window.addEventListener('scroll', toggleScrollButton);

                if (scrollToTopBtn) {
                    scrollToTopBtn.addEventListener('click', function() {
                        window.scrollTo({
                            top: 0,
                            behavior: 'smooth'
                        });
                    });
                }

                if (backToTopBtn) {
                    backToTopBtn.addEventListener('click', function() {
                        window.scrollTo({
                            top: 0,
                            behavior: 'smooth'
                        });
                    });
                }

                // Navbar background change on scroll
                const header = document.querySelector('header');
                if (header) {
                    function updateHeaderBackground() {
                        if (window.scrollY > 100) {
                            header.classList.add('bg-white/95', 'backdrop-blur-sm');
                            header.classList.remove('bg-white');
                        } else {
                            header.classList.remove('bg-white/95', 'backdrop-blur-sm');
                            header.classList.add('bg-white');
                        }
                    }

                    window.addEventListener('scroll', updateHeaderBackground);
                }

                // Intersection Observer for animations
                const observerOptions = {
                    threshold: 0.1,
                    rootMargin: '0px 0px -50px 0px'
                };

                const observer = new IntersectionObserver(function(entries) {
                    entries.forEach(entry => {
                        if (entry.isIntersecting) {
                            entry.target.classList.add('animate-fadeInUp');
                        }
                    });
                }, observerOptions);

                // Observe elements for animation
                document.querySelectorAll('.animate-on-scroll').forEach(el => {
                    observer.observe(el);
                });
            });

            // Notification system
            function showNotification(message, type = 'success') {
                const container = document.getElementById('notification-container');
                const notification = document.createElement('div');

                const bgColor = type === 'success' ? 'bg-green-500' :
                    type === 'error' ? 'bg-red-500' :
                    type === 'warning' ? 'bg-yellow-500' : 'bg-blue-500';

                notification.className =
                    `${bgColor} text-white p-4 rounded-lg shadow-lg mb-4 transform translate-x-full transition-transform duration-300`;
                notification.innerHTML = `
                <div class="flex items-center justify-between">
                    <span>${message}</span>
                    <button onclick="this.parentElement.parentElement.remove()" class="ml-4 text-white hover:text-gray-200">
                        <i class="fas fa-times"></i>
                    </button>
                </div>
            `;

                container.appendChild(notification);

                // Slide in
                setTimeout(() => {
                    notification.classList.remove('translate-x-full');
                }, 10);

                // Auto remove after 5 seconds
                setTimeout(() => {
                    notification.classList.add('translate-x-full');
                    setTimeout(() => {
                        if (notification.parentElement) {
                            notification.remove();
                        }
                    }, 300);
                }, 5000);
            }

            // Livewire event listeners
            window.addEventListener('notification', event => {
                showNotification(event.detail.message, event.detail.type);
            });

            // Form submission loading state
            function setLoadingState(button, loading = true) {
                if (loading) {
                    button.disabled = true;
                    button.innerHTML = '<i class="fas fa-spinner fa-spin mr-2"></i>Processing...';
                } else {
                    button.disabled = false;
                    button.innerHTML = button.dataset.originalText || 'Submit';
                }
            }

            // Lazy loading for images
            function lazyLoadImages() {
                const images = document.querySelectorAll('img[data-src]');
                const imageObserver = new IntersectionObserver((entries, observer) => {
                    entries.forEach(entry => {
                        if (entry.isIntersecting) {
                            const img = entry.target;
                            img.src = img.dataset.src;
                            img.classList.remove('opacity-0');
                            img.classList.add('opacity-100');
                            observer.unobserve(img);
                        }
                    });
                });

                images.forEach(img => imageObserver.observe(img));
            }

            // Initialize lazy loading
            document.addEventListener('DOMContentLoaded', lazyLoadImages);
        </script>

        @stack('scripts')
    </body>

</html>
