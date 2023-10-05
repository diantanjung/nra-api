<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\SurveySchedule;
use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SurveyScheduleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = array();
        $users = User::onlyUserSurveyor()->get();
        $merchant_index = 0;
        $first_date = Carbon::parse("2023-07-01");
        foreach (range(1, 33) as $x) {
            $set_date = $first_date->addDay();
            $isWeekDay = $set_date->dayOfWeek != Carbon::SUNDAY && $set_date->dayOfWeek != Carbon::SATURDAY;
            if ($isWeekDay) {
                foreach ($users as $user) {
                    $time_index = 9;
                    foreach (range($merchant_index + 1, $merchant_index + 8) as $index) {
                        if ($time_index == 12) {
                            $time_index++;
                        }

                        $data[] = [
                            'user_id' => $user->id,
                            'merchant_id' => $index,
                            'date_time' => $set_date->copy()->setTime($time_index, 0, 0, 0)
                        ];

                        $time_index++;

                        if ($index === 1000) {
                            $merchant_index = -8;
                        }
                    }

                    $merchant_index += 8;
                }
            }
        }

        DB::table('survey_schedules')->insert($data);

        $survery_schedule = SurveySchedule::find(1);
        $survery_schedule->update(['status' => 1]);
    }
}
