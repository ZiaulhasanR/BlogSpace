@extends('layouts.app')

@section('title', $post->title)

@section('content')
    <div class="container mx-auto py-10 px-6">
        <div class="max-w-3xl mx-auto bg-white shadow-lg rounded-lg p-6">
            <h1 class="text-4xl font-bold text-gray-800">{{ $post->title }}</h1>
            <p class="text-gray-500 text-sm mt-2">
                <strong>{{ $post->user->name }}</strong> | {{ $post->created_at->format('F j, Y') }}
            </p>

            <div class="mt-3">
                @foreach ($post->categories as $category)
                    <span class="bg-blue-100 text-blue-600 px-2 py-1 rounded">{{ $category->name }}</span>
                @endforeach
            </div>

            @if ($post->image)
                <img src="{{ asset('storage/' . $post->image) }}" alt="Post Image"
                    class="w-full h-96 object-cover rounded-lg my-4">
            @endif


            <div class="text-gray-800 text-lg leading-relaxed mt-4">
                {!! $post->content !!}
            </div><br>

            @auth
                @if (Auth::user()->id === $post->user_id)
                    <a href="{{ route('posts.edit', $post->id) }}">
                        <button class="bg-green-600 text-white px-3 py-1 rounded-lg text-xl hover:bg-green-700">
                            Edit Post
                        </button>
                    </a>
                    <form action="{{ route('posts.destroy', $post->id) }}" method="POST" class="inline">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="bg-red-600 text-white px-3 py-1 rounded-lg text-xl hover:bg-red-700">
                            Delete Post
                        </button>
                    </form>
                @endif
            @endauth

            <meta name="csrf-token" content="{{ csrf_token() }}">

            @php
                $liked = $post->likes->contains('user_id', auth()->id());
            @endphp

            <button class="like-btn bg-yellow-700 px-3 py-1 rounded-lg text-xl hover:bg-yellow-800" data-post-id="{{ $post->id }}">
                👍 <span id="like-text-{{ $post->id }}">{{ $liked ? 'Liked' : 'Like' }}</span>
                (<span id="like-count-{{ $post->id }}">{{ $post->likes->count() }}</span>)
            </button>

            <div class="mt-10">
                <h3 class="text-2xl font-semibold">Comments</h3>

                @auth
                    <form id="comment-form" class="mt-4">
                        @csrf
                        <input type="hidden" id="post_id" value="{{ $post->id }}">
                        <textarea id="comment-body" rows="3" class="w-full border rounded p-2" placeholder="Write a comment..."></textarea>
                        <button type="submit" class="mt-2 bg-blue-500 text-white px-4 py-2 rounded">Post Comment</button>
                    </form>
                @else
                    <p class="text-gray-600 mt-4">You must <a href="{{ route('login') }}" class="text-blue-600">log in</a> to comment.</p>
                @endauth

                <div id="comments-list" class="mt-6">
                    @foreach ($post->comments as $comment)
                        <div class="border-b py-4">
                            <p class="text-gray-800"><strong>{{ $comment->user->name }}</strong>: {{ $comment->body }}</p>
                            <p class="text-gray-500 text-sm">{{ $comment->created_at->diffForHumans() }}</p>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>

    <script>
        document.getElementById('comment-form').addEventListener('submit', function (event) {
            event.preventDefault();

            let post_id = document.getElementById('post_id').value;
            let body = document.getElementById('comment-body').value;
            let csrfToken = document.querySelector('input[name=_token]').value;

            fetch(`/comments/${post_id}`, {
                method: "POST",
                headers: {
                    "Content-Type": "application/json",
                    "X-CSRF-TOKEN": csrfToken
                },
                body: JSON.stringify({ body: body })
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    let commentList = document.getElementById('comments-list');
                    let newComment = document.createElement('div');
                    newComment.classList.add('border-b', 'py-4');
                    newComment.innerHTML = `
                        <p class="text-gray-800"><strong>${data.comment.user.name}</strong>: ${data.comment.body}</p>
                        <p class="text-gray-500 text-sm">${data.comment.created_at}</p>
                    `;
                    commentList.appendChild(newComment);

                    document.getElementById('comment-body').value = '';
                }
            })
            .catch(error => console.error("Error:", error));
        });
    </script>
@endsection
