<div id="invoice">
    <div class="logo-section">
        <div class="store-name">{{ Auth::user()->company->name }}</div>
        <div class="store-info">
            <div class="store-info-line">{{ Auth::user()->company->companyDetail->address }}</div>
            <div class="store-info-line">{{ Auth::user()->company->companyDetail->city }}</div>
            <div class="store-info-line">{{ Auth::user()->company->companyDetail->province }}</div>
            <div class="store-info-line">Telp: {{ Auth::user()->company->phone }}</div>
        </div>
    </div>
    <!-- Info Section -->
    <div class="info-section">
        <div class="info-row">
            <span class="label">No. Invoice</span>
            <span class="value">{{ $transaction->code }}</span>
        </div>
        <div class="info-row">
            <span class="label">Tanggal</span>
            <span class="value">{{ $transaction->created_at->format('d/m/Y') }}</span>
        </div>
        <div class="info-row">
            <span class="label">Waktu</span>
            <span class="value">{{ $transaction->created_at->format('H:i:s') }}</span>
        </div>
        <div class="info-row">
            <span class="label">Kasir</span>
            <span class="value">{{ $transaction->cashier_name ?? '-' }}</span>
        </div>
        <div class="info-row">
            <span class="label">Pelanggan</span>
            <span class="value">{{ $transaction->patient->name ?? ($transaction->patient_name ?? 'Umum') }}</span>
        </div>
        @if (isset($transaction->doctor_name))
            <div class="info-row">
                <span class="label">Dokter</span>
                <span class="value">{{ $transaction->doctor_name }}</span>
            </div>
        @endif
    </div>

    <!-- Transaction Details -->
    <div class="transaction-section">
        <div class="section-title">DETAIL TRANSAKSI</div>
        <div class="transaction-list">
            <div class="transaction-item">
                <span class="item-name">Jasa Dokter</span>
                <span class="item-total">{{ number_format($transactionService, 0, ',', '.') }}</span>
            </div>
            <div class="transaction-item">
                <span class="item-name">Obat Obatan</span>
                <span
                    class="item-total">{{ number_format($transactionDetailNonService + $transactionRecipes, 0, ',', '.') }}</span>
            </div>
        </div>
    </div>

    <!-- Summary Section -->
    <div class="summary-section">
        <div class="summary-row">
            <span class="label">Total</span>
            <span class="value">{{ number_format($transaction->sub_total_price_before_rounding, 0, ',', '.') }}</span>
        </div>
        <div class="summary-row">
            <span class="label">Pembulatan</span>
            <span class="value">{{ number_format($transaction->rounding, 0, ',', '.') }}</span>
        </div>
        <div class="summary-row">
            <span class="label">Diskon</span>
            <span
                class="value">{{ number_format($transaction->promotion_real + $transaction->discount_value, 0, ',', '.') }}</span>
        </div>
        <div class="summary-row total">
            <span class="label">Grand Total</span>
            <span class="value">{{ number_format($transaction->grand_total_price_admin_fee, 0, ',', '.') }}</span>
        </div>
        <div class="summary-row">
            <span class="label">Bayar</span>
            <span class="value">{{ number_format($transaction->payment_amount, 0, ',', '.') }}</span>
        </div>
        <div class="summary-row">
            <span class="label">Kembalian</span>
            <span class="value">{{ number_format($transaction->payment_change, 0, ',', '.') }}</span>
        </div>
    </div>
    <div class="footer">
        <div class="footer-line">Terima kasih atas kunjungan Anda!</div>
        <div class="footer-line">Obat yang dibeli tidak dapat dikembalikan</div>
        <div class="footer-line">Gunakan sesuai petunjuk Apoteker</div>
        <div class="footer-line">Simpan di tempat sejuk & kering</div>
    </div>
</div>
