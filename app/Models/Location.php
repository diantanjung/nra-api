<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Location extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'locations';

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
        if ($request->has('province_id')) {
            $query->where('code',  'LIKE', '%'. $request->province_id .'.%')
                ->where('code', 'NOT LIKE', '%.%.%');
        } else {
            $query->where('code',  'NOT LIKE', '%.%.%')
                ->where('code', 'NOT LIKE', '%.%');
        }

        $query->orderBy('name');

        return $query;
    }

    public function parent()
    {
        $split_code = explode(".", $this->code);
        if (count($split_code) == 1) {
            return null;
        }

        $parent_code = $split_code[count($split_code) - 2];

        return $this->where("code", $parent_code)->first();
    }
}
