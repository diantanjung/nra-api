<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

use App\Traits\ModelValidatable;
use Carbon\Carbon;

class Attendance extends Model
{
    use ModelValidatable;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'attendances';

    /**
     * The attributes that aren't mass assignable.
     *
     * @var array
     */
    protected $guarded = ['_method', 'created_at', 'updated_at'];


    // ---------- CONSTANTS ----------
    const TYPE_WORK = "K";
    const TYPE_ABSEN = "A";
    const TYPE_OVERTIME = "L";
    const TYPE_PERMISSION = "I";
    const TYPE_SICK = "S";
    const TYPE_LEAVE = "C";

    public function isNeedApproval(): bool
    {
        if ($this->type == self::TYPE_WORK || $this->type == self::TYPE_ABSEN) {
            return false;
        }

        return true;
    }

    public static function shiftList(): array
    {
        return [
            'non' => 'NON SHIFT',
            's1' => 'SHIFT 1',
            's2' => 'SHIFT 2',
            's3' => 'SHIFT 3',
        ];
    }

    public static function typeList(): array
    {
        return [
            'K' => 'KERJA',
            'A' => 'ABSEN',
            'L' => 'LEMBUR',
            'I' => 'IZIN',
            'S' => 'SAKIT',
            'C' => 'CUTI'
        ];
    }

    public static function approvalTypeList(): array
    {
        return [
            'L' => 'KONFIRMASI LEMBUR',
            'I' => 'KONFIRMASI IZIN',
            'S' => 'KONFIRMASI SAKIT',
            'C' => 'KONFIRMASI CUTI'
        ];
    }

    const STATUS_PROGRESS = 0;
    const STATUS_DONE = 1;
    const STATUS_REJECT = 2;

    public static function statusList(): array
    {
        return [
            'BELUM',
            'DITERIMA',
            'DITOLAK',
        ];
    }

    // ---------- CUSTOM ATTRIBUTES ----------
    public function getDateAttribute()
    {
        return Carbon::parse($this->in_log_start)->format('Y-m-d');
    }

    public function getShiftLabelAttribute()
    {
        return self::shiftList()[$this->shift];
    }

    public function getTypeLabelAttribute()
    {
        return self::typeList()[$this->type];
    }

    public function getApprovalTypeAttribute()
    {
        return self::approvalTypeList()[$this->type];
    }

    public function getStatusLabelAttribute()
    {
        return self::statusList()[$this->status];
    }

    protected static function booted()
    {
        static::creating(function ($attendance) {
            $user_auth = app('auth')->user();
            if ($user_auth != null) {
                $attendance->user_id = $user_auth->id;
                $attendance->client_id = $user_auth->client_id;
            }
        });
    }

    /**
     * The fields that should be filterable by query.
     *
     * @var array
     */
    public function scopeFilter($query, $request)
    {
        // limit access for user role
        $user_auth = app('auth')->user();
        if (in_array($user_auth->role_id, Role::USER_ONLY_ID)) {
            $query->where('user_id', $user_auth->id);
        } else {
            if ($request->has('user_id')) {
                $query->where('user_id', $request->user_id);
            }
        }

        if ($request->has('client_id')) {
            $query->where('client_id', $request->client_id);
        }

        if ($request->filled('keyword')) {
            $query->where('type', 'like', '%' . $request->keyword . '%')
                ->orWhere('status', 'like', '%' . $request->keyword . '%');
        }

        if ($request->has('start_date')) {
            $end_date = Carbon::parse($request->start_date)->addDay();
            if ($request->has('end_date')) {
                $end_date = Carbon::parse($request->end_date)->addDay();
            }

            $query->whereBetween('in_log_start', [$request->start_date, $end_date->format('Y-m-d')]);
        }

        if ($request->has('order_by')) {
            $order_dir = 'ASC';
            if ($request->has('order_dir')) {
                $order_dir = $request->order_dir;
            }

            $query->orderBy($request->order_by, $order_dir);
        }

        return $query;
    }

    public function scopeFilterApprovals($query, $request)
    {
        $query->where('type', '!=', Attendance::TYPE_WORK)
            ->where('type', '!=', Attendance::TYPE_ABSEN);

        if ($request->has('client_id')) {
            $query->where('client_id', $request->client_id);
        }

        if ($request->has('start_date')) {
            $end_date = Carbon::parse($request->start_date)->addDay();
            if ($request->has('end_date')) {
                $end_date = Carbon::parse($request->end_date)->addDay();
            }

            $query->whereBetween('in_log_start', [$request->start_date, $end_date->format('Y-m-d')]);
        }

        return $query;
    }

    /**
     * Validation rules for the model.
     *
     * @return array
     */
    public function rules(): array
    {
        return [
            '*' => [
                'type' => 'required',
                'status' => 'required',
            ],
            'CREATE' => [
                // 'in_latitude' => 'required',
                // 'in_longitude' => 'required',
                'in_log_start' => 'required',
                'in_log_end' => 'required',
            ],
            'UPDATE' => [],
        ];
    }

    /**
     * Get the user associated with the attendance.
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function approver()
    {
        return $this->belongsTo(User::class, 'approved_by');
    }

    public function notif()
    {
        return $this->morphOne(Notification::class, 'notifiable');
    }

    public function notifAdminMessage()
    {
        $type_label = strtolower($this->type_label);
        $date = Carbon::parse($this->in_log_start);
        $format_date = indo_day($date->copy()->dayOfWeekIso) . ", " . $date->copy()->format('d-M-Y');
        return "Pengguna " . $this->user->name . " telah mengajukan *" . $type_label . "* untuk hari " . $format_date . ".";
    }

    public function notifUserMessage()
    {
        $approver_name = $this->approver->name;
        $status_label = strtolower($this->status_label);
        $date = Carbon::parse($this->in_log_start);
        $format_date = indo_day($date->copy()->dayOfWeekIso) . ", " . $date->copy()->format('d-M-Y');
        return "Pengajuan " . $this->type_label . " anda untuk hari " . $format_date . " telah " . $status_label . " oleh " . $approver_name . ".";
    }

    public function syncAdminNotification($admin_id)
    {
        if ($this->type != self::TYPE_WORK && $this->type != self::TYPE_ABSEN) {
            $notif = new Notification;
            $notif->user_id = $admin_id;
            $notif->type = $this->approval_type;
            $notif->status = Notification::STATUS_NONE;
            $notif->description = $this->notifAdminMessage();
            $this->notif()->save($notif);
        }
    }

    public function syncUserNotification()
    {
        if ($this->type != self::TYPE_WORK && $this->type != self::TYPE_ABSEN) {
            $notif = new Notification;
            $notif->user_id = $this->user_id;
            $notif->type = $this->approval_type;
            $notif->status = $this->status == 1 ? Notification::STATUS_APPROVED : Notification::STATUS_REJECTED;
            $notif->description = $this->notifUserMessage();
            $this->notif()->save($notif);
        }
    }
}
