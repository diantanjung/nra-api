<?php

namespace App\Repository;

use App\Jobs\WhatsappNotification;
use App\Models\Attendance;
use App\Models\User;
use App\Transformers\AttendanceDetailTransformer;
use App\Transformers\AttendanceTransformer;
use Carbon\Carbon;
use Carbon\CarbonPeriod;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use App\Traits\PushNotificationTrait;

class AttendanceRepository
{
    use PushNotificationTrait;
    /**
     * Get list of paginated attendances.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function getAll(Request $request): array
    {
        $attendances = Attendance::filter($request)->paginate($request->get('per_page', 20));

        return fractal($attendances, new AttendanceTransformer())->toArray();
    }

    public function getApprovals(Request $request): array
    {
        $attendances = Attendance::filterApprovals($request)->get();
        // TODO: filter dari tgl pengajuan, tgl buat

        $detail = ['total' => 0, 'list' => []];
        $approvals = array('sakit' => $detail, 'izin' => $detail, 'cuti' => $detail, 'lembur' => $detail);
        foreach ($attendances as $attendance) {
            if ($attendance->type == Attendance::TYPE_OVERTIME) {
                $group_code = 'lembur';
            } else if ($attendance->type == Attendance::TYPE_LEAVE) {
                $group_code = 'cuti';
            } else if ($attendance->type == Attendance::TYPE_SICK) {
                $group_code = 'sakit';
            } else {
                $group_code = 'izin';
            }

            if ($attendance->status == 0) {
                $approvals[$group_code]['total']++;
            }

            $attendance_transformer = fractal($attendance, new AttendanceTransformer())->toArray();
            array_push($approvals[$group_code]['list'], $attendance_transformer['data']);
        }

        return $approvals;
    }

    /**
     * Get list of paginated attendances.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function getSummary(Request $request): array
    {
        // TODO: check jam pulang terus bertambah hitungannya klo lupa di set
        // TODO: total hadir adalah yg di approve saja
        // TODO: perlu set di awal total jam kerja per klien 6 jam (default)
        $attendances = Attendance::filter($request)->get();
        $charts_detail = array();
        $charts_label = array();
        $total_working_hour = 0;
        $summary = [
            "hadir" => 0,
            "absen" => 0,
            "izin" => 0,
            "sakit" => 0,
            "lembur" => 0,
            "cuti" => 0,
        ];

        $charts_date = array();
        $period = CarbonPeriod::create($request->start_date, $request->end_date);
        foreach ($period as $date) {
            $charts_detail[] = "Off";
            $charts_label[] = [
                "day" => indo_day($date->dayOfWeekIso, true),
                "hours" => 0,
            ];
            $charts_date[] = $date->format('Y-m-d');
        }

        foreach ($attendances as $attendance) {
            $start = Carbon::parse($attendance->in_log_start);
            $diff = $start->diffInHours(Carbon::now());
            $time_in = $start->copy()->format('H:i:s');
            $time_out = "";
            if ($attendance->out_log_start != null) {
                $end = Carbon::parse($attendance->out_log_start);
                $time_out = $end->copy()->format('H:i:s');
                $diff = $start->diffInHours($end);
            }

            $detail = $time_in;
            if ($attendance->type == Attendance::TYPE_WORK || $attendance->type == Attendance::TYPE_OVERTIME) {
                $detail .= " - " . $time_out;
                $total_working_hour += $diff;
            }

            $key = array_search($start->copy()->format('Y-m-d'), $charts_date);
            if (array_key_exists($key, $charts_detail)) {
                $charts_label[$key]["hours"] = $diff;
                $charts_detail[$key] = $detail;
            }

            if ($attendance->type == Attendance::TYPE_WORK) {
                $summary['hadir']++;
            } else if ($attendance->type == Attendance::TYPE_ABSEN) {
                $summary['absen']++;
            } else if ($attendance->type == Attendance::TYPE_PERMISSION) {
                $summary['izin']++;
            } else if ($attendance->type == Attendance::TYPE_SICK) {
                $summary['sakit']++;
            } else if ($attendance->type == Attendance::TYPE_OVERTIME) {
                $summary['lembur']++;
            } else if ($attendance->type == Attendance::TYPE_LEAVE) {
                $summary['cuti']++;
            }
        }

        $data = [
            "start_date" => $request->start_date,
            "end_date" => $request->end_date,
            "total_working_hour" => $total_working_hour,
            "charts_label" => $charts_label,
            "charts_detail" => $charts_detail,
            "charts_date" => $charts_date,
            "summary" => $summary
        ];

        return $data;
    }

    /**
     * Get a attendance by ID.
     *
     * @param  int  $id
     * @return array
     *
     * @throws \Illuminate\Database\Eloquent\ModelNotFoundException
     */
    public function getById(int $id): array
    {
        $attendance = Attendance::findOrFail($id);

        return fractal($attendance, new AttendanceDetailTransformer())->toArray();
    }

    public function getDaily(int $user_id, string $type)
    {
        $attendance = Attendance::where('user_id', $user_id)
            ->where('type', $type)
            ->whereDate('in_log_start', date('Y-m-d'))
            ->first();

        return $attendance;
    }

    public function getClientCoordinat()
    {
        $user_auth = app('auth')->user();
        $client_area = $user_auth->profile->client_area;
        return [
            'latitude' => $client_area->latitude,
            'longitude' => $client_area->longitude,
            'radius' => $client_area->radius,
            'date_time' => date('Y-m-d H:i:s'),
            'working_hours' => $client_area->workingHours,
        ];
    }


    /**
     * Store a new attendance.
     *
     * @param  array  $attrs
     * @return array
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(array $attrs): array
    {
        $attendance = new Attendance($attrs);
        if (!$attendance->isValidFor('CREATE')) {
            throw new ValidationException($attendance->validator());
        }

        $attendance->save();
        // TODO: tambah generate image with watermark

        // send notif to admin
        if ($attendance->isNeedApproval()) {
            $this->sendApprovalToAdmin($attendance);
        }

        return fractal($attendance, new AttendanceTransformer())->toArray();
    }

    /**
     * Update a attendance by ID.
     *
     * @param  int  $id
     * @param  array  $attrs
     * @return array
     *
     * @throws \Illuminate\Database\Eloquent\ModelNotFoundException
     * @throws \Illuminate\Validation\ValidationException
     */
    public function updateById(int $id, array $attrs): array
    {
        $attendance = Attendance::findOrFail($id);
        $attendance->fill($attrs);

        if (!$attendance->isValidFor('UPDATE')) {
            throw new ValidationException($attendance->validator());
        }

        $attendance->save();

        return fractal($attendance, new AttendanceTransformer())->toArray();
    }

    public function updateLateById(array $attrs): array
    {
        $attendance = Attendance::whereDate('in_log_start', $attrs['out_date'])->firstOrFail();
        $update_data = [
            "is_late" => 1,
            "out_log_start" => $attrs['out_date'] . " " . $attrs['out_time'],
            "out_log_end" => $attrs['out_date'] . " " . $attrs['out_time'],
            "note" => $attrs['note']
        ];

        $attendance->fill($update_data);
        $attendance->save();

        return fractal($attendance, new AttendanceTransformer())->toArray();
    }

    public function updateApprovalById(array $attrs): array
    {
        $admin_id = app('auth')->user()->id;
        $attendance = Attendance::findOrFail($attrs["id"]);
        $update_data = [
            "status" => $attrs['status'],
            "approved_note" => $attrs['approved_note'],
            "approved_by" => $admin_id,
        ];

        $attendance->fill($update_data);
        $attendance->save();

        // send notif to user
        $this->sendApprovalToUser($attendance);

        return fractal($attendance, new AttendanceTransformer())->toArray();
    }

    /**
     * Delete a attendance by ID.
     *
     * @param  int  $id
     * @return bool
     *
     * @throws \Illuminate\Database\Eloquent\ModelNotFoundException
     */
    public function deleteById(int $id): bool
    {
        $attendance = Attendance::findOrFail($id);

        return (bool) $attendance->delete();
    }

    private function sendApprovalToAdmin($attendance)
    {
        $admin = User::where('username', 'admin')->first();
        // sync notification
        $attendance->syncAdminNotification($admin->id);

        $message = $attendance->notifAdminMessage();
        if ($attendance->note != "") {
            $message .= "\nCatatan : " . $attendance->note;
        }

        $message .= "\n\nInfo lebih lanjut silahkan lihat di aplikasi NRA.";

        dispatch(new WhatsappNotification([
            'phone' => $admin->profile->phone_number,
            'message' => $message,
        ]));
    }

    private function sendApprovalToUser($attendance)
    {
        // sync notification
        $attendance->syncUserNotification();

        $message = $attendance->notifUserMessage();
        if ($attendance->approved_note != "") {
            $message .= "\nCatatan : " . $attendance->approved_note;
        }

        $message .= "\n\nInfo lebih lanjut silahkan lihat di aplikasi NRA.";

        dispatch(new WhatsappNotification([
            'phone' => $attendance->user->profile->phone_number,
            'message' => $message,
        ]));

        $this->pushNotificationToUser($attendance->user->id);
    }
}
