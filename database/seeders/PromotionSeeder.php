<?php

namespace Database\Seeders;

use App\Models\Promotion\Promotion;
use App\Models\Company\Company;
use Illuminate\Database\Seeder;
use Carbon\Carbon;

class PromotionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $companies = Company::all();

        foreach ($companies as $company) {
            // Promo Percentage Discount
            Promotion::create([
                'name' => 'Diskon Akhir Tahun',
                'code' => 'YEAR2025',
                'description' => 'Dapatkan diskon hingga 20% untuk semua pembelian dengan minimal transaksi Rp 100.000',
                'promotion_scope' => 'public',
                'type' => 'percentage',
                'promotion_type' => 'persen',
                'promotion_value' => 20.00,
                'max_discount' => 50000.00,
                'minimum_purchase' => 100000.00,
                'start_date' => Carbon::now()->subDays(7),
                'end_date' => Carbon::now()->addDays(30),
                'total_quota' => 100,
                'quota_per_user' => 1,
                'is_unlimited' => false,
                'is_active' => true,
                'is_stackable' => false,
                'is_auto_apply' => false,
                'priority' => 10,
                'banner_text' => 'HEMAT HINGGA 20%!',
                'terms_conditions' => [
                    'Berlaku untuk semua produk',
                    'Tidak dapat digabung dengan promo lain',
                    'Berlaku hingga ' . Carbon::now()->addDays(30)->format('d M Y')
                ],
                'company_id' => $company->id,
            ]);

            // Promo Fixed Amount
            Promotion::create([
                'name' => 'Cashback Rp 25.000',
                'code' => 'CASHBACK25',
                'description' => 'Dapatkan potongan langsung Rp 25.000 untuk pembelian minimal Rp 200.000',
                'promotion_scope' => 'public',
                'type' => 'fixed_amount',
                'promotion_type' => 'rupiah',
                'promotion_value' => 25000.00,
                'minimum_purchase' => 200000.00,
                'start_date' => Carbon::now(),
                'end_date' => Carbon::now()->addDays(14),
                'total_quota' => 50,
                'quota_per_user' => 2,
                'is_unlimited' => false,
                'is_active' => true,
                'is_stackable' => true,
                'is_auto_apply' => false,
                'priority' => 8,
                'banner_text' => 'HEMAT RP 25.000!',
                'company_id' => $company->id,
            ]);

            // Promo Member Exclusive
            Promotion::create([
                'name' => 'Member VIP Discount',
                'code' => 'VIP15',
                'description' => 'Diskon khusus member VIP 15% untuk semua produk',
                'promotion_scope' => 'private',
                'type' => 'percentage',
                'promotion_type' => 'persen',
                'promotion_value' => 15.00,
                'max_discount' => 100000.00,
                'minimum_purchase' => 50000.00,
                'start_date' => Carbon::now()->subDays(1),
                'end_date' => Carbon::now()->addMonths(3),
                'is_unlimited' => true,
                'is_active' => true,
                'is_stackable' => false,
                'is_auto_apply' => true,
                'priority' => 15,
                'user_types' => ['vip'], // Contoh user type
                'banner_text' => 'EKSKLUSIF MEMBER VIP',
                'company_id' => $company->id,
            ]);

            // Promo Buy X Get Y
            Promotion::create([
                'name' => 'Beli 2 Gratis 1',
                'code' => 'BUY2GET1',
                'description' => 'Beli 2 produk pilihan dan dapatkan 1 gratis (yang termurah)',
                'promotion_scope' => 'public',
                'type' => 'buy_x_get_y',
                'promotion_type' => 'rupiah',
                'buy_quantity' => 2,
                'get_quantity' => 1,
                'minimum_purchase' => 0,
                'start_date' => Carbon::now(),
                'end_date' => Carbon::now()->addDays(7),
                'total_quota' => 30,
                'quota_per_user' => 3,
                'is_unlimited' => false,
                'is_active' => true,
                'is_stackable' => false,
                'is_auto_apply' => false,
                'priority' => 12,
                'banner_text' => 'BELI 2 GRATIS 1',
                'company_id' => $company->id,
            ]);

            // Promo Weekend Special
            Promotion::create([
                'name' => 'Weekend Super Sale',
                'code' => 'WEEKEND30',
                'description' => 'Diskon 30% khusus weekend (Sabtu-Minggu) jam 10:00-22:00',
                'promotion_scope' => 'public',
                'type' => 'percentage',
                'promotion_type' => 'persen',
                'promotion_value' => 30.00,
                'max_discount' => 75000.00,
                'minimum_purchase' => 150000.00,
                'start_date' => Carbon::now()->startOfWeek()->addDays(5), // Sabtu
                'end_date' => Carbon::now()->addWeeks(4)->endOfWeek()->subDay(), // Minggu 4 minggu ke depan
                'start_time' => '10:00:00',
                'end_time' => '22:00:00',
                'applicable_days' => ['saturday', 'sunday'],
                'total_quota' => 200,
                'quota_per_user' => 4,
                'is_unlimited' => false,
                'is_active' => true,
                'is_stackable' => false,
                'is_auto_apply' => false,
                'priority' => 20,
                'banner_text' => 'WEEKEND SUPER SALE 30%!',
                'terms_conditions' => [
                    'Berlaku khusus hari Sabtu dan Minggu',
                    'Jam operasional: 10:00 - 22:00',
                    'Minimal pembelian Rp 150.000',
                    'Maksimal diskon Rp 75.000'
                ],
                'company_id' => $company->id,
            ]);

            // Promo First Time Buyer
            Promotion::create([
                'name' => 'Welcome New Customer',
                'code' => 'WELCOME10',
                'description' => 'Selamat datang! Nikmati diskon 10% untuk pembelian pertama Anda',
                'promotion_scope' => 'public',
                'type' => 'first_time_buyer',
                'promotion_type' => 'persen',
                'promotion_value' => 10.00,
                'max_discount' => 30000.00,
                'minimum_purchase' => 75000.00,
                'start_date' => Carbon::now()->subDays(30),
                'end_date' => Carbon::now()->addMonths(6),
                'is_unlimited' => true,
                'quota_per_user' => 1,
                'is_active' => true,
                'is_stackable' => true,
                'is_auto_apply' => true,
                'priority' => 5,
                'banner_text' => 'SELAMAT DATANG!',
                'company_id' => $company->id,
            ]);
        }
    }
}
