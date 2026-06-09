<div wire:ignore.self id="update-stock-modal"
    class="fixed inset-0 bg-overlay hidden items-center justify-center z-50 transition-opacity duration-300 ease-in-out">
    <div
        class="bg-white rounded-2xl shadow-2xl max-w-lg w-full transform transition-all scale-95 duration-300 ease-out animate-fade-in">
        <!-- Header -->
        <div class="flex justify-between items-center p-6 border-b">
            <div class="flex items-center gap-2">
                <svg class="w-6 h-6 text-blue-500" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4" />
                </svg>
                <h2 class="text-xl font-semibold text-gray-800">Atur Ulang Stok Produk</h2>
            </div>
            <button wire:click="closeUpdateStockModal"
                class="text-gray-500 hover:text-red-500 transition-colors text-2xl leading-none cursor-pointer">
                &times;
            </button>
        </div>

        <!-- Body -->
        <div class="px-6 py-4 text-gray-600">
            <div class="mb-4">
                <label for="newQuantity" class="block text-sm font-medium text-gray-700">
                    Kuantitas Baru <span class="text-red-600">*</span>
                </label>
                <input type="number" id="newQuantity" wire:model.defer="newQuantity"
                    class="mt-1 form-control" placeholder="Masukkan kuantitas baru" min="0" step="1">
                @error('newQuantity')
                    <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-4">
                <label for="updateReason" class="block text-sm font-medium text-gray-700">
                    Alasan Perubahan
                </label>
                <textarea id="updateReason" wire:model.defer="updateReason" rows="3"
                    class="mt-1 form-control" placeholder="Jelaskan alasan perubahan stok..."></textarea>
                @error('updateReason')
                    <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="bg-blue-50 border-l-4 border-blue-500 p-3 rounded">
                <p class="text-sm text-blue-700">
                    <i class="fas fa-info-circle mr-1"></i>
                    Perubahan ini akan tercatat dalam log sistem untuk keperluan audit.
                </p>
            </div>
        </div>

        <!-- Footer -->
        <div class="flex justify-end gap-2 px-6 py-4 border-t">
            <button wire:click="closeUpdateStockModal"
                class="px-4 py-2 bg-gray-200 hover:bg-gray-300 text-gray-800 rounded-lg shadow transition cursor-pointer">
                Batal
            </button>
            <button wire:click='updateStock' wire:loading.attr="disabled"
                class="px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-lg shadow transition">
                <span wire:loading.remove wire:target="updateStock">Perbarui Stok</span>
                <span wire:loading wire:target="updateStock">
                    <i class="fas fa-spinner fa-spin mr-1"></i> Memproses...
                </span>
            </button>
        </div>
    </div>
</div>
