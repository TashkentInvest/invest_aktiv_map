<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\RuxsatnomaBerilganIshTuri;


class RuxsatnomaBerilganIshTuriController extends Controller
{
    public function index()
    {
        $ruxsatnomaBerilganIshTurlari = RuxsatnomaBerilganIshTuri::get()->all();
        return view('pages.ruxsatnoma.ruxsatnoma_berilgan_ish_turi.index', compact('ruxsatnomaBerilganIshTurlari'));
    }

    public function add()
    {
        return view('pages.ruxsatnoma.ruxsatnoma_berilgan_ish_turi.add');
    }

    public function create(Request $request)
    {
        $ruxsatnomaBerilganIshTuri = new RuxsatnomaBerilganIshTuri();
        $ruxsatnomaBerilganIshTuri->name = $request->get('name');
        $ruxsatnomaBerilganIshTuri->comment = $request->get('comment');
        $ruxsatnomaBerilganIshTuri->save();
        return redirect()->route('ruxsatnomaBerilganIshTuriIndex');
    }

    public function edit($id)
    {
        $ruxsatnomaBerilganIshTuri = RuxsatnomaBerilganIshTuri::where('id', $id)->get()->first();
        return view('pages.ruxsatnoma.ruxsatnoma_berilgan_ish_turi.edit', compact('ruxsatnomaBerilganIshTuri'));
    }

    public function update(Request $request, $id)
    {
        $ruxsatnomaBerilganIshTuri = RuxsatnomaBerilganIshTuri::find($id);
        $ruxsatnomaBerilganIshTuri->name = $request->get('name');
        $ruxsatnomaBerilganIshTuri->comment = $request->get('comment');
        $ruxsatnomaBerilganIshTuri->save();
        return redirect()->route('ruxsatnomaBerilganIshTuriIndex');
    }

    public function destroy($id)
    {
        $ruxsatnomaBerilganIshTuri = RuxsatnomaBerilganIshTuri::find($id);
        $ruxsatnomaBerilganIshTuri->delete();
        message_set("Ruxsatnoma berilgan turi deleted !", 'success', 1);
        return redirect()->back();
    }
}
