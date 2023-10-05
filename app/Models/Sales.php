<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

use App\Traits\ModelValidatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Sales extends Model
{
    use HasFactory, ModelValidatable;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'sales';

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

        if ($request->has('event_id')) {
            $query->where('event_id', $request->event_id);
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
                'user_id' => 'required',
                'longitude' => 'required',
                'latitude' => 'required',
                'total_item' => 'required',
                'total_amount' => 'required',
                'pay_amount' => 'required',
                'return_amount' => 'required',
            ],
            'CREATE' => [],
            'UPDATE' => [],
        ];
    }

    /**
     * Relation function.
     *
     * @return object
     */
    public function details()
    {
        return $this->hasMany(SaleDetail::class, 'sales_id');
    }
}
