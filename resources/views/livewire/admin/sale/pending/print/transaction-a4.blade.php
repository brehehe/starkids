@php
    Config::set('terbilang.locale', 'id');
@endphp
<div class="content">
    <div class="header">
        <div class="logo">
            @if(Auth::user()->company->logo)
                <img src="{{ asset('storage/' . Auth::user()->company->logo) }}" alt="Logo" style="height: 50px;">
            @else
                {{ Auth::user()->company->name }}
            @endif
        </div>
        <div class="title">
            <h1>Ringkasan Transaksi</h1>
            <p>No. Transaksi: <strong>{{ $transaction->code }}</strong></p>
            <p>Tanggal: {{ $transaction->created_at->format('d/m/Y H:i') }}</p>
        </div>
    </div>

    <div class="info-grid">
        <div class="info-box">
            <h3>Informasi Pasien</h3>
            <p><strong>Nama:</strong> {{ $transaction->patient_name ?? '-' }}</p>
            <p><strong>No. Member:</strong> {{ $transaction->patient?->member_id ?? '-' }}</p>
            <p><strong>No. Telepon:</strong> {{ $transaction->patient?->phone ?? '-' }}</p>
            <p><strong>Alamat:</strong> {{ $transaction->patient?->address ?? '-' }}</p>
        </div>
        <div class="info-box">
            <h3>Status Pembayaran</h3>
            <p><strong>Metode:</strong> {{ $transaction->paymentMethod?->name ?? 'Mixed/Pending' }}</p>
            <p><strong>Status:</strong> 
                <span style="text-transform: uppercase; font-weight: bold; color: {{ $transaction->status_payment == 'paid' ? '#059669' : '#DC2626' }}">
                    {{ $transaction->status_payment }}
                </span>
            </p>
            <p><strong>Tenor:</strong> {{ $transaction->installment_count ? $transaction->installment_count . 'x (' . $transaction->installment_period . ')' : '-' }}</p>
        </div>
    </div>

    <h3>Rincian Item</h3>
    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Item / Layanan</th>
                <th class="text-right">Harga Satuan</th>
                <th class="text-right">Qty</th>
                <th class="text-right">Subtotal</th>
            </tr>
        </thead>
        <tbody>
            @php $no = 1; @endphp
            @foreach($transaction->transactionDetails as $detail)
                <tr>
                    <td>{{ $no++ }}</td>
                    <td>{{ $detail->name ?? $detail->product?->name ?? 'Item Unknown' }}</td>
                    <td class="text-right">Rp @number($detail->price)</td>
                    <td class="text-right">{{ $detail->quantity }}</td>
                    <td class="text-right">Rp @number($detail->total_price)</td>
                </tr>
            @endforeach
            @foreach($transaction->transactionRecipes as $recipe)
                <tr>
                    <td>{{ $no++ }}</td>
                    <td>Resep: {{ $recipe->product?->name ?? 'Obat' }}</td>
                    <td class="text-right">Rp @number($recipe->price)</td>
                    <td class="text-right">{{ $recipe->quantity }}</td>
                    <td class="text-right">Rp @number($recipe->total_price)</td>
                </tr>
            @endforeach
        </tbody>
        <tfoot>
            <tr>
                <td colspan="4" class="text-right font-bold">Total Tagihan</td>
                <td class="text-right font-bold">Rp @number($transaction->grand_total_price)</td>
            </tr>
            <tr>
                <td colspan="4" class="text-right font-bold text-green-600">Total Terbayar</td>
                <td class="text-right font-bold text-green-600">Rp @number($transaction->payment_amount)</td>
            </tr>
            <tr>
                <td colspan="4" class="text-right font-bold text-red-600">Sisa Tagihan</td>
                <td class="text-right font-bold text-red-600">Rp @number($transaction->remaining_bill)</td>
            </tr>
        </tfoot>
    </table>

    <div style="page-break-inside: avoid;">
        <h3>Rencana Cicilan</h3>
        <table>
            <thead>
                <tr>
                    <th class="w-1 text-center">Tenor</th>
                    <th>Jatuh Tempo</th>
                    <th class="text-right">Nominal</th>
                    <th class="text-center">Status</th>
                </tr>
            </thead>
            <tbody>
                @foreach($transaction->transactionInstallments as $installment)
                    <tr>
                        <td class="text-center">{{ $installment->tenor }}</td>
                        <td>{{ \Carbon\Carbon::parse($installment->due_date)->format('d/m/Y') }}</td>
                        <td class="text-right">Rp @number($installment->amount)</td>
                        <td class="text-center">{{ strtoupper($installment->status) }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <div style="page-break-inside: avoid;">
        <h3>Histori Pembayaran</h3>
        <table>
            <thead>
                <tr>
                    <th>Tanggal</th>
                    <th>Metode</th>
                    <th class="text-right">Nominal</th>
                    <th>Catatan</th>
                </tr>
            </thead>
            <tbody>
                @foreach($transaction->transactionPayments as $payment)
                    <tr>
                        <td>{{ $payment->created_at->format('d/m/Y H:i') }}</td>
                        <td>{{ $payment->paymentMethod?->name ?? '-' }} @if($payment->is_down_payment) (DP) @endif</td>
                        <td class="text-right">Rp @number($payment->payment_amount)</td>
                        <td>{{ $payment->description ?? '-' }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <div class="footer">
        <div>
            <p>Pasien / Keluarga</p>
            <div class="signature-box"></div>
            <p>({{ $transaction->patient_name ?? '................................' }})</p>
        </div>
        <div>
            <p>{{ Auth::user()->company->city ?? 'Indonesia' }}, {{ date('d/m/Y') }}</p>
            <p>Petugas Klinik</p>
            <div class="signature-box"></div>
            <p>({{ Auth::user()->name }})</p>
        </div>
    </div>

    <div class="no-print" style="margin-top: 30px; text-align: center;">
        <button onclick="window.print()" style="padding: 10px 20px; background: #1E3A8A; color: #fff; border: none; border-radius: 5px; cursor: pointer;">
            Cetak Dokumen
        </button>
    </div>
</div>

<script>
    window.print();
</script>
