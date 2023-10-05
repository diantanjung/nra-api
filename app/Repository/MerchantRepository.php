<?php

namespace App\Repository;

use App\Models\Merchant;
use App\Transformers\MerchantTransformer;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class MerchantRepository
{
    /**
     * Get list of paginated merchants.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function getAll(Request $request): array
    {
        $merchants = Merchant::filter($request)->paginate($request->get('per_page', 20));

        return fractal($merchants, new MerchantTransformer())->toArray();
    }

    /**
     * Get a merchant by ID.
     *
     * @param  int  $id
     * @return array
     *
     * @throws \Illuminate\Database\Eloquent\ModelNotFoundException
     */
    public function getById(int $id): array
    {
        $merchant = Merchant::findOrFail($id);

        return fractal($merchant, new MerchantTransformer())->toArray();
    }

    /**
     * Store a new merchant.
     *
     * @param  array  $attrs
     * @return array
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(array $attrs): array
    {
        $merchant = new Merchant($attrs);
        if (!$merchant->isValidFor('CREATE')) {
            throw new ValidationException($merchant->validator());
        }

        $merchant['full_address'] = $this->setFullAddress($attrs);
        $merchant->save();

        return fractal($merchant, new MerchantTransformer())->toArray();
    }

    /**
     * Update a merchant by ID.
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
        $merchant = Merchant::findOrFail($id);
        $merchant->fill($attrs);

        if (!$merchant->isValidFor('UPDATE')) {
            throw new ValidationException($merchant->validator());
        }

        if ($merchant->city_id != $attrs["city_id"]) {
            $merchant['full_address'] = $this->setFullAddress($attrs);
        }

        $merchant->save();

        return fractal($merchant, new MerchantTransformer())->toArray();
    }

    /**
     * Delete a merchant by ID.
     *
     * @param  int  $id
     * @return bool
     *
     * @throws \Illuminate\Database\Eloquent\ModelNotFoundException
     */
    public function deleteById(int $id): bool
    {
        $merchant = Merchant::findOrFail($id);

        return (bool) $merchant->delete();
    }

    private function setFullAddress(array $attrs): string
    {
        $locationRepo = new LocationRepository();
        $code = $attrs['province_id'] . "." . str_pad($attrs['city_id'], 2, "0", STR_PAD_LEFT);
        $location = $locationRepo->getByCode($code)["data"];
        return $attrs['address'] . ", " . $location["city_name"] . ", " . $location["province_name"];
    }
}
