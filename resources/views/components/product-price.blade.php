@props(['product', 'showPercentage' => true, 'showSavings' => false, 'variant' => 'default'])

@php
    $companyId = auth()->user()->company_id ?? null;
    $priceInfo = \App\Helpers\PromotionHelper::getProductPriceInfo($product->id, $companyId);
@endphp

<div class="product-price-display">
    @if ($priceInfo['has_discount'])
        <!-- Product has discount -->
        @if ($variant === 'compact')
            <div class="flex items-center space-x-1">
                <span class="text-xs text-gray-500 line-through">
                    Rp {{ number_format($priceInfo['original_price'], 0, ',', '.') }}
                </span>
                <span class="text-red-600 font-medium">
                    Rp {{ number_format($priceInfo['final_price'], 0, ',', '.') }}
                </span>
            </div>
        @elseif ($variant === 'table')
            <!-- Khusus untuk tampilan tabel -->
            <div class="flex flex-col">
                <span class="text-xs text-gray-500 line-through">
                    Rp {{ number_format($priceInfo['original_price'], 0, ',', '.') }}
                </span>
                <span class="text-red-600 font-semibold">
                    Rp {{ number_format($priceInfo['final_price'], 0, ',', '.') }}
                </span>
            </div>
        @else
            <div class="flex flex-col">
                <div class="flex items-center space-x-2">
                    <span class="text-sm text-gray-500 line-through">
                        Rp {{ number_format($priceInfo['original_price'], 0, ',', '.') }}
                    </span>
                    @if ($showPercentage)
                        <span class="bg-red-100 text-red-800 text-xs px-2 py-0.5 rounded-full">
                            -{{ $priceInfo['discount_percentage'] }}%
                        </span>
                    @endif
                </div>
                <span class="text-red-600 font-semibold">
                    Rp {{ number_format($priceInfo['final_price'], 0, ',', '.') }}
                </span>
                @if ($showSavings)
                    <small class="text-green-600 text-xs">
                        Hemat: Rp {{ number_format($priceInfo['discount_amount'], 0, ',', '.') }}
                    </small>
                @endif
            </div>
        @endif
    @else
        <!-- Product has no discount -->
        <span class="text-gray-900">
            Rp {{ number_format($priceInfo['original_price'], 0, ',', '.') }}
        </span>
    @endif
</div>
