<header class="bg-[#7c3aed] h-[73px] shadow-lg flex justify-between items-center px-6 text-white shrink-0 z-40">
    <div class="flex items-center gap-6">
        <div id="toggleSidebar"
            class="p-2.5 rounded-xl hover:bg-white/10 cursor-pointer transition-all duration-300 active:scale-95 shadow-inner">
            <i class="fa-solid fa-bars-staggered text-2xl"></i>
        </div>
        <h1 class="text-lg font-semibold tracking-tight hidden sm:block">Create your memories for lifetime</h1>
    </div>

    <div class="flex items-center gap-4">
        <div class="text-right hidden md:block">
            <p class="text-sm font-medium opacity-90">{{ Auth::user()->name }} photos</p>
        </div>
        {{-- Profile/Logo Circle --}}
        <div class="h-10 w-10 rounded-full overflow-hidden border-2 border-white/20 shadow-sm bg-white/10">
            @if(Auth::user()->logo)
                {{-- Make sure to run 'php artisan storage:link' --}}
                <img src="{{ asset('storage/' . Auth::user()->logo) }}" alt="User Logo" class="h-full w-full object-cover">
            @else
                {{-- Agar logo nahi hai toh initial letter dikha sakte ho ya default icon --}}
                <div class="h-full w-full flex items-center justify-center bg-amber-400 text-gray-800 font-bold text-xs uppercase">
                    {{ substr(Auth::user()->name, 0, 1) }}
                </div>
            @endif
        </div>
    </div>
</header>