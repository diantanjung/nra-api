<?php

namespace App\Repository;

use App\Models\ProductCategory;
use App\Transformers\ProductCategoryTransformer;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class ProductCategoryRepository
{
    /**
     * Get list of paginated product_categories.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function getAll(Request $request): array
    {
        $product_categories = ProductCategory::filter($request)->paginate($request->get('per_page', 20));

        return fractal($product_categories, new ProductCategoryTransformer())->toArray();
    }

    /**
     * Get a product_category by ID.
     *
     * @param  int  $id
     * @return array
     *
     * @throws \Illuminate\Database\Eloquent\ModelNotFoundException
     */
    public function getById(int $id): array
    {
        $product_category = ProductCategory::findOrFail($id);

        return fractal($product_category, new ProductCategoryTransformer())->toArray();
    }

    /**
     * Store a new product_category.
     *
     * @param  array  $attrs
     * @return array
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(array $attrs): array
    {
        $product_category = new ProductCategory($attrs);
        if (!$product_category->isValidFor('CREATE')) {
            throw new ValidationException($product_category->validator());
        }

        $product_category->save();

        return fractal($product_category, new ProductCategoryTransformer())->toArray();
    }

    /**
     * Update a product_category by ID.
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
        $product_category = ProductCategory::findOrFail($id);
        $product_category->fill($attrs);

        if (!$product_category->isValidFor('UPDATE')) {
            throw new ValidationException($product_category->validator());
        }

        $product_category->save();

        return fractal($product_category, new ProductCategoryTransformer())->toArray();
    }

    /**
     * Delete a product_category by ID.
     *
     * @param  int  $id
     * @return bool
     *
     * @throws \Illuminate\Database\Eloquent\ModelNotFoundException
     */
    public function deleteById(int $id): bool
    {
        $product_category = ProductCategory::findOrFail($id);

        return (bool) $product_category->delete();
    }
}
