<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // role seeder
        $role_data = [
            ['name' => 'ADMIN'],
            ['name' => 'HR'],
            ['name' => 'USER GENERAL'],
            ['name' => 'USER SURVEYOR'],
            ['name' => 'USER SALES'],
            ['name' => 'COORDINATOR'],
        ];

        DB::table('roles')->insert($role_data);

        // user seeder
        $user_data = [
            [
                'role_id' => 1,
                'client_id' => null,
                'username' => 'admin',
                'name' => 'ADMIN NATARI',
                'password' => Hash::make('123123'),
                'photo' => 'https://ui-avatars.com/api/?name=AD&background=random'
            ],
            [
                'role_id' => 2,
                'client_id' => null,
                'username' => 'hr',
                'name' => 'HR NATARI',
                'password' => Hash::make('123123'),
                'photo' => 'https://ui-avatars.com/api/?name=HR&background=random'
            ],
            [
                'role_id' => 3,
                'client_id' => 2,
                'username' => 'user_herbalife',
                'name' => 'USER HERBALIFE',
                'password' => Hash::make('123123'),
                'photo' => 'https://ui-avatars.com/api/?name=US&background=random'
            ],
            [
                'role_id' => 6,
                'client_id' => 2,
                'username' => 'coordinator_herbalife',
                'name' => 'COORDINATOR HERBALIFE',
                'password' => Hash::make('123123'),
                'photo' => 'https://ui-avatars.com/api/?name=CL&background=random'
            ],
            [
                'role_id' => 4,
                'client_id' => 3,
                'username' => 'user_wings',
                'name' => 'USER WINGS',
                'password' => Hash::make('123123'),
                'photo' => 'https://ui-avatars.com/api/?name=US&background=random'
            ],
            [
                'role_id' => 6,
                'client_id' => 3,
                'username' => 'coordinator_wings',
                'name' => 'COORDINATOR WINGS',
                'password' => Hash::make('123123'),
                'photo' => 'https://ui-avatars.com/api/?name=CL&background=random'
            ],
            [
                'role_id' => 3,
                'client_id' => 1,
                'username' => 'user_astra',
                'name' => 'USER ASTRA',
                'password' => Hash::make('123123'),
                'photo' => 'https://ui-avatars.com/api/?name=US&background=random'
            ],
            [
                'role_id' => 6,
                'client_id' => 1,
                'username' => 'coordinator_astra',
                'name' => 'COORDINATOR ASTRA',
                'password' => Hash::make('123123'),
                'photo' => 'https://ui-avatars.com/api/?name=CL&background=random'
            ],
            [
                'role_id' => 5,
                'client_id' => 3,
                'username' => 'user_sales',
                'name' => 'USER SALES',
                'password' => Hash::make('123123'),
                'photo' => 'https://ui-avatars.com/api/?name=US&background=random'
            ],
        ];

        DB::table('users')->insert($user_data);

        // user for wings client
        $this->generateUserByRoleClient(4, 3, 1);

        // user for herbalife client
        $this->generateUserByRoleClient(3, 2, 1);

        // user for astra client
        $this->generateUserByRoleClient(3, 1, 1);

        // user for agility client
        $this->generateUserByRoleClient(3, 4, 1);
    }

    private function generateUserByRoleClient($role_id, $client_id, $total)
    {
        User::factory()->count($total)->create([
            'role_id' => $role_id,
            'client_id' => $client_id,
        ]);
    }
}
