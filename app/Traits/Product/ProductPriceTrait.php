<?php

namespace App\Traits\Product;

use App\Models\Product\Product;
use App\Models\Product\ProductPrice;
use App\Traits\Branch\BranchTrait;
use Illuminate\Support\Facades\Auth;

trait ProductPriceTrait
{
    use BranchTrait;

    //
    public function getProductPrices()
    {
        return ProductPrice::search(trim($this->search))->with('product:id,name,sku_number,product_type_id,normal', 'branch:id,name', 'company:id,name', 'product.productType:id,name', 'product.productStock:quantity,product_id')
            ->where('company_id', Auth::user()->company_id)
            // ->where('branch_id', $this->getBranchOne()->id)
            ->orderBy('order', 'desc')
            ->where('is_updated', false);
    }

    public function getProductPriceUpdates()
    {
        return ProductPrice::search(trim($this->search))->with('product:id,name,sku_number,product_type_id', 'branch:id,name', 'company:id,name', 'product.productType:id,name', 'product.productStock:id,quantity,product_id')
            ->where('company_id', Auth::user()->company_id)
            // ->where('branch_id', $this->getBranchOne()->id)
            ->orderBy('order', 'desc')
            ->where('is_updated', true);
    }

    public function generatePrice($margin)
    {
        $productPrices = $this->getProductPrices()->get();

        foreach ($productPrices as $productPrice) {
            $productPrice->update([
                'is_updated' => false,
                'price_generate' => $this->calculatePrice($productPrice, $margin),
                'recipe_generate' => $this->calculateRecipe($productPrice, $margin),
            ]);
        }
    }

    public function generateFixedPrice()
    {
        $productPrices = $this->getProductPrices()->get();

        foreach ($productPrices as $productPrice) {
            $oldPrice = (float) $productPrice->price;
            $oldRecipe = (float) $productPrice->recipe;
            $oldHna = (float) $productPrice->hpp_average;

            $newPrice = (float) ($productPrice->price_generate > 0 ? $productPrice->price_generate : $productPrice->price);
            $newRecipe = (float) ($productPrice->recipe_generate > 0 ? $productPrice->recipe_generate : $productPrice->recipe);

            $productPrice->update([
                'is_updated' => true,
                'price' => $newPrice,
                'recipe' => $newRecipe,
            ]);

            $calculatedMargin = 0;
            if ($oldHna > 0 && $newPrice > 0) {
                $calculatedMargin = round((($newPrice - $oldHna) / $oldHna) * 100, 2);
            }

            \App\Models\Product\ProductSellingPriceHistory::create([
                'product_id' => $productPrice->product_id,
                'product_price_id' => $productPrice->id,
                'branch_id' => $productPrice->branch_id,
                'company_id' => $productPrice->company_id,
                'user_id' => Auth::user()?->id,
                'old_price' => $oldPrice,
                'new_price' => $newPrice,
                'old_recipe' => $oldRecipe,
                'new_recipe' => $newRecipe,
                'old_hpp_average' => $oldHna,
                'new_hpp_average' => $productPrice->hpp_average,
                'margin' => $calculatedMargin,
                'source' => 'Generate Harga Jual (Farmasi)',
                'notes' => 'Margin: +'.$calculatedMargin.'%',
            ]);
        }
    }

    public function calculatePrice($productPrice, $margin)
    {
        $product = Product::find($productPrice->product_id);

        $normal = $product ? ($product->normal > 0 ? $product->normal : ($product->productCategory?->normal ?? $margin)) : 0;
        dd($normal);

        return $productPrice->hpp_average + ($productPrice->hpp_average * $normal / 100);
    }

    public function calculateRecipe($productPrice, $margin)
    {
        $product = Product::find($productPrice->product_id);

        $recipe = $product ? ($product->recipe > 0 ? $product->recipe : ($product->productCategory?->recipe ?? $margin)) : 0;

        // Jika recipe adalah persentase, misal 10 berarti 10%
        // Maka harga akhir = price + (price * recipe / 100)
        return $productPrice->hpp_average + ($productPrice->hpp_average * $recipe / 100);
    }
}
