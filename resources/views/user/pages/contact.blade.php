<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contact Us - eAlbum</title>
    
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Roboto:wght@100;300;400;500&display=swap');
        .font-roboto { font-family: 'Roboto', sans-serif; }
    </style>
</head>
<body class="bg-white antialiased font-roboto">

    @include('user.pages.extra.navbar')

    <main>
        <section class="relative w-full bg-[#616161] pt-32 pb-20 overflow-hidden">
            <div class="container mx-auto px-6 lg:px-24 flex flex-col md:flex-row items-center justify-between relative z-10">
                
                <div class="max-w-xl mb-10 md:mb-0">
                    <h1 class="text-5xl md:text-6xl font-light text-white mb-6 leading-tight">
                        Contact eAlbum Team.
                    </h1>
                    <p class="text-gray-400 text-lg md:text-xl font-light leading-relaxed">
                        We are here to help and answer any questions you might have. We look forward to hearing from you. Please drop mail or send email to ealbum team.
                    </p>
                </div>
                
                <div class="md:w-5/12 flex justify-end">
                    <div class="relative max-w-sm overflow-hidden rounded-xl shadow-[0_20px_50px_rgba(0,0,0,0.3)] border-4 border-[#222]">
                        <img src="https://images.unsplash.com/photo-1496181133206-80ce9b88a853?q=80&w=1200" 
                             class="w-full h-auto object-cover opacity-90" alt="contact desk">
                    </div>
                </div>
            </div>

            <div class="absolute top-0 right-0 w-64 h-64 bg-blue-500/10 blur-[120px] rounded-full -mr-32 -mt-32"></div>
        </section>

        <section class="py-24 bg-white">
            <div class="container mx-auto px-6 lg:px-24">
                <div class="flex flex-col md:flex-row gap-20">
                    
                    <div class="md:w-1/3 space-y-10">
                        <div class="space-y-2">
                            <p class="text-gray-400 text-sm uppercase tracking-widest font-medium">Email</p>
                            <p class="text-xl text-gray-700 font-light">info@alivecreate.com</p>
                        </div>
                        
                        <div class="space-y-2">
                            <p class="text-gray-400 text-sm uppercase tracking-widest font-medium">Phone</p>
                            <p class="text-xl text-gray-700 font-light">+91 9137634193</p>
                        </div>

                        <div class="pt-6 border-t border-gray-100">
                            <p class="text-gray-500 leading-relaxed font-light text-lg">
                                Give us a call or drop by anytime, we endeavor to answer all inquiries within 24 hours on business days related to digital album.
                            </p>
                            <p class="mt-6 text-gray-600 font-normal">
                                We are open from 10am — 7pm week days.
                            </p>
                        </div>
                    </div>

                    <div class="md:w-2/3">
                        <form action="#" class="space-y-6">
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div class="space-y-2">
                                    <label class="text-xs text-gray-400 uppercase tracking-wider font-semibold">Your Name:</label>
                                    <input type="text" placeholder="First / Last Name" 
                                           class="w-full p-4 bg-gray-50 border border-gray-100 rounded focus:outline-none focus:border-blue-400 focus:bg-white transition shadow-sm">
                                </div>
                                <div class="space-y-2">
                                    <label class="text-xs text-gray-400 uppercase tracking-wider font-semibold">Email Address:</label>
                                    <input type="email" placeholder="info@alivecreate.com" 
                                           class="w-full p-4 bg-gray-50 border border-gray-100 rounded focus:outline-none focus:border-blue-400 focus:bg-white transition shadow-sm">
                                </div>
                            </div>
                            
                            <div class="space-y-2">
                                <label class="text-xs text-gray-400 uppercase tracking-wider font-semibold">Message:</label>
                                <textarea rows="6" placeholder="Message" 
                                          class="w-full p-4 bg-gray-50 border border-gray-100 rounded focus:outline-none focus:border-blue-400 focus:bg-white transition resize-none shadow-sm"></textarea>
                            </div>

                            <button type="submit" 
                                    class="w-full md:w-auto px-12 py-4 bg-[#5da0e3] hover:bg-blue-600 text-white font-medium rounded shadow-lg transition duration-300 uppercase tracking-widest active:scale-95">
                                Send Enquiry
                            </button>
                        </form>
                    </div>

                </div>
            </div>
        </section>
    </main>

    @include('user.pages.extra.footer')

</body>
</html>