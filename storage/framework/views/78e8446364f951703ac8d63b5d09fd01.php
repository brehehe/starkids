<div id="invoice">
    <div class="logo-section">
        <div class="store-name"><?php echo e(Auth::user()->company->name); ?></div>
        <div class="store-info">
            <div class="store-info-line"><?php echo e(Auth::user()->company->companyDetail->address); ?></div>
            <div class="store-info-line"><?php echo e(Auth::user()->company->companyDetail->city); ?></div>
            <div class="store-info-line"><?php echo e(Auth::user()->company->companyDetail->province); ?></div>
            
        </div>
    </div>
    <!-- Info Section -->
    <div class="info-section">
        <div class="info-row">
            <span class="label">No. Invoice</span>
            <span class="value"><?php echo e($transaction->code); ?></span>
        </div>
        <div class="info-row">
            <span class="label">Tanggal</span>
            <span class="value"><?php echo e($transaction->created_at->format('d/m/Y')); ?></span>
        </div>
        <div class="info-row">
            <span class="label">Waktu</span>
            <span class="value"><?php echo e($transaction->created_at->format('H:i:s')); ?></span>
        </div>
        <div class="info-row">
            <span class="label">Kasir</span>
            <span class="value"><?php echo e($transaction->cashier_name ?? '-'); ?></span>
        </div>
        <div class="info-row">
            <span class="label">Pelanggan</span>
            <span class="value"><?php echo e($transaction->patient->name ?? ($transaction->patient_name ?? 'Umum')); ?></span>
        </div>
        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(isset($transaction->doctor_name)): ?>
            <div class="info-row">
                <span class="label">Dokter</span>
                <span class="value"><?php echo e($transaction->doctor_name); ?></span>
            </div>
        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
    </div>

    <!-- Transaction Details -->
    <div class="transaction-section">
        <div class="section-title">DETAIL TRANSAKSI</div>
        <div class="transaction-list">
            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__currentLoopData = $transaction->transactionDetails->whereNull('transaction_detail_id')->whereIn('type_transaction', ['medicine', 'action', 'other']); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoopIteration(); ?><?php endif; ?>
                <div class="transaction-item">
                    <span class="item-name"><?php echo e($item->product->name ?? $item->name); ?></span>
                    <span class="item-total"><?php echo e(number_format($item->sub_total_price, 0, ',', '.')); ?></span>
                </div>

                <?php
                    $transactionDetails = App\Models\Transaction\TransactionDetail::where(
                        'transaction_id',
                        $transaction->id,
                    )
                        ->where('transaction_detail_id', $item->id)
                        ->get();
                ?>

                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__currentLoopData = $transactionDetails; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $detail): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoopIteration(); ?><?php endif; ?>
                    <div class="transaction-item sub-item">
                        <span class="item-name">- <?php echo e($detail->product->name ?? $detail->name); ?></span>
                        <span class="item-total"><?php echo e(number_format($detail->sub_total_price, 0, ',', '.')); ?></span>
                    </div>
                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>

            <?php
                $totalPriveService = App\Models\Transaction\TransactionRecipe::where('transaction_id', $transaction->id)
                    ->selectRaw('COALESCE(SUM(price_service_one + price_service_other + sub_total_price), 0) as total')
                    ->value('total');
                $transactionRecipes = App\Models\Transaction\TransactionRecipe::where(
                    'transaction_id',
                    $transaction->id,
                )->get();
            ?>

            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__currentLoopData = $transaction->transactionRecipes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key_recipe => $recipe): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoopIteration(); ?><?php endif; ?>
                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($recipe->transactionDetail->count() > 1): ?>
                    <div class="transaction-item">
                        <span class="item-name">/R<?php echo e($key_recipe + 1); ?></span>
                    </div>
                    <div class="transaction-item">
                        <span class="item-name">
                            <?php echo e($recipe?->notes && trim($recipe->notes) !== '' ? $recipe->notes : '.............................'); ?>

                        </span>
                        <span class="item-total">
                            <?php echo e(number_format(
                                $recipe->price_service_one +
                                    $recipe->price_service_other +
                                    $recipe->sub_total_price +
                                    $recipe->transactionDetail->sum('sub_total_price'),
                                0,
                                ',',
                                '.',
                            )); ?>

                        </span>
                    </div>
                <?php else: ?>
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__currentLoopData = $recipe->transactionDetail; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $i => $detail): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoopIteration(); ?><?php endif; ?>
                        <div class="transaction-item">
                            <span class="item-name"><?php echo e($detail->product->name ?? $detail->name); ?></span>
                            <span class="item-total">
                                <?php echo e(number_format(
                                    $recipe->price_service_one + $recipe->price_service_other + $recipe->sub_total_price + $detail->sub_total_price,
                                    0,
                                    ',',
                                    '.',
                                )); ?>

                            </span>
                        </div>
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>

            
        </div>
    </div>

    <!-- Summary Section -->
    <div class="summary-section">
        
        <div class="summary-row">
            <span class="label">Pembulatan</span>
            <span class="value"><?php echo e(number_format($transaction->rounding, 0, ',', '.')); ?></span>
        </div>
        <div class="summary-row">
            <span class="label">Diskon</span>
            <span
                class="value"><?php echo e(number_format($transaction->promotion_real + $transaction->discount_value, 0, ',', '.')); ?></span>
        </div>
        <div class="summary-row total">
            <span class="label">Grand Total</span>
            <span class="value"><?php echo e(number_format($transaction->grand_total_price_admin_fee, 0, ',', '.')); ?></span>
        </div>
        <div class="summary-row">
            <span class="label">Bayar</span>
            <span class="value"><?php echo e(number_format($transaction->payment_amount, 0, ',', '.')); ?></span>
        </div>
        <div class="summary-row">
            <span class="label">Kembalian</span>
            <span class="value"><?php echo e(number_format($transaction->payment_change, 0, ',', '.')); ?></span>
        </div>
    </div>
    <div class="footer">
        <div class="footer-line">Terima kasih atas kunjungan Anda!</div>
        <div class="footer-line">Obat yang dibeli tidak dapat dikembalikan</div>
        <div class="footer-line">Gunakan sesuai petunjuk Apoteker</div>
        <div class="footer-line">Simpan di tempat sejuk & kering</div>
    </div>
</div>
<?php /**PATH /Users/macbookair/Documents/mediction/mediction.id/resources/views/print/invoice.blade.php ENDPATH**/ ?>