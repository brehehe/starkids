<div class="<?php echo \Illuminate\Support\Arr::toCssClasses([$personalize['simple.wrapper'], $personalize['sizes.' . $size]]); ?>"
     role="progressbar"
     aria-valuenow="<?php echo e($percent); ?>"
     aria-valuemin="0"
     aria-valuemax="100">
    <div class="<?php echo \Illuminate\Support\Arr::toCssClasses([$personalize['simple.progress'], $colors['background']]); ?>"
         style="width: <?php echo e($percent); ?>%">
          <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(!$withoutText): ?>
               <?php echo e($percent); ?>%
          <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>    
     </div>
</div>
<?php /**PATH /Users/macbookair/Documents/mediction/mediction.id/vendor/tallstackui/tallstackui/src/resources/views/components/progress/variations/simple.blade.php ENDPATH**/ ?>