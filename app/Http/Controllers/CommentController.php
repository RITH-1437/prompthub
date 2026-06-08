<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use App\Models\Prompt;
use Illuminate\Http\Request;

class CommentController extends Controller
{
    public function store(Request $request, Prompt $prompt)
    {
        $request->validate([
            'content' => 'required|max:1000',
        ]);

        $prompt->comments()->create([
            'user_id' => auth()->id(),
            'content' => $request->content,
        ]);

        return back()->with(
            'success',
            'Comment added.'
        );
    }

    public function destroy(Prompt $prompt, Comment $comment)
    {
        if ($comment->prompt_id !== $prompt->id) {
            abort(404);
        }

        $userId = auth()->id();

        if ($userId !== $comment->user_id && $userId !== $prompt->user_id) {
            abort(403);
        }

        $comment->delete();

        return back()->with(
            'success',
            'Comment deleted.'
        );
    }
}
