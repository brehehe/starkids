<div>
    <div class="mb-4">
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-2xl font-bold text-[#1E3A8A]">Laporan Dead Stock</h1>
            </div>
        </div>
    </div>
    <div class="bg-white/80 backdrop-blur-sm rounded-xl p-5 shadow-lg border border-gray-100 mb-6">
        <div class="grid grid-cols-1 sm:grid-cols-1 lg:grid-cols-1 gap-4">
            <!-- Supplier Filter -->
            <div x-data="{
                startDate: <?php if ((object) ('start_date') instanceof \Livewire\WireDirective) : ?>window.Livewire.find('<?php echo e($__livewire->getId()); ?>').entangle('<?php echo e('start_date'->value()); ?>')<?php echo e('start_date'->hasModifier('live') ? '.live' : ''); ?><?php else : ?>window.Livewire.find('<?php echo e($__livewire->getId()); ?>').entangle('<?php echo e('start_date'); ?>')<?php endif; ?>.live,
                endDate: <?php if ((object) ('end_date') instanceof \Livewire\WireDirective) : ?>window.Livewire.find('<?php echo e($__livewire->getId()); ?>').entangle('<?php echo e('end_date'->value()); ?>')<?php echo e('end_date'->hasModifier('live') ? '.live' : ''); ?><?php else : ?>window.Livewire.find('<?php echo e($__livewire->getId()); ?>').entangle('<?php echo e('end_date'); ?>')<?php endif; ?>.live,
                init() {
                    flatpickr(this.$refs.startInput, {
                        dateFormat: 'Y-m-d',
                        defaultDate: this.startDate,
                        onChange: ([date], dateStr) => {
                            this.startDate = dateStr;
                            if (this.endDate && this.endDate < dateStr) {
                                this.endDate = '';
                                this.$refs.endInput._flatpickr.clear();
                            }
                            this.$refs.endInput._flatpickr.set('minDate', dateStr);
                        }
                    });

                    flatpickr(this.$refs.endInput, {
                        dateFormat: 'Y-m-d',
                        defaultDate: this.endDate,
                        onChange: ([date], dateStr) => {
                            this.endDate = dateStr;
                        }
                    });
                },
                resetDates() {
                    this.startDate = '';
                    this.endDate = '';
                    this.$refs.startInput._flatpickr.clear();
                    this.$refs.endInput._flatpickr.clear();
                }
            }" x-init="init()" class="flex items-center space-x-2">

                <!-- Tanggal Dari -->
                <div class="relative flex-1">
                    <input type="text" x-ref="startInput" x-model="startDate" placeholder="Tanggal Dari"
                        class="mt-1 form-control">
                </div>

                <!-- Tanggal Sampai -->
                <div class="relative flex-1">
                    <input type="text" x-ref="endInput" x-model="endDate" placeholder="Tanggal Sampai"
                        class="mt-1 form-control">
                </div>

                <!-- Tombol Reset -->
                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($start_date || $end_date): ?>
                    <div>
                        <button type="button" @click="resetDates()" wire:click='resetDates()'
                            class="mt-1 px-4 py-2 bg-red-500 text-white rounded-md hover:bg-red-600 focus:outline-none">
                            <i class="fa-regular fa-xmark text-white text-lg"></i>
                        </button>
                    </div>
                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
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
    <div class="bg-white/80 backdrop-blur-sm rounded-xl shadow-lg border border-gray-100 overflow-hidden mb-6">
        <div class="table-container">
            <table class="table">
                <thead>
                    <tr>
                        <th class="w-1 center">No</th>
                        <th>Produk</th>
                        <th>Kode</th>
                        <th>Deskripsi</th>
                        <th>Quantity Old</th>
                        <th>Quantity</th>
                        <th>Harga</th>
                        <th>Total</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__empty_5 = true; $__currentLoopData = $deadStocks; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $deadStock): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_5 = false; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoopIteration(); ?><?php endif; ?>
                        <tr>
                            <td class="center"><?php echo e($deadStocks->firstItem() + $index); ?></td>
                            <td><?php echo e($deadStock->product->name ?? '-'); ?></td>
                            <td><?php echo e($deadStock->code ?? '-'); ?></td>
                            <td><?php echo e($deadStock->description ?? '-'); ?></td>
                            <td><?php echo e($deadStock->quantity_old ?? '-'); ?></td>
                            <td><?php echo e($deadStock->quantity ?? '-'); ?></td>
                            <td><?php echo e(number_format($deadStock->price, 0, ',', '.') ?? '-'); ?></td>
                            <td><?php echo e(number_format($deadStock->total, 0, ',', '.') ?? '-'); ?></td>
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
                    Menampilkan <span class="font-medium"><?php echo e($deadStocks->firstItem()); ?></span> sampai <span
                        class="font-medium"><?php echo e($deadStocks->lastItem()); ?></span> dari <span
                        class="font-medium"><?php echo e($deadStocks->total()); ?></span> hasil
                </div>
                <div>
                    <nav class="relative z-0 inline-flex rounded-md shadow-sm -space-x-px" aria-label="Pagination">
                        <?php echo e($deadStocks->links('vendor.livewire.custom')); ?> <!-- Menampilkan pagination -->
                    </nav>
                </div>
            </div>
        </div>
    </div>
</div><?php /**PATH /Users/macbookair/Documents/mediction/mediction.id/resources/views/livewire/admin/report/dead-stock/admin-report-dead-stock-index.blade.php ENDPATH**/ ?>