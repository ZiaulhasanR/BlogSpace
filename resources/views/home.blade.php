@extends('layouts.app')

@section('title', 'Home - BlogSpace')

@section('content')
    <div class="bg-blue-600">
        <h1 class="pt-32 text-white text-8xl text-center font-bold">Create a blog <br> worth sharing</h1>
        <p class="text-center text-white pt-5 text-2xl">
            Get a full suite of intuitive design features and powerful marketing tools <br>
            to create a unique blog that leaves a lasting impression.
        </p>
        <div class="justify-center flex py-10">
            <a href="{{ route('dashboard') }}">
            <button class="bg-white text-black rounded-3xl py-4 px-6 text-center text-xl font-semibold">
                Start Blogging
            </button>
        </a>
        </div>
        <div class="flex justify-center">
            <img class="text-center" src="https://static.wixstatic.com/media/0784b1_7c171ccfee9c478982bfa6208247a648~mv2.jpg/v1/fill/w_1395,h_796,al_t,q_85,usm_0.66_1.00_0.01,enc_avif,quality_auto/0784b1_7c171ccfee9c478982bfa6208247a648~mv2.jpg" width="1100px" alt="">
        </div>
    </div>


    <div id="blog-section" class="px-40 pt-10 bg-blue-300">
        <h1 class="text-3xl text-center py-8 font-bold text-blue-700">Blog Posts</h1>

        {{-- <h1 class="text-4xl font-bold text-center mb-10">All Blog Posts</h1> --}}
        <div class="grid grid-cols-1 px-10 container  itme-center">
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

                    <p class="text-gray-600 mb-4">{!! Str::limit(strip_tags($post->content), 200) !!}</p>

                    <button class="like-btn mt-4 inline-block px-4 py-2 rounded text-blue-500" data-post-id="{{ $post->id }}">
                        👍(<span id="like-count-{{ $post->id }}">{{ $post->likes->count() }}</span>)
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
