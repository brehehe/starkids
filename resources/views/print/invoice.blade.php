<div id="invoice">
    <div class="logo-section">
        <div class="store-name">{{ Auth::user()->company->name }}</div>
        <div class="store-info">
            <div class="store-info-line">{{ Auth::user()->company->companyDetail->address }}</div>
            <div class="store-info-line">{{ Auth::user()->company->companyDetail->city }}</div>
            <div class="store-info-line">{{ Auth::user()->company->companyDetail->province }}</div>
            {{-- <div class="store-info-line">Telp: {{ Auth::user()->company->phone }}</div> --}}
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
                    <span class="item-name">{{ $item->product->name ?? $item->name }}</span>
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
                        <span class="item-name">- {{ $detail->product->name ?? $detail->name }}</span>
                        <span class="item-total">{{ number_format($detail->sub_total_price, 0, ',', '.') }}</span>
                    </div>
                @endforeach
            @endforeach

            @php
                $totalPriveService = App\Models\Transaction\TransactionRecipe::where('transaction_id', $transaction->id)
                    ->selectRaw('COALESCE(SUM(price_service_one + price_service_other + sub_total_price), 0) as total')
                    ->value('total');
                $transactionRecipes = App\Models\Transaction\TransactionRecipe::where(
                    'transaction_id',
                    $transaction->id,
                )->get();
            @endphp

            @foreach ($transaction->transactionRecipes as $key_recipe => $recipe)
                @if ($recipe->transactionDetail->count() > 1)
                    <div class="transaction-item">
                        <span class="item-name">/R{{ $key_recipe + 1 }}</span>
                    </div>
                    <div class="transaction-item">
                        <span class="item-name">
                            {{ $recipe?->notes && trim($recipe->notes) !== '' ? $recipe->notes : '.............................' }}
                        </span>
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
                @else
                    @foreach ($recipe->transactionDetail as $i => $detail)
                        <div class="transaction-item">
                            <span class="item-name">{{ $detail->product->name ?? $detail->name }}</span>
                            <span class="item-total">
                                {{ number_format(
                                    $recipe->price_service_one + $recipe->price_service_other + $recipe->sub_total_price + $detail->sub_total_price,
                                    0,
                                    ',',
                                    '.',
                                ) }}
                            </span>
                        </div>
                    @endforeach
                @endif
            @endforeach

            {{-- @foreach ($transactionRecipes as $index => $recipe)
                <div class="transaction-item font-bold">
                    <span class="item-name">Racikan {{ $index + 1 }}</span>
                </div>

                @foreach ($recipe->transactionDetail as $i => $detail)
                    <div class="transaction-item sub-item">
                        <span class="item-name">
                            {{ $detail->product->name ?? $detail->name }}
                        </span>

                        @if ($i == $recipe->transactionDetail->count() - 1)
                            <span class="item-total">
                                {{ number_format($recipe->transactionDetail->sum('sub_total_price'), 0, ',', '.') }}
                            </span>
                        @endif
                    </div>
                @endforeach
            @endforeach

            <div class="transaction-item">
                <span class="item-name">Biaya Jasa</span>
                <span class="item-total">{{ number_format($totalPriveService, 0, ',', '.') }}</span>
            </div> --}}
        </div>
    </div>

    <!-- Summary Section -->
    <div class="summary-section">
        {{-- <div class="summary-row">
            <span class="label">Total</span>
            <span class="value">{{ number_format($transaction->sub_total_price_before_rounding, 0, ',', '.') }}</span>
        </div> --}}
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
