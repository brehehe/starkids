<?php

namespace Database\Seeders;

use App\Models\Company\Company;
use App\Models\Promotion\PromotionSimplified;
use Illuminate\Database\Seeder;

class PromotionSystemSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $companyId = Company::first()->id;

        // Create sample promotions
        PromotionSimplified::create([
            'company_id' => $companyId,
            'name' => 'Diskon 20% Weekend',
            'description' => 'Dapatkan diskon 20% untuk semua produk di akhir pekan',
            'code' => 'WEEKEND20',
            'type' => 'discount',
            'discount_type' => 'percentage',
            'discount_value' => 20.00,
            'max_discount' => 100000.00,
            'minimum_purchase' => 50000.00,
            'is_active' => true,
            'is_unlimited' => false,
            'total_quota' => 100,
            'quota_per_user' => 2,
            'used_count' => 0,
            'start_date' => '2025-07-28 00:00:00',
            'end_date' => '2025-08-28 23:59:59',
            'applicable_days' => json_encode(['saturday', 'sunday']),
            'applicable_products' => null,
            'applicable_user_types' => json_encode(['customer', 'member']),
            'terms_conditions' => json_encode([
                'Berlaku untuk semua produk',
                'Tidak dapat digabung dengan promo lain',
                'Minimal pembelian Rp 50.000',
            ]),
            'is_featured' => true,
            'can_combine_with_other' => false,
        ]);

        PromotionSimplified::create([
            'company_id' => $companyId,
            'name' => 'Beli 2 Gratis 1',
            'description' => 'Beli 2 produk gratis 1 produk termurah',
            'code' => 'BUY2GET1',
            'type' => 'buy_x_get_y',
            'buy_quantity' => 2,
            'get_quantity' => 1,
            'minimum_purchase' => 0,
            'is_active' => true,
            'is_unlimited' => true,
            'quota_per_user' => 5,
            'used_count' => 0,
            'start_date' => '2025-07-28 00:00:00',
            'end_date' => '2025-08-28 23:59:59',
            'applicable_products' => null,
            'applicable_user_types' => null,
            'terms_conditions' => json_encode([
                'Berlaku untuk produk kategori tertentu',
                'Gratis produk dengan harga termurah',
            ]),
            'is_featured' => false,
            'can_combine_with_other' => true,
        ]);

        PromotionSimplified::create([
            'company_id' => $companyId,
            'name' => 'Cashback 10%',
            'description' => 'Dapatkan cashback 10% untuk pembelian minimal Rp 100.000',
            'code' => 'CASHBACK10',
            'type' => 'special',
            'special_type' => 'cashback',
            'cashback_percentage' => 10.00,
            'minimum_purchase' => 100000.00,
            'is_active' => true,
            'is_unlimited' => false,
            'total_quota' => 50,
            'quota_per_user' => 1,
            'used_count' => 0,
            'start_date' => '2025-07-28 00:00:00',
            'end_date' => '2025-08-15 23:59:59',
            'applicable_products' => null,
            'applicable_user_types' => json_encode(['member', 'vip']),
            'terms_conditions' => json_encode([
                'Cashback maksimal Rp 50.000',
                'Berlaku untuk member dan VIP',
                'Cashback akan dikirim dalam 3 hari kerja',
            ]),
            'is_featured' => true,
            'can_combine_with_other' => false,
        ]);

        PromotionSimplified::create([
            'company_id' => $companyId,
            'name' => 'Paket Bundle Hemat',
            'description' => 'Paket bundle 3 produk dengan harga spesial',
            'code' => 'BUNDLE3',
            'type' => 'bundle',
            'bundle_price' => 150000.00,
            'bundle_products' => json_encode([
                ['product_id' => 1, 'quantity' => 1],
                ['product_id' => 2, 'quantity' => 1],
                ['product_id' => 3, 'quantity' => 1],
            ]),
            'minimum_purchase' => 0,
            'is_active' => true,
            'is_unlimited' => false,
            'total_quota' => 25,
            'quota_per_user' => 1,
            'used_count' => 0,
            'start_date' => '2025-07-28 00:00:00',
            'end_date' => '2025-08-20 23:59:59',
            'applicable_products' => json_encode([1, 2, 3]),
            'applicable_user_types' => null,
            'terms_conditions' => json_encode([
                'Paket bundle tidak dapat diubah',
                'Hemat hingga 30% dari harga normal',
            ]),
            'is_featured' => false,
            'can_combine_with_other' => false,
        ]);

        echo "✅ Promotion system seeder completed!\n";
        echo "Created 4 sample promotions:\n";
        echo "1. WEEKEND20 - 20% discount for weekends\n";
        echo "2. BUY2GET1 - Buy 2 get 1 free\n";
        echo "3. CASHBACK10 - 10% cashback\n";
        echo "4. BUNDLE3 - Bundle package deal\n";
    }
}
