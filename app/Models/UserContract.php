<?php

namespace App\Models;

use App\Traits\ModelValidatable;
use Illuminate\Database\Eloquent\Model;


class UserContract extends Model
{
    use ModelValidatable;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'user_contracts';

    /**
     * The attributes that aren't mass assignable.
     *
     * @var array
     */
    protected $guarded = ['_method', 'created_at', 'updated_at'];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function contract_type()
    {
        return $this->belongsTo(ContractType::class, 'contract_type_id');
    }

    /**
     * The fields that should be filterable by query.
     *
     * @var array
     */
    public function scopeFilter($query, $request)
    {
        if ($request->filled('keyword')) {
            $query->whereRelation('user', 'name', 'like', '%' . $request->keyword . '%');
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
                        ->orderBy(User::select('name')->whereColumn('users.id', 'user_contracts.user_id'), $order_dir);
                    break;
                case 'contract_type_name':
                    $query
                        ->with('contract_type')
                        ->orderBy(ContractType::select('name')->whereColumn('contract_types.id', 'user_contracts.contract_type_id'), $order_dir);
                    break;
                default:
                    $query->orderBy($request->order_by, $order_dir);
                    break;
            }
        }
        return $query;
    }

    public function rules(): array
    {
        return [
            '*' => [
                'user_id' => 'required',
                'contract_type_id' => 'required',
                'effective_date_start' => 'required',
                'effective_date_end' => 'required',
            ],
            'CREATE' => [],
            'UPDATE' => [],
        ];
    }
}
