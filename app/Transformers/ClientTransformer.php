<?php

namespace App\Transformers;

use App\Models\Client;
use App\Models\Role;
use League\Fractal\TransformerAbstract;

class ClientTransformer extends TransformerAbstract
{
    /**
     * A Fractal transformer.
     *
     * @param  \App\Models\Client  $client
     * @return array
     */
    public function transform(Client $client): array
    {
        $total_employee = $client->users()->onlyUser()->count();
        return [
            'id' => (int) $client->id,
            'name' => (string) $client->name,
            'address' => (string) $client->address,
            'logo' => (string) $client->logo,
            'settings' => (string) $client->settings,
            'total_employee' => (int) $total_employee,
        ];
    }
}
