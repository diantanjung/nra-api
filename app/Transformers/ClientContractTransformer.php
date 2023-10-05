<?php

namespace App\Transformers;

use App\Models\UserContract;
use League\Fractal\TransformerAbstract;

class ClientContractTransformer extends TransformerAbstract
{
    /**
     * A Fractal transformer.
     *
     * @param  \App\Models\UserContract  $user_contract
     * @return array
     */
    public function transform(UserContract $user_contract): array
    {
        return [
            'user_id' => (int) $user_contract->user_id,
            'contract_id' => (int) $user_contract->id,
            'contract_type_id' => (int) $user_contract->contract_type_id,
            'contract_type_name' => (string) $user_contract->contract_type->name,
            'effective_date_start' => (string) $user_contract->effective_date_start,
            'effective_date_end' => (string) $user_contract->effective_date_end,
            'note' => (string) $user_contract->note,
            'created_at' => (string) $user_contract->created_at,
        ];
    }
}
