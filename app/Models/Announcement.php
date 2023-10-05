<?php

namespace App\Models;

use App\Jobs\WhatsappNotification;
use Illuminate\Database\Eloquent\Model;
use App\Traits\ModelValidatable;
use Carbon\Carbon;
use Illuminate\Support\Facades\Queue;

class Announcement extends Model
{
    use ModelValidatable;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'announcements';

    /**
     * The attributes that aren't mass assignable.
     *
     * @var array
     */
    protected $guarded = ['_method', 'created_at', 'updated_at'];

    /**
     * The fields that should be filterable by query.
     *
     * @var array
     */
    public function scopeFilter($query, $request)
    {
        if ($request->filled('keyword')) {
            $query->where('title', 'like', '%' . $request->keyword . '%')
                ->orWhere('content', 'like', '%' . $request->keyword . '%');
        }

        if ($request->has('client_id')) {
            $query->where('client_id', $request->client_id);
        }

        $start_date = $end_date = Carbon::now();
        if ($request->has('start_date')) {
            $end_date = $end_date->addDay();
            if ($request->has('end_date')) {
                $end_date = Carbon::parse($request->end_date)->addDay();
            }
            $start_date  = Carbon::parse($request->start_date);
            $query->whereBetween('created_at', [
                $start_date->format('Y-m-d') . " 00:00:01", $end_date->format('Y-m-d') . " 23:59:59"
            ]);
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

    /**
     * Validation rules for the model.
     *
     * @return array
     */
    public function rules(): array
    {
        return [
            '*' => [
                'client_id' => 'required',
                'title' => 'required',
                'content' => 'required',
                'is_active' => 'required',
            ],
            'CREATE' => [],
            'UPDATE' => [],
        ];
    }

    public function notifs()
    {
        return $this->morphMany(Notification::class, 'notifiable');
    }

    public function syncToNotification()
    {
        if (!$this->is_active) {
            return;
        }

        $notif_data = [];
        $users = User::where('client_id', $this->client_id)->get();
        foreach ($users as $user) {
            $notif = new Notification;
            $notif->user_id = $user->id;
            $notif->type = "PENGUMUMAN";
            $notif->status = Notification::STATUS_NONE;
            $notif->description = $this->title;
            $notif_data[] = $notif;

            if (($user->profile->phone_number ?? "") != "") {
                $message = "*-- " . $user->client->name . " --*\n";
                $message .= "_PENGUMUMAN_: " . $this->title;
                $message .= "\n\nInfo lebih lanjut silahkan lihat di aplikasi NRA.";
                dispatch(new WhatsappNotification([
                    'phone' => $user->profile->phone_number,
                    'message' => $message,
                ]));
            }
        }

        $this->notifs()->saveMany($notif_data);
    }
}
