<div>
    {{-- Because she competes with no one, no one can compete with her. --}}
    <div class="min-h-dvh bg-white">
    {{-- HEADER --}}
        <div class="sticky top-0 z-40 bg-white/95 backdrop-blur border-b border-slate-100">
            <div class="px-5 sm:px-6 h-14 flex items-center gap-3">
                <a href="{{ route('mobile.queue.register') }}">
                    <button type="button"
                            wire:click="back"
                            class="w-9 h-9 rounded-full bg-slate-100 text-slate-700 flex items-center justify-center
                                active:scale-[0.98] transition"
                            aria-label="Back">
                        <svg class="w-5 h-5" viewBox="0 0 24 24" fill="none">
                            <path d="M15 18l-6-6 6-6" stroke="currentColor" stroke-width="2"
                                stroke-linecap="round" stroke-linejoin="round"/>
                        </svg>
                    </button>
                </a>
                <div class="font-extrabold text-slate-900">Tambah Pasien</div>
            </div>
        </div>

        @php
            // helper class (biar konsisten)
            $label = 'text-[12px] font-extrabold text-slate-900';
            $req = '<span class="text-rose-500">*</span>';

            $inputBase = 'w-full h-12 rounded-xl border border-sky-300 bg-white px-4 text-sm text-slate-800
                        placeholder:text-slate-400 outline-none
                        focus:ring-2 focus:ring-sky-400 focus:border-sky-200';

            $inputBlue = 'bg-sky-400'; // untuk field yang read-only (RM)
        @endphp

        {{-- CONTENT --}}
        <div class="px-5 sm:px-6 py-5 pb-28 space-y-4">
            {{-- No. Rekam Medis --}}
            {{-- <div class="space-y-2">
                <label class="{{ $label }}">No. Rekam Medis</label>
                <input type="text"
                    wire:model.defer="no_rm"
                    class="{{ $inputBase }} {{ $inputBlue }}"
                    placeholder="RM21285-101223/015"
                    readonly>
            </div> --}}

            {{-- Nama Lengkap --}}
            <div class="space-y-2">
                <label class="{{ $label }}">Nama Lengkap {!! $req !!}</label>
                <input type="text"
                    wire:model.defer="name"
                    class="{{ $inputBase }}"
                    placeholder="Masukkan Nama Lengkap">
                    @error('name')
                        <p class="text-xs text-red-600">{{ $message }}</p>
                    @enderror
            </div>

            {{-- NIK / NIK Ibu --}}
            <div class="space-y-2">
                <div class="flex items-center justify-between">
                    <label class="{{ $label }}">
                        {{ $identity_card_mother ? 'NIK Ibu' : 'NIK' }} {!! $req !!}
                    </label>

                    <label class="inline-flex items-center gap-2 text-xs font-semibold text-slate-600 select-none cursor-pointer">
                        <input type="checkbox"
                            wire:model.live="identity_card_mother"
                            class="sr-only peer">

                        <span class="relative w-11 h-6 rounded-full bg-slate-200 transition peer-checked:bg-sky-400
                                    after:content-[''] after:absolute after:top-1 after:left-1 after:w-4 after:h-4
                                    after:rounded-full after:bg-white after:shadow after:transition
                                    peer-checked:after:translate-x-5">
                        </span>

                        <span>Gunakan NIK Ibu</span>
                    </label>
                </div>

                <input type="text"
                    wire:model.defer="identity_card"
                    class="{{ $inputBase }}"
                    placeholder="{{ $identity_card_mother ? 'Masukkan NIK Ibu' : 'Masukkan No NIK' }}">
                @error('identity_card')
                    <p class="text-xs text-red-600">{{ $message }}</p>
                @enderror
            </div>

            {{-- Email --}}
            <div class="space-y-2">
                <label class="{{ $label }}">Email </label>
                <input type="email"
                    wire:model.defer="email"
                    class="{{ $inputBase }}"
                    placeholder="Masukkan Email">
                @error('email')
                    <p class="text-xs text-red-600">{{ $message }}</p>
                @enderror
            </div>

            {{-- No. Handphone --}}
            <div class="space-y-2">
                <label class="{{ $label }}">No. Handphone {!! $req !!}</label>
                <input type="number"
                    wire:model.defer="phone"
                    class="{{ $inputBase }}"
                    placeholder="Masukkan No. Handphone">
                @error('phone')
                    <p class="text-xs text-red-600">{{ $message }}</p>
                @enderror
            </div>

            {{-- Tanggal Lahir + Usia --}}
            <div class="space-y-2">
                <label class="{{ $label }}">Tanggal Lahir {!! $req !!}</label>
                <input type="date"
                    wire:model.lazy="birth_date"
                    class="{{ $inputBase }}"
                    placeholder="dd/mm/yyyy">
                @error('birth_date')
                    <p class="text-xs text-red-600">{{ $message }}</p>
                @enderror
            </div>
            {{-- <div class="grid grid-cols-2 gap-4">

                <div class="space-y-2">
                    <label class="{{ $label }}">Usia</label>

                    <div class="relative">
                        <input type="number"
                            inputmode="numeric"
                            wire:model.defer="age"
                            class="{{ $inputBase }} pr-20 {{ $inputBlue }}"
                            placeholder="42"
                            min="0" readonly>

                        <span class="pointer-events-none absolute right-3 top-1/2 -translate-y-1/2
                                    text-sm font-bold text-slate-500">
                            Tahun
                        </span>
                        @error('age')
                            <p class="text-xs text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
            </div> --}}

            {{-- Status Pasien Dalam Keluarga --}}
            <div class="space-y-2">
                <label class="{{ $label }}">Status Pasien Dalam Keluarga {!! $req !!}</label>
                <div class="relative">
                    <select wire:model.defer="family_status" class="{{ $inputBase }} pr-10 appearance-none">
                        <option value="" selected style="display: none">Pilih Salah Satu</option>
                        <option value="istri">Istri</option>
                        <option value="suami">Suami</option>
                        <option value="anak">Anak</option>
                        <option value="ayah">Ayah</option>
                        <option value="ibu">Ibu</option>
                        <option value="kakek">Kakek</option>
                        <option value="nenek">Nenek</option>
                        <option value="saudara">Saudara</option>
                    </select>
                    <span class="pointer-events-none absolute right-3 top-1/2 -translate-y-1/2 text-slate-500">
                        <svg class="w-5 h-5" viewBox="0 0 24 24" fill="none">
                            <path d="M6 9l6 6 6-6" stroke="currentColor" stroke-width="2"
                                stroke-linecap="round" stroke-linejoin="round"/>
                        </svg>
                    </span>
                    @error('family_status')
                        <p class="text-xs text-red-600">{{ $message }}</p>
                    @enderror
                </div>
            </div>
            <div class="space-y-2">
                <label class="{{ $label }}">Status Perkawinan</label>
                <div class="relative">
                    <select wire:model.defer="marital_status" class="{{ $inputBase }} pr-10 appearance-none">
                        <option value="" selected style="display: none">Pilih Salah Satu</option>
                        @foreach ($maritalStatusDetails as $maritalStatusDetail)
                            <option value="{{ $maritalStatusDetail['code'] }}"> {{ $maritalStatusDetail['display_ind'] }}</option>
                        @endforeach
                    </select>
                    <span class="pointer-events-none absolute right-3 top-1/2 -translate-y-1/2 text-slate-500">
                        <svg class="w-5 h-5" viewBox="0 0 24 24" fill="none">
                            <path d="M6 9l6 6 6-6" stroke="currentColor" stroke-width="2"
                                stroke-linecap="round" stroke-linejoin="round"/>
                        </svg>
                    </span>
                    @error('age')
                        <p class="text-xs text-red-600">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            {{-- Jenis Kelamin + Agama --}}
            <div class="grid grid-cols-2 gap-4">
                <div class="space-y-2">
                    <label class="{{ $label }}">Jenis Kelamin {!! $req !!}</label>
                    <div class="relative">
                        <select wire:model.defer="administrative_gender" class="{{ $inputBase }} pr-10 appearance-none">
                            <option value="" selected style="display: none">Pilih Salah Satu</option>
                            @foreach ($administrativeGenderDetails as $administrativeGenderDetail)
                                <option value="{{ $administrativeGenderDetail['code'] }}">{{ $administrativeGenderDetail['display'] }}</option>
                            @endforeach
                        </select>
                        <span class="pointer-events-none absolute right-3 top-1/2 -translate-y-1/2 text-slate-500">
                            <svg class="w-5 h-5" viewBox="0 0 24 24" fill="none">
                                <path d="M6 9l6 6 6-6" stroke="currentColor" stroke-width="2"
                                    stroke-linecap="round" stroke-linejoin="round"/>
                            </svg>
                        </span>
                    </div>
                    @error('administrative_gender')
                        <p class="text-xs text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Golongan Darah --}}
                <div class="space-y-2">
                    <label class="{{ $label }}">Golongan Darah</label>
                    <div class="relative">
                        <select wire:model.defer="blood_group" class="{{ $inputBase }} pr-10 appearance-none">
                            <option value="" selected style="display: none">Pilih Salah Satu</option>
                            <option value="A">A</option>
                            <option value="B">B</option>
                            <option value="AB">AB</option>
                            <option value="O">O</option>
                            <option value="Tidak Tahu">Tidak Tahu</option>
                        </select>
                        <span class="pointer-events-none absolute right-3 top-1/2 -translate-y-1/2 text-slate-500">
                            <svg class="w-5 h-5" viewBox="0 0 24 24" fill="none">
                                <path d="M6 9l6 6 6-6" stroke="currentColor" stroke-width="2"
                                    stroke-linecap="round" stroke-linejoin="round"/>
                            </svg>
                        </span>
                        @error('blood_group')
                            <p class="text-xs text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
            </div>


            {{-- PROVINSI --}}
            <div class="grid grid-cols-2 gap-4">
                <div class="space-y-2">
                    <label class="{{ $label }}">Provinsi {!! $req !!}</label>
                    <div class="relative" wire:key="select-{{ rand() }}">
                        <select class="{{ $inputBase }} pr-10 appearance-none" x-data x-ref="input" x-init="$($refs.input).selectize({
                            dropdownParent: 'body',
                            allowClear: true,
                            plugins: ['clear_button'],
                            onChange: function(e) {
                                @this.set('province_code', e ? e : null);
                            }
                        });"
                            wire:model.lazy="province_code" id="province_code">
                            <option value="">-- Pilih Provinsi --</option>
                            @foreach ($provinces as $province)
                                <option value="{{ $province['code'] }}">{{ $province['name'] }}</option>
                            @endforeach
                        </select>
                        <span class="pointer-events-none absolute right-3 top-1/2 -translate-y-1/2 text-slate-500">
                            <svg class="w-5 h-5" viewBox="0 0 24 24" fill="none">
                                <path d="M6 9l6 6 6-6" stroke="currentColor" stroke-width="2"
                                    stroke-linecap="round" stroke-linejoin="round"/>
                            </svg>
                        </span>
                    </div>
                    @error('province_code')
                        <p class="text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
                <div class="space-y-2">
                    <label class="{{ $label }}">Kota/Kabupaten {!! $req !!}</label>
                    <div class="relative" wire:key="select-{{ rand() }}">
                        <select class="{{ $inputBase }} pr-10 appearance-none" x-data x-ref="input" x-init="$($refs.input).selectize({
                            dropdownParent: 'body',
                            allowClear: true,
                            plugins: ['clear_button'],
                            onChange: function(e) {
                                @this.set('city_code', e ? e : null);
                            }
                        });"
                            wire:model.lazy="city_code" id="city_code">
                            <option value="">-- Pilih Kota/Kabupaten --</option>
                            @foreach ($cities as $city)
                                <option value="{{ $city['code'] }}">{{ $city['name'] }}</option>
                            @endforeach
                        </select>
                        <span class="pointer-events-none absolute right-3 top-1/2 -translate-y-1/2 text-slate-500">
                            <svg class="w-5 h-5" viewBox="0 0 24 24" fill="none">
                                <path d="M6 9l6 6 6-6" stroke="currentColor" stroke-width="2"
                                    stroke-linecap="round" stroke-linejoin="round"/>
                            </svg>
                        </span>
                    </div>
                    @error('city_code')
                        <p class="text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
                <div class="space-y-2">
                    <label class="{{ $label }}">Kecamatan {!! $req !!}</label>
                    <div class="relative" wire:key="select-{{ rand() }}">
                        <select class="{{ $inputBase }} pr-10 appearance-none" x-data x-ref="input" x-init="$($refs.input).selectize({
                            dropdownParent: 'body',
                            allowClear: true,
                            plugins: ['clear_button'],
                            onChange: function(e) {
                                @this.set('district_code', e ? e : null);
                            }
                        });"
                            wire:model.lazy="district_code" id="district_code">
                            <option value="">-- Pilih Kecamatan --</option>
                            @foreach ($districts as $district)
                                <option value="{{ $district['code'] }}">{{ $district['name'] }}</option>
                            @endforeach
                        </select>
                        <span class="pointer-events-none absolute right-3 top-1/2 -translate-y-1/2 text-slate-500">
                            <svg class="w-5 h-5" viewBox="0 0 24 24" fill="none">
                                <path d="M6 9l6 6 6-6" stroke="currentColor" stroke-width="2"
                                    stroke-linecap="round" stroke-linejoin="round"/>
                            </svg>
                        </span>
                    </div>
                    @error('district_code')
                        <p class="text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
                <div class="space-y-2">
                    <label class="{{ $label }}">Kelurahan {!! $req !!}</label>
                    <div class="relative" wire:key="select-{{ rand() }}">
                        <select class="{{ $inputBase }} pr-10 appearance-none" x-data x-ref="input" x-init="$($refs.input).selectize({
                            dropdownParent: 'body',
                            allowClear: true,
                            plugins: ['clear_button'],
                            onChange: function(e) {
                                @this.set('sub_district_code', e ? e : null);
                            }
                        });"
                            wire:model.lazy="sub_district_code" id="sub_district_code">
                            <option value="">-- Pilih Kecamatan --</option>
                            @foreach ($subDistricts as $sub_district)
                                <option value="{{ $sub_district['code'] }}">{{ $sub_district['name'] }}</option>
                            @endforeach
                        </select>
                        <span class="pointer-events-none absolute right-3 top-1/2 -translate-y-1/2 text-slate-500">
                            <svg class="w-5 h-5" viewBox="0 0 24 24" fill="none">
                                <path d="M6 9l6 6 6-6" stroke="currentColor" stroke-width="2"
                                    stroke-linecap="round" stroke-linejoin="round"/>
                            </svg>
                        </span>
                    </div>
                    @error('sub_district_code')
                        <p class="text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            {{-- Alamat --}}
            <div class="space-y-2">
                <label class="{{ $label }}">Alamat {!! $req !!}</label>
                <textarea rows="10" wire:model.defer="address" class="{{ $inputBase }} h-28 resize-none pt-2" placeholder="Contoh : Jl. Raya No. 123"></textarea>
                @error('address')
                    <p class="text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            {{-- RW + RT + kode pos--}}
            <div class="grid grid-cols-3 gap-4">
                <div class="space-y-2">
                    <label class="{{ $label }}">Kode Pos {!! $req !!}</label>
                    <input type="number"
                        wire:model.defer="postal_code"
                        class="{{ $inputBase }}"
                        placeholder="Masukkan Kode Pos">
                    @error('postal_code')
                        <p class="text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div class="space-y-2">
                    <label class="{{ $label }}">RT {!! $req !!}</label>
                    <input type="text"
                        wire:model.defer="rt_code"
                        class="{{ $inputBase }}"
                        placeholder="Masukkan RT">
                    @error('rt_code')
                        <p class="text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div class="space-y-2">
                    <label class="{{ $label }}">RW {!! $req !!}</label>
                    <input type="text"
                        wire:model.defer="rw_code"
                        class="{{ $inputBase }}"
                        placeholder="Masukkan RW">
                    @error('rw_code')
                        <p class="text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
            </div>
        </div>

        {{-- FOOTER BUTTON (sticky bottom) --}}
        <div class="fixed inset-x-0 bottom-0 z-50 bg-white/85 backdrop-blur border-t border-slate-100">
            <div class="pb-[max(env(safe-area-inset-bottom),0.75rem)]"></div>
            <div class="px-5 sm:px-6 py-3">
                <button type="button"
                        wire:click="submit"
                        class="w-full h-12 rounded-2xl bg-sky-400 text-white font-extrabold
                            shadow-[0_18px_40px_rgba(14,165,233,0.25)]
                            active:scale-[0.99] transition">
                    Simpan
                </button>
            </div>
        </div>
    </div>
</div>
@push('scripts')
    {{-- Helper Alpine component (taruh sekali di bawah view / @push('scripts')) --}}
@endpush
