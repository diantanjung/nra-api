<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

use App\Traits\ModelValidatable;
use Carbon\Carbon;

class SurveySchedule extends Model
{
    use ModelValidatable;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'survey_schedules';

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
            $query->whereRelation('merchant', 'name', 'like', '%' . $request->keyword . '%');
        }

        if ($request->has('start_date')) {
            $end_date = Carbon::parse($request->start_date)->addDay();
            if ($request->has('end_date')) {
                $end_date = Carbon::parse($request->end_date)->addDay();
            }

            $query->whereBetween('date_time', [$request->start_date, $end_date->format('Y-m-d')]);
        }

        if ($request->has('user_id')) {
            $query->where('user_id', $request->user_id);
        }

        if ($request->has('user_ids') && !empty($request->user_ids)) {
            $query->whereIn('user_id', $request->user_ids);
        }

        if ($request->has('merchant_id')) {
            $query->where('merchant_id', $request->merchant_id);
        }

        if ($request->has('merchant_ids') && !empty($request->merchant_ids)) {
            $query->whereIn('merchant_id', $request->merchant_ids);
        }

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
                case 'merchant_name':
                    $query
                        ->with('merchant')
                        ->orderBy(Merchant::select('name')->whereColumn('merchants.id', 'survey_schedules.merchant_id'), $order_dir);
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
                'merchant_id' => 'required',
                'date_time' => 'required',
            ],
            'CREATE' => [],
            'UPDATE' => [],
        ];
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function merchant()
    {
        return $this->belongsTo(Merchant::class, 'merchant_id');
    }
}
