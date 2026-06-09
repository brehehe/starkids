<div>
    <div class="mb-4">
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-2xl font-bold text-[#1E3A8A]">Neraca Keuangan</h1>
            </div>
        </div>
    </div>

    {{-- Statistics Cards --}}
    <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-6">
        <div class="bg-gradient-to-br from-blue-500 to-blue-600 rounded-xl shadow-lg p-6 text-white">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-blue-100 text-sm font-medium">Total Aktiva</p>
                    <h3 class="text-2xl font-bold mt-2">Rp {{ number_format($this->totalAssets, 0, ',', '.') }}</h3>
                </div>
                <div class="bg-white/20 rounded-full p-4">
                    <i class="fas fa-building text-2xl"></i>
                </div>
            </div>
        </div>

        <div class="bg-gradient-to-br from-red-500 to-red-600 rounded-xl shadow-lg p-6 text-white">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-red-100 text-sm font-medium">Total Kewajiban</p>
                    <h3 class="text-2xl font-bold mt-2">Rp {{ number_format($this->totalLiabilities, 0, ',', '.') }}</h3>
                </div>
                <div class="bg-white/20 rounded-full p-4">
                    <i class="fas fa-file-invoice-dollar text-2xl"></i>
                </div>
            </div>
        </div>

        <div class="bg-gradient-to-br from-purple-500 to-purple-600 rounded-xl shadow-lg p-6 text-white">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-purple-100 text-sm font-medium">Total Modal</p>
                    <h3 class="text-2xl font-bold mt-2">Rp {{ number_format($this->totalEquity, 0, ',', '.') }}</h3>
                </div>
                <div class="bg-white/20 rounded-full p-4">
                    <i class="fas fa-wallet text-2xl"></i>
                </div>
            </div>
        </div>

        <div class="bg-gradient-to-br from-{{ $this->balanceStatus['is_balanced'] ? 'green' : 'orange' }}-500 to-{{ $this->balanceStatus['is_balanced'] ? 'green' : 'orange' }}-600 rounded-xl shadow-lg p-6 text-white">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-white/90 text-sm font-medium">Status Neraca</p>
                    <h3 class="text-xl font-bold mt-2">{{ $this->balanceStatus['is_balanced'] ? 'Seimbang' : 'Tidak Seimbang' }}</h3>
                    @if(!$this->balanceStatus['is_balanced'])
                        <p class="text-xs mt-1">Selisih: Rp {{ number_format(abs($this->balanceStatus['difference']), 0, ',', '.') }}</p>
                    @endif
                </div>
                <div class="bg-white/20 rounded-full p-4">
                    <i class="fas fa-{{ $this->balanceStatus['is_balanced'] ? 'check-circle' : 'exclamation-triangle' }} text-2xl"></i>
                </div>
            </div>
        </div>
    </div>

    {{-- Filters --}}
    <div class="bg-white/80 backdrop-blur-sm rounded-xl shadow-lg border border-gray-100 p-4 mb-4">
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Dari Tanggal</label>
                <input type="date" wire:model.live="start_date" class="form-control" />
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Sampai Tanggal</label>
                <input type="date" wire:model.live="end_date" class="form-control" />
            </div>
            <div class="flex items-end">
                <button wire:click="resetFilters" class="btn btn-secondary w-full">
                    <i class="fas fa-redo mr-2"></i> Reset Filter
                </button>
            </div>
        </div>
    </div>

    {{-- Standard Accounting Format Balance Sheet --}}
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-6">
        {{-- ASSETS Section --}}
        <div class="bg-white rounded-xl shadow-lg border border-gray-100 overflow-hidden">
            <div class="bg-gradient-to-r from-blue-600 to-blue-700 text-white px-6 py-4">
                <h2 class="text-xl font-bold">AKTIVA</h2>
            </div>

            <div class="p-6">
                @foreach ($detailCategoryAccounts as $index => $detailCategoryAccount)
                    @php
                        $categoryName = strtolower($detailCategoryAccount);
                    @endphp

                    @if(strpos($categoryName, 'aktiva') !== false)
                        {{-- Main Category Header --}}
                        <div class="mb-4">
                            <div class="flex justify-between items-center bg-blue-50 px-4 py-3 rounded-lg mb-2">
                                <h3 class="font-bold text-blue-900 text-lg">{{ $detailCategoryAccount }}</h3>
                                <span class="font-bold text-blue-900">Rp {{ number_format(abs($detailCategoryTotals[$index]['balance'] ?? 0), 0, ',', '.') }}</span>
                            </div>

                            {{-- Sub Categories --}}
                            @if(isset($categoryAccounts[$index]))
                                <div class="ml-4 space-y-2">
                                    @foreach ($categoryAccounts[$index] as $key => $categoryAccount)
                                        <div class="border-l-2 border-blue-200 pl-4">
                                            <div class="flex justify-between items-center py-2">
                                                <span class="font-semibold text-gray-700">{{ $categoryAccount }}</span>
                                                <span class="font-semibold text-gray-900">Rp {{ number_format(abs($categoryAccountTotals[$index][$key]['balance'] ?? 0), 0, ',', '.') }}</span>
                                            </div>

                                            {{-- Individual Accounts --}}
                                            @if(isset($accounts[$index][$key]))
                                                <div class="ml-4 space-y-1">
                                                    @foreach ($accounts[$index][$key] as $key_account => $account)
                                                        <div class="flex justify-between items-center text-sm py-1">
                                                            <span class="text-gray-600">{{ $account }}</span>
                                                            <span class="text-gray-700">Rp {{ number_format(abs($accountTotals[$index][$key][$key_account]['balance'] ?? 0), 0, ',', '.') }}</span>
                                                        </div>
                                                    @endforeach
                                                </div>
                                            @endif
                                        </div>
                                    @endforeach
                                </div>
                            @endif
                        </div>
                    @endif
                @endforeach

                {{-- Total Assets --}}
                <div class="border-t-2 border-blue-900 mt-4 pt-4">
                    <div class="flex justify-between items-center">
                        <h3 class="font-bold text-blue-900 text-lg">TOTAL AKTIVA</h3>
                        <span class="font-bold text-blue-900 text-xl">Rp {{ number_format(abs($this->totalAssets), 0, ',', '.') }}</span>
                    </div>
                </div>
            </div>
        </div>

        {{-- LIABILITIES + EQUITY Section --}}
        <div class="bg-white rounded-xl shadow-lg border border-gray-100 overflow-hidden">
            <div class="bg-gradient-to-r from-purple-600 to-purple-700 text-white px-6 py-4">
                <h2 class="text-xl font-bold">KEWAJIBAN & MODAL</h2>
            </div>

            <div class="p-6">
                {{-- LIABILITIES --}}
                <div class="mb-6">
                    <h3 class="font-bold text-red-700 text-lg mb-3 pb-2 border-b border-red-200">KEWAJIBAN</h3>

                    @foreach ($detailCategoryAccounts as $index => $detailCategoryAccount)
                        @php
                            $categoryName = strtolower($detailCategoryAccount);
                        @endphp

                        @if(strpos($categoryName, 'kewajiban') !== false)
                            <div class="mb-4">
                                <div class="flex justify-between items-center bg-red-50 px-4 py-3 rounded-lg mb-2">
                                    <h4 class="font-bold text-red-900">{{ $detailCategoryAccount }}</h4>
                                    <span class="font-bold text-red-900">Rp {{ number_format(abs($detailCategoryTotals[$index]['balance'] ?? 0), 0, ',', '.') }}</span>
                                </div>

                                @if(isset($categoryAccounts[$index]))
                                    <div class="ml-4 space-y-2">
                                        @foreach ($categoryAccounts[$index] as $key => $categoryAccount)
                                            <div class="border-l-2 border-red-200 pl-4">
                                                <div class="flex justify-between items-center py-2">
                                                    <span class="font-semibold text-gray-700">{{ $categoryAccount }}</span>
                                                    <span class="font-semibold text-gray-900">Rp {{ number_format(abs($categoryAccountTotals[$index][$key]['balance'] ?? 0), 0, ',', '.') }}</span>
                                                </div>

                                                @if(isset($accounts[$index][$key]))
                                                    <div class="ml-4 space-y-1">
                                                        @foreach ($accounts[$index][$key] as $key_account => $account)
                                                            <div class="flex justify-between items-center text-sm py-1">
                                                                <span class="text-gray-600">{{ $account }}</span>
                                                                <span class="text-gray-700">Rp {{ number_format(abs($accountTotals[$index][$key][$key_account]['balance'] ?? 0), 0, ',', '.') }}</span>
                                                            </div>
                                                        @endforeach
                                                    </div>
                                                @endif
                                            </div>
                                        @endforeach
                                    </div>
                                @endif
                            </div>
                        @endif
                    @endforeach

                    <div class="border-t border-gray-300 mt-2 pt-2">
                        <div class="flex justify-between items-center">
                            <span class="font-bold text-gray-800">Total Kewajiban</span>
                            <span class="font-bold text-gray-900">Rp {{ number_format(abs($this->totalLiabilities), 0, ',', '.') }}</span>
                        </div>
                    </div>
                </div>

                {{-- EQUITY --}}
                <div class="mb-6">
                    <h3 class="font-bold text-purple-700 text-lg mb-3 pb-2 border-b border-purple-200">MODAL</h3>

                    @foreach ($detailCategoryAccounts as $index => $detailCategoryAccount)
                        @php
                            $categoryName = strtolower($detailCategoryAccount);
                        @endphp

                        @if(strpos($categoryName, 'modal') !== false)
                            <div class="mb-4">
                                <div class="flex justify-between items-center bg-purple-50 px-4 py-3 rounded-lg mb-2">
                                    <h4 class="font-bold text-purple-900">{{ $detailCategoryAccount }}</h4>
                                    <span class="font-bold text-purple-900">Rp {{ number_format(abs($detailCategoryTotals[$index]['balance'] ?? 0), 0, ',', '.') }}</span>
                                </div>

                                @if(isset($categoryAccounts[$index]))
                                    <div class="ml-4 space-y-2">
                                        @foreach ($categoryAccounts[$index] as $key => $categoryAccount)
                                            <div class="border-l-2 border-purple-200 pl-4">
                                                <div class="flex justify-between items-center py-2">
                                                    <span class="font-semibold text-gray-700">{{ $categoryAccount }}</span>
                                                    <span class="font-semibold text-gray-900">Rp {{ number_format(abs($categoryAccountTotals[$index][$key]['balance'] ?? 0), 0, ',', '.') }}</span>
                                                </div>

                                                @if(isset($accounts[$index][$key]))
                                                    <div class="ml-4 space-y-1">
                                                        @foreach ($accounts[$index][$key] as $key_account => $account)
                                                            <div class="flex justify-between items-center text-sm py-1">
                                                                <span class="text-gray-600">{{ $account }}</span>
                                                                <span class="text-gray-700">Rp {{ number_format(abs($accountTotals[$index][$key][$key_account]['balance'] ?? 0), 0, ',', '.') }}</span>
                                                            </div>
                                                        @endforeach
                                                    </div>
                                                @endif
                                            </div>
                                        @endforeach
                                    </div>
                                @endif
                            </div>
                        @endif
                    @endforeach

                    <div class="border-t border-gray-300 mt-2 pt-2">
                        <div class="flex justify-between items-center">
                            <span class="font-bold text-gray-800">Total Modal</span>
                            <span class="font-bold text-gray-900">Rp {{ number_format(abs($this->totalEquity), 0, ',', '.') }}</span>
                        </div>
                    </div>
                </div>

                {{-- Total Liabilities + Equity --}}
                <div class="border-t-2 border-purple-900 mt-4 pt-4">
                    <div class="flex justify-between items-center">
                        <h3 class="font-bold text-purple-900 text-lg">TOTAL KEWAJIBAN & MODAL</h3>
                        <span class="font-bold text-purple-900 text-xl">Rp {{ number_format(abs($this->totalLiabilities + $this->totalEquity), 0, ',', '.') }}</span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Balance Verification --}}
    <div class="bg-white rounded-xl shadow-lg border border-gray-100 p-6 mb-6">
        <div class="flex items-center justify-between">
            <div>
                <h3 class="text-lg font-bold text-gray-800 mb-2">Verifikasi Neraca</h3>
                <p class="text-sm text-gray-600">Total Aktiva harus sama dengan Total Kewajiban + Modal</p>
            </div>
            <div class="text-right">
                @if($this->balanceStatus['is_balanced'])
                    <div class="flex items-center gap-2 text-green-600">
                        <i class="fas fa-check-circle text-2xl"></i>
                        <span class="font-bold text-lg">SEIMBANG</span>
                    </div>
                @else
                    <div class="flex items-center gap-2 text-orange-600">
                        <i class="fas fa-exclamation-triangle text-2xl"></i>
                        <span class="font-bold text-lg">TIDAK SEIMBANG</span>
                    </div>
                    <p class="text-sm mt-1">Selisih: Rp {{ number_format(abs($this->balanceStatus['difference']), 0, ',', '.') }}</p>
                @endif
            </div>
        </div>

        <div class="grid grid-cols-3 gap-4 mt-4 pt-4 border-t">
            <div class="text-center">
                <p class="text-sm text-gray-600 mb-1">Total Aktiva</p>
                <p class="font-bold text-lg text-blue-600">Rp {{ number_format(abs($this->totalAssets), 0, ',', '.') }}</p>
            </div>
            <div class="text-center">
                <p class="text-sm text-gray-600 mb-1">Total Kewajiban</p>
                <p class="font-bold text-lg text-red-600">Rp {{ number_format(abs($this->totalLiabilities), 0, ',', '.') }}</p>
            </div>
            <div class="text-center">
                <p class="text-sm text-gray-600 mb-1">Total Modal</p>
                <p class="font-bold text-lg text-purple-600">Rp {{ number_format(abs($this->totalEquity), 0, ',', '.') }}</p>
            </div>
        </div>
    </div>
</div>
