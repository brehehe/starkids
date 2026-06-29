<li class="<?php echo e($personalize['circles.li']); ?>"
    x-bind:class="{ 'cursor-pointer': navigate === true }"
    x-on:click="if (navigate === false || (previous === false && item.step < parseInt(selected))) return; selected = item.step;">
    <div class="<?php echo e($personalize['circles.wrapper']); ?>">
        <span class="<?php echo e($personalize['circles.circle.wrapper']); ?>"
              x-bind:class="{
                  '<?php echo e($personalize['circles.circle.inactive']); ?>': parseInt(selected) < item.step,
                  '<?php echo e($personalize['circles.circle.current']); ?>': parseInt(selected) === item.step && item.completed === false,
                  '<?php echo e($personalize['circles.circle.border']); ?>': parseInt(selected) === item.step && item.completed === true,
                  '<?php echo e($personalize['circles.circle.active']); ?>': parseInt(selected) > item.step || parseInt(selected) === item.step && item.completed === true,
              }">
            <?php if (isset($component)) { $__componentOriginal511d4862ff04963c3c16115c05a86a9d = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal511d4862ff04963c3c16115c05a86a9d = $attributes; } ?>
<?php $component = Illuminate\View\DynamicComponent::resolve(['component' => TallStackUi::prefix('icon')] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('dynamic-component'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\DynamicComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['icon' => TallStackUi::icon('check'),'x-show' => 'parseInt(selected) > item.step && item.completed === false || parseInt(selected) === item.step && item.completed === true','internal' => true,'class' => ''.e($personalize['circles.check']).'']); ?>
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
            <span x-show="parseInt(selected) === item.step && item.completed === false"
                  class="<?php echo e($personalize['circles.highlighter.wrapper']); ?>"
                  x-bind:class="{
                      '<?php echo e($personalize['circles.highlighter.current']); ?>': parseInt(selected) === item.step && item.completed ===
                          false,
                      '<?php echo e($personalize['circles.highlighter.active']); ?>': item.completed === true,
                  }"></span>
            <span x-show="parseInt(selected) < item.step" x-text="item.step"></span>
        </span>
        <div class="<?php echo e($personalize['circles.divider.wrapper']); ?>"
             x-show="item.step != steps.length"
             x-bind:class="{
                 '<?php echo e($personalize['circles.divider.inactive']); ?>': parseInt(selected) <= item.step,
                 '<?php echo e($personalize['circles.divider.active']); ?>': parseInt(selected) > item.step,
             }">
        </div>
    </div>
    <div class="<?php echo e($personalize['circles.text.wrapper']); ?>">
        <span x-text="item.title" class="<?php echo e($personalize['circles.text.title']); ?>"></span>
        <span x-text="item.description" class="<?php echo e($personalize['circles.text.description']); ?>"></span>
    </div>
</li>
<?php /**PATH /Users/macbookair/Documents/mediction/mediction.id/vendor/tallstackui/tallstackui/src/resources/views/components/step/variations/circles.blade.php ENDPATH**/ ?>