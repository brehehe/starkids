<?php
if (!function_exists('_38f2cc8f8df49b2e93899500a5260314')):
function _38f2cc8f8df49b2e93899500a5260314($__blaze, $__data = [], $__slots = [], $__bound = [], $__keys = [], $__this = null) {
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
    'name' => null,
    'variant' => null,
];
$name ??= $attributes['name'] ?? $__defaults['name']; unset($attributes['name']);
$variant ??= $attributes['variant'] ?? $__defaults['variant']; unset($attributes['variant']);
unset($__defaults);
?>

<?php
// We only want to show the name attribute it has been set manually
// but not if it has been set from the `wire:model` attribute...
$showName = isset($name);
if (! isset($name)) {
    $name = $attributes->whereStartsWith('wire:model')->first();
}

$classes = Flux::classes()
    // Adjust spacing between fields...
    ->add('*:data-flux-field:mb-3')
    ->add('[&>[data-flux-field]:has(>[data-flux-description])]:mb-4')
    ->add('[&>[data-flux-field]:last-child]:mb-0!')
    ;
?>

<?php $__blaze->ensureRequired('/Users/macbookair/Documents/mediction/mediction.id/vendor/livewire/flux/src/../stubs/resources/views/flux/with-field.blade.php', $__blaze->compiledPath.'/013d94450c8927ccaad4262acb475f9f.php'); ?>
<?php if (isset($__slots013d94450c8927ccaad4262acb475f9f)) { $__slotsStack013d94450c8927ccaad4262acb475f9f[] = $__slots013d94450c8927ccaad4262acb475f9f; } ?>
<?php if (isset($__attrs013d94450c8927ccaad4262acb475f9f)) { $__attrsStack013d94450c8927ccaad4262acb475f9f[] = $__attrs013d94450c8927ccaad4262acb475f9f; } ?>
<?php $__attrs013d94450c8927ccaad4262acb475f9f = ['attributes' => $attributes]; ?>
<?php $__slots013d94450c8927ccaad4262acb475f9f = []; ?>
<?php $__blaze->pushData($__attrs013d94450c8927ccaad4262acb475f9f); ?>
<?php ob_start(); ?>
    <ui-radio-group <?php echo e($attributes->class($classes)); ?> <?php if($showName): ?> name="<?php echo e($name); ?>" <?php endif; ?> data-flux-radio-group>
        <?php echo e($slot); ?>

    </ui-radio-group>
<?php $__slots013d94450c8927ccaad4262acb475f9f['slot'] = new \Illuminate\View\ComponentSlot(trim(ob_get_clean()), []); ?>
<?php $__blaze->pushSlots($__slots013d94450c8927ccaad4262acb475f9f); ?>
<?php _013d94450c8927ccaad4262acb475f9f($__blaze, $__attrs013d94450c8927ccaad4262acb475f9f, $__slots013d94450c8927ccaad4262acb475f9f, ['attributes'], [], $__this ?? (isset($this) ? $this : null)); ?>
<?php if (! empty($__slotsStack013d94450c8927ccaad4262acb475f9f)) { $__slots013d94450c8927ccaad4262acb475f9f = array_pop($__slotsStack013d94450c8927ccaad4262acb475f9f); } ?>
<?php if (! empty($__attrsStack013d94450c8927ccaad4262acb475f9f)) { $__attrs013d94450c8927ccaad4262acb475f9f = array_pop($__attrsStack013d94450c8927ccaad4262acb475f9f); } ?>
<?php $__blaze->popData(); ?>
<?php
echo ltrim(ob_get_clean());
} endif; ?><?php /**PATH /Users/macbookair/Documents/mediction/mediction.id/vendor/livewire/flux/stubs/resources/views/flux/radio/group/variants/default.blade.php ENDPATH**/ ?>