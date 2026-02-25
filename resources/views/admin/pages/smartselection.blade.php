@extends('admin.pages.adminApp')

@section('content')
    <div class="flex h-screen overflow-hidden bg-white">

        @include('admin.extra.sidebar')

        <div id="main-panel" class="flex-1 flex flex-col min-w-0 transition-all duration-500 ease-in-out bg-white">

            @include('admin.extra.header')

            <div class="flex-1 overflow-y-auto p-6 flex flex-col items-center justify-center custom-scrollbar">

                <div
                    class="max-w-3xl w-full bg-white rounded-[40px] border border-gray-100 shadow-[0_20px_50px_rgba(0,0,0,0.05)] p-12 text-center relative overflow-hidden group">

                    <div
                        class="absolute -top-10 -right-10 text-8xl opacity-10 blur-sm group-hover:rotate-12 transition-transform duration-700">
                        🚀</div>
                    <div
                        class="absolute -bottom-10 -left-10 text-8xl opacity-10 blur-sm group-hover:-rotate-12 transition-transform duration-700">
                        🛠️</div>

                    <div class="mb-10 relative inline-block">
                        <div class="absolute inset-0 bg-indigo-50 rounded-full scale-150 animate-pulse opacity-50"></div>
                        <div
                            class="relative w-28 h-28 bg-white rounded-full shadow-xl flex items-center justify-center border-4 border-indigo-50">
                            <i class="fa-solid fa-screwdriver-wrench text-5xl text-indigo-600 animate-bounce"></i>
                        </div>
                        <div class="absolute -right-2 top-0 text-3xl animate-bounce" style="animation-delay: 0.2s">✨</div>
                    </div>

                    <div class="space-y-4 mb-10">
                        <h2 class="text-4xl font-black text-gray-800 tracking-tight">
                            We Appreciate Your <span class="text-indigo-600">Patience!</span> 🙏
                        </h2>
                        <p class="text-gray-500 text-lg font-medium leading-relaxed max-w-lg mx-auto">
                            This page is currently undergoing a <span class="text-indigo-500 font-bold">creative
                                makeover</span>.
                            We’re working hard to bring you something amazing very soon! 🚀
                        </p>
                    </div>

                    <div class="flex items-center gap-4 mb-10">
                        <div class="h-[1px] flex-1 bg-gray-100"></div>
                        <div class="text-gray-300 text-xs font-black uppercase tracking-[0.3em]">Launch Soon</div>
                        <div class="h-[1px] flex-1 bg-gray-100"></div>
                    </div>

                    <div class="flex flex-col sm:flex-row items-center justify-center gap-6">
                        <a href="{{ route('admin.index') }}"
                            class="group flex items-center gap-3 bg-[#1a1c2d] text-white px-10 py-4 rounded-2xl font-bold shadow-2xl shadow-indigo-200 hover:bg-indigo-600 transition-all active:scale-95">
                            <i class="fa-solid fa-house text-sm group-hover:-translate-x-1 transition-transform"></i>
                            Back to Dashboard
                        </a>

                        <div class="text-left">
                            <p class="text-xs text-gray-400 font-bold uppercase tracking-widest mb-1">Stay Tuned for</p>
                            <p class="text-sm text-indigo-600 font-black">NEW EXPERIENCE & MORE UPDATES ✨</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        $(document).ready(function () {
            $(document).on('click', '#toggleSidebar', function () {
                $('#sidebar-container').toggleClass('collapsed-sidebar');
            });
        });
    </script>
@endsection