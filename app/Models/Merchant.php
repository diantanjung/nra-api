<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

use App\Traits\ModelValidatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Merchant extends Model
{
    use HasFactory, ModelValidatable;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'merchants';

    /**
     * The attributes that aren't mass assignable.
     *
     * @var array
     */
    protected $guarded = ['_method', 'created_at', 'updated_at'];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'is_closed_time' => 'datetime',
    ];

    /**
     * The fields that should be filterable by query.
     *
     * @var array
     */
    public function scopeFilter($query, $request)
    {
        if ($request->filled('keyword')) {
            $query->where('name', 'like', '%' . $request->keyword . '%')
                ->orWhere('contact_name', 'like', '%' . $request->keyword . '%');
        }

        if ($request->has('province_id') && !$request->has('city_id')) {
            $provinces = explode(",", $request->province_id);
            $query->whereIn('province_id', $provinces);
        }

        if ($request->has('city_id')) {
            $cities = explode(",", $request->city_id);
            $query->whereIn('city_id', $cities);
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
                'name' => 'required',
                'photo' => 'required',
                'contact_name' => 'required',
                'contact_number' => 'required',
                'province_id' => 'required',
                'city_id' => 'required',
                'address' => 'required',
            ],
            'CREATE' => [],
            'UPDATE' => [],
        ];
    }

    /**
     * Get the chillers that owns the clients.
     */
    public function chillers()
    {
        return $this->hasMany(Chiller::class);
    }
}
