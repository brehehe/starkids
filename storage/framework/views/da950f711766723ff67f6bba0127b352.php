<div>
    <div class="mb-4">
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-2xl font-bold text-[#1E3A8A]">Pasien Konsultasi</h1>
            </div>
        </div>
    </div>
    <div class="p-6 bg-white shadow rounded-lg mb-4">
        <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
            <div>
                <label class="block text-sm font-medium text-gray-700">Nama Pasien</label>
                <p class="mt-1 text-gray-900 font-semibold"><?php echo e($user->name); ?></p>
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700">Email</label>
                <p class="mt-1 text-gray-900 font-semibold"><?php echo e($user->email); ?></p>
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700">Nomor Telepon</label>
                <p class="mt-1 text-gray-900 font-semibold"><?php echo e($user->phone); ?></p>
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700">Tanggal Lahir</label>
                <p class="mt-1 text-gray-900 font-semibold">
                    <?php echo e($user?->userDetail?->birth_date ? Carbon\Carbon::parse($user?->userDetail?->birth_date)->translatedFormat('d F Y') : 'Tidak diketahui'); ?>

                </p>
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700">Jenis Kelamin</label>
                <p class="mt-1 text-gray-900 font-semibold"><?php echo e(Str::title($user?->userDetail?->administrative_gender)); ?>

                </p>
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700">Status Perkawinan</label>
                <p class="mt-1 text-gray-900 font-semibold">
                    <?php echo e($user?->userDetail?->marital_status ? $user->userDetail->marital_status : 'Tidak diketahui'); ?>

                </p>
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700">Alamat</label>
                <p class="mt-1 text-gray-900 font-semibold">
                    <?php echo e($user?->userDetail?->address ? $user->userDetail->address : 'Tidak diketahui'); ?></p>
            </div>
            <?php
                $birthDate = \Carbon\Carbon::parse($user?->userDetail?->birth_date);
                $now = \Carbon\Carbon::now();
                $diff = $birthDate->diff($now);
            ?>

            <div>
                <label class="block text-sm font-medium text-gray-700">Umur</label>
                <p class="mt-1 text-gray-900 font-semibold">
                    <?php echo e($diff->y); ?> Tahun <?php echo e($diff->m); ?> Bulan <?php echo e($diff->d); ?> Hari
                </p>
            </div>
        </div>
    </div>
    <div class="mb-4">
        <div class="overflow-x-auto  w-full">
            <nav class="flex w-full gap-2 px-2" aria-label="Tabs">
                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__currentLoopData = $get_tabs; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $get_tab): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoopIteration(); ?><?php endif; ?>
                    <button wire:click="changeTab('<?php echo e($get_tab); ?>')"
                        class="text-center px-2 py-2 text-sm font-medium transition-all duration-300 cursor-pointer rounded-2xl
                <?php echo e($tab === $get_tab ? 'bg-blue-600 text-white shadow-md' : 'bg-gray-100 text-gray-600 hover:bg-gray-200 hover:text-black'); ?>">
                        <?php echo e(Str::title(Str::replace('-', ' ', $get_tab))); ?>

                    </button>
                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
            </nav>
        </div>
    </div>
    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($tab == 'diagnosa'): ?>
        <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center mb-4 gap-4">
            <div class="flex items-center">
                <span class="text-sm text-gray-700 mr-2">Tampil</span>
                <select class="mt-1 form-control" wire:model.live='perPage'>
                    <option value="5">5</option>
                    <option value="10">10</option>
                    <option value="25">25</option>
                    <option value="50">50</option>
                    <option value="100">100</option>
                </select>
                <span class="text-sm text-gray-700 ml-2">data</span>
            </div>

            <div class="relative w-full sm:w-64">
                <input type="text" class="mt-1 form-control-search" placeholder="Cari Sesuatu..."
                    wire:model.live='search'>
                <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                    <i class="fas fa-search h-3 w-3 text-gray-400"></i>
                </div>
            </div>
        </div>

        <!-- Table Section -->
        <div class="bg-white/80 backdrop-blur-sm rounded-xl shadow-lg border border-gray-100 overflow-hidden mb-6">
            <div class="table-container">
                <table class="table">
                    <thead>
                        <tr>
                            <th class="w-1 center">No</th>
                            <th>Subjective</th>
                            <th>Objective</th>
                            <th>Assessment</th>
                            <th>Plan</th>
                            <th>Tanggal</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__empty_5 = true; $__currentLoopData = $diagnosas; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $diagnosa): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_5 = false; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoopIteration(); ?><?php endif; ?>
                            <tr>
                                <td class="center"><?php echo e($diagnosas->firstItem() + $index); ?></td>
                                <td><?php echo e($diagnosa->subjective ?? '-'); ?></td>
                                <td><?php echo e($diagnosa->objective ?? '-'); ?></td>
                                <td><?php echo e($diagnosa->assessment ?? '-'); ?></td>
                                <td><?php echo e($diagnosa->plan ?? '-'); ?></td>
                                <td><?php echo e(Carbon\Carbon::parse($diagnosa->created_at)->translatedFormat('d F Y') ?? '-'); ?>

                                </td>
                            </tr>
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_5): ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
                            <tr>
                                <td colspan="10" class="no-data">Tidak ada data</td>
                            </tr>
                        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            <div class="px-5 py-4 bg-gray-50/80 border-t border-gray-200">
                <div class="flex items-center justify-between">
                    <div class="text-sm text-gray-700">
                        Menampilkan <span class="font-medium"><?php echo e($diagnosas->firstItem()); ?></span> sampai <span
                            class="font-medium"><?php echo e($diagnosas->lastItem()); ?></span> dari <span
                            class="font-medium"><?php echo e($diagnosas->total()); ?></span> hasil
                    </div>
                    <div>
                        <nav class="relative z-0 inline-flex rounded-md shadow-sm -space-x-px" aria-label="Pagination">
                            <?php echo e($diagnosas->links('vendor.livewire.custom')); ?> <!-- Menampilkan pagination -->
                        </nav>
                    </div>
                </div>
            </div>
        </div>
    <?php elseif($tab == 'alergi'): ?>
        <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center mb-4 gap-4">
            <div class="flex items-center">
                <span class="text-sm text-gray-700 mr-2">Tampil</span>
                <select class="mt-1 form-control" wire:model.live='perPage'>
                    <option value="5">5</option>
                    <option value="10">10</option>
                    <option value="25">25</option>
                    <option value="50">50</option>
                    <option value="100">100</option>
                </select>
                <span class="text-sm text-gray-700 ml-2">data</span>
            </div>

            <div class="relative w-full sm:w-64">
                <input type="text" class="mt-1 form-control-search" placeholder="Cari Sesuatu..."
                    wire:model.live='search'>
                <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                    <i class="fas fa-search h-3 w-3 text-gray-400"></i>
                </div>
            </div>
        </div>

        <!-- Table Section -->
        <div class="bg-white/80 backdrop-blur-sm rounded-xl shadow-lg border border-gray-100 overflow-hidden mb-6">
            <div class="table-container">
                <table class="table">
                    <thead>
                        <tr>
                            <th class="w-1 center">No</th>
                            <th>Alergi Obat</th>
                            <th>Tanggal</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__empty_5 = true; $__currentLoopData = $alergis; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $alergi): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_5 = false; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoopIteration(); ?><?php endif; ?>
                            <tr>
                                <td class="center"><?php echo e($alergis->firstItem() + $index); ?></td>
                                <td><?php echo e($alergi->description ?? '-'); ?></td>
                                <td><?php echo e(Carbon\Carbon::parse($alergi->created_at)->translatedFormat('d F Y') ?? '-'); ?>

                                </td>
                            </tr>
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_5): ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
                            <tr>
                                <td colspan="10" class="no-data">Tidak ada data</td>
                            </tr>
                        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            <div class="px-5 py-4 bg-gray-50/80 border-t border-gray-200">
                <div class="flex items-center justify-between">
                    <div class="text-sm text-gray-700">
                        Menampilkan <span class="font-medium"><?php echo e($alergis->firstItem()); ?></span> sampai <span
                            class="font-medium"><?php echo e($alergis->lastItem()); ?></span> dari <span
                            class="font-medium"><?php echo e($alergis->total()); ?></span> hasil
                    </div>
                    <div>
                        <nav class="relative z-0 inline-flex rounded-md shadow-sm -space-x-px" aria-label="Pagination">
                            <?php echo e($alergis->links('vendor.livewire.custom')); ?> <!-- Menampilkan pagination -->
                        </nav>
                    </div>
                </div>
            </div>
        </div>
    <?php elseif($tab == 'icd-10'): ?>
        <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center mb-4 gap-4">
            <div class="flex items-center">
                <span class="text-sm text-gray-700 mr-2">Tampil</span>
                <select class="mt-1 form-control" wire:model.live='perPage'>
                    <option value="5">5</option>
                    <option value="10">10</option>
                    <option value="25">25</option>
                    <option value="50">50</option>
                    <option value="100">100</option>
                </select>
                <span class="text-sm text-gray-700 ml-2">data</span>
            </div>

            <div class="relative w-full sm:w-64">
                <input type="text" class="mt-1 form-control-search" placeholder="Cari Sesuatu..."
                    wire:model.live='search'>
                <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                    <i class="fas fa-search h-3 w-3 text-gray-400"></i>
                </div>
            </div>
        </div>

        <!-- Table Section -->
        <div class="bg-white/80 backdrop-blur-sm rounded-xl shadow-lg border border-gray-100 overflow-hidden mb-6">
            <div class="table-container">
                <table class="table">
                    <thead>
                        <tr>
                            <th class="w-1 center">No</th>
                            <th>Kode ICD-10</th>
                            <th>Display</th>
                            <th>Tanggal</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__empty_5 = true; $__currentLoopData = $icd10s; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $icd10): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_5 = false; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoopIteration(); ?><?php endif; ?>
                            <tr>
                                <td class="center"><?php echo e($icd10s->firstItem() + $index); ?></td>
                                <td><?php echo e($icd10->icd10->code ?? '-'); ?></td>
                                <td><?php echo e($icd10->icd10->display ?? '-'); ?></td>
                                <td><?php echo e(Carbon\Carbon::parse($icd10->created_at)->translatedFormat('d F Y') ?? '-'); ?>

                                </td>
                            </tr>
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_5): ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
                            <tr>
                                <td colspan="10" class="no-data">Tidak ada data</td>
                            </tr>
                        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                    </tbody>
                </table>
            </div>
            <!-- Pagination -->
            <div class="px-5 py-4 bg-gray-50/80 border-t border-gray-200">
                <div class="flex items-center justify-between">
                    <div class="text-sm text-gray-700">
                        Menampilkan <span class="font-medium"><?php echo e($icd10s->firstItem()); ?></span> sampai <span
                            class="font-medium"><?php echo e($icd10s->lastItem()); ?></span> dari <span
                            class="font-medium"><?php echo e($icd10s->total()); ?></span> hasil
                    </div>
                    <div>
                        <nav class="relative z-0 inline-flex rounded-md shadow-sm -space-x-px"
                            aria-label="Pagination">
                            <?php echo e($icd10s->links('vendor.livewire.custom')); ?> <!-- Menampilkan pagination -->
                        </nav>
                    </div>
                </div>
            </div>
        </div>
    <?php elseif($tab == 'icd-9'): ?>
        <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center mb-4 gap-4">
            <div class="flex items-center">
                <span class="text-sm text-gray-700 mr-2">Tampil</span>
                <select class="mt-1 form-control" wire:model.live='perPage'>
                    <option value="5">5</option>
                    <option value="10">10</option>
                    <option value="25">25</option>
                    <option value="50">50</option>
                    <option value="100">100</option>
                </select>
                <span class="text-sm text-gray-700 ml-2">data</span>
            </div>

            <div class="relative w-full sm:w-64">
                <input type="text" class="mt-1 form-control-search" placeholder="Cari Sesuatu..."
                    wire:model.live='search'>
                <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                    <i class="fas fa-search h-3 w-3 text-gray-400"></i>
                </div>
            </div>
        </div>

        <!-- Table Section -->
        <div class="bg-white/80 backdrop-blur-sm rounded-xl shadow-lg border border-gray-100 overflow-hidden mb-6">
            <div class="table-container">
                <table class="table">
                    <thead>
                        <tr>
                            <th class="w-1 center">No</th>
                            <th>Kode ICD-10</th>
                            <th>Display</th>
                            <th>Tanggal</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__empty_5 = true; $__currentLoopData = $icd9s; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $icd9): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_5 = false; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoopIteration(); ?><?php endif; ?>
                            <tr>
                                <td class="center"><?php echo e($icd9s->firstItem() + $index); ?></td>
                                <td><?php echo e($icd9->icd9->code ?? '-'); ?></td>
                                <td><?php echo e($icd9->icd9->display ?? '-'); ?></td>
                                <td><?php echo e(Carbon\Carbon::parse($icd9->created_at)->translatedFormat('d F Y') ?? '-'); ?>

                                </td>
                            </tr>
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_5): ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
                            <tr>
                                <td colspan="10" class="no-data">Tidak ada data</td>
                            </tr>
                        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                    </tbody>
                </table>
            </div>
            <!-- Pagination -->
            <div class="px-5 py-4 bg-gray-50/80 border-t border-gray-200">
                <div class="flex items-center justify-between">
                    <div class="text-sm text-gray-700">
                        Menampilkan <span class="font-medium"><?php echo e($icd9s->firstItem()); ?></span> sampai <span
                            class="font-medium"><?php echo e($icd9s->lastItem()); ?></span> dari <span
                            class="font-medium"><?php echo e($icd9s->total()); ?></span> hasil
                    </div>
                    <div>
                        <nav class="relative z-0 inline-flex rounded-md shadow-sm -space-x-px"
                            aria-label="Pagination">
                            <?php echo e($icd9s->links('vendor.livewire.custom')); ?> <!-- Menampilkan pagination -->
                        </nav>
                    </div>
                </div>
            </div>
        </div>
    <?php elseif($tab == 'tindakan'): ?>
        <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center mb-4 gap-4">
            <div class="flex items-center">
                <span class="text-sm text-gray-700 mr-2">Tampil</span>
                <select class="mt-1 form-control" wire:model.live='perPage'>
                    <option value="5">5</option>
                    <option value="10">10</option>
                    <option value="25">25</option>
                    <option value="50">50</option>
                    <option value="100">100</option>
                </select>
                <span class="text-sm text-gray-700 ml-2">data</span>
            </div>

            <div class="relative w-full sm:w-64">
                <input type="text" class="mt-1 form-control-search" placeholder="Cari Sesuatu..."
                    wire:model.live='search'>
                <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                    <i class="fas fa-search h-3 w-3 text-gray-400"></i>
                </div>
            </div>
        </div>

        <!-- Table Section -->
        <div class="bg-white/80 backdrop-blur-sm rounded-xl shadow-lg border border-gray-100 overflow-hidden mb-6">
            <div class="table-container">
                <table class="table">
                    <thead>
                        <tr>
                            <th class="w-1 center">No</th>
                            <th>Sku Number</th>
                            <th>Product Name</th>
                            <th>Harga</th>
                            <th>Jumlah</th>
                            <th>Total</th>
                            <th>Tanggal</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__empty_5 = true; $__currentLoopData = $actions; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $action): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_5 = false; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoopIteration(); ?><?php endif; ?>
                            <tr>
                                <td class="center"><?php echo e($actions->firstItem() + $index); ?></td>
                                <td><?php echo e($action?->product?->sku_number ?? '-'); ?></td>
                                <td><?php echo e($action?->product?->name ?? $action?->name ?? '-'); ?></td>
                                <td>Rp<?php echo e(number_format($action->price, 0, ',', '.') ?? 0); ?></td>
                                <td><?php echo e($action->quantity ?? '-'); ?></td>
                                <td>Rp<?php echo e(number_format($action->sub_total_price, 0, ',', '.') ?? 0); ?></td>
                                <td><?php echo e(Carbon\Carbon::parse($action->created_at)->translatedFormat('d F Y') ?? '-'); ?>

                                </td>
                            </tr>
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_5): ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
                            <tr>
                                <td colspan="10" class="no-data">Tidak ada data</td>
                            </tr>
                        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                    </tbody>
                </table>
            </div>
            <!-- Pagination -->
            <div class="px-5 py-4 bg-gray-50/80 border-t border-gray-200">
                <div class="flex items-center justify-between">
                    <div class="text-sm text-gray-700">
                        Menampilkan <span class="font-medium"><?php echo e($actions->firstItem()); ?></span> sampai <span
                            class="font-medium"><?php echo e($actions->lastItem()); ?></span> dari <span
                            class="font-medium"><?php echo e($actions->total()); ?></span> hasil
                    </div>
                    <div>
                        <nav class="relative z-0 inline-flex rounded-md shadow-sm -space-x-px"
                            aria-label="Pagination">
                            <?php echo e($actions->links('vendor.livewire.custom')); ?> <!-- Menampilkan pagination -->
                        </nav>
                    </div>
                </div>
            </div>
        </div>
    <?php elseif($tab == 'bukti-tindakan'): ?>
        <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center mb-4 gap-4">
            <div class="flex items-center">
                <span class="text-sm text-gray-700 mr-2">Tampil</span>
                <select class="mt-1 form-control" wire:model.live='perPage'>
                    <option value="5">5</option>
                    <option value="10">10</option>
                    <option value="25">25</option>
                    <option value="50">50</option>
                    <option value="100">100</option>
                </select>
                <span class="text-sm text-gray-700 ml-2">data</span>
            </div>

            <div class="relative w-full sm:w-64">
                <input type="text" class="mt-1 form-control-search" placeholder="Cari Sesuatu..."
                    wire:model.live='search'>
                <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                    <i class="fas fa-search h-3 w-3 text-gray-400"></i>
                </div>
            </div>
        </div>

        <!-- Table Section -->
        <div class="bg-white/80 backdrop-blur-sm rounded-xl shadow-lg border border-gray-100 overflow-hidden mb-6">
            <div class="table-container">
                <table class="table">
                    <thead>
                        <tr>
                            <th class="w-1 center">No</th>
                            <th>Deskripsi</th>
                            <th>Foto Sebelum</th>
                            <th>Foto Setelah</th>
                            <th>Tanggal</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__empty_5 = true; $__currentLoopData = $proofs; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $proof): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_5 = false; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoopIteration(); ?><?php endif; ?>
                            <tr>
                                <td class="center"><?php echo e($proofs->firstItem() + $index); ?></td>
                                <td><?php echo e($proof->description ?? '-'); ?></td>
                                <td>
                                    <img src="<?php echo e($proof->before_photo ? asset('storage/' . $proof->before_photo) : asset('asset/img/No-Image-Placeholder.svg.png')); ?>"
                                        alt="Sebelum Tindakan" style="width: 150px; height: 150px;"
                                        class=" object-cover rounded-lg cursor-pointer" data-easyzoom="true"
                                        id="before-image-<?php echo e($proof->id); ?>">
                                </td>
                                <td>
                                    <img src="<?php echo e($proof->after_photo ? asset('storage/' . $proof->after_photo) : asset('asset/img/No-Image-Placeholder.svg.png')); ?>"
                                        alt="Setelah Tindakan" style="width: 150px; height: 150px;"
                                        class=" object-cover rounded-lg cursor-pointer" data-easyzoom="true"
                                        id="after-image-<?php echo e($proof->id); ?>">
                                </td>
                                <td><?php echo e(Carbon\Carbon::parse($proof->created_at)->translatedFormat('d F Y') ?? '-'); ?>

                                </td>
                            </tr>
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_5): ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
                            <tr>
                                <td colspan="10" class="no-data">Tidak ada data</td>
                            </tr>
                        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                    </tbody>
                </table>
            </div>
            <!-- Pagination -->
            <div class="px-5 py-4 bg-gray-50/80 border-t border-gray-200">
                <div class="flex items-center justify-between">
                    <div class="text-sm text-gray-700">
                        Menampilkan <span class="font-medium"><?php echo e($proofs->firstItem()); ?></span> sampai <span
                            class="font-medium"><?php echo e($proofs->lastItem()); ?></span> dari <span
                            class="font-medium"><?php echo e($proofs->total()); ?></span> hasil
                    </div>
                    <div>
                        <nav class="relative z-0 inline-flex rounded-md shadow-sm -space-x-px"
                            aria-label="Pagination">
                            <?php echo e($proofs->links('vendor.livewire.custom')); ?> <!-- Menampilkan pagination -->
                        </nav>
                    </div>
                </div>
            </div>
        </div>
    <?php elseif($tab == 'jadwal-kontrol'): ?>
        <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center mb-4 gap-4">
            <div class="flex items-center">
                <span class="text-sm text-gray-700 mr-2">Tampil</span>
                <select class="mt-1 form-control" wire:model.live='perPage'>
                    <option value="5">5</option>
                    <option value="10">10</option>
                    <option value="25">25</option>
                    <option value="50">50</option>
                    <option value="100">100</option>
                </select>
                <span class="text-sm text-gray-700 ml-2">data</span>
            </div>

            <div class="relative w-full sm:w-64">
                <input type="text" class="mt-1 form-control-search" placeholder="Cari Sesuatu..."
                    wire:model.live='search'>
                <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                    <i class="fas fa-search h-3 w-3 text-gray-400"></i>
                </div>
            </div>
        </div>

        <!-- Table Section -->
        <div class="bg-white/80 backdrop-blur-sm rounded-xl shadow-lg border border-gray-100 overflow-hidden mb-6">
            <div class="table-container">
                <table class="table">
                    <thead>
                        <tr>
                            <th class="w-1 center">No</th>
                            <th>Poli</th>
                            <th>Dokter</th>
                            <th>Tanggal Kontrol</th>
                            <th>Deskripsi</th>
                            <th>Tanggal</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__empty_5 = true; $__currentLoopData = $userControls; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $userControl): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_5 = false; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoopIteration(); ?><?php endif; ?>
                            <tr>
                                <td class="center"><?php echo e($userControls->firstItem() + $index); ?></td>
                                <td><?php echo e($userControl->poly->name ?? '-'); ?></td>
                                <td><?php echo e($userControl->doctor->name ?? '-'); ?></td>
                                <td><?php echo e($userControl->date ? Carbon\Carbon::parse($userControl->date)->translatedFormat('d F Y') : '-'); ?>

                                </td>
                                <td><?php echo e($userControl->description ?? '-'); ?></td>
                                <td><?php echo e(Carbon\Carbon::parse($userControl->created_at)->translatedFormat('d F Y') ?? '-'); ?>

                                </td>
                            </tr>
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_5): ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
                            <tr>
                                <td colspan="10" class="no-data">Tidak ada data</td>
                            </tr>
                        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                    </tbody>
                </table>
            </div>
            <!-- Pagination -->
            <div class="px-5 py-4 bg-gray-50/80 border-t border-gray-200">
                <div class="flex items-center justify-between">
                    <div class="text-sm text-gray-700">
                        Menampilkan <span class="font-medium"><?php echo e($userControls->firstItem()); ?></span> sampai <span
                            class="font-medium"><?php echo e($userControls->lastItem()); ?></span> dari <span
                            class="font-medium"><?php echo e($userControls->total()); ?></span> hasil
                    </div>
                    <div>
                        <nav class="relative z-0 inline-flex rounded-md shadow-sm -space-x-px"
                            aria-label="Pagination">
                            <?php echo e($userControls->links('vendor.livewire.custom')); ?> <!-- Menampilkan pagination -->
                        </nav>
                    </div>
                </div>
            </div>
        </div>
    <?php elseif($tab == 'rujukan'): ?>
        <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center mb-4 gap-4">
            <div class="flex items-center">
                <span class="text-sm text-gray-700 mr-2">Tampil</span>
                <select class="mt-1 form-control" wire:model.live='perPage'>
                    <option value="5">5</option>
                    <option value="10">10</option>
                    <option value="25">25</option>
                    <option value="50">50</option>
                    <option value="100">100</option>
                </select>
                <span class="text-sm text-gray-700 ml-2">data</span>
            </div>

            <div class="relative w-full sm:w-64">
                <input type="text" class="mt-1 form-control-search" placeholder="Cari Sesuatu..."
                    wire:model.live='search'>
                <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                    <i class="fas fa-search h-3 w-3 text-gray-400"></i>
                </div>
            </div>
        </div>

        <!-- Table Section -->
        <div class="bg-white/80 backdrop-blur-sm rounded-xl shadow-lg border border-gray-100 overflow-hidden mb-6">
            <div class="table-container">
                <table class="table">
                    <thead>
                        <tr>
                            <th class="w-1 center">No</th>
                            <th>Tanggal Kontrol</th>
                            <th>Rumah Sakit</th>
                            <th>Dokter</th>
                            <th>Deskripsi</th>
                            <th>Tanggal</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__empty_5 = true; $__currentLoopData = $references; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $reference): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_5 = false; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoopIteration(); ?><?php endif; ?>
                            <tr>
                                <td class="center"><?php echo e($references->firstItem() + $index); ?></td>
                                <td><?php echo e($reference->date ? Carbon\Carbon::parse($reference->date)->translatedFormat('d F Y') : '-'); ?>

                                </td>
                                <td><?php echo e($reference->hospital ?? '-'); ?></td>
                                <td><?php echo e($reference->doctor_name ?? '-'); ?></td>
                                <td><?php echo e($reference->description ?? '-'); ?></td>
                                <td><?php echo e(Carbon\Carbon::parse($reference->created_at)->translatedFormat('d F Y') ?? '-'); ?>

                                </td>
                            </tr>
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_5): ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
                            <tr>
                                <td colspan="10" class="no-data">Tidak ada data</td>
                            </tr>
                        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                    </tbody>
                </table>
            </div>
            <!-- Pagination -->
            <div class="px-5 py-4 bg-gray-50/80 border-t border-gray-200">
                <div class="flex items-center justify-between">
                    <div class="text-sm text-gray-700">
                        Menampilkan <span class="font-medium"><?php echo e($references->firstItem()); ?></span> sampai <span
                            class="font-medium"><?php echo e($references->lastItem()); ?></span> dari <span
                            class="font-medium"><?php echo e($references->total()); ?></span> hasil
                    </div>
                    <div>
                        <nav class="relative z-0 inline-flex rounded-md shadow-sm -space-x-px"
                            aria-label="Pagination">
                            <?php echo e($references->links('vendor.livewire.custom')); ?> <!-- Menampilkan pagination -->
                        </nav>
                    </div>
                </div>
            </div>
        </div>
    <?php elseif($tab == 'resep'): ?>
        <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center mb-4 gap-4">
            <div class="flex items-center">
                <span class="text-sm text-gray-700 mr-2">Tampil</span>
                <select class="mt-1 form-control" wire:model.live='perPage'>
                    <option value="5">5</option>
                    <option value="10">10</option>
                    <option value="25">25</option>
                    <option value="50">50</option>
                    <option value="100">100</option>
                </select>
                <span class="text-sm text-gray-700 ml-2">data</span>
            </div>

            <div class="relative w-full sm:w-64">
                <input type="text" class="mt-1 form-control-search" placeholder="Cari Sesuatu..."
                    wire:model.live='search'>
                <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                    <i class="fas fa-search h-3 w-3 text-gray-400"></i>
                </div>
            </div>
        </div>
        <!-- Table Section -->
        <div class="bg-white/80 backdrop-blur-sm rounded-xl shadow-lg border border-gray-100 overflow-hidden mb-6">
            <div class="table-container">
                <table class="table">
                    <thead>
                        <tr class="border-b">
                            <th>Produk</th>
                            <th>Quantity Request</th>
                            <th class="center">Qty</th>
                            <th class="right">Subtotal</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__currentLoopData = $recipes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key_recipe => $recipe): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoopIteration(); ?><?php endif; ?>
                            <tr>
                                <td colspan="8" class="py-3 px-2" style="border-top: 3px solid #155dfc;">
                                    <div class="flex items-center gap-2">
                                        <span class="font-medium text-blue-600"
                                            style="width: <?php echo e($recipe->medicineType?->is_single ? '10%' : '15%'); ?>;">/R</span>
                                        <span class="font-medium"
                                            style="width: 100%"><?php echo e($recipe->medicineType?->name ?? ''); ?></span>
                                        <span class="font-medium" style="width: 100%">Rp
                                            <?php echo e(number_format($recipe->price_service_one ?? 0, 0, ',', '.')); ?></span>
                                        <span class="font-medium"
                                            style="width: 100%"><?php echo e($recipe->numero_recipe); ?></span>
                                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(!$recipe->medicineType?->is_single): ?>
                                            <span class="font-medium"
                                                style="width: 100%"><?php echo e($recipe->product->name ?? ''); ?></span>
                                            <span class="font-medium" style="width: 100%">Rp
                                                <?php echo e(number_format($recipe->sub_total_price ?? 0, 0, ',', '.')); ?></span>
                                        <?php else: ?>
                                            <span class="font-medium" style="width: 100%"></span>
                                            <span class="font-medium" style="width: 100%"></span>
                                        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                        <span class="font-medium"
                                            style="width: 100%"><?php echo e(Carbon\Carbon::parse($recipe->created_at)->translatedFormat('d F Y')); ?></span>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td colspan="8" class="py-3 px-2">
                                    <div class="flex items-center gap-2">
                                        <span
                                            class="font-medium text-blue-600"><?php echo e($recipe->description ?? '-'); ?></span>
                                    </div>
                                </td>
                            </tr>
                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__currentLoopData = $recipe->transactionDetail; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $detail): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoopIteration(); ?><?php endif; ?>
                                <tr>
                                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(!$recipe->medicineType?->is_single): ?>
                                        <td class="py-3 px-2">
                                            <p class="font-medium"><?php echo e($detail->product->name ?? '-'); ?></p>
                                            <p class="text-xs text-gray-500">
                                                @Rp<?php echo e(number_format($detail->price, 0, ',', '.')); ?></p>
                                        </td>
                                        <td class="py-3 px-2"><?php echo e(Str::title($detail->type ?? '-')); ?></td>
                                        <td class="py-3 px-2"><?php echo e($detail->quantity_real ?? 0); ?></td>
                                        <td class="center py-3 px-2"><?php echo e($detail->quantity ?? '-'); ?></td>
                                        <td class="right py-3 px-2">Rp
                                            <?php echo e(number_format($detail->sub_total_price, 0, ',', '.')); ?></td>
                                    <?php else: ?>
                                        <td colspan="5" class="py-3 px-2">
                                            <p class="font-medium"><?php echo e($detail->product->name ?? '-'); ?></p>
                                            <p class="text-xs text-gray-500">
                                                @Rp<?php echo e(number_format($detail->price, 0, ',', '.')); ?></p>
                                        </td>
                                        <td class="center py-3 px-2"><?php echo e($detail->quantity ?? '-'); ?></td>
                                        <td class="right py-3 px-2">Rp
                                            <?php echo e(number_format($detail->sub_total_price, 0, ',', '.')); ?></td>
                                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                </tr>
                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
                    </tbody>
                </table>
            </div>
            <!-- Pagination -->
            <div class="px-5 py-4 bg-gray-50/80 border-t border-gray-200">
                <div class="flex items-center justify-between">
                    <div class="text-sm text-gray-700">
                        Menampilkan <span class="font-medium"><?php echo e($recipes->firstItem()); ?></span> sampai <span
                            class="font-medium"><?php echo e($recipes->lastItem()); ?></span> dari <span
                            class="font-medium"><?php echo e($recipes->total()); ?></span> hasil
                    </div>
                    <div>
                        <nav class="relative z-0 inline-flex rounded-md shadow-sm -space-x-px"
                            aria-label="Pagination">
                            <?php echo e($recipes->links('vendor.livewire.custom')); ?> <!-- Menampilkan pagination -->
                        </nav>
                    </div>
                </div>
            </div>
        </div>
    <?php elseif($tab == 'penjualan'): ?>
        <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center mb-4 gap-4">
            <div class="flex items-center">
                <span class="text-sm text-gray-700 mr-2">Tampil</span>
                <select class="mt-1 form-control" wire:model.live='perPage'>
                    <option value="5">5</option>
                    <option value="10">10</option>
                    <option value="25">25</option>
                    <option value="50">50</option>
                    <option value="100">100</option>
                </select>
                <span class="text-sm text-gray-700 ml-2">data</span>
            </div>

            <div class="relative w-full sm:w-64">
                <input type="text" class="mt-1 form-control-search" placeholder="Cari Sesuatu..."
                    wire:model.live='search'>
                <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                    <i class="fas fa-search h-3 w-3 text-gray-400"></i>
                </div>
            </div>
        </div>
        <!-- Table Section -->
        <div class="bg-white/80 backdrop-blur-sm rounded-xl shadow-lg border border-gray-100 overflow-hidden mb-6">
            <div class="table-container">
                <table class="table">
                    <thead>
                        <tr class="border-b">
                            <th class="w-1 center">No</th>
                            <th>Sku Number</th>
                            <th>Produk</th>
                            <th>Tipe Produk</th>
                            <th>Harga</th>
                            <th>Quantity</th>
                            <th>Subtotal</th>
                            <th>Tanggal</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__currentLoopData = $products; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key_product => $product): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoopIteration(); ?><?php endif; ?>
                            <tr>
                                <td class="center"><?php echo e($products->firstItem() + $key_product); ?></td>
                                <td><?php echo e($product->product->sku_number ?? '-'); ?></td>
                                <td><?php echo e($product->product->name ?? '-'); ?></td>
                                <td><?php echo e($product->product->productType->name ?? '-'); ?></td>
                                <td>Rp <?php echo e(number_format($product->price ?? 0, 0, ',', '.')); ?></td>
                                <td><?php echo e($product->quantity ?? '-'); ?></td>
                                <td>Rp <?php echo e(number_format($product->total ?? 0, 0, ',', '.')); ?></td>
                                <td><?php echo e(Carbon\Carbon::parse($product->created_at)->translatedFormat('d F Y') ?? '-'); ?>

                                </td>
                            </tr>
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
                    </tbody>
                </table>
            </div>
            <!-- Pagination -->
            <div class="px-5 py-4 bg-gray-50/80 border-t border-gray-200">
                <div class="flex items-center justify-between">
                    <div class="text-sm text-gray-700">
                        Menampilkan <span class="font-medium"><?php echo e($products->firstItem()); ?></span> sampai <span
                            class="font-medium"><?php echo e($products->lastItem()); ?></span> dari <span
                            class="font-medium"><?php echo e($products->total()); ?></span> hasil
                    </div>
                    <div>
                        <nav class="relative z-0 inline-flex rounded-md shadow-sm -space-x-px"
                            aria-label="Pagination">
                            <?php echo e($products->links('vendor.livewire.custom')); ?> <!-- Menampilkan pagination -->
                        </nav>
                    </div>
                </div>
            </div>
        </div>
    <?php elseif($tab == 'terima-bayar'): ?>
        <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center mb-4 gap-4">
            <div class="flex items-center">
                <span class="text-sm text-gray-700 mr-2">Tampil</span>
                <select class="mt-1 form-control" wire:model.live='perPage'>
                    <option value="5">5</option>
                    <option value="10">10</option>
                    <option value="25">25</option>
                    <option value="50">50</option>
                    <option value="100">100</option>
                </select>
                <span class="text-sm text-gray-700 ml-2">data</span>
            </div>

            <div class="relative w-full sm:w-64">
                <input type="text" class="mt-1 form-control-search" placeholder="Cari Sesuatu..."
                    wire:model.live='search'>
                <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                    <i class="fas fa-search h-3 w-3 text-gray-400"></i>
                </div>
            </div>
        </div>
        <!-- Table Section -->
        <div class="bg-white/80 backdrop-blur-sm rounded-xl shadow-lg border border-gray-100 overflow-hidden mb-6">
            <div class="table-container">
                <table class="table">
                    <thead>
                        <tr class="border-b">
                            <th class="w-1 center">No</th>
                            <th>Nama Metode Bayar</th>
                            <th>Biaya Admin</th>
                            <th>Pembayaran</th>
                            <th>Tanggal</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__currentLoopData = $payments; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key_payment => $payment): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoopIteration(); ?><?php endif; ?>
                            <tr>
                                <td class="center"><?php echo e($payments->firstItem() + $key_payment); ?></td>
                                <td><?php echo e($payment->paymentMethod->name ?? '-'); ?></td>
                                <td>Rp <?php echo e(number_format($payment->admin_fee, 0, ',', '.')); ?></td>
                                <td>Rp <?php echo e(number_format($payment->payment_real, 0, ',', '.')); ?></td>
                                <td><?php echo e(Carbon\Carbon::parse($payment->created_at)->translatedFormat('d F Y') ?? '-'); ?>

                                </td>
                            </tr>
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
                    </tbody>
                </table>
            </div>
            <!-- Pagination -->
            <div class="px-5 py-4 bg-gray-50/80 border-t border-gray-200">
                <div class="flex items-center justify-between">
                    <div class="text-sm text-gray-700">
                        Menampilkan <span class="font-medium"><?php echo e($payments->firstItem()); ?></span> sampai <span
                            class="font-medium"><?php echo e($payments->lastItem()); ?></span> dari <span
                            class="font-medium"><?php echo e($payments->total()); ?></span> hasil
                    </div>
                    <div>
                        <nav class="relative z-0 inline-flex rounded-md shadow-sm -space-x-px"
                            aria-label="Pagination">
                            <?php echo e($payments->links('vendor.livewire.custom')); ?> <!-- Menampilkan pagination -->
                        </nav>
                    </div>
                </div>
            </div>
        </div>
    <?php elseif($tab == 'laba-rugi'): ?>
        <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center mb-4 gap-4">
            <div class="flex items-center">
                <span class="text-sm text-gray-700 mr-2">Tampil</span>
                <select class="mt-1 form-control" wire:model.live='perPage'>
                    <option value="5">5</option>
                    <option value="10">10</option>
                    <option value="25">25</option>
                    <option value="50">50</option>
                    <option value="100">100</option>
                </select>
                <span class="text-sm text-gray-700 ml-2">data</span>
            </div>

            <div class="relative w-full sm:w-64">
                <input type="text" class="mt-1 form-control-search" placeholder="Cari Sesuatu..."
                    wire:model.live='search'>
                <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                    <i class="fas fa-search h-3 w-3 text-gray-400"></i>
                </div>
            </div>
        </div>
        <div class="bg-white/80 backdrop-blur-sm rounded-xl shadow-lg border border-gray-100 overflow-hidden mb-6">
            <div class="table-container">
                <table class="table">
                    <thead>
                        <tr>
                            <th class="w-1 center">No</th>
                            <th>Produk</th>
                            <th>Tipe Produk</th>
                            <th>Sub Total</th>
                            <th>Hpp Total</th>
                            <th>Quantity</th>
                            <th>Profit</th>
                            <th>Margin</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__empty_5 = true; $__currentLoopData = $profits; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $profit): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_5 = false; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoopIteration(); ?><?php endif; ?>
                            <tr>
                                <td class="center">
                                    <?php echo e($loop->iteration + ($profits->currentPage() - 1) * $profits->perPage()); ?></td>
                                <td>
                                    <p class="font-medium"><?php echo e($profit->product->name); ?></p>
                                    <p class="text-xs text-gray-500"><?php echo e($profit->product->sku_number); ?></p>
                                </td>
                                <td><?php echo e($profit->product->productType->name); ?></td>
                                <td>Rp<?php echo e(number_format($profit->total_penjualan, 0, ',', '.')); ?></td>
                                <td>Rp<?php echo e(number_format($profit->total_hpp_total, 0, ',', '.')); ?></td>
                                <td><?php echo e($profit->total_quantity); ?></td>
                                <td>Rp<?php echo e(number_format($profit->total_profit, 0, ',', '.')); ?></td>
                                <td><?php echo e(number_format($profit->average_margin, 0, ',', '.')); ?>%</td>
                            </tr>
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_5): ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
                            <tr>
                                <td colspan="8" class="no-data">Tidak ada data</td>
                            </tr>
                        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                    </tbody>
                </table>
            </div>
            <div class="px-5 py-4 bg-gray-50/80 border-t border-gray-200">
                <div class="flex items-center justify-between">
                    <div class="text-sm text-gray-700">
                        Menampilkan <span class="font-medium"><?php echo e($profits->firstItem()); ?></span> sampai <span
                            class="font-medium"><?php echo e($profits->lastItem()); ?></span> dari <span
                            class="font-medium"><?php echo e($profits->total()); ?></span> hasil
                    </div>
                    <div>
                        <nav class="relative z-0 inline-flex rounded-md shadow-sm -space-x-px"
                            aria-label="Pagination">
                            <?php echo e($profits->links('vendor.livewire.custom')); ?> <!-- Menampilkan pagination -->
                        </nav>
                    </div>
                </div>
            </div>
        </div>
    <?php elseif($tab == 'observasi'): ?>
        <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center mb-4 gap-4">
            <div class="flex items-center">
                <span class="text-sm text-gray-700 mr-2">Tampil</span>
                <select class="mt-1 form-control" wire:model.live='perPage'>
                    <option value="5">5</option>
                    <option value="10">10</option>
                    <option value="25">25</option>
                    <option value="50">50</option>
                    <option value="100">100</option>
                </select>
                <span class="text-sm text-gray-700 ml-2">data</span>
            </div>

            <div class="relative w-full sm:w-64">
                <input type="text" class="mt-1 form-control-search" placeholder="Cari Sesuatu..."
                    wire:model.live='search'>
                <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                    <i class="fas fa-search h-3 w-3 text-gray-400"></i>
                </div>
            </div>
        </div>
        <div class="bg-white/80 backdrop-blur-sm rounded-xl shadow-lg border border-gray-100 overflow-hidden mb-6">
            <div class="table-container">
                <table class="table">
                    <thead>
                        <tr>
                            <th class="w-1 center">No</th>
                            <th>Heart Rate</th>
                            <th>Breathing</th>
                            <th>Blood Pressure Sistole</th>
                            <th>Blood Pressure Diastole</th>
                            <th>Body Temperature</th>
                            <th>Height</th>
                            <th>Weight</th>
                            <th>Lingkar Kepala</th>

                        </tr>
                    </thead>
                    <tbody>
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__empty_5 = true; $__currentLoopData = $physicalexaminations; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $physicalexamination): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_5 = false; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoopIteration(); ?><?php endif; ?>
                            <tr>
                                <td class="center">
                                    <?php echo e($loop->iteration + ($physicalexaminations->currentPage() - 1) * $physicalexaminations->perPage()); ?>

                                </td>
                                <td><?php echo e($physicalexamination->heart_rate ?? '-'); ?></td>
                                <td><?php echo e($physicalexamination->breathing ?? '-'); ?></td>
                                <td><?php echo e($physicalexamination->blood_pressure_sistole ?? '-'); ?></td>
                                <td><?php echo e($physicalexamination->blood_pressure_diastole ?? '-'); ?></td>
                                <td><?php echo e($physicalexamination->body_temperature ?? '-'); ?></td>
                                <td><?php echo e($physicalexamination->height ?? '-'); ?></td>
                                <td><?php echo e($physicalexamination->weight ?? '-'); ?></td>
                                <td><?php echo e($physicalexamination->head_circumference ?? '-'); ?></td>
                            </tr>
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_5): ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
                            <tr>
                                <td colspan="8" class="no-data">Tidak ada data</td>
                            </tr>
                        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                    </tbody>
                </table>
            </div>
            <div class="px-5 py-4 bg-gray-50/80 border-t border-gray-200">
                <div class="flex items-center justify-between">
                    <div class="text-sm text-gray-700">
                        Menampilkan <span class="font-medium"><?php echo e($physicalexaminations->firstItem()); ?></span> sampai
                        <span class="font-medium"><?php echo e($physicalexaminations->lastItem()); ?></span> dari <span
                            class="font-medium"><?php echo e($physicalexaminations->total()); ?></span> hasil
                    </div>
                    <div>
                        <nav class="relative z-0 inline-flex rounded-md shadow-sm -space-x-px"
                            aria-label="Pagination">
                            <?php echo e($physicalexaminations->links('vendor.livewire.custom')); ?>

                            <!-- Menampilkan pagination -->
                        </nav>
                    </div>
                </div>
            </div>
        </div>
    <?php elseif($tab == 'odontogram'): ?>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">
            <!-- Summary Stats -->
            <div class="bg-white/80 backdrop-blur-sm rounded-xl shadow-lg border border-gray-100 p-6">
                <h3 class="text-lg font-bold text-gray-800 mb-4">Statistik Odontogram</h3>
                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($frequent_odontogram && $frequent_odontogram->count() > 0): ?>
                    <div class="space-y-3">
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__currentLoopData = $frequent_odontogram; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $stat): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoopIteration(); ?><?php endif; ?>
                            <div class="flex items-center justify-between p-3 bg-blue-50/50 rounded-lg border border-blue-100 hover:bg-blue-50 transition-colors">
                                <div>
                                    <p class="text-xs text-gray-500 mb-1">Kondisi</p>
                                    <span class="badge badge-lg badge-primary font-bold"><?php echo e($stat->odontogram_code); ?></span>
                                </div>
                                <div class="text-right">
                                    <p class="text-xs text-gray-500 mb-1">Total</p>
                                    <span class="text-xl font-bold text-blue-700"><?php echo e($stat->total); ?>x</span>
                                </div>
                            </div>
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
                    </div>
                <?php else: ?>
                    <p class="text-gray-500 italic text-center py-4">Belum ada data odontogram.</p>
                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
            </div>

            <!-- Odontogram Visual -->
            <div class="bg-white/80 backdrop-blur-sm rounded-xl shadow-lg border border-gray-100 p-6 md:col-span-2 overflow-x-auto">
                <h3 class="text-lg font-bold text-gray-800 mb-4">Visualisasi Gigi (Terakhir)</h3>
                <div id="odontogram" class="overflow-x-auto">
                    <div id="svgselect" class="min-w-[800px]">
                        <svg version="1.1" height="250px" width="100%">
                            <g transform="scale(1.5)" id="gmain">
                                
                                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__currentLoopData = ['18','17','16','15','14','13','12','11','21','22','23','24','25','26','27','28']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $i => $tooth): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoopIteration(); ?><?php endif; ?>
                                    <g id="P<?php echo e($tooth); ?>" transform="translate(<?php echo e($i * 25); ?>,0)">
                                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__currentLoopData = ['C','T','B','R','L']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $part): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoopIteration(); ?><?php endif; ?>
                                            <?php
                                                $points = match($part) {
                                                    'C' => '5,5 15,5 15,15 5,15',
                                                    'T' => '0,0 20,0 15,5 5,5',
                                                    'B' => '5,15 15,15 20,20 0,20',
                                                    'R' => '15,5 20,0 20,20 15,15',
                                                    'L' => '0,0 5,5 5,15 0,20',
                                                };
                                            ?>
                                            <polygon points="<?php echo e($points); ?>"
                                                fill="<?php echo e($odontogram_map[$tooth.$part] ?? 'white'); ?>"
                                                stroke="black" stroke-width="0.5" id="<?php echo e($part); ?>"></polygon>
                                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
                                        <text x="6" y="30" stroke="black" fill="black" stroke-width="0.1" style="font-size: 6pt;font-weight:normal"><?php echo e($tooth); ?></text>
                                    </g>
                                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>

                                
                                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__currentLoopData = ['55','54','53','52','51','61','62','63','64','65']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $i => $tooth): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoopIteration(); ?><?php endif; ?>
                                    <g id="P<?php echo e($tooth); ?>" transform="translate(<?php echo e(($i + 3) * 25); ?>,40)">
                                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__currentLoopData = ['C','T','B','R','L']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $part): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoopIteration(); ?><?php endif; ?>
                                            <?php
                                                $points = match($part) {
                                                    'C' => '5,5 15,5 15,15 5,15',
                                                    'T' => '0,0 20,0 15,5 5,5',
                                                    'B' => '5,15 15,15 20,20 0,20',
                                                    'R' => '15,5 20,0 20,20 15,15',
                                                    'L' => '0,0 5,5 5,15 0,20',
                                                };
                                            ?>
                                            <polygon points="<?php echo e($points); ?>"
                                                fill="<?php echo e($odontogram_map[$tooth.$part] ?? 'white'); ?>"
                                                stroke="black" stroke-width="0.5" id="<?php echo e($part); ?>"></polygon>
                                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
                                        <text x="6" y="30" stroke="black" fill="black" stroke-width="0.1" style="font-size: 6pt;font-weight:normal"><?php echo e($tooth); ?></text>
                                    </g>
                                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>

                                
                                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__currentLoopData = ['85','84','83','82','81','71','72','73','74','75']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $i => $tooth): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoopIteration(); ?><?php endif; ?>
                                    <g id="P<?php echo e($tooth); ?>" transform="translate(<?php echo e(($i + 3) * 25); ?>,80)">
                                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__currentLoopData = ['C','T','B','R','L']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $part): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoopIteration(); ?><?php endif; ?>
                                            <?php
                                                $points = match($part) {
                                                    'C' => '5,5 15,5 15,15 5,15',
                                                    'T' => '0,0 20,0 15,5 5,5',
                                                    'B' => '5,15 15,15 20,20 0,20',
                                                    'R' => '15,5 20,0 20,20 15,15',
                                                    'L' => '0,0 5,5 5,15 0,20',
                                                };
                                            ?>
                                            <polygon points="<?php echo e($points); ?>"
                                                fill="<?php echo e($odontogram_map[$tooth.$part] ?? 'white'); ?>"
                                                stroke="black" stroke-width="0.5" id="<?php echo e($part); ?>"></polygon>
                                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
                                        <text x="6" y="30" stroke="black" fill="black" stroke-width="0.1" style="font-size: 6pt;font-weight:normal"><?php echo e($tooth); ?></text>
                                    </g>
                                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>

                                
                                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__currentLoopData = ['48','47','46','45','44','43','42','41','31','32','33','34','35','36','37','38']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $i => $tooth): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoopIteration(); ?><?php endif; ?>
                                    <g id="P<?php echo e($tooth); ?>" transform="translate(<?php echo e($i * 25); ?>,120)">
                                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__currentLoopData = ['C','T','B','R','L']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $part): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoopIteration(); ?><?php endif; ?>
                                            <?php
                                                $points = match($part) {
                                                    'C' => '5,5 15,5 15,15 5,15',
                                                    'T' => '0,0 20,0 15,5 5,5',
                                                    'B' => '5,15 15,15 20,20 0,20',
                                                    'R' => '15,5 20,0 20,20 15,15',
                                                    'L' => '0,0 5,5 5,15 0,20',
                                                };
                                            ?>
                                            <polygon points="<?php echo e($points); ?>"
                                                fill="<?php echo e($odontogram_map[$tooth.$part] ?? 'white'); ?>"
                                                stroke="black" stroke-width="0.5" id="<?php echo e($part); ?>"></polygon>
                                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
                                        <text x="6" y="30" stroke="black" fill="black" stroke-width="0.1" style="font-size: 6pt;font-weight:normal"><?php echo e($tooth); ?></text>
                                    </g>
                                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
                            </g>
                        </svg>
                    </div>
                </div>
            </div>
        </div>


        <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center mb-4 gap-4">
            <div class="flex items-center">
                <span class="text-sm text-gray-700 mr-2">Tampil</span>
                <select class="mt-1 form-control" wire:model.live='perPage'>
                    <option value="5">5</option>
                    <option value="10">10</option>
                    <option value="25">25</option>
                    <option value="50">50</option>
                    <option value="100">100</option>
                </select>
                <span class="text-sm text-gray-700 ml-2">data</span>
            </div>
        </div>

        <div class="bg-white/80 backdrop-blur-sm rounded-xl shadow-lg border border-gray-100 overflow-hidden mb-6">
            <div class="table-container">
                <table class="table">
                    <thead>
                        <tr>
                            <th class="w-1 center">No</th>
                            <th>Tanggal</th>
                            <th>Dokter</th>
                            <th>Kode Gigi</th>
                            <th>Kondisi/Tindakan</th>
                            <th>Keterangan</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__empty_5 = true; $__currentLoopData = $historyOdontograms; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $odontogram): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_5 = false; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoopIteration(); ?><?php endif; ?>
                            <tr>
                                <td class="center">
                                    <?php echo e($historyOdontograms->firstItem() + $index); ?>

                                </td>
                                <td><?php echo e($odontogram->created_at ? \Carbon\Carbon::parse($odontogram->created_at)->locale('id')->isoFormat('DD MMMM YYYY HH:mm') : '-'); ?></td>
                                <td><?php echo e($odontogram->transaction->doctor->name ?? '-'); ?></td>
                                <td>
                                    <span class="px-2 py-1 rounded text-white text-xs font-bold" style="background-color: <?php echo e($odontogram->odontogram_color ?? '#000'); ?>">
                                        <?php echo e($odontogram->odontogram_code); ?>

                                    </span>
                                </td>
                                <td><?php echo e($odontogram->product->name ?? $odontogram->name ?? '-'); ?></td>
                                <td><?php echo e($odontogram->description ?? '-'); ?></td>
                            </tr>
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_5): ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
                            <tr>
                                <td colspan="6" class="no-data">Tidak ada data</td>
                            </tr>
                        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                    </tbody>
                </table>
            </div>
            <div class="px-5 py-4 bg-gray-50/80 border-t border-gray-200">
                <div class="flex items-center justify-between">
                    <div class="text-sm text-gray-700">
                        Menampilkan <span class="font-medium"><?php echo e($historyOdontograms->firstItem()); ?></span> sampai
                        <span class="font-medium"><?php echo e($historyOdontograms->lastItem()); ?></span> dari <span
                            class="font-medium"><?php echo e($historyOdontograms->total()); ?></span> hasil
                    </div>
                    <div>
                        <nav class="relative z-0 inline-flex rounded-md shadow-sm -space-x-px"
                            aria-label="Pagination">
                            <?php echo e($historyOdontograms->links('vendor.livewire.custom')); ?>

                        </nav>
                    </div>
                </div>
            </div>
        </div>
    <?php elseif($tab == 'konsultasi'): ?>
        <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center mb-4 gap-4">
            <div class="flex items-center">
                <span class="text-sm text-gray-700 mr-2">Tampil</span>
                <select class="mt-1 form-control" wire:model.live='perPage'>
                    <option value="5">5</option>
                    <option value="10">10</option>
                    <option value="25">25</option>
                    <option value="50">50</option>
                    <option value="100">100</option>
                </select>
                <span class="text-sm text-gray-700 ml-2">data</span>
            </div>
        </div>

        <div class="bg-white/80 backdrop-blur-sm rounded-xl shadow-lg border border-gray-100 overflow-hidden mb-6">
            <div class="table-container">
                <table class="table">
                    <thead>
                        <tr>
                            <th class="w-1 center">No</th>
                            <th>Tanggal</th>
                            <th>Kode Konsultasi</th>
                            <th>Dokter</th>
                            <th>Poli</th>
                            <th>Status</th>
                            <!-- <th>Sub Total</th> -->
                            <th>Total</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__empty_5 = true; $__currentLoopData = $historyConsultations; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $consultation): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_5 = false; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoopIteration(); ?><?php endif; ?>
                            <tr>
                                <td class="center">
                                    <?php echo e($historyConsultations->firstItem() + $index); ?>

                                </td>
                                <td><?php echo e($consultation->created_at ? \Carbon\Carbon::parse($consultation->created_at)->locale('id')->isoFormat('DD MMMM YYYY HH:mm') : '-'); ?></td>
                                <td><?php echo e($consultation->code_consultation ?? '-'); ?></td>
                                <td><?php echo e($consultation->doctor->name ?? '-'); ?></td>
                                <td><?php echo e($consultation->poly->name ?? '-'); ?></td>
                                <td>
                                    <?php
                                        $statusColors = [
                                            'waiting_consultation' => 'bg-gray-100 text-gray-800',
                                            'process' => 'bg-yellow-100 text-yellow-800',
                                            'completed' => 'bg-green-200 text-green-900',
                                            'canceled' => 'bg-red-100 text-red-800',
                                        ];
                                        $label = [
                                            'waiting_consultation' => 'Menunggu',
                                            'process' => 'Proses',
                                            'completed' => 'Selesai',
                                            'canceled' => 'Batal',
                                        ];
                                    ?>
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium <?php echo e($statusColors[$consultation->status] ?? 'bg-gray-100 text-gray-800'); ?>">
                                        <?php echo e($label[$consultation->status] ?? Str::title(str_replace('_', ' ', $consultation->status))); ?>

                                    </span>
                                </td>
                                <!-- <td>Rp <?php echo e(number_format($consultation->total_price ?? 0, 0, ',', '.')); ?></td> -->
                                <td>Rp <?php echo e(number_format($consultation->grand_total_price ?? 0, 0, ',', '.')); ?></td>
                            </tr>
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_5): ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
                            <tr>
                                <td colspan="6" class="no-data">Tidak ada data</td>
                            </tr>
                        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                    </tbody>
                </table>
            </div>
            <div class="px-5 py-4 bg-gray-50/80 border-t border-gray-200">
                <div class="flex items-center justify-between">
                    <div class="text-sm text-gray-700">
                         Menampilkan <span class="font-medium"><?php echo e($historyConsultations->firstItem()); ?></span> sampai
                        <span class="font-medium"><?php echo e($historyConsultations->lastItem()); ?></span> dari <span
                            class="font-medium"><?php echo e($historyConsultations->total()); ?></span> hasil
                    </div>
                    <div>
                        <nav class="relative z-0 inline-flex rounded-md shadow-sm -space-x-px"
                            aria-label="Pagination">
                            <?php echo e($historyConsultations->links('vendor.livewire.custom')); ?>

                        </nav>
                    </div>
                </div>
            </div>
        </div>
    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
</div><?php /**PATH /Users/macbookair/Documents/mediction/mediction.id/resources/views/livewire/admin/consultation/patient/detail/admin-consultation-patient-detail-index.blade.php ENDPATH**/ ?>