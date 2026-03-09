@extends('admin.pages.adminApp')

@section('content')
    <div class="flex h-screen overflow-hidden bg-[#f4f7fe]">
        @include('admin.extra.sidebar')

        <div id="main-panel" class="flex-1 flex flex-col min-w-0 transition-all duration-500 ease-in-out">
            @include('admin.extra.header')

            <div class="flex-1 overflow-y-auto p-6 space-y-6 custom-scrollbar">
                <div class="bg-white rounded-3xl shadow-sm border border-gray-100 p-8 min-h-[500px]">
                    <div class="flex justify-between items-center mb-6">
                        <h2 class="text-xl font-bold text-gray-800 tracking-tight">History</h2>
                        <button id="btnBuyCreditsPopup"
                            class="bg-[#3498db] hover:bg-[#2980b9] text-white px-5 py-2 rounded-lg text-sm font-semibold transition-all flex items-center gap-2 shadow-md">
                            <i class="fa-regular fa-address-book"></i> Buy eAlbum Credits
                        </button>
                    </div>

                    <div class="flex gap-8 border-b border-gray-100 mb-6 text-sm font-semibold">
                        <button class="history-tab active pb-3 border-b-2 border-blue-500 text-blue-600">Credits Buy
                            History</button>
                    </div>

                    <div class="space-y-4">
                        <div class="flex justify-between items-center text-xs text-gray-500">
                            <div>Show <select class="border rounded p-1 mx-1 outline-none">
                                    <option>10</option>
                                </select> entries</div>
                            <div class="flex items-center gap-2">Search: <input type="text"
                                    class="border rounded p-1.5 outline-none w-48 focus:ring-1 focus:ring-blue-400 shadow-sm">
                            </div>
                        </div>

                        <div class="overflow-x-auto">
                            <table class="w-full text-left text-xs whitespace-nowrap" id="creditsDataTable">
                                <thead
                                    class="bg-gray-50/50 text-gray-500 font-bold uppercase tracking-widest border-y border-gray-100">
                                    <tr id="tableHeaderRow">
                                        <th class="px-4 py-4">#</th>
                                        <th class="px-4 py-4">Order Id</th>
                                        <th class="px-4 py-4">Credit Purchase Date</th>
                                        <th class="px-4 py-4">Album Name</th>
                                        <th class="px-4 py-4">Number Of Credits</th>
                                        <th class="px-4 py-4">Amount</th>
                                        <th class="px-4 py-4">Payment Type</th>
                                        <th class="px-4 py-4">Message</th>
                                        <th class="px-4 py-4">Status</th>
                                        <th class="px-4 py-4">Created On</th>
                                    </tr>
                                </thead>
                                <tbody id="tableBodyData" class="divide-y divide-gray-100">
                                    @forelse($creditHistory as $index => $item)
                                        <tr>
                                            <td class="px-4 py-4">{{ $index + 1 }}</td>
                                            <td class="px-4 py-4">{{ $item->order_id }}</td>
                                            <td class="px-4 py-4">
                                                {{ \Carbon\Carbon::parse($item->purchase_date)->format('d-M-Y') }}</td>
                                            <td class="px-4 py-4">{{ $item->album_name }}</td>
                                            <td class="px-4 py-4 font-bold text-blue-600">{{ $item->credits }}</td>
                                            <td class="px-4 py-4">₹{{ number_class($item->amount) }}</td>
                                            <td class="px-4 py-4">{{ $item->payment_type }}</td>
                                            <td class="px-4 py-4 text-gray-400 italic">{{ $item->message }}</td>
                                            <td class="px-4 py-4">
                                                <span
                                                    class="px-2 py-1 rounded-full text-[10px] {{ $item->status == 'Success' ? 'bg-green-100 text-green-600' : 'bg-yellow-100 text-yellow-600' }}">
                                                    {{ $item->status }}
                                                </span>
                                            </td>
                                            <td class="px-4 py-4">{{ $item->created_at->diffForHumans() }}</td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="10" class="text-center py-16 text-gray-400 font-medium italic">
                                                No credit history found.
                                            </td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>

                        <div class="pt-4 flex flex-col space-y-4">
                            <div class="flex justify-between items-center text-xs text-gray-400">
                                <p>Showing 0 to 0 of 0 entries</p>
                                <div class="flex gap-4 font-semibold uppercase tracking-tighter">
                                    <button class="hover:text-gray-600">Previous</button>
                                    <button class="px-3 py-1 bg-gray-100 rounded">1</button>
                                    <button class="hover:text-gray-600">Next</button>
                                </div>
                            </div>
                            <div class="w-full h-1.5 bg-gray-100 rounded-full relative">
                                <div class="absolute left-0 top-0 h-full bg-gray-200 w-1/3 rounded-full"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div id="modalBuyCredits" class="fixed inset-0 z-[999] hidden items-center justify-center p-4">
        <div class="absolute inset-0 bg-black/60 backdrop-blur-sm" id="modalBackdrop"></div>

        <div class="relative bg-white w-full max-w-6xl rounded-2xl shadow-2xl flex flex-col max-h-[90vh] overflow-hidden transform transition-all duration-300 scale-95 opacity-0"
            id="modalUI">
            <div class="p-5 border-b border-gray-100 flex justify-between items-center bg-gray-50/50">
                <h3 class="text-gray-700 font-bold text-sm">Buy Credits ( Credits are used to create digital Photobook )
                </h3>
                <button
                    class="close-modal-trigger text-gray-400 hover:text-red-500 transition-colors text-3xl">&times;</button>
            </div>

            <div class="flex-1 overflow-y-auto p-10 custom-scrollbar">
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8 pb-10">

                    <div
                        class="pricing-card border border-gray-100 p-8 rounded-3xl text-center flex flex-col transition-all duration-300 hover:shadow-2xl hover:-translate-y-2 hover:border-blue-100 cursor-pointer bg-white group">
                        <span
                            class="text-[10px] font-black text-gray-300 tracking-widest uppercase mb-2 group-hover:text-blue-400">Basic
                            Plan</span>
                        <h2 class="text-3xl font-black text-gray-700 mb-2">₹999<span
                                class="text-sm font-medium text-gray-400">/Year</span></h2>
                        <p class="text-[10px] text-gray-400 mb-6 font-bold uppercase tracking-tighter">Best for small
                            photographers</p>

                        <ul class="text-[11px] text-gray-500 mb-8 text-left pl-2 font-medium space-y-2 leading-relaxed">
                            <li class="flex items-start">
                                <svg class="w-3 h-3 text-green-500 mr-2 mt-0.5 flex-shrink-0" fill="none"
                                    stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3"
                                        d="M5 13l4 4L19 7"></path>
                                </svg>
                                <span>Up to 10 albums per year</span>
                            </li>
                            <li class="flex items-start">
                                <svg class="w-3 h-3 text-green-500 mr-2 mt-0.5 flex-shrink-0" fill="none"
                                    stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3"
                                        d="M5 13l4 4L19 7"></path>
                                </svg>
                                <span>Up to 100 photos per album</span>
                            </li>
                            <li class="flex items-start">
                                <svg class="w-3 h-3 text-green-500 mr-2 mt-0.5 flex-shrink-0" fill="none"
                                    stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3"
                                        d="M5 13l4 4L19 7"></path>
                                </svg>
                                <span>Shareable album link</span>
                            </li>
                            <li class="flex items-start">
                                <svg class="w-3 h-3 text-green-500 mr-2 mt-0.5 flex-shrink-0" fill="none"
                                    stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3"
                                        d="M5 13l4 4L19 7"></path>
                                </svg>
                                <span>WhatsApp sharing</span>
                            </li>
                            <li class="flex items-start">
                                <svg class="w-3 h-3 text-green-500 mr-2 mt-0.5 flex-shrink-0" fill="none"
                                    stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3"
                                        d="M5 13l4 4L19 7"></path>
                                </svg>
                                <span>Mobile-friendly gallery</span>
                            </li>
                            <li class="flex items-start">
                                <svg class="w-3 h-3 text-green-500 mr-2 mt-0.5 flex-shrink-0" fill="none"
                                    stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3"
                                        d="M5 13l4 4L19 7"></path>
                                </svg>
                                <span>QR code for album</span>
                            </li>
                            <li class="flex items-start opacity-50">
                                <svg class="w-3 h-3 text-green-500 mr-2 mt-0.5 flex-shrink-0" fill="none"
                                    stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3"
                                        d="M5 13l4 4L19 7"></path>
                                </svg>
                                <span>Basic support</span>
                            </li>
                        </ul>
                        <form action="{{ route('razorpay.payment') }}" method="POST">
                            @csrf
                            <input type="hidden" name="amount" value="999">
                            <input type="hidden" name="plan_name" value="Basic Plan">
                            <button type="submit"
                                class="w-full mt-auto bg-[#3498db]/80 text-white py-3 rounded-full text-[11px] font-black uppercase hover:bg-[#3498db] shadow-md transition">Buy
                                Now</button>
                        </form>
                    </div>

                    <div
                        class="pricing-card border-2 border-blue-100 p-8 rounded-3xl text-center flex flex-col transition-all duration-300 shadow-xl -translate-y-2 hover:shadow-2xl cursor-pointer bg-white group relative">
                        <div
                            class="absolute -top-4 left-1/2 -translate-x-1/2 bg-blue-500 text-white text-[9px] font-black px-4 py-1 rounded-full uppercase">
                            Most Popular</div>
                        <span class="text-[10px] font-black text-blue-400 tracking-widest uppercase mb-2">Pro Plan</span>
                        <h2 class="text-3xl font-black text-gray-700 mb-2">₹2,499<span
                                class="text-sm font-medium text-gray-400">/Year</span></h2>
                        <p class="text-[10px] text-gray-400 mb-6 font-bold uppercase tracking-tighter">Professional
                            Photographers</p>

                        <ul class="text-[11px] text-gray-500 mb-8 text-left pl-2 font-medium space-y-2 leading-relaxed">
                            <li class="flex items-start">
                                <svg class="w-3 h-3 text-green-500 mr-2 mt-0.5 flex-shrink-0" fill="none"
                                    stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3"
                                        d="M5 13l4 4L19 7"></path>
                                </svg>
                                <span>Up to 30 albums per year</span>
                            </li>
                            <li class="flex items-start">
                                <svg class="w-3 h-3 text-green-500 mr-2 mt-0.5 flex-shrink-0" fill="none"
                                    stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3"
                                        d="M5 13l4 4L19 7"></path>
                                </svg>
                                <span>Up to 300 photos per album</span>
                            </li>
                            <li class="flex items-start">
                                <svg class="w-3 h-3 text-green-500 mr-2 mt-0.5 flex-shrink-0" fill="none"
                                    stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3"
                                        d="M5 13l4 4L19 7"></path>
                                </svg>
                                <span>Password protected albums</span>
                            </li>
                            <li class="flex items-start">
                                <svg class="w-3 h-3 text-green-500 mr-2 mt-0.5 flex-shrink-0" fill="none"
                                    stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3"
                                        d="M5 13l4 4L19 7"></path>
                                </svg>
                                <span>Custom cover photo</span>
                            </li>
                            <li class="flex items-start">
                                <svg class="w-3 h-3 text-green-500 mr-2 mt-0.5 flex-shrink-0" fill="none"
                                    stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3"
                                        d="M5 13l4 4L19 7"></path>
                                </svg>
                                <span>WhatsApp & social share</span>
                            </li>
                            <li class="flex items-start">
                                <svg class="w-3 h-3 text-green-500 mr-2 mt-0.5 flex-shrink-0" fill="none"
                                    stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3"
                                        d="M5 13l4 4L19 7"></path>
                                </svg>
                                <span>Download option for clients</span>
                            </li>
                            <li class="flex items-start">
                                <svg class="w-3 h-3 text-green-500 mr-2 mt-0.5 flex-shrink-0" fill="none"
                                    stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3"
                                        d="M5 13l4 4L19 7"></path>
                                </svg>
                                <span class="text-blue-500 font-bold text-[9px]">PRIORITY SUPPORT</span>
                            </li>
                        </ul>
                        <form action="{{ route('razorpay.payment') }}" method="POST">
                            @csrf
                            <input type="hidden" name="amount" value="2499">
                            <input type="hidden" name="plan_name" value="Pro Plan">
                            <button type="submit"
                                class="w-full mt-auto bg-blue-500 text-white py-3 rounded-full text-[11px] font-black uppercase hover:bg-blue-600 shadow-lg shadow-blue-100 transition">Buy
                                Now</button>
                        </form>
                    </div>

                    <div
                        class="pricing-card border border-gray-100 p-8 rounded-3xl text-center flex flex-col transition-all duration-300 hover:shadow-2xl hover:-translate-y-2 hover:border-blue-100 cursor-pointer bg-white group">
                        <span
                            class="text-[10px] font-black text-gray-300 tracking-widest uppercase mb-2 group-hover:text-blue-400">Studio
                            Plan</span>
                        <h2 class="text-3xl font-black text-gray-700 mb-2">₹4,999<span
                                class="text-sm font-medium text-gray-400">/Year</span></h2>
                        <p class="text-[10px] text-gray-400 mb-6 font-bold uppercase tracking-tighter">Best for heavy users
                        </p>

                        <ul class="text-[11px] text-gray-500 mb-8 text-left pl-2 font-medium space-y-2 leading-relaxed">
                            <li class="flex items-start">
                                <svg class="w-3 h-3 text-green-500 mr-2 mt-0.5 flex-shrink-0" fill="none"
                                    stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3"
                                        d="M5 13l4 4L19 7"></path>
                                </svg>
                                <span><b>Unlimited</b> albums & photos</span>
                            </li>
                            <li class="flex items-start">
                                <svg class="w-3 h-3 text-green-500 mr-2 mt-0.5 flex-shrink-0" fill="none"
                                    stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3"
                                        d="M5 13l4 4L19 7"></path>
                                </svg>
                                <span>Custom branding (studio logo)</span>
                            </li>
                            <li class="flex items-start">
                                <svg class="w-3 h-3 text-green-500 mr-2 mt-0.5 flex-shrink-0" fill="none"
                                    stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3"
                                        d="M5 13l4 4L19 7"></path>
                                </svg>
                                <span>Custom domain option</span>
                            </li>
                            <li class="flex items-start">
                                <svg class="w-3 h-3 text-green-500 mr-2 mt-0.5 flex-shrink-0" fill="none"
                                    stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3"
                                        d="M5 13l4 4L19 7"></path>
                                </svg>
                                <span>Analytics (views, downloads)</span>
                            </li>
                            <li class="flex items-start">
                                <svg class="w-3 h-3 text-green-500 mr-2 mt-0.5 flex-shrink-0" fill="none"
                                    stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3"
                                        d="M5 13l4 4L19 7"></path>
                                </svg>
                                <span>Password protected albums</span>
                            </li>
                            <li class="flex items-start">
                                <svg class="w-3 h-3 text-green-500 mr-2 mt-0.5 flex-shrink-0" fill="none"
                                    stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3"
                                        d="M5 13l4 4L19 7"></path>
                                </svg>
                                <span>QR code sharing</span>
                            </li>
                            <li class="flex items-start">
                                <svg class="w-3 h-3 text-green-500 mr-2 mt-0.5 flex-shrink-0" fill="none"
                                    stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3"
                                        d="M5 13l4 4L19 7"></path>
                                </svg>
                                <span>Priority support</span>
                            </li>
                        </ul>
                        <form action="{{ route('razorpay.payment') }}" method="POST">
                            @csrf
                            <input type="hidden" name="amount" value="4999">
                            <input type="hidden" name="plan_name" value="Studio Plan">
                            <button type="submit"
                                class="w-full mt-auto bg-gray-800 text-white py-3 rounded-full text-[11px] font-black uppercase hover:bg-black shadow-md transition">Buy
                                Now</button>
                        </form>
                    </div>

                </div>
            </div>

            <div class="p-5 border-t border-gray-50 flex justify-end bg-gray-50/50">
                <button
                    class="close-modal-trigger bg-white border border-gray-200 text-gray-600 px-8 py-2.5 rounded-xl text-sm font-bold hover:bg-gray-50 transition shadow-sm">Close</button>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script>
        $(document).ready(function () {
            // 1. SIDEBAR TOGGLE LOGIC
            $(document).on('click', '#toggleSidebar', function (e) {
                e.preventDefault();
                $('#sidebar-container').toggleClass('collapsed-sidebar');
            });

            // 2. POPUP LOGIC: Open with Scale Animation
            $(document).on('click', '#btnBuyCreditsPopup', function () {
                $('#modalBuyCredits').removeClass('hidden').addClass('flex');
                setTimeout(() => {
                    $('#modalUI').removeClass('scale-95 opacity-0').addClass('scale-100 opacity-100');
                }, 10);
                $('body').addClass('overflow-hidden');
            });

            // 3. CLOSE MODAL Logic
            $(document).on('click', '.close-modal-trigger, #modalBackdrop', function () {
                $('#modalUI').removeClass('scale-100 opacity-100').addClass('scale-95 opacity-0');
                setTimeout(() => {
                    $('#modalBuyCredits').addClass('hidden').removeClass('flex');
                }, 300);
                $('body').removeClass('overflow-hidden');
            });
        });
    </script>
@endsection