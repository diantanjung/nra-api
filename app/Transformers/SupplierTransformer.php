<?php

namespace App\Transformers;

use App\Models\Supplier;
use League\Fractal\TransformerAbstract;

class SupplierTransformer extends TransformerAbstract
{
    /**
     * A Fractal transformer.
     *
     * @param  \App\Models\Supplier  $supplier
     * @return array
     */
    public function transform(Supplier $supplier): array
    {
        return [
            'id' => (int) $supplier->id,
            'name' => (string) $supplier->name,
        ];
    }
}
