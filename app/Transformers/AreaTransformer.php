<?php

namespace App\Transformers;

use App\Models\Area;
use League\Fractal\TransformerAbstract;

class AreaTransformer extends TransformerAbstract
{
    /**
     * A Fractal transformer.
     *
     * @param  \App\Models\Area  $area
     * @return array
     */
    public function transform(Area $area): array
    {
        return [
            'id' => (int) $area->id,
            'code' => (string) $area->code,
            'name' => (string) $area->name,
        ];
    }
}
