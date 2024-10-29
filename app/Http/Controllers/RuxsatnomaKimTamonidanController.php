<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\RuxsatnomaKimTamonidan;


class RuxsatnomaKimTamonidanController extends Controller
{  
    public function index()
    {
        $ruxsatnomaKimlarTamonidan = RuxsatnomaKimTamonidan::get()->all();
        return view('pages.ruxsatnoma.ruxsatnoma_kim_tamonidan.index', compact('ruxsatnomaKimlarTamonidan'));
    }

    public function add()
    {
        return view('pages.ruxsatnoma.ruxsatnoma_kim_tamonidan.add');
    }

    public function create(Request $request)
    {
        $ruxsatnomaKimTamonidan = new RuxsatnomaKimTamonidan();
        $ruxsatnomaKimTamonidan->name = $request->get('name');
        $ruxsatnomaKimTamonidan->comment = $request->get('comment');
        $ruxsatnomaKimTamonidan->save();
        return redirect()->route('ruxsatnomaKimTamonidanIndex');
    }

    public function edit($id)
    {
        $ruxsatnomaKimTamonidan = RuxsatnomaKimTamonidan::where('id', $id)->get()->first();
        return view('pages.ruxsatnoma.ruxsatnoma_kim_tamonidan.edit', compact('ruxsatnomaKimTamonidan'));
    }

    public function update(Request $request, $id)
    {
        $ruxsatnomaKimTamonidan = RuxsatnomaKimTamonidan::find($id);
        $ruxsatnomaKimTamonidan->name = $request->get('name');
        $ruxsatnomaKimTamonidan->comment = $request->get('comment');
        $ruxsatnomaKimTamonidan->save();
        return redirect()->route('ruxsatnomaKimTamonidanIndex');
    }

    public function destroy($id)
    {
        $ruxsatnomaKimTamonidan = RuxsatnomaKimTamonidan::find($id);
        $ruxsatnomaKimTamonidan->delete();
        message_set("Ruxsatnoma kim tamonidan deleted !",'success',1);
        return redirect()->back();
    }
}


