<?php
    $personalize = $classes();
?>

<div class="<?php echo \Illuminate\Support\Arr::toCssClasses(['relative', $personalize['sizes.circle.' . $size]]); ?>">
    <svg class="h-full w-full"
         width="<?php echo e($sizeCircle); ?>"
         height="<?php echo e($sizeCircle); ?>"
         viewBox="0 0 36 36"
         xmlns="http://www.w3.org/2000/svg">
        <circle cx="18"
                cy="18"
                r="<?php echo e($sizeCircle / 2 - $strokePercent / 2); ?>"
                fill="none"
                class="<?php echo \Illuminate\Support\Arr::toCssClasses(['stroke-current', $personalize['background']]); ?>"
                stroke-width="<?php echo e($strokeCircle); ?>"></circle>
        <g class="origin-center -rotate-90 transform">
            <circle cx="18"
                    cy="18"
                    r="<?php echo e($sizeCircle / 2 - $strokePercent / 2); ?>"
                    fill="none"
                    class="<?php echo \Illuminate\Support\Arr::toCssClasses(['stroke-current', str_replace('bg-', 'text-', $colors['background'])]); ?>"
                    stroke-width="<?php echo e($strokePercent); ?>"
                    stroke-dasharray="100"
                    stroke-dashoffset="<?php echo e(100 - $percent); ?>"></circle>
        </g>
    </svg>
    <div class="<?php echo e($personalize['wrapper']); ?>">
        <span class="<?php echo \Illuminate\Support\Arr::toCssClasses([$personalize['text'], $personalize['sizes.text.' . $size]]); ?>"><?php echo e($percent); ?>%</span>
    </div>
    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($footer): ?>
       <div><?php echo e($footer); ?></div>
    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
</div>
<?php /**PATH /Users/macbookair/Documents/mediction/mediction.id/vendor/tallstackui/tallstackui/src/resources/views/components/progress/circle.blade.php ENDPATH**/ ?>