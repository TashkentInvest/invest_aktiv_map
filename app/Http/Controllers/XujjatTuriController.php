<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\XujjatTuri;


class XujjatTuriController extends Controller
{

    public function index()
    {
        $xujjatTurlari = XujjatTuri::get()->all();
        return view('pages.xujjat.xujjatTuri.index', compact('xujjatTurlari'));
    }

    public function add()
    {
        return view('pages.xujjat.xujjatTuri.add');
    }

    public function create(Request $request)
    {
        $xujjatTuri = new XujjatTuri();
        $xujjatTuri->name = $request->get('name');
        $xujjatTuri->comment = $request->get('comment');
        $xujjatTuri->save();
        return redirect()->route('xujjatTuriIndex');
    }

    public function edit($id)
    {
        $xujjatTuri = XujjatTuri::where('id', $id)->get()->first();
        return view('pages.xujjat.xujjatTuri.edit', compact('xujjatTuri'));
    }

    public function update(Request $request, $id)
    {
        $xujjatTuri = XujjatTuri::find($id);
        $xujjatTuri->name = $request->get('name');
        $xujjatTuri->comment = $request->get('comment');
        $xujjatTuri->save();
        return redirect()->route('xujjatTuriIndex');
    }

    public function destroy($id)
    {
        $xujjatTuri = XujjatTuri::find($id);
        $xujjatTuri->delete();
        message_set("Region deleted !",'success',1);
        return redirect()->back();
    }
}


