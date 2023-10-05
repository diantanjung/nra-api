<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AreaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = [
            ['name' => 'JAKARTA', 'code' => 'JKT'],
            ['name' => 'TANGERANG', 'code' => 'TGR'],
            ['name' => 'BANDUNG', 'code' => 'BDG'],
            ['name' => 'SURABAYA', 'code' => 'SBY'],
            ['name' => 'MAKASSAR', 'code' => 'MKS'],
            ['name' => 'MEDAN', 'code' => 'MDN'],
        ];

        DB::table('areas')->insert($data);
    }
}
