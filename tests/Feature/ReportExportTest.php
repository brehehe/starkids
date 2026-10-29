<?php

namespace Tests\Feature;

use App\Exports\GenericArrayExport;
use App\Livewire\Admin\Consultation\History\AdminConsultationHistoryIndex;
use App\Livewire\Admin\Logistic\ProductStock\AdminLogisticProductStockIndex;
use App\Livewire\Admin\Report\Action\AdminReportActionIndex;
use App\Livewire\Admin\Report\Polyclinic\AdminReportPolyclinicIndex;
use App\Livewire\Admin\Report\Purchase\AdminReportPurchaseIndex;
use App\Livewire\Admin\Report\Stock\AdminReportStockIndex;
use App\Models\Company\Company;
use App\Models\Spatie\Role;
use App\Models\User;
use App\Models\User\UserCompanyRole;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;
use Tests\TestCase;

class ReportExportTest extends TestCase
{
    use RefreshDatabase;

    private function createAuthenticatedUser(): User
    {
        $company = Company::create([
            'name' => 'Test Clinic',
            'code' => 'TC01',
            'phone' => '081234567890',
            'email' => 'clinic@test.com',
            'address' => 'Jl. Kesehatan No. 1',
        ]);

        $role = Role::firstOrCreate([
            'name' => 'Super Admin',
            'guard_name' => 'web',
        ]);

        $user = User::factory()->create([
            'type_user' => 'employee',
            'company_id' => $company->id,
        ]);

        UserCompanyRole::create([
            'user_id' => $user->id,
            'company_id' => $company->id,
            'role_id' => $role->uuid,
            'is_active' => true,
        ]);

        return $user;
    }

    public function test_generic_array_export_generates_valid_collection(): void
    {
        $export = new GenericArrayExport(
            headings: ['No', 'Nama Produk', 'Stok'],
            rows: [
                [1, 'Paracetamol', 50],
                [2, 'Amoxicillin', 30],
            ],
            title: 'Laporan Stok Test'
        );

        $array = $export->array();
        $this->assertCount(2, $array);
        $this->assertEquals(['No', 'Nama Produk', 'Stok'], $export->headings());
    }

    public function test_report_stock_export_excel_and_pdf(): void
    {
        $user = $this->createAuthenticatedUser();

        Livewire::actingAs($user)
            ->test(AdminReportStockIndex::class)
            ->call('exportExcel')
            ->assertFileDownloaded();

        Livewire::actingAs($user)
            ->test(AdminReportStockIndex::class)
            ->call('exportPDF')
            ->assertFileDownloaded();
    }

    public function test_report_action_export_excel_and_pdf(): void
    {
        $user = $this->createAuthenticatedUser();

        Livewire::actingAs($user)
            ->test(AdminReportActionIndex::class)
            ->call('exportExcel')
            ->assertFileDownloaded();

        Livewire::actingAs($user)
            ->test(AdminReportActionIndex::class)
            ->call('exportPDF')
            ->assertFileDownloaded();
    }

    public function test_consultation_history_export_excel_and_pdf(): void
    {
        $user = $this->createAuthenticatedUser();

        Livewire::actingAs($user)
            ->test(AdminConsultationHistoryIndex::class)
            ->call('exportExcel')
            ->assertFileDownloaded();

        Livewire::actingAs($user)
            ->test(AdminConsultationHistoryIndex::class)
            ->call('exportPDF')
            ->assertFileDownloaded();
    }

    public function test_logistic_product_stock_export_excel_and_pdf(): void
    {
        $user = $this->createAuthenticatedUser();

        Livewire::actingAs($user)
            ->test(AdminLogisticProductStockIndex::class)
            ->call('exportExcel')
            ->assertFileDownloaded();

        Livewire::actingAs($user)
            ->test(AdminLogisticProductStockIndex::class)
            ->call('exportPDF')
            ->assertFileDownloaded();
    }

    public function test_report_purchase_export_excel_and_pdf(): void
    {
        $user = $this->createAuthenticatedUser();

        Livewire::actingAs($user)
            ->test(AdminReportPurchaseIndex::class)
            ->call('exportExcel')
            ->assertFileDownloaded();

        Livewire::actingAs($user)
            ->test(AdminReportPurchaseIndex::class)
            ->call('exportPDF')
            ->assertFileDownloaded();
    }

    public function test_report_polyclinic_export_excel_and_pdf(): void
    {
        $user = $this->createAuthenticatedUser();

        Livewire::actingAs($user)
            ->test(AdminReportPolyclinicIndex::class)
            ->call('exportExcel')
            ->assertFileDownloaded();

        Livewire::actingAs($user)
            ->test(AdminReportPolyclinicIndex::class)
            ->call('exportPDF')
            ->assertFileDownloaded();
    }
}
