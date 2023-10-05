<?php

namespace App\Transformers;

use App\Models\Location;
use League\Fractal\TransformerAbstract;

class LocationTransformer extends TransformerAbstract
{
    /**
     * A Fractal transformer.
     *
     * @param  \App\Models\Location  $location
     * @return array
     */
    public function transform(Location $location): array
    {
        $code = explode(".", $location->code);
        $id = $code[count($code) - 1];

        return [
            'id' => (int) $id,
            'name' => (string) $location->name
        ];
    }
}
