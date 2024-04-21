<?php

namespace App\Http\Api;

use App\Http\Controllers\Controller;
use App\Models\Location;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class LocationController extends Controller
{
    /**
     * Search for locations by city name.
     *
     * @api {get} /locations/search Locations Search
     * @apiName SearchLocations
     * @apiGroup Locations
     *
     * @apiParam {String} q Search query for city name.
     *
     */
    public function search(Request $request): JsonResponse
    {
        $query = $request->input('q');
        $results = Location::where('city_name', 'like', '%'.$query.'%')->get();

        return response()->json($results);
    }
}
