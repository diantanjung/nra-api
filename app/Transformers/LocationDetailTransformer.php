<?php

namespace App\Transformers;

use App\Models\Location;
use League\Fractal\TransformerAbstract;

class LocationDetailTransformer extends TransformerAbstract
{
    /**
     * A Fractal transformer.
     *
     * @param  \App\Models\Location  $location
     * @return array
     */
    public function transform(Location $location): array
    {
        $parent = $location->parent();
        $city_id = explode(".", $location->code)[1];
        return [
            "city_id" => (int) $city_id,
            "city_name" => (string) $location->name,
            "province_id" => (int) $parent->code,
            "province_name" => (string) $parent->name,
        ];
    }
}
