<?php
if (!function_exists('_1e684f4d545297afdf74c5c64ef81dfc')):
function _1e684f4d545297afdf74c5c64ef81dfc($__blaze, $__data = [], $__slots = [], $__bound = [], $__keys = [], $__this = null) {
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
$classes = Flux::classes()
    ->add('*:data-flux-field:mb-3')
    ->add('[&>[data-flux-field]:has(>[data-flux-description])]:mb-4')
    ->add('[&>[data-flux-field]:last-child]:mb-0!')
    ;

// Support adding the .self modifier to the wire:model directive...
if (($wireModel = $attributes->wire('model')) && $wireModel->directive && ! $wireModel->hasModifier('self')) {
    unset($attributes[$wireModel->directive]);

    $wireModel->directive .= '.self';

    $attributes = $attributes->merge([$wireModel->directive => $wireModel->value]);
}
?>

<?php $__blaze->ensureRequired('/Users/macbookair/Documents/mediction/mediction.id/vendor/livewire/flux/src/../stubs/resources/views/flux/with-field.blade.php', $__blaze->compiledPath.'/013d94450c8927ccaad4262acb475f9f.php'); ?>
<?php if (isset($__slots013d94450c8927ccaad4262acb475f9f)) { $__slotsStack013d94450c8927ccaad4262acb475f9f[] = $__slots013d94450c8927ccaad4262acb475f9f; } ?>
<?php if (isset($__attrs013d94450c8927ccaad4262acb475f9f)) { $__attrsStack013d94450c8927ccaad4262acb475f9f[] = $__attrs013d94450c8927ccaad4262acb475f9f; } ?>
<?php $__attrs013d94450c8927ccaad4262acb475f9f = ['attributes' => $attributes]; ?>
<?php $__slots013d94450c8927ccaad4262acb475f9f = []; ?>
<?php $__blaze->pushData($__attrs013d94450c8927ccaad4262acb475f9f); ?>
<?php ob_start(); ?>
    <ui-checkbox-group <?php echo e($attributes->class($classes)); ?> data-flux-checkbox-group>
        <?php echo e($slot); ?>

    </ui-checkbox-group>
<?php $__slots013d94450c8927ccaad4262acb475f9f['slot'] = new \Illuminate\View\ComponentSlot(trim(ob_get_clean()), []); ?>
<?php $__blaze->pushSlots($__slots013d94450c8927ccaad4262acb475f9f); ?>
<?php _013d94450c8927ccaad4262acb475f9f($__blaze, $__attrs013d94450c8927ccaad4262acb475f9f, $__slots013d94450c8927ccaad4262acb475f9f, ['attributes'], [], $__this ?? (isset($this) ? $this : null)); ?>
<?php if (! empty($__slotsStack013d94450c8927ccaad4262acb475f9f)) { $__slots013d94450c8927ccaad4262acb475f9f = array_pop($__slotsStack013d94450c8927ccaad4262acb475f9f); } ?>
<?php if (! empty($__attrsStack013d94450c8927ccaad4262acb475f9f)) { $__attrs013d94450c8927ccaad4262acb475f9f = array_pop($__attrsStack013d94450c8927ccaad4262acb475f9f); } ?>
<?php $__blaze->popData(); ?>
<?php
echo ltrim(ob_get_clean());
} endif; ?><?php /**PATH /Users/macbookair/Documents/mediction/mediction.id/vendor/livewire/flux/stubs/resources/views/flux/checkbox/group/variants/default.blade.php ENDPATH**/ ?>