<div class="min-h-screen bg-gradient-to-br from-blue-50 to-green-50">
    <!-- Header Section -->
    <header class="bg-white shadow-lg sticky top-0 z-50">
        <div class="container mx-auto px-4 py-4">
            <div class="flex items-center justify-between">
                <div class="flex items-center space-x-4">
                    <div
                        class="w-12 h-12 bg-gradient-to-r from-blue-500 to-green-500 rounded-full flex items-center justify-center">
                        <i class="fas fa-heartbeat text-white text-xl"></i>
                    </div>
                    <div>
                        <h1 class="text-2xl font-bold text-gray-800">{{ $company->name ?? 'Klinik Sehat Mandiri' }}</h1>
                        <p class="text-sm text-gray-600">Kesehatan Terpercaya</p>
                    </div>
                </div>
                <nav class="hidden md:flex space-x-6">
                    <a href="#home" class="text-gray-700 hover:text-blue-600 transition duration-300">Beranda</a>
                    <a href="#services" class="text-gray-700 hover:text-blue-600 transition duration-300">Layanan</a>
                    <a href="#doctors" class="text-gray-700 hover:text-blue-600 transition duration-300">Dokter</a>
                    <a href="#branch-selection"
                        class="text-gray-700 hover:text-blue-600 transition duration-300">Reservasi</a>
                    <a href="#contact" class="text-gray-700 hover:text-blue-600 transition duration-300">Kontak</a>
                </nav>
                <button class="md:hidden text-gray-700" id="mobile-menu-btn">
                    <i class="fas fa-bars text-xl"></i>
                </button>
            </div>

            <!-- Mobile Menu -->
            <div id="mobile-menu" class="hidden md:hidden mt-4 py-4 border-t border-gray-200">
                <nav class="flex flex-col space-y-2">
                    <a href="#home" class="text-gray-700 hover:text-blue-600 transition duration-300 py-2">Beranda</a>
                    <a href="#services"
                        class="text-gray-700 hover:text-blue-600 transition duration-300 py-2">Layanan</a>
                    <a href="#doctors" class="text-gray-700 hover:text-blue-600 transition duration-300 py-2">Dokter</a>
                    <a href="#branch-selection"
                        class="text-gray-700 hover:text-blue-600 transition duration-300 py-2">Reservasi</a>
                    <a href="#contact" class="text-gray-700 hover:text-blue-600 transition duration-300 py-2">Kontak</a>
                </nav>
            </div>
        </div>
    </header>

    <!-- Hero Slider Section -->
    <section id="home" class="relative h-screen overflow-hidden">
        <div class="hero-slider relative h-full">
            <!-- Slide 1 -->
            <div class="slide active absolute inset-0 bg-gradient-to-r from-blue-600 to-green-600 flex items-center">
                <div class="container mx-auto px-4 text-center text-white">
                    <div class="max-w-4xl mx-auto">
                        <h1 class="text-4xl md:text-6xl font-bold mb-6 animate-fade-in-up">
                            Kesehatan Anda, Prioritas Kami
                        </h1>
                        <p class="text-xl text-blue-100 mb-8 animate-fade-in-up animation-delay-300">
                            Pelayanan kesehatan terbaik dengan teknologi modern dan tenaga medis berpengalaman
                        </p>
                        <div
                            class="flex flex-col sm:flex-row gap-4 justify-center animate-fade-in-up animation-delay-600">
                            <a href="#branch-selection"
                                class="bg-white text-blue-600 px-8 py-3 rounded-full font-semibold hover:bg-blue-50 transition duration-300 transform hover:scale-105">
                                <i class="fas fa-calendar-plus mr-2"></i>Reservasi Online
                            </a>
                            <a href="#services"
                                class="border-2 border-white text-white px-8 py-3 rounded-full font-semibold hover:bg-white hover:text-blue-600 transition duration-300">
                                <i class="fas fa-info-circle mr-2"></i>Lihat Layanan
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Slide 2 -->
            <div class="slide absolute inset-0 bg-gradient-to-r from-green-600 to-blue-600 flex items-center">
                <div class="container mx-auto px-4 text-center text-white">
                    <div class="max-w-4xl mx-auto">
                        <h1 class="text-4xl md:text-6xl font-bold mb-6">
                            Pelayanan 24 Jam
                        </h1>
                        <p class="text-xl text-green-100 mb-8">
                            Siap melayani kebutuhan kesehatan Anda kapan saja dengan tim medis terpercaya
                        </p>
                        <div class="flex flex-col sm:flex-row gap-4 justify-center">
                            <a href="#contact"
                                class="bg-white text-green-600 px-8 py-3 rounded-full font-semibold hover:bg-green-50 transition duration-300 transform hover:scale-105">
                                <i class="fas fa-phone mr-2"></i>Hubungi Kami
                            </a>
                            <a href="#doctors"
                                class="border-2 border-white text-white px-8 py-3 rounded-full font-semibold hover:bg-white hover:text-green-600 transition duration-300">
                                <i class="fas fa-user-md mr-2"></i>Tim Dokter
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Slide 3 -->
            <div class="slide absolute inset-0 bg-gradient-to-r from-purple-600 to-pink-600 flex items-center">
                <div class="container mx-auto px-4 text-center text-white">
                    <div class="max-w-4xl mx-auto">
                        <h1 class="text-4xl md:text-6xl font-bold mb-6">
                            Teknologi Modern
                        </h1>
                        <p class="text-xl text-purple-100 mb-8">
                            Dilengkapi dengan peralatan medis terdepan untuk diagnosis dan perawatan terbaik
                        </p>
                        <div class="flex flex-col sm:flex-row gap-4 justify-center">
                            <a href="#services"
                                class="bg-white text-purple-600 px-8 py-3 rounded-full font-semibold hover:bg-purple-50 transition duration-300 transform hover:scale-105">
                                <i class="fas fa-microscope mr-2"></i>Lihat Fasilitas
                            </a>
                            <a href="#branch-selection"
                                class="border-2 border-white text-white px-8 py-3 rounded-full font-semibold hover:bg-white hover:text-purple-600 transition duration-300">
                                <i class="fas fa-calendar-check mr-2"></i>Booking Sekarang
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Slider Navigation -->
        <div class="absolute bottom-8 left-1/2 transform -translate-x-1/2 flex space-x-3">
            <button
                class="slider-dot active w-3 h-3 bg-white rounded-full opacity-50 hover:opacity-100 transition-opacity"
                data-slide="0"></button>
            <button class="slider-dot w-3 h-3 bg-white rounded-full opacity-50 hover:opacity-100 transition-opacity"
                data-slide="1"></button>
            <button class="slider-dot w-3 h-3 bg-white rounded-full opacity-50 hover:opacity-100 transition-opacity"
                data-slide="2"></button>
        </div>

        <!-- Slider Controls -->
        <button
            class="absolute left-4 top-1/2 transform -translate-y-1/2 text-white bg-black/20 hover:bg-black/40 rounded-full p-3 transition-all duration-300"
            id="prevSlide">
            <i class="fas fa-chevron-left text-xl"></i>
        </button>
        <button
            class="absolute right-4 top-1/2 transform -translate-y-1/2 text-white bg-black/20 hover:bg-black/40 rounded-full p-3 transition-all duration-300"
            id="nextSlide">
            <i class="fas fa-chevron-right text-xl"></i>
        </button>
    </section>

    <!-- Branch Selection Section -->
    <section id="branch-selection" class="py-16 bg-gradient-to-br from-blue-50 to-green-50">
        <div class="container mx-auto px-4">
            <div class="text-center mb-12">
                <h2 class="text-4xl font-bold text-gray-800 mb-4">Pilih Cabang Terdekat</h2>
                <p class="text-gray-600 max-w-2xl mx-auto text-lg">
                    Mulai perjalanan kesehatan Anda dengan memilih cabang yang paling nyaman untuk Anda kunjungi
                </p>
            </div>

            <div class="max-w-6xl mx-auto">
                <div class="grid md:grid-cols-3 gap-8">
                    @foreach ($branches as $branch)
                        <div class="bg-white rounded-2xl shadow-xl overflow-hidden hover:shadow-2xl transition-all duration-300 transform hover:-translate-y-2 cursor-pointer branch-card"
                            data-branch-id="{{ $branch['id'] }}"
                            onclick="selectBranch({{ $branch['id'] }}, '{{ $branch['name'] }}')">
                            <div class="relative h-48 bg-gradient-to-br from-blue-500 to-green-500">
                                <img src="{{ $branch['image'] ?? asset('img/clinic-branch.jpg') }}"
                                    alt="{{ $branch['name'] }}" class="w-full h-full object-cover mix-blend-overlay">
                                <div class="absolute inset-0 bg-gradient-to-t from-black/50 to-transparent"></div>
                                <div class="absolute top-4 right-4">
                                    <span class="bg-green-500 text-white px-3 py-1 rounded-full text-sm font-semibold">
                                        <i class="fas fa-check-circle mr-1"></i>Tersedia
                                    </span>
                                </div>
                                <div class="absolute bottom-4 left-4 text-white">
                                    <h3 class="text-xl font-bold">{{ $branch['name'] }}</h3>
                                    <p class="text-sm opacity-90">
                                        <i class="fas fa-map-marker-alt mr-1"></i>{{ $branch['city'] }}
                                    </p>
                                </div>
                            </div>

                            <div class="p-6">
                                <div class="mb-4">
                                    <p class="text-gray-600 text-sm mb-3">
                                        <i class="fas fa-map-marker-alt text-blue-500 mr-2"></i>
                                        {{ $branch['address'] }}
                                    </p>
                                    <p class="text-gray-600 text-sm mb-3">
                                        <i class="fas fa-phone text-green-500 mr-2"></i>
                                        {{ $branch['phone'] }}
                                    </p>
                                    <p class="text-gray-600 text-sm mb-4">
                                        <i class="fas fa-clock text-purple-500 mr-2"></i>
                                        {{ $branch['hours'] ?? 'Senin - Sabtu: 08:00 - 20:00' }}
                                    </p>
                                </div>

                                <div class="flex items-center justify-between mb-4">
                                    <div class="flex space-x-2">
                                        @foreach ($branch['specialties'] as $specialty)
                                            <span class="bg-blue-100 text-blue-800 px-2 py-1 rounded-full text-xs">
                                                {{ $specialty }}
                                            </span>
                                        @endforeach
                                    </div>
                                    <div class="text-right">
                                        <div class="text-sm text-gray-500">Jarak</div>
                                        <div class="font-semibold text-blue-600">{{ $branch['distance'] ?? '2.5 km' }}
                                        </div>
                                    </div>
                                </div>

                                <button
                                    class="w-full bg-gradient-to-r from-blue-600 to-green-600 text-white py-3 rounded-lg font-semibold hover:from-blue-700 hover:to-green-700 transition-all duration-300 transform hover:scale-105">
                                    <i class="fas fa-arrow-right mr-2"></i>Pilih Cabang Ini
                                </button>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </section>

    <!-- Poly Selection Section (Initially Hidden) -->
    <section id="poly-selection" class="py-16 bg-white hidden">
        <div class="container mx-auto px-4">
            <div class="text-center mb-12">
                <div class="flex items-center justify-center mb-4">
                    <button onclick="backToBranches()"
                        class="mr-4 text-blue-600 hover:text-blue-700 transition-colors">
                        <i class="fas fa-arrow-left text-xl"></i>
                    </button>
                    <h2 class="text-4xl font-bold text-gray-800">Pilih Poli</h2>
                </div>
                <p class="text-gray-600 max-w-2xl mx-auto text-lg">
                    Pilih spesialisasi yang sesuai dengan kebutuhan kesehatan Anda di <span id="selected-branch-name"
                        class="font-semibold text-blue-600"></span>
                </p>
            </div>

            <div class="max-w-4xl mx-auto">
                <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-6">
                    @foreach ($polies as $poly)
                        <div class="bg-gradient-to-br from-blue-50 to-green-50 rounded-xl shadow-lg hover:shadow-xl transition-all duration-300 transform hover:-translate-y-1 cursor-pointer poly-card"
                            data-poly-id="{{ $poly['id'] }}"
                            onclick="selectPoly({{ $poly['id'] }}, '{{ $poly['name'] }}')">
                            <div class="p-6 text-center">
                                <div
                                    class="w-16 h-16 bg-gradient-to-r from-blue-500 to-green-500 rounded-full flex items-center justify-center mx-auto mb-4">
                                    <i class="{{ $poly['icon'] }} text-white text-2xl"></i>
                                </div>
                                <h3 class="text-xl font-semibold text-gray-800 mb-3">{{ $poly['name'] }}</h3>
                                <p class="text-gray-600 text-sm mb-4">{{ $poly['description'] }}</p>
                                <div class="flex items-center justify-between text-sm">
                                    <span class="text-green-600 font-semibold">
                                        <i class="fas fa-user-md mr-1"></i>{{ $poly['doctor_count'] }} Dokter
                                    </span>
                                    <span class="text-blue-600 font-semibold">
                                        <i class="fas fa-clock mr-1"></i>{{ $poly['avg_duration'] }} menit
                                    </span>
                                </div>
                                <div class="mt-4 pt-4 border-t border-gray-200">
                                    <span class="text-gray-700 font-semibold">Mulai dari Rp
                                        {{ number_format($poly['price'], 0, ',', '.') }}</span>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </section>

    <!-- Doctor Schedule Selection Section (Initially Hidden) -->
    <section id="schedule-selection" class="py-16 bg-gradient-to-br from-blue-50 to-green-50 hidden">
        <div class="container mx-auto px-4">
            <div class="text-center mb-12">
                <div class="flex items-center justify-center mb-4">
                    <button onclick="backToPolies()" class="mr-4 text-blue-600 hover:text-blue-700 transition-colors">
                        <i class="fas fa-arrow-left text-xl"></i>
                    </button>
                    <h2 class="text-4xl font-bold text-gray-800">Pilih Jadwal Dokter</h2>
                </div>
                <p class="text-gray-600 max-w-2xl mx-auto text-lg">
                    Pilih jadwal konsultasi yang sesuai dengan waktu Anda di <span id="selected-poly-name"
                        class="font-semibold text-green-600"></span>
                </p>
            </div>

            <div class="max-w-6xl mx-auto">
                <!-- Date Selector -->
                <div class="bg-white rounded-xl shadow-lg p-6 mb-8">
                    <h3 class="text-xl font-semibold text-gray-800 mb-4">Pilih Tanggal</h3>
                    <div class="flex space-x-4 overflow-x-auto pb-2">
                        @for ($i = 0; $i < 7; $i++)
                            @php
                                $date = now()->addDays($i);
                                $isToday = $i === 0;
                            @endphp
                            <button
                                class="date-selector flex-shrink-0 text-center p-3 rounded-lg border-2 transition-all duration-300 {{ $isToday ? 'border-blue-500 bg-blue-50' : 'border-gray-200 hover:border-blue-300' }}"
                                data-date="{{ $date->format('Y-m-d') }}"
                                onclick="selectDate('{{ $date->format('Y-m-d') }}', this)">
                                <div class="text-sm text-gray-600">{{ $date->format('D') }}</div>
                                <div class="text-lg font-semibold {{ $isToday ? 'text-blue-600' : 'text-gray-800' }}">
                                    {{ $date->format('d') }}</div>
                                <div class="text-xs text-gray-500">{{ $date->format('M') }}</div>
                            </button>
                        @endfor
                    </div>
                </div>

                <!-- Doctor Schedule Cards -->
                <div class="grid lg:grid-cols-2 gap-6" id="doctor-schedules">
                    @foreach ($doctorSchedules as $doctor)
                        <div
                            class="bg-white rounded-xl shadow-lg overflow-hidden hover:shadow-xl transition-all duration-300">
                            <div class="p-6">
                                <div class="flex items-start space-x-4 mb-4">
                                    <img src="{{ $doctor['photo'] ?? asset('img/doctor-placeholder.jpg') }}"
                                        alt="{{ $doctor['name'] }}" class="w-16 h-16 rounded-full object-cover">
                                    <div class="flex-1">
                                        <h3 class="text-xl font-semibold text-gray-800">{{ $doctor['name'] }}</h3>
                                        <p class="text-blue-600 font-medium">{{ $doctor['specialization'] }}</p>
                                        <p class="text-gray-600 text-sm">{{ $doctor['experience'] }}</p>
                                        <div class="flex items-center mt-2">
                                            <div class="flex text-yellow-400 mr-2">
                                                @for ($i = 1; $i <= 5; $i++)
                                                    <i
                                                        class="fas fa-star {{ $i <= $doctor['rating'] ? '' : 'text-gray-300' }}"></i>
                                                @endfor
                                            </div>
                                            <span class="text-sm text-gray-600">({{ $doctor['reviews'] }}
                                                review)</span>
                                        </div>
                                    </div>
                                </div>

                                <div class="mb-4">
                                    <h4 class="font-semibold text-gray-800 mb-2">Jadwal Tersedia</h4>
                                    <div class="grid grid-cols-3 gap-2">
                                        @foreach ($doctor['available_times'] as $time)
                                            <button
                                                class="time-slot p-2 text-center border border-gray-200 rounded-lg hover:border-blue-500 hover:bg-blue-50 transition-all duration-300"
                                                data-doctor-id="{{ $doctor['id'] }}" data-time="{{ $time['time'] }}"
                                                onclick="selectTimeSlot({{ $doctor['id'] }}, '{{ $time['time'] }}', '{{ $doctor['name'] }}', this)">
                                                <div class="text-sm font-semibold text-gray-700">{{ $time['time'] }}
                                                </div>
                                                <div class="text-xs text-gray-500">{{ $time['available_slots'] }} slot
                                                </div>
                                            </button>
                                        @endforeach
                                    </div>
                                </div>

                                <div class="flex items-center justify-between pt-4 border-t border-gray-200">
                                    <div class="text-sm text-gray-600">
                                        <i class="fas fa-money-bill-wave mr-1"></i>
                                        Konsultasi: Rp {{ number_format($doctor['consultation_fee'], 0, ',', '.') }}
                                    </div>
                                    <button
                                        class="bg-gradient-to-r from-blue-600 to-green-600 text-white px-4 py-2 rounded-lg font-semibold hover:from-blue-700 hover:to-green-700 transition-all duration-300"
                                        onclick="proceedToBooking({{ $doctor['id'] }})">
                                        Lanjutkan
                                    </button>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </section>
    <div class="container mx-auto px-4">
        <div class="grid md:grid-cols-2 gap-12 items-center">
            <div>
                <h2 class="text-3xl font-bold text-gray-800 mb-6">Tentang {{ $company->name ?? 'Klinik Kami' }}</h2>
                <p class="text-gray-600 mb-6 leading-relaxed">
                    {{ $company->description ?? 'Kami adalah klinik kesehatan yang berkomitmen memberikan pelayanan medis terbaik dengan teknologi modern dan tenaga medis yang berpengalaman. Kesehatan Anda adalah prioritas utama kami.' }}
                </p>
                <div class="grid grid-cols-2 gap-4 mb-6">
                    <div class="text-center p-4 bg-blue-50 rounded-lg">
                        <div class="text-2xl font-bold text-blue-600">10+</div>
                        <div class="text-sm text-gray-600">Tahun Pengalaman</div>
                    </div>
                    <div class="text-center p-4 bg-green-50 rounded-lg">
                        <div class="text-2xl font-bold text-green-600">5000+</div>
                        <div class="text-sm text-gray-600">Pasien Dilayani</div>
                    </div>
                </div>
                <div class="flex flex-wrap gap-4">
                    <span class="bg-blue-100 text-blue-800 px-3 py-1 rounded-full text-sm">Pelayanan 24/7</span>
                    <span class="bg-green-100 text-green-800 px-3 py-1 rounded-full text-sm">Dokter
                        Berpengalaman</span>
                    <span class="bg-purple-100 text-purple-800 px-3 py-1 rounded-full text-sm">Teknologi
                        Modern</span>
                </div>
            </div>
            <div class="relative">
                <img src="{{ asset('img/clinic-hero.jpg') }}" alt="Klinik"
                    class="rounded-lg shadow-xl w-full h-80 object-cover">
                <div class="absolute inset-0 bg-gradient-to-t from-black/20 to-transparent rounded-lg"></div>
            </div>
        </div>
    </div>
    </section>

    <!-- Services Section -->
    <section id="services" class="py-16 bg-gray-50">
        <div class="container mx-auto px-4">
            <div class="text-center mb-12">
                <h2 class="text-3xl font-bold text-gray-800 mb-4">Layanan Kami</h2>
                <p class="text-gray-600 max-w-2xl mx-auto">
                    Kami menyediakan berbagai layanan kesehatan yang komprehensif untuk memenuhi kebutuhan medis Anda
                </p>
            </div>
            <div class="grid md:grid-cols-3 gap-8">
                @foreach ($services as $service)
                    <div class="bg-white rounded-lg shadow-lg p-6 hover:shadow-xl transition duration-300">
                        <div class="text-4xl text-blue-600 mb-4">
                            <i class="{{ $service['icon'] }}"></i>
                        </div>
                        <h3 class="text-xl font-semibold text-gray-800 mb-3">{{ $service['name'] }}</h3>
                        <p class="text-gray-600 mb-4">{{ $service['description'] }}</p>
                        <div class="text-sm text-blue-600 font-semibold">
                            Mulai dari Rp {{ number_format($service['price'], 0, ',', '.') }}
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    <!-- Doctors Section -->
    <section id="doctors" class="py-16 bg-white">
        <div class="container mx-auto px-4">
            <div class="text-center mb-12">
                <h2 class="text-3xl font-bold text-gray-800 mb-4">Tim Dokter Kami</h2>
                <p class="text-gray-600 max-w-2xl mx-auto">
                    Dokter-dokter berpengalaman dan bersertifikat siap melayani kesehatan Anda
                </p>
            </div>
            <div class="grid md:grid-cols-3 gap-8">
                @foreach ($doctors as $doctor)
                    <div class="bg-white rounded-lg shadow-lg overflow-hidden hover:shadow-xl transition duration-300">
                        <img src="{{ $doctor['photo'] ?? asset('img/doctor-placeholder.jpg') }}"
                            alt="{{ $doctor['name'] }}" class="w-full h-64 object-cover">
                        <div class="p-6">
                            <h3 class="text-xl font-semibold text-gray-800 mb-2">{{ $doctor['name'] }}</h3>
                            <p class="text-blue-600 mb-3">{{ $doctor['specialization'] }}</p>
                            <p class="text-gray-600 text-sm mb-4">{{ $doctor['experience'] }}</p>
                            <div class="flex justify-between items-center">
                                <div class="text-sm text-gray-500">
                                    <i class="fas fa-star text-yellow-400"></i>
                                    {{ $doctor['rating'] ?? '4.8' }} ({{ $doctor['reviews'] ?? '120' }} review)
                                </div>
                                <button
                                    class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 transition duration-300">
                                    Booking
                                </button>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    <!-- Booking Form Section (Initially Hidden) -->
    <section id="booking" class="py-16 bg-gradient-to-r from-blue-600 to-green-600 hidden">
        <div class="container mx-auto px-4">
            <div class="text-center text-white mb-12">
                <div class="flex items-center justify-center mb-4">
                    <button onclick="backToSchedule()" class="mr-4 text-white hover:text-blue-100 transition-colors">
                        <i class="fas fa-arrow-left text-xl"></i>
                    </button>
                    <h2 class="text-3xl font-bold">Konfirmasi Reservasi</h2>
                </div>
                <p class="text-blue-100 max-w-2xl mx-auto">
                    Lengkapi data diri Anda untuk menyelesaikan proses reservasi
                </p>
            </div>

            <div class="max-w-4xl mx-auto">
                <!-- Booking Summary -->
                <div class="bg-white rounded-lg shadow-xl p-6 mb-6">
                    <h3 class="text-xl font-semibold text-gray-800 mb-4">Ringkasan Reservasi</h3>
                    <div class="grid md:grid-cols-3 gap-4 text-sm">
                        <div class="flex items-center space-x-3">
                            <div class="w-8 h-8 bg-blue-100 rounded-full flex items-center justify-center">
                                <i class="fas fa-hospital text-blue-600"></i>
                            </div>
                            <div>
                                <div class="text-gray-600">Cabang</div>
                                <div class="font-semibold" id="summary-branch">-</div>
                            </div>
                        </div>
                        <div class="flex items-center space-x-3">
                            <div class="w-8 h-8 bg-green-100 rounded-full flex items-center justify-center">
                                <i class="fas fa-stethoscope text-green-600"></i>
                            </div>
                            <div>
                                <div class="text-gray-600">Poli</div>
                                <div class="font-semibold" id="summary-poly">-</div>
                            </div>
                        </div>
                        <div class="flex items-center space-x-3">
                            <div class="w-8 h-8 bg-purple-100 rounded-full flex items-center justify-center">
                                <i class="fas fa-user-md text-purple-600"></i>
                            </div>
                            <div>
                                <div class="text-gray-600">Dokter</div>
                                <div class="font-semibold" id="summary-doctor">-</div>
                            </div>
                        </div>
                        <div class="flex items-center space-x-3">
                            <div class="w-8 h-8 bg-yellow-100 rounded-full flex items-center justify-center">
                                <i class="fas fa-calendar text-yellow-600"></i>
                            </div>
                            <div>
                                <div class="text-gray-600">Tanggal</div>
                                <div class="font-semibold" id="summary-date">-</div>
                            </div>
                        </div>
                        <div class="flex items-center space-x-3">
                            <div class="w-8 h-8 bg-red-100 rounded-full flex items-center justify-center">
                                <i class="fas fa-clock text-red-600"></i>
                            </div>
                            <div>
                                <div class="text-gray-600">Waktu</div>
                                <div class="font-semibold" id="summary-time">-</div>
                            </div>
                        </div>
                        <div class="flex items-center space-x-3">
                            <div class="w-8 h-8 bg-indigo-100 rounded-full flex items-center justify-center">
                                <i class="fas fa-money-bill-wave text-indigo-600"></i>
                            </div>
                            <div>
                                <div class="text-gray-600">Biaya</div>
                                <div class="font-semibold" id="summary-fee">-</div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Patient Information Form -->
                <div class="bg-white rounded-lg shadow-xl p-8">
                    <h3 class="text-xl font-semibold text-gray-800 mb-6">Data Pasien</h3>
                    <form wire:submit.prevent="submitBooking" class="grid md:grid-cols-2 gap-6">
                        <div>
                            <label class="block text-gray-700 font-semibold mb-2">Nama Lengkap <span
                                    class="text-red-500">*</span></label>
                            <input type="text" wire:model="booking_name"
                                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                                placeholder="Masukkan nama lengkap">
                            @error('booking_name')
                                <span class="text-red-500 text-sm">{{ $message }}</span>
                            @enderror
                        </div>
                        <div>
                            <label class="block text-gray-700 font-semibold mb-2">NIK <span
                                    class="text-red-500">*</span></label>
                            <input type="text" wire:model="booking_nik"
                                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                                placeholder="Masukkan NIK (16 digit)">
                            @error('booking_nik')
                                <span class="text-red-500 text-sm">{{ $message }}</span>
                            @enderror
                        </div>
                        <div>
                            <label class="block text-gray-700 font-semibold mb-2">Nomor Telepon <span
                                    class="text-red-500">*</span></label>
                            <input type="tel" wire:model="booking_phone"
                                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                                placeholder="Masukkan nomor telepon">
                            @error('booking_phone')
                                <span class="text-red-500 text-sm">{{ $message }}</span>
                            @enderror
                        </div>
                        <div>
                            <label class="block text-gray-700 font-semibold mb-2">Email</label>
                            <input type="email" wire:model="booking_email"
                                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                                placeholder="Masukkan email (opsional)">
                            @error('booking_email')
                                <span class="text-red-500 text-sm">{{ $message }}</span>
                            @enderror
                        </div>
                        <div>
                            <label class="block text-gray-700 font-semibold mb-2">Tanggal Lahir <span
                                    class="text-red-500">*</span></label>
                            <input type="date" wire:model="booking_birthdate"
                                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                                max="{{ date('Y-m-d') }}">
                            @error('booking_birthdate')
                                <span class="text-red-500 text-sm">{{ $message }}</span>
                            @enderror
                        </div>
                        <div>
                            <label class="block text-gray-700 font-semibold mb-2">Jenis Kelamin <span
                                    class="text-red-500">*</span></label>
                            <select wire:model="booking_gender"
                                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                                <option value="">Pilih Jenis Kelamin</option>
                                <option value="L">Laki-laki</option>
                                <option value="P">Perempuan</option>
                            </select>
                            @error('booking_gender')
                                <span class="text-red-500 text-sm">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="md:col-span-2">
                            <label class="block text-gray-700 font-semibold mb-2">Alamat <span
                                    class="text-red-500">*</span></label>
                            <textarea wire:model="booking_address" rows="3"
                                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                                placeholder="Masukkan alamat lengkap"></textarea>
                            @error('booking_address')
                                <span class="text-red-500 text-sm">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="md:col-span-2">
                            <label class="block text-gray-700 font-semibold mb-2">Keluhan / Catatan</label>
                            <textarea wire:model="booking_notes" rows="4"
                                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                                placeholder="Ceritakan keluhan atau catatan khusus (opsional)"></textarea>
                            @error('booking_notes')
                                <span class="text-red-500 text-sm">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="md:col-span-2">
                            <div class="flex items-center mb-4">
                                <input type="checkbox" wire:model="booking_agreement" id="agreement"
                                    class="mr-3 h-4 w-4 text-blue-600">
                                <label for="agreement" class="text-gray-700 text-sm">
                                    Saya setuju dengan <a href="#" class="text-blue-600 hover:underline">syarat
                                        dan ketentuan</a>
                                    serta <a href="#" class="text-blue-600 hover:underline">kebijakan
                                        privasi</a> yang berlaku.
                                </label>
                            </div>
                            @error('booking_agreement')
                                <span class="text-red-500 text-sm">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="md:col-span-2 text-center">
                            <button type="submit"
                                class="bg-gradient-to-r from-blue-600 to-green-600 text-white px-12 py-4 rounded-lg font-semibold hover:from-blue-700 hover:to-green-700 transition duration-300 transform hover:scale-105 text-lg">
                                <i class="fas fa-calendar-check mr-2"></i>Konfirmasi Reservasi
                            </button>
                            <p class="text-gray-600 text-sm mt-4">
                                Dengan mengklik tombol di atas, Anda akan menerima konfirmasi melalui WhatsApp atau SMS
                            </p>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>

    <!-- Contact Section -->
    <section id="contact" class="py-16 bg-gray-900 text-white">
        <div class="container mx-auto px-4">
            <div class="grid md:grid-cols-2 gap-12">
                <div>
                    <h2 class="text-3xl font-bold mb-6">Hubungi Kami</h2>
                    <div class="space-y-4">
                        <div class="flex items-center space-x-4">
                            <div class="w-12 h-12 bg-blue-600 rounded-full flex items-center justify-center">
                                <i class="fas fa-map-marker-alt"></i>
                            </div>
                            <div>
                                <div class="font-semibold">Alamat</div>
                                <div class="text-gray-300">
                                    {{ $company->companyDetail->address ?? 'Jl. Kesehatan No. 123, Jakarta Selatan' }}
                                </div>
                            </div>
                        </div>
                        <div class="flex items-center space-x-4">
                            <div class="w-12 h-12 bg-green-600 rounded-full flex items-center justify-center">
                                <i class="fas fa-phone"></i>
                            </div>
                            <div>
                                <div class="font-semibold">Telepon</div>
                                <div class="text-gray-300">{{ $company->phone ?? '(021) 1234-5678' }}</div>
                            </div>
                        </div>
                        <div class="flex items-center space-x-4">
                            <div class="w-12 h-12 bg-purple-600 rounded-full flex items-center justify-center">
                                <i class="fas fa-envelope"></i>
                            </div>
                            <div>
                                <div class="font-semibold">Email</div>
                                <div class="text-gray-300">{{ $company->email ?? 'info@klinik.com' }}</div>
                            </div>
                        </div>
                        <div class="flex items-center space-x-4">
                            <div class="w-12 h-12 bg-red-600 rounded-full flex items-center justify-center">
                                <i class="fas fa-clock"></i>
                            </div>
                            <div>
                                <div class="font-semibold">Jam Operasional</div>
                                <div class="text-gray-300">Senin - Sabtu: 08:00 - 20:00 WIB</div>
                                <div class="text-gray-300">Minggu: 08:00 - 16:00 WIB</div>
                            </div>
                        </div>
                    </div>
                </div>
                <div>
                    <h3 class="text-xl font-semibold mb-6">Peta Lokasi</h3>
                    <div class="bg-gray-800 rounded-lg h-80 flex items-center justify-center">
                        <div class="text-center text-gray-400">
                            <i class="fas fa-map text-4xl mb-4"></i>
                            <p>Google Maps akan ditampilkan di sini</p>
                        </div>
                    </div>
                </div>
            </div>
    </section>

    <!-- Company Profile Section -->
    <section class="py-16 bg-white">
        <div class="container mx-auto px-4">
            <div class="grid md:grid-cols-2 gap-12 items-center">
                <div>
                    <h2 class="text-3xl font-bold text-gray-800 mb-6">Tentang {{ $company->name ?? 'Klinik Kami' }}
                    </h2>
                    <p class="text-gray-600 mb-6 leading-relaxed">
                        {{ $company->description ?? 'Kami adalah klinik kesehatan yang berkomitmen memberikan pelayanan medis terbaik dengan teknologi modern dan tenaga medis yang berpengalaman. Kesehatan Anda adalah prioritas utama kami.' }}
                    </p>
                    <div class="grid grid-cols-2 gap-4 mb-6">
                        <div class="text-center p-4 bg-blue-50 rounded-lg">
                            <div class="text-2xl font-bold text-blue-600">10+</div>
                            <div class="text-sm text-gray-600">Tahun Pengalaman</div>
                        </div>
                        <div class="text-center p-4 bg-green-50 rounded-lg">
                            <div class="text-2xl font-bold text-green-600">5000+</div>
                            <div class="text-sm text-gray-600">Pasien Dilayani</div>
                        </div>
                    </div>
                    <div class="flex flex-wrap gap-4">
                        <span class="bg-blue-100 text-blue-800 px-3 py-1 rounded-full text-sm">Pelayanan 24/7</span>
                        <span class="bg-green-100 text-green-800 px-3 py-1 rounded-full text-sm">Dokter
                            Berpengalaman</span>
                        <span class="bg-purple-100 text-purple-800 px-3 py-1 rounded-full text-sm">Teknologi
                            Modern</span>
                    </div>
                </div>
                <div class="relative">
                    <img src="{{ asset('img/clinic-hero.jpg') }}" alt="Klinik"
                        class="rounded-lg shadow-xl w-full h-80 object-cover">
                    <div class="absolute inset-0 bg-gradient-to-t from-black/20 to-transparent rounded-lg"></div>
                </div>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="bg-gray-800 text-white py-8">
        <div class="container mx-auto px-4">
            <div class="grid md:grid-cols-4 gap-8">
                <div>
                    <div class="flex items-center space-x-3 mb-4">
                        <div
                            class="w-10 h-10 bg-gradient-to-r from-blue-500 to-green-500 rounded-full flex items-center justify-center">
                            <i class="fas fa-heartbeat text-white"></i>
                        </div>
                        <div class="font-bold text-lg">{{ $company->name ?? 'Klinik Sehat' }}</div>
                    </div>
                    <p class="text-gray-400 text-sm">
                        Memberikan pelayanan kesehatan terbaik dengan teknologi modern dan tenaga medis berpengalaman.
                    </p>
                </div>
                <div>
                    <h4 class="font-semibold mb-4">Layanan</h4>
                    <ul class="space-y-2 text-sm text-gray-400">
                        <li><a href="#" class="hover:text-white transition duration-300">Konsultasi Umum</a>
                        </li>
                        <li><a href="#" class="hover:text-white transition duration-300">Pemeriksaan
                                Laboratorium</a></li>
                        <li><a href="#" class="hover:text-white transition duration-300">Medical Check Up</a>
                        </li>
                        <li><a href="#" class="hover:text-white transition duration-300">Farmasi</a></li>
                    </ul>
                </div>
                <div>
                    <h4 class="font-semibold mb-4">Informasi</h4>
                    <ul class="space-y-2 text-sm text-gray-400">
                        <li><a href="#" class="hover:text-white transition duration-300">Tentang Kami</a></li>
                        <li><a href="#" class="hover:text-white transition duration-300">Tim Dokter</a></li>
                        <li><a href="#" class="hover:text-white transition duration-300">Karir</a></li>
                        <li><a href="#" class="hover:text-white transition duration-300">Kontak</a></li>
                    </ul>
                </div>
                <div>
                    <h4 class="font-semibold mb-4">Follow Kami</h4>
                    <div class="flex space-x-4">
                        <a href="#"
                            class="w-10 h-10 bg-blue-600 rounded-full flex items-center justify-center hover:bg-blue-700 transition duration-300">
                            <i class="fab fa-facebook-f"></i>
                        </a>
                        <a href="#"
                            class="w-10 h-10 bg-pink-600 rounded-full flex items-center justify-center hover:bg-pink-700 transition duration-300">
                            <i class="fab fa-instagram"></i>
                        </a>
                        <a href="#"
                            class="w-10 h-10 bg-blue-400 rounded-full flex items-center justify-center hover:bg-blue-500 transition duration-300">
                            <i class="fab fa-twitter"></i>
                        </a>
                        <a href="#"
                            class="w-10 h-10 bg-green-600 rounded-full flex items-center justify-center hover:bg-green-700 transition duration-300">
                            <i class="fab fa-whatsapp"></i>
                        </a>
                    </div>
                </div>
            </div>
            <div class="border-t border-gray-700 mt-8 pt-6 text-center text-sm text-gray-400">
                <p>&copy; {{ date('Y') }} {{ $company->name ?? 'Klinik Sehat Mandiri' }}. All rights reserved.</p>
            </div>
        </div>
    </footer>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Hero Slider Functionality
        let currentSlide = 0;
        const slides = document.querySelectorAll('.slide');
        const totalSlides = slides.length;
        const sliderDots = document.querySelectorAll('.slider-dot');

        function showSlide(index) {
            slides.forEach((slide, i) => {
                slide.classList.toggle('active', i === index);
            });
            sliderDots.forEach((dot, i) => {
                dot.classList.toggle('active', i === index);
            });
        }

        function nextSlide() {
            currentSlide = (currentSlide + 1) % totalSlides;
            showSlide(currentSlide);
        }

        function prevSlide() {
            currentSlide = (currentSlide - 1 + totalSlides) % totalSlides;
            showSlide(currentSlide);
        }

        // Auto slide every 5 seconds
        setInterval(nextSlide, 5000);

        // Slider controls
        document.getElementById('nextSlide')?.addEventListener('click', nextSlide);
        document.getElementById('prevSlide')?.addEventListener('click', prevSlide);

        // Slider dots
        sliderDots.forEach((dot, index) => {
            dot.addEventListener('click', () => {
                currentSlide = index;
                showSlide(currentSlide);
            });
        });

        // Mobile menu toggle
        const mobileMenuBtn = document.getElementById('mobile-menu-btn');
        const mobileMenu = document.getElementById('mobile-menu');

        if (mobileMenuBtn) {
            mobileMenuBtn.addEventListener('click', function() {
                mobileMenu.classList.toggle('hidden');
            });
        }

        // Smooth scrolling
        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', function(e) {
                e.preventDefault();
                const target = document.querySelector(this.getAttribute('href'));
                if (target) {
                    target.scrollIntoView({
                        behavior: 'smooth',
                        block: 'start'
                    });
                }
            });
        });

        // Navbar background on scroll
        window.addEventListener('scroll', function() {
            const header = document.querySelector('header');
            if (window.scrollY > 100) {
                header.classList.add('bg-white/95', 'backdrop-blur-sm');
            } else {
                header.classList.remove('bg-white/95', 'backdrop-blur-sm');
            }
        });
    });

    // Booking Flow Variables
    let selectedBranch = null;
    let selectedPoly = null;
    let selectedDoctor = null;
    let selectedDate = null;
    let selectedTime = null;

    // Branch Selection
    function selectBranch(branchId, branchName) {
        selectedBranch = {
            id: branchId,
            name: branchName
        };
        document.getElementById('selected-branch-name').textContent = branchName;
        document.getElementById('summary-branch').textContent = branchName;

        // Hide branch selection and show poly selection
        document.getElementById('branch-selection').classList.add('hidden');
        document.getElementById('poly-selection').classList.remove('hidden');

        // Smooth scroll to poly section
        document.getElementById('poly-selection').scrollIntoView({
            behavior: 'smooth',
            block: 'start'
        });
    }

    // Poly Selection
    function selectPoly(polyId, polyName) {
        selectedPoly = {
            id: polyId,
            name: polyName
        };
        document.getElementById('selected-poly-name').textContent = polyName;
        document.getElementById('summary-poly').textContent = polyName;

        // Hide poly selection and show schedule selection
        document.getElementById('poly-selection').classList.add('hidden');
        document.getElementById('schedule-selection').classList.remove('hidden');

        // Smooth scroll to schedule section
        document.getElementById('schedule-selection').scrollIntoView({
            behavior: 'smooth',
            block: 'start'
        });
    }

    // Date Selection
    function selectDate(date, element) {
        selectedDate = date;

        // Update active date selector
        document.querySelectorAll('.date-selector').forEach(el => {
            el.classList.remove('border-blue-500', 'bg-blue-50');
            el.classList.add('border-gray-200');
            el.querySelector('div:nth-child(2)').classList.remove('text-blue-600');
            el.querySelector('div:nth-child(2)').classList.add('text-gray-800');
        });

        element.classList.remove('border-gray-200');
        element.classList.add('border-blue-500', 'bg-blue-50');
        element.querySelector('div:nth-child(2)').classList.remove('text-gray-800');
        element.querySelector('div:nth-child(2)').classList.add('text-blue-600');

        // Update summary
        const formattedDate = new Date(date).toLocaleDateString('id-ID', {
            weekday: 'long',
            year: 'numeric',
            month: 'long',
            day: 'numeric'
        });
        document.getElementById('summary-date').textContent = formattedDate;
    }

    // Time Slot Selection
    function selectTimeSlot(doctorId, time, doctorName, element) {
        selectedDoctor = {
            id: doctorId,
            name: doctorName
        };
        selectedTime = time;

        // Update active time slot
        document.querySelectorAll('.time-slot').forEach(el => {
            el.classList.remove('border-blue-500', 'bg-blue-50');
            el.classList.add('border-gray-200');
        });

        element.classList.remove('border-gray-200');
        element.classList.add('border-blue-500', 'bg-blue-50');

        // Update summary
        document.getElementById('summary-doctor').textContent = doctorName;
        document.getElementById('summary-time').textContent = time + ' WIB';
    }

    // Proceed to Booking
    function proceedToBooking(doctorId) {
        if (!selectedDate || !selectedTime) {
            alert('Silakan pilih tanggal dan waktu terlebih dahulu');
            return;
        }

        // Get consultation fee (you can get this from the doctor data)
        const fee = 'Rp 150.000'; // This should be dynamic based on selected doctor
        document.getElementById('summary-fee').textContent = fee;

        // Hide schedule selection and show booking form
        document.getElementById('schedule-selection').classList.add('hidden');
        document.getElementById('booking').classList.remove('hidden');

        // Smooth scroll to booking section
        document.getElementById('booking').scrollIntoView({
            behavior: 'smooth',
            block: 'start'
        });
    }

    // Navigation Back Functions
    function backToBranches() {
        document.getElementById('poly-selection').classList.add('hidden');
        document.getElementById('branch-selection').classList.remove('hidden');
        document.getElementById('branch-selection').scrollIntoView({
            behavior: 'smooth',
            block: 'start'
        });
    }

    function backToPolies() {
        document.getElementById('schedule-selection').classList.add('hidden');
        document.getElementById('poly-selection').classList.remove('hidden');
        document.getElementById('poly-selection').scrollIntoView({
            behavior: 'smooth',
            block: 'start'
        });
    }

    function backToSchedule() {
        document.getElementById('booking').classList.add('hidden');
        document.getElementById('schedule-selection').classList.remove('hidden');
        document.getElementById('schedule-selection').scrollIntoView({
            behavior: 'smooth',
            block: 'start'
        });
    }

    // Add custom CSS for animations
    const style = document.createElement('style');
    style.textContent = `
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

        .animate-fade-in-up {
            animation: fadeInUp 0.6s ease-out;
        }

        .animation-delay-300 {
            animation-delay: 0.3s;
            animation-fill-mode: both;
        }

        .animation-delay-600 {
            animation-delay: 0.6s;
            animation-fill-mode: both;
        }

        .slide {
            opacity: 0;
            transition: opacity 0.5s ease-in-out;
        }

        .slide.active {
            opacity: 1;
        }

        .slider-dot.active {
            opacity: 1 !important;
        }
    `;
    document.head.appendChild(style);
</script>
