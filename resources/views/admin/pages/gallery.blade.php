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
                <p class="text-sm text-gray-500 font-medium text-center px-6">Please wait, we are optimizing and uploading your high-quality photos (Up to 10MB).</p>
                <div class="w-64 h-2 bg-gray-100 rounded-full mt-4 overflow-hidden">
                    <div class="h-full bg-indigo-600 animate-pulse" style="width: 100%"></div>
                </div>
            </div>

            <form action="{{ route('admin.gallery.update', $gallery->studio->id) }}" method="POST" enctype="multipart/form-data" id="galleryUpdateForm">
                @method('PUT') 
                @csrf

                <div class="flex h-screen overflow-hidden bg-[#f4f7fe]">
                    @include('admin.extra.sidebar')

                    <div id="main-panel" class="flex-1 flex flex-col min-w-0 overflow-hidden transition-all duration-500 ease-in-out">
                        @include('admin.extra.header')

                        <div class="flex-1 overflow-y-auto p-6 space-y-6 custom-scrollbar">

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
                                        <label class="text-xs font-bold text-gray-500 uppercase">Contact No</label>
                                        <input type="text" id="studio_contact" name="studio_contact" maxlength="10"
                                            value="{{ old('studio_contact', $gallery->studio->studio_contact ?? '') }}"
                                            class="w-full border-gray-200 rounded-xl p-3 text-sm focus:ring-2 focus:ring-indigo-400 outline-none border transition-all">
                                    </div>
                                    <div class="space-y-2">
                                        <label class="text-xs font-bold text-gray-500 uppercase tracking-wider">Experience</label>
                                        <input type="text" name="experience" value="{{ old('experience', $gallery->studio->experience ?? '') }}"
                                                class="w-full border-gray-200 rounded-xl p-3 text-sm focus:ring-2 focus:ring-indigo-400 outline-none border transition-all">
                                    </div>
                                </div>

                                {{-- 2. Cover Photo Section (Small Size Integration) --}}
                                <h4 class="font-bold text-gray-700 flex items-center gap-2 pt-4 border-t border-gray-50">
                                    <i class="fa-solid fa-image text-blue-500"></i> Album Cover Photo (Max 10MB)
                                </h4>
                                {{-- 🟢 Chhota preview aur style --}}
                                <div class="flex items-start gap-8 bg-gray-50/50 p-6 rounded-2xl border border-gray-100">
                                    <div class="relative group h-32 w-48 bg-gray-100 rounded-2xl overflow-hidden border border-gray-200 flex items-center justify-center shrink-0 shadow-inner">
                                        <img id="coverPreview" src="{{ $gallery->studio->album->cover_photo ? asset('storage/album_covers/' . $gallery->studio->album->cover_photo) : '' }}" 
                                             class="w-full h-full object-cover {{ $gallery->studio->album->cover_photo ? '' : 'hidden' }}">
                                        <div id="coverPlaceholder" class="{{ $gallery->studio->album->cover_photo ? 'hidden' : '' }} text-center p-3">
                                            <i class="fa-solid fa-cloud-arrow-up text-2xl text-gray-300"></i>
                                            <p class="text-[9px] text-gray-400 font-bold uppercase mt-1">No Cover</p>
                                        </div>
                                        <button type="button" id="btnRemoveCover" class="absolute top-2 right-2 bg-red-500 text-white w-7 h-7 rounded-full flex items-center justify-center shadow-lg opacity-0 group-hover:opacity-100 transition-all text-xs">
                                            <i class="fa-solid fa-trash-can"></i>
                                        </button>
                                        <input type="hidden" name="remove_cover" id="removeCoverInput" value="0">
                                    </div>
                                    <div class="space-y-3 flex-1">
                                        <label class="block text-xs font-bold text-indigo-600 uppercase">Upload New Cover</label>
                                        <input type="file" name="cover_photo" id="coverPhotoInput" accept="image/*"
                                               class="block w-full text-sm text-gray-500 file:mr-4 file:py-2.5 file:px-6 file:rounded-xl file:border-0 file:text-xs file:font-bold file:bg-indigo-600 file:text-white hover:file:bg-indigo-700 transition-all cursor-pointer">
                                        <p class="text-[10px] text-gray-400 font-medium italic mt-2">Recommended: 1920x1080px (16:9). Images up to 10MB are optimized.</p>
                                    </div>
                                </div>

                                {{-- 3. Album Details --}}
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
                                        <div class="space-y-2">
                                            <label class="text-xs font-bold text-gray-500 uppercase tracking-wider">Album Unique Code</label>
                                            <input type="text" value="{{ $gallery->studio->album->unique_code ?? 'N/A' }}" readonly
                                                    class="w-full bg-gray-50 border-gray-200 rounded-xl p-3 text-sm font-mono font-bold text-indigo-600 border cursor-not-allowed">
                                        </div>
                                    </div>
                                    <div>
                                        <label class="text-xs font-bold text-gray-500 uppercase">Album Type</label>
                                        <input type="text" name="album_type" 
                                            value="{{ old('album_type', $gallery->studio->album->album_type ?? '') }}"
                                            placeholder="Wedding, Event etc."
                                            class="w-full border-gray-200 rounded-xl p-3 text-sm focus:ring-2 focus:ring-indigo-400 outline-none border transition-all">
                                    </div>
                                </div>

                                {{-- 4. Music & Bulk Upload --}}
                                <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 pt-4 border-t border-gray-50">
                                    <div class="space-y-4">
                                        <label class="text-xs font-bold text-gray-500 uppercase">Background Music (MP3 - Max 10MB)</label>
                                        <div class="flex items-center gap-3">
                                            <div class="flex-1 border-2 border-dashed border-gray-200 rounded-2xl p-4 bg-gray-50/50">
                                                <input type="file" id="songInput" name="album_song" accept="audio/mp3"
                                                    class="text-xs cursor-pointer file:mr-4 file:py-2 file:px-4 file:rounded-xl file:border-0 file:bg-indigo-600 file:text-white">
                                            </div>
                                            <button type="button" id="btnRemoveSong" class="{{ isset($gallery->studio->album->album_song) ? '' : 'hidden' }} w-12 h-12 bg-red-100 text-red-600 rounded-2xl flex items-center justify-center hover:bg-red-500 hover:text-white transition-all shadow-sm">
                                                <i class="fa-solid fa-trash-can"></i>
                                            </button>
                                            <input type="hidden" name="remove_song" id="removeSongInput" value="0">
                                        </div>
                                        <audio id="songPreview" controls class="{{ isset($gallery->studio->album->album_song) ? '' : 'hidden' }} w-full h-10 mt-2 rounded-lg bg-white">
                                            @if(isset($gallery->studio->album->album_song))
                                                <source src="{{ asset('storage/songs/' . $gallery->studio->album->album_song) }}" type="audio/mpeg">
                                            @endif
                                        </audio>
                                    </div>

                                    <div class="space-y-4">
                                        <div class="flex items-center justify-between">
                                            <label class="text-xs font-bold text-gray-500 uppercase">Add Gallery Photos (Max 10MB Each)</label>
                                            <span id="imageCountLabel" class="text-[10px] font-bold text-indigo-500 bg-indigo-50 px-3 py-1 rounded-full uppercase">0 Selected</span>
                                        </div>
                                        <div class="border-2 border-dashed border-indigo-100 rounded-3xl p-6 bg-indigo-50/10 text-center group hover:border-indigo-400 transition-all">
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

                            <h4 class="font-bold text-gray-700 flex items-center gap-2 pt-6"><i class="fa-solid fa-box-archive text-indigo-500"></i> Active Gallery</h4>
                            <div id="removedImagesContainer"></div>

                            @if($gallery && is_array($gallery->images))
                                <div id="currentGalleryGrid" class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 xl:grid-cols-5 gap-6 pb-20">
                                    @foreach($gallery->images as $image)
                                        <div class="gallery-item group relative aspect-square bg-white rounded-2xl overflow-hidden border border-gray-100 shadow-sm hover:shadow-xl transition-all" data-image-path="{{ $image }}">
                                            <img src="{{ asset('web/media/sm/' . $image) }}" class="w-full h-full object-cover">                                    
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
                    $('#galleryUpdateForm').on('submit', function() {
                        $('#uploadLoader').removeClass('hidden').addClass('flex');
                        $('#submitBtn').prop('disabled', true).addClass('opacity-50 cursor-not-allowed');
                    });

                    $('#studio_contact').on('input', function() {
                        this.value = this.value.replace(/[^0-9]/g, '');
                    });

                    $('.btn-remove-image').on('click', function() {
                        const $item = $(this).closest('.gallery-item');
                        const imagePath = $item.data('image-path');
                        $item.fadeOut(300, function() {
                            $(this).remove();
                            $('#removedImagesContainer').append(`<input type="hidden" name="removed_images[]" value="${imagePath}">`);
                            $('#currentPhotoCount').text(parseInt($('#currentPhotoCount').text()) - 1);
                        });
                    });

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

                    $('#albumImages').on('change', function(e) {
                        const preview = $('#imageGridPreview');
                        preview.empty();
                        const files = e.target.files;
                        $('#imageCountLabel').text(`${files.length} Selected`);

                        Array.from(files).forEach(file => {
                            const reader = new FileReader();
                            reader.onload = function(event) {
                                preview.append(`<div class="aspect-square rounded-xl overflow-hidden border border-gray-100 shadow-sm"><img src="${event.target.result}" class="w-full h-full object-cover"></div>`);
                            }
                            reader.readAsDataURL(file);
                        });
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