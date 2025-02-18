<?php

namespace App\Http\Controllers\Blade;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Regions;
use App\Models\District;

class RegionController extends Controller
{
    public function index()
    {
        $regions = Regions::get()->all();
        return view('pages.regions.index', compact('regions'));
    }

    public function add()
    {
        return view('pages.regions.add');
    }

    public function create(Request $request)
    {
        $region = new Regions();
        $region->name_uz = $request->get('name_uz');
        $region->name_ru = $request->get('name_ru');
        $region->save();
        return redirect()->route('regionIndex');
    }

    public function edit($id)
    {
        $region = Regions::where('id', $id)->get()->first();
        return view('pages.regions.edit', compact('region'));
    }

    public function update(Request $request, $id)
    {
        $region = Regions::find($id);
        $region->name_uz = $request->get('name_uz');
        $region->name_ru = $request->get('name_ru');
        $region->save();
        return redirect()->route('districtIndex');
    }

    public function destroy($id)
    {
        $region = Regions::find($id);
        $region->delete();
        message_set("Region deleted !",'success',1);
        return redirect()->back();
    }
}
