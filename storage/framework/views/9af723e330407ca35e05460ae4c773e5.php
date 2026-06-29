<div>
    <div class="mb-4">
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-2xl font-bold text-[#1E3A8A]">Laporan Transaksi Komprehensif</h1>
                <p class="text-gray-600 mt-1">Analisis lengkap data transaksi, pembayaran, dan detail produk</p>
            </div>
            <div class="flex space-x-2">
                <button wire:click="exportData" class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-lg transition-colors">
                    <i class="fas fa-download mr-2"></i>Export
                </button>
            </div>
        </div>
    </div>

    <!-- Summary Cards -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4 mb-6">
        <div class="bg-gradient-to-r from-blue-500 to-blue-600 rounded-xl shadow-lg p-6 text-white">
            <div class="flex items-center justify-between">
                <div>
                    <h3 class="text-sm font-medium opacity-90">Total Transaksi</h3>
                    <p class="text-2xl font-bold"><?php echo e(number_format($summaryData['total_transactions'] ?? 0)); ?></p>
                </div>
                <div class="w-12 h-12 bg-white bg-opacity-20 rounded-full flex items-center justify-center">
                    <i class="fas fa-receipt text-xl"></i>
                </div>
            </div>
        </div>

        <div class="bg-gradient-to-r from-green-500 to-green-600 rounded-xl shadow-lg p-6 text-white">
            <div class="flex items-center justify-between">
                <div>
                    <h3 class="text-sm font-medium opacity-90">Total Pendapatan</h3>
                    <p class="text-2xl font-bold">Rp <?php echo e(number_format($summaryData['total_revenue'] ?? 0, 0, ',', '.')); ?></p>
                </div>
                <div class="w-12 h-12 bg-white bg-opacity-20 rounded-full flex items-center justify-center">
                    <i class="fas fa-money-bill-wave text-xl"></i>
                </div>
            </div>
        </div>

        <div class="bg-gradient-to-r from-purple-500 to-purple-600 rounded-xl shadow-lg p-6 text-white">
            <div class="flex items-center justify-between">
                <div>
                    <h3 class="text-sm font-medium opacity-90">Rata-rata Transaksi</h3>
                    <p class="text-2xl font-bold">Rp <?php echo e(number_format($summaryData['avg_transaction'] ?? 0, 0, ',', '.')); ?></p>
                </div>
                <div class="w-12 h-12 bg-white bg-opacity-20 rounded-full flex items-center justify-center">
                    <i class="fas fa-chart-line text-xl"></i>
                </div>
            </div>
        </div>

        <div class="bg-gradient-to-r from-orange-500 to-orange-600 rounded-xl shadow-lg p-6 text-white">
            <div class="flex items-center justify-between">
                <div>
                    <h3 class="text-sm font-medium opacity-90">Total Diskon</h3>
                    <p class="text-2xl font-bold">Rp <?php echo e(number_format($summaryData['total_discount'] ?? 0, 0, ',', '.')); ?></p>
                </div>
                <div class="w-12 h-12 bg-white bg-opacity-20 rounded-full flex items-center justify-center">
                    <i class="fas fa-percentage text-xl"></i>
                </div>
            </div>
        </div>
    </div>

    <!-- Status Summary -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-6">
        <div class="bg-white rounded-xl shadow-lg p-6 border border-gray-100">
            <div class="flex items-center justify-between">
                <div>
                    <h3 class="text-sm font-medium text-gray-600">Transaksi Selesai</h3>
                    <p class="text-xl font-bold text-green-600"><?php echo e(number_format($summaryData['completed_transactions'] ?? 0)); ?></p>
                </div>
                <div class="w-10 h-10 bg-green-100 rounded-full flex items-center justify-center">
                    <i class="fas fa-check text-green-600"></i>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-xl shadow-lg p-6 border border-gray-100">
            <div class="flex items-center justify-between">
                <div>
                    <h3 class="text-sm font-medium text-gray-600">Transaksi Pending</h3>
                    <p class="text-xl font-bold text-yellow-600"><?php echo e(number_format($summaryData['pending_transactions'] ?? 0)); ?></p>
                </div>
                <div class="w-10 h-10 bg-yellow-100 rounded-full flex items-center justify-center">
                    <i class="fas fa-clock text-yellow-600"></i>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-xl shadow-lg p-6 border border-gray-100">
            <div class="flex items-center justify-between">
                <div>
                    <h3 class="text-sm font-medium text-gray-600">Transaksi Dibatalkan</h3>
                    <p class="text-xl font-bold text-red-600"><?php echo e(number_format($summaryData['cancelled_transactions'] ?? 0)); ?></p>
                </div>
                <div class="w-10 h-10 bg-red-100 rounded-full flex items-center justify-center">
                    <i class="fas fa-times text-red-600"></i>
                </div>
            </div>
        </div>
    </div>

    <!-- Filters -->
    <div class="bg-white rounded-xl shadow-lg p-6 mb-6">
        <h3 class="text-lg font-semibold text-gray-800 mb-4">Filter Laporan</h3>
        
        <!-- Report Type Selection -->
        <div class="mb-4">
            <label class="block text-sm font-medium text-gray-700 mb-2">Jenis Laporan</label>
            <div class="flex flex-wrap gap-2">
                <button wire:click="$set('reportType', 'summary')" 
                    class="px-4 py-2 rounded-lg transition-colors <?php echo e($reportType === 'summary' ? 'bg-blue-600 text-white' : 'bg-gray-200 text-gray-700 hover:bg-gray-300'); ?>">
                    Ringkasan Transaksi
                </button>
                <button wire:click="$set('reportType', 'detailed')" 
                    class="px-4 py-2 rounded-lg transition-colors <?php echo e($reportType === 'detailed' ? 'bg-blue-600 text-white' : 'bg-gray-200 text-gray-700 hover:bg-gray-300'); ?>">
                    Detail Produk
                </button>
                <button wire:click="$set('reportType', 'payment')" 
                    class="px-4 py-2 rounded-lg transition-colors <?php echo e($reportType === 'payment' ? 'bg-blue-600 text-white' : 'bg-gray-200 text-gray-700 hover:bg-gray-300'); ?>">
                    Laporan Pembayaran
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
                <label class="block text-sm font-medium text-gray-700">Tipe Transaksi</label>
                <select wire:model.live="type" class="mt-1 form-control">
                    <option value="">Semua Tipe</option>
                    <option value="consultation">Konsultasi</option>
                    <option value="non-resep">Non Resep</option>
                    <option value="resep">Resep</option>
                </select>
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700">Status</label>
                <select wire:model.live="status" class="mt-1 form-control">
                    <option value="">Semua Status</option>
                    <option value="pending">Pending</option>
                    <option value="processing">Processing</option>
                    <option value="completed">Completed</option>
                    <option value="cancelled">Cancelled</option>
                </select>
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mt-4">
            <div>
                <label class="block text-sm font-medium text-gray-700">Dokter</label>
                <select wire:model.live="doctor_id" class="mt-1 form-control">
                    <option value="">Semua Dokter</option>
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__currentLoopData = $doctors; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $doctor): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoopIteration(); ?><?php endif; ?>
                        <option value="<?php echo e($doctor->id); ?>"><?php echo e($doctor->name); ?></option>
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
                </select>
            </div>
            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($reportType === 'payment'): ?>
            <div>
                <label class="block text-sm font-medium text-gray-700">Metode Pembayaran</label>
                <select wire:model.live="payment_method_id" class="mt-1 form-control">
                    <option value="">Semua Metode</option>
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__currentLoopData = $paymentMethods; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $method): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoopIteration(); ?><?php endif; ?>
                        <option value="<?php echo e($method->id); ?>"><?php echo e($method->name); ?></option>
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
                </select>
            </div>
            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
            <div>
                <label class="block text-sm font-medium text-gray-700">Pencarian</label>
                <input type="text" wire:model.live="search" placeholder="Cari kode transaksi, pasien..." class="mt-1 form-control" />
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
            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($reportType === 'summary'): ?>
                <!-- Summary Report Table -->
                <table class="table">
                    <thead>
                        <tr>
                            <th class="w-1 center">No</th>
                            <th>Kode Transaksi</th>
                            <th>Tanggal</th>
                            <th>Pasien</th>
                            <th>Dokter</th>
                            <th>Tipe</th>
                            <th>Status</th>
                            <th>Total</th>
                            <th>Diskon</th>
                            <th>Grand Total</th>
                            <th class="w-1 center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__empty_5 = true; $__currentLoopData = $reportData; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $transaction): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_5 = false; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoopIteration(); ?><?php endif; ?>
                            <tr>
                                <td class="center"><?php echo e($reportData->firstItem() + $index); ?></td>
                                <td class="font-medium"><?php echo e($transaction->code); ?></td>
                                <td><?php echo e($transaction->created_at->format('d/m/Y H:i')); ?></td>
                                <td><?php echo e($transaction->patient_name ?? $transaction->patient?->name ?? '-'); ?></td>
                                <td><?php echo e($transaction->doctor?->name ?? '-'); ?></td>
                                <td>
                                    <span class="px-2 py-1 text-xs rounded-full 
                                        <?php echo e($transaction->type === 'consultation' ? 'bg-blue-100 text-blue-800' : 
                                           ($transaction->type === 'resep' ? 'bg-green-100 text-green-800' : 'bg-gray-100 text-gray-800')); ?>">
                                        <?php echo e(ucfirst($transaction->type)); ?>

                                    </span>
                                </td>
                                <td>
                                    <span class="px-2 py-1 text-xs rounded-full 
                                        <?php echo e($transaction->status === 'completed' ? 'bg-green-100 text-green-800' : 
                                           ($transaction->status === 'pending' ? 'bg-yellow-100 text-yellow-800' : 'bg-red-100 text-red-800')); ?>">
                                        <?php echo e(ucfirst($transaction->status)); ?>

                                    </span>
                                </td>
                                <td>Rp <?php echo e(number_format($transaction->sub_total_price, 0, ',', '.')); ?></td>
                                <td>Rp <?php echo e(number_format($transaction->discount_value, 0, ',', '.')); ?></td>
                                <td class="font-semibold">Rp <?php echo e(number_format($transaction->grand_total_price, 0, ',', '.')); ?></td>
                                <td class="center">
                                    <button class="text-blue-600 hover:text-blue-800" title="Detail">
                                        <i class="fas fa-eye"></i>
                                    </button>
                                </td>
                            </tr>
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_5): ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
                            <tr>
                                <td colspan="11" class="center text-gray-500 py-8">
                                    <i class="fas fa-inbox text-4xl mb-4 opacity-50"></i>
                                    <p>Tidak ada data transaksi</p>
                                </td>
                            </tr>
                        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                    </tbody>
                </table>
            <?php elseif($reportType === 'detailed'): ?>
                <!-- Detailed Report Table -->
                <table class="table">
                    <thead>
                        <tr>
                            <th class="w-1 center">No</th>
                            <th>Kode Transaksi</th>
                            <th>Tanggal</th>
                            <th>Produk</th>
                            <th>SKU</th>
                            <th>Qty</th>
                            <th>Harga Satuan</th>
                            <th>Total</th>
                            <th>HPP</th>
                            <th>Profit</th>
                            <th>Margin</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__empty_5 = true; $__currentLoopData = $reportData; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $detail): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_5 = false; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoopIteration(); ?><?php endif; ?>
                            <tr>
                                <td class="center"><?php echo e($reportData->firstItem() + $index); ?></td>
                                <td class="font-medium"><?php echo e($detail->transaction->code); ?></td>
                                <td><?php echo e($detail->created_at->format('d/m/Y H:i')); ?></td>
                                <td><?php echo e($detail->product_name); ?></td>
                                <td><?php echo e($detail->product?->sku_number ?? '-'); ?></td>
                                <td class="center"><?php echo e(number_format($detail->quantity)); ?></td>
                                <td>Rp <?php echo e(number_format($detail->price, 0, ',', '.')); ?></td>
                                <td>Rp <?php echo e(number_format($detail->total, 0, ',', '.')); ?></td>
                                <td>Rp <?php echo e(number_format($detail->hpp_total, 0, ',', '.')); ?></td>
                                <td class="<?php echo e($detail->profit >= 0 ? 'text-green-600' : 'text-red-600'); ?>">
                                    Rp <?php echo e(number_format($detail->profit, 0, ',', '.')); ?>

                                </td>
                                <td class="<?php echo e($detail->margin >= 0 ? 'text-green-600' : 'text-red-600'); ?>">
                                    <?php echo e(number_format($detail->margin, 2)); ?>%
                                </td>
                            </tr>
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_5): ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
                            <tr>
                                <td colspan="11" class="center text-gray-500 py-8">
                                    <i class="fas fa-inbox text-4xl mb-4 opacity-50"></i>
                                    <p>Tidak ada data detail transaksi</p>
                                </td>
                            </tr>
                        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                    </tbody>
                </table>
            <?php elseif($reportType === 'payment'): ?>
                <!-- Payment Report Table -->
                <table class="table">
                    <thead>
                        <tr>
                            <th class="w-1 center">No</th>
                            <th>Kode Transaksi</th>
                            <th>Tanggal</th>
                            <th>Pasien</th>
                            <th>Metode Pembayaran</th>
                            <th>Jumlah Bayar</th>
                            <th>Jumlah Real</th>
                            <th>Fee</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__empty_5 = true; $__currentLoopData = $reportData; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $payment): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_5 = false; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoopIteration(); ?><?php endif; ?>
                            <tr>
                                <td class="center"><?php echo e($reportData->firstItem() + $index); ?></td>
                                <td class="font-medium"><?php echo e($payment->transaction->code); ?></td>
                                <td><?php echo e($payment->created_at->format('d/m/Y H:i')); ?></td>
                                <td><?php echo e($payment->transaction->patient_name); ?></td>
                                <td><?php echo e($payment->paymentMethod->name); ?></td>
                                <td>Rp <?php echo e(number_format($payment->payment_amount, 0, ',', '.')); ?></td>
                                <td>Rp <?php echo e(number_format($payment->payment_real, 0, ',', '.')); ?></td>
                                <td>Rp <?php echo e(number_format($payment->fee ?? 0, 0, ',', '.')); ?></td>
                                <td>
                                    <span class="px-2 py-1 text-xs rounded-full bg-green-100 text-green-800">
                                        Paid
                                    </span>
                                </td>
                            </tr>
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_5): ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
                            <tr>
                                <td colspan="9" class="center text-gray-500 py-8">
                                    <i class="fas fa-inbox text-4xl mb-4 opacity-50"></i>
                                    <p>Tidak ada data pembayaran</p>
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
            // Show loading state
            Swal.fire({
                title: 'Mengekspor Data...',
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
<?php $__env->stopPush(); ?><?php /**PATH /Users/macbookair/Documents/mediction/mediction.id/resources/views/livewire/admin/report/transaction/admin-report-transaction-index.blade.php ENDPATH**/ ?>