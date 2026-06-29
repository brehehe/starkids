<?php # [BlazeFolded]:{flux::text}:{/Users/macbookair/Documents/mediction/mediction.id/vendor/livewire/flux/src/../stubs/resources/views/flux/text.blade.php}:{1781835918} ?>
<?php # [BlazeFolded]:{flux::text}:{/Users/macbookair/Documents/mediction/mediction.id/vendor/livewire/flux/src/../stubs/resources/views/flux/text.blade.php}:{1781835918} ?>
<?php # [BlazeFolded]:{flux::button}:{/Users/macbookair/Documents/mediction/mediction.id/vendor/livewire/flux/src/../stubs/resources/views/flux/button/index.blade.php}:{1781835918} ?>
<?php # [BlazeFolded]:{flux::link}:{/Users/macbookair/Documents/mediction/mediction.id/vendor/livewire/flux/src/../stubs/resources/views/flux/link.blade.php}:{1781835918} ?>
<?php

use App\Livewire\Actions\Logout;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Livewire\Attributes\Layout;
use Livewire\Volt\Component;

?>

<div class="mt-4 flex flex-col gap-6">
    <?php ob_start(); ?><p class="[:where(&amp;)]:font-normal [:where(&amp;)]:text-sm [:where(&amp;)]:text-zinc-500 [:where(&amp;)]:dark:text-white/70 text-center" data-flux-text ><?php ob_start(); ?>
        <?php echo e(__('Please verify your email address by clicking on the link we just emailed to you.')); ?>

    <?php echo trim(ob_get_clean()); ?></p><?php echo ltrim(ob_get_clean()); ?>

    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(session('status') == 'verification-link-sent'): ?>
        <?php ob_start(); ?><p class="[:where(&amp;)]:font-normal [:where(&amp;)]:text-sm [:where(&amp;)]:text-zinc-500 [:where(&amp;)]:dark:text-white/70 text-center font-medium !dark:text-green-400 !text-green-600" data-flux-text ><?php ob_start(); ?>
            <?php echo e(__('A new verification link has been sent to the email address you provided during registration.')); ?>

        <?php echo trim(ob_get_clean()); ?></p><?php echo ltrim(ob_get_clean()); ?>
    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

    <div class="flex flex-col items-center justify-between space-y-3">
        <?php ob_start(); ?><button type="button" class="relative items-center font-medium justify-center gap-2 whitespace-nowrap disabled:opacity-75 dark:disabled:opacity-75 disabled:cursor-default disabled:pointer-events-none justify-center h-10 text-sm rounded-lg ps-4 pe-4 inline-flex  bg-[var(--color-accent)] hover:bg-[color-mix(in_oklab,_var(--color-accent),_transparent_10%)] text-[var(--color-accent-foreground)] border border-black/10 dark:border-0 shadow-[inset_0px_1px_--theme(--color-white/.2)] [[data-flux-button-group]_&amp;]:border-e-0 [:is([data-flux-button-group]&gt;&amp;:last-child,_[data-flux-button-group]_:last-child&gt;&amp;)]:border-e-[1px] dark:[:is([data-flux-button-group]&gt;&amp;:last-child,_[data-flux-button-group]_:last-child&gt;&amp;)]:border-e-0 dark:[:is([data-flux-button-group]&gt;&amp;:last-child,_[data-flux-button-group]_:last-child&gt;&amp;)]:border-s-[1px] [:is([data-flux-button-group]&gt;&amp;:not(:first-child),_[data-flux-button-group]_:not(:first-child)&gt;&amp;)]:border-s-[color-mix(in_srgb,var(--color-accent-foreground),transparent_85%)] *:transition-opacity [&amp;[data-loading]&gt;:not([data-flux-loading-indicator])]:opacity-0 [&amp;[data-flux-loading]&gt;:not([data-flux-loading-indicator])]:opacity-0 [&amp;[data-loading]&gt;[data-flux-loading-indicator]]:opacity-100 [&amp;[data-flux-loading]&gt;[data-flux-loading-indicator]]:opacity-100 data-loading:pointer-events-none data-flux-loading:pointer-events-none  w-full" data-flux-button="data-flux-button" data-flux-group-target="data-flux-group-target" wire:target="sendVerification" wire:loading.attr="data-flux-loading" wire:click="sendVerification">
        <div class="absolute inset-0 flex items-center justify-center opacity-0" data-flux-loading-indicator>
                <svg class="shrink-0 [:where(&amp;)]:size-4 animate-spin" data-flux-icon xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" aria-hidden="true" data-slot="icon">
    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
</svg>
                    </div>
        
        
                    
            
            <span><?php ob_start(); ?>
            <?php echo e(__('Resend verification email')); ?>

        <?php echo trim(ob_get_clean()); ?></span>
    </button>
<?php echo ltrim(ob_get_clean()); ?>

        <?php ob_start(); ?><a class="inline font-medium underline-offset-[6px] hover:decoration-current underline [[data-color]&gt;&amp;]:text-inherit [[data-color]&gt;&amp;]:decoration-current/20 dark:[[data-color]&gt;&amp;]:decoration-current/50 [[data-color]&gt;&amp;]:hover:decoration-current text-[var(--color-accent-content)] decoration-[color-mix(in_oklab,var(--color-accent-content),transparent_80%)] text-sm cursor-pointer" wire:click="logout" data-flux-link ><?php ob_start(); ?>
            <?php echo e(__('Log out')); ?>

        <?php echo trim(ob_get_clean()); ?></a><?php echo ltrim(ob_get_clean()); ?>
    </div>
</div><?php /**PATH /Users/macbookair/Documents/mediction/mediction.id/resources/views/livewire/auth/verify-email.blade.php ENDPATH**/ ?>