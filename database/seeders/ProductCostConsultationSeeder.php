<?php

namespace Database\Seeders;

use App\Models\Branch\Branch;
use App\Models\Company\Company;
use App\Models\Product\Product;
use App\Models\Product\ProductPrice;
use App\Models\Product\ProductType;
use App\Models\Transaction\TransactionDetail;
use App\Models\Unit\Unit;
use Illuminate\Database\Seeder;

class ProductCostConsultationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Unit::all()->each(function ($unit) {
            $units[$unit->name] = $unit;
        });

        $company = Company::first();
        $branchId = Branch::where('company_id', $company->id)->first()->id;

        $ProductType = ProductType::where('name', 'Jasa')->first()->id;
        $defaultUnit = Unit::where('name', 'Pcs')->first();

        $product = Product::create([
            'company_id' => $company->id,
            'name' => 'Biaya Konsultasi',
            'description' => 'Biaya Konsultasi',
            'product_type_id' => $ProductType,
            'registration_path' => 'import',
            'unit_id' => $defaultUnit->id,
            'is_narcotics' => false,
            'is_non_stock' => true,
        ]);

        ProductPrice::create([
            'product_id' => $product->id,
            'company_id' => $company->id,
            'branch_id' => $branchId,
            'hpp_average' => 0, // Biaya Konsultasi tidak memiliki HPP
            'price' => 0, // Biaya Konsultasi tidak memiliki harga
            'is_updated' => false,
        ]);

        $transaction = TransactionDetail::where('company_id', $company->id)
            ->whereNull('product_id')->where('name', 'Biaya Konsultasi')
            ->get();

        foreach ($transaction as $item) {
            $item->product_id = $product->id;
            $item->save();
        }
    }
}
