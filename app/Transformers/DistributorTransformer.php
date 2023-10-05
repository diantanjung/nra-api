<?php

namespace App\Transformers;

use App\Models\Distributor;
use League\Fractal\TransformerAbstract;

class DistributorTransformer extends TransformerAbstract
{
    /**
     * A Fractal transformer.
     *
     * @param  \App\Models\Distributor  $distributor
     * @return array
     */
    public function transform(Distributor $distributor): array
    {
        return [
            'id' => (int) $distributor->id,
            'name' => (string) $distributor->name,
            'contact' => (string) $distributor->contact,
            'phone_number' => (int) $distributor->phone_number,
            'province_id' => (int) $distributor->province_id,
            'city_id' => (int) $distributor->city_id,
            'address' => (string) $distributor->address,
            'latitude' => (string) $distributor->latitude,
            'longitude' => (string) $distributor->longitude,
            'photo' => (string) $distributor->photo,
        ];
    }
}
