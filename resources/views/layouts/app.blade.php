<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'eAlbum') }}</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body>

    @include('user.pages.extra.navbar')


    <main>
        @yield('content')

        @include('user.pages.second')

        @include('user.pages.third')

        @include('user.pages.fourth')

        @include('user.pages.fifth')

    </main>

    @include('user.pages.extra.footer')

</body>

</html>