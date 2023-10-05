<?php

namespace App\Http\Controllers;

use App\Repository\ChillerRepository;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class ChillerController extends Controller
{
    /**
     * Controller constructor.
     *
     * @param  \App\Repository\ChillerRepository  $chiller
     */
    public function __construct(ChillerRepository $chiller)
    {
        $this->chiller = $chiller;
    }

    /**
     * Get all the chillers.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(Request $request): JsonResponse
    {
        if ((int) $request->merchant_id == 0) {
            abort(400, 'merchant_id param is required');
        }

        $chillers = $this->chiller->getAll($request);

        return response()->json($chillers, Response::HTTP_OK);
    }

    /**
     * Store a chiller.
     *
     * @param  \Illuminate\Http\Request  $request
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request): JsonResponse
    {
        $chiller = $this->chiller->store($request->all());

        return response()->json($chiller, Response::HTTP_CREATED);
    }

    /**
     * Get a chiller.
     *
     * @param  string  $id
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function show(string $id): JsonResponse
    {
        $chiller = $this->chiller->getById($id);

        return response()->json($chiller, Response::HTTP_OK);
    }

    /**
     * Update a chiller.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int                       $id
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request, string $id): JsonResponse
    {
        $chiller = $this->chiller->updateById($id, $request->all());

        return response()->json($chiller, Response::HTTP_OK);
    }

    /**
     * Delete a chiller.
     *
     * @param  string  $id
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(string $id): JsonResponse
    {
        $this->chiller->deleteById($id);

        return response()->json(null, Response::HTTP_NO_CONTENT);
    }
}
