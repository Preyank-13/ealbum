@extends('layouts.app')

<section class="relative h-screen w-full flex items-center justify-center overflow-hidden">
    <div class="absolute inset-0 z-0">
        <img src="https://images.unsplash.com/photo-1511795409834-ef04bbd61622?q=80&w=2069&auto=format&fit=crop" 
             alt="Wedding Background" 
             class="w-full h-full object-cover">
        <div class="absolute inset-0 bg-black/50 bg-gradient-to-r from-black/60 to-transparent"></div>
    </div>

    <div class="container mx-auto px-6 relative z-10 flex flex-col lg:flex-row items-center justify-between gap-12">
        
        <div class="text-white max-w-xl space-y-6">
            <h1 class="text-5xl lg:text-7xl font-bold leading-tight">
                Creating memories for <br> a lifetime
            </h1>
            <p class="text-xl text-gray-200">
                Start create eAlbum for free.
            </p>
            
            <div class="pt-4">
                <a href="{{ route('login') }}" class="bg-blue-600 hover:bg-blue-700 text-white font-semibold py-4 px-8 rounded-lg shadow-lg transition duration-300 uppercase text-sm tracking-wider">
                    Create eAlbum Account
                </a>
            </div>

            <div class="pt-8">
                <h2 class="text-3xl font-light text-gray-300">
                    Now you can view your album as VIDEO!
                </h2>
            </div>
        </div>

        <div class="w-full max-w-2xl">
            <div class="relative group shadow-2xl rounded-2xl overflow-hidden border-8 border-white/10">
                <div class="aspect-video">
                    <iframe 
                        class="w-full h-full" 
                        src="https://www.youtube.com/embed/dQw4w9WgXcQ" 
                        title="eAlbum Video" 
                        frameborder="0" 
                        allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" 
                        allowfullscreen>
                    </iframe>
                </div>
            </div>
        </div>

    </div>
</section>
