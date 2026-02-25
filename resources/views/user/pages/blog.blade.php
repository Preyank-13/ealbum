<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Blogs - eAlbum</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Roboto:wght@100;300;400;500&display=swap');
        .font-roboto { font-family: 'Roboto', sans-serif; }
        
        /* Category Dropdown Hidden by Default */
        #category-menu { display: none; z-index: 50; }
    </style>
</head>
<body class="bg-gray-50 antialiased font-roboto">

    @include('user.pages.extra.navbar')

    <main class="py-16 bg-[#C2C2C2]">
        <div class="container mx-auto px-6 lg:px-24">
            
            <div class="flex items-center gap-4 mb-12 relative">
                <span class="text-balck-500">Category:</span>
                <div id="category-trigger" class="relative inline-block border border-gray-200 bg-white px-6 py-2 rounded cursor-pointer text-blue-500 font-medium min-w-[180px]">
                    All Categories <span class="float-right text-gray-400">▼</span>
                    
                    <div id="category-menu" class="absolute left-0 top-full mt-1 w-full bg-white border border-gray-100 shadow-xl rounded py-2">
                        <a href="#" class="block px-4 py-2 text-sm text-gray-600 hover:bg-blue-50 hover:text-blue-500">Alive Prints</a>
                        <a href="#" class="block px-4 py-2 text-sm text-gray-600 hover:bg-blue-50 hover:text-blue-500">eAlbum</a>
                        <a href="#" class="block px-4 py-2 text-sm text-gray-600 hover:bg-blue-50 hover:text-blue-500">Marketing</a>
                        <a href="#" class="block px-4 py-2 text-sm text-gray-600 hover:bg-blue-50 hover:text-blue-500">Photography</a>
                        <a href="#" class="block px-4 py-2 text-sm text-gray-600 hover:bg-blue-50 hover:text-blue-500">Uncategorized</a>
                    </div>
                </div>
            </div>

            <div class="flex flex-col lg:flex-row gap-12">
                
                <div class="lg:w-2/3 grid grid-cols-1 md:grid-cols-2 gap-8">
                    
                    <div class="bg-white border border-gray-100 rounded-lg overflow-hidden transition-all hover:shadow-lg group">
                        <div class="p-8">
                            <p class="text-xs text-gray-400 mb-2 uppercase tracking-widest">May 14, 2021</p>
                            <h3 class="text-xl font-normal text-gray-800 mb-6 group-hover:text-blue-500 transition">
                                Relive the Memories like Never before with the Advanced Photobook App
                            </h3>
                            <a href="#" class="text-blue-500 font-medium text-sm hover:underline">Read More</a>
                        </div>
                    </div>

                    <div class="bg-white border border-gray-100 rounded-lg overflow-hidden transition-all hover:shadow-lg group">
                        <div class="p-8">
                            <p class="text-xs text-gray-400 mb-2 uppercase tracking-widest">May 14, 2021</p>
                            <h3 class="text-xl font-normal text-gray-800 mb-6 group-hover:text-blue-500 transition">
                                Experience Digitalization through the eAlbum App
                            </h3>
                            <a href="#" class="text-blue-500 font-medium text-sm hover:underline">Read More</a>
                        </div>
                    </div>

                    <div class="bg-white border border-gray-100 rounded-lg overflow-hidden shadow-sm transition hover:shadow-md">
                        <img src="https://images.unsplash.com/photo-1554048612-b6a482bc67e5?q=80&w=2070" class="w-full h-48 object-cover" alt="Blog">
                        <div class="p-8">
                            <p class="text-xs text-gray-400 mb-2 uppercase tracking-widest">September 25, 2019</p>
                            <h3 class="text-xl font-normal text-gray-800 mb-4">Attract Your Precious Clients To Your Photography Skills By Latest eAlbum App</h3>
                            <a href="#" class="text-blue-500 font-medium text-sm hover:underline">Read More</a>
                        </div>
                    </div>

                    <div class="bg-white border border-gray-100 rounded-lg overflow-hidden shadow-sm transition hover:shadow-md">
                        <div class="bg-green-500 h-48 flex items-center justify-center text-white text-3xl font-bold">
                            Free Marketing
                        </div>
                        <div class="p-8">
                            <p class="text-xs text-gray-400 mb-2 uppercase tracking-widest">July 31, 2019</p>
                            <h3 class="text-xl font-normal text-gray-800 mb-4">Photography Marketing – Create a free online portfolio</h3>
                            <a href="#" class="text-blue-500 font-medium text-sm hover:underline">Read More</a>
                        </div>
                    </div>

                </div>

                <div class="lg:w-1/3 space-y-12">
                    
                    <div class="bg-white p-8 border border-gray-100 rounded-lg">
                        <input type="text" placeholder="Type search keywords here" 
                               class="w-full p-4 bg-gray-50 border border-gray-100 rounded focus:outline-none focus:border-blue-300 italic text-sm text-gray-500">
                    </div>

                    <div class="space-y-6">
                        <h4 class="text-gray-800 font-medium border-b border-gray-100 pb-4">Recent Posts</h4>
                        <ul class="space-y-4 text-sm text-blue-500">
                            <li><a href="#" class="hover:underline">Relive the Memories like Never before...</a></li>
                            <li><a href="#" class="hover:underline">Experience Digitalization through the eAlbum...</a></li>
                            <li><a href="#" class="hover:underline">Attract Your Precious Clients To Your...</a></li>
                            <li><a href="#" class="hover:underline">Choose eAlbum App & Boost Your Business...</a></li>
                        </ul>
                    </div>

                    <div class="space-y-6">
                        <h4 class="text-gray-800 font-medium border-b border-gray-100 pb-4">Categories</h4>
                        <ul class="space-y-3 text-sm text-blue-400">
                            <li><a href="#" class="hover:underline">Alive Prints</a></li>
                            <li><a href="#" class="hover:underline">eAlbum</a></li>
                            <li><a href="#" class="hover:underline">Marketing</a></li>
                            <li><a href="#" class="hover:underline">Photography</a></li>
                            <li><a href="#" class="hover:underline">Uncategorized</a></li>
                        </ul>
                    </div>

                </div>
            </div>
        </div>
    </main>

    @include('user.pages.extra.footer')

    <script>
        $(document).ready(function() {
            // Dropdown hover handling
            $('#category-trigger').hover(
                function() { $('#category-menu').stop(true, true).fadeIn(200); },
                function() { $('#category-menu').stop(true, true).fadeOut(200); }
            );
        });
    </script>

</body>
</html>