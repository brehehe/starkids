<?php
    $personalize = $classes();
?>

<div x-cloak
     <?php if($wire): ?>
         x-data="tallstackui_slide(<?php if ((object) ($entangle) instanceof \Livewire\WireDirective) : ?>window.Livewire.find('<?php echo e($__livewire->getId()); ?>').entangle('<?php echo e($entangle->value()); ?>')<?php echo e($entangle->hasModifier('live') ? '.live' : ''); ?><?php else : ?>window.Livewire.find('<?php echo e($__livewire->getId()); ?>').entangle('<?php echo e($entangle); ?>')<?php endif; ?>, <?php echo \Illuminate\Support\Js::from($configurations['overflow'] ?? false)->toHtml() ?>)"
     <?php else: ?>
         x-data="tallstackui_slide(false, <?php echo \Illuminate\Support\Js::from($configurations['overflow'] ?? false)->toHtml() ?>)"
     <?php endif; ?>
     x-show="show"
     <?php if(!$configurations['persistent']): ?> x-on:keydown.escape.window="top_ui && (show = false)" <?php endif; ?>
     x-on:slide:<?php echo e($open); ?>.window="show = true;"
     x-on:slide:<?php echo e($close); ?>.window="show = false;"
     class="<?php echo \Illuminate\Support\Arr::toCssClasses(['relative', $configurations['zIndex']]); ?>"
     <?php echo e($attributes->whereStartsWith('x-on:')); ?>>
    <div x-show="show"
         x-transition:enter="ease-in-out duration-300"
         x-transition:enter-start="opacity-0"
         x-transition:enter-end="opacity-100"
         x-transition:leave="ease-in-out duration-200"
         x-transition:leave-start="opacity-100"
         x-transition:leave-end="opacity-0"
         class="<?php echo \Illuminate\Support\Arr::toCssClasses([$personalize['wrapper.first'], $personalize['blur.'.($configurations['blur'] === true ? 'sm' : $configurations['blur'])] ?? null => $configurations['blur']]); ?>"></div>
    <div class="<?php echo e($personalize['wrapper.second']); ?>">
        <div class="<?php echo e($personalize['wrapper.third']); ?>">
            <div class="<?php echo \Illuminate\Support\Arr::toCssClasses([
                    $personalize['wrapper.fourth'],
                    'inset-y-0' => !$configurations['bottom'],
                    'bottom-0' => $configurations['bottom'],
                    'left-0' => $configurations['left'],    
                    'pr-10' => $configurations['left'] && $configurations['size'] !== 'full',
                    'right-0' => $configurations['left'] === false,
                    'pl-10' =>
                        $configurations['left'] === false &&
                        $configurations['size'] !== 'full' &&
                        $configurations['top'] === false && 
                        $configurations['bottom'] === false,
                    $configurations['size'] => $configurations['top'] || $configurations['bottom'],
                    'h-full' => !$configurations['top'] || !$configurations['bottom'],
                    'w-[100dvw]' => $configurations['top'] || $configurations['bottom'],
                ]); ?>">
                <div x-show="show"
                    x-transition:enter="transform transition ease-in-out duration-700"
                    x-transition:enter-start="<?php if($configurations['left']): ?> -translate-x-full <?php elseif($configurations['top']): ?> -translate-y-full <?php elseif($configurations['bottom']): ?> translate-y-full <?php else: ?> translate-x-full <?php endif; ?>"
                    x-transition:enter-end="<?php if($configurations['left']): ?> translate-x-0 <?php elseif($configurations['top']): ?> translate-y-0 <?php elseif($configurations['bottom']): ?> translate-y-0 <?php else: ?> translate-x-0 <?php endif; ?>"
                    x-transition:leave="transform transition ease-in-out duration-700"
                    x-transition:leave-start="<?php if($configurations['left']): ?> translate-x-0 <?php elseif($configurations['top']): ?> translate-y-0 <?php elseif($configurations['bottom']): ?> translate-y-0 <?php else: ?> translate-x-0 <?php endif; ?>"
                    x-transition:leave-end="<?php if($configurations['left']): ?> -translate-x-full <?php elseif($configurations['top']): ?> -translate-y-full <?php elseif($configurations['bottom']): ?> translate-y-full <?php else: ?> translate-x-full <?php endif; ?>"
                     class="<?php echo \Illuminate\Support\Arr::toCssClasses(['pointer-events-auto w-screen', $configurations['size'],  'h-full' => !$configurations['top'] || !$configurations['bottom']]); ?>"
                     <?php if(!$configurations['persistent']): ?> x-on:mousedown.away="top_ui && (show = false)" <?php endif; ?>>
                    <div class="<?php echo \Illuminate\Support\Arr::toCssClasses([
                            $personalize['wrapper.fifth'], 
                            $configurations['size'],
                            'h-full' => !$configurations['top'] || !$configurations['bottom']
                        ]); ?>">
                        <div class="<?php echo e($personalize['header']); ?>">
                            <div class="<?php echo \Illuminate\Support\Arr::toCssClasses(['flex items-start', 'justify-between' => $title !== null, 'justify-end' => $title === null]); ?>">
                                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($title): ?>
                                    <h2 <?php if($title instanceof \Illuminate\View\ComponentSlot): ?>
                                            <?php echo e($title->attributes->class($personalize['title.text'])); ?>

                                        <?php else: ?>
                                            class="<?php echo e($personalize['title.text']); ?>"
                                        <?php endif; ?>><?php echo e($title); ?></h2>
                                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                <button type="button" x-on:click="show = false">
                                    <?php if (isset($component)) { $__componentOriginal511d4862ff04963c3c16115c05a86a9d = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal511d4862ff04963c3c16115c05a86a9d = $attributes; } ?>
<?php $component = Illuminate\View\DynamicComponent::resolve(['component' => TallStackUi::prefix('icon')] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('dynamic-component'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\DynamicComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['icon' => TallStackUi::icon('x-mark'),'internal' => true,'class' => ''.e($personalize['title.close']).'']); ?>
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
                            </div>
                        </div>
                        <div class="<?php echo e($personalize['body']); ?>">
                            <?php echo e($slot); ?>

                        </div>
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($footer): ?>
                            <div <?php if($footer instanceof \Illuminate\View\ComponentSlot): ?> <?php echo e($footer->attributes->class([
                                    $personalize['footer'],
                                    'justify-start' => $footer->attributes->get('start', false),
                                    'justify-end' => $footer->attributes->get('end', false),
                                ])); ?> <?php else: ?> class="<?php echo e($personalize['footer']); ?>" <?php endif; ?>>
                                <?php echo e($footer); ?>

                            </div>
                        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php /**PATH /Users/macbookair/Documents/mediction/mediction.id/vendor/tallstackui/tallstackui/src/resources/views/components/slide.blade.php ENDPATH**/ ?>