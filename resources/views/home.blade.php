@extends('layouts.app')

@section('title', 'Home - BlogSpace')

@section('content')
    <div class="bg-blue-600">
        <h1 class="pt-32 text-white text-8xl text-center font-bold">Create a blog <br> worth sharing</h1>
        <p class="text-center text-white pt-5 text-2xl">
            Get a full suite of intuitive design features and powerful marketing tools <br>
            to create a unique blog that leaves a lasting impression.
        </p>
        <div class="justify-center flex py-10">
            <button class="bg-white text-black rounded-3xl py-4 px-6 text-center text-xl font-semibold">
                Start Blogging
            </button>
        </div>
        <div class="flex justify-center">
            <img class="text-center" src="https://static.wixstatic.com/media/0784b1_7c171ccfee9c478982bfa6208247a648~mv2.jpg/v1/fill/w_1395,h_796,al_t,q_85,usm_0.66_1.00_0.01,enc_avif,quality_auto/0784b1_7c171ccfee9c478982bfa6208247a648~mv2.jpg" width="1100px" alt="">
        </div>
    </div>
@endsection
