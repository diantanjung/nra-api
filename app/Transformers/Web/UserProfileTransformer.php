<?php

namespace App\Transformers\Web;

use App\Models\User;
use League\Fractal\TransformerAbstract;

class UserProfileTransformer extends TransformerAbstract
{
    /**
     * A Fractal transformer.
     *
     * @param  \App\Models\User  $user_profile
     * @return array
     */
    public function transform(User $user): array
    {
        return [
            'id' => (int) $user->id,
            'name' => (string) $user->name,
            'email' => (string) $user->email,
            'username' => (string) $user->username,
            'role_id' => (int) $user->role_id,
            'role_name' => (string) $user->role->name,
            'client_id' => (int) ($user->client_id ?? 0),
            'client_name' => (string) ($user->client->name ?? ''),
            'photo' => (string) $user->photo,
            'client_id' => (int) $user->client_id,
            'client_name' => (string) ($user->client->name ?? ''),
            'profile' => [
                'department_id' => (int) $user->profile->department_id,
                'department_name' => (string) ($user->profile->department->name ?? ''),
                'area_id' => (int) $user->profile->area_id,
                'area_name' => (string) ($user->profile->area->name ?? ''),
                'nip' => (string) $user->profile->nip,
                'title' => (string) $user->profile->title,
                'birth_place' => (string) $user->profile->birth_place,
                'birth_date' => (string) $user->profile->birth_date,
                'gender' => (string) $user->profile->gender,
                'religion' => (string) $user->profile->religion,
                'contract_id' => (int) ($user->profile->user_contract->contract_type_id ?? 0),
                'contract_name' => (string) ($user->profile->user_contract->contract_type->name ?? ''),
                'marital_status' => (string) $user->profile->marital_status,
                'address' => (string) $user->profile->address,
                'phone_number' => (string) $user->profile->phone_number,
                'bpjs_number' => (string) $user->profile->bpjs_number,
                'npwp_number' => (string) $user->profile->npwp_number,
                'relationship_number' => (string) $user->profile->relationship_number,
                'blood_type' => (string) $user->profile->blood_type,
                'tribe' => (string) $user->profile->tribe,
                'is_validated' => (bool) $user->profile->is_validated,
            ]
        ];
    }
}
