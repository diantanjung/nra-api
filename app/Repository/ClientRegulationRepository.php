<?php

namespace App\Repository;

use App\Models\ClientRegulation;
use App\Transformers\ClientRegulationTransformer;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class ClientRegulationRepository
{
    /**
     * Get list of paginated client regulations.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function getAll(Request $request): array
    {
        $client_regulations = ClientRegulation::filter($request)->paginate($request->get('per_page', 20));

        return fractal($client_regulations, new ClientRegulationTransformer())->toArray();
    }

    /**
     * Get a client regulation by ID.
     *
     * @param  int  $id
     * @return array
     *
     * @throws \Illuminate\Database\Eloquent\ModelNotFoundException
     */
    public function getById(int $id): array
    {
        $client_regulation = ClientRegulation::findOrFail($id);

        return fractal($client_regulation, new ClientRegulationTransformer())->toArray();
    }

    /**
     * Store a new client regulation.
     *
     * @param  array  $attrs
     * @return array
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(array $attrs): array
    {
        $client_regulation = new ClientRegulation($attrs);
        if (!$client_regulation->isValidFor('CREATE')) {
            throw new ValidationException($client_regulation->validator());
        }

        $client_regulation->save();

        return fractal($client_regulation, new ClientRegulationTransformer())->toArray();
    }

    /**
     * Update a client regulation by ID.
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
        $client_regulation = ClientRegulation::findOrFail($id);
        $client_regulation->fill($attrs);

        if (!$client_regulation->isValidFor('UPDATE')) {
            throw new ValidationException($client_regulation->validator());
        }

        $client_regulation->save();

        return fractal($client_regulation, new ClientRegulationTransformer())->toArray();
    }

    /**
     * Delete a client regulation by ID.
     *
     * @param  int  $id
     * @return bool
     *
     * @throws \Illuminate\Database\Eloquent\ModelNotFoundException
     */
    public function deleteById(int $id): bool
    {
        $client_regulation = ClientRegulation::findOrFail($id);

        return (bool) $client_regulation->delete();
    }
}
