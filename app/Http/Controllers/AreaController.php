<?php

namespace App\Http\Controllers;

use App\Repository\AreaRepository;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class AreaController extends Controller
{
    /**
     * Controller constructor.
     *
     * @param  \App\Repository\AreaRepository  $area
     */
    public function __construct(AreaRepository $area)
    {
        $this->area = $area;
    }

    /**
     * Get all the areas.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(Request $request): JsonResponse
    {
        $areas = $this->area->getAll($request);

        return response()->json($areas, Response::HTTP_OK);
    }

    /**
     * Store a area.
     *
     * @param  \Illuminate\Http\Request  $request
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request): JsonResponse
    {
        $area = $this->area->store($request->all());

        return response()->json($area, Response::HTTP_CREATED);
    }

    /**
     * Get a area.
     *
     * @param  int  $id
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function show(int $id): JsonResponse
    {
        $area = $this->area->getById($id);

        return response()->json($area, Response::HTTP_OK);
    }

    /**
     * Update a area.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int                       $id
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request, int $id): JsonResponse
    {
        $area = $this->area->updateById($id, $request->all());

        return response()->json($area, Response::HTTP_OK);
    }

    /**
     * Delete a area.
     *
     * @param  int  $id
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(int $id): JsonResponse
    {
        $this->area->deleteById($id);

        return response()->json(null, Response::HTTP_NO_CONTENT);
    }
}
