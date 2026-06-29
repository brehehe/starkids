<?php $__env->startSection('content'); ?>
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">
                            <i class="fas fa-prescription-bottle-alt"></i> Daftar Resep Obat
                        </h3>
                    </div>
                    <div class="card-body">
                        <!-- Search Form -->
                        <form method="GET" action="<?php echo e(route('user.prescription.index')); ?>" class="mb-3">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="input-group">
                                        <input type="text" name="search" class="form-control"
                                            placeholder="Cari berdasarkan kode resep, nama pasien, atau dokter..."
                                            value="<?php echo e(request('search')); ?>">
                                        <div class="input-group-append">
                                            <button class="btn btn-primary" type="submit">
                                                <i class="fas fa-search"></i> Cari
                                            </button>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <a href="<?php echo e(route('user.prescription.index')); ?>" class="btn btn-secondary">
                                        <i class="fas fa-refresh"></i> Reset
                                    </a>
                                </div>
                            </div>
                        </form>

                        <!-- Prescriptions Table -->
                        <div class="table-responsive">
                            <table class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th style="width: 50px;">No</th>
                                        <th>Kode Resep</th>
                                        <th>Kode Konsultasi</th>
                                        <th>Tanggal</th>
                                        <th>Pasien</th>
                                        <th>Dokter</th>
                                        <th>Poli</th>
                                        <th>Status</th>
                                        <th style="width: 200px;">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__empty_1 = true; $__currentLoopData = $prescriptions; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $prescription): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoopIteration(); ?><?php endif; ?>
                                        <tr>
                                            <td><?php echo e($prescriptions->firstItem() + $index); ?></td>
                                            <td>
                                                <span class="badge badge-info"><?php echo e($prescription->code); ?></span>
                                            </td>
                                            <td>
                                                <span
                                                    class="badge badge-success"><?php echo e($prescription->code_consultation); ?></span>
                                            </td>
                                            <td><?php echo e($prescription->created_at->format('d/m/Y H:i')); ?></td>
                                            <td>
                                                <strong><?php echo e($prescription->patient_name); ?></strong><br>
                                                <small class="text-muted"><?php echo e($prescription->patient->phone ?? '-'); ?></small>
                                            </td>
                                            <td>
                                                <strong><?php echo e($prescription->doctor_name); ?></strong><br>
                                                <small class="text-muted"><?php echo e($prescription->poly_name); ?></small>
                                            </td>
                                            <td><?php echo e($prescription->poly_name); ?></td>
                                            <td>
                                                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($prescription->status == 'completed'): ?>
                                                    <span class="badge badge-success">Selesai</span>
                                                <?php elseif($prescription->status == 'processing'): ?>
                                                    <span class="badge badge-warning">Diproses</span>
                                                <?php else: ?>
                                                    <span
                                                        class="badge badge-secondary"><?php echo e(ucfirst($prescription->status)); ?></span>
                                                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                            </td>
                                            <td>
                                                <div class="btn-group" role="group">
                                                    <!-- View Prescription -->
                                                    <a href="<?php echo e(route('user.prescription.show', $prescription->id)); ?>"
                                                        class="btn btn-sm btn-info" title="Lihat Resep">
                                                        <i class="fas fa-eye"></i>
                                                    </a>

                                                    <!-- Print Prescription -->
                                                    <a href="<?php echo e(route('user.prescription.print', $prescription->id)); ?>"
                                                        class="btn btn-sm btn-primary" title="Cetak Resep" target="_blank">
                                                        <i class="fas fa-print"></i>
                                                    </a>

                                                    <!-- View Copy -->
                                                    <a href="<?php echo e(route('user.prescription.copy', $prescription->id)); ?>"
                                                        class="btn btn-sm btn-warning" title="Lihat Copy Resep">
                                                        <i class="fas fa-copy"></i>
                                                    </a>

                                                    <!-- Print Copy -->
                                                    <a href="<?php echo e(route('user.prescription.print-copy', $prescription->id)); ?>"
                                                        class="btn btn-sm btn-danger" title="Cetak Copy Resep"
                                                        target="_blank">
                                                        <i class="fas fa-file-pdf"></i>
                                                    </a>
                                                </div>
                                            </td>
                                        </tr>
                                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
                                        <tr>
                                            <td colspan="9" class="text-center">
                                                <div class="py-4">
                                                    <i class="fas fa-prescription-bottle-alt fa-3x text-muted mb-3"></i>
                                                    <p class="text-muted">Tidak ada resep yang ditemukan</p>
                                                </div>
                                            </td>
                                        </tr>
                                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                </tbody>
                            </table>
                        </div>

                        <!-- Pagination -->
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($prescriptions->hasPages()): ?>
                            <div class="row">
                                <div class="col-md-6">
                                    <p class="text-muted">
                                        Menampilkan <?php echo e($prescriptions->firstItem()); ?> - <?php echo e($prescriptions->lastItem()); ?>

                                        dari <?php echo e($prescriptions->total()); ?> resep
                                    </p>
                                </div>
                                <div class="col-md-6">
                                    <div class="float-right">
                                        <?php echo e($prescriptions->links()); ?>

                                    </div>
                                </div>
                            </div>
                        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Quick Actions Modal -->
    <div class="modal fade" id="quickActionsModal" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Aksi Cepat</h5>
                    <button type="button" class="close" data-dismiss="modal">
                        <span>&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="list-group">
                        <a href="#" class="list-group-item list-group-item-action" id="viewPrescription">
                            <i class="fas fa-eye text-info"></i> Lihat Resep
                        </a>
                        <a href="#" class="list-group-item list-group-item-action" id="printPrescription">
                            <i class="fas fa-print text-primary"></i> Cetak Resep
                        </a>
                        <a href="#" class="list-group-item list-group-item-action" id="viewCopy">
                            <i class="fas fa-copy text-warning"></i> Lihat Copy Resep
                        </a>
                        <a href="#" class="list-group-item list-group-item-action" id="printCopy">
                            <i class="fas fa-file-pdf text-danger"></i> Cetak Copy Resep
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <?php $__env->startPush('scripts'); ?>
        <script>
            $(document).ready(function() {
                // Quick actions modal
                let currentPrescriptionId = null;

                $(document).on('click', '.quick-actions', function(e) {
                    e.preventDefault();
                    currentPrescriptionId = $(this).data('id');
                    $('#quickActionsModal').modal('show');
                });

                $('#viewPrescription').click(function(e) {
                    e.preventDefault();
                    if (currentPrescriptionId) {
                        window.location.href = '<?php echo e(route('user.prescription.show', ':id')); ?>'.replace(':id',
                            currentPrescriptionId);
                    }
                });

                $('#printPrescription').click(function(e) {
                    e.preventDefault();
                    if (currentPrescriptionId) {
                        window.open('<?php echo e(route('user.prescription.print', ':id')); ?>'.replace(':id',
                            currentPrescriptionId), '_blank');
                    }
                });

                $('#viewCopy').click(function(e) {
                    e.preventDefault();
                    if (currentPrescriptionId) {
                        window.location.href = '<?php echo e(route('user.prescription.copy', ':id')); ?>'.replace(':id',
                            currentPrescriptionId);
                    }
                });

                $('#printCopy').click(function(e) {
                    e.preventDefault();
                    if (currentPrescriptionId) {
                        window.open('<?php echo e(route('user.prescription.print-copy', ':id')); ?>'.replace(':id',
                            currentPrescriptionId), '_blank');
                    }
                });

                // Auto-refresh setiap 30 detik
                setInterval(function() {
                    location.reload();
                }, 30000);
            });
        </script>
    <?php $__env->stopPush(); ?>

    <?php $__env->startPush('styles'); ?>
        <style>
            .btn-group .btn {
                margin-right: 2px;
            }

            .badge {
                font-size: 0.75em;
            }

            .table td {
                vertical-align: middle;
            }

            .quick-actions {
                cursor: pointer;
            }

            .list-group-item:hover {
                background-color: #f8f9fa;
            }
        </style>
    <?php $__env->stopPush(); ?>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layout.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /Users/macbookair/Documents/mediction/mediction.id/resources/views/admin/prescription/index.blade.php ENDPATH**/ ?>