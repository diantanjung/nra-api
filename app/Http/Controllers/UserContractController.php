<?php

namespace App\Http\Controllers;

use App\Repository\UserContractRepository;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Http\Controllers\Controller;

class UserContractController extends Controller
{
    protected $contract;

    /**
     * Controller constructor.
     *
     * @param  \App\Repository\UserContractRepository  $contract
     */
    public function __construct(UserContractRepository $contract)
    {
        $this->contract = $contract;
    }

    /**
     * Get all the contracts.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(Request $request): JsonResponse
    {
        $contracts = $this->contract->getAll($request);

        return response()->json($contracts, Response::HTTP_OK);
    }

    /**
     * Store a contract.
     *
     * @param  \Illuminate\Http\Request  $request
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request): JsonResponse
    {
        $contract = $this->contract->store($request->all());

        return response()->json($contract, Response::HTTP_CREATED);
    }

    /**
     * Get a contract.
     *
     * @param  int  $id
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function show(int $id): JsonResponse
    {
        $contract = $this->contract->getByUserId($id);

        return response()->json($contract, Response::HTTP_OK);
    }

    /**
     * Update a contract.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int                       $id
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request, int $id): JsonResponse
    {
        $contract = $this->contract->updateById($id, $request->all());

        return response()->json($contract, Response::HTTP_OK);
    }

    /**
     * Delete a contract.
     *
     * @param  int  $id
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(int $id): JsonResponse
    {
        $this->contract->deleteById($id);

        return response()->json(null, Response::HTTP_NO_CONTENT);
    }
}
