<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Post;
use App\Models\Comment;
use App\Models\Like;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class PostController extends Controller
{
    /**
     * Show all posts, with optional category filtering.
     * This method is used for both home and posts index pages.
     */
    public function index(Request $request)
    {
        $categories = Category::all();
        $postsQuery = Post::with(['categories', 'likes', 'user']); // Load relationships to avoid multiple queries

        // Apply category filtering if selected
        if ($request->has('categories') && !empty($request->categories)) {
            $postsQuery->whereHas('categories', function ($query) use ($request) {
                $query->whereIn('categories.id', $request->categories);
            });
        }

        $posts = $postsQuery->latest()->get(); // Get posts ordered by latest

        // Determine which view to return based on the route
        if ($request->routeIs('home')) {
            return view('home', compact('posts', 'categories'));
        } else {
            return view('posts.index', compact('posts', 'categories'));
        }
    }

    /**
     * Show the form for creating a new post.
     */
    public function create()
    {
        Log::info('Create post page accessed.');
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

        // Handle image upload
        $imagePath = null;
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('post_images', 'public');
        }


        $post = Post::create([
            'title' => $request->title,
            'content' => $request->content,
            'image' => $imagePath,
            'user_id' => Auth::id(),
        ]);


        $post->categories()->sync($request->category_id);

        return redirect()->route('posts.index')->with('success', 'Post created successfully!');
    }

    /**
     * Display a single post.
     */
    public function show($id)
    {
        $post = Post::with(['user', 'categories', 'comments.user'])->findOrFail($id);
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

    /**
     * Store a new comment on a post.
     */
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
    public function myPosts()
    {
        $posts = Post::where('user_id', Auth::id())->latest()->get();
        $categories = Category::all();

        return view('posts.my-posts', compact('posts', 'categories'));
    }
}
