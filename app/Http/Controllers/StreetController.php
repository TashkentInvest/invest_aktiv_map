<?php

namespace App\Http\Controllers;

use App\Models\District;
use App\Models\Products;
use App\Models\Regions;
use App\Models\Street;
use Illuminate\Http\Request;

class StreetController extends Controller
{
    public function index()
    {
        $streets = Street::with('district')->get();
        return view('pages.streets.index', compact('streets'));
    }

    public function create_new(Request $request)
    {
        $request->validate([
            'district_id' => 'required|exists:districts,id',
            'street_name' => 'required|string|max:255',
        ]);

        $street = new Street();
        $street->district_id = $request->district_id;
        $street->name = $request->street_name;

        $street->save();

        return response()->json([
            'id' => $street->id,
            'name' => $street->name,
        ]);
    }


    public function getDistricts($district_id)
    {
        try {
            $districts = Street::where('district_id', $district_id)->get();
            return response()->json($districts);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Error fetching districts'], 500);
        }
    }



    public function getProductByStreet($street_id)
    {
        $product = Products::where('street_id', $street_id)->first();
        $street = Street::find($street_id);

        if ($product && $street) {
            // Fetch district data based on the district_id of the street
            $district = District::find($street->district_id);

            if ($district) {
                $response = [
                    'exists' => true,
                    'product' => $product,
                    'street' => $street,
                    'district' => $district // Include district data in the response
                ];
            } else {
                $response = [
                    'exists' => false,
                    'message' => 'District not found for the street.'
                ];
            }
        } else {
            $response = [
                'exists' => false,
                'message' => 'Product or street not found.'
            ];
        }

        return response()->json($response);
    }

    public function getStreets($district_id)
    {
        $streets = Street::where('district_id', $district_id)->get();
        return response()->json($streets);
    }

    public function add()
    {
        $districts = District::get()->all();
        return view('pages.streets.add', compact('districts'));
    }

    public function create(Request $request)
    {
        $street = new Street();
        $street->name = $request->get('name');
        $street->name_ru = $request->get('name_ru');
        $street->type = $request->get('type');
        $street->comment = $request->get('comment');
        $street->code = $request->get('code');
        $street->district_id = $request->get('district_id');
        $street->save();
        return redirect()->route('streetIndex');
    }

    public function edit($id)
    {
        $street = Street::findOrFail($id); // Adjust this query based on your needs
        $districts = District::all(); // Or use a more specific query if needed
        return view('pages.streets.edit', compact('districts', 'street'));
    }



    public function update(Request $request, $id)
    {
        $street = Street::find($id);
        $street->name = $request->get('name');
        $street->name_ru = $request->get('name_ru');
        $street->type = $request->get('type');
        $street->comment = $request->get('comment');
        $street->code = $request->get('code');
        $street->district_id = $request->get('district_id');
        $street->save();
        return redirect()->route('streetIndex');
    }

    public function destroy($id)
    {
        $street = Street::find($id);
        $street->delete();
        message_set("District deleted !",'success',1);
        return redirect()->back();
    }
}
