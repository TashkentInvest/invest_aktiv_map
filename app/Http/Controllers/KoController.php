<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Ko;


class KoController extends Controller
{

    public function index()
    {
        $kos = Ko::get()->all();
        return view('pages.coefficient.ko.index', compact('kos'));
    }

    public function add()
    {
        return view('pages.coefficient.ko.add');
    }

    public function create(Request $request)
    {
        $ko = new Ko();
        $ko->name = $request->get('name');
        $ko->coefficient = $request->get('coefficient');
        $ko->save();
        return redirect()->route('kjIndex');
    }

    public function edit($id)
    {
        $ko = Ko::where('id', $id)->get()->first();
        return view('pages.coefficient.ko.edit', compact('ko'));
    }

    public function update(Request $request, $id)
    {
        $ko = Ko::find($id);
        $ko->name = $request->get('name');
        $ko->coefficient = $request->get('coefficient');
        $ko->save();
        return redirect()->route('kjIndex');
    }

    public function destroy($id)
    {
        $ko = Ko::find($id);
        $ko->delete();
        message_set("Region deleted !",'success',1);
        return redirect()->back();
    }
}


