<?php

namespace Database\Seeders;

use App\Models\Merchant;
use App\Repository\LocationRepository;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class MerchantSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // get location name
        $locationRepo = new LocationRepository();

        $jaksel = "31.74";
        $location_mj = $locationRepo->getByCode($jaksel)["data"];
        $address_mj = "Jl. H. Sarmah No.19, Parigi, Kec. Pd. Aren";
        $full_address_mj = $address_mj . ", " . $location_mj["city_name"] . ", " . $location_mj["province_name"];

        $bogor = "32.01";
        $location_pt = $locationRepo->getByCode($bogor)["data"];
        $address_pt = "Jl. Prof. DR. Satrio No.10, RT.3/RW.3, Karet Semanggi, Kecamatan Setiabudi";
        $full_address_pt = $address_pt . ", " . $location_pt["city_name"] . ", " . $location_pt["province_name"];

        $data = [
            [
                "code" => "WR-MJ",
                "name" => "WR MAMA JAYA",
                "photo" => "https://ui-avatars.com/api/?name=WRMJ&background=22215B&color=FFFFFF",
                "contact_name" => "Dimas Negara",
                "contact_number" => "681234567891",
                "province_id" => $location_mj["province_id"],
                "city_id" => $location_mj["city_id"],
                "address" => $address_mj,
                "full_address" => $full_address_mj,
                "latitude" => "-6.2740176",
                "longitude" => "106.6664845",
            ],
            [
                "code" => "WR-KP3",
                "name" => "WR KOPI 3 PUTRI",
                "photo" => "https://ui-avatars.com/api/?name=WRKP&background=22215B&color=FFFFFF",
                "contact_name" => "Syifa Andini",
                "contact_number" => "681234567890",
                "province_id" => $location_pt["province_id"],
                "city_id" => $location_pt["city_id"],
                "address" => $address_pt,
                "full_address" => $full_address_pt,
                "latitude" => "-6.2211999",
                "longitude" => "106.6804275",
            ],
        ];

        DB::table("merchants")->insert($data);

        // factory
        Merchant::factory()->count(998)->create();
    }
}
