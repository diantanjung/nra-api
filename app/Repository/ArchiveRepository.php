<?php

namespace App\Repository;

use App\Models\Archive;
use App\Transformers\ArchiveTransformer;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class ArchiveRepository
{
    /**
     * Get list of paginated archives.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function getAll(Request $request): array
    {
        $archives = Archive::filter($request)->paginate($request->get('per_page', 20));

        return fractal($archives, new ArchiveTransformer())->toArray();
    }

    /**
     * Get a archive by ID.
     *
     * @param  int  $id
     * @return array
     *
     * @throws \Illuminate\Database\Eloquent\ModelNotFoundException
     */
    public function getById(int $id): array
    {
        $archive = Archive::findOrFail($id);

        return fractal($archive, new ArchiveTransformer())->toArray();
    }

    /**
     * Store a new archive.
     *
     * @param  array  $attrs
     * @return array
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(array $attrs): array
    {
        $archive = new Archive($attrs);
        if (!$archive->isValidFor('CREATE')) {
            throw new ValidationException($archive->validator());
        }

        $archive->save();

        return fractal($archive, new ArchiveTransformer())->toArray();
    }

    /**
     * Update a archive by ID.
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
        $archive = Archive::findOrFail($id);
        $archive->fill($attrs);

        if (!$archive->isValidFor('UPDATE')) {
            throw new ValidationException($archive->validator());
        }

        $archive->save();

        return fractal($archive, new ArchiveTransformer())->toArray();
    }

    /**
     * Delete a archive by ID.
     *
     * @param  int  $id
     * @return bool
     *
     * @throws \Illuminate\Database\Eloquent\ModelNotFoundException
     */
    public function deleteById(int $id): bool
    {
        $archive = Archive::findOrFail($id);

        return (bool) $archive->delete();
    }
}
