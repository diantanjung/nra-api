<?php

namespace Database\Seeders;

use App\Models\Survey;
use App\Models\SurveyDetail;
use App\Models\SurveySchedule;
use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SurveySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        foreach (SurveySchedule::limit(64)->get() as $survey_schedule) {
            $date = Carbon::parse($survey_schedule->date_time);
            if ($date->isToday()) {
                continue;
            }

            $survey_schedule->update(['status' => 1]);

            $rand_checkin = rand(0, 1);
            $checkin_photo = "-";
            if ($rand_checkin) {
                $checkin_photo = "https://ui-avatars.com/api/?name=WR&background=random";
            }

            $survey_data = [
                "user_id" => $survey_schedule->user_id,
                "schedule_id" => $survey_schedule->id,
                "log_start" => $date->copy()->format("Y-m-d H:i:s"),
                "log_end" => $date->copy()->addMinutes(rand(30, 60))->format("Y-m-d H:i:s"),
                "coordinat" => "-8.6698669,115.2121079",
                "checkin_photo" => $checkin_photo,
                "checked_chillers" => true,
                "checked_products" => true,
                "status" => 1,
            ];

            $survey = Survey::create($survey_data);

            foreach ($survey_schedule->merchant->chillers as $chiller) {
                $conditions = ["A", "B", "C"];
                $survey_detail_data = [
                    "survey_id" => $survey->id,
                    "chiller_id" => $chiller->id,
                    "chiller_photo" => "https://nafla-storage.sg-sin1.upcloudobjects.com/dev-cdn/MkzsqN3IMGIOGWpHGVea_1673170770.jpg",
                    "chiller_placement" => rand(0, 1),
                    "chiller_branding" => rand(0, 1),
                    "chiller_cleanliness" => rand(0, 1),
                    "chiller_condition" => $conditions[rand(0, 2)],
                    "chiller_maintenance" => rand(0, 1),
                    "planogram" => rand(0, 1),
                    "planogram_photo" => "https://nafla-storage.sg-sin1.upcloudobjects.com/dev-cdn/DrXv9wZbi6ApRaJiwtFG_1673170706.jpg",
                    "created_at" => $survey->log_start,
                ];

                $survey_detail = SurveyDetail::create($survey_detail_data);

                $survey_products = array();
                foreach ($chiller->product_chillers as $product_chiller) {
                    $survey_products[] = [
                        "survey_detail_id" => $survey_detail->id,
                        "product_chiller_id" => $product_chiller->id,
                        "product_id" => $product_chiller->product_id,
                        "sell_price" => $product_chiller->sell_price,
                        "stock" => rand(50, 100),
                        "sos" => 5,
                        "percentage" => 20,
                        "status" => rand(0, 1),
                        "created_at" => $survey->log_start,
                    ];
                }

                DB::table('survey_products')->insert($survey_products);
            }
        };
    }
}
