<?php

namespace App\Http\Controllers;

use App\Repository\ClientRegulationRepository;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class ClientRegulationController extends Controller
{
    /**
     * Controller constructor.
     *
     * @param  \App\Repository\ClientRegulationRepository  $client_regulation
     */
    public function __construct(ClientRegulationRepository $client_regulation)
    {
        $this->client_regulation = $client_regulation;
    }

    /**
     * Get all the client regulations.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(Request $request): JsonResponse
    {
        $client_regulations = $this->client_regulation->getAll($request);

        return response()->json($client_regulations, Response::HTTP_OK);
    }

    /**
     * Store a client regulation.
     *
     * @param  \Illuminate\Http\Request  $request
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request): JsonResponse
    {
        $client_regulation = $this->client_regulation->store($request->all());

        return response()->json($client_regulation, Response::HTTP_CREATED);
    }

    /**
     * Get a client regulation.
     *
     * @param  int  $id
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function show(int $id): JsonResponse
    {
        $client_regulation = $this->client_regulation->getById($id);

        return response()->json($client_regulation, Response::HTTP_OK);
    }

    /**
     * Update a client regulation.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int                       $id
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request, int $id): JsonResponse
    {
        $client_regulation = $this->client_regulation->updateById($id, $request->all());

        return response()->json($client_regulation, Response::HTTP_OK);
    }

    /**
     * Delete a client regulation.
     *
     * @param  int  $id
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(int $id): JsonResponse
    {
        $this->client_regulation->deleteById($id);

        return response()->json(null, Response::HTTP_NO_CONTENT);
    }
}
