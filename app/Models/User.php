<?php

namespace App\Models;

use App\Traits\AttributeHashable;
use App\Traits\ModelValidatable;
use Illuminate\Auth\Authenticatable;
use Illuminate\Contracts\Auth\Access\Authorizable as AuthorizableContract;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use Laravel\Lumen\Auth\Authorizable;
use Tymon\JWTAuth\Contracts\JWTSubject;
use App\Traits\FileUploadable;


class User extends Model implements AuthenticatableContract, AuthorizableContract, JWTSubject
{
    use Authenticatable, Authorizable, ModelValidatable, AttributeHashable, HasFactory, FileUploadable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'client_id', 'role_id', 'username', 'name', 'password', 'photo', 'device_token'
    ];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = [
        'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $visible = [
        'id', 'name', 'username',
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
                ->orWhere('username', 'like', '%' . $request->keyword . '%')
                ->OrWhereRelation('role', 'name', 'like', '%' . $request->keyword . '%');
        }

        if ($request->has('role_id')) {
            $query->whereIn('role_id', explode(",", $request->role_id));
        }

        $order_by = 'name';
        $order_dir = 'ASC';
        if ($request->has('order_by')) {
            $order_by = $request->order_by;
            if ($request->has('order_dir')) {
                $order_dir = $request->order_dir;
            }
        }

        $query->orderBy($order_by, $order_dir);

        return $query;
    }

    /**
     * Hash the attributes before saving.
     *
     * @var array
     */
    protected $hashable = [
        'password',
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
                'role_id' => 'required',
                'name' => 'required',
            ],
            'CREATE' => [
                'username' => 'required|unique:users,username',
                'password' => 'required|min:6',
            ],
            'UPDATE' => [
                'username' => 'required|unique:users,username,' . $this->id,
                'password' => 'sometimes',
            ],
        ];
    }

    /**
     * Get the identifier that will be stored in the subject claim of the JWT.
     *
     * @return mixed
     */
    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    /**
     * Return a key value array, containing any custom claims to be added to the JWT.
     *
     * @return array
     */
    public function getJWTCustomClaims(): array
    {
        return [];
    }

    // --------------------
    // RELATIONSHIP
    // --------------------
    /**
     * Get the role associated with the user.
     */
    public function role()
    {
        return $this->belongsTo(Role::class, 'role_id');
    }

    /**
     * Get the user that owns the profile.
     */
    public function profile()
    {
        return $this->hasOne(UserProfile::class);
    }

    /**
     * Get the client associated with the user.
     */
    public function client()
    {
        return $this->belongsTo(Client::class, 'client_id');
    }

    /**
     * Get the user that owns the archive.
     */
    public function archive()
    {
        return $this->hasMany(UserArchive::class);
    }

    /**
     * Get the user that owns the contract.
     */
    public function user_contract()
    {
        return $this->hasOne(UserContract::class);
    }

    public function scopeOnlyUserSurveyor($query)
    {
        $query->where('role_id', 4);
    }

    public function scopeOnlyUser($query)
    {
        $query->whereIn('role_id', Role::USER_ONLY_ID);
    }
}
