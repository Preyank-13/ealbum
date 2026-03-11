<?php

namespace App\Http\Controllers;

use App\Models\Studio;
use App\Models\Album;
use App\Models\Credit; 
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class StudioController extends Controller
{
    // Dashboard Index
    public function index()
    {
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

    /**
     * 🟢 PROFILE UPDATE LOGIC (Smart Storage)
     * Isme sirf file ka naam DB mein jayega
     */
    public function update(Request $request)
    {
        $user = Auth::user();
        
        $request->validate([
            'name' => 'required|string|max:255',
            'business_name' => 'required|string|max:255',
            'contact_no' => 'required|string|max:15',
            'logo' => 'nullable|image', // Validation remove kar di user ke request par
        ]);

        $logoName = $user->logo; // Purana naam

        if ($request->hasFile('logo')) {
            // 1. Purani file delete karo (cleanup)
            if ($user->logo) {
                Storage::disk('public')->delete('logos/' . $user->logo);
            }

            // 2. Nayi file ka unique naam banao
            $file = $request->file('logo');
            $logoName = time() . '_' . $file->getClientOriginalName();

            // 3. File ko local storage folder mein save karo
            $file->storeAs('logos', $logoName, 'public');
        }

        // 4. DB mein sirf 'logoName' save hoga
        $user->update([
            'name' => $request->name,
            'business_name' => $request->business_name,
            'contact_no' => $request->contact_no,
            'about' => $request->about,
            'address' => $request->address,
            'city' => $request->city,
            'zip_code' => $request->zip_code,
            'logo' => $logoName, 
        ]);

        return back()->with('status', 'Profile Updated Successfully!');
    }

    public function handlePricingRedirect()
    {
        if (auth()->check()) {
            return redirect()->route('admin.credit'); 
        }
        return redirect()->guest(route('login'))->with('url.intended', route('admin.credit'));
    }

    public function credit()
    {
        $creditHistory = Credit::where('user_id', Auth::id())
            ->orderBy('created_at', 'desc')
            ->get();

        return view('admin.pages.credit', compact('creditHistory'));
    }
}