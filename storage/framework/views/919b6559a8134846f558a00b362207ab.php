<?php
if (!function_exists('_919b6559a8134846f558a00b362207ab')):
function _919b6559a8134846f558a00b362207ab($__blaze, $__data = [], $__slots = [], $__bound = [], $__keys = [], $__this = null) {
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
    'interactive' => null,
    'position' => 'top',
    'align' => 'center',
    'content' => null,
    'kbd' => null,
    'toggleable' => null,
];
$interactive ??= $attributes['interactive'] ?? $__defaults['interactive']; unset($attributes['interactive']);
$position ??= $attributes['position'] ?? $__defaults['position']; unset($attributes['position']);
$align ??= $attributes['align'] ?? $__defaults['align']; unset($attributes['align']);
$content ??= $attributes['content'] ?? $__defaults['content']; unset($attributes['content']);
$kbd ??= $attributes['kbd'] ?? $__defaults['kbd']; unset($attributes['kbd']);
$toggleable ??= $attributes['toggleable'] ?? $__defaults['toggleable']; unset($attributes['toggleable']);
unset($__defaults);
?>

<?php
// Support adding the .self modifier to the wire:model directive...
if (($wireModel = $attributes->wire('model')) && $wireModel->directive && ! $wireModel->hasModifier('self')) {
    unset($attributes[$wireModel->directive]);

    $wireModel->directive .= '.self';

    $attributes = $attributes->merge([$wireModel->directive => $wireModel->value]);
}
?>

<?php if ($toggleable): ?>
    <ui-dropdown position="<?php echo e($position); ?> <?php echo e($align); ?>" <?php echo e($attributes); ?> data-flux-tooltip>
        <?php echo e($slot); ?>


        <?php if ($content !== null): ?>
            <?php $__blaze->ensureRequired('/Users/macbookair/Documents/mediction/mediction.id/vendor/livewire/flux/src/../stubs/resources/views/flux/tooltip/content.blade.php', $__blaze->compiledPath.'/5293bc4aef7f2ba2f1c856e1765b0265.php'); ?>
<?php if (isset($__slots5293bc4aef7f2ba2f1c856e1765b0265)) { $__slotsStack5293bc4aef7f2ba2f1c856e1765b0265[] = $__slots5293bc4aef7f2ba2f1c856e1765b0265; } ?>
<?php if (isset($__attrs5293bc4aef7f2ba2f1c856e1765b0265)) { $__attrsStack5293bc4aef7f2ba2f1c856e1765b0265[] = $__attrs5293bc4aef7f2ba2f1c856e1765b0265; } ?>
<?php $__attrs5293bc4aef7f2ba2f1c856e1765b0265 = ['kbd' => $kbd]; ?>
<?php $__slots5293bc4aef7f2ba2f1c856e1765b0265 = []; ?>
<?php $__blaze->pushData($__attrs5293bc4aef7f2ba2f1c856e1765b0265); ?>
<?php ob_start(); ?><?php echo e($content); ?><?php $__slots5293bc4aef7f2ba2f1c856e1765b0265['slot'] = new \Illuminate\View\ComponentSlot(trim(ob_get_clean()), []); ?>
<?php $__blaze->pushSlots($__slots5293bc4aef7f2ba2f1c856e1765b0265); ?>
<?php _5293bc4aef7f2ba2f1c856e1765b0265($__blaze, $__attrs5293bc4aef7f2ba2f1c856e1765b0265, $__slots5293bc4aef7f2ba2f1c856e1765b0265, ['kbd'], [], $__this ?? (isset($this) ? $this : null)); ?>
<?php if (! empty($__slotsStack5293bc4aef7f2ba2f1c856e1765b0265)) { $__slots5293bc4aef7f2ba2f1c856e1765b0265 = array_pop($__slotsStack5293bc4aef7f2ba2f1c856e1765b0265); } ?>
<?php if (! empty($__attrsStack5293bc4aef7f2ba2f1c856e1765b0265)) { $__attrs5293bc4aef7f2ba2f1c856e1765b0265 = array_pop($__attrsStack5293bc4aef7f2ba2f1c856e1765b0265); } ?>
<?php $__blaze->popData(); ?>
        <?php endif; ?>
    </ui-dropdown>
<?php else: ?>
    <ui-tooltip position="<?php echo e($position); ?> <?php echo e($align); ?>" <?php echo e($attributes); ?> data-flux-tooltip <?php if($interactive): ?> interactive <?php endif; ?>>
        <?php echo e($slot); ?>


        <?php if ($content !== null): ?>
            <?php $__blaze->ensureRequired('/Users/macbookair/Documents/mediction/mediction.id/vendor/livewire/flux/src/../stubs/resources/views/flux/tooltip/content.blade.php', $__blaze->compiledPath.'/5293bc4aef7f2ba2f1c856e1765b0265.php'); ?>
<?php if (isset($__slots5293bc4aef7f2ba2f1c856e1765b0265)) { $__slotsStack5293bc4aef7f2ba2f1c856e1765b0265[] = $__slots5293bc4aef7f2ba2f1c856e1765b0265; } ?>
<?php if (isset($__attrs5293bc4aef7f2ba2f1c856e1765b0265)) { $__attrsStack5293bc4aef7f2ba2f1c856e1765b0265[] = $__attrs5293bc4aef7f2ba2f1c856e1765b0265; } ?>
<?php $__attrs5293bc4aef7f2ba2f1c856e1765b0265 = ['kbd' => $kbd]; ?>
<?php $__slots5293bc4aef7f2ba2f1c856e1765b0265 = []; ?>
<?php $__blaze->pushData($__attrs5293bc4aef7f2ba2f1c856e1765b0265); ?>
<?php ob_start(); ?><?php echo e($content); ?><?php $__slots5293bc4aef7f2ba2f1c856e1765b0265['slot'] = new \Illuminate\View\ComponentSlot(trim(ob_get_clean()), []); ?>
<?php $__blaze->pushSlots($__slots5293bc4aef7f2ba2f1c856e1765b0265); ?>
<?php _5293bc4aef7f2ba2f1c856e1765b0265($__blaze, $__attrs5293bc4aef7f2ba2f1c856e1765b0265, $__slots5293bc4aef7f2ba2f1c856e1765b0265, ['kbd'], [], $__this ?? (isset($this) ? $this : null)); ?>
<?php if (! empty($__slotsStack5293bc4aef7f2ba2f1c856e1765b0265)) { $__slots5293bc4aef7f2ba2f1c856e1765b0265 = array_pop($__slotsStack5293bc4aef7f2ba2f1c856e1765b0265); } ?>
<?php if (! empty($__attrsStack5293bc4aef7f2ba2f1c856e1765b0265)) { $__attrs5293bc4aef7f2ba2f1c856e1765b0265 = array_pop($__attrsStack5293bc4aef7f2ba2f1c856e1765b0265); } ?>
<?php $__blaze->popData(); ?>
        <?php endif; ?>
    </ui-tooltip>
<?php endif; ?>
<?php
echo ltrim(ob_get_clean());
} endif; ?><?php /**PATH /Users/macbookair/Documents/mediction/mediction.id/vendor/livewire/flux/stubs/resources/views/flux/tooltip/index.blade.php ENDPATH**/ ?>