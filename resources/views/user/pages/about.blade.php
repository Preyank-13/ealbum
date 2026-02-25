<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>About Us - eAlbum</title>
    
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Roboto:wght@100;300;400;500&display=swap');
        .font-roboto { font-family: 'Roboto', sans-serif; }
    </style>
</head>
<body class="bg-white antialiased font-roboto">

    @include('user.pages.extra.navbar')

    <div class="relative w-full h-[450px] bg-[#1a1a1a] flex flex-col items-center justify-center text-center px-4 overflow-hidden">
        <div class="absolute inset-0 opacity-40">
            <img src="https://images.unsplash.com/photo-1542038784456-1ea8e935640e?q=80&w=2070" 
                 class="w-full h-full object-cover grayscale" alt="background">
        </div>
        <div class="relative z-10">
            <h1 class="text-white text-5xl md:text-6xl font-light tracking-wide mb-6">
                We, at <span class="font-normal">eAlbum</span>
            </h1>
            <p class="text-gray-300 text-lg md:text-xl max-w-4xl mx-auto leading-relaxed font-light">
                Bring you an innovative way to tell your album stories in a handiest and easily shareable way with ealbum.
            </p>
        </div>
    </div>

    <div class="max-w-6xl mx-auto px-6 py-20">
        <div class="space-y-12 text-center">
            <p class="text-[#555] text-lg md:text-xl leading-relaxed font-light">
                We, at eAlbum, bring you an innovative way to tell your album stories in a handiest and easily shareable way. It allows you to create albums in no time and get them in your mobile phone through our innovative and Intuitive application.
            </p>

            <p class="text-[#555] text-lg md:text-xl leading-relaxed font-light">
                <span class="text-blue-500 hover:underline cursor-pointer">eAlbum</span> gives you a chance to stand out in the market by giving a new concept to your customer.
            </p>

            <p class="text-[#555] text-lg md:text-xl leading-relaxed font-light italic bg-gray-50 p-6 rounded-lg">
                "We also have a sample demo video of our photo album software for your better understanding. Feel free to connect with us!"
            </p>

            <p class="text-[#555] text-lg md:text-xl leading-relaxed font-light">
                It's time to give your business a competitive edge! Download from 
                <span class="text-blue-500 underline cursor-pointer">Google Play Store</span> or 
                <span class="text-blue-500 underline cursor-pointer">App Store</span>.
            </p>
        </div>
    </div>

    @include('user.pages.extra.footer')

</body>
</html>