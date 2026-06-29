<?php
if (!function_exists('__f4234d781a8e7ee079f4c171ca8311e3')):
function __f4234d781a8e7ee079f4c171ca8311e3($__blaze, $__data = [], $__slots = [], $__bound = [], $__keys = [], $__this = null) {
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
    'name' => $attributes->whereStartsWith('wire:model')->first(),
    'resize' => 'vertical',
    'invalid' => null,
    'rows' => 4,
];
$name ??= $attributes['name'] ?? $__defaults['name']; unset($attributes['name']);
$resize ??= $attributes['resize'] ?? $__defaults['resize']; unset($attributes['resize']);
$invalid ??= $attributes['invalid'] ?? $__defaults['invalid']; unset($attributes['invalid']);
$rows ??= $attributes['rows'] ?? $__defaults['rows']; unset($attributes['rows']);
unset($__defaults);
?>

<?php
$classes = Flux::classes()
    ->add('block p-3 w-full')
    ->add('shadow-xs disabled:shadow-none border rounded-lg')
    ->add('bg-white dark:bg-white/10 dark:disabled:bg-white/[7%]')
    ->add($resize ? 'resize-y' : 'resize-none')
    ->add('text-base sm:text-sm text-zinc-700 disabled:text-zinc-500 placeholder-zinc-400 disabled:placeholder-zinc-400/70 dark:text-zinc-300 dark:disabled:text-zinc-400 dark:placeholder-zinc-400 dark:disabled:placeholder-zinc-500')
    ->add('border-zinc-200 border-b-zinc-300/80 dark:border-white/10')
    ->add('data-invalid:shadow-none data-invalid:border-red-500 dark:data-invalid:border-red-500')
    ;

$resizeStyle = match ($resize) {
    'none' => 'resize: none',
    'both' => 'resize: both',
    'horizontal' => 'resize: horizontal',
    'vertical' => 'resize: vertical',
};
?>

<?php $__blaze->ensureRequired('/Users/macbookair/Documents/mediction/mediction.id/vendor/livewire/flux/src/../stubs/resources/views/flux/with-field.blade.php', $__blaze->compiledPath.'/013d94450c8927ccaad4262acb475f9f.php'); ?>
<?php if (isset($__slots013d94450c8927ccaad4262acb475f9f)) { $__slotsStack013d94450c8927ccaad4262acb475f9f[] = $__slots013d94450c8927ccaad4262acb475f9f; } ?>
<?php if (isset($__attrs013d94450c8927ccaad4262acb475f9f)) { $__attrsStack013d94450c8927ccaad4262acb475f9f[] = $__attrs013d94450c8927ccaad4262acb475f9f; } ?>
<?php $__attrs013d94450c8927ccaad4262acb475f9f = ['attributes' => $attributes]; ?>
<?php $__slots013d94450c8927ccaad4262acb475f9f = []; ?>
<?php $__blaze->pushData($__attrs013d94450c8927ccaad4262acb475f9f); ?>
<?php ob_start(); ?>
    <textarea
        <?php echo e($attributes->class($classes)); ?>

        rows="<?php echo e($rows); ?>"
        style="<?php echo e($resizeStyle); ?>; <?php echo e($rows === 'auto' ? 'field-sizing: content' : ''); ?>"
        <?php if(isset($name)): ?> name="<?php echo e($name); ?>" <?php endif; ?>
        [STARTCOMPILEDUNBLAZE:KY2tqhekbY]<?php \Livewire\Blaze\Unblaze::storeScope("KY2tqhekbY", scope: ['name' => $name ?? null, 'invalid' => $invalid ?? false]) ?>[ENDCOMPILEDUNBLAZE:KY2tqhekbY]
        data-flux-control
        data-flux-textarea
    ><?php echo e($slot); ?></textarea>
<?php $__slots013d94450c8927ccaad4262acb475f9f['slot'] = new \Illuminate\View\ComponentSlot($__blaze->processPassthroughContent('trim', trim(ob_get_clean())), []); ?>
<?php $__blaze->pushSlots($__slots013d94450c8927ccaad4262acb475f9f); ?>
<?php __013d94450c8927ccaad4262acb475f9f($__blaze, $__attrs013d94450c8927ccaad4262acb475f9f, $__slots013d94450c8927ccaad4262acb475f9f, ['attributes'], [], $__this ?? (isset($this) ? $this : null)); ?>
<?php if (! empty($__slotsStack013d94450c8927ccaad4262acb475f9f)) { $__slots013d94450c8927ccaad4262acb475f9f = array_pop($__slotsStack013d94450c8927ccaad4262acb475f9f); } ?>
<?php if (! empty($__attrsStack013d94450c8927ccaad4262acb475f9f)) { $__attrs013d94450c8927ccaad4262acb475f9f = array_pop($__attrsStack013d94450c8927ccaad4262acb475f9f); } ?>
<?php $__blaze->popData(); ?>
<?php
echo $__blaze->processPassthroughContent('ltrim', ltrim(ob_get_clean()));
} endif; ?><?php /**PATH /Users/macbookair/Documents/mediction/mediction.id/vendor/livewire/flux/src/../stubs/resources/views/flux/textarea.blade.php ENDPATH**/ ?>