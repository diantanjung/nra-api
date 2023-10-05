<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

use App\Traits\ModelValidatable;
use Carbon\Carbon;

class Notification extends Model
{
    use ModelValidatable;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'notifications';

    /**
     * The attributes that aren't mass assignable.
     *
     * @var array
     */
    protected $guarded = ['_method', 'created_at', 'updated_at'];

    // ---------- CONSTANTS ----------
    const STATUS_NONE = "none";
    const STATUS_APPROVED = "approved";
    const STATUS_REJECTED = "rejected";

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
            $query->where('user_id', $user_auth->id)->orWhereNull('user_id');
        } else {
            if ($request->has('user_id')) {
                $query->where('user_id', $request->user_id)->orWhereNull('user_id');
            }
        }

        if ($request->has('type')) {
            $query->where('type', $request->type);
        }

        if ($request->has('is_read')) {
            $query->where('is_read', $request->is_read);
        }

        if ($request->has('status')) {
            $query->where('status', $request->status);
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
            '*' => [],
            'CREATE' => [],
            'UPDATE' => [
                'is_read' => 'required',
            ],
        ];
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function notifiable()
    {
        return $this->morphTo();
    }
}
