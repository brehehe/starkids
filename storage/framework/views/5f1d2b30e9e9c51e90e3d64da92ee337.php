<?php
    Config::set('terbilang.locale', 'id');
?>
<div class="content">
    <div class="header">
        <div class="logo">
            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(Auth::user()->company->logo): ?>
                <img src="<?php echo e(asset('storage/' . Auth::user()->company->logo)); ?>" alt="Logo" style="height: 50px;">
            <?php else: ?>
                <?php echo e(Auth::user()->company->name); ?>

            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
        </div>
        <div class="title">
            <h1>Ringkasan Transaksi</h1>
            <p>No. Transaksi: <strong><?php echo e($transaction->code); ?></strong></p>
            <p>Tanggal: <?php echo e($transaction->created_at->format('d/m/Y H:i')); ?></p>
        </div>
    </div>

    <div class="info-grid">
        <div class="info-box">
            <h3>Informasi Pasien</h3>
            <p><strong>Nama:</strong> <?php echo e($transaction->patient_name ?? '-'); ?></p>
            <p><strong>No. Member:</strong> <?php echo e($transaction->patient?->member_id ?? '-'); ?></p>
            <p><strong>No. Telepon:</strong> <?php echo e($transaction->patient?->phone ?? '-'); ?></p>
            <p><strong>Alamat:</strong> <?php echo e($transaction->patient?->address ?? '-'); ?></p>
        </div>
        <div class="info-box">
            <h3>Status Pembayaran</h3>
            <p><strong>Metode:</strong> <?php echo e($transaction->paymentMethod?->name ?? 'Mixed/Pending'); ?></p>
            <p><strong>Status:</strong> 
                <span style="text-transform: uppercase; font-weight: bold; color: <?php echo e($transaction->status_payment == 'paid' ? '#059669' : '#DC2626'); ?>">
                    <?php echo e($transaction->status_payment); ?>

                </span>
            </p>
            <p><strong>Tenor:</strong> <?php echo e($transaction->installment_count ? $transaction->installment_count . 'x (' . $transaction->installment_period . ')' : '-'); ?></p>
        </div>
    </div>

    <h3>Rincian Item</h3>
    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Item / Layanan</th>
                <th class="text-right">Harga Satuan</th>
                <th class="text-right">Qty</th>
                <th class="text-right">Subtotal</th>
            </tr>
        </thead>
        <tbody>
            <?php $no = 1; ?>
            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__currentLoopData = $transaction->transactionDetails; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $detail): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoopIteration(); ?><?php endif; ?>
                <tr>
                    <td><?php echo e($no++); ?></td>
                    <td><?php echo e($detail->name ?? $detail->product?->name ?? 'Item Unknown'); ?></td>
                    <td class="text-right">Rp <?php echo number_format($detail->price, 0, ',', '.'); ?></td>
                    <td class="text-right"><?php echo e($detail->quantity); ?></td>
                    <td class="text-right">Rp <?php echo number_format($detail->total_price, 0, ',', '.'); ?></td>
                </tr>
            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__currentLoopData = $transaction->transactionRecipes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $recipe): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoopIteration(); ?><?php endif; ?>
                <tr>
                    <td><?php echo e($no++); ?></td>
                    <td>Resep: <?php echo e($recipe->product?->name ?? 'Obat'); ?></td>
                    <td class="text-right">Rp <?php echo number_format($recipe->price, 0, ',', '.'); ?></td>
                    <td class="text-right"><?php echo e($recipe->quantity); ?></td>
                    <td class="text-right">Rp <?php echo number_format($recipe->total_price, 0, ',', '.'); ?></td>
                </tr>
            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
        </tbody>
        <tfoot>
            <tr>
                <td colspan="4" class="text-right font-bold">Total Tagihan</td>
                <td class="text-right font-bold">Rp <?php echo number_format($transaction->grand_total_price, 0, ',', '.'); ?></td>
            </tr>
            <tr>
                <td colspan="4" class="text-right font-bold text-green-600">Total Terbayar</td>
                <td class="text-right font-bold text-green-600">Rp <?php echo number_format($transaction->payment_amount, 0, ',', '.'); ?></td>
            </tr>
            <tr>
                <td colspan="4" class="text-right font-bold text-red-600">Sisa Tagihan</td>
                <td class="text-right font-bold text-red-600">Rp <?php echo number_format($transaction->remaining_bill, 0, ',', '.'); ?></td>
            </tr>
        </tfoot>
    </table>

    <div style="page-break-inside: avoid;">
        <h3>Rencana Cicilan</h3>
        <table>
            <thead>
                <tr>
                    <th class="w-1 text-center">Tenor</th>
                    <th>Jatuh Tempo</th>
                    <th class="text-right">Nominal</th>
                    <th class="text-center">Status</th>
                </tr>
            </thead>
            <tbody>
                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__currentLoopData = $transaction->transactionInstallments; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $installment): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoopIteration(); ?><?php endif; ?>
                    <tr>
                        <td class="text-center"><?php echo e($installment->tenor); ?></td>
                        <td><?php echo e(\Carbon\Carbon::parse($installment->due_date)->format('d/m/Y')); ?></td>
                        <td class="text-right">Rp <?php echo number_format($installment->amount, 0, ',', '.'); ?></td>
                        <td class="text-center"><?php echo e(strtoupper($installment->status)); ?></td>
                    </tr>
                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
            </tbody>
        </table>
    </div>

    <div style="page-break-inside: avoid;">
        <h3>Histori Pembayaran</h3>
        <table>
            <thead>
                <tr>
                    <th>Tanggal</th>
                    <th>Metode</th>
                    <th class="text-right">Nominal</th>
                    <th>Catatan</th>
                </tr>
            </thead>
            <tbody>
                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__currentLoopData = $transaction->transactionPayments; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $payment): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoopIteration(); ?><?php endif; ?>
                    <tr>
                        <td><?php echo e($payment->created_at->format('d/m/Y H:i')); ?></td>
                        <td><?php echo e($payment->paymentMethod?->name ?? '-'); ?> <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($payment->is_down_payment): ?> (DP) <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?></td>
                        <td class="text-right">Rp <?php echo number_format($payment->payment_amount, 0, ',', '.'); ?></td>
                        <td><?php echo e($payment->description ?? '-'); ?></td>
                    </tr>
                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
            </tbody>
        </table>
    </div>

    <div class="footer">
        <div>
            <p>Pasien / Keluarga</p>
            <div class="signature-box"></div>
            <p>(<?php echo e($transaction->patient_name ?? '................................'); ?>)</p>
        </div>
        <div>
            <p><?php echo e(Auth::user()->company->city ?? 'Indonesia'); ?>, <?php echo e(date('d/m/Y')); ?></p>
            <p>Petugas Klinik</p>
            <div class="signature-box"></div>
            <p>(<?php echo e(Auth::user()->name); ?>)</p>
        </div>
    </div>

    <div class="no-print" style="margin-top: 30px; text-align: center;">
        <button onclick="window.print()" style="padding: 10px 20px; background: #1E3A8A; color: #fff; border: none; border-radius: 5px; cursor: pointer;">
            Cetak Dokumen
        </button>
    </div>
</div>

<script>
    window.print();
</script><?php /**PATH /Users/macbookair/Documents/mediction/mediction.id/resources/views/livewire/admin/sale/pending/print/transaction-a4.blade.php ENDPATH**/ ?>