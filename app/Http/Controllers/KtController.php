<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Kt;


class KtController extends Controller
{

    public function index()
    {
        $kts = Kt::get()->all();
        return view('pages.coefficient.kt.index', compact('kts'));
    }

    public function add()
    {
        return view('pages.coefficient.kt.add');
    }

    public function create(Request $request)
    {
        $kt = new Kt();
        $kt->name = $request->get('name');
        $kt->coefficient = $request->get('coefficient');
        $kt->save();
        return redirect()->route('kjIndex');
    }

    public function edit($id)
    {
        $kt = Kt::where('id', $id)->get()->first();
        return view('pages.coefficient.kt.edit', compact('kt'));
    }

    public function update(Request $request, $id)
    {
        $kt = Kt::find($id);
        $kt->name = $request->get('name');
        $kt->coefficient = $request->get('coefficient');
        $kt->save();
        return redirect()->route('kjIndex');
    }

    public function destroy($id)
    {
        $kt = Kt::find($id);
        $kt->delete();
        message_set("Region deleted !",'success',1);
        return redirect()->back();
    }
}


