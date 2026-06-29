<div>
    <div class="prescription-container">
        <div class="watermark">COPY RESEP</div>

        <!-- Copy Indicator (Hidden by default, shown when needed) -->
        <div class="copy-indicator" style="display: none;">
            
        </div>

        <div class="content">
            <!-- Header -->
            <div class="header">
                <div class="logo-section">
                    <img src="<?php echo e(asset('storage/' . Auth::user()->company->logo)); ?>"
                        style="width: 175px; height: 75px; margin-left: 50px;" alt="Logo">
                </div>

                <div class="title-section">
                    <div class="prescription-title">COPY RESEP</div>
                    <div class="document-type">Medical Prescription</div>
                </div>

                <div class="prescription-info">
                    <div class="prescription-number">No. RCP-2025-0001</div>
                    <div>Tanggal: <?php echo e(date('d/m/Y')); ?></div>
                    <div>Waktu: <?php echo e(date('H:i:s')); ?></div>
                    <div>Kode Konsultasi: POLI0001</div>
                </div>
            </div>

            <!-- Doctor Info -->
            <div class="doctor-info">
                <div class="doctor-card">
                    <div class="doctor-title">Dokter Pemeriksa</div>
                    <div class="doctor-details">
                        <div><strong><?php echo e($transaction->doctor?->name ?? '-'); ?></strong></div>
                        <div><?php echo e($transaction->doctor?->userDetail?->specialization ?? '-'); ?></div>
                        <div>SIP: <?php echo e($transaction->doctor?->userDetail?->sip_number ?? '-'); ?></div>
                        
                    </div>
                </div>

                <div class="doctor-card">
                    <div class="doctor-title">Poli/Klinik</div>
                    <div class="doctor-details">
                        <div><strong><?php echo e($transaction?->location?->name); ?></strong></div>
                        <div><?php echo e(config('app.name')); ?></div>
                        <div><?php echo e(Auth::user()->company->companyDetail->address); ?></div>
                        <div><?php echo e(Auth::user()->company->companyDetail->city); ?>,
                            <?php echo e(Auth::user()->company->companyDetail->postal_code); ?>

                        </div>
                        <div>Telp: <?php echo e(Auth::user()->company->phone); ?></div>
                    </div>
                </div>
            </div>

            <!-- Patient Info -->
            <div class="patient-info">
                <div class="patient-title">Data Pasien</div>
                <div class="patient-details">
                    <div class="patient-row">
                        <div class="patient-label">Nama</div>
                        <div class="patient-colon">:</div>
                        <div class="patient-value"><?php echo e($transaction->patient?->name ?? '-'); ?></div>
                    </div>
                    <div class="patient-row">
                        <div class="patient-label">Umur</div>
                        <div class="patient-colon">:</div>
                        <div class="patient-value">
                            <?php
                                $birthDate = Carbon\Carbon::parse($transaction?->patient?->userDetail?->birth_date);
                                $now = Carbon\Carbon::now();

                                $years = $birthDate->diff($now)->y;
                                $months = $birthDate->diff($now)->m;
                                $days = $birthDate->diff($now)->d;
                            ?>

                            <?php echo e($years); ?> tahun <?php echo e($months); ?> bulan <?php echo e($days); ?> hari
                        </div>
                    </div>
                    <div class="patient-row">
                        <div class="patient-label">Jenis Kelamin</div>
                        <div class="patient-colon">:</div>
                        <div class="patient-value">
                            <?php echo e($transaction->patient?->userDetail->administrative_gender == 'male' ? 'Laki - Laki' : 'Perempuan' ?? '-'); ?>

                        </div>
                    </div>
                    <div class="patient-row">
                        <div class="patient-label">Alamat</div>
                        <div class="patient-colon">:</div>
                        <div class="patient-value"><?php echo e($transaction->patient?->userDetail->address ?? '-'); ?></div>
                    </div>
                    <div class="patient-row">
                        <div class="patient-label">No. Telepon</div>
                        <div class="patient-colon">:</div>
                        <div class="patient-value"><?php echo e($transaction->patient?->phone ?? '-'); ?></div>
                    </div>
                    <div class="patient-row">
                        <div class="patient-label">Diagnosis</div>
                        <div class="patient-colon">:</div>
                        <div class="patient-value">
                            <?php echo e($transactionDiagnosas?->assessment ?? ($transaction->diagnosis ?? '-')); ?>

                        </div>
                    </div>
                </div>
            </div>

            <!-- Prescription Table -->
            <table class="prescription-table">
                <thead>
                    <tr>
                        <th class="no-col">No</th>
                        <th class="medicine-col">Nama Obat & Sediaan</th>
                        <th class="quantity-col">Jumlah</th>
                        <th>Aturan Pakai</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__currentLoopData = $transaction->transactionRecipes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $recipe): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoopIteration(); ?><?php endif; ?>
                        
                        <tr>
                            <td class="no-col" rowspan="<?php echo e($recipe->transactionDetail->count()); ?>">
                                /R<?php echo e($loop->iteration); ?>

                            </td>

                            
                            <?php $firstDetail = $recipe->transactionDetail->first(); ?>
                            <td class="medicine-col"><?php echo e($firstDetail->product->name ?? '-'); ?></td>

                            <td class="quantity-col" rowspan="<?php echo e($recipe->transactionDetail->count()); ?>">
                                <?php echo e($recipe->numero_recipe ?? 0); ?>

                            </td>
                            <td rowspan="<?php echo e($recipe->transactionDetail->count()); ?>">
                                <?php echo e($recipe->description ?? '-'); ?>

                            </td>
                        </tr>

                        
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__currentLoopData = $recipe->transactionDetail->skip(1); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $detail): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoopIteration(); ?><?php endif; ?>
                            <tr>
                                <td class="medicine-col"><?php echo e($detail->product->name ?? '-'); ?></td>
                            </tr>
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
                </tbody>
            </table>

            <!-- Bottom Section -->
            <div class="bottom-section" style="justify:end">
                <div class="signature-section text-right">
                    <div class="signature-location">
                        Surabaya, <?php echo e(Carbon\Carbon::now()->format('d F Y')); ?> <br>
                    </div>
                    <br>
                    <div class="signature-line"></div>
                </div>
            </div>
        </div>
        <!-- Action Buttons -->
        <div class="action-buttons"
            style="position: fixed; top: 20px; right: 20px; z-index: 1000; display: flex; gap: 10px;">
            <button onclick="printPrescription()" class="btn btn-print">
                <i class="fas fa-print"></i> Cetak
            </button>
            <button onclick="downloadPDF()" class="btn btn-download">
                <i class="fas fa-download"></i> Download
            </button>
        </div>
    </div>
</div><?php /**PATH /Users/macbookair/Documents/mediction/mediction.id/resources/views/livewire/admin/receipt/recipe/admin-receipt-recipe-index.blade.php ENDPATH**/ ?>