<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\View\View;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     */
    public function create(): View
    {
        return view('auth.register');
    }

    /**
     * Handle an incoming registration request.
     */
    public function store(Request $request): RedirectResponse
    {
        // 1. Validation Logic
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'business_name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:'.User::class],
            'contact_no' => ['required', 'string', 'max:15'],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
            'logo' => ['nullable', 'image', 'mimes:jpg,jpeg,png', 'max:2048'], // Logo validation
            'about' => ['nullable', 'string', 'max:200'],
            'address' => ['nullable', 'string'],
            'city' => ['nullable', 'string', 'max:100'],
            'country' => ['nullable', 'string'],
            'zip_code' => ['nullable', 'string', 'max:10'],
        ]);

        // 2. Logo Upload Logic (Saving to public storage)
        $logoPath = null;
        if ($request->hasFile('logo')) {
            // 'logos' folder mein save hoga public disk par
            $logoPath = $request->file('logo')->store('logos', 'public');
        }

        // 3. User Creation with all new fields
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'business_name' => $request->business_name,
            'contact_no' => $request->contact_no,
            'about' => $request->about,
            'address' => $request->address,
            'city' => $request->city,
            'country' => $request->country ?? 'India',
            'zip_code' => $request->zip_code,
            'logo' => $logoPath, // Database mein file path save hoga
        ]);

        event(new Registered($user));

        Auth::login($user);

        // Aapka dashboard route admin.index hai
        return redirect(route('admin.index', absolute: false));
    }
}