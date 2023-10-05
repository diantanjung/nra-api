<?php

namespace App\Http\Controllers;

use App\Repository\ContractTypeRepository;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class ContractTypeController extends Controller
{
    /**
     * Controller constructor.
     *
     * @param  \App\Repository\ContractTypeRepository  $contract_type
     */
    public function __construct(ContractTypeRepository $contract_type)
    {
        $this->contract_type = $contract_type;
    }

    /**
     * Get all the contract types.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(Request $request): JsonResponse
    {
        $contract_types = $this->contract_type->getAll($request);

        return response()->json($contract_types, Response::HTTP_OK);
    }

    /**
     * Store a contract type.
     *
     * @param  \Illuminate\Http\Request  $request
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request): JsonResponse
    {
        $contract_type = $this->contract_type->store($request->all());

        return response()->json($contract_type, Response::HTTP_CREATED);
    }

    /**
     * Get a contract type.
     *
     * @param  int  $id
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function show(int $id): JsonResponse
    {
        $contract_type = $this->contract_type->getById($id);

        return response()->json($contract_type, Response::HTTP_OK);
    }

    /**
     * Update a contract type.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int                       $id
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request, int $id): JsonResponse
    {
        $contract_type = $this->contract_type->updateById($id, $request->all());

        return response()->json($contract_type, Response::HTTP_OK);
    }

    /**
     * Delete a contract type.
     *
     * @param  int  $id
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(int $id): JsonResponse
    {
        $this->contract_type->deleteById($id);

        return response()->json(null, Response::HTTP_NO_CONTENT);
    }
}
