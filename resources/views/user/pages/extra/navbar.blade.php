<nav id="main-navbar" class="fixed top-0 left-0 w-full z-50 transition-all duration-300 px-6 py-5 lg:px-20 flex items-center justify-between text-white">
    <div class="flex items-center space-x-2">
        <div class="flex items-center bg-white p-1 rounded shadow-sm">
            <a href="{{ route('user.pages.welcome') }}">
                <svg class="w-8 h-8 text-blue-600" fill="currentColor" viewBox="0 0 24 24">
                <path d="M12 2L2 7l10 5 10-5-10-5zM2 17l10 5 10-5M2 12l10 5 10-5"></path>
            </svg>
            </a>
        </div>
        <span id="nav-logo-text" class="text-2xl font-bold tracking-tight transition-colors"><a href="{{ route('user.pages.welcome') }}">eAlbum</a></span>
    </div>

    <div id="nav-links" class="hidden md:flex items-center space-x-8 text-sm font-bold uppercase tracking-widest transition-colors">
        <a href="{{ route('user.pages.welcome') }}" class="hover:text-blue-400 transition">Home</a>
        <a href="{{ route('user.about') }}" class="hover:text-blue-400 transition">About Us</a>
        <a href="{{ route('user.contact') }}" class="hover:text-blue-400 transition">Contact Us</a>
        <a href="{{ route('user.price') }}" class="hover:text-blue-400 transition">Pricing</a>
        <a href="{{ route('user.blog') }}" class="hover:text-blue-400 transition">Blogs</a>
    </div>

    <div class="flex items-center space-x-4">
        <a href="{{ route('user.access') }}" id="view-btn" class="hidden lg:block border border-white/50 px-6 py-2 rounded font-bold uppercase text-xs hover:bg-white hover:text-black transition duration-300">
            View eAlbum
        </a>
        <a href="{{ route('login') }}" class="bg-[#2563eb] px-6 py-2 rounded font-bold uppercase text-xs hover:bg-blue-700 transition duration-300 shadow-lg text-white">
            Create eAlbum
        </a>
    </div>
</nav>

<script>
    window.onscroll = function() {
        const nav = document.getElementById('main-navbar');
        const logoText = document.getElementById('nav-logo-text');
        const navLinks = document.getElementById('nav-links');
        const viewBtn = document.getElementById('view-btn');

        if (window.pageYOffset > 50) {
            // Jab scroll karein (White BG)
            nav.classList.add('bg-white', 'shadow-md', 'py-3');
            nav.classList.remove('bg-transparent', 'text-white', 'py-5');
            nav.classList.add('text-gray-800');
            
            // Links aur logo ka color dark karein
            logoText.classList.add('text-gray-900');
            navLinks.classList.remove('text-white');
            navLinks.classList.add('text-gray-700');
            viewBtn.classList.add('border-gray-400', 'text-gray-700');
            viewBtn.classList.remove('border-white/50', 'text-white');
        } else {
            // Default State (Transparent)
            nav.classList.remove('bg-white', 'shadow-md', 'py-3', 'text-gray-800');
            nav.classList.add('bg-transparent', 'text-white', 'py-5');
            
            logoText.classList.remove('text-gray-900');
            navLinks.classList.add('text-white');
            navLinks.classList.remove('text-gray-700');
            viewBtn.classList.remove('border-gray-400', 'text-gray-700');
            viewBtn.classList.add('border-white/50', 'text-white');
        }
    };
</script>