<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

use App\Traits\ModelValidatable;

class ClientAreaHour extends Model
{
    use ModelValidatable;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'client_area_hours';

    /**
     * The attributes that aren't mass assignable.
     *
     * @var array
     */
    protected $guarded = ['_method', 'created_at', 'updated_at'];

    /**
     * Get the client associated with the location.
     */
    public function client_area()
    {
        return $this->belongsTo(ClientArea::class, 'client_area_id');
    }
}
