<?php

namespace App\Repository;

use App\Models\Product;
use App\Models\Procurement;
use App\Models\ProcurementDetail;
use App\Transformers\ProcurementProductTransformer;
use App\Transformers\ProcurementTransformer;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class ProcurementRepository
{
    /**
     * Get list of paginated procurement.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function getAll(Request $request): array
    {
        $procurement = Procurement::filter($request)->paginate($request->get('per_page', 20));

        return fractal($procurement, new ProcurementTransformer())->toArray();
    }

    public function getProducts(): array
    {
        $user_auth = app('auth')->user();
        $procurement = Procurement::where('user_id', $user_auth->id)
            ->orderBy('id', 'desc')
            ->firstOrFail();

        return fractal($procurement->details, new ProcurementProductTransformer())->toArray();
    }

    /**
     * Get a procurement by ID.
     *
     * @param  int  $id
     * @return array
     *
     * @throws \Illuminate\Database\Eloquent\ModelNotFoundException
     */
    public function getById(int $id): array
    {
        $procurement = Procurement::findOrFail($id);

        return fractal($procurement, new ProcurementTransformer())->toArray();
    }

    /**
     * Store a new procurement.
     *
     * @param  array  $attrs
     * @return array
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(array $attrs): array
    {
        $user_auth = app('auth')->user();
        $attrs['user_id'] = $user_auth->id;
        $procurement = new Procurement($attrs);
        if (!$procurement->isValidFor('CREATE')) {
            throw new ValidationException($procurement->validator());
        }
        $procurement->save();

        if ($attrs['products'] && count($attrs['products']) > 0) {
            $procurement_details = [];
            foreach ($attrs['products'] as $product_procurement) {
                $product = Product::where('id', $product_procurement['id'])->firstOrFail();
                $product_procurement['procurement_id'] = $procurement['id'];
                $product_procurement['product_id'] = $product_procurement['id'];
                unset($product_procurement['id']);
                $procurement_detail = new ProcurementDetail($product_procurement);
                if (!$procurement_detail->isValidFor('CREATE')) {
                    throw new ValidationException($procurement_detail->validator());
                }
                $procurement_details[] = $product_procurement;
            }
            ProcurementDetail::insert($procurement_details);
        }

        return fractal($procurement, new ProcurementTransformer())->toArray();
    }

    /**
     * Update a procurement by ID.
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
        $procurement = Procurement::findOrFail($id);
        $procurement->fill($attrs);
        if (!$procurement->isValidFor('UPDATE')) {
            throw new ValidationException($procurement->validator());
        }

        $procurement->save();

        return fractal($procurement, new ProcurementTransformer())->toArray();
    }

    /**
     * Delete a procurement by ID.
     *
     * @param  int  $id
     * @return bool
     *
     * @throws \Illuminate\Database\Eloquent\ModelNotFoundException
     */
    public function deleteById(int $id): bool
    {
        $procurement = Procurement::findOrFail($id);

        return (bool) $procurement->delete();
    }
}
