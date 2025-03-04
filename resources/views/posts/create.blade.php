@extends('layouts.app')

@section('title', 'Create Post')

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
            <input type="text" name="title" class="w-full border-2 border-gray-300 rounded-lg p-2 focus:border-blue-500 focus:ring-blue-500" required>
        </div>

        <!-- Category Dropdown -->
        {{-- <div class="mb-4">
            <label class="block text-gray-700 font-medium">Category</label>
            <div class="space-y-2">
                @foreach($categories as $category)
                    <div class="flex items-center">
                        <input type="checkbox" name="category_id[]" value="{{ $category->id }}"
                               {{ in_array($category->id, old('category_id', [])) ? 'checked' : '' }}
                               class="mr-2">
                        <label class="text-gray-700">{{ $category->name }}</label>
                    </div>
                @endforeach
            </div>
            <small class="text-gray-500">Hold Ctrl (Windows) / Cmd (Mac) to select multiple categories.</small>
        </div> --}}

        <div x-data="{ open: false }" class="relative">
            <!-- Button to toggle dropdown -->
            <button @click="open = !open" type="button" class="inline-flex items-center mt-4 px-4 py-1 bg-cyan-800 text-white rounded-lg focus:outline-none">
                Select Category
            </button>
            <!-- Dropdown Menu -->
            <div x-show="open" @click.outside="open = false" class="absolute left-0 mt-2 w-56 bg-white border rounded-lg shadow-lg z-10">
                <div class="p-4">
                    @foreach($categories as $category)
                        <label class="block mb-2">
                            <input type="checkbox" name="category_id[]" value="{{ $category->id }}" class="mr-2"> {{ $category->name }}
                        </label>
                    @endforeach
                </div>
            </div>
        </div>
        <!-- Content -->
        <div class="mb-4">
            <label class="block text-gray-700 font-medium">Content</label>
            <textarea name="content" rows="5" class="w-full border-2 border-gray-300 rounded-lg p-2 focus:border-blue-500 focus:ring-blue-500" required></textarea>
        </div>

        <!-- Image Upload -->
        <div class="mb-4">
            <label class="block  text-gray-700 font-medium">Upload Image</label>
            <input type="file" name="image" class="w-full border-2 border-gray-300 rounded-lg p-2 focus:border-blue-500 focus:ring-blue-500">
        </div>

        <!-- Submit Button -->
        <button type="submit" class="w-full bg-blue-600 text-white py-2 rounded-lg hover:bg-blue-700 font-semibold">Create Post</button>
    </form>
</div>
@endsection
