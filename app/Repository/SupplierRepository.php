<?php

namespace App\Repository;

use App\Models\Supplier;
use App\Transformers\SupplierTransformer;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class SupplierRepository
{
    /**
     * Get list of paginated suppliers.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function getAll(Request $request): array
    {
        $suppliers = Supplier::filter($request)->paginate($request->get('per_page', 20));

        return fractal($suppliers, new SupplierTransformer())->toArray();
    }

    /**
     * Get a supplier by ID.
     *
     * @param  int  $id
     * @return array
     *
     * @throws \Illuminate\Database\Eloquent\ModelNotFoundException
     */
    public function getById(int $id): array
    {
        $supplier = Supplier::findOrFail($id);

        return fractal($supplier, new SupplierTransformer())->toArray();
    }

    /**
     * Store a new supplier.
     *
     * @param  array  $attrs
     * @return array
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(array $attrs): array
    {
        $supplier = new Supplier($attrs);
        if (!$supplier->isValidFor('CREATE')) {
            throw new ValidationException($supplier->validator());
        }

        $supplier->save();

        return fractal($supplier, new SupplierTransformer())->toArray();
    }

    /**
     * Update a supplier by ID.
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
        $supplier = Supplier::findOrFail($id);
        $supplier->fill($attrs);

        if (!$supplier->isValidFor('UPDATE')) {
            throw new ValidationException($supplier->validator());
        }

        $supplier->save();

        return fractal($supplier, new SupplierTransformer())->toArray();
    }

    /**
     * Delete a supplier by ID.
     *
     * @param  int  $id
     * @return bool
     *
     * @throws \Illuminate\Database\Eloquent\ModelNotFoundException
     */
    public function deleteById(int $id): bool
    {
        $supplier = Supplier::findOrFail($id);

        return (bool) $supplier->delete();
    }
}
