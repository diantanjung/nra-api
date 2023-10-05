<?php

namespace App\Transformers;

use App\Models\Procurement;
use League\Fractal\TransformerAbstract;

class ProcurementTransformer extends TransformerAbstract
{
    /**
     * A Fractal transformer.
     *
     * @param  \App\Models\Procurement  $procurement
     * @return array
     */
    public function transform(Procurement $procurement): array
    {
        return [
            'id' => (int) $procurement->id,
            'user_id' => (int) $procurement->user_id,
            'distributor_id' => (int) $procurement->distributor_id,
            'distributor_name' => (string) $procurement->distributor->name,
            'distributor_photo' => (string) $procurement->distributor->photo,
            'total_item' => (int) $procurement->total_item,
            'attachment' => (string) $procurement->attachment,
            'note' => (string) $procurement->note,
            'details' => fractal($procurement->details, new ProcurementDetailTransformer())->toArray()['data'],
        ];
    }
}
