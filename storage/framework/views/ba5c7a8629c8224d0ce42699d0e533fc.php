<?php
    $personalize = $classes();
?>

<?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($simple): ?>
    <div class="<?php echo e($personalize['simple.wrapper']); ?>">
        <span class="<?php echo e($personalize['simple.base']); ?>" x-text="$store['tsui.side-bar'].open ? <?php echo \Illuminate\Support\Js::from($text ?? $slot)->toHtml() ?> : <?php echo \Illuminate\Support\Js::from(str($text ?? $slot)->limit(5))->toHtml() ?>"></span>
    </div>
<?php elseif($line): ?>
    <div class="<?php echo e($personalize['line.wrapper.first']); ?>">
        <div class="<?php echo e($personalize['line.wrapper.second']); ?>" x-show="$store['tsui.side-bar'].open">
            <div class="<?php echo e($personalize['line.border']); ?>"></div>
        </div>
        <div class="<?php echo e($personalize['line.wrapper.third']); ?>">
            <span class="<?php echo e($personalize['line.base']); ?>" x-text="$store['tsui.side-bar'].open ? <?php echo \Illuminate\Support\Js::from($text ?? $slot)->toHtml() ?> : <?php echo \Illuminate\Support\Js::from(str($text ?? $slot)->limit(5))->toHtml() ?>"></span>
        </div>
    </div>
<?php else: ?>
    <div class="<?php echo e($personalize['line-right.wrapper.first']); ?>">
        <div class="<?php echo e($personalize['line-right.wrapper.second']); ?>" x-show="$store['tsui.side-bar'].open">
            <div class="<?php echo e($personalize['line-right.border']); ?>"></div>
        </div>
        <div class="<?php echo e($personalize['line-right.wrapper.third']); ?>">
            <span class="<?php echo e($personalize['line-right.base']); ?>" x-text="$store['tsui.side-bar'].open ? <?php echo \Illuminate\Support\Js::from($text ?? $slot)->toHtml() ?> : <?php echo \Illuminate\Support\Js::from(str($text ?? $slot)->limit(5))->toHtml() ?>"></span>
        </div>
    </div>
<?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
<?php /**PATH /Users/macbookair/Documents/mediction/mediction.id/vendor/tallstackui/tallstackui/src/resources/views/components/layout/sidebar/separator.blade.php ENDPATH**/ ?>