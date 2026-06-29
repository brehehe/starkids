{{-- WHO Growth Chart for Children (Livewire Compatible) --}}
<div class="space-y-6" id="growthChartContainer">
    <!-- Growth Chart Cards -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6" wire:ignore>
        <!-- BB/U Card -->
        <div class="bg-gradient-to-br from-blue-50 to-white rounded-xl shadow-md border-2 border-blue-200 overflow-hidden">
            <div class="bg-gradient-to-r from-blue-500 to-blue-600 p-4 text-white">
                <div class="flex items-center gap-3">
                    <div class="bg-white/20 rounded-full p-3">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 6l3 1m0 0l-3 9a5.002 5.002 0 006.001 0M6 7l3 9M6 7l6-2m6 2l3-1m-3 1l-3 9a5.002 5.002 0 006.001 0M18 7l3 9m-3-9l-6-2m0-2v2m0 16V5m0 16H9m3 0h3" />
                        </svg>
                    </div>
                    <div>
                        <h3 class="text-xl font-bold">Indikator BB/U</h3>
                        <p class="text-sm text-blue-100">Berat Badan Sesuai Usia</p>
                    </div>
                </div>
            </div>
            <div class="p-4">
                <div class="mb-4" style="height: 250px;">
                    <canvas id="bbUChart"></canvas>
                </div>
                <div id="bbURating" class="text-center py-2 rounded-lg font-semibold bg-gray-100 text-gray-600">
                    <span id="bbUStatus">Menunggu data...</span>
                </div>
                <p class="text-xs text-gray-600 text-center mt-2">
                    Z-Score: <span id="bbUZ" class="font-semibold">-</span>
                </p>
            </div>
        </div>

        <!-- PB/U Card -->
        <div class="bg-gradient-to-br from-orange-50 to-white rounded-xl shadow-md border-2 border-orange-200 overflow-hidden">
            <div class="bg-gradient-to-r from-orange-500 to-orange-600 p-4 text-white">
                <div class="flex items-center gap-3">
                    <div class="bg-white/20 rounded-full p-3">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 12l3-3 3 3 4-4M8 21l4-4 4 4M3 4h18M4 4h16v12a1 1 0 01-1 1H5a1 1 0 01-1-1V4z" />
                        </svg>
                    </div>
                    <div>
                        <h3 class="text-xl font-bold">Indikator PB/U</h3>
                        <p class="text-sm text-orange-100">Panjang Badan Sesuai Usia</p>
                    </div>
                </div>
            </div>
            <div class="p-4">
                <div class="mb-4" style="height: 250px;">
                    <canvas id="pbUChart"></canvas>
                </div>
                <div id="pbURating" class="text-center py-2 rounded-lg font-semibold bg-gray-100 text-gray-600">
                    <span id="pbUStatus">Menunggu data...</span>
                </div>
                <p class="text-xs text-gray-600 text-center mt-2">
                    Z-Score: <span id="pbUZ" class="font-semibold">-</span>
                </p>
            </div>
        </div>

        <!-- BB/PB Card -->
        <div class="bg-gradient-to-br from-green-50 to-white rounded-xl shadow-md border-2 border-green-200 overflow-hidden">
            <div class="bg-gradient-to-r from-green-500 to-green-600 p-4 text-white">
                <div class="flex items-center gap-3">
                    <div class="bg-white/20 rounded-full p-3">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 00-2-2m0 0h2a2 2 0 012-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" />
                        </svg>
                    </div>
                    <div>
                        <h3 class="text-xl font-bold">Indikator BB/PB</h3>
                        <p class="text-sm text-green-100">Berat Badan Sesuai Panjang Badan</p>
                    </div>
                </div>
            </div>
            <div class="p-4">
                <div class="mb-4" style="height: 250px;">
                    <canvas id="bbPbChart"></canvas>
                </div>
                <div id="bbPbRating" class="text-center py-2 rounded-lg font-semibold bg-gray-100 text-gray-600">
                    <span id="bbPbStatus">Menunggu data...</span>
                </div>
                <p class="text-xs text-gray-600 text-center mt-2">
                    Z-Score: <span id="bbPbZ" class="font-semibold">-</span>
                </p>
            </div>
        </div>
    </div>

    <!-- Interpretation & Recommendations -->
    <div class="bg-white rounded-xl shadow-lg p-6 border border-gray-200" wire:ignore>
        <div class="flex items-center gap-3 mb-6">
            <div class="bg-gradient-to-br from-purple-500 to-purple-600 rounded-full p-3">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                </svg>
            </div>
            <div>
                <h3 class="text-xl font-bold text-gray-800">Hasil Perhitungan & Rekomendasi</h3>
                <p class="text-sm text-gray-600">Parameter Pertumbuhan Anak</p>
            </div>
        </div>

        <!-- Summary Results -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-6">
            <div class="bg-blue-50 border-l-4 border-blue-500 p-4 rounded-r-lg">
                <div class="flex items-center gap-2">
                    <svg class="h-5 w-5 text-blue-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 6l3 1m0 0l-3 9a5.002 5.002 0 006.001 0M6 7l3 9M6 7l6-2m6 2l3-1m-3 1l-3 9a5.002 5.002 0 006.001 0M18 7l3 9m-3-9l-6-2m0-2v2m0 16V5m0 16H9m3 0h3" />
                    </svg>
                    <span class="text-sm font-medium text-blue-900">BB/U</span>
                </div>
                <p id="bbUSummary" class="text-sm text-blue-700 mt-1">Z-Score: -</p>
            </div>

            <div class="bg-orange-50 border-l-4 border-orange-500 p-4 rounded-r-lg">
                <div class="flex items-center gap-2">
                    <svg class="h-5 w-5 text-orange-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 12l3-3 3 3 4-4M8 21l4-4 4 4M3 4h18M4 4h16v12a1 1 0 01-1 1H5a1 1 0 01-1-1V4z" />
                    </svg>
                    <span class="text-sm font-medium text-orange-900">PB/U</span>
                </div>
                <p id="pbUSummary" class="text-sm text-orange-700 mt-1">Z-Score: -</p>
            </div>

            <div class="bg-green-50 border-l-4 border-green-500 p-4 rounded-r-lg">
                <div class="flex items-center gap-2">
                    <svg class="h-5 w-5 text-green-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 00-2-2m0 0h2a2 2 0 012-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" />
                    </svg>
                    <span class="text-sm font-medium text-green-900">BB/PB</span>
                </div>
                <p id="bbPbSummary" class="text-sm text-green-700 mt-1">Z-Score: -</p>
            </div>
        </div>

        <!-- Recommendations -->
        <div class="bg-gradient-to-r from-purple-50 to-indigo-50 rounded-lg p-5 border border-purple-200">
            <h4 class="font-semibold text-purple-900 mb-3 flex items-center gap-2">
                <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
                Informasi Penting
            </h4>
            <div id="recommendations" class="space-y-2 text-sm text-purple-800">
                <p>Masukkan data berat dan tinggi badan untuk melihat rekomendasi.</p>
            </div>
        </div>

        <!-- Legend -->
        <div class="mt-6 border-t pt-4">
            <p class="text-sm font-semibold text-gray-700 mb-2">Keterangan Status:</p>
            <div class="grid grid-cols-2 md:grid-cols-3 gap-2 text-xs">
                <div class="flex items-center gap-2">
                    <span class="w-3 h-3 rounded-full bg-green-500"></span>
                    <span class="text-gray-700">● Normal</span>
                </div>
                <div class="flex items-center gap-2">
                    <span class="w-3 h-3 rounded-full bg-red-500"></span>
                    <span class="text-gray-700">● Kurang</span>
                </div>
                <div class="flex items-center gap-2">
                    <span class="w-3 h-3 rounded-full bg-orange-500"></span>
                    <span class="text-gray-700">● Berlebih</span>
                </div>
            </div>
        </div>
    </div>

    <!-- Manual Refresh Button -->
    <div class="flex justify-center">
        <button onclick="window.refreshGrowthCharts()"
                class="px-6 py-3 bg-gradient-to-r from-indigo-600 to-purple-600 text-white rounded-lg shadow-lg hover:shadow-xl transform hover:scale-105 transition-all duration-200 flex items-center gap-2">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" />
            </svg>
            Hitung Ulang Growth Chart
        </button>
    </div>
</div>

{{-- JavaScript for this component is in parent file's @push('scripts') section --}}
