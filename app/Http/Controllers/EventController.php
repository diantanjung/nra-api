<?php

namespace App\Http\Controllers;

use App\Repository\EventRepository;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class EventController extends Controller
{
    /**
     * Controller constructor.
     *
     * @param  \App\Repository\EventRepository  $event
     */
    public function __construct(EventRepository $event)
    {
        $this->event = $event;
    }

    /**
     * Get all the events.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(Request $request): JsonResponse
    {
        $events = $this->event->getAll($request);

        return response()->json($events, Response::HTTP_OK);
    }

    /**
     * Store an event.
     *
     * @param  \Illuminate\Http\Request  $request
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request): JsonResponse
    {
        $event = $this->event->store($request->all());

        return response()->json($event, Response::HTTP_CREATED);
    }

    /**
     * Get an event.
     *
     * @param  int  $id
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function show(int $id): JsonResponse
    {
        $event = $this->event->getById($id);

        return response()->json($event, Response::HTTP_OK);
    }

    /**
     * Update an event.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int                       $id
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request, int $id): JsonResponse
    {
        $event = $this->event->updateById($id, $request->all());

        return response()->json($event, Response::HTTP_OK);
    }

    /**
     * Delete an event.
     *
     * @param  int  $id
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(int $id): JsonResponse
    {
        $this->event->deleteById($id);

        return response()->json(null, Response::HTTP_NO_CONTENT);
    }
}
