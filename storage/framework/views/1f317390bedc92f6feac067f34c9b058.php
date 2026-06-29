<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Slip Gaji - <?php echo e($payroll->user->name ?? 'Pegawai'); ?></title>
    <style>
        body {
            font-family: 'Helvetica', 'Arial', sans-serif;
            font-size: 12px;
            line-height: 1.5;
            color: #333;
        }
        .header {
            text-align: center;
            border-bottom: 2px solid #1E3A8A;
            padding-bottom: 15px;
            margin-bottom: 20px;
        }
        .header h1 {
            color: #1E3A8A;
            margin: 0;
            font-size: 24px;
        }
        .header p {
            margin: 5px 0 0;
            color: #666;
        }
        .info-table {
            width: 100%;
            margin-bottom: 25px;
        }
        .info-table td {
            padding: 5px;
            vertical-align: top;
        }
        .info-label {
            width: 120px;
            font-weight: bold;
            color: #555;
        }
        .section-title {
            font-size: 14px;
            font-weight: bold;
            color: #1E3A8A;
            margin-bottom: 10px;
            padding-bottom: 5px;
            border-bottom: 1px solid #ddd;
        }
        .grid {
            width: 100%;
            border-collapse: separate;
            border-spacing: 15px 0;
        }
        .col {
            width: 50%;
            vertical-align: top;
        }
        .details-table {
            width: 100%;
            border-collapse: collapse;
        }
        .details-table td {
            padding: 8px 0;
            border-bottom: 1px dashed #eee;
        }
        .details-table .amount {
            text-align: right;
            font-weight: bold;
        }
        .total-row {
            font-weight: bold;
            color: #1E3A8A;
        }
        .total-row td {
            border-bottom: 1px solid #ddd;
            border-top: 1px solid #ddd;
            padding: 10px 0;
        }
        .net-salary-box {
            margin-top: 30px;
            background-color: #f0f4f8;
            border-left: 5px solid #1E3A8A;
            padding: 20px;
            text-align: center;
        }
        .net-salary-label {
            font-size: 14px;
            font-weight: bold;
            color: #555;
            margin-bottom: 10px;
        }
        .net-salary-amount {
            font-size: 28px;
            font-weight: bold;
            color: #1E3A8A;
        }
        .footer {
            margin-top: 50px;
            width: 100%;
            text-align: right;
            color: #666;
        }
        .signature-box {
            display: inline-block;
            text-align: center;
            width: 200px;
        }
        .signature-line {
            border-top: 1px solid #333;
            margin-top: 60px;
            padding-top: 5px;
            font-weight: bold;
        }
    </style>
</head>
<body>

    <div class="header">
        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($payroll->company->logo_url): ?>
            <img src="<?php echo e(public_path('storage/'.$payroll->company->logo_url)); ?>" alt="Logo" style="max-height: 50px; margin-bottom: 10px;">
        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
        <h1>SLIP GAJI</h1>
        <p><strong><?php echo e($payroll->company->name ?? 'Perusahaan'); ?></strong></p>
    </div>

    <table class="info-table">
        <tr>
            <td class="info-label">Bulan/Tahun</td>
            <td>: <?php echo e(\Carbon\Carbon::parse($payroll->period)->translatedFormat('F Y')); ?></td>
            <td class="info-label">Nomor Induk</td>
            <td>: <?php echo e($payroll->user->userDetail->identity_card ?? '-'); ?></td>
        </tr>
        <tr>
            <td class="info-label">Nama Pegawai</td>
            <td>: <strong><?php echo e($payroll->user->name ?? '-'); ?></strong></td>
        </tr>
    </table>

    <div class="section-title" style="font-size: 16px;">Gaji Pokok Dasar: <span>Rp <?php echo e(number_format($payroll->basic_salary, 0, ',', '.')); ?></span></div>

    <table class="grid">
        <tr>
            <td class="col">
                <div class="section-title">Penerimaan (+)</div>
                <table class="details-table">
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__empty_1 = true; $__currentLoopData = $payroll->details->where('type', 'allowance'); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $detail): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoopIteration(); ?><?php endif; ?>
                    <tr>
                        <td><?php echo e($detail->name); ?></td>
                        <td class="amount">Rp <?php echo e(number_format($detail->amount, 0, ',', '.')); ?></td>
                    </tr>
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
                    <tr>
                        <td colspan="2" style="font-style: italic; color: #999;">Tidak ada penambahan.</td>
                    </tr>
                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                    <tr class="total-row">
                        <td>Total Penerimaan</td>
                        <td class="amount" style="color: green;">Rp <?php echo e(number_format($payroll->total_allowance, 0, ',', '.')); ?></td>
                    </tr>
                </table>
            </td>
            <td class="col">
                <div class="section-title" style="color: darkred;">Mendapatkan Potongan (-)</div>
                <table class="details-table">
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__empty_1 = true; $__currentLoopData = $payroll->details->where('type', 'deduction'); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $detail): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoopIteration(); ?><?php endif; ?>
                    <tr>
                        <td><?php echo e($detail->name); ?></td>
                        <td class="amount">Rp <?php echo e(number_format($detail->amount, 0, ',', '.')); ?></td>
                    </tr>
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
                    <tr>
                        <td colspan="2" style="font-style: italic; color: #999;">Tidak ada potongan.</td>
                    </tr>
                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                    <tr class="total-row">
                        <td>Total Potongan</td>
                        <td class="amount" style="color: darkred;">Rp <?php echo e(number_format($payroll->total_deduction, 0, ',', '.')); ?></td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>

    <div class="net-salary-box">
        <div class="net-salary-label">GAJI BERSIH (TAKE HOME PAY)</div>
        <div class="net-salary-amount">Rp <?php echo e(number_format($payroll->net_salary, 0, ',', '.')); ?></div>
    </div>

    <div class="footer">
        <div class="signature-box">
            <div>Mengetahui,</div>
            <div style="font-size: 10px; margin-top: 5px; color: #999;">HR / Keuangan</div>
            <div class="signature-line"><?php echo e($payroll->company->name ?? 'Manajemen'); ?></div>
        </div>
    </div>

</body>
</html>
<?php /**PATH /Users/macbookair/Documents/mediction/mediction.id/resources/views/pdf/slip-gaji.blade.php ENDPATH**/ ?>