@extends('admin.pages.adminApp')

@section('content')

    <div class="flex h-screen overflow-hidden bg-[#f4f7fe]">

        @include('admin.extra.sidebar')

        <div id="main-panel" class="flex-1 flex flex-col min-w-0 transition-all duration-500 ease-in-out">

            @include('admin.extra.header')

            <div class="flex-1 overflow-y-auto p-6 space-y-8 custom-scrollbar">

                {{-- Alert Messages --}}
                @if(session('success'))
                    <div id="alert-success" class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded-xl relative mb-4 shadow-sm flex justify-between items-center transition-opacity duration-300">
                        <span class="font-bold flex items-center"><i class="fa-solid fa-circle-check mr-2"></i>{{ session('success') }}</span>
                        <button type="button" onclick="document.getElementById('alert-success').style.display='none'" class="text-green-700 hover:text-green-900 transition-colors"><i class="fa-solid fa-xmark text-lg"></i></button>
                    </div>
                @endif

                @if(session('error'))
                    <div id="alert-error" class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded-xl relative mb-4 shadow-sm flex justify-between items-center">
                        <span class="font-bold flex items-center"><i class="fa-solid fa-circle-exclamation mr-2"></i>{{ session('error') }}</span>
                        <button type="button" onclick="document.getElementById('alert-error').style.display='none'" class="text-red-700 hover:text-red-900"><i class="fa-solid fa-xmark text-lg"></i></button>
                    </div>
                @endif

                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
                    <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100 flex flex-col items-center text-center group hover:shadow-md transition-all">
                        <div class="text-red-500 mb-2"><i class="fa-solid fa-file-video text-4xl group-hover:scale-110 transition-transform"></i></div>
                        <p class="text-gray-400 text-[10px] font-bold uppercase tracking-widest">Total Album Created</p>
                        <h2 class="text-3xl font-black text-gray-800">{{ $albums->count() }}</h2>
                    </div>

                    <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100 flex flex-col items-center text-center group hover:shadow-md transition-all">
                        <div class="text-yellow-500 mb-2">
                            <i class="fa-solid {{ auth()->user()->is_unlimited ? 'fa-infinity' : 'fa-money-bill-1' }} text-4xl group-hover:scale-110 transition-transform"></i>
                        </div>
                        <p class="text-gray-400 text-[10px] font-bold uppercase tracking-widest">
                            {{ auth()->user()->is_unlimited ? 'Unlimited Plan Active' : 'eAlbum Credits Available' }}
                        </p>
                        <h2 class="text-3xl font-black text-gray-800">
                            @if(auth()->user()->is_unlimited && auth()->user()->plan_expires_at && now()->lt(auth()->user()->plan_expires_at))
                                <span class="text-blue-600">∞</span>
                            @else
                                {{ Auth::user()->credits ?? 0 }}
                            @endif
                        </h2>
                        @if(Auth::user()->active_plan != 'Studio' && Auth::user()->active_plan != 'Studio Plan')
                            <button type="button" id="btnBuyCreditsPopup" class="text-blue-600 font-bold text-xs mt-1 hover:underline focus:outline-none">
                                Upgrade / Buy Credits
                            </button>
                        @else
                            <p class="text-green-500 text-[9px] font-black uppercase mt-1 tracking-tighter">Maximum Plan Active</p>
                        @endif
                    </div>

                    <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100 flex flex-col items-center text-center group hover:shadow-md transition-all">
                        <div class="text-amber-400 mb-2"><i class="fa-solid fa-crown text-4xl group-hover:scale-110 transition-transform {{ auth()->user()->active_plan ? 'text-yellow-500' : 'text-gray-300' }}"></i></div>
                        @if(auth()->user()->active_plan && auth()->user()->plan_expires_at && now()->lt(auth()->user()->plan_expires_at))
                            <p class="text-gray-400 text-[10px] leading-tight font-bold uppercase tracking-tighter">Active Subscription</p>
                            <h3 class="text-lg font-bold text-gray-800 uppercase">{{ auth()->user()->active_plan }} Plan</h3>
                            <p class="text-blue-600 font-bold text-[11px] mt-1">Expires: {{ auth()->user()->plan_expires_at->format('d M, Y') }}</p>
                            <p class="text-gray-400 text-[9px]">({{ (int) now()->diffInDays(auth()->user()->plan_expires_at) }} days left)</p>
                        @else
                            <p class="text-gray-400 text-[10px] leading-tight font-bold uppercase tracking-tighter">No Active Subscription</p>
                            <button id="btnBuyCreditsPopup" class="text-blue-600 font-bold text-xs mt-1 hover:underline">Get Subscription</button>
                        @endif
                    </div>

                    <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100 flex flex-col items-center text-center group hover:shadow-md transition-all">
                        <div class="text-green-500 mb-2"><i class="fa-solid fa-phone-volume text-4xl group-hover:scale-110 transition-transform"></i></div>
                        <p class="text-gray-400 text-[10px] font-bold uppercase tracking-widest">For support contact</p>
                        <h2 class="text-blue-600 font-bold text-lg">+91 9137634193</h2>
                    </div>
                </div>

                <div class="grid grid-cols-1 lg:grid-cols-2 gap-4">
                    <div class="flex gap-2">
                        @if(Auth::user()->credits < 100 && !Auth::user()->is_unlimited)
                            <button id="btnCreateAlbumCheck" class="bg-blue-600 text-white px-6 py-3 rounded-xl text-sm font-bold shadow-md hover:bg-blue-700 transition">Create EAlbum</button>
                        @else
                            <a href="{{ route('admin.studio') }}" class="bg-blue-600 text-white px-6 py-3 rounded-xl text-sm font-bold shadow-md hover:bg-blue-700 transition">Create EAlbum</a>
                        @endif
                    </div>
                </div>

                <div class="bg-white rounded-3xl shadow-sm border border-gray-100 overflow-hidden">
                    <div class="p-6 border-b border-gray-50 bg-gray-50/30 flex justify-between items-center">
                        <h3 class="font-bold text-gray-800 text-lg">Your Projects</h3>
                        <div class="text-xs text-gray-500">Show <select class="border rounded p-1 mx-1"><option>10</option></select> entries</div>
                    </div>

                    <div class="overflow-x-auto p-4 custom-scrollbar">
                        <table class="w-full text-left border-collapse min-w-[1150px]">
                            <thead class="bg-gray-50/50 text-gray-500 text-[11px] font-bold uppercase tracking-wider border-y border-gray-100">
                                <tr>
                                    <th class="px-4 py-4 text-center">ID</th>
                                    <th class="px-4 py-4">Unique Code</th>
                                    <th class="px-4 py-4">Album Name</th>
                                    <th class="px-4 py-4">Album Type</th>
                                    <th class="px-4 py-4">Studio Contact Person</th>
                                    <th class="px-4 py-4">Contact No</th>
                                    <th class="px-4 py-4">Photography Exp.</th>
                                    <th class="px-4 py-4">Album Created On</th>
                                    <th class="px-4 py-4">Album Validity</th>
                                    <th class="px-4 py-4 text-center">Take Action</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-100 text-[12px]">
                                @foreach ($albums as $data)
                                    <tr class="hover:bg-indigo-50/30 transition-all group">
                                        {{-- 1. ID --}}
                                        <td class="px-2 py-4 font-bold text-blue-600 text-center">{{ $loop->iteration }}</td>

                                        {{-- 2. Unique Code --}}
                                        <td class="px-2 py-4 font-medium">{{ $data->album->unique_code }}</td>

                                        {{-- 3. Album Name --}}
                                        <td class="px-2 py-4 font-bold text-gray-700 max-w-[150px] whitespace-normal leading-tight">
                                            {{ $data->album->album_name }}
                                        </td>

                                        {{-- 4. Album Type --}}
                                        <td class="px-2 py-4">
                                            <span class="bg-blue-100 text-blue-600 px-2 py-0.5 rounded text-[9px] font-bold uppercase block w-max">
                                                {{ $data->album->album_type ?? 'N/A' }}
                                            </span>
                                        </td>

                                        {{-- 5. Studio Contact Person --}}
                                        <td class="px-2 py-4 whitespace-nowrap">{{ $data->contact_person }}</td>

                                        {{-- 6. Contact No --}}
                                        <td class="px-2 py-4">{{ $data->studio_contact }}</td>

                                        {{-- 7. Photography Exp. --}}
                                        <td class="px-2 py-4">{{ $data->experience ?? 'N/A' }}</td>

                                        {{-- 8. Album Created On --}}
                                        <td class="px-2 py-4 whitespace-nowrap">{{ $data->created_at->format('d M, Y') }}</td>

                                        {{-- 9. Album Validity --}}
                                        <td class="px-2 py-4 text-gray-400">
                                            @if(auth()->user()->plan_expires_at && now()->lt(auth()->user()->plan_expires_at))
                                                <span class="text-gray-700 font-bold">{{ auth()->user()->plan_expires_at->format('d-m-Y') }}</span>
                                                <span class="block text-[10px]">({{ now()->diffInDays(auth()->user()->plan_expires_at) }} days left)</span>
                                            @else
                                                <span class="text-red-500 font-bold">Expired</span>
                                            @endif
                                        </td>

                                        {{-- 10. Take Action --}}
                                        <td class="px-2 py-4">
                                            <div class="flex items-center justify-center gap-2 whitespace-nowrap">
                                                <button type="button"
                                                    class="px-3 py-1.5 rounded-lg bg-purple-50 text-purple-600 hover:bg-purple-600 hover:text-white transition-all text-[11px] btn-extend-validity">Extend</button>

                                                <a href="{{ route('admin.gallery.update', $data->id) }}"
                                                    class="px-3 py-1.5 rounded-lg bg-blue-50 text-blue-600 hover:bg-blue-600 hover:text-white transition-all text-[11px]">Edit</a>

                                                <form action="{{ route('admin.album.destroy', $data->id) }}" method="POST"
                                                    onsubmit="return confirm('Delete this album?')" class="inline">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit"
                                                        class="px-3 py-1.5 rounded-lg bg-red-50 text-red-600 hover:bg-red-600 hover:text-white transition-all text-[11px]">
                                                        <i class="fa-solid fa-trash-can"></i>
                                                    </button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                            </table>
                            </div>
                            </div>

                            {{-- BOTTOM BOXES --}}
                <div class="mt-8">
                    <h4 class="text-lg font-bold text-gray-800 mb-6">How to create eAlbum? <span class="text-red-500 text-sm font-normal cursor-pointer ml-2 hover:underline">Watch Video Guide</span></h4>
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                        <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100">
                            <p class="text-sm font-medium leading-relaxed">
                                <span class="text-blue-600 font-bold">(1) Create EAlbum</span><br>
                                Click on "Create eAlbum" button by entering Event Name.
                            </p>
                        </div>
                        <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100">
                            <p class="text-sm font-medium leading-relaxed">
                                <span class="text-blue-600 font-bold">(2) Upload Images</span><br>
                                Upload Album images, enter details and hit Save button.
                            </p>
                        </div>
                        <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100">
                            <p class="text-sm font-medium leading-relaxed">
                                <span class="text-blue-600 font-bold">(3) Click On "Save EAlbum" Button</span><br>
                                Click on Save eAlbum button to save album.
                            </p>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>

    {{-- Validity Modal --}}
    <div id="validityModal" class="fixed inset-0 z-[100] hidden items-center justify-center p-4">
        <div class="absolute inset-0 bg-black/50 backdrop-blur-sm closeModalTrigger"></div>
        <div class="relative bg-white w-full max-w-lg rounded-2xl shadow-2xl overflow-hidden transform transition-all duration-300 scale-95 opacity-0" id="validityModalContent">
            <div class="p-5 border-b border-gray-100 flex justify-between items-center bg-gray-50/50">
                <h3 class="text-gray-700 font-bold text-sm uppercase tracking-wider">Extend Validity</h3>
                <button class="closeModalTrigger text-gray-400 hover:text-red-500 text-3xl">&times;</button>
            </div>
            <div class="p-8 space-y-6">
                <h2 class="text-2xl font-bold text-green-600">Extend eAlbum Validity</h2>
                <p class="text-sm text-gray-500">Select the desired validity period and note credit deductions:</p>
                <select class="w-full border-2 border-gray-100 rounded-xl p-3 outline-none focus:ring-2 focus:ring-indigo-400">
                    <option value="1">1 Year - Deduct 1 Credit</option>
                    <option value="10">10 Years - Deduct 10 Credits</option>
                </select>
                <button class="w-full bg-blue-600 text-white py-4 rounded-xl font-bold shadow-lg hover:bg-blue-700 transition">Confirm Extension</button>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script>
        $(document).ready(function () {
            // Sidebar Toggle
            $(document).on('click', '#toggleSidebar', function (e) {
                e.preventDefault();
                $('#sidebar-container').toggleClass('collapsed-sidebar');
            });

            // Validity Modal Logic
            $(document).on('click', '.btn-extend-validity', function () {
                $('#validityModal').removeClass('hidden').addClass('flex');
                setTimeout(() => { $('#validityModalContent').removeClass('scale-95 opacity-0').addClass('scale-100 opacity-100'); }, 10);
            });

            $(document).on('click', '.closeModalTrigger', function () {
                $('#validityModalContent').removeClass('scale-100 opacity-100').addClass('scale-95 opacity-0');
                setTimeout(() => { $('#validityModal').addClass('hidden').removeClass('flex'); }, 300);
            });

            $('.bg-white').hover(
                function () { $(this).find('i').addClass('fa-bounce'); },
                function () { $(this).find('i').removeClass('fa-bounce'); }
            );
        });
    </script>

    @include('admin.extra.popup')
@endsection