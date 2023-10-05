<?php

namespace App\Transformers;

use App\Models\Department;
use League\Fractal\TransformerAbstract;

class DepartmentTransformer extends TransformerAbstract
{
    /**
     * A Fractal transformer.
     *
     * @param  \App\Models\Department  $department
     * @return array
     */
    public function transform(Department $department): array
    {
        return [
            'id' => (int) $department->id,
            'code' => (string) $department->code,
            'name' => (string) $department->name,
        ];
    }
}
