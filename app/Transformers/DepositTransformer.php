<?php

namespace App\Transformers;

use App\Models\Deposit;
use League\Fractal\TransformerAbstract;

class DepositTransformer extends TransformerAbstract
{
    /**
     * A Fractal transformer.
     *
     * @param  \App\Models\Deposit  $deposit
     * @return array
     */
    public function transform(Deposit $deposit): array
    {
        return [
            'id' => (int) $deposit->id,
            'user_id' => (int) $deposit->user_id,
            'event_id' => (int) $deposit->event_id,
            'distributor_id' => (int) $deposit->distributor_id,
            'total_amount' => (int) $deposit->total_amount,
            'attachment' => (string) $deposit->attachment,
            'note' => (string) $deposit->note,
        ];
    }
}
