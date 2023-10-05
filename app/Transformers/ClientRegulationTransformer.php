<?php

namespace App\Transformers;

use App\Models\ClientRegulation;
use League\Fractal\TransformerAbstract;

class ClientRegulationTransformer extends TransformerAbstract
{
    /**
     * A Fractal transformer.
     *
     * @param  \App\Models\ClientRegulation  $client_regulation
     * @return array
     */
    public function transform(ClientRegulation $client_regulation): array
    {
        return [
            'id' => (int) $client_regulation->id,
            'regulation_id' => (int) $client_regulation->regulation_id,
            'regulation_type' => (string) $client_regulation->regulation->type,
            'regulation_name' => (string) $client_regulation->regulation->name,
            'regulation_description' => (string) $client_regulation->regulation->description,
            'location_id' => (int) $client_regulation->client_location_id,
            'client_id' => (int) $client_regulation->client_location->client_id,
            'client_name' => (string) $client_regulation->client_location->client->name,
            'area_id' => (int) $client_regulation->client_location->area_id,
            'area_name' => (string) $client_regulation->client_location->area->name,
            'department_id' => (int) $client_regulation->client_location->department_id,
            'department_name' => (string) ($client_regulation->client_location->department->name ?? ''),
            'shift' => (string) $client_regulation->client_location->shift,
        ];
    }
}
