<?php
    $personalize = $classes();
?>

<div x-cloak
     x-data="tallstackui_keyValue(<?php echo $entangle; ?>, <?php echo \Illuminate\Support\Js::from($this->getId())->toHtml() ?>, <?php echo \Illuminate\Support\Js::from($limit)->toHtml() ?>, <?php echo \Illuminate\Support\Js::from($static)->toHtml() ?>, <?php echo \Illuminate\Support\Js::from($deleteMethod)->toHtml() ?>)"
     class="<?php echo e($personalize['wrapper.first']); ?>">
    <div class="<?php echo e($personalize['header.wrapper']); ?>">
        <p class="<?php echo e($personalize['header.key']); ?>"><?php echo e($label ?? trans('tallstack-ui::messages.key-value.headers.key')); ?></p>
        <p class="<?php echo e($personalize['header.value']); ?>"><?php echo e($value ?? trans('tallstack-ui::messages.key-value.headers.value')); ?></p>
        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($header): ?>
            <?php echo e($header); ?>

        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
    </div>
    <div x-bind:class="{ 'divide-y divide-gray-300 dark:divide-dark-500' : rows.length > 0 }">
        <div class="<?php echo e($personalize['empty.wrapper']); ?>" dusk="tallstackui_empty_message" x-show="rows.length === 0">
            <p class="<?php echo e($personalize['empty.text']); ?>"><?php echo e(trans('tallstack-ui::messages.key-value.empty')); ?></p>
        </div>
        <template x-for="(row, index) in rows" :key="row.index ?? index">
            <div class="<?php echo \Illuminate\Support\Arr::toCssClasses([
                    $personalize['list.wrapper'],
                    'py-4' => ! $deletable,
                ]); ?>">
                <div>
                    <input x-model="row.key"
                           x-on:keyup.shift.enter="add"
                           x-on:keyup.enter="sync"
                           dusk="tallstackui_input_key"
                           <?php if($static): echo 'readonly'; endif; ?>
                           <?php if($placeholders): ?> placeholder="<?php echo e(trans('tallstack-ui::messages.key-value.placeholders.key')); ?>"
                           <?php endif; ?>
                           class="<?php echo e($personalize['list.input.key']); ?>"/>
                </div>
                <div class="<?php echo \Illuminate\Support\Arr::toCssClasses([
                        'relative pr-8 mr-2',
                        'top-2' => $deletable,
                    ]); ?>">
                    <div>
                        <input x-model="row.value"
                               x-on:keyup.shift.enter="add"
                               x-on:keyup.enter="sync"
                               dusk="tallstackui_input_value"
                               <?php if($placeholders): ?> placeholder="<?php echo e(trans('tallstack-ui::messages.key-value.placeholders.value')); ?>"
                               <?php endif; ?>
                               <?php if($static): echo 'readonly'; endif; ?>
                               class="<?php echo e($personalize['list.input.value']); ?>"/>
                    </div>
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($deletable): ?>
                        <button class="cursor-pointer"
                                type="button"
                                <?php echo e($attributes->only('x-on:remove')); ?>

                                x-on:click="remove(index)">
                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($icon instanceof \Illuminate\View\ComponentSlot): ?>
                                <?php echo e($icon); ?>

                            <?php else: ?>
                                <?php if (isset($component)) { $__componentOriginal511d4862ff04963c3c16115c05a86a9d = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal511d4862ff04963c3c16115c05a86a9d = $attributes; } ?>
<?php $component = Illuminate\View\DynamicComponent::resolve(['component' => TallStackUi::prefix('icon')] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('dynamic-component'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\DynamicComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['icon' => TallStackUi::icon($icon ?? 'trash'),'dusk' => 'tallstackui_delete_row_button','internal' => true,'class' => ''.e($personalize['button.delete']).'']); ?>
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
                        </button>
                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                </div>
            </div>
        </template>
    </div>
    <button x-on:click="add"
            type="button"
            dusk="tallstackui_add_row_button"
            <?php echo e($attributes->only('x-on:add')); ?>

            class="<?php echo e($personalize['button.add']); ?>"
            x-show="addable">
        <?php echo e(trans('tallstack-ui::messages.key-value.add-row')); ?>

    </button>
</div>
<?php /**PATH /Users/macbookair/Documents/mediction/mediction.id/vendor/tallstackui/tallstackui/src/resources/views/components/key-value.blade.php ENDPATH**/ ?>