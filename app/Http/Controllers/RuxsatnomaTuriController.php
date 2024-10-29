<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\RuxsatnomaTuri;


class RuxsatnomaTuriController extends Controller
{

    public function index()
    {
        $ruxsatnomaTurlari = RuxsatnomaTuri::get()->all();
        return view('pages.ruxsatnoma.ruxsatnoma_turi.index', compact('ruxsatnomaTurlari'));
    }

    public function add()
    {
        return view('pages.ruxsatnoma.ruxsatnoma_turi.add');
    }

    public function create(Request $request)
    {
        $ruxsatnomaTuri = new RuxsatnomaTuri();
        $ruxsatnomaTuri->name = $request->get('name');
        $ruxsatnomaTuri->comment = $request->get('comment');
        $ruxsatnomaTuri->save();
        return redirect()->route('ruxsatnomaTuriIndex');
    }

    public function edit($id)
    {
        $ruxsatnomaTuri = RuxsatnomaTuri::where('id', $id)->get()->first();
        return view('pages.ruxsatnoma.ruxsatnoma_turi.edit', compact('ruxsatnomaTuri'));
    }

    public function update(Request $request, $id)
    {
        $ruxsatnomaTuri = RuxsatnomaTuri::find($id);
        $ruxsatnomaTuri->name = $request->get('name');
        $ruxsatnomaTuri->comment = $request->get('comment');
        $ruxsatnomaTuri->save();
        return redirect()->route('ruxsatnomaTuriIndex');
    }

    public function destroy($id)
    {
        $ruxsatnomaTuri = RuxsatnomaTuri::find($id);
        $ruxsatnomaTuri->delete();
        message_set("Ruxsatnoma turi deleted !",'success',1);
        return redirect()->back();
    }
}


