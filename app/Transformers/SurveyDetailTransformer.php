<?php

namespace App\Transformers;

use App\Models\SurveyDetail;
use League\Fractal\TransformerAbstract;

class SurveyDetailTransformer extends TransformerAbstract
{
    /**
     * A Fractal transformer.
     *
     * @param  \App\Models\SurveyDetail  $survey_detail
     * @return array
     */
    public function transform(SurveyDetail $survey_detail): array
    {
        return [
            'survey_id' => (int) $survey_detail->survey_id,
            'survey_detail_id' => (int) $survey_detail->id,
            'chiller_id' => (int) $survey_detail->chiller_id,
            'chiller_photo' => (string) $survey_detail->chiller_photo,
            'chiller_placement' => (bool) $survey_detail->chiller_placement,
            'chiller_placement_note' => (string) $survey_detail->chiller_placement_note,
            'chiller_branding' => (bool) $survey_detail->chiller_branding,
            'chiller_branding_note' => (string) $survey_detail->chiller_branding_note,
            'chiller_cleanliness' => (bool) $survey_detail->chiller_cleanliness,
            'chiller_cleanliness_note' => (string) $survey_detail->chiller_cleanliness_note,
            'chiller_condition' => (string) $survey_detail->chiller_condition,
            'chiller_condition_note' => (string) $survey_detail->chiller_condition_note,
            'chiller_maintenance' => (bool) $survey_detail->chiller_maintenance,
            'chiller_maintenance_note' => (string) $survey_detail->chiller_maintenance_note,
        ];
    }
}
