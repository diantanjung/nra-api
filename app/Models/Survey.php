<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

use App\Traits\ModelValidatable;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class Survey extends Model
{
    use ModelValidatable;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'surveys';

    /**
     * The attributes that aren't mass assignable.
     *
     * @var array
     */
    protected $guarded = ['_method', 'created_at', 'updated_at'];

    /**
     * The "booted" method of the model.
     *
     * @return void
     */
    protected static function booted()
    {
        static::creating(function ($survey) {
            if (Auth::id() != null) {
                $survey->user_id = Auth::id();
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
        if ($request->filled('keyword')) {
            $query->whereRelation('schedule.merchant', 'name', 'like', '%' . $request->keyword . '%');
        }

        if ($request->filled('date')) {
            $query->whereDate('log_start', '=', $request->date);
        }

        if ($request->filled('merchant_id')) {
            $merchants = explode(",", $request->merchant_id);
            $query->whereHas('schedule', function ($query) use ($merchants) {
                $query->whereIn('merchant_id', $merchants);
            });
        }

        if ($request->filled('user_id')) {
            $user_ids = explode(",", $request->user_id);
            $query->whereIn('user_id', $user_ids);
        }

        if ($request->filled('status')) {
            $statuses = explode(",", $request->status);
            $query->whereIn('status', $statuses);
        }

        if ($request->filled('order_by')) {
            $order_dir = 'ASC';
            if ($request->has('order_dir')) {
                $order_dir = $request->order_dir;
            }
            switch ($request->order_by) {
                case 'user_name':
                    $query
                        ->with('user')
                        ->orderBy(User::select('name')->whereColumn('users.id', 'surveys.user_id'), $order_dir);
                    break;
                case 'merchant_name':
                    break;
                default:
                    $query->orderBy($request->order_by, $order_dir);
                    break;
            }
        }

        return $query;
    }

    public function scopeFilterReport($query, $request)
    {
        $start_date = Carbon::now()->subWeek()->format("Y-m-d");
        $end_date = Carbon::tomorrow()->format("Y-m-d");
        if ($request->has('start_date')) {
            $start_date = $request->start_date;
        }

        if ($request->has('end_date')) {
            $end_date = Carbon::parse($request->end_date)->addDay()->format("Y-m-d");
        }

        $query->whereBetween('log_start', [$start_date, $end_date]);

        if ($request->has('merchant_id')) {
            $merchants = explode(",", $request->merchant_id);
            $query->whereHas('schedule', function ($query) use ($merchants) {
                $query->whereIn('merchant_id', $merchants);
            });
        }

        if ($request->has('user_id')) {
            $user_ids = explode(",", $request->user_id);
            $query->whereIn('user_id', $user_ids);
        }

        if ($request->has('status')) {
            $statuses = explode(",", $request->status);
            $query->whereIn('status', $statuses);
        }

        if ($request->has('province_id') && !$request->has('city_id')) {
            $provinces = explode(",", $request->province_id);
            $query->whereHas('schedule.merchant', function ($query) use ($provinces) {
                $query->whereIn('province_id', $provinces);
            });
        }

        if ($request->has('city_id')) {
            $cities = explode(",", $request->city_id);
            $query->whereHas('schedule.merchant', function ($query) use ($cities) {
                $query->whereIn('city_id', $cities);
            });
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
            'CREATE' => [
                'schedule_id' => 'required',
                'coordinat' => 'required',
                'log_start' => 'required',
                'checkin_photo' => 'required',
                'status' => 'required',
            ],
            'UPDATE' => [],
        ];
    }

    public function getStatusLabelAttribute()
    {
        if ($this->status != "") {
            return self::statusList()[$this->status];
        }

        return "";
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function schedule()
    {
        return $this->belongsTo(SurveySchedule::class, 'schedule_id');
    }

    public function details()
    {
        return $this->hasMany(SurveyDetail::class);
    }

    public function checkDetailPerChiller($chiller_id)
    {
        foreach ($this->details as $detail) {
            if ($detail->chiller_id === $chiller_id) {
                return true;
            }
        }

        return false;
    }

    public function checkProductPerChiller($chiller_id)
    {
        foreach ($this->details as $detail) {
            if ($detail->chiller_id === $chiller_id) {
                if (count($detail->products) > 0) {
                    return true;
                }
            }
        }

        return false;
    }

    const STATUS_DRAFT = 0;
    const STATUS_DONE = 1;
    const STATUS_REJECT = 2;

    public static function statusList(): array
    {
        return [
            'DRAFT',
            'SELESAI',
            'BATAL',
        ];
    }
}
