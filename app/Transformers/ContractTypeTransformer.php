<?php

namespace App\Transformers;

use App\Models\ContractType;
use League\Fractal\TransformerAbstract;

class ContractTypeTransformer extends TransformerAbstract
{
    /**
     * A Fractal transformer.
     *
     * @param  \App\Models\ContractType  $contract_type
     * @return array
     */
    public function transform(ContractType $contract_type): array
    {
        return [
            'id' => (int) $contract_type->id,
            'name' => (string) $contract_type->name,
        ];
    }
}
