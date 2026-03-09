<?php

namespace App\Http\Controllers;

use App\Models\Studio;
use App\Models\Album;
use App\Models\Credit; // 1. Naya Model Import kiya
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class StudioController extends Controller
{
    // Dashboard Index
    public function index()
    {
        // Sirf login user ke studios aur unke albums/galleries load honge
        $albums = Studio::where('user_id', auth()->id())
            ->with(['album', 'gallery'])
            ->latest()
            ->get();

        return view('admin.pages.index', compact('albums'));
    }

    public function profile()
    {
        $user = Auth::user();
        return view('admin.pages.profile', compact('user'));
    }

    // 2. Pehla wala khali credit() function hata diya
    
    public function smart()
    {
        return view('admin.pages.smartselection');
    }
    public function studio()
    {
        return view('admin.pages.studio');
    }
    public function show()
    {
        return view('admin.pages.gallery');
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/');
    }
    // Profile Update
    public function update(Request $request)
    {
        $user = Auth::user();
        $request->validate([
            'name' => 'required|string|max:255',
            'business_name' => 'required|string|max:255',
            'contact_no' => 'required|string|max:15',
            'logo' => 'nullable|image|max:4096',
        ]);

        $logoPath = $user->logo;
        if ($request->hasFile('logo')) {
            if ($user->logo) {
                Storage::disk('public')->delete($user->logo);
            }
            $logoPath = $request->file('logo')->store('logos', 'public');
        }

        $user->update([
            'name' => $request->name,
            'business_name' => $request->business_name,
            'contact_no' => $request->contact_no,
            'about' => $request->about,
            'address' => $request->address,
            'city' => $request->city,
            'zip_code' => $request->zip_code,
            'logo' => $logoPath,
        ]);

        return back()->with('status', 'Profile Updated Successfully!');
    }

    public function handlePricingRedirect()
    {
        // 1. Check karo user logged in hai ya nahi
        if (auth()->check()) {
            // Agar logged in hai, toh seedha admin ke credit page par bhej do
            return redirect()->route('admin.credit'); 
        }

        // 2. Agar login nahi hai, toh login page par bhejo
        return redirect()->guest(route('login'))->with('url.intended', route('admin.credit'));
    }

    public function credit()
    {
        // Logged-in user ki saari credit history latest pehle
        $creditHistory = Credit::where('user_id', Auth::id())
            ->orderBy('created_at', 'desc')
            ->get();

        return view('admin.pages.credit', compact('creditHistory'));
    }
}