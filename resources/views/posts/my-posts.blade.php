@extends('layouts.app')

@section('title', 'My Posts')

@section('content')
    <div class="container mx-auto py-10">
        <h1 class="text-4xl font-bold text-center mb-10">My Blog Posts</h1>

        <div class="grid grid-cols-1 px-10 container">
            @if ($posts->count() > 0)
                @foreach ($posts as $post)
                    <div class="bg-white rounded-lg shadow-md flex mb-6 overflow-hidden">
                        @if ($post->image)
                            <div class="w-1/3">
                                <img src="{{ asset('storage/' . $post->image) }}" alt="Post Image" class="w-full h-full object-cover">
                            </div>
                        @endif

                        <div class="w-2/3 p-6">
                            <div class="flex items-center text-gray-500 text-sm mb-2">
                                <span class="mr-2">📅 {{ $post->created_at->format('F d, Y') }}</span>
                            </div>

                            <h2 class="text-2xl font-bold text-green-700 mb-2 hover:underline">
                                <a href="{{ route('posts.show', $post->id) }}">{{ $post->title }}</a>
                            </h2>

                            <p class="text-gray-600 mb-4">{!! Str::limit(strip_tags($post->content), 100) !!}</p>

                            <button class="like-btn mt-4 inline-block px-4 py-2 rounded text-blue-500"
                                data-post-id="{{ $post->id }}">
                                👍(<span id="like-count-{{ $post->id }}">{{ $post->likes->count() }}</span>)
                            </button>

                            <a href="{{ route('posts.show', $post->id) }}" class="text-blue-500 mt-4 inline-block">
                                💬 {{ $post->comments->count() }} Comments
                            </a>
                        </div>
                    </div>
                @endforeach
            @else
                <p class="text-center text-gray-600">You haven't posted anything yet.</p>
            @endif
        </div>
    </div>
@endsection
