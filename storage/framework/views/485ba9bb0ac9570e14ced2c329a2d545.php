<?php # [BlazeFolded]:{flux::heading}:{/Users/macbookair/Documents/mediction/mediction.id/vendor/livewire/flux/src/../stubs/resources/views/flux/heading.blade.php}:{1781835918} ?>
<?php # [BlazeFolded]:{flux::heading}:{/Users/macbookair/Documents/mediction/mediction.id/vendor/livewire/flux/src/../stubs/resources/views/flux/heading.blade.php}:{1781835918} ?>
<?php # [BlazeFolded]:{flux::select}:{/Users/macbookair/Documents/mediction/mediction.id/vendor/livewire/flux/src/../stubs/resources/views/flux/select/index.blade.php}:{1781835918} ?>
<?php # [BlazeFolded]:{flux::input}:{/Users/macbookair/Documents/mediction/mediction.id/vendor/livewire/flux/src/../stubs/resources/views/flux/input/index.blade.php}:{1781835918} ?>
<?php # [BlazeFolded]:{flux::input}:{/Users/macbookair/Documents/mediction/mediction.id/vendor/livewire/flux/src/../stubs/resources/views/flux/input/index.blade.php}:{1781835918} ?>
<?php # [BlazeFolded]:{flux::textarea}:{/Users/macbookair/Documents/mediction/mediction.id/vendor/livewire/flux/src/../stubs/resources/views/flux/textarea.blade.php}:{1781835918} ?>
<?php # [BlazeFolded]:{flux::button}:{/Users/macbookair/Documents/mediction/mediction.id/vendor/livewire/flux/src/../stubs/resources/views/flux/button/index.blade.php}:{1781835918} ?>
<?php # [BlazeFolded]:{flux::heading}:{/Users/macbookair/Documents/mediction/mediction.id/vendor/livewire/flux/src/../stubs/resources/views/flux/heading.blade.php}:{1781835918} ?>
<?php # [BlazeFolded]:{flux::badge}:{/Users/macbookair/Documents/mediction/mediction.id/vendor/livewire/flux/src/../stubs/resources/views/flux/badge/index.blade.php}:{1781835918} ?>
<?php # [BlazeFolded]:{flux::badge}:{/Users/macbookair/Documents/mediction/mediction.id/vendor/livewire/flux/src/../stubs/resources/views/flux/badge/index.blade.php}:{1781835918} ?>
<?php # [BlazeFolded]:{flux::badge}:{/Users/macbookair/Documents/mediction/mediction.id/vendor/livewire/flux/src/../stubs/resources/views/flux/badge/index.blade.php}:{1781835918} ?>
<div class="p-6">
    <div class="mb-6 flex justify-between items-center">
        <?php ob_start(); ?><div class="font-medium [:where(&amp;)]:text-zinc-800 [:where(&amp;)]:dark:text-white text-2xl [&amp;:has(+[data-flux-subheading])]:mb-2 [[data-flux-subheading]+&amp;]:mt-2" data-flux-heading><?php ob_start(); ?>Pengajuan Ijin & Cuti<?php echo trim(ob_get_clean()); ?></div>
<?php echo ltrim(ob_get_clean()); ?>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Form Section -->
        <div class="bg-white p-6 rounded-lg shadow border border-gray-200 lg:col-span-1">
            <?php ob_start(); ?><div class="font-medium [:where(&amp;)]:text-zinc-800 [:where(&amp;)]:dark:text-white text-base [&amp;:has(+[data-flux-subheading])]:mb-2 [[data-flux-subheading]+&amp;]:mt-2 mb-4" data-flux-heading><?php ob_start(); ?>Buat Pengajuan Baru<?php echo trim(ob_get_clean()); ?></div>
<?php echo ltrim(ob_get_clean()); ?>
            
            <form wire:submit.prevent="submitLeave" class="space-y-4">
                
                <?php ob_start(); ?><ui-field class="min-w-0 [&amp;:not(:has([data-flux-field])):has([data-flux-control][disabled])&gt;[data-flux-label]]:opacity-50 [&amp;:has(&gt;[data-flux-radio-group][disabled])&gt;[data-flux-label]]:opacity-50 [&amp;:has(&gt;[data-flux-checkbox-group][disabled])&gt;[data-flux-label]]:opacity-50 block *:data-flux-label:mb-3 [&amp;&gt;[data-flux-label]:has(+[data-flux-description])]:mb-2 [&amp;&gt;[data-flux-label]+[data-flux-description]]:mt-0 [&amp;&gt;[data-flux-label]+[data-flux-description]]:mb-3 [&amp;&gt;*:not([data-flux-label])+[data-flux-description]]:mt-3" data-flux-field>
    <ui-label class="inline-flex items-center text-sm font-medium  [:where(&amp;)]:text-zinc-800 [:where(&amp;)]:dark:text-white [&amp;:has([data-flux-label-trailing])]:flex" data-flux-label>
    Jenis Pengajuan

    
    
    </ui-label>
        
        
        <select
    class="appearance-none [:where(&amp;)]:w-full ps-3 pe-10 block h-10 py-2 text-base sm:text-sm leading-[1.375rem] rounded-lg shadow-xs border bg-white dark:bg-white/10 dark:disabled:bg-white/[7%] text-zinc-700 dark:text-zinc-300 disabled:text-zinc-500 dark:disabled:text-zinc-400 has-[option.placeholder:checked]:text-zinc-400 dark:has-[option.placeholder:checked]:text-zinc-400 dark:[&amp;&gt;option]:bg-zinc-700 dark:[&amp;&gt;option]:text-white disabled:shadow-none border border-zinc-200 border-b-zinc-300/80 dark:border-white/10" wire:model="type" label="Jenis Pengajuan"
         name="type"         data-flux-control
    data-flux-select-native
    data-flux-group-target
>
    
    <?php ob_start(); ?>
                    <option value="annual">Cuti Tahunan</option>
                    <option value="sick">Sakit</option>
                    <option value="permission">Ijin Khusus</option>
                <?php echo trim(ob_get_clean()); ?>

</select>

        
        <?php if (isset($scope)) $__scope = $scope; ?><?php $scope = array (
  'attributes' => 
  array (
    'name' => 'type',
  ),
); ?>
        <?php $__blaze->ensureRequired('/Users/macbookair/Documents/mediction/mediction.id/vendor/livewire/flux/src/../stubs/resources/views/flux/error.blade.php', $__blaze->compiledPath.'/2ee447fcce7bc37ea277dca40628c725.php'); ?>
<?php $__blaze->pushData(['attributes' => new \Illuminate\View\ComponentAttributeBag($scope['attributes'])]); ?>
<?php _2ee447fcce7bc37ea277dca40628c725($__blaze, ['attributes' => new \Illuminate\View\ComponentAttributeBag($scope['attributes'])], [], ['attributes'], [], $__this ?? (isset($this) ? $this : null)); ?>
<?php $__blaze->popData(); ?><?php if (isset($__scope)) { $scope = $__scope; unset($__scope); } ?>
</ui-field>
<?php echo ltrim(ob_get_clean()); ?>
                
                <div class="grid grid-cols-2 gap-4">
                    <?php ob_start(); ?><ui-field class="min-w-0 [&amp;:not(:has([data-flux-field])):has([data-flux-control][disabled])&gt;[data-flux-label]]:opacity-50 [&amp;:has(&gt;[data-flux-radio-group][disabled])&gt;[data-flux-label]]:opacity-50 [&amp;:has(&gt;[data-flux-checkbox-group][disabled])&gt;[data-flux-label]]:opacity-50 block *:data-flux-label:mb-3 [&amp;&gt;[data-flux-label]:has(+[data-flux-description])]:mb-2 [&amp;&gt;[data-flux-label]+[data-flux-description]]:mt-0 [&amp;&gt;[data-flux-label]+[data-flux-description]]:mb-3 [&amp;&gt;*:not([data-flux-label])+[data-flux-description]]:mt-3" data-flux-field>
    <ui-label class="inline-flex items-center text-sm font-medium  [:where(&amp;)]:text-zinc-800 [:where(&amp;)]:dark:text-white [&amp;:has([data-flux-label-trailing])]:flex" data-flux-label>
    Mulai Tanggal

    
    
    </ui-label>
        
        
        <div class="w-full relative block group/input" data-flux-input>
            
            <input
                type="date"
                
                class="w-full border rounded-lg block disabled:shadow-none dark:shadow-none appearance-none text-base sm:text-sm py-2 h-10 leading-[1.375rem] ps-3 pe-3 bg-white dark:bg-white/10 dark:disabled:bg-white/[7%] text-zinc-700 disabled:text-zinc-500 placeholder-zinc-400 disabled:placeholder-zinc-400/70 dark:text-zinc-300 dark:disabled:text-zinc-400 dark:placeholder-zinc-400 dark:disabled:placeholder-zinc-500 shadow-xs border-zinc-200 border-b-zinc-300/80 disabled:border-b-zinc-200 dark:border-white/10 dark:disabled:border-white/5 data-invalid:shadow-none data-invalid:border-red-500 dark:data-invalid:border-red-500 disabled:data-invalid:border-red-500 dark:disabled:data-invalid:border-red-500" wire:model="start_date" label="Mulai Tanggal" required="required"
                 name="start_date"                                                 <?php if (isset($scope)) $__scope = $scope; ?><?php $scope = array (
  'name' => 'start_date',
  'invalid' => false,
); ?>
                <?php if ($scope['invalid'] || ($scope['name'] && $errors->has($scope['name']))): ?>
                aria-invalid="true" data-invalid
                <?php endif; ?>
                <?php if (isset($__scope)) { $scope = $__scope; unset($__scope); } ?>
                data-flux-control
                data-flux-group-target
                                            >

                    </div>

        
        <?php if (isset($scope)) $__scope = $scope; ?><?php $scope = array (
  'attributes' => 
  array (
    'name' => 'start_date',
  ),
); ?>
        <?php $__blaze->ensureRequired('/Users/macbookair/Documents/mediction/mediction.id/vendor/livewire/flux/src/../stubs/resources/views/flux/error.blade.php', $__blaze->compiledPath.'/2ee447fcce7bc37ea277dca40628c725.php'); ?>
<?php $__blaze->pushData(['attributes' => new \Illuminate\View\ComponentAttributeBag($scope['attributes'])]); ?>
<?php _2ee447fcce7bc37ea277dca40628c725($__blaze, ['attributes' => new \Illuminate\View\ComponentAttributeBag($scope['attributes'])], [], ['attributes'], [], $__this ?? (isset($this) ? $this : null)); ?>
<?php $__blaze->popData(); ?><?php if (isset($__scope)) { $scope = $__scope; unset($__scope); } ?>
</ui-field>
<?php echo ltrim(ob_get_clean()); ?>
                    <?php ob_start(); ?><ui-field class="min-w-0 [&amp;:not(:has([data-flux-field])):has([data-flux-control][disabled])&gt;[data-flux-label]]:opacity-50 [&amp;:has(&gt;[data-flux-radio-group][disabled])&gt;[data-flux-label]]:opacity-50 [&amp;:has(&gt;[data-flux-checkbox-group][disabled])&gt;[data-flux-label]]:opacity-50 block *:data-flux-label:mb-3 [&amp;&gt;[data-flux-label]:has(+[data-flux-description])]:mb-2 [&amp;&gt;[data-flux-label]+[data-flux-description]]:mt-0 [&amp;&gt;[data-flux-label]+[data-flux-description]]:mb-3 [&amp;&gt;*:not([data-flux-label])+[data-flux-description]]:mt-3" data-flux-field>
    <ui-label class="inline-flex items-center text-sm font-medium  [:where(&amp;)]:text-zinc-800 [:where(&amp;)]:dark:text-white [&amp;:has([data-flux-label-trailing])]:flex" data-flux-label>
    Sampai Tanggal

    
    
    </ui-label>
        
        
        <div class="w-full relative block group/input" data-flux-input>
            
            <input
                type="date"
                
                class="w-full border rounded-lg block disabled:shadow-none dark:shadow-none appearance-none text-base sm:text-sm py-2 h-10 leading-[1.375rem] ps-3 pe-3 bg-white dark:bg-white/10 dark:disabled:bg-white/[7%] text-zinc-700 disabled:text-zinc-500 placeholder-zinc-400 disabled:placeholder-zinc-400/70 dark:text-zinc-300 dark:disabled:text-zinc-400 dark:placeholder-zinc-400 dark:disabled:placeholder-zinc-500 shadow-xs border-zinc-200 border-b-zinc-300/80 disabled:border-b-zinc-200 dark:border-white/10 dark:disabled:border-white/5 data-invalid:shadow-none data-invalid:border-red-500 dark:data-invalid:border-red-500 disabled:data-invalid:border-red-500 dark:disabled:data-invalid:border-red-500" wire:model="end_date" label="Sampai Tanggal" required="required"
                 name="end_date"                                                 <?php if (isset($scope)) $__scope = $scope; ?><?php $scope = array (
  'name' => 'end_date',
  'invalid' => false,
); ?>
                <?php if ($scope['invalid'] || ($scope['name'] && $errors->has($scope['name']))): ?>
                aria-invalid="true" data-invalid
                <?php endif; ?>
                <?php if (isset($__scope)) { $scope = $__scope; unset($__scope); } ?>
                data-flux-control
                data-flux-group-target
                                            >

                    </div>

        
        <?php if (isset($scope)) $__scope = $scope; ?><?php $scope = array (
  'attributes' => 
  array (
    'name' => 'end_date',
  ),
); ?>
        <?php $__blaze->ensureRequired('/Users/macbookair/Documents/mediction/mediction.id/vendor/livewire/flux/src/../stubs/resources/views/flux/error.blade.php', $__blaze->compiledPath.'/2ee447fcce7bc37ea277dca40628c725.php'); ?>
<?php $__blaze->pushData(['attributes' => new \Illuminate\View\ComponentAttributeBag($scope['attributes'])]); ?>
<?php _2ee447fcce7bc37ea277dca40628c725($__blaze, ['attributes' => new \Illuminate\View\ComponentAttributeBag($scope['attributes'])], [], ['attributes'], [], $__this ?? (isset($this) ? $this : null)); ?>
<?php $__blaze->popData(); ?><?php if (isset($__scope)) { $scope = $__scope; unset($__scope); } ?>
</ui-field>
<?php echo ltrim(ob_get_clean()); ?>
                </div>
                
                <?php ob_start(); ?><ui-field class="min-w-0 [&amp;:not(:has([data-flux-field])):has([data-flux-control][disabled])&gt;[data-flux-label]]:opacity-50 [&amp;:has(&gt;[data-flux-radio-group][disabled])&gt;[data-flux-label]]:opacity-50 [&amp;:has(&gt;[data-flux-checkbox-group][disabled])&gt;[data-flux-label]]:opacity-50 block *:data-flux-label:mb-3 [&amp;&gt;[data-flux-label]:has(+[data-flux-description])]:mb-2 [&amp;&gt;[data-flux-label]+[data-flux-description]]:mt-0 [&amp;&gt;[data-flux-label]+[data-flux-description]]:mb-3 [&amp;&gt;*:not([data-flux-label])+[data-flux-description]]:mt-3" data-flux-field>
    <ui-label class="inline-flex items-center text-sm font-medium  [:where(&amp;)]:text-zinc-800 [:where(&amp;)]:dark:text-white [&amp;:has([data-flux-label-trailing])]:flex" data-flux-label>
    Alasan / Keterangan

    
    
    </ui-label>
        
        
        <textarea
        class="block p-3 w-full shadow-xs disabled:shadow-none border rounded-lg bg-white dark:bg-white/10 dark:disabled:bg-white/[7%] resize-y text-base sm:text-sm text-zinc-700 disabled:text-zinc-500 placeholder-zinc-400 disabled:placeholder-zinc-400/70 dark:text-zinc-300 dark:disabled:text-zinc-400 dark:placeholder-zinc-400 dark:disabled:placeholder-zinc-500 border-zinc-200 border-b-zinc-300/80 dark:border-white/10 data-invalid:shadow-none data-invalid:border-red-500 dark:data-invalid:border-red-500" wire:model="reason" label="Alasan / Keterangan" required="required"
        rows="3"
        style="resize: vertical; "
         name="reason"         <?php if (isset($scope)) $__scope = $scope; ?><?php $scope = array (
  'name' => 'reason',
  'invalid' => false,
); ?>
        <?php if ($scope['invalid'] || ($scope['name'] && $errors->has($scope['name']))): ?>
        aria-invalid="true" data-invalid
        <?php endif; ?>
        <?php if (isset($__scope)) { $scope = $__scope; unset($__scope); } ?>
        data-flux-control
        data-flux-textarea
    ></textarea>

        
        <?php if (isset($scope)) $__scope = $scope; ?><?php $scope = array (
  'attributes' => 
  array (
    'name' => 'reason',
  ),
); ?>
        <?php $__blaze->ensureRequired('/Users/macbookair/Documents/mediction/mediction.id/vendor/livewire/flux/src/../stubs/resources/views/flux/error.blade.php', $__blaze->compiledPath.'/2ee447fcce7bc37ea277dca40628c725.php'); ?>
<?php $__blaze->pushData(['attributes' => new \Illuminate\View\ComponentAttributeBag($scope['attributes'])]); ?>
<?php _2ee447fcce7bc37ea277dca40628c725($__blaze, ['attributes' => new \Illuminate\View\ComponentAttributeBag($scope['attributes'])], [], ['attributes'], [], $__this ?? (isset($this) ? $this : null)); ?>
<?php $__blaze->popData(); ?><?php if (isset($__scope)) { $scope = $__scope; unset($__scope); } ?>
</ui-field>
<?php echo ltrim(ob_get_clean()); ?>
                
                <div class="space-y-1">
                    <label class="text-sm font-medium text-gray-700">Lampiran Bukti (Opsional)</label>
                    <input type="file" wire:model="attachment" class="w-full text-sm text-gray-500
                        file:mr-4 file:py-2 file:px-4
                        file:rounded file:border-0
                        file:text-sm file:font-semibold
                        file:bg-emerald-50 file:text-emerald-700
                        hover:file:bg-emerald-100 border p-2 rounded"
                        accept=".pdf,.jpg,.jpeg,.png">
                    <div wire:loading wire:target="attachment" class="text-xs text-blue-500 mt-1">Mengunggah...</div>
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__errorArgs = ['attachment'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <span class="text-red-500 text-xs"><?php echo e($message); ?></span> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                </div>
                
                <?php ob_start(); ?><button type="submit" class="relative items-center font-medium justify-center gap-2 whitespace-nowrap disabled:opacity-75 dark:disabled:opacity-75 disabled:cursor-default disabled:pointer-events-none justify-center h-10 text-sm rounded-lg ps-4 pe-4 inline-flex  bg-[var(--color-accent)] hover:bg-[color-mix(in_oklab,_var(--color-accent),_transparent_10%)] text-[var(--color-accent-foreground)] border border-black/10 dark:border-0 shadow-[inset_0px_1px_--theme(--color-white/.2)] [[data-flux-button-group]_&amp;]:border-e-0 [:is([data-flux-button-group]&gt;&amp;:last-child,_[data-flux-button-group]_:last-child&gt;&amp;)]:border-e-[1px] dark:[:is([data-flux-button-group]&gt;&amp;:last-child,_[data-flux-button-group]_:last-child&gt;&amp;)]:border-e-0 dark:[:is([data-flux-button-group]&gt;&amp;:last-child,_[data-flux-button-group]_:last-child&gt;&amp;)]:border-s-[1px] [:is([data-flux-button-group]&gt;&amp;:not(:first-child),_[data-flux-button-group]_:not(:first-child)&gt;&amp;)]:border-s-[color-mix(in_srgb,var(--color-accent-foreground),transparent_85%)] *:transition-opacity [&amp;[disabled]&gt;:not([data-flux-loading-indicator])]:opacity-0 [&amp;[disabled]&gt;[data-flux-loading-indicator]]:opacity-100 [&amp;[disabled]]:pointer-events-none [--color-accent:var(--color-blue-500)] [--color-accent-content:var(--color-blue-600)] [--color-accent-foreground:var(--color-white)] dark:[--color-accent:var(--color-blue-500)] dark:[--color-accent-content:var(--color-blue-400)] dark:[--color-accent-foreground:var(--color-white)] w-full" data-flux-button="data-flux-button" data-flux-group-target="data-flux-group-target" wire:loading.attr="disabled">
        <div class="absolute inset-0 flex items-center justify-center opacity-0" data-flux-loading-indicator>
                <svg class="shrink-0 [:where(&amp;)]:size-4 animate-spin" data-flux-icon xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" aria-hidden="true" data-slot="icon">
    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
</svg>
                    </div>
        
        
                    
            
            <span><?php ob_start(); ?>
                    Kirim Pengajuan
                <?php echo trim(ob_get_clean()); ?></span>
    </button>
<?php echo ltrim(ob_get_clean()); ?>
            </form>
        </div>

        <!-- History Section -->
        <div class="bg-white p-6 rounded-lg shadow border border-gray-200 lg:col-span-2">
            <?php ob_start(); ?><div class="font-medium [:where(&amp;)]:text-zinc-800 [:where(&amp;)]:dark:text-white text-base [&amp;:has(+[data-flux-subheading])]:mb-2 [[data-flux-subheading]+&amp;]:mt-2 mb-4" data-flux-heading><?php ob_start(); ?>Riwayat Pengajuan<?php echo trim(ob_get_clean()); ?></div>
<?php echo ltrim(ob_get_clean()); ?>
            
            <div class="overflow-x-auto">
                <table class="w-full text-sm text-left">
                    <thead class="text-xs text-gray-700 bg-gray-50 uppercase border-b border-gray-200">
                        <tr>
                            <th class="px-4 py-3">Tanggal Pengajuan</th>
                            <th class="px-4 py-3">Jenis</th>
                            <th class="px-4 py-3">Tgl Mulai - Selesai</th>
                            <th class="px-4 py-3">Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__empty_5 = true; $__currentLoopData = $leaves; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $leave): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_5 = false; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoopIteration(); ?><?php endif; ?>
                        <tr class="border-b border-gray-100 hover:bg-gray-50">
                            <td class="px-4 py-3 text-gray-500"><?php echo e(\Carbon\Carbon::parse($leave->created_at)->format('d M Y H:i')); ?></td>
                            <td class="px-4 py-3 font-medium">
                                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($leave->type == 'annual'): ?> Cuti Tahunan 
                                <?php elseif($leave->type == 'sick'): ?> Sakit 
                                <?php else: ?> Ijin Khusus <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                            </td>
                            <td class="px-4 py-3">
                                <?php echo e(\Carbon\Carbon::parse($leave->start_date)->format('d M')); ?> - 
                                <?php echo e(\Carbon\Carbon::parse($leave->end_date)->format('d M Y')); ?>

                            </td>
                            <td class="px-4 py-3">
                                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($leave->status == 'pending'): ?>
                                    <?php ob_start(); ?><div data-flux-badge="data-flux-badge" class="inline-flex items-center font-medium whitespace-nowrap  [print-color-adjust:exact] text-sm py-1 **:data-flux-badge-icon:me-1.5 rounded-md px-2 text-zinc-700 [&amp;_button]:text-zinc-700! dark:text-zinc-200 dark:[&amp;_button]:text-zinc-200! bg-zinc-400/15 dark:bg-zinc-400/40 [&amp;:is(button)]:hover:bg-zinc-400/25 dark:[button]:hover:bg-zinc-400/50">
        <?php ob_start(); ?>Pending<?php echo trim(ob_get_clean()); ?>

    </div>
<?php echo ltrim(ob_get_clean()); ?>
                                <?php elseif($leave->status == 'approved'): ?>
                                    <?php ob_start(); ?><div data-flux-badge="data-flux-badge" class="inline-flex items-center font-medium whitespace-nowrap  [print-color-adjust:exact] text-sm py-1 **:data-flux-badge-icon:me-1.5 rounded-md px-2 text-zinc-700 [&amp;_button]:text-zinc-700! dark:text-zinc-200 dark:[&amp;_button]:text-zinc-200! bg-zinc-400/15 dark:bg-zinc-400/40 [&amp;:is(button)]:hover:bg-zinc-400/25 dark:[button]:hover:bg-zinc-400/50">
        <?php ob_start(); ?>Disetujui<?php echo trim(ob_get_clean()); ?>

    </div>
<?php echo ltrim(ob_get_clean()); ?>
                                <?php else: ?>
                                    <?php ob_start(); ?><div data-flux-badge="data-flux-badge" class="inline-flex items-center font-medium whitespace-nowrap  [print-color-adjust:exact] text-sm py-1 **:data-flux-badge-icon:me-1.5 rounded-md px-2 text-zinc-700 [&amp;_button]:text-zinc-700! dark:text-zinc-200 dark:[&amp;_button]:text-zinc-200! bg-zinc-400/15 dark:bg-zinc-400/40 [&amp;:is(button)]:hover:bg-zinc-400/25 dark:[button]:hover:bg-zinc-400/50">
        <?php ob_start(); ?>Ditolak<?php echo trim(ob_get_clean()); ?>

    </div>
<?php echo ltrim(ob_get_clean()); ?>
                                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                            </td>
                        </tr>
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_5): ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
                        <tr>
                            <td colspan="4" class="px-4 py-8 text-center text-gray-500">Belum ada riwayat pengajuan.</td>
                        </tr>
                        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div><?php /**PATH /Users/macbookair/Documents/mediction/mediction.id/resources/views/livewire/admin/hr/leave/admin-hr-leave-index.blade.php ENDPATH**/ ?>