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
                        <a href="{{ route('admin.posts.edit', $post->id) }}" class="text-blue-600">Edit</a>
                        <button class="delete-post text-red-500 ml-2" data-post-id="{{ $post->id }}">Delete</button>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
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
