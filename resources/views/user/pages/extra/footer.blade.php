<footer class="bg-[#1a1a1a] text-gray-400 py-16">
    <div class="container mx-auto px-6 lg:px-24">
        
        <div class="grid grid-cols-1 md:grid-cols-4 gap-12 border-b border-gray-800 pb-12">
            
            <div class="col-span-1 md:col-span-1">
                <div class="flex items-center gap-2 mb-4 grayscale brightness-200">
                    <div class="w-8 h-8 bg-gray-600 rounded flex items-center justify-center text-black font-bold text-xs italic"><a href="{{ route('user.pages.welcome') }}">eA</a></div>
                    <span class="text-xl font-bold tracking-wider text-white"><a href="{{ route('user.pages.welcome') }}">eAlbum</a></span>
                </div>
                <p class="text-sm leading-relaxed">
                    Creating memories for a lifetime. A digital revolution for photographers and families.
                </p>
            </div>

            <div>
                <h4 class="text-white font-semibold mb-6 uppercase tracking-wider text-sm"><a href="https://www.alivecreate.com/">Our Company</a></h4>
                <ul class="space-y-4 text-sm">
                    <li><a href="{{ route('user.about') }}" class="hover:text-blue-400 transition">About Us</a></li>
                    <li><a href="#" class="hover:text-blue-400 transition">Terms & Conditions</a></li>
                    <li><a href="#" class="hover:text-blue-400 transition">Privacy Policy</a></li>
                </ul>
            </div>

            <div>
                <h4 class="text-white font-semibold mb-6 uppercase tracking-wider text-sm">Products</h4>
                <ul class="space-y-4 text-sm">
                    <li><a href="{{ route('user.price') }}" class="hover:text-blue-400 transition">Pricing</a></li>
                    <li><a href="{{ route('user.blog') }}" class="hover:text-blue-400 transition">Blogs</a></li>
                    <li><a href="{{ route('login') }}" class="hover:text-blue-400 transition">View eAlbum</a></li>
                </ul>
            </div>

            <div>
                <h4 class="text-white font-semibold mb-6 uppercase tracking-wider text-sm">Contact Us</h4>
                <ul class="space-y-4 text-sm">
                    <li><a href="https://www.alivecreate.com/" class="hover:text-blue-400 transition">info@alivecreate.com</a></li>
                    <li><a href="{{ route('user.contact') }}" class="hover:text-blue-400 transition">Contact Form</a></li>
                </ul>
            </div>
        </div>

        <div class="flex flex-col md:flex-row justify-between items-center mt-8 text-xs tracking-widest uppercase">
            <p>&copy; 2026 eAlbum. All rights reserved.</p>
            <p>Powered by <a href="https://www.alivecreate.com/" class="text-white hover:text-blue-400 font-bold">Alivecreate Web Solutions</a></p>
        </div>
        
    </div>
</footer>