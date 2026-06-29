<?php

namespace Database\Seeders\Type;

use App\Models\Product\ProductType;
use Illuminate\Database\Seeder;

class TypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        $types = [
            ['name' => 'Obat', 'type' => 'take'],
            ['name' => 'Vaksin', 'type' => 'non-take'],
            ['name' => 'Tindakan', 'type' => 'non-take'],
            ['name' => 'Produk Pendukung', 'type' => 'non-take'],
            ['name' => 'Jasa', 'type' => 'non-take'],
            ['name' => 'Lainnya', 'type' => 'non-take'],
        ];

        foreach ($types as $type) {
            ProductType::create($type);
        }
    }
}
