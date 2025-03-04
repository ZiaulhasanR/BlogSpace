<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    @vite('resources/css/app.css')
</head>
<body>
    <div class="bg-blue-600">
        <h1 class="pt-32 text-white text-8xl text-center font-bold">Create a blog <br> worth sharing</h1>
        <p class="text-center text-white pt-5 text-2xl">Get a full suite of intuitive design features and powerful marketing tools <br> to create a unique blog that leaves a lasting impression.</p>
        <div class="justify-center flex py-10">
            <a href="{{ Auth::check() ? route('posts.create') : route('login') }}">
                <button class="bg-white text-black rounded-4xl py-4 px-6 text-center text-xl font-semibold">
                    Start Blogging
                </button>
            </a>
        </div>

        <div class="flex justify-center">
            <img class="text-center" src="https://static.wixstatic.com/media/0784b1_7c171ccfee9c478982bfa6208247a648~mv2.jpg/v1/fill/w_1395,h_796,al_t,q_85,usm_0.66_1.00_0.01,enc_avif,quality_auto/0784b1_7c171ccfee9c478982bfa6208247a648~mv2.jpg" alt="">

        </div>


    </div>


</body>
</html>
