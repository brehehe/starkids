<?php
if (!function_exists('_f6d5889ab554df0d6b7f12234e5a58f0')):
function _f6d5889ab554df0d6b7f12234e5a58f0($__blaze, $__data = [], $__slots = [], $__bound = [], $__keys = [], $__this = null) {
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
extract(Flux::forwardedAttributes($attributes, [
    'tooltipPosition',
    'tooltipKbd',
    'tooltip',
]));
?>

<?php $tooltipPosition = $tooltipPosition ??= $attributes->pluck('tooltip:position'); ?>
<?php $tooltipKbd = $tooltipKbd ??= $attributes->pluck('tooltip:kbd'); ?>
<?php $tooltip = $tooltip ??= $attributes->pluck('tooltip'); ?>

<?php
$__defaults = [
    'tooltipPosition' => 'top',
    'tooltipKbd' => null,
    'tooltip' => null,
];
$tooltipPosition ??= $attributes['tooltip-position'] ?? $attributes['tooltipPosition'] ?? $__defaults['tooltipPosition']; unset($attributes['tooltipPosition'], $attributes['tooltip-position']);
$tooltipKbd ??= $attributes['tooltip-kbd'] ?? $attributes['tooltipKbd'] ?? $__defaults['tooltipKbd']; unset($attributes['tooltipKbd'], $attributes['tooltip-kbd']);
$tooltip ??= $attributes['tooltip'] ?? $__defaults['tooltip']; unset($attributes['tooltip']);
unset($__defaults);
?>

<?php if ($tooltip): ?>
    <?php $__blaze->ensureRequired('/Users/macbookair/Documents/mediction/mediction.id/vendor/livewire/flux/src/../stubs/resources/views/flux/tooltip/index.blade.php', $__blaze->compiledPath.'/65ebe32a313649b2003c89797eef1bef.php'); ?>
<?php if (isset($__slots65ebe32a313649b2003c89797eef1bef)) { $__slotsStack65ebe32a313649b2003c89797eef1bef[] = $__slots65ebe32a313649b2003c89797eef1bef; } ?>
<?php if (isset($__attrs65ebe32a313649b2003c89797eef1bef)) { $__attrsStack65ebe32a313649b2003c89797eef1bef[] = $__attrs65ebe32a313649b2003c89797eef1bef; } ?>
<?php $__attrs65ebe32a313649b2003c89797eef1bef = ['content' => $tooltip,'position' => $tooltipPosition,'kbd' => $tooltipKbd]; ?>
<?php $__slots65ebe32a313649b2003c89797eef1bef = []; ?>
<?php $__blaze->pushData($__attrs65ebe32a313649b2003c89797eef1bef); ?>
<?php ob_start(); ?>
        <?php echo e($slot); ?>

    <?php $__slots65ebe32a313649b2003c89797eef1bef['slot'] = new \Illuminate\View\ComponentSlot(trim(ob_get_clean()), []); ?>
<?php $__blaze->pushSlots($__slots65ebe32a313649b2003c89797eef1bef); ?>
<?php _65ebe32a313649b2003c89797eef1bef($__blaze, $__attrs65ebe32a313649b2003c89797eef1bef, $__slots65ebe32a313649b2003c89797eef1bef, ['content', 'position', 'kbd'], [], $__this ?? (isset($this) ? $this : null)); ?>
<?php if (! empty($__slotsStack65ebe32a313649b2003c89797eef1bef)) { $__slots65ebe32a313649b2003c89797eef1bef = array_pop($__slotsStack65ebe32a313649b2003c89797eef1bef); } ?>
<?php if (! empty($__attrsStack65ebe32a313649b2003c89797eef1bef)) { $__attrs65ebe32a313649b2003c89797eef1bef = array_pop($__attrsStack65ebe32a313649b2003c89797eef1bef); } ?>
<?php $__blaze->popData(); ?>
<?php else: ?>
    <?php echo e($slot); ?>

<?php endif; ?>
<?php
echo ltrim(ob_get_clean());
} endif; ?><?php /**PATH /Users/macbookair/Documents/mediction/mediction.id/vendor/livewire/flux/stubs/resources/views/flux/with-tooltip.blade.php ENDPATH**/ ?>