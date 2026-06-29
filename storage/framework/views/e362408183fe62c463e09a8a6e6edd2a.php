<div>
    <div class="mb-4">
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-2xl font-bold text-[#1E3A8A]">SatuSehat Sync Manager</h1>
                <p class="text-sm text-gray-500">Sinkronisasi data Pasien dan Kunjungan Medis ke platform SatuSehat Kemenkes.</p>
            </div>
        </div>
    </div>

    <!-- Status Cards -->
    <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-6">
        <div class="p-4 bg-white/85 backdrop-blur-sm shadow-md rounded-xl border-l-4 border-yellow-500">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-xs font-semibold text-gray-500 uppercase">Antrian Pending</p>
                    <h3 class="text-2xl font-bold text-gray-800"><?php echo e($stats['pending']); ?></h3>
                </div>
                <div class="p-2 bg-yellow-100 rounded-full text-yellow-600">
                    <i class="fa-solid fa-clock-rotate-left text-xl"></i>
                </div>
            </div>
        </div>
        <div class="p-4 bg-white/85 backdrop-blur-sm shadow-md rounded-xl border-l-4 border-blue-500">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-xs font-semibold text-gray-500 uppercase">Sedang Diproses</p>
                    <h3 class="text-2xl font-bold text-gray-800"><?php echo e($stats['process']); ?></h3>
                </div>
                <div class="p-2 bg-blue-100 rounded-full text-blue-600">
                    <i class="fa-solid fa-spinner fa-spin text-xl"></i>
                </div>
            </div>
        </div>
        <div class="p-4 bg-white/85 backdrop-blur-sm shadow-md rounded-xl border-l-4 border-green-500">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-xs font-semibold text-gray-500 uppercase">Sukses Terkirim</p>
                    <h3 class="text-2xl font-bold text-gray-800"><?php echo e($stats['success']); ?></h3>
                </div>
                <div class="p-2 bg-green-100 rounded-full text-green-600">
                    <i class="fa-solid fa-circle-check text-xl"></i>
                </div>
            </div>
        </div>
        <div class="p-4 bg-white/85 backdrop-blur-sm shadow-md rounded-xl border-l-4 border-red-500">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-xs font-semibold text-gray-500 uppercase">Gagal Terkirim</p>
                    <h3 class="text-2xl font-bold text-gray-800"><?php echo e($stats['failed']); ?></h3>
                </div>
                <div class="p-2 bg-red-100 rounded-full text-red-600">
                    <i class="fa-solid fa-triangle-exclamation text-xl"></i>
                </div>
            </div>
        </div>
    </div>

    <!-- Navigation Tabs -->
    <div class="mb-6">
        <div class="border-b border-gray-200">
            <nav class="flex gap-6" aria-label="Tabs">
                <button wire:click="changeTab('patient')"
                    class="py-4 px-1 border-b-2 font-medium text-sm transition-all <?php echo e($tab === 'patient' ? 'border-[#1E3A8A] text-[#1E3A8A]' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300'); ?>">
                    <i class="fa-solid fa-user mr-2"></i>Pasien Belum Sinkron
                </button>
                <button wire:click="changeTab('encounter')"
                    class="py-4 px-1 border-b-2 font-medium text-sm transition-all <?php echo e($tab === 'encounter' ? 'border-[#1E3A8A] text-[#1E3A8A]' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300'); ?>">
                    <i class="fa-solid fa-file-medical mr-2"></i>Kunjungan Belum Sinkron
                </button>
                <button wire:click="changeTab('outbox')"
                    class="py-4 px-1 border-b-2 font-medium text-sm transition-all <?php echo e($tab === 'outbox' ? 'border-[#1E3A8A] text-[#1E3A8A]' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300'); ?>">
                    <i class="fa-solid fa-list-check mr-2"></i>Log Antrian (Outbox)
                </button>
            </nav>
        </div>
    </div>

    <!-- Controls Area -->
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

        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($tab === 'outbox'): ?>
            <div class="w-full sm:w-48">
                <select class="mt-1 form-control" wire:model.live="outboxStatus">
                    <option value="">Semua Status Antrian</option>
                    <option value="pending">Pending</option>
                    <option value="process">Proses</option>
                    <option value="success">Sukses</option>
                    <option value="failed">Gagal</option>
                </select>
            </div>
        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

        <div class="relative w-full sm:w-64">
            <input type="text" class="mt-1 form-control-search pl-10" placeholder="Cari kata kunci..."
                wire:model.live.debounce.300ms="search">
            <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                <i class="fas fa-search h-3 w-3 text-gray-400"></i>
            </div>
        </div>

        <div class="flex gap-2 w-full sm:w-auto justify-end">
            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($tab === 'patient'): ?>
                <button wire:click="queueAllUnsyncedPatients" class="btn btn-primary">
                    <i class="fa-solid fa-cloud-arrow-up mr-2"></i> Sinkron Semua Pasien (Max 100)
                </button>
            <?php elseif($tab === 'encounter'): ?>
                <button wire:click="queueAllUnsyncedEncounters" class="btn btn-primary">
                    <i class="fa-solid fa-cloud-arrow-up mr-2"></i> Sinkron Semua Kunjungan (Max 100)
                </button>
            <?php elseif($tab === 'outbox'): ?>
                <button wire:click="retryFailedTasks" class="btn btn-warning text-white">
                    <i class="fa-solid fa-arrows-rotate mr-2"></i> Coba Lagi Gagal
                </button>
                <button wire:click="clearFailedTasks" class="btn btn-danger">
                    <i class="fa-solid fa-trash-can mr-2"></i> Hapus Gagal
                </button>
            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
        </div>
    </div>

    <!-- Table Section -->
    <div class="bg-white/80 backdrop-blur-sm rounded-xl shadow-lg border border-gray-100 overflow-hidden mb-6">
        <div class="table-container">
            <table class="table">
                <thead>
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($tab === 'patient'): ?>
                        <tr>
                            <th class="w-1 center">No</th>
                            <th>Nama Pasien</th>
                            <th>NIK</th>
                            <th>Jenis Kelamin</th>
                            <th>Tanggal Lahir</th>
                            <th class="center">Status</th>
                            <th class="w-1 center">Aksi</th>
                        </tr>
                    <?php elseif($tab === 'encounter'): ?>
                        <tr>
                            <th class="w-1 center">No</th>
                            <th>Kode Transaksi</th>
                            <th>Nama Pasien</th>
                            <th>Dokter</th>
                            <th>Tanggal Kunjungan</th>
                            <th class="center">Status</th>
                            <th class="w-1 center">Aksi</th>
                        </tr>
                    <?php elseif($tab === 'outbox'): ?>
                        <tr>
                            <th class="w-1 center">No</th>
                            <th>Service / Method</th>
                            <th class="center">Status</th>
                            <th class="center">Percobaan</th>
                            <th>Tanggal Antrian</th>
                            <th>Respon / Error</th>
                            <th class="w-1 center">Aksi</th>
                        </tr>
                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                </thead>
                <tbody>
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__empty_1 = true; $__currentLoopData = $dataList; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoopIteration(); ?><?php endif; ?>
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($tab === 'patient'): ?>
                            <tr>
                                <td class="center"><?php echo e($dataList->firstItem() + $index); ?></td>
                                <td class="font-medium text-gray-900"><?php echo e($item->name); ?></td>
                                <td><?php echo e($item->userDetail->identity_card ?? '-'); ?></td>
                                <td><?php echo e($item->userDetail->administrative_gender === 'male' ? 'Laki-laki' : ($item->userDetail->administrative_gender === 'female' ? 'Perempuan' : '-')); ?></td>
                                <td><?php echo e($item->userDetail->birth_date ? \Carbon\Carbon::parse($item->userDetail->birth_date)->locale('id')->isoFormat('D MMMM Y') : '-'); ?></td>
                                <td class="center">
                                    <span class="px-2 py-1 text-xs font-medium rounded-full bg-red-100 text-red-800">Belum Sync</span>
                                </td>
                                <td class="center">
                                    <button wire:click="queuePatient('<?php echo e($item->id); ?>')" class="btn btn-icon text-blue-600 hover:text-blue-800" title="Sinkronkan Pasien">
                                        <i class="fa-solid fa-cloud-arrow-up text-lg"></i>
                                    </button>
                                </td>
                            </tr>
                        <?php elseif($tab === 'encounter'): ?>
                            <tr>
                                <td class="center"><?php echo e($dataList->firstItem() + $index); ?></td>
                                <td class="font-medium text-gray-900"><?php echo e($item->transaction->code ?? '-'); ?></td>
                                <td><?php echo e($item->transaction->patient_name ?? '-'); ?></td>
                                <td><?php echo e($item->transaction->doctor_name ?? '-'); ?></td>
                                <td><?php echo e($item->transaction->date ? \Carbon\Carbon::parse($item->transaction->date)->locale('id')->isoFormat('D MMMM Y') : '-'); ?></td>
                                <td class="center">
                                    <span class="px-2 py-1 text-xs font-medium rounded-full bg-red-100 text-red-800">Belum Sync</span>
                                </td>
                                <td class="center">
                                    <button wire:click="queueEncounter('<?php echo e($item->id); ?>')" class="btn btn-icon text-blue-600 hover:text-blue-800" title="Sinkronkan Kunjungan">
                                        <i class="fa-solid fa-cloud-arrow-up text-lg"></i>
                                    </button>
                                </td>
                            </tr>
                        <?php elseif($tab === 'outbox'): ?>
                            <tr>
                                <td class="center"><?php echo e($dataList->firstItem() + $index); ?></td>
                                <td class="font-medium text-gray-900">
                                    <p class="text-sm font-semibold"><?php echo e(class_basename($item->service_class)); ?></p>
                                    <span class="text-xs text-gray-500 font-normal">Method: <?php echo e($item->service_method); ?></span>
                                </td>
                                <td class="center">
                                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($item->status === 'success'): ?>
                                        <span class="px-2 py-1 text-xs font-medium rounded-full bg-green-100 text-green-800">Sukses</span>
                                    <?php elseif($item->status === 'failed'): ?>
                                        <span class="px-2 py-1 text-xs font-medium rounded-full bg-red-100 text-red-800">Gagal</span>
                                    <?php elseif($item->status === 'process'): ?>
                                        <span class="px-2 py-1 text-xs font-medium rounded-full bg-blue-100 text-blue-800">Proses</span>
                                    <?php else: ?>
                                        <span class="px-2 py-1 text-xs font-medium rounded-full bg-yellow-100 text-yellow-800">Pending</span>
                                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                </td>
                                <td class="center"><?php echo e($item->execution); ?> / 3</td>
                                <td><?php echo e($item->created_at ? $item->created_at->locale('id')->isoFormat('D MMMM Y HH:mm:s') : '-'); ?></td>
                                <td>
                                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($item->response_body): ?>
                                        <div class="max-w-xs truncate text-xs text-gray-500" title="<?php echo e($item->response_body); ?>">
                                            <?php echo e($item->response_body); ?>

                                        </div>
                                    <?php else: ?>
                                        <span class="text-xs text-gray-400">-</span>
                                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                </td>
                                <td class="center">
                                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($item->status === 'failed'): ?>
                                        <button wire:click="retryFailedTasks" class="btn btn-icon text-yellow-600 hover:text-yellow-800" title="Coba Lagi">
                                            <i class="fa-solid fa-arrows-rotate"></i>
                                        </button>
                                    <?php else: ?>
                                        <span class="text-gray-300">-</span>
                                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                </td>
                            </tr>
                        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
                        <tr>
                            <td colspan="7" class="p-8 text-center text-gray-400">
                                <i class="fa-solid fa-inbox text-3xl mb-2 block"></i>
                                Tidak ada data yang ditemukan.
                            </td>
                        </tr>
                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($dataList instanceof \Illuminate\Pagination\LengthAwarePaginator && $dataList->hasPages()): ?>
            <div class="px-5 py-4 bg-gray-50/80 border-t border-gray-200">
                <div class="flex items-center justify-between">
                    <div class="text-sm text-gray-700">
                        Menampilkan <span class="font-medium"><?php echo e($dataList->firstItem()); ?></span> sampai <span
                            class="font-medium"><?php echo e($dataList->lastItem()); ?></span> dari <span
                            class="font-medium"><?php echo e($dataList->total()); ?></span> hasil
                    </div>
                    <div>
                        <nav class="relative z-0 inline-flex rounded-md shadow-sm -space-x-px" aria-label="Pagination">
                            <?php echo e($dataList->links('vendor.livewire.custom')); ?> <!-- Menampilkan pagination -->
                        </nav>
                    </div>
                </div>
            </div>
        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
    </div>
</div><?php /**PATH /Users/macbookair/Documents/mediction/mediction.id/resources/views/livewire/admin/consultation/satusehat/admin-consultation-satusehat-index.blade.php ENDPATH**/ ?>