<li class="<?php echo e($personalize['simple.li']); ?>"
    x-bind:class="{ 'cursor-pointer': navigate === true }"
    x-on:click="if (navigate === false || (previous === false && item.step < parseInt(selected))) return; selected = item.step;">
    <div class="<?php echo e($personalize['simple.bar.wrapper']); ?>"
         x-bind:class="{
             '<?php echo e($personalize['simple.bar.inactive']); ?>': parseInt(selected) < item.step,
             '<?php echo e($personalize['simple.bar.current']); ?>': parseInt(selected) === item.step && item.completed === false,
             '<?php echo e($personalize['simple.bar.active']); ?>': parseInt(selected) > item.step || parseInt(selected) === item.step && item.completed === true,
         }">
        <span x-text="item.title"
              class="<?php echo e($personalize['simple.text.title.wrapper']); ?>"
              x-bind:class="{
                  '<?php echo e($personalize['simple.text.title.inactive']); ?>': parseInt(selected) < item.step,
                  '<?php echo e($personalize['simple.text.title.current']); ?>': parseInt(selected) === item.step && item.completed === false,
                  '<?php echo e($personalize['simple.text.title.active']); ?>': parseInt(selected) > item.step || parseInt(selected) === item.step && item.completed === true,
              }"></span>
        <span x-text="item.description" class="<?php echo e($personalize['simple.text.description']); ?>"></span>
    </div>
</li>
<?php /**PATH /Users/macbookair/Documents/mediction/mediction.id/vendor/tallstackui/tallstackui/src/resources/views/components/step/variations/simple.blade.php ENDPATH**/ ?>