<?php

namespace App\Repository;

use App\Models\Deposit;
use App\Transformers\DepositTransformer;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpFoundation\Exception\BadRequestException;

class DepositRepository
{
    /**
     * Get list of paginated deposits.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function getAll(Request $request): array
    {
        $deposits = Deposit::filter($request)->paginate($request->get('per_page', 20));

        return fractal($deposits, new DepositTransformer())->toArray();
    }

    /**
     * Get a deposit by ID.
     *
     * @param  int  $id
     * @return array
     *
     * @throws \Illuminate\Database\Eloquent\ModelNotFoundException
     */
    public function getById(int $id): array
    {
        $deposit = Deposit::findOrFail($id);

        return fractal($deposit, new DepositTransformer())->toArray();
    }

    /**
     * Store a new deposit.
     *
     * @param  array  $attrs
     * @return array
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(array $attrs): array
    {
        $deposit = new Deposit($attrs);
        if (!$deposit->isValidFor('CREATE')) {
            throw new ValidationException($deposit->validator());
        }

        $deposit->save();

        return fractal($deposit, new DepositTransformer())->toArray();
    }

    /**
     * Update a deposit by ID.
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
        $deposit = Deposit::findOrFail($id);
        $deposit->fill($attrs);
        if (!$deposit->isValidFor('UPDATE')) {
            throw new ValidationException($deposit->validator());
        }

        $deposit->save();

        return fractal($deposit, new DepositTransformer())->toArray();
    }

    /**
     * Delete a deposit by ID.
     *
     * @param  int  $id
     * @return bool
     *
     * @throws \Illuminate\Database\Eloquent\ModelNotFoundException
     */
    public function deleteById(int $id): bool
    {
        $deposit = Deposit::findOrFail($id);

        return (bool) $deposit->delete();
    }
}
