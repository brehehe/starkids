<?php $attributes ??= new \Illuminate\View\ComponentAttributeBag;

$__newAttributes = [];
$__propNames = \Illuminate\View\ComponentAttributeBag::extractPropNames((['product', 'showPercentage' => true, 'showSavings' => false, 'variant' => 'default']));

foreach ($attributes->all() as $__key => $__value) {
    if (in_array($__key, $__propNames)) {
        $$__key = $$__key ?? $__value;
    } else {
        $__newAttributes[$__key] = $__value;
    }
}

$attributes = new \Illuminate\View\ComponentAttributeBag($__newAttributes);

unset($__propNames);
unset($__newAttributes);

foreach (array_filter((['product', 'showPercentage' => true, 'showSavings' => false, 'variant' => 'default']), 'is_string', ARRAY_FILTER_USE_KEY) as $__key => $__value) {
    $$__key = $$__key ?? $__value;
}

$__defined_vars = get_defined_vars();

foreach ($attributes->all() as $__key => $__value) {
    if (array_key_exists($__key, $__defined_vars)) unset($$__key);
}

unset($__defined_vars, $__key, $__value); ?>

<?php
    $companyId = auth()->user()->company_id ?? null;
    $priceInfo = \App\Helpers\PromotionHelper::getProductPriceInfo($product->id, $companyId);
?>

<div class="product-price-display">
    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($priceInfo['has_discount']): ?>
        <!-- Product has discount -->
        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($variant === 'compact'): ?>
            <div class="flex items-center space-x-1">
                <span class="text-xs text-gray-500 line-through">
                    Rp <?php echo e(number_format($priceInfo['original_price'], 0, ',', '.')); ?>

                </span>
                <span class="text-red-600 font-medium">
                    Rp <?php echo e(number_format($priceInfo['final_price'], 0, ',', '.')); ?>

                </span>
            </div>
        <?php elseif($variant === 'table'): ?>
            <!-- Khusus untuk tampilan tabel -->
            <div class="flex flex-col">
                <span class="text-xs text-gray-500 line-through">
                    Rp <?php echo e(number_format($priceInfo['original_price'], 0, ',', '.')); ?>

                </span>
                <span class="text-red-600 font-semibold">
                    Rp <?php echo e(number_format($priceInfo['final_price'], 0, ',', '.')); ?>

                </span>
            </div>
        <?php else: ?>
            <div class="flex flex-col">
                <div class="flex items-center space-x-2">
                    <span class="text-sm text-gray-500 line-through">
                        Rp <?php echo e(number_format($priceInfo['original_price'], 0, ',', '.')); ?>

                    </span>
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($showPercentage): ?>
                        <span class="bg-red-100 text-red-800 text-xs px-2 py-0.5 rounded-full">
                            -<?php echo e($priceInfo['discount_percentage']); ?>%
                        </span>
                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                </div>
                <span class="text-red-600 font-semibold">
                    Rp <?php echo e(number_format($priceInfo['final_price'], 0, ',', '.')); ?>

                </span>
                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($showSavings): ?>
                    <small class="text-green-600 text-xs">
                        Hemat: Rp <?php echo e(number_format($priceInfo['discount_amount'], 0, ',', '.')); ?>

                    </small>
                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
            </div>
        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
    <?php else: ?>
        <!-- Product has no discount -->
        <span class="text-gray-900">
            Rp <?php echo e(number_format($priceInfo['original_price'], 0, ',', '.')); ?>

        </span>
    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
</div>
<?php /**PATH /Users/macbookair/Documents/mediction/mediction.id/resources/views/components/product-price.blade.php ENDPATH**/ ?>