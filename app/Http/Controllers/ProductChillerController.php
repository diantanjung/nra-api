<?php

namespace App\Http\Controllers;

use App\Repository\ProductChillerRepository;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class ProductChillerController extends Controller
{
    /**
     * Controller constructor.
     *
     * @param  \App\Repository\ProductChillerRepository  $product_chiller
     */
    public function __construct(ProductChillerRepository $product_chiller)
    {
        $this->product_chiller = $product_chiller;
    }

    /**
     * Get all the product_chillers.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(Request $request): JsonResponse
    {
        $product_chillers = $this->product_chiller->getAll($request);

        return response()->json($product_chillers, Response::HTTP_OK);
    }

    /**
     * Store a product_chiller.
     *
     * @param  \Illuminate\Http\Request  $request
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request): JsonResponse
    {
        $product_chiller = $this->product_chiller->store($request->all());

        return response()->json($product_chiller, Response::HTTP_CREATED);
    }

    /**
     * Get a product_chiller.
     *
     * @param  int  $id
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function show(int $id): JsonResponse
    {
        $product_chiller = $this->product_chiller->getById($id);

        return response()->json($product_chiller, Response::HTTP_OK);
    }

    /**
     * Update a product_chiller.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int                       $id
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request, int $id): JsonResponse
    {
        $product_chiller = $this->product_chiller->updateById($id, $request->all());

        return response()->json($product_chiller, Response::HTTP_OK);
    }

    /**
     * Restore a product_chiller.
     *
     * @param  int  $id
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function restore(int $id): JsonResponse
    {
        $product_chiller = $this->product_chiller->restoreById($id);

        return response()->json($product_chiller, Response::HTTP_OK);
    }

    /**
     * Delete a product_chiller.
     *
     * @param  int  $id
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(int $id): JsonResponse
    {
        $this->product_chiller->deleteById($id);

        return response()->json(null, Response::HTTP_NO_CONTENT);
    }
}
