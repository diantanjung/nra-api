<?php

namespace App\Repository;

use App\Models\ContractType;
use App\Transformers\ContractTypeTransformer;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class ContractTypeRepository
{
    /**
     * Get list of paginated contract types.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function getAll(Request $request): array
    {
        $contract_types = ContractType::filter($request)->paginate($request->get('per_page', 20));

        return fractal($contract_types, new ContractTypeTransformer())->toArray();
    }

    /**
     * Get a contract type by ID.
     *
     * @param  int  $id
     * @return array
     *
     * @throws \Illuminate\Database\Eloquent\ModelNotFoundException
     */
    public function getById(int $id): array
    {
        $contract_type = ContractType::findOrFail($id);

        return fractal($contract_type, new ContractTypeTransformer())->toArray();
    }

    /**
     * Store a new contract type.
     *
     * @param  array  $attrs
     * @return array
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(array $attrs): array
    {
        $contract_type = new ContractType($attrs);
        if (!$contract_type->isValidFor('CREATE')) {
            throw new ValidationException($contract_type->validator());
        }
        $contract_type->save();
        return fractal($contract_type, new ContractTypeTransformer())->toArray();
    }

    /**
     * Update a contract type by ID.
     *
     * @param  int  $id
     * @param  array  $attrs
     * @return array
     *
     * @throws \Illuminate\Database\Eloquent\ModelNotFoundException
     * @throws \Illuminate\Validation\ValidationException
     */
    public function updateById(int $id, array $attrs): array
    {
        $contract_type = ContractType::findOrFail($id);
        $contract_type->fill($attrs);

        if (!$contract_type->isValidFor('UPDATE')) {
            throw new ValidationException($contract_type->validator());
        }

        $contract_type->save();

        return fractal($contract_type, new ContractTypeTransformer())->toArray();
    }

    /**
     * Delete a contract type by ID.
     *
     * @param  int  $id
     * @return bool
     *
     * @throws \Illuminate\Database\Eloquent\ModelNotFoundException
     */
    public function deleteById(int $id): bool
    {
        $contract_type = ContractType::findOrFail($id);

        return (bool) $contract_type->delete();
    }
}
