<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

use App\Traits\ModelValidatable;

class Product extends Model
{
    use ModelValidatable;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'products';

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
            $query->where('sku', 'like', '%' . $request->keyword . '%')
                ->orWhere('name', 'like', '%' . $request->keyword . '%');
        }

        if ($request->has('rtd')) {
            $query->where('is_rtd', $request->rtd);
        }

        if ($request->has('sales')) {
            $query->where('is_sales', $request->sales);
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

    public function scopeOnlyRTD($query)
    {
        $query->where('is_rtd', 1);
    }

    public function scopeOnlySales($query)
    {
        $query->where('is_sales', 1);
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
                'category_id' => 'required',
                'supplier_id' => 'required',
                'sku' => 'required',
                'name' => 'required',
                'photo' => 'required',
                'uom' => 'required',
                'weight' => 'required',
                'weight_type' => 'required',
                'sell_price' => 'required',
                'recommendation' => 'required',
                'depth' => 'required',
            ],
            'CREATE' => [],
            'UPDATE' => [],
        ];
    }

    public function category()
    {
        return $this->belongsTo(ProductCategory::class, 'category_id');
    }

    public function supplier()
    {
        return $this->belongsTo(Supplier::class, 'supplier_id');
    }
}
