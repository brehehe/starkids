<?php $attributes ??= new \Illuminate\View\ComponentAttributeBag;

$__newAttributes = [];
$__propNames = \Illuminate\View\ComponentAttributeBag::extractPropNames((['product', 'showOriginal' => true, 'class' => '', 'variant' => 'default']));

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

foreach (array_filter((['product', 'showOriginal' => true, 'class' => '', 'variant' => 'default']), 'is_string', ARRAY_FILTER_USE_KEY) as $__key => $__value) {
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

<div class="discount-price-display <?php echo e($class); ?>">
    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($priceInfo['has_discount']): ?>
        <!-- Product has discount -->
        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($variant === 'inline'): ?>
            <!-- Tampilan horizontal -->
            <div class="flex items-center space-x-2">
                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($showOriginal): ?>
                    <span class="text-xs text-gray-500 line-through">
                        Rp <?php echo e(number_format($priceInfo['original_price'], 0, ',', '.')); ?>

                    </span>
                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                <span class="text-red-600 font-semibold">
                    Rp <?php echo e(number_format($priceInfo['final_price'], 0, ',', '.')); ?>

                </span>
            </div>
        <?php else: ?>
            <!-- Tampilan vertikal (default) -->
            <div class="flex flex-col">
                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($showOriginal): ?>
                    <span class="text-xs text-gray-500 line-through">
                        Rp <?php echo e(number_format($priceInfo['original_price'], 0, ',', '.')); ?>

                    </span>
                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                <span class="text-red-600 font-semibold">
                    Rp <?php echo e(number_format($priceInfo['final_price'], 0, ',', '.')); ?>

                </span>
            </div>
        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
    <?php else: ?>
        <!-- Product has no discount - show original price -->
        <span class="text-gray-900">
            Rp <?php echo e(number_format($priceInfo['original_price'], 0, ',', '.')); ?>

        </span>
    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
</div>
<?php /**PATH /Users/macbookair/Documents/mediction/mediction.id/resources/views/components/discount-price.blade.php ENDPATH**/ ?>