@extends('layouts.app')

@section('title', 'View Posts')

@section('content')
    <div class="container mx-auto py-10 flex">
        <aside class="w-1/4 bg-gray-100 p-4 rounded-lg shadow-lg h-screen sticky top-10 overflow-auto">
            <h2 class="text-xl font-semibold mb-4">Filter by Categories</h2>
            <form action="{{ route('posts.index') }}" method="GET" id="category-filter-form">
                <div class="mb-2">
                    <input type="checkbox" id="all-categories" name="all_categories" value="1"
                        {{ empty(request('categories')) ? 'checked' : '' }}>
                    <label class="ml-2" for="all-categories">All</label>
                </div>
                @foreach ($categories as $category)
                    <div class="mb-2">
                        <input type="checkbox" class="category-checkbox" name="categories[]" value="{{ $category->id }}"
                            {{ in_array($category->id, request('categories', [])) ? 'checked' : '' }}>
                        <label class="ml-2">{{ $category->name }}</label>
                    </div>
                @endforeach
                {{-- <button type="submit" class="mt-4 bg-blue-500 text-white px-4 py-2 rounded">Apply Filters</button> --}}
            </form>
        </aside>


        <div class="w-3/4 pl-6">
            <div class="flex ">
                <div>
                    <h1 class="text-4xl font-bold text-center mb-10">All Blog Posts</h1>
                </div>
                <div class="pl-[700px]">
                    @if (Auth::check())
                        @php $role = Auth::user()->role; @endphp
                        @if ($role === 'author' || $role === 'admin')
                            <a href="{{ route('posts.my') }}">
                                <button class="bg-cyan-600 text-white px-3 py-1 rounded-lg text-xl hover:bg-cyan-700">
                                    My Posts
                                </button>
                            </a>
                        @endif
                    @endif
                </div>

            </div>

            <div class="grid grid-cols-1 px-10 container">
                @foreach ($posts as $post)
                    <div class="bg-white rounded-lg shadow-md flex mb-6 overflow-hidden">
                        @if ($post->image)
                            <div class="w-1/3">
                                <img src="{{ asset('storage/' . $post->image) }}" alt="Post Image"
                                    class="w-full h-full object-cover">
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

                            <p class="text-gray-600 mb-4">{!! Str::limit(strip_tags($post->content), 100) !!}</p>

                            <button class="like-btn mt-4 inline-block px-4 py-2 rounded text-blue-500"
                                data-post-id="{{ $post->id }}">
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
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const allCategoriesCheckbox = document.getElementById('all-categories');
            console.log(allCategoriesCheckbox);
            const categoryCheckboxes = document.querySelectorAll('.category-checkbox');
            console.log(categoryCheckboxes);
            const form = document.getElementById('category-filter-form');
            console.log(form);

            // Function to update the state of the "All" checkbox
            function updateAllCheckboxState() {
                const anyCategoryChecked = Array.from(categoryCheckboxes).some(checkbox => checkbox.checked);
                allCategoriesCheckbox.checked = !anyCategoryChecked;
            }

            // Event listener for the "All" checkbox
            allCategoriesCheckbox.addEventListener('change', function() {
                if (this.checked) {
                    categoryCheckboxes.forEach(checkbox => {
                        checkbox.checked = false;
                    });
                }
                form.submit();
            });

            // Event listeners for individual category checkboxes
            categoryCheckboxes.forEach(checkbox => {
                checkbox.addEventListener('change', function() {
                    if (this.checked) {
                        allCategoriesCheckbox.checked = false;
                    } else {
                        updateAllCheckboxState();
                    }
                    form.submit();
                });
            });

            // Initialize the state of the "All" checkbox on page load
            updateAllCheckboxState();
        });
    </script>
@endsection
