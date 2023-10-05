<?php

namespace App\Transformers;

use App\Models\ProcurementDetail;
use League\Fractal\TransformerAbstract;

class ProcurementProductTransformer extends TransformerAbstract
{
    /**
     * A Fractal transformer.
     *
     * @param  \App\Models\ProcurementDetail  $procurement_detail
     * @return array
     */
    public function transform(ProcurementDetail $procurement_detail): array
    {
        return [
            'id' => (int) $procurement_detail->id,
            'product_id' => (int) $procurement_detail->procurement_id,
            'sell_price' => (int) $procurement_detail->sell_price,
            'qty' => (int) $procurement_detail->qty,
            'expired_at' =>  (string) $procurement_detail->expired_at,
            'name' => (string) $procurement_detail->product->name,
            'description' => (string) $procurement_detail->product->description,
            'photo' => (string) $procurement_detail->product->photo,
            'uom' => (string) $procurement_detail->product->uom,
            'weight' => (int) $procurement_detail->product->weight,
            'weight_type' => (string) $procurement_detail->product->weight_type,
        ];
    }
}
