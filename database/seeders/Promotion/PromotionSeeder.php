<?php

namespace Database\Seeders\Promotion;

use App\Models\Promotion\PromotionEvent;
use App\Models\Company\Company;
use App\Models\User;
use Illuminate\Database\Seeder;
use Carbon\Carbon;
use Illuminate\Support\Str;

class PromotionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Get first company for demo
        $company = Company::first();
        $user = User::first();

        if (!$company || !$user) {
            $this->command->error('Company atau User tidak ditemukan. Jalankan CompanySeeder terlebih dahulu.');
            return;
        }

        $this->command->info('🎉 Creating promotion samples...');

        $promotions = [
            [
                'code' => 'DISKON20',
                'name' => 'Diskon 20% untuk Pembelian Minimal 100rb',
                'description' => 'Dapatkan diskon 20% untuk semua produk dengan minimal pembelian Rp 100.000',
                'type' => 'percentage',
                'start_date' => Carbon::now(),
                'end_date' => Carbon::now()->addMonths(1),
                'discount_value' => 20.00,
                'minimum_purchase' => 100000.00,
                'maximum_discount' => 50000.00,
                'usage_limit' => 100,
                'usage_limit_per_customer' => 1,
                'customer_type' => 'all',
                'applicable_to' => 'all_products',
                'auto_apply' => false,
                'is_active' => true,
                'is_featured' => true,
                'terms_conditions' => [
                    'Berlaku untuk semua produk',
                    'Tidak dapat digabung dengan promosi lain',
                    'Berlaku hingga ' . Carbon::now()->addMonths(1)->format('d M Y')
                ]
            ],
            [
                'code' => 'POTONGAN50K',
                'name' => 'Potongan Langsung 50 Ribu',
                'description' => 'Potongan langsung Rp 50.000 untuk pembelian minimal Rp 200.000',
                'type' => 'fixed_amount',
                'start_date' => Carbon::now(),
                'end_date' => Carbon::now()->addWeeks(2),
                'discount_value' => 50000.00,
                'minimum_purchase' => 200000.00,
                'maximum_discount' => null,
                'usage_limit' => 50,
                'usage_limit_per_customer' => 2,
                'customer_type' => 'existing',
                'applicable_to' => 'all_products',
                'auto_apply' => true,
                'is_active' => true,
                'is_featured' => false,
                'terms_conditions' => [
                    'Khusus untuk customer existing',
                    'Maksimal 2x penggunaan per customer',
                    'Auto apply jika memenuhi syarat'
                ]
            ],
            [
                'code' => 'BELI2GRATIS1',
                'name' => 'Beli 2 Gratis 1 - Produk Pilihan',
                'description' => 'Beli 2 produk pilihan, dapatkan 1 produk gratis',
                'type' => 'buy_x_get_y',
                'start_date' => Carbon::now()->subDays(5),
                'end_date' => Carbon::now()->addDays(10),
                'discount_value' => null,
                'minimum_purchase' => 0.00,
                'maximum_discount' => null,
                'buy_quantity' => 2,
                'get_quantity' => 1,
                'usage_limit' => 30,
                'usage_limit_per_customer' => 1,
                'customer_type' => 'all',
                'applicable_to' => 'specific_products',
                'product_ids' => [], // akan diisi product IDs yang spesifik
                'auto_apply' => false,
                'is_active' => true,
                'is_featured' => true,
                'terms_conditions' => [
                    'Berlaku untuk produk pilihan saja',
                    'Produk gratis dengan nilai terendah',
                    'Tidak berlaku untuk produk sale'
                ]
            ],
            [
                'code' => 'PAKETSEHAT',
                'name' => 'Paket Sehat Bundle - Vitamin & Suplemen',
                'description' => 'Paket bundling vitamin dan suplemen dengan harga spesial',
                'type' => 'bundle',
                'start_date' => Carbon::now(),
                'end_date' => Carbon::now()->addMonths(2),
                'discount_value' => null,
                'minimum_purchase' => 0.00,
                'maximum_discount' => null,
                'bundle_price' => 150000.00,
                'bundle_products' => [
                    ['product_id' => 'vitamin-c-id', 'quantity' => 1],
                    ['product_id' => 'vitamin-d-id', 'quantity' => 1],
                    ['product_id' => 'multivitamin-id', 'quantity' => 1]
                ],
                'usage_limit' => null,
                'usage_limit_per_customer' => 5,
                'customer_type' => 'all',
                'applicable_to' => 'specific_products',
                'auto_apply' => false,
                'is_active' => true,
                'is_featured' => true,
                'terms_conditions' => [
                    'Paket harus dibeli lengkap',
                    'Tidak bisa beli sebagian',
                    'Hemat 30% dari harga normal'
                ]
            ],
            [
                'code' => 'CASHBACK10',
                'name' => 'Cashback 10% - Maksimal 25rb',
                'description' => 'Dapatkan cashback 10% untuk setiap pembelian, maksimal Rp 25.000',
                'type' => 'cashback',
                'start_date' => Carbon::now()->addDays(3),
                'end_date' => Carbon::now()->addMonths(3),
                'discount_value' => 10.00,
                'minimum_purchase' => 50000.00,
                'maximum_discount' => 25000.00,
                'usage_limit' => 200,
                'usage_limit_per_customer' => 3,
                'customer_type' => 'vip',
                'applicable_to' => 'all_products',
                'auto_apply' => true,
                'is_active' => true,
                'is_featured' => false,
                'terms_conditions' => [
                    'Khusus member VIP',
                    'Cashback dikreditkan dalam 3 hari kerja',
                    'Maksimal 3x per bulan'
                ]
            ],
            [
                'code' => 'PELANGGANSETIA',
                'name' => 'Loyalty Points Double',
                'description' => 'Dapatkan poin loyalitas 2x lipat untuk setiap pembelian',
                'type' => 'loyalty_points',
                'start_date' => Carbon::now(),
                'end_date' => Carbon::now()->addMonths(6),
                'discount_value' => 2.00, // 2x multiplier
                'minimum_purchase' => 0.00,
                'maximum_discount' => null,
                'usage_limit' => null,
                'usage_limit_per_customer' => null,
                'customer_type' => 'existing',
                'applicable_to' => 'all_products',
                'auto_apply' => true,
                'is_active' => true,
                'is_featured' => false,
                'terms_conditions' => [
                    'Poin akan dikreditkan otomatis',
                    'Berlaku untuk semua pembelian',
                    'Poin dapat ditukar dengan reward'
                ]
            ]
        ];

        foreach ($promotions as $promotionData) {
            $promotionData['company_id'] = $company->id;
            $promotionData['created_by'] = $user->id;
            $promotionData['used_count'] = 0;

            // Generate unique ID
            $promotionData['id'] = Str::uuid();

            PromotionEvent::create($promotionData);

            $this->command->info("✅ Created promotion: {$promotionData['name']}");
        }

        $this->command->info("🎉 Promotion seeding completed! Created " . count($promotions) . " promotions.");
    }
}
