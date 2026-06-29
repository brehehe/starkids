<div>
    
    <div class="min-h-dvh bg-slate-100">
        
        <div class="relative overflow-hidden rounded-b-[42px] bg-gradient-to-b from-sky-400 to-sky-600 h-[290px]">
            
            <div class="absolute -bottom-12 -right-16 w-[360px] h-[360px] opacity-15">
                <img src="<?php echo e(asset('asset/img/mobile/logo-starkids-1.png')); ?>" alt="<?php echo e(config('app.name')); ?>"
                    class="w-full h-full object-contain" />
            </div>

            
            <div class="absolute -bottom-14 left-1/2 -translate-x-1/2 w-[130%] h-32 bg-slate-100 rounded-t-[100%]">
            </div>

            
            <div class="pt-[max(env(safe-area-inset-top),0.75rem)]"></div>

            
            <div class="relative z-10 px-5 pt-3 flex items-center justify-between">
                <div class="text-white font-extrabold text-[17px]">
                    Profile
                </div>

                <button type="button" class="text-white">
                    <svg class="w-5 h-5" viewBox="0 0 24 24" fill="none">
                        <path d="M4 20h4l10-10-4-4L4 16v4Z" stroke="currentColor" stroke-width="2"
                            stroke-linejoin="round" />
                        <path d="M13 7l4 4" stroke="currentColor" stroke-width="2" stroke-linecap="round" />
                    </svg>
                </button>
            </div>
        </div>

        
        <div class="relative z-20 -mt-52 px-5 pb-8">
            
            <div
                class="w-72 mx-auto rounded-2xl bg-white shadow-[0_10px_30px_rgba(15,23,42,0.10)] border border-slate-100 p-5 text-center">
                <div class="mx-auto w-36 h-36 rounded-full overflow-hidden bg-slate-100">
                    <img src="<?php echo e(asset('asset/img/mobile/male-profile.png')); ?>" alt="Profile"
                        class="w-full h-full object-cover"
                        onerror="this.src='https://placehold.co/300x300/png?text=Profile';" />
                </div>

                <div class="mt-5 text-sky-400 font-extrabold text-[20px] leading-tight">
                    <?php echo e($user?->name); ?>

                </div>

                <div class="mt-1 text-sky-400 text-[14px] leading-tight">
                    <?php echo e($user?->email ?? '-'); ?>

                </div>

                <div class="mt-1 text-sky-400 text-[14px] leading-tight">
                    No.RM : <?php echo e($medicalRecordNumber); ?>

                </div>
            </div>

            
            <div class="mt-10 space-y-4">
                
                <a href="<?php echo e(route('mobile.profile-account')); ?>"
                    class="flex items-center justify-between rounded-2xl bg-white px-5 py-4 shadow-[0_10px_25px_rgba(15,23,42,0.10)] border border-slate-100">
                    <div class="flex items-center gap-3">
                        <div class="text-sky-400">
                            <svg class="w-6 h-6" viewBox="0 0 24 24" fill="none">
                                <path d="M12 12a4 4 0 1 0-4-4 4 4 0 0 0 4 4Z" stroke="currentColor" stroke-width="2" />
                                <path d="M4 20a8 8 0 0 1 16 0" stroke="currentColor" stroke-width="2"
                                    stroke-linecap="round" />
                                <path d="M19 7h2M20 6v2" stroke="currentColor" stroke-width="2"
                                    stroke-linecap="round" />
                            </svg>
                        </div>
                        <div class="text-slate-900 font-semibold text-[15px]">
                            Informasi Akun
                        </div>
                    </div>

                    <div class="text-slate-900">
                        <svg class="w-5 h-5" viewBox="0 0 24 24" fill="none">
                            <path d="M9 6l6 6-6 6" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                stroke-linejoin="round" />
                        </svg>
                    </div>
                </a>

                <a href="#"
                    class="flex items-center justify-between rounded-2xl bg-white px-5 py-4 shadow-[0_10px_25px_rgba(15,23,42,0.10)] border border-slate-100">
                    <div class="flex items-center gap-3">
                        <div class="text-sky-400">
                            <svg class="w-6 h-6" viewBox="0 0 24 24" fill="none">
                                <path d="M17 21a4 4 0 0 0-8 0" stroke="currentColor" stroke-width="2"
                                    stroke-linecap="round" />
                                <path d="M7 21a4 4 0 0 0-4-4" stroke="currentColor" stroke-width="2"
                                    stroke-linecap="round" />
                                <path d="M17 21a4 4 0 0 1 4-4" stroke="currentColor" stroke-width="2"
                                    stroke-linecap="round" />
                                <path d="M12 11a4 4 0 1 0-4-4 4 4 0 0 0 4 4Z" stroke="currentColor" stroke-width="2" />
                                <path d="M5 13a3 3 0 1 0-3-3 3 3 0 0 0 3 3Z" stroke="currentColor" stroke-width="2" />
                                <path d="M19 13a3 3 0 1 0-3-3 3 3 0 0 0 3 3Z" stroke="currentColor" stroke-width="2" />
                            </svg>
                        </div>
                        <div class="text-slate-900 font-semibold text-[15px]">
                            Pasien Lain
                        </div>
                    </div>

                    <div class="text-slate-900">
                        <svg class="w-5 h-5" viewBox="0 0 24 24" fill="none">
                            <path d="M9 6l6 6-6 6" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                stroke-linejoin="round" />
                        </svg>
                    </div>
                </a>

                <a href="#" wire:click="showMedicalRecordNumber"
                    class="flex items-center justify-between rounded-2xl bg-white px-5 py-4 shadow-[0_10px_25px_rgba(15,23,42,0.10)] border border-slate-100">
                    <div class="flex items-center gap-3">
                        <div class="text-sky-400">
                            <svg class="w-6 h-6" viewBox="0 0 24 24" fill="none">
                                <rect x="3" y="5" width="18" height="14" rx="2" stroke="currentColor"
                                    stroke-width="2" />
                                <path d="M3 10h18" stroke="currentColor" stroke-width="2" />
                            </svg>
                        </div>
                        <div class="text-slate-900 font-semibold text-[15px]">
                            Kartu Pasien
                        </div>
                    </div>

                    <div class="text-slate-900">
                        <svg class="w-5 h-5" viewBox="0 0 24 24" fill="none">
                            <path d="M9 6l6 6-6 6" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                stroke-linejoin="round" />
                        </svg>
                    </div>
                </a>

                <a href="#"
                    class="flex items-center justify-between rounded-2xl bg-white px-5 py-4 shadow-[0_10px_25px_rgba(15,23,42,0.10)] border border-slate-100">
                    <div class="flex items-center gap-3">
                        <div class="text-sky-400">
                            <svg class="w-6 h-6" viewBox="0 0 24 24" fill="none">
                                <rect x="5" y="11" width="14" height="10" rx="2" stroke="currentColor"
                                    stroke-width="2" />
                                <path d="M8 11V8a4 4 0 1 1 8 0v3" stroke="currentColor" stroke-width="2"
                                    stroke-linecap="round" />
                            </svg>
                        </div>
                        <div class="text-slate-900 font-semibold text-[15px]">
                            Ubah Password
                        </div>
                    </div>

                    <div class="text-slate-900">
                        <svg class="w-5 h-5" viewBox="0 0 24 24" fill="none">
                            <path d="M9 6l6 6-6 6" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                stroke-linejoin="round" />
                        </svg>
                    </div>
                </a>

                
                <a href="#" wire:click="openModalLogout"
                    class="flex items-center justify-between rounded-2xl bg-white px-5 py-4 shadow-[0_10px_25px_rgba(15,23,42,0.10)] border border-slate-100">
                    <div class="flex items-center gap-3">
                        <div class="text-rose-500">
                            <svg class="w-6 h-6" viewBox="0 0 24 24" fill="none">
                                <path d="M15 17l5-5-5-5" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                    stroke-linejoin="round" />
                                <path d="M20 12H9" stroke="currentColor" stroke-width="2" stroke-linecap="round" />
                                <path d="M11 4H7a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h4" stroke="currentColor"
                                    stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                            </svg>
                        </div>
                        <div class="text-slate-900 font-semibold text-[15px]">
                            Keluar
                        </div>
                    </div>

                    <div class="text-slate-900">
                        <svg class="w-5 h-5" viewBox="0 0 24 24" fill="none">
                            <path d="M9 6l6 6-6 6" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                stroke-linejoin="round" />
                        </svg>
                    </div>
                </a>
            </div>
        </div>
    </div>

    
    <div wire:ignore.self id="modal-logout"
        class="fixed inset-0 bg-overlay hidden items-center justify-center z-50 transition-opacity duration-300 ease-in-out">
        <div
            class="bg-white rounded-2xl shadow-2xl max-w-lg w-full transform transition-all scale-95 duration-300 ease-out animate-fade-in">
            <!-- Header -->
            <div class="flex justify-between items-center p-6 border-b">
                <div class="flex items-center gap-2">
                    <svg class="w-6 h-6 text-sky-500" fill="none" stroke="currentColor" stroke-width="2"
                        viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M13 16h-1v-4h-1m1-4h.01M12 20.5C6.753 20.5 2.5 16.247 2.5 11S6.753 1.5 12 1.5 21.5 5.753 21.5 11 17.247 20.5 12 20.5z" />
                    </svg>
                    <h2 class="text-xl font-semibold text-gray-800">Pemberitahuan</h2>
                </div>
                <button wire:click="closeModal('modal-logout')"
                    class="text-gray-500 hover:text-red-500 transition-colors text-2xl leading-none cursor-pointer">
                    &times;
                </button>
            </div>

            <!-- Body -->
            <div class="px-6 py-4 text-gray-700 font-medium">
                <p>Apakah Anda yakin akan keluar aplikasi !</p>
            </div>

            <!-- Footer -->
            <div class="flex justify-end gap-2 px-6 py-4 border-t">
                <button wire:click="closeModal('modal-logout')"
                    class="px-4 py-2 bg-gray-200 hover:bg-gray-300 text-gray-800 rounded-lg shadow transition cursor-pointer">
                    Batal
                </button>
                <button wire:click='logout'
                    class="px-4 py-2 bg-sky-500 hover:bg-sky-600 text-white rounded-lg shadow transition">
                    Keluar
                </button>
            </div>
        </div>
    </div>

    
    <div wire:ignore.self id="modal-rm"
        class="fixed inset-0 bg-overlay hidden items-center justify-center z-50 transition-opacity duration-300 ease-in-out">
        <div
            class="bg-white rounded-2xl shadow-2xl max-w-lg w-full transform transition-all scale-95 duration-300 ease-out animate-fade-in">
            <!-- Header -->
            <div class="flex justify-between items-center p-6 border-b">
                <div class="flex items-center gap-2">
                    <svg class="w-6 h-6 text-sky-500" fill="none" stroke="currentColor" stroke-width="2"
                        viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M13 16h-1v-4h-1m1-4h.01M12 20.5C6.753 20.5 2.5 16.247 2.5 11S6.753 1.5 12 1.5 21.5 5.753 21.5 11 17.247 20.5 12 20.5z" />
                    </svg>
                    <h2 class="text-xl font-semibold text-gray-800">Kartu Pasien</h2>
                </div>
                <button wire:click="closeModal('modal-rm')"
                    class="text-gray-500 hover:text-red-500 transition-colors text-2xl leading-none cursor-pointer">
                    &times;
                </button>
            </div>

            <!-- Body -->
            <div class="px-6 py-6">
                <div class="flex flex-col items-center justify-center text-center">
                    <div class="bg-white p-4 rounded-xl border border-gray-200 shadow-sm">
                        <img src="data:image/png;base64,<?php echo e($qrCode); ?>" alt="QR Code"
                            class="mx-auto w-52 h-52 object-contain">
                    </div>

                    <div class="mt-4">
                        <p class="text-sm text-gray-500">Nomor Rekam Medis</p>
                        <p class="mt-1 text-lg font-semibold text-gray-800 tracking-wide break-all">
                            <?php echo e($medicalRecordNumber); ?>

                        </p>
                    </div>
                </div>
            </div>

            <!-- Footer -->
            <div class="flex justify-end gap-2 px-6 py-4 border-t">
                <button wire:click="closeModal('modal-rm')"
                    class="px-4 py-2 bg-gray-200 hover:bg-gray-300 text-gray-800 rounded-lg shadow transition cursor-pointer">
                    Tutup
                </button>
                
            </div>
        </div>
    </div>
</div><?php /**PATH /Users/macbookair/Documents/mediction/mediction.id/resources/views/livewire/mobile/profile/profile-index.blade.php ENDPATH**/ ?>