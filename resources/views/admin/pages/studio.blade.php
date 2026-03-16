@extends('admin.pages.adminApp')

@section('content')
    <div class="flex h-screen overflow-hidden bg-[#f4f7fe]">
        @include('admin.extra.sidebar')

        <div id="main-panel" class="flex-1 flex flex-col min-w-0 transition-all duration-500 ease-in-out">
            @include('admin.extra.header')

            <div class="flex-1 overflow-y-auto p-6 space-y-6 custom-scrollbar">

                <div class="bg-white rounded-3xl shadow-sm border border-gray-100 p-6 flex flex-wrap items-center justify-between gap-4">
                    <div class="flex items-center gap-4">
                        <a href="{{ route('admin.index') }}"
                            class="bg-purple-500 text-white px-5 py-2 rounded-xl text-sm font-bold flex items-center gap-2 hover:bg-purple-600 transition active:scale-95">
                            <i class="fa-solid fa-arrow-left"></i> Back
                        </a>
                        <h2 class="text-2xl font-black text-gray-800 tracking-tight">New Album <span id="displayUniqueCode"
                                class="text-red-500 text-sm ml-2 font-bold tracking-widest">GEN-CODE</span></h2>
                    </div>
                    <div class="flex gap-3">
                        <button id="mainSubmitBtn"
                            class="bg-[#2ecc71] text-white px-6 py-2 rounded-xl text-sm font-bold hover:bg-green-600 shadow-lg shadow-green-100 transition">Save
                            Album</button>
                        <button
                            class="bg-[#1abc9c] text-white px-6 py-2 rounded-xl text-sm font-bold hover:bg-teal-600 shadow-lg shadow-teal-100 transition flex items-center gap-2">
                            <i class="fa-solid fa-share-nodes"></i> Copy and Share
                        </button>
                    </div>
                </div>

                @if(session('success'))
                    <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded-xl mb-4">
                        {{ session('success') }}
                    </div>
                @endif

                @if($errors->any())
                    <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded-xl mb-4">
                        <ul class="list-disc pl-5">
                            @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form action="{{ route('admin.album.store') }}" method="POST" enctype="multipart/form-data" id="albumForm"
                    class="space-y-6">
                    @csrf

                    <div class="bg-white rounded-3xl shadow-sm border border-gray-100 p-8 space-y-8">
                        <h4 class="font-bold text-gray-700 flex items-center gap-2"><i
                                class="fa-solid fa-camera text-indigo-500"></i> Add More Details About Studio</h4>
                        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                            <div class="space-y-2">
                                <label class="text-xs font-bold text-gray-500 uppercase">Your Studio Name</label>
                                <input type="text" name="studio_name" required value="{{ old('studio_name') }}"
                                    class="w-full border-gray-200 rounded-xl p-3 text-sm focus:ring-2 focus:ring-indigo-400 outline-none border transition-all">
                            </div>
                            <div class="space-y-2">
                                <label class="text-xs font-bold text-gray-500 uppercase">Studio Contact Person</label>
                                <input type="text" name="contact_person" required value="{{ old('contact_person') }}"
                                    class="w-full border-gray-200 rounded-xl p-3 text-sm focus:ring-2 focus:ring-indigo-400 outline-none border transition-all">
                            </div>
                            <div class="space-y-2">
                                <label class="text-xs font-bold text-gray-500 uppercase">Studio Email</label>
                                <input type="email" name="studio_email" required value="{{ old('studio_email') }}"
                                    class="w-full border-gray-200 rounded-xl p-3 text-sm focus:ring-2 focus:ring-indigo-400 outline-none border transition-all">
                            </div>
                            <div class="space-y-2">
                                <label class="text-xs font-bold text-gray-500 uppercase">Contact No</label>
                                <div class="flex gap-2">
                                    <input type="text" name="studio_contact" required value="{{ old('studio_contact') }}"
                                        class="flex-1 border-gray-200 rounded-xl p-3 text-sm focus:ring-2 focus:ring-indigo-400 outline-none border transition-all">
                                    <button type="button"
                                        class="bg-green-50 text-green-600 border border-green-200 px-4 py-2 rounded-xl text-xs font-bold hover:bg-green-500 hover:text-white transition">
                                        <i class="fa-brands fa-whatsapp text-lg"></i>
                                    </button>
                                </div>
                            </div>
                            <div class="space-y-2">
                                <label class="text-xs font-bold text-gray-500 uppercase">Photography Experience</label>
                                <input type="text" name="experience" placeholder="e.g. 4 year, 5 month Exp."
                                    value="{{ old('experience') }}"
                                    class="w-full border-gray-200 rounded-xl p-3 text-sm focus:ring-2 focus:ring-indigo-400 outline-none border transition-all">
                            </div>
                        </div>

                        <h4 class="font-bold text-gray-700 flex items-center gap-2 pt-4 border-t border-gray-50"><i
                                class="fa-solid fa-images text-purple-500"></i> Add More Details About Album</h4>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div class="space-y-2">
                                <label class="text-xs font-bold text-gray-500 uppercase">Your Album Name</label>
                                <input type="text" name="album_name" placeholder="Enter Album Name" required
                                    value="{{ old('album_name') }}"
                                    class="w-full border-gray-200 rounded-xl p-3 text-sm focus:ring-2 focus:ring-indigo-400 outline-none border transition-all">
                            </div>

                            <div class="space-y-2">
                                <label class="text-xs font-bold text-gray-500 uppercase">Your Album Type</label>
                                <div class="flex gap-2">
                                    <select id="albumTypeSelect" name="album_type"
                                        class="flex-1 border-gray-200 rounded-xl p-3 text-sm focus:ring-2 focus:ring-indigo-400 outline-none border transition-all">
                                        <option value="Wedding">Wedding Photography</option>
                                        <option value="Corporate">Corporate Event</option>
                                        <option value="Commercial">Commercial/Product</option>
                                        <option value="Maternity">Maternity/Baby Shoot</option>
                                        <option value="Custom">Other (Custom Type)</option>
                                    </select>
                                    <input type="text" id="customTypeInput" name="custom_type" placeholder="Type here..."
                                        class="hidden flex-1 border-gray-200 rounded-xl p-3 text-sm focus:ring-2 focus:ring-indigo-400 outline-none border transition-all">
                                </div>
                            </div>

                            <div class="space-y-2">
                                <label class="text-xs font-bold text-gray-500 uppercase">Album Unique Code</label>
                                <div class="flex gap-2">
                                    <input type="text" name="unique_code" id="uniqueCodeInput" readonly
                                        class="flex-1 bg-gray-50 border-gray-200 rounded-xl p-3 text-sm font-mono font-bold text-indigo-600 outline-none border">
                                    <button type="button" id="regenerateCode"
                                        class="bg-indigo-100 text-indigo-600 px-4 rounded-xl hover:bg-indigo-200 transition"><i
                                            class="fa-solid fa-rotate"></i></button>
                                </div>
                            </div>

                            <div class="space-y-2">
                                <label class="text-xs font-bold text-gray-500 uppercase">Album Cover Photo (Single)</label>
                                <div class="max-w-[200px]">
                                    <div
                                        class="relative w-full h-auto min-h-[100px] border-2 border-dashed border-gray-200 rounded-2xl bg-gray-50 group hover:border-indigo-400 transition-all overflow-hidden">
                                        <input type="file" id="coverPhoto" name="cover_photo" accept="image/*" required
                                            class="absolute inset-0 opacity-0 cursor-pointer z-20">
                                        <div id="coverPlaceholder"
                                            class="flex flex-col items-center justify-center p-6 text-gray-400 text-xs gap-2 text-center">
                                            <i class="fa-solid fa-cloud-arrow-up text-2xl text-gray-300"></i>
                                            <span class="font-medium">Upload Cover</span>
                                        </div>
                                        <div id="coverPreviewContainer" class="hidden relative w-full z-30 bg-white">
                                            <img src="" id="coverImg" class="block w-full h-auto object-contain">
                                            <button type="button" id="removeCover"
                                                class="absolute top-2 right-2 bg-red-500 text-white w-7 h-7 rounded-full flex items-center justify-center hover:bg-red-600 transition shadow-md">
                                                <i class="fa-solid fa-xmark text-sm"></i>
                                            </button>
                                        </div>
                                    </div>
                                    <p class="text-[10px] text-gray-400 mt-1 italic">* Optimized for high quality.</p>
                                </div>
                            </div>
                        </div>

                        <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 pt-4 border-t border-gray-50">
                            <div class="space-y-4">
                                <label class="text-xs font-bold text-gray-500 uppercase">Background Music (MP3)</label>
                                <div class="flex items-center gap-4">
                                    <div
                                        class="flex-1 border-2 border-dashed border-gray-200 rounded-2xl p-4 bg-gray-50/50">
                                        <input type="file" id="songInput" name="album_song" accept="audio/mp3,audio/wav"
                                            class="text-xs text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-xl file:border-0 file:text-xs file:font-bold file:bg-indigo-600 file:text-white hover:file:bg-indigo-700 cursor-pointer">
                                    </div>
                                    <div id="songSuccess"
                                        class="hidden w-10 h-10 bg-green-500 text-white rounded-full flex items-center justify-center animate-bounce shadow-lg shadow-green-200">
                                        <i class="fa-solid fa-check"></i>
                                    </div>
                                </div>
                                <audio id="songPreview" controls class="hidden w-full h-10 mt-2"></audio>
                            </div>

                            <div class="space-y-4">
                                <div class="flex items-center justify-between">
                                    <label class="text-xs font-bold text-gray-500 uppercase">Upload Album Photos (Max 50 Photos)</label>
                                    <span id="imageCount"
                                        class="text-[10px] font-bold text-gray-400 bg-gray-100 px-3 py-1 rounded-full uppercase">0
                                        / 50 Selected</span>
                                </div>
                                <div
                                    class="border-2 border-dashed border-indigo-100 rounded-3xl p-6 bg-indigo-50/10 text-center group hover:border-indigo-400 transition-all">
                                    <input type="file" id="albumImages" name="album_photos[]" multiple accept="image/*"
                                        class="hidden">
                                    <label for="albumImages" class="cursor-pointer flex flex-col items-center">
                                        <i
                                            class="fa-solid fa-cloud-arrow-up text-3xl text-indigo-300 group-hover:text-indigo-600 transition-colors mb-2"></i>
                                        <span
                                            class="bg-indigo-600 text-white px-6 py-2 rounded-xl text-xs font-bold shadow-xl shadow-indigo-100">Choose
                                            Photos</span>
                                    </label>
                                </div>
                            </div>
                        </div>

                        <div id="imageGridPreview" class="grid grid-cols-3 sm:grid-cols-4 lg:grid-cols-6 gap-4 mt-6"></div>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script>
        $(document).ready(function () {

            // 1. UNIQUE CODE GENERATOR
            function generateUniqueCode(length = 10) {
                const chars = '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ';
                let result = '';
                for (let i = 0; i < length; i++) {
                    result += chars.charAt(Math.floor(Math.random() * chars.length));
                }
                return result;
            }

            const initialCode = generateUniqueCode();
            $('#uniqueCodeInput').val(initialCode);
            $('#displayUniqueCode').text('CODE: ' + initialCode);

            $('#regenerateCode').click(function () {
                const newCode = generateUniqueCode();
                $('#uniqueCodeInput').val(newCode);
                $('#displayUniqueCode').text('CODE: ' + newCode);
            });

            // 2. ALBUM TYPE CUSTOM TOGGLE
            $('#albumTypeSelect').change(function () {
                if ($(this).val() === 'Custom') {
                    $(this).addClass('hidden');
                    $('#customTypeInput').removeClass('hidden').focus();
                    $('#customTypeInput').on('input', function () {
                        $('#albumTypeSelect').val($(this).val());
                    });
                }
            });

            // 3. COVER PHOTO PREVIEW (🟢 Changed Limit to 20MB)
            $('#coverPhoto').change(function () {
                const file = this.files[0];
                if (file && file.size <= 20 * 1024 * 1024) { 
                    const reader = new FileReader();
                    reader.onload = function (e) {
                        $('#coverImg').attr('src', e.target.result);
                        $('#coverPlaceholder').addClass('hidden');
                        $('#coverPreviewContainer').removeClass('hidden');
                    }
                    reader.readAsDataURL(file);
                } else if (file) {
                    alert("Bhai, cover photo 20MB se badi hai! Thodi choti file upload karo.");
                    $(this).val('');
                }
            });

            $('#removeCover').click(function (e) {
                e.stopPropagation();
                $('#coverPhoto').val('');
                $('#coverPreviewContainer').addClass('hidden');
                $('#coverPlaceholder').removeClass('hidden');
            });

            // 4. BULK IMAGES VALIDATION (🟢 Changed Limit to 20MB per photo)
            $('#albumImages').change(function () {
                const files = this.files;
                if (files.length > 50) {
                    alert("Maximum 50 photos hi allowed hain!");
                    $(this).val('');
                    return;
                }

                $('#imageGridPreview').empty();
                let validCount = 0;

                Array.from(files).forEach(file => {
                    // Check individual file size (20MB)
                    if (file.size <= 20 * 1024 * 1024) {
                        validCount++;
                        const reader = new FileReader();
                        reader.onload = function (e) {
                            $('#imageGridPreview').append(`
                                    <div class="relative group aspect-square overflow-hidden rounded-2xl border border-gray-100 shadow-sm animate-fade-in-up">
                                        <img src="${e.target.result}" class="w-full h-full object-cover">
                                    </div>`);
                        }
                        reader.readAsDataURL(file);
                    } else {
                        console.warn(`${file.name} is too large (>20MB).`);
                    }
                });

                $('#imageCount').text(`${validCount} / 50 Selected`);
            });

            $('#songInput').change(function () {
                const file = this.files[0];
                if (file) {
                    if (file.size > 15 * 1024 * 1024) { // Music limit 15MB
                        alert("Song size 15MB se kam honi chahiye!");
                        $(this).val('');
                        return;
                    }
                    const url = URL.createObjectURL(file);
                    $('#songPreview').attr('src', url).removeClass('hidden');
                    $('#songSuccess').removeClass('hidden');
                }
            });

            $('#mainSubmitBtn').click(function () {
                if (!$('#coverPhoto').val()) {
                    alert("Kripya cover photo upload karein!");
                    return;
                }
                $('#albumForm').submit();
            });
        });
    </script>

    <style>
        .animate-fade-in-up { animation: fadeInUp 0.4s ease-out; }
        @keyframes fadeInUp {
            from { opacity: 0; transform: translateY(10px); }
            to { opacity: 1; transform: translateY(0); }
        }
        .custom-scrollbar::-webkit-scrollbar { width: 5px; }
        .custom-scrollbar::-webkit-scrollbar-thumb { background: #e2e8f0; border-radius: 10px; }
    </style>
@endsection