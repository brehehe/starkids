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
        $response->assertSee('window.print');
        $response->assertSee('autoprint');
    }

    public function test_user_with_null_company_can_view_invoice_and_recipe_without_error(): void
    {
        [$company, $user, $branch] = $this->setupCompanyAndUser();

        // Simulate user with null company_id
        $userWithoutCompany = User::factory()->create([
            'type_user' => 'employee',
            'company_id' => null,
        ]);

        $this->actingAs($userWithoutCompany);

        $transaction = Transaction::create([
            'code' => 'TRXNULLCOMP123',
            'company_id' => $company->id,
            'branch_id' => $branch->id,
            'user_id' => $user->id,
            'sub_total_price_before_rounding' => 150000,
            'rounding' => 0,
            'promotion_real' => 0,
            'discount_value' => 0,
            'grand_total_price_admin_fee' => 150000,
            'payment_amount' => 150000,
            'payment_change' => 0,
            'status' => 'completed',
        ]);

        // Invoice print
        $invoiceRes = $this->get(route('print.invoice', $transaction->id));
        $invoiceRes->assertStatus(200);
        $invoiceRes->assertSee('Starkids Medical Center');
        $invoiceRes->assertSee('window.print');

        // Invoice total print
        $invoiceTotalRes = $this->get(route('print.invoice-total', $transaction->id));
        $invoiceTotalRes->assertStatus(200);
        $invoiceTotalRes->assertSee('Starkids Medical Center');
        $invoiceTotalRes->assertSee('window.print');

        // Recipe page (Livewire)
        $recipeRes = $this->get(route('user.receipt.recipe', $transaction->id));
        $recipeRes->assertStatus(200);
        $recipeRes->assertSee('COPY RESEP');
        $recipeRes->assertSee('Starkids Medical Center');

        // Receipt kwitansi page (Livewire)
        $kwitansiRes = $this->get(route('user.receipt.receipt', $transaction->id));
        $kwitansiRes->assertStatus(200);
        $kwitansiRes->assertSee('KWITANSI PEMBAYARAN');
        $kwitansiRes->assertSee('Starkids Medical Center');

        // Receipt invoice page (Livewire)
        $receiptInvoiceRes = $this->get(route('user.receipt.invoice', $transaction->id));
        $receiptInvoiceRes->assertStatus(200);
        $receiptInvoiceRes->assertSee('Starkids Medical Center');

        // Layout POS app view with null company user
        $posLayoutView = $this->view('layout.pos.app', ['slot' => '<div>POS Test Content</div>']);
        $posLayoutView->assertSee('asset/img/icon.webp');

        // Layout app view with null company user
        $appLayoutView = $this->view('layout.app', ['slot' => '<div>App Test Content</div>']);
        $appLayoutView->assertSee('asset/img/icon.webp');
    }

    public function test_user_can_view_invoice_a5_and_invoice_total_a5_routes(): void
    {
        [$company, $user, $branch] = $this->setupCompanyAndUser();

        $this->actingAs($user);

        $transaction = Transaction::create([
            'code' => 'TRXTESTA5999',
            'company_id' => $company->id,
            'branch_id' => $branch->id,
            'user_id' => $user->id,
            'sub_total_price_before_rounding' => 250000,
            'rounding' => 0,
            'promotion_real' => 0,
            'discount_value' => 0,
            'grand_total_price_admin_fee' => 250000,
            'payment_amount' => 250000,
            'payment_change' => 0,
            'status' => 'completed',
        ]);

        // A5 Invoice
        $responseA5 = $this->get(route('print.invoice.a5', $transaction->id));
        $responseA5->assertStatus(200);
        $responseA5->assertSee('paper-a5');
        $responseA5->assertSee('Kertas A5');

        // A5 Invoice Total
        $responseTotalA5 = $this->get(route('print.invoice-total.a5', $transaction->id));
        $responseTotalA5->assertStatus(200);
        $responseTotalA5->assertSee('paper-a5');
        $responseTotalA5->assertSee('Kertas A5');

        // Thermal Invoice (default)
        $responseThermal = $this->get(route('print.invoice', $transaction->id));
        $responseThermal->assertStatus(200);
        $responseThermal->assertSee('paper-thermal');
        $responseThermal->assertSee('Struk Thermal');
    }
}
