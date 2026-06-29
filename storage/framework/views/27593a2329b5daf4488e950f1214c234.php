<?php # [BlazeFolded]:{flux::radio.indicator}:{/Users/macbookair/Documents/mediction/mediction.id/vendor/livewire/flux/src/../stubs/resources/views/flux/radio/indicator.blade.php}:{1781835918} ?>
<?php
if (!function_exists('_27593a2329b5daf4488e950f1214c234')):
function _27593a2329b5daf4488e950f1214c234($__blaze, $__data = [], $__slots = [], $__bound = [], $__keys = [], $__this = null) {
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
    'name' => $attributes->whereStartsWith('wire:model')->first(),
];
$name ??= $attributes['name'] ?? $__defaults['name']; unset($attributes['name']);
unset($__defaults);
?>

<?php $__blaze->ensureRequired('/Users/macbookair/Documents/mediction/mediction.id/vendor/livewire/flux/src/../stubs/resources/views/flux/with-inline-field.blade.php', $__blaze->compiledPath.'/f37e4817c286efcfebd2a6cc9e60f179.php'); ?>
<?php if (isset($__slotsf37e4817c286efcfebd2a6cc9e60f179)) { $__slotsStackf37e4817c286efcfebd2a6cc9e60f179[] = $__slotsf37e4817c286efcfebd2a6cc9e60f179; } ?>
<?php if (isset($__attrsf37e4817c286efcfebd2a6cc9e60f179)) { $__attrsStackf37e4817c286efcfebd2a6cc9e60f179[] = $__attrsf37e4817c286efcfebd2a6cc9e60f179; } ?>
<?php $__attrsf37e4817c286efcfebd2a6cc9e60f179 = ['variant' => 'inline','attributes' => $attributes]; ?>
<?php $__slotsf37e4817c286efcfebd2a6cc9e60f179 = []; ?>
<?php $__blaze->pushData($__attrsf37e4817c286efcfebd2a6cc9e60f179); ?>
<?php ob_start(); ?>
    
    
    
    <ui-radio <?php echo e($attributes->class('flex size-[1.125rem] rounded-full mt-px outline-offset-2')); ?> data-flux-control data-flux-radio tabindex="-1">
        <?php ob_start(); ?><div class="shrink-0 size-[1.125rem] rounded-full text-sm text-zinc-700 dark:text-zinc-800 shadow-xs [ui-radio[disabled]_&amp;]:opacity-75 [ui-radio[data-checked][disabled]_&amp;]:opacity-50 [ui-radio[disabled]_&amp;]:shadow-none [ui-radio[data-checked]_&amp;]:shadow-none flex justify-center items-center [ui-radio[data-checked]_&amp;&gt;div]:block border border-zinc-300 dark:border-white/10 [ui-radio[disabled]_&amp;]:border-zinc-200 dark:[ui-radio[disabled]_&amp;]:border-white/5 [ui-radio[data-checked]_&amp;]:border-transparent data-indeterminate:border-transparent [ui-radio[data-checked]_&amp;]:[ui-radio[disabled]_&amp;]:border-transparent data-indeterminate:border-transparent [print-color-adjust:exact] bg-white dark:bg-white/10 [ui-radio[data-checked]_&amp;]:bg-[var(--color-accent)] hover:[ui-radio[data-checked]_&amp;]:bg-(--color-accent) focus:[ui-radio[data-checked]_&amp;]:bg-(--color-accent)" data-flux-radio-indicator>
    <div class="hidden size-2 rounded-full bg-[var(--color-accent-foreground)]"></div>
</div>
<?php echo ltrim(ob_get_clean()); ?>
    </ui-radio>
<?php $__slotsf37e4817c286efcfebd2a6cc9e60f179['slot'] = new \Illuminate\View\ComponentSlot(trim(ob_get_clean()), []); ?>
<?php $__blaze->pushSlots($__slotsf37e4817c286efcfebd2a6cc9e60f179); ?>
<?php _f37e4817c286efcfebd2a6cc9e60f179($__blaze, $__attrsf37e4817c286efcfebd2a6cc9e60f179, $__slotsf37e4817c286efcfebd2a6cc9e60f179, ['attributes'], [], $__this ?? (isset($this) ? $this : null)); ?>
<?php if (! empty($__slotsStackf37e4817c286efcfebd2a6cc9e60f179)) { $__slotsf37e4817c286efcfebd2a6cc9e60f179 = array_pop($__slotsStackf37e4817c286efcfebd2a6cc9e60f179); } ?>
<?php if (! empty($__attrsStackf37e4817c286efcfebd2a6cc9e60f179)) { $__attrsf37e4817c286efcfebd2a6cc9e60f179 = array_pop($__attrsStackf37e4817c286efcfebd2a6cc9e60f179); } ?>
<?php $__blaze->popData(); ?>
<?php
echo ltrim(ob_get_clean());
} endif; ?><?php /**PATH /Users/macbookair/Documents/mediction/mediction.id/vendor/livewire/flux/stubs/resources/views/flux/radio/variants/default.blade.php ENDPATH**/ ?>