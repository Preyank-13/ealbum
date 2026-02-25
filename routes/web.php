<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\StudioController;
use App\Http\Controllers\SocialiteController;
use App\Http\Controllers\AlbumController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

// =============================
// ✅ PUBLIC API ROUTE (IMPORTANT)
// =============================
Route::get('/api/galleries', [AlbumController::class, 'apiGalleries']);


// --- Public Routes ---
Route::get('/', function () { 
    return view('user.pages.welcome'); 
})->name('user.pages.welcome');

Route::controller(SocialiteController::class)->group(function () {
    Route::get('/auth/google', 'googlelogin')->name('auth.google');
    Route::get('/auth/google/callback', 'googleAuthentication')->name('auth.google/callback');
});

// User Pages
Route::get('/about', [UserController::class, 'about'])->name('user.about');
Route::get('/contact-us', [UserController::class, 'contact'])->name('user.contact');
Route::get('/pricing', [UserController::class, 'price'])->name('user.price');
Route::get('/blogs', [UserController::class, 'blog'])->name('user.blog');


// --- Auth Protected Routes ---
Route::middleware(['auth', 'verified'])->group(function () {
    
    Route::get('/dashboard', function () { 
        return redirect()->route('admin.index'); 
    })->name('dashboard');

    Route::prefix('admin')->group(function () {

        Route::get('/', [StudioController::class, 'index'])->name('admin.index');
        Route::get('/credit', [StudioController::class, 'credit'])->name('admin.credit');
        Route::get('/smart-selection', [StudioController::class, 'smart'])->name('admin.smartselection');
        Route::get('/create-studio', [StudioController::class, 'studio'])->name('admin.studio'); 
        Route::get('/logout', [StudioController::class, 'logout'])->name('admin.logout');

        Route::get('/profile', [StudioController::class, 'profile'])->name('admin.profile');
        Route::post('/profile/update', [StudioController::class, 'update'])->name('admin.profile.update');

        Route::post('/album/store', [AlbumController::class, 'store'])->name('admin.album.store');
        Route::get('/album-list', [AlbumController::class, 'index'])->name('admin.album.index');

        Route::get('/my-gallery', [AlbumController::class, 'show'])->name('gallery.page');
        Route::get('/admin/my-gallery', [StudioController::class, 'show'])->name('admin.my-gallery');
        Route::put('/admin/my-gallery', [AlbumController::class, 'update'])->name('admin.gallery.update');
        Route::delete('/album/delete/{id}', [AlbumController::class, 'destroy'])->name('admin.album.destroy');

    });
});

require __DIR__ . '/auth.php';