<div>
    <div class="mb-4">
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-2xl font-bold text-[#1E3A8A]">Ubah Password</h1>
            </div>
            <div>
                <button wire:click="changePassword" class="btn btn-primary">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                    </svg>
                    Edit Ubah Password
                </button>
            </div>
        </div>
    </div>
    <div class="mb-4">
        <label for="currentPassword" class="block text-sm font-medium text-gray-700">Masukan Password Lama <span
                class="text-red-600">*</span>
        </label>
        <div x-data="{ show: false }" class="relative">
            <input :type="show ? 'text' : 'currentPassword'" id="currentPassword" wire:model.defer="currentPassword"
                placeholder="Contoh : 12345678"
                class="mt-1 block w-full rounded-md border-gray-300 px-4 py-2 shadow-sm focus:border-blue-500 focus:ring-blue-500 pr-10">

            <button type="button" @click="show = !show"
                class="absolute inset-y-0 right-0 px-3 flex items-center text-gray-500" tabindex="-1">
                <i :class="show ? 'fas fa-eye-slash' : 'fas fa-eye'"></i>
            </button>
        </div>

        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__errorArgs = ['currentPassword'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
            <p class="text-sm text-red-600 mt-1"><?php echo e($message); ?></p>
        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
    </div>
    <div class="mb-4">
        <label for="newPassword" class="block text-sm font-medium text-gray-700">Masukan Password Baru <span
                class="text-red-600">*</span>
        </label>
        <div x-data="{ show: false }" class="relative">
            <input :type="show ? 'text' : 'newPassword'" id="newPassword" wire:model.defer="newPassword"
                placeholder="Contoh : 12345678"
                class="mt-1 block w-full rounded-md border-gray-300 px-4 py-2 shadow-sm focus:border-blue-500 focus:ring-blue-500 pr-10">

            <button type="button" @click="show = !show"
                class="absolute inset-y-0 right-0 px-3 flex items-center text-gray-500" tabindex="-1">
                <i :class="show ? 'fas fa-eye-slash' : 'fas fa-eye'"></i>
            </button>
        </div>

        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__errorArgs = ['newPassword'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
            <p class="text-sm text-red-600 mt-1"><?php echo e($message); ?></p>
        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
    </div>
    <div class="mb-4">
        <label for="confirmPassword" class="block text-sm font-medium text-gray-700">Masukan Konfirmasi Password <span
                class="text-red-600">*</span>
        </label>
        <div x-data="{ show: false }" class="relative">
            <input :type="show ? 'text' : 'confirmPassword'" id="confirmPassword" wire:model.defer="confirmPassword"
                placeholder="Contoh : 12345678"
                class="mt-1 block w-full rounded-md border-gray-300 px-4 py-2 shadow-sm focus:border-blue-500 focus:ring-blue-500 pr-10">

            <button type="button" @click="show = !show"
                class="absolute inset-y-0 right-0 px-3 flex items-center text-gray-500" tabindex="-1">
                <i :class="show ? 'fas fa-eye-slash' : 'fas fa-eye'"></i>
            </button>
        </div>

        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__errorArgs = ['confirmPassword'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
            <p class="text-sm text-red-600 mt-1"><?php echo e($message); ?></p>
        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
    </div>
</div>
<?php $__env->startPush('scripts'); ?>
    <script>
        document.getElementById("btnPrint").addEventListener("click", async () => {
            try {
                const device = await navigator.bluetooth.requestDevice({
                    acceptAllDevices: true,
                    optionalServices: [0x18F0] // contoh service UUID printer
                });

                const server = await device.gatt.connect();
                const service = await server.getPrimaryService(0x18F0);
                const characteristic = await service.getCharacteristic(0x2AF1);

                // Kirim ESC/POS string
                const encoder = new TextEncoder();
                await characteristic.writeValue(encoder.encode(
                    "Halo ini struk dari Browser!\nTotal: Rp 50.000\n\n"));
                alert("✅ Berhasil print ke " + device.name);
            } catch (err) {
                console.error(err);
                alert("❌ Error: " + err);
            }
        });
    </script>
<?php $__env->stopPush(); ?><?php /**PATH /Users/macbookair/Documents/mediction/mediction.id/resources/views/livewire/admin/change-password/admin-change-password-index.blade.php ENDPATH**/ ?>