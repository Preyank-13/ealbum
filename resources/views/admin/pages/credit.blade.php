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
                        <button class="history-tab active pb-3 border-b-2 border-blue-500 text-blue-600">Credits Buy History</button>
                    </div>

                    <div class="space-y-4">
                        <div class="flex justify-between items-center text-xs text-gray-500">
                            <div>Show <select class="border rounded p-1 mx-1 outline-none"><option>10</option></select> entries</div>
                            <div class="flex items-center gap-2">Search: <input type="text" class="border rounded p-1.5 outline-none w-48 focus:ring-1 focus:ring-blue-400 shadow-sm"></div>
                        </div>

                        <div class="overflow-x-auto">
                            <table class="w-full text-left text-xs whitespace-nowrap" id="creditsDataTable">
                                <thead class="bg-gray-50/50 text-gray-500 font-bold uppercase tracking-widest border-y border-gray-100 text-center">
                                    <tr id="tableHeaderRow">
                                        <th class="px-4 py-4">ID</th>
                                        <th class="px-4 py-4">Order Id</th>
                                        <th class="px-4 py-4">Credit Purchase Date</th>
                                        <th class="px-4 py-4">Your Plan</th>
                                        <th class="px-4 py-4">Added Credits</th>
                                        <th class="px-4 py-4">Purchased Amount</th>
                                        <th class="px-4 py-4">Payment Type</th>
                                        <th class="px-4 py-4">Message</th>
                                        <th class="px-4 py-4">Status</th>
                                        <th class="px-4 py-4">Created On</th>
                                    </tr>
                                </thead>
                                <tbody id="tableBodyData" class="divide-y divide-gray-100">
                                    @forelse($creditHistory as $history)
                                        <tr class="hover:bg-gray-50/50 transition-all">
                                            <td class="px-4 py-4 text-gray-600 text-center">{{ $loop->iteration }}</td>

                                            {{-- Order ID / Album Created Column --}}
                                            <td class="px-4 py-4 font-medium text-gray-800 text-center">
                                                @if($history->payment_type == 'Debit')
                                                    <span class="text-red-600 font-bold">{{ $history->album_name ?? 'Album' }} Created</span>
                                                @else
                                                    {{ $history->order_id }}
                                                @endif
                                            </td>

                                            <td class="px-4 py-4 text-gray-600 text-center">
                                                {{ \Carbon\Carbon::parse($history->purchase_date)->format('d-M-Y') }}
                                            </td>

                                            {{-- 🟢 FIXED: Your Plan Column --}}
                                            <td class="px-4 py-4 text-gray-600 text-center font-semibold">
                                                @if($history->payment_type == 'Debit')
                                                    {{-- Album banane ke waqt user ka jo active plan tha wo dikhao --}}
                                                    {{ auth()->user()->active_plan ?? 'Basic Plan' }}
                                                @else
                                                    {{-- Purchase ke waqt jo plan kharida wo dikhao --}}
                                                    {{ $history->album_name ?? 'N/A' }}
                                                @endif
                                            </td>

                                            <td
                                                class="px-4 py-4 font-bold text-center {{ $history->payment_type == 'Debit' ? 'text-red-500' : 'text-green-500' }}">
                                                {{ $history->payment_type == 'Debit' ? '-' : '+' }}{{ $history->credits }}
                                            </td>

                                            <td class="px-4 py-4 font-semibold text-center">
                                                @if($history->payment_type == 'Debit')
                                                    {{-- 🟢 Album Creation Row Logic --}}

                                                    @if(auth()->user()->active_plan == 'Studio' || auth()->user()->active_plan == 'Studio Plan' || auth()->user()->is_unlimited)
                                                        {{-- Studio Plan UI --}}
                                                        <div class="flex flex-col items-center justify-center">
                                                            <span class="text-blue-600 text-xl font-black leading-none">∞</span>
                                                            <span class="text-[9px] text-blue-400 font-bold uppercase tracking-tighter mt-1">Albums Left to Create</span>
                                                        </div>
                                                    @else
                                                        {{-- Basic/Pro Plan UI --}}
                                                        @php
                                                            // Plan ke hisaab se limit set karein
                                                            $planName = auth()->user()->active_plan;
                                                            $limit = (str_contains($planName, 'Pro')) ? 30 : 10;

                                                            // $albums variable aapke controller se aana chahiye
                                                            $currentCount = isset($albums) ? $albums->count() : 0;
                                                            $left = $limit - $currentCount;
                                                        @endphp
                                                        <div class="flex flex-col items-center justify-center">
                                                            <span class="text-indigo-600 font-black text-sm">{{ max($left, 0) }} Albums Left</span>
                                                            <span class="text-[9px] text-gray-400 font-bold uppercase tracking-tighter mt-0.5">for your
                                                                {{ $planName }}</span>
                                                        </div>
                                                    @endif

                                                @else
                                                    {{-- 🔵 Normal Plan Purchase Row (Real Price) --}}
                                                    <span class="text-gray-800 font-bold">₹{{ number_format($history->amount, 2) }}</span>
                                                @endif
                                            </td>

                                            <td class="px-4 py-4 text-gray-600 text-center">{{ $history->payment_type }}</td>
                                            <td class="px-4 py-4 text-gray-400 text-xs text-center">{{ $history->message }}</td>

                                            <td class="px-4 py-4 text-center">
                                                @if($history->payment_type == 'Debit')
                                                    <span class="px-2 py-1 rounded-full text-[10px] font-bold uppercase bg-red-100 text-red-600">
                                                        Credit Used
                                                    </span>
                                                @else
                                                    <span
                                                        class="px-2 py-1 rounded-full text-[10px] font-bold uppercase {{ $history->status == 'Success' ? 'bg-green-100 text-green-600' : 'bg-red-100 text-red-600' }}">
                                                        {{ $history->status }}
                                                    </span>
                                                @endif
                                            </td>

                                            <td class="px-4 py-4 text-gray-500 text-[10px] text-center">
                                                {{ $history->created_at->diffForHumans() }}
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="10" class="text-center py-10 text-gray-400">No transaction history found.</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Script for Sidebar & Popup --}}
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script>
        $(document).ready(function () {
            $(document).on('click', '#toggleSidebar', function (e) {
                e.preventDefault();
                $('#sidebar-container').toggleClass('collapsed-sidebar');
            });

            $(document).on('click', '#btnBuyCreditsPopup', function () {
                $('#modalBuyCredits').removeClass('hidden').addClass('flex');
                setTimeout(() => {
                    $('#modalUI').removeClass('scale-95 opacity-0').addClass('scale-100 opacity-100');
                }, 10);
                $('body').addClass('overflow-hidden');
            });

            $(document).on('click', '.close-modal-trigger, #modalBackdrop', function () {
                $('#modalUI').removeClass('scale-100 opacity-100').addClass('scale-95 opacity-0');
                setTimeout(() => {
                    $('#modalBuyCredits').addClass('hidden').removeClass('flex');
                }, 300);
                $('body').removeClass('overflow-hidden');
            });
        });
    </script>

    @include('admin.extra.popup')
@endsection