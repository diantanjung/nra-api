<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

use App\Traits\ModelValidatable;

class Chiller extends Model
{
    use ModelValidatable;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'chillers';

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
        $query->where('merchant_id',  $request->merchant_id);

        if ($request->filled('keyword')) {
            $query->where('merk', 'like', '%' . $request->keyword . '%')
                ->orWhere('type', 'like', '%' . $request->keyword . '%')
                ->orWhere('code', 'like', '%' . $request->keyword . '%');
        }

        if ($request->has('is_exclusive')) {
            $query->where('is_exclusive', $request->is_exclusive);
        }

        if ($request->has('merchant_id')) {
            $query->where('merchant_id', $request->merchant_id);
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
                'merchant_id' => 'required',
                'name' => 'required',
                'merk' => 'required',
                'type' => 'required',
                'category' => 'required',
                'capacity' => 'required',
                'is_exclusive' => 'required',
            ],
            'CREATE' => [],
            'UPDATE' => [],
        ];
    }

    /**
     * Get the merchant associated with the chiller.
     */
    public function merchant()
    {
        return $this->belongsTo(Merchant::class, 'merchant_id');
    }

    public function product_chillers()
    {
        return $this->hasMany(ProductChiller::class);
    }
}
