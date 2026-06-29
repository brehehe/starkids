@props(['product', 'showPercentage' => true, 'variant' => 'default'])

@php
    $companyId = auth()->user()->company_id ?? null;
    $priceInfo = \App\Helpers\PromotionHelper::getProductPriceInfo($product->id, $companyId);
@endphp

<div class="product-discount-display">
    @if ($priceInfo['has_discount'])
        @if ($variant === 'compact')
            <span class="text-red-600 text-sm">
                Rp {{ number_format($priceInfo['discount_amount'], 0, ',', '.') }}
            </span>
        @elseif($variant === 'detailed')
            <div class="flex flex-col">
                <span class="text-red-600 font-medium">
                    Rp {{ number_format($priceInfo['discount_amount'], 0, ',', '.') }}
                </span>
                {{-- @if ($showPercentage)
                    <small class="text-gray-500 text-xs">
                        {{ $priceInfo['discount_percentage'] }}% off
                    </small>
                @endif --}}
            </div>
        @elseif($variant === 'final_price')
            <span class="text-red-600 font-medium">
                Rp {{ number_format($priceInfo['final_price'], 0, ',', '.') }}
            </span>
        @else
            <span class="text-red-600">
                Rp {{ number_format($priceInfo['discount_amount'], 0, ',', '.') }}
                @if ($showPercentage)
                    <small class="text-gray-500">({{ $priceInfo['discount_percentage'] }}%)</small>
                @endif
            </span>
        @endif
    @else
        <span class="text-gray-400">-</span>
    @endif
</div>
