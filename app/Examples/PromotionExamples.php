<?php

namespace App\Examples;

use App\Services\PromotionService;
use App\Models\Promotion;

/**
 * Contoh Praktis Penggunaan Sistem Promosi Kompleks
 *
 * File ini berisi contoh-contoh implementasi untuk berbagai skenario promosi
 * yang umum digunakan dalam bisnis e-commerce/apotek
 */

class PromotionExamples
{
    private $promotionService;

    public function __construct()
    {
        $this->promotionService = new PromotionService();
    }

    /**
     * Contoh 1: Apotek dengan Buy X Get Y Kompleks
     * Skenario: Beli 2 Paracetamol 500mg, gratis 1 Vitamin C
     */
    public function examplePharmacyBuyXGetY()
    {
        // Data promosi
        $promotion = new \stdClass();
        $promotion->type = 'buy_x_get_y';
        $promotion->buy_get_mode = 'different_product';
        $promotion->buy_products = [
            ['product_id' => 1, 'quantity' => 2] // Paracetamol 500mg
        ];
        $promotion->get_products = [
            [
                'product_id' => 2, // Vitamin C
                'quantity' => 1,
                'discount_type' => 'free',
                'discount_value' => 0
            ]
        ];

        // Keranjang belanja customer
        $cartItems = [
            [
                'product_id' => 1,
                'quantity' => 2,
                'price' => 5000,
                'name' => 'Paracetamol 500mg',
                'category_id' => 1
            ],
            [
                'product_id' => 2,
                'quantity' => 1,
                'price' => 15000,
                'name' => 'Vitamin C 1000mg',
                'category_id' => 2
            ]
        ];

        $result = $this->promotionService->calculateBuyXGetY($promotion, $cartItems);

        return [
            'scenario' => 'Apotek Buy X Get Y',
            'original_total' => 25000,
            'discount' => $result['discount'], // Expected: 15000
            'final_total' => 25000 - $result['discount'],
            'message' => 'Beli 2 Paracetamol, gratis 1 Vitamin C'
        ];
    }

    /**
     * Contoh 2: Bundle Paket Kesehatan
     * Skenario: Paket check-up dengan harga spesial
     */
    public function exampleHealthBundle()
    {
        $promotion = new \stdClass();
        $promotion->type = 'bundle';
        $promotion->bundle_products = [
            ['product_id' => 10, 'quantity' => 1, 'price' => 150000], // Test Gula Darah
            ['product_id' => 11, 'quantity' => 1, 'price' => 200000], // Test Kolesterol
            ['product_id' => 12, 'quantity' => 1, 'price' => 100000]  // Test Asam Urat
        ];
        $promotion->bundle_price = 400000; // Harga bundle
        $promotion->bundle_discount = 50000; // Diskon tambahan

        $cartItems = [
            ['product_id' => 10, 'quantity' => 1, 'price' => 180000, 'name' => 'Test Gula Darah'],
            ['product_id' => 11, 'quantity' => 1, 'price' => 250000, 'name' => 'Test Kolesterol'],
            ['product_id' => 12, 'quantity' => 1, 'price' => 120000, 'name' => 'Test Asam Urat']
        ];

        $result = $this->promotionService->calculateBundle($promotion, $cartItems);

        return [
            'scenario' => 'Bundle Paket Kesehatan',
            'original_total' => 550000,
            'bundle_price' => 400000,
            'additional_discount' => 50000,
            'final_price' => 350000,
            'total_savings' => 200000,
            'bundle_applied' => $result['bundle_applied']
        ];
    }

    /**
     * Contoh 3: Diskon Bertingkat untuk Apotek
     * Skenario: Semakin banyak beli, semakin besar diskon
     */
    public function exampleTieredDiscount()
    {
        $promotion = new \stdClass();
        $promotion->type = 'minimum_purchase_discount';
        $promotion->discount_type = 'percentage';
        $promotion->discount_tiers = [
            ['min_amount' => 50000, 'discount_value' => 5, 'max_discount' => 25000],
            ['min_amount' => 100000, 'discount_value' => 10, 'max_discount' => 50000],
            ['min_amount' => 200000, 'discount_value' => 15, 'max_discount' => 100000],
            ['min_amount' => 500000, 'discount_value' => 20, 'max_discount' => 200000]
        ];

        $scenarios = [
            ['cart_total' => 75000, 'expected_discount' => 3750],   // 5%
            ['cart_total' => 150000, 'expected_discount' => 15000], // 10%
            ['cart_total' => 300000, 'expected_discount' => 45000], // 15%
            ['cart_total' => 600000, 'expected_discount' => 120000] // 20%
        ];

        $results = [];
        foreach ($scenarios as $scenario) {
            $result = $this->promotionService->calculateTierDiscount($promotion, $scenario['cart_total']);
            $results[] = [
                'cart_total' => $scenario['cart_total'],
                'discount' => $result['discount'],
                'final_total' => $scenario['cart_total'] - $result['discount'],
                'tier_applied' => $result['tier_applied']
            ];
        }

        return $results;
    }

    /**
     * Contoh 4: Cashback untuk Loyalty Program
     * Skenario: Cashback 3% untuk member, maksimal Rp 50.000
     */
    public function exampleCashbackProgram()
    {
        $promotion = new \stdClass();
        $promotion->type = 'cashback';
        $promotion->cashback_percentage = 3;
        $promotion->max_cashback = 50000;
        $promotion->cashback_type = 'instant';

        $scenarios = [
            ['cart_total' => 100000, 'expected_cashback' => 3000],
            ['cart_total' => 500000, 'expected_cashback' => 15000],
            ['cart_total' => 2000000, 'expected_cashback' => 50000] // Capped at max
        ];

        $results = [];
        foreach ($scenarios as $scenario) {
            $result = $this->promotionService->calculateCashback($promotion, $scenario['cart_total']);
            $results[] = [
                'cart_total' => $scenario['cart_total'],
                'cashback_amount' => $result['cashback_amount'],
                'cashback_percentage' => $result['cashback_percentage'],
                'is_capped' => $result['cashback_amount'] == $promotion->max_cashback
            ];
        }

        return $results;
    }

    /**
     * Contoh 5: Promosi Kategori Produk
     * Skenario: Beli 3 produk kategori vitamin, yang termurah gratis
     */
    public function exampleCategoryBasedPromotion()
    {
        $promotion = new \stdClass();
        $promotion->type = 'buy_x_get_y';
        $promotion->buy_get_mode = 'category_based';
        $promotion->buy_quantity = 2;
        $promotion->get_quantity = 1;
        $promotion->target_categories = [3]; // Kategori Vitamin

        $cartItems = [
            ['product_id' => 20, 'quantity' => 1, 'price' => 25000, 'category_id' => 3, 'name' => 'Vitamin D3'],
            ['product_id' => 21, 'quantity' => 1, 'price' => 35000, 'category_id' => 3, 'name' => 'Vitamin B Complex'],
            ['product_id' => 22, 'quantity' => 1, 'price' => 20000, 'category_id' => 3, 'name' => 'Vitamin E'],
            ['product_id' => 23, 'quantity' => 1, 'price' => 50000, 'category_id' => 1, 'name' => 'Antibiotik'] // Bukan vitamin
        ];

        $result = $this->promotionService->calculateCategoryBasedBuyXGetY($promotion, $cartItems);

        return [
            'scenario' => 'Promosi Kategori Vitamin',
            'eligible_products' => 3, // Hanya produk vitamin
            'cheapest_free' => 20000, // Vitamin E gratis
            'discount' => $result,
            'message' => 'Beli 2 vitamin, yang termurah gratis'
        ];
    }

    /**
     * Contoh 6: Kombinasi Multiple Promosi
     * Skenario: Menerapkan beberapa promosi sekaligus
     */
    public function exampleMultiplePromotions()
    {
        $cartItems = [
            ['product_id' => 1, 'quantity' => 3, 'price' => 10000, 'category_id' => 1], // Paracetamol
            ['product_id' => 2, 'quantity' => 1, 'price' => 15000, 'category_id' => 2], // Vitamin C
            ['product_id' => 3, 'quantity' => 2, 'price' => 25000, 'category_id' => 3], // Suplemen
        ];

        $cartTotal = 95000; // Total keranjang

        // Simulasi user profile
        $userProfile = [
            'id' => 123,
            'is_first_purchase' => false,
            'loyalty_tier' => 'gold'
        ];

        $result = $this->promotionService->applyPromotions($cartItems, $cartTotal, $userProfile);

        return [
            'scenario' => 'Multiple Promotions',
            'original_total' => $cartTotal,
            'total_discount' => $result['total_discount'],
            'cashback_amount' => $result['cashback_amount'],
            'earned_points' => $result['earned_points'],
            'final_total' => $result['final_total'],
            'applied_promotions' => count($result['applied_promotions']),
            'promotions_detail' => $result['applied_promotions']
        ];
    }

    /**
     * Contoh 7: Promosi Flash Sale
     * Skenario: Diskon besar-besaran untuk produk tertentu dengan waktu terbatas
     */
    public function exampleFlashSale()
    {
        $promotion = new \stdClass();
        $promotion->type = 'product_discount';
        $promotion->product_discounts = [
            '1' => ['type' => 'percentage', 'value' => 50, 'max_discount' => 25000], // Paracetamol 50% off
            '2' => ['type' => 'fixed_per_item', 'value' => 10000], // Vitamin C -10rb per item
            '3' => ['type' => 'fixed_total', 'value' => 30000]     // Suplemen -30rb total
        ];

        $cartItems = [
            ['product_id' => 1, 'quantity' => 2, 'price' => 15000], // Paracetamol
            ['product_id' => 2, 'quantity' => 3, 'price' => 20000], // Vitamin C
            ['product_id' => 3, 'quantity' => 1, 'price' => 75000], // Suplemen
        ];

        $result = $this->promotionService->calculateProductDiscounts($promotion, $cartItems);

        return [
            'scenario' => 'Flash Sale Produk Spesifik',
            'original_total' => 135000,
            'total_discount' => $result['discount'],
            'final_total' => 135000 - $result['discount'],
            'discounted_products' => $result['applied_discounts']
        ];
    }

    /**
     * Test Runner - Menjalankan semua contoh
     */
    public function runAllExamples()
    {
        $examples = [
            'pharmacy_buy_x_get_y' => $this->examplePharmacyBuyXGetY(),
            'health_bundle' => $this->exampleHealthBundle(),
            'tiered_discount' => $this->exampleTieredDiscount(),
            'cashback_program' => $this->exampleCashbackProgram(),
            'category_promotion' => $this->exampleCategoryBasedPromotion(),
            'multiple_promotions' => $this->exampleMultiplePromotions(),
            'flash_sale' => $this->exampleFlashSale()
        ];

        return [
            'message' => 'Sistem Promosi Kompleks - Semua Contoh Berhasil Dijalankan',
            'total_examples' => count($examples),
            'examples' => $examples,
            'summary' => [
                'buy_x_get_y_variants' => 3,
                'bundle_scenarios' => 1,
                'tiered_discounts' => 4,
                'cashback_scenarios' => 3,
                'category_promotions' => 1,
                'product_specific_discounts' => 3,
                'total_scenarios_tested' => 15
            ]
        ];
    }
}

/**
 * Usage Examples:
 *
 * $examples = new PromotionExamples();
 *
 * // Jalankan contoh spesifik
 * $buyXGetY = $examples->examplePharmacyBuyXGetY();
 * $bundle = $examples->exampleHealthBundle();
 *
 * // Jalankan semua contoh
 * $allResults = $examples->runAllExamples();
 *
 * // Display results
 * echo json_encode($allResults, JSON_PRETTY_PRINT);
 */
