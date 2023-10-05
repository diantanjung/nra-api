<?php

namespace App\Transformers;

use App\Models\Survey;
use League\Fractal\TransformerAbstract;

class SurveyTransformer extends TransformerAbstract
{
    /**
     * A Fractal transformer.
     *
     * @param  \App\Models\Survey  $survey
     * @return array
     */
    public function transform(Survey $survey): array
    {
        return [
            'id' => (int) $survey->id,
            'schedule_id' => (int) $survey->schedule_id,
            'schedule_date' => (string) ($survey->schedule->date_time ?? ""),
            'user_id' => (int) $survey->user_id,
            'user_name' => (string) ($survey->user->name ?? ""),
            'merchant_id' => (int) ($survey->schedule->merchant_id ?? 0),
            'merchant_name' => (string) ($survey->schedule->merchant->name ?? ""),
            'merchant_address' => (string) ($survey->schedule->merchant->full_address ?? ""),
            'log_start' => (string) $survey->log_start,
            'log_end' => (string) $survey->log_end,
            'coordinat' => (string) $survey->coordinat,
            'status' => (int) $survey->status,
            'status_label' => (string) $survey->status_label,
            'is_closed' => (bool) $survey->is_closed,
            'checkin_photo' => (string) $survey->checkin_photo,
            'checked_chillers' => (bool) $survey->checked_chillers,
            'checked_products' => (bool) $survey->checked_products,
        ];
    }
}
