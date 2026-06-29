<div>
    <div class="mb-4">
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-2xl font-bold text-[#1E3A8A]">Generate Gaji</h1>
                <p class="text-gray-500 text-sm mt-1">Kalkulasi dan snapshot gaji bulanan otomatis berdasarkan Master Gaji dan Potongan Khusus.</p>
            </div>
            <button wire:click="generatePayroll" class="btn-primary" title="Proses Hitung Gaji" wire:loading.attr="disabled">
                <i wire:loading.remove wire:target="generatePayroll" class="fas fa-cogs mr-2"></i>
                <svg wire:loading wire:target="generatePayroll" class="animate-spin -ml-1 mr-2 h-4 w-4 text-white inline-block" fill="none" viewBox="0 0 24 24">
                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                </svg>
                <span wire:loading.remove wire:target="generatePayroll">Generate Gaji Bulan Ini</span>
                <span wire:loading wire:target="generatePayroll">Memproses...</span>
            </button>
        </div>
    </div>

    <!-- Table Controls -->
    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center mb-4 gap-4">
        <div class="flex items-center gap-4">
            <div class="flex items-center border border-blue-200 rounded-lg overflow-hidden bg-blue-50/50 relative px-3 py-1.5 shadow-sm">
                <i class="fas fa-calendar-alt text-blue-500 mr-2"></i>
                <span class="text-sm font-bold text-gray-700 mr-2">Bulan:</span>
                <input type="month" class="form-control-sm border-none bg-transparent shadow-none font-bold text-blue-700 outline-none p-0 focus:ring-0" wire:model.live='filterPeriod'>
            </div>
            
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

        <div class="relative w-full sm:w-64">
            <input type="text" class="mt-1 form-control-search" placeholder="Cari Nama Pegawai..."
                wire:model.live.debounce.300ms='search'>
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
                        <th>Pegawai & Divisi</th>
                        <th class="text-right">Gaji Pokok</th>
                        <th class="text-right text-green-700">Tunjangan (+)</th>
                        <th class="text-right text-red-700">Potongan (-)</th>
                        <th class="text-right bg-blue-50">Total Gaji Bersih</th>
                        <th class="center">Status</th>
                        <th class="w-1 center">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__empty_5 = true; $__currentLoopData = $payrolls; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_5 = false; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoopIteration(); ?><?php endif; ?>
                    <tr>
                        <td class="center"><?php echo e($payrolls->firstItem() + $index); ?></td>
                        <td>
                            <div class="font-bold text-gray-900"><?php echo e($item->user->name ?? '-'); ?></div>
                            <div class="text-xs text-gray-500"><?php echo e($item->user->email ?? '-'); ?></div>
                        </td>
                        <td class="text-right font-medium text-gray-700">
                            Rp <?php echo e(number_format($item->basic_salary, 0, ',', '.')); ?>

                        </td>
                        <td class="text-right font-medium text-green-700">
                            Rp <?php echo e(number_format($item->total_allowance, 0, ',', '.')); ?>

                        </td>
                        <td class="text-right font-medium text-red-600">
                            Rp <?php echo e(number_format($item->total_deduction, 0, ',', '.')); ?>

                        </td>
                        <td class="text-right font-bold text-blue-700 bg-blue-50/50">
                            Rp <?php echo e(number_format($item->net_salary, 0, ',', '.')); ?>

                        </td>
                        <td class="center">
                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($item->status == 'paid'): ?>
                                <span class="px-2 py-1 bg-green-100 text-green-700 rounded text-xs font-bold border border-green-200">
                                    <i class="fas fa-check-circle mr-1"></i> Dibayar
                                </span>
                                <div class="text-[10px] text-gray-400 mt-1"><?php echo e(Carbon\Carbon::parse($item->payment_date)->format('d/m/Y')); ?></div>
                            <?php elseif($item->status == 'published'): ?>
                                <span class="px-2 py-1 bg-yellow-100 text-yellow-700 rounded text-xs font-bold border border-yellow-200">Terbit</span>
                            <?php else: ?>
                                <span class="px-2 py-1 bg-gray-100 text-gray-700 rounded text-xs font-bold border border-gray-200">Draft</span>
                            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                        </td>
                        <td class="center whitespace-nowrap">
                            <button wire:click="viewDetails('<?php echo e($item->id); ?>')" class="btn-action btn-edit bg-blue-50 text-blue-600 hover:bg-blue-100 mr-2" title="Detail & Rincian">
                                <i class="fas fa-file-invoice-dollar"></i>
                            </button>
                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($item->status != 'paid'): ?>
                                <button wire:click="markAsPaid('<?php echo e($item->id); ?>')" onclick="confirm('Tandai gaji <?php echo e($item->user->name); ?> sebagai lunas dibayar?') || event.stopImmediatePropagation()" class="btn-action btn-edit bg-green-50 text-green-600 hover:bg-green-100" title="Bayar Sekarang">
                                    <i class="fas fa-check"></i>
                                </button>
                            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                        </td>
                    </tr>
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_5): ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
                    <tr>
                        <td colspan="8" class="no-data py-12">
                            <div class="flex flex-col items-center justify-center text-gray-500">
                                <i class="fas fa-money-check-alt text-5xl mb-4 text-gray-300"></i>
                                <h3 class="text-lg font-bold text-gray-600 mb-1">Daftar Gaji Kosong</h3>
                                <p class="text-sm text-gray-400">Belum ada *generate* gaji untuk periode <b><?php echo e(Carbon\Carbon::parse($filterPeriod)->translatedFormat('F Y')); ?></b>.</p>
                                <p class="text-sm mt-2">Klik tombol <b class="text-blue-600">Generate Gaji Bulan Ini</b> di atas untuk menarik rekap data.</p>
                            </div>
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
                    Menampilkan <span class="font-medium"><?php echo e($payrolls->firstItem() ?? 0); ?></span> sampai <span
                        class="font-medium"><?php echo e($payrolls->lastItem() ?? 0); ?></span> dari <span
                        class="font-medium"><?php echo e($payrolls->total() ?? 0); ?></span> data rekap
                </div>
                <div>
                    <nav class="relative z-0 inline-flex rounded-md shadow-sm -space-x-px" aria-label="Pagination">
                        <?php echo e($payrolls->links('vendor.livewire.custom')); ?>

                    </nav>
                </div>
            </div>
        </div>
    </div>


    <!-- Modal Detail Gaji -->
    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($selectedPayroll): ?>
    <div wire:ignore.self id="modal-details" class="fixed inset-0 bg-overlay flex items-center justify-center z-50">
        <div class="bg-white rounded-2xl shadow-2xl w-full max-w-2xl transform transition-all scale-100 duration-300 ease-out animate-fade-in flex flex-col" style="max-height: 90vh;">
            <!-- Header -->
            <div class="flex justify-between items-center px-6 py-4 border-b bg-gray-50 rounded-t-2xl">
                <div>
                    <h2 class="text-xl font-bold text-[#1E3A8A] flex items-center">
                        <i class="fas fa-file-invoice-dollar mr-2 text-blue-500"></i>
                        Slip Gaji (<?php echo e(Carbon\Carbon::parse($selectedPayroll->period)->translatedFormat('F Y')); ?>)
                    </h2>
                    <p class="text-sm text-gray-500 font-medium mt-1">Pegawai: <span class="text-gray-800"><?php echo e($selectedPayroll->user->name ?? '-'); ?></span></p>
                </div>
                <button wire:click="closeDetails" class="text-gray-400 hover:text-red-500 bg-white shadow-sm border p-1 rounded-md transition-colors text-2xl leading-none cursor-pointer">
                    &times;
                </button>
            </div>

            <!-- Body Scrollable -->
            <div id="slip-content" class="p-8 overflow-y-auto bg-white">
                
                <div class="flex items-center justify-between mb-6 pb-4 border-b border-gray-200">
                    <div>
                        <span class="text-sm text-gray-500">Gaji Pokok Dasar</span>
                        <div class="text-xl font-bold text-gray-800">Rp <?php echo e(number_format($selectedPayroll->basic_salary, 0, ',', '.')); ?></div>
                    </div>
                    <div class="text-right">
                        <span class="text-sm text-gray-500">Status Pembayaran</span>
                        <div>
                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($selectedPayroll->status == 'paid'): ?>
                                <span class="px-2 py-1 bg-green-100 text-green-700 rounded text-xs font-bold border border-green-200">LUNAS</span>
                                <div class="text-xs text-gray-500 mt-1"><?php echo e(Carbon\Carbon::parse($selectedPayroll->payment_date)->translatedFormat('d M Y')); ?></div>
                            <?php elseif($selectedPayroll->status == 'published'): ?>
                                <span class="px-2 py-1 bg-yellow-100 text-yellow-700 rounded text-xs font-bold border border-yellow-200">TERBIT</span>
                            <?php else: ?>
                                <span class="px-2 py-1 bg-gray-100 text-gray-600 rounded text-xs font-bold border border-gray-200">DRAFT (PROSES)</span>
                            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                        </div>
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Kolom Tunjangan -->
                    <div>
                        <h4 class="font-bold text-green-700 border-b border-green-200 pb-2 mb-3 flex items-center justify-between">
                            <span><i class="fas fa-plus-circle mr-1"></i> Penambahan</span>
                        </h4>
                        <ul class="space-y-3">
                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__empty_5 = true; $__currentLoopData = $selectedPayroll->details->where('type', 'allowance'); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $detail): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_5 = false; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoopIteration(); ?><?php endif; ?>
                                <li class="flex justify-between items-center text-sm">
                                    <span class="text-gray-600"><?php echo e($detail->name); ?></span>
                                    <span class="font-medium text-gray-900 flex whitespace-nowrap">Rp <span class="ml-auto min-w-[70px] text-right"><?php echo e(number_format($detail->amount, 0, ',', '.')); ?></span></span>
                                </li>
                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_5): ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
                                <li class="text-sm text-gray-400 italic text-center py-2">Tidak ada tambahan</li>
                            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                            <li class="flex justify-between items-center text-sm font-bold pt-3 mt-3 border-t border-gray-200">
                                <span class="text-gray-800">Total Tambahan</span>
                                <span class="text-green-700 flex whitespace-nowrap">Rp <span class="ml-auto min-w-[70px] text-right"><?php echo e(number_format($selectedPayroll->total_allowance, 0, ',', '.')); ?></span></span>
                            </li>
                        </ul>
                    </div>

                    <!-- Kolom Potongan -->
                    <div>
                        <h4 class="font-bold text-red-600 border-b border-red-200 pb-2 mb-3 flex items-center justify-between">
                            <span><i class="fas fa-minus-circle mr-1"></i> Pengurangan</span>
                        </h4>
                        <ul class="space-y-3">
                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__empty_5 = true; $__currentLoopData = $selectedPayroll->details->where('type', 'deduction'); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $detail): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_5 = false; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoopIteration(); ?><?php endif; ?>
                                <li class="flex justify-between items-center text-sm">
                                    <span class="text-gray-600"><?php echo e($detail->name); ?></span>
                                    <span class="font-medium text-gray-900 flex whitespace-nowrap">Rp <span class="ml-auto min-w-[70px] text-right"><?php echo e(number_format($detail->amount, 0, ',', '.')); ?></span></span>
                                </li>
                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_5): ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
                                <li class="text-sm text-gray-400 italic text-center py-2">Tidak ada pengurangan</li>
                            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                            <li class="flex justify-between items-center text-sm font-bold pt-3 mt-3 border-t border-gray-200">
                                <span class="text-gray-800">Total Potongan</span>
                                <span class="text-red-600 flex whitespace-nowrap">Rp <span class="ml-auto min-w-[70px] text-right"><?php echo e(number_format($selectedPayroll->total_deduction, 0, ',', '.')); ?></span></span>
                            </li>
                        </ul>
                    </div>
                </div>

                <div class="mt-8 bg-[#1E3A8A] text-white rounded-xl p-5 shadow-lg flex items-center justify-between">
                    <div>
                        <div class="text-blue-100 text-sm font-medium">TOTAL GAJI BERSIH (TAKE HOME PAY)</div>
                        <div class="text-xs text-blue-200 mt-1">*Ditransfer ke rekening pegawai</div>
                    </div>
                    <div class="text-3xl font-extrabold tracking-tight">
                        Rp <?php echo e(number_format($selectedPayroll->net_salary, 0, ',', '.')); ?>

                    </div>
                </div>

            </div>
            
            <!-- Footer Locked -->
            <div class="p-4 border-t border-gray-200 bg-gray-50 flex justify-end gap-3 shrink-0 rounded-b-2xl">
                <button wire:click="downloadPDF('<?php echo e($selectedPayroll->id); ?>')" class="px-5 py-2.5 bg-blue-600 hover:bg-blue-700 text-white font-bold rounded-xl shadow-sm transition-all focus:outline-none cursor-pointer flex items-center">
                    <i class="fas fa-file-pdf mr-2"></i> Simpan PDF
                </button>
                <button wire:click="closeDetails" class="px-5 py-2.5 bg-white border border-gray-300 hover:bg-gray-50 text-gray-700 font-bold rounded-xl shadow-sm transition-all focus:outline-none cursor-pointer">
                    Tutup
                </button>
            </div>
        </div>
    </div>
    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
</div><?php /**PATH /Users/macbookair/Documents/mediction/mediction.id/resources/views/livewire/admin/hr/payroll/admin-hr-payroll-generate-index.blade.php ENDPATH**/ ?>