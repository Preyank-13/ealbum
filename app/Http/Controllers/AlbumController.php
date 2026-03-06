<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Studio;
use App\Models\Album;
use App\Models\Gallery;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class AlbumController extends Controller
{
    public function apiIndex()
    {
        $albums = Album::with('images')->get();
        return response()->json(['success' => true, 'data' => $albums]);
    }

    public function index()
    {
        $albums = Studio::with('albums')->latest()->get();
        return view('admin.pages.index', compact('albums'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'studio_name' => 'required|string|max:255',
            'contact_person' => 'required|string|max:255',
            'studio_email' => 'required|email|max:255',
            'studio_contact' => 'required',
            'album_name' => 'required|string|max:255',
            'unique_code' => 'required|unique:albums,unique_code',
            'cover_photo' => 'required|image|max:40000',
            'album_song' => 'nullable|mimes:mp3,wav|max:20000',
            'album_photos.*' => 'image|max:40000',
        ]);

        DB::beginTransaction();
        try {
            $studio = Studio::create([
                'user_id' => auth()->id(),
                'studio_name' => $request->studio_name,
                'contact_person' => $request->contact_person,
                'studio_email' => $request->studio_email,
                'studio_contact' => $request->studio_contact,
                'experience' => $request->experience,
            ]);

            $coverName = null;
            if ($request->hasFile('cover_photo')) {
                $file = $request->file('cover_photo');
                $coverName = time() . '_cover_' . str_replace(' ', '_', $file->getClientOriginalName());
                $file->storeAs('album_covers', $coverName, 'public');
            }

            $songName = null;
            if ($request->hasFile('album_song')) {
                $file = $request->file('album_song');
                $songName = time() . '_song_' . str_replace(' ', '_', $file->getClientOriginalName());
                $file->storeAs('songs', $songName, 'public');
            }

            $album = Album::create([
                'studio_id' => $studio->id,
                'album_name' => $request->album_name,
                'album_type' => $request->album_type,
                'unique_code' => $request->unique_code,
                'cover_photo' => $coverName,
                'album_song' => $songName,
            ]);

            $photoNames = [];
            if ($request->hasFile('album_photos')) {
                foreach ($request->file('album_photos') as $photo) {
                    $pName = time() . '_' . str_replace(' ', '_', $photo->getClientOriginalName());
                    $photo->storeAs('galleries', $pName, 'public');
                    $photoNames[] = $pName;
                }
            }

            Gallery::create([
                'studio_id' => $studio->id,
                'images' => $photoNames,
                'status' => 'active',
            ]);

            DB::commit();
            return redirect()->route('admin.index')->with('success', 'Album Created Successfully!');
        } catch (\Exception $e) {
            DB::rollback();
            return back()->withInput()->withErrors($e->getMessage());
        }
    }

    // ... baki methods wahi rahenge

    // ✅ FIXED: Update logic without ID
   public function update(Request $request, $id)
{
    set_time_limit(300);

    // URL ki ID ke base par specific studio ko dhundhein
    $studio = Studio::where('id', $id)
        ->where('user_id', auth()->id())
        ->with(['album', 'gallery'])
        ->firstOrFail();

    $album = $studio->album;
    $gallery = $studio->gallery;

    // 1. Studio Update
    $studio->update($request->only(['studio_name', 'contact_person', 'studio_email', 'studio_contact', 'experience']));

    // 2. Album Data Preparation
    $albumType = ($request->album_type == 'Custom') ? $request->custom_type : $request->album_type;
    $albumData = ['album_name' => $request->album_name, 'album_type' => $albumType];

    // 3. Cover Photo Update
    if ($request->hasFile('cover_photo')) {
        if ($album->cover_photo) {
            Storage::disk('public')->delete('album_covers/' . $album->cover_photo);
        }
        $file = $request->file('cover_photo');
        $name = time() . '_cover_' . str_replace(' ', '_', $file->getClientOriginalName());
        $file->storeAs('album_covers', $name, 'public');
        $albumData['cover_photo'] = $name;
    }

    // 4. Song Update
    if ($request->hasFile('album_song')) {
        if ($album->album_song) {
            Storage::disk('public')->delete('songs/' . $album->album_song);
        }
        $file = $request->file('album_song');
        $name = time() . '_song_' . str_replace(' ', '_', $file->getClientOriginalName());
        $file->storeAs('songs', $name, 'public');
        $albumData['album_song'] = $name;
    }

    $album->update($albumData);

    // 5. Gallery Logic
    $currentImages = is_array($gallery->images) ? $gallery->images : [];
    
    // Purani photos hatana
    if ($request->has('removed_images')) {
        foreach ($request->removed_images as $fileName) {
            Storage::disk('public')->delete('galleries/' . $fileName);
            $currentImages = array_diff($currentImages, [$fileName]);
        }
    }

    // Nayi photos add karna
    if ($request->hasFile('album_photos')) {
        foreach ($request->file('album_photos') as $photo) {
            $pName = time() . '_' . str_replace(' ', '_', $photo->getClientOriginalName());
            $photo->storeAs('galleries', $pName, 'public');
            $currentImages[] = $pName;
        }
    }

    $gallery->update(['images' => array_values($currentImages)]);

    return redirect()->back()->with('success', 'Updated Successfully!');
}


    public function destroy($id)
    {
        $studio = Studio::findOrFail($id);
        $album = Album::where('studio_id', $studio->id)->first();
        $gallery = Gallery::where('studio_id', $studio->id)->first();

        if ($album) {
            if ($album->cover_photo) {
                @unlink(public_path('storage/album_covers/' . $album->cover_photo));
            }
            if ($album->album_song) {
                @unlink(public_path('storage/songs/' . $album->album_song));
            }
            $album->delete();
        }

        if ($gallery) {
            $images = is_array($gallery->images) ? $gallery->images : json_decode($gallery->images);
            if ($images) {
                foreach ($images as $img) {
                    @unlink(public_path('storage/galleries/' . $img));
                }
            }
            $gallery->delete();
        }

        $studio->delete();
        return back()->with('success', 'Album deleted!');
    }

// ✅ NEW: Added Edit Method
    public function edit($id)
    {
        // Studio ID ke base par data fetch karein aur sath mein album/gallery load karein
        $studio = Studio::where('id', $id)
            ->where('user_id', auth()->id())
            ->with(['album', 'gallery'])
            ->firstOrFail();

        // Aapka form $gallery variable use kar raha hai, toh wahi bhejenge
        $gallery = $studio->gallery;

        // Aapke blade file ka path check kar lena (admin.pages.edit_gallery ya gallery)
        return view('admin.pages.gallery', compact('gallery'));
    }


    public function fetchAlbumContent(Request $request)
{
    $code = $request->input('access_code');
    
    // Album table se unique_code match karein
    $album = Album::where('unique_code', $code)->first();

    if (!$album) {
        return response()->json(['success' => false, 'message' => 'Invalid Access Code!']);
    }

    // Studio aur uski linked Gallery fetch karein
    $studio = Studio::with('gallery')->find($album->studio_id);

    return response()->json([
        'success' => true,
        'data' => [
            'album_name' => $album->album_name,
            'cover' => asset('storage/album_covers/' . $album->cover_photo),
            'music' => $album->album_song ? asset('storage/songs/' . $album->album_song) : null,
            'images' => array_map(function($img) {
                return asset('storage/galleries/' . $img);
            }, $studio->gallery->images)
        ]
    ]);
}

public function verifyCode(Request $request) {
    $album = Album::where('unique_code', $request->access_code)->first();
    
    if (!$album) {
        return back()->with('error', 'Invalid Code!');
    }
    
    // Code sahi hai toh Viewer page par bhej do
    return redirect()->route('user.album.view', ['code' => $album->unique_code]);
}

public function showViewer($code) {
    $album = Album::where('unique_code', $code)->with('studio.gallery')->firstOrFail();
    
    // PHP array mein photos convert karein
    $images = $album->studio->gallery->images; 

    return view('user.pages.viewer', compact('album', 'images'));
}

   public function show($id)
{
    // Specific ID aur logged-in user ka data fetch karein
    $studio = Studio::where('id', $id)
        ->where('user_id', auth()->id())
        ->with(['album', 'gallery'])
        ->first();

    // Agar entry nahi milti, toh Dashboard par redirect karein
    if (!$studio) {
        return redirect()->route('admin.index')->with('error', 'Requested album not found.');
    }

    $gallery = $studio->gallery;
    
    // Gallery view par data bhejhein
    return view('admin.pages.gallery', compact('gallery'));
}


}