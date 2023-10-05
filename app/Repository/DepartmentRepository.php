<?php

namespace App\Repository;

use App\Models\Department;
use App\Transformers\DepartmentTransformer;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class DepartmentRepository
{
    /**
     * Get list of paginated departments.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function getAll(Request $request): array
    {
        $departments = Department::filter($request)->paginate($request->get('per_page', 20));

        return fractal($departments, new DepartmentTransformer())->toArray();
    }

    /**
     * Get a department by ID.
     *
     * @param  int  $id
     * @return array
     *
     * @throws \Illuminate\Database\Eloquent\ModelNotFoundException
     */
    public function getById(int $id): array
    {
        $department = Department::findOrFail($id);

        return fractal($department, new DepartmentTransformer())->toArray();
    }

    /**
     * Store a new department.
     *
     * @param  array  $attrs
     * @return array
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(array $attrs): array
    {
        $department = new Department($attrs);
        if (!$department->isValidFor('CREATE')) {
            throw new ValidationException($department->validator());
        }

        $department->save();

        return fractal($department, new DepartmentTransformer())->toArray();
    }

    /**
     * Update a department by ID.
     *
     * @param  int  $id
     * @param  array  $attrs
     * @return array
     *
     * @throws \Illuminate\Database\Eloquent\ModelNotFoundException
     * @throws \Illuminate\Validation\ValidationException
     */
    public function updateById(int $id, array $attrs): array
    {
        $department = Department::findOrFail($id);
        $department->fill($attrs);

        if (!$department->isValidFor('UPDATE')) {
            throw new ValidationException($department->validator());
        }

        $department->save();

        return fractal($department, new DepartmentTransformer())->toArray();
    }

    /**
     * Delete a department by ID.
     *
     * @param  int  $id
     * @return bool
     *
     * @throws \Illuminate\Database\Eloquent\ModelNotFoundException
     */
    public function deleteById(int $id): bool
    {
        $department = Department::findOrFail($id);

        return (bool) $department->delete();
    }
}
