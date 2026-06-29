<div>
    <div class="mb-4">
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-2xl font-bold text-[#1E3A8A]">Laporan Odontogram</h1>
            </div>
        </div>
    </div>

    <!-- Filter Section -->
    <div class="p-6 bg-white shadow rounded-lg mb-4">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div>
                <label class="block text-sm font-medium text-gray-700">Pilih Pasien</label>
                <select wire:model.live="patient_id" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm p-2 border">
                    <option value="">-- Pilih Pasien --</option>
                    @foreach ($patients as $patient)
                        <option value="{{ $patient->id }}">{{ $patient->name }} - {{ $patient->phone }}</option>
                    @endforeach
                </select>
            </div>
        </div>
    </div>

    @if ($patient_id)
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">
            <!-- Summary Stats -->
            <div class="bg-white/80 backdrop-blur-sm rounded-xl shadow-lg border border-gray-100 p-6">
                <h3 class="text-lg font-bold text-gray-800 mb-4">Statistik Odontogram</h3>
                @if ($frequent_odontogram && $frequent_odontogram->count() > 0)
                    <div class="space-y-3">
                        @foreach ($frequent_odontogram as $stat)
                            <div
                                class="flex items-center justify-between p-3 bg-blue-50/50 rounded-lg border border-blue-100 hover:bg-blue-50 transition-colors">
                                <div>
                                    <p class="text-xs text-gray-500 mb-1">Kondisi</p>
                                    <span
                                        class="badge badge-lg badge-primary font-bold">{{ $stat->odontogram_code }}</span>
                                </div>
                                <div class="text-right">
                                    <p class="text-xs text-gray-500 mb-1">Total</p>
                                    <span class="text-xl font-bold text-blue-700">{{ $stat->total }}x</span>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <p class="text-gray-500 italic text-center py-4">Belum ada data odontogram.</p>
                @endif
            </div>

            <!-- Odontogram Visual -->
            <div
                class="bg-white/80 backdrop-blur-sm rounded-xl shadow-lg border border-gray-100 p-6 md:col-span-2 overflow-x-auto">
                <h3 class="text-lg font-bold text-gray-800 mb-4">Visualisasi Gigi (Terakhir)</h3>
                <div id="odontogram" class="overflow-x-auto">
                    <div id="svgselect" class="min-w-[800px]">
                        <svg version="1.1" height="250px" width="100%">
                            <g transform="scale(1.5)" id="gmain">
                                {{-- Copied exact structure from reference --}}
                                @foreach (['18', '17', '16', '15', '14', '13', '12', '11', '21', '22', '23', '24', '25', '26', '27', '28'] as $i => $tooth)
                                    <g id="P{{ $tooth }}" transform="translate({{ $i * 25 }},0)">
                                        @foreach (['C', 'T', 'B', 'R', 'L'] as $part)
                                            @php
                                                $points = match ($part) {
                                                    'C' => '5,5 15,5 15,15 5,15',
                                                    'T' => '0,0 20,0 15,5 5,5',
                                                    'B' => '5,15 15,15 20,20 0,20',
                                                    'R' => '15,5 20,0 20,20 15,15',
                                                    'L' => '0,0 5,5 5,15 0,20',
                                                };
                                            @endphp
                                            <polygon points="{{ $points }}"
                                                fill="{{ $odontogram_map[$tooth . $part] ?? 'white' }}" stroke="black"
                                                stroke-width="0.5" id="{{ $part }}"></polygon>
                                        @endforeach
                                        <text x="6" y="30" stroke="black" fill="black" stroke-width="0.1"
                                            style="font-size: 6pt;font-weight:normal">{{ $tooth }}</text>
                                    </g>
                                @endforeach

                                {{-- Milk Teeth Upper --}}
                                @foreach (['55', '54', '53', '52', '51', '61', '62', '63', '64', '65'] as $i => $tooth)
                                    <g id="P{{ $tooth }}"
                                        transform="translate({{ ($i + 3) * 25 }},40)">
                                        @foreach (['C', 'T', 'B', 'R', 'L'] as $part)
                                            @php
                                                $points = match ($part) {
                                                    'C' => '5,5 15,5 15,15 5,15',
                                                    'T' => '0,0 20,0 15,5 5,5',
                                                    'B' => '5,15 15,15 20,20 0,20',
                                                    'R' => '15,5 20,0 20,20 15,15',
                                                    'L' => '0,0 5,5 5,15 0,20',
                                                };
                                            @endphp
                                            <polygon points="{{ $points }}"
                                                fill="{{ $odontogram_map[$tooth . $part] ?? 'white' }}" stroke="black"
                                                stroke-width="0.5" id="{{ $part }}"></polygon>
                                        @endforeach
                                        <text x="6" y="30" stroke="black" fill="black" stroke-width="0.1"
                                            style="font-size: 6pt;font-weight:normal">{{ $tooth }}</text>
                                    </g>
                                @endforeach

                                {{-- Milk Teeth Lower --}}
                                @foreach (['85', '84', '83', '82', '81', '71', '72', '73', '74', '75'] as $i => $tooth)
                                    <g id="P{{ $tooth }}"
                                        transform="translate({{ ($i + 3) * 25 }},80)">
                                        @foreach (['C', 'T', 'B', 'R', 'L'] as $part)
                                            @php
                                                $points = match ($part) {
                                                    'C' => '5,5 15,5 15,15 5,15',
                                                    'T' => '0,0 20,0 15,5 5,5',
                                                    'B' => '5,15 15,15 20,20 0,20',
                                                    'R' => '15,5 20,0 20,20 15,15',
                                                    'L' => '0,0 5,5 5,15 0,20',
                                                };
                                            @endphp
                                            <polygon points="{{ $points }}"
                                                fill="{{ $odontogram_map[$tooth . $part] ?? 'white' }}" stroke="black"
                                                stroke-width="0.5" id="{{ $part }}"></polygon>
                                        @endforeach
                                        <text x="6" y="30" stroke="black" fill="black" stroke-width="0.1"
                                            style="font-size: 6pt;font-weight:normal">{{ $tooth }}</text>
                                    </g>
                                @endforeach

                                {{-- Lower Jaw --}}
                                @foreach (['48', '47', '46', '45', '44', '43', '42', '41', '31', '32', '33', '34', '35', '36', '37', '38'] as $i => $tooth)
                                    <g id="P{{ $tooth }}" transform="translate({{ $i * 25 }},120)">
                                        @foreach (['C', 'T', 'B', 'R', 'L'] as $part)
                                            @php
                                                $points = match ($part) {
                                                    'C' => '5,5 15,5 15,15 5,15',
                                                    'T' => '0,0 20,0 15,5 5,5',
                                                    'B' => '5,15 15,15 20,20 0,20',
                                                    'R' => '15,5 20,0 20,20 15,15',
                                                    'L' => '0,0 5,5 5,15 0,20',
                                                };
                                            @endphp
                                            <polygon points="{{ $points }}"
                                                fill="{{ $odontogram_map[$tooth . $part] ?? 'white' }}" stroke="black"
                                                stroke-width="0.5" id="{{ $part }}"></polygon>
                                        @endforeach
                                        <text x="6" y="30" stroke="black" fill="black" stroke-width="0.1"
                                            style="font-size: 6pt;font-weight:normal">{{ $tooth }}</text>
                                    </g>
                                @endforeach
                            </g>
                        </svg>
                    </div>
                </div>
            </div>
        </div>

        <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center mb-4 gap-4">
            <div class="flex items-center">
                <span class="text-sm text-gray-700 mr-2">Tampil</span>
                <select class="mt-1 form-control" wire:model.live='perPage'>
                    <option value="5">5</option>
                    <option value="10">10</option>
                    <option value="25">25</option>
                    <option value="50">50</option>
                    <option value="100">100</option>
                </select>
                <span class="text-sm text-gray-700 ml-2">data</span>
            </div>
        </div>

        <div class="bg-white/80 backdrop-blur-sm rounded-xl shadow-lg border border-gray-100 overflow-hidden mb-6">
            <div class="table-container">
                <table class="table">
                    <thead>
                        <tr>
                            <th class="w-1 center">No</th>
                            <th>Tanggal</th>
                            <th>Dokter</th>
                            <th>Kode Gigi</th>
                            <th>Kondisi/Tindakan</th>
                            <th>Keterangan</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($historyOdontograms as $index => $odontogram)
                            <tr>
                                <td class="center">
                                    {{ $historyOdontograms->firstItem() + $index }}
                                </td>
                                <td>{{ $odontogram->created_at ? \Carbon\Carbon::parse($odontogram->created_at)->locale('id')->isoFormat('DD MMMM YYYY HH:mm') : '-' }}
                                </td>
                                <td>{{ $odontogram->transaction->doctor->name ?? '-' }}</td>
                                <td>
                                    <span class="px-2 py-1 rounded text-white text-xs font-bold"
                                        style="background-color: {{ $odontogram->odontogram_color ?? '#000' }}">
                                        {{ $odontogram->odontogram_code }}
                                    </span>
                                </td>
                                <td>{{ $odontogram->product->name ?? ($odontogram->name ?? '-') }}</td>
                                <td>{{ $odontogram->description ?? '-' }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="no-data">Tidak ada data</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            <div class="px-5 py-4 bg-gray-50/80 border-t border-gray-200">
                <div class="flex items-center justify-between">
                    <div class="text-sm text-gray-700">
                        Menampilkan <span class="font-medium">{{ $historyOdontograms->firstItem() }}</span> sampai
                        <span class="font-medium">{{ $historyOdontograms->lastItem() }}</span> dari <span
                            class="font-medium">{{ $historyOdontograms->total() }}</span> hasil
                    </div>
                    <div>
                        <nav class="relative z-0 inline-flex rounded-md shadow-sm -space-x-px" aria-label="Pagination">
                            {{ $historyOdontograms->links('vendor.livewire.custom') }}
                        </nav>
                    </div>
                </div>
            </div>
        </div>
    @else
        <div class="p-6 bg-white shadow rounded-lg mb-4 text-center">
            <p class="text-gray-500">Silakan pilih pasien untuk melihat laporan odontogram.</p>
        </div>
    @endif
</div>
