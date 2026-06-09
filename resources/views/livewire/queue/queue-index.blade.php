<div>
    {{-- To attain knowledge, add things every day; To attain wisdom, subtract things every day. --}}
    <div class="min-h-screen">
        <!-- Header -->
        <nav class="bg-white shadow-lg border-b border-gray-200">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex justify-between h-16">
                    <div class="flex items-center">
                        <div class="flex-shrink-0">
                            <h1 class="text-2xl font-bold text-blue-600 ">🏥 Antrian Klinik</h1>
                        </div>
                    </div>
                    <div class="flex items-center space-x-2">
                        <a href="{{ route('queue.register') }}"
                            class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg font-medium transition-colors duration-200 flex items-center space-x-2">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                            </svg>
                            <span>Daftar Antrian</span>
                        </a>
                        <a href="#"
                            class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-lg font-medium transition-colors duration-200">
                            Dashboard Admin
                        </a>
                        <button id="theme-toggle" type="button"
                            class="text-gray-500  hover:bg-gray-100 dark:hover:bg-gray-700 focus:outline-none focus:ring-4 focus:ring-gray-200 dark:focus:ring-gray-700 rounded-lg text-sm p-2.5">
                            <svg id="theme-toggle-dark-icon" class="hidden w-5 h-5" fill="currentColor"
                                viewBox="0 0 20 20">
                                <path d="M17.293 13.293A8 8 0 016.707 2.707a8.001 8.001 0 1010.586 10.586z"></path>
                            </svg>
                            <svg id="theme-toggle-light-icon" class="hidden w-5 h-5" fill="currentColor"
                                viewBox="0 0 20 20">
                                <path
                                    d="M10 2a1 1 0 011 1v1a1 1 0 11-2 0V3a1 1 0 011-1zm4 8a4 4 0 11-8 0 4 4 0 018 0zm-.464 4.95l.707.707a1 1 0 001.414-1.414l-.707-.707a1 1 0 00-1.414 1.414zm2.12-10.607a1 1 0 010 1.414l-.706.707a1 1 0 11-1.414-1.414l.707-.707a1 1 0 011.414 0zM17 11a1 1 0 100-2h-1a1 1 0 100 2h1zm-7 4a1 1 0 011 1v1a1 1 0 11-2 0v-1a1 1 0 011-1zM5.05 5.05A1 1 0 016.465 3.636l.707.707a1 1 0 01-1.414 1.414l-.707-.707a1 1 0 010-1.414zM5 11a1 1 0 100-2H4a1 1 0 100 2h1zM8 16a1 1 0 011 1v1a1 1 0 11-2 0v-1a1 1 0 011-1z">
                                </path>
                            </svg>
                        </button>
                    </div>
                </div>
            </div>
        </nav>

        <!-- Main Content -->
        <main class="max-w-7xl mx-auto py-6 sm:px-6 lg:px-8">
            <!-- Branch Selection -->
            <div class="mb-8">
                <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg border border-gray-200">
                    <div class="p-6">
                        <h2 class="text-2xl font-bold text-gray-900 mb-6">Pilih Cabang Klinik</h2>
                        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                            @foreach ($branches as $branch)
                                <div class="bg-white border border-gray-200 rounded-lg shadow-md hover:shadow-lg transition-shadow duration-300 cursor-pointer {{ $selectedBranch == $branch['id'] ? 'ring-2 ring-blue-500' : '' }}"
                                    wire:click="selectBranch('{{ $branch['id'] }}')">
                                    <div class="relative">
                                        <img src="{{ asset('asset/img/no-image.png') }}" alt="{{ $branch['name'] }}"
                                            class="w-full h-48 object-cover rounded-t-lg"
                                            onerror="this.src='{{ asset('img/default-clinic.jpg') }}'">
                                    </div>
                                    <div class="p-4">
                                        <h3 class="text-lg font-semibold text-gray-900 mb-2">{{ $branch['name'] }}</h3>
                                        <p class="text-sm text-gray-600 mb-2">{{ $branch['city'] }}</p>
                                        <p class="text-sm text-gray-500 mb-3 flex items-center">
                                            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z">
                                                </path>
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                            </svg>
                                            {{ $branch['address'] }}
                                        </p>
                                        <div class="flex items-center justify-between text-sm text-gray-500 mb-3">
                                            <span class="flex items-center">
                                                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor"
                                                    viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        stroke-width="2"
                                                        d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z">
                                                    </path>
                                                </svg>
                                                {{ $branch['phone'] }}
                                            </span>
                                            {{-- <span class="text-blue-600 font-medium">{{ $branch['distance'] }}</span> --}}
                                        </div>
                                        <div class="flex flex-wrap gap-1 mb-3">
                                            @foreach ($branch['specialties'] as $specialty)
                                                <span
                                                    class="bg-blue-100 text-blue-800 text-xs font-medium px-2 py-1 rounded-full">
                                                    {{ $specialty }}
                                                </span>
                                            @endforeach
                                        </div>
                                        {{-- <div class="text-xs text-gray-500 mb-3">
                                            <svg class="w-4 h-4 inline mr-1" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                            </svg>
                                            {{ $branch['hours'] }}
                                        </div> --}}
                                        <div class="grid grid-cols-3 gap-2 text-center">
                                            <div class="bg-gray-50 rounded p-2">
                                                <div class="text-lg font-bold text-blue-600">
                                                    {{ $branch['current_queue'] }}</div>
                                                <div class="text-xs text-gray-500">Sedang Dilayani</div>
                                            </div>
                                            <div class="bg-gray-50 rounded p-2">
                                                <div class="text-lg font-bold text-yellow-600">
                                                    {{ $branch['waiting_queue'] }}</div>
                                                <div class="text-xs text-gray-500">Menunggu</div>
                                            </div>
                                            <div class="bg-gray-50 rounded p-2">
                                                <div class="text-lg font-bold text-green-600">
                                                    {{ $branch['total_queue'] }}</div>
                                                <div class="text-xs text-gray-500">Total Hari Ini</div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>

            @if ($selectedBranch && $selectedBranchData)
                <!-- Poli Selection for Selected Branch -->
                <div class="mb-8">
                    <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg border border-gray-200">
                        <div class="p-6">
                            <h2 class="text-2xl font-bold text-gray-900 mb-2">Poli di {{ $selectedBranchData['name'] }}
                            </h2>
                            <p class="text-gray-600 mb-6">Pilih poli untuk melihat informasi antrian</p>
                            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                                @foreach ($polies as $poli)
                                    <div class="bg-white border border-gray-200 rounded-lg p-4 hover:shadow-md transition-shadow duration-300 cursor-pointer {{ $selectedPoly == $poli['id'] ? 'ring-2 ring-blue-500' : '' }}"
                                        wire:click="selectPoly({{ $poli['id'] }})">
                                        <div class="flex items-center mb-3">
                                            <div class="bg-blue-100 p-2 rounded-lg mr-3">
                                                <i class="{{ $poli['icon'] }} text-blue-600 text-xl"></i>
                                            </div>
                                            <div>
                                                <h3 class="font-semibold text-gray-900">{{ $poli['name'] }}</h3>
                                                <p class="text-sm text-gray-500">{{ $poli['description'] }}</p>
                                            </div>
                                        </div>
                                        <div class="text-sm text-gray-600 mb-3">
                                            <strong>Dokter:</strong> {{ $poli['doctor'] }}
                                        </div>
                                        <div class="grid grid-cols-3 gap-2 text-center">
                                            <div class="bg-blue-50 rounded p-2">
                                                <div class="text-sm font-bold text-blue-600">
                                                    {{ $poli['current_queue'] }}</div>
                                                <div class="text-xs text-gray-500">Sekarang</div>
                                            </div>
                                            <div class="bg-yellow-50 rounded p-2">
                                                <div class="text-sm font-bold text-yellow-600">
                                                    {{ $poli['waiting_count'] }}</div>
                                                <div class="text-xs text-gray-500">Menunggu</div>
                                            </div>
                                            <div class="bg-green-50 rounded p-2">
                                                <div class="text-sm font-bold text-green-600">
                                                    {{ $poli['served_today'] }}</div>
                                                <div class="text-xs text-gray-500">Selesai</div>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
            @endif

            @if ($selectedPoly)
                <!-- Current Queue Display for Selected Poli -->
                <div class="mb-8">
                    <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg border border-gray-200">
                        <div class="p-6 text-center">
                            @php
                                $selectedPoliData = collect($polies)->firstWhere('id', $selectedPoly);
                            @endphp
                            <h2 class="text-3xl font-bold text-gray-900 mb-4">Antrian
                                {{ $selectedPoliData['name'] ?? 'Poli' }}</h2>
                            <div class="bg-blue-50 border border-blue-200 rounded-lg p-8 mb-4">
                                <div class="text-6xl font-bold text-blue-600 mb-2">
                                    {{ $selectedPoliData['current_queue'] ?? '000' }}</div>
                                <div class="text-xl text-gray-700">{{ $selectedPoliData['doctor'] ?? 'Dokter' }}</div>
                                <div class="text-sm text-gray-500 mt-2">Sedang Dilayani</div>
                            </div>

                            <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mt-6">
                                <div class="bg-yellow-50 border border-yellow-200 rounded-lg p-4">
                                    <div class="text-2xl font-bold text-yellow-600">
                                        {{ $selectedPoliData['waiting_count'] ?? 0 }}</div>
                                    <div class="text-sm text-yellow-700">Antrian Menunggu</div>
                                </div>
                                <div class="bg-green-50 border border-green-200 rounded-lg p-4">
                                    <div class="text-2xl font-bold text-green-600">
                                        {{ $selectedPoliData['served_today'] ?? 0 }}</div>
                                    <div class="text-sm text-green-700">Selesai Hari Ini</div>
                                </div>
                                <div class="bg-blue-50 border border-blue-200 rounded-lg p-4">
                                    <div class="text-2xl font-bold text-blue-600">
                                        {{ ($selectedPoliData['served_today'] ?? 0) + ($selectedPoliData['waiting_count'] ?? 0) + 1 }}
                                    </div>
                                    <div class="text-sm text-blue-700">Total Hari Ini</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @else
                <!-- Default Current Queue Display -->
                {{-- <div class="mb-8">
                    <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg border border-gray-200">
                        <div class="p-6 text-center">
                            <h2 class="text-3xl font-bold text-gray-900 mb-4">Antrian Saat Ini</h2>
                            @if ($selectedBranch)
                                <div class="bg-blue-50 border border-blue-200 rounded-lg p-8 mb-4">
                                    <div class="text-6xl font-bold text-blue-600 mb-2">
                                        {{ $selectedBranchData['current_queue'] }}</div>
                                    <div class="text-xl text-gray-700">{{ $selectedBranchData['name'] }}</div>
                                    <div class="text-sm text-gray-500 mt-2">Sedang Dilayani</div>
                                </div>
                            @else
                                <div class="bg-gray-50 border border-gray-200 rounded-lg p-8 mb-4">
                                    <div class="text-4xl font-bold text-gray-400 mb-2">-</div>
                                    <div class="text-xl text-gray-500">Pilih cabang untuk melihat antrian</div>
                                </div>
                            @endif

                            @if ($selectedBranch && $selectedBranchData)
                                <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mt-6">
                                    <div class="bg-yellow-50 border border-yellow-200 rounded-lg p-4">
                                        <div class="text-2xl font-bold text-yellow-600">
                                            {{ $selectedBranchData['waiting_queue'] }}</div>
                                        <div class="text-sm text-yellow-700">Antrian Menunggu</div>
                                    </div>
                                    <div class="bg-green-50 border border-green-200 rounded-lg p-4">
                                        <div class="text-2xl font-bold text-green-600">
                                            {{ $selectedBranchData['total_queue'] - $selectedBranchData['waiting_queue'] }}
                                        </div>
                                        <div class="text-sm text-green-700">Selesai Hari Ini</div>
                                    </div>
                                    <div class="bg-blue-50 border border-blue-200 rounded-lg p-4">
                                        <div class="text-2xl font-bold text-blue-600">
                                            {{ $selectedBranchData['total_queue'] }}</div>
                                        <div class="text-sm text-blue-700">Total Hari Ini</div>
                                    </div>
                                </div>
                            @endif
                        </div>
                    </div>
                </div> --}}
            @endif

            <!-- Queue List -->
            {{-- <div class="bg-white  overflow-hidden shadow-xl sm:rounded-lg border border-gray-200 ">
                <div class="px-6 py-4 border-b border-gray-200 ">
                    <h3 class="text-lg font-medium text-gray-900"> Daftar Antrian Hari Ini</h3>
                    <p class="text-sm text-gray-500 ">{{ now()->format('d F Y') }}</p>
                </div>
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200 ">
                        <thead class="bg-gray-50 ">
                            <tr>
                                <th
                                    class="px-6 py-3 text-left text-xs font-medium text-gray-500  uppercase tracking-wider">
                                    No. Antrian</th>
                                <th
                                    class="px-6 py-3 text-left text-xs font-medium text-gray-500  uppercase tracking-wider">
                                    Nama Pasien</th>
                                <th
                                    class="px-6 py-3 text-left text-xs font-medium text-gray-500  uppercase tracking-wider">
                                    Waktu Daftar</th>
                                <th
                                    class="px-6 py-3 text-left text-xs font-medium text-gray-500  uppercase tracking-wider">
                                    Status</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white  divide-y divide-gray-200 " id="queue-table-body">
                            @forelse($todayQueues as $queue)
                                <tr class="hover:bg-gray-50 -700 transition-colors duration-200">
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-lg font-bold text-gray-900  $queue['queue_number'] }}</div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm font-medium text-gray-900  $queue['patient_name'] }}</div>
                                        <div class="text-sm text-gray-500 ">{{ $queue['gender'] }}, {{ $queue['age'] }} tahun</div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 ">
                                        {{ \Carbon\Carbon::parse($queue['queue_time'])->format('H:i') }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        @if ($queue['status'] === 'Menunggu')
                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800 /20 ">
                                                Menunggu
                                            </span>
                                        @elseif($queue['status'] === 'Sedang Dilayani')
                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800 /20 ">
                                                Sedang Dilayani
                                            </span>
                                        @elseif($queue['status'] === 'Selesai')
                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800 /20 ">
                                                Selesai
                                            </span>
                                        @else
                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800 /20 ">
                                                Dibatalkan
                                            </span>
                                        @endif
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="px-6 py-8 text-center text-gray-500 ">
                                        Belum ada antrian hari ini
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div> --}}
        </main>
    </div>

    <!-- JavaScript for Enhanced Interactions -->
    {{-- <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Auto refresh queue every 30 seconds
            setInterval(function() {
                if (window.livewire) {
                    Livewire.emit('refreshQueue');
                }
            }, 30000);

            // Add smooth scroll animation when branch is selected
            document.addEventListener('livewire:load', function() {
                Livewire.on('branchSelected', () => {
                    setTimeout(() => {
                        const poliSection = document.querySelector('[class*="Poli di"]');
                        if (poliSection) {
                            poliSection.scrollIntoView({
                                behavior: 'smooth',
                                block: 'start'
                            });
                        }
                    }, 100);
                });
            });

            // Add pulse animation to current queue
            const currentQueueElement = document.querySelector('.text-6xl');
            if (currentQueueElement) {
                setInterval(() => {
                    currentQueueElement.classList.add('animate-pulse');
                    setTimeout(() => {
                        currentQueueElement.classList.remove('animate-pulse');
                    }, 2000);
                }, 5000);
            }
        });

        // Theme toggle functionality
        const themeToggleBtn = document.getElementById('theme-toggle');
        const themeToggleDarkIcon = document.getElementById('theme-toggle-dark-icon');
        const themeToggleLightIcon = document.getElementById('theme-toggle-light-icon');

        if (localStorage.getItem('color-theme') === 'dark' || (!('color-theme' in localStorage) && window.matchMedia(
                '(prefers-color-scheme: dark)').matches)) {
            themeToggleLightIcon.classList.remove('hidden');
        } else {
            themeToggleDarkIcon.classList.remove('hidden');
        }

        themeToggleBtn.addEventListener('click', function() {
            themeToggleDarkIcon.classList.toggle('hidden');
            themeToggleLightIcon.classList.toggle('hidden');

            if (localStorage.getItem('color-theme')) {
                if (localStorage.getItem('color-theme') === 'light') {
                    document.documentElement.classList.add('dark');
                    localStorage.setItem('color-theme', 'dark');
                } else {
                    document.documentElement.classList.remove('dark');
                    localStorage.setItem('color-theme', 'light');
                }
            } else {
                if (document.documentElement.classList.contains('dark')) {
                    document.documentElement.classList.remove('dark');
                    localStorage.setItem('color-theme', 'light');
                } else {
                    document.documentElement.classList.add('dark');
                    localStorage.setItem('color-theme', 'dark');
                }
            }
        });
    </script> --}}
</div>
