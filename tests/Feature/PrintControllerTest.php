<?php

namespace Tests\Feature;

use App\Models\Branch\Branch;
use App\Models\Company\Company;
use App\Models\Company\CompanyDetail;
use App\Models\Transaction\Transaction;
use App\Models\User;
use App\Models\User\UserType;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PrintControllerTest extends TestCase
{
    use RefreshDatabase;

    private function setupCompanyAndUser(): array
    {
        $company = Company::create([
            'name' => 'Starkids Medical Center',
            'code' => 'Strkds',
            'email' => 'starkids@example.com',
            'phone' => '081234567890',
            'is_main' => true,
        ]);

        CompanyDetail::create([
            'company_id' => $company->id,
            'address' => 'Jl. Dharmahusada Indah I No. 17',
            'city' => 'Kota Surabaya',
            'province' => 'Jawa Timur',
        ]);

        $branch = Branch::create([
            'company_id' => $company->id,
            'name' => 'Pusat',
            'code' => 'PST',
        ]);

        $userType = UserType::create([
            'name' => 'Umum',
            'company_id' => $company->id,
        ]);

        $user = User::factory()->create([
            'type_user' => 'employee',
            'email_verified_at' => now(),
            'company_id' => $company->id,
        ]);

        return [$company, $user, $branch];
    }

    public function test_user_can_view_invoice_print(): void
    {
        [$company, $user, $branch] = $this->setupCompanyAndUser();

        $this->actingAs($user);

        $transaction = Transaction::create([
            'code' => 'TRXTEST123456',
            'company_id' => $company->id,
            'branch_id' => $branch->id,
            'user_id' => $user->id,
            'sub_total_price_before_rounding' => 100000,
            'rounding' => 0,
            'promotion_real' => 0,
            'discount_value' => 0,
            'grand_total_price_admin_fee' => 100000,
            'payment_amount' => 100000,
            'payment_change' => 0,
            'status' => 'completed',
        ]);

        $response = $this->get(route('print.invoice', $transaction->id));

        $response->assertStatus(200);
        $response->assertSee('TRXTEST123456');
        $response->assertSee('Starkids Medical Center');
        $response->assertSee('DETAIL TRANSAKSI');
    }

    public function test_user_can_view_invoice_total_print(): void
    {
        [$company, $user, $branch] = $this->setupCompanyAndUser();

        $this->actingAs($user);

        $transaction = Transaction::create([
            'code' => 'TRXTEST789012',
            'company_id' => $company->id,
            'branch_id' => $branch->id,
            'user_id' => $user->id,
            'sub_total_price_before_rounding' => 200000,
            'rounding' => 0,
            'promotion_real' => 0,
            'discount_value' => 0,
            'grand_total_price_admin_fee' => 200000,
            'payment_amount' => 200000,
            'payment_change' => 0,
            'status' => 'completed',
        ]);

        $response = $this->get(route('print.invoice-total', $transaction->id));

        $response->assertStatus(200);
        $response->assertSee('TRXTEST789012');
        $response->assertSee('Jasa Dokter');
        $response->assertSee('Obat Obatan');
    }
}
