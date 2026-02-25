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
                    <button id="btnBuyCreditsPopup" class="bg-[#3498db] hover:bg-[#2980b9] text-white px-5 py-2 rounded-lg text-sm font-semibold transition-all flex items-center gap-2 shadow-md">
                        <i class="fa-regular fa-address-book"></i> Buy eAlbum Credits
                    </button>
                </div>

                <div class="flex gap-8 border-b border-gray-100 mb-6 text-sm font-semibold">
                    <button class="history-tab active pb-3 border-b-2 border-blue-500 text-blue-600" data-view="buy">Credits Buy History</button>
                    <button class="history-tab pb-3 text-gray-400 hover:text-gray-600 transition" data-view="redeem">Redeem Coupons History</button>
                </div>

                <div class="space-y-4">
                    <div class="flex justify-between items-center text-xs text-gray-500">
                        <div>Show <select class="border rounded p-1 mx-1 outline-none"><option>10</option></select> entries</div>
                        <div class="flex items-center gap-2">Search: <input type="text" class="border rounded p-1.5 outline-none w-48 focus:ring-1 focus:ring-blue-400 shadow-sm"></div>
                    </div>

                    <div class="overflow-x-auto">
                        <table class="w-full text-left text-xs whitespace-nowrap" id="creditsDataTable">
                            <thead class="bg-gray-50/50 text-gray-500 font-bold uppercase tracking-widest border-y border-gray-100">
                                <tr id="tableHeaderRow">
                                    <th class="px-4 py-4">#</th>
                                    <th class="px-4 py-4">Order Id</th>
                                    <th class="px-4 py-4">Product Type</th>
                                    <th class="px-4 py-4">Number Of Credits</th>
                                    <th class="px-4 py-4">Amount</th>
                                    <th class="px-4 py-4">Message</th>
                                    <th class="px-4 py-4">Status</th>
                                    <th class="px-4 py-4">Created On</th>
                                </tr>
                            </thead>
                            <tbody id="tableBodyData" class="divide-y divide-gray-100">
                                <tr><td colspan="8" class="text-center py-16 text-gray-400 font-medium italic">No data available in table</td></tr>
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
                        <div class="w-full h-1.5 bg-gray-100 rounded-full relative"><div class="absolute left-0 top-0 h-full bg-gray-200 w-1/3 rounded-full"></div></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div id="modalBuyCredits" class="fixed inset-0 z-[999] hidden items-center justify-center p-4">
    <div class="absolute inset-0 bg-black/60 backdrop-blur-sm" id="modalBackdrop"></div>
    
    <div class="relative bg-white w-full max-w-6xl rounded-2xl shadow-2xl flex flex-col max-h-[90vh] overflow-hidden transform transition-all duration-300 scale-95 opacity-0" id="modalUI">
        <div class="p-5 border-b border-gray-100 flex justify-between items-center bg-gray-50/50">
            <h3 class="text-gray-700 font-bold text-sm">Buy Credits(Credits are used to create eAlbum(ebook) project)</h3>
            <button class="close-modal-trigger text-gray-400 hover:text-red-500 transition-colors text-3xl">&times;</button>
        </div>

        <div class="flex-1 overflow-y-auto p-10 custom-scrollbar">
            <div class="flex gap-3 mb-12">
                <input type="text" placeholder="Enter Coupon" class="w-full max-w-[280px] border-gray-200 border rounded-full px-6 py-2.5 text-sm outline-none focus:ring-2 focus:ring-blue-100 shadow-inner">
                <button class="bg-[#3498db] text-white px-8 py-2.5 rounded-full text-sm font-bold shadow-lg hover:bg-blue-600 transition active:scale-95">Redeem</button>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 lg:grid-cols-5 gap-6 pb-10">
                <div class="pricing-card border border-gray-100 p-6 rounded-3xl text-center flex flex-col transition-all duration-300 hover:shadow-2xl hover:-translate-y-2 hover:border-blue-100 cursor-pointer bg-white group">
                    <span class="text-[10px] font-black text-gray-300 tracking-widest uppercase mb-2 group-hover:text-blue-400">Starter</span>
                    <h2 class="text-3xl font-black text-gray-700 mb-6">Rs. 160</h2>
                    <ul class="text-[11px] text-gray-500 space-y-4 mb-8 text-left pl-2 font-medium">
                        <li>• 5 Credits (5 eAlbum)</li>
                        <li>• Create 5 eBooks(eAlbum)</li>
                    </ul>
                    <button class="mt-auto bg-[#3498db]/80 text-white py-3 rounded-full text-[11px] font-black uppercase hover:bg-[#3498db] shadow-md transition">Buy</button>
                </div>

                <div class="pricing-card border border-gray-100 p-6 rounded-3xl text-center flex flex-col transition-all duration-300 hover:shadow-2xl hover:-translate-y-2 hover:border-blue-100 cursor-pointer bg-white group">
                    <span class="text-[10px] font-black text-gray-300 tracking-widest uppercase mb-2 group-hover:text-blue-400">Business</span>
                    <h2 class="text-3xl font-black text-gray-700 mb-6">Rs. 250</h2>
                    <ul class="text-[11px] text-gray-500 space-y-4 mb-8 text-left pl-2 font-medium">
                        <li>• 10 Credits (10 eAlbum)</li>
                        <li>• Create 10 eBooks(eAlbum)</li>
                    </ul>
                    <button class="mt-auto bg-[#3498db]/80 text-white py-3 rounded-full text-[11px] font-black uppercase hover:bg-[#3498db] shadow-md transition">Buy</button>
                </div>

                <div class="pricing-card border border-gray-100 p-6 rounded-3xl text-center flex flex-col transition-all duration-300 hover:shadow-2xl hover:-translate-y-2 hover:border-blue-100 cursor-pointer bg-white group">
                    <span class="text-[10px] font-black text-gray-300 tracking-widest uppercase mb-2 group-hover:text-blue-400">Ultimate</span>
                    <h2 class="text-3xl font-black text-gray-700 mb-6">Rs. 900</h2>
                    <ul class="text-[11px] text-gray-500 space-y-4 mb-8 text-left pl-2 font-medium">
                        <li>• 40 Credits (40 eAlbum)</li>
                        <li>• Create 40 eBooks(eAlbum)</li>
                    </ul>
                    <button class="mt-auto bg-[#3498db]/80 text-white py-3 rounded-full text-[11px] font-black uppercase hover:bg-[#3498db] shadow-md transition">Buy</button>
                </div>

                <div class="pricing-card bg-white p-6 rounded-3xl shadow-xl border-2 border-blue-50 flex flex-col text-center scale-105 ring-4 ring-blue-50/30 transition-all duration-300 hover:-translate-y-2 cursor-pointer z-10">
                    <span class="text-[10px] font-black text-blue-400 tracking-widest uppercase mb-2">1 Year Subscription</span>
                    <h2 class="text-3xl font-black text-gray-700 mb-6">Rs. 999</h2>
                    <ul class="text-[11px] text-gray-600 space-y-3 mb-8 text-left pl-2 font-bold">
                        <li>✓ 12 Months</li>
                        <li>✓ Recommended for You!</li>
                        <li>✓ Manage up to 60 projects</li>
                        <li>✓ 24/7 priority support</li>
                    </ul>
                    <button class="mt-auto bg-[#3498db] text-white py-3 rounded-full text-[11px] font-black uppercase hover:bg-blue-600 shadow-xl shadow-blue-100 transition">Buy</button>
                </div>

                <div class="pricing-card border border-gray-100 p-6 rounded-3xl text-center flex flex-col transition-all duration-300 hover:shadow-2xl hover:-translate-y-2 hover:border-blue-100 cursor-pointer bg-white group">
                    <span class="text-[10px] font-black text-gray-300 tracking-widest uppercase mb-2 group-hover:text-blue-400">Premium</span>
                    <h2 class="text-3xl font-black text-gray-700 mb-6">Rs. 7500</h2>
                    <ul class="text-[11px] text-gray-500 space-y-4 mb-8 text-left pl-2 font-medium">
                        <li>• 500 Credits (500 eAlbum)</li>
                        <li>• Create 500 eBooks(eAlbum)</li>
                    </ul>
                    <button class="mt-auto bg-[#3498db]/80 text-white py-3 rounded-full text-[11px] font-black uppercase hover:bg-[#3498db] shadow-md transition">Buy</button>
                </div>
            </div>

        </div>

        <div class="p-5 border-t border-gray-50 flex justify-end bg-gray-50/50">
            <button class="close-modal-trigger bg-white border border-gray-200 text-gray-600 px-8 py-2.5 rounded-xl text-sm font-bold hover:bg-gray-50 transition shadow-sm">Close</button>
        </div>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<script>
$(document).ready(function() {
    // 1. SIDEBAR TOGGLE LOGIC
    $(document).on('click', '#toggleSidebar', function(e) {
        e.preventDefault();
        $('#sidebar-container').toggleClass('collapsed-sidebar');
    });

    // 2. POPUP LOGIC: Open with Scale Animation
    $(document).on('click', '#btnBuyCreditsPopup', function() {
        $('#modalBuyCredits').removeClass('hidden').addClass('flex');
        setTimeout(() => {
            $('#modalUI').removeClass('scale-95 opacity-0').addClass('scale-100 opacity-100');
        }, 10);
        $('body').addClass('overflow-hidden');
    });

    // 3. CLOSE MODAL Logic
    $(document).on('click', '.close-modal-trigger, #modalBackdrop', function() {
        $('#modalUI').removeClass('scale-100 opacity-100').addClass('scale-95 opacity-0');
        setTimeout(() => {
            $('#modalBuyCredits').addClass('hidden').removeClass('flex');
        }, 300);
        $('body').removeClass('overflow-hidden');
    });

    // 4. TABS SWITCHING LOGIC
    $('.history-tab').on('click', function() {
        const view = $(this).data('view');
        $('.history-tab').removeClass('active border-b-2 border-blue-500 text-blue-600').addClass('text-gray-400');
        $(this).addClass('active border-b-2 border-blue-500 text-blue-600').removeClass('text-gray-400');

        if(view === 'buy') {
            $('#tableHeaderRow').html(`
                <th class="px-4 py-4">#</th>
                <th class="px-4 py-4">Order Id</th>
                <th class="px-4 py-4">Product Type</th>
                <th class="px-4 py-4">Number Of Credits</th>
                <th class="px-4 py-4">Amount</th>
                <th class="px-4 py-4">Message</th>
                <th class="px-4 py-4">Status</th>
                <th class="px-4 py-4">Created On</th>
            `);
        } else {
            $('#tableHeaderRow').html(`
                <th class="px-4 py-4">#</th>
                <th class="px-4 py-4">Product Type</th>
                <th class="px-4 py-4">Coupon Number</th>
                <th class="px-4 py-4">Number Of Credits</th>
                <th class="px-4 py-4">Redeem On</th>
            `);
        }
    });
});
</script>
@endsection