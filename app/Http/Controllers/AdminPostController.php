<?php
namespace App\Http\Controllers;
use Illuminate\Support\Facades\Auth;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class AdminPostController extends Controller
{
    public function index()
    {
        // Fetch all posts from the database
        $posts = Post::all();

        // Return the admin post index view with posts data
        return view('admin.posts.index', compact('posts'));
    }

    public function create()
    {
        // Return the create post view
        return view('admin.posts.create');
    }

    public function store(Request $request)
    {
        // Validate the incoming request
        $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048', // Optional image validation
        ]);

        // Handle the image upload
        $imagePath = $request->hasFile('image') ? $request->file('image')->store('posts', 'public') : null;

        // Create the new post
        $post = new Post();
        $post->title = $request->title;
        $post->content = $request->content;
        $post->image = $imagePath;
        $post->user_id = Auth::id(); // Assuming the logged-in user is the author
        $post->save();

        // Redirect back to the posts index page
        return redirect()->route('admin.posts.index')->with('success', 'Post created successfully!');
    }

    public function edit(Post $post)
    {
        // Return the edit view for the specific post
        return view('admin.posts.edit', compact('post'));
    }

    public function update(Request $request, Post $post)
    {
        // Validate the incoming request
        $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048', // Optional image validation
        ]);

        // Update the post fields
        $post->title = $request->title;
        $post->content = $request->content;

        // Handle image upload if a new image is provided
        if ($request->hasFile('image')) {
            // Delete the old image if it exists
            if (Storage::exists('public/' . $post->image)) {
                Storage::delete('public/' . $post->image);
            }

            // Store the new image
            $imagePath = $request->file('image')->store('posts', 'public');
            $post->image = $imagePath;
        }

        // Save the updated post
        $post->save();

        // Redirect to the posts index page with a success message
        return redirect()->route('admin.posts.index')->with('success', 'Post updated successfully!');
    }

    public function destroy(Post $post)
    {
        // Delete the post from the database
        if (Storage::exists('public/' . $post->image)) {
            Storage::delete('public/' . $post->image); // Delete the associated image
        }

        $post->delete();

        // Return a success response
        return response()->json(['success' => true]);
    }
}
