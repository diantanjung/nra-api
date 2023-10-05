<?php

namespace App\Http\Controllers;

use App\Repository\DepositRepository;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class DepositController extends Controller
{
    /**
     * Controller constructor.
     *
     * @param  \App\Repository\DepositRepository  $deposit
     */
    public function __construct(DepositRepository $deposit)
    {
        $this->deposit = $deposit;
    }

    /**
     * Get all the deposits.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(Request $request): JsonResponse
    {
        $deposits = $this->deposit->getAll($request);

        return response()->json($deposits, Response::HTTP_OK);
    }

    /**
     * Store a deposit.
     *
     * @param  \Illuminate\Http\Request  $request
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request): JsonResponse
    {
        $deposit = $this->deposit->store($request->all());

        return response()->json($deposit, Response::HTTP_CREATED);
    }

    /**
     * Get a deposit.
     *
     * @param  int  $id
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function show(int $id): JsonResponse
    {
        $deposit = $this->deposit->getById($id);

        return response()->json($deposit, Response::HTTP_OK);
    }

    /**
     * Update a deposit.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int                       $id
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request, int $id): JsonResponse
    {
        $deposit = $this->deposit->updateById($id, $request->all());

        return response()->json($deposit, Response::HTTP_OK);
    }

    /**
     * Delete a deposit.
     *
     * @param  int  $id
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(int $id): JsonResponse
    {
        $this->deposit->deleteById($id);

        return response()->json(null, Response::HTTP_NO_CONTENT);
    }
}
