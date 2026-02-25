<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>eAlbum - Business Landing Page</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <style>
        .feature-content {
            display: none;
        }

        .feature-content.active {
            display: block;
        }

        @keyframes slideInRight {
            from {
                opacity: 0;
                transform: translateX(30px);
            }

            to {
                opacity: 1;
                transform: translateX(0);
            }
        }

        .animate-slide {
            animation: slideInRight 0.5s ease-out forwards;
        }

        .tab-btn.active {
            color: #3b82f6;
            border-bottom: 2px solid #3b82f6;
        }
    </style>
</head>

<body class="bg-gray-50 font-sans text-gray-700">



    <section class="py-20 text-center bg-white">
        <div class="container mx-auto px-6">
            <h2 class="text-3xl font-normal mb-8">Your customer will love it!</h2>
            <p class="max-w-4xl mx-auto text-gray-500 leading-relaxed">
                Yes, you get that right! Just like a traditional album, with our FREE eBook you can enjoy viewing every
                memory page by page. It's like a pocket album for you! Furthermore, you can share it with your loved
                ones as per your convenience.
            </p>
        </div>
    </section>

    <section class="py-20 bg-[#F2F2F2]">
        <h2 class="text-3xl text-center mb-16">How to use app?</h2>
        <div class="container mx-auto px-6 grid grid-cols-1 md:grid-cols-3 gap-8">
            <div class="bg-white p-8 rounded-lg shadow-sm text-center border border-gray-100">
                <div class="text-blue-500 text-4xl mb-4 flex justify-center">▶</div>
                <h3 class="font-semibold mb-4 text-xl">1. Download App</h3>
                <p class="text-gray-400 text-sm mb-6">Stack comes with integration for Mail Chimp and Campaign Monitor
                    forms.</p>
                <div class="space-y-2">
                    <a href="#" class="text-blue-400 text-sm block hover:underline">For Android User</a>
                    <a href="#" class="text-blue-400 text-sm block hover:underline">For iOS User</a>
                </div>
            </div>
            <div class="bg-white p-8 rounded-lg shadow-sm text-center border border-gray-100">
                <div class="text-blue-500 text-4xl mb-4 flex justify-center">🔓</div>
                <h3 class="font-semibold mb-4 text-xl">2. Download eAlbum</h3>
                <p class="text-gray-400 text-sm mb-6">Including the premium Icons Mind icon kit, Stack features a highly
                    diverse set.</p>
                <a href="#" class="text-blue-400 text-sm hover:underline">Learn More</a>
            </div>
            <div class="bg-white p-8 rounded-lg shadow-sm text-center border border-gray-100">
                <div class="text-blue-500 text-4xl mb-4 flex justify-center">📷</div>
                <h3 class="font-semibold mb-4 text-xl">3. Enjoy Viewing</h3>
                <p class="text-gray-400 text-sm mb-6">Combine blocks from a range of categories to build pages that are
                    rich in visual style.</p>
                <a href="#" class="text-blue-400 text-sm hover:underline">Learn More</a>
            </div>
        </div>
    </section>

    <section class="py-20 bg-white min-h-[500px]">
        <div class="container mx-auto px-6 text-center">
            <h2 class="text-3xl font-light mb-12">App Features : Single App, Multiple Options</h2>

            <div class="flex justify-center border-b border-gray-200 max-w-2xl mx-auto mb-12">
                <button class="tab-btn active px-8 py-4 font-medium transition" data-target="basic">Basic</button>
                <button class="tab-btn px-8 py-4 font-medium transition" data-target="alive">Alive Prints</button>
                <button class="tab-btn px-8 py-4 font-medium transition" data-target="editor">Photo Editor</button>
            </div>

            <div class="max-w-xl mx-auto text-left min-h-[200px]" id="tab-content">
                <div id="basic" class="feature-content active">
                    <ul class="space-y-3 text-gray-600">
                        <li class="flex items-center">▪ View eAlbum Online/Offline</li>
                        <li class="flex items-center">▪ Unlimited Download and Sharing</li>
                        <li class="flex items-center">▪ Access anywhere anytime</li>
                        <li class="flex items-center">▪ Easy Navigation of album pages</li>
                        <li class="flex items-center">▪ Audio playing while viewing</li>
                    </ul>
                </div>
                <div id="alive" class="feature-content">
                    <p class="text-lg text-gray-600 italic">"Alive print : playing video on photo, New experience"</p>
                </div>
                <div id="editor" class="feature-content">
                    <p class="text-lg text-gray-600">Free Photo Editor to create Collage, Scrapbook, Mirror Effect etc.
                    </p>
                </div>
            </div>
        </div>
    </section>

    <script>
        $(document).ready(function () {
            $('.tab-btn').click(function () {
                const target = $(this).data('target');

                // Update Button UI
                $('.tab-btn').removeClass('active');
                $(this).addClass('active');

                // Change Content with Fade and Slide Effect
                $('.feature-content').hide().removeClass('animate-slide');
                $(`#${target}`).fadeIn(200).addClass('animate-slide');
            });
        });
    </script>
</body>

</html>