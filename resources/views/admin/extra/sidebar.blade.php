<div id="sidebar-container"
    class="w-64 bg-[#1a1c2d] text-white flex flex-col shrink-0 transition-all duration-500 ease-in-out min-h-screen border-r border-white/5 overflow-hidden z-50 shadow-2xl">

    <div id="sidebar-logo-container"
        class="p-6 flex items-center gap-3 border-b border-white/5 h-[73px] cursor-pointer hover:bg-white/5 transition-all">
        <div class="bg-white p-1.5 rounded-lg shadow-lg shrink-0 flex items-center justify-center">
            <i class="fa-solid fa-camera-retro text-indigo-600 text-xl"></i>
        </div>
        <h2
            class="text-xl font-bold tracking-wider sidebar-text whitespace-nowrap opacity-100 transition-all duration-300">
            eAlbum</h2>
    </div>

    <nav class="flex-1 px-3 space-y-1 mt-6 overflow-x-hidden custom-scrollbar">

        {{-- Dashboard --}}
        <a href="{{ route('admin.index') }}" class="nav-item flex items-center gap-4 p-3 rounded-xl transition-all duration-300 group relative 
           {{ Route::is('admin.index') ? 'active text-white' : 'text-gray-400 hover:bg-white/5 hover:text-white' }}">
            <i class="ml-3 text-xl fa-solid fa-house group-hover:-translate-x-1 transition-transform"></i>
            <span class="sidebar-text font-medium whitespace-nowrap opacity-100 transition-all duration-300">Dashboard</span>
            <div class="active-indicator absolute left-0 w-1 h-8 bg-white rounded-r-full {{ Route::is('admin.index') ? '' : 'hidden' }}"></div>
        </a>

        {{-- Credit Details --}}
        <a href="{{ route('admin.credit') }}" class="nav-item flex items-center gap-4 p-3 rounded-xl transition-all duration-300 group relative 
           {{ Route::is('admin.credit') ? 'active text-white' : 'text-gray-400 hover:bg-white/5 hover:text-white' }}">
            <i class="fa-solid fa-credit-card text-xl min-w-[40px] text-center group-hover:scale-110 transition-transform"></i>
            <span class="sidebar-text font-medium whitespace-nowrap opacity-100 transition-all duration-300">{{ Auth::user()->name }}'s Credit Details</span>
            <div class="active-indicator absolute left-0 w-1 h-8 bg-white rounded-r-full {{ Route::is('admin.credit') ? '' : 'hidden' }}"></div>
        </a>

        {{-- Profile --}}
        <a href="{{ route('admin.profile') }}" class="nav-item flex items-center gap-4 p-3 rounded-xl transition-all duration-300 group relative 
           {{ Route::is('admin.profile') ? 'active text-white' : 'text-gray-400 hover:bg-white/5 hover:text-white' }}">
            <i class="fa-solid fa-user text-xl min-w-[40px] text-center group-hover:scale-110 transition-transform"></i>
            <span class="sidebar-text font-medium whitespace-nowrap opacity-100 transition-all duration-300">{{ Auth::user()->name }}'s Profile</span>
            <div class="active-indicator absolute left-0 w-1 h-8 bg-white rounded-r-full {{ Route::is('admin.profile') ? '' : 'hidden' }}"></div>
        </a>

        {{-- ✅ FIXED GALLERY LINK: 
             Yeh link sirf tabhi dikhega jab hum Gallery page par honge aur $gallery data available hoga.
             Dashboard par yeh link kaam nahi karega kyunki wahan ID nahi milti.
        --}}
        @if(isset($gallery))
        <a href="{{ route('admin.my-gallery', $gallery->studio_id) }}" class="nav-item flex items-center gap-4 p-3 rounded-xl transition-all duration-300 group relative 
            {{ Route::is('admin.my-gallery') ? 'active text-white' : 'text-gray-400 hover:bg-white/5 hover:text-white' }}">
            <i class="fa-solid fa-image text-xl min-w-[40px] text-center group-hover:scale-110 transition-transform"></i>
            <span class="sidebar-text font-medium whitespace-nowrap opacity-100 transition-all duration-300">Current Gallery</span>
            <div class="active-indicator absolute left-0 w-1 h-8 bg-white rounded-r-full {{ Route::is('admin.my-gallery') ? '' : 'hidden' }}"></div>
        </a>
        @endif

        {{-- Smart Selection --}}
        <a href="{{ route('admin.smartselection') }}"
            class="nav-item flex items-center gap-4 p-3 rounded-xl transition-all duration-300 group relative
           {{ Route::is('admin.smartselection') ? 'active text-white' : 'text-gray-400 hover:bg-white/5 hover:text-white' }}">
            <i class="fa-solid fa-wand-magic-sparkles text-xl min-w-[40px] text-center"></i>
            <span class="sidebar-text whitespace-nowrap opacity-100 transition-all duration-300">Smart Selection</span>
            <span class="sidebar-text absolute right-2 bg-blue-500 text-[9px] px-1.5 py-0.5 rounded font-bold uppercase shadow-sm">New</span>
            <div class="active-indicator absolute left-0 w-1 h-8 bg-white rounded-r-full {{ Route::is('admin.smartselection') ? '' : 'hidden' }}"></div>
        </a>
    </nav>

    <div class="p-4 border-t border-white/5 mt-auto bg-[#151725]">
        <form method="POST" action="{{ route('admin.logout') }}">
            @csrf
            <button type="submit"
                class="w-full flex items-center gap-4 p-3 rounded-xl text-red-400 hover:bg-red-500/10 hover:text-red-300 transition-all duration-300 font-bold group">
                <i class="fa-solid fa-right-from-bracket text-xl min-w-[40px] text-center group-hover:-translate-x-1 transition-transform"></i>
                <span class="sidebar-text whitespace-nowrap opacity-100 transition-all duration-300">Sign Out</span>
            </button>
        </form>
    </div>
</div>

<style>
    .collapsed-sidebar { width: 88px !important; }
    .collapsed-sidebar .sidebar-text { opacity: 0 !important; width: 0; pointer-events: none; }
    .collapsed-sidebar .nav-item { justify-content: center; padding-left: 0; padding-right: 0; }
    .nav-item.active { background: #4f46e5 !important; color: white !important; box-shadow: 0 4px 15px rgba(79, 70, 229, 0.4); }
    .nav-item.active i { color: white !important; }
    .custom-scrollbar::-webkit-scrollbar { width: 4px; }
    .custom-scrollbar::-webkit-scrollbar-thumb { background: rgba(255,255,255,0.1); border-radius: 10px; }
</style>