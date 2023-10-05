<?php

namespace App\Http\Controllers;

use App\Repository\LocationRepository;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class LocationController extends Controller
{
    /**
     * Controller constructor.
     *
     * @param  \App\Repository\LocationRepository  $location
     */
    public function __construct(LocationRepository $location)
    {
        $this->location = $location;
    }

    /**
     * Get all the locations.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(Request $request): JsonResponse
    {
        $locations = $this->location->getAll($request);

        return response()->json($locations, Response::HTTP_OK);
    }
}
