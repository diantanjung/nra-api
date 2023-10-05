<?php

namespace App\Transformers\Web;

use App\Models\UserContract;
use League\Fractal\TransformerAbstract;

class UserContractTransformer extends TransformerAbstract
{
    /**
     * A Fractal transformer.
     *
     * @param  \App\Models\UserContract  $department
     * @return array
     */
    public function transform(UserContract $contract): array
    {
        return [
            'id'                 => (int) $contract->id,
            'user_id'            => (int) $contract->user_id,
            'user_name'          => (string) $contract->user->name,
            'contract_type_id'   => (int) $contract->contract_type->id,
            'contract_type_name' => (string) $contract->contract_type->name,
            'effective_date_start'     => (string) $contract->effective_date_start,
            'effective_date_end'     => (string) $contract->effective_date_end,
            'note'               => (string) $contract->note,
        ];
    }
}
