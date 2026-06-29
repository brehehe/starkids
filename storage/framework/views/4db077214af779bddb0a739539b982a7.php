<div>
    <div class="mb-4">
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-2xl font-bold text-[#1E3A8A]">Buku Besar</h1>
            </div>
        </div>
    </div>

    
    <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-6">
        <div class="bg-gradient-to-br from-blue-500 to-blue-600 rounded-xl shadow-lg p-6 text-white">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-blue-100 text-sm font-medium">Total Transaksi</p>
                    <h3 class="text-3xl font-bold mt-2"><?php echo e(number_format($this->totalTransactions, 0, ',', '.')); ?></h3>
                </div>
                <div class="bg-white/20 rounded-full p-4">
                    <i class="fas fa-list text-2xl"></i>
                </div>
            </div>
        </div>

        <div class="bg-gradient-to-br from-green-500 to-green-600 rounded-xl shadow-lg p-6 text-white">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-green-100 text-sm font-medium">Total Debit</p>
                    <h3 class="text-2xl font-bold mt-2">Rp <?php echo e(number_format($this->totalDebit, 0, ',', '.')); ?></h3>
                </div>
                <div class="bg-white/20 rounded-full p-4">
                    <i class="fas fa-plus-circle text-2xl"></i>
                </div>
            </div>
        </div>

        <div class="bg-gradient-to-br from-red-500 to-red-600 rounded-xl shadow-lg p-6 text-white">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-red-100 text-sm font-medium">Total Kredit</p>
                    <h3 class="text-2xl font-bold mt-2">Rp <?php echo e(number_format($this->totalCredit, 0, ',', '.')); ?></h3>
                </div>
                <div class="bg-white/20 rounded-full p-4">
                    <i class="fas fa-minus-circle text-2xl"></i>
                </div>
            </div>
        </div>

        <div class="bg-gradient-to-br from-purple-500 to-purple-600 rounded-xl shadow-lg p-6 text-white">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-purple-100 text-sm font-medium">Saldo</p>
                    <h3 class="text-2xl font-bold mt-2">Rp <?php echo e(number_format($this->balance, 0, ',', '.')); ?></h3>
                </div>
                <div class="bg-white/20 rounded-full p-4">
                    <i class="fas fa-balance-scale text-2xl"></i>
                </div>
            </div>
        </div>
    </div>

    
    <div class="bg-white/80 backdrop-blur-sm rounded-xl shadow-lg border border-gray-100 p-4 mb-4">
        <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Dari Tanggal</label>
                <input type="date" wire:model.live="start_date" class="form-control" />
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Sampai Tanggal</label>
                <input type="date" wire:model.live="end_date" class="form-control" />
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Akun Biaya</label>
                <div <?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::$currentLoop['key'] = 'select-'.e(rand()).''; ?>wire:key="select-<?php echo e(rand()); ?>">
                    <select class="form-control" x-data x-ref="input" x-init="$($refs.input).selectize({
                        dropdownParent: 'body',
                        allowClear: true,
                        plugins: ['clear_button'],
                        onChange: function(e) {
                            window.Livewire.find('<?php echo e($_instance->getId()); ?>').set('account_id', e ? e : null);
                        }
                    });"
                        wire:model.lazy="account_id" id="account_id">
                        <option value="">-- Pilih Akun Biaya --</option>
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__currentLoopData = $accountOptions; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key_account => $account): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoopIteration(); ?><?php endif; ?>
                            <option value="<?php echo e($key_account); ?>"><?php echo e($account); ?></option>
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
                    </select>
                </div>
            </div>
            <div class="flex items-end">
                <button wire:click="resetFilters" class="btn btn-secondary w-full">
                    <i class="fas fa-redo mr-2"></i> Reset Filter
                </button>
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
        <div class="space-y-4">
            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__empty_5 = true; $__currentLoopData = $accounts; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $account): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_5 = false; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoopIteration(); ?><?php endif; ?>
                <div x-data="{ open: false }" class="bg-white border rounded-lg shadow-sm overflow-hidden">
                    
                    <div @click="open = !open" class="p-4 bg-gray-50 flex items-center justify-between cursor-pointer hover:bg-gray-100 transition-colors">
                        <div class="flex items-center space-x-4">
                            <div class="bg-blue-100 text-blue-600 rounded-full p-2">
                                <i :class="open ? 'fas fa-chevron-up' : 'fas fa-chevron-down'"></i>
                            </div>
                            <div>
                                <h3 class="text-lg font-semibold text-gray-800"><?php echo e($account->code); ?> - <?php echo e($account->name); ?></h3>
                                <p class="text-sm text-gray-500"><?php echo e($account->accountTransactions->count()); ?> Transaksi</p>
                            </div>
                        </div>
                        <div class="flex space-x-8">
                            <div class="text-right">
                                <p class="text-xs text-gray-500 uppercase">Total Debit</p>
                                <p class="font-bold text-green-600">Rp <?php echo e(number_format($account->accountTransactions->sum('debit'), 0, ',', '.')); ?></p>
                            </div>
                            <div class="text-right">
                                <p class="text-xs text-gray-500 uppercase">Total Kredit</p>
                                <p class="font-bold text-red-600">Rp <?php echo e(number_format($account->accountTransactions->sum('credit'), 0, ',', '.')); ?></p>
                            </div>
                            <div class="text-right">
                                <p class="text-xs text-gray-500 uppercase">Saldo</p>
                                <p class="font-bold text-blue-600">Rp <?php echo e(number_format($account->accountTransactions->sum('debit') - $account->accountTransactions->sum('credit'), 0, ',', '.')); ?></p>
                            </div>
                        </div>
                    </div>

                    
                    <div x-show="open" x-collapse class="border-t">
                        <div class="table-container">
                            <table class="table">
                                <thead class="bg-gray-50">
                                    <tr>
                                        <th class="w-1 center">No</th>
                                        <th>Kode Jurnal</th>
                                        <th>Tanggal</th>
                                        <th>Deskripsi</th>
                                        <th style="width: 15%">Debit</th>
                                        <th style="width: 15%">Kredit</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__currentLoopData = $account->accountTransactions; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $transaction): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoopIteration(); ?><?php endif; ?>
                                        <tr class="hover:bg-gray-50">
                                            <td class="center"><?php echo e($index + 1); ?></td>
                                            <td><?php echo e($transaction->journalItem->code ?? '-'); ?></td>
                                            <td><?php echo e($transaction->date ? \Carbon\Carbon::parse($transaction->date)->locale('id')->isoFormat('D MMMM Y') : '-'); ?></td>
                                            <td><?php echo e($transaction->description ?? '-'); ?></td>
                                            <td class="text-right"><?php echo e($transaction->debit ? 'Rp ' . number_format($transaction->debit, 0, ',', '.') : '-'); ?></td>
                                            <td class="text-right"><?php echo e($transaction->credit ? 'Rp ' . number_format($transaction->credit, 0, ',', '.') : '-'); ?></td>
                                        </tr>
                                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_5): ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
                <div class="text-center py-10 bg-white rounded-lg border border-gray-200">
                    <p class="text-gray-500 text-lg">Tidak ada data akun yang ditemukan.</p>
                </div>
            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
        </div>

        <!-- Pagination -->
        <!-- Pagination -->
        <div class="px-5 py-4 bg-gray-50/80 border-t border-gray-200">
            <div class="flex items-center justify-between">
                <div class="text-sm text-gray-700">
                    Menampilkan <span class="font-medium"><?php echo e($accounts->firstItem()); ?></span> sampai <span
                        class="font-medium"><?php echo e($accounts->lastItem()); ?></span> dari <span
                        class="font-medium"><?php echo e($accounts->total()); ?></span> hasil
                </div>
                <div>
                    <nav class="relative z-0 inline-flex rounded-md shadow-sm -space-x-px" aria-label="Pagination">
                        <?php echo e($accounts->links('vendor.livewire.custom')); ?> <!-- Menampilkan pagination -->
                    </nav>
                </div>
            </div>
        </div>

    </div>
</div><?php /**PATH /Users/macbookair/Documents/mediction/mediction.id/resources/views/livewire/admin/finance/ledger/admin-finance-ledger-index.blade.php ENDPATH**/ ?>