@extends('layouts.app')

@section('title', 'Edit Category')

@section('content')
    <div class="container px-44">
        <h2 class="text-2xl font-bold mb-4">Edit Category</h2>

        <form action="{{ route('admin.categories.update', $category->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <!-- Title -->
            <div class="mb-4">
                <label for="name" class="block text-sm font-medium">Name</label>
                <input type="text" id="name" name="name" value="{{ old('name', $category->name) }}"
                    class="mt-1 block w-full p-2 border border-gray-300 rounded" required>
                @error('name')
                    <span class="text-red-500 text-xs">{{ $message }}</span>
                @enderror
            </div>

            <div class="mb-4">
                <label for="description" class="block text-sm font-medium">Description</label>
                <input type="text" id="description" name="description" value="{{ old('description', $category->description) }}"
                    class="mt-1 block w-full p-2 border border-gray-300 rounded" required>
                @error('description')
                    <span class="text-red-500 text-xs">{{ $message }}</span>
                @enderror
            </div>


            <!-- Submit Button -->
            <div class="mt-4">
                <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded">Update Category</button>
            </div>
        </form>
    </div>
@endsection
