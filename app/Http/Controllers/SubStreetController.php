<?php

namespace App\Http\Controllers;

use App\Models\District;
use App\Models\Products;
use App\Models\Regions;
use App\Models\Street;
use App\Models\SubStreet;
use Illuminate\Http\Request;

class SubStreetController extends Controller
{
    public function index()
    {
        $substreets = SubStreet::join('districts', 'sub_streets.district_id', '=', 'districts.id')
                                ->orderBy('districts.name_uz', 'desc')
                                ->select('sub_streets.*')
                                ->paginate(15);

        return view('pages.substreets.index', compact('substreets'));
    }


    public function create_new(Request $request)
    {
        $subStreet = new SubStreet();
        $subStreet->district_id = $request->district_id;
        $subStreet->name = $request->sub_street_name;
        $subStreet->save();

        return response()->json([
            'id' => $subStreet->id,
            'name' => $subStreet->name
        ]);
    }


    public function getDistricts($district_id)
    {
        try {
            $streets = SubStreet::where('district_id', $district_id)->get();
            return response()->json($streets);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Error fetching streets'], 500);
        }
    }

    public function add()
    {
        $districts = District::get()->all();
        return view('pages.substreets.add', compact('districts'));
    }

    public function create(Request $request)
    {
        $substreet = new SubStreet();
        $substreet->name = $request->get('name');
        $substreet->name_ru = $request->get('name_ru');
        $substreet->type = $request->get('type');
        $substreet->comment = $request->get('comment');
        $substreet->code = $request->get('code');
        $substreet->district_id = $request->get('district_id');
        $substreet->save();

        return redirect()->route('substreetIndex');
    }

    public function edit($id)
    {
        $substreet = SubStreet::findOrFail($id);
        $districts = District::all();
        return view('pages.substreets.edit', compact('districts', 'substreet'));
    }



    public function update(Request $request, $id)
    {
        $substreet = SubStreet::find($id);
        $substreet->name = $request->get('name');
        $substreet->name_ru = $request->get('name_ru');
        $substreet->type = $request->get('type');
        $substreet->comment = $request->get('comment');
        $substreet->code = $request->get('code');
        $substreet->district_id = $request->get('district_id');
        $substreet->save();
        return redirect()->route('substreetIndex');
    }

    public function destroy($id)
    {
        $substreet = SubStreet::find($id);
        $substreet->delete();
        message_set("substreet deleted !",'success',1);
        return redirect()->back();
    }
}
