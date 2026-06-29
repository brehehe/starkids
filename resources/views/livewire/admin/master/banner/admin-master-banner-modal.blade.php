<div wire:ignore.self id="bannerModal" class="fixed inset-0 bg-overlay hidden items-center justify-center z-50 transition-opacity duration-300 ease-in-out">
    <div class="bg-white rounded-2xl shadow-2xl max-w-lg w-full transform transition-all scale-95 duration-300 ease-out animate-fade-in">
        <!-- Header -->
        <div class="flex justify-between items-center p-6 border-b">
            <div class="flex items-center gap-2">
                <svg class="w-6 h-6 text-blue-500" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                </svg>
                <h2 class="text-xl font-semibold text-gray-800">{{ $banner_id ? 'Edit Banner' : 'Tambah Banner' }}</h2>
            </div>
            <button wire:click="closeModal()" class="text-gray-500 hover:text-red-500 transition-colors text-2xl leading-none cursor-pointer">
                &times;
            </button>
        </div>

        <!-- Body -->
        <div class="px-6 py-4 text-gray-600">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div class="md:col-span-2">
                    <label class="block text-sm font-medium text-gray-700 mb-1">Banner Image <span class="text-red-600">*</span></label>

                    <input type="file" wire:model.live="new_image" class="block text-sm text-gray-500 w-full
                                           file:px-2 file:py-1 file:rounded-md
                                           file:border file:border-gray-300
                                           file:text-xs file:font-medium
                                           file:bg-blue-50 file:text-blue-700
                                           hover:file:bg-blue-100" accept="image/*" />
                    <div wire:loading wire:target="new_image" class="text-sm text-gray-500 mt-1">
                        Uploading image...
                    </div>
                    @error('new_image')
                        <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                    @enderror
                </div>
                
                <div class="md:col-span-2">
                    @if ($new_image)
                        <div class="mt-4">
                            <label class="block text-sm font-medium text-gray-700 mb-1">Preview:</label>
                            <img src="{{ $new_image->temporaryUrl() }}" alt="Preview" class="w-full h-auto rounded border shadow" />
                        </div>
                    @elseif ($image)
                        <div class="mt-4">
                            <label class="block text-sm font-medium text-gray-700 mb-1">Current Banner:</label>
                            <img src="{{ asset('storage/' . $image) }}" alt="Preview" class="w-full h-auto rounded border shadow" />
                        </div>
                    @endif
                </div>

                <div class="md:col-span-2">
                     <label for="isActive" class="block text-sm font-medium text-gray-700 mb-1">Status</label>
                    <div class="form-check form-switch">
                        <input class="form-check-input" type="checkbox" wire:model.defer="is_active" id="isActive">
                        <label class="form-check-label text-sm" for="isActive">Aktif</label>
                    </div>
                </div>
            </div>
        </div>

        <!-- Footer -->
        <div class="flex justify-end gap-2 px-6 py-4 border-t">
            <button wire:click="closeModal()" class="px-4 py-2 bg-gray-200 hover:bg-gray-300 text-gray-800 rounded-lg shadow transition cursor-pointer">
                Batal
            </button>
            <button wire:click='save' class="px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-lg shadow transition">
                Simpan
            </button>
        </div>
    </div>
</div>

@push('scripts')
    <script>
        document.addEventListener('livewire:initialized', () => {
            @this.on('open-modal', (event) => {
                var modal = document.getElementById('bannerModal');
                modal.classList.remove('hidden');
                modal.classList.add('flex');
            });

            @this.on('close-modal', (event) => {
                 var modal = document.getElementById('bannerModal');
                modal.classList.add('hidden');
                modal.classList.remove('flex');
            });
        });
    </script>
@endpush
