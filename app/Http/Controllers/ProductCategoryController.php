<?php

namespace App\Http\Controllers;

use App\Repository\ProductCategoryRepository;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class ProductCategoryController extends Controller
{
    /**
     * Controller constructor.
     *
     * @param  \App\Repository\ProductCategoryRepository  $product_category
     */
    public function __construct(ProductCategoryRepository $product_category)
    {
        $this->product_category = $product_category;
    }

    /**
     * Get all the product_categories.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(Request $request): JsonResponse
    {
        $product_categories = $this->product_category->getAll($request);

        return response()->json($product_categories, Response::HTTP_OK);
    }

    /**
     * Store a product_category.
     *
     * @param  \Illuminate\Http\Request  $request
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request): JsonResponse
    {
        $product_category = $this->product_category->store($request->all());

        return response()->json($product_category, Response::HTTP_CREATED);
    }

    /**
     * Get a product_category.
     *
     * @param  int  $id
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function show(int $id): JsonResponse
    {
        $product_category = $this->product_category->getById($id);

        return response()->json($product_category, Response::HTTP_OK);
    }

    /**
     * Update a product_category.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int                       $id
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request, int $id): JsonResponse
    {
        $product_category = $this->product_category->updateById($id, $request->all());

        return response()->json($product_category, Response::HTTP_OK);
    }

    /**
     * Delete a product_category.
     *
     * @param  int  $id
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(int $id): JsonResponse
    {
        $this->product_category->deleteById($id);

        return response()->json(null, Response::HTTP_NO_CONTENT);
    }
}
