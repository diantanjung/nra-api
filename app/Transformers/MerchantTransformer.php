<?php

namespace App\Transformers;

use App\Models\Merchant;
use League\Fractal\TransformerAbstract;

class MerchantTransformer extends TransformerAbstract
{
    /**
     * A Fractal transformer.
     *
     * @param  \App\Models\Merchant  $merchant
     * @return array
     */
    public function transform(Merchant $merchant): array
    {
        return [
            'id' => (int) $merchant->id,
            'code' => (string) $merchant->code,
            'name' => (string) $merchant->name,
            'photo' => (string) $merchant->photo,
            'contact_name' => (string) $merchant->contact_name,
            'contact_number' => (string) $merchant->contact_number,
            'province_id' => (int) $merchant->province_id,
            'city' => (int) $merchant->city_id,
            'address' => (string) $merchant->address,
            'full_address' => (string) $merchant->full_address,
            'latitude' => (string) $merchant->latitude,
            'longitude' => (string) $merchant->longitude,
            'chillers' => fractal($merchant->chillers, new ChillerTransformer())->toArray()["data"],
            'is_closed' => (bool) $merchant->is_closed,
            'is_closed_time' => (string) $merchant->is_closed_time,
        ];
    }
}
