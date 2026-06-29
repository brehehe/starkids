<div>
    <div class="mb-4">
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-2xl font-bold text-[#1E3A8A]">Setting Shift Pegawai</h1>
                <p class="text-sm text-gray-500 mt-1">Atur jadwal shift kerja untuk setiap pegawai</p>
            </div>
        </div>
    </div>

    <!-- Table Controls -->
    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center mb-4 gap-4">
        <div class="flex items-center">
            <span class="text-sm text-gray-700 mr-2">Tampil</span>
            <select class="mt-1 form-control" wire:model.live='perPage'>
                <option value="5">5</option>
                <option value="10">10</option>
                <option value="25">25</option>
                <option value="50">50</option>
            </select>
            <span class="text-sm text-gray-700 ml-2">data</span>
        </div>

        <div class="relative w-full sm:w-64">
            <input type="text" class="mt-1 form-control-search" placeholder="Cari Nama / No. HP Pegawai..."
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
                        <th>Nama Pegawai</th>
                        <th>No. HP</th>
                        <th class="center">Shift Saat Ini</th>
                        <th class="center">Jam Kerja</th>
                        <th class="w-1 center">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__empty_5 = true; $__currentLoopData = $employees; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $employee): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_5 = false; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoopIteration(); ?><?php endif; ?>
                    <tr <?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::$currentLoop['key'] = 'emp-'.e($employee->id).''; ?>wire:key="emp-<?php echo e($employee->id); ?>">
                        <td class="center"><?php echo e($employees->firstItem() + $index); ?></td>
                        <td>
                            <div class="flex items-center gap-2">
                                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($employee->profile): ?>
                                    <img src="<?php echo e(Storage::url($employee->profile)); ?>" class="w-8 h-8 rounded-full object-cover" alt="">
                                <?php else: ?>
                                    <div class="w-8 h-8 rounded-full bg-blue-100 text-blue-700 flex items-center justify-center text-xs font-bold">
                                        <?php echo e(strtoupper(substr($employee->name, 0, 2))); ?>

                                    </div>
                                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                <span class="font-medium"><?php echo e($employee->name); ?></span>
                            </div>
                        </td>
                        <td class="text-gray-600"><?php echo e($employee->phone ?? '-'); ?></td>
                        <td class="center">
                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($employee->shift): ?>
                                <span class="px-2 py-1 bg-blue-100 text-blue-800 rounded text-xs font-semibold">
                                    <?php echo e($employee->shift->name); ?>

                                </span>
                            <?php else: ?>
                                <span class="px-2 py-1 bg-gray-100 text-gray-500 rounded text-xs">
                                    Belum diset
                                </span>
                            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                        </td>
                        <td class="center text-sm text-gray-600">
                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($employee->shift): ?>
                                <?php echo e(\Carbon\Carbon::createFromFormat('H:i:s', $employee->shift->start_time)->format('H:i')); ?>

                                &ndash;
                                <?php echo e(\Carbon\Carbon::createFromFormat('H:i:s', $employee->shift->end_time)->format('H:i')); ?>

                            <?php else: ?>
                                <span class="text-gray-400">-</span>
                            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                        </td>
                        <td class="center">
                            <div class="flex items-center justify-center gap-2">
                                <button wire:click="openModal('<?php echo e($employee->id); ?>')" class="btn-action btn-edit" title="Set Shift">
                                    <i class="fas fa-clock"></i>
                                </button>
                                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($employee->shift): ?>
                                    <button wire:click="clearShift('<?php echo e($employee->id); ?>')" class="btn-action btn-delete" title="Hapus Shift">
                                        <i class="fas fa-times"></i>
                                    </button>
                                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                            </div>
                        </td>
                    </tr>
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_5): ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
                    <tr>
                        <td colspan="6" class="no-data">Belum ada data pegawai.</td>
                    </tr>
                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        <div class="px-5 py-4 bg-gray-50/80 border-t border-gray-200">
            <div class="flex items-center justify-between">
                <div class="text-sm text-gray-700">
                    Menampilkan <span class="font-medium"><?php echo e($employees->firstItem() ?? 0); ?></span> sampai <span
                        class="font-medium"><?php echo e($employees->lastItem() ?? 0); ?></span> dari <span
                        class="font-medium"><?php echo e($employees->total() ?? 0); ?></span> pegawai
                </div>
                <div>
                    <nav class="relative z-0 inline-flex rounded-md shadow-sm -space-x-px" aria-label="Pagination">
                        <?php echo e($employees->links('vendor.livewire.custom')); ?>

                    </nav>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Assign Shift -->
    <div wire:ignore.self id="modal-shift-setting"
        class="fixed inset-0 bg-overlay hidden items-center justify-center z-50 transition-opacity duration-300 ease-in-out">
        <div class="bg-white rounded-2xl shadow-2xl w-full transform transition-all scale-95 duration-300 ease-out animate-fade-in"
            style="max-width: 460px;">
            <!-- Header -->
            <div class="flex justify-between items-center p-6 border-b">
                <div class="flex items-center gap-2">
                    <i class="fa-solid fa-user-clock text-blue-500 text-xl"></i>
                    <h2 class="text-xl font-semibold text-gray-800">Set Shift Pegawai</h2>
                </div>
                <button wire:click="closeModal()"
                    class="text-gray-500 hover:text-red-500 transition-colors text-2xl leading-none cursor-pointer">
                    &times;
                </button>
            </div>

            <!-- Body -->
            <div class="px-6 py-5 text-gray-600">
                <div class="mb-4 p-3 bg-blue-50 rounded-lg border border-blue-100">
                    <p class="text-sm text-blue-700 font-medium">Pegawai: <span class="text-blue-900"><?php echo e($employee_name); ?></span></p>
                </div>

                <div>
                    <label for="shift_id" class="block text-sm font-medium text-gray-700 mb-1">Pilih Shift</label>
                    <select id="shift_id" wire:model.defer="shift_id" class="mt-1 form-control">
                        <option value="">-- Tidak Ada Shift --</option>
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__currentLoopData = $shifts; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $shift): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoopIteration(); ?><?php endif; ?>
                            <option value="<?php echo e($shift->id); ?>">
                                <?php echo e($shift->name); ?>

                                (<?php echo e(\Carbon\Carbon::createFromFormat('H:i:s', $shift->start_time)->format('H:i')); ?>

                                &ndash;
                                <?php echo e(\Carbon\Carbon::createFromFormat('H:i:s', $shift->end_time)->format('H:i')); ?>)
                            </option>
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
                    </select>
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__errorArgs = ['shift_id'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <p class="text-sm text-red-600 mt-1"><?php echo e($message); ?></p> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                    <p class="text-xs text-gray-400 mt-1">Pilih "Tidak Ada Shift" untuk mengosongkan shift pegawai ini.</p>
                </div>
            </div>

            <!-- Footer -->
            <div class="flex justify-end gap-2 px-6 py-4 border-t">
                <button wire:click="closeModal()" class="px-4 py-2 bg-gray-200 hover:bg-gray-300 text-gray-800 rounded-lg shadow transition cursor-pointer">
                    Batal
                </button>
                <button wire:click="save()" class="px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-lg shadow transition cursor-pointer" wire:loading.attr="disabled">
                    <span wire:loading.remove wire:target="save">Simpan</span>
                    <span wire:loading wire:target="save">Menyimpan...</span>
                </button>
            </div>
        </div>
    </div>
</div><?php /**PATH /Users/macbookair/Documents/mediction/mediction.id/resources/views/livewire/admin/hr/shift/admin-hr-shift-setting-index.blade.php ENDPATH**/ ?>