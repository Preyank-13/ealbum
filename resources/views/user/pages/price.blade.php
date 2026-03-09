<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pricing - eAlbum</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Roboto:wght@100;300;400;500&display=swap');

        .font-roboto {
            font-family: 'Roboto', sans-serif;
        }
    </style>
</head>

<body class="bg-white antialiased font-roboto">

    @include('user.pages.extra.navbar')

    <main class="py-20 bg-[#C2C2C2]">
        <div class="container mx-auto px-6 lg:px-24">

            <div class="text-center mb-16">
                <h1 class="text-3xl md:text-4xl font-normal text-gray-800 mb-6">
                    Affordable eAlbum Pricing – Plans for Every Photographer & Occasion
                </h1>
                <p class="text-gray-500 text-lg max-w-5xl mx-auto leading-relaxed font-light">
                    Looking for an easy and affordable way to share memories? Our eAlbum pricing plans are designed for
                    photographers, studios, and individuals who want to deliver beautiful, QR code-based digital photo
                    albums. Whether it's a wedding, birthday, baby shower, or professional portfolio, eAlbum offers
                    flexible plans to match your needs.
                </p>
            </div>

            <div class="flex items-center justify-center max-w-6xl mx-auto mb-20">

                <div
                    class="bg-white border border-gray-100 shadow-sm rounded-lg overflow-hidden transition hover:shadow-md">
                    <div class="p-10 text-left">
                        <h3 class="text-2xl text-gray-400 font-light mb-4">Pay as you go</h3>
                        <div class="flex items-baseline mb-6">
                            <span class="text-4xl font-medium text-gray-800">Rs.100</span>
                            <span class="text-gray-500 ml-2 font-light text-2xl">/per ealbum</span>
                        </div>
                        <p class="text-gray-500 mb-10">Create Digital Photobook as per your need.</p>
                    </div>
                    <a href="{{ route('login') }}"
                        class="block w-full bg-[#5da0e3] hover:bg-blue-600 text-white text-center py-4 font-medium transition">
                        Start Creating Digital Photobook
                    </a>
                </div>

            </div>

            <div class="max-w-6xl mx-auto bg-gray-50 rounded-xl p-10 mb-20">
                <h2 class="text-xl text-gray-700 font-normal mb-8 uppercase tracking-wide">Why Choose eAlbum?</h2>
                <ul class="space-y-6">
                    <li class="flex items-start gap-4 text-gray-600 font-light">
                        <span class="text-blue-500 text-lg mt-1">📱</span>
                        <p><strong>QR Code-Based Sharing</strong> – Your clients simply scan and view their albums.</p>
                    </li>
                    <li class="flex items-start gap-4 text-gray-600 font-light">
                        <span class="text-blue-500 text-lg mt-1">🎞️</span>
                        <p><strong>Photo-to-Video Conversion</strong> – Turn memories into emotional stories.</p>
                    </li>
                    <li class="flex items-start gap-4 text-gray-600 font-light">
                        <span class="text-blue-500 text-lg mt-1">☁️</span>
                        <p><strong>Cloud Access Anywhere</strong> – Available 24/7 from mobile, tablet, or desktop.</p>
                    </li>
                    <li class="flex items-start gap-4 text-gray-600 font-light">
                        <span class="text-blue-500 text-lg mt-1">🎉</span>
                        <p><strong>Perfect for All Events</strong> – Weddings, baby shoots, birthdays, and more.</p>
                    </li>
                    <li class="flex items-start gap-4 text-gray-600 font-light">
                        <span class="text-blue-500 text-lg mt-1">🚀</span>
                        <p><strong>Fast Upload</strong> – Create in less than 1 minute.</p>
                    </li>
                </ul>
            </div>

            <div class="max-w-6xl mx-auto space-y-10 text-gray-600 font-light leading-relaxed">
                <h2 class="text-2xl text-gray-800 font-normal flex items-center gap-2">
                    <span class="text-blue-400">✚</span> Frequently Asked Questions
                </h2>

                <p>
                    At eAlbum.in, we offer affordable and flexible pricing for photographers, studios, and creative
                    professionals who want to deliver high-quality digital photo albums.
                </p>

                <p>
                    Our QR code based eAlbums are not only convenient and modern, but they also provide a premium
                    experience for clients. Whether you’re a wedding photographer looking for a quick and elegant way to
                    share wedding memories, or a baby photographer wanting to provide parents with a shareable digital
                    album, our plans are designed to meet your needs.
                </p>

                <p>
                    Each eAlbum comes with cloud access, mobile optimization, and optional video album conversion,
                    making it easy to turn static images into emotional stories. With eAlbum pricing plans starting at
                    just ₹10, you can scale your business, impress clients, and stay ahead of the digital trend. Our
                    platform is ideal for weddings, pre-weddings, baby shoots, birthdays, and even corporate portfolios.
                    Choose a digital photo album plan that works for you – simple, professional, and shareable, all
                    powered by CODNIX LLP and managed by <a href="#"
                        class="text-blue-500 hover:underline">SmartSelection.in</a>.
                </p>
            </div>

        </div>
    </main>

    @include('user.pages.extra.footer')

</body>

</html>