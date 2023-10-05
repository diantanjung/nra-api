<?php

namespace App\Http\Controllers;

use App\Repository\ClientRepository;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class ClientController extends Controller
{
    protected $client;

    /**
     * Controller constructor.
     *
     * @param  \App\Repository\ClientRepository  $client
     */
    public function __construct(ClientRepository $client)
    {
        $this->client = $client;
    }

    /**
     * Get all the client data.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(): JsonResponse
    {
        $clients = $this->client->recap();

        return response()->json($clients, Response::HTTP_OK);
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
        return $this->client->store($request->all());
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
        $client = $this->client->getById($id);

        return response()->json($client, Response::HTTP_OK);
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
        $client = $this->client->updateById($id, $request->all());

        return response()->json($client, Response::HTTP_OK);
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
        $this->client->deleteById($id);

        return response()->json(null, Response::HTTP_NO_CONTENT);
    }

    /**
     * Get client employee list.
     *
     * @param  int  $id
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function employee(Request $request): JsonResponse
    {
        $client = $this->client->employees($request);

        return response()->json($client, Response::HTTP_OK);
    }

    /**
     * Update client employee contract.
     *
     * @param  int  $id
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function contract(Request $request): JsonResponse
    {
        $client = $this->client->updateContract($request);

        return response()->json($client, Response::HTTP_OK);
    }
}
