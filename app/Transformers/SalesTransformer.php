<?php

namespace App\Transformers;

use App\Models\Sales;
use League\Fractal\TransformerAbstract;

class SalesTransformer extends TransformerAbstract
{
    /**
     * A Fractal transformer.
     *
     * @param  \App\Models\Sales  $sales
     * @return array
     */
    public function transform(Sales $sales): array
    {
        return [
            'id' => (int) $sales->id,
            'user_id' => (int) $sales->user_id,
            'event_id' => (int) $sales->event_id,
            'latitude' => (string) $sales->latitude,
            'longitude' => (string) $sales->longitude,
            'total_item' => (int) $sales->total_item,
            'total_amount' => (int) $sales->total_amount,
            'pay_amount' => (int) $sales->pay_amount,
            'return_amount' => (int) $sales->return_amount,
            'customer_name' => (string) $sales->customer_name,
            'customer_phone_number' => (string) $sales->customer_phone_number,
            'note' => (string) $sales->note,
            'details' => $sales->details,
        ];
    }
}
