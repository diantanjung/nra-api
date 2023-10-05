<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UserProfileSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        $admin_hr_data = [
            [
                'user_id' => 1,
                'is_validated' => true,
                'phone_number' => '6285161318191',
            ],
            [
                'user_id' => 2,
                'is_validated' => true,
                'phone_number' => '6285161318191',
            ]
        ];

        DB::table('user_profiles')->insert($admin_hr_data);

        $user_data = [
            [
                'user_id' => 3,
                'department_id' => 1,
                'client_area_id' => 3,
                'nip' => '196508071992031019',
                'title' => null,
                'birth_place' => 'Samarinda',
                'birth_date' => '1965-08-07',
                'gender' => 'Laki-laki',
                'religion' => 'Islam',
                'contract_id' => 1,
                'marital_status' => 'Kawin',
                'address' => 'Jl. Jakarta II RT 37, Kota Bandung, Jawa Barat',
                'phone_number' => '6285161318191',
                'npwp_number' => '68.816.664.4.722.000',
                'bpjs_number' => '0000123721716',
                'relationship_number' => '-',
                'blood_type' => '-',
                'tribe' => 'Bugis',
                'is_validated' => false
            ],
            [
                'user_id' => 5,
                'department_id' => 2,
                'client_area_id' => 2,
                'nip' => '196508071992031212',
                'title' => null,
                'birth_place' => 'Surabaya',
                'birth_date' => '1965-08-07',
                'gender' => 'Perempuan',
                'religion' => 'Islam',
                'contract_id' => 2,
                'marital_status' => 'Belum Kawin',
                'address' => 'Jl. Kaliurang 8 RT 001, Kota Surabaya, Jawa Timur',
                'phone_number' => '6285161318191',
                'npwp_number' => '68.816.664.4.11.000',
                'bpjs_number' => '0000111721716',
                'relationship_number' => '-',
                'blood_type' => 'O',
                'tribe' => 'Jawa',
                'is_validated' => false
            ],
            [
                'user_id' => 7,
                'department_id' => 1,
                'client_area_id' => 1,
                'nip' => '196508071992031111',
                'title' => null,
                'birth_place' => 'Samarinda',
                'birth_date' => '1991-08-07',
                'gender' => 'Laki-laki',
                'religion' => 'Islam',
                'contract_id' => 2,
                'marital_status' => 'Sudah Kawin',
                'address' => 'Jl. KS TUbun Dalam No 8 RT 001, Kota Samarinda, Kalimantan Timur',
                'phone_number' => '6285161318191',
                'npwp_number' => '68.816.664.4.22.000',
                'bpjs_number' => '0000221721716',
                'relationship_number' => '-',
                'blood_type' => 'O',
                'tribe' => 'Banjar',
                'is_validated' => false
            ],
        ];

        DB::table('user_profiles')->insert($user_data);

        $coordinator_data = [
            [
                'user_id' => 4,
                'is_validated' => true,
                'phone_number' => '6285161318191',
            ],
            [
                'user_id' => 6,
                'is_validated' => true,
                'phone_number' => '6285161318191',
            ],
            [
                'user_id' => 8,
                'is_validated' => true,
                'phone_number' => '6285161318191',
            ],
        ];

        DB::table('user_profiles')->insert($coordinator_data);

        // $user_surveyors = array();
        // foreach (range(9, 60) as $id) {
        //     $client_area_id = 1;
        //     if ($id <= 17) {
        //         $client_area_id = 2;
        //     } else if ($id > 17 && $id < 34) {
        //         $client_area_id = rand(3, 6);
        //     } else if ($id > 33 && $id < 51) {
        //         $client_area_id = 1;
        //     } else if ($id > 50 && $id < 61) {
        //         $client_area_id = 7;
        //     }

        //     $user_surveyors[] = [
        //         'user_id' => $id,
        //         'is_validated' => false,
        //         'department_id' => rand(1, 6),
        //         'client_area_id' => $client_area_id,
        //         'phone_number' => '6285161318191',
        //     ];
        // }

        // DB::table('user_profiles')->insert($user_surveyors);
    }
}
