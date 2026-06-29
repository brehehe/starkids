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
                grid-template-columns: 150px 1fr 150px;
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
                font-size: 8px;
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
                font-size: 8px;
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
                font-size: 8px;
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
                display: flex;
                justify-content: flex-end;
                /* ⬅️ Ini akan menaruh isi ke akhir secara horizontal */
                align-items: flex-end;
                /* ⬅️ Ini akan menaruh isi ke bawah secara vertikal */
                /* ⬅️ Pastikan punya tinggi agar efek terlihat */
            }

            .signature-section {
                width: 250px;
                text-align: center;
                background: #f8f9fa;
                padding: 4px;
                /* Dikurangi dari 5px menjadi 4px */
                border-radius: 4px;
                border: 1px solid #dee2e6;
                min-height: 100px;
                /* Dikurangi dari default */
            }

            .signature-location {
                font-size: 12px;
                /* Dikurangi dari 8px menjadi 7px */
                color: #666;
                font-style: italic;
                margin-bottom: 8px;
                /* Dikurangi dari 15px menjadi 8px */
            }

            .signature-title {
                font-size: 10px;
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
                font-size: 10px;
                /* Dikurangi dari 9px menjadi 8px */
                font-weight: bold;
                color: #1976D2;
            }

            .signature-position {
                font-size: 12px;
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
                    align-items: center !important;
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

                .bottom-section {
                    margin-top: auto;
                    /* ⬅️ Kunci utama agar posisi di akhir halaman */
                }

                .watermark-text {
                    display: none;
                }
            }

            .watermark {
                position: fixed;
                top: 40%;
                left: 42%;
                transform: translate(-50%, -50%);
                opacity: 0.2;
                z-index: 0;
                width: 450px;
                height: auto;
            }
        </style>
    </head>

    <body>
        <?php echo $__env->yieldContent('content'); ?>
    </body>

</html>
<?php /**PATH /Users/macbookair/Documents/mediction/mediction.id/resources/views/layout/receipt/mail-order.blade.php ENDPATH**/ ?>