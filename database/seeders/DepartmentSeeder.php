<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DepartmentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = [
            ['name' => 'SECURITY', 'code' => 'SCR'],
            ['name' => 'CLEANING SERVICE', 'code' => 'CLS'],
            ['name' => 'GARDENER', 'code' => 'GAR'],
            ['name' => 'ADMIN', 'code' => 'ADM'],
            ['name' => 'PROMOTION B/G', 'code' => 'PBG'],
        ];

        DB::table('departments')->insert($data);
    }
}
