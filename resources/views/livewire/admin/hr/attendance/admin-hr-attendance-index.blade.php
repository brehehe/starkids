<div class="p-6" x-data="attendanceCamera()">
    <div class="mb-6 flex justify-between items-center">
        <flux:heading size="xl">Absensi Kehadiran</flux:heading>
        <flux:button variant="primary" color="blue" @click="openScanner()">Absen Sekarang</flux:button>
    </div>

    <div class="grid grid-cols-1 gap-6">

        <!-- Summary Cards Section -->
        <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
            <!-- Hadir -->
            <div class="bg-white p-4 rounded-lg shadow-sm border border-green-200 flex flex-col items-center justify-center">
                <div class="w-12 h-12 bg-green-100 text-green-600 rounded-full flex items-center justify-center mb-2">
                    <i class="fas fa-calendar-check text-xl"></i>
                </div>
                <div class="text-gray-500 text-sm font-medium">Hadir</div>
                <div class="text-2xl font-bold text-gray-800">{{ $countPresent }}</div>
            </div>

            <!-- Terlambat -->
            <div class="bg-white p-4 rounded-lg shadow-sm border border-yellow-200 flex flex-col items-center justify-center">
                <div class="w-12 h-12 bg-yellow-100 text-yellow-600 rounded-full flex items-center justify-center mb-2">
                    <i class="fas fa-clock text-xl"></i>
                </div>
                <div class="text-gray-500 text-sm font-medium">Terlambat</div>
                <div class="text-2xl font-bold text-gray-800">{{ $countLate }}</div>
            </div>

            <!-- Alfa -->
            <div class="bg-white p-4 rounded-lg shadow-sm border border-red-200 flex flex-col items-center justify-center">
                <div class="w-12 h-12 bg-red-100 text-red-600 rounded-full flex items-center justify-center mb-2">
                    <i class="fas fa-times-circle text-xl"></i>
                </div>
                <div class="text-gray-500 text-sm font-medium">Alfa/Tidak Hadir</div>
                <div class="text-2xl font-bold text-gray-800">{{ $countAbsent }}</div>
            </div>

            <!-- Pulang Cepat -->
            <div class="bg-white p-4 rounded-lg shadow-sm border border-orange-200 flex flex-col items-center justify-center">
                <div class="w-12 h-12 bg-orange-100 text-orange-600 rounded-full flex items-center justify-center mb-2">
                    <i class="fas fa-running text-xl"></i>
                </div>
                <div class="text-gray-500 text-sm font-medium">Pulang Cepat</div>
                <div class="text-2xl font-bold text-gray-800">{{ $countLeftEarly }}</div>
            </div>
        </div>

        <!-- History Section -->
        <div class="bg-white p-6 rounded-lg shadow-sm border border-gray-200" x-data="{ tab: 'all' }">
            <div class="mb-6 flex flex-col sm:flex-row sm:items-center justify-between gap-4">
                <h2 class="text-xl font-semibold text-gray-800">Riwayat Kehadiran (30 Hari Terakhir)</h2>
                
                <!-- Tabs -->
                <div class="flex bg-gray-100 p-1 rounded-lg overflow-x-auto whitespace-nowrap hide-scrollbar">
                    <button @click="tab = 'all'" :class="tab === 'all' ? 'bg-white shadow text-gray-800' : 'text-gray-500 hover:text-gray-700'" class="px-4 py-2 text-sm font-medium rounded-md transition-all">Semua</button>
                    <button @click="tab = 'present'" :class="tab === 'present' ? 'bg-white shadow text-gray-800' : 'text-gray-500 hover:text-gray-700'" class="px-4 py-2 text-sm font-medium rounded-md transition-all">Hadir</button>
                    <button @click="tab = 'late'" :class="tab === 'late' ? 'bg-white shadow text-gray-800' : 'text-gray-500 hover:text-gray-700'" class="px-4 py-2 text-sm font-medium rounded-md transition-all">Terlambat</button>
                    <button @click="tab = 'left_early'" :class="tab === 'left_early' ? 'bg-white shadow text-gray-800' : 'text-gray-500 hover:text-gray-700'" class="px-4 py-2 text-sm font-medium rounded-md transition-all">Pulang Cepat</button>
                    <button @click="tab = 'absent'" :class="tab === 'absent' ? 'bg-white shadow text-gray-800' : 'text-gray-500 hover:text-gray-700'" class="px-4 py-2 text-sm font-medium rounded-md transition-all">Alfa</button>
                </div>
            </div>

            <div class="overflow-x-auto">
                <table class="w-full text-sm text-left">
                    <thead class="text-xs text-gray-700 bg-gray-50 uppercase border-b border-gray-200">
                        <tr>
                            <th class="px-4 py-3">Tanggal</th>
                            <th class="px-4 py-3">In</th>
                            <th class="px-4 py-3">Lokasi Masuk</th>
                            <th class="px-4 py-3">Out</th>
                            <th class="px-4 py-3">Lokasi Keluar</th>
                            <th class="px-4 py-3">Catatan / Alasan</th>
                        </tr>
                    </thead>
                    <tbody>
                        <!-- All History -->
                        <template x-if="tab === 'all'">
                            <template x-for="record in {{ Js::from($historyAll) }}" :key="record.id">
                                <tr class="border-b border-gray-100 hover:bg-gray-50">
                                    <td class="px-4 py-3 font-medium" x-text="new Date(record.date).toLocaleDateString('id-ID', { year: 'numeric', month: 'short', day: 'numeric' })"></td>
                                    <td class="px-4 py-3" x-text="record.clock_in_time ? record.clock_in_time.substring(0, 5) : '-'"></td>
                                    <td class="px-4 py-3" x-text="record.clock_in_location_address || (record.clock_in_location_lat ? record.clock_in_location_lat + ', ' + record.clock_in_location_long : '-')"></td>
                                    <td class="px-4 py-3" x-text="record.clock_out_time ? record.clock_out_time.substring(0, 5) : '-'"></td>
                                    <td class="px-4 py-3" x-text="record.clock_out_location_address || (record.clock_out_location_lat ? record.clock_out_location_lat + ', ' + record.clock_out_location_long : '-')"></td>
                                    <td class="px-4 py-3">
                                        <div class="flex flex-col gap-1">
                                            <span class="inline-block px-2 py-1 rounded text-[10px] font-bold uppercase w-fit"
                                                :class="{
                                                    'bg-green-100 text-green-800': record.status === 'present',
                                                    'bg-yellow-100 text-yellow-800': record.status === 'late',
                                                    'bg-orange-100 text-orange-800': record.status === 'left_early',
                                                    'bg-red-100 text-red-800': record.status === 'absent'
                                                }" x-text="record.status.replace('_', ' ')"></span>
                                            <span x-show="record.reason" x-text="record.reason" class="text-xs text-gray-500 mt-1"></span>
                                        </div>
                                    </td>
                                </tr>
                            </template>
                        </template>

                        <!-- Present -->
                        <template x-if="tab === 'present'">
                            <template x-for="record in {{ Js::from($historyPresent) }}" :key="record.id">
                                <tr class="border-b border-gray-100 hover:bg-gray-50">
                                    <td class="px-4 py-3 font-medium" x-text="new Date(record.date).toLocaleDateString('id-ID', { year: 'numeric', month: 'short', day: 'numeric' })"></td>
                                    <td class="px-4 py-3" x-text="record.clock_in_time ? record.clock_in_time.substring(0, 5) : '-'"></td>
                                    <td class="px-4 py-3" x-text="record.clock_in_location_address || (record.clock_in_location_lat ? record.clock_in_location_lat + ', ' + record.clock_in_location_long : '-')"></td>
                                    <td class="px-4 py-3" x-text="record.clock_out_time ? record.clock_out_time.substring(0, 5) : '-'"></td>
                                    <td class="px-4 py-3" x-text="record.clock_out_location_address || (record.clock_out_location_lat ? record.clock_out_location_lat + ', ' + record.clock_out_location_long : '-')"></td>
                                    <td class="px-4 py-3" x-text="record.reason || '-'"></td>
                                </tr>
                            </template>
                        </template>

                        <!-- Late -->
                        <template x-if="tab === 'late'">
                            <template x-for="record in {{ Js::from($historyLate) }}" :key="record.id">
                                <tr class="border-b border-gray-100 hover:bg-gray-50">
                                    <td class="px-4 py-3 font-medium" x-text="new Date(record.date).toLocaleDateString('id-ID', { year: 'numeric', month: 'short', day: 'numeric' })"></td>
                                    <td class="px-4 py-3" x-text="record.clock_in_time ? record.clock_in_time.substring(0, 5) : '-'"></td>
                                    <td class="px-4 py-3" x-text="record.clock_in_location_address || (record.clock_in_location_lat ? record.clock_in_location_lat + ', ' + record.clock_in_location_long : '-')"></td>
                                    <td class="px-4 py-3" x-text="record.clock_out_time ? record.clock_out_time.substring(0, 5) : '-'"></td>
                                    <td class="px-4 py-3" x-text="record.clock_out_location_address || (record.clock_out_location_lat ? record.clock_out_location_lat + ', ' + record.clock_out_location_long : '-')"></td>
                                    <td class="px-4 py-3" x-text="record.reason || '-'"></td>
                                </tr>
                            </template>
                        </template>

                        <!-- Left Early -->
                        <template x-if="tab === 'left_early'">
                            <template x-for="record in {{ Js::from($historyLeftEarly) }}" :key="record.id">
                                <tr class="border-b border-gray-100 hover:bg-gray-50">
                                    <td class="px-4 py-3 font-medium" x-text="new Date(record.date).toLocaleDateString('id-ID', { year: 'numeric', month: 'short', day: 'numeric' })"></td>
                                    <td class="px-4 py-3" x-text="record.clock_in_time ? record.clock_in_time.substring(0, 5) : '-'"></td>
                                    <td class="px-4 py-3" x-text="record.clock_in_location_address || (record.clock_in_location_lat ? record.clock_in_location_lat + ', ' + record.clock_in_location_long : '-')"></td>
                                    <td class="px-4 py-3" x-text="record.clock_out_time ? record.clock_out_time.substring(0, 5) : '-'"></td>
                                    <td class="px-4 py-3" x-text="record.clock_out_location_address || (record.clock_out_location_lat ? record.clock_out_location_lat + ', ' + record.clock_out_location_long : '-')"></td>
                                    <td class="px-4 py-3">
                                        <span x-show="record.reason" x-text="record.reason" class="text-xs px-2 py-1 bg-gray-100 rounded text-gray-700"></span>
                                        <span x-show="!record.reason">-</span>
                                    </td>
                                </tr>
                            </template>
                        </template>

                        <!-- Absent -->
                        <template x-if="tab === 'absent'">
                            <template x-for="record in {{ Js::from($historyAbsent) }}" :key="record.id">
                                <tr class="border-b border-gray-100 hover:bg-gray-50">
                                    <td class="px-4 py-3 font-medium" x-text="new Date(record.date).toLocaleDateString('id-ID', { year: 'numeric', month: 'short', day: 'numeric' })"></td>
                                    <td colspan="4" class="px-4 py-3 text-center text-gray-400 italic">Tidak ada data kehadiran</td>
                                    <td class="px-4 py-3" x-text="record.reason || '-'"></td>
                                </tr>
                            </template>
                        </template>

                        <!-- Empty States -->
                        <template x-if="tab === 'all' && {{ count($historyAll) }} === 0">
                            <tr><td colspan="6" class="px-4 py-8 text-center text-gray-500">Belum ada riwayat absensi.</td></tr>
                        </template>
                        <template x-if="tab === 'present' && {{ count($historyPresent) }} === 0">
                            <tr><td colspan="6" class="px-4 py-8 text-center text-gray-500">Belum ada riwayat hadir.</td></tr>
                        </template>
                        <template x-if="tab === 'late' && {{ count($historyLate) }} === 0">
                            <tr><td colspan="6" class="px-4 py-8 text-center text-gray-500">Belum ada riwayat terlambat.</td></tr>
                        </template>
                        <template x-if="tab === 'left_early' && {{ count($historyLeftEarly) }} === 0">
                            <tr><td colspan="6" class="px-4 py-8 text-center text-gray-500">Belum ada riwayat pulang cepat.</td></tr>
                        </template>
                        <template x-if="tab === 'absent' && {{ count($historyAbsent) }} === 0">
                            <tr><td colspan="6" class="px-4 py-8 text-center text-gray-500">Belum ada riwayat alfa.</td></tr>
                        </template>
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Camera Custom Modal -->
        <div x-show="isModalOpen" style="display: none;" id="modal"
            class="fixed inset-0 bg-overlay flex items-center justify-center z-50 transition-opacity duration-300 ease-in-out">
            <div class="bg-white rounded-2xl shadow-2xl w-full transform transition-all scale-95 duration-300 ease-out animate-fade-in"
                style="max-width: 1000px;">
                <!-- Header -->
                <div class="flex justify-between items-center p-6 border-b border-gray-200">
                    <div class="flex items-center gap-2">
                        <i class="fas fa-camera text-blue-500 text-xl"></i>
                        <h2 class="text-xl font-semibold text-gray-800">Ambil Foto & Lokasi</h2>
                    </div>
                    <button @click="stopCamera()"
                        class="text-gray-500 hover:text-red-500 transition-colors text-2xl leading-none cursor-pointer">
                        &times;
                    </button>
                </div>

                <!-- Body -->
                <div class="px-6 py-4 text-gray-600 overflow-auto" style="max-height: 70vh;">
                    <div class="space-y-6">
                        <div
                            class="relative rounded overflow-hidden bg-gray-100 aspect-video flex items-center justify-center">
                            <video x-ref="video" class="w-full h-full object-cover" autoplay playsinline></video>
                            <canvas x-ref="canvas" class="hidden"></canvas>
                            <div x-show="!streamActive"
                                class="absolute inset-0 flex items-center justify-center text-gray-400">
                                <span x-text="cameraError ? 'Kamera tidak tersedia' : 'Memuat kamera...'"></span>
                            </div>
                        </div>

                        <div class="space-y-4">
                            <div class="text-sm border border-gray-200 p-3 rounded bg-gray-50 flex items-start gap-2">
                                <i class="fas fa-map-marker-alt text-gray-400 mt-1"></i>
                                <div class="w-full">
                                    <div class="font-medium text-gray-900">Lokasi Anda</div>
                                    <div x-show="locationError" class="text-red-500" x-text="locationError"></div>
                                    <div x-show="!locationError && latitude && longitude" class="text-gray-700">
                                        <span x-text="latitude"></span>, <span x-text="longitude"></span>
                                    </div>
                                    <div x-show="address" class="text-gray-600 text-xs mt-1">
                                        <span x-text="address"></span>
                                    </div>
                                    <div x-show="latitude && longitude" class="mt-3 rounded overflow-hidden border">
                                        <div x-ref="map" style="height: 200px; width: 100%;"></div>
                                    </div>
                                    <div x-show="!locationError && (!latitude || !longitude)" class="text-gray-500">
                                        Mencari lokasi...</div>
                                </div>
                            </div>

                            <div class="flex flex-col gap-2 mt-4 border border-gray-200 p-3 rounded bg-gray-50">
                                <label for="reason" class="text-sm font-medium text-gray-700">Catatan / Alasan Pulang Cepat (Opsional)</label>
                                <textarea id="reason" x-model="reason" class="w-full p-2 text-sm rounded border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500" rows="2" placeholder="Masukkan alasan jika pulang lebih awal..."></textarea>
                            </div>

                            <div class="flex gap-4 mt-2">
                                <button type="button" @click="captureAndSubmit('clockIn')"
                                    :disabled="!readyToSubmit ||
                                        {{ $todayAttendance && $todayAttendance->clock_in_time ? 'true' : 'false' }}"
                                    class="flex-1 py-3 px-4 bg-emerald-600 hover:bg-emerald-700 text-white rounded font-medium disabled:opacity-50 disabled:cursor-not-allowed transition-colors">
                                    Clock In
                                </button>

                                <button type="button" @click="captureAndSubmit('clockOut')"
                                    :disabled="!readyToSubmit || false ===
                                        {{ $todayAttendance && $todayAttendance->clock_in_time ? 'true' : 'false' }} ||
                                        {{ $todayAttendance && $todayAttendance->clock_out_time ? 'true' : 'false' }}"
                                    class="flex-1 py-3 px-4 bg-red-600 hover:bg-red-700 text-white rounded font-medium disabled:opacity-50 disabled:cursor-not-allowed transition-colors">
                                    Clock Out
                                </button>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Footer -->
                <div class="flex justify-end gap-2 px-6 py-4 border-t border-gray-200">
                    <button @click="stopCamera()"
                        class="px-4 py-2 bg-gray-200 hover:bg-gray-300 text-gray-800 rounded-lg shadow transition cursor-pointer">
                        Batal
                    </button>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
        <script>
            document.addEventListener('alpine:init', () => {
                Alpine.data('attendanceCamera', () => ({
                    isModalOpen: false,
                    streamActive: false,
                    cameraError: false,
                    locationError: false,
                    latitude: null,
                    longitude: null,
                    readyToSubmit: false,
                    map: null,
                    marker: null,
                    stream: null,
                    address: null,
                    reason: '', // Add reason explicitly into alpine data

                    init() {
                        // Do not initialize anything on load. Wait for openScanner()
                    },

                    openScanner() {
                        this.isModalOpen = true;
                        // Wait for the modal DOM to render so $refs.video is available
                        setTimeout(() => {
                            this.startCamera();
                            this.getLocation();
                        }, 300);
                    },

                    stopCamera() {
                        this.isModalOpen = false;

                        if (this.stream) {
                            this.stream.getTracks().forEach(track => track.stop());
                            this.streamActive = false;
                            this.stream = null;
                            this.$refs.video.srcObject = null;
                        }
                        if (this.map) {
                            this.map.remove();
                            this.map = null;
                        }
                        this.latitude = null;
                        this.longitude = null;
                        this.address = null;
                        this.reason = '';
                    },

                    async startCamera() {
                        try {
                            this.stream = await navigator.mediaDevices.getUserMedia({
                                video: {
                                    facingMode: 'user'
                                }
                            });
                            this.$refs.video.srcObject = this.stream;
                            this.streamActive = true;
                            this.checkReady();
                        } catch (err) {
                            console.error('Error accessing camera:', err);
                            this.cameraError = true;
                        }
                    },

                    getLocation() {
                        if (!navigator.geolocation) {
                            this.locationError = "Geolocation tidak didukung browser.";
                            this.checkReady();
                            return;
                        }

                        navigator.geolocation.getCurrentPosition(
                            async (position) => {
                                    this.latitude = position.coords.latitude;
                                    this.longitude = position.coords.longitude;
                                    this.locationError = null;

                                    // Reverse geocoding
                                    try {
                                        const response = await fetch(
                                            `https://nominatim.openstreetmap.org/reverse?format=json&lat=${this.latitude}&lon=${this.longitude}`
                                        );
                                        const data = await response.json();
                                        this.address = data.display_name;
                                    } catch (e) {
                                        this.address = "Alamat tidak ditemukan";
                                    }

                                    // 🔥 INIT MAP
                                    this.$nextTick(() => {
                                        if (!this.$refs.map)
                                            return; // guard if modal isn't rendered

                                        if (!this.map) {
                                            this.map = L.map(this.$refs.map).setView(
                                                [this.latitude, this.longitude],
                                                16
                                            );

                                            L.tileLayer(
                                                'https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                                                    attribution: '&copy; OpenStreetMap contributors'
                                                }).addTo(this.map);

                                            this.marker = L.marker([
                                                this.latitude,
                                                this.longitude
                                            ]).addTo(this.map);
                                        } else {
                                            this.map.setView([this.latitude, this.longitude],
                                                16);
                                            this.marker.setLatLng([
                                                this.latitude,
                                                this.longitude
                                            ]);
                                        }
                                    });

                                    this.checkReady();
                                },
                                (error) => {
                                    // User denied geolocation or timeout
                                    this.locationError =
                                        "Lokasi tidak tersedia (Izin ditolak atau timeout).";
                                    this.checkReady(); // Still allow submission but without location
                                }
                        );
                    },

                    checkReady() {
                        // Start if camera is ready. Location is optional/allowed to fail
                        if (this.streamActive) {
                            this.readyToSubmit = true;
                        }
                    },

                    captureAndSubmit(action) {
                        if (!this.readyToSubmit) return;

                        const video = this.$refs.video;
                        const canvas = this.$refs.canvas;
                        canvas.width = video.videoWidth;
                        canvas.height = video.videoHeight;

                        const context = canvas.getContext('2d');
                        context.drawImage(video, 0, 0, canvas.width, canvas.height);

                        const photoBase64 = canvas.toDataURL('image/jpeg', 0.8);

                        @this.set('photo', photoBase64);
                        @this.set('latitude', this.latitude);
                        @this.set('longitude', this.longitude);
                        @this.set('address', this.address);
                        @this.set('reason', this.reason); // Assign Livewire reason to Alpine reason

                        if (action === 'clockIn') {
                            @this.clockIn();
                        } else if (action === 'clockOut') {
                            @this.clockOut();
                        }

                        this.stopCamera();
                    }
                }));
            });
        </script>
    @endpush
</div>
