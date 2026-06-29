<div>
    <div class="mb-4">
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-2xl font-bold text-[#1E3A8A]">Klaim Asuransi</h1>
            </div>
        </div>
    </div>
    <div class="space-y-6 mb-6">
        <!-- SECTION 1: Informasi Umum Produk -->
        <div class="p-6 bg-white shadow rounded-lg">
            <div class="flex gap-4">
                <div class="flex-1">
                    <label class="block text-sm font-medium text-gray-700">Tanggal Konsultasi</label>
                    <input type="date" class="mt-1 form-control w-full" wire:model.live='date'
                        placeholder="Pilih Tanggal">
                </div>
                <div class="flex-1">
                    <label class="block text-sm font-medium text-gray-700">Lokasi</label>
                    <select class="mt-1 form-control w-full" wire:model.live='location_id'>
                        <option value="">Semua Lokasi</option>
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__currentLoopData = $locations; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $id => $name): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoopIteration(); ?><?php endif; ?>
                            <option value="<?php echo e($id); ?>"><?php echo e($name); ?></option>
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
                    </select>
                </div>
                <div class="flex-1">
                    <label class="block text-sm font-medium text-gray-700">Pasien</label>
                    <select class="mt-1 form-control w-full" wire:model.live='patient_id'>
                        <option value="">Semua Pasien</option>
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__currentLoopData = $patients; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $id => $name): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoopIteration(); ?><?php endif; ?>
                            <option value="<?php echo e($id); ?>"><?php echo e($name); ?></option>
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
                    </select>
                </div>
                <div class="flex-1">
                    <label class="block text-sm font-medium text-gray-700">Asuransi</label>
                    <select class="mt-1 form-control w-full" wire:model.live='insurance_id'>
                        <option value="">Semua Asuransi</option>
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__currentLoopData = $insurances; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $id => $name): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoopIteration(); ?><?php endif; ?>
                            <option value="<?php echo e($id); ?>"><?php echo e($name); ?></option>
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
                    </select>
                </div>

                <div class="flex-1">
                    <label class="block text-sm font-medium text-gray-700">Klaim</label>
                    <select class="mt-1 form-control w-full" wire:model.live='is_insurance_claim'>
                        <option value="">Semua Klaim</option>
                        <option value="false">Belum Klaim</option>
                        <option value="true">Sudah Klaim</option>
                    </select>
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
                        <th>Nomor Antrian</th>
                        <th>Asuransi</th>
                        <th>Nomer Asuransi</th>
                        <th>Apakah Sudah Klaim?</th>
                        <th>Pasien</th>
                        <th>Dokter</th>
                        <th>Poli</th>
                        <th>Tanggal</th>
                        <th>Status</th>
                        <th class="w-1 center">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__empty_5 = true; $__currentLoopData = $transactions; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $transaction): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_5 = false; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoopIteration(); ?><?php endif; ?>
                        <tr>
                            <td class="center"><?php echo e($transactions->firstItem() + $index); ?></td>
                            <td>
                                <p><?php echo e($transaction->code_consultation ?? '-'); ?></p>
                                <span class="text-xs text-gray-500">
                                    <?php echo e($transaction?->controlDoctor?->start_time_get); ?>

                                    -
                                    <?php echo e($transaction?->controlDoctor?->end_time_get); ?>

                                </span>
                            </td>
                            <td><?php echo e($transaction?->insurance?->name ?? '-'); ?></td>
                            <td><?php echo e($transaction->insurance_number ?? '-'); ?></td>
                            <td>
                                <span
                                    class="px-2 py-1 text-xs font-medium rounded-full <?php echo e($transaction->is_insurance_claim ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800'); ?>">
                                    <?php echo e($transaction->is_insurance_claim ? 'Ya' : 'Belum'); ?>

                                </span>
                            </td>
                            <td><?php echo e($transaction->patient_name ?? '-'); ?></td>
                            <td><?php echo e($transaction?->doctor?->name ?? '-'); ?></td>
                            <td><?php echo e($transaction->location_name ?? '-'); ?></td>
                            <td>
                                <?php echo e($transaction->date ? \Carbon\Carbon::parse($transaction->date)->locale('id')->isoFormat('D MMMM Y') : '-'); ?>

                            </td>

                            <td>
                                <?php
                                    $statusColors = [
                                        'waiting_consultation' => 'bg-gray-100 text-gray-800',
                                        'draft_consultation' => 'bg-gray-200 text-gray-900',
                                        'call_consultation' => 'bg-blue-100 text-blue-800',
                                        'confirmation_call' => 'bg-indigo-100 text-indigo-800',
                                        'consultation' => 'bg-green-100 text-green-800',
                                        'pharmacy' => 'bg-teal-100 text-teal-800',
                                        'call_pharmacy' => 'bg-cyan-100 text-cyan-800',
                                        'sale_pharmacy' => 'bg-purple-100 text-purple-800',
                                        'draft' => 'bg-gray-100 text-gray-800',
                                        'process' => 'bg-yellow-100 text-yellow-800',
                                        'take_medicine' => 'bg-orange-100 text-orange-800',
                                        'completed' => 'bg-green-200 text-green-900',
                                        'canceled' => 'bg-red-100 text-red-800',
                                    ];

                                    $label = [
                                        'waiting_consultation' => 'Menunggu Konsultasi',
                                        'draft_consultation' => 'Draft Konsultasi',
                                        'call_consultation' => 'Panggil Konsultasi',
                                        'confirmation_call' => 'Konfirmasi Panggilan',
                                        'consultation' => 'Konsultasi',
                                        'pharmacy' => 'Farmasi',
                                        'call_pharmacy' => 'Panggil Farmasi',
                                        'sale_pharmacy' => 'Penjualan Farmasi',
                                        'draft' => 'Draft',
                                        'process' => 'Proses',
                                        'take_medicine' => 'Ambil Obat',
                                        'completed' => 'Selesai',
                                        'canceled' => 'Dibatalkan',
                                    ];
                                ?>

                                <span
                                    class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium <?php echo e($statusColors[$transaction->status] ?? 'bg-gray-100 text-gray-800'); ?>">
                                    <?php echo e($label[$transaction->status] ?? 'Selesai'); ?>

                                </span>
                            </td>
                            <td class="center">
                                <div class="flex items-center">
                                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(!$transaction->is_insurance_claim): ?>
                                        <button
                                            class="btn btn-icon text-green-600 hover:text-green-800 transition-colors edit-btn"
                                            wire:click="confirmInsuranceClaim('<?php echo e($transaction->id); ?>')">
                                            <i class="fa-solid fa-check"></i>
                                        </button>
                                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($transaction->status == 'canceled'): ?>
                                        <button
                                            class="btn btn-icon text-blue-600 hover:text-blue-800 transition-colors edit-btn"
                                            wire:click="confirmDetail('<?php echo e($transaction->id); ?>')">
                                            <i class="fa-solid fa-eye"></i>
                                        </button>
                                    <?php else: ?>
                                        <button
                                            class="btn btn-icon text-blue-600 hover:text-blue-800 transition-colors edit-btn"
                                            wire:click="confirmDetail('<?php echo e($transaction->id); ?>')">
                                            <i class="fa-solid fa-eye"></i>
                                        </button>
                                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(in_array($transaction->status, [
                                            'waiting_consultation',
                                            'draft_consultation',
                                            'call_consultation',
                                            'confirmation_call',
                                        ])): ?>
                                        <button
                                            class="btn btn-icon text-red-600 hover:text-red-800 transition-colors edit-btn"
                                            wire:click="confirmDelete('<?php echo e($transaction->id); ?>')">
                                            <i class="fa-solid fa-trash"></i>
                                        </button>
                                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                </div>
                            </td>
                        </tr>
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_5): ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
                        <tr>
                            <td colspan="10" class="no-data">Tidak ada data
                            </td>
                        </tr>
                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        <div class="px-5 py-4 bg-gray-50/80 border-t border-gray-200">
            <div class="flex items-center justify-between">
                <div class="text-sm text-gray-700">
                    Menampilkan <span class="font-medium"><?php echo e($transactions->firstItem()); ?></span> sampai <span
                        class="font-medium"><?php echo e($transactions->lastItem()); ?></span> dari <span
                        class="font-medium"><?php echo e($transactions->total()); ?></span> hasil
                </div>
                <div>
                    <nav class="relative z-0 inline-flex rounded-md shadow-sm -space-x-px" aria-label="Pagination">
                        <?php echo e($transactions->links('vendor.livewire.custom')); ?> <!-- Menampilkan pagination -->
                    </nav>
                </div>
            </div>
        </div>

    </div>
</div><?php /**PATH /Users/macbookair/Documents/mediction/mediction.id/resources/views/livewire/admin/consultation/claim-insurance/admin-consultation-claim-insurance-index.blade.php ENDPATH**/ ?>