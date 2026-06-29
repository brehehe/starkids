<?php
    $personalize = $classes();
?>

<div x-data="tallstackui_carousel(<?php echo \Illuminate\Support\Js::from($images)->toHtml() ?>, <?php echo \Illuminate\Support\Js::from($cover)->toHtml() ?>, <?php echo \Illuminate\Support\Js::from($autoplay)->toHtml() ?>, <?php echo \Illuminate\Support\Js::from($interval)->toHtml() ?>, <?php echo \Illuminate\Support\Js::from($withoutLoop)->toHtml() ?>, <?php echo \Illuminate\Support\Js::from($shuffle)->toHtml() ?>)"
     <?php echo e($attributes->only(['x-on:next', 'x-on:previous'])); ?>

     x-ref="carousel">
    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($header): ?>
        <?php echo e($header); ?>

    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
    <div class="<?php echo e($personalize['wrapper.first']); ?>">
        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(!$autoplay): ?>
            <button type="button"
                    class="<?php echo e($personalize['buttons.left.base']); ?>"
                    dusk="tallstackui_carousel_previous"
                    x-on:click="previous()">
                <?php if (isset($component)) { $__componentOriginal511d4862ff04963c3c16115c05a86a9d = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal511d4862ff04963c3c16115c05a86a9d = $attributes; } ?>
<?php $component = Illuminate\View\DynamicComponent::resolve(['component' => TallStackUi::prefix('icon')] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('dynamic-component'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\DynamicComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['icon' => TallStackUi::icon('chevron-left'),'internal' => true,'class' => ''.e($personalize['buttons.left.icon.size']).'']); ?>
<?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::processComponentKey($component); ?>

<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal511d4862ff04963c3c16115c05a86a9d)): ?>
<?php $attributes = $__attributesOriginal511d4862ff04963c3c16115c05a86a9d; ?>
<?php unset($__attributesOriginal511d4862ff04963c3c16115c05a86a9d); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal511d4862ff04963c3c16115c05a86a9d)): ?>
<?php $component = $__componentOriginal511d4862ff04963c3c16115c05a86a9d; ?>
<?php unset($__componentOriginal511d4862ff04963c3c16115c05a86a9d); ?>
<?php endif; ?>
            </button>
            <button type="button"
                    class="<?php echo e($personalize['buttons.right.base']); ?>"
                    dusk="tallstackui_carousel_next"
                    x-on:click="next()">
                <?php if (isset($component)) { $__componentOriginal511d4862ff04963c3c16115c05a86a9d = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal511d4862ff04963c3c16115c05a86a9d = $attributes; } ?>
<?php $component = Illuminate\View\DynamicComponent::resolve(['component' => TallStackUi::prefix('icon')] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('dynamic-component'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\DynamicComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['icon' => TallStackUi::icon('chevron-right'),'internal' => true,'class' => ''.e($personalize['buttons.right.icon.size']).'']); ?>
<?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::processComponentKey($component); ?>

<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal511d4862ff04963c3c16115c05a86a9d)): ?>
<?php $attributes = $__attributesOriginal511d4862ff04963c3c16115c05a86a9d; ?>
<?php unset($__attributesOriginal511d4862ff04963c3c16115c05a86a9d); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal511d4862ff04963c3c16115c05a86a9d)): ?>
<?php $component = $__componentOriginal511d4862ff04963c3c16115c05a86a9d; ?>
<?php unset($__componentOriginal511d4862ff04963c3c16115c05a86a9d); ?>
<?php endif; ?>
            </button>
        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
        <div class="<?php echo \Illuminate\Support\Arr::toCssClasses([
            $personalize['wrapper.second'],
            'min-h-[50svh]' => is_null($wrapper),
            $wrapper => ! is_null($wrapper),
        ]); ?>">
            <template x-for="(image, index) in images" :key="index">
                <div x-show="current == index + 1" class="<?php echo e($personalize['images.wrapper.first']); ?>" x-transition.opacity.duration.1000ms>
                    <a x-bind:href="image.url ?? null" x-bind:target="image.target">
                        <template x-if="image.title">
                            <div class="<?php echo \Illuminate\Support\Arr::toCssClasses([$personalize['images.wrapper.second'], 'rounded-xl' => $round]); ?>">
                                <h3 class="<?php echo e($personalize['images.content.title']); ?>" x-text="image.title"></h3>
                                <p class="<?php echo e($personalize['images.content.description']); ?>" x-text="image.description"></p>
                            </div>
                        </template>
                        <img class="<?php echo \Illuminate\Support\Arr::toCssClasses([$personalize['images.base'], 'rounded-xl' => $round]); ?>"
                             x-bind:src="image.src"
                             x-bind:alt="image.alt"
                             <?php if($autoplay && $stopOnHover): ?>
                                 x-on:mouseover="(paused = !paused), reset()"
                             x-on:mouseleave="(paused = !paused), reset()"
                                <?php endif; ?> />
                    </a>
                </div>
            </template>
        </div>
        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(!$withoutIndicators): ?>
            <div class="<?php echo e($personalize['indicators.wrapper']); ?>">
                <template x-for="(image, index) in images">
                    <button class="<?php echo e($personalize['indicators.buttons.base']); ?>"
                            x-on:click="(current = index + 1), reset()"
                            x-bind:class="[
                                current === index + 1 ? '<?php echo e($personalize['indicators.buttons.current']); ?>' : '<?php echo e($personalize['indicators.buttons.inactive']); ?>'
                            ]"></button>
                </template>
            </div>
        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
    </div>
    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($footer): ?>
        <?php echo e($footer); ?>

    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
</div>
<?php /**PATH /Users/macbookair/Documents/mediction/mediction.id/vendor/tallstackui/tallstackui/src/resources/views/components/carousel.blade.php ENDPATH**/ ?>