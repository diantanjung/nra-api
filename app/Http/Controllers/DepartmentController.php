<?php

namespace App\Http\Controllers;

use App\Repository\DepartmentRepository;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class DepartmentController extends Controller
{
    /**
     * Controller constructor.
     *
     * @param  \App\Repository\DepartmentRepository  $department
     */
    public function __construct(DepartmentRepository $department)
    {
        $this->department = $department;
    }

    /**
     * Get all the departments.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(Request $request): JsonResponse
    {
        $departments = $this->department->getAll($request);

        return response()->json($departments, Response::HTTP_OK);
    }

    /**
     * Store a department.
     *
     * @param  \Illuminate\Http\Request  $request
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request): JsonResponse
    {
        $department = $this->department->store($request->all());

        return response()->json($department, Response::HTTP_CREATED);
    }

    /**
     * Get a department.
     *
     * @param  int  $id
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function show(int $id): JsonResponse
    {
        $department = $this->department->getById($id);

        return response()->json($department, Response::HTTP_OK);
    }

    /**
     * Update a department.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int                       $id
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request, int $id): JsonResponse
    {
        $department = $this->department->updateById($id, $request->all());

        return response()->json($department, Response::HTTP_OK);
    }

    /**
     * Delete a department.
     *
     * @param  int  $id
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(int $id): JsonResponse
    {
        $this->department->deleteById($id);

        return response()->json(null, Response::HTTP_NO_CONTENT);
    }
}
