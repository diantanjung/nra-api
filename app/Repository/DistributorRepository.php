<?php

namespace App\Repository;

use App\Models\Distributor;
use App\Transformers\DistributorTransformer;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpFoundation\Exception\BadRequestException;

class DistributorRepository
{
    /**
     * Get list of paginated distributors.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function getAll(Request $request): array
    {
        $distributors = Distributor::filter($request)->paginate($request->get('per_page', 20));

        return fractal($distributors, new DistributorTransformer())->toArray();
    }

    /**
     * Get a distributor by ID.
     *
     * @param  int  $id
     * @return array
     *
     * @throws \Illuminate\Database\Eloquent\ModelNotFoundException
     */
    public function getById(int $id): array
    {
        $distributor = Distributor::findOrFail($id);

        return fractal($distributor, new DistributorTransformer())->toArray();
    }

    /**
     * Store a new distributor.
     *
     * @param  array  $attrs
     * @return array
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(array $attrs): array
    {
        $distributor = new Distributor($attrs);
        if (!$distributor->isValidFor('CREATE')) {
            throw new ValidationException($distributor->validator());
        }

        $distributor->save();

        return fractal($distributor, new DistributorTransformer())->toArray();
    }

    /**
     * Update a distributor by ID.
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
        $distributor = Distributor::findOrFail($id);
        $distributor->fill($attrs);
        if (!$distributor->isValidFor('UPDATE')) {
            throw new ValidationException($distributor->validator());
        }

        $distributor->save();

        return fractal($distributor, new DistributorTransformer())->toArray();
    }

    /**
     * Delete a distributor by ID.
     *
     * @param  int  $id
     * @return bool
     *
     * @throws \Illuminate\Database\Eloquent\ModelNotFoundException
     */
    public function deleteById(int $id): bool
    {
        $distributor = Distributor::findOrFail($id);

        return (bool) $distributor->delete();
    }
}
