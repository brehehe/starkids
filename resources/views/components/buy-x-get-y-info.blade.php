@props([
    'promotionInfo' => [],
    'variant' => 'default', // default, compact, detailed
])

@if (!empty($promotionInfo))
    <div class="buy-x-get-y-info {{ $variant === 'compact' ? 'text-xs' : 'text-sm' }}">
        @if ($variant === 'compact')
            {{-- Compact version for table cells --}}
            @foreach ($promotionInfo as $info)
                <div class="bg-green-50 text-green-700 px-2 py-1 rounded text-xs mb-1">
                    <i class="fas fa-gift mr-1"></i>
                    {{ $info['get_product_name'] }} ({{ $info['free_quantity'] }}x) GRATIS
                </div>
            @endforeach
        @elseif($variant === 'detailed')
            {{-- Detailed version for popover or expanded view --}}
            <div class="space-y-2">
                @foreach ($promotionInfo as $info)
                    <div class="bg-gradient-to-r from-green-50 to-emerald-50 border border-green-200 rounded-lg p-3">
                        <div class="flex items-start justify-between">
                            <div class="flex items-center space-x-2">
                                <div class="bg-green-500 text-white rounded-full p-1">
                                    <i class="fas fa-gift text-xs"></i>
                                </div>
                                <div>
                                    <div class="font-medium text-green-800">{{ $info['promotion_text'] }}</div>
                                    <div class="text-green-600 text-sm">
                                        Beli: {{ $info['buy_product_name'] }} →
                                        Gratis: {{ $info['get_product_name'] }} ({{ $info['free_quantity'] }}x)
                                    </div>
                                </div>
                            </div>
                            <div class="text-right">
                                <div class="text-green-700 font-medium">
                                    Hemat Rp {{ number_format($info['savings'], 0, ',', '.') }}
                                </div>
                                <div class="text-green-600 text-xs">
                                    dari Rp {{ number_format($info['original_price'], 0, ',', '.') }}/item
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach

                <div class="bg-green-100 border border-green-300 rounded-lg p-2 mt-2">
                    <div class="flex items-center justify-between text-green-800">
                        <span class="font-medium">
                            <i class="fas fa-calculator mr-1"></i>
                            Total Hemat:
                        </span>
                        <span class="font-bold text-lg">
                            Rp {{ number_format(collect($promotionInfo)->sum('savings'), 0, ',', '.') }}
                        </span>
                    </div>
                </div>
            </div>
        @else
            {{-- Default version --}}
            <div class="space-y-2">
                @foreach ($promotionInfo as $info)
                    <div class="bg-green-50 border border-green-200 rounded-lg p-2">
                        <div class="flex items-center justify-between">
                            <div class="flex items-center space-x-2">
                                <i class="fas fa-gift text-green-500"></i>
                                <span class="text-green-700">
                                    {{ $info['get_product_name'] }} ({{ $info['free_quantity'] }}x) - GRATIS
                                </span>
                            </div>
                            <span class="text-green-600 text-sm">
                                Hemat Rp {{ number_format($info['savings'], 0, ',', '.') }}
                            </span>
                        </div>
                        @if ($info['promotion_text'])
                            <div class="text-green-600 text-xs mt-1">
                                {{ $info['promotion_text'] }}
                            </div>
                        @endif
                    </div>
                @endforeach
            </div>
        @endif
    </div>
@endif

<style>
    .buy-x-get-y-info .fas {
        font-size: inherit;
    }

    .buy-x-get-y-info .bg-gradient-to-r {
        background: linear-gradient(to right, #f0fdf4, #ecfdf5);
    }
</style>
