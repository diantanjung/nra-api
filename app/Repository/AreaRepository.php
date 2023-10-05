<?php

namespace App\Repository;

use App\Models\Area;
use App\Transformers\AreaTransformer;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class AreaRepository
{
    /**
     * Get list of paginated areas.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function getAll(Request $request): array
    {
        $areas = Area::filter($request)->paginate($request->get('per_page', 20));

        return fractal($areas, new AreaTransformer())->toArray();
    }

    /**
     * Get a area by ID.
     *
     * @param  int  $id
     * @return array
     *
     * @throws \Illuminate\Database\Eloquent\ModelNotFoundException
     */
    public function getById(int $id): array
    {
        $area = Area::findOrFail($id);

        return fractal($area, new AreaTransformer())->toArray();
    }

    /**
     * Store a new area.
     *
     * @param  array  $attrs
     * @return array
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(array $attrs): array
    {
        $area = new Area($attrs);
        if (!$area->isValidFor('CREATE')) {
            throw new ValidationException($area->validator());
        }
        $area->save();
        return fractal($area, new AreaTransformer())->toArray();
    }

    /**
     * Update a area by ID.
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
        $area = Area::findOrFail($id);
        $area->fill($attrs);

        if (!$area->isValidFor('UPDATE')) {
            throw new ValidationException($area->validator());
        }

        $area->save();

        return fractal($area, new AreaTransformer())->toArray();
    }

    /**
     * Delete a area by ID.
     *
     * @param  int  $id
     * @return bool
     *
     * @throws \Illuminate\Database\Eloquent\ModelNotFoundException
     */
    public function deleteById(int $id): bool
    {
        $area = Area::findOrFail($id);

        return (bool) $area->delete();
    }
}
