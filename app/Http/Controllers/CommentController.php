<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use App\Rules\PostExistsRule;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;

class CommentController extends Controller {
    public function store(Request $request) {
        $request->validate([
            "comment" => "string",
            "post_id" => [new PostExistsRule()]
        ]);
        $comment = new Comment();
        $comment->post_id = $request['post_id'];
        $comment->user_id = Auth::id();
        $comment->comment = $request['comment'];
        $comment->save();
        return redirect()->back();
    }

    public function destroy(Comment $comment) {
        if (Gate::allows("comment_owner", $comment)) {
            $comment->delete();
            return back()->with("message", "Comment Deleted");
        }
        return back()->with("message", "Cannot delete the message");
    }
}
