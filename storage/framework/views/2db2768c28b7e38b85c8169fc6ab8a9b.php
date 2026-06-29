<div>
    <div class="mb-4">
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-2xl font-bold text-[#1E3A8A]">Potongan / Tambahan Khusus</h1>
                <p class="text-gray-500 text-sm mt-1">Kelola data potongan dan tambahan gaji pegawai di luar komponen master per bulan.</p>
            </div>
            <button wire:click="create()" class="btn-primary" title="Tambah Data">
                <i class="fas fa-plus mr-2"></i> Tambah Data
            </button>
        </div>
    </div>

    <!-- Table Controls -->
    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center mb-4 gap-4">
        <div class="flex items-center gap-4">
            <div class="flex items-center">
                <span class="text-sm text-gray-700 mr-2">Periode</span>
                <input type="month" class="form-control py-1 px-3" wire:model.live='filterPeriod'>
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
            <input type="text" class="mt-1 form-control-search" placeholder="Cari Nama Pegawai / Ket..."
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
                        <th>Keterangan / Nama</th>
                        <th class="center">Tipe</th>
                        <th class="text-right">Nominal (Rp)</th>
                        <th class="w-1 center">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__empty_5 = true; $__currentLoopData = $adjustments; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_5 = false; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoopIteration(); ?><?php endif; ?>
                    <tr>
                        <td class="center"><?php echo e($adjustments->firstItem() + $index); ?></td>
                        <td>
                            <div class="font-medium text-gray-900"><?php echo e($item->user->name ?? '-'); ?></div>
                            <div class="text-xs text-gray-500"><?php echo e($item->user->email ?? $item->user->phone ?? '-'); ?></div>
                        </td>
                        <td>
                            <div class="font-medium text-gray-800"><?php echo e($item->name); ?></div>
                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($item->description): ?>
                                <div class="text-xs text-gray-500"><?php echo e(Str::limit($item->description, 50)); ?></div>
                            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                        </td>
                        <td class="center">
                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($item->type == 'allowance'): ?>
                                <span class="px-2 py-1 bg-green-100 text-green-700 rounded text-xs font-bold border border-green-200">Tambahan (+)</span>
                            <?php else: ?>
                                <span class="px-2 py-1 bg-red-100 text-red-700 rounded text-xs font-bold border border-red-200">Potongan (-)</span>
                            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                        </td>
                        <td class="text-right font-medium text-gray-800">
                            Rp <?php echo e(number_format($item->amount, 0, ',', '.')); ?>

                        </td>
                        <td class="center whitespace-nowrap">
                            <button wire:click="edit('<?php echo e($item->id); ?>')" class="btn-action btn-edit bg-blue-50 text-blue-600 hover:bg-blue-100 mr-2" title="Edit">
                                <i class="fas fa-edit"></i>
                            </button>
                            <button wire:click="deleteConfirm('<?php echo e($item->id); ?>')" class="btn-action btn-delete bg-red-50 text-red-600 hover:bg-red-100" title="Hapus">
                                <i class="fas fa-trash"></i>
                            </button>
                        </td>
                    </tr>
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_5): ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
                    <tr>
                        <td colspan="6" class="no-data py-8">
                            <div class="flex flex-col items-center justify-center text-gray-500">
                                <i class="fas fa-receipt text-4xl mb-3 text-gray-300"></i>
                                <p>Belum ada data Potongan/Tambahan untuk periode <b><?php echo e(Carbon\Carbon::parse($filterPeriod)->translatedFormat('F Y')); ?></b>.</p>
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
                    Menampilkan <span class="font-medium"><?php echo e($adjustments->firstItem() ?? 0); ?></span> sampai <span
                        class="font-medium"><?php echo e($adjustments->lastItem() ?? 0); ?></span> dari <span
                        class="font-medium"><?php echo e($adjustments->total() ?? 0); ?></span> data
                </div>
                <div>
                    <nav class="relative z-0 inline-flex rounded-md shadow-sm -space-x-px" aria-label="Pagination">
                        <?php echo e($adjustments->links('vendor.livewire.custom')); ?>

                    </nav>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Form (Create/Edit) -->
    <div wire:ignore.self id="modal-adjustment"
        class="fixed inset-0 bg-overlay hidden items-center justify-center z-50 transition-opacity duration-300 ease-in-out">
        <div class="bg-white rounded-2xl shadow-2xl w-full max-w-lg transform transition-all scale-95 duration-300 ease-out animate-fade-in">
            <!-- Header -->
            <div class="flex justify-between items-center p-6 border-b bg-gray-50 rounded-t-2xl">
                <h2 class="text-xl font-bold text-gray-800"><?php echo e($data_id ? 'Edit Data' : 'Tambah Baru'); ?> (<?php echo e(Carbon\Carbon::parse($filterPeriod)->translatedFormat('F Y')); ?>)</h2>
                <button wire:click="closeModal()"
                    class="text-gray-400 hover:text-red-500 bg-white shadow-sm border p-1 rounded-md transition-colors text-2xl leading-none cursor-pointer">
                    &times;
                </button>
            </div>

            <!-- Body -->
            <div class="p-6 text-gray-600">
                <div class="grid grid-cols-1 gap-4 mb-4">
                    <div>
                        <label for="user_id" class="block text-sm font-medium text-gray-700">Pegawai <span class="text-red-600">*</span></label>
                        <select id="user_id" wire:model.defer="user_id" class="mt-1 form-control bg-gray-50 select2-tail">
                            <option value="">-- Pilih Pegawai --</option>
                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__currentLoopData = $employees; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $emp): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoopIteration(); ?><?php endif; ?>
                                <option value="<?php echo e($emp->id); ?>"><?php echo e($emp->name); ?></option>
                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
                        </select>
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__errorArgs = ['user_id'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <p class="text-sm text-red-600 mt-1"><?php echo e($message); ?></p> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                    </div>

                    <div>
                        <label for="name" class="block text-sm font-medium text-gray-700">Keterangan / Nama <span class="text-red-600">*</span></label>
                        <input id="name" type="text" wire:model.defer="name" placeholder="Cth: Bonus" class="mt-1 form-control">
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__errorArgs = ['name'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <p class="text-sm text-red-600 mt-1"><?php echo e($message); ?></p> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                    </div>

                    <div>
                        <label for="type" class="block text-sm font-medium text-gray-700">Tipe <span class="text-red-600">*</span></label>
                        <select id="type" wire:model.defer="type" class="mt-1 form-control bg-gray-50">
                            <option value="allowance">Tambahan (+)</option>
                            <option value="deduction">Potongan (-)</option>
                        </select>
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__errorArgs = ['type'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <p class="text-sm text-red-600 mt-1"><?php echo e($message); ?></p> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                    </div>

                    <div>
                        <label for="amount" class="block text-sm font-medium text-gray-700">Nominal (Rp) <span class="text-red-600">*</span></label>
                        <div class="relative mt-1">
                            <input id="amount" type="number" wire:model.defer="amount" placeholder="0" class="pl-4 form-control">
                        </div>
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__errorArgs = ['amount'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <p class="text-sm text-red-600 mt-1"><?php echo e($message); ?></p> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                    </div>

                    <div>
                        <label for="description" class="block text-sm font-medium text-gray-700">Catatan Tambahan</label>
                        <textarea id="description" wire:model.defer="description" rows="2" placeholder="Opsional..." class="mt-1 form-control"></textarea>
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__errorArgs = ['description'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <p class="text-sm text-red-600 mt-1"><?php echo e($message); ?></p> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                    </div>
                </div>
            </div>

            <!-- Footer -->
            <div class="flex justify-end gap-2 p-6 border-t bg-gray-50 rounded-b-2xl">
                <button wire:click="closeModal()" class="px-5 py-2.5 bg-white border border-gray-300 hover:bg-gray-50 text-gray-700 font-medium rounded-xl shadow-sm transition-all focus:ring-2 focus:ring-gray-200 focus:outline-none cursor-pointer">
                    Batal
                </button>
                <button wire:click="save()" class="px-5 py-2.5 bg-blue-600 hover:bg-blue-700 text-white font-medium rounded-xl shadow-sm transition-all focus:ring-2 focus:ring-blue-500 focus:outline-none cursor-pointer flex items-center" wire:loading.attr="disabled">
                    <svg wire:loading wire:target="save" class="animate-spin -ml-1 mr-2 h-4 w-4 text-white" fill="none" viewBox="0 0 24 24">
                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                    </svg>
                    <span wire:loading.remove wire:target="save">Simpan</span>
                    <span wire:loading wire:target="save">Menyimpan...</span>
                </button>
            </div>
        </div>
    </div>

    <!-- Modal Konfirmasi Hapus -->
    <div wire:ignore.self id="modal-delete"
        class="fixed inset-0 bg-overlay hidden items-center justify-center z-50 transition-opacity duration-300 ease-in-out">
        <div class="bg-white rounded-2xl shadow-2xl w-full max-w-md transform transition-all scale-95 duration-300 ease-out animate-fade-in p-6 text-center">
            
            <div class="mx-auto flex items-center justify-center h-16 w-16 rounded-full bg-red-100 mb-6">
                <i class="fas fa-exclamation-triangle text-3xl text-red-600"></i>
            </div>
            
            <h3 class="text-xl font-bold text-gray-900 mb-2">Hapus Data Khusus</h3>
            <p class="text-sm text-gray-500 mb-6 font-medium px-4">
                Apakah Anda yakin ingin menghapus catatan potongan/tambahan ini? Aksi ini tidak dapat dikembalikan.
            </p>
            
            <div class="flex justify-center gap-3 w-full">
                <button wire:click="closeModal()" class="flex-1 px-5 py-2.5 bg-white border-2 border-gray-200 hover:bg-gray-50 text-gray-700 font-bold rounded-xl transition-all focus:ring-4 focus:ring-gray-100 focus:outline-none cursor-pointer">
                    Batal
                </button>
                <button wire:click="delete()" class="flex-1 px-5 py-2.5 bg-red-600 hover:bg-red-700 text-white font-bold rounded-xl shadow-lg shadow-red-200 transition-all focus:ring-4 focus:ring-red-100 focus:outline-none cursor-pointer flex justify-center items-center" wire:loading.attr="disabled">
                    <svg wire:loading wire:target="delete" class="animate-spin -ml-1 mr-2 h-4 w-4 text-white" fill="none" viewBox="0 0 24 24">
                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                    </svg>
                    <span wire:loading.remove wire:target="delete">Ya, Hapus</span>
                    <span wire:loading wire:target="delete">Menghapus...</span>
                </button>
            </div>
        </div>
    </div>
</div><?php /**PATH /Users/macbookair/Documents/mediction/mediction.id/resources/views/livewire/admin/hr/payroll/admin-hr-payroll-adjustment-index.blade.php ENDPATH**/ ?>