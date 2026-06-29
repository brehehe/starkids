<?php
if (!function_exists('_e1caa18dbf7db81411a58d2e8f981e9e')):
function _e1caa18dbf7db81411a58d2e8f981e9e($__blaze, $__data = [], $__slots = [], $__bound = [], $__keys = [], $__this = null) {
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
<?php $__attrsa41ec97622e3c0df12f99efa7230ad29 = ['attributes' => $attributes,'size' => $size === 'sm' || $size === 'xs' ? 'xs' : 'sm','xData' => 'fluxInputCopyable','xOn:click' => 'copy()','xBind:dataCopyableCopied' => 'copied','ariaLabel' => e(__('Copy to clipboard'))]; ?>
<?php $__slotsa41ec97622e3c0df12f99efa7230ad29 = []; ?>
<?php $__blaze->pushData($__attrsa41ec97622e3c0df12f99efa7230ad29); ?>
<?php ob_start(); ?>
    <?php $__blaze->ensureRequired('/Users/macbookair/Documents/mediction/mediction.id/vendor/livewire/flux/src/../stubs/resources/views/flux/icon/clipboard-document-check.blade.php', $__blaze->compiledPath.'/555a314a7c53f8560b10e3672ca8835e.php'); ?>
<?php $__blaze->pushData(['variant' => $iconVariant,'class' => 'hidden [[data-copyable-copied]>&]:block']); ?>
<?php _555a314a7c53f8560b10e3672ca8835e($__blaze, ['variant' => $iconVariant,'class' => 'hidden [[data-copyable-copied]>&]:block'], [], ['variant'], [], $__this ?? (isset($this) ? $this : null)); ?>
<?php $__blaze->popData(); ?>
    <?php $__blaze->ensureRequired('/Users/macbookair/Documents/mediction/mediction.id/vendor/livewire/flux/src/../stubs/resources/views/flux/icon/clipboard-document.blade.php', $__blaze->compiledPath.'/20332647437abf3868c6ebe1c3826359.php'); ?>
<?php $__blaze->pushData(['variant' => $iconVariant,'class' => 'block [[data-copyable-copied]>&]:hidden']); ?>
<?php _20332647437abf3868c6ebe1c3826359($__blaze, ['variant' => $iconVariant,'class' => 'block [[data-copyable-copied]>&]:hidden'], [], ['variant'], [], $__this ?? (isset($this) ? $this : null)); ?>
<?php $__blaze->popData(); ?>
<?php $__slotsa41ec97622e3c0df12f99efa7230ad29['slot'] = new \Illuminate\View\ComponentSlot(trim(ob_get_clean()), []); ?>
<?php $__blaze->pushSlots($__slotsa41ec97622e3c0df12f99efa7230ad29); ?>
<?php _a41ec97622e3c0df12f99efa7230ad29($__blaze, $__attrsa41ec97622e3c0df12f99efa7230ad29, $__slotsa41ec97622e3c0df12f99efa7230ad29, ['attributes', 'size'], ['xData' => 'x-data', 'xOn:click' => 'x-on:click', 'xBind:dataCopyableCopied' => 'x-bind:data-copyable-copied', 'ariaLabel' => 'aria-label'], $__this ?? (isset($this) ? $this : null)); ?>
<?php if (! empty($__slotsStacka41ec97622e3c0df12f99efa7230ad29)) { $__slotsa41ec97622e3c0df12f99efa7230ad29 = array_pop($__slotsStacka41ec97622e3c0df12f99efa7230ad29); } ?>
<?php if (! empty($__attrsStacka41ec97622e3c0df12f99efa7230ad29)) { $__attrsa41ec97622e3c0df12f99efa7230ad29 = array_pop($__attrsStacka41ec97622e3c0df12f99efa7230ad29); } ?>
<?php $__blaze->popData(); ?>
<?php
echo ltrim(ob_get_clean());
} endif; ?><?php /**PATH /Users/macbookair/Documents/mediction/mediction.id/vendor/livewire/flux/stubs/resources/views/flux/input/copyable.blade.php ENDPATH**/ ?>