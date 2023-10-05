<?php

namespace Database\Seeders;

use App\Models\Attendance;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class AttendanceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $latitude = "-8.3358957";
        $longitude = "113.5330736";
        $photo = "https://ui-avatars.com/api/?name=AT&background=random";
        $now = Carbon::now();

        $data = [
            [
                'client_id' => 2,
                'client_area_hour_id' => 3,
                'user_id' => 3,
                'type' => Attendance::TYPE_WORK,
                'status' => Attendance::STATUS_DONE,
                'in_latitude' => $latitude,
                'in_longitude' => $longitude,
                'in_photo' => $photo,
                'in_attachment' => NULL,
                'in_log_start' => $now->copy()->format('Y-m-d') . ' 09:00:00',
                'in_log_end' => $now->copy()->format('Y-m-d') . ' 09:10:00',
                'out_latitude' => $latitude,
                'out_longitude' => $longitude,
                'out_photo' => $photo,
                'out_attachment' => NULL,
                'out_log_start' => $now->copy()->format('Y-m-d') . ' 17:00:00',
                'out_log_end' => $now->copy()->format('Y-m-d') . ' 17:05:00',
                'approved_by' => 2,
                'note' => NULL
            ],
            [
                'client_id' => 2,
                'client_area_hour_id' => 3,
                'user_id' => 3,
                'type' => Attendance::TYPE_OVERTIME,
                'status' => Attendance::STATUS_DONE,
                'in_latitude' => $latitude,
                'in_longitude' => $longitude,
                'in_photo' => $photo,
                'in_attachment' => NULL,
                'in_log_start' => $now->copy()->subDays(1)->format('Y-m-d') . ' 17:00:00',
                'in_log_end' => $now->copy()->subDays(1)->format('Y-m-d') . ' 17:05:00',
                'out_latitude' => $latitude,
                'out_longitude' => $longitude,
                'out_photo' => $photo,
                'out_attachment' => NULL,
                'out_log_start' => $now->copy()->subDays(1)->format('Y-m-d') . ' 20:00:00',
                'out_log_end' => $now->copy()->subDays(1)->format('Y-m-d') . ' 20:05:00',
                'approved_by' => NULL,
                'note' => NULL
            ],
            [
                'client_id' => 2,
                'client_area_hour_id' => 3,
                'user_id' => 3,
                'type' => Attendance::TYPE_PERMISSION,
                'status' => Attendance::STATUS_REJECT,
                'in_latitude' => $latitude,
                'in_longitude' => $longitude,
                'in_photo' => $photo,
                'in_attachment' => NULL,
                'in_log_start' => $now->copy()->subDays(2)->format('Y-m-d') . ' 09:00:00',
                'in_log_end' => $now->copy()->subDays(2)->format('Y-m-d') . ' 09:05:00',
                'out_latitude' => NULL,
                'out_longitude' => NULL,
                'out_photo' => NULL,
                'out_attachment' => NULL,
                'out_log_start' => NULL,
                'out_log_end' => NULL,
                'approved_by' => 2,
                'note' => "Harap izin mulai H-1",
            ]
        ];

        DB::table('attendances')->insert($data);
    }
}
