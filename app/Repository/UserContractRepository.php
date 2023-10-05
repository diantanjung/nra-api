<?php

namespace App\Repository;

use App\Models\UserContract;
use App\Transformers\Web\UserContractTransformer;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class UserContractRepository
{
    /**
     * Get list of paginated contracts.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function getAll(Request $request): array
    {
        $contracts = UserContract::filter($request)->paginate($request->get('per_page', 20));

        return fractal($contracts, new UserContractTransformer())->toArray();
    }

    /**
     * Get a contract by ID.
     *
     * @param  int  $id
     * @return array
     *
     * @throws \Illuminate\Database\Eloquent\ModelNotFoundException
     */
    public function getById(int $id): array
    {
        $contract = UserContract::findOrFail($id);

        return fractal($contract, new UserContractTransformer())->toArray();
    }

    public function getByUserId(int $user_id): array
    {
        $contract = UserContract::where('user_id', $user_id)->firstOrFail();

        return fractal($contract, new UserContractTransformer())->toArray();
    }

    /**
     * Store a new contract.
     *
     * @param  array  $attrs
     * @return array
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(array $attrs): array
    {
        $contract = new UserContract($attrs);
        if (!$contract->isValidFor('CREATE')) {
            throw new ValidationException($contract->validator());
        }

        $contract->save();

        return fractal($contract, new UserContractTransformer())->toArray();
    }

    /**
     * Update a contract by ID.
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
        $contract = UserContract::findOrFail($id);
        $contract->fill($attrs);

        if (!$contract->isValidFor('UPDATE')) {
            throw new ValidationException($contract->validator());
        }

        $contract->save();

        return fractal($contract, new UserContractTransformer())->toArray();
    }

    /**
     * Delete a contract by ID.
     *
     * @param  int  $id
     * @return bool
     *
     * @throws \Illuminate\Database\Eloquent\ModelNotFoundException
     */
    public function deleteById(int $id): bool
    {
        $contract = UserContract::findOrFail($id);

        return (bool) $contract->delete();
    }
}
