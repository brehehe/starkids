<div>
    <?php echo $__env->make('livewire.admin.consultation.consultation.admin-consultation-consultation-modal', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
    <div class="mb-4">
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-2xl font-bold text-[#1E3A8A]">Konsultasi</h1>
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
    <div class="bg-white/80 backdrop-blur-sm rounded-xl shadow-lg border border-gray-100 overflow-x-auto scrollbar-thin mb-6">
        <div class="table-container overflow-x-auto scrollbar-thin">
            <table class="table">
                <thead>
                    <tr>
                        <th class="w-12 text-center">No</th>
                        <th class="whitespace-nowrap">Nomor Antrian</th>
                        <th class="whitespace-nowrap">Tgl Daftar</th>
                        <th class="whitespace-nowrap">Asuransi</th>
                        <th class="whitespace-nowrap">Pasien</th>
                        <th class="whitespace-nowrap">No. IHS</th>
                        <th class="whitespace-nowrap">Tgl Lahir</th>
                        <th class="whitespace-nowrap">Nomer HP</th>
                        <th class="whitespace-nowrap">Dokter</th>
                        <th class="whitespace-nowrap">Poli</th>
                        <th class="whitespace-nowrap">Status</th>
                        <th class="w-24 text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__empty_5 = true; $__currentLoopData = $transactions; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $transaction): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_5 = false; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoopIteration(); ?><?php endif; ?>
                        <tr
                            class="hover:bg-green-50 <?php echo e(in_array($transaction->status, ['draft_consultation', 'call_consultation', 'confirmation_call', 'consultation']) ? '' : ($transaction->status == 'canceled' ? 'bg-red-100' : 'bg-green-100')); ?>">
                            <td class="text-center"><?php echo e($transactions->firstItem() + $index); ?></td>
                            <td>
                                <div class="flex flex-col">
                                    <span class="font-medium text-gray-900"><?php echo e($transaction->code_consultation ?? '-'); ?></span>
                                    <span class="text-xs text-gray-500 ml-1">
                                        <?php echo e($transaction?->controlDoctor?->start_time_get); ?> - <?php echo e($transaction?->controlDoctor?->end_time_get); ?>

                                    </span>
                                </div>
                            </td>
                            <td class="text-sm whitespace-nowrap">
                                <?php echo e($transaction->created_at ? \Carbon\Carbon::parse($transaction->created_at)->locale('id')->isoFormat('DD MMMM YYYY HH:mm') : '-'); ?>

                            </td>
                            <td class="text-sm whitespace-nowrap">
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium <?php echo e($transaction->is_insurance ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800'); ?>"><?php echo e($transaction->is_insurance ? 'Ya' : 'Tidak'); ?></span>
                            </td>
                            <td class="font-medium text-gray-900 whitespace-nowrap"><?php echo e($transaction->patient_name ?? '-'); ?></td>
                            <td class="text-sm whitespace-nowrap">
                                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($transaction->patient?->patient?->OHPatient?->id_patient): ?>
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-semibold bg-emerald-50 text-emerald-700 border border-emerald-200">
                                        <?php echo e($transaction->patient->patient->OHPatient->id_patient); ?>

                                    </span>
                                <?php elseif($transaction->patient?->patient?->ihs_number): ?>
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-semibold bg-emerald-50 text-emerald-700 border border-emerald-200">
                                        <?php echo e($transaction->patient->patient->ihs_number); ?>

                                    </span>
                                <?php elseif($transaction->patient?->userDetail?->ihs_number): ?>
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-semibold bg-emerald-50 text-emerald-700 border border-emerald-200">
                                        <?php echo e($transaction->patient->userDetail->ihs_number); ?>

                                    </span>
                                <?php else: ?>
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-gray-50 text-gray-500 border border-gray-200">
                                        Belum Terhubung
                                    </span>
                                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                            </td>
                            <td class="text-sm whitespace-nowrap">
                                <?php echo e($transaction?->patient?->userDetail?->birth_date ? \Carbon\Carbon::parse($transaction->patient->userDetail->birth_date)->locale('id')->isoFormat('DD MMM YY') : '-'); ?>

                            </td>
                            <td class="text-sm whitespace-nowrap"><?php echo e($transaction?->patient?->phone ?? '-'); ?></td>
                            <td class="text-sm whitespace-nowrap"><?php echo e($transaction?->doctor?->name ?? '-'); ?></td>
                            <td class="text-sm whitespace-nowrap"><?php echo e($transaction->location_name ?? '-'); ?></td>
                            <td>
                                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($transaction->status == 'draft_consultation'): ?>
                                    <span
                                        class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800">
                                        Draft
                                    </span>
                                <?php elseif($transaction->status == 'call_consultation'): ?>
                                    <span
                                        class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                        Panggilan
                                    </span>
                                <?php elseif($transaction->status == 'confirmation_call'): ?>
                                    <span
                                        class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                        Konfirmasi
                                    </span>
                                <?php elseif($transaction->status == 'consultation'): ?>
                                    <span
                                        class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                        Konsultasi
                                    </span>
                                <?php else: ?>
                                    <span
                                        class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-gray-100 text-gray-800">
                                        Selesai
                                    </span>
                                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                            </td>
                            <td class="text-center">
                                <div class="flex items-center justify-center gap-1">
                                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(!$transaction->transactionPhysicalExamination): ?>
                                        <button
                                            class="btn btn-icon text-green-600 hover:text-green-800 transition-colors edit-btn"
                                            wire:click="createPhysicalExam('<?php echo e($transaction->id); ?>')">
                                            <i class="fa-solid fa-file-medical"></i>
                                        </button>
                                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($transaction->status == 'draft_consultation'): ?>
                                        <button
                                            class="btn btn-icon text-yellow-600 hover:text-yellow-800 transition-colors edit-btn"
                                            wire:click="confirmCallPatient('<?php echo e($transaction->id); ?>')">
                                            <i class="fa-solid fa-user-check"></i>
                                        </button>
                                        <button
                                            class="btn btn-icon text-red-600 hover:text-red-800 transition-colors edit-btn"
                                            wire:click="confirmCancelled('<?php echo e($transaction->id); ?>')">
                                            <i class="fa-solid fa-trash"></i>
                                        </button>
                                    <?php elseif($transaction->status == 'call_consultation'): ?>
                                        <button
                                            class="btn btn-icon text-yellow-600 hover:text-yellow-800 transition-colors edit-btn"
                                            wire:click="confirmCall('<?php echo e($transaction->id); ?>')">
                                            <i class="fa-solid fa-phone"></i>
                                        </button>
                                        <button
                                            class="btn btn-icon text-red-600 hover:text-red-800 transition-colors edit-btn"
                                            wire:click="confirmCancelled('<?php echo e($transaction->id); ?>')">
                                            <i class="fa-solid fa-trash"></i>
                                        </button>
                                    <?php elseif($transaction->status == 'confirmation_call'): ?>
                                        <button
                                            class="btn btn-icon text-green-600 hover:text-green-800 transition-colors edit-btn"
                                            wire:click="confirmConsultation('<?php echo e($transaction->id); ?>')">
                                            <i class="fa-solid fa-stethoscope"></i>
                                        </button>
                                        <button
                                            class="btn btn-icon text-red-600 hover:text-red-800 transition-colors edit-btn"
                                            wire:click="confirmCancelled('<?php echo e($transaction->id); ?>')">
                                            <i class="fa-solid fa-trash"></i>
                                        </button>
                                    <?php elseif($transaction->status == 'consultation'): ?>
                                        <button
                                            class="btn btn-icon text-green-600 hover:text-green-800 transition-colors edit-btn"
                                            wire:click="confirmConsultation('<?php echo e($transaction->id); ?>')">
                                            <i class="fa-solid fa-stethoscope"></i>
                                        </button>
                                        <button
                                            class="btn btn-icon text-red-600 hover:text-red-800 transition-colors edit-btn"
                                            wire:click="confirmCancelled('<?php echo e($transaction->id); ?>')">
                                            <i class="fa-solid fa-trash"></i>
                                        </button>
                                    <?php else: ?>
                                        <button
                                            class="btn btn-icon text-blue-600 hover:text-blue-800 transition-colors edit-btn"
                                            wire:click="confirmDetail('<?php echo e($transaction->id); ?>')">
                                            <i class="fa-solid fa-eye"></i>
                                        </button>
                                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                </div>
                            </td>
                        </tr>
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_5): ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
                        <tr>
                            <td colspan="12" class="no-data">Tidak ada data
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
</div><?php /**PATH /Users/macbookair/Documents/mediction/mediction.id/resources/views/livewire/admin/consultation/consultation/admin-consultation-consultation-index.blade.php ENDPATH**/ ?>