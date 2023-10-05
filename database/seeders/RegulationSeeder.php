<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RegulationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = [
            ['type' => 'ABSEN', 'name' => '20 JAM KERJA PER PEKAN'],
            ['type' => 'ABSEN', 'name' => '40 JAM KERJA PER PEKAN'],
            ['type' => 'ABSEN', 'name' => 'BERLAKU PERBANTUAN'],
            ['type' => 'ABSEN', 'name' => 'TIDAK BERLAKU PERBANTUAN'],
            ['type' => 'ABSEN', 'name' => 'BERLAKU WORK FROM HOME'],
            ['type' => 'ABSEN', 'name' => 'TIDAK BERLAKU WORK FROM HOME'],
            ['type' => 'ABSEN', 'name' => 'SAKIT DENGAN SURAT DOKTER TANPA BATASAN PERBULAN'],
            ['type' => 'ABSEN', 'name' => 'SAKIT DENGAN SURAT DOKTER MAX 2 KALI PERBULAN'],
            ['type' => 'ABSEN', 'name' => 'BERLAKU CUTI'],
            ['type' => 'ABSEN', 'name' => 'TIDAK BERLAKU CUTI'],
            ['type' => 'LEMBUR', 'name' => 'TIDAK ADA MINIMAL JAM'],
            ['type' => 'LEMBUR', 'name' => 'MINIMAL DIATAS 2 JAM'],
        ];

        DB::table('regulations')->insert($data);
    }
}
