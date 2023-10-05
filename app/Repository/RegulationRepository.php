<?php

namespace App\Repository;

use App\Models\Regulation;
use App\Transformers\RegulationTransformer;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class RegulationRepository
{
    /**
     * Get list of paginated regulations.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function getAll(Request $request): array
    {
        $regulations = Regulation::filter($request)->paginate($request->get('per_page', 20));

        return fractal($regulations, new RegulationTransformer())->toArray();
    }

    /**
     * Get a regulation by ID.
     *
     * @param  int  $id
     * @return array
     *
     * @throws \Illuminate\Database\Eloquent\ModelNotFoundException
     */
    public function getById(int $id): array
    {
        $regulation = Regulation::findOrFail($id);

        return fractal($regulation, new RegulationTransformer())->toArray();
    }

    /**
     * Store a new regulation.
     *
     * @param  array  $attrs
     * @return array
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(array $attrs): array
    {
        $regulation = new Regulation($attrs);
        if (!$regulation->isValidFor('CREATE')) {
            throw new ValidationException($regulation->validator());
        }

        $regulation->save();

        return fractal($regulation, new RegulationTransformer())->toArray();
    }

    /**
     * Update a regulation by ID.
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
        $regulation = Regulation::findOrFail($id);
        $regulation->fill($attrs);

        if (!$regulation->isValidFor('UPDATE')) {
            throw new ValidationException($regulation->validator());
        }

        $regulation->save();

        return fractal($regulation, new RegulationTransformer())->toArray();
    }

    /**
     * Delete a regulation by ID.
     *
     * @param  int  $id
     * @return bool
     *
     * @throws \Illuminate\Database\Eloquent\ModelNotFoundException
     */
    public function deleteById(int $id): bool
    {
        $regulation = Regulation::findOrFail($id);

        return (bool) $regulation->delete();
    }
}
