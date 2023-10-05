<?php

namespace App\Http\Controllers;

use App\Repository\SupplierRepository;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class SupplierController extends Controller
{
    /**
     * Controller constructor.
     *
     * @param  \App\Repository\SupplierRepository  $supplier
     */
    public function __construct(SupplierRepository $supplier)
    {
        $this->supplier = $supplier;
    }

    /**
     * Get all the suppliers.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(Request $request): JsonResponse
    {
        $suppliers = $this->supplier->getAll($request);

        return response()->json($suppliers, Response::HTTP_OK);
    }

    /**
     * Store a supplier.
     *
     * @param  \Illuminate\Http\Request  $request
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request): JsonResponse
    {
        $supplier = $this->supplier->store($request->all());

        return response()->json($supplier, Response::HTTP_CREATED);
    }

    /**
     * Get a supplier.
     *
     * @param  string  $id
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function show(string $id): JsonResponse
    {
        $supplier = $this->supplier->getById($id);

        return response()->json($supplier, Response::HTTP_OK);
    }

    /**
     * Update a supplier.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int                       $id
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request, string $id): JsonResponse
    {
        $supplier = $this->supplier->updateById($id, $request->all());

        return response()->json($supplier, Response::HTTP_OK);
    }

    /**
     * Delete a supplier.
     *
     * @param  string  $id
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(string $id): JsonResponse
    {
        $this->supplier->deleteById($id);

        return response()->json(null, Response::HTTP_NO_CONTENT);
    }
}
