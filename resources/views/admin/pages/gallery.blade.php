@extends('admin.pages.adminApp')

@section('content')
    {{-- Form Action aur Method --}}
    <form action="{{ route('admin.gallery.update') }}" method="POST" enctype="multipart/form-data" id="galleryUpdateForm">
        @csrf
        @method('PUT') 
        
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
                                <i class="fa-solid fa-arrow-left mr-2"></i> Back to Dashboard
                            </a>
                            <button type="submit"
                                class="bg-green-600 text-white px-5 py-2 rounded-xl text-sm font-bold hover:bg-green-700 transition shadow-lg shadow-green-100">
                                <i class="fa-solid fa-floppy-disk mr-2"></i> Update Changes
                            </button>
                        </div>
                    </div>

                    <div class="bg-white rounded-3xl shadow-sm border border-gray-100 p-8 space-y-8">
                        
                        <h4 class="font-bold text-gray-700 flex items-center gap-2">
                            <i class="fa-solid fa-camera text-indigo-500"></i> Update Your Studio Details
                        </h4>
                        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                            <div class="space-y-2">
                                <label class="text-xs font-bold text-gray-500 uppercase">Your Studio Name</label>
                                <input type="text" name="studio_name" value="{{ $gallery->studio->studio_name ?? '' }}"
                                    class="w-full border-gray-200 rounded-xl p-3 text-sm focus:ring-2 focus:ring-indigo-400 outline-none border transition-all">
                            </div>
                            <div class="space-y-2">
                                <label class="text-xs font-bold text-gray-500 uppercase">Studio Contact Person</label>
                                <input type="text" name="contact_person" value="{{ $gallery->studio->contact_person ?? '' }}"
                                    class="w-full border-gray-200 rounded-xl p-3 text-sm focus:ring-2 focus:ring-indigo-400 outline-none border transition-all">
                            </div>
                            <div class="space-y-2">
                                <label class="text-xs font-bold text-gray-500 uppercase">Studio Email</label>
                                <input type="email" name="studio_email" value="{{ $gallery->studio->studio_email ?? '' }}"
                                    class="w-full border-gray-200 rounded-xl p-3 text-sm focus:ring-2 focus:ring-indigo-400 outline-none border transition-all">
                            </div>
                            <div class="space-y-2">
                                <label class="text-xs font-bold text-gray-500 uppercase">Contact No</label>
                                <div class="flex gap-2">
                                    <input type="text" name="studio_contact" value="{{ $gallery->studio->studio_contact ?? '' }}"
                                        class="flex-1 border-gray-200 rounded-xl p-3 text-sm focus:ring-2 focus:ring-indigo-400 outline-none border transition-all">
                                    <button type="button" class="bg-green-50 text-green-600 border border-green-200 px-4 py-2 rounded-xl hover:bg-green-500 hover:text-white transition">
                                        <i class="fa-brands fa-whatsapp text-lg"></i>
                                    </button>
                                </div>
                            </div>
                            <div class="space-y-2">
                                <label class="text-xs font-bold text-gray-500 uppercase">Photography Experience</label>
                                <input type="text" name="experience" value="{{ $gallery->studio->experience ?? '' }}"
                                    class="w-full border-gray-200 rounded-xl p-3 text-sm focus:ring-2 focus:ring-indigo-400 outline-none border transition-all">
                            </div>
                        </div>

                        <h4 class="font-bold text-gray-700 flex items-center gap-2 pt-4 border-t border-gray-50">
                            <i class="fa-solid fa-images text-purple-500"></i> Update Your Album Details
                        </h4>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div class="space-y-2">
                                <label class="text-xs font-bold text-gray-500 uppercase">Your Album Name</label>
                                <input type="text" name="album_name" value="{{ $gallery->studio->album->album_name ?? '' }}"
                                    class="w-full border-gray-200 rounded-xl p-3 text-sm focus:ring-2 focus:ring-indigo-400 outline-none border transition-all">
                            </div>

                            <div class="space-y-2">
                                <label class="text-xs font-bold text-gray-500 uppercase">Your Album Type</label>
                                <div class="flex gap-2">
                                    @php 
                                        $defaultTypes = ['Wedding', 'Corporate', 'Commercial', 'Maternity'];
                                        $dbValue = $gallery->studio->album->album_type ?? '';
                                        $isCustom = !in_array($dbValue, $defaultTypes) && !empty($dbValue);
                                    @endphp
                                    <select id="albumTypeSelect" name="album_type"
                                        class="flex-1 border-gray-200 rounded-xl p-3 text-sm focus:ring-2 focus:ring-indigo-400 outline-none border transition-all">
                                        <option value="Wedding" {{ $dbValue == 'Wedding' ? 'selected' : '' }}>Wedding Photography</option>
                                        <option value="Corporate" {{ $dbValue == 'Corporate' ? 'selected' : '' }}>Corporate Event</option>
                                        <option value="Commercial" {{ $dbValue == 'Commercial' ? 'selected' : '' }}>Commercial/Product</option>
                                        <option value="Maternity" {{ $dbValue == 'Maternity' ? 'selected' : '' }}>Maternity/Baby Shoot</option>
                                        <option value="Custom" {{ $isCustom ? 'selected' : '' }}>Other (Custom Type)</option>
                                    </select>
                                    <input type="text" id="customTypeInput" name="custom_type" value="{{ $isCustom ? $dbValue : '' }}"
                                        placeholder="Enter custom type..."
                                        class="{{ $isCustom ? '' : 'hidden' }} flex-1 border-gray-200 rounded-xl p-3 text-sm focus:ring-2 focus:ring-indigo-400 outline-none border transition-all">
                                </div>
                            </div>

                            <div class="space-y-2">
                                <label class="text-xs font-bold text-gray-500 uppercase">Album Cover Photo</label>
                                <div class="relative aspect-square w-48 rounded-2xl overflow-hidden border-2 border-dashed border-gray-200 bg-gray-50 group flex items-center justify-center">
                                    <input type="file" id="coverPhotoInput" name="cover_photo" accept="image/*" class="absolute inset-0 opacity-0 cursor-pointer z-20">
                                    
                                    <img id="coverPreview" 
                                        src="{{ isset($gallery->studio->album->cover_photo) ? asset('storage/' . $gallery->studio->album->cover_photo) : '' }}" 
                                        class="{{ isset($gallery->studio->album->cover_photo) ? '' : 'hidden' }} w-full h-full object-cover">
                                    
                                    <div id="coverPlaceholder" class="{{ isset($gallery->studio->album->cover_photo) ? 'hidden' : '' }} flex flex-col items-center justify-center text-gray-300">
                                        <i class="fa-solid fa-image text-2xl mb-1"></i>
                                        <p class="text-[10px] font-bold uppercase">Change Cover</p>
                                    </div>
                                    {{-- Cover Remove Button --}}
                                    <button type="button" id="btnRemoveCover" class="absolute top-2 right-2 z-30 bg-red-500 text-white w-8 h-8 rounded-full flex items-center justify-center opacity-0 group-hover:opacity-100 transition-opacity">
                                        <i class="fa-solid fa-xmark"></i>
                                    </button>
                                    <input type="hidden" name="remove_cover" id="removeCoverInput" value="0">
                                </div>
                            </div>

                            <div class="space-y-2">
                                <label class="text-xs font-bold text-gray-500 uppercase">Album Unique Code</label>
                                <input type="text" value="{{ $gallery->studio->album->unique_code ?? '' }}" readonly 
                                    class="w-full bg-gray-50 border-gray-200 rounded-xl p-3 text-sm font-mono font-bold text-indigo-600 border">
                            </div>
                        </div>

                        <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 pt-4 border-t border-gray-50">
                            <div class="space-y-4">
                                <label class="text-xs font-bold text-gray-500 uppercase">Background Music (MP3)</label>
                                <div class="flex items-center gap-4">
                                    <div class="flex-1 border-2 border-dashed border-gray-200 rounded-2xl p-4 bg-gray-50/50">
                                        <input type="file" id="songInput" name="album_song" accept="audio/*"
                                            class="text-xs cursor-pointer file:mr-4 file:py-2 file:px-4 file:rounded-xl file:border-0 file:bg-indigo-600 file:text-white">
                                    </div>
                                    <div id="songSuccess" class="{{ isset($gallery->studio->album->album_song) ? '' : 'hidden' }} w-10 h-10 bg-green-500 text-white rounded-full flex items-center justify-center">
                                        <i class="fa-solid fa-check"></i>
                                    </div>
                                </div>
                                <audio id="songPreview" controls class="{{ isset($gallery->studio->album->album_song) ? '' : 'hidden' }} w-full h-10 mt-2">
                                    @if(isset($gallery->studio->album->album_song))
                                        <source src="{{ asset('storage/' . $gallery->studio->album->album_song) }}" type="audio/mpeg">
                                    @endif
                                </audio>
                            </div>

                            <div class="space-y-4">
                                <div class="flex items-center justify-between">
                                    <label class="text-xs font-bold text-gray-500 uppercase">Add More Photos (Max 50)</label>
                                    <span id="imageCountLabel" class="text-[10px] font-bold text-gray-400 bg-gray-100 px-3 py-1 rounded-full uppercase">0 / 50 Selected</span>
                                </div>
                                <div class="border-2 border-dashed border-indigo-100 rounded-3xl p-6 bg-indigo-50/10 text-center group hover:border-indigo-400 transition-all">
                                    <input type="file" id="albumImages" name="album_photos[]" multiple accept="image/*" class="hidden">
                                    <label for="albumImages" class="cursor-pointer flex flex-col items-center">
                                        <i class="fa-solid fa-cloud-arrow-up text-3xl text-indigo-300 group-hover:text-indigo-600 mb-2"></i>
                                        <span class="bg-indigo-600 text-white px-6 py-2 rounded-xl text-xs font-bold shadow-xl shadow-indigo-100">Choose Photos</span>
                                    </label>
                                </div>
                            </div>
                        </div>

                        <div id="imageGridPreview" class="grid grid-cols-3 sm:grid-cols-4 lg:grid-cols-6 gap-4 mt-6"></div>
                    </div>

                    <h4 class="font-bold text-gray-700 flex items-center gap-2 pt-6"><i class="fa-solid fa-images text-indigo-500"></i> Current Gallery Photos (Click X to remove)</h4>
                    
                    {{-- Container for hidden inputs of removed images --}}
                    <div id="removedImagesContainer"></div>

                    @if($gallery && is_array($gallery->images))
                        <div id="currentGalleryGrid" class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 xl:grid-cols-5 gap-6 pb-10">
                            @foreach($gallery->images as $index => $image)
                                <div class="gallery-item group relative aspect-square bg-white rounded-2xl overflow-hidden border border-gray-100 shadow-sm hover:shadow-xl transition-all" data-image-path="{{ $image }}">
                                    <img src="{{ asset('storage/' . $image) }}" class="w-full h-full object-cover">
                                    
                                    {{-- Delete/Cross Mark --}}
                                    <button type="button" class="btn-remove-image absolute top-2 right-2 bg-red-500 text-white w-7 h-7 rounded-full flex items-center justify-center opacity-0 group-hover:opacity-100 transition-opacity shadow-lg">
                                        <i class="fa-solid fa-xmark"></i>
                                    </button>

                                    <div class="absolute inset-0 bg-black/40 opacity-0 group-hover:opacity-100 transition-opacity flex items-center justify-center pointer-events-none">
                                        <div class="bg-white/20 backdrop-blur-md text-white p-3 rounded-full">
                                            <i class="fa-solid fa-expand"></i>
                                        </div>
                                    </div>
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
            // 1. Remove Current Gallery Images
            $('.btn-remove-image').on('click', function() {
                const $item = $(this).closest('.gallery-item');
                const imagePath = $item.data('image-path');
                
                // Confirm delete UI se hatao
                $item.fadeOut(300, function() {
                    $(this).remove();
                    // Hidden input add karein taaki controller ko pata chale kaunsa remove karna hai
                    $('#removedImagesContainer').append(`<input type="hidden" name="removed_images[]" value="${imagePath}">`);
                    
                    // Count update karein
                    const currentCount = parseInt($('#currentPhotoCount').text());
                    $('#currentPhotoCount').text(currentCount - 1);
                });
            });

            // 2. Remove Cover Photo logic
            $('#btnRemoveCover').on('click', function(e) {
                e.preventDefault();
                $('#coverPreview').addClass('hidden').attr('src', '');
                $('#coverPlaceholder').removeClass('hidden');
                $('#removeCoverInput').val('1'); // Server ko bataye ki purana cover delete karna hai
                $(this).addClass('opacity-0');
            });

            // 3. Single Cover Photo Preview
            $('#coverPhotoInput').on('change', function(e) {
                const file = e.target.files[0];
                if (file) {
                    const reader = new FileReader();
                    reader.onload = function(event) {
                        $('#coverPreview').attr('src', event.target.result).removeClass('hidden');
                        $('#coverPlaceholder').addClass('hidden');
                        $('#btnRemoveCover').removeClass('opacity-0');
                        $('#removeCoverInput').val('0'); // Naya photo hai, isliye delete flag 0
                    }
                    reader.readAsDataURL(file);
                }
            });

            // 4. Background Music Preview
            $('#songInput').on('change', function(e) {
                const file = e.target.files[0];
                if (file) {
                    const url = URL.createObjectURL(file);
                    const player = document.getElementById('songPreview');
                    $('#songPreview').attr('src', url).removeClass('hidden');
                    $('#songSuccess').removeClass('hidden');
                    player.load();
                }
            });

            // 5. New Gallery Photos Grid Preview
            $('#albumImages').on('change', function(e) {
                const preview = $('#imageGridPreview');
                preview.empty();
                const files = e.target.files;
                $('#imageCountLabel').text(`${files.length} / 50 Selected`);

                Array.from(files).forEach(file => {
                    const reader = new FileReader();
                    reader.onload = function(event) {
                        const html = `
                            <div class="aspect-square rounded-xl overflow-hidden border border-gray-200 shadow-sm relative group">
                                <img src="${event.target.result}" class="w-full h-full object-cover">
                            </div>`;
                        preview.append(html);
                    }
                    reader.readAsDataURL(file);
                });
            });

            // 6. Album Type Logic
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
        .custom-scrollbar::-webkit-scrollbar { width: 6px; }
        .custom-scrollbar::-webkit-scrollbar-thumb { background: #e2e8f0; border-radius: 10px; }
        .grid>div { animation: fadeInUp 0.5s ease-out forwards; }
        @keyframes fadeInUp { from { opacity: 0; transform: translateY(20px); } to { opacity: 1; transform: translateY(0); } }
        .btn-remove-image:hover { transform: scale(1.1); }
    </style>
@endsection