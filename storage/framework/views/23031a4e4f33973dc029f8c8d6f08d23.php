<?php
if (!function_exists('_23031a4e4f33973dc029f8c8d6f08d23')):
function _23031a4e4f33973dc029f8c8d6f08d23($__blaze, $__data = [], $__slots = [], $__bound = [], $__keys = [], $__this = null) {
$__env = $__blaze->env;
$__slots['slot'] ??= new \Illuminate\View\ComponentSlot('');
if (($__data['attributes'] ?? null) instanceof \Illuminate\View\ComponentAttributeBag) { $__data = $__data + $__data['attributes']->all(); unset($__data['attributes']); }
extract($__slots, EXTR_SKIP); unset($__slots);
extract($__data, EXTR_SKIP);
$attributes = \Livewire\Blaze\Runtime\BlazeAttributeBag::make($__data, $__bound, $__keys);
unset($__data, $__bound, $__keys);
ob_start();
?>


<ui-legend <?php echo e($attributes->class('text-base font-medium text-zinc-800 dark:text-white')); ?> data-flux-legend>
    <?php echo e($slot); ?>

</ui-legend>
<?php
echo ltrim(ob_get_clean());
} endif; ?><?php /**PATH /Users/macbookair/Documents/mediction/mediction.id/vendor/livewire/flux/stubs/resources/views/flux/legend.blade.php ENDPATH**/ ?>