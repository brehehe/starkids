<?php

namespace Tests\Feature;

use App\Livewire\Admin\Consultation\Consultation\Detail\AdminConsultationConsultationDetailIndex;
use App\Livewire\Admin\Master\Action\AdminMasterActionIndex;
use App\Livewire\Admin\Master\Doctor\AdminMasterDoctorIndex;
use App\Livewire\Admin\Master\Service\AdminMasterServiceIndex;
use App\Models\Branch\Branch;
use App\Models\Company\Company;
use App\Models\Practitiont\Practitioner;
use App\Models\Product\Product;
use App\Models\Product\ProductPrice;
use App\Models\Product\ProductType;
use App\Models\Role\RoleCompany;
use App\Models\Spatie\Role;
use App\Models\Transaction\Transaction;
use App\Models\Transaction\TransactionPhysicalExamination;
use App\Models\User;
use App\Models\User\UserDetail;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Str;
use Livewire\Livewire;
use Tests\TestCase;

class MasterDoctorAndNumericDefaultsTest extends TestCase
{
    use RefreshDatabase;

    protected $company;

    protected $branch;

    protected $user;

    protected function setUp(): void
    {
        parent::setUp();

        $this->company = Company::create([
            'id' => (string) Str::uuid(),
            'code' => 'TESTCOMP',
            'name' => 'Starkids Medical Center',
            'email' => 'test@starkids.com',
            'phone' => '081234567890',
            'website' => 'starkids.com',
            'is_active' => true,
        ]);

        $this->branch = Branch::create([
            'company_id' => $this->company->id,
            'name' => 'Main Branch',
        ]);

        $this->user = User::factory()->create([
            'company_id' => $this->company->id,
            'email' => 'admin@starkids.com',
            'phone' => '081299999999',
            'username' => 'adminstarkids',
            'type_user' => 'employee',
        ]);

        $roleDokter = Role::firstOrCreate(['name' => 'Dokter', 'guard_name' => 'web']);
        Role::firstOrCreate(['name' => 'Perawat', 'guard_name' => 'web']);
        Role::firstOrCreate(['name' => 'Terapis', 'guard_name' => 'web']);
        Role::firstOrCreate(['name' => 'Super Admin', 'guard_name' => 'web']);

        RoleCompany::firstOrCreate([
            'role_id' => $roleDokter->uuid ?? $roleDokter->id,
            'company_id' => $this->company->id,
        ]);

        ProductType::firstOrCreate(['name' => 'Jasa']);
        ProductType::firstOrCreate(['name' => 'Tindakan']);
        ProductType::firstOrCreate(['name' => 'Paket']);
    }

    public function test_doctor_validation_allows_nullable_str_sip_and_specialization(): void
    {
        $practitioner = Practitioner::create([
            'nik' => '3578150204840002',
            'company_id' => $this->company->id,
            'practitioner_id' => '10002967812',
            'name' => 'dr. Felix Setiawan',
        ]);

        Livewire::actingAs($this->user)
            ->test(AdminMasterDoctorIndex::class)
            ->set('role_name', 'Dokter')
            ->set('name', 'dr. Felix Setiawan')
            ->set('phone', '081211112222')
            ->set('password', 'password123')
            ->set('address', 'Jl. Medika 123')
            ->set('administrative_gender', 'male')
            ->set('nik', '3578150204840002')
            ->set('doctor_id', '10002967812')
            ->set('practitioner_id', $practitioner->id)
            ->set('license_number', '') // STR empty
            ->set('sip_number', '')      // SIP empty
            ->set('specialization', '')  // Spesialis empty
            ->set('price_doctor', '')    // Biaya konsultasi empty
            ->set('doctor_type', 'general')
            ->call('submit')
            ->assertHasNoErrors();

        $createdUser = User::where('name', 'dr. Felix Setiawan')->first();
        $this->assertNotNull($createdUser);
        $detail = UserDetail::where('user_id', $createdUser->id)->first();
        $this->assertNotNull($detail);
        $this->assertNull($detail->sip_number);
        $this->assertNull($detail->specialization);
        $this->assertNull($detail->license_number);
    }

    public function test_service_master_defaults_to_zero_when_price_and_hpp_are_empty(): void
    {
        Livewire::actingAs($this->user)
            ->test(AdminMasterServiceIndex::class)
            ->set('name', 'Konsultasi Online')
            ->set('description', 'Layanan telemedisin')
            ->set('hpp_average', '')
            ->set('price', '')
            ->call('save')
            ->assertHasNoErrors();

        $product = Product::where('name', 'Konsultasi Online')->first();
        $this->assertNotNull($product);

        $price = ProductPrice::where('product_id', $product->id)->first();
        $this->assertNotNull($price);
        $this->assertEquals(0, $price->price);
        $this->assertEquals(0, $price->hpp_average);
    }

    public function test_action_master_defaults_to_zero_when_numbers_are_empty(): void
    {
        Livewire::actingAs($this->user)
            ->test(AdminMasterActionIndex::class)
            ->set('name', 'Nebulizer Anak')
            ->set('description', 'Tindakan uap')
            ->set('hpp_average', '')
            ->set('price', '')
            ->set('type_incentive_nurse', 'rupiah')
            ->set('type_incentive_doctor', 'rupiah')
            ->set('incentive_nurse', '')
            ->set('incentive_doctor', '')
            ->call('save')
            ->assertHasNoErrors();

        $product = Product::where('name', 'Nebulizer Anak')->first();
        $this->assertNotNull($product);
        $this->assertEquals(0, $product->incentive_doctor);
        $this->assertEquals(0, $product->incentive_nurse);

        $price = ProductPrice::where('product_id', $product->id)->first();
        $this->assertNotNull($price);
        $this->assertEquals(0, $price->price);
        $this->assertEquals(0, $price->hpp_average);
    }

    public function test_consultation_detail_observasi_saves_zero_when_entered_or_cleared(): void
    {
        $patient = User::factory()->create([
            'company_id' => $this->company->id,
            'type_user' => 'patient',
        ]);

        $transaction = Transaction::create([
            'id' => (string) Str::uuid(),
            'code' => 'TRX-TEST-001',
            'company_id' => $this->company->id,
            'patient_id' => $patient->id,
            'status' => 'consultation',
            'grand_total_price' => 100000,
            'type' => 'konsultasi',
            'created_at' => now(),
        ]);

        session(['transaction_id' => $transaction->id]);

        Livewire::actingAs($this->user)
            ->test(AdminConsultationConsultationDetailIndex::class)
            ->set('weight', '0')
            ->set('height', '0')
            ->set('head_circumference', '')
            ->assertSet('weight', '0')
            ->assertSet('height', '0')
            ->assertSet('head_circumference', '0');

        $exam = TransactionPhysicalExamination::where('transaction_id', $transaction->id)->first();
        $this->assertNotNull($exam);
        $this->assertEquals('0', $exam->weight);
        $this->assertEquals('0', $exam->height);
        $this->assertEquals('0', $exam->head_circumference);
    }
}
