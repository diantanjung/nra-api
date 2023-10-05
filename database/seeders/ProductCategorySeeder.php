<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProductCategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $categories = [
            ['parent_id' => NULL, 'name' => 'MINUMAN'],
            ['parent_id' => NULL, 'name' => 'MAKANAN'],
        ];

        $sub_categories = [
            ['parent_id' => 1, 'name' => 'Minuman Ringan'],
            ['parent_id' => 1, 'name' => 'Jus'],
            ['parent_id' => 1, 'name' => 'Kopi'],
            ['parent_id' => 1, 'name' => 'Teh'],
            ['parent_id' => 1, 'name' => 'Susu'],
            ['parent_id' => 1, 'name' => 'Kental Manis'],
            ['parent_id' => 1, 'name' => 'Sirup'],
            ['parent_id' => 1, 'name' => 'Coklat Bubuk dan Kremer'],
            ['parent_id' => 1, 'name' => 'Minuman Tradisional'],
            ['parent_id' => 1, 'name' => 'Air Mineral'],
            ['parent_id' => 2, 'name' => 'Makanan Instan'],
            ['parent_id' => 2, 'name' => 'Makanan Kaleng'],
            ['parent_id' => 2, 'name' => 'Sarapan'],
            ['parent_id' => 2, 'name' => 'Cokelat & Permen'],
            ['parent_id' => 2, 'name' => 'Cemilan & Biskuit'],
            ['parent_id' => 2, 'name' => 'Korean Food'],
            ['parent_id' => 2, 'name' => 'Western Food'],
        ];

        DB::table('product_categories')->insert(array_merge(
            $categories,
            $sub_categories
        ));
    }
}
