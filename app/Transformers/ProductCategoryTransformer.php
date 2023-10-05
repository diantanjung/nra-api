<?php

namespace App\Transformers;

use App\Models\ProductCategory;
use League\Fractal\TransformerAbstract;

class ProductCategoryTransformer extends TransformerAbstract
{
    /**
     * A Fractal transformer.
     *
     * @param  \App\Models\ProductCategory  $product_category
     * @return array
     */
    public function transform(ProductCategory $product_category): array
    {
        return [
            'id' => (int) $product_category->id,
            'name' => (string) $product_category->name,
            'icon' => (string) $product_category->icon,
            'parent_id' => (int) $product_category->parent_id,
            'parent_label' => (string) ($product_category->parent->name ?? ""),
        ];
    }
}
