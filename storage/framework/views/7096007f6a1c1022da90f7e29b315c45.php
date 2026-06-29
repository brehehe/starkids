<div>
    <div class="mb-4">
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-2xl font-bold text-[#1E3A8A]">Pembelian Langsung</h1>
            </div>
            <div>
                <a href="<?php echo e(route('user.logistic.direct-purchase.detail')); ?>" class="btn btn-primary">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                    </svg>
                    Buat Pembelian Langsung
                </a>
            </div>
        </div>
    </div>
    <div class="bg-white/80 backdrop-blur-sm rounded-xl p-5 shadow-lg border border-gray-100 mb-6">
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-2 gap-4">
            <!-- Supplier Filter -->
            <div>
                <div <?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::$currentLoop['key'] = 'select-'.e(rand()).''; ?>wire:key="select-<?php echo e(rand()); ?>">
                    <select class="mt-1 form-control" x-data x-ref="input" x-init="$($refs.input).selectize({
                        dropdownParent: 'body',
                        allowClear: true,
                        plugins: ['clear_button'],
                        onChange: function(e) {
                            window.Livewire.find('<?php echo e($_instance->getId()); ?>').set('supplier_id', e ? e : null);
                        }
                    });"
                        wire:model.live="supplier_id" id="supplier_id">
                        <option value="">-- Pilih Supplier --</option>
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__currentLoopData = $suppliers; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $supplier): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoopIteration(); ?><?php endif; ?>
                            <option value="<?php echo e($supplier['id']); ?>"><?php echo e($supplier['name']); ?></option>
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
                    </select>
                </div>
            </div>
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
                        <th>No SP</th>
                        <th>No Invoice</th>
                        <th>Supplier</th>
                        <th>Deskripsi</th>
                        <th>Status</th>
                        <th>Grand Total</th>
                        <th class="w-1 center">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__empty_1 = true; $__currentLoopData = $purchaseRequisitions; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $purchaseRequisition): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoopIteration(); ?><?php endif; ?>
                        <tr>
                            <td class="w-1 center"><?php echo e($purchaseRequisitions->firstItem() + $index); ?></td>
                            <td><?php echo e($purchaseRequisition->number); ?></td>
                            <td><?php echo e($purchaseRequisition?->purchaseOrder?->number); ?></td>
                            <td><?php echo e($purchaseRequisition->supplier->name ?? '-'); ?></td>
                            <td><?php echo e($purchaseRequisition->notes ?? '-'); ?></td>
                            <td>
                                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($purchaseRequisition->purchaseOrder): ?>
                                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($purchaseRequisition->purchaseOrder->status === 'pending'): ?>
                                        <span
                                            class="px-2 py-1 text-xs font-semibold rounded bg-yellow-100 text-yellow-800">
                                            Barang Sebagian Di terima
                                        </span>
                                    <?php elseif($purchaseRequisition->purchaseOrder->status === 'success'): ?>
                                        <span
                                            class="px-2 py-1 text-xs font-semibold rounded bg-green-100 text-green-800">
                                            Barang Diterima
                                        </span>
                                    <?php elseif($purchaseRequisition->purchaseOrder->status === 'retur'): ?>
                                        <span class="px-2 py-1 text-xs font-semibold rounded bg-blur-100 text-blur-800">
                                            Retur
                                        </span>
                                    <?php elseif($purchaseRequisition->purchaseOrder->status === 'reject'): ?>
                                        <span class="px-2 py-1 text-xs font-semibold rounded bg-red-100 text-red-800">
                                            SP Dibatalkan
                                        </span>
                                    <?php else: ?>
                                        <span class="px-2 py-1 text-xs font-semibold rounded bg-gray-100 text-gray-800">
                                            Menunggu Barang Datang
                                        </span>
                                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                <?php else: ?>
                                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($purchaseRequisition->status == 'reject'): ?>
                                        <span class="px-2 py-1 text-xs font-semibold rounded bg-red-100 text-red-800">
                                            SP Dibatalkan
                                        </span>
                                    <?php else: ?>
                                        <span class="px-2 py-1 text-xs font-semibold rounded bg-gray-100 text-gray-800">
                                            Menunggu Barang Datang
                                        </span>
                                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

                            </td>
                            <td>Rp <?php echo number_format($purchaseRequisition?->purchaseOrder?->grand_total, 0, ',', '.'); ?></td>
                            <td class="center">
                                <div class="flex items-center">
                                    <!-- Tombol Detail -->
                                    <button
                                        class="btn btn-icon text-blue-600 hover:text-blue-800 transition-colors edit-btn"
                                        wire:click="detail('<?php echo e($purchaseRequisition->id); ?>')" aria-label="Lihat Detail">
                                        <i class="fas fa-eye text-blue-600 text-lg"></i> <!-- FontAwesome Eye Icon -->
                                    </button>
                                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($purchaseRequisition->id): ?>
                                        <a href="<?php echo e(route('user.receipt.mail-order', ['purchase_order_id' => $purchaseRequisition->id])); ?>"
                                            class="btn btn-icon text-green-600 hover:text-green-800 transition-colors">
                                            <i class="fas fa-file-invoice text-green-600 text-lg"></i>
                                        </a>
                                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(in_array($purchaseRequisition->status, ['draft'])): ?>
                                        <!-- Tombol Batalkan SP -->
                                        <button
                                            class="btn btn-icon text-red-600 hover:text-red-800 transition-colors delete-btn relative"
                                            wire:click="confirmDelete('<?php echo e($purchaseRequisition->id); ?>')"
                                            x-data="{ open: false }" @mouseenter="open = true" @mouseleave="open = false"
                                            aria-label="Batalkan SP">

                                            <i class="fas fa-trash-alt text-red-600 text-base"></i>
                                            <!-- FontAwesome Trash Icon -->

                                            <!-- Tooltip -->
                                            <div x-show="open" x-transition
                                                class="absolute w-max max-w-xs bg-white text-red-600 text-xs rounded px-2 py-1 bottom-full left-1/2 transform -translate-x-1/2 mb-2 shadow-md">
                                                Batalkan SP
                                            </div>
                                        </button>
                                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                    <button
                                        class="btn btn-icon text-red-600 hover:text-red-800 transition-colors edit-btn"
                                        wire:click="confirmDelete('<?php echo e($purchaseRequisition->id); ?>')" aria-label="Lihat Hapus">
                                        <i class="fas fa-trash text-red-600 text-lg"></i> <!-- FontAwesome Eye Icon -->
                                    </button>
                                </div>
                            </td>
                        </tr>
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
                        <tr>
                            <td colspan="10" class="no-data">Tidak ada data
                            </td>
                        </tr>
                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                </tbody>
            </table>
        </div>
        <div class="px-5 py-4 bg-gray-50/80 border-t border-gray-200">
            <div class="flex items-center justify-between">
                <div class="text-sm text-gray-700">
                    Menampilkan <span class="font-medium"><?php echo e($purchaseRequisitions->firstItem()); ?></span> sampai
                    <span class="font-medium"><?php echo e($purchaseRequisitions->lastItem()); ?></span> dari <span
                        class="font-medium"><?php echo e($purchaseRequisitions->total()); ?></span> hasil
                </div>
                <div>
                    <nav class="relative z-0 inline-flex rounded-md shadow-sm -space-x-px" aria-label="Pagination">
                        <?php echo e($purchaseRequisitions->links('vendor.livewire.custom')); ?>

                        <!-- Menampilkan pagination -->
                    </nav>
                </div>
            </div>
        </div>
    </div>
</div><?php /**PATH /Users/macbookair/Documents/mediction/mediction.id/resources/views/livewire/admin/logistic/direct-purchase/admin-logistic-direct-purchase-index.blade.php ENDPATH**/ ?>