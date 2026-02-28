<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Studio;
use App\Models\Album;
use App\Models\Gallery;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str; // ✅ added

class AlbumController extends Controller
{

    public function apiIndex()
    {
        $albums = Album::with('images')->get();

        return response()->json([
            'success' => true,
            'data' => $albums
        ]);
    }
    // Display Listing
    public function index()
    {
        $albums = Studio::with('albums')->latest()->get(); // ✅ fixed relationship
        return view('admin.pages.index', compact('albums'));
    }

    // Save New Album
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

        // 1️⃣ Create Studio
        $studio = Studio::create([
            'user_id' => auth()->id(),
            'studio_name' => $request->studio_name,
            'contact_person' => $request->contact_person,
            'studio_email' => $request->studio_email,
            'studio_contact' => $request->studio_contact,
            'experience' => $request->experience,
        ]);

        // 2️⃣ Cover Photo
        $coverName = null;
        if ($request->hasFile('cover_photo')) {
            $file = $request->file('cover_photo');
            $coverName = time() . '_cover_' . str_replace(' ', '_', $file->getClientOriginalName());
            $file->storeAs('album_covers', $coverName, 'public');
        }

        // 3️⃣ Song
        $songName = null;
        if ($request->hasFile('album_song')) {
            $file = $request->file('album_song');
            $songName = time() . '_song_' . str_replace(' ', '_', $file->getClientOriginalName());
            $file->storeAs('songs', $songName, 'public');
        }

        // 4️⃣ Create Album
        $album = Album::create([
            'studio_id' => $studio->id,
            'album_name' => $request->album_name,
            'album_type' => $request->album_type,
            'unique_code' => $request->unique_code,
            'cover_photo' => $coverName,
            'album_song' => $songName,
        ]);

        // 5️⃣ Multiple Photos Save Properly
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

        return redirect()->route('admin.index')
            ->with('success', 'Album Created Successfully!');

    } catch (\Exception $e) {
        DB::rollback();
        return back()->withInput()->withErrors($e->getMessage());
    }
}

    //Update Code

    public function update(Request $request)
{
    set_time_limit(300);

    $studio = Studio::where('user_id', auth()->id())
        ->with(['album', 'gallery'])
        ->firstOrFail();

    $album = $studio->album;
    $gallery = $studio->gallery;

    // 1️⃣ Update Studio
    $studio->update($request->only([
        'studio_name',
        'contact_person',
        'studio_email',
        'studio_contact',
        'experience'
    ]));

    // 2️⃣ Album Type Fix
    $albumType = ($request->album_type == 'Custom')
        ? $request->custom_type
        : $request->album_type;

    $albumData = [
        'album_name' => $request->album_name,
        'album_type' => $albumType,
    ];

    // 3️⃣ Cover Update
    if ($request->hasFile('cover_photo')) {

        if ($album->cover_photo) {
            Storage::disk('public')->delete('album_covers/' . $album->cover_photo);
        }

        $file = $request->file('cover_photo');
        $name = time() . '_cover_' . str_replace(' ', '_', $file->getClientOriginalName());
        $file->storeAs('album_covers', $name, 'public');

        $albumData['cover_photo'] = $name;
    }

    // 4️⃣ Song Update
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

    // 5️⃣ Gallery Logic
    $currentImages = is_array($gallery->images)
        ? $gallery->images
        : [];

    // Remove Selected Images
    if ($request->has('removed_images')) {
        foreach ($request->removed_images as $fileName) {

            Storage::disk('public')->delete('galleries/' . $fileName);
            $currentImages = array_diff($currentImages, [$fileName]);
        }
    }

    // Add New Images
    if ($request->hasFile('album_photos')) {
        foreach ($request->file('album_photos') as $photo) {

            $pName = time() . '_' . str_replace(' ', '_', $photo->getClientOriginalName());
            $photo->storeAs('galleries', $pName, 'public');

            $currentImages[] = $pName;
        }
    }

    $gallery->update([
        'images' => array_values($currentImages)
    ]);

    return redirect()->back()
        ->with('success', 'Updated Successfully!');
}

    // Delete Logic
    public function destroy($id)
    {
        $studio = Studio::findOrFail($id);

        $album = Album::where('studio_id', $studio->id)->first();
        $gallery = Gallery::where('studio_id', $studio->id)->first();

        if ($album) {
            if ($album->cover_photo) {
                @unlink(public_path('storage/' . $album->cover_photo));
            }
            if ($album->album_song) {
                @unlink(public_path('storage/' . $album->album_song));
            }
            $album->delete();
        }

        if ($gallery) {
            $images = is_array($gallery->images)
                ? $gallery->images
                : json_decode($gallery->images);

            if ($images) {
                foreach ($images as $img) {
                    @unlink(public_path('storage/' . $img));
                }
            }
            $gallery->delete();
        }

        $studio->delete();

        return back()->with('success', 'Album and its photos have been deleted!');
    }


    // Fetch / Show Images
   public function show()
{
    $studio = Studio::where('user_id', auth()->id())
        ->with(['album', 'gallery'])
        ->firstOrFail();

    $gallery = $studio->gallery;

    return view('admin.pages.gallery', compact('gallery'));
}

}