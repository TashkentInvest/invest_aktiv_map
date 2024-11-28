<?php

namespace App\Http\Controllers;

use App\Models\Aktiv;
use App\Models\Comment;
use Illuminate\Http\Request;

class CommentController extends Controller
{
    public function store(Request $request, $aktivId)
    {
        $validated = $request->validate([
            'content' => 'required|string|max:1000',
        ]);

        $comment = Comment::create([
            'user_id' => auth()->id(),
            'aktiv_id' => $aktivId,
            'content' => $validated['content'],
        ]);

        return redirect()->back()->with('success', 'Comment added successfully!');
    }
}
