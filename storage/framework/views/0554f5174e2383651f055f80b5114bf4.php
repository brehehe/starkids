<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ringkasan Transaksi A4</title>
    <style>
        @page {
            size: A4 portrait;
            margin: 15mm;
        }
        body {
            font-family: 'Arial', sans-serif;
            font-size: 12px;
            color: #333;
            line-height: 1.5;
            background: #f0f0f0;
            display: flex;
            justify-content: center;
            padding: 20px;
        }
        .container {
            width: 210mm;
            min-height: 297mm;
            background: #fff;
            padding: 20mm;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
        }
        .header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            border-bottom: 2px solid #1E3A8A;
            padding-bottom: 10px;
            margin-bottom: 20px;
        }
        .logo {
            font-size: 24px;
            font-weight: bold;
            color: #1E3A8A;
        }
        .title {
            text-align: right;
        }
        .title h1 {
            margin: 0;
            font-size: 20px;
            text-transform: uppercase;
        }
        .info-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 40px;
            margin-bottom: 30px;
        }
        .info-box h3 {
            border-bottom: 1px solid #ddd;
            padding-bottom: 5px;
            margin-bottom: 10px;
            color: #1E3A8A;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        th {
            background: #f8fafc;
            text-align: left;
            padding: 10px;
            border-bottom: 2px solid #ddd;
        }
        td {
            padding: 10px;
            border-bottom: 1px solid #eee;
        }
        .text-right { text-align: right; }
        .font-bold { font-weight: bold; }
        .footer {
            margin-top: 50px;
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 100px;
            text-align: center;
        }
        .signature-box {
            margin-top: 60px;
            border-top: 1px solid #333;
            width: 200px;
            margin-left: auto;
            margin-right: auto;
        }
        @media print {
            body { background: none; padding: 0; }
            .container { box-shadow: none; width: 100%; height: auto; padding: 0; }
            .no-print { display: none; }
        }
    </style>
</head>
<body>
    <div class="container">
        <?php echo $__env->yieldContent('content'); ?>
    </div>
    <script>
        window.onload = function() {
            // Optional: window.print();
        }
    </script>
</body>
</html>
<?php /**PATH /Users/macbookair/Documents/mediction/mediction.id/resources/views/layout/receipt/a4.blade.php ENDPATH**/ ?>