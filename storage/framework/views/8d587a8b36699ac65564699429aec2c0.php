<?php
    $personalize = $classes();
?>

<span <?php echo e($attributes->class([
        'rounded-md' => !$round && !$square,
        'rounded-full' => $round,
        $personalize['wrapper.class'],
        $personalize['wrapper.sizes.' . $size],
        $colors['background'],
        $colors['text'],
    ])); ?>>
    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($left): ?>
        <?php echo e($left); ?>

    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
    <?php echo e(__('tallstack-ui::messages.environment.environment')); ?>: <?php echo e(str(app()->environment())->title()); ?>

    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($branch): ?>
        (<?php echo e(__('tallstack-ui::messages.environment.branch')); ?>: <?php if (isset($component)) { $__componentOriginal8be4ae206c32e1dab9a7592241490b13 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal8be4ae206c32e1dab9a7592241490b13 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'tallstack-ui::components.icon.generic.fork','data' => ['class' => 'w-4 h-4']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('tallstack-ui::icon.generic.fork'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['class' => 'w-4 h-4']); ?>
<?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::processComponentKey($component); ?>

<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal8be4ae206c32e1dab9a7592241490b13)): ?>
<?php $attributes = $__attributesOriginal8be4ae206c32e1dab9a7592241490b13; ?>
<?php unset($__attributesOriginal8be4ae206c32e1dab9a7592241490b13); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal8be4ae206c32e1dab9a7592241490b13)): ?>
<?php $component = $__componentOriginal8be4ae206c32e1dab9a7592241490b13; ?>
<?php unset($__componentOriginal8be4ae206c32e1dab9a7592241490b13); ?>
<?php endif; ?> <?php echo e($branch); ?>)
    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($right): ?>
        <?php echo e($right); ?>

    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
</span>
<?php /**PATH /Users/macbookair/Documents/mediction/mediction.id/vendor/tallstackui/tallstackui/src/resources/views/components/environment.blade.php ENDPATH**/ ?>