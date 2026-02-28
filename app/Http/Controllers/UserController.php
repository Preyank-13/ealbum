<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index()
    {
        return view('user.pages.welcome');
    }
    public function about()
    {
        return view('user.pages.about');
    }
    public function contact()
    {
        return view('user.pages.contact');
    }
    public function price()
    {
        return view('user.pages.price');
    }
    public function blog()
    {
        return view('user.pages.blog');
    }
    public function access()
    {
        return view('user.pages.access');
    }

    //Show Photos
    public function showGallery($unique_code)
{
    // 1. Unique code se album dhundein
    $album = \App\Models\Album::where('unique_code', $unique_code)->firstOrFail();

    // 2. Us album se related gallery fetch karein
    $gallery = \App\Models\Gallery::where('studio_id', $album->studio_id)->first();

    // 3. Photos ko array format mein lein
    $photos = [];
    if ($gallery && !empty($gallery->images)) {
        // Agar model mein casts set hai toh seedha use karein, nahi toh decode
        $photos = is_array($gallery->images) ? $gallery->images : json_decode($gallery->images, true);
    }

    return view('user.pages.gallery_display', compact('album', 'photos'));
}
}
