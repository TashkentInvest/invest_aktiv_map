<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderAtkaz;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $orders = Order::with(['client', 'branch'])
        ->orderBy('created_at','desc')
        ->paginate(10);

        return view('pages.orders.index', compact('orders'));
    }


    public function show($id)
    {
        $orderAtkaz = OrderAtkaz::get()->all();
        $item = Order::with([
            'branch.client',
            'branch.street',
            'branch.ruxsatnoma',
            'branch.loyihaHajmiMalumotnoma',
            'branch.loyihaHujjatlari',
            'orderAtkaz'
        ])->findOrFail($id);

        return view('pages.orders.show', compact('item', 'orderAtkaz'));
    }

    public function arxiv()
    {
        $orders = Order::all();

        return view('pages.orders.history', compact('orders'));
    }


    public function approve($id)
    {
        $item = Order::findOrFail($id);
        $item->user_id = Auth::id();
        $item->status = 1;

        $item->order_atkaz_id = null;

        $item->save();

        $item->update([
            'action' => 'updated',
            'action_timestamp' => now(),
        ]);

        return redirect()->route('orders.index')->with('success', 'Order approved successfully!');
    }

    public function reject(Request $request, $id)
    {
        $item = Order::findOrFail($id);

        $item->user_id = Auth::id();
        $item->status = 2;
        $item->order_atkaz_id = $request->input('order_atkaz_id');

        if ($request->filled('comment')) {
            $item->comment = $request->input('comment');
        }

        $item->save();

        $item->update([
            'action' => 'updated',
            'action_timestamp' => now(),
        ]);


        return redirect()->route('orders.index')->with('success', 'Order rejected and soft-deleted successfully!');
    }


    public function update(Request $request, Order $order)
    {
        //
    }


    public function destroy(Order $order)
    {
        //
    }
}
