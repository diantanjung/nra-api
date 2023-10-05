<?php

namespace App\Exports;

use App\Models\SurveyProduct;
use App\Models\Product;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithTitle;

class SurveyProductSheet implements FromCollection, WithTitle, WithHeadings
{
    protected $start_date;
    protected $end_date;

    public function __construct(string $start_date, string $end_date)
    {
        $this->start_date = $start_date;
        $this->end_date = $end_date;
    }

    /**
     * @return Array
     * Modify data from collection before exporting to excel
     */
    public function map($data): array
    {
        $product = Product::findOrFail($data->product_id);

        return [
            $product->name,
            $data->sell_price,
            $data->stock,
        ];
    }

    public function headings(): array
    {
        return [
            "Nama Produk",
            "Harga Jual",
            "Stock",
        ];
    }

    /**
     * @return Collection
     */
    public function collection()
    {
        $surveyProducts = SurveyProduct::query()
            ->whereBetween('created_at', [$this->start_date, $this->end_date])
            ->get();

        return $surveyProducts->map(function ($surveyProduct) {
            return $this->map($surveyProduct);
        });
    }

    /**
     * @return string
     */
    public function title(): string
    {
        return 'survey_product';
    }
}
