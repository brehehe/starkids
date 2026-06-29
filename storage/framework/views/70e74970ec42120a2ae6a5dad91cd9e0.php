<div>
    <?php
        Config::set('terbilang.locale', 'id');
    ?>
    <div class="kwitansi-container">
        <img src="<?php echo e(Auth::user()->company->logo ? asset('storage/' . Auth::user()->company->logo) : asset('asset/img/logo.png')); ?>"
            class="watermark">
        <div class="content">
            <!-- Header -->
            <div class="header">
                <div class="logo-section">
                    <div class="logo-placeholder">
                        <img src="<?php echo e(Auth::user()->company->logo ? asset('storage/' . Auth::user()->company->logo) : asset('asset/img/logo.png')); ?>"
                            style="width: 60mm; height: 20mm;">
                    </div>
                </div>

                <div class="title-section">
                    <div class="kwitansi-title">KWITANSI PEMBAYARAN</div>
                    <div class="company-subtitle">
                        <?php echo e(config('app.name')); ?>

                    </div>
                    <div class="company-subtitle">
                        <?php echo e(Auth::user()->company->companyDetail->address ?? '-'); ?>

                    </div>
                    <div class="company-subtitle">
                        No Telepon: <?php echo e(Auth::user()->company->phone ?? '-'); ?>

                    </div>
                </div>

                <div class="invoice-info">
                    <div class="invoice-number">No. <?php echo e($transaction->code); ?></div>
                    <div>Tanggal pembayaran</div>
                    <div><?php echo e($transaction->created_at->format('d/m/Y')); ?></div>
                </div>
            </div>

            <!-- Divider -->
            <div class="divider"></div>

            <!-- Main content -->
            <div class="main-content">
                <div class="receipt-info">
                    <div class="info-row">
                        <div class="info-label">Telah Diterima Dari</div>
                        <div class="info-colon">:</div>
                        <div class="info-value">
                            <strong><?php echo e($transaction->patient->name ?? ($transaction->patient_name ?? null)); ?></strong>
                        </div>
                    </div>

                    <div class="info-row">
                        <div class="info-label">Sejumlah Uang</div>
                        <div class="info-colon">:</div>
                        <div class="info-value">
                            <?php echo e(Str::title(Terbilang::make($transaction->grand_total_price))); ?>

                        </div>
                    </div>

                    <div class="info-row">
                        <div class="info-label">Untuk Pembayaran</div>
                        <div class="info-colon">:</div>
                        <div class="info-value"><?php echo e($description); ?></div>
                    </div>

                    <div class="info-row">
                        <div class="info-label">Diagnosa</div>
                        <div class="info-colon">:</div>
                        <div class="info-value">
                            <?php echo e($transactionDiagnosas?->assessment ?? ($transaction->diagnosis ?? '-')); ?>

                        </div>
                    </div>

                    <div class="info-row">
                        <div class="info-label">Imunisasi</div>
                        <div class="info-colon">:</div>
                        <div class="info-value"><?php echo e($transaction->immunization ?? '-'); ?></div>
                    </div>
                </div>

            </div>

            <!-- Bottom section -->
            <div class="bottom-section">
                <div class="amount-section">
                    <div class="amount-label">Nominal</div>
                    <div class="info-colon">:</div>
                    <div class="amount-value">Rp.
                        <?php echo e(number_format($transaction->grand_total_price, 0, ',', '.')); ?>

                    </div>
                </div>

                <div class="signature-section">
                    <div class="signature-location">Surabaya,
                        <?php echo e(\Carbon\Carbon::now()->locale('id')->translatedFormat('d F Y')); ?>

                    </div>
                    <div class="signature-line"></div>
                    <div class="signature-company"><?php echo e(config('app.name')); ?></div>
                </div>
            </div>
        </div>
    </div>
</div><?php /**PATH /Users/macbookair/Documents/mediction/mediction.id/resources/views/livewire/admin/receipt/receipt/admin-receipt-receipt-index.blade.php ENDPATH**/ ?>