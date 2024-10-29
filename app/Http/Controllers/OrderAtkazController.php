<?php

namespace App\Http\Controllers;

use App\Models\orderAtkaz;

use Illuminate\Http\Request;

class OrderAtkazController extends Controller
{
    
    public function index()
    {
        $orderAtkaz  = OrderAtkaz::get()->all();

        return view('pages.orders.atkaz.index', compact('orderAtkaz'));
    }
    

    public function add()   
    { 
        return view('pages.orders.atkaz.add');
    }

    public function create(Request $request)
    {
        $orderAtkaz = new OrderAtkaz();
        $orderAtkaz->name = $request->get('name');
        $orderAtkaz->name_ru = $request->get('name_ru');
        $orderAtkaz->comment = $request->get('comment');
        $orderAtkaz->status = $request->get('status');
        $orderAtkaz->save();
        
        return redirect()->route('orderAtkazIndex');
    }

    public function edit($id)
    {
        $orderAtkaz = OrderAtkaz::find($id);
        
        return view('pages.orders.atkaz.edit', compact('orderAtkaz'));
    }
    
    public function update(Request $request, $id)
    {
        $orderAtkaz = OrderAtkaz::find($id);
        $orderAtkaz->name = $request->get('name');
        $orderAtkaz->name_ru = $request->get('name_ru');
        $orderAtkaz->comment = $request->get('comment');
        $orderAtkaz->status = $request->get('status');
    
        $orderAtkaz->save();
        return redirect()->route('orderAtkazIndex');
    }

    public function destroy($id)
    {
        $orderAtkaz = OrderAtkaz::find($id);
        $orderAtkaz->delete();
        message_set("orderAtkaz deleted !",'success',1);
        return redirect()->back();
    }
}
