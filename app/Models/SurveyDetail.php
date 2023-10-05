<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

use App\Traits\ModelValidatable;

class SurveyDetail extends Model
{
    use ModelValidatable;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'survey_details';

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
                'survey_id' => 'required',
            ],
            'CREATE' => [],
            'UPDATE' => [],
        ];
    }

    public function survey()
    {
        return $this->belongsTo(Survey::class, 'survey_id');
    }

    public function chiller()
    {
        return $this->belongsTo(Chiller::class, 'chiller_id');
    }

    public function products()
    {
        return $this->hasMany(SurveyProduct::class);
    }
}
