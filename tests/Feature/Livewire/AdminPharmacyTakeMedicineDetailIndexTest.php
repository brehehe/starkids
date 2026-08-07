<?php

namespace Tests\Feature\Livewire;

use App\Livewire\Admin\Pharmacy\TakeMedicine\Detail\AdminPharmacyTakeMedicineDetailIndex;
use App\Models\Branch\Branch;
use App\Models\Company\Company;
use App\Models\Product\Product;
use App\Models\Product\ProductPrice;
use App\Models\Product\ProductStock;
use App\Models\Transaction\Transaction;
use App\Models\Transaction\TransactionDetail;
use App\Models\User;
use App\Models\User\UserType;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;
use Tests\TestCase;

class AdminPharmacyTakeMedicineDetailIndexTest extends TestCase
{
    use RefreshDatabase;

    public function test_save_completes_take_medicine_transaction_and_decrements_stock(): void
    {
        $company = Company::create([
            'name' => 'Starkids Medical Center',
            'code' => 'STKDS',
            'email' => 'starkids@example.com',
            'phone' => '081234567890',
            'is_main' => true,
        ]);

        $branch = Branch::create([
            'company_id' => $company->id,
            'name' => 'Main Branch',
            'code' => 'BR001',
        ]);

        $userType = UserType::create([
            'company_id' => $company->id,
            'name' => 'Umum',
        ]);

        $user = User::create([
            'name' => 'Admin User',
            'email' => 'admin@example.com',
            'password' => bcrypt('password'),
            'company_id' => $company->id,
        ]);
        $this->actingAs($user);

        $product = Product::create([
            'company_id' => $company->id,
            'name' => 'Paracetamol 500mg',
            'code' => 'PRD-001',
            'is_non_stock' => false,
        ]);

        ProductStock::create([
            'company_id' => $company->id,
            'branch_id' => $branch->id,
            'product_id' => $product->id,
            'quantity' => 50,
        ]);

        ProductPrice::create([
            'company_id' => $company->id,
            'branch_id' => $branch->id,
            'product_id' => $product->id,
            'hpp_average' => 5000,
            'price' => 10000,
        ]);

        $transaction = Transaction::create([
            'company_id' => $company->id,
            'code' => 'TRX-001',
            'status' => 'take_medicine',
            'is_take_medicine' => true,
            'patient_name' => 'John Doe',
        ]);

        $transactionDetail = TransactionDetail::create([
            'transaction_id' => $transaction->id,
            'product_id' => $product->id,
            'type_transaction' => 'medicine',
            'quantity' => 5,
            'price' => 10000,
            'sub_total_price' => 50000,
        ]);

        session(['transaction_id' => $transaction->id]);

        Livewire::test(AdminPharmacyTakeMedicineDetailIndex::class)
            ->call('save');

        $this->assertEquals('completed', $transaction->fresh()->status);

        $stock = ProductStock::where('product_id', $product->id)
            ->where('company_id', $company->id)
            ->where('branch_id', $branch->id)
            ->first();

        $this->assertEquals(45, $stock->quantity);
    }
}
