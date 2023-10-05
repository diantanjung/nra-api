<?php

namespace App\Http\Controllers;

use App\Repository\MerchantRepository;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class MerchantController extends Controller
{
    /**
     * Controller constructor.
     *
     * @param  \App\Repository\MerchantRepository  $merchant
     */
    public function __construct(MerchantRepository $merchant)
    {
        $this->merchant = $merchant;
    }

    /**
     * Get all the merchants.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(Request $request): JsonResponse
    {
        $merchants = $this->merchant->getAll($request);

        return response()->json($merchants, Response::HTTP_OK);
    }

    /**
     * Store a merchant.
     *
     * @param  \Illuminate\Http\Request  $request
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request): JsonResponse
    {
        $merchant = $this->merchant->store($request->all());

        return response()->json($merchant, Response::HTTP_CREATED);
    }

    /**
     * Get a merchant.
     *
     * @param  string  $id
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function show(string $id): JsonResponse
    {
        $merchant = $this->merchant->getById($id);

        return response()->json($merchant, Response::HTTP_OK);
    }

    /**
     * Update a merchant.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int                       $id
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request, string $id): JsonResponse
    {
        $merchant = $this->merchant->updateById($id, $request->all());

        return response()->json($merchant, Response::HTTP_OK);
    }

    /**
     * Delete a merchant.
     *
     * @param  string  $id
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(string $id): JsonResponse
    {
        $this->merchant->deleteById($id);

        return response()->json(null, Response::HTTP_NO_CONTENT);
    }
}
