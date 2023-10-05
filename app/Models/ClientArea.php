<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

use App\Traits\ModelValidatable;

class ClientArea extends Model
{
    use ModelValidatable;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'client_areas';

    /**
     * The attributes that aren't mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'client_id',
        'area_id',
        'address',
        'latitude',
        'longitude',
        'radius',
        'gmaps_url',
        'site_photo',
        'qr_photo',
    ];

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
                'area_id' => 'required',
                'address' => 'required',
            ],
            'CREATE' => [],
            'UPDATE' => [],
        ];
    }

    /**
     * The fields that should be filterable by query.
     *
     * @var array
     */
    public function scopeFilter($query, $request)
    {
        if ($request->filled('keyword')) {
            $query->where('address', 'like', '%' . $request->keyword . '%')
                ->orWhereRelation('client', 'name', 'like', '%' . $request->keyword . '%')
                ->orWhereRelation('area', 'name', 'like', '%' . $request->keyword . '%');
        }

        if ($request->has('client_id')) {
            $query->where('client_id', $request->client_id);
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
     * Get the client associated with the location.
     */
    public function client()
    {
        return $this->belongsTo(Client::class, 'client_id');
    }

    /**
     * Get the area associated with the location.
     */
    public function area()
    {
        return $this->belongsTo(Area::class, 'area_id');
    }

    public function workingHours()
    {
        return $this->hasMany(ClientAreaHour::class, 'client_area_id');
    }
}
