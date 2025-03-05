@extends('layouts.app')

@section('title', 'Edit Post')
<link href="https://cdn.quilljs.com/1.3.6/quill.snow.css" rel="stylesheet">

@section('content')
    <div class="container px-44">
        <h2 class="text-2xl font-bold mb-4">Edit Post</h2>

        <form action="{{ route('posts.update', $post->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <!-- Title -->
            <div class="mb-4">
                <label for="title" class="block text-sm font-medium">Title</label>
                <input type="text" id="title" name="title" value="{{ old('title', $post->title) }}"
                    class="mt-1 block w-full p-2 border border-gray-300 rounded" required>
                @error('title')
                    <span class="text-red-500 text-xs">{{ $message }}</span>
                @enderror
            </div>

            <!-- Content -->
            <div class="mb-4">
                <label for="content" class="block text-sm font-medium">Content</label>
                <!-- Quill Editor Container -->
                <div id="quill-editor" class="mt-1 block w-full p-2 border border-gray-300 rounded"
                     style="min-height: 200px;">{!! old('content', $post->content) !!}</div>
                <!-- Hidden Input to Store Quill Content -->
                <input type="hidden" name="content" id="content" value="{{ old('content', $post->content) }}">
                @error('content')
                    <span class="text-red-500 text-xs">{{ $message }}</span>
                @enderror
            </div>

            <!-- Image Upload -->
            <div class="mb-4">
                <label for="image" class="block text-sm font-medium">Post Image (Optional)</label>
                <input type="file" id="image" name="image"
                    class="mt-1 block w-full p-2 border border-gray-300 rounded">
                @error('image')
                    <span class="text-red-500 text-xs">{{ $message }}</span>
                @enderror
            </div>

            <!-- Display Current Image -->
            @if ($post->image)
                <div class="mb-4">
                    <label class="block text-sm font-medium">Current Image</label>
                    <img src="{{ asset('storage/' . $post->image) }}" alt="Current Image"
                        class="w-32 h-32 object-cover mt-2">
                </div>
            @endif

            <!-- Submit Button -->
            <div class="mt-4">
                <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded">Update Post</button>
            </div>
        </form>
    </div>

    <!-- Include Quill JS -->
    <script src="https://cdn.quilljs.com/1.3.6/quill.js"></script>
    <script>
        // Initialize Quill editor
        var quill = new Quill('#quill-editor', {
            theme: 'snow',
            placeholder: 'Write your post content here...',
            modules: {
                toolbar: [
                    ['bold', 'italic', 'underline', 'strike'],
                    ['blockquote', 'code-block'],
                    [{ 'header': 1 }, { 'header': 2 }],
                    [{ 'list': 'ordered' }, { 'list': 'bullet' }],
                    [{ 'script': 'sub' }, { 'script': 'super' }],
                    [{ 'indent': '-1' }, { 'indent': '+1' }],
                    [{ 'direction': 'rtl' }],
                    [{ 'size': ['small', false, 'large', 'huge'] }],
                    [{ 'header': [1, 2, 3, 4, 5, 6, false] }],
                    [{ 'color': [] }, { 'background': [] }],
                    [{ 'font': [] }],
                    [{ 'align': [] }],
                    ['link', 'image', 'video'],
                    ['clean']
                ]
            }
        });

        // Set initial content
        const initialContent = {!! json_encode(old('content', $post->content)) !!};
        quill.root.innerHTML = initialContent;

        // Synchronize hidden input with Quill content
        quill.on('text-change', function() {
            document.getElementById('content').value = quill.root.innerHTML;
        });

        // Ensure content is updated on form submit
        document.querySelector('form').addEventListener('submit', function() {
            document.getElementById('content').value = quill.root.innerHTML;
        });
    </script>
@endsection
