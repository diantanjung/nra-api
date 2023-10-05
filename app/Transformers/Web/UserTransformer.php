<?php

namespace App\Transformers\Web;

use App\Models\UserProfile;
use League\Fractal\TransformerAbstract;

class UserProfileTransformer extends TransformerAbstract
{
    /**
     * A Fractal transformer.
     *
     * @param  \App\Models\UserProfile  $user_profile
     * @return array
     */
    public function transform(UserProfile $user_profile): array
    {
        return [
            'user_id' => (int) $user_profile->user_id,
            'name' => (string) $user_profile->user->name,
            'username' => (string) $user_profile->user->username,
            'role_id' => (int) $user_profile->user->role_id,
            'role_name' => (string) $user_profile->user->role->name,
            'client_id' => (int) ($user_profile->user->client_id ?? 0),
            'client_name' => (string) ($user_profile->user->client->name ?? ''),
            'photo' => (string) $user_profile->user->photo,
            'client_id' => (int) $user_profile->user->client_id,
            'client_name' => (string) ($user_profile->user->client->name ?? ''),
            'department_id' => (int) $user_profile->department_id,
            'department_name' => (string) ($user_profile->department->name ?? ''),
            'area_id' => (int) $user_profile->area_id,
            'area_name' => (string) ($user_profile->area->name ?? ''),
            'nip' => (string) $user_profile->nip,
            'title' => (string) $user_profile->title,
            'birth_place' => (string) $user_profile->birth_place,
            'birth_date' => (string) $user_profile->birth_date,
            'gender' => (string) $user_profile->gender,
            'religion' => (string) $user_profile->religion,
            'contract_id' => (int) ($user_profile->user_contract->contract_type_id ?? 0),
            'contract_name' => (string) ($user_profile->user_contract->contract_type->name ?? ''),
            'marital_status' => (string) $user_profile->marital_status,
            'address' => (string) $user_profile->address,
            'phone_number' => (string) $user_profile->phone_number,
            'bpjs_number' => (string) $user_profile->bpjs_number,
            'npwp_number' => (string) $user_profile->npwp_number,
            'relationship_number' => (string) $user_profile->relationship_number,
            'blood_type' => (string) $user_profile->blood_type,
            'tribe' => (string) $user_profile->tribe,
            'is_validated' => (bool) $user_profile->is_validated,
        ];
    }
}
