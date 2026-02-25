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
            'cover_photo' => 'required|image|max:3072',
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

            $coverPath = $request->file('cover_photo')
                ->store('album_covers', 'public');

            // ✅ define unique code properly
            $unique_code = $request->unique_code ?? strtoupper(Str::random(10));

            // ✅ fixed variables here
            Album::create([
                'studio_id' => $studio->id,
                'album_name' => $request->album_name,
                'album_type' => $request->album_type,
                'unique_code' => $unique_code,
                'cover_photo' => $coverPath,
                'album_song' => $request->album_song,
            ]);

            $photos = [];

            if ($request->hasFile('album_photos')) {
                foreach ($request->file('album_photos') as $photo) {
                    $photos[] = $photo->store('galleries', 'public');
                }
            }

            // ✅ Step 2 Fix: Agar Model mein $casts laga hai to json_encode hatana hoga
            Gallery::create([
                'studio_id' => $studio->id,
                'images' => $photos, // Seedha array pass karein
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
    // 1. Studio aur Album fetch karein (Logged-in user ke base par)
    $studio = \App\Models\Studio::where('user_id', auth()->id())->first();
    $album = $studio->album;
    $gallery = $studio->gallery;

    // 2. Studio Details Update
    $studio->update([
        'studio_name' => $request->studio_name,
        'contact_person' => $request->contact_person,
        'studio_email' => $request->studio_email,
        'studio_contact' => $request->studio_contact,
        'experience' => $request->experience,
    ]);

    // 3. Album Details Update (Type, Cover & Music)
    $albumType = ($request->album_type == 'Custom') ? $request->custom_type : $request->album_type;
    
    $albumData = [
        'album_name' => $request->album_name,
        'album_type' => $albumType,
    ];

    // Cover Photo Update
    if ($request->hasFile('cover_photo')) {
        $albumData['cover_photo'] = $request->file('cover_photo')->store('covers', 'public');
    } elseif ($request->remove_cover == '1') {
        $albumData['cover_photo'] = null; // Agar user ne X click kiya
    }

    // Background Music Update
    if ($request->hasFile('album_song')) {
        $albumData['album_song'] = $request->file('album_song')->store('music', 'public');
    }

    $album->update($albumData);

    // 4. GALLERY LOGIC (Remove + Add Photos)
    $currentImages = $gallery->images ?? [];

    // Pehle: Jo images remove karni hain unhe list se nikalein
    if ($request->has('removed_images')) {
        $currentImages = array_diff($currentImages, $request->removed_images);
        
        // Optional: Storage folder se bhi file delete karein
        foreach($request->removed_images as $path) {
            \Illuminate\Support\Facades\Storage::disk('public')->delete($path);
        }
    }

    // Baad mein: Nayi photos jo select ki hain unhe add karein
    if ($request->hasFile('album_photos')) {
        foreach ($request->file('album_photos') as $photo) {
            $currentImages[] = $photo->store('gallery', 'public');
        }
    }

    // Database update karein (array_values se indexing sahi rehti hai)
    $gallery->update([
        'images' => array_values($currentImages)
    ]);

    return redirect()->back()->with('success', 'Profile and Gallery updated successfully!');
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

        return back()->with('success', 'Album aur uski saari photos delete ho gayi hain!');
    }


    // Fetch / Show Images
    public function show()
    {
        $gallery = \App\Models\Gallery::whereHas('studio', function ($q) {
            $q->where('user_id', auth()->id());
        })->with(['studio.album'])->first();

        return view('admin.pages.gallery', compact('gallery'));
    }


    // API Data
    public function apiGalleries()
{
    try {
        $galleries = Gallery::all();

        return response()->json([
            'status' => true,
            'data' => $galleries
        ]);
    } catch (\Throwable $e) {
        return response()->json([
            'status' => false,
            'error' => $e->getMessage(),
            'line' => $e->getLine()
        ], 500);
    }
}
}