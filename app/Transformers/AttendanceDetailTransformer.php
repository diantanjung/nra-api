<?php

namespace App\Transformers;

use App\Models\Attendance;
use Carbon\Carbon;
use League\Fractal\TransformerAbstract;

class AttendanceDetailTransformer extends TransformerAbstract
{
    /**
     * A Fractal transformer.
     *
     * @param  \App\Models\Attendance  $attendance
     * @return array
     */
    public function transform(Attendance $attendance): array
    {
        return [
            'id' => (int) $attendance->id,
            'client' => (string) $attendance->user->client->name,
            'client_id' => (int) $attendance->user->client_id,
            'client_area_hour_id' => (int) $attendance->client_area_hour_id,
            'user_id' => (int) $attendance->user_id,
            'name' => (string) $attendance->user->name,
            'in_photo' => (string) $attendance->in_photo,
            'in_attachment' => (string) $attendance->in_attachment,
            'in_log_start' => (string) $attendance->in_log_start,
            'in_log_end' => (string) $attendance->in_log_end,
            'in_latitude' => (string) $attendance->in_latitude,
            'in_longitude' => (string) $attendance->in_longitude,
            'out_photo' => (string) $attendance->out_photo,
            'out_attachment' => (string) $attendance->out_attachment,
            'out_log_start' => (string) $attendance->out_log_start,
            'out_log_end' => (string) $attendance->out_log_end,
            'out_latitude' => (string) $attendance->out_latitude,
            'out_longitude' => (string) $attendance->out_longitude,
            'department_id' => (int) $attendance->user->profile->department_id,
            'department_name' => (string) ($attendance->user->profile->department->name ?? ''),
            'type' => (string) $attendance->type_label,
            'type_code' => (string) $attendance->type,
            'status' => (string) $attendance->status_label,
            'status_code' => (int) $attendance->status,
            'note' => (string) $attendance->note,
            'is_late' => (bool) $attendance->is_late,
            'is_halfday' => (bool) $attendance->is_halfday,
            'approved_note' => (string) $attendance->approved_note,
            'approved_by' => (int) $attendance->approved_by,
            'approved_by_name' => (string) ($attendance->approver->name ?? ''),
            'created_at' => (string) $attendance->created_at,
            'updated_at' => (string) $attendance->updated_at,
        ];
    }
}
