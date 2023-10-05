<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->call([
            LocationSeeder::class,
            DepartmentSeeder::class,
            AreaSeeder::class,
            RegulationSeeder::class,
            ClientSeeder::class,
            ArchiveSeeder::class,
            UserSeeder::class,
            ContractSeeder::class,
            UserProfileSeeder::class,
            // AttendanceSeeder::class,
            SupplierSeeder::class,
            ProductCategorySeeder::class,
            ProductSeeder::class,
            MerchantSeeder::class,
            ChillerSeeder::class,
            ProductChillerSeeder::class,
            SurveyScheduleSeeder::class,
            SurveySeeder::class,
            // NotificationSeeder::class,
        ]);
    }
}
