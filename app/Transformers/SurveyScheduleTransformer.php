<?php

namespace App\Transformers;

use App\Models\SurveySchedule;
use League\Fractal\TransformerAbstract;

class SurveyScheduleTransformer extends TransformerAbstract
{
    /**
     * A Fractal transformer.
     *
     * @param  \App\Models\SurveySchedule  $survey_schedule
     * @return array
     */
    public function transform(SurveySchedule $survey_schedule): array
    {
        return [
            'id' => (int) $survey_schedule->id,
            'user_id' => (int) $survey_schedule->user_id,
            'user_name' => (string) $survey_schedule->user->name,
            'merchant_id' => (int) $survey_schedule->merchant_id,
            'merchant_name' => (string) $survey_schedule->merchant->name,
            'merchant_address' => (string) $survey_schedule->merchant->full_address,
            'merchant_is_closed' => (bool) $survey_schedule->merchant->is_closed,
            'merchant_is_closed_time' => (string) $survey_schedule->merchant->is_closed_time,
            'date_time' => (string) $survey_schedule->date_time,
            'status' => (int) $survey_schedule->status,
        ];
    }
}
