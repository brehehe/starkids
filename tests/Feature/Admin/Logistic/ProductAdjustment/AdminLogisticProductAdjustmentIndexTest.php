<?php

namespace Tests\Feature\Admin\Logistic\ProductAdjustment;

use App\Livewire\Admin\Logistic\ProductAdjustment\AdminLogisticProductAdjustmentIndex;
use App\Models\Branch\Branch;
use App\Models\Company\Company;
use App\Models\Product\Product;
use App\Models\Product\ProductPrice;
use App\Models\Product\ProductStock;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;
use Spatie\Permission\Models\Role;
use Tests\TestCase;

class AdminLogisticProductAdjustmentIndexTest extends TestCase
{
    use RefreshDatabase;

    public function test_component_can_render()
    {
        $company = Company::factory()->create();
        $branch = Branch::factory()->create(['company_id' => $company->id]);

        Role::firstOrCreate(['name' => 'Super Admin', 'guard_name' => 'web']);

        $user = User::factory()->create(['company_id' => $company->id]);
        $user->assignRole('Super Admin');

        $this->actingAs($user);

        Livewire::test(AdminLogisticProductAdjustmentIndex::class)
            ->assertStatus(200)
            ->assertSee('Perbaikan Stok & Harga');
    }

    public function test_can_adjust_stock_and_price()
    {
        $company = Company::factory()->create();
        $branch = Branch::factory()->create(['company_id' => $company->id]);

        Role::firstOrCreate(['name' => 'Super Admin', 'guard_name' => 'web']);

        $user = User::factory()->create(['company_id' => $company->id]);
        $user->assignRole('Super Admin');

        $product = Product::factory()->create(['company_id' => $company->id]);

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
            'price' => 7000,
        ]);

        $this->actingAs($user);

        Livewire::test(AdminLogisticProductAdjustmentIndex::class)
            ->set('editingStocks.'.$product->id, 20)
            ->set('editingHnas.'.$product->id, 6000)
            ->set('editingPrices.'.$product->id, 8000)
            ->call('saveAdjustment', $product->id)
            ->assertDispatched('notify');

        $this->assertEquals(20, $stock->fresh()->quantity);
        $this->assertEquals(6000, $price->fresh()->hpp_average);
        $this->assertEquals(8000, $price->fresh()->price);

        $this->assertDatabaseHas('product_stock_histories', [
            'product_id' => $product->id,
            'quantity' => 10, // The diff
            'type' => 'in',
        ]);

        $this->assertDatabaseHas('product_price_histories', [
            'product_id' => $product->id,
            'price' => 8000,
            'hpp_average' => 6000,
        ]);
    }
}
