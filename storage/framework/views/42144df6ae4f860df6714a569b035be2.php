<?php # [BlazeFolded]:{flux::button}:{/Users/macbookair/Documents/mediction/mediction.id/vendor/livewire/flux/src/../stubs/resources/views/flux/button/index.blade.php}:{1781835918} ?>
<?php # [BlazeFolded]:{flux::input}:{/Users/macbookair/Documents/mediction/mediction.id/vendor/livewire/flux/src/../stubs/resources/views/flux/input/index.blade.php}:{1781835918} ?>
<?php # [BlazeFolded]:{flux::input}:{/Users/macbookair/Documents/mediction/mediction.id/vendor/livewire/flux/src/../stubs/resources/views/flux/input/index.blade.php}:{1781835918} ?>
<?php # [BlazeFolded]:{flux::input}:{/Users/macbookair/Documents/mediction/mediction.id/vendor/livewire/flux/src/../stubs/resources/views/flux/input/index.blade.php}:{1781835918} ?>
<?php # [BlazeFolded]:{flux::button}:{/Users/macbookair/Documents/mediction/mediction.id/vendor/livewire/flux/src/../stubs/resources/views/flux/button/index.blade.php}:{1781835918} ?>
<?php # [BlazeFolded]:{flux::button}:{/Users/macbookair/Documents/mediction/mediction.id/vendor/livewire/flux/src/../stubs/resources/views/flux/button/index.blade.php}:{1781835918} ?>
<div>
    <div class="mb-6">
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-2xl font-bold text-[#1E3A8A]">Perbaikan Stok & Harga</h1>
                <p class="text-gray-500 text-sm">Sesuaikan stok, HNA, dan harga jual produk secara langsung jika terjadi
                    kesalahan data.</p>
            </div>
            <div class="flex gap-2">
                <?php ob_start(); ?><a href="<?php echo e(route('user.logistic.product-stock')); ?>" data-flux-button="data-flux-button" class="relative items-center font-medium justify-center gap-2 whitespace-nowrap disabled:opacity-75 dark:disabled:opacity-75 disabled:cursor-default disabled:pointer-events-none justify-center h-10 text-sm rounded-lg ps-3 pe-4 inline-flex  bg-transparent hover:bg-zinc-800/5 dark:hover:bg-white/15 text-zinc-800 dark:text-white">
        <svg class="shrink-0 [:where(&amp;)]:size-4" data-flux-icon xmlns="http://www.w3.org/2000/svg" viewBox="0 0 16 16" fill="currentColor" aria-hidden="true" data-slot="icon">
  <path fill-rule="evenodd" d="M14 8a.75.75 0 0 1-.75.75H4.56l3.22 3.22a.75.75 0 1 1-1.06 1.06l-4.5-4.5a.75.75 0 0 1 0-1.06l4.5-4.5a.75.75 0 0 1 1.06 1.06L4.56 7.25h8.69A.75.75 0 0 1 14 8Z" clip-rule="evenodd"/>
</svg>

                
                    
            
            <span><?php ob_start(); ?>
                    Kembali ke Stok
                <?php echo trim(ob_get_clean()); ?></span>
    </a>
<?php echo ltrim(ob_get_clean()); ?>
            </div>
        </div>
    </div>

    <!-- Table Controls -->
    <div class="bg-white/80 backdrop-blur-sm rounded-xl shadow-lg border border-gray-100 p-4 mb-6">
        <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
            <div class="flex items-center">
                <span class="text-sm text-gray-700 mr-2">Tampil</span>
                <select class="form-control h-10 py-1" wire:model.live='perPage'>
                    <option value="5">5</option>
                    <option value="10">10</option>
                    <option value="25">25</option>
                    <option value="50">50</option>
                </select>
                <span class="text-sm text-gray-700 ml-2">data</span>
            </div>

            <div class="relative w-full sm:w-80">
                <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                    <i class="fas fa-search text-gray-400"></i>
                </div>
                <input type="text" class="form-control-search pl-10" placeholder="Cari Nama Produk atau SKU..."
                    wire:model.live.debounce.300ms='search'>
            </div>
        </div>
    </div>

    <!-- Table Section -->
    <div class="bg-white/80 backdrop-blur-sm rounded-xl shadow-lg border border-gray-100 overflow-hidden mb-6">
        <div class="table-container overflow-x-auto">
            <table class="table min-w-full">
                <thead>
                    <tr class="bg-gray-50/50">
                        <th class="w-1 text-center py-4">No</th>
                        <th class="py-4">Informasi Produk</th>
                        <th class="text-right py-4">Stok Saat Ini</th>
                        <th class="py-4">Penyesuaian Stok</th>
                        <th class="py-4">HNA (HPP Rata-rata)</th>
                        <th class="py-4">Harga Jual</th>
                        <th class="text-center py-4">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__empty_1 = true; $__currentLoopData = $products; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $product): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoopIteration(); ?><?php endif; ?>
                        <tr <?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::$currentLoop['key'] = 'product-'.e($product->id).''; ?>wire:key="product-<?php echo e($product->id); ?>" class="hover:bg-blue-50/30 transition-colors">
                            <td class="text-center text-gray-500 font-medium">
                                <?php echo e($products->firstItem() + $index); ?>

                            </td>
                            <td class="py-4">
                                <div class="font-bold text-[#1E3A8A] leading-tight"><?php echo e($product->name); ?></div>
                                <div class="flex items-center gap-2 mt-1">
                                    <span
                                        class="text-[10px] px-1.5 py-0.5 bg-gray-100 text-gray-600 rounded font-mono uppercase tracking-wider">
                                        <?php echo e($product->sku_number ?: 'NO-SKU'); ?>

                                    </span>
                                    <span class="text-[10px] px-1.5 py-0.5 bg-blue-50 text-blue-600 rounded font-medium">
                                        <?php echo e($product->unit->name ?? '-'); ?>

                                    </span>
                                </div>
                            </td>
                            <td class="text-right py-4 font-semibold text-gray-700">
                                <?php echo e(number_format($product->productStock->quantity ?? 0)); ?>

                            </td>
                            <td class="py-4">
                                <div class="relative max-w-[140px]">
                                    <?php ob_start(); ?><div class="w-full relative block group/input !h-9 text-sm" data-flux-input>
            
            <input
                type="number"
                
                class="w-full border rounded-lg block disabled:shadow-none dark:shadow-none appearance-none text-base sm:text-sm py-2 h-10 leading-[1.375rem] ps-3 pe-3 bg-white dark:bg-white/10 dark:disabled:bg-white/[7%] text-zinc-700 disabled:text-zinc-500 placeholder-zinc-400 disabled:placeholder-zinc-400/70 dark:text-zinc-300 dark:disabled:text-zinc-400 dark:placeholder-zinc-400 dark:disabled:placeholder-zinc-500 shadow-xs border-zinc-200 border-b-zinc-300/80 disabled:border-b-zinc-200 dark:border-white/10 dark:disabled:border-white/5 data-invalid:shadow-none data-invalid:border-red-500 dark:data-invalid:border-red-500 disabled:data-invalid:border-red-500 dark:disabled:data-invalid:border-red-500" wire:model="editingStocks.<?php echo e($product->id); ?>" placeholder="<?php echo e($product->productStock->quantity ?? 0); ?>"                 name="editingStocks.<?php echo e($product->id); ?>"                                                 <?php if (isset($scope)) $__scope = $scope; ?><?php $scope = array (
  'name' => 'editingStocks.'.e($product->id),
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
<?php echo ltrim(ob_get_clean()); ?>
                                </div>
                            </td>
                            <td class="py-4">
                                <div class="relative max-w-[160px]">
                                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none z-10">
                                        <span class="text-gray-400 text-xs font-medium">Rp</span>
                                    </div>
                                    <?php ob_start(); ?><div class="w-full relative block group/input !h-9 pl-8 text-sm" data-flux-input>
            
            <input
                type="number"
                
                class="w-full border rounded-lg block disabled:shadow-none dark:shadow-none appearance-none text-base sm:text-sm py-2 h-10 leading-[1.375rem] ps-3 pe-3 bg-white dark:bg-white/10 dark:disabled:bg-white/[7%] text-zinc-700 disabled:text-zinc-500 placeholder-zinc-400 disabled:placeholder-zinc-400/70 dark:text-zinc-300 dark:disabled:text-zinc-400 dark:placeholder-zinc-400 dark:disabled:placeholder-zinc-500 shadow-xs border-zinc-200 border-b-zinc-300/80 disabled:border-b-zinc-200 dark:border-white/10 dark:disabled:border-white/5 data-invalid:shadow-none data-invalid:border-red-500 dark:data-invalid:border-red-500 disabled:data-invalid:border-red-500 dark:disabled:data-invalid:border-red-500" wire:model="editingHnas.<?php echo e($product->id); ?>" placeholder="<?php echo e(number_format($product->productPrice->hpp_average ?? 0, 0, '', '')); ?>"                 name="editingHnas.<?php echo e($product->id); ?>"                                                 <?php if (isset($scope)) $__scope = $scope; ?><?php $scope = array (
  'name' => 'editingHnas.'.e($product->id),
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
<?php echo ltrim(ob_get_clean()); ?>
                                </div>
                            </td>
                            <td class="py-4">
                                <div class="relative max-w-[160px]">
                                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none z-10">
                                        <span class="text-gray-400 text-xs font-medium">Rp</span>
                                    </div>
                                    <?php ob_start(); ?><div class="w-full relative block group/input !h-9 pl-8 text-sm" data-flux-input>
            
            <input
                type="number"
                
                class="w-full border rounded-lg block disabled:shadow-none dark:shadow-none appearance-none text-base sm:text-sm py-2 h-10 leading-[1.375rem] ps-3 pe-3 bg-white dark:bg-white/10 dark:disabled:bg-white/[7%] text-zinc-700 disabled:text-zinc-500 placeholder-zinc-400 disabled:placeholder-zinc-400/70 dark:text-zinc-300 dark:disabled:text-zinc-400 dark:placeholder-zinc-400 dark:disabled:placeholder-zinc-500 shadow-xs border-zinc-200 border-b-zinc-300/80 disabled:border-b-zinc-200 dark:border-white/10 dark:disabled:border-white/5 data-invalid:shadow-none data-invalid:border-red-500 dark:data-invalid:border-red-500 disabled:data-invalid:border-red-500 dark:disabled:data-invalid:border-red-500" wire:model="editingPrices.<?php echo e($product->id); ?>" placeholder="<?php echo e(number_format($product->productPrice->price ?? 0, 0, '', '')); ?>"                 name="editingPrices.<?php echo e($product->id); ?>"                                                 <?php if (isset($scope)) $__scope = $scope; ?><?php $scope = array (
  'name' => 'editingPrices.'.e($product->id),
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
<?php echo ltrim(ob_get_clean()); ?>
                                </div>
                            </td>
                            <td class="text-center py-4">
                                <div class="flex items-center justify-center gap-2">
                                    <?php ob_start(); ?><button type="button" class="relative items-center font-medium justify-center gap-2 whitespace-nowrap disabled:opacity-75 dark:disabled:opacity-75 disabled:cursor-default disabled:pointer-events-none justify-center h-8 text-sm rounded-md px-3 inline-flex  bg-[var(--color-accent)] hover:bg-[color-mix(in_oklab,_var(--color-accent),_transparent_10%)] text-[var(--color-accent-foreground)] border border-black/10 dark:border-0 shadow-[inset_0px_1px_--theme(--color-white/.2)] [[data-flux-button-group]_&amp;]:border-e-0 [:is([data-flux-button-group]&gt;&amp;:last-child,_[data-flux-button-group]_:last-child&gt;&amp;)]:border-e-[1px] dark:[:is([data-flux-button-group]&gt;&amp;:last-child,_[data-flux-button-group]_:last-child&gt;&amp;)]:border-e-0 dark:[:is([data-flux-button-group]&gt;&amp;:last-child,_[data-flux-button-group]_:last-child&gt;&amp;)]:border-s-[1px] [:is([data-flux-button-group]&gt;&amp;:not(:first-child),_[data-flux-button-group]_:not(:first-child)&gt;&amp;)]:border-s-[color-mix(in_srgb,var(--color-accent-foreground),transparent_85%)] *:transition-opacity [&amp;[data-loading]&gt;:not([data-flux-loading-indicator])]:opacity-0 [&amp;[data-flux-loading]&gt;:not([data-flux-loading-indicator])]:opacity-0 [&amp;[data-loading]&gt;[data-flux-loading-indicator]]:opacity-100 [&amp;[data-flux-loading]&gt;[data-flux-loading-indicator]]:opacity-100 data-loading:pointer-events-none data-flux-loading:pointer-events-none  !py-1.5" data-flux-button="data-flux-button" data-flux-group-target="data-flux-group-target" wire:target="saveAdjustment('<?php echo e($product->id); ?>')" wire:loading.attr="disabled" wire:click="saveAdjustment('<?php echo e($product->id); ?>')">
        <div class="absolute inset-0 flex items-center justify-center opacity-0" data-flux-loading-indicator>
                <svg class="shrink-0 [:where(&amp;)]:size-4 animate-spin" data-flux-icon xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" aria-hidden="true" data-slot="icon">
    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
</svg>
                    </div>
        
        
                    
            
            <span><?php ob_start(); ?>
                                        Simpan
                                    <?php echo trim(ob_get_clean()); ?></span>
    </button>
<?php echo ltrim(ob_get_clean()); ?>
                                    <?php ob_start(); ?><button type="button" class="relative items-center font-medium justify-center gap-2 whitespace-nowrap disabled:opacity-75 dark:disabled:opacity-75 disabled:cursor-default disabled:pointer-events-none justify-center h-8 text-sm rounded-md w-8 inline-flex  bg-transparent hover:bg-zinc-800/5 dark:hover:bg-white/15 text-zinc-800 dark:text-white    *:transition-opacity [&amp;[data-loading]&gt;:not([data-flux-loading-indicator])]:opacity-0 [&amp;[data-flux-loading]&gt;:not([data-flux-loading-indicator])]:opacity-0 [&amp;[data-loading]&gt;[data-flux-loading-indicator]]:opacity-100 [&amp;[data-flux-loading]&gt;[data-flux-loading-indicator]]:opacity-100 data-loading:pointer-events-none data-flux-loading:pointer-events-none  !py-1.5 !px-2" data-flux-button="data-flux-button" wire:target="showHistory('<?php echo e($product->id); ?>')" wire:loading.attr="data-flux-loading" wire:click="showHistory('<?php echo e($product->id); ?>')" title="Lihat Histori">
        <div class="absolute inset-0 flex items-center justify-center opacity-0" data-flux-loading-indicator>
                <svg class="shrink-0 [:where(&amp;)]:size-5 animate-spin" data-flux-icon xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" aria-hidden="true" data-slot="icon">
    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
</svg>
                    </div>
        
                    <svg class="shrink-0 [:where(&amp;)]:size-5" data-flux-icon xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true" data-slot="icon">
  <path fill-rule="evenodd" d="M10 18a8 8 0 1 0 0-16 8 8 0 0 0 0 16Zm.75-13a.75.75 0 0 0-1.5 0v5c0 .414.336.75.75.75h4a.75.75 0 0 0 0-1.5h-3.25V5Z" clip-rule="evenodd"/>
</svg>
    </button>
<?php echo ltrim(ob_get_clean()); ?>
                                </div>
                            </td>
                        </tr>
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
                        <tr>
                            <td colspan="7" class="text-center py-12">
                                <div class="flex flex-col items-center">
                                    <div class="bg-gray-50 rounded-full p-4 mb-3">
                                        <i class="fas fa-box-open text-3xl text-gray-300"></i>
                                    </div>
                                    <p class="text-gray-500 font-medium">Tidak ada data produk ditemukan.</p>
                                    <p class="text-gray-400 text-xs">Coba kata kunci pencarian yang lain.</p>
                                </div>
                            </td>
                        </tr>
                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        <div class="px-6 py-4 bg-gray-50/50 border-t border-gray-100">
            <div class="flex flex-col sm:flex-row items-center justify-between gap-4">
                <div class="text-sm text-gray-500">
                    Menampilkan <span class="font-semibold text-gray-700"><?php echo e($products->firstItem()); ?></span> sampai
                    <span class="font-semibold text-gray-700"><?php echo e($products->lastItem()); ?></span> dari <span
                        class="font-semibold text-gray-700"><?php echo e($products->total()); ?></span> produk
                </div>
                <div>
                    <?php echo e($products->links('vendor.livewire.custom')); ?>

                </div>
            </div>
        </div>
    </div>

    <!-- History Modal -->
    <!-- History Modal -->
    <div wire:ignore.self id="history-modal"
        class="fixed inset-0 bg-gray-900/50 backdrop-blur-sm hidden items-center justify-center z-50 transition-opacity duration-300 ease-in-out">
        <div
            class="bg-white rounded-2xl shadow-2xl max-w-4xl w-full transform transition-all scale-95 duration-300 ease-out animate-fade-in">
            <!-- Header -->
            <div class="flex justify-between items-center p-6 border-b">
                <div class="flex items-center gap-4">
                    <i class="fas fa-history text-blue-500 text-xl"></i>
                    <div>
                        <h2 class="text-xl font-semibold text-gray-800">Histori Harga & HNA</h2>
                        <p class="text-sm text-gray-500"><?php echo e($selectedProductName); ?></p>
                    </div>
                </div>
                <button onclick="document.getElementById('history-modal').classList.add('hidden'); document.getElementById('history-modal').classList.remove('flex');"
                    class="text-gray-400 hover:text-red-500 transition-colors text-2xl leading-none cursor-pointer">
                    <i class="fas fa-times"></i>
                </button>
            </div>

            <!-- Body -->
            <div class="px-6 py-4" style="max-height: 70vh; overflow-y: auto;">
                <div class="table-container overflow-x-auto rounded-lg border border-gray-100">
                    <table class="table min-w-full text-sm">
                        <thead>
                            <tr class="bg-gray-50">
                                <th class="py-3">Tanggal</th>
                                <th class="text-right py-3">Harga Jual</th>
                                <th class="text-right py-3">HNA (HPP)</th>
                                <th class="text-center py-3">Stok Saat Itu</th>
                                <th class="py-3">Petugas</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100">
                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__empty_1 = true; $__currentLoopData = $priceHistory; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $history): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoopIteration(); ?><?php endif; ?>
                                <tr class="hover:bg-gray-50/50 transition-colors">
                                    <td class="py-3 font-medium text-gray-600">
                                        <?php echo e($history->created_at->format('d/m/Y')); ?>

                                        <div class="text-[10px] text-gray-400"><?php echo e($history->created_at->format('H:i')); ?></div>
                                    </td>
                                    <td class="text-right py-3 font-bold text-blue-600">
                                        Rp <?php echo e(number_format($history->price, 0, ',', '.')); ?>

                                    </td>
                                    <td class="text-right py-3 font-semibold text-gray-700">
                                        Rp <?php echo e(number_format($history->hpp_average, 0, ',', '.')); ?>

                                    </td>
                                    <td class="text-center py-3">
                                        <span class="px-2 py-0.5 bg-gray-100 text-gray-600 rounded-full text-xs font-medium">
                                            <?php echo e(number_format($history->quantity)); ?>

                                        </span>
                                    </td>
                                    <td class="py-3 text-gray-500">
                                        <?php echo e($history->user->name ?? '-'); ?>

                                    </td>
                                </tr>
                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
                                <tr>
                                    <td colspan="5" class="text-center py-8 text-gray-400 italic">
                                        Belum ada histori harga untuk produk ini.
                                    </td>
                                </tr>
                            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Footer -->
            <div class="flex justify-end items-center px-6 py-4 border-t bg-gray-50 rounded-b-2xl">
                <button onclick="document.getElementById('history-modal').classList.add('hidden'); document.getElementById('history-modal').classList.remove('flex');"
                    class="px-6 py-2 bg-gray-200 hover:bg-gray-300 text-gray-800 rounded-lg shadow-sm transition font-medium cursor-pointer">
                    Tutup
                </button>
            </div>
        </div>
    </div>

    <!-- Notification Scripts -->
    <script>
        window.addEventListener('notify', event => {
            const data = event.detail[0] || event.detail;
            Swal.fire({
                icon: data.type,
                title: data.message,
                toast: true,
                position: 'top-end',
                showConfirmButton: false,
                timer: 3000,
                timerProgressBar: true,
            });
        });
    </script>
</div><?php /**PATH /Users/macbookair/Documents/mediction/mediction.id/resources/views/livewire/admin/logistic/product-adjustment/admin-logistic-product-adjustment-index.blade.php ENDPATH**/ ?>