<div>
    {{-- To attain knowledge, add things every day; To attain wisdom, subtract things every day. --}}
    @php
        $blue = 'from-sky-400 via-sky-500 to-sky-600';
    @endphp

    <div class="min-h-dvh bg-slate-100">
        {{-- HERO TOP AREA --}}
        <div class="relative overflow-hidden rounded-b-2xl bg-gradient-to-b {{ $blue }}">
            {{-- safe padding top --}}
            <div class="pt-[max(env(safe-area-inset-top),1.25rem)] sm:pt-2 md:pt-4"></div>

            {{-- TOP BAR --}}
            <div class="px-3 pt-2 pb-5">
                <div class="flex items-center gap-3">
                    {{-- Avatar --}}
                    <img
                        src="{{ asset('asset/img/mobile/profile.png') }}"
                        alt="Avatar"
                        class="w-10 h-10 rounded-full object-cover ring-2 ring-white/70"
                        onerror="this.src='https://placehold.co/80x80/png';"
                    />

                    {{-- Search --}}
                    <div class="flex-1">
                        <div class="relative">
                            <input
                                wire:model.live.debounce.300ms="search"
                                placeholder="Cari Nama Dokter dan Pelayanan"
                                class="w-full h-11 rounded-full bg-white/95 shadow
                                    pl-5 pr-12 text-sm text-slate-700 placeholder:text-slate-400
                                    outline-none focus:ring-4 focus:ring-sky-500/20"
                            />
                            <button type="button"
                                    class="absolute right-1.5 top-1/2 -translate-y-1/2
                                        w-9 h-9 rounded-full bg-sky-500 text-white flex items-center justify-center shadow">
                                <svg class="w-5 h-5" viewBox="0 0 24 24" fill="none">
                                    <circle cx="11" cy="11" r="7" stroke="currentColor" stroke-width="2"/>
                                    <path d="M20 20l-3.5-3.5" stroke="currentColor" stroke-width="2" stroke-linecap="round"/>
                                </svg>
                            </button>
                        </div>
                    </div>

                    {{-- Notification --}}
                    {{-- <button type="button" class="relative w-10 h-10 rounded-full bg-white/20 text-white flex items-center justify-center">
                        <svg class="w-6 h-6" viewBox="0 0 24 24" fill="none">
                            <path d="M15 17H9c-1.7 0-3-1.3-3-3v-3a6 6 0 0 1 12 0v3c0 1.7-1.3 3-3 3Z"
                                stroke="currentColor" stroke-width="2" stroke-linejoin="round"/>
                            <path d="M10 19a2 2 0 0 0 4 0" stroke="currentColor" stroke-width="2" stroke-linecap="round"/>
                        </svg>
                        <span class="absolute -top-1 -right-1 min-w-5 h-5 px-1 rounded-full bg-rose-500 text-[10px] font-bold
                                    flex items-center justify-center">
                            99+
                        </span>
                    </button> --}}
                </div>

                {{-- Hero title + illustration --}}
                <div class="mt-8 flex items-end gap-4">
                    <div class="flex-1 pb-2">
                        <h1 class="text-white text-5xl sm:text-8xl font-extrabold leading-none tracking-tight">
                            Yuk !
                        </h1>
                        <p class="mt-2 text-white/90 text-sm sm:text-lg">
                            Periksakan Kesehatan Anda
                        </p>
                    </div>

                    <img
                        src="{{ asset('asset/img/mobile/header-home.png') }}"
                        alt="Doctors"
                        class="w-48 sm:w-64 drop-shadow-xl"
                        onerror="this.src='https://placehold.co/400x300/png?text=Doctors';"
                    />
                </div>
            </div>

            {{-- decorative bubbles --}}
            <div class="absolute -bottom-20 -right-28 w-72 h-72 rounded-full bg-white/10"></div>
            <div class="absolute -top-24 -left-24 w-64 h-64 rounded-full bg-white/10"></div>
        </div>

        {{-- CONTENT --}}
        <div class="py-5 px-2 space-y-4">
            {{-- Banner "Selamat Pagi" --}}
            {{-- <div class="relative overflow-hidden rounded-2xl shadow bg-white">
                <img
                    src="{{ asset('images/banner-morning.jpg') }}"
                    alt="Banner"
                    class="h-24 w-full object-cover"
                    onerror="this.src='https://placehold.co/900x260/png?text=Banner';"
                />
                <div class="absolute right-3 bottom-3">
                    <span class="inline-flex items-center rounded-full bg-slate-900/70 px-3 py-1 text-xs font-semibold text-white">
                        Selamat Pagi
                    </span>
                </div>
            </div> --}}

            {{-- Promo Banner --}}
            {{-- <div class="overflow-hidden rounded-2xl shadow bg-white">
                <img
                    src="{{ asset('images/promo.jpg') }}"
                    alt="Promo"
                    class="h-28 w-full object-cover"
                    onerror="this.src='https://placehold.co/900x300/png?text=Promo';"
                />
            </div> --}}

            {{-- CTA Immunisasi --}}
            {{-- <a href="#"
            class="block rounded-2xl border border-orange-200 bg-orange-50 px-4 py-4 text-center shadow-sm">
                <span class="text-sm font-semibold text-slate-800">
                    Ingin Melihat Jadwal Imunisasi ?
                </span>
                <span class="text-sm font-extrabold text-sky-600"> Lihat Disini</span>
            </a> --}}

            {{-- Queue Card Slider (INLINE, bukan modal) --}}
            @if ($queueRegisters)
                <section class="-mt-2" x-data="queueSlider()" x-init="init()">
                    <div
                        x-ref="track"
                        @scroll.debounce.50ms="syncIndex"
                        class="flex gap-4 overflow-x-auto scroll-smooth snap-x snap-mandatory scrollbar-hide px-1"
                    >
                        @foreach($queueRegisters as $i => $q)
                            <div class="min-w-full snap-center" data-slide>
                                <a href="{{ route('mobile.queue.register.detail', $q['id']) }}">
                                    <div class="rounded-[28px] bg-white border border-slate-200 shadow-[0_10px_24px_rgba(15,23,42,0.08)] px-5 py-6">
                                        {{-- Header nama pasien --}}
                                        <div class="text-center">
                                            <div class="text-black font-extrabold text-[20px] leading-tight">
                                                Nama Pasien
                                            </div>
                                            <div class="mt-1 text-sky-400 font-extrabold text-[21px] sm:text-[24px] leading-tight truncate">
                                                {{ $q['patient_name'] }}
                                            </div>
                                        </div>

                                        {{-- Judul nomor antrian --}}
                                        <div class="mt-6 text-center">
                                            <span class="inline-block text-black font-extrabold text-[18px] sm:text-[20px] leading-tight border-b-[3px] border-sky-500 px-1">
                                                Nomor Antrian Anda
                                            </span>
                                        </div>

                                        {{-- Nomor antrian besar --}}
                                        <div class="mt-4 text-center text-sky-400 font-black tracking-tight text-[88px] sm:text-[110px] leading-none">
                                            {{ $q['queue_number'] }}
                                        </div>

                                        {{-- Info 3 kolom --}}
                                        <div class="mt-7 grid grid-cols-3 gap-2 text-center">
                                            <div>
                                                <div class="text-slate-400 text-sm sm:text-sm leading-tight">
                                                    Jumlah Antrian
                                                </div>
                                                <div class="mt-2 text-sky-400 font-extrabold text-xl sm:text-4xl leading-none">
                                                    {{ $q['total_queue'] }}
                                                </div>
                                            </div>

                                            <div>
                                                <div class="text-slate-400 text-sm sm:text-sm leading-tight">
                                                    Antrian Dilayani
                                                </div>
                                                <div class="mt-2 text-teal-400 font-extrabold text-xl sm:text-4xl leading-none">
                                                    {{ $q['current_queue'] }}
                                                </div>
                                            </div>

                                            <div>
                                                <div class="text-slate-400 text-sm sm:text-sm leading-tight">
                                                    Tanggal Periksa
                                                </div>
                                                <div class="mt-2 text-sky-400 font-extrabold text-xl sm:text-4xl leading-none">
                                                    {{ $q['check_date'] }}
                                                </div>
                                            </div>
                                        </div>

                                        {{-- Separator --}}
                                        <div class="mt-8 h-px bg-sky-300"></div>

                                        {{-- Status dokter --}}
                                        {{-- <div class="mt-5 text-center">
                                            <div class="text-slate-400 text-[13px] sm:text-sm">
                                                Status Kedatangan Dokter
                                            </div>
                                            <div class="mt-1 font-extrabold text-[24px] sm:text-[28px] leading-tight {{ $q['doctor_status_color'] }}">
                                                {{ $q['doctor_status'] }}
                                            </div>
                                        </div> --}}
                                    </div>
                                </a>
                            </div>
                        @endforeach
                    </div>

                    {{-- Dots indicator --}}
                    <div class="mt-4 flex items-center justify-center gap-2">
                        @foreach($queueRegisters as $i => $q)
                            <button
                                type="button"
                                @click="goTo({{ $i }})"
                                class="h-3 rounded-full transition-all duration-200"
                                :class="index === {{ $i }} ? 'w-10 bg-sky-400' : 'w-3 bg-slate-300'"
                                aria-label="Slide {{ $i + 1 }}"
                            ></button>
                        @endforeach
                    </div>
                </section>
            @endif

            {{-- Pelayanan --}}
            <section class="">
                <div class="flex items-center justify-between">
                    <h2 class="text-lg font-extrabold text-slate-900">Pelayanan</h2>
                    <a href="#" class="text-sm font-semibold text-sky-600">Lihat Semua</a>
                </div>

                <div class="mt-4 overflow-x-auto scrollbar-hide -mx-2 px-2 snap-x snap-mandatory">
                    <div class="flex gap-3 min-w-max">
                        @foreach ($polyclinics as $polyclinic)
                            <a href="#"
                            class="w-32 shrink-0 snap-start bg-white rounded-2xl shadow-sm border border-slate-100 p-4 text-center">
                                <div class="mx-auto w-full aspect-square rounded-xl bg-slate-50 flex items-center justify-center overflow-hidden">
                                    <img src="{{ $polyclinic['icon'] }}" class="w-full h-full object-contain" alt="{{ $polyclinic['label'] }}">
                                </div>
                                <div class="mt-2 text-[11px] font-semibold text-slate-800 leading-tight">
                                    {{ $polyclinic['label'] }}
                                </div>
                            </a>
                        @endforeach
                    </div>
                </div>
            </section>

            {{-- Dokter Berpengalaman --}}
            <section class="pt-2">
                <div class="flex items-center justify-between">
                    <h2 class="text-lg font-extrabold text-slate-900">Dokter Berpengalaman</h2>
                    <a href="#" class="text-sm font-semibold text-sky-600">Lihat Semua</a>
                </div>

                <div class="mt-4 grid grid-cols-2 md:grid-cols-3 gap-3">
                    @foreach ($doctors as $doctor)
                        <a href="#" class="bg-white rounded-2xl shadow border border-slate-100 p-4">
                            <div class="rounded-2xl bg-slate-50 overflow-hidden">
                                <img src="{{ $doctor?->profile }}" alt="{{ $doctor?->name }}" class="w-full h-28 object-contain">
                            </div>

                            <div class="mt-3">
                                <div class="text-sm font-extrabold text-sky-600 truncate">{{ $doctor?->name }}</div>
                                <div class="text-xs text-slate-500">{{ $doctor?->typeDoctor }}</div>
                            </div>
                        </a>
                    @endforeach
                </div>
            </section>

            {{-- bottom spacer --}}
            <div class="h-6"></div>
        </div>
    </div>
</div>
@push('scripts')
<script>
    function queueSlider() {
        return {
            index: 0,

            init() {
                this.$nextTick(() => {
                    this.syncIndex();
                    window.addEventListener('resize', () => this.goTo(this.index, false));
                });
            },

            goTo(i, smooth = true) {
                const track = this.$refs.track;
                if (!track) return;

                const slides = track.querySelectorAll('[data-slide]');
                if (!slides.length) return;

                if (i < 0) i = 0;
                if (i > slides.length - 1) i = slides.length - 1;

                this.index = i;

                const left = slides[i].offsetLeft - track.offsetLeft;

                track.scrollTo({
                    left,
                    behavior: smooth ? 'smooth' : 'auto'
                });
            },

            syncIndex() {
                const track = this.$refs.track;
                if (!track) return;

                const slides = [...track.querySelectorAll('[data-slide]')];
                if (!slides.length) return;

                const center = track.scrollLeft + (track.clientWidth / 2);

                let closestIndex = 0;
                let minDistance = Infinity;

                slides.forEach((slide, i) => {
                    const slideCenter = slide.offsetLeft + (slide.clientWidth / 2);
                    const distance = Math.abs(center - slideCenter);

                    if (distance < minDistance) {
                        minDistance = distance;
                        closestIndex = i;
                    }
                });

                this.index = closestIndex;
            }
        }
    }
</script>
@endpush
