<div id="modalBuyCredits" class="fixed inset-0 z-[999] hidden items-center justify-center p-4">
    <div class="absolute inset-0 bg-black/60 backdrop-blur-sm" id="modalBackdrop"></div>

    <div class="relative bg-white w-full max-w-6xl rounded-[2.5rem] shadow-2xl flex flex-col max-h-[95vh] overflow-hidden transform transition-all duration-300 scale-95 opacity-0" id="modalUI">
        
        <div class="p-6 border-b border-gray-100 flex justify-between items-center bg-white">
            <h3 class="text-gray-800 font-bold text-sm tracking-tight">Upgrade Your Plan & Get More Features</h3>
            <button class="close-modal-trigger text-gray-400 hover:text-red-500 transition-colors text-3xl">
                <i class="fa-solid fa-xmark"></i>
            </button>
        </div>

        {{-- 🟡 Dynamic Alert Message Section --}}
        @php
            $user = auth()->user();
            $isExpired = $user->active_plan && $user->plan_expires_at && now()->gt($user->plan_expires_at);
            $lowCredits = !$user->is_unlimited && ($user->credits < 100);
        @endphp

        @if($isExpired || $lowCredits)
        <div class="px-8 py-4 bg-yellow-50 border-b border-yellow-100 flex items-center gap-4">
            <div class="w-10 h-10 bg-yellow-400 rounded-full flex items-center justify-center text-white shrink-0 shadow-sm">
                <i class="fa-solid fa-triangle-exclamation"></i>
            </div>
            <div>
                <p class="text-[13px] font-black text-yellow-800 uppercase tracking-tight">
                    @if($isExpired)
                        Please Upgrade your plan, your old plan ({{ $user->active_plan }}) has expired!
                    @elseif($lowCredits)
                        You have no more credits to create album. Please purchase a plan to continue.
                    @endif
                </p>
                <p class="text-[10px] text-yellow-600 font-bold mt-0.5">Choose a plan below to activate your account instantly.</p>
            </div>
        </div>
        @endif

        <div class="flex-1 overflow-y-auto p-6 md:p-12 custom-scrollbar bg-white">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8 items-stretch">

                <div class="pricing-card border border-gray-100 p-8 rounded-[2rem] text-center flex flex-col transition-all duration-300 hover:shadow-2xl bg-white relative group">
                    <span class="text-[11px] font-bold text-blue-300 tracking-[0.2em] uppercase mb-4">Basic Plan</span>
                    <h2 class="text-4xl font-black text-gray-800 mb-2">₹999<span class="text-sm font-medium text-gray-400 italic">/Year</span></h2>
                    <p class="text-[10px] text-gray-400 font-bold uppercase mb-8">Best for small photographers</p>
                    
                    <ul class="text-[12px] text-gray-500 mb-10 text-left space-y-4 flex-1">
                        <li class="flex items-center gap-3"><i class="fa-solid fa-check text-green-500"></i> Up to 10 albums per year</li>
                        <li class="flex items-center gap-3"><i class="fa-solid fa-check text-green-500"></i> Up to 100 photos per album</li>
                        <li class="flex items-center gap-3"><i class="fa-solid fa-check text-green-500"></i> Shareable album link</li>
                        <li class="flex items-center gap-3"><i class="fa-solid fa-check text-green-500"></i> WhatsApp sharing</li>
                        <li class="flex items-center gap-3"><i class="fa-solid fa-check text-green-500"></i> Mobile-friendly gallery</li>
                        <li class="flex items-center gap-3"><i class="fa-solid fa-check text-green-500"></i> QR code for album</li>
                        <li class="flex items-center gap-3 text-gray-300"><i class="fa-solid fa-check"></i> Basic support</li>
                    </ul>

                    @php $active = auth()->user()->active_plan; @endphp
                    @if(($active == 'Pro Plan' || $active == 'Studio Plan' || $active == 'Pro' || $active == 'Studio') && !$isExpired)
                        <button class="w-full bg-gray-100 text-gray-400 py-4 rounded-full text-xs font-black uppercase cursor-not-allowed" disabled>Plan Active</button>
                    @else
                        <form action="{{ route('razorpay.payment') }}" method="POST">
                            @csrf
                            <input type="hidden" name="amount" value="999">
                            <input type="hidden" name="plan_name" value="Basic Plan">
                            <button type="submit" class="w-full bg-[#6db9e9] text-white py-4 rounded-full text-xs font-black uppercase tracking-widest hover:bg-blue-500 transition-all shadow-lg">Buy Now</button>
                        </form>
                    @endif
                </div>

                <div class="pricing-card border-2 border-blue-50 p-8 rounded-[2rem] text-center flex flex-col transition-all duration-300 shadow-xl bg-white relative scale-105 z-10">
                    <div class="absolute -top-4 left-1/2 -translate-x-1/2 bg-[#4489f4] text-white text-[10px] font-black px-6 py-1.5 rounded-full uppercase">Most Popular</div>
                    <span class="text-[11px] font-bold text-blue-500 tracking-[0.2em] uppercase mb-4">Pro Plan</span>
                    <h2 class="text-4xl font-black text-gray-800 mb-2">₹2,499<span class="text-sm font-medium text-gray-400 italic">/Year</span></h2>
                    <p class="text-[10px] text-gray-400 font-bold uppercase mb-8">Professional Photographers</p>

                    <ul class="text-[12px] text-gray-500 mb-10 text-left space-y-4 flex-1">
                        <li class="flex items-center gap-3"><i class="fa-solid fa-check text-green-500"></i> Up to 30 albums per year</li>
                        <li class="flex items-center gap-3"><i class="fa-solid fa-check text-green-500"></i> Up to 300 photos per album</li>
                        <li class="flex items-center gap-3"><i class="fa-solid fa-check text-green-500"></i> Password protected albums</li>
                        <li class="flex items-center gap-3"><i class="fa-solid fa-check text-green-500"></i> Custom cover photo</li>
                        <li class="flex items-center gap-3"><i class="fa-solid fa-check text-green-500"></i> QR code sharing</li>
                        <li class="flex items-center gap-3"><i class="fa-solid fa-check text-green-500"></i> WhatsApp & social share</li>
                        <li class="flex items-center gap-3"><i class="fa-solid fa-check text-green-500"></i> Download option for clients</li>
                        <li class="flex items-center gap-3 text-blue-500 font-bold uppercase text-[9px]"><i class="fa-solid fa-check"></i> PRIORITY SUPPORT</li>
                    </ul>

                    @if(($active == 'Studio' || $active == 'Studio Plan') && !$isExpired)
                        <button class="w-full bg-gray-100 text-gray-400 py-4 rounded-full text-xs font-black uppercase cursor-not-allowed" disabled>Studio Active</button>
                    @else
                        <form action="{{ route('razorpay.payment') }}" method="POST">
                            @csrf
                            <input type="hidden" name="amount" value="2499">
                            <input type="hidden" name="plan_name" value="Pro Plan">
                            <button type="submit" class="w-full bg-[#4489f4] text-white py-4 rounded-full text-xs font-black uppercase tracking-widest hover:bg-blue-600 transition-all shadow-lg">Buy Now</button>
                        </form>
                    @endif
                </div>

                <div class="pricing-card border border-gray-100 p-8 rounded-[2rem] text-center flex flex-col transition-all duration-300 hover:shadow-2xl bg-white group">
                    <span class="text-[11px] font-bold text-blue-300 tracking-[0.2em] uppercase mb-4">Studio Plan</span>
                    <h2 class="text-4xl font-black text-gray-800 mb-2">₹4,999<span class="text-sm font-medium text-gray-400 italic">/Year</span></h2>
                    <p class="text-[10px] text-gray-400 font-bold uppercase mb-8">Best for heavy users</p>

                    <ul class="text-[12px] text-gray-500 mb-10 text-left space-y-4 flex-1">
                        <li class="flex items-center gap-3 font-bold text-gray-800"><i class="fa-solid fa-check text-green-500"></i> Unlimited albums & photos</li>
                        <li class="flex items-center gap-3"><i class="fa-solid fa-check text-green-500"></i> Custom branding (studio logo)</li>
                        <li class="flex items-center gap-3"><i class="fa-solid fa-check text-green-500"></i> Custom domain option</li>
                        <li class="flex items-center gap-3"><i class="fa-solid fa-check text-green-500"></i> Client download gallery</li>
                        <li class="flex items-center gap-3"><i class="fa-solid fa-check text-green-500"></i> Password protected albums</li>
                        <li class="flex items-center gap-3"><i class="fa-solid fa-check text-green-500"></i> QR code sharing</li>
                        <li class="flex items-center gap-3"><i class="fa-solid fa-check text-green-500"></i> Analytics (views, downloads)</li>
                        <li class="flex items-center gap-3"><i class="fa-solid fa-check text-green-500"></i> Priority support</li>
                    </ul>

                    @if(($active == 'Studio' || $active == 'Studio Plan') && !$isExpired)
                        <button class="w-full bg-green-100 text-green-600 py-4 rounded-full text-xs font-black uppercase cursor-not-allowed" disabled>Already Active</button>
                    @else
                        <form action="{{ route('razorpay.payment') }}" method="POST">
                            @csrf
                            <input type="hidden" name="amount" value="4999">
                            <input type="hidden" name="plan_name" value="Studio Plan">
                            <button type="submit" class="w-full bg-[#2c313d] text-white py-4 rounded-full text-xs font-black uppercase tracking-widest hover:bg-black transition-all shadow-lg">Buy Now</button>
                        </form>
                    @endif
                </div>
            </div>
        </div>

        <div class="p-6 border-t border-gray-50 flex justify-end bg-white">
            <button class="close-modal-trigger bg-white border border-gray-200 text-gray-700 px-10 py-2.5 rounded-xl text-xs font-bold hover:bg-gray-50 transition shadow-sm">Close</button>
        </div>
    </div>
</div>

<style>
    .custom-scrollbar::-webkit-scrollbar { width: 5px; }
    .custom-scrollbar::-webkit-scrollbar-thumb { background: #e2e8f0; border-radius: 10px; }
</style>

<script>
    $(document).ready(function () {
        $(document).on('click', '#btnBuyCreditsPopup', function (e) {
            e.preventDefault();
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