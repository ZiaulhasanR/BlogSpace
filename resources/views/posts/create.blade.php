@extends('layouts.app')

@section('title', 'Create Post')
<link href="https://cdn.quilljs.com/1.3.6/quill.snow.css" rel="stylesheet">
@section('content')
    <div class="max-w-3xl mx-auto mt-10 bg-white p-6 shadow-lg rounded-lg">
        <h2 class="text-2xl font-semibold mb-5">Create a New Post</h2>

        @if ($errors->any())
            <div class="bg-red-100 text-red-700 p-3 rounded mb-4">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('posts.store') }}" method="POST" enctype="multipart/form-data">
            @csrf

            <!-- Title -->
            <div class="mb-4">
                <label class="block text-gray-700 font-medium">Title</label>
                <input type="text" name="title" value="{{ old('title') }}"
                    class="w-full border-2 border-gray-300 rounded-lg p-2 focus:border-blue-500 focus:ring-blue-500"
                    required>
            </div>

            <!-- Category Selection -->
            <div x-data="{ open: false }" class="relative mb-4">
                <button @click="open = !open" type="button"
                    class="inline-flex items-center px-4 py-1 bg-cyan-800 text-white rounded-lg focus:outline-none">
                    Select Category
                </button>
                <div x-show="open" @click.outside="open = false"
                    class="absolute left-0 mt-2 w-56 bg-white border rounded-lg shadow-lg z-10">
                    <div class="p-4">
                        @foreach ($categories as $category)
                            <label class="block mb-2">
                                <input type="checkbox" name="category_id[]" value="{{ $category->id }}" class="mr-2"
                                    {{ in_array($category->id, old('category_id', [])) ? 'checked' : '' }}>
                                {{ $category->name }}
                            </label>
                        @endforeach
                    </div>
                </div>
            </div>

            <!-- Content -->
            <div class="mb-4">
                <label class="block text-gray-700 font-medium">Content</label>
                <div id="quill-editor" class="border-2 border-gray-300 rounded-lg p-2 bg-white"></div>
                <input type="hidden" name="content" id="content">
            </div>

            <!-- Image Upload -->
            <div class="mb-4">
                <label class="block text-gray-700 font-medium">Upload Image</label>
                <input type="file" name="image"
                    class="w-full border-2 border-gray-300 rounded-lg p-2 focus:border-blue-500 focus:ring-blue-500">
            </div>

            <!-- Submit Button -->
            <button type="submit"
                class="w-full bg-blue-600 text-white py-2 rounded-lg hover:bg-blue-700 font-semibold">Create Post</button>
        </form>
    </div>

    <!-- Include Quill script -->
    <script src="https://cdn.quilljs.com/1.3.6/quill.js"></script>
    <script>
        const toolbarOptions = [
            ['bold', 'italic', 'underline', 'strike'],
            ['blockquote', 'code-block'],
            ['link', 'image', 'video', 'formula'],
            [{
                'header': 1
            }, {
                'header': 2
            }],
            [{
                'list': 'ordered'
            }, {
                'list': 'bullet'
            }, {
                'list': 'check'
            }],
            [{
                'script': 'sub'
            }, {
                'script': 'super'
            }],
            [{
                'indent': '-1'
            }, {
                'indent': '+1'
            }],
            [{
                'direction': 'rtl'
            }],
            [{
                'size': ['small', false, 'large', 'huge']
            }],
            [{
                'header': [1, 2, 3, 4, 5, 6, false]
            }],
            [{
                'color': []
            }, {
                'background': []
            }],
            [{
                'font': []
            }],
            [{
                'align': []
            }],
            ['clean']
        ];

        const quill = new Quill('#quill-editor', {
            theme: 'snow',
            placeholder: 'Write your post content here...',
            modules: {
                toolbar: toolbarOptions
            }
        });

        quill.on('text-change', (delta, oldDelta, source) => {
            console.log(quill.root.innerHTML.trim());
            document.querySelector('#content').value = quill.root.innerHTML;
        });

        
    </script>

@endsection
