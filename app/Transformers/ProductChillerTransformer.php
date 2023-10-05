<?php

namespace App\Transformers;

use App\Models\ProductChiller;
use League\Fractal\TransformerAbstract;

class ProductChillerTransformer extends TransformerAbstract
{
    /**
     * A Fractal transformer.
     *
     * @param  \App\Models\ProductChiller  $product_chiller
     * @return array
     */
    public function transform(ProductChiller $product_chiller): array
    {
        return [
            'id' => (int) $product_chiller->id,
            'chiller_id' => (int) $product_chiller->chiller_id,
            'chiller_label' => (string) $product_chiller->chiller->merk . " " . $product_chiller->chiller->type,
            'chiller_capacity' => (int) $product_chiller->chiller->capacity,
            'stock' => (int) $product_chiller->stock,
            'status' => (int) $product_chiller->status,
            'product_id' => (int) ($product_chiller->product_id ?? 0),
            'category_id' => (int) ($product_chiller->product->category_id ?? 0),
            'category_name' => (string) ($product_chiller->product->category->name ?? ""),
            'supplier_id' => (int) ($product_chiller->product->supplier_id ?? 0),
            'supplier_name' => (string) ($product_chiller->product->supplier->name ?? ""),
            'sku' => (string) ($product_chiller->product->sku ?? ""),
            'barcode_id' => (string) ($product_chiller->product->barcode_id ?? ""),
            'name' => (string) ($product_chiller->product->name ?? $product_chiller->product_competitor),
            'description' => (string) ($product_chiller->product->description ?? ""),
            'photo' => (string) ($product_chiller->product->photo ?? ""),
            'uom' => (string) ($product_chiller->product->uom ?? ""),
            'weight' => (int) ($product_chiller->product->weight ?? 0),
            'weight_type' => (string) ($product_chiller->product->weight_type ?? ""),
            'is_rtd' => (bool) ($product_chiller->product->is_rtd ?? false),
            'is_competitor' => (bool) $product_chiller->is_competitor,
            'sell_price' => (float) ($product_chiller->product->sell_price ?? 0),
            'recommendation' => (int) ($product_chiller->product->recommendation ?? $product_chiller->stock),
            'depth' => (int) ($product_chiller->product->depth ?? $product_chiller->stock),
            'deleted_at' => (string) $product_chiller->deleted_at,
        ];
    }
}
