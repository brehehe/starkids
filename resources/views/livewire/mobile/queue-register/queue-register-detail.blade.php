<div>
    {{-- Stop trying to control. --}}
    <div class="min-h-dvh bg-slate-100">
        {{-- HERO (full bleed / breakout dari padding layout) --}}
        <div class="px-5 sm:px-6 relative z-0 overflow-hidden rounded-b-3xl
                    bg-gradient-to-b from-sky-400 to-sky-600 h-80">

            {{-- bubbles --}}
            {{-- <div class="absolute -top-24 -left-28 w-72 h-72 rounded-full bg-white/10"></div> --}}
            <div class="absolute -bottom-16 -right-20 w-[400px] h-[400px] rounded-full">
                <img src="{{ asset('asset/img/mobile/logo-starkids-1.png') }}" alt="{{config('app.name')}}"
                    class="drop-shadow-md opacity-15" />
            </div>

            {{-- safe top --}}
            <div class="pt-[max(env(safe-area-inset-top),0.9rem)]"></div>

            {{-- TOP BAR + DOCTOR --}}
            <div class="relative z-10 px-5 sm:px-6 pt-2">
                <div class="flex items-center gap-3">
                    <a href="{{ route('mobile.home') }}"
                        class="w-8 h-8 rounded-full bg-white/95 text-slate-800 shadow flex items-center justify-center active:scale-[0.98] transition -ml-6"
                        aria-label="Back">
                        <svg class="w-5 h-5" viewBox="0 0 24 24" fill="none">
                            <path d="M15 18l-6-6 6-6" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                stroke-linejoin="round" />
                        </svg>
                    </a>
                    <div class="text-white font-extrabold text-xl">
                        Detail Antrian
                    </div>
                </div>

                {{-- Doctor info --}}
                <div class="mt-6 flex flex-col items-center text-center">
                    <div class="w-32 h-32 rounded-[26px] bg-white/95 shadow-xl overflow-hidden ring-4 ring-white/50">
                        <img src="{{ $doctorAvatar }}" alt="{{ $doctorName }}" class="w-full h-full object-cover"
                            onerror="this.src='https://placehold.co/240x240/png?text=Doctor';" />
                    </div>

                    <div class="mt-4 text-white font-bold text-xl sm:text-xl md:text-2xl leading-tight truncate">
                        {{ $doctorName }}
                    </div>
                </div>
            </div>
        </div>

        {{-- CONTENT (JANGAN pakai -mt, pakai translate biar tidak ketutup) --}}
        <div class="px-5 sm:px-6 pb-14 -mt-3">
            <div class="relative z-10 -translate-y-10 space-y-5">
                {{-- CARD 1: Antrian sedang dilayani --}}
                <div class="rounded-[28px] bg-sky-100 p-4 shadow-[0_16px_40px_rgba(15,23,42,0.12)]">
                    <div class="rounded-[22px] bg-white p-5 border border-slate-100">
                        <div class="text-center font-extrabold text-slate-900">
                            Antrian Sedang Dilayani
                        </div>

                        <div
                            class="mt-3 text-center text-sky-500 font-extrabold tracking-tight text-[68px] leading-none">
                            {{ $currentQueueNumber }}
                        </div>

                        <div class="mt-5 grid grid-cols-2 gap-4">
                            <div class="text-center">
                                <div class="text-[12px] text-slate-500 font-semibold">Jumlah Antrian</div>
                                <div class="mt-1 text-sky-500 font-extrabold text-xl">{{ $queueCount }}</div>
                            </div>

                            <div class="text-center">
                                <div class="text-[12px] text-slate-500 font-semibold">Tanggal Pemeriksaan</div>
                                <div class="mt-1 text-sky-500 font-extrabold text-xl">{{ $checkupDate }}</div>
                            </div>
                        </div>

                        <div class="my-5 h-px bg-slate-200"></div>

                        {{-- <div class="text-center">
                            <div class="text-[12px] text-slate-500 font-semibold">Status Kedatangan Dokter</div>
                            <div class="mt-1 text-sky-500 font-extrabold text-xl">
                                {{ $doctorStatus }}
                            </div>
                        </div> --}}
                    </div>
                </div>

                {{-- divider line --}}
                <div class="h-px bg-sky-300/60"></div>

                {{-- CARD: Queue Ticket --}}
                <div
                    class="relative rounded-[30px] bg-gradient-to-br from-sky-400 via-sky-500 to-cyan-500 p-[1.5px] shadow-[0_18px_45px_rgba(14,165,233,0.28)]">
                    <div class="relative rounded-[29px] bg-white overflow-hidden">
                        {{-- decorative blur / bubbles --}}
                        <div
                            class="pointer-events-none absolute -top-10 -right-10 w-36 h-36 rounded-full bg-sky-100/80 blur-2xl">
                        </div>
                        <div
                            class="pointer-events-none absolute -bottom-12 -left-10 w-40 h-40 rounded-full bg-cyan-100/70 blur-2xl">
                        </div>

                        {{-- header --}}
                        <div class="relative px-5 pt-5 pb-4">
                            <div class="flex items-start justify-between gap-3">
                                <div>
                                    <div class="mt-1 text-base font-extrabold text-slate-900">
                                        Nomor Antrian Anda
                                    </div>
                                </div>

                                {{-- status chip (opsional) --}}
                                <div
                                    class="shrink-0 inline-flex items-center gap-1.5 rounded-full bg-emerald-50 text-emerald-600 px-3 py-1 text-[11px] font-bold border border-emerald-100">
                                    <span class="w-1.5 h-1.5 rounded-full bg-emerald-400 animate-pulse"></span>
                                    Aktif
                                </div>
                            </div>

                            {{-- queue number --}}
                            <div class="mt-4 flex items-center justify-center">
                                <div class="relative">
                                    <div class="absolute inset-0 blur-xl bg-emerald-200/60 rounded-full"></div>
                                    <div class="relative px-6 py-2 rounded-2xl bg-emerald-50 border border-emerald-100">
                                        <div
                                            class="text-center text-emerald-500 font-black tracking-tight text-[64px] leading-none">
                                            {{ $yourQueueNumber ?? '—' }}
                                        </div>
                                    </div>
                                </div>
                            </div>

                            {{-- label klinik --}}
                            {{-- <div class="mt-3 text-center">
                                <div
                                    class="inline-flex items-center rounded-full bg-slate-100 text-slate-700 px-3 py-1 text-xs font-bold">
                                    {{ $clinicLabel ?? 'Klinik / Lokasi' }}
                                </div>
                            </div> --}}
                        </div>

                        {{-- ticket separator --}}
                        <div class="relative px-4">
                            <div class="absolute -left-3 top-1/2 -translate-y-1/2 w-6 h-6 rounded-full bg-slate-100">
                            </div>
                            <div class="absolute -right-3 top-1/2 -translate-y-1/2 w-6 h-6 rounded-full bg-slate-100">
                            </div>
                            <div class="border-t border-dashed border-slate-300"></div>
                        </div>

                        {{-- detail info --}}
                        <div class="relative px-5 py-4">
                            <div class="grid grid-cols-1 gap-3">
                                {{-- Tanggal Pemeriksaan --}}
                                <div class="flex items-start gap-3 rounded-2xl bg-slate-50 border border-slate-100 p-3">
                                    <div
                                        class="w-9 h-9 rounded-xl bg-sky-100 text-sky-600 flex items-center justify-center shrink-0">
                                        <svg class="w-4 h-4" viewBox="0 0 24 24" fill="none">
                                            <path d="M8 3v3M16 3v3M4 9h16" stroke="currentColor" stroke-width="2"
                                                stroke-linecap="round" />
                                            <rect x="4" y="5" width="16" height="15" rx="2" stroke="currentColor"
                                                stroke-width="2" />
                                        </svg>
                                    </div>
                                    <div class="min-w-0">
                                        <div class="text-[11px] font-bold uppercase tracking-wide text-slate-500">
                                            Tanggal Pemeriksaan</div>
                                        <div class="text-sm font-extrabold text-slate-900 leading-snug">
                                            {{ $selectedDateLabel ?? '-' }}
                                        </div>
                                    </div>
                                </div>

                                {{-- Poli + Dokter --}}
                                <div class="gap-3">
                                    <div
                                        class="flex items-start gap-3 rounded-2xl bg-slate-50 border border-slate-100 p-3">
                                        <div
                                            class="w-9 h-9 rounded-xl bg-violet-100 text-violet-600 flex items-center justify-center shrink-0">
                                            <svg class="w-4 h-4" viewBox="0 0 24 24" fill="none">
                                                <path d="M4 10l8-6 8 6v9a1 1 0 0 1-1 1h-4v-5H9v5H5a1 1 0 0 1-1-1v-9Z"
                                                    stroke="currentColor" stroke-width="2" stroke-linejoin="round" />
                                            </svg>
                                        </div>
                                        <div class="min-w-0">
                                            <div class="text-[11px] font-bold uppercase tracking-wide text-slate-500">
                                                Poli</div>
                                            <div class="text-sm font-extrabold text-slate-900 truncate">
                                                {{ $selectedPoliName ?? '-' }}
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                {{-- Jadwal Dokter --}}
                                <div class="flex items-start gap-3 rounded-2xl bg-sky-50 border border-sky-100 p-3">
                                    <div
                                        class="w-9 h-9 rounded-xl bg-amber-100 text-amber-600 flex items-center justify-center shrink-0">
                                        <svg class="w-4 h-4" viewBox="0 0 24 24" fill="none">
                                            <path d="M12 7v5l3 2" stroke="currentColor" stroke-width="2"
                                                stroke-linecap="round" stroke-linejoin="round" />
                                            <path d="M12 22a10 10 0 1 0-10-10 10 10 0 0 0 10 10Z" stroke="currentColor"
                                                stroke-width="2" />
                                        </svg>
                                    </div>
                                    <div class="min-w-0">
                                        <div class="text-[11px] font-bold uppercase tracking-wide text-slate-500">Jadwal
                                            Dokter</div>
                                        <div class="text-sm font-extrabold text-slate-900">
                                            {{ $selectedDoctorSchedule ?? '-' }}
                                        </div>
                                        <div class="mt-1 text-xs text-slate-500">
                                            Harap datang 15 menit sebelum jadwal.
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>

            {{-- kompensasi gap karena translate (supaya tinggi halaman normal) --}}
            <div class="-mt-10"></div>
        </div>

        {{-- safe bottom --}}
        {{-- <div class="pb-[max(env(safe-area-inset-bottom),0px)]"></div> --}}
    </div>
</div>