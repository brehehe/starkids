<?php
if (!function_exists('_895f674814de89c5d2290100c9a891c8')):
function _895f674814de89c5d2290100c9a891c8($__blaze, $__data = [], $__slots = [], $__bound = [], $__keys = [], $__this = null) {
$__env = $__blaze->env;

if (($__data['attributes'] ?? null) instanceof \Illuminate\View\ComponentAttributeBag) { $__data = $__data + $__data['attributes']->all(); unset($__data['attributes']); }
extract($__slots, EXTR_SKIP); unset($__slots);
extract($__data, EXTR_SKIP);
$attributes = \Livewire\Blaze\Runtime\BlazeAttributeBag::make($__data, $__bound, $__keys);
unset($__data, $__bound, $__keys);
ob_start();
?>


<?php $__blaze->ensureRequired('/Users/macbookair/Documents/mediction/mediction.id/vendor/livewire/flux/src/../stubs/resources/views/flux/checkbox/index.blade.php', $__blaze->compiledPath.'/bbbfec15bc8250fde489a142bb555313.php'); ?>
<?php $__blaze->pushData(['all' => true,'attributes' => $attributes]); ?>
<?php _bbbfec15bc8250fde489a142bb555313($__blaze, ['all' => true,'attributes' => $attributes], [], ['all', 'attributes'], [], $__this ?? (isset($this) ? $this : null)); ?>
<?php $__blaze->popData(); ?>
<?php
echo ltrim(ob_get_clean());
} endif; ?><?php /**PATH /Users/macbookair/Documents/mediction/mediction.id/vendor/livewire/flux/stubs/resources/views/flux/checkbox/all.blade.php ENDPATH**/ ?>