<?php
    $personalize = $classes();
?>

<?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(!$livewire && $property): ?>
    <input hidden name="<?php echo e($property); ?>">
<?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

<div x-data="tallstackui_formTime(
    <?php echo $entangle; ?>,
    <?php echo \Illuminate\Support\Js::from($format === '24')->toHtml() ?>,
    {...<?php echo \Illuminate\Support\Js::from($times())->toHtml() ?>},
    <?php echo \Illuminate\Support\Js::from($attributes->get('required', false))->toHtml() ?>,
    <?php echo \Illuminate\Support\Js::from($livewire)->toHtml() ?>,
    <?php echo \Illuminate\Support\Js::from($property)->toHtml() ?>,
    <?php echo \Illuminate\Support\Js::from($attributes->get('value'))->toHtml() ?>,
    <?php echo \Illuminate\Support\Js::from($attributes->only(['disabled', 'readonly'])->getAttributes())->toHtml() ?>,
    <?php echo \Illuminate\Support\Js::from($change)->toHtml() ?>)"
    x-cloak x-on:click.outside="show = false">
    <?php if (isset($component)) { $__componentOriginal511d4862ff04963c3c16115c05a86a9d = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal511d4862ff04963c3c16115c05a86a9d = $attributes; } ?>
<?php $component = Illuminate\View\DynamicComponent::resolve(['component' => TallStackUi::prefix('input')] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('dynamic-component'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\DynamicComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['attributes' => $attributes->except('name'),'label' => $label,'hint' => $hint,'invalidate' => $invalidate,'alternative' => $attributes->get('name'),'floatable' => true,'x-ref' => 'input','x-on:click' => '(disables[\'disabled\'] ?? false) || (disables[\'readonly\'] ?? false) ? false : show = !show','x-on:keydown' => '$event.preventDefault()','dusk' => 'tallstackui_time_input','class' => 'cursor-pointer caret-transparent']); ?>
<?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::processComponentKey($component); ?>

                          <?php $__env->slot('suffix', null, ['class' => 'ml-1 mr-2']); ?> 
                             <div class="<?php echo e($personalize['icon.wrapper']); ?>">
                                 <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(!$attributes->has('required')): ?>
                                    <button type="button" class="cursor-pointer" x-on:click="clear()" x-show="model">
                                        <?php if (isset($component)) { $__componentOriginal511d4862ff04963c3c16115c05a86a9d = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal511d4862ff04963c3c16115c05a86a9d = $attributes; } ?>
<?php $component = Illuminate\View\DynamicComponent::resolve(['component' => TallStackUi::prefix('icon')] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('dynamic-component'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\DynamicComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['dusk' => 'tallstackui_time_clear','internal' => true,'icon' => TallStackUi::icon('x-mark'),'class' => \Illuminate\Support\Arr::toCssClasses([$personalize['icon.size'], $personalize['icon.clear']])]); ?>
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
                                <button type="button" class="cursor-pointer" x-on:click="(disables['disabled'] ?? false) || (disables['readonly'] ?? false) ? false : show = !show">
                                    <?php if (isset($component)) { $__componentOriginal511d4862ff04963c3c16115c05a86a9d = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal511d4862ff04963c3c16115c05a86a9d = $attributes; } ?>
<?php $component = Illuminate\View\DynamicComponent::resolve(['component' => TallStackUi::prefix('icon')] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('dynamic-component'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\DynamicComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['icon' => TallStackUi::icon('clock'),'internal' => true,'class' => ''.e($personalize['icon.size']).'']); ?>
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
                          <?php $__env->endSlot(); ?>
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
    <?php if (isset($component)) { $__componentOriginal511d4862ff04963c3c16115c05a86a9d = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal511d4862ff04963c3c16115c05a86a9d = $attributes; } ?>
<?php $component = Illuminate\View\DynamicComponent::resolve(['component' => TallStackUi::prefix('floating')] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('dynamic-component'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\DynamicComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['floating' => $personalize['floating.default'],'class' => $personalize['floating.class']]); ?>
<?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::processComponentKey($component); ?>

        <div class="<?php echo \Illuminate\Support\Arr::toCssClasses(['flex flex-col', 'mb-2' => $helper || $footer?->isNotEmpty(), 'w-full' => $format === '24']); ?>">
            <div class="<?php echo e($personalize['wrapper']); ?>">
                <span x-text="formatted.hours" x-ref="hours" class="<?php echo e($personalize['time']); ?>"></span>
                <span class="<?php echo e($personalize['separator']); ?>">:</span>
                <span x-text="formatted.minutes" x-ref="minutes" class="<?php echo e($personalize['time']); ?>"></span>
                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($format === '12'): ?>
                    <div class="<?php echo e($personalize['interval.wrapper']); ?>">
                        <p class="<?php echo e($personalize['interval.text']); ?>" x-text="interval"></p>
                    </div>
                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
            </div>
            <div wire:ignore.self class="<?php echo e($personalize['helper.wrapper']); ?>">
                <input type="range"
                       min="<?php echo e($format === '12' ? 1 : 0); ?>"
                       max="<?php echo e($format === '12' ? 12 : 23); ?>"
                       step="<?php echo e($stepHour ?? 1); ?>"
                       x-model="hours"
                       x-on:change="change($event, 'hours');"
                       <?php echo e($attributes->only('x-on:hour')); ?>

                       dusk="tallstackui_time_hours"
                       x-on:change="alert(1);"
                       x-on:mouseenter="$refs.hours.classList.add('<?php echo e($personalize['range.light']); ?>', '<?php echo e($personalize['range.dark']); ?>')"
                       x-on:mouseleave="$refs.hours.classList.remove('<?php echo e($personalize['range.light']); ?>', '<?php echo e($personalize['range.dark']); ?>')"
                       class="<?php echo \Illuminate\Support\Arr::toCssClasses(['focus:outline-hidden', $personalize['range.base'], $personalize['range.thumb']]); ?>">
                <input type="range"
                       min="0"
                       max="59"
                       step="<?php echo e($stepMinute ?? 1); ?>"
                       x-model="minutes"
                       x-on:change="change($event, 'minutes');"
                       <?php echo e($attributes->only('x-on:minute')); ?>

                       dusk="tallstackui_time_minutes"
                       x-on:mouseenter="$refs.minutes.classList.add('<?php echo e($personalize['range.light']); ?>', '<?php echo e($personalize['range.dark']); ?>')"
                       x-on:mouseleave="$refs.minutes.classList.remove('<?php echo e($personalize['range.light']); ?>', '<?php echo e($personalize['range.dark']); ?>')"
                       class="<?php echo \Illuminate\Support\Arr::toCssClasses(['focus:outline-hidden', $personalize['range.base'], $personalize['range.thumb']]); ?>">
            </div>
            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($format === '12'): ?>
                <div x-ref="format" <?php echo e($attributes->only('x-on:interval')); ?> class="<?php echo e($personalize['interval.buttons.wrapper']); ?>">
                    <button type="button"
                            x-on:click="select('AM')"
                            class="<?php echo e($personalize['interval.buttons.am']); ?>"
                            dusk="tallstackui_time_am">AM</button>
                    <button type="button"
                            x-on:click="select('PM')"
                            class="<?php echo e($personalize['interval.buttons.pm']); ?>"
                            dusk="tallstackui_time_pm">PM</button>
                </div>
            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
        </div>
        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($helper || $footer): ?>
             <?php $__env->slot('footer', null, []); ?> 
                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($helper): ?>
                <?php if (isset($component)) { $__componentOriginal511d4862ff04963c3c16115c05a86a9d = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal511d4862ff04963c3c16115c05a86a9d = $attributes; } ?>
<?php $component = Illuminate\View\DynamicComponent::resolve(['component' => TallStackUi::prefix('button')] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('dynamic-component'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\DynamicComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['text' => trans('tallstack-ui::messages.time.helper'),'type' => 'button','class' => \Illuminate\Support\Arr::toCssClasses([$personalize['helper.button'], 'mt-2' => $format === '24']),'x-on:click' => 'current()','attributes' => $attributes->only('x-on:current'),'dusk' => 'tallstackui_time_current','xs' => true]); ?>
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
                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($footer): ?>
                    <?php echo e($footer); ?>

                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
             <?php $__env->endSlot(); ?>
        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
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
</div>
<?php /**PATH /Users/macbookair/Documents/mediction/mediction.id/vendor/tallstackui/tallstackui/src/resources/views/components/form/time.blade.php ENDPATH**/ ?>