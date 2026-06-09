<div class="p-4 pt-16">
    <div class="mb-4 flex items-center justify-between">
        <div class="flex items-center gap-4">
            <a href="{{ route('user.sale.pending') }}" class="btn btn-icon bg-white shadow-sm">
                <i class="fas fa-arrow-left"></i>
            </a>
            <h1 class="text-2xl font-bold text-[#1E3A8A]">Detail Pembayaran: {{ $transaction->code }}</h1>
        </div>
        <div class="flex gap-2">
            <a target="_blank" href="{{ route('user.sale.pending.print.transaction-a4', ['transaction_id' => $transaction->id]) }}" 
               class="btn bg-white border-blue-600 text-blue-600 hover:bg-blue-50">
                <i class="fas fa-file-pdf mr-2"></i> Cetak A4
            </a>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Kolom Kiri: Ringkasan & Histori -->
        <div class="lg:col-span-2 space-y-6">
            <!-- Informasi Pasien & Transaksi -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
                <div class="p-4 bg-gray-50 border-b border-gray-200">
                    <h2 class="font-semibold text-gray-800">Ringkasan Transaksi</h2>
                </div>
                <div class="p-6 grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div class="space-y-3">
                        <div class="flex justify-between">
                            <span class="text-gray-500">Pasien:</span>
                            <span class="font-medium text-gray-900">{{ $transaction->patient_name ?? '-' }}</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-gray-500">No. Member:</span>
                            <span class="font-medium text-gray-900">{{ $transaction->patient?->member_id ?? '-' }}</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-gray-500">Tanggal Transaksi:</span>
                            <span class="font-medium text-gray-900">{{ $transaction->created_at->format('d/m/Y H:i') }}</span>
                        </div>
                    </div>
                    <div class="space-y-3">
                        <div class="flex justify-between">
                            <span class="text-gray-500">Total Tagihan:</span>
                            <span class="font-bold text-gray-900">Rp @number($transaction->grand_total_price)</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-gray-500">Total Terbayar:</span>
                            <span class="font-bold text-green-600">Rp @number($transaction->payment_amount)</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-gray-500">Sisa Tagihan:</span>
                            <span class="font-bold text-red-600">Rp @number($transaction->remaining_bill)</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Rencana Cicilan -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
                <div class="p-4 bg-gray-50 border-b border-gray-200 flex justify-between items-center">
                    <h2 class="font-semibold text-gray-800">Rencana Cicilan ({{ $transaction->installment_count }}x {{ ucfirst($transaction->installment_period) }})</h2>
                    @if($transaction->installment_count)
                        @php
                            $paidCount = $transaction->transactionInstallments->where('status', 'paid')->count();
                            $remainingTenor = max(0, $transaction->installment_count - $paidCount);
                        @endphp
                        <span class="badge badge-primary">Sisa {{ $remainingTenor }} Tenor</span>
                    @endif
                </div>
                <div class="table-container">
                    <table class="table">
                        <thead>
                            <tr>
                                <th class="w-1 center">Tenor</th>
                                <th>Jatuh Tempo</th>
                                <th>Nominal</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($transaction->transactionInstallments->sortBy('tenor') as $installment)
                                <tr class="{{ $installment->status == 'paid' ? 'bg-green-50/30' : '' }}">
                                    <td class="center font-medium">{{ $installment->tenor }}</td>
                                    <td>{{ \Carbon\Carbon::parse($installment->due_date)->format('d/m/Y') }}</td>
                                    <td class="font-medium">Rp @number($installment->amount)</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="no-data">Tidak ada rincian cicilan di database</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Histori Pembayaran -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
                <div class="p-4 bg-gray-50 border-b border-gray-200">
                    <h2 class="font-semibold text-gray-800">Histori Pembayaran</h2>
                </div>
                <div class="table-container">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Tanggal</th>
                                <th>Metode</th>
                                <th class="text-right">Nominal</th>
                                <th>Catatan</th>
                                <th class="w-1 center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($transaction->transactionPayments as $payment)
                                <tr>
                                    <td>{{ $payment->created_at->format('d/m/Y H:i') }}</td>
                                    <td>
                                        <div class="font-medium">{{ $payment->paymentMethod?->name ?? 'N/A' }}</div>
                                        @if($payment->is_down_payment)
                                            <span class="text-[10px] bg-blue-100 text-blue-700 px-1 rounded">DP</span>
                                        @endif
                                    </td>
                                    <td class="text-right font-medium">Rp @number($payment->payment_amount)</td>
                                    <td class="text-gray-500 text-sm italic">{{ $payment->description ?? '-' }}</td>
                                    <td class="center">
                                        <a target="_blank" href="{{ route('user.sale.pending.print.payment', ['payment_id' => $payment->id]) }}" 
                                           class="btn btn-icon text-blue-600 hover:text-blue-800" title="Cetak Kwitansi">
                                            <i class="fas fa-print"></i>
                                        </a>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="no-data">Belum ada histori pembayaran</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <!-- Kolom Kanan: Form Pembayaran -->
        <div class="space-y-6">
            @if($transaction->status_payment != 'paid')
                <div class="bg-white rounded-xl shadow-lg border border-blue-100 overflow-hidden sticky top-20">
                    <div class="p-4 bg-blue-600 text-white">
                        <h2 class="font-semibold flex items-center gap-2">
                            <i class="fas fa-money-bill-wave"></i>
                            Konfirmasi Pembayaran
                        </h2>
                    </div>
                    <div class="p-6 space-y-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Metode Bayar <span class="text-red-500">*</span></label>
                            <select wire:model="payment_method_id" class="form-control w-full">
                                <option value="">-- Pilih Metode --</option>
                                @foreach($paymentMethods as $method)
                                    <option value="{{ $method->id }}">{{ $method->name }}</option>
                                @endforeach
                            </select>
                            @error('payment_method_id') <span class="text-xs text-red-500">{{ $message }}</span> @enderror
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Nominal Pembayaran <span class="text-red-500">*</span></label>
                            <div class="relative">
                                <input type="text" onkeyup="convertToRupiah(this)" wire:model.live="payment_amount" 
                                    class="form-control pl-10 w-full font-bold text-lg" placeholder="0">
                            </div>
                            @error('payment_amount') <span class="text-xs text-red-500">{{ $message }}</span> @enderror
                            <p class="text-[10px] text-orange-600 mt-1">*Nominal disarankan berdasarkan sisa cicilan</p>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Biaya Admin (Opsional)</label>
                            <div class="relative">
                                <input type="text" onkeyup="convertToRupiah(this)" wire:model.live="admin_fee" 
                                    class="form-control pl-10 w-full" placeholder="0">
                            </div>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Catatan</label>
                            <textarea wire:model="description" rows="3" class="form-control w-full text-sm" placeholder="Contoh: Pembayaran cicilan ke-2"></textarea>
                        </div>

                        <button wire:click="submitPayment" wire:loading.attr="disabled"
                            class="w-full bg-blue-600 hover:bg-blue-700 text-white font-bold py-3 px-4 rounded-xl shadow-md transition-all flex items-center justify-center gap-2">
                            <span wire:loading.remove wire:target="submitPayment">
                                <i class="fas fa-check-circle"></i> Simpan Pembayaran
                            </span>
                            <span wire:loading wire:target="submitPayment">
                                <i class="fas fa-spinner fa-spin"></i> Memproses...
                            </span>
                        </button>
                    </div>
                </div>
            @else
                <div class="bg-green-50 rounded-xl p-8 border border-green-200 text-center space-y-4">
                    <div class="w-16 h-16 bg-green-100 text-green-600 rounded-full flex items-center justify-center mx-auto text-2xl">
                        <i class="fas fa-check"></i>
                    </div>
                    <h2 class="text-xl font-bold text-green-800">Lunas</h2>
                    <p class="text-green-700">Transaksi ini telah dibayar penuh.</p>
                </div>
            @endif
        </div>
    </div>
</div>
