<?php

namespace App\Transformers;

use App\Models\ProcurementDetail;
use League\Fractal\TransformerAbstract;

class ProcurementDetailTransformer extends TransformerAbstract
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
            'procurement_id' => (int) $procurement_detail->procurement_id,
            'product_id' => (int) $procurement_detail->product_id,
            'product_name' => (string) $procurement_detail->product->name,
            'product_photo' => (string) $procurement_detail->product->photo,
            'price' => (int) $procurement_detail->price,
            'sell_price' => (int) $procurement_detail->sell_price,
            'qty' => (int) $procurement_detail->qty,
            'expired_at' =>  (string) $procurement_detail->expired_at,
        ];
    }
}
