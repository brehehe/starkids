<?php

namespace Tests\Feature\Admin\Logistic\ProductAdjustment;

use App\Livewire\Admin\Logistic\ProductAdjustment\AdminLogisticProductAdjustmentIndex;
use App\Models\Branch\Branch;
use App\Models\Company\Company;
use App\Models\Product\Product;
use App\Models\Product\ProductPrice;
use App\Models\Product\ProductStock;
use App\Models\Spatie\Role;
use App\Models\User;
use App\Models\User\UserCompanyRole;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;
use Tests\TestCase;

class AdminLogisticProductAdjustmentIndexTest extends TestCase
{
    use RefreshDatabase;

    private function createUserWithRole(Company $company): User
    {
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

    public function test_component_can_render_without_product_price()
    {
        $company = Company::create([
            'name' => 'Test Company',
            'code' => 'CO001',
            'phone' => '08123456789',
            'email' => 'test@company.com',
            'is_main' => true,
        ]);
        Branch::create([
            'company_id' => $company->id,
            'name' => 'Test Branch',
            'is_main' => true,
        ]);

        $user = $this->createUserWithRole($company);

        // Create product without productPrice or productStock
        Product::create([
            'company_id' => $company->id,
            'name' => 'Product Without Price',
            'sku_number' => 'SKU-NOPRICE',
        ]);

        $this->actingAs($user);

        Livewire::test(AdminLogisticProductAdjustmentIndex::class)
            ->assertStatus(200)
            ->assertSee('Perbaikan Stok & Harga', false)
            ->assertSee('Product Without Price');
    }

    public function test_can_open_and_save_adjustment_modal()
    {
        $company = Company::create([
            'name' => 'Test Company',
            'code' => 'CO001',
            'phone' => '08123456789',
            'email' => 'test@company.com',
            'is_main' => true,
        ]);
        $branch = Branch::create([
            'company_id' => $company->id,
            'name' => 'Test Branch',
            'is_main' => true,
        ]);

        $user = $this->createUserWithRole($company);

        $product = Product::create([
            'company_id' => $company->id,
            'name' => 'Paracetamol 500mg',
            'sku_number' => 'PCT500',
        ]);

        $stock = ProductStock::create([
            'product_id' => $product->id,
            'branch_id' => $branch->id,
            'company_id' => $company->id,
            'quantity' => 10,
        ]);

        $price = ProductPrice::create([
            'product_id' => $product->id,
            'branch_id' => $branch->id,
            'company_id' => $company->id,
            'hpp_average' => 5000,
            'hpp_average_without_discount' => 5500,
            'price' => 7000,
        ]);

        $this->actingAs($user);

        Livewire::test(AdminLogisticProductAdjustmentIndex::class)
            ->call('openAdjustmentModal', $product->id)
            ->assertSet('selectedAdjustmentProductId', $product->id)
            ->assertSet('productName', 'Paracetamol 500mg')
            ->assertSet('currentStock', 10)
            ->set('adjustedStock', 20)
            ->set('adjustedHna', '6.000')
            ->set('adjustedHnaGross', '6.500')
            ->set('margin_normal', 25)
            ->set('adjustedPrice', '7.500')
            ->set('adjustmentNotes', 'Koreksi stok opname bulanan')
            ->call('saveAdjustmentModal')
            ->assertDispatched('notify');

        $this->assertEquals(20, $stock->fresh()->quantity);
        $this->assertEquals(6000, $price->fresh()->hpp_average);
        $this->assertEquals(6500, $price->fresh()->hpp_average_without_discount);
        $this->assertEquals(7500, $price->fresh()->price);

        $this->assertDatabaseHas('product_stock_histories', [
            'product_id' => $product->id,
            'quantity' => 10,
            'type' => 'in',
        ]);

        $this->assertDatabaseHas('product_price_histories', [
            'product_id' => $product->id,
            'price' => 6000,
            'hpp_average' => 6000,
        ]);

        $this->assertDatabaseHas('product_selling_price_histories', [
            'product_id' => $product->id,
            'new_price' => 7500,
            'new_hpp_average' => 6000,
        ]);
    }
}
