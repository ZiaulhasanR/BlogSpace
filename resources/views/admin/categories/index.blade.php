@extends('layouts.app')

@section('title', 'Manage Categories')

@section('content')
<div class="container px-10 pt-3">
    <div class="flex justify-between">
        <h2 class="text-2xl font-bold mb-4">Manage Categories</h2>
        <a href="{{route('admin.categories.create')}}" class="pl-4">
            <button class="create-category bg-blue-500 text-white px-3 py-1 rounded hover:bg-blue-700">Create New Category</button>
        </a>

    </div>

    <table class="w-full border mt-4">
        <thead>
            <tr>
                <th class="px-4 py-2">Name</th>
                <th class="px-4 py-2">Description</th>

            </tr>
        </thead>
        <tbody>
            @foreach ($categories as $category)
                <tr id="post-{{ $category->id }}">
                    <td class="px-4 py-2 pl-10">{{ $category->name }}</td>
                    <td class="px-4 py-2">{!! Str::limit(strip_tags($category->description), 50) !!}</td>

                    {{-- <td class="px-4 py-2">{{ $post->user->name }}</td> --}}
                    <td class="px-4 py-2">
                        <a href="{{ route('admin.categories.edit', $category->id) }}" class="text-blue-600"><button class="bg-orange-500 ml-2 hover:bg-orange-700 px-3 py-1 text-white rounded">Edit</button></a>
                        <button class="delete-category bg-red-500 ml-2 hover:bg-red-700 px-3 py-1 rounded text-white" data-post-id="{{ $category->id }}">Delete</button>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
    <a href="{{ route('admin.home') }}" class="flex justify-end">
        <button class="bg-cyan-500 ml-2 my-4 hover:bg-cyan-700 px-3 py-2 rounded text-white"><i class="fas fa-arrow-right"></i>Back to Admin Panel</button>
    </a>
</div>

<script>
document.addEventListener("DOMContentLoaded", function() {
    document.querySelectorAll('.delete-category').forEach(button => {
        button.addEventListener('click', function() {
            let categoryId = this.getAttribute('data-post-id');
            let csrfToken = '{{ csrf_token() }}';

            fetch(`/admin/categories/${categoryId}`, {
                method: 'DELETE',
                headers: {
                    "X-CSRF-TOKEN": csrfToken,
                    "Content-Type": "application/json"
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    document.getElementById(`post-${categoryId}`).remove();
                }
            });
        });
    });
});
</script>
@endsection
