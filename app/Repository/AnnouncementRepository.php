<?php

namespace App\Repository;

use App\Models\Announcement;
use App\Transformers\AnnouncementTransformer;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class AnnouncementRepository
{
    /**
     * Get list of paginated announcements.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function getAll(Request $request): array
    {
        $announcements = Announcement::filter($request)->paginate($request->get('per_page', 20));

        return fractal($announcements, new AnnouncementTransformer())->toArray();
    }

    /**
     * Get a announcement by ID.
     *
     * @param  int  $id
     * @return array
     *
     * @throws \Illuminate\Database\Eloquent\ModelNotFoundException
     */
    public function getById(int $id): array
    {
        $announcement = Announcement::findOrFail($id);

        return fractal($announcement, new AnnouncementTransformer())->toArray();
    }

    /**
     * Store a new announcement.
     *
     * @param  array  $attrs
     * @return array
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(array $attrs): array
    {
        $announcement = new Announcement($attrs);
        if (!$announcement->isValidFor('CREATE')) {
            throw new ValidationException($announcement->validator());
        }

        $announcement->save();
        $announcement->syncToNotification();

        return fractal($announcement, new AnnouncementTransformer())->toArray();
    }

    /**
     * Update a announcement by ID.
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
        $announcement = Announcement::findOrFail($id);
        $announcement->fill($attrs);

        if (!$announcement->isValidFor('UPDATE')) {
            throw new ValidationException($announcement->validator());
        }

        $announcement->save();

        return fractal($announcement, new AnnouncementTransformer())->toArray();
    }

    /**
     * Delete a announcement by ID.
     *
     * @param  int  $id
     * @return bool
     *
     * @throws \Illuminate\Database\Eloquent\ModelNotFoundException
     */
    public function deleteById(int $id): bool
    {
        $announcement = Announcement::findOrFail($id);

        return (bool) $announcement->delete();
    }
}
