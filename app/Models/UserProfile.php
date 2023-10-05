<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;


class UserProfile extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'user_profiles';

    /**
     * The attributes that aren't mass assignable.
     *
     * @var array
     */
    protected $guarded = ['_method', 'created_at', 'updated_at'];

    /**
     * Get the department associated with the user.
     */
    public function department()
    {
        return $this->belongsTo(Department::class, 'department_id');
    }

    /**
     * Get the area associated with the user.
     */
    public function client_area()
    {
        return $this->belongsTo(ClientArea::class, 'client_area_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function user_contract()
    {
        return $this->belongsTo(UserContract::class, 'contract_id');
    }

    public function rules(): array
    {
        return [
            '*' => [
                'user_id' => 'required',
                'department_id' => 'required',
                'client_area_id' => 'required',
            ],
            'CREATE' => [],
            'UPDATE' => [],
        ];
    }
}
