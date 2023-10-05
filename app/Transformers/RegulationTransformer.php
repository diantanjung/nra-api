<?php

namespace App\Transformers;

use App\Models\Regulation;
use League\Fractal\TransformerAbstract;

class RegulationTransformer extends TransformerAbstract
{
    /**
     * A Fractal transformer.
     *
     * @param  \App\Models\Regulation  $regulation
     * @return array
     */
    public function transform(Regulation $regulation): array
    {
        return [
            'id' => (int) $regulation->id,
            'type' => (string) $regulation->type,
            'name' => (string) $regulation->name,
            'description' => (string) $regulation->description,
        ];
    }
}
