<?php

namespace App\Http\Controllers;

use App\Models\Notification;
use App\Repository\AnnouncementRepository;
use App\Repository\NotificationRepository;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class AnnouncementController extends Controller
{
    protected $announcement;
    protected $notification;

    /**
     * Controller constructor.
     *
     * @param  \App\Repository\AnnouncementRepository  $announcement
     * @param  \App\Repository\NotificationRepository  $notification
     */
    public function __construct(AnnouncementRepository $announcement, NotificationRepository $notification)
    {
        $this->announcement = $announcement;
        $this->notification = $notification;
    }

    /**
     * Get all the announcements.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(Request $request): JsonResponse
    {
        $announcements = $this->announcement->getAll($request);

        return response()->json($announcements, Response::HTTP_OK);
    }

    /**
     * Store a announcement.
     *
     * @param  \Illuminate\Http\Request  $request
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request): JsonResponse
    {
        $announcement = $this->announcement->store($request->all());

        return response()->json($announcement, Response::HTTP_CREATED);
    }

    /**
     * Get a announcement.
     *
     * @param  int  $id
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function show(int $id): JsonResponse
    {
        $announcement = $this->announcement->getById($id);

        return response()->json($announcement, Response::HTTP_OK);
    }

    /**
     * Update a announcement.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int                       $id
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request, int $id): JsonResponse
    {
        $announcement = $this->announcement->updateById($id, $request->all());

        return response()->json($announcement, Response::HTTP_OK);
    }

    /**
     * Delete a announcement.
     *
     * @param  int  $id
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(int $id): JsonResponse
    {
        $this->announcement->deleteById($id);
        $this->notification->deleteByAssociateId('Announcement', $id);

        return response()->json(null, Response::HTTP_NO_CONTENT);
    }
}
