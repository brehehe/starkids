<!DOCTYPE html>
<html lang="id">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Resep Obat - Template</title>
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
                border: 2px solid #2196F3;
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
                border-bottom: 3px solid #2196F3;
                margin-bottom: 20px;
            }

            .logo-section {
                display: flex;
                flex-direction: column;
                align-items: center;
            }

            .logo-placeholder {
                width: 250px;
                height: 60px;
                background: linear-gradient(135deg, #2196F3, #1976D2);
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
                box-shadow: 0 2px 8px rgba(33, 150, 243, 0.3);
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
                color: #1976D2;
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
                background: #f8f9fa;
                border-radius: 4px;
                border: 1px solid #dee2e6;
            }

            .prescription-number {
                font-weight: bold;
                color: #1976D2;
                font-size: 11px;
                margin-bottom: 3px;
            }

            /* Doctor Info */
            .doctor-info {
                display: grid;
                grid-template-columns: 1fr 1fr;
                gap: 20px;
                margin-bottom: 20px;
            }

            .doctor-card {
                background: #e3f2fd;
                padding: 10px;
                border-radius: 6px;
                border: 1px solid #2196F3;
            }

            .doctor-title {
                font-size: 12px;
                font-weight: bold;
                color: #1976D2;
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
                background: linear-gradient(135deg, #1976D2, #0D47A1);
                color: white;
                font-weight: bold;
                text-align: center;
                font-size: 10px;
                text-transform: uppercase;
                letter-spacing: 0.5px;
            }

            .prescription-table tbody tr:nth-child(even) {
                background: #f8f9fa;
            }

            .prescription-table tbody tr:hover {
                background: #e3f2fd;
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
                color: #1976D2;
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

            /* Notes Section */
            .notes-section {
                background: #fff3cd;
                padding: 12px;
                border-radius: 6px;
                border: 1px solid #f0ad4e;
                margin: 20px 0;
            }

            .notes-title {
                font-size: 12px;
                font-weight: bold;
                color: #856404;
                margin-bottom: 8px;
                text-transform: uppercase;
            }

            .notes-content {
                font-size: 10px;
                line-height: 1.4;
                color: #6c5f00;
            }

            /* Bottom Section */
            .bottom-section {
                margin-top: 30px;
                display: flex;
                justify-content: flex-end;
                /* dorong ke kanan */
                padding-top: 20px;
                border-top: 2px solid #e0e0e0;
            }

            .signature-section {
                text-align: center;
                background: #f8f9fa;
                padding: 15px;
                border-radius: 6px;
                border: 1px solid #dee2e6;
                min-height: 100px;

                /* tambahin ini */
                width: 250px;
                /* fix width */
                /* atau */
                min-width: 220px;
                /* biar minimal segini */
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
                color: #1976D2;
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
                color: rgba(33, 150, 243, 0.05);
                font-weight: bold;
                pointer-events: none;
                z-index: 1;
            }

            /* Copy Indicator */
            /* .copy-indicator {
                position: absolute;
                top: 10px;
                right: 15px;
                background: #ff5722;
                color: white;
                padding: 5px 10px;
                border-radius: 4px;
                font-size: 9px;
                font-weight: bold;
                text-transform: uppercase;
                letter-spacing: 0.5px;
                box-shadow: 0 2px 4px rgba(255, 87, 34, 0.3);
            } */

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
                    border: 2px solid #2196F3;
                }

                .watermark {
                    display: none;
                }

                .copy-indicator {
                    display: block !important;
                }
            }
        </style>
    </head>

    <body>
        @yield('content')
        <script>
            // Function to show copy indicator
            function showCopyIndicator() {
                document.querySelector('.copy-indicator').style.display = 'block';
                document.querySelector('.copy-indicator').textContent = 'COPY RESEP';
            }

            // Function to hide copy indicator
            function hideCopyIndicator() {
                document.querySelector('.copy-indicator').style.display = 'none';
            }

            // Function to print prescription
            function printPrescription() {
                hideCopyIndicator();
                window.print();
            }

            // Function to create copy of prescription
            function createCopy() {
                showCopyIndicator();
                setTimeout(() => {
                    window.print();
                    setTimeout(() => {
                        hideCopyIndicator();
                    }, 1000);
                }, 100);
            }

            // Function to download as PDF
            function downloadPDF() {
                // Hide action buttons before generating PDF
                document.querySelector('.action-buttons').style.display = 'none';

                // Use browser's print to PDF functionality
                window.print();

                // Show action buttons again
                setTimeout(() => {
                    document.querySelector('.action-buttons').style.display = 'flex';
                }, 1000);
            }

            // Function to edit prescription (placeholder)
            function editPrescription() {
                alert('Fitur edit akan membuka form edit resep');
                // Redirect to edit form or open modal
                // window.location.href = '/prescription/edit/{{ $prescription->id ?? 1 }}';
            }

            // Function to copy prescription data to clipboard
            function copyToClipboard() {
                const prescriptionData = {
                    number: document.querySelector('.prescription-number').textContent,
                    doctor: 'Dr. Ahmad Santoso, Sp.PD',
                    patient: 'Budi Santoso',
                    diagnosis: 'Hipertensi Grade 1 (I10)',
                    medicines: [
                        'Amlodipine 5mg - 1x1 - 30 tablet',
                        'Vitamin B Complex - 1x1 - 30 tablet',
                        'Paracetamol 500mg - 3x1 - 10 tablet'
                    ]
                };

                const textToCopy = `
COPY RESEP
${prescriptionData.number}
Dokter: ${prescriptionData.doctor}
Pasien: ${prescriptionData.patient}
Diagnosis: ${prescriptionData.diagnosis}

OBAT:
${prescriptionData.medicines.map((med, index) => `${index + 1}. ${med}`).join('\n')}
            `.trim();

                navigator.clipboard.writeText(textToCopy).then(() => {
                    showNotification('Data resep berhasil disalin ke clipboard!');
                }).catch(() => {
                    showNotification('Gagal menyalin data resep', 'error');
                });
            }

            // Function to show notification
            function showNotification(message, type = 'success') {
                const notification = document.createElement('div');
                notification.className = `notification ${type}`;
                notification.textContent = message;
                notification.style.cssText = `
                position: fixed;
                top: 80px;
                right: 20px;
                background: ${type === 'success' ? '#4CAF50' : '#f44336'};
                color: white;
                padding: 12px 20px;
                border-radius: 4px;
                z-index: 1001;
                font-size: 14px;
                box-shadow: 0 2px 8px rgba(0,0,0,0.2);
                animation: slideIn 0.3s ease;
            `;

                document.body.appendChild(notification);

                setTimeout(() => {
                    notification.style.animation = 'slideOut 0.3s ease';
                    setTimeout(() => {
                        document.body.removeChild(notification);
                    }, 300);
                }, 3000);
            }

            // Add CSS animations
            const style = document.createElement('style');
            style.textContent = `
            @keyframes slideIn {
                from { transform: translateX(100%); opacity: 0; }
                to { transform: translateX(0); opacity: 1; }
            }

            @keyframes slideOut {
                from { transform: translateX(0); opacity: 1; }
                to { transform: translateX(100%); opacity: 0; }
            }

            .btn {
                padding: 8px 12px;
                border: none;
                border-radius: 4px;
                cursor: pointer;
                font-size: 12px;
                font-weight: 500;
                display: flex;
                align-items: center;
                gap: 5px;
                transition: all 0.3s ease;
                text-decoration: none;
                color: white;
            }

            .btn:hover {
                transform: translateY(-2px);
                box-shadow: 0 4px 8px rgba(0,0,0,0.2);
            }

            .btn-print {
                background: #2196F3;
            }

            .btn-copy {
                background: #FF9800;
            }

            .btn-download {
                background: #4CAF50;
            }

            .btn-edit {
                background: #9C27B0;
            }

            @media print {
                .action-buttons {
                    display: none !important;
                }
            }
        `;
            document.head.appendChild(style);

            // Add Font Awesome for icons
            if (!document.querySelector('link[href*="font-awesome"]')) {
                const fontAwesome = document.createElement('link');
                fontAwesome.rel = 'stylesheet';
                fontAwesome.href = 'https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css';
                document.head.appendChild(fontAwesome);
            }
        </script>
    </body>

</html>
