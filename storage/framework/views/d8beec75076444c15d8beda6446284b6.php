<!DOCTYPE html>
<html lang="id">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Kwitansi Pembayaran LJN</title>
        <style>
            * {
                margin: 0;
                padding: 0;
                box-sizing: border-box;
            }

            body {
                font-family: 'Times New Roman', serif;
                font-size: 12px;
                line-height: 1.4;
                color: #000;
                background: #f0f0f0;
                display: flex;
                justify-content: center;
                align-items: center;
                min-height: 100vh;
            }

            .kwitansi-container {
                width: 210mm;
                height: 146mm;
                background: #fff;
                padding: 10mm;
                box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
                border-radius: 8px;
                position: relative;
            }

            .content {
                height: 100%;
                display: flex;
                flex-direction: column;
            }

            /* Header */
            .header {
                display: grid;
                grid-template-columns: 120px 1fr 120px;
                align-items: start;
                margin-bottom: 15px;
                gap: 20px;
            }

            .logo-section {
                margin-left: 100px;
                display: flex;
                flex-direction: column;
                align-items: center;
            }

            .company-subtitle {
                font-size: 10px;
                text-align: center;
                color: black;
                line-height: 1.2;
            }

            .title-section {
                margin-left: 50px;
                text-align: center;
                padding-top: 10px;
            }

            .kwitansi-title {
                font-size: 16px;
                font-weight: bold;
                letter-spacing: 2px;
                margin-bottom: 5px;
                text-transform: uppercase;
            }

            .subtitle {
                font-size: 14px;
                color: #333;
            }

            .invoice-info {
                text-align: right;
                font-size: 11px;
                line-height: 1.3;
                padding-top: 5px;
            }

            .invoice-info div {
                margin-bottom: 2px;
            }

            .invoice-number {
                font-weight: bold;
            }

            /* Divider */
            .divider {
                width: 100%;
                height: 1px;
                background: #000;
                margin: 15px 0;
            }

            /* Main content */
            .main-content {
                flex: 1;
                display: flex;
                flex-direction: column;
                gap: 15px;
            }

            .receipt-info {
                display: flex;
                flex-direction: column;
                gap: 8px;
            }

            .info-row {
                display: flex;
                align-items: flex-start;
                gap: 15px;
            }

            .info-label {
                width: 200px;
                font-size: 18px;
                color: #333;
            }

            .info-colon {
                width: 10px;
                font-size: 18px;
            }

            .info-value {
                flex: 1;
                font-size: 18px;
                line-height: 1.4;
            }


            /* Bottom section */
            .bottom-section {
                margin-top: auto;
                display: grid;
                grid-template-columns: 1fr 1fr;
                gap: 40px;
                align-items: end;
            }

            .amount-section {
                display: flex;
                align-items: center;
                gap: 15px;
            }

            .amount-label {
                font-size: 15px;
                color: #333;
            }

            .amount-value {
                font-size: 25px;
                font-weight: bold;
                color: #000;
                border: #000 1px solid;
                padding: 10px;
            }

            .signature-section {
                text-align: center;
            }

            .signature-location {
                font-size: 12px;
                margin-bottom: 50px;
                color: #666;
            }

            .signature-company {
                font-size: 12px;
                font-weight: bold;
                color: #000;
            }

            .signature-line {
                width: 150px;
                height: 1px;
                background: #000;
                margin: 40px auto 10px;
            }

            .watermark {
                position: fixed;
                top: 50%;
                left: 42%;
                transform: translate(-50%, -50%);
                opacity: 0.1;
                z-index: 0;
                width: 450px;
                height: auto;
            }

            /* Print styles */
            @media print {
                @page {
                    size: A5 landscape;
                    margin: 1mm;
                    /* Dikurangi dari 10mm menjadi 8mm */
                }

                body {
                    margin: 0;
                    padding: 0;
                    background: #fff;
                }

                .kwitansi-container {
                    box-shadow: none;
                    border-radius: 0;
                    /* page-break-inside: avoid; */
                }
            }
        </style>
    </head>

    <body>
        <?php echo $__env->yieldContent('content'); ?>
    </body>

</html>
<?php /**PATH /Users/macbookair/Documents/mediction/mediction.id/resources/views/layout/receipt/receipt.blade.php ENDPATH**/ ?>