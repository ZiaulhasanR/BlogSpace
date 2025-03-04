@extends('layouts.app')

@section('title', 'Login')

@section('content')
<div class="flex justify-center items-center min-h-screen bg-gray-100">
    <div class="bg-white p-8 rounded-lg shadow-lg max-w-md w-full">
        <h2 class="text-2xl font-bold text-center text-gray-700 mb-6">Login to Your Account</h2>

        @if (session('error'))
            <div class="bg-red-100 text-red-700 p-2 rounded mb-4">
                {{ session('error') }}
            </div>
        @endif

        <form action="{{route("login.submit")}}" method="POST">
            @csrf

            <!-- Email Input -->
            <div class="mb-4">
                <label for="email" class="block text-gray-600">Email Address</label>
                <input type="email" id="email" name="email" required
                    class="w-full p-2 border rounded mt-1 focus:outline-none focus:ring-2 focus:ring-blue-500">
            </div>

            <!-- Password Input -->
            <div class="mb-4">
                <label for="password" class="block text-gray-600">Password</label>
                <input type="password" id="password" name="password" required
                    class="w-full p-2 border rounded mt-1 focus:outline-none focus:ring-2 focus:ring-blue-500">
            </div>

            <!-- Remember Me -->
            <div class="flex items-center justify-between mb-4">
                <label class="flex items-center">
                    <input type="checkbox" name="remember" class="mr-2">
                    <span class="text-gray-600">Remember me</span>
                </label>
                <a href="#" class="text-blue-500 hover:underline">Forgot Password?</a>
            </div>

            <!-- Login Button -->
            <button type="submit"
                class="w-full bg-blue-600 text-white py-2 rounded-lg hover:bg-blue-700 transition-all">
                Login
            </button>
        </form>

        <!-- Register Link -->
        <p class="mt-4 text-center text-gray-600">
            Don't have an account?
            <a href="{{route("register")}}" class="text-blue-500 hover:underline">Sign up</a>
        </p>
    </div>
</div>
@endsection
