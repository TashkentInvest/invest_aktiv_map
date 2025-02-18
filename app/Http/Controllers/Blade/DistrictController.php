<?php

namespace App\Http\Controllers\Blade;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Regions;
use App\Models\District;
use App\Models\Street;

class DistrictController extends Controller
{
    public function index()
    {
        $districts = District::with('region')->get();
        return view('pages.districts.index', compact('districts'));
    }

    public function getDistricts($region_id)
    {
        try {
            $districts = District::where('region_id', $region_id)->get();
            return response()->json($districts);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Error fetching districts'], 500);
        }
    }

    public function getStreets($district_id)
    {
        $streets = Street::where('district_id', $district_id)->get();
        return response()->json($streets);
    }

    public function add()
    {
        $regions = Regions::get()->all();
        return view('pages.districts.add', compact('regions'));
    }

    public function create(Request $request)
    {
        $district = new District();
        $district->name_uz = $request->get('name_uz');
        $district->name_ru = $request->get('name_ru');
        $district->region_id = $request->get('region_id');
        $district->save();
        return redirect()->route('districtIndex');
    }

    public function edit($id)
    {
        $regions = Regions::get()->all();
        $district = District::where('id', $id)->get()->first();
        return view('pages.districts.edit', compact('district', 'regions'));
    }

    public function update(Request $request, $id)
    {
        $district = District::find($id);
        $district->name_uz = $request->get('name_uz');
        $district->name_ru = $request->get('name_ru');
        $district->region_id = $request->get('region_id');
        $district->save();
        return redirect()->route('districtIndex');
    }

    public function destroy($id)
    {
        $district = District::find($id);
        $district->delete();
        message_set("District deleted !",'success',1);
        return redirect()->back();
    }
}
