<div wire:ignore.self id="modal" class="fixed inset-0 bg-overlay hidden items-center justify-center z-50 transition-opacity duration-300 ease-in-out">
    <div class="bg-white rounded-2xl shadow-2xl w-full transform transition-all scale-95 duration-300 ease-out animate-fade-in" style="max-width: 850px;">
        <!-- Header -->
        <div class="flex justify-between items-center p-6 border-b">
            <div class="flex items-center gap-2">
                <svg class="w-6 h-6 text-blue-500" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M13 16h-1v-4h-1m1-4h.01M12 20.5C6.753 20.5 2.5 16.247 2.5 11S6.753 1.5 12 1.5 21.5 5.753 21.5 11 17.247 20.5 12 20.5z" />
                </svg>
                <h2 class="text-xl font-semibold text-gray-800">Modal Tindakan</h2>
            </div>
            <button wire:click="closeModal('modal')" class="text-gray-500 hover:text-red-500 transition-colors text-2xl leading-none cursor-pointer">
                &times;
            </button>
        </div>

        <!-- Body -->
        <div class="px-6 py-4 text-gray-600 overflow-auto" style="max-height: 600px;">
            {{-- Nama --}}
            <div class="mb-4">
                <label for="name" class="block text-sm font-medium text-gray-700">Nama <span class="text-red-600">*</span></label>
                <input type="text" class="mt-1 form-control" wire:model.live='name' id="name" placeholder="Masukkan nama tindakan">
                @error('name')
                    <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                @enderror
            </div>

            {{-- Deskripsi --}}
            <div class="mb-4">
                <label for="description" class="block text-sm font-medium text-gray-700">Deskripsi</label>
                <textarea class="mt-1 form-control" wire:model.live='description' id="description" rows="3" placeholder="Masukkan deskripsi tindakan"></textarea>
                @error('description')
                    <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                @enderror
            </div>

            {{-- HPP & Harga --}}
            <div class="grid grid-cols-2 gap-4 mb-4">
                <div>
                    <label for="hpp_average" class="block text-sm font-medium text-gray-700">HPP Average <span class="text-red-600">*</span></label>
                    <div class="mt-1 flex rounded-md shadow-sm">
                        <span class="inline-flex items-center rounded-l-md border border-r-0 border-gray-300 bg-gray-100 px-3 text-gray-500 text-sm">Rp</span>
                        <input type="text" onkeyup="convertToRupiah(this)" wire:model.live='hpp_average' class="form-control rounded-l-none" placeholder="0" />
                    </div>
                    @error('hpp_average')
                        <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                    @enderror
                </div>
                <div>
                    <label for="price" class="block text-sm font-medium text-gray-700">Harga <span class="text-red-600">*</span></label>
                    <div class="mt-1 flex rounded-md shadow-sm">
                        <span class="inline-flex items-center rounded-l-md border border-r-0 border-gray-300 bg-gray-100 px-3 text-gray-500 text-sm">Rp</span>
                        <input type="text" onkeyup="convertToRupiah(this)" wire:model.live='price' class="form-control rounded-l-none" placeholder="0" />
                    </div>
                    @error('price')
                        <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            {{-- Insentif Default (Perawat & Dokter) --}}
            <div class="grid grid-cols-2 gap-4 mb-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700">Tipe Insentif Perawat</label>
                    <select id="type_incentive_nurse" wire:model.lazy="type_incentive_nurse" class="mt-1 form-control">
                        <option value="rupiah">Rupiah</option>
                        <option value="percentage">Persen</option>
                    </select>
                    @error('type_incentive_nurse')
                        <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                    @enderror
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700">Insentif Perawat / Terapis</label>
                    @if ($type_incentive_nurse == 'rupiah')
                        <input onkeyup="convertToRupiah(this);" type="text" wire:model.lazy="incentive_nurse" placeholder="Contoh : 100000" class="mt-1 form-control">
                    @else
                        <input type="number" wire:model.lazy="incentive_nurse" placeholder="Contoh : 10" class="mt-1 form-control">
                    @endif
                    @error('incentive_nurse')
                        <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                    @enderror
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700">Tipe Insentif Dokter <span class="text-xs text-gray-400">(default)</span></label>
                    <select id="type_incentive_doctor" wire:model.lazy="type_incentive_doctor" class="mt-1 form-control">
                        <option value="rupiah">Rupiah</option>
                        <option value="percentage">Persen</option>
                    </select>
                    @error('type_incentive_doctor')
                        <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                    @enderror
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700">Insentif Dokter <span class="text-xs text-gray-400">(default)</span></label>
                    @if ($type_incentive_doctor == 'rupiah')
                        <input onkeyup="convertToRupiah(this);" type="text" wire:model.lazy="incentive_doctor" placeholder="Contoh : 100000" class="mt-1 form-control">
                    @else
                        <input type="number" wire:model.lazy="incentive_doctor" placeholder="Contoh : 10" class="mt-1 form-control">
                    @endif
                    @error('incentive_doctor')
                        <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            {{-- Preview Kalkulasi Insentif Default --}}
            @if ($price && $incentive_doctor)
                <div class="mb-4 rounded-xl border border-blue-100 bg-blue-50 px-4 py-3 flex items-center justify-between gap-4">
                    <div class="flex items-center gap-2 text-blue-600">
                        <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 7h6m0 10v-3m-3 3h.01M9 17h.01M9 11h.01M12 11h.01M15 11h.01M4 19h16a2 2 0 002-2V7a2 2 0 00-2-2H4a2 2 0 00-2 2v10a2 2 0 002 2z" />
                        </svg>
                        <span class="text-sm font-medium">Kalkulasi Insentif Dokter (default)</span>
                    </div>
                    <div class="text-right">
                        <div class="text-xs text-blue-400 mb-0.5">
                            @if ($type_incentive_doctor === 'percentage')
                                Rp {{ $price }} × {{ $incentive_doctor }}%
                            @else
                                Nominal tetap
                            @endif
                        </div>
                        <div class="text-base font-bold text-blue-700">
                            Rp {{ number_format($doctorIncentiveCalculated, 0, ',', '.') }}
                            <span class="text-xs font-normal text-blue-400">/ tindakan</span>
                        </div>
                    </div>
                </div>
            @endif

            {{-- ===== Per-Doctor Incentive Section ===== --}}
            @if ($data_id)
                <div class="border rounded-xl overflow-hidden mb-2">
                    <div class="bg-gray-50 px-4 py-3 border-b flex items-center gap-2">
                        <svg class="w-4 h-4 text-indigo-500" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z" />
                        </svg>
                        <h3 class="text-sm font-semibold text-gray-700">Insentif Per-Dokter</h3>
                        <span class="text-xs text-gray-400">(override insentif default untuk dokter tertentu)</span>
                    </div>

                    {{-- Form tambah --}}
                    <div class="px-4 py-3 border-b bg-white">
                        <div class="grid grid-cols-12 gap-2 items-end">
                            <div class="col-span-5">
                                <label class="block text-xs text-gray-500 mb-1">Dokter</label>
                                <select wire:model="di_doctor_id" class="form-control text-sm">
                                    <option value="">-- Pilih Dokter --</option>
                                    @foreach ($doctors as $doc)
                                        <option value="{{ $doc->id }}">{{ $doc->name }}</option>
                                    @endforeach
                                </select>
                                @error('di_doctor_id')
                                    <p class="text-xs text-red-500 mt-0.5">{{ $message }}</p>
                                @enderror
                            </div>
                            <div class="col-span-3">
                                <label class="block text-xs text-gray-500 mb-1">Tipe</label>
                                <select wire:model.live="di_type" class="form-control text-sm">
                                    <option value="rupiah">Rupiah (Rp)</option>
                                    <option value="percentage">Persen (%)</option>
                                </select>
                            </div>
                            <div class="col-span-3">
                                <label class="block text-xs text-gray-500 mb-1">
                                    Nilai {{ $di_type === 'percentage' ? '(max 100%)' : '(Rp)' }}
                                </label>
                                @if ($di_type === 'rupiah')
                                    <input type="text" wire:model.blur="di_value" onkeyup="convertToRupiah(this)"
                                        class="form-control text-sm" placeholder="0">
                                @else
                                    <input type="number" wire:model="di_value" min="0" max="100"
                                        class="form-control text-sm" placeholder="0">
                                @endif
                                @error('di_value')
                                    <p class="text-xs text-red-500 mt-0.5">{{ $message }}</p>
                                @enderror
                            </div>
                            <div class="col-span-1">
                                <button wire:click="addDoctorIncentive"
                                    class="w-full h-9 bg-indigo-600 hover:bg-indigo-700 text-white rounded-lg text-sm flex items-center justify-center transition cursor-pointer"
                                    title="Tambah">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4" />
                                    </svg>
                                </button>
                            </div>
                        </div>
                    </div>

                    {{-- Tabel per-doctor --}}
                    <div class="overflow-x-auto">
                        <table class="w-full text-sm">
                            <thead class="bg-gray-50 text-xs text-gray-500 uppercase">
                                <tr>
                                    <th class="px-4 py-2 text-left">Dokter</th>
                                    <th class="px-4 py-2 text-center">Tipe</th>
                                    <th class="px-4 py-2 text-right">Nilai</th>
                                    <th class="px-4 py-2 text-right">≈ Rp / Tindakan</th>
                                    <th class="px-4 py-2 text-center">Hapus</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($doctor_incentives as $di)
                                    <tr class="border-t hover:bg-gray-50">
                                        <td class="px-4 py-2 font-medium text-gray-700">{{ $di['doctor_name'] }}</td>
                                        <td class="px-4 py-2 text-center">
                                            <span class="inline-block px-2 py-0.5 rounded text-xs
                                                {{ $di['type_incentive'] === 'percentage' ? 'bg-purple-100 text-purple-600' : 'bg-green-100 text-green-600' }}">
                                                {{ $di['type_incentive'] === 'percentage' ? '%' : 'Rp' }}
                                            </span>
                                        </td>
                                        <td class="px-4 py-2 text-right text-gray-700">
                                            @if ($di['type_incentive'] === 'percentage')
                                                {{ number_format($di['incentive_value'], 0, ',', '.') }}%
                                            @else
                                                Rp {{ number_format($di['incentive_value'], 0, ',', '.') }}
                                            @endif
                                        </td>
                                        <td class="px-4 py-2 text-right font-semibold text-indigo-700">
                                            Rp {{ number_format($di['calculated'], 0, ',', '.') }}
                                        </td>
                                        <td class="px-4 py-2 text-center">
                                            <button wire:click="removeDoctorIncentive('{{ $di['id'] }}')"
                                                class="text-red-500 hover:text-red-700 transition cursor-pointer">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                                </svg>
                                            </button>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5" class="px-4 py-4 text-center text-gray-400 text-xs italic">
                                            Belum ada insentif per-dokter. Semua dokter menggunakan nilai default.
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            @endif
        </div>

        <!-- Footer -->
        <div class="flex justify-end gap-2 px-6 py-4 border-t">
            <button wire:click="closeModal('modal')" class="px-4 py-2 bg-gray-200 hover:bg-gray-300 text-gray-800 rounded-lg shadow transition cursor-pointer">
                Batal
            </button>
            <button wire:click='save' class="px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-lg shadow transition">
                Simpan
            </button>
        </div>
    </div>
</div>
