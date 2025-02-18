<?php

namespace App\Http\Controllers;

use App\Models\Bank;
use App\Models\District;
use App\Models\Regions;
use App\Models\Street;
use App\Models\SubStreet;
use Illuminate\Http\Request;

class BankController extends Controller
{

    public function index()
    {
        $banks = Bank::with('substreet.district.region')->get();

        return view('pages.banks.index', compact('banks'));
    }


    public function create_new(Request $request)
    {
        $bank = new Bank();
        $bank->substreet_id = $request->substreet_id;
        $bank->name = $request->substreet_name;
        $bank->home_number = $request->home_number;
        $bank->apartment_number = $request->apartment_number;
        $bank->save();

        return response()->json([
            'id' => $bank->id,
            'name' => $bank->name
        ]);
    }


    public function add()
    {
        $regions = Regions::all();
        return view('pages.banks.add',compact('regions'));
    }

    public function create(Request $request)
    {
        $validatedData = $request->validate([
            'sub_street_id' => 'required|integer|exists:sub_streets,id',
        ]);
        // dd($request);
        $bank = new Bank();
        $bank->name = $request->get('name');
        $bank->comment = $request->get('comment');
        $bank->code = $request->get('code');
        $bank->sub_street_id = $request->get('sub_street_id');
        $bank->save();

        return redirect()->route('bankIndex');
    }

    public function edit($id)
    {
        $bank = Bank::with('substreet.district.region')->find($id);
        $regions = Regions::all();

        return view('pages.banks.edit', compact('bank', 'regions'));
    }

    public function update(Request $request, $id)
    {

        $validatedData = $request->validate([
            'sub_street_id' => 'required|integer|exists:sub_streets,id',
        ]);
        // dd($request);
        $bank = Bank::find($id);
        $bank->name = $request->get('name');
        $bank->comment = $request->get('comment');
        $bank->code = $request->get('code');
        $bank->sub_street_id = $request->get('sub_street_id');
        $bank->home_number = $request->home_number;
        $bank->apartment_number = $request->apartment_number;
        $bank->save();
        return redirect()->route('bankIndex');
    }

    public function destroy($id)
    {
        $bank = Bank::find($id);
        $bank->delete();
        message_set("bank deleted !",'success',1);
        return redirect()->back();
    }
}
