<div class="relative">
    <div class="<?php echo \Illuminate\Support\Arr::toCssClasses($personalize['floating.wrapper']); ?>" style="margin-inline-start: calc(<?php echo e($percent); ?>% - 1.25rem);">
        <?php echo e($percent); ?>%
    </div>
    <div class="<?php echo \Illuminate\Support\Arr::toCssClasses([$personalize['floating.progress'], $personalize['sizes.' . $size]]); ?>"
         role="progressbar"
         aria-valuenow="<?php echo e($percent); ?>"
         aria-valuemin="0"
         aria-valuemax="100">
        <div class="<?php echo \Illuminate\Support\Arr::toCssClasses([$personalize['floating.float'], $colors['background']]); ?>" style="width: <?php echo e($percent); ?>%"></div>
    </div>
</div>
<?php /**PATH /Users/macbookair/Documents/mediction/mediction.id/vendor/tallstackui/tallstackui/src/resources/views/components/progress/variations/floating.blade.php ENDPATH**/ ?>