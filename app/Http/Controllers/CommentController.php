<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use App\Models\User;
use App\Notifications\CommentAddedNotification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CommentController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'project_id' => 'required|exists:projects,id',
            'comment' => 'required|string|max:1000',
        ]);

        $comment = Comment::create([
            'project_id' => $request->project_id,
            'user_id' => Auth::id(),
            'comment' => $request->comment,
        ]);

        // notify admin + assigned staff
        $project = $comment->project;
        $recipients = collect([
            $project->assignedUser,
            User::where('role', 'admin')->first(),
        ])->filter();

        foreach ($recipients as $recipient) {
            $recipient->notify(new CommentAddedNotification($comment));
        }

        return back()->with('success', 'Comment added successfully!');
    }

    public function destroy(Comment $comment)
    {
        if ($comment->user_id !== Auth::id()) {
            abort(403, 'Unauthorized');
        }

        $comment->delete();

        return back()->with('success', 'Comment deleted.');
    }
}