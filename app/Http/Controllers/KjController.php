<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Kj;


class KjController extends Controller
{

    public function index()
    {
        $kjs = Kj::get()->all();
        return view('pages.coefficient.kj.index', compact('kjs'));
    }

    public function add()
    {
        return view('pages.coefficient.kj.add');
    }

    public function create(Request $request)
    {
        $kj = new Kj();
        $kj->name = $request->get('name');
        $kj->coefficient = $request->get('coefficient');
        $kj->save();
        return redirect()->route('kjIndex');
    }

    public function edit($id)
    {
        $kj = Kj::where('id', $id)->get()->first();
        return view('pages.coefficient.kj.edit', compact('kj'));
    }

    public function update(Request $request, $id)
    {
        $kj = Kj::find($id);
        $kj->name = $request->get('name');
        $kj->coefficient = $request->get('coefficient');
        $kj->save();
        return redirect()->route('kjIndex');
    }

    public function destroy($id)
    {
        $kj = Kj::find($id);
        $kj->delete();
        message_set("Region deleted !",'success',1);
        return redirect()->back();
    }
}


