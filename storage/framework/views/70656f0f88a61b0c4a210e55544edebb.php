<?php
if (!function_exists('_70656f0f88a61b0c4a210e55544edebb')):
function _70656f0f88a61b0c4a210e55544edebb($__blaze, $__data = [], $__slots = [], $__bound = [], $__keys = [], $__this = null) {
$__env = $__blaze->env;
$__slots['slot'] ??= new \Illuminate\View\ComponentSlot('');
if (($__data['attributes'] ?? null) instanceof \Illuminate\View\ComponentAttributeBag) { $__data = $__data + $__data['attributes']->all(); unset($__data['attributes']); }
extract($__slots, EXTR_SKIP); unset($__slots);
extract($__data, EXTR_SKIP);
$attributes = \Livewire\Blaze\Runtime\BlazeAttributeBag::make($__data, $__bound, $__keys);
unset($__data, $__bound, $__keys);
ob_start();
?>


<?php
$__defaults = [
    'animate' => null,
];
$animate ??= $attributes['animate'] ?? $__defaults['animate']; unset($attributes['animate']);
unset($__defaults);
?>

<div <?php echo e($attributes); ?> data-flux-skeleton-group>
    <?php echo e($slot); ?>

</div><?php
echo ltrim(ob_get_clean());
} endif; ?><?php /**PATH /Users/macbookair/Documents/mediction/mediction.id/vendor/livewire/flux/stubs/resources/views/flux/skeleton/group.blade.php ENDPATH**/ ?>