<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Services\PromotionService;
use Illuminate\Http\Request;

class PromotionController extends Controller
{
    protected $promotionService;

    public function __construct(PromotionService $promotionService)
    {
        $this->promotionService = $promotionService;
    }

    /**
     * Apply promotions to cart
     */
    public function applyPromotions(Request $request)
    {
        $cartItems = $request->input('cart_items', []);
        $cartTotal = $request->input('cart_total', 0);
        $userProfile = $request->input('user_profile');

        try {
            $result = $this->promotionService->applyPromotions($cartItems, $cartTotal, $userProfile);

            return response()->json([
                'success' => true,
                'data' => $result,
                'message' => 'Promosi berhasil diterapkan'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal menerapkan promosi: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Calculate specific promotion
     */
    public function calculatePromotion(Request $request, $promotionId)
    {
        $cartItems = $request->input('cart_items', []);
        $cartTotal = $request->input('cart_total', 0);
        $userProfile = $request->input('user_profile');

        try {
            $promotion = \App\Models\Promotion::findOrFail($promotionId);

            $result = [];

            switch ($promotion->type) {
                case 'buy_x_get_y':
                    $result = $this->promotionService->calculateBuyXGetY($promotion, $cartItems, $userProfile);
                    break;

                case 'bundle':
                    $result = $this->promotionService->calculateBundle($promotion, $cartItems);
                    break;

                case 'cashback':
                    $result = $this->promotionService->calculateCashback($promotion, $cartTotal, $userProfile);
                    break;

                case 'minimum_purchase_discount':
                    $result = $this->promotionService->calculateTierDiscount($promotion, $cartTotal);
                    break;

                default:
                    $result = ['discount' => 0, 'message' => 'Tipe promosi tidak didukung'];
            }

            return response()->json([
                'success' => true,
                'data' => $result,
                'promotion' => [
                    'id' => $promotion->id,
                    'name' => $promotion->name,
                    'description' => $this->promotionService->generatePromotionDescription($promotion)
                ]
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal menghitung promosi: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Example usage scenarios
     */
    public function examples()
    {
        return response()->json([
            'success' => true,
            'examples' => [
                'buy_x_get_y_same_product' => [
                    'title' => 'Beli 2 Gratis 1 (Produk Sama)',
                    'description' => 'Customer beli 3 produk yang sama, dapat gratis 1',
                    'config' => [
                        'type' => 'buy_x_get_y',
                        'buy_get_mode' => 'same_product',
                        'buy_quantity' => 2,
                        'get_quantity' => 1
                    ],
                    'cart_example' => [
                        ['product_id' => 1, 'quantity' => 3, 'price' => 10000]
                    ],
                    'expected_discount' => 10000
                ],

                'buy_x_get_y_different_product' => [
                    'title' => 'Beli Produk A, Gratis Produk B',
                    'description' => 'Customer beli produk tertentu, dapat produk lain gratis',
                    'config' => [
                        'type' => 'buy_x_get_y',
                        'buy_get_mode' => 'different_product',
                        'buy_products' => [
                            ['product_id' => 1, 'quantity' => 1]
                        ],
                        'get_products' => [
                            ['product_id' => 2, 'quantity' => 1, 'discount_type' => 'free']
                        ]
                    ],
                    'cart_example' => [
                        ['product_id' => 1, 'quantity' => 1, 'price' => 50000],
                        ['product_id' => 2, 'quantity' => 1, 'price' => 25000]
                    ],
                    'expected_discount' => 25000
                ],

                'bundle_promotion' => [
                    'title' => 'Paket Bundle Hemat',
                    'description' => 'Beli beberapa produk dalam satu paket dengan harga spesial',
                    'config' => [
                        'type' => 'bundle',
                        'bundle_products' => [
                            ['product_id' => 1, 'quantity' => 1, 'price' => 45000],
                            ['product_id' => 2, 'quantity' => 1, 'price' => 20000]
                        ],
                        'bundle_price' => 60000
                    ],
                    'cart_example' => [
                        ['product_id' => 1, 'quantity' => 1, 'price' => 50000],
                        ['product_id' => 2, 'quantity' => 1, 'price' => 25000]
                    ],
                    'expected_discount' => 15000
                ],

                'tier_discount' => [
                    'title' => 'Diskon Bertingkat',
                    'description' => 'Semakin besar belanja, semakin besar diskon',
                    'config' => [
                        'type' => 'minimum_purchase_discount',
                        'discount_tiers' => [
                            ['min_amount' => 100000, 'discount_value' => 10, 'max_discount' => 50000],
                            ['min_amount' => 200000, 'discount_value' => 15, 'max_discount' => 100000],
                            ['min_amount' => 500000, 'discount_value' => 20, 'max_discount' => 200000]
                        ]
                    ],
                    'cart_total_example' => 250000,
                    'expected_discount' => 37500
                ],

                'cashback_promotion' => [
                    'title' => 'Cashback 5%',
                    'description' => 'Dapatkan cashback 5% dari total belanja',
                    'config' => [
                        'type' => 'cashback',
                        'cashback_percentage' => 5,
                        'max_cashback' => 50000
                    ],
                    'cart_total_example' => 200000,
                    'expected_cashback' => 10000
                ]
            ]
        ]);
    }
}
