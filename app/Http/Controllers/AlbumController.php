<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Studio;
use App\Models\Album;
use App\Models\Gallery;
use App\Models\credit;
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
        $albums = Studio::where('user_id', auth()->id())->with('albums')->latest()->get();
        return view('admin.pages.index', compact('albums'));
    }

    public function store(Request $request)
    {
        $user = auth()->user();

        /* LOGIC ADDED: 
           Pehle check karenge ki user ka plan 'Studio' (Unlimited) hai ya nahi.
           Agar Unlimited nahi hai, tabhi 100 credits check karenge.
        */
        if (!$user->is_unlimited && $user->credits < 100) {
            return redirect()->back()->with('error', 'Please add credit to your account to create your album.');
        }

        $request->validate([
            'studio_name' => 'required|string|max:255',
            'contact_person' => 'required|string|max:255',
            'studio_email' => 'required|email|max:255',
            'studio_contact' => 'required',
            'album_name' => 'required|string|max:255',
            'album_type' => 'required|string|max:255',
            'unique_code' => 'required|unique:albums,unique_code',
            'cover_photo' => 'required|image|max:10240',
            'album_song' => 'nullable|mimes:mp3,wav|max:50000',
            'album_photos.*' => 'image|max:10240',
        ]);

        DB::beginTransaction();
        try {
            $studio = Studio::create([
                'user_id' => $user->id,
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

            /* LOGIC ADDED: 
               Deduction sirf tab hoga jab user 'Unlimited' plan par NA HO.
            */
            if (!$user->is_unlimited) {
                // Credit deduction
                $user->decrement('credits', 100);

                // Credit Log Entry
                credit::create([
                    'user_id' => $user->id,
                    'order_id' => 'ALBUM_' . strtoupper(Str::random(10)),
                    'purchase_date' => now(),
                    'album_name' => $request->album_name,
                    'credits' => 100,
                    'amount' => 0,
                    'payment_type' => 'Debit',
                    'status' => 'Success',
                    'message' => '100 credits deducted for album creation'
                ]);
                $msg = 'Album Created and 100 Credits deducted!';
            } else {
                // Unlimited user ke liye sirf success message, deduction nahi
                $msg = 'Album Created successfully under Unlimited Plan!';
            }

            DB::commit();
            return redirect()->route('admin.index')->with('success', $msg);
        } catch (\Exception $e) {
            DB::rollback();
            return back()->withInput()->withErrors($e->getMessage());
        }
    }

    public function update(Request $request, $id)
    {
        set_time_limit(300);
        $studio = Studio::where('id', $id)->where('user_id', auth()->id())->with(['album', 'gallery'])->firstOrFail();
        $album = $studio->album;
        $gallery = $studio->gallery;
        $studio->update($request->only(['studio_name', 'contact_person', 'studio_email', 'studio_contact', 'experience']));

        $albumData = ['album_name' => $request->album_name, 'album_type' => $request->album_type];

        if ($request->hasFile('cover_photo')) {
            if ($album->cover_photo) {
                Storage::disk('public')->delete('album_covers/' . $album->cover_photo);
            }
            $file = $request->file('cover_photo');
            $name = time() . '_cover_' . str_replace(' ', '_', $file->getClientOriginalName());
            $file->storeAs('album_covers', $name, 'public');
            $albumData['cover_photo'] = $name;
        }

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
        $currentImages = is_array($gallery->images) ? $gallery->images : [];
        if ($request->has('removed_images')) {
            foreach ($request->removed_images as $fileName) {
                Storage::disk('public')->delete('galleries/' . $fileName);
                $currentImages = array_diff($currentImages, [$fileName]);
            }
        }

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
        // Eager loading album and gallery
        $studio = Studio::with(['album', 'gallery'])->findOrFail($id);
        $album = $studio->album;
        $gallery = $studio->gallery;

        $deletedAlbumName = $album ? $album->album_name : 'Album';

        // 1. Delete Cover Photo from local storage
        if ($album && $album->cover_photo) {
            $coverPath = 'album_covers/' . $album->cover_photo;
            if (Storage::disk('public')->exists($coverPath)) {
                Storage::disk('public')->delete($coverPath);
            }
        }

        // 2. Delete Album Song from local storage
        if ($album && $album->album_song) {
            $songPath = 'songs/' . $album->album_song;
            if (Storage::disk('public')->exists($songPath)) {
                Storage::disk('public')->delete($songPath);
            }
        }

        // 3. Delete Multiple Gallery Images from local storage
        if ($gallery && $gallery->images) {
            $images = is_array($gallery->images) ? $gallery->images : json_decode($gallery->images, true);
            if (!empty($images)) {
                foreach ($images as $img) {
                    $imgPath = 'galleries/' . $img;
                    if (Storage::disk('public')->exists($imgPath)) {
                        Storage::disk('public')->delete($imgPath);
                    }
                }
            }
        }

        // 4. Sabse pehle child records delete karein (agar Cascade nahi lagaya hai to)
        if ($album)
            $album->delete();
        if ($gallery)
            $gallery->delete();

        // 5. Last mein main Studio record delete karein
        $studio->delete();

        return back()->with('success', $deletedAlbumName . ' deleted successfully');
    }
    public function edit($id)
    {
        $studio = Studio::where('id', $id)->where('user_id', auth()->id())->with(['album', 'gallery'])->firstOrFail();
        $gallery = $studio->gallery;
        return view('admin.pages.gallery', compact('gallery'));
    }

    public function fetchAlbumContent(Request $request)
    {
        $code = $request->input('access_code');
        $album = Album::with(['studio.gallery'])->where('unique_code', $code)->first();
        if (!$album) {
            return response()->json(['success' => false, 'message' => 'Invalid Code!']);
        }
        $studio = $album->studio;
        $gallery = $studio ? $studio->gallery : null;
        if (!$gallery) {
            return response()->json(['success' => false, 'message' => 'Gallery not found.']);
        }

        return response()->json([
            'success' => true,
            'data' => [
                'album_name' => $album->album_name,
                'studio_name' => $studio->studio_name,
                'cover' => asset('storage/album_covers/' . $album->cover_photo),
                'music' => $album->album_song ? asset('storage/songs/' . $album->album_song) : null,
                'images' => array_map(function ($img) {
                    return asset('storage/galleries/' . $img); }, $gallery->images)
            ]
        ]);
    }

    public function verifyCode(Request $request)
    {
        $album = Album::where('unique_code', $request->access_code)->first();
        if (!$album) {
            return back()->with('error', 'Invalid Code!');
        }
        return redirect()->route('user.album.view', ['code' => $album->unique_code]);
    }

    public function showViewer($code)
    {
        $album = Album::where('unique_code', $code)->with('studio.gallery')->firstOrFail();
        $images = $album->studio->gallery->images;
        return view('user.pages.viewer', compact('album', 'images'));
    }

    public function show($id)
    {
        $studio = Studio::where('id', $id)->where('user_id', auth()->id())->with(['album', 'gallery'])->first();
        if (!$studio) {
            return redirect()->route('admin.index')->with('error', 'Album not found.');
        }
        $gallery = $studio->gallery;
        return view('admin.pages.gallery', compact('gallery'));
    }
}