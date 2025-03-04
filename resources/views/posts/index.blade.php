@extends('layouts.app')

@section('title', 'View Posts')

@section('content')
<div class="container mx-auto py-10 flex">
    <aside class="w-1/4 bg-gray-100 p-4 rounded-lg shadow-lg h-screen sticky top-10 overflow-auto">
        <h2 class="text-xl font-semibold mb-4">Filter by Categories</h2>
        <form action="{{ route('posts.index') }}" method="GET">
            @foreach ($categories as $category)
                <div class="mb-2">
                    <input type="checkbox" name="categories[]" value="{{ $category->id }}"
                        {{ in_array($category->id, request('categories', [])) ? 'checked' : '' }}>
                    <label class="ml-2">{{ $category->name }}</label>
                </div>
            @endforeach
            <button type="submit" class="mt-4 bg-blue-500 text-white px-4 py-2 rounded">Apply Filters</button>
        </form>
    </aside>

    <div class="w-3/4 pl-6">
        <h1 class="text-4xl font-bold text-center mb-10">All Blog Posts</h1>
        <div class="grid grid-cols-1 px-10 container">
            @foreach ($posts as $post)
            <div class="bg-white rounded-lg shadow-md flex mb-6 overflow-hidden">
                @if ($post->image)
                    <div class="w-1/3">
                        <img src="{{ asset('storage/' . $post->image) }}" alt="Post Image" class="w-full h-full object-cover">
                    </div>
                @endif

                <div class="w-2/3 p-6">
                    <div class="flex items-center text-gray-500 text-sm mb-2">
                        <span class="mr-2">👤 {{ $post->user->name }}</span>
                        <span>📅 {{ $post->created_at->format('F d, Y') }}</span>
                    </div>
                    <p class="text-gray-600 mb-2">
                        @foreach ($post->categories as $category)
                            <span class="bg-blue-100 text-blue-600 px-2 py-1 rounded">{{ $category->name }}</span>
                        @endforeach
                    </p>

                    <h2 class="text-2xl font-bold text-green-700 mb-2 hover:underline">
                        <a href="{{ route('posts.show', $post->id) }}">{{ $post->title }}</a>
                    </h2>

                    <p class="text-gray-600 mb-4">{{ Str::limit($post->content, 100) }}</p>
                    <meta name="csrf-token" content="{{ csrf_token() }}">

                    @php
                        $liked = $post->likes->contains('user_id', auth()->id());
                    @endphp

                    <button class="like-btn mt-4 inline-block px-4 py-2 rounded" data-post-id="{{ $post->id }}">
                        👍 <span id="like-text-{{ $post->id }}">{{ $liked ? 'Liked' : 'Like' }}</span>
                        (<span id="like-count-{{ $post->id }}">{{ $post->likes->count() }}</span>)
                    </button>

                    <!-- Comment Count Button (Redirect to Post Page) -->
                    <a href="{{ route('posts.show', $post->id) }}" class="text-blue-500 mt-4 inline-block">
                        💬 {{ $post->comments->count() }} Comments
                    </a>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</div>
@endsection
