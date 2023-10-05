<?php

namespace App\Repository;

use App\Models\Announcement;
use App\Transformers\AnnouncementTransformer;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class ScheduleRepository
{
    /**
     * Get list of paginated announcements.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function index(Request $request): array
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
    public function show(int $id): array
    {
        $announcement = Announcement::findOrFail($id);

        return fractal($announcement, new AnnouncementTransformer())->toArray();
    }
}
