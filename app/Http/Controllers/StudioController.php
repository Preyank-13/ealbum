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
        $user_id = auth()->id();
        
        // Fetch albums for the projects table
        $albums = Studio::where('user_id', $user_id)
            ->with(['album', 'gallery'])
            ->latest()
                ->get();

        // 🟢 Dashboard par bhi credit history bhej rahe hain taaki table load ho sake
        $creditHistory = Credit::where('user_id', $user_id)->latest()->get();

        return view('admin.pages.index', compact('albums', 'creditHistory'));
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
     */
    public function update(Request $request)
    {
        $user = Auth::user();
        
        $request->validate([
            'name' => 'required|string|max:255',
            'business_name' => 'required|string|max:255',
            'contact_no' => 'required|string|max:15',
            'logo' => 'nullable|image|max:5120', // 5MB limit for logo
        ]);

        $logoName = $user->logo; // Default to old name

        if ($request->hasFile('logo')) {
            // 1. Purani file delete karo (cleanup)
            if ($user->logo && Storage::disk('public')->exists('logos/' . $user->logo)) {
                Storage::disk('public')->delete('logos/' . $user->logo);
            }

            // 2. Nayi file ka unique naam banao
            $file = $request->file('logo');
            $logoName = time() . '_' . str_replace(' ', '_', $file->getClientOriginalName());

            // 3. File save karo
            $file->storeAs('logos', $logoName, 'public');
        }

        // 4. Update Database
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
        // 🟢 Transactions fetch karne ka standard logic
        $creditHistory = Credit::where('user_id', auth()->id())
            ->latest()
            ->get();

        return view('admin.pages.credit', compact('creditHistory'));
    }
}