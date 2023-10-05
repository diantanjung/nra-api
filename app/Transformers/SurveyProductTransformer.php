<?php

namespace App\Transformers;

use App\Models\SurveyDetail;
use League\Fractal\TransformerAbstract;

class SurveyProductTransformer extends TransformerAbstract
{
    /**
     * A Fractal transformer.
     *
     * @param  \App\Models\SurveyDetail  $survey_detail
     * @return array
     */
    public function transform(SurveyDetail $survey_detail): array
    {
        return [
            'survey_id' => (int) $survey_detail->survey_id,
            'survey_detail_id' => (int) $survey_detail->id,
            'chiller_id' => (int) $survey_detail->chiller_id,
            'chiller_capacity' => (int) $survey_detail->chiller->capacity,
            'schedule_id' => (int) $survey_detail->survey_id,
            'planogram' => (bool) $survey_detail->planogram,
            'planogram_note' => (string) $survey_detail->planogram_note,
            'planogram_photo' => (string) $survey_detail->planogram_photo,
            'products' => $this->transformProducts($survey_detail->products),
        ];
    }

    private function transformProducts($survey_products): array
    {
        $product_data = array();
        foreach ($survey_products as $survey_product) {
            $product_data[] = [
                'id' => (int) $survey_product->id,
                'product_chiller_id' => $survey_product->product_chiller_id,
                'sell_price' => (int) $survey_product->sell_price,
                'stock' => (int) $survey_product->stock,
                'percentage' => (float) $survey_product->percentage,
                'status' => (bool) $survey_product->status,
                'name' => $survey_product->product_chiller->product->name,
                'photo' => $survey_product->product_chiller->product->photo,
                'recommendation' => $survey_product->product_chiller->product->recommendation,
                'depth' => $survey_product->product_chiller->product->depth,
            ];
        }

        return $product_data;
    }
}
