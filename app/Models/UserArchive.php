<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

use App\Traits\FileUploadable;
use App\Traits\ModelValidatable;

class UserArchive extends Model
{
    use ModelValidatable, FileUploadable;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'user_archives';

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

        if ($request->filled('keyword')) {
            $query->whereRelation('master', 'name', 'like', '%' . $request->keyword . '%');
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
                'attachment' => 'required',
            ],
            'CREATE' => [
                'user_id' => 'required|unique:user_archives,user_id,' . $this->id . ',id,archive_id,' . $this->archive_id,
            ],
            'UPDATE' => [],
        ];
    }

    /**
     * Get the archive associated with the user.
     */
    public function master()
    {
        return $this->belongsTo(Archive::class, 'archive_id');
    }
}
