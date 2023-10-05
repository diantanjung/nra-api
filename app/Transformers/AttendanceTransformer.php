<?php

namespace App\Transformers;

use App\Models\Attendance;
use Carbon\Carbon;
use League\Fractal\TransformerAbstract;

class AttendanceTransformer extends TransformerAbstract
{
    /**
     * A Fractal transformer.
     *
     * @param  \App\Models\Attendance  $attendance
     * @return array
     */
    public function transform(Attendance $attendance): array
    {
        $time_in = Carbon::parse($attendance->in_log_start)->format('H:i:s');
        $time_out = "";
        if ($attendance->out_log_start != null) {
            $time_out = Carbon::parse($attendance->out_log_start)->format('H:i:s');
        }

        return [
            'id' => (int) $attendance->id,
            'client' => (string) $attendance->user->client->name,
            'client_id' => (int) $attendance->user->client_id,
            'client_area_hour_id' => (int) $attendance->client_area_hour_id,
            'user_id' => (int) $attendance->user_id,
            'name' => (string) $attendance->user->name,
            'photo' => (string) $attendance->in_photo,
            'department_id' => (int) $attendance->user->profile->department_id,
            'department_name' => (string) ($attendance->user->profile->department->name ?? ''),
            'type' => (string) $attendance->type_label,
            'type_code' => (string) $attendance->type,
            'status' => (string) $attendance->status_label,
            'status_code' => (int) $attendance->status,
            'date' => (string) $attendance->date,
            'time_in' => (string) $time_in,
            'time_out' => (string) $time_out,
            'note' => (string) $attendance->note,
        ];
    }
}
