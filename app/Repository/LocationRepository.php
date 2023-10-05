<?php

namespace App\Repository;

use App\Models\Location;
use App\Transformers\LocationDetailTransformer;
use App\Transformers\LocationTransformer;
use Illuminate\Http\Request;

class LocationRepository
{
    /**
     * Get list of paginated locations.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function getAll(Request $request): array
    {
        $locations = Location::filter($request)->get();

        return fractal($locations, new LocationTransformer())->toArray();
    }

    /**
     * Get a location by code.
     *
     * @param  string  $code
     * @return array
     *
     * @throws \Illuminate\Database\Eloquent\ModelNotFoundException
     */
    public function getByCode(string $code): array
    {
        $location = Location::where("code", $code)->firstOrFail();

        return fractal($location, new LocationDetailTransformer())->toArray();
    }
}
