<!-- resources/views/layouts/app.blade.php -->
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'BlogSpace')</title>
    @vite('resources/css/app.css')
    <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
</head>

<body>

    <!-- Sticky Navbar -->
    <nav class="bg-white text-black p-5 flex justify-between items-center shadow-lg sticky top-0 z-50">
        <div class="text-4xl font-bold">
            <a href="{{ route('home') }}">BlogSpace</a>
        </div>
        <div>
            <ul class="flex space-x-6 font-semibold">
                <li><a href="{{ route('home') }}" class="hover:text-blue-500">Home</a></li>
                <li><a href="#" class="hover:text-blue-500">About</a></li>
                <li><a href="#" class="hover:text-blue-500">Blog</a></li>
                <li><a href="#" class="hover:text-blue-500">Contact</a></li>
            </ul>
        </div>
        <div class="flex space-x-4 relative">
            @auth
                <a href="{{ route('dashboard') }}">
                    <button
                        class="bg-green-500 px-4 py-2 rounded-lg font-semibold text-white hover:bg-green-600">Dashboard</button>
                </a>
                <!-- User Dropdown -->
                <div x-data="{ open: false }" class="relative">
                    <button @click="open = !open"
                        class="flex items-center space-x-2 bg-gray-200 px-4 py-2 rounded-lg font-semibold hover:bg-gray-300">
                        <span>{{ Auth::user()->name }}</span>
                        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd"
                                d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 011.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                                clip-rule="evenodd" />
                        </svg>
                    </button>

                    <!-- Dropdown Menu -->
                    <div x-show="open" @click.away="open = false"
                        class="absolute right-0 mt-2 w-40 bg-white border rounded-lg shadow-lg">
                        <a href="#" class="block px-4 py-2 text-gray-700 hover:bg-gray-200">Profile</a>
                        <form method="POST" action="{{ route('logout') }}" class="block">
                            @csrf
                            <button type="submit" class="w-full text-left px-4 py-2 text-gray-700 hover:bg-gray-200">
                                Logout
                            </button>
                        </form>
                    </div>
                </div>
            @else
                <!-- Login & Register Buttons -->
                <a href="{{ route('login') }}">
                    <button
                        class="bg-white text-blue-700 px-4 py-2 rounded-lg font-semibold hover:bg-gray-200">Login</button>
                </a>
                <a href="{{ route('register') }}">
                    <button class="bg-yellow-400 px-4 py-2 rounded-lg font-semibold hover:bg-yellow-500">Get
                        Started</button>
                </a>
            @endauth
        </div>
    </nav>

    <!-- Main Content -->
    <div class="container mx-auto mt-0">
        @yield('content')
    </div>

</body>

<script>
    document.addEventListener("DOMContentLoaded", function() {
        document.querySelectorAll('.like-btn').forEach(button => {
            button.addEventListener('click', function() {
                let postId = this.getAttribute('data-post-id');
                let csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute(
                    'content');

                fetch(`/posts/${postId}/like`, {
                        method: 'POST',
                        headers: {
                            'X-CSRF-TOKEN': csrfToken,
                            'Content-Type': 'application/json',
                            'Accept': 'application/json'
                        },
                        body: JSON.stringify({})
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            let likeCountSpan = document.getElementById(
                                `like-count-${postId}`);
                            let likeTextSpan = document.getElementById(
                                `like-text-${postId}`);

                            likeCountSpan.textContent = data.likes_count;
                            likeTextSpan.textContent = data.liked ? 'Liked' :
                            'Like';

                            if (data.liked) {
                                this.classList.add(
                                'text-red-500'); // Change color when liked
                            } else {
                                this.classList.remove(
                                'text-red-500'); // Revert color when unliked
                            }
                        }
                    })
                    .catch(error => console.error('Error:', error));
            });
        });
    });



</script>




</html>
