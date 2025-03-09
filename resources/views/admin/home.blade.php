@extends('layouts.app')
@extends('layouts.sidebar')

@section('title', 'Admin-Panel')

@section('content')
    <div class="container mx-auto my-10 grid grid-cols-2 items-center px-6 bg-blue-100">
        <div class="">
            {{-- <h1 class="text-4xl font-semibold text-center">Welcome to Admin Panel</h1> --}}


            {{-- <div class="flex flex-col justify-center items-center mt-10 gap-5">

                @if (Auth::check())
                    @php $role = Auth::user()->role; @endphp

                    <div class="flex flex-col justify-center items-center mt-10 gap-5">
                        @if ($role === 'admin')
                            <a href="{{ route('users.index') }}">
                                <button class="bg-blue-600 text-white px-6 py-3 rounded-lg text-xl hover:bg-blue-700">
                                    Users
                                </button>
                            </a>
                            <a href="{{ route('admin.posts.index') }}">
                                <button class="bg-blue-600 text-white px-14 py-3 rounded-lg text-xl hover:bg-blue-700">
                                    Posts
                                </button>
                            </a>
                            <a href="{{ route('admin.categories.index') }}">
                                <button class="bg-blue-600 text-white px-14 py-3 rounded-lg text-xl hover:bg-blue-700">
                                    Categories
                                </button>
                            </a>
                        @endif
                    </div>
                @endif
            </div> --}}

        </div>

        <div>
            <img src="https://static.wixstatic.com/media/0784b1_2c6c52c23fd94bd2ae5d02cc7f7f050f~mv2.jpg/v1/fill/w_735,h_721,al_c,q_85,usm_0.66_1.00_0.01,enc_avif,quality_auto/Artboard.jpg"
                class="h-[80vh] w-full" alt="">
        </div>

    </div>
@endsection
