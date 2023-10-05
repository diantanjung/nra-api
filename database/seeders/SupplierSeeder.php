<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SupplierSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = [
            ['name' => 'WINGS'],
            ['name' => 'SANTOS JAYA ABADI'],
            ['name' => 'SINAR SOSRO'],
            ['name' => 'COCA-COLA'],
            ['name' => 'KALBE FARMA'],
            ['name' => 'UNILEVER'],
            ['name' => 'ULTRAJAYA'],
            ['name' => 'NUTRIFOOD'],
        ];

        DB::table('suppliers')->insert($data);
    }
}
