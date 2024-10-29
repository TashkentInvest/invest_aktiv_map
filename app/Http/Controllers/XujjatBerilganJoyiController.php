<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\XujjatBerilganJoyi;


class XujjatBerilganJoyiController extends Controller
{

    public function index()
    {
        $xujjatBerilganJoylari = XujjatBerilganJoyi::get()->all();
        return view('pages.xujjat.berilganJoyi.index', compact('xujjatBerilganJoylari'));
    }

    public function add()
    {
        return view('pages.xujjat.berilganJoyi.add');
    }

    public function create(Request $request)
    {
        $xujjatBerilganJoyi = new XujjatBerilganJoyi();
        $xujjatBerilganJoyi->name = $request->get('name');
        $xujjatBerilganJoyi->comment = $request->get('comment');
        $xujjatBerilganJoyi->save();
        return redirect()->route('xujjatBerilganJoyiIndex');
    }

    public function edit($id)
    {
        $xujjatBerilganJoyi = XujjatBerilganJoyi::where('id', $id)->get()->first();
        return view('pages.xujjat.berilganJoyi.edit', compact('xujjatBerilganJoyi'));
    }

    public function update(Request $request, $id)
    {
        $xujjatBerilganJoyi = XujjatBerilganJoyi::find($id);
        $xujjatBerilganJoyi->name = $request->get('name');
        $xujjatBerilganJoyi->comment = $request->get('comment');
        $xujjatBerilganJoyi->save();
        return redirect()->route('xujjatBerilganJoyiIndex');
    }

    public function destroy($id)
    {
        $xujjatBerilganJoyi = XujjatBerilganJoyi::find($id);
        $xujjatBerilganJoyi->delete();
        message_set("Region deleted !",'success',1);
        return redirect()->back();
    }
}


