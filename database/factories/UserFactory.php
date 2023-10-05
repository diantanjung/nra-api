<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;
use Faker\Factory as Faker;

class UserFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = User::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $faker = Faker::create('id_ID');
        $name = $faker->name();
        return [
            'name' => $name,
            'password' => Hash::make('123123'),
            'username' => $faker->nik(),
            'role_id' => 4,
            'client_id' => 3,
            'photo' => "https://ui-avatars.com/api/?name=". $name[0] ."&background=random",
        ];
    }
}
