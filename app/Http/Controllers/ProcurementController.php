<?php

namespace App\Http\Controllers;

use App\Repository\ProcurementRepository;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class ProcurementController extends Controller
{
    protected $procurement;

    /**
     * Controller constructor.
     *
     * @param  \App\Repository\ProcurementRepository  $procurement
     */
    public function __construct(ProcurementRepository $procurement)
    {
        $this->procurement = $procurement;
    }

    /**
     * Get all the procurement.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(Request $request): JsonResponse
    {
        $procurement = $this->procurement->getAll($request);

        return response()->json($procurement, Response::HTTP_OK);
    }

    public function products(): JsonResponse
    {
        $products = $this->procurement->getProducts();

        return response()->json($products, Response::HTTP_OK);
    }

    /**
     * Store a procurement.
     *
     * @param  \Illuminate\Http\Request  $request
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request): JsonResponse
    {
        $procurement = $this->procurement->store($request->all());

        return response()->json($procurement, Response::HTTP_CREATED);
    }

    /**
     * Get a procurement.
     *
     * @param  int  $id
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function show(int $id): JsonResponse
    {
        $procurement = $this->procurement->getById($id);

        return response()->json($procurement, Response::HTTP_OK);
    }

    /**
     * Update a procurement.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int                       $id
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request, int $id): JsonResponse
    {
        $procurement = $this->procurement->updateById($id, $request->all());

        return response()->json($procurement, Response::HTTP_OK);
    }

    /**
     * Delete a procurement.
     *
     * @param  int  $id
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(int $id): JsonResponse
    {
        $this->procurement->deleteById($id);

        return response()->json(null, Response::HTTP_NO_CONTENT);
    }
}
