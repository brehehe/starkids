<?php
if (!function_exists('_7f521e000226efcb619d9193e4fc3d39')):
function _7f521e000226efcb619d9193e4fc3d39($__blaze, $__data = [], $__slots = [], $__bound = [], $__keys = [], $__this = null) {
$__env = $__blaze->env;

if (($__data['attributes'] ?? null) instanceof \Illuminate\View\ComponentAttributeBag) { $__data = $__data + $__data['attributes']->all(); unset($__data['attributes']); }
extract($__slots, EXTR_SKIP); unset($__slots);
extract($__data, EXTR_SKIP);
$attributes = \Livewire\Blaze\Runtime\BlazeAttributeBag::make($__data, $__bound, $__keys);
unset($__data, $__bound, $__keys);
ob_start();
?>


<?php
$classes = Flux::classes()
    ->add('z-20 fixed inset-0 bg-black/10 hidden')
    ->add('data-flux-sidebar-on-mobile:not-data-flux-sidebar-collapsed-mobile:block')
    ;
?>

<ui-sidebar-toggle <?php echo e($attributes->class($classes)); ?> data-flux-sidebar-backdrop></ui-sidebar-toggle>
<?php
echo ltrim(ob_get_clean());
} endif; ?><?php /**PATH /Users/macbookair/Documents/mediction/mediction.id/vendor/livewire/flux/stubs/resources/views/flux/sidebar/backdrop.blade.php ENDPATH**/ ?>