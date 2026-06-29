<?php
if (!function_exists('_83400ace09a6d0a2c39b0fad2ee6df4e')):
function _83400ace09a6d0a2c39b0fad2ee6df4e($__blaze, $__data = [], $__slots = [], $__bound = [], $__keys = [], $__this = null) {
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
    'class' => '-me-1 [[data-flux-input]:has(input:placeholder-shown)_&]:hidden [[data-flux-input]:has(input[disabled])_&]:hidden',
    'square' => true,
    'size' => null,
]);
?>

<?php $__blaze->ensureRequired('/Users/macbookair/Documents/mediction/mediction.id/vendor/livewire/flux/src/../stubs/resources/views/flux/button/index.blade.php', $__blaze->compiledPath.'/a41ec97622e3c0df12f99efa7230ad29.php'); ?>
<?php if (isset($__slotsa41ec97622e3c0df12f99efa7230ad29)) { $__slotsStacka41ec97622e3c0df12f99efa7230ad29[] = $__slotsa41ec97622e3c0df12f99efa7230ad29; } ?>
<?php if (isset($__attrsa41ec97622e3c0df12f99efa7230ad29)) { $__attrsStacka41ec97622e3c0df12f99efa7230ad29[] = $__attrsa41ec97622e3c0df12f99efa7230ad29; } ?>
<?php $__attrsa41ec97622e3c0df12f99efa7230ad29 = ['attributes' => $attributes,'size' => $size === 'sm' || $size === 'xs' ? 'xs' : 'sm','xData' => 'fluxInputClearable','xOn:click' => 'clear()','tabindex' => '-1','ariaLabel' => e(__('Clear input')),'dataFluxClearButton' => true]; ?>
<?php $__slotsa41ec97622e3c0df12f99efa7230ad29 = []; ?>
<?php $__blaze->pushData($__attrsa41ec97622e3c0df12f99efa7230ad29); ?>
<?php ob_start(); ?>
    <?php $__blaze->ensureRequired('/Users/macbookair/Documents/mediction/mediction.id/vendor/livewire/flux/src/../stubs/resources/views/flux/icon/x-mark.blade.php', $__blaze->compiledPath.'/f93ab27e042c5175fd9c28501e3b14ec.php'); ?>
<?php $__blaze->pushData(['variant' => $iconVariant]); ?>
<?php _f93ab27e042c5175fd9c28501e3b14ec($__blaze, ['variant' => $iconVariant], [], ['variant'], [], $__this ?? (isset($this) ? $this : null)); ?>
<?php $__blaze->popData(); ?>
<?php $__slotsa41ec97622e3c0df12f99efa7230ad29['slot'] = new \Illuminate\View\ComponentSlot(trim(ob_get_clean()), []); ?>
<?php $__blaze->pushSlots($__slotsa41ec97622e3c0df12f99efa7230ad29); ?>
<?php _a41ec97622e3c0df12f99efa7230ad29($__blaze, $__attrsa41ec97622e3c0df12f99efa7230ad29, $__slotsa41ec97622e3c0df12f99efa7230ad29, ['attributes', 'size', 'dataFluxClearButton'], ['xData' => 'x-data', 'xOn:click' => 'x-on:click', 'ariaLabel' => 'aria-label', 'dataFluxClearButton' => 'data-flux-clear-button'], $__this ?? (isset($this) ? $this : null)); ?>
<?php if (! empty($__slotsStacka41ec97622e3c0df12f99efa7230ad29)) { $__slotsa41ec97622e3c0df12f99efa7230ad29 = array_pop($__slotsStacka41ec97622e3c0df12f99efa7230ad29); } ?>
<?php if (! empty($__attrsStacka41ec97622e3c0df12f99efa7230ad29)) { $__attrsa41ec97622e3c0df12f99efa7230ad29 = array_pop($__attrsStacka41ec97622e3c0df12f99efa7230ad29); } ?>
<?php $__blaze->popData(); ?>
<?php
echo ltrim(ob_get_clean());
} endif; ?><?php /**PATH /Users/macbookair/Documents/mediction/mediction.id/vendor/livewire/flux/stubs/resources/views/flux/input/clearable.blade.php ENDPATH**/ ?>