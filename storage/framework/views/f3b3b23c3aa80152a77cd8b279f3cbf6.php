<?php
if (!function_exists('_f3b3b23c3aa80152a77cd8b279f3cbf6')):
function _f3b3b23c3aa80152a77cd8b279f3cbf6($__blaze, $__data = [], $__slots = [], $__bound = [], $__keys = [], $__this = null) {
$__env = $__blaze->env;

if (($__data['attributes'] ?? null) instanceof \Illuminate\View\ComponentAttributeBag) { $__data = $__data + $__data['attributes']->all(); unset($__data['attributes']); }
extract($__slots, EXTR_SKIP); unset($__slots);
extract($__data, EXTR_SKIP);
$attributes = \Livewire\Blaze\Runtime\BlazeAttributeBag::make($__data, $__bound, $__keys);
unset($__data, $__bound, $__keys);
ob_start();
?>


<?php
$__defaults = [
    'iconVariant' => 'mini',
    'size' => null,
];
$iconVariant ??= $attributes['icon-variant'] ?? $attributes['iconVariant'] ?? $__defaults['iconVariant']; unset($attributes['iconVariant'], $attributes['icon-variant']);
$size ??= $attributes['size'] ?? $__defaults['size']; unset($attributes['size']);
unset($__defaults);
?>

<?php
$attributes = $attributes->merge([
    'variant' => 'subtle',
    'class' => '-me-1',
    'square' => true,
    'size' => null,
]);
?>

<?php $__blaze->ensureRequired('/Users/macbookair/Documents/mediction/mediction.id/vendor/livewire/flux/src/../stubs/resources/views/flux/button/index.blade.php', $__blaze->compiledPath.'/a41ec97622e3c0df12f99efa7230ad29.php'); ?>
<?php if (isset($__slotsa41ec97622e3c0df12f99efa7230ad29)) { $__slotsStacka41ec97622e3c0df12f99efa7230ad29[] = $__slotsa41ec97622e3c0df12f99efa7230ad29; } ?>
<?php if (isset($__attrsa41ec97622e3c0df12f99efa7230ad29)) { $__attrsStacka41ec97622e3c0df12f99efa7230ad29[] = $__attrsa41ec97622e3c0df12f99efa7230ad29; } ?>
<?php $__attrsa41ec97622e3c0df12f99efa7230ad29 = ['attributes' => $attributes,'size' => $size === 'sm' || $size === 'xs' ? 'xs' : 'sm']; ?>
<?php $__slotsa41ec97622e3c0df12f99efa7230ad29 = []; ?>
<?php $__blaze->pushData($__attrsa41ec97622e3c0df12f99efa7230ad29); ?>
<?php ob_start(); ?>
    <?php $__blaze->ensureRequired('/Users/macbookair/Documents/mediction/mediction.id/vendor/livewire/flux/src/../stubs/resources/views/flux/icon/chevron-down.blade.php', $__blaze->compiledPath.'/f4386bd6d2ce21640f01869451b65a3e.php'); ?>
<?php $__blaze->pushData(['variant' => $iconVariant]); ?>
<?php _f4386bd6d2ce21640f01869451b65a3e($__blaze, ['variant' => $iconVariant], [], ['variant'], [], $__this ?? (isset($this) ? $this : null)); ?>
<?php $__blaze->popData(); ?>
<?php $__slotsa41ec97622e3c0df12f99efa7230ad29['slot'] = new \Illuminate\View\ComponentSlot(trim(ob_get_clean()), []); ?>
<?php $__blaze->pushSlots($__slotsa41ec97622e3c0df12f99efa7230ad29); ?>
<?php _a41ec97622e3c0df12f99efa7230ad29($__blaze, $__attrsa41ec97622e3c0df12f99efa7230ad29, $__slotsa41ec97622e3c0df12f99efa7230ad29, ['attributes', 'size'], [], $__this ?? (isset($this) ? $this : null)); ?>
<?php if (! empty($__slotsStacka41ec97622e3c0df12f99efa7230ad29)) { $__slotsa41ec97622e3c0df12f99efa7230ad29 = array_pop($__slotsStacka41ec97622e3c0df12f99efa7230ad29); } ?>
<?php if (! empty($__attrsStacka41ec97622e3c0df12f99efa7230ad29)) { $__attrsa41ec97622e3c0df12f99efa7230ad29 = array_pop($__attrsStacka41ec97622e3c0df12f99efa7230ad29); } ?>
<?php $__blaze->popData(); ?>
<?php
echo ltrim(ob_get_clean());
} endif; ?><?php /**PATH /Users/macbookair/Documents/mediction/mediction.id/vendor/livewire/flux/stubs/resources/views/flux/input/expandable.blade.php ENDPATH**/ ?>