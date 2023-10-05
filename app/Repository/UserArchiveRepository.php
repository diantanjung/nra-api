<?php

namespace App\Repository;

use App\Models\UserArchive;
use App\Transformers\UserArchiveTransformer;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class UserArchiveRepository
{
    /**
     * Get list of paginated user archives.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function getAll(Request $request): array
    {
        $user_archives = UserArchive::filter($request)->paginate($request->get('per_page', 20));

        return fractal($user_archives, new UserArchiveTransformer())->toArray();
    }

    /**
     * Get a user archive by ID.
     *
     * @param  int  $id
     * @return array
     *
     * @throws \Illuminate\Database\Eloquent\ModelNotFoundException
     */
    public function getById(int $id): array
    {
        $user_archive = UserArchive::findOrFail($id);

        return fractal($user_archive, new UserArchiveTransformer())->toArray();
    }

    /**
     * Store a new user_archive.
     *
     * @param  array  $attrs
     * @return array
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(array $attrs): array
    {
        if (!array_key_exists('user_id', $attrs)) {
            $user = app('auth')->user();
            $attrs['user_id'] = $user->id;
        }

        $user_archive = new UserArchive($attrs);
        if (!$user_archive->isValidFor('CREATE')) {
            throw new ValidationException($user_archive->validator());
        }

        $upload = $user_archive->saveFiles($attrs['attachment']);
        $user_archive['attachment'] = $upload;
        $user_archive->save();

        return fractal($user_archive, new UserArchiveTransformer())->toArray();
    }

    /**
     * Update a user archive by ID.
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
        $user_archive = UserArchive::findOrFail($id);

        if (!$user_archive->isValidFor('UPDATE')) {
            throw new ValidationException($user_archive->validator());
        }

        if (($attrs['attachment'] ?? null) == null) {
            $upload = null;
        } else {
            $upload = $user_archive->saveFiles($attrs['attachment']);
        }

        $attrs['attachment'] = $upload;
        $user_archive->fill($attrs);
        $user_archive->save();

        return fractal($user_archive, new UserArchiveTransformer())->toArray();
    }

    /**
     * Delete a user archive by ID.
     *
     * @param  int  $id
     * @return bool
     *
     * @throws \Illuminate\Database\Eloquent\ModelNotFoundException
     */
    public function deleteById(int $id): bool
    {
        $user_archive = UserArchive::findOrFail($id);

        return (bool) $user_archive->delete();
    }
}
