<?php

namespace App\Http\Controllers;

use App\Repository\SalesRepository;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class SalesController extends Controller
{
    protected $sales;

    /**
     * Controller constructor.
     *
     * @param  \App\Repository\SalesRepository  $sales
     */
    public function __construct(SalesRepository $sales)
    {
        $this->sales = $sales;
    }

    /**
     * Get all the sales.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(Request $request): JsonResponse
    {
        $sales = $this->sales->getAll($request);

        return response()->json($sales, Response::HTTP_OK);
    }

    public function stock(Request $request): JsonResponse
    {
        $products = $this->sales->getStockProduct($request);

        return response()->json($products, Response::HTTP_OK);
    }

    /**
     * Store a sales.
     *
     * @param  \Illuminate\Http\Request  $request
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request): JsonResponse
    {
        $sales = $this->sales->store($request->all());

        return response()->json($sales, Response::HTTP_CREATED);
    }

    /**
     * Get a sales.
     *
     * @param  int  $id
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function show(int $id): JsonResponse
    {
        $sales = $this->sales->getById($id);

        return response()->json($sales, Response::HTTP_OK);
    }

    /**
     * Update a sales.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int                       $id
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request, int $id): JsonResponse
    {
        $sales = $this->sales->updateById($id, $request->all());

        return response()->json($sales, Response::HTTP_OK);
    }

    /**
     * Delete a sales.
     *
     * @param  int  $id
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(int $id): JsonResponse
    {
        $this->sales->deleteById($id);

        return response()->json(null, Response::HTTP_NO_CONTENT);
    }
}
