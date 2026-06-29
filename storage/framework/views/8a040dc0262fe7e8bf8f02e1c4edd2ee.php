<div>
    <div class="mb-4">
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-2xl font-bold text-[#1E3A8A]">Laporan Medis Komprehensif</h1>
                <p class="text-gray-600 mt-1">Analisis data medis: diagnosis, resep, pemeriksaan fisik, dan kode ICD</p>
            </div>
            <div class="flex space-x-2">
                <button wire:click="exportData" class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-lg transition-colors">
                    <i class="fas fa-download mr-2"></i>Export
                </button>
            </div>
        </div>
    </div>

    <!-- Summary Cards -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4 mb-6">
        <div class="bg-gradient-to-r from-blue-500 to-blue-600 rounded-xl shadow-lg p-6 text-white">
            <div class="flex items-center justify-between">
                <div>
                    <h3 class="text-sm font-medium opacity-90">Total Konsultasi</h3>
                    <p class="text-2xl font-bold"><?php echo e(number_format($summaryData['total_consultations'] ?? 0)); ?></p>
                </div>
                <div class="w-12 h-12 bg-white bg-opacity-20 rounded-full flex items-center justify-center">
                    <i class="fas fa-user-md text-xl"></i>
                </div>
            </div>
        </div>

        <div class="bg-gradient-to-r from-green-500 to-green-600 rounded-xl shadow-lg p-6 text-white">
            <div class="flex items-center justify-between">
                <div>
                    <h3 class="text-sm font-medium opacity-90">Total Diagnosis</h3>
                    <p class="text-2xl font-bold"><?php echo e(number_format($summaryData['total_diagnoses'] ?? 0)); ?></p>
                </div>
                <div class="w-12 h-12 bg-white bg-opacity-20 rounded-full flex items-center justify-center">
                    <i class="fas fa-stethoscope text-xl"></i>
                </div>
            </div>
        </div>

        <div class="bg-gradient-to-r from-purple-500 to-purple-600 rounded-xl shadow-lg p-6 text-white">
            <div class="flex items-center justify-between">
                <div>
                    <h3 class="text-sm font-medium opacity-90">Total Resep</h3>
                    <p class="text-2xl font-bold"><?php echo e(number_format($summaryData['total_recipes'] ?? 0)); ?></p>
                </div>
                <div class="w-12 h-12 bg-white bg-opacity-20 rounded-full flex items-center justify-center">
                    <i class="fas fa-prescription-bottle-alt text-xl"></i>
                </div>
            </div>
        </div>

        <div class="bg-gradient-to-r from-orange-500 to-orange-600 rounded-xl shadow-lg p-6 text-white">
            <div class="flex items-center justify-between">
                <div>
                    <h3 class="text-sm font-medium opacity-90">Pemeriksaan Fisik</h3>
                    <p class="text-2xl font-bold"><?php echo e(number_format($summaryData['total_examinations'] ?? 0)); ?></p>
                </div>
                <div class="w-12 h-12 bg-white bg-opacity-20 rounded-full flex items-center justify-center">
                    <i class="fas fa-heartbeat text-xl"></i>
                </div>
            </div>
        </div>

        <div class="bg-gradient-to-r from-teal-500 to-teal-600 rounded-xl shadow-lg p-6 text-white">
            <div class="flex items-center justify-between">
                <div>
                    <h3 class="text-sm font-medium opacity-90">Pasien Unik</h3>
                    <p class="text-2xl font-bold"><?php echo e(number_format($summaryData['unique_patients'] ?? 0)); ?></p>
                </div>
                <div class="w-12 h-12 bg-white bg-opacity-20 rounded-full flex items-center justify-center">
                    <i class="fas fa-users text-xl"></i>
                </div>
            </div>
        </div>

        <div class="bg-gradient-to-r from-indigo-500 to-indigo-600 rounded-xl shadow-lg p-6 text-white">
            <div class="flex items-center justify-between">
                <div>
                    <h3 class="text-sm font-medium opacity-90">Dokter Aktif</h3>
                    <p class="text-2xl font-bold"><?php echo e(number_format($summaryData['unique_doctors'] ?? 0)); ?></p>
                </div>
                <div class="w-12 h-12 bg-white bg-opacity-20 rounded-full flex items-center justify-center">
                    <i class="fas fa-user-friends text-xl"></i>
                </div>
            </div>
        </div>
    </div>

    <!-- Filters -->
    <div class="bg-white rounded-xl shadow-lg p-6 mb-6">
        <h3 class="text-lg font-semibold text-gray-800 mb-4">Filter Laporan Medis</h3>
        
        <!-- Report Type Selection -->
        <div class="mb-4">
            <label class="block text-sm font-medium text-gray-700 mb-2">Jenis Laporan</label>
            <div class="flex flex-wrap gap-2">
                <button wire:click="$set('reportType', 'diagnosis')" 
                    class="px-4 py-2 rounded-lg transition-colors <?php echo e($reportType === 'diagnosis' ? 'bg-blue-600 text-white' : 'bg-gray-200 text-gray-700 hover:bg-gray-300'); ?>">
                    <i class="fas fa-stethoscope mr-1"></i>Diagnosis
                </button>
                <button wire:click="$set('reportType', 'recipe')" 
                    class="px-4 py-2 rounded-lg transition-colors <?php echo e($reportType === 'recipe' ? 'bg-blue-600 text-white' : 'bg-gray-200 text-gray-700 hover:bg-gray-300'); ?>">
                    <i class="fas fa-prescription-bottle-alt mr-1"></i>Resep
                </button>
                <button wire:click="$set('reportType', 'examination')" 
                    class="px-4 py-2 rounded-lg transition-colors <?php echo e($reportType === 'examination' ? 'bg-blue-600 text-white' : 'bg-gray-200 text-gray-700 hover:bg-gray-300'); ?>">
                    <i class="fas fa-heartbeat mr-1"></i>Pemeriksaan Fisik
                </button>
                <button wire:click="$set('reportType', 'icd')" 
                    class="px-4 py-2 rounded-lg transition-colors <?php echo e($reportType === 'icd' ? 'bg-blue-600 text-white' : 'bg-gray-200 text-gray-700 hover:bg-gray-300'); ?>">
                    <i class="fas fa-code mr-1"></i>Kode ICD
                </button>
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
            <div>
                <label class="block text-sm font-medium text-gray-700">Dari Tanggal</label>
                <input type="date" wire:model.live="start_date" class="mt-1 form-control" />
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700">Sampai Tanggal</label>
                <input type="date" wire:model.live="end_date" class="mt-1 form-control" />
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700">Dokter</label>
                <select wire:model.live="doctor_id" class="mt-1 form-control">
                    <option value="">Semua Dokter</option>
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__currentLoopData = $doctors; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $doctor): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoopIteration(); ?><?php endif; ?>
                        <option value="<?php echo e($doctor->id); ?>"><?php echo e($doctor->name); ?></option>
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
                </select>
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700">Pencarian</label>
                <input type="text" wire:model.live="search" placeholder="Cari diagnosis, obat, kode..." class="mt-1 form-control" />
            </div>
        </div>
    </div>

    <!-- Table Controls -->
    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center mb-4 gap-4">
        <div class="flex items-center">
            <span class="text-sm text-gray-700 mr-2">Tampil</span>
            <select class="mt-1 form-control" wire:model.live='perPage'>
                <option value="10">10</option>
                <option value="25">25</option>
                <option value="50">50</option>
                <option value="100">100</option>
            </select>
            <span class="text-sm text-gray-700 ml-2">data</span>
        </div>
    </div>

    <!-- Data Table -->
    <div class="bg-white/80 backdrop-blur-sm rounded-xl shadow-lg border border-gray-100 overflow-hidden mb-6">
        <div class="table-container">
            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($reportType === 'diagnosis'): ?>
                <!-- Diagnosis Report Table -->
                <table class="table">
                    <thead>
                        <tr>
                            <th class="w-1 center">No</th>
                            <th>Kode Transaksi</th>
                            <th>Tanggal</th>
                            <th>Pasien</th>
                            <th>Dokter</th>
                            <th>Diagnosis</th>
                            <th>Catatan</th>
                            <th>Tindak Lanjut</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__empty_5 = true; $__currentLoopData = $reportData; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $diagnosis): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_5 = false; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoopIteration(); ?><?php endif; ?>
                            <tr>
                                <td class="center"><?php echo e($reportData->firstItem() + $index); ?></td>
                                <td class="font-medium"><?php echo e($diagnosis->transaction->code); ?></td>
                                <td><?php echo e($diagnosis->created_at->format('d/m/Y H:i')); ?></td>
                                <td><?php echo e($diagnosis->transaction->patient_name ?? $diagnosis->transaction->patient?->name ?? '-'); ?></td>
                                <td><?php echo e($diagnosis->transaction->doctor?->name ?? '-'); ?></td>
                                <td class="max-w-xs">
                                    <div class="truncate" title="<?php echo e($diagnosis->diagnosis); ?>">
                                        <?php echo e($diagnosis->diagnosis); ?>

                                    </div>
                                </td>
                                <td class="max-w-xs">
                                    <div class="truncate" title="<?php echo e($diagnosis->notes); ?>">
                                        <?php echo e($diagnosis->notes ?? '-'); ?>

                                    </div>
                                </td>
                                <td><?php echo e($diagnosis->follow_up ?? '-'); ?></td>
                            </tr>
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_5): ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
                            <tr>
                                <td colspan="8" class="center text-gray-500 py-8">
                                    <i class="fas fa-stethoscope text-4xl mb-4 opacity-50"></i>
                                    <p>Tidak ada data diagnosis</p>
                                </td>
                            </tr>
                        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                    </tbody>
                </table>
            <?php elseif($reportType === 'recipe'): ?>
                <!-- Recipe Report Table -->
                <table class="table">
                    <thead>
                        <tr>
                            <th class="w-1 center">No</th>
                            <th>Kode Transaksi</th>
                            <th>Tanggal</th>
                            <th>Pasien</th>
                            <th>Dokter</th>
                            <th>Obat</th>
                            <th>Dosis</th>
                            <th>Aturan Pakai</th>
                            <th>Qty</th>
                            <th>Narkotika</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__empty_5 = true; $__currentLoopData = $reportData; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $recipe): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_5 = false; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoopIteration(); ?><?php endif; ?>
                            <tr>
                                <td class="center"><?php echo e($reportData->firstItem() + $index); ?></td>
                                <td class="font-medium"><?php echo e($recipe->transaction->code); ?></td>
                                <td><?php echo e($recipe->created_at->format('d/m/Y H:i')); ?></td>
                                <td><?php echo e($recipe->transaction->patient_name); ?></td>
                                <td><?php echo e($recipe->transaction->doctor?->name ?? '-'); ?></td>
                                <td><?php echo e($recipe->product_name); ?></td>
                                <td><?php echo e($recipe->dosage ?? '-'); ?></td>
                                <td class="max-w-xs">
                                    <div class="truncate" title="<?php echo e($recipe->usage_rules); ?>">
                                        <?php echo e($recipe->usage_rules ?? '-'); ?>

                                    </div>
                                </td>
                                <td class="center"><?php echo e(number_format($recipe->quantity)); ?></td>
                                <td class="center">
                                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($recipe->is_narcotic): ?>
                                        <span class="px-2 py-1 text-xs rounded-full bg-red-100 text-red-800">
                                            <i class="fas fa-exclamation-triangle mr-1"></i>Ya
                                        </span>
                                    <?php else: ?>
                                        <span class="px-2 py-1 text-xs rounded-full bg-green-100 text-green-800">
                                            Tidak
                                        </span>
                                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                </td>
                            </tr>
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_5): ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
                            <tr>
                                <td colspan="10" class="center text-gray-500 py-8">
                                    <i class="fas fa-prescription-bottle-alt text-4xl mb-4 opacity-50"></i>
                                    <p>Tidak ada data resep</p>
                                </td>
                            </tr>
                        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                    </tbody>
                </table>
            <?php elseif($reportType === 'examination'): ?>
                <!-- Physical Examination Report Table -->
                <table class="table">
                    <thead>
                        <tr>
                            <th class="w-1 center">No</th>
                            <th>Kode Transaksi</th>
                            <th>Tanggal</th>
                            <th>Pasien</th>
                            <th>Dokter</th>
                            <th>Tekanan Darah</th>
                            <th>Detak Jantung</th>
                            <th>Suhu</th>
                            <th>Berat Badan</th>
                            <th>Tinggi Badan</th>
                            <th>Catatan</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__empty_5 = true; $__currentLoopData = $reportData; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $examination): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_5 = false; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoopIteration(); ?><?php endif; ?>
                            <tr>
                                <td class="center"><?php echo e($reportData->firstItem() + $index); ?></td>
                                <td class="font-medium"><?php echo e($examination->transaction->code); ?></td>
                                <td><?php echo e($examination->created_at->format('d/m/Y H:i')); ?></td>
                                <td><?php echo e($examination->transaction->patient_name); ?></td>
                                <td><?php echo e($examination->transaction->doctor?->name ?? '-'); ?></td>
                                <td><?php echo e($examination->blood_pressure ?? '-'); ?></td>
                                <td><?php echo e($examination->heart_rate ? $examination->heart_rate . ' bpm' : '-'); ?></td>
                                <td><?php echo e($examination->temperature ? $examination->temperature . '°C' : '-'); ?></td>
                                <td><?php echo e($examination->weight ? $examination->weight . ' kg' : '-'); ?></td>
                                <td><?php echo e($examination->height ? $examination->height . ' cm' : '-'); ?></td>
                                <td class="max-w-xs">
                                    <div class="truncate" title="<?php echo e($examination->notes); ?>">
                                        <?php echo e($examination->notes ?? '-'); ?>

                                    </div>
                                </td>
                            </tr>
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_5): ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
                            <tr>
                                <td colspan="11" class="center text-gray-500 py-8">
                                    <i class="fas fa-heartbeat text-4xl mb-4 opacity-50"></i>
                                    <p>Tidak ada data pemeriksaan fisik</p>
                                </td>
                            </tr>
                        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                    </tbody>
                </table>
            <?php elseif($reportType === 'icd'): ?>
                <!-- ICD Report Table -->
                <table class="table">
                    <thead>
                        <tr>
                            <th class="w-1 center">No</th>
                            <th>Kode Transaksi</th>
                            <th>Tanggal</th>
                            <th>Pasien</th>
                            <th>Dokter</th>
                            <th>Tipe ICD</th>
                            <th>Kode</th>
                            <th>Deskripsi</th>
                            <th>Kategori</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__empty_5 = true; $__currentLoopData = $reportData; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $icd): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_5 = false; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoopIteration(); ?><?php endif; ?>
                            <tr>
                                <td class="center"><?php echo e($reportData->firstItem() + $index); ?></td>
                                <td class="font-medium"><?php echo e($icd->transaction->code); ?></td>
                                <td><?php echo e($icd->created_at->format('d/m/Y H:i')); ?></td>
                                <td><?php echo e($icd->transaction->patient_name); ?></td>
                                <td><?php echo e($icd->transaction->doctor?->name ?? '-'); ?></td>
                                <td>
                                    <span class="px-2 py-1 text-xs rounded-full <?php echo e($icd->icd_type === 'ICD-9' ? 'bg-blue-100 text-blue-800' : 'bg-purple-100 text-purple-800'); ?>">
                                        <?php echo e($icd->icd_type); ?>

                                    </span>
                                </td>
                                <td class="font-mono"><?php echo e($icd->code ?? '-'); ?></td>
                                <td class="max-w-xs">
                                    <div class="truncate" title="<?php echo e($icd->description); ?>">
                                        <?php echo e($icd->description ?? '-'); ?>

                                    </div>
                                </td>
                                <td><?php echo e($icd->category ?? '-'); ?></td>
                            </tr>
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_5): ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
                            <tr>
                                <td colspan="9" class="center text-gray-500 py-8">
                                    <i class="fas fa-code text-4xl mb-4 opacity-50"></i>
                                    <p>Tidak ada data kode ICD</p>
                                </td>
                            </tr>
                        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                    </tbody>
                </table>
            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
        </div>
    </div>

    <!-- Pagination -->
    <div class="mt-6">
        <?php echo e($reportData->links()); ?>

    </div>
</div>

<?php $__env->startPush('scripts'); ?>
<script>
    document.addEventListener('livewire:init', function() {
        Livewire.on('export-started', function() {
            Swal.fire({
                title: 'Mengekspor Data Medis...',
                text: 'Mohon tunggu sebentar',
                allowOutsideClick: false,
                showConfirmButton: false,
                willOpen: () => {
                    Swal.showLoading();
                }
            });
        });
    });
</script>
<?php $__env->stopPush(); ?><?php /**PATH /Users/macbookair/Documents/mediction/mediction.id/resources/views/livewire/admin/report/medical/admin-report-medical-index.blade.php ENDPATH**/ ?>