<div>
    <div class="mb-4">
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-2xl font-bold text-[#1E3A8A]">Profile</h1>
            </div>
            <div>
                <button wire:click="submit" class="btn btn-primary">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                    </svg>
                    Ubah Profile
                </button>
            </div>
        </div>
    </div>
    <div class="grid grid-cols-2 gap-4 mb-4">
        <div class="mb-4">
            <label for="name" class="block text-sm font-medium text-gray-700">Nama User <span
                    class="text-red-600">*</span></label>
            <input id="name" type="name" wire:model.defer="name" placeholder="Contoh : Admin"
                class="mt-1 form-control">
            @error('name')
                <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
            @enderror
        </div>
        <div class="mb-4">
            <label for="identity_card" class="block text-sm font-medium text-gray-700">NIK </label>
            <input id="identity_card" type="identity_card" wire:model.defer="identity_card"
                placeholder="Contoh : 12345678" class="mt-1 form-control">
        </div>
        <div class="mb-4">
            <label for="email" class="block text-sm font-medium text-gray-700">Email</label>
            <input id="email" type="email" wire:model.defer="email" placeholder="Contoh : admin@gmail.com"
                class="mt-1 form-control">
            @error('email')
                <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
            @enderror
        </div>
        <div class="mb-4">
            <label for="phone" class="block text-sm font-medium text-gray-700">Nomor Telepon <span
                    class="text-red-600">*</span></label>
            <input id="phone" type="number" wire:model.defer="phone" placeholder="Contoh : 081234567890"
                class="mt-1 form-control">
            @error('phone')
                <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
            @enderror
        </div>
        <div class="md:col-span-2 mb-4">
            <label for="password" class="block text-sm font-medium text-gray-700">Password @if (!$data_id)
                    <span class="text-red-600">*</span>
                @else
                @endif
            </label>
            <div x-data="{ show: false }" class="relative">
                <input :type="show ? 'text' : 'password'" id="password" wire:model.defer="password"
                    placeholder="Contoh : 12345678" class="mt-1 form-control">

                <button type="button" @click="show = !show"
                    class="absolute inset-y-0 right-0 px-3 flex items-center text-gray-500" tabindex="-1">
                    <i :class="show ? 'fas fa-eye-slash' : 'fas fa-eye'"></i>
                </button>
            </div>

            @error('password')
                <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
            @enderror
        </div>
        <div class="mb-4">
            <label for="province_code" class="block text-sm font-medium text-gray-700">Provinsi </label>
            <div wire:key="select-{{ rand() }}">
                <select class="mt-1 form-control" x-data x-ref="input" x-init="$($refs.input).selectize({
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
            </div>
            @error('province_code')
                <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
            @enderror
        </div>
        <div class="mb-4">
            <label for="city_code" class="block text-sm font-medium text-gray-700">Kota </label>
            <div wire:key="select-{{ rand() }}">
                <select class="mt-1 form-control" x-data x-ref="input" x-init="$($refs.input).selectize({
                    dropdownParent: 'body',
                    allowClear: true,
                    plugins: ['clear_button'],
                    onChange: function(e) {
                        @this.set('city_code', e ? e : null);
                    }
                });"
                    wire:model.lazy="city_code" id="city_code">
                    <option value="">-- Pilih Kota --</option>
                    @foreach ($cities as $city)
                        <option value="{{ $city['code'] }}">{{ $city['name'] }}</option>
                    @endforeach
                </select>
            </div>
            @error('city_code')
                <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
            @enderror
        </div>
        <div class="mb-4">
            <label for="district_code" class="block text-sm font-medium text-gray-700">Kecamatan </label>
            <div wire:key="select-{{ rand() }}">
                <select class="mt-1 form-control" x-data x-ref="input" x-init="$($refs.input).selectize({
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
            </div>
            @error('district_code')
                <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
            @enderror
        </div>
        <div class="mb-4">
            <label for="sub_district_code" class="block text-sm font-medium text-gray-700">Kelurahan </label>
            <div wire:key="select-{{ rand() }}">
                <select class="mt-1 form-control" x-data x-ref="input" x-init="$($refs.input).selectize({
                    dropdownParent: 'body',
                    allowClear: true,
                    plugins: ['clear_button'],
                    onChange: function(e) {
                        @this.set('sub_district_code', e ? e : null);
                    }
                });"
                    wire:model.lazy="sub_district_code" id="sub_district_code">
                    <option value="">-- Pilih Kelurahan --</option>
                    @foreach ($subDistricts as $subDistrict)
                        <option value="{{ $subDistrict['code'] }}">{{ $subDistrict['name'] }}</option>
                    @endforeach
                </select>
            </div>
            @error('sub_district_code')
                <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
            @enderror
        </div>
    </div>
    <div class="grid grid-cols-2 gap-4">
        <div class="md:col-span-2 mb-4">
            <label for="address" class="block text-sm font-medium text-gray-700">Alamat <span
                    class="text-red-600">*</span></label>
            <textarea id="address" wire:model.defer="address" placeholder="Contoh : Jl. Raya No. 123"
                class="mt-1 form-control"></textarea>
            @error('address')
                <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
            @enderror
        </div>
        <div class="mb-4">
            <label for="rt_code" class="block text-sm font-medium text-gray-700">RT</label>
            <input autocomplete="false" id="rt_code" type="text" wire:model.defer="rt_code"
                placeholder="Contoh : 001" class="mt-1 form-control">
        </div>
        <div class="mb-4">
            <label for="rw_code" class="block text-sm font-medium text-gray-700">RW</label>
            <input autocomplete="false" id="rw_code" type="text" wire:model.defer="rw_code"
                placeholder="Contoh : 001" class="mt-1 form-control">
        </div>
        <div class="{{ $profile || $profile_old ? null : 'md:col-span-2' }} mb-4">
            <label class="block text-sm font-medium text-gray-700">Profile</label>

            <input type="file" wire:model.live="profile"
                class="block text-sm text-gray-500 w-full
                                           file:px-2 file:py-1 file:rounded-md
                                           file:border file:border-gray-300
                                           file:text-xs file:font-medium
                                           file:bg-blue-50 file:text-blue-700
                                           hover:file:bg-blue-100"
                accept="image/*" />
            <div wire:loading wire:target="profile" class="text-sm text-gray-500 mt-1">
                Uploading profile...
            </div>
            @error('profile')
                <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
            @enderror
        </div>
        @if ($profile)
            <div class="mt-4">
                <label class="block text-sm font-medium text-gray-700">Preview
                    Profile:</label>
                <img src="{{ $profile->temporaryUrl() }}" alt="Preview Profile"
                    class="h-20 w-auto rounded border shadow" />
            </div>
        @else
            @if ($profile_old)
                <div class="mt-4">
                    <label class="block text-sm font-medium text-gray-700">Preview
                        Profile:</label>
                    <img src="{{ asset('storage/' . $profile_old) }}" alt="Preview Profile"
                        class="h-20 w-auto rounded border shadow" />
                </div>
            @endif
        @endif
        <div class="mb-4">
            <label for="license_number" class="block text-sm font-medium text-gray-700">Nomor SIA</label>
            <input id="license_number" type="license_number" wire:model.defer="license_number"
                placeholder="Contoh : 12345678" class="mt-1 form-control">
            @error('license_number')
                <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
            @enderror
        </div>
        <div class="mb-4">
            <label for="identity_card" class="block text-sm font-medium text-gray-700">Golongan Darah </label>
            <select class="mt-1 form-control" wire:model='blood_group'>
                <option value="">Pilih Golongan Darah</option>
                <option value="A">A</option>
                <option value="B">B</option>
                <option value="AB">AB</option>
                <option value="O">O</option>
                <option value="Tidak Tahu">Tidak Tahu</option>
            </select>
        </div>
        <div class="mb-4">
            <label for="administrative_gender" class="block text-sm font-medium text-gray-700">Gender</label>
            <select id="administrative_gender" wire:model.defer="administrative_gender" class="mt-1 form-control">
                <option value="">Pilih Gender</option>
                @foreach ($administrativeGenderDetails as $administrativeGenderDetail)
                    <option value="{{ $administrativeGenderDetail['code'] }}">
                        {{ $administrativeGenderDetail['display'] }}</option>
                @endforeach
            </select>
            @error('administrative_gender')
                <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
            @enderror
        </div>
        <div class="mb-4">
            <label for="marital_status" class="block text-sm font-medium text-gray-700">Status
                Perkawinan</label>
            <select id="marital_status" wire:model.defer="marital_status" class="mt-1 form-control">
                <option value="">Pilih Status Perkawinan</option>
                @foreach ($maritalStatusDetails as $maritalStatusDetail)
                    <option value="{{ $maritalStatusDetail['code'] }}">
                        {{ $maritalStatusDetail['display_ind'] }}</option>
                @endforeach
            </select>
        </div>
        <div class="mb-4">
            <label for="birth_date" class="block text-sm font-medium text-gray-700">Tanggal Lahir</label>
            <input id="birth_date" type="date" wire:model.defer="birth_date" placeholder="Contoh : Jakarta"
                class="mt-1 form-control">
            @error('birth_date')
                <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
            @enderror
        </div>
        <div class="mb-4">
            <label for="deceased_date" class="block text-sm font-medium text-gray-700">Tanggal
                Kematian</label>
            <input id="deceased_date" type="date" wire:model.defer="deceased_date" placeholder="Contoh : Jakarta"
                class="mt-1 form-control">
            @error('deceased_date')
                <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
            @enderror
        </div>
    </div>
</div>
