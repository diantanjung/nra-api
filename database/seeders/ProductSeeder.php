<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // get klikindomaret product image
        // document.getElementsByClassName("lalala")[0].style.backgroundImage.split('"')[1]

        $data = array_merge(
            $this->foodsProducts(),
            $this->drinksProducts(),
            $this->competitorsProducts()
        );

        DB::table('products')->insert($data);
    }

    public function foodsProducts()
    {
        return [
            [
                'category_id' => 13,
                'supplier_id' => 1,
                'sku' => "10023789",
                'name' => "Sedaap Mie Instant Goreng 90G",
                'description' => " Mi goreng instant original dengan rasa yang special dan tambahan bawang goreng, jelas terasa sedapnya. ",
                'photo' => url('uploads/mie_sedap.jpeg'),
                'uom' => "Unit",
                'weight' => 90,
                'weight_type' => "Gr",
                'is_rtd' => 0,
                'is_sales' => 1,
                'sell_price' => 3100,
                'recommendation' => 5,
                'depth' => 6
            ],
        ];
    }

    public function drinksProducts()
    {
        return [
            [
                'sku' => '20087542',
                'name' => 'Golda Coffee Drink Dolce Latte 200Ml',
                'description' => 'Kopi dengan aroma yang khas dan nikmat terpadu susu yang lembut.',
                'photo' => url('uploads/golda_latte.jpeg'),
                'weight' => '200',
                'weight_type' => 'Ml',
                'sell_price' => 3100,
                'recommendation' => 5,
                'depth' => 6,
                'uom' => 'Unit',
                'category_id' => 5,
                'supplier_id' => 1,
                'is_rtd' => 1,
                'is_sales' => 0
            ],
            [
                'sku' => '20123322',
                'name' => 'Golda Coffee Drink Cappuccino 200mL',
                'description' => 'Kopi dengan aroma yang khas dan nikmat terpadu susu yang lembut.',
                'photo' => url('uploads/gola_cappucino.jpeg'),
                'weight' => 200,
                'weight_type' => 'Ml',
                'sell_price' => 3100,
                'recommendation' => 5,
                'depth' => 6,
                'uom' => 'Unit',
                'category_id' => 5,
                'supplier_id' => 1,
                'is_rtd' => 1,
                'is_sales' => 0
            ],
            [
                'sku' => '20043877',
                'name' => 'Floridina Juice Pulp Orange 350Ml',
                'description' => 'Floridina minuman rasa jeruk dengan bulir utuh jeruk asli yang mengandung vitamin C. Terbuat dari jeruk floridina berkualitas.',
                'photo' => url('uploads/floridina_orange.jpeg'),
                'weight' => 350,
                'weight_type' => 'Ml',
                'sell_price' => 3200,
                'recommendation' => 5,
                'depth' => 6,
                'uom' => 'Unit',
                'category_id' => 4,
                'supplier_id' => 1,
                'is_rtd' => 1,
                'is_sales' => 0
            ],
            [
                'sku' => '20113377',
                'name' => 'Floridina Juice Pulp Coco Bit 350Ml',
                'description' => 'Floridina Coco adalah adalah minuman jus buah asli yang hadir dengan bulir-bulir jeruk dan nata de coco yang sangat menyegarkan.',
                'photo' => url('uploads/floridina_coco.jpeg'),
                'weight' => 350,
                'weight_type' => 'Ml',
                'sell_price' => 3200,
                'recommendation' => 5,
                'depth' => 6,
                'uom' => 'Unit',
                'category_id' => 4,
                'supplier_id' => 1,
                'is_rtd' => 1,
                'is_sales' => 0
            ],
            [
                'sku' => '20107748',
                'name' => 'Milku Susu Uht Cokelat Premium 200Ml',
                'description' => 'MILKU Susu UHT Cokelat Premium 200ml - Susu UHT rasa cokelat persembahan Milku. Terbuat dari berbagai macam bahan berkualitas, membuat Milku UHT Cokelat memiliki cita rasa premium yang lezat',
                'photo' => url('uploads/milku_coklat.jpeg'),
                'weight' => 200,
                'weight_type' => 'Ml',
                'sell_price' => 3200,
                'recommendation' => 5,
                'depth' => 6,
                'uom' => 'Unit',
                'category_id' => 7,
                'supplier_id' => 1,
                'is_rtd' => 1,
                'is_sales' => 0
            ],
            [
                'sku' => '20107749',
                'name' => 'Milku Susu Uht Stroberi 200Ml',
                'description' => 'MILKU Susu UHT Cokelat Premium 200ml - Susu rasa stroberi persembahan Milku. Terbuat dari berbagai macam bahan berkualitas, membuat Milku UHT Cokelat memiliki cita rasa premium yang lezat',
                'photo' => url('uploads/milku_strobery.jpeg'),
                'weight' => 200,
                'weight_type' => 'Ml',
                'sell_price' => 3200,
                'recommendation' => 5,
                'depth' => 6,
                'uom' => 'Unit',
                'category_id' => 7,
                'supplier_id' => 1,
                'is_rtd' => 1,
                'is_sales' => 0
            ],
            [
                'sku' => '20069773',
                'name' => 'Isoplus Minuman Isotonik 350Ml',
                'description' => 'ISOPLUS Minuman Isotonik Pet 350 ml adalah minuman isotonik yang hadir untuk mencukupi kebutuhan ion tubuh sehingga mendukung Anda beraktivitas dengan nyaman dan semangat sepanjang hari',
                'photo' => url('uploads/isoplus.jpeg'),
                'weight' => 350,
                'weight_type' => 'Ml',
                'sell_price' => 3200,
                'recommendation' => 5,
                'depth' => 6,
                'uom' => 'Unit',
                'category_id' => 3,
                'supplier_id' => 1,
                'is_rtd' => 1,
                'is_sales' => 0
            ],
            [
                'sku' => '20095747',
                'name' => 'Javana Minuman Teh Melati Gula Batu 350Ml',
                'description' => 'JAVANA Minuman Teh Gula Batu 350 ml adalah minuman teh berkemasan dengan rasa gula batu.',
                'photo' => url('uploads/javana.jpeg'),
                'weight' => 350,
                'weight_type' => 'Ml',
                'sell_price' => 3200,
                'recommendation' => 5,
                'depth' => 6,
                'uom' => 'Unit',
                'category_id' => 6,
                'supplier_id' => 1,
                'is_rtd' => 1,
                'is_sales' => 0
            ],
            [
                'sku' => '20055829',
                'name' => 'Javana Minuman Teh Melati 350Ml',
                'description' => 'JAVANA Minuman Teh Melati 350 ml adalah minuman teh bunga melati berkemasan. Teh dibuat dari seduhan daun teh pertama, sehingga teh memiliki rasa yang pekat.',
                'photo' => url('uploads/javana_gula.jpeg'),
                'weight' => 350,
                'weight_type' => 'Ml',
                'sell_price' => 3200,
                'recommendation' => 5,
                'depth' => 6,
                'uom' => 'Unit',
                'category_id' => 6,
                'supplier_id' => 1,
                'is_rtd' => 1,
                'is_sales' => 0
            ],
        ];
    }

    public function competitorsProducts()
    {
        return [
            [
                'name' => 'Good Day Coffee Drink Cappuccino 250Ml',
                'sku' => '20076770',
                'sell_price' => 7500,
                'recommendation' => 5,
                'depth' => 6,
                'description' => 'Minuman kopi dalam kemasan botol dengan perpaduan rasa dan aroma kopi yang lembut dan istimewa.',
                'photo' => url('uploads/good_day.jpeg'),
                'weight' => 250,
                'weight_type' => 'Ml',
                'uom' => 'Unit',
                'category_id' => 5,
                'supplier_id' => 1,
                'is_rtd' => 1,
                'is_sales' => 1,
            ],
            [
                'name' => 'Sosro Teh Botol Original 350Ml',
                'sku' => '20072249',
                'sell_price' => 4000,
                'recommendation' => 5,
                'depth' => 6,
                'description' => 'Minuman teh terbuat dari daun teh berkualitas memberikan kesegaran teh bagi anda.',
                'photo' => url('uploads/teh_sosro.jpeg'),
                'weight' => 350,
                'weight_type' => 'Ml',
                'uom' => 'Unit',
                'category_id' => 6,
                'supplier_id' => 2,
                'is_rtd' => 1,
                'is_sales' => 1,
            ],
            [
                'name' => 'Nutriboost Orange 300Ml',
                'sku' => '20046314',
                'sell_price' => 7000,
                'recommendation' => 5,
                'depth' => 6,
                'description' => 'Minute maid nutriboost, Minuman mengandung susu + sari buah rasa jeruk. Enak + menyegarkan.',
                'photo' => url('uploads/nutriboost.jpeg'),
                'weight' => 300,
                'weight_type' => 'Ml',
                'uom' => 'Unit',
                'category_id' => 4,
                'supplier_id' => 3,
                'is_rtd' => 1,
                'is_sales' => 1,
            ],
            [
                'name' => 'Hydro Coco Natural Health Drink 250Ml',
                'sku' => '20018435',
                'sell_price' => 6200,
                'recommendation' => 5,
                'depth' => 6,
                'description' => 'Hydro coco dibuat dengan air kelapa asli (bukan konsentrat) tanpa menambahkan air serta diproses secara aseptis.',
                'photo' => url('uploads/hydro_coco.jpeg'),
                'weight' => 250,
                'weight_type' => 'Ml',
                'uom' => 'Unit',
                'category_id' => 3,
                'supplier_id' => 4,
                'is_rtd' => 1,
                'is_sales' => 1,
            ],
        ];
    }
}
