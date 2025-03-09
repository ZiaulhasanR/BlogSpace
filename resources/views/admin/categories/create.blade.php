@extends('layouts.app')

@section('title', 'Create Category')
@section('content')
    <div class="max-w-3xl mx-auto mt-10 bg-white p-6 shadow-lg rounded-lg">
        <h2 class="text-2xl font-semibold mb-5">Create a New Category</h2>

        @if ($errors->any())
            <div class="bg-red-100 text-red-700 p-3 rounded mb-4">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('admin.categories.store') }}" method="POST" enctype="multipart/form-data">
            @csrf

            <!-- Title -->
            <div class="mb-4">
                <label class="block text-gray-700 font-medium">Name</label>
                <input type="text" name="name" value="{{ old('name') }}"
                    class="w-full border-2 border-gray-300 rounded-lg p-2 focus:border-blue-500 focus:ring-blue-500"
                    required>
            </div>

            <div class="mb-4">
                <label class="block text-gray-700 font-medium">Description</label>
                <input type="text" name="description" value="{{ old('description') }}"
                    class="w-full border-2 border-gray-300 rounded-lg p-2 focus:border-blue-500 focus:ring-blue-500"
                    required>
            </div>




            <!-- Submit Button -->
            <button type="submit"
                class="w-full bg-blue-600 text-white py-2 rounded-lg hover:bg-blue-700 font-semibold">Create Category</button>
        </form>
    </div>



@endsection
