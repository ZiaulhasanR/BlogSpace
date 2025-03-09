<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'BlogSpace')</title>
    @vite('resources/css/app.css')
    <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
</head>

<body class="bg-gray-100">

    <div class="flex">
        @auth
            @if (Auth::user()->role === 'admin')
                <!-- Sidebar -->
                <aside class="w-64 bg-blue-900 text-white h-screen p-5 fixed left-0 top-20">
                    <h2 class="text-2xl font-bold text-center mb-6">Admin Panel</h2>
                    <nav class="flex flex-col space-y-4">
                        <a href="{{ route('users.index') }}" class="px-4 py-2 bg-blue-700 hover:bg-blue-600 rounded flex">
                            <svg xmlns="http://www.w3.org/2000/svg" width="18" height="20" class="mr-1"
                                viewBox="0 0 512 512"><!-- Icon from Subway Icon Set by Mariusz Ostrowski - https://creativecommons.org/licenses/by/4.0/ -->
                                <path fill="currentColor"
                                    d="m448 362.7l-117.3-21.3C320 320 320 310.7 320 298.7c10.7-10.7 32-21.3 32-32c10.7-32 10.7-53.3 10.7-53.3c5.5-8 21.3-21.3 21.3-42.7s-21.3-42.7-21.3-53.3C362.7 32 319.2 0 256 0c-60.5 0-106.7 32-106.7 117.3c0 10.7-21.3 32-21.3 53.3s15.2 35.4 21.3 42.7c0 0 0 21.3 10.7 53.3c0 10.7 21.3 21.3 32 32c0 10.7 0 21.3-10.7 42.7L64 362.7C21.3 373.3 0 448 0 512h512c0-64-21.3-138.7-64-149.3" />
                            </svg> Users
                        </a>
                        <a href="{{ route('admin.posts.index') }}" class="px-4 py-2 bg-blue-700 hover:bg-blue-600 rounded flex">
                            <svg xmlns="http://www.w3.org/2000/svg" width="18" height="20" class="mr-1"
                                viewBox="0 0 32 32"><!-- Icon from Fluent Emoji High Contrast by Microsoft Corporation - https://github.com/microsoft/fluentui-emoji/blob/main/LICENSE -->
                                <path fill="currentColor"
                                    d="M4.08 5A3.08 3.08 0 0 0 1 8.08v17.935c0 .755.17 1.576.504 2.28a1 1 0 0 0 .073.176a4.78 4.78 0 0 0 4.498 2.531h17.927a3.03 3.03 0 0 0 2.887-2.15l3.957-11.82l.005-.016A3.085 3.085 0 0 0 28 13v-1c0-1.701-1.299-3-3-3h-8.167a1.1 1.1 0 0 1-.759-.318L13.626 6.19l-.008-.009A4.06 4.06 0 0 0 10.755 5zM26 13H10.886a4.68 4.68 0 0 0-4.404 3.102l-.003.008C4.62 21.439 3.583 24.273 3 25.768V8.08C3 7.484 3.484 7 4.08 7h6.675a2.06 2.06 0 0 1 1.449.596l2.448 2.492l.009.009a3.1 3.1 0 0 0 2.172.903H25c.596 0 1 .404 1 1zM4.445 28.657a3 3 0 0 1-.425-.292l.042-.061q.07-.111.132-.23c.082-.16.182-.38.31-.684c.507-1.21 1.569-4.043 3.862-10.618A2.68 2.68 0 0 1 10.886 15h17.025a1.087 1.087 0 0 1 1.036 1.406l-3.96 11.826l-.005.017l-.004.015a1.03 1.03 0 0 1-.984.738H6.045l-.065.002a2.8 2.8 0 0 1-1.535-.347" />
                            </svg>
                            Posts
                        </a>
                        <a href="{{ route('admin.categories.index') }}" class="flex items-center px-3 py-2 bg-blue-700 hover:bg-blue-600 rounded">
                            <svg class="w-6 h-6 mr-1" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M6 2h9l6 6v14H6V2zm9 1.5V9h5.5L15 3.5zM8 13h8v-2H8v2zm0 4h8v-2H8v2z"/>
                            </svg>
                            Category
                        </a>
                        <a href="{{route('admin.role-requests')}}" class="flex items-center px-3 py-2 bg-blue-700 hover:bg-blue-600 rounded">
                            <svg class="w-6 h-6 mr-1" fill="currentColor" viewBox="0 0 24 24">
                                <!-- SVG path data for the bell icon -->
                                <path d="M12 2C10.34 2 9 3.34 9 5V6.29C7.21 7.17 6 9.01 6 11V16L4 18V19H20V18L18 16V11C18 9.01 16.79 7.17 15 6.29V5C15 3.34 13.66 2 12 2ZM12 22C13.1 22 14 21.1 14 20H10C10 21.1 10.9 22 12 22Z"/>
                            </svg>
                            Notifications
                        </a>
                    </nav>
                </aside>
            @endif
        @endauth

    </div>
</body>

</html>
