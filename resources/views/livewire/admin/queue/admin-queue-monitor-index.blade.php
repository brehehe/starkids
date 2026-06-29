<div wire:poll.5s="updateQueues" x-data="queueVoiceSystem"
    x-init="checkNewCalls($wire.queues); $watch('$wire.queues', value => checkNewCalls(value))"
    class="min-h-screen bg-slate-900 text-white p-4 md:p-8 font-sans transition-all duration-500">
    <!-- Autoplay Interaction Overlay -->
    <template x-if="!audioEnabled">
        <div
            class="fixed inset-0 z-[100] bg-slate-900/95 backdrop-blur-md flex flex-col items-center justify-center p-8 text-center">
            <div
                class="bg-slate-800 p-12 rounded-[3rem] border border-blue-500/30 shadow-2xl max-w-xl animate-in fade-in zoom-in duration-500">
                <div
                    class="w-24 h-24 bg-blue-600 rounded-full flex items-center justify-center mb-8 mx-auto animate-bounce">
                    <i class="fas fa-volume-up text-4xl text-white"></i>
                </div>
                <h2 class="text-3xl md:text-4xl font-black text-white mb-4 uppercase tracking-tight">Aktifkan Suara
                    Monitor</h2>
                <p class="text-slate-400 text-lg mb-10 font-medium">Klik tombol di bawah ini untuk mengaktifkan
                    panggilan suara otomatis dan sistem pengeras suara.</p>
                <button @click="enableAudio"
                    class="bg-blue-600 hover:bg-blue-500 text-white text-xl font-black py-5 px-12 rounded-full shadow-[0_0_30px_rgba(37,99,235,0.4)] transition-all hover:scale-105 active:scale-95 uppercase tracking-widest">
                    Mulai Sekarang
                </button>
            </div>
        </div>
    </template>

    <div class="max-w-[1920px] mx-auto">
        <!-- Header -->
        <div
            class="flex flex-col md:flex-row justify-between items-center mb-8 md:mb-12 border-b border-slate-700 pb-6 gap-6">
            <div class="text-center md:text-left">
                <h1 class="text-3xl md:text-5xl lg:text-6xl font-extrabold text-blue-400 tracking-tight">ANTREAN
                    POLIKLINIK</h1>
                <p class="text-lg md:text-xl text-slate-400 mt-2 font-medium">{{config('app.name')}}</p>
            </div>
            <div class="text-center md:text-right">
                <div class="text-4xl md:text-6xl lg:text-7xl font-mono font-bold text-white tracking-widest">
                    {{ $currentTime }}</div>
                <div class="text-md md:text-lg lg:text-xl text-slate-400 mt-1 font-semibold">
                    {{ now()->isoFormat('dddd, D MMMM YYYY') }}</div>
            </div>
        </div>

        <!-- Queue Grid -->
        <div class="grid grid-cols-1 sm:grid-cols-2 xl:grid-cols-3 2xl:grid-cols-4 gap-6 md:gap-8 lg:gap-10">
            @forelse($queues as $queue)
                <div
                    class="bg-slate-800 rounded-[2.5rem] overflow-hidden shadow-2xl border border-slate-700/50 flex flex-col h-full transform transition hover:scale-[1.02] duration-300">
                    <div class="p-5 md:p-8 bg-gradient-to-r from-blue-700 to-blue-600 shadow-inner">
                        <h2
                            class="text-xl md:text-2xl lg:text-3xl font-black text-center uppercase tracking-[0.15em] drop-shadow-md">
                            {{ $queue['poly_name'] }}</h2>
                    </div>

                    <div class="p-6 md:p-10 flex flex-col items-center justify-between flex-grow space-y-8"
                        :class="{ 'ring-4 ring-blue-500 ring-inset animate-pulse': '{{ $queue['status'] }}' === 'call_consultation' }">
                        <div class="text-center group">
                            <p
                                class="text-slate-400 text-xs md:text-sm uppercase font-bold tracking-[0.2em] mb-3 opacity-80">
                                Nomor Antrean</p>
                            <div
                                class="text-[4rem] md:text-[4rem] lg:text-[6rem] font-black text-white leading-none tracking-tighter transition-all group-hover:text-blue-400">
                                {{ $queue['current_queue'] }}
                            </div>
                        </div>

                        <div class="w-full">
                            <div class="w-full h-px bg-slate-700/50 mb-8"></div>

                            <div class="text-center w-full mb-8">
                                <p
                                    class="text-slate-400 text-xs md:text-sm uppercase font-bold tracking-[0.2em] mb-3 opacity-80">
                                    Pasien Sedang Diperiksa</p>
                                <p
                                    class="text-xl md:text-2xl lg:text-3xl font-black text-blue-300 truncate px-2 tracking-tight">
                                    {{ $queue['patient_name'] }}
                                </p>
                            </div>

                            <div
                                class="w-full flex items-center justify-center space-x-3 bg-slate-900/50 py-4 px-4 rounded-[1.5rem] border border-slate-700/50 shadow-inner">
                                <div
                                    class="w-3 h-3 rounded-full bg-green-500 animate-pulse shadow-[0_0_10px_rgba(34,197,94,0.6)]">
                                </div>
                                <span class="text-slate-200 font-bold text-sm md:text-base lg:text-lg truncate">dr.
                                    {{ $queue['doctor_name'] }}</span>
                            </div>
                        </div>
                    </div>

                    @if($queue['status'] !== 'Kosong')
                        <div class="bg-blue-500/10 py-4 text-center border-t border-slate-700/30">
                            <span
                                class="text-blue-400 font-black uppercase tracking-[0.25em] text-xs md:text-sm animate-pulse inline-block">
                                {{ $queue['status'] === 'call_consultation' ? 'Panggilan Pasien' : 'SEDANG KONSULTASI' }}
                            </span>
                        </div>
                    @endif
                </div>
            @empty
                <div
                    class="col-span-full flex flex-col items-center justify-center py-32 md:py-48 bg-slate-800/50 rounded-[3rem] border-2 border-dashed border-slate-700 shadow-inner">
                    <div class="text-6xl md:text-8xl text-slate-700 mb-6 opacity-40">
                        <i class="fas fa-calendar-alt"></i>
                    </div>
                    <p class="text-xl md:text-3xl text-slate-500 font-bold tracking-wide italic">Beri tahu jadwal dokter
                        terlebih dahulu</p>
                </div>
            @endforelse
        </div>

        <!-- Footer / Marquee -->
        <div
            class="mt-12 md:mt-16 bg-slate-800/80 backdrop-blur-sm rounded-[2rem] border border-slate-700/50 overflow-hidden shadow-2xl flex items-stretch">
            <!-- Fixed INFO badge as a pillar -->
            <div
                class="bg-blue-600 px-6 md:px-10 py-4 flex items-center justify-center shrink-0 shadow-[4px_0_15px_rgba(0,0,0,0.4)] z-20 relative">
                <span class="text-xs md:text-sm lg:text-base font-black tracking-[0.3em] uppercase">INFO</span>
            </div>

            <!-- Scrolling container with internal fades -->
            <div class="relative flex-grow overflow-hidden flex items-center py-4 bg-slate-900/20">
                <div
                    class="whitespace-nowrap animate-marquee text-slate-300 text-lg md:text-2xl font-medium tracking-wide">
                    Silahkan menunggu di depan ruangan poliklinik masing-masing • Pastikan nomor antrean Anda sudah
                    sesuai • Terima kasih telah mempercayakan kesehatan Anda kepada kami • {{config('app.name')}}
                    mengutamakan pelayanan terbaik untuk Anda.
                </div>


                <!-- Gradient fades restricted to scrolling area -->
                <div
                    class="absolute inset-y-0 left-0 w-20 bg-gradient-to-r from-slate-800 to-transparent pointer-events-none z-10">
                </div>
                <div
                    class="absolute inset-y-0 right-0 w-20 bg-gradient-to-l from-slate-800 to-transparent pointer-events-none z-10">
                </div>
            </div>
        </div>
    </div>
</div>

<script data-cfasync="false">
    (function () {
        const initVoiceSystem = () => {
            if (typeof Alpine !== 'undefined' && !window.voiceSystemInitialized) {
                window.voiceSystemInitialized = true;
                console.log('🚀 Voice System Initializing...');

                Alpine.data('queueVoiceSystem', () => ({
                    callTracker: {},
                    voiceQueue: [],
                    isSpeaking: false,
                    audioContext: null,
                    audioEnabled: false,

                    enableAudio() {
                        console.log('🔘 enableAudio() clicked. Initializing sequential queue.');
                        this.audioEnabled = true;

                        try {
                            if (!this.audioContext) {
                                this.audioContext = new (window.AudioContext || window.webkitAudioContext)();
                            }
                            if (this.audioContext.state === 'suspended') {
                                this.audioContext.resume();
                            }

                            // Add confirmation to the FRONT of the queue
                            this.voiceQueue.unshift('Sistem suara aktif. Menunggu antrean pasien.');

                            console.log('🔊 Audio Context running. Queue:', this.voiceQueue.length);
                            this.processQueue();
                        } catch (e) {
                            console.error('❌ Error initializing AudioContext:', e);
                        }
                    },

                    checkNewCalls(queues) {
                        if (!queues || !Array.isArray(queues)) return;
                        console.log('🔍 Scanning queues...', queues.length);

                        queues.forEach(item => {
                            if (item.status === 'call_consultation' && item.id) {
                                const currentCount = this.callTracker[item.id] || 0;
                                if (currentCount < 2) {
                                    console.log(`🎯 New patient call: ${item.patient_name}`);
                                    const neededCalls = 2 - currentCount;
                                    for (let i = 0; i < neededCalls; i++) {
                                        this.addToVoiceQueue(item);
                                    }
                                    this.callTracker[item.id] = 2;
                                }
                            }
                        });
                    },

                    addToVoiceQueue(item) {
                        const message = `Panggilan Pasien. Nomor antrian. ${item.current_queue}. atas nama. ${item.patient_name}. silahkan menuju. ${item.poly_name}`;
                        this.voiceQueue.push(message);
                        console.log('➕ Added to queue:', message);
                        if (this.audioEnabled) {
                            this.processQueue();
                        }
                    },

                    async processQueue() {
                        if (!this.audioEnabled || this.isSpeaking || this.voiceQueue.length === 0) {
                            return;
                        }

                        this.isSpeaking = true;
                        const text = this.voiceQueue.shift();
                        console.log('📢 Processing:', text);

                        try {
                            // Only play chime if it's a patient call (contains "Nomor antrian")
                            if (text.includes('Nomor antrian')) {
                                await this.playChime();
                                // Small delay after chime before speaking
                                await new Promise(r => setTimeout(r, 800));
                            }

                            await this.speak(text);
                        } catch (e) {
                            console.error('❌ Playback error:', e);
                        } finally {
                            this.isSpeaking = false;
                            // Pause between queue items
                            setTimeout(() => this.processQueue(), 1200);
                        }
                    },

                    async playChime() {
                        return new Promise((resolve) => {
                            try {
                                if (!this.audioContext) {
                                    this.audioContext = new (window.AudioContext || window.webkitAudioContext)();
                                }
                                if (this.audioContext.state === 'suspended') {
                                    this.audioContext.resume();
                                }

                                const audio = new Audio('/asset/music/nada-suara.mp3');
                                const source = this.audioContext.createMediaElementSource(audio);
                                const gainNode = this.audioContext.createGain();
                                gainNode.gain.value = 1.2; // Slightly softer
                                source.connect(gainNode);
                                gainNode.connect(this.audioContext.destination);

                                audio.onended = () => {
                                    source.disconnect();
                                    gainNode.disconnect();
                                    resolve();
                                };
                                audio.onerror = (e) => {
                                    console.error('⚠️ Chime failed:', e);
                                    resolve();
                                };
                                audio.play().catch(e => {
                                    console.warn('⚠️ Play blocked:', e);
                                    resolve();
                                });
                            } catch (e) {
                                console.error('⚠️ Chime exception:', e);
                                resolve();
                            }
                        });
                    },

                    async speak(text) {
                        return new Promise((resolve) => {
                            if (!window.speechSynthesis) return resolve();

                            const speech = new SpeechSynthesisUtterance(text);
                            speech.lang = 'id-ID';
                            speech.rate = 0.85;

                            const selectAndSpeak = () => {
                                const voices = window.speechSynthesis.getVoices();
                                // Prioritize Male Voices: Ardi (Microsoft), Google Male, or any containing "Male"
                                let selectedVoice = voices.find(v => v.name.includes('Microsoft Ardi')) ||
                                    voices.find(v => v.name.toLowerCase().includes('male') && v.lang.startsWith('id')) ||
                                    voices.find(v => v.name.includes('Microsoft Gadis')) || // Fallback to female but lower pitch
                                    voices.find(v => v.name.includes('Microsoft Andika')) ||
                                    voices.find(v => v.lang.startsWith('id'));

                                if (selectedVoice) {
                                    speech.voice = selectedVoice;
                                    // Acoustic adjustments for Male sound
                                    if (selectedVoice.name.includes('Ardi') || selectedVoice.name.toLowerCase().includes('male')) {
                                        speech.pitch = 0.95; // Natural male pitch
                                        speech.rate = 1.15;  // Faster, efficient calling
                                    } else {
                                        // If falling back to female voice, lower pitch significantly to simulate male
                                        speech.pitch = 0.65;
                                        speech.rate = 1.1;   // Slightly faster fallback
                                    }
                                } else {
                                    speech.pitch = 0.7; // Deepen generic default
                                }

                                speech.onend = () => resolve();
                                speech.onerror = (e) => {
                                    console.error('⚠️ Speech error:', e);
                                    resolve();
                                };
                                window.speechSynthesis.speak(speech);
                            };

                            if (window.speechSynthesis.getVoices().length > 0) {
                                selectAndSpeak();
                            } else {
                                window.speechSynthesis.onvoiceschanged = () => {
                                    selectAndSpeak();
                                    window.speechSynthesis.onvoiceschanged = null;
                                };
                                setTimeout(selectAndSpeak, 600);
                            }
                        });
                    },

                    listVoices() {
                        const voices = window.speechSynthesis.getVoices();
                        const idVoices = voices.filter(v => v.lang.startsWith('id') || v.name.toLowerCase().includes('indonesia'));
                        console.log('📋 Available Indonesian Voices:');
                        if (idVoices.length === 0) {
                            console.log('❌ No Indonesian voices found. Using system default.');
                        } else {
                            idVoices.forEach((v, i) => {
                                console.log(`${i + 1}. Name: "${v.name}" | Lang: ${v.lang} ${v.default ? '(Default)' : ''}`);
                            });
                        }
                    }
                }));
            }
        };

        // Initialize early and on livewire ready
        initVoiceSystem();
        document.addEventListener('DOMContentLoaded', () => {
            initVoiceSystem();
            // List voices after a short delay to ensure they are loaded
            setTimeout(() => {
                const el = document.querySelector('[x-data="queueVoiceSystem"]');
                if (el && el.__x && el.__x.$data) el.__x.$data.listVoices();
            }, 1000);
        });
        document.addEventListener('livewire:init', initVoiceSystem);

        if (window.speechSynthesis) {
            window.speechSynthesis.onvoiceschanged = () => {
                const el = document.querySelector('[x-data="queueVoiceSystem"]');
                if (el && el.__x && el.__x.$data) el.__x.$data.listVoices();
            };
        }
    })();
</script>

<style>
    @keyframes marquee {
        0% {
            transform: translateX(100%);
        }

        100% {
            transform: translateX(-150%);
        }
    }

    .animate-marquee {
        animation: marquee 35s linear infinite;
    }

    /* Better scaling for extremely large displays */
    @media (min-width: 2560px) {
        .max-w-\[1920px\] {
            max-w: 2400px;
        }
    }
</style>