<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CommentController extends Controller
{
    /**
     * Store a new comment.
     */
    public function store(Request $request, $postId)
    {
        $request->validate([
            'body' => 'required|string',
        ]);

        $comment = new Comment();
        $comment->body = $request->body;
        $comment->user_id = Auth::id();
        $comment->post_id = $postId;
        $comment->save();

        return response()->json([
            'success' => true,
            'comment' => [
                'body' => $comment->body,
                'user' => ['name' => Auth::user()->name],
                'created_at' => $comment->created_at->diffForHumans(),
            ]
        ]);
    }


    /**
     * Fetch all comments for a post.
     */
    public function fetch(Post $post)
    {
        $comments = $post->comments()->with('user')->latest()->get();

        return response()->json([
            'success' => true,
            'comments' => $comments->map(function ($comment) {
                return [
                    'id' => $comment->id,
                    'body' => $comment->body,
                    'user' => $comment->user->name,
                    'created_at' => $comment->created_at->diffForHumans(),
                ];
            })
        ]);
    }

    /**
     * Update an existing comment.
     */
    public function update(Request $request, Comment $comment)
    {
        if (Auth::id() !== $comment->user_id) {
            return response()->json(['success' => false, 'message' => 'Unauthorized'], 403);
        }

        $request->validate([
            'body' => 'required|string|max:500',
        ]);

        $comment->update(['body' => $request->body]);

        return response()->json([
            'success' => true,
            'message' => 'Comment updated successfully!',
            'comment' => [
                'id' => $comment->id,
                'body' => $comment->body,
            ]
        ]);
    }

    /**
     * Delete a comment.
     */
    public function destroy($id)
    {
        $comment = Comment::find($id);

        

        if (Auth::id() === $comment->user_id || Auth::id() === $comment->post->user_id) {
            $comment->delete();
            return response()->json(['success' => true]);
        }

        return response()->json(['success' => false, 'message' => 'Unauthorized.'], 403);
    }
}
