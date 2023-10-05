<?php

namespace App\Transformers;

use App\Models\Chiller;
use App\Models\Merchant;
use League\Fractal\TransformerAbstract;

class ChillerTransformer extends TransformerAbstract
{
    /**
     * A Fractal transformer.
     *
     * @param  \App\Models\Chiller  $chiller
     * @return array
     */
    public function transform(Chiller $chiller): array
    {
        return [
            'id' => (int) $chiller->id,
            'name' => (string) $chiller->name,
            'merk' => (string) $chiller->merk,
            'type' => (string) $chiller->type,
            'category' => (string) $chiller->category,
            'capacity' => (string) $chiller->capacity,
            'photo' => (string) $chiller->photo,
            'is_exclusive' => (bool) $chiller->is_exclusive,
            'last_maintenance_date' => (string) $chiller->last_maintenance_date,
            'placement_date' => (string) $chiller->placement_date,
        ];
    }
}
