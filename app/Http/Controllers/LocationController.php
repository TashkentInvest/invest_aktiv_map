<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\District;
use App\Models\Street;
use App\Models\SubStreet;
use Illuminate\Support\Facades\Log;

class LocationController extends Controller
{
    // Get districts by region ID
    public function getDistricts(Request $request)
    {
        $regionId = $request->get('region_id');
        Log::info("Region ID received: $regionId");
        $districts = District::where('region_id', $regionId)->pluck('name_uz', 'id');
        return response()->json($districts);
    }

    // Get streets by district ID
    public function getStreets(Request $request)
    {
        $districtId = $request->get('district_id');
        Log::info("District ID received: $districtId");
        $streets = Street::where('district_id', $districtId)->pluck('name', 'id');
        return response()->json($streets);
    }

    // Get substreets by street ID
    public function getSubstreets(Request $request)
    {
        $streetId = $request->get('street_id');
        Log::info("Street ID received: $streetId");
        $substreets = SubStreet::where('street_id', $streetId)->pluck('name', 'id');
        return response()->json($substreets);
    }
}
