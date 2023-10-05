<?php

namespace App\Exports;

use App\Models\Product;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithTitle;

class ProductMasterSheet implements FromQuery, WithTitle, WithHeadings
{
    public function headings(): array
    {
        return [
            "id",
            "category_id",
            "supplier_id",
            "sku",
            "barcode_id",
            "name",
            "description",
            "photo",
            "uom",
            "weight",
            "weight_type",
            "recommendation",
            "depth",
            "sell_price",
            "is_rtd",
            "created_at",
            "updated_at",
            "deleted_at",
        ];
    }

    /**
     * @return Builder
     */
    public function query()
    {
        return Product::query()->where('is_sales', 0);
    }

    /**
     * @return string
     */
    public function title(): string
    {
        return 'product_master';
    }
}
