<div wire:ignore.self id="modal"
    class="fixed inset-0 bg-overlay hidden items-center justify-center z-50 transition-opacity duration-300 ease-in-out">
    <div
        class="bg-white rounded-2xl shadow-2xl max-w-4xl w-full transform transition-all scale-95 duration-300 ease-out animate-fade-in">
        <!-- Header -->
        <div class="flex justify-between items-center p-6 border-b">
            <div class="flex items-center gap-4">
                <i class="fas fa-info-circle text-blue-500 text-xl"></i>
                <h2 class="text-xl font-semibold text-gray-800">Modal Transaksi</h2>
            </div>
            <div class="flex items-center gap-4">
                {{-- <div class="text-sm text-gray-500">
                    <span>2025-05-20 09:37:51</span>
                    <span class="mx-2">|</span>
                    <span class="font-medium">brehehe</span>
                </div> --}}
                <button wire:click="closeModal()"
                    class="text-gray-500 hover:text-red-500 transition-colors text-2xl leading-none cursor-pointer">
                    <i class="fas fa-times"></i>
                </button>
            </div>
        </div>

        <!-- Body -->
        <div class="px-6 py-4 text-gray-600" style="max-height: 70vh; overflow-y: auto;">
            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700">Tipe Transaksi</label>
                <div class="mt-1 flex gap-4">
                    <button
                        class="{{ $type == 'non-resep' ? 'bg-blue-500 text-white' : 'bg-white-200 border border-blue-400' }} px-4 py-2 rounded-lg flex items-center gap-4"
                        wire:click="$set('type', 'non-resep')">
                        <i class="fas fa-pills"></i>
                        <span>Non-Resep</span>
                    </button>
                    <button
                        class="{{ $type == 'resep' ? 'bg-blue-500 text-white' : 'bg-white-200 border border-blue-400' }} px-4 py-2 rounded-lg flex items-center gap-4"
                        wire:click="$set('type', 'resep')">
                        <i class="fas fa-prescription"></i>
                        <span>Resep</span>
                    </button>
                </div>
            </div>
            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700">Tipe Customer <span
                        class="text-red-600">*</span></label>
                <select wire:model.lazy='type_customer'
                    class="mt-1 block w-full rounded-md border-gray-300 px-4 py-2 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                    <option value="">Pilih Pelanggan</option>
                    <option value="umum">Umum</option>
                    <option value="new">Baru</option>
                    <option value="member">Terdaftar</option>
                </select>
                @error('type_customer')
                    <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                @enderror
            </div>
            @if ($type_customer == 'member')
                <div class="mb-4">
                    <div class="flex flex-col md:flex-row justify-between items-center mb-2 gap-2">
                        <label class="block text-sm font-medium text-gray-700">Pilih Pasien Terdaftar <span
                                class="text-red-600">*</span></label>
                        <div class="relative max-w-sm w-full">
                            <input type="text" wire:model.live.debounce.300ms="searchModalPatient" placeholder="Cari Nama / RM / Telp..."
                                class="block w-full pl-10 pr-4 py-2 border rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 text-sm">
                            <i class="fas fa-search absolute left-3 top-1/2 -translate-y-1/2 text-gray-400"></i>
                        </div>
                    </div>
                    
                    <div class="border rounded-lg overflow-hidden bg-white mt-2 relative">
                        <!-- Loading Indicator Overlay -->
                        <div wire:loading wire:target="searchModalPatient, patientPage" class="absolute inset-0 bg-white/70 backdrop-blur-sm z-10 flex items-center justify-center">
                            <div class="text-blue-600 flex flex-col items-center">
                                <i class="fas fa-spinner fa-spin text-2xl mb-1"></i>
                                <span class="text-xs font-semibold">Memuat Data...</span>
                            </div>
                        </div>

                        <div class="overflow-x-auto">
                            <table class="w-full text-sm text-left align-middle">
                                <thead class="bg-gray-50 border-b">
                                    <tr>
                                        <th class="py-2 px-4 font-semibold text-gray-600">No. RM</th>
                                        <th class="py-2 px-4 font-semibold text-gray-600">Nama Pasien</th>
                                        <th class="py-2 px-4 font-semibold text-gray-600 text-center w-28">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($patients as $patient)
                                        <tr class="border-b last:border-0 hover:bg-gray-50 {{ $patient_company_role_id == $patient->id ? 'bg-blue-50' : '' }}">
                                            <td class="py-2 px-4 text-gray-800">{{ $patient?->medical_record_number }}</td>
                                            <td class="py-2 px-4 text-gray-800 font-medium">
                                                {{ $patient?->user?->name ?? 'Unknown' }}
                                                <div class="text-xs text-gray-500 font-normal">{{ $patient?->user?->phone ?? '-' }}</div>
                                            </td>
                                            <td class="py-2 px-4 text-center">
                                                @if($patient_company_role_id == $patient->id)
                                                    <span class="inline-flex items-center px-2 py-1 rounded bg-green-100 text-green-700 text-xs font-medium border border-green-200">
                                                        <i class="fas fa-check-circle mr-1"></i> Terpilih
                                                    </span>
                                                @else
                                                    <button type="button" wire:click="$set('patient_company_role_id', '{{ $patient->id }}')" 
                                                        class="px-3 py-1 bg-white border border-blue-600 text-blue-600 rounded hover:bg-blue-50 text-xs transition duration-150">
                                                        Pilih
                                                    </button>
                                                @endif
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="3" class="py-4 text-center text-gray-500 text-sm">
                                                Tidak ada data pasien ditemukan.
                                            </td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                    
                    @if(method_exists($patients, 'links'))
                        <div class="mt-3">
                            {{ $patients->links('vendor.livewire.custom', ['pageName' => 'patientPage']) }}
                        </div>
                    @endif

                    @error('patient_company_role_id')
                        <p class="text-sm text-red-600 mt-2"><i class="fas fa-exclamation-circle mr-1"></i> {{ $message }}</p>
                    @enderror
                </div>
            @elseif($type_customer == 'new')
                <div class="grid grid-cols-3 gap-4">
                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700">Nama <span
                                class="text-red-600">*</span></label>
                        <input type="text" wire:model.lazy='patient_name' placeholder="Nama Pasien"
                            class="mt-1 block w-full rounded-md border-gray-300 px-4 py-2 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                        @error('patient_name')
                            <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700">No. Telepon <span
                                class="text-red-600">*</span></label>
                        <input type="number" wire:model.lazy='patient_phone' placeholder="No. Telepon Pasien"
                            class="mt-1 block w-full rounded-md border-gray-300 px-4 py-2 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                        @error('patient_phone')
                            <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700">Gender</label>
                        <select wire:model.lazy='patient_gender'
                            class="mt-1 block w-full rounded-md border-gray-300 px-4 py-2 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                            <option value="">Pilih Gender</option>
                            @foreach ($genders as $gender)
                                <option value="{{ $gender['code'] }}">{{ $gender['display'] }}</option>
                            @endforeach
                        </select>
                        @error('patient_gender')
                            <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                    <div class="mb-4 md:col-span-3">
                        <label class="block text-sm font-medium text-gray-700">Alamat <span
                                class="text-red-600">*</span></label>
                        <textarea wire:model.lazy='patient_address' placeholder="Alamat Pasien"
                            class="mt-1 block w-full rounded-md border-gray-300 px-4 py-2 shadow-sm focus:border-blue-500 focus:ring-blue-500"></textarea>
                        @error('patient_address')
                            <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
            @elseif ($type_customer == 'umum')
                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700">Nama <span
                            class="text-red-600">*</span></label>
                    <input type="text" wire:model.lazy='patient_name' placeholder="Umum"
                        class="mt-1 block w-full rounded-md border-gray-300 px-4 py-2 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                    @error('patient_name')
                        <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                    @enderror
                </div>
            @endif
            @if ($type == 'resep')
                <div class="grid grid-cols-2 gap-4 mb-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Nomor Resep <span
                                class="text-red-600">*</span></label>
                        <input type="text" wire:model.lazy='number_recipe' placeholder="Nomor Resep"
                            class="mt-1 block w-full rounded-md border-gray-300 px-4 py-2 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                        @error('number_recipe')
                            <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Tipe Dokter <span
                                class="text-red-600">*</span></label>
                        <select wire:model.lazy='type_doctor'
                            class="mt-1 block w-full rounded-md border-gray-300 px-4 py-2 shadow-sm focus:border-blue-500 focus:ring-blue-500"
                            style="height: 38px">
                            <option value="">Pilih Dokter</option>
                            <option value="old">Lama</option>
                            <option value="new">Baru</option>
                        </select>
                        @error('type_doctor')
                            <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
                @if ($type_doctor == 'old')
                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700">Pilih Dokter <span
                                class="text-red-600">*</span></label>
                        <div wire:key="select-{{ rand() }}">
                            <select x-data x-ref="input" x-init="$($refs.input).selectize({
                                dropdownParent: 'body',
                                allowClear: true,
                                {{-- plugins: ['clear_button'], --}}
                                onChange: function(e) {
                                    @this.set('doctor_id', e ? e : null);
                                }
                            });" wire:model.live="doctor_id"
                                id="doctor_id">
                                <option value="">-- Pilih Dokter --</option>
                                @foreach ($doctors as $doctor)
                                    <option value="{{ $doctor['id'] }}">{{ $doctor['name'] }} -
                                        {{ $doctor['specialization'] }} ({{ $doctor['type'] }})</option>
                                @endforeach
                            </select>
                        </div>
                        @error('doctor_id')
                            <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                @elseif ($type_doctor == 'new')
                    <div class="grid grid-cols-2 gap-4">
                        <div class="mb-4">
                            <label class="block text-sm font-medium text-gray-700">Nama Dokter <span
                                    class="text-red-600">*</span></label>
                            <input type="text" wire:model.lazy='name_doctor' placeholder="Nama Dokter"
                                class="mt-1 block w-full rounded-md border-gray-300 px-4 py-2 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                            @error('name_doctor')
                                <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                        <div class="mb-4">
                            <label class="block text-sm font-medium text-gray-700">Spesialis</label>
                            <input type="text" wire:model.lazy='specialization' placeholder="Spesialis Dokter"
                                class="mt-1 block w-full rounded-md border-gray-300 px-4 py-2 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                            @error('specialization')
                                <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                        <div class="mb-4 md:col-span-2">
                            <label class="block text-sm font-medium text-gray-700">Rumah Sakit / Klinik</label>
                            <input type="text" wire:model.lazy='hospital'
                                placeholder="Rumah Sakit / Klinik Dokter"
                                class="mt-1 block w-full rounded-md border-gray-300 px-4 py-2 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                            @error('hospital')
                                <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                @endif
            @endif
            <!-- Notes -->
            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700">Catatan</label>
                <textarea rows="3" placeholder="Tambahkan catatan jika diperlukan"
                    class="mt-1 block w-full rounded-md border-gray-300 px-4 py-2 shadow-sm focus:border-blue-500 focus:ring-blue-500"></textarea>
            </div>
        </div>

        <!-- Footer -->
        <div class="flex justify-between items-center px-6 py-4 border-t bg-gray-50">
            <div class="text-sm text-gray-500">
                <span class="font-medium">Status:</span>
                <span class="ml-1 px-2 py-1 bg-yellow-100 text-yellow-800 rounded-full text-xs">Draft</span>
            </div>
            <div class="flex gap-4">
                <button wire:click="closeModal()" wire:loading.attr="disabled" wire:target="saveTransaction"
                    class="px-4 py-2 bg-gray-200 hover:bg-gray-300 text-gray-800 rounded-lg shadow transition cursor-pointer">
                    <i class="fas fa-times mr-2"></i>Batal
                </button>
                <button wire:click='saveTransaction()' wire:loading.attr="disabled" wire:target="saveTransaction"
                    class="px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-lg shadow transition">
                    <span wire:loading.remove wire:target="saveTransaction">
                        <i class="fas fa-save mr-2"></i>Simpan
                    </span>
                    <span wire:loading wire:target="saveTransaction">
                        <i class="fas fa-spinner fa-spin mr-2"></i>Menyimpan...
                    </span>
                </button>
            </div>
        </div>
    </div>
</div>

<div wire:ignore.self id="modalCash"
    class="fixed inset-0 bg-overlay hidden items-center justify-center z-50 transition-opacity duration-300 ease-in-out">
    <div
        class="bg-white rounded-2xl shadow-2xl max-w-4xl w-full transform transition-all scale-95 duration-300 ease-out animate-fade-in">
        <!-- Header -->
        <div class="flex justify-between items-center p-6 border-b">
            <div class="flex items-center gap-4">
                <i class="fas fa-info-circle text-blue-500 text-xl"></i>
                <h2 class="text-xl font-semibold text-gray-800">Modal Cash</h2>
            </div>
        </div>
        <div class="px-6 py-4 text-gray-600" style="max-height: 70vh; overflow-y: auto;">
            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700">Deskripsi <span
                        class="text-red-600">*</span></label>
                <input type="text" wire:model.lazy='description' placeholder="Deskripsi"
                    class="mt-1 block w-full rounded-md border-gray-300 px-4 py-2 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                @error('description')
                    <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                @enderror
            </div>
            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700">Total Cash <span
                        class="text-red-600">*</span></label>
                <input type="text" onkeyup="convertToRupiah(this)" wire:model.lazy='amount'
                    placeholder="Masukan Total Cash"
                    class="mt-1 block w-full rounded-md border-gray-300 px-4 py-2 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                @error('amount')
                    <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                @enderror
            </div>
        </div>
        <div class="flex justify-between items-center px-6 py-4 border-t bg-gray-50">
            {{-- <div class="text-sm text-gray-500">
                <span class="font-medium">Status:</span>
                <span class="ml-1 px-2 py-1 bg-yellow-100 text-yellow-800 rounded-full text-xs">Draft</span>
            </div> --}}
            <div class="flex gap-4">
                {{-- <button wire:click="closeModal()" wire:loading.attr="disabled" wire:target="saveTransaction" class="px-4 py-2 bg-gray-200 hover:bg-gray-300 text-gray-800 rounded-lg shadow transition cursor-pointer">
                    <i class="fas fa-times mr-2"></i>Batal
                </button> --}}
                <button wire:click='submitCashBank()' wire:loading.attr="disabled" wire:target="submitCashBank"
                    class="px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-lg shadow transition">
                    <span wire:loading.remove wire:target="submitCashBank">
                        <i class="fas fa-save mr-2"></i>Simpan
                    </span>
                    <span wire:loading wire:target="submitCashBank">
                        <i class="fas fa-spinner fa-spin mr-2"></i>Menyimpan...
                    </span>
                </button>
            </div>
        </div>
    </div>
</div>
