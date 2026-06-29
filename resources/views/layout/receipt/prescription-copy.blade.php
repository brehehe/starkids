<!DOCTYPE html>
<html lang="id">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Copy Resep Obat - Template</title>
        <style>
            * {
                margin: 0;
                padding: 0;
                box-sizing: border-box;
            }

            body {
                font-family: 'Arial', sans-serif;
                font-size: 11px;
                line-height: 1.4;
                color: #000;
                background: #f5f5f5;
                padding: 10px;
                display: flex;
                justify-content: center;
                align-items: center;
            }

            .prescription-container {
                width: 210mm;
                background: #fff;
                padding: 8mm;
                box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
                border-radius: 6px;
                position: relative;
                border: 2px solid #ff5722;
            }

            .content {
                display: flex;
                flex-direction: column;
                min-height: 100%;
            }

            /* Header Section */
            .header {
                display: grid;
                grid-template-columns: 100px 1fr 120px;
                align-items: center;
                gap: 15px;
                padding-bottom: 15px;
                border-bottom: 3px solid #ff5722;
                margin-bottom: 20px;
            }

            .logo-section {
                display: flex;
                flex-direction: column;
                align-items: center;
            }

            .logo-placeholder {
                width: 80px;
                height: 60px;
                background: linear-gradient(135deg, #ff5722, #d32f2f);
                border-radius: 8px;
                display: flex;
                align-items: center;
                justify-content: center;
                color: white;
                font-size: 10px;
                font-weight: bold;
                text-align: center;
                line-height: 1.1;
                margin-bottom: 5px;
                box-shadow: 0 2px 8px rgba(255, 87, 34, 0.3);
            }

            .clinic-info {
                text-align: center;
                font-size: 8px;
                color: #666;
                font-weight: 500;
                line-height: 1.2;
            }

            .title-section {
                text-align: center;
            }

            .prescription-title {
                font-size: 24px;
                font-weight: bold;
                color: #d32f2f;
                letter-spacing: 3px;
                margin-bottom: 5px;
            }

            .document-type {
                font-size: 12px;
                color: #666;
                font-style: italic;
            }

            .prescription-info {
                text-align: right;
                font-size: 10px;
                line-height: 1.3;
                padding: 8px;
                background: #ffebee;
                border-radius: 4px;
                border: 1px solid #ffcdd2;
            }

            .prescription-number {
                font-weight: bold;
                color: #d32f2f;
                font-size: 11px;
                margin-bottom: 3px;
            }

            /* Copy Notice */
            .copy-notice {
                background: #fff3e0;
                border: 2px solid #ff9800;
                border-radius: 8px;
                padding: 12px;
                margin: 15px 0;
                text-align: center;
            }

            .copy-notice-title {
                font-size: 14px;
                font-weight: bold;
                color: #e65100;
                margin-bottom: 5px;
                text-transform: uppercase;
                letter-spacing: 1px;
            }

            .copy-notice-text {
                font-size: 10px;
                color: #bf360c;
                line-height: 1.4;
            }

            /* Doctor Info */
            .doctor-info {
                display: grid;
                grid-template-columns: 1fr 1fr;
                gap: 20px;
                margin-bottom: 20px;
            }

            .doctor-card {
                background: #ffebee;
                padding: 10px;
                border-radius: 6px;
                border: 1px solid #ff5722;
            }

            .doctor-title {
                font-size: 12px;
                font-weight: bold;
                color: #d32f2f;
                margin-bottom: 8px;
                text-transform: uppercase;
            }

            .doctor-details {
                font-size: 10px;
                line-height: 1.4;
            }

            .doctor-details div {
                margin-bottom: 2px;
            }

            /* Patient Info */
            .patient-info {
                background: #f8f9fa;
                padding: 12px;
                border-radius: 6px;
                border: 1px solid #dee2e6;
                margin-bottom: 20px;
            }

            .patient-title {
                font-size: 12px;
                font-weight: bold;
                color: #333;
                margin-bottom: 8px;
                text-transform: uppercase;
            }

            .patient-details {
                display: grid;
                grid-template-columns: 1fr 1fr;
                gap: 15px;
                font-size: 10px;
            }

            .patient-row {
                display: flex;
                align-items: center;
                gap: 8px;
            }

            .patient-label {
                width: 80px;
                font-weight: 600;
                color: #333;
                flex-shrink: 0;
            }

            .patient-colon {
                width: 8px;
                font-weight: bold;
                flex-shrink: 0;
            }

            .patient-value {
                flex: 1;
                font-weight: 500;
            }

            /* Prescription Table */
            .prescription-table {
                width: 100%;
                border-collapse: collapse;
                font-size: 10px;
                margin: 20px 0;
                box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
                border-radius: 6px;
                overflow: hidden;
            }

            .prescription-table th,
            .prescription-table td {
                border: 1px solid #ddd;
                padding: 8px;
                text-align: left;
            }

            .prescription-table th {
                background: linear-gradient(135deg, #d32f2f, #b71c1c);
                color: white;
                font-weight: bold;
                text-align: center;
                font-size: 10px;
                text-transform: uppercase;
                letter-spacing: 0.5px;
            }

            .prescription-table tbody tr:nth-child(even) {
                background: #ffebee;
            }

            .prescription-table tbody tr:hover {
                background: #ffcdd2;
            }

            .prescription-table .no-col {
                width: 30px;
                text-align: center;
            }

            .prescription-table .medicine-col {
                width: auto;
                font-weight: 500;
            }

            .prescription-table .dosage-col {
                width: 120px;
                text-align: center;
            }

            .prescription-table .quantity-col {
                width: 80px;
                text-align: center;
            }

            .prescription-table .instruction-col {
                width: 200px;
            }

            .medicine-name {
                font-weight: bold;
                color: #d32f2f;
                margin-bottom: 2px;
                font-size: 10px;
            }

            .medicine-details {
                font-size: 8px;
                color: #666;
                line-height: 1.2;
            }

            .dosage-info {
                font-weight: bold;
                color: #d32f2f;
                text-align: center;
            }

            .instruction-text {
                font-size: 9px;
                line-height: 1.3;
                color: #333;
            }

            /* Copy Restrictions */
            .copy-restrictions {
                background: #ffebee;
                padding: 12px;
                border-radius: 6px;
                border: 2px solid #f44336;
                margin: 20px 0;
            }

            .restrictions-title {
                font-size: 12px;
                font-weight: bold;
                color: #c62828;
                margin-bottom: 8px;
                text-transform: uppercase;
            }

            .restrictions-content {
                font-size: 10px;
                line-height: 1.4;
                color: #d32f2f;
            }

            .restrictions-content ul {
                margin-left: 15px;
            }

            .restrictions-content li {
                margin-bottom: 3px;
            }

            /* Bottom Section */
            .bottom-section {
                margin-top: 30px;
                display: grid;
                grid-template-columns: 1fr 1fr;
                gap: 40px;
                align-items: end;
                padding-top: 20px;
                border-top: 2px solid #e0e0e0;
            }

            .signature-section {
                text-align: center;
                background: #ffebee;
                padding: 15px;
                border-radius: 6px;
                border: 1px solid #ffcdd2;
                min-height: 100px;
            }

            .signature-location {
                font-size: 10px;
                color: #666;
                font-style: italic;
                margin-bottom: 20px;
            }

            .signature-title {
                font-size: 11px;
                font-weight: bold;
                color: #333;
                margin-bottom: 5px;
            }

            .signature-line {
                width: 120px;
                height: 1px;
                background: #333;
                margin: 30px auto 8px;
            }

            .signature-name {
                font-size: 12px;
                font-weight: bold;
                color: #d32f2f;
                margin-bottom: 2px;
            }

            .signature-position {
                font-size: 9px;
                color: #666;
                font-style: italic;
            }

            .signature-license {
                font-size: 8px;
                color: #999;
                margin-top: 2px;
            }

            /* Watermark */
            .watermark {
                position: absolute;
                top: 50%;
                left: 50%;
                transform: translate(-50%, -50%) rotate(-45deg);
                font-size: 48px;
                color: rgba(255, 87, 34, 0.08);
                font-weight: bold;
                pointer-events: none;
                z-index: 1;
                letter-spacing: 3px;
            }

            /* Copy Indicator */
            .copy-indicator {
                position: absolute;
                top: 10px;
                right: 15px;
                background: #ff5722;
                color: white;
                padding: 8px 15px;
                border-radius: 6px;
                font-size: 12px;
                font-weight: bold;
                text-transform: uppercase;
                letter-spacing: 1px;
                box-shadow: 0 3px 6px rgba(255, 87, 34, 0.4);
                animation: pulse 2s infinite;
            }

            @keyframes pulse {
                0% {
                    transform: scale(1);
                }

                50% {
                    transform: scale(1.05);
                }

                100% {
                    transform: scale(1);
                }
            }

            /* Print Styles */
            @media print {
                @page {
                    size: A4 portrait;
                    margin: 15mm;
                }

                body {
                    margin: 0;
                    padding: 0;
                    background: #fff;
                    font-size: 10px;
                }

                .prescription-container {
                    width: 100%;
                    background: #fff;
                    padding: 0;
                    box-shadow: none;
                    border-radius: 0;
                    border: 2px solid #ff5722;
                }

                .watermark {
                    display: block !important;
                }

                .copy-indicator {
                    display: block !important;
                }
            }
        </style>
    </head>

    <body>
        <div class="prescription-container">
            <div class="watermark">COPY RESEP</div>

            <!-- Copy Indicator -->
            <div class="copy-indicator">
                COPY RESEP
            </div>

            <div class="content">
                <!-- Header -->
                <div class="header">
                    <div class="logo-section">
                        <div class="logo-placeholder">
                            {{ $clinic['name'] }}
                        </div>
                        <div class="clinic-info">
                            {{ $clinic['name'] }}<br>
                            Kesehatan Terpadu
                        </div>
                    </div>

                    <div class="title-section">
                        <div class="prescription-title">COPY RESEP</div>
                        <div class="document-type">Copy of Medical Prescription</div>
                    </div>

                    <div class="prescription-info">
                        <div class="prescription-number">No. {{ $prescription['number'] }}</div>
                        <div>Tanggal: {{ $prescription['date'] }}</div>
                        <div>Waktu: {{ $prescription['time'] }}</div>
                        <div>Kode Konsultasi: {{ $prescription['consultation_code'] }}</div>
                        <div style="color: #d32f2f; font-weight: bold;">COPY {{ $prescription['date'] }}</div>
                    </div>
                </div>

                <!-- Copy Notice -->
                <div class="copy-notice">
                    <div class="copy-notice-title">⚠️ PERHATIAN - INI ADALAH COPY RESEP ⚠️</div>
                    <div class="copy-notice-text">
                        Dokumen ini adalah salinan resep asli yang telah ditebus. Copy resep ini hanya untuk keperluan
                        dokumentasi dan tidak dapat digunakan untuk menebus obat kembali di apotek manapun.
                    </div>
                </div>

                <!-- Doctor Info -->
                <div class="doctor-info">
                    <div class="doctor-card">
                        <div class="doctor-title">Dokter Pemeriksa</div>
                        <div class="doctor-details">
                            <div><strong>{{ $doctor['name'] }}</strong></div>
                            <div>{{ $doctor['specialization'] }}</div>
                            <div>SIP: {{ $doctor['sip'] }}</div>
                            <div>STR: {{ $doctor['str'] }}</div>
                        </div>
                    </div>

                    <div class="doctor-card">
                        <div class="doctor-title">Poli/Klinik</div>
                        <div class="doctor-details">
                            <div><strong>{{ $location['name'] }}</strong></div>
                            <div>{{ $clinic['name'] }}</div>
                            <div>{{ $location['address'] }}</div>
                            <div>Telp: {{ $location['phone'] }}</div>
                        </div>
                    </div>
                </div>

                <!-- Patient Info -->
                <div class="patient-info">
                    <div class="patient-title">Data Pasien</div>
                    <div class="patient-details">
                        <div class="patient-row">
                            <div class="patient-label">Nama</div>
                            <div class="patient-colon">:</div>
                            <div class="patient-value">{{ $patient['name'] }}</div>
                        </div>
                        <div class="patient-row">
                            <div class="patient-label">Umur</div>
                            <div class="patient-colon">:</div>
                            <div class="patient-value">{{ $patient['age'] }}</div>
                        </div>
                        <div class="patient-row">
                            <div class="patient-label">Jenis Kelamin</div>
                            <div class="patient-colon">:</div>
                            <div class="patient-value">{{ $patient['gender'] }}</div>
                        </div>
                        <div class="patient-row">
                            <div class="patient-label">Alamat</div>
                            <div class="patient-colon">:</div>
                            <div class="patient-value">{{ $patient['address'] }}</div>
                        </div>
                        <div class="patient-row">
                            <div class="patient-label">No. Telepon</div>
                            <div class="patient-colon">:</div>
                            <div class="patient-value">{{ $patient['phone'] }}</div>
                        </div>
                        <div class="patient-row">
                            <div class="patient-label">Diagnosis</div>
                            <div class="patient-colon">:</div>
                            <div class="patient-value">{{ $patient['diagnosis'] }}</div>
                        </div>
                    </div>
                </div>

                <!-- Prescription Table -->
                <table class="prescription-table">
                    <thead>
                        <tr>
                            <th class="no-col">No</th>
                            <th class="medicine-col">Nama Obat & Sediaan</th>
                            <th class="dosage-col">Dosis</th>
                            <th class="quantity-col">Jumlah</th>
                            <th class="instruction-col">Aturan Pakai</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($medicines as $medicine)
                            <tr>
                                <td class="no-col">{{ $medicine['no'] }}</td>
                                <td class="medicine-col">
                                    <div class="medicine-name">{{ $medicine['name'] }}</div>
                                    <div class="medicine-details">{{ $medicine['details'] }}</div>
                                </td>
                                <td class="dosage-col">
                                    <div class="dosage-info">{{ $medicine['dosage'] }}</div>
                                </td>
                                <td class="quantity-col">{{ $medicine['quantity'] }}</td>
                                <td class="instruction-col">
                                    <div class="instruction-text">
                                        {{ $medicine['instruction'] }}
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>

                <!-- Copy Restrictions -->
                <div class="copy-restrictions">
                    <div class="restrictions-title">🚫 KETENTUAN COPY RESEP</div>
                    <div class="restrictions-content">
                        <ul>
                            <li><strong>TIDAK BERLAKU untuk menebus obat:</strong> Copy resep ini tidak dapat digunakan
                                untuk membeli obat di apotek</li>
                            <li><strong>Hanya untuk dokumentasi:</strong> Dokumen ini hanya untuk keperluan arsip dan
                                dokumentasi medis</li>
                            <li><strong>Sudah ditebus:</strong> Obat-obatan dalam resep asli telah ditebus pada tanggal
                                {{ date('d/m/Y') }}</li>
                            <li><strong>Konsultasi ulang:</strong> Untuk mendapatkan obat yang sama, silakan konsultasi
                                kembali dengan dokter</li>
                            <li><strong>Tidak dapat difotokopi:</strong> Copy resep ini tidak boleh difotokopi untuk
                                keperluan apapun</li>
                        </ul>
                    </div>
                </div>

                <!-- Bottom Section -->
                <div class="bottom-section">
                    <div class="signature-section">
                        <div class="signature-location">{{ $location['name'] }}, {{ date('d F Y') }}</div>
                        <div class="signature-title">Dokter Pemeriksa</div>
                        <div class="signature-line"></div>
                        <div class="signature-name">{{ $doctor['name'] }}</div>
                        <div class="signature-position">{{ $doctor['specialization'] }}</div>
                        <div class="signature-license">SIP: {{ $doctor['sip'] }}</div>
                    </div>

                    <div class="signature-section">
                        <div class="signature-location">Apoteker Penanggung Jawab</div>
                        <div class="signature-title">Menyetujui</div>
                        <div class="signature-line"></div>
                        <div class="signature-name">{{ $pharmacist['name'] }}</div>
                        <div class="signature-position">{{ $pharmacist['position'] }}</div>
                        <div class="signature-license">SIA: {{ $pharmacist['license'] }}</div>
                    </div>
                </div>
            </div>
        </div>

        <script>
            // Function to print copy prescription
            function printCopyPrescription() {
                window.print();
            }

            // Auto-print when page loads (optional)
            window.onload = function() {
                // Uncomment the line below to auto-print when page loads
                // setTimeout(printCopyPrescription, 1000);
            };
        </script>
    </body>

</html>
