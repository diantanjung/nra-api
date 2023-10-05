<?php

namespace Database\Seeders;

use App\Models\Attendance;
use App\Models\Notification;
use App\Models\User;
use Illuminate\Database\Seeder;

class NotificationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user = User::find(1);
        $attendances = Attendance::all();
        foreach ($attendances as $attendance) {
            if ($attendance->type != Attendance::TYPE_WORK && $attendance->type != Attendance::TYPE_ABSEN) {
                $notif = new Notification;
                $notif->user_id = $attendance->user_id;
                $notif->type = $attendance->approval_type;
                $notif->status = $attendance->status == 1 ? Notification::STATUS_APPROVED : Notification::STATUS_REJECTED;
                $notif->description = "Pengajuan " . strtolower($attendance->type_label) . " telah " . ($attendance->status == 1 ? 'disetujui' : 'ditolak') . ' oleh ' . $user->name;
                $attendance->notif()->save($notif);
            }
        }
    }
}
