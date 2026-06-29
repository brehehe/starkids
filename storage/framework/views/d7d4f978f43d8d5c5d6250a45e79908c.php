<div x-show="selected === <?php echo \Illuminate\Support\Js::from($tab)->toHtml() ?>" role="tabpanel" x-init="tabs.push({ tab: <?php echo \Illuminate\Support\Js::from($tab)->toHtml() ?>, title: <?php echo \Illuminate\Support\Js::from($title)->toHtml() ?>, right: <?php echo \Illuminate\Support\Js::from($content['right'])->toHtml() ?>, left: <?php echo \Illuminate\Support\Js::from($content['left'])->toHtml() ?> });" aria-labelledby="<?php echo e($tab); ?>">
    <?php echo e($slot); ?>

</div>
<?php /**PATH /Users/macbookair/Documents/mediction/mediction.id/vendor/tallstackui/tallstackui/src/resources/views/components/tab/items.blade.php ENDPATH**/ ?>