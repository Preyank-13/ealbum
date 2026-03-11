<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans text-gray-900 antialiased">
        {{-- 🟢 Ekdum clean background --}}
        <div class="min-h-screen flex flex-col sm:justify-center items-center pt-6 sm:pt-0 bg-[#f4f7fe]">
            
            {{-- 🔴 Logo section puri tarah hata diya gaya hai --}}

            {{-- ⚪ Professional White Card --}}
            <div class="w-full sm:max-w-md mt-6 px-8 py-10 bg-white shadow-[0_10px_40px_-15px_rgba(0,0,0,0.1)] overflow-hidden sm:rounded-3xl border border-gray-100">
                {{ $slot }}
            </div>

            {{-- Footer (Optional) --}}
            <div class="mt-8 text-center">
                <p class="text-xs text-gray-400 font-medium">&copy; {{ date('Y') }} AlivecreateWebSolutions All rights reserved.</p>
            </div>
        </div>
    </body>
</html>