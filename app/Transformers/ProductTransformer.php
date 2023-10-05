<?php

namespace App\Transformers;

use App\Models\Product;
use League\Fractal\TransformerAbstract;

class ProductTransformer extends TransformerAbstract
{
    /**
     * A Fractal transformer.
     *
     * @param  \App\Models\Product  $product
     * @return array
     */
    public function transform(Product $product): array
    {
        return [
            'id' => (int) $product->id,
            'category_id' => (int) $product->category_id,
            'category_name' => (string) $product->category->name,
            'supplier_id' => (int) $product->supplier_id,
            'supplier_name' => (string) $product->supplier->name,
            'sku' => (string) $product->sku,
            'barcode_id' => (string) $product->barcode_id,
            'name' => (string) $product->name,
            'description' => (string) $product->description,
            'photo' => (string) $product->photo,
            'uom' => (string) $product->uom,
            'weight' => (int) $product->weight,
            'weight_type' => (string) $product->weight_type,
            'is_rtd' => (bool) $product->is_rtd,
            'is_sales' => (bool) $product->is_sales,
            'sell_price' => (float) $product->sell_price,
            'recommendation' => (int) $product->recommendation,
            'depth' => (int) $product->depth,
        ];
    }
}
