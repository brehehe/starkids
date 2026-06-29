<!DOCTYPE html>
<html lang="id">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Surat Pesanan A5 - Template Rapi</title>
        <style>
            * {
                margin: 0;
                padding: 0;
                box-sizing: border-box;
            }

            body {
                font-family: 'Arial', sans-serif;
                font-size: 10px;
                line-height: 1.3;
                color: #000;
                background: #f5f5f5;
                padding: 10px;
                display: flex;
                justify-content: center;
                align-items: center;
                /* min-height: 100vh; */
            }

            .surat-container {
                width: 210mm;
                background: #fff;
                padding: 4mm;
                box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
                border-radius: 6px;
                position: relative;
                border: 1px solid #ddd;
            }

            .content {
                display: flex;
                flex-direction: column;
                min-height: 100%;
            }

            /* Header Section */
            .header {
                display: grid;
                grid-template-columns: 80px 1fr 150px;
                align-items: center;
                gap: 12px;
                padding-bottom: 10px;
                border-bottom: 2px solid #2196F3;
                margin-bottom: 12px;
            }

            .logo-section {
                display: flex;
                flex-direction: column;
                align-items: center;
            }

            .logo-placeholder {
                /* width: 60px; */
                /* height: 45px; */
                /* background: linear-gradient(135deg, #2196F3, #1976D2); */
                border-radius: 8px;
                display: flex;
                align-items: center;
                justify-content: center;
                color: white;
                font-size: 8px;
                font-weight: bold;
                text-align: center;
                line-height: 1.1;
                margin-bottom: 4px;
                /* box-shadow: 0 2px 8px rgba(33, 150, 243, 0.3); */
            }

            .company-info {
                text-align: center;
                font-size: 7px;
                color: #666;
                font-weight: 500;
                line-height: 1.2;
            }

            .title-section {
                text-align: center;
            }

            .surat-title {
                font-size: 18px;
                font-weight: bold;
                color: #1976D2;
                letter-spacing: 2px;
                margin-bottom: 2px;
            }

            .document-type {
                font-size: 9px;
                color: #666;
                font-style: italic;
            }

            .order-info {
                text-align: right;
                font-size: 9px;
                line-height: 1.2;
                padding: 6px;
                background: #f8f9fa;
                border-radius: 4px;
                border: 1px solid #dee2e6;
            }

            .order-number {
                font-weight: bold;
                color: #1976D2;
                font-size: 10px;
                margin-bottom: 2px;
            }

            /* Main Content - FIXED: Menghilangkan flex: 1 */
            .main-content {
                display: flex;
                flex-direction: column;
                gap: 6px;
            }

            .order-details {
                display: flex;
                flex-direction: column;
                gap: 4px;
                margin-bottom: 6px;
            }

            .detail-row {
                display: flex;
                align-items: flex-start;
                gap: 6px;
            }

            .detail-label {
                width: 90px;
                font-size: 9px;
                color: #333;
                font-weight: 600;
                flex-shrink: 0;
            }

            .detail-colon {
                width: 6px;
                font-size: 9px;
                font-weight: bold;
                flex-shrink: 0;
            }

            .detail-value {
                flex: 1;
                font-size: 9px;
                line-height: 1.3;
            }

            .supplier-info {
                background: #f8f9fa;
                padding: 6px;
                border-radius: 4px;
                border: 1px solid #dee2e6;
            }

            .supplier-name {
                font-weight: bold;
                color: #1976D2;
                margin-bottom: 2px;
            }

            .delivery-address {
                background: #e8f5e8;
                padding: 6px;
                border-radius: 4px;
                border: 1px solid #c3e6cb;
            }

            /* Items Table */
            .items-table {
                width: 100%;
                border-collapse: collapse;
                font-size: 7px;
                margin: 6px 0;
                box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
                border-radius: 4px;
                overflow: hidden;
            }

            .items-table th,
            .items-table td {
                border: 1px solid #ddd;
                padding: 3px;
                text-align: left;
            }

            .items-table th {
                background: linear-gradient(135deg, #1976D2, #0D47A1);
                color: white;
                font-weight: bold;
                text-align: center;
                font-size: 7px;
                text-transform: uppercase;
                letter-spacing: 0.3px;
            }

            .items-table tbody tr:nth-child(even) {
                background: #f8f9fa;
            }

            .items-table tbody tr:hover {
                background: #e3f2fd;
            }

            .items-table .no-col {
                width: 20px;
                text-align: center;
            }

            .items-table .qty-col {
                width: 30px;
                text-align: center;
            }

            .items-table .unit-col {
                width: 35px;
                text-align: center;
            }

            .items-table .price-col {
                width: 55px;
                text-align: right;
            }

            .items-table .total-col {
                width: 65px;
                text-align: right;
            }

            .items-table .description-col {
                width: auto;
                font-weight: 500;
            }

            .product-name {
                font-weight: bold;
                color: #333;
                margin-bottom: 1px;
                font-size: 7px;
            }

            .product-details {
                font-size: 6px;
                color: #666;
                line-height: 1.2;
            }

            .total-row {
                font-weight: bold;
                background: linear-gradient(135deg, #4CAF50, #45a049) !important;
                color: white !important;
            }

            .total-row td {
                border-color: #4CAF50 !important;
            }

            /* Terms Section */
            .terms-section {
                padding: 4px;
                background: #fff8dc;
                border: 1px solid #f39c12;
                border-radius: 4px;
                margin: 4px 0;
            }

            .terms-title {
                font-weight: bold;
                color: #d68910;
                font-size: 8px;
                margin-bottom: 3px;
                text-transform: uppercase;
            }

            .terms-list {
                font-size: 7px;
                line-height: 1.2;
                color: #5d4e37;
            }

            .terms-list ul {
                margin-left: 8px;
            }

            .terms-list li {
                margin-bottom: 1px;
            }

            /* Bottom Section - FIXED: Mengurangi margin-top */
            .bottom-section {
                margin-top: 10px;
                /* Dikurangi dari 'auto' menjadi 10px */
                display: grid;
                grid-template-columns: 1fr 1fr 1fr;
                gap: 8px;
                /* Dikurangi dari 12px menjadi 8px */
                align-items: end;
                padding-top: 4px;
                /* Dikurangi dari 6px menjadi 4px */
                border-top: 1px solid #e0e0e0;
            }

            .signature-section {
                text-align: center;
                background: #f8f9fa;
                padding: 4px;
                /* Dikurangi dari 5px menjadi 4px */
                border-radius: 4px;
                border: 1px solid #dee2e6;
                min-height: 60px;
                /* Dikurangi dari default */
            }

            .signature-location {
                font-size: 7px;
                /* Dikurangi dari 8px menjadi 7px */
                color: #666;
                font-style: italic;
                margin-bottom: 8px;
                /* Dikurangi dari 15px menjadi 8px */
            }

            .signature-title {
                font-size: 7px;
                /* Dikurangi dari 8px menjadi 7px */
                font-weight: bold;
                color: #333;
                margin-bottom: 2px;
            }

            .signature-line {
                width: 60px;
                /* Dikurangi dari 80px menjadi 60px */
                height: 1px;
                /* background: #333; */
                margin: 8px auto 3px;
                /* Dikurangi dari 15px menjadi 8px */
            }

            .signature-line-bottom {
                width: 60px;
                /* Dikurangi dari 80px menjadi 60px */
                height: 1px;
                background: #333;
                margin: 8px auto 3px;
                /* Dikurangi dari 15px menjadi 8px */
            }

            .signature-name {
                font-size: 8px;
                /* Dikurangi dari 9px menjadi 8px */
                font-weight: bold;
                color: #1976D2;
            }

            .signature-position {
                font-size: 6px;
                /* Dikurangi dari 7px menjadi 6px */
                color: #666;
                margin-top: 1px;
                font-style: italic;
            }

            /* Watermark */
            .watermark {
                position: absolute;
                top: 50%;
                left: 50%;
                transform: translate(-50%, -50%) rotate(-45deg);
                font-size: 36px;
                color: rgba(33, 150, 243, 0.03);
                font-weight: bold;
                pointer-events: none;
                z-index: 1;
            }

            /* Print Styles - FIXED FOR A5 */
            @media print {
                @page {
                    size: A5 portrait;
                    margin: 2mm;
                    /* Dikurangi dari 10mm menjadi 8mm */
                }

                body {
                    margin: 0;
                    padding: 0;
                    background: #fff;
                    font-size: 9px;
                }

                .surat-container {
                    width: 150mm;
                    background: #fff;
                    padding: 4mm;
                    box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
                    border-radius: 6px;
                    position: relative;
                    border: 1px solid #ddd;
                }

                .content {
                    display: flex;
                    flex-direction: column;
                }

                /* PENTING: Pastikan header tetap horizontal saat print */
                .header {
                    display: grid !important;
                    grid-template-columns: 70px 1fr 90px !important;
                    align-items: center !important;
                    gap: 8px !important;
                    /* Dikurangi dari 10px menjadi 8px */
                    padding-bottom: 6px !important;
                    /* Dikurangi dari 8px menjadi 6px */
                    border-bottom: 2px solid #2196F3 !important;
                    margin-bottom: 8px !important;
                    /* Dikurangi dari 10px menjadi 8px */
                }

                .logo-placeholder {
                    width: 45px;
                    height: 35px;
                    font-size: 6px;
                }

                .company-info {
                    font-size: 5px;
                }

                .surat-title {
                    font-size: 14px;
                }

                .document-type {
                    font-size: 7px;
                }

                .order-info {
                    font-size: 7px;
                    padding: 3px;
                }

                .order-number {
                    font-size: 8px;
                }

                .main-content {
                    gap: 3px;
                    /* Dikurangi dari 4px menjadi 3px */
                }

                .items-table {
                    font-size: 9px;
                    margin: 3px 0;
                    /* Dikurangi dari 4px menjadi 3px */
                }

                .items-table th,
                .items-table td {
                    padding: 2px;
                }

                .items-table th {
                    font-size: 8px;
                }

                .product-name {
                    font-size: 8px;
                }

                .product-details {
                    font-size: 6px;
                }

                .terms-section {
                    padding: 2px;
                    /* Dikurangi dari 3px menjadi 2px */
                    margin: 2px 0;
                    /* Dikurangi dari 3px menjadi 2px */
                }

                .terms-title {
                    font-size: 10px;
                }

                .terms-list {
                    font-size: 8px;
                }

                .bottom-section {
                    margin-top: 6px !important;
                    /* Dikurangi dari default */
                    gap: 6px !important;
                    /* Dikurangi dari 10px menjadi 6px */
                    padding-top: 2px !important;
                    /* Dikurangi dari 4px menjadi 2px */
                }

                .signature-section {
                    padding: 2px !important;
                    /* Dikurangi dari 4px menjadi 2px */
                    min-height: 50px !important;
                    /* Dikurangi dari default */
                }

                .signature-location {
                    font-size: 8px !important;
                    margin-bottom: 6px !important;
                    /* Dikurangi dari 12px menjadi 6px */
                }

                .signature-title {
                    font-size: 8px !important;
                }

                .signature-line {
                    width: 40px !important;
                    /* Dikurangi dari 70px menjadi 40px */
                    margin: 6px auto 2px !important;
                    /* Dikurangi dari 12px menjadi 6px */
                }

                .signature-name {
                    font-size: 10px !important;
                }

                .signature-position {
                    font-size: 8px !important;
                }

                .watermark {
                    display: none;
                }
            }
        </style>
    </head>

    <body>
        <div class="surat-container">
            <div class="watermark">PURCHASE ORDER</div>

            <div class="content">
                <!-- Header -->
                <div class="header">
                    <div class="logo-section">
                        <div class="logo-placeholder">
                            APOTEK<br>SEHAT
                        </div>
                        <div class="company-info">
                            PT. APOTEK SEHAT<br>
                            SEJAHTERA
                        </div>
                    </div>

                    <div class="title-section">
                        <div class="surat-title">SURAT PESANAN</div>
                        <div class="document-type">Purchase Order Document</div>
                    </div>

                    <div class="order-info">
                        <div class="order-number">No. PO-2025-0001</div>
                        <div>Tanggal: 16/07/2025</div>
                        <div>Waktu: 14:06:42</div>
                        <div>User: brehehe</div>
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
                                    <div class="supplier-name">PT. KIMIA FARMA TRADING & DISTRIBUTION</div>
                                    <div>Jl. Veteran No. 9, Jakarta Pusat 10110</div>
                                    <div>Telp: (021) 3441991 | Fax: (021) 3441992</div>
                                    <div>Email: td@kimiafarma.co.id</div>
                                    <div>NPWP: 01.001.625.4-017.000</div>
                                </div>
                            </div>
                        </div>

                        <div class="detail-row">
                            <div class="detail-label">Mohon Dikirim</div>
                            <div class="detail-colon">:</div>
                            <div class="detail-value">Obat-obatan dan produk kesehatan farmasi sesuai dengan daftar
                                spesifikasi di bawah ini</div>
                        </div>

                        <div class="detail-row">
                            <div class="detail-label">Kirim Ke</div>
                            <div class="detail-colon">:</div>
                            <div class="detail-value">
                                <div class="delivery-address">
                                    <div><strong>Apotek Sehat Sejahtera</strong></div>
                                    <div>Jl. Raya Kesehatan No. 123, Blok A-15</div>
                                    <div>Jakarta Selatan, DKI Jakarta 12345</div>
                                    <div>Telp: (021) 1234-5678 | WA: 0812-3456-7890</div>
                                    <div>PIC: brehehe (Manager Pembelian)</div>
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
                                <th class="price-col">Harga</th>
                                <th class="total-col">Total</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td class="no-col">1</td>
                                <td class="description-col">
                                    <strong>Paracetamol 500mg</strong><br>
                                    <small>Tablet, Merk: Sanbe, Kemasan: Strip 10 tablet</small>
                                </td>
                                <td class="qty-col">50</td>
                                <td class="unit-col">Box</td>
                                <td class="price-col">15,000</td>
                                <td class="total-col">750,000</td>
                            </tr>
                            <tr>
                                <td class="no-col">2</td>
                                <td class="description-col">
                                    <strong>Amoxicillin 500mg</strong><br>
                                    <small>Kapsul, Merk: Indofarma, Kemasan: Strip 10 kapsul</small>
                                </td>
                                <td class="qty-col">30</td>
                                <td class="unit-col">Box</td>
                                <td class="price-col">25,000</td>
                                <td class="total-col">750,000</td>
                            </tr>
                            <tr>
                                <td class="no-col">3</td>
                                <td class="description-col">
                                    <strong>Vitamin C 1000mg</strong><br>
                                    <small>Tablet Effervescent, Merk: Sido Muncul, Kemasan: Tube 10 tablet</small>
                                </td>
                                <td class="qty-col">100</td>
                                <td class="unit-col">Box</td>
                                <td class="price-col">12,000</td>
                                <td class="total-col">1,200,000</td>
                            </tr>
                            <tr>
                                <td class="no-col">4</td>
                                <td class="description-col">
                                    <strong>Betadine Solution 60ml</strong><br>
                                    <small>Antiseptik, Merk: Mundipharma, Kemasan: Botol 60ml</small>
                                </td>
                                <td class="qty-col">24</td>
                                <td class="unit-col">Btl</td>
                                <td class="price-col">18,500</td>
                                <td class="total-col">444,000</td>
                            </tr>
                            <tr>
                                <td class="no-col">5</td>
                                <td class="description-col">
                                    <strong>OBH Combi Batuk Berdahak 100ml</strong><br>
                                    <small>Sirup, Merk: OBH Combi, Kemasan: Botol 100ml</small>
                                </td>
                                <td class="qty-col">36</td>
                                <td class="unit-col">Btl</td>
                                <td class="price-col">22,000</td>
                                <td class="total-col">792,000</td>
                            </tr>
                            <tr>
                                <td class="no-col">6</td>
                                <td class="description-col">
                                    <strong>Antangin JRG Sachet</strong><br>
                                    <small>Herbal, Merk: Deltomed, Kemasan: Sachet 15ml</small>
                                </td>
                                <td class="qty-col">120</td>
                                <td class="unit-col">Pcs</td>
                                <td class="price-col">3,500</td>
                                <td class="total-col">420,000</td>
                            </tr>
                            <tr class="total-row">
                                <td colspan="5" style="text-align: right; font-weight: bold;">TOTAL PESANAN (Rp):
                                </td>
                                <td class="total-col" style="font-weight: bold;">4,356,000</td>
                            </tr>
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
                                <li><strong>Kelengkapan:</strong> Sertakan batch number, expired date, dan sertifikat
                                    halal</li>
                                <li><strong>Kemasan:</strong> Kemasan harus utuh, tidak rusak, dan sesuai standar
                                    farmasi</li>
                            </ul>
                        </div>
                    </div>
                </div>

                <!-- Bottom Section -->
                <div class="bottom-section">
                    <div class="contact-info">
                        <div class="contact-title">Kontak Person</div>
                        <div class="contact-details">
                            <div><strong>Nama:</strong> brehehe</div>
                            <div><strong>Jabatan:</strong> Manager Pembelian</div>
                            <div><strong>Telepon:</strong> (021) 1234-5678</div>
                            <div><strong>Mobile:</strong> 0812-3456-7890</div>
                            <div><strong>Email:</strong> brehehe@apoteksehat.com</div>
                            <div><strong>Jam Kerja:</strong> 08:00 - 17:00 WIB</div>
                        </div>
                    </div>

                    <div class="signature-section">
                        <div class="signature-location">Jakarta, 16 Juli 2025</div>
                        <div class="signature-title">Hormat Kami,</div>
                        <div class="signature-line"></div>
                        <div class="signature-name">brehehe</div>
                        <div class="signature-position">Manager Pembelian</div>
                    </div>
                </div>
            </div>
        </div>
    </body>

</html>
<?php /**PATH /Users/macbookair/Documents/mediction/mediction.id/resources/views/layout/receipt/recipe.blade.php ENDPATH**/ ?>