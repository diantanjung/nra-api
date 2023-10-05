<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ContractSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = [
            ['name' => 'KONTRAK'],
            ['name' => 'HARIAN'],
            ['name' => 'PERBANTUAN'],
            ['name' => 'MENGUNDURKAN DIRI'],
            ['name' => 'NON AKTIF'],
        ];

        DB::table('contract_types')->insert($data);

        // user contract
        $contract_data = [
            [
                "user_id" => 3,
                "contract_type_id" => 1,
                "effective_date_start" => date('Y-m-d'),
                "effective_date_end" => date('Y-m-d'),
                "note" => null
            ],
            [
                "user_id" => 5,
                "contract_type_id" => 2,
                "effective_date_start" => date('Y-m-d'),
                "effective_date_end" => date('Y-m-d'),
                "note" => null
            ],
        ];

        DB::table('user_contracts')->insert($contract_data);
    }
}
