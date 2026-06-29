<div id="invoice">
    <div class="logo-section">
        <div class="store-name">{{ Auth::user()->company->name }}</div>
        <div class="store-info">
            {{ Auth::user()->company->companyDetail->address }}<br>
            {{ Auth::user()->company->companyDetail->city }},
            {{ Auth::user()->company->companyDetail->province }}<br>
            Telp: {{ Auth::user()->company->phone }}
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
            @foreach ($transaction->transactionDetails->whereNull('transaction_detail_id')->whereIn('type_transaction', ['medicine', 'action', 'other']) as $item)
                <div class="transaction-item">
                    <span class="item-name">{{ $item->product->name ?? $item->name }} x{{ $item->quantity }}</span>
                    <span class="item-total">{{ number_format($item->sub_total_price, 0, ',', '.') }}</span>
                </div>

                @php
                    $transactionDetails = App\Models\Transaction\TransactionDetail::where(
                        'transaction_id',
                        $transaction->id,
                    )
                        ->where('transaction_detail_id', $item->id)
                        ->get();
                @endphp

                @foreach ($transactionDetails as $detail)
                    <div class="transaction-item sub-item">
                        <span class="item-name">- {{ $detail->product->name ?? $detail->name }}
                            x{{ $detail->quantity }}</span>
                        <span class="item-total">{{ number_format($detail->sub_total_price, 0, ',', '.') }}</span>
                    </div>
                @endforeach
            @endforeach

            @foreach ($transaction->transactionRecipes as $key_recipe => $recipe)
                <div class="transaction-item">
                    <span class="item-name">/R{{ $key_recipe + 1 }}</span>
                    <span class="item-total">
                        {{ number_format(
                            $recipe->price_service_one +
                                $recipe->price_service_other +
                                $recipe->sub_total_price +
                                $recipe->transactionDetail->sum('sub_total_price'),
                            0,
                            ',',
                            '.',
                        ) }}
                    </span>
                </div>
            @endforeach
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
            <span class="label">TOTAL</span>
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
        Terima kasih atas kunjungan Anda!<br>
        Obat yang dibeli tidak dapat dikembalikan<br>
        Gunakan sesuai petunjuk Apoteker<br>
        Simpan di tempat sejuk & kering<br>
    </div>
</div>
