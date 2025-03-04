<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Post;
use App\Models\Comment;
use App\Models\Like;
use Illuminate\Support\Facades\Log;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PostController extends Controller
{
    /**
     * Show the form for creating a new post.
     */
    public function create()
    {
        Log::info('djuhiu');
        $categories = Category::all();
        return view('posts.create', compact('categories'));
    }

    /**
     * Store a newly created post in the database.
     */
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'category_id' => 'required|array',
            'category_id.*' => 'exists:categories,id',
            'content' => 'required|string',
            'image' => 'nullable|image|max:2048',
        ]);

        $imagePath = null;
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('post_images', 'public');
        }

        // Create a new post
        $post = Post::create([
            'title' => $request->title,
            'content' => $request->content,
            'image' => $imagePath,
            'user_id' => Auth::id(),
        ]);

        // Attach selected categories to the post
        $post->categories()->sync($request->category_id);

        return redirect()->route('posts.index')->with('success', 'Post created successfully!');
    }

    /**
     * Display a listing of the posts with category filter.
     */
    public function index(Request $request)
    {
        $categories = Category::all();
        $posts = Post::with(['categories', 'likes']); // Load likes to prevent null error

        // Apply category filtering if selected
        if ($request->has('categories') && !empty($request->categories)) {
            $posts->whereHas('categories', function ($query) use ($request) {
                $query->whereIn('categories.id', $request->categories);
            });
        }

        return view('posts.index', [
            'posts' => $posts->latest()->get(),
            'categories' => $categories
        ]);
    }

    /**
     * Display a single post.
     */
    public function show($id)
    {
        $post = Post::with(['user', 'categories', 'comments'])->findOrFail($id);
        return view('posts.show', compact('post'));
    }


    /**
     * Like or unlike a post.
     */
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
    public function storeComment(Request $request, $postId)
    {
        $request->validate([
            'body' => 'required|string|max:500',
        ]);

        $comment = new Comment([
            'body' => $request->body,
            'user_id' => Auth::id(),
            'post_id' => $postId,
        ]);
        $comment->save();

        return response()->json([
            'message' => 'Comment added successfully!',
            'comment' => $comment->load('user'),
        ]);
    }
}
