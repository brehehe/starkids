<div>
    <div class="surat-container">
        <img src="{{ Auth::user()->company->logo ? asset('storage/' . Auth::user()->company->logo) : asset('asset/img/logo.png') }}"
            class="watermark">

        <div class="content">
            <!-- Header -->
            <div class="header">
                <div class="logo-section">
                    <div class="logo-placeholder">
                        <img src="{{ Auth::user()->company->logo ? asset('storage/' . Auth::user()->company->logo) : asset('asset/img/logo.png') }}"
                            style="width: 40mm; height: 15mm;">
                    </div>
                </div>

                <div class="title-section">
                    <div class="surat-title">SURAT PESANAN</div>
                    <div class="document-type">{{config('app.name')}}</div>
                </div>

                <div class="order-info">
                    <div class="order-number">No. {{ $purchase_order->number }}</div>
                    <div>Tanggal: 16/07/2025</div>
                </div>
            </div>

            <!-- Main Content -->
            <div class="main-content">
                <div class="order-details">
                    <div class="detail-row">
                        <div class="detail-label">Kepada</div>
                        <div class="detail-colon">:</div>
                        <div class="detail-value">
                            <div class="supplier-info">
                                <div class="supplier-name">{{ $purchase_order?->supplier?->name }}</div>
                                <div>{{ $purchase_order?->supplier?->address ?? '-' }}</div>
                            </div>
                        </div>
                    </div>

                    <div class="detail-row">
                        <div class="detail-label">Kirim Ke</div>
                        <div class="detail-colon">:</div>
                        <div class="detail-value">
                            <div class="delivery-address">
                                <div><strong>{{config('app.name')}}</strong></div>
                                <div>{{ Auth::user()->company->companyDetail->address }}</div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Items Table -->
                <table class="items-table">
                    <thead>
                        <tr>
                            <th class="no-col">No</th>
                            <th class="description-col">Nama Produk & Spesifikasi</th>
                            <th class="qty-col">Qty</th>
                            <th class="unit-col">Unit</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($purchase_order->purchaseRequisitionItems as $item)
                            <tr>
                                <td class="no-col">{{ $loop->iteration }}</td>
                                <td class="description-col">
                                    <div class="product-name">{{ $item->product->name }}</div>
                                    <div class="product-details">{{ $item->product->description }}</div>
                                </td>
                                <td class="qty-col">{{ $item->quantity }}</td>
                                <td class="qty-col">{{ $item?->productUnit?->unit?->name }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>

                <!-- Terms Section -->
                <div class="terms-section">
                    <div class="terms-title">Syarat dan Ketentuan Pemesanan</div>
                    <div class="terms-list">
                        <ul>
                            <li><strong>Pembayaran:</strong> NET 30 hari dari tanggal faktur/pengiriman</li>
                            <li><strong>Kualitas:</strong> Barang harus dalam kondisi baik, tidak rusak/cacat</li>
                            <li><strong>Expired Date:</strong> Minimal 24 bulan dari tanggal pengiriman</li>
                            <li><strong>Pengiriman:</strong> Maksimal 7 hari kerja setelah PO dikonfirmasi</li>
                            <li><strong>Kelengkapan:</strong> Sertakan batch number, expired date</li>
                            <li><strong>Kemasan:</strong> Kemasan harus utuh, tidak rusak, dan sesuai standar
                                farmasi</li>
                        </ul>
                    </div>
                </div>
            </div>

            <!-- Bottom Section -->
            <div class="bottom-section">
                {{-- <div class="signature-section">
                    <div class="signature-location"></div>
                    <div class="signature-line"></div>
                    <div class="signature-line"></div>
                    <div class="signature-line"></div>
                    <div class="signature-line-bottom"></div>
                    <div class="signature-name">----------------------</div>
                    <div class="signature-position">Manager</div>
                </div>
                <div class="signature-section">
                    <div class="signature-location"></div>
                    <div class="signature-line"></div>
                    <div class="signature-line"></div>
                    <div class="signature-line"></div>
                    <div class="signature-line-bottom"></div>
                    <div class="signature-name">----------------------</div>
                    <div class="signature-position">Supervisor</div>
                </div> --}}
                <div class="signature-section">
                    <div class="signature-location">Surabaya,
                        {{ \Carbon\Carbon::now()->translatedFormat('d F Y') }}
                    </div>
                    {{-- <div class="signature-title">Hormat Kami,</div> --}}
                    <div class="signature-line"></div>
                    <div class="signature-line"></div>
                    <div class="signature-line"></div>
                    <div class="signature-line"></div>
                    <div class="signature-line"></div>
                    <div class="signature-name">----------------------------------------------------</div>
                    <div class="signature-position">Manager Pembelian</div>
                </div>
            </div>
        </div>
    </div>
</div>