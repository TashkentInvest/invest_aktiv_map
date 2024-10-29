<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Kz;


class KzController extends Controller
{

    public function index()
    {
        $kzs = Kz::get()->all();
        return view('pages.coefficient.kz.index', compact('kzs'));
    }

    public function add()
    {
        return view('pages.coefficient.kz.add');
    }

    public function create(Request $request)
    {
        $kz = new Kz();
        $kz->name = $request->get('name');
        $kz->coefficient = $request->get('coefficient');
        $kz->save();
        return redirect()->route('kjIndex');
    }

    public function edit($id)
    {
        $kz = Kz::where('id', $id)->get()->first();
        return view('pages.coefficient.kz.edit', compact('kz'));
    }

    public function update(Request $request, $id)
    {
        $kz = Kz::find($id);
        $kz->name = $request->get('name');
        $kz->coefficient = $request->get('coefficient');
        $kz->save();
        return redirect()->route('kjIndex');
    }

    public function destroy($id)
    {
        $kz = Kz::find($id);
        $kz->delete();
        message_set("Region deleted !",'success',1);
        return redirect()->back();
    }
}


