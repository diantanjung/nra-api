<?php

namespace App\Http\Controllers;

use App\Repository\RegulationRepository;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class RegulationController extends Controller
{
    /**
     * Controller constructor.
     *
     * @param  \App\Repository\RegulationRepository  $regulation
     */
    public function __construct(RegulationRepository $regulation)
    {
        $this->regulation = $regulation;
    }

    /**
     * Get all the regulations.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(Request $request): JsonResponse
    {
        $regulations = $this->regulation->getAll($request);

        return response()->json($regulations, Response::HTTP_OK);
    }

    /**
     * Store a regulation.
     *
     * @param  \Illuminate\Http\Request  $request
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request): JsonResponse
    {
        $regulation = $this->regulation->store($request->all());

        return response()->json($regulation, Response::HTTP_CREATED);
    }

    /**
     * Get a regulation.
     *
     * @param  int  $id
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function show(int $id): JsonResponse
    {
        $regulation = $this->regulation->getById($id);

        return response()->json($regulation, Response::HTTP_OK);
    }

    /**
     * Update a regulation.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int                       $id
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request, int $id): JsonResponse
    {
        $regulation = $this->regulation->updateById($id, $request->all());

        return response()->json($regulation, Response::HTTP_OK);
    }

    /**
     * Delete a regulation.
     *
     * @param  int  $id
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(int $id): JsonResponse
    {
        $this->regulation->deleteById($id);

        return response()->json(null, Response::HTTP_NO_CONTENT);
    }
}
