<?php
    $personalize = $classes();
?>

<div x-data="{ selected: <?php if(!$selected): ?> <?php echo TallStackUi::blade($attributes, $livewire)->entangle(); ?> <?php else: ?> <?php echo \Illuminate\Support\Js::from($selected)->toHtml() ?> <?php endif; ?>, tabs: [] }" class="<?php echo e($personalize['base.wrapper']); ?>">
    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(!$scrollOnMobile): ?>
    <div class="<?php echo e($personalize['base.padding']); ?>">
        <select x-model="selected" class="<?php echo e($personalize['base.select']); ?>" aria-label="Select a tab" x-on:change="$refs.ul.dispatchEvent(new CustomEvent('navigate', {detail: {select: selected}}));">
            <template x-for="item in tabs">
                <option x-bind:value="item.tab" x-text="item.title ?? item.tab" x-bind:selected="item.tab === selected">
                </option>
            </template>
        </select>
    </div>
    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
    <ul role="tablist" class="<?php echo \Illuminate\Support\Arr::toCssClasses([$personalize['base.body'], 'hidden sm:flex' => ! $scrollOnMobile]); ?>" <?php echo e($attributes->only('x-on:navigate')); ?> x-ref="ul">
        <template x-for="item in tabs">
            <li role="tab"
                tabindex="0"
                x-on:click="selected = item.tab; $refs.ul.dispatchEvent(new CustomEvent('navigate', {detail: {select: item.tab}}));"
                x-on:keypress.enter="selected = item.tab; $refs.ul.dispatchEvent(new CustomEvent('navigate', {detail: {select: item.tab}}));"
                x-bind:aria-selected="selected === item.tab ? 'true' : 'false'"
                x-bind:class="{
                    '<?php echo e($personalize['item.select']); ?>' : selected === item.tab,
                    '<?php echo e($personalize['item.unselect']); ?>' : selected !== item.tab,
                    'hidden sm:flex': selected !== item.tab && ! <?php echo \Illuminate\Support\Js::from($scrollOnMobile)->toHtml() ?>,
                }">
                <div class="<?php echo e($personalize['item.wrapper']); ?>">
                    <template x-if="item.left">
                        <div x-html="item.left"></div>
                    </template>
                    <span x-text="item.title ?? item.tab"></span>
                    <template x-if="item.right">
                        <div x-html="item.right"></div>
                    </template>
                </div>
            </li>
        </template>
    </ul>
    <hr class="<?php echo \Illuminate\Support\Arr::toCssClasses([$personalize['base.divider'], 'hidden sm:block' => ! $scrollOnMobile]); ?>">
    <div class="<?php echo e($personalize['base.content']); ?>">
        <?php echo e($slot); ?>

    </div>
</div>
<?php /**PATH /Users/macbookair/Documents/mediction/mediction.id/vendor/tallstackui/tallstackui/src/resources/views/components/tab/tab.blade.php ENDPATH**/ ?>