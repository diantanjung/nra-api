<?php

namespace App\Transformers;

use League\Fractal\TransformerAbstract;

class TokenTransformer extends TransformerAbstract
{
    /**
     * A Fractal transformer.
     *
     * @param  string  $token
     * @return array
     */
    public function transform(string $token): array
    {
        $user = app('auth')->user();
        return [
            'id' => (int) $user->id,
            'name' => (string) $user->name,
            'role' => (string) $user->role->name,
            'role_id' => (int) $user->role_id,
            'client' => (string) ($user->client->name ?? '-'),
            'client_id' => (int) ($user->client_id ?? 0),
            'access_token' => (string) $token,
            'token_type' => 'bearer',
            'expires_in' => (string) app('auth')->factory()->getTTL() * 60,
            'is_validated' => (bool) $user->profile->is_validated,
            'phone_number' => (string) $user->profile->phone_number,
        ];
    }
}
