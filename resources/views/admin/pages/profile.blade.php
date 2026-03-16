@extends('admin.pages.adminApp')

@section('content')
    <div class="flex h-screen overflow-hidden bg-[#f4f7fe]">

        @include('admin.extra.sidebar')

        <div id="main-panel" class="flex-1 flex flex-col min-w-0 transition-all duration-500 ease-in-out">

            @include('admin.extra.header')

            <div class="flex-1 overflow-y-auto p-6 space-y-8 custom-scrollbar">

                <div class="bg-white rounded-3xl shadow-sm border border-gray-100 overflow-hidden">
                    <div class="p-6 border-b border-gray-50 bg-gray-50/30">
                        <h3 class="font-bold text-gray-800 text-lg">{{ Auth::user()->name }}'s Profile</h3>
                    </div>

                    @if(session('status'))
                        <div class="mx-8 mt-4 p-4 bg-green-100 border border-green-200 text-green-700 rounded-xl text-sm font-bold">
                            {{ session('status') }}
                        </div>
                    @endif

                    {{-- 🟢 Form setup as it is --}}
                    <form action="{{ route('admin.profile.update') }}" method="POST" enctype="multipart/form-data"
                        class="p-8 space-y-6">
                        @csrf
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-8">

                            <div class="space-y-2">
                                <label class="text-sm font-semibold text-gray-600">Business Name</label>
                                <input type="text" name="business_name"
                                    value="{{ old('business_name', $user->business_name) }}"
                                    class="w-full border-gray-200 rounded-xl p-3 text-sm focus:ring-2 focus:ring-indigo-400 outline-none border transition-all">
                            </div>

                            <div class="space-y-2">
                                <label class="text-sm font-semibold text-gray-600">Your Name</label>
                                <input type="text" name="name" value="{{ old('name', $user->name) }}"
                                    class="w-full border-gray-200 rounded-xl p-3 text-sm focus:ring-2 focus:ring-indigo-400 outline-none border transition-all">
                            </div>

                            <div class="space-y-2">
                                <label class="text-sm font-semibold text-gray-600">Email Id (User Id)</label>
                                {{-- 🟢 Added required and standard email type validation --}}
                                <input type="email" value="{{ $user->email }}"
                                    class="w-full border-gray-100 rounded-xl p-3 text-sm bg-gray-50 text-gray-400 border outline-none cursor-not-allowed"
                                    readonly required>
                            </div>

                            <div class="space-y-2">
                                <label class="text-sm font-semibold text-gray-600">Password</label>
                                <input type="password" name="password" value="{{ old('password') }}"
                                    placeholder="Leave blank to keep current"
                                    class="w-full border-gray-200 rounded-xl p-3 text-sm focus:ring-2 focus:ring-indigo-400 outline-none border transition-all">
                            </div>

                            <div class="space-y-2">
                                <label class="text-sm font-semibold text-gray-600">Contact No</label>
                                <input type="text" name="contact_no" value="{{ old('contact_no', $user->contact_no) }}"
                                    class="w-full border-gray-200 rounded-xl p-3 text-sm focus:ring-2 focus:ring-indigo-400 outline-none border transition-all">
                            </div>

                            <div class="space-y-2">
                                <label class="text-sm font-semibold text-gray-600">About Business/You</label>
                                <input type="text" name="about" value="{{ old('about', $user->about) }}"
                                    placeholder="Enter About Details"
                                    class="w-full border-gray-200 rounded-xl p-3 text-sm focus:ring-2 focus:ring-indigo-400 outline-none border transition-all">
                            </div>

                            <div class="space-y-2">
                                <label class="text-sm font-semibold text-gray-600">Address</label>
                                <textarea name="address" rows="3" placeholder="Enter Address"
                                    class="w-full border-gray-200 rounded-xl p-3 text-sm focus:ring-2 focus:ring-indigo-400 outline-none border transition-all resize-none custom-scrollbar">{{ old('address', $user->address) }}</textarea>
                            </div>

                            <div class="space-y-2">
                                <label class="text-sm font-semibold text-gray-600">City</label>
                                <input type="text" name="city" value="{{ old('city', $user->city) }}"
                                    placeholder="Enter City"
                                    class="w-full border-gray-200 rounded-xl p-3 text-sm focus:ring-2 focus:ring-indigo-400 outline-none border transition-all">
                            </div>

                            {{-- 🟢 Updated Country Logic with your provided list --}}
                            <div class="space-y-2">
                                <label class="text-sm font-semibold text-gray-600">Country</label>
                                <select id="country" name="country"
                                    class="w-full border-gray-200 rounded-xl p-3 text-sm focus:ring-2 focus:ring-indigo-400 outline-none border transition-all bg-white custom-scrollbar max-h-40">
                                    <option value="">Select Country</option>
                                    @php
                                        $countries = [
                                            "Afghanistan", "Australia", "Bangladesh", "Canada", "China", 
                                            "France", "Germany", "India", "Indonesia", "Italy", "Japan", 
                                            "Malaysia", "Nepal", "Netherlands", "New Zealand", "Pakistan", 
                                            "Russia", "Singapore", "South Africa", "Spain", "Sri Lanka", 
                                            "Thailand", "United Arab Emirates", "United Kingdom", "United States", "Vietnam"
                                        ];
                                    @endphp
                                    @foreach($countries as $country)
                                        <option value="{{ $country }}" {{ old('country', $user->country) == $country ? 'selected' : '' }}>
                                            {{ $country }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="space-y-2">
                                <label class="text-sm font-semibold text-gray-600">Zip Code</label>
                                <input type="text" name="zip_code" value="{{ old('zip_code', $user->zip_code) }}"
                                    placeholder="Enter Zip Code"
                                    class="w-full border-gray-200 rounded-xl p-3 text-sm focus:ring-2 focus:ring-indigo-400 outline-none border transition-all">
                            </div>

                            <div class="space-y-2">
                                <label class="text-sm font-semibold text-gray-600">Business Logo (High Quality
                                    Allowed)</label>
                                <div class="flex flex-col gap-4">
                                    <div class="flex items-center gap-2 border border-gray-200 rounded-xl p-2 bg-gray-50">
                                        <input type="file" id="logoInput" name="logo" accept="image/*"
                                            class="text-xs text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-xs file:font-bold file:bg-gray-200 file:text-gray-700 hover:file:bg-gray-300">
                                    </div>
                                    <div id="logoPreviewBox"
                                        class="w-32 h-32 bg-gray-100 border border-dashed border-gray-300 rounded-xl flex items-center justify-center overflow-hidden">
                                        @if($user->logo)
                                            <img src="{{ asset('storage/logos/' . $user->logo) }}"
                                                class="w-full h-full object-cover">
                                        @else
                                            <span class="placeholder text-[10px] text-gray-400 text-center p-2">No logo
                                                uploaded</span>
                                            <img src="#" class="hidden w-full h-full object-cover">
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="pt-4 text-right">
                            <button type="submit"
                                class="bg-blue-600 text-white px-8 py-3 rounded-xl text-sm font-bold shadow-md hover:bg-blue-700 transition">Update
                                Profile</button>
                        </div>
                    </form>
                </div>
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

            // 2. Real-time Logo Preview Logic
            $('#logoInput').change(function () {
                if (this.files && this.files[0]) {
                    var reader = new FileReader();
                    reader.onload = function (e) {
                        $('#logoPreviewBox .placeholder').addClass('hidden');
                        $('#logoPreviewBox img').attr('src', e.target.result).removeClass('hidden').addClass('w-full h-full object-cover');
                    }
                    reader.readAsDataURL(this.files[0]);
                }
            });
        });
    </script>
@endsection