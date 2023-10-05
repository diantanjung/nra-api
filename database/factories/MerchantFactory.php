<?php

namespace Database\Factories;

use App\Models\Merchant;
use Illuminate\Database\Eloquent\Factories\Factory;
use Faker\Factory as Faker;

class MerchantFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Merchant::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $faker = Faker::create('id_ID');
        $name = $faker->name();
        $address = explode(", ", $faker->address());
        $location = $this->locationList()[rand(0, 4)];
        $suffix = ["JAYA", "INDO", "SEJAHTERA", "SUKSES", "RIZKI"];
        $num = rand(1, 100);
        $warung = "WR " . strtoupper(explode(" ", $name)[rand(0, 1)]) . " " . $suffix[rand(0, 4)] . " #" . $num;
        $split_warung = explode(" ", $warung);
        $code = "WR-" . $split_warung[1][0] . $split_warung[2][0] . $split_warung[2][0] . $num;
        $full_address = $address[0] . ", " . $location["city_name"] . ", " . $location["province_name"];

        return [
            'code' => $code,
            'name' => $warung,
            "contact_name" => $name,
            "contact_number" => "6281234567890",
            "province_id" => $location["province_id"],
            "city_id" => $location["city_id"],
            "address" => $address[0],
            "full_address" => $full_address,
            "latitude" => $faker->latitude(),
            "longitude" => $faker->longitude(),
            'photo' => "https://ui-avatars.com/api/?name=WR&background=random"
        ];
    }

    public function locationList()
    {
        return [
            [
                "province_id" => 31,
                "province_name" => "DKI JAKARTA",
                "city_id" => 71,
                "city_name" => "JAKARTA PUSAT",
            ],
            [
                "province_id" => 32,
                "province_name" => "JAWA BARAT",
                "city_id" => 73,
                "city_name" => "KOTA BANDUNG",
            ],
            [
                "province_id" => 33,
                "province_name" => "JAWA TENGAH",
                "city_id" => 74,
                "city_name" => "KOTA SEMARANG",
            ],
            [
                "province_id" => 34,
                "province_name" => "DAERAH ISTIMEWA YOGYAKARTA",
                "city_id" => 71,
                "city_name" => "KOTA YOGYAKARTA",
            ],
            [
                "province_id" => 35,
                "province_name" => "JAWA TIMUR",
                "city_id" => 78,
                "city_name" => "KOTA SURABAYA",
            ],
        ];
    }
}
