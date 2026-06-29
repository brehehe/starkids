<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width,initial-scale=1.0" />
    <title><?php echo e(config('app.name')); ?></title>
    <!-- Tailwind CSS & Font Awesome -->
    <?php echo app('Illuminate\Foundation\Vite')(['resources/css/app.css', 'resources/js/app.js']); ?>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css">
    <link rel="preconnect" href="https://fonts.bunny.net" />
    <link href="https://fonts.bunny.net/css?family=inter:400,600,700" rel="stylesheet" />
    <link rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/selectize.js/0.15.2/css/selectize.bootstrap5.min.css"
        integrity="sha512-Ars0BmSwpsUJnWMw+KoUKGKunT7+T8NGK0ORRKj+HT8naZzLSIQoOSIIM3oyaJljgLxFi0xImI5oZkAWEFARSA=="
        crossorigin="anonymous" referrerpolicy="no-referrer">
    <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">
    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(Auth::user()): ?>
        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(Auth::user()->company->icon): ?>
            <link rel="icon" href="<?php echo e(asset('storage/' . Auth::user()->company->icon)); ?>">
        <?php else: ?>
            <link rel="icon" href="<?php echo e(asset('asset/img/icon.webp')); ?>">
        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
    <?php else: ?>
        <link rel="icon" href="<?php echo e(asset('asset/img/icon.webp')); ?>">
    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
    <style>
        body {
            font-family: 'Inter', Arial, sans-serif;
        }

        .scrollbar-thin::-webkit-scrollbar {
            width: 6px;
        }

        .scrollbar-thin::-webkit-scrollbar-thumb {
            background: #1e3a8a66;
            border-radius: 3px;
        }

        html {
            scroll-behavior: smooth;
        }

        /* Back to Top Button Animation */
        #backToTop {
            transition: all 0.3s ease;
        }

        #backToTop:hover {
            transform: translateY(-3px);
        }

        .input-disabled {
            background-color: #f3f4f6;
            /* Tailwind's bg-gray-100 */
            color: #6b7280;
            /* Tailwind's text-gray-500 */
            cursor: not-allowed;
        }

        .scrollbar-custom {
            scrollbar-width: thin;
            scrollbar-color: #cbd5e0 #f7fafc;
        }

        .scrollbar-custom::-webkit-scrollbar {
            width: 6px;
        }

        .scrollbar-custom::-webkit-scrollbar-track {
            background: #f7fafc;
            border-radius: 3px;
        }

        .scrollbar-custom::-webkit-scrollbar-thumb {
            background: #cbd5e0;
            border-radius: 3px;
        }

        .scrollbar-custom::-webkit-scrollbar-thumb:hover {
            background: #a0aec0;
        }

        /* Loading states */
        .opacity-50 {
            opacity: 0.5;
            pointer-events: none;
        }

        /* Smooth transitions */
        .transition-colors {
            transition: background-color 0.2s ease-in-out;
        }
    </style>
    <?php echo \Livewire\Mechanisms\FrontendAssets\FrontendAssets::styles(); ?>

    <?php echo $__env->yieldPushContent('styles'); ?>
</head>

<body class="bg-blue-50 min-h-screen text-[#1E3A8A]">
    <?php echo $__env->make('layout.pos.header', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
    <div class="mb-5">
        <?php echo $__env->yieldContent('content'); ?>
    </div>
    <?php echo $__env->make('layout.pos.footer', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/selectize.js/0.15.2/js/selectize.min.js"
        integrity="sha512-IOebNkvA/HZjMM7MxL0NYeLYEalloZ8ckak+NDtOViP7oiYzG5vn6WVXyrJDiJPhl4yRdmNAG49iuLmhkUdVsQ=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <?php echo \Livewire\Mechanisms\FrontendAssets\FrontendAssets::scripts(); ?>

    <?php echo $__env->yieldPushContent('scripts'); ?>
    <script>
        // Service Worker Registration
        if ('serviceWorker' in navigator) {
            window.addEventListener('load', () => {
                navigator.serviceWorker.register('/sw.js');
            });
        }

        // Update DateTime
        function updateDateTime() {
            const now = new Date();

            // Array nama bulan dalam bahasa Indonesia
            const bulan = [
                "Januari", "Februari", "Maret", "April", "Mei", "Juni",
                "Juli", "Agustus", "September", "Oktober", "November", "Desember"
            ];

            // Array nama hari dalam bahasa Indonesia
            const hari = [
                "Minggu", "Senin", "Selasa", "Rabu", "Kamis", "Jumat", "Sabtu"
            ];

            // Format tanggal Indonesia
            const formatted = hari[now.getDay()] + ', ' +
                now.getDate() + ' ' +
                bulan[now.getMonth()] + ' ' +
                now.getFullYear() + ' ' +
                String(now.getHours()).padStart(2, '0') + ':' +
                String(now.getMinutes()).padStart(2, '0') + ':' +
                String(now.getSeconds()).padStart(2, '0') + ' WIB';

            document.querySelector('#currentDateTime span').textContent = formatted;
        }

        // Update setiap detik
        setInterval(updateDateTime, 1000);


        // Back to Top functionality
        const backToTopButton = document.getElementById('backToTop');

        window.onscroll = function () {
            if (document.body.scrollTop > 20 || document.documentElement.scrollTop > 20) {
                backToTopButton.classList.remove('hidden');
            } else {
                backToTopButton.classList.add('hidden');
            }
        };

        function scrollToTop() {
            window.scrollTo({
                top: 0,
                behavior: 'smooth'
            });
        }

        // Prevent form resubmission on refresh
        if (window.history.replaceState) {
            window.history.replaceState(null, null, window.location.href);
        }

        // On page load/refresh, scroll to top
        window.onload = function () {
            window.scrollTo(0, 0);
        }

        window.addEventListener('open-modal', event => {
            const modal = document.getElementById(event.detail[0].id);
            if (modal) {
                modal.classList.remove('hidden');
                modal.classList.add('flex');
            }
        });


        // Dengar event dari Livewire untuk tutup modal berdasarkan ID yang dikirimkan
        window.addEventListener('close-modal', event => {
            const modal = document.getElementById(event.detail[0].id);
            if (modal) {
                modal.classList.add('hidden');
                modal.classList.remove('flex');
            }
        });

        // Tutup modal jika klik luar konten
        document.addEventListener('click', function (e) {
            const modals = document.querySelectorAll('.modal');
            modals.forEach(modal => {
                if (!modal.classList.contains('hidden') && e.target === modal) {
                    window.livewire.emit('closeModal', modal
                        .id); // Kirim event untuk menutup modal tertentu
                }
            });
        });

        function convertToRupiah(input) {
            let angka = input.value.replace(/[^,\d]/g, "");
            let split = angka.split(",");
            let sisa = split[0].length % 3;
            let rupiah = split[0].substr(0, sisa);
            let ribuan = split[0].substr(sisa).match(/\d{3}/g);

            if (ribuan) {
                let separator = sisa ? "." : "";
                rupiah += separator + ribuan.join(".");
            }

            rupiah = split[1] !== undefined ? rupiah + "," + split[1] : rupiah;

            input.value = rupiah;
        }

        // Ini penting! Daftarkan ke global scope
        window.convertToRupiah = convertToRupiah;
    </script>
</body>

</html><?php /**PATH /Users/macbookair/Documents/mediction/mediction.id/resources/views/layout/pos/app.blade.php ENDPATH**/ ?>