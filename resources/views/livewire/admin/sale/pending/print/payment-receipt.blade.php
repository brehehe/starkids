@php
    Config::set('terbilang.locale', 'id');
    $company = $payment->transaction?->company ?? Auth::user()?->company;
@endphp
<div class="kwitansi-container">
    <div class="content">
        <div class="header">
            <div class="logo-section">
                @if($company?->logo)
                    <img src="{{ asset('storage/' . $company->logo) }}" alt="Logo" style="height: 60px;">
                @else
                    <div class="logo-placeholder" style="font-size: 20px; font-weight: bold;">{{ $company?->name ?? config('app.name') }}</div>
                @endif
                <div class="company-subtitle">{{ $company?->companyDetail?->address ?? ($company?->address ?? '-') }}</div>
            </div>
            <div class="title-section">
                <div class="kwitansi-title">Kwitansi Pembayaran</div>
                <div class="subtitle">Bukti Pembayaran Cicilan / Pelunasan</div>
            </div>
            <div class="invoice-info">
                <div class="invoice-number">No. Kwitansi: <strong>#{{ strtoupper(substr($payment->id, 0, 8)) }}</strong></div>
                <div>Tanggal: {{ $payment->created_at->format('d/m/Y') }}</div>
                <div>No. Transaksi: {{ $payment->transaction->code }}</div>
            </div>
        </div>

        <div class="divider"></div>

        <div class="main-content">
            <div class="receipt-info">
                <div class="info-row">
                    <div class="info-label">Telah terima dari</div>
                    <div class="info-colon">:</div>
                    <div class="info-value font-bold">{{ $payment->transaction->patient_name ?? '-' }}</div>
                </div>
                <div class="info-row">
                    <div class="info-label">Uang sejumlah</div>
                    <div class="info-colon">:</div>
                    <div class="info-value italic">
                        # {{ ucwords(Terbilang::make($payment->payment_amount)) }} Rupiah #
                    </div>
                </div>
                <div class="info-row">
                    <div class="info-label">Untuk pembayaran</div>
                    <div class="info-colon">:</div>
                    <div class="info-value">
                        {{ $payment->description ?: 'Pembayaran Transaksi ' . $payment->transaction->code }}
                        @if($payment->is_down_payment) (Down Payment) @endif
                    </div>
                </div>
            </div>
        </div>

        <div class="bottom-section" style="margin-top: 20px;">
            <div class="amount-section">
                <div class="amount-label">TOTAL :</div>
                <div class="amount-value">Rp @number($payment->payment_amount)</div>
            </div>
            <div class="signature-section">
                <div class="signature-location">{{ $company?->companyDetail?->city ?? ($company?->city ?? 'Indonesia') }}, {{ date('d F Y') }}</div>
                <div class="signature-company">{{ $company?->name ?? config('app.name') }}</div>
                <div class="signature-line"></div>
                <div class="signature-name">Kasir: {{ Auth::user()->name }}</div>
            </div>
        </div>
    </div>

    <script>
        window.print();
    </script>
</div>
