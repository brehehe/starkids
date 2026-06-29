<?php
if (!function_exists('_013d94450c8927ccaad4262acb475f9f')):
function _013d94450c8927ccaad4262acb475f9f($__blaze, $__data = [], $__slots = [], $__bound = [], $__keys = [], $__this = null) {
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
    'name',
    'descriptionTrailing',
    'description',
    'label',
    'badge',
]));
?>

<?php $descriptionTrailing = $descriptionTrailing ??= $attributes->pluck('description:trailing'); ?>

<?php
$__defaults = [
    'name' => $attributes->whereStartsWith('wire:model')->first(),
    'descriptionTrailing' => null,
    'description' => null,
    'label' => null,
    'badge' => null,
];
$name ??= $attributes['name'] ?? $__defaults['name']; unset($attributes['name']);
$descriptionTrailing ??= $attributes['description-trailing'] ?? $attributes['descriptionTrailing'] ?? $__defaults['descriptionTrailing']; unset($attributes['descriptionTrailing'], $attributes['description-trailing']);
$description ??= $attributes['description'] ?? $__defaults['description']; unset($attributes['description']);
$label ??= $attributes['label'] ?? $__defaults['label']; unset($attributes['label']);
$badge ??= $attributes['badge'] ?? $__defaults['badge']; unset($attributes['badge']);
unset($__defaults);
?>

<?php if (isset($label) || isset($description) || isset($descriptionTrailing)): ?>
    <?php

        $fieldAttributes = Flux::attributesAfter('field:', $attributes, []);
        $labelAttributes = Flux::attributesAfter('label:', $attributes, ['badge' => $badge]);
        $descriptionAttributes = Flux::attributesAfter('description:', $attributes, []);
        $errorAttributes = Flux::attributesAfter('error:', $attributes, ['name' => $name]);
    ?>
    <?php $__blaze->ensureRequired('/Users/macbookair/Documents/mediction/mediction.id/vendor/livewire/flux/src/../stubs/resources/views/flux/field.blade.php', $__blaze->compiledPath.'/5d3490f8f33c416423724f959b1fb299.php'); ?>
<?php if (isset($__slots5d3490f8f33c416423724f959b1fb299)) { $__slotsStack5d3490f8f33c416423724f959b1fb299[] = $__slots5d3490f8f33c416423724f959b1fb299; } ?>
<?php if (isset($__attrs5d3490f8f33c416423724f959b1fb299)) { $__attrsStack5d3490f8f33c416423724f959b1fb299[] = $__attrs5d3490f8f33c416423724f959b1fb299; } ?>
<?php $__attrs5d3490f8f33c416423724f959b1fb299 = ['attributes' => $fieldAttributes]; ?>
<?php $__slots5d3490f8f33c416423724f959b1fb299 = []; ?>
<?php $__blaze->pushData($__attrs5d3490f8f33c416423724f959b1fb299); ?>
<?php ob_start(); ?>
        <?php if (isset($label)): ?>
            <?php $__blaze->ensureRequired('/Users/macbookair/Documents/mediction/mediction.id/vendor/livewire/flux/src/../stubs/resources/views/flux/label.blade.php', $__blaze->compiledPath.'/e0d5822898a798309fbb3b6afe2c9b63.php'); ?>
<?php if (isset($__slotse0d5822898a798309fbb3b6afe2c9b63)) { $__slotsStacke0d5822898a798309fbb3b6afe2c9b63[] = $__slotse0d5822898a798309fbb3b6afe2c9b63; } ?>
<?php if (isset($__attrse0d5822898a798309fbb3b6afe2c9b63)) { $__attrsStacke0d5822898a798309fbb3b6afe2c9b63[] = $__attrse0d5822898a798309fbb3b6afe2c9b63; } ?>
<?php $__attrse0d5822898a798309fbb3b6afe2c9b63 = ['attributes' => $labelAttributes]; ?>
<?php $__slotse0d5822898a798309fbb3b6afe2c9b63 = []; ?>
<?php $__blaze->pushData($__attrse0d5822898a798309fbb3b6afe2c9b63); ?>
<?php ob_start(); ?><?php echo e($label); ?><?php $__slotse0d5822898a798309fbb3b6afe2c9b63['slot'] = new \Illuminate\View\ComponentSlot(trim(ob_get_clean()), []); ?>
<?php $__blaze->pushSlots($__slotse0d5822898a798309fbb3b6afe2c9b63); ?>
<?php _e0d5822898a798309fbb3b6afe2c9b63($__blaze, $__attrse0d5822898a798309fbb3b6afe2c9b63, $__slotse0d5822898a798309fbb3b6afe2c9b63, ['attributes'], [], $__this ?? (isset($this) ? $this : null)); ?>
<?php if (! empty($__slotsStacke0d5822898a798309fbb3b6afe2c9b63)) { $__slotse0d5822898a798309fbb3b6afe2c9b63 = array_pop($__slotsStacke0d5822898a798309fbb3b6afe2c9b63); } ?>
<?php if (! empty($__attrsStacke0d5822898a798309fbb3b6afe2c9b63)) { $__attrse0d5822898a798309fbb3b6afe2c9b63 = array_pop($__attrsStacke0d5822898a798309fbb3b6afe2c9b63); } ?>
<?php $__blaze->popData(); ?>
        <?php endif; ?>

        <?php if (isset($description)): ?>
            <?php $__blaze->ensureRequired('/Users/macbookair/Documents/mediction/mediction.id/vendor/livewire/flux/src/../stubs/resources/views/flux/description.blade.php', $__blaze->compiledPath.'/2198872cf9d01aa4e236054da3e11ebc.php'); ?>
<?php if (isset($__slots2198872cf9d01aa4e236054da3e11ebc)) { $__slotsStack2198872cf9d01aa4e236054da3e11ebc[] = $__slots2198872cf9d01aa4e236054da3e11ebc; } ?>
<?php if (isset($__attrs2198872cf9d01aa4e236054da3e11ebc)) { $__attrsStack2198872cf9d01aa4e236054da3e11ebc[] = $__attrs2198872cf9d01aa4e236054da3e11ebc; } ?>
<?php $__attrs2198872cf9d01aa4e236054da3e11ebc = ['attributes' => $descriptionAttributes]; ?>
<?php $__slots2198872cf9d01aa4e236054da3e11ebc = []; ?>
<?php $__blaze->pushData($__attrs2198872cf9d01aa4e236054da3e11ebc); ?>
<?php ob_start(); ?><?php echo e($description); ?><?php $__slots2198872cf9d01aa4e236054da3e11ebc['slot'] = new \Illuminate\View\ComponentSlot(trim(ob_get_clean()), []); ?>
<?php $__blaze->pushSlots($__slots2198872cf9d01aa4e236054da3e11ebc); ?>
<?php _2198872cf9d01aa4e236054da3e11ebc($__blaze, $__attrs2198872cf9d01aa4e236054da3e11ebc, $__slots2198872cf9d01aa4e236054da3e11ebc, ['attributes'], [], $__this ?? (isset($this) ? $this : null)); ?>
<?php if (! empty($__slotsStack2198872cf9d01aa4e236054da3e11ebc)) { $__slots2198872cf9d01aa4e236054da3e11ebc = array_pop($__slotsStack2198872cf9d01aa4e236054da3e11ebc); } ?>
<?php if (! empty($__attrsStack2198872cf9d01aa4e236054da3e11ebc)) { $__attrs2198872cf9d01aa4e236054da3e11ebc = array_pop($__attrsStack2198872cf9d01aa4e236054da3e11ebc); } ?>
<?php $__blaze->popData(); ?>
        <?php endif; ?>

        <?php echo e($slot); ?>


        
        <?php $__getScope = fn($scope = []) => $scope; ?><?php if (isset($scope)) $__scope = $scope; ?><?php $scope = $__getScope(scope: ['attributes' => $errorAttributes->getAttributes()]); ?>
        <?php $__blaze->ensureRequired('/Users/macbookair/Documents/mediction/mediction.id/vendor/livewire/flux/src/../stubs/resources/views/flux/error.blade.php', $__blaze->compiledPath.'/2ee447fcce7bc37ea277dca40628c725.php'); ?>
<?php $__blaze->pushData(['attributes' => new \Illuminate\View\ComponentAttributeBag($scope['attributes'])]); ?>
<?php _2ee447fcce7bc37ea277dca40628c725($__blaze, ['attributes' => new \Illuminate\View\ComponentAttributeBag($scope['attributes'])], [], ['attributes'], [], $__this ?? (isset($this) ? $this : null)); ?>
<?php $__blaze->popData(); ?>
        <?php if (isset($__scope)) { $scope = $__scope; unset($__scope); } ?>

        <?php if (isset($descriptionTrailing)): ?>
            <?php $__blaze->ensureRequired('/Users/macbookair/Documents/mediction/mediction.id/vendor/livewire/flux/src/../stubs/resources/views/flux/description.blade.php', $__blaze->compiledPath.'/2198872cf9d01aa4e236054da3e11ebc.php'); ?>
<?php if (isset($__slots2198872cf9d01aa4e236054da3e11ebc)) { $__slotsStack2198872cf9d01aa4e236054da3e11ebc[] = $__slots2198872cf9d01aa4e236054da3e11ebc; } ?>
<?php if (isset($__attrs2198872cf9d01aa4e236054da3e11ebc)) { $__attrsStack2198872cf9d01aa4e236054da3e11ebc[] = $__attrs2198872cf9d01aa4e236054da3e11ebc; } ?>
<?php $__attrs2198872cf9d01aa4e236054da3e11ebc = ['attributes' => $descriptionAttributes]; ?>
<?php $__slots2198872cf9d01aa4e236054da3e11ebc = []; ?>
<?php $__blaze->pushData($__attrs2198872cf9d01aa4e236054da3e11ebc); ?>
<?php ob_start(); ?><?php echo e($descriptionTrailing); ?><?php $__slots2198872cf9d01aa4e236054da3e11ebc['slot'] = new \Illuminate\View\ComponentSlot(trim(ob_get_clean()), []); ?>
<?php $__blaze->pushSlots($__slots2198872cf9d01aa4e236054da3e11ebc); ?>
<?php _2198872cf9d01aa4e236054da3e11ebc($__blaze, $__attrs2198872cf9d01aa4e236054da3e11ebc, $__slots2198872cf9d01aa4e236054da3e11ebc, ['attributes'], [], $__this ?? (isset($this) ? $this : null)); ?>
<?php if (! empty($__slotsStack2198872cf9d01aa4e236054da3e11ebc)) { $__slots2198872cf9d01aa4e236054da3e11ebc = array_pop($__slotsStack2198872cf9d01aa4e236054da3e11ebc); } ?>
<?php if (! empty($__attrsStack2198872cf9d01aa4e236054da3e11ebc)) { $__attrs2198872cf9d01aa4e236054da3e11ebc = array_pop($__attrsStack2198872cf9d01aa4e236054da3e11ebc); } ?>
<?php $__blaze->popData(); ?>
        <?php endif; ?>
    <?php $__slots5d3490f8f33c416423724f959b1fb299['slot'] = new \Illuminate\View\ComponentSlot(trim(ob_get_clean()), []); ?>
<?php $__blaze->pushSlots($__slots5d3490f8f33c416423724f959b1fb299); ?>
<?php _5d3490f8f33c416423724f959b1fb299($__blaze, $__attrs5d3490f8f33c416423724f959b1fb299, $__slots5d3490f8f33c416423724f959b1fb299, ['attributes'], [], $__this ?? (isset($this) ? $this : null)); ?>
<?php if (! empty($__slotsStack5d3490f8f33c416423724f959b1fb299)) { $__slots5d3490f8f33c416423724f959b1fb299 = array_pop($__slotsStack5d3490f8f33c416423724f959b1fb299); } ?>
<?php if (! empty($__attrsStack5d3490f8f33c416423724f959b1fb299)) { $__attrs5d3490f8f33c416423724f959b1fb299 = array_pop($__attrsStack5d3490f8f33c416423724f959b1fb299); } ?>
<?php $__blaze->popData(); ?>
<?php else: ?>
    <?php echo e($slot); ?>

<?php endif; ?>
<?php
echo ltrim(ob_get_clean());
} endif; ?><?php /**PATH /Users/macbookair/Documents/mediction/mediction.id/vendor/livewire/flux/src/../stubs/resources/views/flux/with-field.blade.php ENDPATH**/ ?>