<?php

namespace Database\Seeders;

use App\Models\ClientArea;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ClientSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $client_data = [
            [
                'name' => 'ASTRA',
                'address' => 'Jl. Jend. Basuki Rachmat No.44, RT.1/RW.3, Pd. Bambu, Kec. Duren Sawit, Kota Jakarta Timur, Daerah Khusus Ibukota Jakarta 13430',
                'logo' => url('uploads/astra_logo.png'),
            ],
            [
                'name' => 'HERBALIFE',
                'address' => 'Jl. KH. Wahid Hasyim No.156, RT.2/RW.10, Kp. Bali, Kecamatan Tanah Abang, Kota Jakarta Pusat, Daerah Khusus Ibukota Jakarta 10250',
                'logo' => url('uploads/herbalife_logo.png'),
            ],
            [
                'name' => 'WINGS',
                'address' => 'Jl. Tipar Cakung Kav. F 5-7, Cakung Barat, Cakung, Jakarta Timur 13910',
                'logo' => url('uploads/wings_logo.png'),
            ],
            [
                'name' => 'AGILITY',
                'address' => 'Jl. AMD Kariangau No.42, RT.68, Batu Ampar, Kec. Balikpapan Utara, Kota Balikpapan, Kalimantan Timur 76127',
                'logo' => url('uploads/agility_logo.png'),
            ],
        ];

        DB::table('clients')->insert($client_data);

        // client area
        $area_data = [
            // astra
            [
                'client_id' => 1,
                'area_id' => 1,
                'radius' => 50,
                'address' => 'Jl. Jend. Basuki Rachmat No.44, RT.1/RW.3, Pd. Bambu, Kec. Duren Sawit, Kota Jakarta Timur, Daerah Khusus Ibukota Jakarta 13430',
                'latitude' => '-8.3358957,',
                'longitude' => '113.5330736',
                'gmaps_url' => 'https://goo.gl/maps/sVpgAKdFizKF36xbA',
                'site_photo' => 'https://ui-avatars.com/api/?name=ASTRA&background=22215B&color=FFFFFF',
                'qr_photo' => 'https://id.qr-code-generator.com/wp-content/themes/qr/new_structure/markets/basic_market/generator/dist/generator/assets/images/websiteQRCode_noFrame.png',
            ],
            // wings
            [
                'client_id' => 3,
                'area_id' => 1,
                'radius' => 50,
                'address' => 'Jalan Tipar Cakung Kav. F 5-7, Jl. Cakung Bar No.154, RT.1/RW.9, Cakung Bar., Kec. Cakung, Kota Jakarta Timur, Daerah Khusus Ibukota Jakarta 13910',
                'latitude' => '-6.255497899801678',
                'longitude' => '106.86397545039654',
                'gmaps_url' => 'https://goo.gl/maps/1ViTft5KaBLeAZzb7',
                'site_photo' => 'https://ui-avatars.com/api/?name=WINGS&background=22215B&color=FFFFFF',
                'qr_photo' => 'https://id.qr-code-generator.com/wp-content/themes/qr/new_structure/markets/basic_market/generator/dist/generator/assets/images/websiteQRCode_noFrame.png',
            ],
            // herbalife
            [
                'client_id' => 2,
                'area_id' => 1,
                'radius' => 50,
                'address' => 'Gedung CIBIS Nine, Lantai Dasar & Lantai 6, Jl. TB Simatupang No. 2, Cilandak, RT.13/RW.5, Cilandak Tim., Kec. Ps. Minggu, Kota Jakarta Selatan, Daerah Khusus Ibukota Jakarta 12950',
                'latitude' => '-6.2948497',
                'longitude' => '106.8133696',
                'gmaps_url' => 'https://goo.gl/maps/LqngjK4hAWdHQC116',
                'site_photo' => 'https://ui-avatars.com/api/?name=HERBALIFE&background=22215B&color=FFFFFF',
                'qr_photo' => 'https://id.qr-code-generator.com/wp-content/themes/qr/new_structure/markets/basic_market/generator/dist/generator/assets/images/websiteQRCode_noFrame.png',
            ],
            [
                'client_id' => 2,
                'area_id' => 2,
                'radius' => 50,
                'address' => 'Jl. Gajah Mada No.59, RT.001/RW.003, Pakojan, Kec. Pinang, Kota Tangerang, Banten 15142',
                'latitude' => '-6.2296172',
                'longitude' => '106.6894299',
                'gmaps_url' => 'https://goo.gl/maps/vBCZDdt4C14tGwYx5',
                'site_photo' => 'https://ui-avatars.com/api/?name=HERBALIFE&background=22215B&color=FFFFFF',
                'qr_photo' => 'https://id.qr-code-generator.com/wp-content/themes/qr/new_structure/markets/basic_market/generator/dist/generator/assets/images/websiteQRCode_noFrame.png',
            ],
            [
                'client_id' => 2,
                'area_id' => 3,
                'radius' => 50,
                'address' => 'Jl. Gatot Subroto No.73, Malabar, Kec. Lengkong, Kota Bandung, Jawa Barat 40262',
                'latitude' => '-6.9092181',
                'longitude' => '107.6034212',
                'gmaps_url' => 'https://goo.gl/maps/eTsMAKqWxeM8TsFh7',
                'site_photo' => 'https://ui-avatars.com/api/?name=HERBALIFE&background=22215B&color=FFFFFF',
                'qr_photo' => 'https://id.qr-code-generator.com/wp-content/themes/qr/new_structure/markets/basic_market/generator/dist/generator/assets/images/websiteQRCode_noFrame.png',
            ],
            [
                'client_id' => 2,
                'area_id' => 4,
                'radius' => 50,
                'address' => 'Ruko Kartika Niaga Blok A No. 7, Jl. Kebraon V, Kebraon, Kec. Karangpilang, Kota SBY, Jawa Timur 60222',
                'latitude' => '-7.2808577',
                'longitude' => '112.6586327',
                'gmaps_url' => 'https://goo.gl/maps/kdLbVmtvnAoC5LWa7',
                'site_photo' => 'https://ui-avatars.com/api/?name=HERBALIFE&background=22215B&color=FFFFFF',
                'qr_photo' => 'https://id.qr-code-generator.com/wp-content/themes/qr/new_structure/markets/basic_market/generator/dist/generator/assets/images/websiteQRCode_noFrame.png',
            ],
            // agility
            [
                'client_id' => 4,
                'area_id' => 1,
                'radius' => 50,
                'address' => 'Jalan Tipar Cakung Kav. F 5-7, Jl. Cakung Bar No.154, RT.1/RW.9, Cakung Bar., Kec. Cakung, Kota Jakarta Timur, Daerah Khusus Ibukota Jakarta 13910',
                'latitude' => '-6.1693851',
                'longitude' => '106.9272161',
                'gmaps_url' => 'https://goo.gl/maps/1ViTft5KaBLeAZzb7',
                'site_photo' => 'https://ui-avatars.com/api/?name=WINGS&background=22215B&color=FFFFFF',
                'qr_photo' => 'https://id.qr-code-generator.com/wp-content/themes/qr/new_structure/markets/basic_market/generator/dist/generator/assets/images/websiteQRCode_noFrame.png',
            ],
        ];

        DB::table('client_areas')->insert($area_data);

        // client regulation
        $regulation_data = [];
        $astra_regulation = [2, 4, 5, 8, 10, 11];
        foreach ($astra_regulation as $regulation_id) {
            $regulation_data[] = ['client_id' => 1, 'regulation_id' => $regulation_id];
        }

        $wings_regulation = [2, 4, 5, 8, 10, 11];
        foreach ($wings_regulation as $regulation_id) {
            $regulation_data[] = ['client_id' => 2, 'regulation_id' => $regulation_id];
        }

        $herbalife_regulation = [2, 3, 5, 7, 9, 12];
        foreach ($herbalife_regulation as $regulation_id) {
            $regulation_data[] = ['client_id' => 3, 'regulation_id' => $regulation_id];
        }

        $herbalife_regulation = [2, 3, 5, 7, 9, 12];
        foreach ($herbalife_regulation as $regulation_id) {
            $regulation_data[] = ['client_id' => 4, 'regulation_id' => $regulation_id];
        }

        DB::table('client_regulations')->insert($regulation_data);

        $client_hour_data = array();
        foreach (ClientArea::get(['id']) as $client_area) {
            $client_hour_data[] = [
                'client_area_id' => $client_area->id,
                'shift' => 'NON SHIFT',
                'time_start' => '08:00',
                'time_end' => '17:00',
                'status' => 1,
            ];
        }

        DB::table('client_area_hours')->insert($client_hour_data);
    }
}
