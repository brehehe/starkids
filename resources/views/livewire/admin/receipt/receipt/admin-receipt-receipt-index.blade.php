<div>
    @php
        Config::set('terbilang.locale', 'id');
    @endphp
    <div class="kwitansi-container">
        <img src="{{ Auth::user()->company->logo ? asset('storage/' . Auth::user()->company->logo) : asset('asset/img/logo.png') }}"
            class="watermark">
        <div class="content">
            <!-- Header -->
            <div class="header">
                <div class="logo-section">
                    <div class="logo-placeholder">
                        <img src="{{ Auth::user()->company->logo ? asset('storage/' . Auth::user()->company->logo) : asset('asset/img/logo.png') }}"
                            style="width: 60mm; height: 20mm;">
                    </div>
                </div>

                <div class="title-section">
                    <div class="kwitansi-title">KWITANSI PEMBAYARAN</div>
                    <div class="company-subtitle">
                        {{config('app.name')}}
                    </div>
                    <div class="company-subtitle">
                        {{ Auth::user()->company->companyDetail->address ?? '-' }}
                    </div>
                    <div class="company-subtitle">
                        No Telepon: {{ Auth::user()->company->phone ?? '-' }}
                    </div>
                </div>

                <div class="invoice-info">
                    <div class="invoice-number">No. {{ $transaction->code }}</div>
                    <div>Tanggal pembayaran</div>
                    <div>{{ $transaction->created_at->format('d/m/Y') }}</div>
                </div>
            </div>

            <!-- Divider -->
            <div class="divider"></div>

            <!-- Main content -->
            <div class="main-content">
                <div class="receipt-info">
                    <div class="info-row">
                        <div class="info-label">Telah Diterima Dari</div>
                        <div class="info-colon">:</div>
                        <div class="info-value">
                            <strong>{{ $transaction->patient->name ?? ($transaction->patient_name ?? null) }}</strong>
                        </div>
                    </div>

                    <div class="info-row">
                        <div class="info-label">Sejumlah Uang</div>
                        <div class="info-colon">:</div>
                        <div class="info-value">
                            {{ Str::title(Terbilang::make($transaction->grand_total_price)) }}
                        </div>
                    </div>

                    <div class="info-row">
                        <div class="info-label">Untuk Pembayaran</div>
                        <div class="info-colon">:</div>
                        <div class="info-value">{{ $description }}</div>
                    </div>

                    <div class="info-row">
                        <div class="info-label">Diagnosa</div>
                        <div class="info-colon">:</div>
                        <div class="info-value">
                            {{ $transactionDiagnosas?->assessment ?? ($transaction->diagnosis ?? '-') }}
                        </div>
                    </div>

                    <div class="info-row">
                        <div class="info-label">Imunisasi</div>
                        <div class="info-colon">:</div>
                        <div class="info-value">{{ $transaction->immunization ?? '-' }}</div>
                    </div>
                </div>

            </div>

            <!-- Bottom section -->
            <div class="bottom-section">
                <div class="amount-section">
                    <div class="amount-label">Nominal</div>
                    <div class="info-colon">:</div>
                    <div class="amount-value">Rp.
                        {{ number_format($transaction->grand_total_price, 0, ',', '.') }}
                    </div>
                </div>

                <div class="signature-section">
                    <div class="signature-location">Surabaya,
                        {{ \Carbon\Carbon::now()->locale('id')->translatedFormat('d F Y') }}
                    </div>
                    <div class="signature-line"></div>
                    <div class="signature-company">{{config('app.name')}}</div>
                </div>
            </div>
        </div>
    </div>
</div>