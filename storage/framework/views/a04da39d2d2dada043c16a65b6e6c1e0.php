<!DOCTYPE html>
<html lang="id" class="h-full">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">
    <title>Daftar Antrian - Klinik BR Health</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        tailwind.config = {
            darkMode: 'class',
            theme: {
                extend: {
                    colors: {
                        primary: '#3B82F6',
                        secondary: '#1E40AF'
                    }
                }
            }
        }
    </script>
    <style>
        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .animate-fade-in {
            animation: fadeIn 0.5s ease-out;
        }
    </style>
</head>
<body class="h-full bg-gradient-to-br from-blue-50 to-indigo-100 dark:from-slate-900 dark:to-slate-800">
    <div class="min-h-full flex flex-col justify-center py-12 sm:px-6 lg:px-8">
        <div class="sm:mx-auto sm:w-full sm:max-w-md">
            <div class="text-center">
                <h1 class="text-3xl font-bold text-gray-900 dark:text-white mb-2">🏥 Klinik BR Health</h1>
                <h2 class="text-xl text-gray-600 dark:text-gray-300">Daftar Antrian Online</h2>
            </div>
        </div>

        <div class="mt-8 sm:mx-auto sm:w-full sm:max-w-2xl">
            <div class="bg-white dark:bg-slate-800 py-8 px-6 shadow-2xl sm:rounded-2xl sm:px-10 border border-gray-200 dark:border-slate-700 backdrop-blur-sm">
                <!-- Enhanced Step Indicator -->
                <div class="mb-10">
                    <!-- Progress Bar Background -->
                    <div class="relative mb-8">
                        <div class="absolute top-1/2 left-0 w-full h-2 bg-gray-200 dark:bg-slate-600 rounded-full transform -translate-y-1/2"></div>
                        <div id="overall-progress" class="absolute top-1/2 left-0 h-2 bg-gradient-to-r from-blue-500 via-blue-600 to-indigo-600 rounded-full transform -translate-y-1/2 transition-all duration-700 ease-out shadow-lg" style="width: 25%"></div>
                    </div>

                    <!-- Step Indicators -->
                    <div class="flex items-center justify-between relative px-1 sm:px-2">
                        <div class="flex flex-col items-center group cursor-pointer min-w-0 flex-1">
                            <div id="step1-indicator" class="flex items-center justify-center w-10 h-10 sm:w-12 sm:h-12 bg-gradient-to-br from-blue-500 to-blue-700 text-white rounded-full text-sm font-bold shadow-xl transform transition-all duration-300 group-hover:scale-110 group-hover:shadow-2xl border-2 sm:border-4 border-white dark:border-slate-800">
                                <svg class="w-4 h-4 sm:w-5 sm:h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                                </svg>
                            </div>
                            <span id="step1-text" class="mt-2 sm:mt-3 text-xs sm:text-sm font-bold text-blue-600 text-center leading-tight px-1">Pilih Poli</span>
                        </div>

                        <div class="flex flex-col items-center group cursor-pointer min-w-0 flex-1">
                            <div id="step2-indicator" class="flex items-center justify-center w-10 h-10 sm:w-12 sm:h-12 bg-gray-300 dark:bg-slate-600 text-gray-500 dark:text-gray-400 rounded-full text-sm font-bold shadow-lg transform transition-all duration-300 group-hover:scale-110 group-hover:shadow-xl border-2 sm:border-4 border-white dark:border-slate-800">
                                <svg class="w-4 h-4 sm:w-5 sm:h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                </svg>
                            </div>
                            <span id="step2-text" class="mt-2 sm:mt-3 text-xs sm:text-sm font-semibold text-gray-500 dark:text-gray-400 text-center leading-tight px-1">Pilih Dokter</span>
                        </div>

                        <div class="flex flex-col items-center group cursor-pointer min-w-0 flex-1">
                            <div id="step3-indicator" class="flex items-center justify-center w-10 h-10 sm:w-12 sm:h-12 bg-gray-300 dark:bg-slate-600 text-gray-500 dark:text-gray-400 rounded-full text-sm font-bold shadow-lg transform transition-all duration-300 group-hover:scale-110 group-hover:shadow-xl border-2 sm:border-4 border-white dark:border-slate-800">
                                <svg class="w-4 h-4 sm:w-5 sm:h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                </svg>
                            </div>
                            <span id="step3-text" class="mt-2 sm:mt-3 text-xs sm:text-sm font-semibold text-gray-500 dark:text-gray-400 text-center leading-tight px-1">Jadwal</span>
                        </div>

                        <div class="flex flex-col items-center group cursor-pointer min-w-0 flex-1">
                            <div id="step4-indicator" class="flex items-center justify-center w-10 h-10 sm:w-12 sm:h-12 bg-gray-300 dark:bg-slate-600 text-gray-500 dark:text-gray-400 rounded-full text-sm font-bold shadow-lg transform transition-all duration-300 group-hover:scale-110 group-hover:shadow-xl border-2 sm:border-4 border-white dark:border-slate-800">
                                <svg class="w-4 h-4 sm:w-5 sm:h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                </svg>
                            </div>
                            <span id="step4-text" class="mt-2 sm:mt-3 text-xs sm:text-sm font-semibold text-gray-500 dark:text-gray-400 text-center leading-tight px-1">Data Diri</span>
                        </div>
                    </div>
                </div>

                <form id="registration-form">
                    <?php echo csrf_field(); ?>
                    <input type="hidden" name="doctor_id" id="selected_doctor_id">
                    <input type="hidden" name="visit_time" id="selected_visit_time">

                    <!-- Step 1: Pilih Poli -->
                    <div id="step1" class="step animate-fade-in">
                        <div class="text-center mb-6">
                            <h3 class="text-2xl font-bold text-gray-900 dark:text-white mb-2">Pilih Poli Klinik</h3>
                            <p class="text-gray-600 dark:text-gray-400">Silakan pilih jenis layanan kesehatan yang Anda butuhkan</p>
                        </div>
                        <div class="grid grid-cols-1 gap-4">
                            <label class="poli-option cursor-pointer group">
                                <input type="radio" name="poli" value="umum" class="sr-only">
                                <div class="flex items-center p-5 border-2 border-gray-200 dark:border-slate-600 rounded-xl hover:border-blue-500 hover:shadow-lg transition-all duration-300 group-hover:scale-[1.02] group-hover:bg-blue-50 dark:group-hover:bg-blue-900/20">
                                    <div class="text-3xl mr-4 group-hover:scale-110 transition-transform duration-300">🩺</div>
                                    <div class="flex-1">
                                        <div class="font-semibold text-gray-900 dark:text-white text-lg">Poli Umum</div>
                                        <div class="text-sm text-gray-500 dark:text-gray-400 mt-1">Pemeriksaan kesehatan umum dan konsultasi medis</div>
                                    </div>
                                    <div class="text-blue-500 opacity-0 group-hover:opacity-100 transition-opacity duration-300">
                                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                                        </svg>
                                    </div>
                                </div>
                            </label>
                            <label class="poli-option cursor-pointer group">
                                <input type="radio" name="poli" value="gigi" class="sr-only">
                                <div class="flex items-center p-5 border-2 border-gray-200 dark:border-slate-600 rounded-xl hover:border-blue-500 hover:shadow-lg transition-all duration-300 group-hover:scale-[1.02] group-hover:bg-blue-50 dark:group-hover:bg-blue-900/20">
                                    <div class="text-3xl mr-4 group-hover:scale-110 transition-transform duration-300">🦷</div>
                                    <div class="flex-1">
                                        <div class="font-semibold text-gray-900 dark:text-white text-lg">Poli Gigi</div>
                                        <div class="text-sm text-gray-500 dark:text-gray-400 mt-1">Perawatan gigi, mulut, dan kesehatan oral</div>
                                    </div>
                                    <div class="text-blue-500 opacity-0 group-hover:opacity-100 transition-opacity duration-300">
                                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                                        </svg>
                                    </div>
                                </div>
                            </label>
                            <label class="poli-option cursor-pointer group">
                                <input type="radio" name="poli" value="mata" class="sr-only">
                                <div class="flex items-center p-5 border-2 border-gray-200 dark:border-slate-600 rounded-xl hover:border-blue-500 hover:shadow-lg transition-all duration-300 group-hover:scale-[1.02] group-hover:bg-blue-50 dark:group-hover:bg-blue-900/20">
                                    <div class="text-3xl mr-4 group-hover:scale-110 transition-transform duration-300">👁️</div>
                                    <div class="flex-1">
                                        <div class="font-semibold text-gray-900 dark:text-white text-lg">Poli Mata</div>
                                        <div class="text-sm text-gray-500 dark:text-gray-400 mt-1">Pemeriksaan mata, penglihatan, dan kesehatan mata</div>
                                    </div>
                                    <div class="text-blue-500 opacity-0 group-hover:opacity-100 transition-opacity duration-300">
                                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                                        </svg>
                                    </div>
                                </div>
                            </label>
                            <label class="poli-option cursor-pointer group">
                                <input type="radio" name="poli" value="anak" class="sr-only">
                                <div class="flex items-center p-5 border-2 border-gray-200 dark:border-slate-600 rounded-xl hover:border-blue-500 hover:shadow-lg transition-all duration-300 group-hover:scale-[1.02] group-hover:bg-blue-50 dark:group-hover:bg-blue-900/20">
                                    <div class="text-3xl mr-4 group-hover:scale-110 transition-transform duration-300">👶</div>
                                    <div class="flex-1">
                                        <div class="font-semibold text-gray-900 dark:text-white text-lg">Poli Anak</div>
                                        <div class="text-sm text-gray-500 dark:text-gray-400 mt-1">Kesehatan anak, bayi, dan tumbuh kembang</div>
                                    </div>
                                    <div class="text-blue-500 opacity-0 group-hover:opacity-100 transition-opacity duration-300">
                                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                                        </svg>
                                    </div>
                                </div>
                            </label>
                            <label class="poli-option cursor-pointer group">
                                <input type="radio" name="poli" value="kandungan" class="sr-only">
                                <div class="flex items-center p-5 border-2 border-gray-200 dark:border-slate-600 rounded-xl hover:border-blue-500 hover:shadow-lg transition-all duration-300 group-hover:scale-[1.02] group-hover:bg-blue-50 dark:group-hover:bg-blue-900/20">
                                    <div class="text-3xl mr-4 group-hover:scale-110 transition-transform duration-300">🤱</div>
                                    <div class="flex-1">
                                        <div class="font-semibold text-gray-900 dark:text-white text-lg">Poli Kandungan</div>
                                        <div class="text-sm text-gray-500 dark:text-gray-400 mt-1">Kesehatan ibu, kandungan, dan kebidanan</div>
                                    </div>
                                    <div class="text-blue-500 opacity-0 group-hover:opacity-100 transition-opacity duration-300">
                                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                                        </svg>
                                    </div>
                                </div>
                            </label>
                        </div>
                        <button type="button" id="next-step1" class="mt-8 w-full bg-gradient-to-r from-blue-600 to-blue-700 hover:from-blue-700 hover:to-blue-800 text-white py-3 px-6 rounded-xl font-semibold transition-all duration-300 disabled:opacity-50 disabled:cursor-not-allowed disabled:transform-none transform hover:scale-[1.02] shadow-lg hover:shadow-xl" disabled>
                            <span class="flex items-center justify-center">
                                Lanjutkan
                                <svg class="w-5 h-5 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"></path>
                                </svg>
                            </span>
                        </button>
                    </div>

                    <!-- Step 2: Pilih Dokter -->
                    <div id="step2" class="step hidden animate-fade-in">
                        <div class="text-center mb-6">
                            <h3 class="text-2xl font-bold text-gray-900 dark:text-white mb-2">Pilih Dokter</h3>
                            <p class="text-gray-600 dark:text-gray-400">Pilih dokter yang tersedia untuk poli yang Anda pilih</p>
                        </div>
                        <div id="doctor-list" class="space-y-4 mb-8">
                            <!-- Doctors will be loaded here based on selected poli -->
                        </div>
                        <div class="flex space-x-4">
                            <button type="button" id="prev-step2" class="flex-1 bg-gray-100 hover:bg-gray-200 dark:bg-slate-700 dark:hover:bg-slate-600 text-gray-700 dark:text-gray-300 py-3 px-6 rounded-xl font-semibold transition-all duration-300 transform hover:scale-[1.02] shadow-md hover:shadow-lg">
                                <span class="flex items-center justify-center">
                                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 17l-5-5m0 0l5-5m-5 5h12"></path>
                                    </svg>
                                    Kembali
                                </span>
                            </button>
                            <button type="button" id="next-step2" class="flex-1 bg-gradient-to-r from-blue-600 to-blue-700 hover:from-blue-700 hover:to-blue-800 text-white py-3 px-6 rounded-xl font-semibold transition-all duration-300 disabled:opacity-50 disabled:cursor-not-allowed disabled:transform-none transform hover:scale-[1.02] shadow-lg hover:shadow-xl" disabled>
                                <span class="flex items-center justify-center">
                                    Lanjutkan
                                    <svg class="w-5 h-5 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"></path>
                                    </svg>
                                </span>
                            </button>
                        </div>
                    </div>

                    <!-- Step 3: Pilih Jadwal -->
                    <div id="step3" class="step hidden animate-fade-in">
                        <div class="text-center mb-6">
                            <h3 class="text-2xl font-bold text-gray-900 dark:text-white mb-2">Pilih Jadwal Kunjungan</h3>
                            <p class="text-gray-600 dark:text-gray-400">Tentukan tanggal dan waktu kunjungan Anda</p>
                        </div>

                        <div class="bg-gradient-to-r from-blue-50 to-indigo-50 dark:from-blue-900/20 dark:to-indigo-900/20 rounded-xl p-6 mb-6">
                            <div class="mb-6">
                                <label for="visit_date" class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-3 flex items-center">
                                    <svg class="w-5 h-5 mr-2 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                    </svg>
                                    Pilih Tanggal
                                </label>
                                <input type="date" id="visit_date" name="visit_date" class="w-full px-4 py-3 border-2 border-gray-200 dark:border-slate-600 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 dark:bg-slate-700 dark:text-white transition-all duration-300 hover:border-blue-300" min="<?php echo e(date('Y-m-d')); ?>">
                            </div>

                            <div class="mb-6">
                                <label for="visit_time" class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-3 flex items-center">
                                    <svg class="w-5 h-5 mr-2 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    </svg>
                                    Slot Waktu Tersedia
                                </label>
                                <div id="time-slots" class="grid grid-cols-2 gap-3">
                                    <!-- Time slots will be loaded here based on selected doctor and date -->
                                </div>
                                <div id="no-slots-message" class="hidden text-center py-8">
                                    <div class="text-gray-400 dark:text-gray-500">
                                        <svg class="w-12 h-12 mx-auto mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                        </svg>
                                        <p class="text-sm">Pilih tanggal untuk melihat slot waktu yang tersedia</p>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="flex space-x-4">
                            <button type="button" id="prev-step3" class="flex-1 bg-gray-100 hover:bg-gray-200 dark:bg-slate-700 dark:hover:bg-slate-600 text-gray-700 dark:text-gray-300 py-3 px-6 rounded-xl font-semibold transition-all duration-300 transform hover:scale-[1.02] shadow-md hover:shadow-lg">
                                <span class="flex items-center justify-center">
                                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 17l-5-5m0 0l5-5m-5 5h12"></path>
                                    </svg>
                                    Kembali
                                </span>
                            </button>
                            <button type="button" id="next-step3" class="flex-1 bg-gradient-to-r from-blue-600 to-blue-700 hover:from-blue-700 hover:to-blue-800 text-white py-3 px-6 rounded-xl font-semibold transition-all duration-300 disabled:opacity-50 disabled:cursor-not-allowed disabled:transform-none transform hover:scale-[1.02] shadow-lg hover:shadow-xl" disabled>
                                <span class="flex items-center justify-center">
                                    Lanjutkan
                                    <svg class="w-5 h-5 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"></path>
                                    </svg>
                                </span>
                            </button>
                        </div>
                    </div>

                    <!-- Step 4: Data Pasien -->
                    <div id="step4" class="step hidden animate-fade-in">
                        <div class="text-center mb-6">
                            <h3 class="text-2xl font-bold text-gray-900 dark:text-white mb-2">Data Pasien</h3>
                            <p class="text-gray-600 dark:text-gray-400">Lengkapi data diri untuk menyelesaikan pendaftaran</p>
                        </div>

                        <!-- NIK Search Section -->
                        <div id="nik-search-section" class="bg-gradient-to-r from-green-50 to-emerald-50 dark:from-green-900/20 dark:to-emerald-900/20 rounded-xl p-6 space-y-6">
                            <div>
                                <label for="nik" class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-3 flex items-center">
                                    <svg class="w-5 h-5 mr-2 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V8a2 2 0 00-2-2h-5m-4 0V4a2 2 0 114 0v2m-4 0a2 2 0 104 0m-5 8a2 2 0 100-4 2 2 0 000 4zm0 0c1.306 0 2.417.835 2.83 2M9 14a3.001 3.001 0 00-2.83 2M15 11h3m-3 4h2"></path>
                                    </svg>
                                    NIK (Nomor Induk Kependudukan)
                                </label>
                                <div class="flex space-x-3">
                                    <input type="text" id="nik" name="nik" class="flex-1 px-4 py-3 border-2 border-gray-200 dark:border-slate-600 rounded-xl focus:ring-2 focus:ring-green-500 focus:border-green-500 dark:bg-slate-700 dark:text-white transition-all duration-300 hover:border-green-300" placeholder="Masukkan 16 digit NIK" maxlength="16">
                                    <button type="button" id="search-nik" class="px-6 py-3 bg-gradient-to-r from-green-600 to-green-700 hover:from-green-700 hover:to-green-800 text-white rounded-xl font-semibold transition-all duration-300 transform hover:scale-[1.02] shadow-lg hover:shadow-xl">
                                        <span class="flex items-center">
                                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                                            </svg>
                                            Cari
                                        </span>
                                    </button>
                                </div>
                                <p class="text-sm text-gray-600 dark:text-gray-400 mt-2 flex items-center">
                                    <svg class="w-4 h-4 mr-1 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    </svg>
                                    Masukkan NIK untuk mencari data pasien yang sudah terdaftar
                                </p>
                            </div>

                            <div class="text-center">
                                <div class="relative">
                                    <div class="absolute inset-0 flex items-center">
                                        <div class="w-full border-t border-gray-300 dark:border-slate-600"></div>
                                    </div>
                                    <div class="relative flex justify-center text-sm">
                                        <span class="px-4 bg-gradient-to-r from-green-50 to-emerald-50 dark:from-green-900/20 dark:to-emerald-900/20 text-gray-500 dark:text-gray-400 font-medium">atau</span>
                                    </div>
                                </div>
                            </div>

                            <div class="text-center">
                                <button type="button" id="new-patient-btn" class="px-8 py-3 bg-gradient-to-r from-gray-600 to-gray-700 hover:from-gray-700 hover:to-gray-800 text-white rounded-xl font-semibold transition-all duration-300 transform hover:scale-[1.02] shadow-lg hover:shadow-xl">
                                    <span class="flex items-center justify-center">
                                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                                        </svg>
                                        Pasien Baru
                                    </span>
                                </button>
                            </div>
                        </div>

                        <!-- Patient Data Form (Hidden initially) -->
                        <div id="patient-form-section" class="space-y-6 hidden animate-fade-in">
                            <div class="bg-gradient-to-r from-blue-50 to-indigo-50 dark:from-blue-900/20 dark:to-indigo-900/20 border-2 border-blue-200 dark:border-blue-800 rounded-xl p-6 mb-6">
                                <div class="flex items-center">
                                    <div class="text-blue-600 dark:text-blue-400 mr-3">
                                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                        </svg>
                                    </div>
                                    <div>
                                        <p class="text-sm font-semibold text-blue-800 dark:text-blue-200" id="patient-status-text">Data pasien ditemukan</p>
                                    </div>
                                </div>
                            </div>

                            <div class="bg-gradient-to-r from-purple-50 to-pink-50 dark:from-purple-900/20 dark:to-pink-900/20 rounded-xl p-6 space-y-6">
                                <div>
                                    <label for="patient_name" class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-3 flex items-center">
                                        <svg class="w-5 h-5 mr-2 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                        </svg>
                                        Nama Lengkap
                                    </label>
                                    <input type="text" id="patient_name" name="patient_name" class="w-full px-4 py-3 border-2 border-gray-200 dark:border-slate-600 rounded-xl focus:ring-2 focus:ring-purple-500 focus:border-purple-500 dark:bg-slate-700 dark:text-white transition-all duration-300 hover:border-purple-300" placeholder="Masukkan nama lengkap">
                                </div>

                                <div>
                                    <label for="phone_number" class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-3 flex items-center">
                                        <svg class="w-5 h-5 mr-2 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path>
                                        </svg>
                                        Nomor Telepon
                                    </label>
                                    <input type="tel" id="phone_number" name="phone_number" class="w-full px-4 py-3 border-2 border-gray-200 dark:border-slate-600 rounded-xl focus:ring-2 focus:ring-purple-500 focus:border-purple-500 dark:bg-slate-700 dark:text-white transition-all duration-300 hover:border-purple-300" placeholder="08xxxxxxxxxx">
                                </div>

                                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                    <div>
                                        <label for="gender" class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-3 flex items-center">
                                            <svg class="w-5 h-5 mr-2 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197m13.5-9a2.5 2.5 0 11-5 0 2.5 2.5 0 015 0z"></path>
                                            </svg>
                                            Jenis Kelamin
                                        </label>
                                        <select id="gender" name="gender" class="w-full px-4 py-3 border-2 border-gray-200 dark:border-slate-600 rounded-xl focus:ring-2 focus:ring-purple-500 focus:border-purple-500 dark:bg-slate-700 dark:text-white transition-all duration-300 hover:border-purple-300">
                                            <option value="">Pilih Jenis Kelamin</option>
                                            <option value="L">Laki-laki</option>
                                            <option value="P">Perempuan</option>
                                        </select>
                                    </div>
                                    <div>
                                        <label for="age" class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-3 flex items-center">
                                            <svg class="w-5 h-5 mr-2 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                            </svg>
                                            Umur
                                        </label>
                                        <input type="number" id="age" name="age" class="w-full px-4 py-3 border-2 border-gray-200 dark:border-slate-600 rounded-xl focus:ring-2 focus:ring-purple-500 focus:border-purple-500 dark:bg-slate-700 dark:text-white transition-all duration-300 hover:border-purple-300" placeholder="Masukkan umur" min="1" max="120">
                                    </div>
                                </div>

                                <div>
                                    <label for="complaint" class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-3 flex items-center">
                                        <svg class="w-5 h-5 mr-2 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                        </svg>
                                        Keluhan (Opsional)
                                    </label>
                                    <textarea id="complaint" name="complaint" rows="4" class="w-full px-4 py-3 border-2 border-gray-200 dark:border-slate-600 rounded-xl focus:ring-2 focus:ring-purple-500 focus:border-purple-500 dark:bg-slate-700 dark:text-white transition-all duration-300 hover:border-purple-300 resize-none" placeholder="Jelaskan keluhan Anda dengan detail..."></textarea>
                                </div>

                                <div class="text-center pt-4">
                                    <button type="button" id="back-to-search" onclick="backToNIKSearch()" class="px-6 py-3 bg-gradient-to-r from-gray-500 to-gray-600 hover:from-gray-600 hover:to-gray-700 text-white rounded-xl font-semibold transition-all duration-300 transform hover:scale-[1.02] shadow-lg hover:shadow-xl">
                                        <span class="flex items-center justify-center">
                                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                                            </svg>
                                            Kembali ke Pencarian NIK
                                        </span>
                                    </button>
                                </div>
                            </div>
                        </div>

                        <div class="flex space-x-4 mt-8">
                            <button type="button" id="prev-step4" class="flex-1 bg-gradient-to-r from-gray-400 to-gray-500 hover:from-gray-500 hover:to-gray-600 text-white py-4 px-6 rounded-xl font-semibold transition-all duration-300 transform hover:scale-[1.02] shadow-lg hover:shadow-xl">
                                <span class="flex items-center justify-center">
                                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                                    </svg>
                                    Kembali
                                </span>
                            </button>
                            <button type="submit" id="submit-form" class="flex-1 bg-gradient-to-r from-green-600 to-green-700 hover:from-green-700 hover:to-green-800 text-white py-4 px-6 rounded-xl font-semibold transition-all duration-300 transform hover:scale-[1.02] shadow-lg hover:shadow-xl disabled:opacity-50 disabled:cursor-not-allowed disabled:transform-none" disabled>
                                <span class="flex items-center justify-center">
                                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    </svg>
                                    Daftar Antrian
                                </span>
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        <div class="mt-8 text-center">
            <a href="<?php echo e(route('queue.index')); ?>" class="text-blue-600 hover:text-blue-800 dark:text-blue-400 dark:hover:text-blue-300 font-medium">
                ← Kembali ke Halaman Antrian
            </a>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            let currentStep = 1;
            const totalSteps = 4;

            // Step navigation functions
            function showStep(step) {
                // Hide all steps
                document.querySelectorAll('.step').forEach(s => s.classList.add('hidden'));

                // Show current step
                document.getElementById(`step${step}`).classList.remove('hidden');

                // Update step indicators
                updateStepIndicators(step);

                currentStep = step;
            }

            function updateStepIndicators(step) {
                for (let i = 1; i <= totalSteps; i++) {
                    const indicator = document.getElementById(`step${i}-indicator`);
                    const text = document.getElementById(`step${i}-text`);
                    const progress = document.getElementById(`progress${i}`);

                    if (i < step) {
                        // Completed step
                        indicator.className = 'flex items-center justify-center w-8 h-8 bg-green-600 text-white rounded-full text-sm font-medium';
                        indicator.innerHTML = '✓';
                        text.className = 'ml-2 text-sm font-medium text-green-600';
                        if (progress) progress.style.width = '100%';
                    } else if (i === step) {
                        // Current step
                        indicator.className = 'flex items-center justify-center w-8 h-8 bg-blue-600 text-white rounded-full text-sm font-medium';
                        indicator.innerHTML = i;
                        text.className = 'ml-2 text-sm font-medium text-blue-600';
                    } else {
                        // Future step
                        indicator.className = 'flex items-center justify-center w-8 h-8 bg-gray-200 dark:bg-slate-600 text-gray-500 rounded-full text-sm font-medium';
                        indicator.innerHTML = i;
                        text.className = 'ml-2 text-sm font-medium text-gray-500';
                        if (progress) progress.style.width = '0%';
                    }
                }
            }

            // Poli selection
            document.querySelectorAll('.poli-option').forEach(option => {
                option.addEventListener('click', function() {
                    // Remove selection from all options
                    document.querySelectorAll('.poli-option div').forEach(div => {
                        div.classList.remove('border-blue-500', 'bg-blue-50', 'dark:bg-blue-900/20');
                        div.classList.add('border-gray-200', 'dark:border-slate-600');
                    });

                    // Add selection to clicked option
                    const div = this.querySelector('div');
                    div.classList.remove('border-gray-200', 'dark:border-slate-600');
                    div.classList.add('border-blue-500', 'bg-blue-50', 'dark:bg-blue-900/20');

                    // Check the radio button
                    this.querySelector('input[type="radio"]').checked = true;

                    // Enable next button
                    document.getElementById('next-step1').disabled = false;
                });
            });

            // Step 1 next button
            document.getElementById('next-step1').addEventListener('click', function() {
                const selectedPoli = document.querySelector('input[name="poli"]:checked');
                if (selectedPoli) {
                    loadDoctors(selectedPoli.value);
                }
                showStep(2);
                document.getElementById('progress1').style.width = '100%';
            });

            // Step 2 validation
            function validateStep2() {
                const date = document.getElementById('visit_date').value;
                const time = document.getElementById('visit_time').value;
                const nextBtn = document.getElementById('next-step2');

                nextBtn.disabled = !(date && time);
            }

            // Step 2 navigation
              const prevStep2 = document.getElementById('prev-step2');
              const nextStep2 = document.getElementById('next-step2');

              if (prevStep2) {
                  prevStep2.addEventListener('click', function() {
                      showStep(1);
                      document.getElementById('progress1').style.width = '0%';
                  });
              }

              if (nextStep2) {
                  nextStep2.addEventListener('click', function() {
                      showStep(3);
                      document.getElementById('progress2').style.width = '100%';

                      // Load time slots if date is already selected
                      const selectedDate = document.getElementById('visit_date').value;
                      const selectedDoctor = document.querySelector('input[name="doctor_id"]:checked');
                      if (selectedDate && selectedDoctor) {
                          loadTimeSlots(selectedDoctor.value, selectedDate);
                      }
                  });
              }

              // Load doctors when poli is selected - this is handled in step 1 next button

             function loadDoctors(poliId) {
                 const doctorList = document.getElementById('doctor-list');

                 // Sample doctors data with quota
                 const doctors = {
                     'umum': [
                         { id: 1, name: 'Dr. Ahmad Santoso, Sp.PD', quota: 15, booked: 8 },
                         { id: 2, name: 'Dr. Siti Nurhaliza, Sp.PD', quota: 12, booked: 12 }, // Full quota
                         { id: 3, name: 'Dr. Budi Hartono, Sp.PD', quota: 10, booked: 3 }
                     ],
                     'gigi': [
                         { id: 4, name: 'Dr. Maya Sari, Sp.KG', quota: 8, booked: 5 },
                         { id: 5, name: 'Dr. Andi Wijaya, Sp.KG', quota: 10, booked: 10 }, // Full quota
                     ],
                     'mata': [
                         { id: 6, name: 'Dr. Lisa Permata, Sp.M', quota: 12, booked: 7 },
                         { id: 7, name: 'Dr. Rudi Setiawan, Sp.M', quota: 8, booked: 2 }
                     ],
                     'anak': [
                         { id: 8, name: 'Dr. Indira Sari, Sp.A', quota: 10, booked: 4 },
                         { id: 9, name: 'Dr. Bambang Sutrisno, Sp.A', quota: 8, booked: 6 }
                     ],
                     'kandungan': [
                         { id: 10, name: 'Dr. Ratna Dewi, Sp.OG', quota: 12, booked: 9 },
                         { id: 11, name: 'Dr. Hendra Kusuma, Sp.OG', quota: 10, booked: 10 } // Full quota
                     ]
                 };

                 const poliDoctors = doctors[poliId] || [];

                 doctorList.innerHTML = '';

                 poliDoctors.forEach(doctor => {
                     const isFullyBooked = doctor.booked >= doctor.quota;
                     const availableSlots = doctor.quota - doctor.booked;

                     const doctorCard = document.createElement('div');
                     doctorCard.className = `border rounded-lg p-4 cursor-pointer transition-all duration-200 ${
                         isFullyBooked
                             ? 'border-red-300 bg-red-50 dark:bg-red-900/20 dark:border-red-600 opacity-60 cursor-not-allowed'
                             : 'border-gray-300 dark:border-slate-600 hover:border-blue-500 dark:hover:border-blue-400 hover:bg-blue-50 dark:hover:bg-blue-900/20'
                     }`;

                     doctorCard.innerHTML = `
                         <div class="flex items-center justify-between">
                             <div class="flex items-center space-x-3">
                                 <input type="radio" name="doctor_id" value="${doctor.id}"
                                        class="w-4 h-4 text-blue-600 border-gray-300 focus:ring-blue-500"
                                        ${isFullyBooked ? 'disabled' : ''}>
                                 <div>
                                     <h4 class="font-medium text-gray-900 dark:text-white">${doctor.name}</h4>
                                     <p class="text-sm ${
                                         isFullyBooked
                                             ? 'text-red-600 dark:text-red-400'
                                             : 'text-green-600 dark:text-green-400'
                                     }">
                                         ${isFullyBooked ? 'Kuota Penuh' : `${availableSlots} slot tersedia`}
                                     </p>
                                 </div>
                             </div>
                             <div class="text-right">
                                 <div class="text-sm text-gray-500 dark:text-gray-400">
                                     ${doctor.booked}/${doctor.quota}
                                 </div>
                                 <div class="w-16 bg-gray-200 dark:bg-gray-700 rounded-full h-2 mt-1">
                                     <div class="${
                                         isFullyBooked ? 'bg-red-500' : 'bg-green-500'
                                     } h-2 rounded-full" style="width: ${(doctor.booked / doctor.quota) * 100}%"></div>
                                 </div>
                             </div>
                         </div>
                     `;

                     if (!isFullyBooked) {
                         doctorCard.addEventListener('click', function() {
                             const radio = doctorCard.querySelector('input[type="radio"]');
                             radio.checked = true;
                             validateStep2();
                         });
                     }

                     doctorList.appendChild(doctorCard);
                 });
             }

             // Step 2 validation
              function validateStep2() {
                  const selectedDoctor = document.querySelector('input[name="doctor_id"]:checked');
                  const nextBtn = document.getElementById('next-step2');

                  if (selectedDoctor) {
                      nextBtn.disabled = false;
                      // Update hidden input
                      document.getElementById('selected_doctor_id').value = selectedDoctor.value;
                  } else {
                      nextBtn.disabled = true;
                      document.getElementById('selected_doctor_id').value = '';
                  }
              }

              // Listen for doctor selection changes
              document.addEventListener('change', function(e) {
                  if (e.target.name === 'doctor_id') {
                      validateStep2();

                      // Load time slots if date is already selected
                      const selectedDate = document.getElementById('visit_date').value;
                      if (selectedDate) {
                          loadTimeSlots(e.target.value, selectedDate);
                      }
                  }
              });

            // Step 3 navigation
              const prevStep3 = document.getElementById('prev-step3');
              const nextStep3 = document.getElementById('next-step3');
              const visitDateInput = document.getElementById('visit_date');

              if (prevStep3) {
                  prevStep3.addEventListener('click', function() {
                      showStep(2);
                      document.getElementById('progress2').style.width = '0%';
                  });
              }

              if (nextStep3) {
                  nextStep3.addEventListener('click', function() {
                      showStep(4);
                      document.getElementById('progress3').style.width = '100%';
                  });
              }

              // Load time slots when date is selected
              if (visitDateInput) {
                  visitDateInput.addEventListener('change', function() {
                      const selectedDate = this.value;
                      const selectedDoctor = document.querySelector('input[name="doctor_id"]:checked');

                      if (selectedDate && selectedDoctor) {
                          loadTimeSlots(selectedDoctor.value, selectedDate);
                      }
                  });
              }

             function loadTimeSlots(doctorId, date) {
                 const timeSlotsContainer = document.getElementById('time-slots');

                 // Sample time slots with quota
                 const timeSlots = [
                     { time: '08:00', label: '08:00 - 09:00', quota: 3, booked: 1 },
                     { time: '09:00', label: '09:00 - 10:00', quota: 3, booked: 3 }, // Full
                     { time: '10:00', label: '10:00 - 11:00', quota: 3, booked: 0 },
                     { time: '11:00', label: '11:00 - 12:00', quota: 3, booked: 2 },
                     { time: '13:00', label: '13:00 - 14:00', quota: 3, booked: 1 },
                     { time: '14:00', label: '14:00 - 15:00', quota: 3, booked: 3 }, // Full
                     { time: '15:00', label: '15:00 - 16:00', quota: 3, booked: 0 },
                     { time: '16:00', label: '16:00 - 17:00', quota: 3, booked: 1 }
                 ];

                 timeSlotsContainer.innerHTML = '';

                 timeSlots.forEach(slot => {
                     const isFullyBooked = slot.booked >= slot.quota;
                     const availableSlots = slot.quota - slot.booked;

                     const slotCard = document.createElement('div');
                     slotCard.className = `border rounded-lg p-3 cursor-pointer transition-all duration-200 ${
                         isFullyBooked
                             ? 'border-red-300 bg-red-50 dark:bg-red-900/20 dark:border-red-600 opacity-60 cursor-not-allowed'
                             : 'border-gray-300 dark:border-slate-600 hover:border-blue-500 dark:hover:border-blue-400 hover:bg-blue-50 dark:hover:bg-blue-900/20'
                     }`;

                     slotCard.innerHTML = `
                         <div class="flex items-center justify-between mb-2">
                             <div class="flex items-center space-x-2">
                                 <input type="radio" name="visit_time" value="${slot.time}"
                                        class="w-4 h-4 text-blue-600 border-gray-300 focus:ring-blue-500"
                                        ${isFullyBooked ? 'disabled' : ''}>
                                 <span class="font-medium text-gray-900 dark:text-white">${slot.label}</span>
                             </div>
                         </div>
                         <div class="flex items-center justify-between">
                             <span class="text-xs ${
                                 isFullyBooked
                                     ? 'text-red-600 dark:text-red-400'
                                     : 'text-green-600 dark:text-green-400'
                             }">
                                 ${isFullyBooked ? 'Penuh' : `${availableSlots} tersisa`}
                             </span>
                             <div class="flex items-center space-x-1">
                                 <span class="text-xs text-gray-500 dark:text-gray-400">${slot.booked}/${slot.quota}</span>
                                 <div class="w-8 bg-gray-200 dark:bg-gray-700 rounded-full h-1">
                                     <div class="${
                                         isFullyBooked ? 'bg-red-500' : 'bg-green-500'
                                     } h-1 rounded-full" style="width: ${(slot.booked / slot.quota) * 100}%"></div>
                                 </div>
                             </div>
                         </div>
                     `;

                     if (!isFullyBooked) {
                         slotCard.addEventListener('click', function() {
                             const radio = slotCard.querySelector('input[type="radio"]');
                             radio.checked = true;
                             validateStep3();
                         });
                     }

                     timeSlotsContainer.appendChild(slotCard);
                 });
             }

             // Step 3 validation
              function validateStep3() {
                  const selectedDate = document.getElementById('visit_date').value;
                  const selectedTime = document.querySelector('input[name="visit_time"]:checked');
                  const nextBtn = document.getElementById('next-step3');

                  if (selectedDate && selectedTime) {
                      nextBtn.disabled = false;
                      // Update hidden input
                      document.getElementById('selected_visit_time').value = selectedTime.value;
                  } else {
                      nextBtn.disabled = true;
                      document.getElementById('selected_visit_time').value = '';
                  }
              }

              // Listen for time slot selection changes
              document.addEventListener('change', function(e) {
                  if (e.target.name === 'visit_time') {
                      validateStep3();
                  }
              });

            // NIK search functionality
             function searchPatientByNIK() {
                 const nikInput = document.getElementById('nik');
                 const nik = nikInput.value.trim();

                if (!nik) {
                    Swal.fire({
                        icon: 'warning',
                        title: 'Peringatan',
                        text: 'Silakan masukkan NIK terlebih dahulu'
                    });
                    return;
                }

                if (nik.length !== 16) {
                    Swal.fire({
                        icon: 'warning',
                        title: 'NIK Tidak Valid',
                        text: 'NIK harus terdiri dari 16 digit'
                    });
                    return;
                }

                // Show loading
                Swal.fire({
                    title: 'Mencari data pasien...',
                    allowOutsideClick: false,
                    didOpen: () => {
                        Swal.showLoading();
                    }
                });

                // Simulate API call - replace with actual API endpoint
                setTimeout(() => {
                    // Sample patient data - replace with actual API response
                     const samplePatients = {
                         '1234567890123456': {
                             name: 'Ahmad Wijaya',
                             phone: '081234567890',
                             gender: 'L',
                             age: '35'
                         },
                         '9876543210987654': {
                             name: 'Siti Nurhaliza',
                             phone: '087654321098',
                             gender: 'P',
                             age: '28'
                         },
                         '1111222233334444': {
                             name: 'Budi Santoso',
                             phone: '082111222333',
                             gender: 'L',
                             age: '42'
                         },
                         '5555666677778888': {
                             name: 'Dewi Lestari',
                             phone: '085555666777',
                             gender: 'P',
                             age: '31'
                         },
                         '3333444455556666': {
                             name: 'Rudi Hermawan',
                             phone: '083333444555',
                             gender: 'L',
                             age: '27'
                         },
                         '7777888899990000': {
                             name: 'Maya Sari',
                             phone: '087777888999',
                             gender: 'P',
                             age: '39'
                         },
                         '2222333344445555': {
                             name: 'Andi Pratama',
                             phone: '082222333444',
                             gender: 'L',
                             age: '33'
                         },
                         '8888999900001111': {
                             name: 'Rina Wati',
                             phone: '088888999000',
                             gender: 'P',
                             age: '26'
                         }
                     };

                    const patientData = samplePatients[nik];

                    if (patientData) {
                        // Patient found - populate hidden form fields for submission
                        document.getElementById('patient_name').value = patientData.name;
                        document.getElementById('phone_number').value = patientData.phone;
                        document.getElementById('gender').value = patientData.gender;
                        document.getElementById('age').value = patientData.age;

                        // Hide NIK search section
                        document.getElementById('nik-search-section').style.display = 'none';

                        // Show patient summary instead of editable form
                        const patientSummaryHtml = `
                            <div class="bg-gradient-to-r from-green-50 to-emerald-50 dark:from-green-900/20 dark:to-emerald-900/20 border-2 border-green-200 dark:border-green-800 rounded-xl p-6 mb-6">
                                <div class="flex items-center mb-4">
                                    <div class="text-green-600 dark:text-green-400 mr-3">
                                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                        </svg>
                                    </div>
                                    <div>
                                        <p class="text-lg font-bold text-green-800 dark:text-green-200">Data Pasien Ditemukan!</p>
                                        <p class="text-sm text-green-600 dark:text-green-300">Data siap untuk pendaftaran antrian</p>
                                    </div>
                                </div>

                                <div class="bg-white dark:bg-slate-800 rounded-lg p-4 space-y-3">
                                    <div class="flex justify-between items-center border-b border-gray-200 dark:border-slate-600 pb-2">
                                        <span class="text-sm font-medium text-gray-600 dark:text-gray-400">NIK:</span>
                                        <span class="text-sm font-semibold text-gray-900 dark:text-white">${nik}</span>
                                    </div>
                                    <div class="flex justify-between items-center border-b border-gray-200 dark:border-slate-600 pb-2">
                                        <span class="text-sm font-medium text-gray-600 dark:text-gray-400">Nama:</span>
                                        <span class="text-sm font-semibold text-gray-900 dark:text-white">${patientData.name}</span>
                                    </div>
                                    <div class="flex justify-between items-center border-b border-gray-200 dark:border-slate-600 pb-2">
                                        <span class="text-sm font-medium text-gray-600 dark:text-gray-400">Telepon:</span>
                                        <span class="text-sm font-semibold text-gray-900 dark:text-white">${patientData.phone}</span>
                                    </div>
                                    <div class="flex justify-between items-center border-b border-gray-200 dark:border-slate-600 pb-2">
                                        <span class="text-sm font-medium text-gray-600 dark:text-gray-400">Jenis Kelamin:</span>
                                        <span class="text-sm font-semibold text-gray-900 dark:text-white">${patientData.gender === 'L' ? 'Laki-laki' : 'Perempuan'}</span>
                                    </div>
                                    <div class="flex justify-between items-center">
                                        <span class="text-sm font-medium text-gray-600 dark:text-gray-400">Umur:</span>
                                        <span class="text-sm font-semibold text-gray-900 dark:text-white">${patientData.age} tahun</span>
                                    </div>
                                </div>

                                <div class="mt-4 text-center">
                                    <button type="button" onclick="backToNIKSearch()" class="px-4 py-2 bg-gray-500 hover:bg-gray-600 text-white rounded-lg font-medium transition-all duration-300">
                                        <span class="flex items-center justify-center">
                                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                                            </svg>
                                            Cari NIK Lain
                                        </span>
                                    </button>
                                </div>
                            </div>
                        `;

                        // Replace patient form section with summary
                        document.getElementById('patient-form-section').innerHTML = patientSummaryHtml;
                        document.getElementById('patient-form-section').classList.remove('hidden');

                        // Enable submit button since data is complete
                        document.getElementById('submit-form').disabled = false;

                        Swal.fire({
                            icon: 'success',
                            title: 'Data Ditemukan!',
                            text: `Data pasien ${patientData.name} berhasil ditemukan dan siap untuk pendaftaran`,
                            timer: 2000,
                            showConfirmButton: false
                        });
                    } else {
                        // Patient not found
                        Swal.fire({
                            icon: 'info',
                            title: 'Data Tidak Ditemukan',
                            text: 'NIK tidak ditemukan dalam database. Silakan daftar sebagai pasien baru.',
                            confirmButtonText: 'Daftar Pasien Baru',
                            showCancelButton: true,
                            cancelButtonText: 'Coba Lagi'
                        }).then((result) => {
                            if (result.isConfirmed) {
                                showNewPatientForm();
                            }
                        });
                    }
                }, 1500);
            }

            function showNewPatientForm() {
                 // Clear form
                 document.getElementById('patient_name').value = '';
                 document.getElementById('phone_number').value = '';
                 document.getElementById('gender').value = '';
                 document.getElementById('age').value = '';

                 // Reset readonly states and styling for new patient
                 const formFields = ['patient_name', 'phone_number', 'age'];
                 formFields.forEach(fieldId => {
                     const field = document.getElementById(fieldId);
                     field.readOnly = false;
                     field.classList.remove('bg-gray-100', 'dark:bg-slate-600', 'cursor-not-allowed');
                     field.classList.add('hover:border-purple-300');
                 });

                 const genderField = document.getElementById('gender');
                 genderField.disabled = false;
                 genderField.classList.remove('bg-gray-100', 'dark:bg-slate-600', 'cursor-not-allowed');

                 // Show patient data form
                 document.getElementById('nik-search-section').style.display = 'none';
                 document.getElementById('patient-form-section').classList.remove('hidden');
                 document.getElementById('patient-status-text').textContent = 'Silakan lengkapi data diri Anda';

                 // Focus on first input
                 document.getElementById('patient_name').focus();

                 validateStep4();
             }

             function backToNIKSearch() {
                 document.getElementById('nik-search-section').style.display = 'block';
                 document.getElementById('patient-form-section').classList.add('hidden');
                 document.getElementById('nik').value = '';

                 // Clear form
                 document.getElementById('patient_name').value = '';
                 document.getElementById('phone_number').value = '';
                 document.getElementById('gender').value = '';
                 document.getElementById('age').value = '';

                 // Reset patient form section to original form HTML
                 const originalFormHtml = `
                     <div class="bg-gradient-to-r from-blue-50 to-indigo-50 dark:from-blue-900/20 dark:to-indigo-900/20 border-2 border-blue-200 dark:border-blue-800 rounded-xl p-6 mb-6">
                         <div class="flex items-center">
                             <div class="text-blue-600 dark:text-blue-400 mr-3">
                                 <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                     <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                 </svg>
                             </div>
                             <div>
                                 <p class="text-sm font-semibold text-blue-800 dark:text-blue-200" id="patient-status-text">Data pasien ditemukan</p>
                             </div>
                         </div>
                     </div>

                     <div class="bg-gradient-to-r from-purple-50 to-pink-50 dark:from-purple-900/20 dark:to-pink-900/20 rounded-xl p-6 space-y-6">
                         <div>
                             <label for="patient_name" class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-3 flex items-center">
                                 <svg class="w-5 h-5 mr-2 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                     <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                 </svg>
                                 Nama Lengkap
                             </label>
                             <input type="text" id="patient_name" name="patient_name" class="w-full px-4 py-3 border-2 border-gray-200 dark:border-slate-600 rounded-xl focus:ring-2 focus:ring-purple-500 focus:border-purple-500 dark:bg-slate-700 dark:text-white transition-all duration-300 hover:border-purple-300" placeholder="Masukkan nama lengkap">
                         </div>

                         <div>
                             <label for="phone_number" class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-3 flex items-center">
                                 <svg class="w-5 h-5 mr-2 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                     <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path>
                                 </svg>
                                 Nomor Telepon
                             </label>
                             <input type="tel" id="phone_number" name="phone_number" class="w-full px-4 py-3 border-2 border-gray-200 dark:border-slate-600 rounded-xl focus:ring-2 focus:ring-purple-500 focus:border-purple-500 dark:bg-slate-700 dark:text-white transition-all duration-300 hover:border-purple-300" placeholder="08xxxxxxxxxx">
                         </div>

                         <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                             <div>
                                 <label for="gender" class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-3 flex items-center">
                                     <svg class="w-5 h-5 mr-2 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                         <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197m13.5-9a2.5 2.5 0 11-5 0 2.5 2.5 0 015 0z"></path>
                                     </svg>
                                     Jenis Kelamin
                                 </label>
                                 <select id="gender" name="gender" class="w-full px-4 py-3 border-2 border-gray-200 dark:border-slate-600 rounded-xl focus:ring-2 focus:ring-purple-500 focus:border-purple-500 dark:bg-slate-700 dark:text-white transition-all duration-300 hover:border-purple-300">
                                     <option value="">Pilih Jenis Kelamin</option>
                                     <option value="L">Laki-laki</option>
                                     <option value="P">Perempuan</option>
                                 </select>
                             </div>
                             <div>
                                 <label for="age" class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-3 flex items-center">
                                     <svg class="w-5 h-5 mr-2 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                         <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                     </svg>
                                     Umur
                                 </label>
                                 <input type="number" id="age" name="age" class="w-full px-4 py-3 border-2 border-gray-200 dark:border-slate-600 rounded-xl focus:ring-2 focus:ring-purple-500 focus:border-purple-500 dark:bg-slate-700 dark:text-white transition-all duration-300 hover:border-purple-300" placeholder="Masukkan umur" min="1" max="120">
                             </div>
                         </div>

                         <div>
                             <label for="complaint" class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-3 flex items-center">
                                 <svg class="w-5 h-5 mr-2 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                     <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                 </svg>
                                 Keluhan (Opsional)
                             </label>
                             <textarea id="complaint" name="complaint" rows="4" class="w-full px-4 py-3 border-2 border-gray-200 dark:border-slate-600 rounded-xl focus:ring-2 focus:ring-purple-500 focus:border-purple-500 dark:bg-slate-700 dark:text-white transition-all duration-300 hover:border-purple-300 resize-none" placeholder="Jelaskan keluhan Anda dengan detail..."></textarea>
                         </div>

                         <div class="text-center pt-4">
                             <button type="button" id="back-to-search" onclick="backToNIKSearch()" class="px-6 py-3 bg-gradient-to-r from-gray-500 to-gray-600 hover:from-gray-600 hover:to-gray-700 text-white rounded-xl font-semibold transition-all duration-300 transform hover:scale-[1.02] shadow-lg hover:shadow-xl">
                                 <span class="flex items-center justify-center">
                                     <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                         <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                                     </svg>
                                     Kembali ke Pencarian NIK
                                 </span>
                             </button>
                         </div>
                     </div>
                 `;

                 document.getElementById('patient-form-section').innerHTML = originalFormHtml;

                 // Disable submit button
                 document.getElementById('submit-form').disabled = true;

                 // Re-attach event listeners for form validation
                 const patientName = document.getElementById('patient_name');
                 const phoneNumber = document.getElementById('phone_number');
                 const genderSelect = document.getElementById('gender');
                 const ageInput = document.getElementById('age');

                 if (patientName) patientName.addEventListener('input', validateStep4);
                 if (phoneNumber) phoneNumber.addEventListener('input', validateStep4);
                 if (genderSelect) genderSelect.addEventListener('change', validateStep4);
                 if (ageInput) ageInput.addEventListener('input', validateStep4);
             }

            // Step 4 validation
            function validateStep4() {
                const name = document.getElementById('patient_name');
                const phone = document.getElementById('phone_number');
                const gender = document.getElementById('gender');
                const age = document.getElementById('age');
                const submitBtn = document.getElementById('submit-form');

                if (name && phone && gender && age && submitBtn) {
                    const isValid = name.value.trim() && phone.value.trim() && gender.value && age.value;
                    submitBtn.disabled = !isValid;
                }
            }

            // NIK search event listeners
             const nikSearchBtn = document.getElementById('search-nik');
             const newPatientBtn = document.getElementById('new-patient-btn');
             const nikInput = document.getElementById('nik');

            if (nikSearchBtn) {
                nikSearchBtn.addEventListener('click', searchPatientByNIK);
            }

            if (newPatientBtn) {
                newPatientBtn.addEventListener('click', showNewPatientForm);
            }

            if (nikInput) {
                nikInput.addEventListener('keypress', function(e) {
                    if (e.key === 'Enter') {
                        searchPatientByNIK();
                    }
                });

                // Only allow numbers
                nikInput.addEventListener('input', function(e) {
                    this.value = this.value.replace(/[^0-9]/g, '');
                    if (this.value.length > 16) {
                        this.value = this.value.slice(0, 16);
                    }
                });
            }

            const patientName = document.getElementById('patient_name');
            const phoneNumber = document.getElementById('phone_number');
            const genderSelect = document.getElementById('gender');
            const ageInput = document.getElementById('age');
            const prevStep4 = document.getElementById('prev-step4');

            if (patientName) patientName.addEventListener('input', validateStep4);
            if (phoneNumber) phoneNumber.addEventListener('input', validateStep4);
            if (genderSelect) genderSelect.addEventListener('change', validateStep4);
            if (ageInput) ageInput.addEventListener('input', validateStep4);

            // Step 4 navigation
            if (prevStep4) {
                prevStep4.addEventListener('click', function() {
                    showStep(3);
                    document.getElementById('progress3').style.width = '0%';
                });
            }

            // Form submission - Show dummy ticket immediately
            document.getElementById('registration-form').addEventListener('submit', async function(e) {
                e.preventDefault();

                // Generate dummy queue number
                const queueNumber = 'A' + String(Math.floor(Math.random() * 999) + 1).padStart(3, '0');

                // Get selected session time
                const selectedTimeSlot = document.querySelector('input[name="visit_time"]:checked');
                const selectedDate = document.getElementById('visit_date').value;
                const selectedPoli = document.querySelector('input[name="poli"]:checked');

                // Format session time for display
                let sessionTimeDisplay = 'Tidak dipilih';
                if (selectedTimeSlot) {
                    const timeValue = selectedTimeSlot.value;
                    const nextHour = String(parseInt(timeValue.split(':')[0]) + 1).padStart(2, '0');
                    sessionTimeDisplay = `${timeValue} - ${nextHour}:00`;
                }

                // Format date for display
                const dateDisplay = selectedDate ? new Date(selectedDate).toLocaleDateString('id-ID') : new Date().toLocaleDateString('id-ID');

                // Get poli name
                const poliNames = {
                    'umum': 'Poli Umum',
                    'gigi': 'Poli Gigi',
                    'mata': 'Poli Mata',
                    'anak': 'Poli Anak',
                    'kandungan': 'Poli Kandungan'
                };
                const poliDisplay = selectedPoli ? poliNames[selectedPoli.value] || 'Poli Umum' : 'Poli Umum';

                // Show dummy ticket immediately
                 Swal.fire({
                     icon: 'success',
                     title: 'Pendaftaran Berhasil!',
                     html: `
                         <div class="text-center">
                             <div class="text-4xl mb-4">🎫</div>
                             <h3 class="text-xl font-bold mb-2">Nomor Antrian Anda</h3>
                             <div class="text-3xl font-bold text-blue-600 mb-4">${queueNumber}</div>
                             <p class="text-gray-600">Silakan datang sesuai jadwal yang telah dipilih</p>
                             <p class="text-sm text-gray-500 mt-2">Simpan nomor antrian ini untuk referensi</p>
                             <div class="mt-4 p-3 bg-gray-50 rounded-lg">
                                 <p class="text-xs text-gray-500">Estimasi waktu tunggu: 15-30 menit</p>
                                 <p class="text-xs text-gray-500">${poliDisplay} | Tanggal: ${dateDisplay}</p>
                                 <p class="text-xs text-gray-500">Sesi: ${sessionTimeDisplay}</p>
                             </div>
                         </div>
                     `,
                     confirmButtonText: '🖨️ Cetak Antrian',
                     confirmButtonColor: '#3B82F6',
                     showCloseButton: true,
                     closeButtonAriaLabel: 'Tutup',
                     allowOutsideClick: false,
                     customClass: {
                         closeButton: 'swal2-close-custom'
                     }
                 }).then((result) => {
                     if (result.isConfirmed) {
                         // Print functionality
                         const printContent = `
                             <div style="text-align: center; font-family: Arial, sans-serif; padding: 20px;">
                                 <h2>🏥 BR Health</h2>
                                 <h3>Tiket Antrian</h3>
                                 <div style="font-size: 48px; font-weight: bold; color: #2563eb; margin: 20px 0;">${queueNumber}</div>
                                 <p>${poliDisplay}</p>
                                 <p>Tanggal: ${dateDisplay}</p>
                                 <p>Sesi: ${sessionTimeDisplay}</p>
                                 <p>Waktu Cetak: ${new Date().toLocaleTimeString('id-ID')}</p>
                                 <p style="margin-top: 20px; font-size: 12px;">Estimasi waktu tunggu: 15-30 menit</p>
                                 <p style="font-size: 12px;">Harap simpan tiket ini sebagai bukti antrian</p>
                             </div>
                         `;
                         const printWindow = window.open('', '_blank');
                         printWindow.document.write(printContent);
                         printWindow.document.close();
                         printWindow.print();
                         printWindow.close();
                     }
                 });
            });

            // Set minimum date to today
            document.getElementById('visit_date').min = new Date().toISOString().split('T')[0];
        });
    </script>
</body>
</html>
<?php /**PATH /Users/macbookair/Documents/mediction/mediction.id/resources/views/queue/register.blade.php ENDPATH**/ ?>