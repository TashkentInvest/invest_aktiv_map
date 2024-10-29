<?php

namespace App\Http\Controllers;

use App\Models\SubyektShakli;

// use GuzzleHttp\Psr7\Request;
use Illuminate\Http\Request;



class SubyektShakliController extends Controller
{
    public function index()
    {
        $subyektShakli = SubyektShakli::get();
        return view('pages.subyekt_shakli.index', compact('subyektShakli'));
    }    
    public function add()   
    { 
        $subyektShakli = SubyektShakli::get()->all();
        return view('pages.subyekt_shakli.add', compact('subyektShakli'));
    }

    public function create(Request $request)
    {
        $subyektShakli = SubyektShakli::create();
        $subyektShakli->name = $request->get('name');
        $subyektShakli->name_ru = $request->get('name_ru');
        $subyektShakli->description = $request->get('description');
        $subyektShakli->description_ru = $request->get('description_ru');
        $subyektShakli->code = $request->get('code');
        $subyektShakli->save();
        // Redirect to the index route
        return redirect()->route('subyektShakliIndex');
    }
    public function edit($id)
    {
        $subyektShakli = SubyektShakli::get()->where('id', $id)->first();
        return view('pages.subyekt_shakli.edit',compact('subyektShakli'));
    }

    public function update(Request $request, $id)
    {
        $subyektShakli = SubyektShakli::find($id);
        $subyektShakli->name = $request->get('name');
        $subyektShakli->name_ru = $request->get('name_ru');
        $subyektShakli->description = $request->get('description');
        $subyektShakli->description_ru = $request->get('description_ru');
        $subyektShakli->code = $request->get('code');
        $subyektShakli->save();
        return redirect()->route('subyektShakliIndex');
    }

    public function destroy($id)
    {
        $subyektShakli = SubyektShakli::find($id);
        $subyektShakli->delete();
        message_set("SubyektShakli deleted !",'success',1);
        return redirect()->back();
    }
}
