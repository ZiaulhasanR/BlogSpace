<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Post;
use App\Models\Like;
use Illuminate\Support\Facades\Auth;

class LikeController extends Controller
{
    public function toggleLike($postId)
{
    $user = Auth::user();
    $post = Post::findOrFail($postId);

    if (!$user) {
        return response()->json(['success' => false, 'message' => 'Unauthorized'], 403);
    }

    $like = $post->likes()->where('user_id', $user->id)->first();

    if ($like) {
        $like->delete();
        $liked = false;
    } else {
        $post->likes()->create(['user_id' => $user->id]);
        $liked = true;
    }

    return response()->json([
        'success' => true,
        'liked' => $liked,
        'likes_count' => $post->likes()->count()
    ]);
}

}
