<?php
    $personalize = $classes();
?>

<div <?php echo e($attributes->class([
        $personalize['border.base'] => !$borderless && !$model,
        $personalize['border.radius'] => !$square,
        $personalize['wrapper.class'],
        $colors['background'] => !$model,
        $personalize['wrapper.sizes.' . $size],
    ])->except('x-bind:src')); ?>>
    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($model || $image): ?>
        <img class="<?php echo \Illuminate\Support\Arr::toCssClasses([
            $personalize['border.radius'] => !$square,
            $personalize['content.image.class'],
            $personalize['content.image.sizes.' . $size],
        ]); ?>" <?php echo e($attributes->only('x-bind:src')); ?> src="<?php echo e($image ?? $modelable()); ?>" alt="<?php echo e($text ?? $model?->getAttribute($property ?? null)); ?>"/>
    <?php elseif($text || $slot->isNotEmpty()): ?>
        <span class="<?php echo \Illuminate\Support\Arr::toCssClasses([
                $personalize['content.text.class'],
                $personalize['content.text.colors.colorful'] => $color !== 'white',
                $personalize['content.text.colors.white'] => $color === 'white',
            ]); ?>"><?php echo $text ?? $slot; ?></span>
    <?php else: ?>
        <svg class="<?php echo \Illuminate\Support\Arr::toCssClasses([
                $personalize['content.text.class'],
                $personalize['content.text.colors.colorful'] => $color !== 'white',
                $personalize['content.text.colors.white'] => $color === 'white',
            ]); ?>" fill="currentColor" viewBox="0 0 24 24" stroke="currentColor">
            <path d="M24 20.993V24H0v-2.996A14.977 14.977 0 0112.004 15c4.904 0 9.26 2.354 11.996 5.993zM16.002 8.999a4 4 0 11-8 0 4 4 0 018 0z"></path>
        </svg>
    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
</div>
<?php /**PATH /Users/macbookair/Documents/mediction/mediction.id/vendor/tallstackui/tallstackui/src/resources/views/components/avatar.blade.php ENDPATH**/ ?>