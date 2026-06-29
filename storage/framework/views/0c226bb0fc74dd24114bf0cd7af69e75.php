<?php $attributes ??= new \Illuminate\View\ComponentAttributeBag;

$__newAttributes = [];
$__propNames = \Illuminate\View\ComponentAttributeBag::extractPropNames((['product', 'showPercentage' => true, 'variant' => 'default']));

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

foreach (array_filter((['product', 'showPercentage' => true, 'variant' => 'default']), 'is_string', ARRAY_FILTER_USE_KEY) as $__key => $__value) {
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

<div class="product-discount-display">
    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($priceInfo['has_discount']): ?>
        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($variant === 'compact'): ?>
            <span class="text-red-600 text-sm">
                Rp <?php echo e(number_format($priceInfo['discount_amount'], 0, ',', '.')); ?>

            </span>
        <?php elseif($variant === 'detailed'): ?>
            <div class="flex flex-col">
                <span class="text-red-600 font-medium">
                    Rp <?php echo e(number_format($priceInfo['discount_amount'], 0, ',', '.')); ?>

                </span>
                
            </div>
        <?php elseif($variant === 'final_price'): ?>
            <span class="text-red-600 font-medium">
                Rp <?php echo e(number_format($priceInfo['final_price'], 0, ',', '.')); ?>

            </span>
        <?php else: ?>
            <span class="text-red-600">
                Rp <?php echo e(number_format($priceInfo['discount_amount'], 0, ',', '.')); ?>

                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($showPercentage): ?>
                    <small class="text-gray-500">(<?php echo e($priceInfo['discount_percentage']); ?>%)</small>
                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
            </span>
        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
    <?php else: ?>
        <span class="text-gray-400">-</span>
    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
</div>
<?php /**PATH /Users/macbookair/Documents/mediction/mediction.id/resources/views/components/product-discount.blade.php ENDPATH**/ ?>