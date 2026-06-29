<?php
    $personalize = $classes();
?>

<div <?php if(!$delay): ?>
         wire:loading
     <?php else: ?>
         wire:loading.delay<?php echo e(is_string($delay) && $delay !== "1" ? ".{$delay}" : ""); ?>

     <?php endif; ?> <?php if($loading): ?> wire:target="<?php echo e($loading); ?>" <?php endif; ?> <?php echo e($attributes); ?> class="<?php echo \Illuminate\Support\Arr::toCssClasses([
        $configurations['zIndex'],
        $personalize['wrapper.first'],
        $personalize['blur'] => $configurations['blur'] === true,
        $personalize['opacity'] => $configurations['opacity'] === true,
    ]); ?>" x-ref="loading" x-data="tallstackui_loading(<?php echo \Illuminate\Support\Js::from($this->getName())->toHtml() ?>, <?php echo \Illuminate\Support\Js::from($configurations['overflow'] ?? false)->toHtml() ?>)">
    <div class="<?php echo e($personalize['wrapper.second']); ?>">
        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(!$text && empty($slot->toHtml())): ?>
            <?php if (isset($component)) { $__componentOriginal100998c99e03c8e5bcab5165538db40c = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal100998c99e03c8e5bcab5165538db40c = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'tallstack-ui::components.icon.generic.loading','data' => ['class' => ''.e($personalize['spinner']).'']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('tallstack-ui::icon.generic.loading'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['class' => ''.e($personalize['spinner']).'']); ?>
<?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::processComponentKey($component); ?>

<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal100998c99e03c8e5bcab5165538db40c)): ?>
<?php $attributes = $__attributesOriginal100998c99e03c8e5bcab5165538db40c; ?>
<?php unset($__attributesOriginal100998c99e03c8e5bcab5165538db40c); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal100998c99e03c8e5bcab5165538db40c)): ?>
<?php $component = $__componentOriginal100998c99e03c8e5bcab5165538db40c; ?>
<?php unset($__componentOriginal100998c99e03c8e5bcab5165538db40c); ?>
<?php endif; ?>
        <?php else: ?>
            <div class="<?php echo e($personalize['text']); ?>">
                <?php echo $text ?? $slot; ?>

            </div>
        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
    </div>
</div>
<?php /**PATH /Users/macbookair/Documents/mediction/mediction.id/vendor/tallstackui/tallstackui/src/resources/views/components/loading.blade.php ENDPATH**/ ?>