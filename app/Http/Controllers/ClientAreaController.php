<?php

namespace App\Http\Controllers;

use App\Repository\ClientAreaRepository;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class ClientAreaController extends Controller
{
    protected $client_area;

    /**
     * Controller constructor.
     *
     * @param  \App\Repository\ClientAreaRepository  $client_area
     */
    public function __construct(ClientAreaRepository $client_area)
    {
        $this->client_area = $client_area;
    }

    /**
     * Get all the client areas.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(Request $request): JsonResponse
    {
        $client_areas = $this->client_area->getAll($request);

        return response()->json($client_areas, Response::HTTP_OK);
    }

    /**
     * Store a client area.
     *
     * @param  \Illuminate\Http\Request  $request
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request): JsonResponse
    {
        $client_area = $this->client_area->store($request->all());

        return response()->json($client_area, Response::HTTP_CREATED);
    }

    /**
     * Get a client area.
     *
     * @param  int  $id
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function show(int $id): JsonResponse
    {
        $client_area = $this->client_area->getById($id);

        return response()->json($client_area, Response::HTTP_OK);
    }

    /**
     * Update a client area.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int                       $id
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request, int $id): JsonResponse
    {
        $client_area = $this->client_area->updateById($id, $request->all());

        return response()->json($client_area, Response::HTTP_OK);
    }

    /**
     * Delete a client area.
     *
     * @param  int  $id
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(int $id): JsonResponse
    {
        $this->client_area->deleteById($id);

        return response()->json(null, Response::HTTP_NO_CONTENT);
    }
}
