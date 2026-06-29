<?php
if (!function_exists('_355decf17dc6d8bb76d078316fde34b8')):
function _355decf17dc6d8bb76d078316fde34b8($__blaze, $__data = [], $__slots = [], $__bound = [], $__keys = [], $__this = null) {
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
$classes = Flux::classes('[grid-area:footer]')
    ->add($attributes->has('container') ? '' : 'p-6 lg:p-8')
    ;
?>

<div <?php echo e($attributes->class($classes)); ?> data-flux-footer>
    <?php $__blaze->ensureRequired('/Users/macbookair/Documents/mediction/mediction.id/vendor/livewire/flux/src/../stubs/resources/views/flux/with-container.blade.php', $__blaze->compiledPath.'/4ee5a5dd7a3f4cb613ef0f2fe3514a24.php'); ?>
<?php if (isset($__slots4ee5a5dd7a3f4cb613ef0f2fe3514a24)) { $__slotsStack4ee5a5dd7a3f4cb613ef0f2fe3514a24[] = $__slots4ee5a5dd7a3f4cb613ef0f2fe3514a24; } ?>
<?php if (isset($__attrs4ee5a5dd7a3f4cb613ef0f2fe3514a24)) { $__attrsStack4ee5a5dd7a3f4cb613ef0f2fe3514a24[] = $__attrs4ee5a5dd7a3f4cb613ef0f2fe3514a24; } ?>
<?php $__attrs4ee5a5dd7a3f4cb613ef0f2fe3514a24 = ['attributes' => $attributes->except('class')->class('p-6 lg:p-8')]; ?>
<?php $__slots4ee5a5dd7a3f4cb613ef0f2fe3514a24 = []; ?>
<?php $__blaze->pushData($__attrs4ee5a5dd7a3f4cb613ef0f2fe3514a24); ?>
<?php ob_start(); ?>
        <?php echo e($slot); ?>

    <?php $__slots4ee5a5dd7a3f4cb613ef0f2fe3514a24['slot'] = new \Illuminate\View\ComponentSlot(trim(ob_get_clean()), []); ?>
<?php $__blaze->pushSlots($__slots4ee5a5dd7a3f4cb613ef0f2fe3514a24); ?>
<?php _4ee5a5dd7a3f4cb613ef0f2fe3514a24($__blaze, $__attrs4ee5a5dd7a3f4cb613ef0f2fe3514a24, $__slots4ee5a5dd7a3f4cb613ef0f2fe3514a24, ['attributes'], [], $__this ?? (isset($this) ? $this : null)); ?>
<?php if (! empty($__slotsStack4ee5a5dd7a3f4cb613ef0f2fe3514a24)) { $__slots4ee5a5dd7a3f4cb613ef0f2fe3514a24 = array_pop($__slotsStack4ee5a5dd7a3f4cb613ef0f2fe3514a24); } ?>
<?php if (! empty($__attrsStack4ee5a5dd7a3f4cb613ef0f2fe3514a24)) { $__attrs4ee5a5dd7a3f4cb613ef0f2fe3514a24 = array_pop($__attrsStack4ee5a5dd7a3f4cb613ef0f2fe3514a24); } ?>
<?php $__blaze->popData(); ?>
</div>
<?php
echo ltrim(ob_get_clean());
} endif; ?><?php /**PATH /Users/macbookair/Documents/mediction/mediction.id/vendor/livewire/flux/stubs/resources/views/flux/footer.blade.php ENDPATH**/ ?>