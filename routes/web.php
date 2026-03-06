<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\StudioController;
use App\Http\Controllers\SocialiteController;
use App\Http\Controllers\AlbumController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

// =============================================================
// ✅ PUBLIC API & VIEWER ROUTES
// =============================================================
Route::get('/api/galleries', [AlbumController::class, 'apiGalleries']);

// --- Public Pages ---
Route::get('/', function () { 
    return view('user.pages.welcome'); 
})->name('user.pages.welcome');

// Social Authentication
Route::controller(SocialiteController::class)->group(function () {
    Route::get('/auth/google', 'googlelogin')->name('auth.google');
    Route::get('/auth/google/callback', 'googleAuthentication')->name('auth.google/callback');
});

// General User Pages
Route::get('/about', [UserController::class, 'about'])->name('user.about');
Route::get('/contact-us', [UserController::class, 'contact'])->name('user.contact');
Route::get('/pricing', [UserController::class, 'price'])->name('user.price');
Route::get('/blogs', [UserController::class, 'blog'])->name('user.blog');

/// Page load karne ke liye
Route::get('/access', [UserController::class, 'access'])->name('user.access');

// Code check karke viewer page par redirect karne ke liye
Route::post('/access/verify', [AlbumController::class, 'verifyCode'])->name('user.access.verify');

// Final Viewer Page jahan flipbook dikhegi
Route::get('/view-album/{code}', [AlbumController::class, 'showViewer'])->name('user.album.view');

// ✅ AJAX Data Fetch Route
Route::post('/fetch-album-content', [AlbumController::class, 'fetchAlbumContent'])->name('album.fetch');

// ✅ Handle Refresh (URL rewrite ke baad refresh karne par page error nahi dega)
Route::get('/{code}', [UserController::class, 'access'])->where('code', '.*');


// =============================================================
// ✅ AUTH PROTECTED ROUTES (Admin Panel)
// =============================================================
Route::middleware(['auth', 'verified'])->group(function () {
    
    Route::get('/dashboard', function () { 
        return redirect()->route('admin.index'); 
    })->name('dashboard');

    Route::prefix('admin')->group(function () {

        // --- Studio & Credits ---
        Route::get('/', [StudioController::class, 'index'])->name('admin.index');
        Route::get('/credit', [StudioController::class, 'credit'])->name('admin.credit');
        Route::get('/smart-selection', [StudioController::class, 'smart'])->name('admin.smartselection');
        Route::get('/create-studio', [StudioController::class, 'studio'])->name('admin.studio'); 
        
        // Secure Logout
        Route::post('/logout', [StudioController::class, 'logout'])->name('admin.logout');

        // --- Profile Management ---
        Route::get('/profile', [StudioController::class, 'profile'])->name('admin.profile');
        Route::post('/profile/update', [StudioController::class, 'update'])->name('admin.profile.update');

        // --- Album & Gallery Management ---
        Route::get('/album-list', [AlbumController::class, 'index'])->name('admin.album.index');
        Route::post('/album/store', [AlbumController::class, 'store'])->name('admin.album.store');

        Route::get('/my-gallery/{id}', [AlbumController::class, 'edit'])->name('admin.my-gallery');
        Route::put('/my-gallery/{id}', [AlbumController::class, 'update'])->name('admin.gallery.update');
        Route::delete('/album/delete/{id}', [AlbumController::class, 'destroy'])->name('admin.album.destroy');

    });
});

require __DIR__ . '/auth.php';