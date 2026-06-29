<?php
    Config::set('terbilang.locale', 'id');
?>
<div class="kwitansi-container">
    <div class="content">
        <div class="header">
            <div class="logo-section">
                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(Auth::user()->company->logo): ?>
                    <img src="<?php echo e(asset('storage/' . Auth::user()->company->logo)); ?>" alt="Logo" style="height: 60px;">
                <?php else: ?>
                    <div class="logo-placeholder" style="font-size: 20px; font-weight: bold;"><?php echo e(Auth::user()->company->name); ?></div>
                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                <div class="company-subtitle"><?php echo e(Auth::user()->company->address); ?></div>
            </div>
            <div class="title-section">
                <div class="kwitansi-title">Kwitansi Pembayaran</div>
                <div class="subtitle">Bukti Pembayaran Cicilan / Pelunasan</div>
            </div>
            <div class="invoice-info">
                <div class="invoice-number">No. Kwitansi: <strong>#<?php echo e(strtoupper(substr($payment->id, 0, 8))); ?></strong></div>
                <div>Tanggal: <?php echo e($payment->created_at->format('d/m/Y')); ?></div>
                <div>No. Transaksi: <?php echo e($payment->transaction->code); ?></div>
            </div>
        </div>

        <div class="divider"></div>

        <div class="main-content">
            <div class="receipt-info">
                <div class="info-row">
                    <div class="info-label">Telah terima dari</div>
                    <div class="info-colon">:</div>
                    <div class="info-value font-bold"><?php echo e($payment->transaction->patient_name ?? '-'); ?></div>
                </div>
                <div class="info-row">
                    <div class="info-label">Uang sejumlah</div>
                    <div class="info-colon">:</div>
                    <div class="info-value italic">
                        # <?php echo e(ucwords(Terbilang::make($payment->payment_amount))); ?> Rupiah #
                    </div>
                </div>
                <div class="info-row">
                    <div class="info-label">Untuk pembayaran</div>
                    <div class="info-colon">:</div>
                    <div class="info-value">
                        <?php echo e($payment->description ?: 'Pembayaran Transaksi ' . $payment->transaction->code); ?>

                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($payment->is_down_payment): ?> (Down Payment) <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                    </div>
                </div>
            </div>
        </div>

        <div class="bottom-section" style="margin-top: 20px;">
            <div class="amount-section">
                <div class="amount-label">TOTAL :</div>
                <div class="amount-value">Rp <?php echo number_format($payment->payment_amount, 0, ',', '.'); ?></div>
            </div>
            <div class="signature-section">
                <div class="signature-location"><?php echo e(Auth::user()->company->city ?? 'Indonesia'); ?>, <?php echo e(date('d F Y')); ?></div>
                <div class="signature-company"><?php echo e(Auth::user()->company->name); ?></div>
                <div class="signature-line"></div>
                <div class="signature-name">Kasir: <?php echo e(Auth::user()->name); ?></div>
            </div>
        </div>
    </div>

    <script>
        window.print();
    </script>
</div><?php /**PATH /Users/macbookair/Documents/mediction/mediction.id/resources/views/livewire/admin/sale/pending/print/payment-receipt.blade.php ENDPATH**/ ?>