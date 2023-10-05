<?php

namespace App\Repository;

use App\Models\Sales;
use App\Models\SaleDetail;
use App\Models\ProcurementDetail;
use App\Transformers\SalesTransformer;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class SalesRepository
{
    /**
     * Get list of paginated sales.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function getAll(Request $request): array
    {
        $sales = Sales::filter($request)->paginate($request->get('per_page', 20));

        return fractal($sales, new SalesTransformer())->toArray();
    }

    /**
     * Get a sales by ID.
     *
     * @param  int  $id
     * @return array
     *
     * @throws \Illuminate\Database\Eloquent\ModelNotFoundException
     */
    public function getById(int $id): array
    {
        $sales = Sales::findOrFail($id);

        return fractal($sales, new SalesTransformer())->toArray();
    }

    /**
     * Store a new sales.
     *
     * @param  array  $attrs
     * @return array
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(array $attrs): array
    {
        $sales = new Sales($attrs);
        if (!$sales->isValidFor('CREATE')) {
            throw new ValidationException($sales->validator());
        }

        $sales->save();

        if ($attrs['details'] && count($attrs['details']) > 0) {
            $sales_details = [];
            foreach ($attrs['details'] as $sale_detail) {
                $procurementDetailId = ProcurementDetail::where('id', $sale_detail['id'])->firstOrFail();
                $sale_detail['procurement_detail_id'] = $sale_detail['id'];
                $sale_detail['sales_id'] = $sales['id'];
                unset($sale_detail['id']);
                $saleDetail = new SaleDetail($sale_detail);
                if (!$saleDetail->isValidFor('CREATE')) {
                    throw new ValidationException($saleDetail->validator());
                }
                $sales_details[] = $sale_detail;
            }

            SaleDetail::insert($sales_details);
        }

        return fractal($sales, new SalesTransformer())->toArray();
    }

    /**
     * Update a sales by ID.
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
        $sales = Sales::findOrFail($id);
        $sales->fill($attrs);
        if (!$sales->isValidFor('UPDATE')) {
            throw new ValidationException($sales->validator());
        }

        $sales->save();

        return fractal($sales, new SalesTransformer())->toArray();
    }

    /**
     * Delete a sales by ID.
     *
     * @param  int  $id
     * @return bool
     *
     * @throws \Illuminate\Database\Eloquent\ModelNotFoundException
     */
    public function deleteById(int $id): bool
    {
        $sales = Sales::findOrFail($id);

        return (bool) $sales->delete();
    }
}
