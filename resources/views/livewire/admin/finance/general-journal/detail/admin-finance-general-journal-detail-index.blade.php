<div>
    <div class="mb-4">
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-2xl font-bold text-[#1E3A8A]">{{ $journal_id ? 'Edit' : 'Tambah' }} Jurnal Umum</h1>
            </div>
            <div>
                <a href="{{ route('user.finance.general-journal') }}" class="btn btn-secondary">
                    <i class="fas fa-arrow-left mr-2"></i> Kembali
                </a>
            </div>
        </div>
    </div>

    <div class="bg-white rounded-xl shadow-lg border border-gray-100 p-6">
        <form wire:submit.prevent="save">
            {{-- Header Info --}}
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-6">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">
                        Tanggal <span class="text-red-500">*</span>
                    </label>
                    <input type="date" wire:model="date" class="form-control @error('date') border-red-500 @enderror" required>
                    @error('date')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">
                        Deskripsi <span class="text-red-500">*</span>
                    </label>
                    <input type="text" wire:model="description" class="form-control @error('description') border-red-500 @enderror"
                           placeholder="Masukkan deskripsi jurnal..." required>
                    @error('description')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            {{-- Journal Items Table --}}
            <div class="mb-6">
                <div class="flex justify-between items-center mb-4">
                    <h3 class="text-lg font-semibold text-gray-700">Detail Transaksi</h3>
                    <button type="button" wire:click="addRow" class="btn btn-sm btn-success">
                        <i class="fas fa-plus mr-1"></i> Tambah Baris
                    </button>
                </div>

                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">#</th>
                                <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Akun <span class="text-red-500">*</span></th>
                                <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Debit (Rp)</th>
                                <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Kredit (Rp)</th>
                                <th class="px-4 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @foreach($items as $index => $item)
                                <tr>
                                    <td class="px-4 py-3 whitespace-nowrap text-sm text-gray-900">
                                        {{ $index + 1 }}
                                    </td>
                                    <td class="px-4 py-3">
                                        <select wire:model="items.{{ $index }}.account_id"
                                                class="form-control @error('items.'.$index.'.account_id') border-red-500 @enderror"
                                                required>
                                            <option value="">Pilih Akun</option>
                                            @foreach($accounts as $account)
                                                <option value="{{ $account->id }}">{{ $account->name }} ({{ $account->code }})</option>
                                            @endforeach
                                        </select>
                                        @error('items.'.$index.'.account_id')
                                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                        @enderror
                                    </td>
                                    <td class="px-4 py-3">
                                        <input type="number"
                                               wire:model.blur="items.{{ $index }}.debit"
                                               class="form-control @error('items.'.$index.'.debit') border-red-500 @enderror"
                                               min="0"
                                               step="0.01"
                                               placeholder="0">
                                        @error('items.'.$index.'.debit')
                                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                        @enderror
                                    </td>
                                    <td class="px-4 py-3">
                                        <input type="number"
                                               wire:model.blur="items.{{ $index }}.credit"
                                               class="form-control @error('items.'.$index.'.credit') border-red-500 @enderror"
                                               min="0"
                                               step="0.01"
                                               placeholder="0">
                                        @error('items.'.$index.'.credit')
                                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                        @enderror
                                    </td>
                                    <td class="px-4 py-3 text-center">
                                        @if(count($items) > 1)
                                            <button type="button"
                                                    wire:click="removeRow({{ $index }})"
                                                    class="text-red-600 hover:text-red-900">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                        <tfoot class="bg-gray-50">
                            <tr>
                                <td colspan="2" class="px-4 py-3 text-right font-bold text-gray-700">Total:</td>
                                <td class="px-4 py-3">
                                    <span class="font-bold text-green-600">
                                        Rp {{ number_format(collect($items)->sum('debit'), 0, ',', '.') }}
                                    </span>
                                </td>
                                <td class="px-4 py-3">
                                    <span class="font-bold text-red-600">
                                        Rp {{ number_format(collect($items)->sum('credit'), 0, ',', '.') }}
                                    </span>
                                </td>
                                <td></td>
                            </tr>
                            <tr>
                                <td colspan="2" class="px-4 py-3 text-right font-bold text-gray-700">Selisih:</td>
                                <td colspan="2" class="px-4 py-3">
                                    @php
                                        $balance = collect($items)->sum('debit') - collect($items)->sum('credit');
                                    @endphp
                                    <span class="font-bold {{ $balance == 0 ? 'text-green-600' : 'text-red-600' }}">
                                        Rp {{ number_format(abs($balance), 0, ',', '.') }}
                                        @if($balance == 0)
                                            <i class="fas fa-check-circle ml-2"></i>
                                        @else
                                            <i class="fas fa-exclamation-triangle ml-2"></i>
                                        @endif
                                    </span>
                                </td>
                                <td></td>
                            </tr>
                        </tfoot>
                    </table>
                </div>

                @if($balance != 0)
                    <div class="mt-4 bg-yellow-50 border border-yellow-200 rounded-lg p-4">
                        <div class="flex items-center">
                            <i class="fas fa-exclamation-triangle text-yellow-600 mr-2"></i>
                            <p class="text-sm text-yellow-800">
                                <strong>Perhatian:</strong> Total debit dan kredit harus sama. Saat ini terdapat selisih
                                <strong>Rp {{ number_format(abs($balance), 0, ',', '.') }}</strong>
                            </p>
                        </div>
                    </div>
                @endif
            </div>

            {{-- Action Buttons --}}
            <div class="flex justify-end gap-3">
                <a href="{{ route('user.finance.general-journal') }}" class="btn btn-secondary">
                    <i class="fas fa-times mr-2"></i> Batal
                </a>
                <button type="submit" class="btn btn-primary" wire:loading.attr="disabled">
                    <i class="fas fa-save mr-2" wire:loading.remove></i>
                    <i class="fas fa-spinner fa-spin mr-2" wire:loading></i>
                    <span wire:loading.remove>{{ $journal_id ? 'Update' : 'Simpan' }}</span>
                    <span wire:loading>Menyimpan...</span>
                </button>
            </div>
        </form>
    </div>
</div>
