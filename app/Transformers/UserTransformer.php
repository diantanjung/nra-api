<?php

namespace App\Transformers;

use App\Models\User;
use League\Fractal\TransformerAbstract;

class UserTransformer extends TransformerAbstract
{
    /**
     * A Fractal transformer.
     *
     * @param  \App\Models\User  $user
     * @return array
     */
    public function transform(User $user): array
    {
        return [
            'id' => (int) $user->id,
            'name' => (string) $user->name,
            'username' => (string) $user->username,
            'photo' => (string) $user->photo,
            'role_id' => (int) $user->role_id,
            'role_name' => (string) $user->role->name,
            'client_id' => (int) ($user->client_id ?? 0),
            'client_name' => (string) ($user->client->name ?? ''),
            'is_validated' => (bool) $user->profile->is_validated,
        ];
    }
}
