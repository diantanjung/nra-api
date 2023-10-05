<?php

namespace App\Http\Controllers;

use App\Repository\ProductRepository;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class ProductController extends Controller
{
    protected $product;

    /**
     * Controller constructor.
     *
     * @param  \App\Repository\ProductRepository  $product
     */
    public function __construct(ProductRepository $product)
    {
        $this->product = $product;
    }

    /**
     * Get all the products.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(Request $request): JsonResponse
    {
        $products = $this->product->getAll($request);

        return response()->json($products, Response::HTTP_OK);
    }

    /**
     * Store a product.
     *
     * @param  \Illuminate\Http\Request  $request
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request): JsonResponse
    {
        $product = $this->product->store($request->all());

        return response()->json($product, Response::HTTP_CREATED);
    }

    /**
     * Get a product.
     *
     * @param  int  $id
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function show(int $id): JsonResponse
    {
        $product = $this->product->getById($id);

        return response()->json($product, Response::HTTP_OK);
    }

    /**
     * Update a product.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int                       $id
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request, int $id): JsonResponse
    {
        $product = $this->product->updateById($id, $request->all());

        return response()->json($product, Response::HTTP_OK);
    }

    /**
     * Delete a product.
     *
     * @param  int  $id
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(int $id): JsonResponse
    {
        try {
            $this->product->deleteById($id);
            return response()->json(null, Response::HTTP_NO_CONTENT);
        } catch (\Exception $e) {
            return responseError("GAGAL: produk memiliki relasi ke data lain", 400);
        }
    }
}
