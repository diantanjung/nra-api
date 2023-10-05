<?php

namespace App\Transformers;

use App\Models\ClientArea;
use League\Fractal\TransformerAbstract;

class ClientAreaTransformer extends TransformerAbstract
{
    /**
     * A Fractal transformer.
     *
     * @param  \App\Models\ClientArea  $client_area
     * @return array
     */
    public function transform(ClientArea $client_area): array
    {
        return [
            'id' => (int) $client_area->id,
            'client_id' => (int) $client_area->client_id,
            'client_name' => (string) $client_area->client->name,
            'area_id' => (int) $client_area->area_id,
            'area_name' => (string) $client_area->area->name,
            'radius' => (int) $client_area->radius,
            'address' => (string) $client_area->address,
            'latitude' => (string) $client_area->latitude,
            'longitude' => (string) $client_area->longitude,
            'gmaps_url' => (string) $client_area->gmaps_url,
            'site_photo' => (string) $client_area->site_photo,
            'qr_photo' => (string) $client_area->qr_photo,
            'working_hours' => $client_area->workingHours,
        ];
    }
}
