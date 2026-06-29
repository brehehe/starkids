<div>
    <div class="<?php echo \Illuminate\Support\Arr::toCssClasses($personalize['title.wrapper']); ?>">
        <h3 class="<?php echo \Illuminate\Support\Arr::toCssClasses($personalize['title.title']); ?>"><?php echo e($title); ?></h3>
        <span class="<?php echo \Illuminate\Support\Arr::toCssClasses($personalize['title.percent']); ?>"><?php echo e($percent); ?>%</span>
    </div>
    <div class="<?php echo \Illuminate\Support\Arr::toCssClasses([$personalize['title.progress'], $personalize['sizes.' . $size]]); ?>"
         role="progressbar"
         aria-valuenow="<?php echo e($percent); ?>"
         aria-valuemin="0"
         aria-valuemax="100">
        <div class="<?php echo \Illuminate\Support\Arr::toCssClasses([$personalize['title.bar'], $colors['background']]); ?>" style="width: <?php echo e($percent); ?>%"></div>
    </div>
</div>
<?php /**PATH /Users/macbookair/Documents/mediction/mediction.id/vendor/tallstackui/tallstackui/src/resources/views/components/progress/variations/title.blade.php ENDPATH**/ ?>