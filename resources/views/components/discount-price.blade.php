@props(['product', 'showOriginal' => true, 'class' => '', 'variant' => 'default'])

@php
    $companyId = auth()->user()->company_id ?? null;
    $priceInfo = \App\Helpers\PromotionHelper::getProductPriceInfo($product->id, $companyId);
@endphp

<div class="discount-price-display {{ $class }}">
    @if ($priceInfo['has_discount'])
        <!-- Product has discount -->
        @if ($variant === 'inline')
            <!-- Tampilan horizontal -->
            <div class="flex items-center space-x-2">
                @if ($showOriginal)
                    <span class="text-xs text-gray-500 line-through">
                        Rp {{ number_format($priceInfo['original_price'], 0, ',', '.') }}
                    </span>
                @endif
                <span class="text-red-600 font-semibold">
                    Rp {{ number_format($priceInfo['final_price'], 0, ',', '.') }}
                </span>
            </div>
        @else
            <!-- Tampilan vertikal (default) -->
            <div class="flex flex-col">
                @if ($showOriginal)
                    <span class="text-xs text-gray-500 line-through">
                        Rp {{ number_format($priceInfo['original_price'], 0, ',', '.') }}
                    </span>
                @endif
                <span class="text-red-600 font-semibold">
                    Rp {{ number_format($priceInfo['final_price'], 0, ',', '.') }}
                </span>
            </div>
        @endif
    @else
        <!-- Product has no discount - show original price -->
        <span class="text-gray-900">
            Rp {{ number_format($priceInfo['original_price'], 0, ',', '.') }}
        </span>
    @endif
</div>
