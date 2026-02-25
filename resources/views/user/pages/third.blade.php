<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Viewing Experience - eAlbum</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        /* Custom font for cleaner look */
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@300;400;600&display=swap');

        body {
            font-family: 'Inter', sans-serif;
        }
    </style>
</head>

<body class="antialiased">

    <section class="relative min-h-screen w-full flex items-center overflow-hidden bg-black">

        <div class="absolute inset-0 z-0">
            <img src="https://wallpapers.com/images/hd/hd-photography-of-camera-by-the-fallen-leaves-tcae37ar7goef06h.jpg"
                alt="Photography Background" class="w-full h-full object-cover opacity-60">

        </div>

        <div class="container mx-auto px-6 lg:px-24 z-10">

            <div
                class="rounded-lg bg-white p-2 md:p-20 max-w-2xl shadow-2xl transition-all duration-500 hover:shadow-blue-500/10">

                <h1 class="text-4xl md:text-5xl font-light text-gray-800 mb-8 tracking-tight">
                    Viewing <span class="font-normal">Experience!</span>
                </h1>

                <div class="space-y-6 text-gray-600 text-base md:text-lg leading-relaxed font-light">
                    <p>
                        Did the thought of having a digital album ever stunned you? Have you ever thought how wonderful
                        it would be to share your wedding album with your relatives across the globe? Well, this vision
                        has brought to life with <span class="text-blue-600 font-medium"><a href="{{ route('user.pages.welcome') }}">eAlbum</a></span> – your mobile
                        photo book.
                    </p>

                    <p>
                        Yes, you get that right! Just like a traditional album, with our <strong>FREE eBook</strong> you
                        can enjoy viewing every memory page by page. It's like a pocket album for you! Furthermore, you
                        can share it with your loved ones as per your convenience.
                    </p>
                </div>

                <div class="mt-8 w-16 h-1 bg-blue-500"></div>
            </div>

        </div>
    </section>

</body>

</html>