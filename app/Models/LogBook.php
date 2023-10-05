<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

use App\Traits\ModelValidatable;
use Carbon\Carbon;

class LogBook extends Model
{
    use ModelValidatable;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'log_books';

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
        // limit access for user role
        $user_auth = app('auth')->user();
        if (in_array($user_auth->role_id, Role::USER_ONLY_ID)) {
            $query->where('user_id', $user_auth->id);
        } else {
            if ($request->has('user_id')) {
                $query->where('user_id', $request->user_id);
            }
        }

        if ($request->has('user_ids') && !empty($request->user_ids)) {
            $query->whereIn('user_id', $request->user_ids);
        }

        if ($request->filled('keyword')) {
            $query->where('category', 'like', '%' . $request->keyword . '%')
                ->orWhere('activity', 'like', '%' . $request->keyword . '%');
        }

        $start_date = $end_date = Carbon::now();
        if ($request->has('start_date')) {
            $end_date = $end_date->addDay();
            if ($request->has('end_date')) {
                $end_date = Carbon::parse($request->end_date)->addDay();
            }
            $start_date  = Carbon::parse($request->start_date);
        }

        $query->whereBetween('datetime', [
            $start_date->format('Y-m-d') . " 00:00:01", $end_date->format('Y-m-d') . " 23:59:59"
        ]);

        if ($request->has('order_by')) {
            $order_dir = 'ASC';
            if ($request->has('order_dir')) {
                $order_dir = $request->order_dir;
            }

            switch ($request->order_by) {
                case 'user_name':
                    $query
                        ->with('user')
                        ->orderBy(User::select('name')->whereColumn('users.id', 'survey_schedules.user_id'), $order_dir);
                    break;
                default:
                    $query->orderBy($request->order_by, $order_dir);
                    break;
            }
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
                'user_id' => 'required',
                'category' => 'required',
                'datetime' => 'required',
                'activity' => 'required',
            ],
            'CREATE' => [],
            'UPDATE' => [],
        ];
    }

    /**
     * Get the user associated with the log book.
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
