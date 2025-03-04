@extends('layouts.app')

@section('title', 'Edit Post')

@section('content')
<div class="container">
    <h2 class="text-2xl font-bold mb-4">Edit Post</h2>

    <form action="{{ route('admin.posts.update', $post->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div class="mb-4">
            <label for="title" class="block text-sm font-medium">Title</label>
            <input type="text" id="title" name="title" value="{{ old('title', $post->title) }}" class="mt-1 block w-full p-2 border border-gray-300 rounded" required>
            @error('title')
                <span class="text-red-500 text-xs">{{ $message }}</span>
            @enderror
        </div>

        <div class="mb-4">
            <label for="content" class="block text-sm font-medium">Content</label>
            <textarea id="content" name="content" rows="4" class="mt-1 block w-full p-2 border border-gray-300 rounded" required>{{ old('content', $post->content) }}</textarea>
            @error('content')
                <span class="text-red-500 text-xs">{{ $message }}</span>
            @enderror
        </div>

        <div class="mb-4">
            <label for="image" class="block text-sm font-medium">Post Image (Optional)</label>
            <input type="file" id="image" name="image" class="mt-1 block w-full p-2 border border-gray-300 rounded">
            @error('image')
                <span class="text-red-500 text-xs">{{ $message }}</span>
            @enderror
        </div>

        @if($post->image)
            <div class="mb-4">
                <label class="block text-sm font-medium">Current Image</label>
                <img src="{{ asset('storage/' . $post->image) }}" alt="Current Image" class="w-32 h-32 object-cover mt-2">
            </div>
        @endif

        <div class="mt-4">
            <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded">Update Post</button>
        </div>
    </form>
</div>
@endsection
