@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
    <div class="container mx-auto my-10 grid grid-cols-2 items-center px-6 bg-blue-100">
        <div class="">
            <h1 class="text-4xl font-semibold text-center">Welcome to your Dashboard</h1>


            <div class="flex flex-col justify-center items-center mt-10 gap-5">

                @if (Auth::check())
                    @php $role = Auth::user()->role; @endphp

                    <div class="flex flex-col justify-center items-center mt-10 gap-5">


                        <a href="{{ route('posts.index') }}">
                            <button class="bg-blue-600 text-white px-14 py-3 rounded-lg text-xl hover:bg-blue-700">
                                View Post
                            </button>
                        </a>


                        @if ($role === 'author' || $role === 'admin')
                            <a href="{{ route('create.post') }}">
                                <button class="bg-blue-600 text-white px-6 py-3 rounded-lg text-xl hover:bg-blue-700">
                                    Create New Post
                                </button>
                            </a>
                        @endif
                        @if (Auth::user()->role === 'user' && !Auth::user()->roleRequests()->where('status', 'pending')->exists())
                            <form action="{{ route('request.upgrade') }}" method="POST">
                                @csrf
                                <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
                                    Request to Become an Author
                                </button>
                            </form>
                        @elseif (Auth::user()->roleRequests()->where('status', 'pending')->exists())
                            <p class="text-yellow-500 font-semibold">Your request is pending approval.</p>
                        @endif



                        @if ($role === 'admin')
                            <a href="{{ route('admin.home') }}">
                                <button class="bg-blue-600 text-white px-14 py-3 rounded-lg text-xl hover:bg-blue-700">
                                    Admin Panel
                                </button>
                            </a>
                        @endif
                    </div>
                @endif
            </div>

        </div>

        <div>
            <img src="https://static.wixstatic.com/media/0784b1_6e875de35784442e8cefe8a574bb28f7~mv2.jpg/v1/fill/w_1313,h_625,al_c,q_85,usm_0.66_1.00_0.01,enc_avif,quality_auto/Cover%20%20Copy%2010.jpg"
                class="h-[80vh]" alt="">
        </div>

    </div>
@endsection
