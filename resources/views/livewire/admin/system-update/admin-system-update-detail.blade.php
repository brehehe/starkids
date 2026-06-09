<div>
    <div class="mb-4">
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-2xl font-bold text-[#1E3A8A]">{{ $updateId ? 'Edit' : 'Buat' }} System Update</h1>
                <p class="text-gray-600 text-sm mt-1">{{ $updateId ? 'Perbarui' : 'Tambahkan' }} informasi update sistem</p>
            </div>
        </div>
    </div>

    <div class="bg-white rounded-xl shadow-lg border border-gray-100 p-6">
        <form wire:submit.prevent="save">
            {{-- Title --}}
            <div class="mb-6">
                <label class="block text-sm font-medium text-gray-700 mb-2">
                    Judul Update <span class="text-red-500">*</span>
                </label>
                <input
                    type="text"
                    wire:model="title"
                    class="form-control @error('title') border-red-500 @enderror"
                    placeholder="Contoh: Update Fitur Baru v2.0">
                @error('title')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            {{-- Type --}}
            <div class="mb-6">
                <label class="block text-sm font-medium text-gray-700 mb-2">
                    Tipe Update <span class="text-red-500">*</span>
                </label>
                <select wire:model="type" class="form-control @error('type') border-red-500 @enderror">
                    @foreach($types as $key => $label)
                        <option value="{{ $key }}">{{ $label }}</option>
                    @endforeach
                </select>
                @error('type')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            {{-- Content --}}
            <div class="mb-6">
                <label class="block text-sm font-medium text-gray-700 mb-2">
                    Konten Update <span class="text-red-500">*</span>
                </label>
                <textarea
                    wire:model="content"
                    rows="6"
                    class="form-control @error('content') border-red-500 @enderror"
                    placeholder="Jelaskan detail update sistem..."></textarea>
                @error('content')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            {{-- Published At --}}
            <div class="mb-6">
                <label class="block text-sm font-medium text-gray-700 mb-2">
                    Tanggal Publikasi
                </label>
                <input
                    type="datetime-local"
                    wire:model="published_at"
                    class="form-control @error('published_at') border-red-500 @enderror">
                @error('published_at')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
                <p class="text-gray-500 text-sm mt-1">Kosongkan untuk menggunakan waktu saat ini</p>
            </div>

            {{-- Is Active --}}
            <div class="mb-6">
                <label class="flex items-center cursor-pointer">
                    <input
                        type="checkbox"
                        wire:model="is_active"
                        class="form-checkbox h-5 w-5 text-blue-600 rounded">
                    <span class="ml-3 text-sm font-medium text-gray-700">
                        Aktifkan update (akan ditampilkan di halaman login)
                    </span>
                </label>
            </div>

            {{-- Actions --}}
            <div class="flex items-center justify-end gap-3 pt-4 border-t">
                <button
                    type="button"
                    wire:click="cancel"
                    class="btn btn-secondary">
                    <i class="fas fa-times mr-2"></i>
                    Batal
                </button>
                <button
                    type="submit"
                    class="btn btn-primary">
                    <i class="fas fa-save mr-2"></i>
                    {{ $updateId ? 'Perbarui' : 'Simpan' }}
                </button>
            </div>
        </form>
    </div>
</div>
