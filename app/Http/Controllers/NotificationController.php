<?php

namespace App\Http\Controllers;

use App\Models\Role;
use App\Repository\NotificationRepository;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Http\Response;

class NotificationController extends Controller
{
    protected $notification;

    /**
     * Controller constructor.
     *
     * @param  \App\Repository\NotificationRepository  $notification
     */
    public function __construct(NotificationRepository $notification)
    {
        $this->notification = $notification;
    }

    /**
     * Get all the notifications.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(Request $request): JsonResponse
    {
        $notifications = $this->notification->getAll($request);

        return response()->json($notifications, Response::HTTP_OK);
    }

    public function check(): JsonResponse
    {
        $notification_status = $this->notification->checkReadStatus();

        return responseSuccess($notification_status);
    }

    /**
     * Update a notification.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int                       $id
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request, int $id): JsonResponse
    {
        $notification = $this->notification->updateById($id, $request->all());

        return response()->json($notification, Response::HTTP_OK);
    }
}
