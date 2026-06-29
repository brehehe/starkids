<div>
    @include('livewire.admin.sale.pos.detail.admin-sale-pos-detail-modal')
    <main class="max-w-full mx-auto p-4 pt-16 grid grid-cols-1 lg:grid-cols-4 gap-6" style="margin-top: 50px;">


        <div class="bg-white rounded-xl shadow-md p-4 flex flex-col md:col-span-3">
            <!-- Header with Cart Title and DateTime/User Info -->
            <div class="flex justify-between items-center mb-4">
                <h2 class="font-semibold text-lg">
                    <i class="fas fa-shopping-cart mr-2"></i>Keranjang
                </h2>
                @if (in_array($transaction->status, ['draft', 'process', 'take_medicine', 'completed']))
                    <div class="text-sm text-gray-500 flex flex-col items-end">
                        <div class="flex gap-2 w-full">
                            <div class="relative flex-1 md:w-94">
                                <input wire:model.lazy='search_sku' type="text" id="skuInput"
                                    placeholder="Masukkan SKU / Scan Barcode"
                                    class="w-full pl-10 pr-4 py-2 bg-blue-50 border border-blue-200 rounded-lg focus:ring-2 focus:ring-[#1E3A8A] focus:outline-none"
                                    autocomplete="off" />
                                <i class="fas fa-barcode absolute left-3 top-1/2 -translate-y-1/2 text-[#1E3A8A]"></i>
                            </div>
                            <!-- Right side buttons -->
                            <div class="flex gap-2">
                                <button
                                    class="px-4 py-2 bg-yellow-500 text-white rounded-lg hover:bg-yellow-900 whitespace-nowrap transition-colors duration-150"
                                    wire:click="openModal()">
                                    <i class="fas fa-search mr-2"></i>Pilih Produk
                                </button>
                            </div>
                        </div>
                    </div>
                @endif
            </div>

            <div class="flex-1 overflow-y-auto scrollbar-custom">
                <table class="w-full text-sm">
                    <thead>
                        <tr class="border-b">
                            <th class="py-2 text-left">Produk</th>
                            <th class="py-2 text-left">Quantity Request</th>
                            <th class="py-2 text-center">Quantity</th>
                            <th class="py-2 text-right">Subtotal</th>
                            @if (in_array($transaction->status, ['draft', 'process', 'take_medicine', 'completed']))
                                <th class="py-2 w-8"></th>
                            @endif
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($actions as $key_action => $action)
                            <tr class="border-b">
                                <td class="py-2" colspan="2">
                                    <p class="font-medium">{{ $action['product_name'] }}</p>
                                    <p class="text-xs text-gray-500">
                                        @Rp{{ number_format($action['price'], 0, ',', '.') }}</p>
                                </td>
                                <td class="py-2 text-center">
                                    {{ $action['quantity'] }}
                                </td>
                                <td class="py-2 text-right">
                                    Rp{{ number_format($action['sub_total_price'], 0, ',', '.') }}</td>
                            </tr>
                        @endforeach
                        @foreach ($transaction_details as $key => $transaction_detail)
                            <tr class="border-t-4">
                                <td colspan="3" class="py-3 px-2">
                                    <div class="flex items-center gap-2">
                                        <span class="font-medium text-blue-600">/R-{{ $key + 1 }}</span>
                                        <select
                                            {{ in_array($transaction->status, ['draft', 'process', 'take_medicine', 'completed']) ? null : 'disabled' }}
                                            class="{{ in_array($transaction->status, ['draft', 'process', 'take_medicine', 'completed']) ? null : 'bg-gray-100 cursor-not-allowed' }} text-sm border rounded px-2 py-1"
                                            wire:model.lazy='transaction_details.{{ $key }}.medicine_type_id'>
                                            <option value="">Jenis Resep</option>
                                            @foreach ($medicine_types as $medicine_type)
                                                <option value="{{ $medicine_type['id'] }}">{{ $medicine_type['name'] }}
                                                </option>
                                            @endforeach
                                        </select>
                                        <div
                                            class="flex items-center border rounded px-2 py-1 w-30 bg-gray-100 cursor-not-allowed">
                                            <span class="text-gray-500 mr-2 select-none">Rp</span>
                                            <input type="text" disabled
                                                wire:model='transaction_details.{{ $key }}.price_service_one'
                                                placeholder="Jasa 1"
                                                class="text-sm bg-gray-100 text-gray-500 focus:outline-none w-full cursor-not-allowed" />
                                        </div>
                                        <input type="text"
                                            {{ in_array($transaction->status, ['draft', 'process', 'take_medicine', 'completed']) ? null : 'disabled' }}
                                            wire:model.lazy='transaction_details.{{ $key }}.numero_recipe'
                                            placeholder="Numero Resep"
                                            class="{{ in_array($transaction->status, ['draft', 'process', 'take_medicine', 'completed']) ? null : 'bg-gray-100 cursor-not-allowed' }} text-sm border rounded px-2 py-1 w-30">
                                        @if (!$transaction_detail['is_single'])
                                            <select
                                                {{ in_array($transaction->status, ['draft', 'process', 'take_medicine', 'completed']) ? null : 'disabled' }}
                                                class="{{ in_array($transaction->status, ['draft', 'process', 'take_medicine', 'completed']) ? null : 'bg-gray-100 cursor-not-allowed' }} text-sm border rounded px-2 py-1"
                                                wire:model.lazy='transaction_details.{{ $key }}.product_id'>
                                                <option value="">Jenis Produk Pendukung</option>
                                                @foreach ($supporting_products as $supporting_product)
                                                    <option value="{{ $supporting_product['id'] }}">
                                                        {{ $supporting_product['name'] }} -
                                                        {{ $supporting_product['product_stock']['quantity'] ?? 0 }} -
                                                        Rp
                                                        {{ number_format($supporting_product['product_price']['price'] ?? 0, 0, ',', '.') }}
                                                    </option>
                                                @endforeach
                                            </select>
                                            <div
                                                class="flex items-center border rounded px-2 py-1 w-30 bg-gray-100 cursor-not-allowed">
                                                <span class="text-gray-500 mr-2 select-none">Rp</span>
                                                <input type="text" disabled
                                                    wire:model='transaction_details.{{ $key }}.sub_total_price'
                                                    placeholder="Jasa 1"
                                                    class="text-sm bg-gray-100 text-gray-500 focus:outline-none w-full cursor-not-allowed" />
                                            </div>
                                            @if (in_array($transaction->status, ['draft', 'process', 'take_medicine', 'completed']))
                                                <button class="text-blue-500 hover:text-blue-700"
                                                    wire:click="addDetail('{{ $transaction_detail['id'] }}')">
                                                    <i class="fas fa-plus"></i>
                                                </button>
                                            @endif
                                        @endif
                                        @if (in_array($transaction->status, ['draft', 'process', 'take_medicine', 'completed']))
                                            <button class="text-red-600 hover:text-red-800 mx-1"
                                                wire:click="confirmDeleteTransactionRecipe('{{ $transaction_detail['id'] }}')"
                                                title="Hapus">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        @endif
                                    </div>
                                    <div class="mt-2 text-sm text-gray-600">
                                        <input type="text"
                                            {{ in_array($transaction->status, ['draft', 'process', 'take_medicine', 'completed']) ? null : 'disabled' }}
                                            wire:model.lazy='transaction_details.{{ $key }}.description'
                                            placeholder="Aturan Pakai"
                                            class="{{ in_array($transaction->status, ['draft', 'process', 'take_medicine', 'completed']) ? null : 'bg-gray-100 cursor-not-allowed' }} w-full border rounded px-2 py-1">
                                    </div>
                                    <div class="mt-2 text-sm text-gray-600">
                                        <input type="text"
                                            {{ in_array($transaction->status, ['draft', 'process', 'take_medicine', 'completed']) ? null : 'disabled' }}
                                            wire:model.lazy='transaction_details.{{ $key }}.notes'
                                            placeholder="Catatan Resep"
                                            class="{{ in_array($transaction->status, ['draft', 'process', 'take_medicine', 'completed']) ? null : 'bg-gray-100 cursor-not-allowed' }} w-full border rounded px-2 py-1">
                                    </div>
                                </td>
                            </tr>
                            @if (!empty($transaction_detail['details']))
                                @foreach ($transaction_detail['details'] as $index => $item)
                                    <tr class="border-b">
                                        <td class="py-2" colspan="{{ !$transaction_detail['is_single'] ? 1 : 2 }}">
                                            <p class="font-medium">{{ $item['product_name'] }}</p>
                                            <p class="text-xs text-gray-500">
                                                @Rp{{ number_format($item['price'], 0, ',', '.') }}</p>
                                        </td>
                                        @if (!$transaction_detail['is_single'])
                                            <td class="py-2">
                                                <input
                                                    wire:model.lazy="transaction_details.{{ $key }}.details.{{ $index }}.quantity_real"
                                                    type="text" placeholder="Quantity Permintaan"
                                                    {{ in_array($transaction->status, ['draft', 'process', 'take_medicine', 'completed']) ? null : 'disabled' }}
                                                    class="{{ in_array($transaction->status, ['draft', 'process', 'take_medicine', 'completed']) ? null : 'bg-gray-100 cursor-not-allowed' }} text-sm border rounded px-2 py-1 w-48">
                                            </td>
                                            </td>
                                        @endif
                                        <td class="py-2 text-center">
                                            {{ $item['quantity'] }}
                                        </td>
                                        <td class="py-2 text-right">
                                            Rp{{ number_format($item['sub_total_price'], 0, ',', '.') }}</td>
                                        @if (in_array($transaction->status, ['draft', 'process', 'take_medicine', 'completed']))
                                            <td class="py-2 text-center">
                                                <button
                                                    wire:click="confirmDeleteTransactionDetail('{{ $item['id'] }}')"
                                                    class="text-red-500 hover:text-red-700"><i
                                                        class="fas fa-trash"></i></button>
                                            </td>
                                        @endif
                                    </tr>
                                @endforeach
                            @endif
                        @endforeach
                        @forelse ($medicines as $key_medicine => $medicine)
                            <tr
                                class="border-b {{ isset($medicine['is_free_item']) && $medicine['is_free_item'] ? 'bg-green-50' : 'border-t-4' }}">
                                <td class="py-2" colspan="5">
                                    <div class="flex items-start justify-between">
                                        <div class="flex-1">
                                            {{-- Add indentation for child items --}}
                                            <div
                                                class="{{ isset($medicine['is_parent']) && !$medicine['is_parent'] ? 'ml-6' : '' }}">
                                                {{-- Parent/Child indicator --}}
                                                @if (isset($medicine['is_parent']) && !$medicine['is_parent'])
                                                    <span class="text-gray-400 mr-2">└─</span>
                                                @endif

                                                <p
                                                    class="font-medium {{ isset($medicine['is_free_item']) && $medicine['is_free_item'] ? 'text-green-700' : '' }}">
                                                    {{ $medicine['product_name'] }}
                                                    @if (isset($medicine['is_free_item']) && $medicine['is_free_item'])
                                                        <span
                                                            class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-green-100 text-green-800 ml-2">
                                                            <i class="fas fa-gift mr-1"></i>GRATIS
                                                        </span>
                                                    @endif
                                                </p>
                                                <p class="text-xs text-gray-500 flex ">
                                                    @if ($medicine['price_discount'] != $medicine['price'])
                                                        <span class="line-through text-red-500 mr-2">
                                                            Rp{{ number_format($medicine['price_discount'], 0, ',', '.') }}
                                                        </span>
                                                    @endif
                                                    <span
                                                        class="{{ isset($medicine['is_free_item']) && $medicine['is_free_item'] ? 'text-green-600 font-medium' : '' }}">
                                                        @if (isset($medicine['is_free_item']) && $medicine['is_free_item'])
                                                            GRATIS
                                                            (Rp{{ number_format($medicine['price_discount'] ?? 0, 0, ',', '.') }})
                                                        @else
                                                            Rp{{ number_format($medicine['price'], 0, ',', '.') }}
                                                        @endif
                                                    </span>
                                                </p>
                                                @if (isset($medicine['promotion_text']) && $medicine['promotion_text'])
                                                    <p class="text-xs text-green-600 mt-1">
                                                        <i
                                                            class="fas fa-tag mr-1"></i>{{ $medicine['promotion_text'] }}
                                                    </p>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                </td>
                                <td class="py-2 text-center">
                                    @if ($transaction->status == 'draft')
                                        @if (isset($medicine['is_free_item']) && $medicine['is_free_item'])
                                            {{-- Free items cannot be manually adjusted --}}
                                            <span
                                                class="text-green-600 font-medium">{{ number_format($medicine['quantity'], 0, ',', '.') }}</span>
                                            <div class="text-xs text-green-500 mt-1">Auto</div>
                                        @else
                                            <div class="flex justify-center items-center gap-2">
                                                <button
                                                    wire:click="updateQuantity('{{ $medicine['id'] }}','decrement')"
                                                    class="w-6 h-6 bg-gray-100 rounded-full hover:bg-gray-200"><i
                                                        class="fas fa-minus text-xs"></i></button>
                                                <input type="number"
                                                    wire:model.lazy='medicines.{{ $key_medicine }}.quantity'
                                                    class="w-20 h-6 text-center border rounded" />
                                                <button
                                                    wire:click="updateQuantity('{{ $medicine['id'] }}','increment')"
                                                    class="w-6 h-6 bg-gray-100 rounded-full hover:bg-gray-200"><i
                                                        class="fas fa-plus text-xs"></i></button>
                                            </div>
                                        @endif
                                    @else
                                        {{ number_format($medicine['quantity'], 0, ',', '.') }}
                                    @endif
                                </td>
                                <td class="py-2 text-right">
                                    <span
                                        class="{{ isset($medicine['is_free_item']) && $medicine['is_free_item'] ? 'text-green-600 font-medium' : '' }}">
                                        @if (isset($medicine['is_free_item']) && $medicine['is_free_item'])
                                            GRATIS
                                        @else
                                            Rp{{ number_format($medicine['sub_total_price'], 0, ',', '.') }}
                                        @endif
                                    </span>
                                </td>
                                @if ($transaction->status == 'draft')
                                    <td class="py-2 text-center">
                                        @if (isset($medicine['is_free_item']) && $medicine['is_free_item'])
                                            {{-- Free items show info icon instead of delete --}}
                                            <i class="fas fa-info-circle text-green-500"
                                                title="Item gratis dari promosi"></i>
                                        @else
                                            <button
                                                wire:click="confirmDeleteTransactionDetail('{{ $medicine['id'] }}')"
                                                class="text-red-500 hover:text-red-700"><i
                                                    class="fas fa-trash"></i></button>
                                        @endif
                                    </td>
                                @endif
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

        </div>

        <div class="bg-white rounded-xl shadow-md p-4 flex flex-col">
            <!-- Header Section -->
            <div class="flex justify-between items-center mb-4">
                <h2 class="font-semibold text-lg"><i class="fas fa-credit-card mr-2"></i>Pembayaran</h2>
            </div>

            <!-- Transaction Info Section -->
            <div class="bg-gray-50 rounded-lg p-3 mb-4">
                <div class="grid grid-cols-1 gap-4">
                    <div class="space-y-1">
                        <div class="flex items-center text-sm">
                            <i class="fas fa-receipt text-gray-500 w-5"></i>
                            <span class="text-gray-600">{{ $transaction->code }}</span>
                        </div>
                        <div class="flex items-center text-sm">
                            <i class="fas fa-user text-gray-500 w-5"></i>
                            <span class="font-medium">{{ $transaction->patient_name }}</span>
                        </div>
                        @if ($transaction->type == 'resep')
                            <div class="flex items-center text-sm">
                                <i class="fas fa-user-md text-gray-500 w-5"></i>
                                <span class="text-gray-600">{{ $transaction->doctor_name ?? '-' }}</span>
                            </div>
                            <div class="flex items-center text-sm">
                                <i class="fas fa-id-badge text-gray-500 w-5"></i>
                                <span class="text-gray-600">{{ $transaction->number_recipe ?? '-' }}</span>
                            </div>
                        @endif
                        <div class="flex items-center text-sm">
                            <i class="fas fa-tag text-gray-500 w-5"></i>
                            <span class="text-gray-600">{{ Str::title($transaction->type) }}</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Main Content -->
            <div class="flex-1 space-y-4">
                <!-- Bill and Discount Section -->
                <div class="grid grid-cols-1 gap-3">
                    {{-- <div>
                        <textarea wire:model='diagnosas' placeholder="Masukkan Diagnosa"
                            {{ $transaction->status == 'draft' ? null : 'disabled' }}
                            class="w-full px-3 py-2 border border-gray-200 rounded-lg focus:ring-2 focus:ring-[#1E3A8A] focus:outline-none"></textarea>
                    </div>
                    <div>
                        <textarea wire:model='immunization' placeholder="Masukkan Imunisasi"
                            {{ $transaction->status == 'draft' ? null : 'disabled' }}
                            class="w-full px-3 py-2 border border-gray-200 rounded-lg focus:ring-2 focus:ring-[#1E3A8A] focus:outline-none"></textarea>
                    </div> --}}
                    <div>
                        <label class="block text-sm font-medium mb-1">Total Tagihan</label>
                        <div class="px-3 py-2 bg-gray-50 border border-gray-200 rounded-lg text-lg font-semibold">
                            Rp {{ number_format($transaction->sub_total_price, 0, ',', '.') }}
                        </div>
                    </div>
                    <!-- Promotion Selection -->
                    @if (in_array($transaction->status, ['draft', 'process', 'take_medicine', 'completed']))
                        <div>
                            <label class="block text-sm font-medium mb-1">
                                Promosi Diskon
                                @if ($has_deposit)
                                    <span class="text-xs text-orange-600">(Nonaktif - Menggunakan Deposit)</span>
                                @endif
                            </label>
                            <select wire:model.live='promotion_simplified_id' {{ $has_deposit ? 'disabled' : '' }}
                                class="w-full px-3 py-2 border border-gray-200 rounded-lg focus:ring-2 focus:ring-[#1E3A8A] focus:outline-none {{ $has_deposit ? 'bg-gray-100 cursor-not-allowed' : '' }}">
                                <option value="">
                                    {{ $has_deposit ? 'Nonaktif karena deposit' : 'Pilih Promosi (Opsional)' }}
                                </option>
                                @if (!$has_deposit)
                                    @foreach ($availablePromotions as $promotion)
                                        <option value="{{ $promotion['id'] }}">
                                            {{ $promotion['name'] }} - {{ $promotion['discount_text'] }}
                                            @if ($promotion['minimum_purchase'] > 0)
                                                (Min. Rp
                                                {{ number_format($promotion['minimum_purchase'], 0, ',', '.') }})
                                            @endif
                                        </option>
                                    @endforeach
                                @endif
                            </select>
                            @if ($has_deposit)
                                <div class="mt-2 p-2 bg-orange-50 border border-orange-200 rounded text-sm">
                                    <div class="flex items-center text-orange-700">
                                        <i class="fas fa-money-bill-wave mr-2"></i>
                                        <span class="font-medium">Menggunakan Deposit</span>
                                    </div>
                                    <div class="text-orange-600 mt-1">
                                        Diskon otomatis: Rp {{ number_format($deposit_discount_amount, 0, ',', '.') }}
                                    </div>
                                </div>
                            @elseif ($promotionSummary)
                                <div class="mt-2 p-2 bg-green-50 border border-green-200 rounded text-sm">
                                    <div class="flex items-center text-green-700">
                                        <i class="fas fa-tag mr-2"></i>
                                        <span class="font-medium">{{ $promotionSummary['name'] }}</span>
                                    </div>
                                    <div class="text-green-600 mt-1">
                                        Hemat: Rp
                                        {{ number_format($promotionSummary['discount_amount'], 0, ',', '.') }}
                                    </div>
                                </div>
                            @endif
                        </div>
                    @elseif($transaction->promotion_simplified_id)
                        <div>
                            <label class="block text-sm font-medium mb-1">Promosi Diterapkan</label>
                            <div class="px-3 py-2 bg-green-50 border border-green-200 rounded-lg">
                                <div class="flex items-center text-green-700">
                                    <i class="fas fa-tag mr-2"></i>
                                    <span
                                        class="font-medium">{{ $promotionSummary['name'] ?? 'Promosi Aktif' }}</span>
                                </div>
                                <div class="text-green-600 text-sm mt-1">
                                    Hemat: Rp {{ number_format($transaction->promotion_real ?? 0, 0, ',', '.') }}
                                </div>
                            </div>
                        </div>
                    @else
                        <div>
                            <label class="block text-sm font-medium mb-1">Promosi Diskon</label>
                            <select wire:model.live='promotion_simplified_id' disabled
                                class="w-full px-3 py-2 border border-gray-200 rounded-lg focus:ring-2 focus:ring-[#1E3A8A] focus:outline-none">
                                <option value="">Pilih Promosi (Opsional)</option>
                                @foreach ($availablePromotions as $promotion)
                                    <option value="{{ $promotion['id'] }}">
                                        {{ $promotion['name'] }} - {{ $promotion['discount_text'] }}
                                        @if ($promotion['minimum_purchase'] > 0)
                                            (Min. Rp {{ number_format($promotion['minimum_purchase'], 0, ',', '.') }})
                                        @endif
                                    </option>
                                @endforeach
                            </select>
                            @if ($promotionSummary)
                                <div class="mt-2 p-2 bg-green-50 border border-green-200 rounded text-sm">
                                    <div class="flex items-center text-green-700">
                                        <i class="fas fa-tag mr-2"></i>
                                        <span class="font-medium">{{ $promotionSummary['name'] }}</span>
                                    </div>
                                    <div class="text-green-600 mt-1">
                                        Hemat: Rp
                                        {{ number_format($promotionSummary['discount_amount'], 0, ',', '.') }}
                                    </div>
                                </div>
                            @endif
                        </div>
                    @endif
                    <div>
                        @if (in_array($transaction->status, ['draft', 'process', 'take_medicine', 'completed']))
                            <label class="block text-sm font-medium mb-1">
                                Diskon
                                @if ($has_deposit)
                                    <span class="text-xs text-orange-600">(Otomatis dari Deposit)</span>
                                @endif
                            </label>
                            <div class="relative">
                                <select wire:model.lazy='discount_type' {{ $has_deposit ? 'disabled' : '' }}
                                    class="absolute left-0 top-0 h-full w-16 border-r border-gray-200 rounded-l-lg text-sm text-center appearance-none {{ $has_deposit ? 'bg-gray-100 cursor-not-allowed' : 'bg-gray-50 hover:bg-gray-100' }} focus:ring-2 focus:ring-[#1E3A8A] focus:outline-none">
                                    <option value="rupiah">Rp</option>
                                    @if (!$has_deposit)
                                        <option value="percentage">%</option>
                                    @endif
                                </select>
                                @if ($discount_type == 'percentage' && !$has_deposit)
                                    <input type="number" wire:model.lazy='discount' placeholder="Diskon (%)"
                                        class="w-full pl-18 px-3 py-2 border border-gray-200 rounded-lg focus:ring-2 focus:ring-[#1E3A8A] focus:outline-none" />
                                @else
                                    <input type="text" onkeyup="convertToRupiah(this)" wire:model.lazy='discount'
                                        {{ $has_deposit ? 'readonly' : '' }}
                                        class="w-full pl-18 px-3 py-2 border border-gray-200 rounded-lg focus:ring-2 focus:ring-[#1E3A8A] focus:outline-none {{ $has_deposit ? 'bg-gray-100 cursor-not-allowed' : '' }}"
                                        placeholder="{{ $has_deposit ? 'Diskon otomatis dari deposit' : '0' }}" />
                                @endif
                            </div>
                            @if ($has_deposit)
                                <div class="mt-1 text-xs text-orange-600">
                                    <i class="fas fa-info-circle mr-1"></i>
                                    Diskon diatur otomatis sesuai nilai deposit
                                </div>
                            @endif
                        @else
                            <label class="block text-sm font-medium mb-1">Diskon</label>
                            <div class="px-3 py-2 bg-gray-50 border border-gray-200 rounded-lg text-lg font-semibold">
                                @if ($transaction->discount_type == 'percentage')
                                    {{ $transaction->discount }} %
                                @else
                                    Rp {{ number_format($transaction->discount, 0, ',', '.') }}
                                @endif
                                @if ($has_deposit)
                                    <span class="text-xs text-orange-600 ml-2">(Dari Deposit)</span>
                                @endif
                            </div>
                        @endif
                    </div>
                </div>
                <!-- Toggle Switches Section -->
                <div class="grid grid-cols-2 gap-3">
                    <!-- Insurance Toggle -->
                    <div class="flex items-center justify-between p-3 bg-gray-50 rounded-lg border border-gray-200 hover:border-blue-300 transition-colors">
                        <div class="flex items-center gap-2">
                            <i class="fas fa-shield-alt text-blue-600"></i>
                            <div>
                                <label class="text-sm font-medium text-gray-700 cursor-pointer">Asuransi</label>
                                <p class="text-xs text-gray-500">{{ $is_insurance ? 'Aktif' : 'Nonaktif' }}</p>
                            </div>
                        </div>
                        <label class="relative inline-flex items-center cursor-pointer">
                            <input type="checkbox" wire:model.live="is_insurance" class="sr-only peer">
                            <div class="w-11 h-6 bg-gray-300 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-blue-300 rounded-full peer peer-checked:after:translate-x-full rtl:peer-checked:after:-translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:start-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-blue-600"></div>
                        </label>
                    </div>

                    <!-- Pending Payment Toggle -->
                    <div class="flex items-center justify-between p-3 bg-gray-50 rounded-lg border border-gray-200 hover:border-orange-300 transition-colors">
                        <div class="flex items-center gap-2">
                            <i class="fas fa-clock text-orange-600"></i>
                            <div>
                                <label class="text-sm font-medium text-gray-700 cursor-pointer">Pending</label>
                                <p class="text-xs text-gray-500">{{ $is_pending_payment ? 'Aktif' : 'Nonaktif' }}</p>
                            </div>
                        </div>
                        <label class="relative inline-flex items-center cursor-pointer">
                            <input type="checkbox" wire:model.live="is_pending_payment" class="sr-only peer">
                            <div class="w-11 h-6 bg-gray-300 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-orange-300 rounded-full peer peer-checked:after:translate-x-full rtl:peer-checked:after:-translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:start-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-orange-600"></div>
                        </label>
                    </div>
                </div>
                <!-- Payment Methods Section -->
                @if (!$is_pending_payment)
                    <div class="space-y-3">
                        <div class="flex justify-between items-center">
                            <label class="block text-sm font-medium">Metode Pembayaran</label>
                            @if (in_array($transaction->status, ['draft', 'process', 'take_medicine', 'completed']))
                                @if ((float) $transaction->remaining_bill > 0)
                                    <button class="text-sm text-blue-600 hover:text-blue-800"
                                        wire:click="openModalPayment()">
                                        <i class="fas fa-plus-circle mr-1"></i>Tambah Metode
                                    </button>
                                @endif
                            @endif
                        </div>
                    </div>
                @endif
                <!-- Summary Section -->
                <div class="bg-gray-50 rounded-lg p-3">
                    {{-- <div class="flex justify-between items-center">
                        <span class="text-sm text-gray-600">Jasa 1</span>
                        <span class="text-sm font-semibold text-[#1E3A8A]">Rp {{ number_format($transaction->first_service_price, 0, ',', '.') }}</span>
                    </div>
                    <div class="flex justify-between items-center">
                        <span class="text-sm text-gray-600">Produk Pendukung</span>
                        <span class="text-sm font-semibold text-[#1E3A8A]">Rp {{ number_format($transaction->price_product_price, 0, ',', '.') }}</span>
                    </div>
                    <div class="flex justify-between items-center">
                        <span class="text-sm text-gray-600">Jasa 2</span>
                        <span class="text-sm font-semibold text-[#1E3A8A]">Rp {{ number_format($transaction->second_service_price, 0, ',', '.') }}</span>
                    </div> --}}
                    <div class="flex justify-between items-center">
                        <span class="text-sm text-gray-600">Produk</span>
                        <span class="text-sm font-semibold text-[#1E3A8A]">Rp
                            {{ number_format($transaction->product_price, 0, ',', '.') }}</span>
                    </div>
                    <div class="flex justify-between items-center">
                        <span class="text-sm text-gray-600">Embalage</span>
                        <span class="text-sm font-semibold text-[#1E3A8A]">Rp
                            {{ number_format($transaction->embalage, 0, ',', '.') }}</span>
                    </div>
                    {{-- Promotion Simplified Summary --}}
                    @if ($transaction->promotion_simplified_id && $transaction->promotion_real > 0)
                        <div class="mb-2 p-2 bg-blue-50 rounded border border-blue-200">
                            <div class="flex items-center mb-1">
                                <i class="fas fa-percentage text-blue-600 mr-2"></i>
                                <span class="text-sm font-medium text-blue-800">Promosi Diskon</span>
                            </div>
                            <div class="flex justify-between items-center text-xs">
                                <span class="text-blue-700">{{ $promotionSummary['name'] ?? 'Promosi Aktif' }}</span>
                                <span class="font-medium text-blue-800">Hemat
                                    Rp{{ number_format($transaction->promotion_real, 0, ',', '.') }}</span>
                            </div>
                        </div>
                    @endif

                    <div class="flex justify-between items-center">
                        <span class="text-sm text-gray-600">Promosi</span>
                        <span class="text-sm font-semibold text-[#1E3A8A]">Rp
                            {{ number_format($transaction->promotion_real ?? 0, 0, ',', '.') }}</span>
                    </div>
                    <div class="flex justify-between items-center">
                        <span class="text-sm text-gray-600">Diskon</span>
                        <span class="text-sm font-semibold text-[#1E3A8A]">Rp
                            {{ number_format($transaction->discount_value, 0, ',', '.') }}</span>
                    </div>
                    <div class="flex justify-between items-center">
                        <span class="text-sm text-gray-600">Pembulatan</span>
                        <span class="text-sm font-semibold text-[#1E3A8A]">Rp
                            {{ number_format($transaction->rounding, 0, ',', '.') }}</span>
                    </div>
                    <div class="flex justify-between items-center">
                        <span class="text-sm text-gray-600">Total Pembayaran</span>
                        <span class="text-sm font-semibold text-[#1E3A8A]">Rp
                            {{ number_format($transaction->grand_total_price, 0, ',', '.') }}</span>
                    </div>
                    <hr class="my-1">
                    @foreach ($transactionPayments as $transactionPayment)
                        <div class="flex justify-between items-center">
                            <span class="text-sm text-gray-600">{{ $transactionPayment->paymentMethod->name }}</span>
                            <span class="text-sm font-semibold text-[#1E3A8A]">Rp
                                {{ number_format($transactionPayment->payment_amount, 0, ',', '.') }}
                                @if (in_array($transaction->status, ['draft', 'process', 'take_medicine', 'completed']))
                                    <button
                                        wire:click="confirmDeleteTransactionPayment('{{ $transactionPayment->id }}')"
                                        class="text-red-500 hover:text-red-700"><i class="fas fa-trash"></i></button>
                                @endif
                            </span>
                        </div>
                    @endforeach
                    <hr class="my-1">
                    <div class="flex justify-between items-center">
                        <span class="text-sm text-gray-600">Total Terbayar</span>
                        <span class="text-sm font-semibold text-[#1E3A8A]">Rp
                            {{ number_format($transaction->payment_amount, 0, ',', '.') }}</span>
                    </div>
                    @if ($transaction->is_single_payment)
                        <div class="flex justify-between items-center">
                            <span class="text-sm text-gray-600">Biaya Admin</span>
                            <span class="text-sm font-semibold text-[#1E3A8A]">Rp
                                {{ number_format($transaction->single_payment_admin_fee, 0, ',', '.') }}</span>
                        </div>
                        <div class="flex justify-between items-center">
                            <span class="text-sm text-gray-600">Total</span>
                            <span class="text-sm font-semibold text-[#1E3A8A]">Rp
                                {{ number_format($transaction->grand_total_price_admin_fee, 0, ',', '.') }}</span>
                        </div>
                    @endif
                    <div class="flex justify-between items-center">
                        <span class="text-sm text-gray-600">Sisa Tagihan</span>
                        <span class="text-sm font-semibold text-red-500">Rp
                            {{ number_format($transaction->remaining_bill, 0, ',', '.') }}</span>
                    </div>
                    <div class="flex justify-between items-center">
                        <span class="text-sm text-gray-600">Kembalian</span>
                        <span class="text-sm font-semibold text-red-500">Rp
                            {{ number_format($transaction->payment_change, 0, ',', '.') }}</span>
                    </div>
                </div>
            </div>

            <!-- Action Buttons -->
            @if ($transaction->status == 'draft')
                <div class="grid grid-cols-3 gap-3 mt-4">
                    <button wire:click='confirmResetTransaction()' type="button"
                        class="px-4 py-2 border border-gray-200 rounded-lg hover:bg-gray-50 flex items-center justify-center gap-2">
                        <i class="fas fa-trash"></i>
                        <span>Reset</span>
                    </button>
                    <button wire:click="confirmSaveTransaction('draft')" type="button"
                        class="px-4 py-2 bg-green-500 text-white rounded-lg hover:bg-green-600 flex items-center justify-center gap-2">
                        <i class="fas fa-file-lines"></i>
                        <span>Draft</span>
                    </button>
                    <button wire:click="confirmSaveTransaction('process')" type="button"
                        class="px-4 py-2 bg-[#1E3A8A] text-white rounded-lg hover:bg-blue-900 flex items-center justify-center gap-2">
                        <i class="fas fa-check"></i>
                        <span>Proses</span>
                    </button>
                </div>
            @elseif (in_array($transaction->status, ['process', 'take_medicine', 'completed']))
                <div class="grid grid-cols-2 gap-3 mt-4">
                    <button wire:click="confirmDeleteTransaction()" type="button"
                        class="px-4 py-2 bg-red-500 text-white rounded-lg hover:bg-red-600 flex items-center justify-center gap-2">
                        <i class="fas fa-trash"></i>
                        <span>Batalkan</span>
                    </button>
                    <button wire:click="confirmSaveTransaction('completed')" type="button"
                        class="px-4 py-2 bg-green-500 text-white rounded-lg hover:bg-green-600 flex items-center justify-center gap-2">
                        <i class="fas fa-file-lines"></i>
                        <span>Selesai</span>
                    </button>
                </div>
                {{-- @elseif ($transaction->status == 'completed')
                <div class="grid grid-cols-2 gap-3 mt-4">
                    <button wire:click="printInvoice()" type="button"
                        class="px-4 py-2 bg-blue-500 text-white rounded-lg hover:bg-blue-600 flex items-center justify-center gap-2">
                        <i class="fas fa-file-invoice"></i>
                        <span>Invoice</span>
                    </button>
                    <button wire:click="printReceipt()" type="button"
                        class="px-4 py-2 bg-green-500 text-white rounded-lg hover:bg-green-600 flex items-center justify-center gap-2">
                        <i class="fas fa-file-lines"></i>
                        <span>Struk</span>
                    </button>
                </div> --}}
            @endif
        </div>
    </main>
</div>
