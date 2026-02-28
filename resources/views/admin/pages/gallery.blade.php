@extends('admin.pages.adminApp')

@section('content')
            <div id="uploadLoader" class="fixed inset-0 z-[200] hidden flex-col items-center justify-center bg-white/80 backdrop-blur-md">
                <div class="relative">
                    <div class="w-20 h-20 border-4 border-indigo-100 border-t-indigo-600 rounded-full animate-spin"></div>
                    <div class="absolute inset-0 flex items-center justify-center">
                        <i class="fa-solid fa-cloud-arrow-up text-indigo-600 text-xl"></i>
                    </div>
                </div>
                <h3 class="mt-6 text-xl font-black text-gray-800">Processing Your Album...</h3>
                <p class="text-sm text-gray-500 font-medium text-center px-6">Please wait, we are optimizing and uploading your high-quality photos.</p>
                <div class="w-64 h-2 bg-gray-100 rounded-full mt-4 overflow-hidden">
                    <div class="h-full bg-indigo-600 animate-pulse" style="width: 100%"></div>
                </div>
            </div>

            <form action="{{ route('admin.gallery.update') }}" method="POST" enctype="multipart/form-data" id="galleryUpdateForm">
                @csrf
                @method('PUT') 

                <div class="flex h-screen overflow-hidden bg-[#f4f7fe]">
                    @include('admin.extra.sidebar')

                    <div id="main-panel" class="flex-1 flex flex-col min-w-0 overflow-hidden transition-all duration-500 ease-in-out">
                        @include('admin.extra.header')

                        <div class="flex-1 overflow-y-auto p-6 space-y-6 custom-scrollbar">

                            {{-- Top Header Card --}}
                            <div class="mb-8 flex justify-between items-center bg-white p-6 rounded-3xl shadow-sm border border-gray-100">
                                <h2 class="text-2xl font-black text-gray-800 tracking-tight">
                                    Update Your Studio, Album & Gallery
                                    <span class="text-indigo-500 text-sm ml-2">
                                        (<span id="currentPhotoCount">{{ count($gallery->images ?? []) }}</span>) Photos
                                    </span>
                                </h2>
                                <div class="flex justify-between gap-2">
                                    <a href="{{ route('admin.index') }}"
                                        class="bg-indigo-600 text-white px-5 py-2 rounded-xl text-sm font-bold hover:bg-indigo-700 transition shadow-lg shadow-indigo-100">
                                        <i class="fa-solid fa-arrow-left mr-2"></i> Back
                                    </a>
                                    <button type="submit" id="submitBtn"
                                        class="bg-green-600 text-white px-5 py-2 rounded-xl text-sm font-bold hover:bg-green-700 transition shadow-lg shadow-green-100">
                                        <i class="fa-solid fa-floppy-disk mr-2"></i> Update Changes
                                    </button>
                                </div>
                            </div>

                            <div class="bg-white rounded-3xl shadow-sm border border-gray-100 p-8 space-y-8">

                                {{-- 1. Studio Details --}}
                                <h4 class="font-bold text-gray-700 flex items-center gap-2">
                                    <i class="fa-solid fa-camera text-indigo-500"></i> Studio Details
                                </h4>
                                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                                    <div class="space-y-2">
                                        <label class="text-xs font-bold text-gray-500 uppercase">Studio Name</label>
                                        <input type="text" name="studio_name" value="{{ old('studio_name', $gallery->studio->studio_name ?? '') }}"
                                            class="w-full border-gray-200 rounded-xl p-3 text-sm focus:ring-2 focus:ring-indigo-400 outline-none border transition-all">
                                    </div>
                                    <div class="space-y-2">
                                        <label class="text-xs font-bold text-gray-500 uppercase">Contact Person</label>
                                        <input type="text" name="contact_person" value="{{ old('contact_person', $gallery->studio->contact_person ?? '') }}"
                                            class="w-full border-gray-200 rounded-xl p-3 text-sm focus:ring-2 focus:ring-indigo-400 outline-none border transition-all">
                                    </div>
                                    <div class="space-y-2">
                                        <label class="text-xs font-bold text-gray-500 uppercase">Email</label>
                                        <input type="email" name="studio_email" value="{{ old('studio_email', $gallery->studio->studio_email ?? '') }}"
                                            class="w-full border-gray-200 rounded-xl p-3 text-sm focus:ring-2 focus:ring-indigo-400 outline-none border transition-all">
                                    </div>
                                    <div class="space-y-2">
                                        <label class="text-xs font-bold text-gray-500 uppercase">Contact No (10 Digits Only)</label>
                                        <input type="text" id="studio_contact" name="studio_contact" maxlength="10" placeholder="9876543210"
                                            value="{{ old('studio_contact', $gallery->studio->studio_contact ?? '') }}"
                                            class="w-full border-gray-200 rounded-xl p-3 text-sm focus:ring-2 focus:ring-indigo-400 outline-none border transition-all">
                                    </div>
                                    {{-- Studio Experience Section --}}
                                    <div class="space-y-2">
                                        <label class="text-xs font-bold text-gray-500 uppercase tracking-wider">Photography Experience</label>
                                        <div class="relative">
                                            <input type="text" name="experience" value="{{ old('experience', $gallery->studio->experience ?? '') }}"
                                                placeholder="e.g. 5 Years, 2 Months"
                                                class="w-full border-gray-200 rounded-xl p-3 text-sm focus:ring-2 focus:ring-indigo-400 outline-none border transition-all">
                                            <div class="absolute inset-y-0 right-0 flex items-center pr-3 pointer-events-none">
                                                <i class="fa-solid fa-briefcase text-indigo-300 text-xs"></i>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                {{-- 2. Album Details --}}
                                <h4 class="font-bold text-gray-700 flex items-center gap-2 pt-4 border-t border-gray-50">
                                    <i class="fa-solid fa-images text-purple-500"></i> Album Details
                                </h4>

                                <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                                    <div class="space-y-4">
                                        <div>
                                            <label class="text-xs font-bold text-gray-500 uppercase">Album Name</label>
                                            <input type="text" name="album_name" value="{{ old('album_name', $gallery->studio->album->album_name ?? '') }}"
                                                class="w-full border-gray-200 rounded-xl p-3 text-sm focus:ring-2 focus:ring-indigo-400 outline-none border transition-all">
                                        </div>

                                        {{-- Album Unique Code Section --}}
                                        <div class="space-y-2">
                                            <label class="text-xs font-bold text-gray-500 uppercase tracking-wider">Album Unique Code</label>
                                            <div class="relative">
                                                <input type="text" value="{{ $gallery->studio->album->unique_code ?? 'N/A' }}" readonly
                                                    class="w-full bg-gray-50 border-gray-200 rounded-xl p-3 text-sm font-mono font-bold text-indigo-600 border cursor-not-allowed"
                                                    title="This code is generated automatically and cannot be changed.">

                                                {{-- Optional: Key Icon for better UI --}}
                                                <div class="absolute inset-y-0 right-0 flex items-center pr-3 pointer-events-none">
                                                    <i class="fa-solid fa-key text-indigo-300 text-xs"></i>
                                                </div>
                                            </div>
                                            <p class="text-[10px] text-gray-400 italic">This unique code is used by clients to access their digital album.</p>
                                        </div>

                                        <div>
                                            <label class="text-xs font-bold text-gray-500 uppercase">Album Type</label>
                                            @php 
                                                $defaultTypes = ['Wedding Photography', 'Corporate Event', 'Commercial/Product', 'Maternity/Baby Shoot'];
    $dbValue = $gallery->studio->album->album_type ?? '';
    $oldValue = old('album_type', $dbValue);
    $isCustom = !in_array($oldValue, $defaultTypes) && $oldValue != "";
                                            @endphp
                                            <select id="albumTypeSelect" name="album_type"
                                                class="w-full border-gray-200 rounded-xl p-3 text-sm focus:ring-2 focus:ring-indigo-400 outline-none border transition-all mb-2">
                                                @foreach($defaultTypes as $type)
                                                    <option value="{{ $type }}" {{ $oldValue == $type ? 'selected' : '' }}>{{ $type }}</option>
                                                @endforeach
                                                <option value="Custom" {{ $isCustom ? 'selected' : '' }}>Other (Custom Type)</option>
                                            </select>
                                            <input type="text" id="customTypeInput" name="custom_type" 
                                                value="{{ $isCustom ? $oldValue : old('custom_type') }}"
                                                placeholder="Enter custom album type..."
                                                class="{{ $isCustom ? '' : 'hidden' }} w-full border-gray-200 rounded-xl p-3 text-sm focus:ring-2 focus:ring-indigo-400 outline-none border transition-all">
                                        </div>
                                    </div>

                                    {{-- COVER PHOTO --}}
                                    <div class="space-y-2">
                                        <label class="text-xs font-bold text-gray-500 uppercase">Album Cover Photo</label>
                                        <div class="relative w-full max-w-[250px] aspect-square rounded-2xl overflow-hidden border-2 border-dashed border-gray-200 bg-gray-50 group flex items-center justify-center">
                                            <input type="file" id="coverPhotoInput" name="cover_photo" accept="image/*" class="absolute inset-0 opacity-0 cursor-pointer z-20">

                                            @php $coverImg = $gallery->studio->album->cover_photo ?? null; @endphp
                                            <img id="coverPreview" 
                                                src="{{ $coverImg ? asset('storage/album_covers/' . $coverImg) : '' }}" 
                                                class="{{ $coverImg ? '' : 'hidden' }} w-full h-full object-cover shadow-inner">

                                            <div id="coverPlaceholder" class="{{ $coverImg ? 'hidden' : '' }} flex flex-col items-center justify-center text-gray-400 text-center p-4">
                                                <i class="fa-solid fa-cloud-arrow-up text-3xl mb-2"></i>
                                                <p class="text-[10px] font-bold uppercase">Click to Change Cover</p>
                                            </div>

                                            <button type="button" id="btnRemoveCover" class="absolute top-3 right-3 z-30 bg-red-500 text-white w-8 h-8 rounded-full flex items-center justify-center opacity-0 group-hover:opacity-100 transition-opacity shadow-lg">
                                                <i class="fa-solid fa-trash-can text-sm"></i>
                                            </button>
                                            <input type="hidden" name="remove_cover" id="removeCoverInput" value="0">
                                        </div>
                                    </div>
                                </div>

                                {{-- 3. Music & Bulk Upload --}}
                                <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 pt-4 border-t border-gray-50">
                                    <div class="space-y-4">
                                        <label class="text-xs font-bold text-gray-500 uppercase">Background Music (MP3)</label>
                                        <div class="flex items-center gap-3">
                                            <div class="flex-1 border-2 border-dashed border-gray-200 rounded-2xl p-4 bg-gray-50/50">
                                                <input type="file" id="songInput" name="album_song" accept="audio/*"
                                                    class="text-xs cursor-pointer file:mr-4 file:py-2 file:px-4 file:rounded-xl file:border-0 file:bg-indigo-600 file:text-white">
                                            </div>
                                            <button type="button" id="btnRemoveSong" class="{{ isset($gallery->studio->album->album_song) ? '' : 'hidden' }} w-12 h-12 bg-red-100 text-red-600 rounded-2xl flex items-center justify-center hover:bg-red-500 hover:text-white transition-all shadow-sm">
                                                <i class="fa-solid fa-trash-can"></i>
                                            </button>
                                            <input type="hidden" name="remove_song" id="removeSongInput" value="0">
                                        </div>
                                        <audio id="songPreview" controls class="{{ isset($gallery->studio->album->album_song) ? '' : 'hidden' }} w-full h-10 mt-2 rounded-lg bg-white">
                                            @if(isset($gallery->studio->album->album_song))
                                                <source src="{{ asset('storage/' . $gallery->studio->album->album_song) }}" type="audio/mpeg">
                                            @endif
                                        </audio>
                                    </div>

                                    <div class="space-y-4">
                                        <div class="flex items-center justify-between">
                                            <label class="text-xs font-bold text-gray-500 uppercase">Add New Gallery Photos</label>
                                            <span id="imageCountLabel" class="text-[10px] font-bold text-indigo-500 bg-indigo-50 px-3 py-1 rounded-full uppercase">0 Selected</span>
                                        </div>
                                        <div class="border-2 border-dashed border-indigo-100 rounded-3xl p-6 bg-indigo-50/10 text-center group hover:border-indigo-400 transition-all">
                                            {{-- FIXED: Added multiple="multiple" and z-index --}}
                                            <input type="file" id="albumImages" name="album_photos[]" multiple="multiple" accept="image/*" class="hidden">
                                            <label for="albumImages" class="cursor-pointer flex flex-col items-center">
                                                <i class="fa-solid fa-images text-3xl text-indigo-300 group-hover:text-indigo-600 mb-2"></i>
                                                <span class="bg-indigo-600 text-white px-6 py-2 rounded-xl text-xs font-bold shadow-xl shadow-indigo-100">Upload Photos</span>
                                            </label>
                                        </div>
                                    </div>
                                </div>

                                <div id="imageGridPreview" class="grid grid-cols-3 sm:grid-cols-4 lg:grid-cols-6 gap-4 mt-6"></div>
                            </div>

                            {{-- Current Gallery --}}
                            <h4 class="font-bold text-gray-700 flex items-center gap-2 pt-6"><i class="fa-solid fa-box-archive text-indigo-500"></i> Active Gallery</h4>
                            <div id="removedImagesContainer"></div>

                            @if($gallery && is_array($gallery->images))
                                <div id="currentGalleryGrid" class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 xl:grid-cols-5 gap-6 pb-20">
                                    @foreach($gallery->images as $image)
                                        <div class="gallery-item group relative aspect-square bg-white rounded-2xl overflow-hidden border border-gray-100 shadow-sm hover:shadow-xl transition-all" data-image-path="{{ $image }}">
                                            <img src="{{ asset('storage/galleries/' . $image) }}" class="w-full h-full object-cover">                                    
                                            <button type="button" class="btn-remove-image absolute top-2 right-2 bg-red-500 text-white w-7 h-7 rounded-full flex items-center justify-center opacity-0 group-hover:opacity-100 transition-opacity shadow-lg">
                                                <i class="fa-solid fa-xmark"></i>
                                            </button>
                                        </div>
                                    @endforeach
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </form>

            <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
            <script>
                $(document).ready(function() {
                    // LOADER LOGIC: Trigger on form submit
                    $('#galleryUpdateForm').on('submit', function() {
                        $('#uploadLoader').removeClass('hidden').addClass('flex');
                        $('#submitBtn').prop('disabled', true).addClass('opacity-50 cursor-not-allowed');
                    });

                    // 1. Validation: Numbers Only
                    $('#studio_contact').on('input', function() {
                        this.value = this.value.replace(/[^0-9]/g, '');
                    });

                    // 2. Remove Gallery Image
                    $('.btn-remove-image').on('click', function() {
                        const $item = $(this).closest('.gallery-item');
                        const imagePath = $item.data('image-path');
                        $item.fadeOut(300, function() {
                            $(this).remove();
                            $('#removedImagesContainer').append(`<input type="hidden" name="removed_images[]" value="${imagePath}">`);
                            $('#currentPhotoCount').text(parseInt($('#currentPhotoCount').text()) - 1);
                        });
                    });

                    // 3. Cover Photo Preview
                    $('#coverPhotoInput').on('change', function(e) {
                        const file = e.target.files[0];
                        if (file) {
                            const reader = new FileReader();
                            reader.onload = function(event) {
                                $('#coverPreview').attr('src', event.target.result).removeClass('hidden');
                                $('#coverPlaceholder').addClass('hidden');
                                $('#removeCoverInput').val('0');
                            }
                            reader.readAsDataURL(file);
                        }
                    });

                    $('#btnRemoveCover').on('click', function() {
                        $('#coverPreview').addClass('hidden').attr('src', '');
                        $('#coverPlaceholder').removeClass('hidden');
                        $('#coverPhotoInput').val(''); 
                        $('#removeCoverInput').val('1');
                    });

                    // 4. Music Logic
                    $('#songInput').on('change', function(e) {
                        const file = e.target.files[0];
                        if (file) {
                            const url = URL.createObjectURL(file);
                            $('#songPreview').attr('src', url).removeClass('hidden');
                            $('#btnRemoveSong').removeClass('hidden');
                            $('#removeSongInput').val('0');
                            document.getElementById('songPreview').load();
                        }
                    });

                    $('#btnRemoveSong').on('click', function() {
                        const audio = document.getElementById('songPreview');
                        audio.pause();
                        $('#songPreview').addClass('hidden').attr('src', '');
                        $('#songInput').val('');
                        $(this).addClass('hidden');
                        $('#removeSongInput').val('1');
                    });

                    // 5. Bulk Upload Preview (Fixing Selection)
                    $('#albumImages').on('change', function(e) {
                        const preview = $('#imageGridPreview');
                        preview.empty();
                        const files = e.target.files;
                        $('#imageCountLabel').text(`${files.length} Selected`);

                        Array.from(files).forEach(file => {
                            const reader = new FileReader();
                            reader.onload = function(event) {
                                preview.append(`<div class="aspect-square rounded-xl overflow-hidden border border-gray-200 shadow-sm"><img src="${event.target.result}" class="w-full h-full object-cover"></div>`);
                            }
                            reader.readAsDataURL(file);
                        });
                    });

                    // 6. Album Type Toggle
                    $('#albumTypeSelect').on('change', function() {
                        if ($(this).val() === 'Custom') {
                            $('#customTypeInput').removeClass('hidden').focus();
                        } else {
                            $('#customTypeInput').addClass('hidden').val('');
                        }
                    });
                });
            </script>

            <style>
                .custom-scrollbar::-webkit-scrollbar { width: 5px; }
                .custom-scrollbar::-webkit-scrollbar-thumb { background: #cbd5e1; border-radius: 10px; }
                .gallery-item img { transition: transform 0.5s ease; }
                .gallery-item:hover img { transform: scale(1.08); }
                input[type="text"]:read-only { background-color: #f8fafc; cursor: not-allowed; }
            </style>
@endsection