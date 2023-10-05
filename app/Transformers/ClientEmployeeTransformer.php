<?php

namespace App\Transformers;

use App\Models\User;
use League\Fractal\TransformerAbstract;

class ClientEmployeeTransformer extends TransformerAbstract
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
            'user_id' => (int) $user->id,
            'role_id' => (int) $user->role_id,
            'role_name' => (string) $user->role->name,
            'name' => (string) $user->name,
            'photo' => (string) $user->photo,
            'client_id' => (int) $user->client_id,
            'client_name' => (string) ($user->client->name ?? ''),
            'department_id' => (int) ($user->profile->department_id ?? 0),
            'department_name' => (string) ($user->profile->department->name ?? ''),
            'client_area_id' => (int) ($user->profile->client_area_id ?? 0),
            'client_area_name' => (string) ($user->profile->client_area->name ?? ''),
            'contract_type_id' => (int) ($user->profile->user_contract->contract_type_id ?? 0),
            'contract_type_name' => (string) ($user->profile->user_contract->contract_type->name ?? ''),
            'is_validated' => (bool) ($user->profile->is_validated ?? false),
        ];
    }
}
