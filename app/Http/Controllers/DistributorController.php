<?php

namespace App\Http\Controllers;

use App\Repository\DistributorRepository;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class DistributorController extends Controller
{
    protected $distributor;

    /**
     * Controller constructor.
     *
     * @param  \App\Repository\DistributorRepository  $distributor
     */
    public function __construct(DistributorRepository $distributor)
    {
        $this->distributor = $distributor;
    }

    /**
     * Get all the distributors.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(Request $request): JsonResponse
    {
        $distributors = $this->distributor->getAll($request);

        return response()->json($distributors, Response::HTTP_OK);
    }

    /**
     * Store a distributor.
     *
     * @param  \Illuminate\Http\Request  $request
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request): JsonResponse
    {
        $distributor = $this->distributor->store($request->all());

        return response()->json($distributor, Response::HTTP_CREATED);
    }

    /**
     * Get a distributor.
     *
     * @param  int  $id
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function show(int $id): JsonResponse
    {
        $distributor = $this->distributor->getById($id);

        return response()->json($distributor, Response::HTTP_OK);
    }

    /**
     * Update a distributor.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int                       $id
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request, int $id): JsonResponse
    {
        $distributor = $this->distributor->updateById($id, $request->all());

        return response()->json($distributor, Response::HTTP_OK);
    }

    /**
     * Delete a distributor.
     *
     * @param  int  $id
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(int $id): JsonResponse
    {
        $this->distributor->deleteById($id);

        return response()->json(null, Response::HTTP_NO_CONTENT);
    }
}
