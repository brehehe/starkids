<div wire:ignore.self id="modal"
    class="fixed inset-0 bg-gray-900/50 backdrop-blur-sm hidden items-center justify-center z-50 transition-opacity duration-300 ease-in-out">
    <div
        class="bg-white rounded-2xl shadow-2xl max-w-lg w-full mx-4 transform transition-all scale-95 duration-300 ease-out animate-fade-in">
        <!-- Header -->
        <div class="flex justify-between items-center p-6 border-b border-gray-100">
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 rounded-xl bg-blue-50 flex items-center justify-center text-blue-600">
                    <i class="fas fa-tag text-lg"></i>
                </div>
                <div>
                    <h2 class="text-xl font-bold text-gray-800">Ubah Harga Jual</h2>
                    <p class="text-xs text-gray-500 font-medium">Penyesuaian margin & harga jual produk</p>
                </div>
            </div>
            <button wire:click="closeModal()"
                onclick="document.getElementById('modal').classList.add('hidden'); document.getElementById('modal').classList.remove('flex');"
                class="text-gray-400 hover:text-red-500 transition-colors text-2xl leading-none cursor-pointer p-1">
                <i class="fas fa-times"></i>
            </button>
        </div>

        <!-- Body -->
        <div class="px-6 py-4 text-gray-600 space-y-4">
            <div>
                <label for="productName" class="block text-sm font-medium text-gray-700">Nama Produk</label>
                <input type="text" id="productName" wire:model="productName" disabled
                    class="mt-1 form-control bg-gray-50 text-gray-700 font-semibold cursor-not-allowed">
            </div>

            <div class="grid grid-cols-2 gap-3">
                <div>
                    <label for="hpp_average" class="block text-xs font-bold text-emerald-800">HNA Netto (Dgn Diskon)</label>
                    <div class="mt-1 flex rounded-md shadow-sm">
                        <span class="inline-flex items-center rounded-l-md border border-r-0 border-emerald-200 bg-emerald-50 px-2.5 text-emerald-700 text-xs font-bold">
                            Rp
                        </span>
                        <input type="text" onkeyup="convertToRupiah(this);" id="hpp_average" disabled
                            wire:model="hpp_average" class="form-control rounded-l-none bg-emerald-50/40 font-bold text-emerald-900 border-emerald-200 cursor-not-allowed text-xs" />
                    </div>
                </div>

                <div>
                    <label for="hpp_average_without_discount" class="block text-xs font-bold text-amber-800">HNA Bruto (Tanpa Diskon)</label>
                    <div class="mt-1 flex rounded-md shadow-sm">
                        <span class="inline-flex items-center rounded-l-md border border-r-0 border-amber-200 bg-amber-50 px-2.5 text-amber-700 text-xs font-bold">
                            Rp
                        </span>
                        <input type="text" onkeyup="convertToRupiah(this);" id="hpp_average_without_discount" disabled
                            wire:model="hpp_average_without_discount" class="form-control rounded-l-none bg-amber-50/40 font-bold text-amber-900 border-amber-200 cursor-not-allowed text-xs" />
                    </div>
                </div>
            </div>

            <div class="grid grid-cols-2 gap-3">
                <div>
                    <label for="margin_normal" class="block text-sm font-medium text-gray-700">Margin (%) <span class="text-red-600">*</span></label>
                    <div class="mt-1 flex rounded-md shadow-sm">
                        <input type="number" id="margin_normal" wire:model.live="margin_normal" placeholder="0"
                            class="form-control rounded-r-none">
                        <span class="inline-flex items-center rounded-r-md border border-l-0 border-gray-300 bg-gray-100 px-3 text-gray-500 text-xs font-semibold">
                            %
                        </span>
                    </div>
                    @error('margin_normal')
                        <p class="text-xs text-red-600 mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="price_generate" class="block text-sm font-medium text-gray-700">Harga Jual Baru <span class="text-red-600">*</span></label>
                    <div class="mt-1 flex rounded-md shadow-sm">
                        <span class="inline-flex items-center rounded-l-md border border-r-0 border-gray-300 bg-gray-100 px-2.5 text-gray-500 text-xs font-semibold">
                            Rp
                        </span>
                        <input type="text" onkeyup="convertToRupiah(this);" id="price_generate"
                            wire:model="price_generate" placeholder="0" class="form-control rounded-l-none font-bold text-blue-700 text-sm" />
                    </div>
                    @error('price_generate')
                        <p class="text-xs text-red-600 mt-1">{{ $message }}</p>
                    @enderror
                </div>
            </div>
            <p class="text-[11px] text-gray-400">Harga jual otomatis terhitung dari HNA Netto + Margin, atau Anda dapat mengetik angka harga langsung.</p>
        </div>

        <!-- Footer -->
        <div class="flex justify-end gap-2 px-6 py-4 border-t border-gray-100 bg-gray-50/50 rounded-b-2xl">
            <button type="button" wire:click="closeModal()"
                onclick="document.getElementById('modal').classList.add('hidden'); document.getElementById('modal').classList.remove('flex');"
                class="px-4 py-2 bg-gray-200 hover:bg-gray-300 text-gray-700 text-sm font-medium rounded-xl transition cursor-pointer">
                Batal
            </button>
            <button type="button" wire:click='save'
                class="px-5 py-2 bg-blue-600 hover:bg-blue-700 text-white text-sm font-semibold rounded-xl shadow-sm transition cursor-pointer flex items-center gap-2">
                <i class="fas fa-save"></i>
                Simpan Harga
            </button>
        </div>
    </div>
</div>
