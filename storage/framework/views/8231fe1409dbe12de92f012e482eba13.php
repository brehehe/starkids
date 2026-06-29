<?php
if (!function_exists('_8231fe1409dbe12de92f012e482eba13')):
function _8231fe1409dbe12de92f012e482eba13($__blaze, $__data = [], $__slots = [], $__bound = [], $__keys = [], $__this = null) {
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
    'name' => null,
    'align' => 'right',
    'checked' => null
];
$name ??= $attributes['name'] ?? $__defaults['name']; unset($attributes['name']);
$align ??= $attributes['align'] ?? $__defaults['align']; unset($attributes['align']);
$checked ??= $attributes['checked'] ?? $__defaults['checked']; unset($attributes['checked']);
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
    ->add('group h-5 w-8 min-w-8 relative inline-flex items-center outline-offset-2')
    ->add('rounded-full')
    ->add('transition')
    ->add('bg-zinc-800/15 [&[disabled]]:opacity-50 dark:bg-transparent dark:border dark:border-white/20 dark:[&[disabled]]:border-white/10')
    ->add('[print-color-adjust:exact]')
    ->add([
        'data-checked:bg-(--color-accent)',
        'data-checked:border-0',
    ])
    ;

$indicatorClasses = Flux::classes()
    ->add('size-3.5')
    ->add('rounded-full')
    ->add('transition translate-x-[0.1875rem] dark:translate-x-[0.125rem] rtl:-translate-x-[0.1875rem] dark:rtl:-translate-x-[0.125rem]')
    ->add('bg-white')
    ->add([
        'group-data-checked:translate-x-[0.9375rem] rtl:group-data-checked:-translate-x-[0.9375rem]',
        // We have to add the dark variant of the `translate-x-[0.9375rem]` to ensure that if `.dark` is added to an element mid way
        // down the DOM instead of on the root HTML element, that the above `dark:translate-x-[0.125rem]` doesn't over ride it...
        'dark:group-data-checked:translate-x-[0.9375rem] dark:rtl:group-data-checked:-translate-x-[0.9375rem]',
        'group-data-checked:bg-(--color-accent-foreground)',
    ]);
?>

<?php if ($align === 'left' || $align === 'start'): ?>
    <?php $__blaze->ensureRequired('/Users/macbookair/Documents/mediction/mediction.id/vendor/livewire/flux/src/../stubs/resources/views/flux/with-inline-field.blade.php', $__blaze->compiledPath.'/f37e4817c286efcfebd2a6cc9e60f179.php'); ?>
<?php if (isset($__slotsf37e4817c286efcfebd2a6cc9e60f179)) { $__slotsStackf37e4817c286efcfebd2a6cc9e60f179[] = $__slotsf37e4817c286efcfebd2a6cc9e60f179; } ?>
<?php if (isset($__attrsf37e4817c286efcfebd2a6cc9e60f179)) { $__attrsStackf37e4817c286efcfebd2a6cc9e60f179[] = $__attrsf37e4817c286efcfebd2a6cc9e60f179; } ?>
<?php $__attrsf37e4817c286efcfebd2a6cc9e60f179 = ['attributes' => $attributes]; ?>
<?php $__slotsf37e4817c286efcfebd2a6cc9e60f179 = []; ?>
<?php $__blaze->pushData($__attrsf37e4817c286efcfebd2a6cc9e60f179); ?>
<?php ob_start(); ?>
        <ui-switch <?php echo e($attributes->class($classes)); ?> <?php if($showName): ?> name="<?php echo e($name); ?>" <?php endif; ?> <?php if($checked): ?> checked data-checked <?php endif; ?> data-flux-control data-flux-switch>
            <span class="<?php echo e(\Illuminate\Support\Arr::toCssClasses($indicatorClasses)); ?>"></span>
        </ui-switch>
    <?php $__slotsf37e4817c286efcfebd2a6cc9e60f179['slot'] = new \Illuminate\View\ComponentSlot(trim(ob_get_clean()), []); ?>
<?php $__blaze->pushSlots($__slotsf37e4817c286efcfebd2a6cc9e60f179); ?>
<?php _f37e4817c286efcfebd2a6cc9e60f179($__blaze, $__attrsf37e4817c286efcfebd2a6cc9e60f179, $__slotsf37e4817c286efcfebd2a6cc9e60f179, ['attributes'], [], $__this ?? (isset($this) ? $this : null)); ?>
<?php if (! empty($__slotsStackf37e4817c286efcfebd2a6cc9e60f179)) { $__slotsf37e4817c286efcfebd2a6cc9e60f179 = array_pop($__slotsStackf37e4817c286efcfebd2a6cc9e60f179); } ?>
<?php if (! empty($__attrsStackf37e4817c286efcfebd2a6cc9e60f179)) { $__attrsf37e4817c286efcfebd2a6cc9e60f179 = array_pop($__attrsStackf37e4817c286efcfebd2a6cc9e60f179); } ?>
<?php $__blaze->popData(); ?>
<?php else: ?>
    <?php $__blaze->ensureRequired('/Users/macbookair/Documents/mediction/mediction.id/vendor/livewire/flux/src/../stubs/resources/views/flux/with-reversed-inline-field.blade.php', $__blaze->compiledPath.'/d29685632c993eda710d58204fd13b0a.php'); ?>
<?php if (isset($__slotsd29685632c993eda710d58204fd13b0a)) { $__slotsStackd29685632c993eda710d58204fd13b0a[] = $__slotsd29685632c993eda710d58204fd13b0a; } ?>
<?php if (isset($__attrsd29685632c993eda710d58204fd13b0a)) { $__attrsStackd29685632c993eda710d58204fd13b0a[] = $__attrsd29685632c993eda710d58204fd13b0a; } ?>
<?php $__attrsd29685632c993eda710d58204fd13b0a = ['attributes' => $attributes]; ?>
<?php $__slotsd29685632c993eda710d58204fd13b0a = []; ?>
<?php $__blaze->pushData($__attrsd29685632c993eda710d58204fd13b0a); ?>
<?php ob_start(); ?>
        <ui-switch <?php echo e($attributes->class($classes)); ?> <?php if($showName): ?> name="<?php echo e($name); ?>" <?php endif; ?> <?php if($checked): ?> checked data-checked <?php endif; ?> data-flux-control data-flux-switch>
            <span class="<?php echo e(\Illuminate\Support\Arr::toCssClasses($indicatorClasses)); ?>"></span>
        </ui-switch>
    <?php $__slotsd29685632c993eda710d58204fd13b0a['slot'] = new \Illuminate\View\ComponentSlot(trim(ob_get_clean()), []); ?>
<?php $__blaze->pushSlots($__slotsd29685632c993eda710d58204fd13b0a); ?>
<?php _d29685632c993eda710d58204fd13b0a($__blaze, $__attrsd29685632c993eda710d58204fd13b0a, $__slotsd29685632c993eda710d58204fd13b0a, ['attributes'], [], $__this ?? (isset($this) ? $this : null)); ?>
<?php if (! empty($__slotsStackd29685632c993eda710d58204fd13b0a)) { $__slotsd29685632c993eda710d58204fd13b0a = array_pop($__slotsStackd29685632c993eda710d58204fd13b0a); } ?>
<?php if (! empty($__attrsStackd29685632c993eda710d58204fd13b0a)) { $__attrsd29685632c993eda710d58204fd13b0a = array_pop($__attrsStackd29685632c993eda710d58204fd13b0a); } ?>
<?php $__blaze->popData(); ?>
<?php endif; ?>
<?php
echo ltrim(ob_get_clean());
} endif; ?><?php /**PATH /Users/macbookair/Documents/mediction/mediction.id/vendor/livewire/flux/stubs/resources/views/flux/switch.blade.php ENDPATH**/ ?>