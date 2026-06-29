<div>
    <div class="mb-4">
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-2xl font-bold text-[#1E3A8A]">Laporan Tindakan</h1>
            </div>
        </div>
    </div>

    {{-- Filters --}}
    <div class="bg-white/80 backdrop-blur-sm rounded-xl shadow-lg border border-gray-100 p-4 mb-4">
        <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Perawat</label>
                <select wire:model.live="nurse_id" class="form-control">
                    <option value="">Semua Perawat</option>
                    @foreach($nurses as $nurse)
                        <option value="{{ $nurse->id }}">{{ $nurse->name }}</option>
                    @endforeach
                </select>
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Dokter</label>
                <select wire:model.live="doctor_id" class="form-control">
                    <option value="">Semua Dokter</option>
                    @foreach($doctors as $doctor)
                        <option value="{{ $doctor->id }}">{{ $doctor->name }}</option>
                    @endforeach
                </select>
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Tindakan / Produk</label>
                <select wire:model.live="product_id" class="form-control">
                    <option value="">Semua Tindakan</option>
                    @foreach($products as $product)
                        <option value="{{ $product->id }}">{{ $product->name }}</option>
                    @endforeach
                </select>
            </div>
             <div class="flex items-end md:col-start-4">
                {{-- Placeholder if needed, or move reset button here if added --}}
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

    <!-- Charts Section -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-6">
        <!-- Chart Tindakan Terbanyak -->
        <div class="bg-white/80 backdrop-blur-sm rounded-xl shadow-lg border border-gray-100 p-6">
            <h3 class="text-lg font-bold text-[#1E3A8A] mb-4">Top 10 Tindakan Terbanyak</h3>
            <div style="height: 300px;">
                <canvas id="qtyChart" wire:ignore></canvas>
            </div>
        </div>

        <!-- Chart Biaya Terbanyak -->
        <div class="bg-white/80 backdrop-blur-sm rounded-xl shadow-lg border border-gray-100 p-6">
            <h3 class="text-lg font-bold text-[#1E3A8A] mb-4">Top 10 Biaya Terbanyak</h3>
            <div style="height: 300px;">
                <canvas id="revChart" wire:ignore></canvas>
            </div>
        </div>
    </div>

    <div class="bg-white/80 backdrop-blur-sm rounded-xl shadow-lg border border-gray-100 overflow-hidden mb-6">
        <div class="table-container">
            <table class="table">
                <thead>
                    <tr>
                        <th class="w-1 center">No</th>
                        <th>Tanggal</th>
                        <th>Kode Transaksi</th>
                        <th>Tindakan / Produk</th>
                        <th>Perawat</th>
                        <th>Dokter</th>
                        <th>Harga</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($details as $index => $detail)
                        <tr>
                            <td class="center">{{ $details->firstItem() + $index }}</td>
                            <td>{{ $detail->transaction ? \Carbon\Carbon::parse($detail->transaction->created_at)->locale('id')->isoFormat('D MMMM Y HH:mm') : '-' }}</td>
                            <td>{{ $detail->transaction->code ?? '-' }}</td>
                            <td>{{ $detail->product->name ?? $detail->name }}</td>
                            <td>{{ $detail->nurse->name ?? '-' }}</td>
                            <td>{{ $detail->doctor->name ?? '-' }}</td>
                            <td>{{ number_format($detail->sub_total_price, 0, ',', '.') }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="no-data">Tidak ada data</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        <div class="px-5 py-4 bg-gray-50/80 border-t border-gray-200">
             {{ $details->links('vendor.livewire.custom') }}
        </div>
    </div>
</div>

@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        document.addEventListener('livewire:initialized', () => {
            const qtyCtx = document.getElementById('qtyChart').getContext('2d');
            const revCtx = document.getElementById('revChart').getContext('2d');

            let qtyChart = new Chart(qtyCtx, {
                type: 'bar',
                data: {
                    labels: {!! json_encode($chartQtyLabels) !!},
                    datasets: [{
                        label: 'Total Kuantitas',
                        data: {!! json_encode($chartQtyData) !!},
                        backgroundColor: 'rgba(59, 130, 246, 0.8)',
                        borderColor: 'rgb(59, 130, 246)',
                        borderWidth: 1
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: { legend: { display: false } },
                    scales: { y: { beginAtZero: true } }
                }
            });

            let revChart = new Chart(revCtx, {
                type: 'bar',
                data: {
                    labels: {!! json_encode($chartRevLabels) !!},
                    datasets: [{
                        label: 'Total Biaya',
                        data: {!! json_encode($chartRevData) !!},
                        backgroundColor: 'rgba(16, 185, 129, 0.8)',
                        borderColor: 'rgb(16, 185, 129)',
                        borderWidth: 1
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: { legend: { display: false } },
                    scales: {
                        y: {
                            beginAtZero: true,
                            ticks: {
                                callback: function(value) {
                                    return 'Rp ' + value.toLocaleString('id-ID');
                                }
                            }
                        }
                    }
                }
            });

            Livewire.on('update-charts', (data) => {
                let chartsData = data[0];
                qtyChart.data.labels = chartsData.qtyLabels;
                qtyChart.data.datasets[0].data = chartsData.qtyData;
                qtyChart.update();

                revChart.data.labels = chartsData.revLabels;
                revChart.data.datasets[0].data = chartsData.revData;
                revChart.update();
            });
        });
    </script>
@endpush
