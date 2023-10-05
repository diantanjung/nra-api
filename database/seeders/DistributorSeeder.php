<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DistributorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $latitude = "-8.6849428";
        $longitude = "115.1881891";
        $photo = "https://ui-avatars.com/api/?name=AT&background=random";

        $data = [
            [
                "name" => "WR KELONTONG BERSAUDARA",
                "contact" => "andy",
                "phone_number" => "6285112123123",
                "province_id" => 51,
                "city_id" => 71,
                "address" => "Jl. Gunung Soputan, Pemecutan Klod, Denpasar Barat",
                "latitude" => $latitude,
                "longitude" => $longitude,
                "photo" => $photo
            ],
        ];

        DB::table('distributors')->insert($data);
    }
}
