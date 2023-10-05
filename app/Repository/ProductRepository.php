<?php

namespace App\Repository;

use App\Models\Product;
use App\Transformers\ProductTransformer;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class ProductRepository
{
    /**
     * Get list of paginated products.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function getAll(Request $request): array
    {
        $products = Product::filter($request)->paginate($request->get('per_page', 20));

        return fractal($products, new ProductTransformer())->toArray();
    }

    /**
     * Get list of paginated competitor products.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function getCompetitors(Request $request): array
    {
        $products = Product::filter($request)->onlyCompetitors()->paginate($request->get('per_page', 20));

        return fractal($products, new ProductTransformer())->toArray();
    }

    /**
     * Get a product by ID.
     *
     * @param  int  $id
     * @return array
     *
     * @throws \Illuminate\Database\Eloquent\ModelNotFoundException
     */
    public function getById(int $id): array
    {
        $product = Product::findOrFail($id);

        return fractal($product, new ProductTransformer())->toArray();
    }

    /**
     * Store a new product.
     *
     * @param  array  $attrs
     * @return array
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(array $attrs): array
    {
        $product = new Product($attrs);
        if (!$product->isValidFor('CREATE')) {
            throw new ValidationException($product->validator());
        }

        $product->save();

        return fractal($product, new ProductTransformer())->toArray();
    }

    /**
     * Update a product by ID.
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
        $product = Product::findOrFail($id);
        $product->fill($attrs);

        if (!$product->isValidFor('UPDATE')) {
            throw new ValidationException($product->validator());
        }

        $product->save();

        return fractal($product, new ProductTransformer())->toArray();
    }

    /**
     * Delete a product by ID.
     *
     * @param  int  $id
     * @return bool
     *
     * @throws \Illuminate\Database\Eloquent\ModelNotFoundException
     */
    public function deleteById(int $id): bool
    {
        $product = Product::findOrFail($id);

        return (bool) $product->delete();
    }
}
