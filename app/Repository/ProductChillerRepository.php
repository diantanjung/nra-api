<?php

namespace App\Repository;

use App\Models\ProductChiller;
use App\Transformers\ProductChillerTransformer;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;

class ProductChillerRepository
{
    /**
     * Get list of paginated product_chillers.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function getAll(Request $request): array
    {
        $product_chillers = ProductChiller::filter($request)->paginate($request->get('per_page', 20));

        return fractal($product_chillers, new ProductChillerTransformer())->toArray();
    }

    /**
     * Get a product_chiller by ID.
     *
     * @param  int  $id
     * @return array
     *
     * @throws \Illuminate\Database\Eloquent\ModelNotFoundException
     */
    public function getById(int $id): array
    {
        $product_chiller = ProductChiller::findOrFail($id);

        return fractal($product_chiller, new ProductChillerTransformer())->toArray();
    }

    /**
     * Store a new product_chiller.
     *
     * @param  array  $attrs
     * @return array
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(array $attrs): array
    {
        $check = ProductChiller::where('product_id', $attrs['product_id'])
            ->where('chiller_id', $attrs['chiller_id'])
            ->first();

        if ($check != null) {
            throw new BadRequestHttpException("product already exist");
        }

        $product_chiller = new ProductChiller($attrs);
        if (!$product_chiller->isValidFor('CREATE')) {
            throw new ValidationException($product_chiller->validator());
        }

        $product_chiller->save();

        return fractal($product_chiller, new ProductChillerTransformer())->toArray();
    }

    /**
     * Update a product_chiller by ID.
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
        $product_chiller = ProductChiller::findOrFail($id);
        $product_chiller->fill($attrs);

        if (!$product_chiller->isValidFor('UPDATE')) {
            throw new ValidationException($product_chiller->validator());
        }

        $product_chiller->save();

        return fractal($product_chiller, new ProductChillerTransformer())->toArray();
    }

    /**
     * Delete a product_chiller by ID.
     *
     * @param  int  $id
     * @return bool
     *
     * @throws \Illuminate\Database\Eloquent\ModelNotFoundException
     */
    public function deleteById(int $id): bool
    {
        $product_chiller = ProductChiller::findOrFail($id);

        return (bool) $product_chiller->delete();
    }

    public function restoreById(int $id): array
    {
        $product_chiller = ProductChiller::findOrFail($id);
        $product_chiller->restore();

        return fractal($product_chiller, new ProductChillerTransformer())->toArray();
    }
}
