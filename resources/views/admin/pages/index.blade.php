@extends('admin.pages.adminApp')

@section('content')
    <div class="flex h-screen overflow-hidden bg-[#f4f7fe]">

        @include('admin.extra.sidebar')

        <div id="main-panel" class="flex-1 flex flex-col min-w-0 transition-all duration-500 ease-in-out">

            @include('admin.extra.header')

            <div class="flex-1 overflow-y-auto p-6 space-y-8 custom-scrollbar">

                {{-- 🟢 Alert Messages for Credit Errors or Success --}}
                @if(session('error'))
                    <div
                        class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded-xl relative mb-4 shadow-sm animate-pulse">
                        <span class="block sm:inline font-bold"><i
                                class="fa-solid fa-circle-exclamation mr-2"></i>{{ session('error') }}</span>
                    </div>
                @endif

                @if(session('success'))
                    <div
                        class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded-xl relative mb-4 shadow-sm">
                        <span class="block sm:inline font-bold"><i
                                class="fa-solid fa-circle-check mr-2"></i>{{ session('success') }}</span>
                    </div>
                @endif

                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
                    <div
                        class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100 flex flex-col items-center text-center group hover:shadow-md transition-all">
                        <div class="text-red-500 mb-2"><i
                                class="fa-solid fa-file-video text-4xl group-hover:scale-110 transition-transform"></i>
                        </div>
                        <p class="text-gray-400 text-[10px] font-bold uppercase tracking-widest">Total Album Created</p>
                        {{-- 🟢 Dynamic Album Count --}}
                        <h2 class="text-3xl font-black text-gray-800">{{ $albums->count() }}</h2>
                    </div>

                    <div
                        class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100 flex flex-col items-center text-center group hover:shadow-md transition-all">
                        <div class="text-yellow-500 mb-2"><i
                                class="fa-solid fa-money-bill-1 text-4xl group-hover:scale-110 transition-transform"></i>
                        </div>
                        <p class="text-gray-400 text-[10px] font-bold uppercase tracking-widest">eAlbum Credits Available</p>
                        <h2 class="text-3xl font-black text-gray-800">{{ Auth::user()->credits }}</h2>
                        <a href="{{ route('admin.razorpay.index')}}"
                            class="text-blue-600 font-bold text-xs mt-1 hover:underline">Buy Credits</a>
                    </div>

                    <div
                        class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100 flex flex-col items-center text-center group hover:shadow-md transition-all">
                        <div class="text-amber-400 mb-2"><i
                                class="fa-solid fa-crown text-4xl group-hover:scale-110 transition-transform"></i></div>
                        <p class="text-gray-400 text-[10px] leading-tight font-bold uppercase tracking-tighter">No Active
                            Subscription</p>
                        <a href="{{ route('admin.razorpay.index') }}"
                            class="text-blue-600 font-bold text-xs mt-1 hover:underline">Get Subscription</a>
                    </div>

                    <div
                        class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100 flex flex-col items-center text-center group hover:shadow-md transition-all">
                        <div class="text-green-500 mb-2"><i
                                class="fa-solid fa-phone-volume text-4xl group-hover:scale-110 transition-transform"></i>
                        </div>
                        <p class="text-gray-400 text-[10px] font-bold uppercase tracking-widest">For support contact</p>
                        <h2 class="text-blue-600 font-bold text-lg">+91 9137634193</h2>
                    </div>
                </div>

                <div class="grid grid-cols-1 lg:grid-cols-2 gap-4">
                    <div class="flex gap-2">
                        <a href="{{ route('admin.studio') }}"
                            class="bg-blue-600 text-white px-6 py-3 rounded-xl text-sm font-bold whitespace-nowrap shadow-md hover:bg-blue-700 transition">Create
                            EAlbum</a>
                    </div>
                </div>

                <div class="bg-white rounded-3xl shadow-sm border border-gray-100 overflow-hidden">
                    <div class="p-6 border-b border-gray-50 bg-gray-50/30 flex justify-between items-center">
                        <h3 class="font-bold text-gray-800 text-lg">Your Projects</h3>
                        <div class="text-xs text-gray-500">
                            Show <select class="border rounded p-1 mx-1">
                                <option>10</option>
                            </select> entries
                        </div>
                    </div>

                    <div class="overflow-x-auto p-4 custom-scrollbar">
                        <table class="w-full text-left border-collapse min-w-[1150px]">
                            <thead
                                class="bg-gray-50/50 text-gray-500 text-[11px] font-bold uppercase tracking-wider border-y border-gray-100">
                                <tr>
                                    <th class="px-4 py-4">ID</th>
                                    <th class="px-4 py-4">Unique Code</th>
                                    <th class="px-4 py-4">Album Type</th>
                                    <th class="px-4 py-4">Title</th>
                                    <th class="px-4 py-4">Contact Person Name</th>
                                    <th class="px-4 py-4">Photography Exp.</th>
                                    <th class="px-4 py-4">Contact No</th>
                                    <th class="px-4 py-4">Created On</th>
                                    <th class="px-4 py-4">End Validity Date</th>
                                    <th class="px-4 py-4 text-center">Action</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-100 text-[12px]">
    @foreach ($albums as $data)
        <tr class="hover:bg-indigo-50/30 transition-all group">
            <td class="px-2 py-4 font-bold text-blue-600 text-center">{{ $loop->iteration }}</td>
            <td class="px-2 py-4 font-medium">{{ $data->album->unique_code }}</td>
            <td class="px-2 py-4">
                <span class="bg-blue-100 text-blue-600 px-2 py-0.5 rounded text-[9px] font-bold uppercase block w-max">
                    {{ $data->album->album_type ?? 'N/A' }}
                </span>
            </td>
            <td class="px-2 py-4 font-bold text-gray-700 max-w-[150px] whitespace-normal leading-tight">
                {{ $data->album->album_name }}
            </td>
            <td class="px-2 py-4 whitespace-nowrap">{{ $data->contact_person }}</td>
            <td class="px-2 py-4 whitespace-nowrap">{{ $data->experience }}</td>
            <td class="px-2 py-4">{{ $data->studio_contact }}</td>
            <td class="px-2 py-4 whitespace-nowrap">{{ $data->created_at->format('d M, Y') }}</td>
            <td class="px-2 py-4 text-gray-400">--</td>
            <td class="px-2 py-4">
                <div class="flex items-center justify-start gap-2 flex-nowrap">
                    <button type="button"
                        class="px-3 py-1.5 rounded-lg bg-purple-50 text-purple-600 hover:bg-purple-600 hover:text-white transition-all duration-300 shadow-sm text-[11px] whitespace-nowrap btn-extend-validity">
                        Extend Validity
                    </button>

                    <a href="{{ route('admin.gallery.update', $data->id) }}"
                        class="px-3 py-1.5 rounded-lg bg-blue-50 text-blue-600 hover:bg-blue-600 hover:text-white transition-all duration-300 shadow-sm text-[11px]">
                        Edit
                    </a>

                    <form action="{{ route('admin.album.destroy', $data->id) }}" method="POST"
                        onsubmit="return confirm('Are you sure you want to delete this album?')" class="inline">
                        @csrf
                        @method('DELETE')
                        <button type="submit"
                            class="flex items-center gap-1 px-3 py-1.5 rounded-lg bg-red-50 text-red-600 hover:bg-red-600 hover:text-white transition-all duration-300 shadow-sm text-[11px]">
                            <i class="fa-solid fa-trash-can text-[10px]"></i>
                            Delete
                        </button>
                    </form>
                </div>
            </td>
        </tr>
    @endforeach
</tbody>
                        </table>
                    </div>

                    <div class="p-4 border-t border-gray-50 flex justify-between items-center text-xs text-gray-500">
                        <div>Showing 1 to {{ $albums->count() }} of {{ $albums->count() }} entries</div>
                        <div class="flex gap-1">
                            <button class="px-3 py-1.5 border rounded-lg hover:bg-gray-50 transition">Previous</button>
                            <button class="px-3 py-1.5 bg-indigo-600 text-white rounded-lg">1</button>
                            <button class="px-3 py-1.5 border rounded-lg hover:bg-gray-50 transition">Next</button>
                        </div>
                    </div>
                </div>

                <div class="mt-8">
                    <h4 class="text-lg font-bold text-gray-800 mb-6">How to create eAlbum? <span
                            class="text-red-500 text-sm font-normal cursor-pointer ml-2 hover:underline">Watch Video
                            Guide</span></h4>
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

    <div id="validityModal" class="fixed inset-0 z-[100] hidden items-center justify-center p-4">
        <div class="absolute inset-0 bg-black/50 backdrop-blur-sm closeModalTrigger"></div>

        <div class="relative bg-white w-full max-w-lg rounded-2xl shadow-2xl overflow-hidden transform transition-all duration-300 scale-95 opacity-0"
            id="validityModalContent">
            <div class="p-5 border-b border-gray-100 flex justify-between items-center bg-gray-50/50">
                <h3 class="text-gray-700 font-bold text-sm uppercase tracking-wider">Extend Validity</h3>
                <button
                    class="closeModalTrigger text-gray-400 hover:text-red-500 transition-colors text-3xl">&times;</button>
            </div>

            <div class="p-8 space-y-6">
                <h2 class="text-2xl font-bold text-green-600">Extend eAlbum Validity</h2>
                <p class="text-sm text-gray-500 leading-relaxed">
                    Select the desired validity period for your eAlbum and note the corresponding credit deductions:
                </p>

                <div class="space-y-2">
                    <label class="block text-xs font-black text-gray-400 uppercase tracking-widest">Choose Validity
                        Period:</label>
                    <select
                        class="w-full border-2 border-gray-100 rounded-xl p-3 text-sm focus:ring-2 focus:ring-indigo-400 outline-none transition-all appearance-none bg-no-repeat bg-[right_1rem_center] bg-[url('data:image/svg+xml;charset=US-ASCII,%3Csvg%20width%3D%2220%22%20height%3D%2220%22%20viewBox%3D%220%200%2020%2020%22%20fill%3D%22none%22%20xmlns%3D%22http%3A//www.w3.org/2000/svg%22%3E%3Cpath%20d%3D%22M5%207L10%2012L15%207%22%20stroke%3D%22%236B7280%22%20stroke-width%3D%221.5%22%20stroke-linecap%3D%22round%22%20stroke-linejoin%3D%22round%22/%3E%3C/svg%3E')]">
                        <option value="1">1 Year - Deduct 1 Credit</option>
                        <option value="2">2 Years - Deduct 2 Credits</option>
                        <option value="3">3 Years - Deduct 3 Credits</option>
                        <option value="4">4 Years - Deduct 4 Credits</option>
                        <option value="5">5 Years - Deduct 5 Credits</option>
                        <option value="6">6 Years - Deduct 6 Credits</option>
                        <option value="7">7 Years - Deduct 7 Credits</option>
                        <option value="8">8 Years - Deduct 8 Credits</option>
                        <option value="9">9 Years - Deduct 9 Credits</option>
                        <option value="10">10 Years - Deduct 10 Credits</option>
                    </select>
                </div>

                <button
                    class="w-full bg-blue-600 text-white py-4 rounded-xl font-bold shadow-lg shadow-blue-100 hover:bg-blue-700 transition active:scale-95">
                    Confirm Extension
                </button>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script>
        $(document).ready(function () {
            // 1. Sidebar Toggle
            $(document).on('click', '#toggleSidebar', function (e) {
                e.preventDefault();
                $('#sidebar-container').toggleClass('collapsed-sidebar');
            });

            // 2. OPEN VALIDITY MODAL
            $(document).on('click', '.btn-extend-validity', function () {
                $('#validityModal').removeClass('hidden').addClass('flex');
                setTimeout(() => {
                    $('#validityModalContent').removeClass('scale-95 opacity-0').addClass('scale-100 opacity-100');
                }, 10);
            });

            // 3. CLOSE MODAL Logic
            $(document).on('click', '.closeModalTrigger', function () {
                $('#validityModalContent').removeClass('scale-100 opacity-100').addClass('scale-95 opacity-0');
                setTimeout(() => {
                    $('#validityModal').addClass('hidden').removeClass('flex');
                }, 300);
            });

            // 4. Hover Bounce Effect
            $('.bg-white').hover(
                function () { $(this).find('i').addClass('fa-bounce'); },
                function () { $(this).find('i').removeClass('fa-bounce'); }
            );
        });
    </script>
@endsection