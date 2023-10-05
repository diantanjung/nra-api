<?php

namespace App\Repository;

use App\Models\Chiller;
use App\Transformers\ChillerTransformer;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class ChillerRepository
{
    /**
     * Get list of paginated chillers.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function getAll(Request $request): array
    {
        $chillers = Chiller::filter($request)->paginate($request->get('per_page', 20));

        return fractal($chillers, new ChillerTransformer())->toArray();
    }

    /**
     * Get a chiller by ID.
     *
     * @param  int  $id
     * @return array
     *
     * @throws \Illuminate\Database\Eloquent\ModelNotFoundException
     */
    public function getById(int $id): array
    {
        $chiller = Chiller::findOrFail($id);

        return fractal($chiller, new ChillerTransformer())->toArray();
    }

    /**
     * Store a new chiller.
     *
     * @param  array  $attrs
     * @return array
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(array $attrs): array
    {
        $chiller = new Chiller($attrs);
        if (!$chiller->isValidFor('CREATE')) {
            throw new ValidationException($chiller->validator());
        }

        $chiller->save();

        return fractal($chiller, new ChillerTransformer())->toArray();
    }

    /**
     * Update a chiller by ID.
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
        $chiller = Chiller::findOrFail($id);
        $chiller->fill($attrs);

        if (!$chiller->isValidFor('UPDATE')) {
            throw new ValidationException($chiller->validator());
        }

        $chiller->save();

        return fractal($chiller, new ChillerTransformer())->toArray();
    }

    /**
     * Delete a chiller by ID.
     *
     * @param  int  $id
     * @return bool
     *
     * @throws \Illuminate\Database\Eloquent\ModelNotFoundException
     */
    public function deleteById(int $id): bool
    {
        $chiller = Chiller::findOrFail($id);

        return (bool) $chiller->delete();
    }
}
