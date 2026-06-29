<?php

namespace Tests\Feature\Console;

use App\Models\Branch\Branch;
use App\Models\Company\Company;
use App\Models\Product\Product;
use App\Models\Product\ProductPrice;
use App\Models\Product\ProductPriceHistory;
use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Support\Str;
use Tests\TestCase;

class CheckPriceProductNullTest extends TestCase
{
    use DatabaseTransactions;

    /** @test */
    public function it_recalculates_hpp_average_for_products_with_zero_price_and_updated_flag()
    {
        // 1. Setup Data
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

        $user = User::factory()->create(['company_id' => $company->id]);

        $product = Product::create([
            'company_id' => $company->id,
            'name' => 'Test Product',
            'sku_number' => 'SKU12345',
        ]);

        // Create ProductPrice with price 0 and is_updated true
        $productPrice = ProductPrice::create([
            'id' => Str::uuid(),
            'product_id' => $product->id,
            'company_id' => $company->id,
            'branch_id' => $branch->id,
            'price' => 0,
            'hpp_average' => 0,
            'is_updated' => true,
        ]);

        // Create ProductPriceHistory entries
        // Entry 1: Qty 10, Price 100 -> SubTotal 1000
        ProductPriceHistory::create([
            'id' => Str::uuid(),
            'product_id' => $product->id,
            'product_price_id' => $productPrice->id,
            'company_id' => $company->id,
            'branch_id' => $branch->id,
            'user_id' => $user->id,
            'quantity' => 10,
            'price' => 100,
            'sub_total_price' => 1000,
            'hpp_average' => 100,
            'is_updated' => false,
        ]);

        // Entry 2: Qty 10, Price 120 -> SubTotal 1200
        ProductPriceHistory::create([
            'id' => Str::uuid(),
            'product_id' => $product->id,
            'product_price_id' => $productPrice->id,
            'company_id' => $company->id,
            'branch_id' => $branch->id,
            'user_id' => $user->id,
            'quantity' => 10,
            'price' => 120,
            'sub_total_price' => 1200,
            'hpp_average' => 120,
            'is_updated' => false,
        ]);

        // Total SubTotal = 2200, Total Qty = 20. Expected HPP = 110.

        // 2. Run Command
        $this->artisan('check:price-product-null')
            ->assertSuccessful();

        // 3. Assertions
        $productPrice->refresh();

        $this->assertEquals(110, $productPrice->hpp_average);
        $this->assertFalse((bool) $productPrice->is_updated);
    }
}
