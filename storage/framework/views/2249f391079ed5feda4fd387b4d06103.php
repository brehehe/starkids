<div role="tabpanel"
     x-show="parseInt(selected) === <?php echo e($step); ?>"
     x-init="steps.push({ step: <?php echo \Illuminate\Support\Js::from($step)->toHtml() ?>, title: <?php echo \Illuminate\Support\Js::from($title)->toHtml() ?>, description: <?php echo \Illuminate\Support\Js::from($description)->toHtml() ?>, completed: <?php echo \Illuminate\Support\Js::from($completed)->toHtml() ?> })">
    <?php echo e($slot); ?>

</div>
<?php /**PATH /Users/macbookair/Documents/mediction/mediction.id/vendor/tallstackui/tallstackui/src/resources/views/components/step/items.blade.php ENDPATH**/ ?>