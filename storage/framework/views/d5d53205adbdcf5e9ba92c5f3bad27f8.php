<li class="<?php echo e($personalize['panels.li']); ?>"
    x-bind:class="{ 'cursor-pointer': navigate === true }"
    x-on:click="if (navigate === false || (previous === false && item.step < parseInt(selected))) return; selected = item.step;">
    <div class="<?php echo e($personalize['panels.wrapper']); ?>">
        <span class="<?php echo e($personalize['panels.item']); ?>">
            <span class="<?php echo e($personalize['panels.circle.wrapper']); ?>"
                  x-bind:class="{
                      '<?php echo e($personalize['panels.circle.inactive']); ?>': parseInt(selected) < item.step,
                      '<?php echo e($personalize['panels.circle.current']); ?>': parseInt(selected) === item.step && item.completed === false,
                      '<?php echo e($personalize['panels.circle.active']); ?>': parseInt(selected) > item.step || parseInt(selected) === item.step && item.completed === true,
                  }">
                <span x-text="item.step"
                      x-show="parseInt(selected) < item.step || parseInt(selected) === item.step && item.completed === false"
                      x-bind:class="{
                          '<?php echo e($personalize['panels.text.number.active']); ?>': parseInt(selected) <= item.step,
                          '<?php echo e($personalize['panels.text.number.inactive']); ?>': parseInt(selected) >= item.step,
                      }">
                </span>
                <?php if (isset($component)) { $__componentOriginal511d4862ff04963c3c16115c05a86a9d = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal511d4862ff04963c3c16115c05a86a9d = $attributes; } ?>
<?php $component = Illuminate\View\DynamicComponent::resolve(['component' => TallStackUi::prefix('icon')] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('dynamic-component'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\DynamicComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['icon' => TallStackUi::icon('check'),'x-show' => 'parseInt(selected) > item.step || parseInt(selected) === item.step && item.completed === true','internal' => true,'class' => ''.e($personalize['panels.check']).'']); ?>
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
            </span>
            <div class="flex flex-col">
                <span class="<?php echo e($personalize['panels.text.title.wrapper']); ?>"
                      x-bind:class="{
                        '<?php echo e($personalize['panels.text.title.inactive']); ?>': parseInt(selected) === item.step && item.completed === false || parseInt(selected) < item.step,
                        '<?php echo e($personalize['panels.text.title.active']); ?>': parseInt(selected) > item.step || parseInt(selected) === item.step && item.completed === true,
                      }" x-text="item.title"></span>
                <span class="<?php echo e($personalize['panels.text.description']); ?>" x-text="item.description"></span>
            </div>
        </span>
    </div>
    <div x-show="item.step !== steps.length" class="<?php echo e($personalize['panels.divider.wrapper']); ?>">
        <svg class="<?php echo e($personalize['panels.divider.svg']); ?>" viewBox="0 0 22 80" fill="none" preserveAspectRatio="none">
            <path d="M0 -2L20 40L0 82" vector-effect="non-scaling-stroke" stroke="currentcolor" stroke-linejoin="round" />
        </svg>
    </div>
</li>
<?php /**PATH /Users/macbookair/Documents/mediction/mediction.id/vendor/tallstackui/tallstackui/src/resources/views/components/step/variations/panels.blade.php ENDPATH**/ ?>