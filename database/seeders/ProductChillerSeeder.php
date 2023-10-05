<?php

namespace Database\Seeders;

use App\Models\Chiller;
use App\Models\Product;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProductChillerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = array();
        $products = Product::whereIn('id', [2, 4, 6, 8, 10])->get();
        $chillers = Chiller::all();
        foreach ($chillers as $chiller) {
            foreach ($products as $product) {
                $data[] = [
                    "product_id" => $product->id,
                    "chiller_id" => $chiller->id,
                    "sell_price" => $product->sell_price + 400,
                    "stock" => 100,
                    "status" => true,
                ];
            }
        }

        DB::table('product_chillers')->insert($data);
    }
}
