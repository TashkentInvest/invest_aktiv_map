<?php

namespace App\Http\Controllers;

use App\Models\Message;
use Illuminate\Http\Request;

class ChatController extends Controller
{
    public function index()
    {
        $messages = Message::with('user')->orderBy('created_at', 'asc')->get();
        return view('pages.construction.chat.index', compact('messages'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'message' => 'required|string|max:255',
        ]);

        $message = new Message();
        $message->user_id = auth()->id();
        $message->message = $request->message;
        $message->save();

        return redirect()->back();
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'message' => 'required|string|max:255',
        ]);

        $message = Message::findOrFail($id);
        if ($message->user_id !== auth()->id()) {
            return redirect()->back()->with('error', 'You can only edit your own messages.');
        }

        $message->message = $request->message;
        $message->save();

        return redirect()->back();
    }

    public function destroy($id)
    {
        $message = Message::findOrFail($id);
        if ($message->user_id !== auth()->id()) {
            return redirect()->back()->with('error', 'You can only delete your own messages.');
        }

        $message->delete();

        return redirect()->back();
    }
}
