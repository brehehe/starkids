<div>
    <div class="mb-6">
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-2xl font-bold text-[#1E3A8A]">Detail Promosi</h1>
                <p class="text-gray-600"><?php echo e($promotion->name); ?></p>
            </div>
            <div class="flex items-center space-x-3">
                <button wire:click="toggleStatus"
                    class="btn <?php echo e($promotion->is_active ? 'btn-secondary' : 'btn-primary'); ?>">
                    <?php echo e($promotion->is_active ? 'Nonaktifkan' : 'Aktifkan'); ?>

                </button>
                <button wire:click="duplicatePromotion" class="btn btn-outline">
                    Duplikasi
                </button>
                <a href="<?php echo e(route('admin.promotion.index')); ?>" class="btn btn-secondary">
                    Kembali
                </a>
            </div>
        </div>
    </div>

    <!-- Promotion Info -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-6">
        <!-- Basic Information -->
        <div class="lg:col-span-2">
            <div class="bg-white/80 backdrop-blur-sm rounded-xl shadow-lg border border-gray-100 p-6">
                <h3 class="text-lg font-semibold text-gray-900 mb-4">Informasi Promosi</h3>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Nama</label>
                        <p class="mt-1 text-sm text-gray-900"><?php echo e($promotion->name); ?></p>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700">Kode</label>
                        <p class="mt-1">
                            <span
                                class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                <?php echo e($promotion->code); ?>

                            </span>
                        </p>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700">Tipe</label>
                        <p class="mt-1 text-sm text-gray-900"><?php echo e(ucfirst(str_replace('_', ' ', $promotion->type))); ?></p>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700">Nilai</label>
                        <p class="mt-1 text-sm text-gray-900">
                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($promotion->promotion_type === 'persen'): ?>
                                <?php echo e($promotion->promotion_value); ?>%
                            <?php else: ?>
                                Rp <?php echo e(number_format($promotion->promotion_value, 0, ',', '.')); ?>

                            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                        </p>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700">Minimal Pembelian</label>
                        <p class="mt-1 text-sm text-gray-900">
                            Rp <?php echo e(number_format($promotion->minimum_purchase, 0, ',', '.')); ?>

                        </p>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700">Status</label>
                        <p class="mt-1">
                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($promotion->is_active): ?>
                                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($promotion->end_date && $promotion->end_date < now()): ?>
                                    <span
                                        class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800">
                                        Kadaluarsa
                                    </span>
                                <?php elseif($promotion->start_date && $promotion->start_date > now()): ?>
                                    <span
                                        class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800">
                                        Akan Datang
                                    </span>
                                <?php else: ?>
                                    <span
                                        class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                        Aktif
                                    </span>
                                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                            <?php else: ?>
                                <span
                                    class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-gray-100 text-gray-800">
                                    Tidak Aktif
                                </span>
                            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                        </p>
                    </div>
                </div>

                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($promotion->description): ?>
                    <div class="mt-4">
                        <label class="block text-sm font-medium text-gray-700">Deskripsi</label>
                        <p class="mt-1 text-sm text-gray-900"><?php echo e($promotion->description); ?></p>
                    </div>
                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
            </div>
        </div>

        <!-- Statistics -->
        <div>
            <div class="bg-white/80 backdrop-blur-sm rounded-xl shadow-lg border border-gray-100 p-6">
                <h3 class="text-lg font-semibold text-gray-900 mb-4">Statistik</h3>

                <div class="space-y-4">
                    <div>
                        <div class="flex items-center justify-between">
                            <span class="text-sm font-medium text-gray-600">Total Penggunaan</span>
                            <span class="text-lg font-bold text-blue-600"><?php echo e($analytics['total_usage']); ?></span>
                        </div>
                    </div>

                    <div>
                        <div class="flex items-center justify-between">
                            <span class="text-sm font-medium text-gray-600">Sisa Kuota</span>
                            <span class="text-lg font-bold text-green-600"><?php echo e($analytics['remaining_quota']); ?></span>
                        </div>
                    </div>

                    <div>
                        <div class="flex items-center justify-between">
                            <span class="text-sm font-medium text-gray-600">Total Diskon</span>
                            <span class="text-lg font-bold text-purple-600">
                                Rp <?php echo e(number_format($analytics['total_discount_given'], 0, ',', '.')); ?>

                            </span>
                        </div>
                    </div>

                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(!$promotion->is_unlimited): ?>
                        <div>
                            <div class="flex items-center justify-between mb-2">
                                <span class="text-sm font-medium text-gray-600">Progress</span>
                                <span class="text-sm text-gray-500">
                                    <?php echo e($promotion->used_count); ?>/<?php echo e($promotion->total_quota); ?>

                                </span>
                            </div>
                            <div class="w-full bg-gray-200 rounded-full h-2">
                                <div class="bg-blue-600 h-2 rounded-full"
                                    style="width: <?php echo e($promotion->total_quota > 0 ? ($promotion->used_count / $promotion->total_quota) * 100 : 0); ?>%">
                                </div>
                            </div>
                        </div>
                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                </div>
            </div>
        </div>
    </div>

    <!-- Period Information -->
    <div class="bg-white/80 backdrop-blur-sm rounded-xl shadow-lg border border-gray-100 p-6 mb-6">
        <h3 class="text-lg font-semibold text-gray-900 mb-4">Periode Berlaku</h3>

        <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
            <div>
                <label class="block text-sm font-medium text-gray-700">Tanggal Mulai</label>
                <p class="mt-1 text-sm text-gray-900">
                    <?php echo e($promotion->start_date ? $promotion->start_date->format('d/m/Y') : 'Tidak dibatasi'); ?>

                </p>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700">Tanggal Selesai</label>
                <p class="mt-1 text-sm text-gray-900">
                    <?php echo e($promotion->end_date ? $promotion->end_date->format('d/m/Y') : 'Tidak dibatasi'); ?>

                </p>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700">Jam Mulai</label>
                <p class="mt-1 text-sm text-gray-900">
                    <?php echo e($promotion->start_time ?: 'Sepanjang hari'); ?>

                </p>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700">Jam Selesai</label>
                <p class="mt-1 text-sm text-gray-900">
                    <?php echo e($promotion->end_time ?: 'Sepanjang hari'); ?>

                </p>
            </div>
        </div>

        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($promotion->applicable_days && count($promotion->applicable_days) > 0): ?>
            <div class="mt-4">
                <label class="block text-sm font-medium text-gray-700 mb-2">Hari Berlaku</label>
                <div class="flex flex-wrap gap-2">
                    <?php
                        $dayLabels = [
                            'monday' => 'Senin',
                            'tuesday' => 'Selasa',
                            'wednesday' => 'Rabu',
                            'thursday' => 'Kamis',
                            'friday' => 'Jumat',
                            'saturday' => 'Sabtu',
                            'sunday' => 'Minggu',
                        ];
                    ?>
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__currentLoopData = $promotion->applicable_days; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $day): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoopIteration(); ?><?php endif; ?>
                        <span
                            class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-gray-100 text-gray-800">
                            <?php echo e($dayLabels[$day] ?? $day); ?>

                        </span>
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
                </div>
            </div>
        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
    </div>

    <!-- Usage History -->
    <div class="bg-white/80 backdrop-blur-sm rounded-xl shadow-lg border border-gray-100 overflow-hidden">
        <div class="px-6 py-4 border-b border-gray-200">
            <h3 class="text-lg font-semibold text-gray-900">Riwayat Penggunaan</h3>
        </div>

        <div class="table-container">
            <table class="table">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Pengguna</th>
                        <th>Tanggal</th>
                        <th>Diskon</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__empty_1 = true; $__currentLoopData = $usages; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $usage): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoopIteration(); ?><?php endif; ?>
                        <tr>
                            <td><?php echo e($usages->firstItem() + $index); ?></td>
                            <td><?php echo e($usage->user->name ?? 'N/A'); ?></td>
                            <td><?php echo e($usage->created_at->format('d/m/Y H:i')); ?></td>
                            <td>Rp <?php echo e(number_format($usage->discount_amount, 0, ',', '.')); ?></td>
                            <td>
                                <span
                                    class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                    Berhasil
                                </span>
                            </td>
                        </tr>
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
                        <tr>
                            <td colspan="5" class="no-data">Belum ada penggunaan</td>
                        </tr>
                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                </tbody>
            </table>
        </div>

        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($usages->hasPages()): ?>
            <div class="px-5 py-4 bg-gray-50/80 border-t border-gray-200">
                <div class="flex items-center justify-between">
                    <div class="text-sm text-gray-700">
                        Menampilkan <span class="font-medium"><?php echo e($usages->firstItem()); ?></span> sampai <span
                            class="font-medium"><?php echo e($usages->lastItem()); ?></span> dari <span
                            class="font-medium"><?php echo e($usages->total()); ?></span> hasil
                    </div>
                    <div>
                        <nav class="relative z-0 inline-flex rounded-md shadow-sm -space-x-px" aria-label="Pagination">
                            <?php echo e($usages->links('vendor.livewire.custom')); ?>

                        </nav>
                    </div>
                </div>
            </div>
        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
    </div>
</div><?php /**PATH /Users/macbookair/Documents/mediction/mediction.id/resources/views/livewire/admin/promotion/show/admin-promotion-show-index.blade.php ENDPATH**/ ?>