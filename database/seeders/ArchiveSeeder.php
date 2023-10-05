<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ArchiveSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = [
            ["name" => "KTP"],
            ["name" => "Kartu Keluarga"],
            ["name" => "Kartu Pegawai"],
            ["name" => "Kartu BPJS / ASKES"],
            ["name" => "NPWP"],
            ["name" => "Akte Lahir"],
            ["name" => "Buku Nikah"],
        ];

        DB::table('archives')->insert($data);
    }
}
