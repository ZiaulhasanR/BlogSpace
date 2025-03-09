@extends('layouts.app')

@section('title', 'Manage Posts')

@section('content')
<div class="container px-10 pt-3">
    <h2 class="text-2xl font-bold mb-4">Manage Posts</h2>

    <table class="w-full border mt-4">
        <thead>
            <tr>
                <th class="px-4 py-2">Title</th>
                <th class="px-4 py-2">Content</th>
                <th class="px-4 py-2">Image</th>
                <th class="px-4 py-2">Author</th>
                <th class="px-4 py-2">Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($posts as $post)
                <tr id="post-{{ $post->id }}">
                    <td class="px-4 py-2 pl-10">{{ $post->title }}</td>
                    <td class="px-4 py-2">{!! Str::limit(strip_tags($post->content), 50) !!}</td>
                    <td class="px-4 py-2">
                        @if($post->image)
                            <img src="{{ asset('storage/' . $post->image) }}" alt="{{ $post->title }}" class="w-16 h-16 object-cover">
                        @else
                            No Image
                        @endif
                    </td>
                    <td class="px-4 py-2">{{ $post->user->name }}</td>
                    <td class="px-4 py-2">
                        <a href="{{ route('admin.posts.edit', $post->id) }}" class="text-blue-600"><button class="bg-orange-500 ml-2 hover:bg-orange-700 px-3 py-1 text-white rounded">Edit</button></a>
                        <button class="delete-post bg-red-500 ml-2 hover:bg-red-700 px-3 py-1 rounded text-white" data-post-id="{{ $post->id }}">Delete</button>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
    <a href="{{ route('admin.home') }}" class="flex justify-end">
        <button class="bg-cyan-500 ml-2 my-4 hover:bg-cyan-700 px-3 py-2 rounded text-white flex items-center">
            <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" class="mr-1" viewBox="0 0 512 512">
                <path fill="currentColor"
                    d="M8 256c0 137 111 248 248 248s248-111 248-248S393 8 256 8S8 119 8 256m448 0c0 110.5-89.5 200-200 200S56 366.5 56 256S145.5 56 256 56s200 89.5 200 200m-72-20v40c0 6.6-5.4 12-12 12H256v67c0 10.7-12.9 16-20.5 8.5l-99-99c-4.7-4.7-4.7-12.3 0-17l99-99c7.6-7.6 20.5-2.2 20.5 8.5v67h116c6.6 0 12 5.4 12 12" />
            </svg>
            Back to Admin Panel
        </button>
    </a>
</div>

<script>
document.addEventListener("DOMContentLoaded", function() {
    document.querySelectorAll('.delete-post').forEach(button => {
        button.addEventListener('click', function() {
            let postId = this.getAttribute('data-post-id');
            let csrfToken = '{{ csrf_token() }}';

            fetch(`/admin/posts/${postId}`, {
                method: 'DELETE',
                headers: {
                    "X-CSRF-TOKEN": csrfToken,
                    "Content-Type": "application/json"
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    document.getElementById(`post-${postId}`).remove();
                }
            });
        });
    });
});
</script>
@endsection
