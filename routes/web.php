<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\StudioController;
use App\Http\Controllers\SocialiteController;
use App\Http\Controllers\AlbumController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\RazorpayController;
use Illuminate\Support\Facades\Route;

// USER ROUTES
Route::get('/', function () { 
    return view('user.pages.welcome'); 
})->name('user.pages.welcome');

Route::get('/api/galleries', [AlbumController::class, 'apiGalleries']);

Route::controller(SocialiteController::class)->group(function () {
    Route::get('/auth/google', 'googlelogin')->name('auth.google');
    Route::get('/auth/google/callback', 'googleAuthentication')->name('auth.google/callback');
});

Route::get('/about', [UserController::class, 'about'])->name('user.about');
Route::get('/contact-us', [UserController::class, 'contact'])->name('user.contact');
Route::get('/pricing', [UserController::class, 'price'])->name('user.price');
Route::get('/blogs', [UserController::class, 'blog'])->name('user.blog');

/**
 * RAZORPAY ROUTES (Hamesha /{code} se upar rakhein)
 * Inhe middleware ke bahar rakha hai testing ke liye taaki redirect loop na bane
 */


Route::get("/razorpay", [RazorpayController::class, 'index'])->name('admin.razorpay.index');

Route::post("/razorpay/payment", [RazorpayController::class, 'payment'])->name('razorpay.payment');
Route::get("/razorpay/callback", [RazorpayController::class, 'callback'])->name('razorpay.callback');



Route::get('/access', [UserController::class, 'access'])->name('user.access');
Route::post('/access/verify', [AlbumController::class, 'verifyCode'])->name('user.access.verify');
Route::get('/view-album/{code}', [AlbumController::class, 'showViewer'])->name('user.album.view');
Route::post('/fetch-album-content', [AlbumController::class, 'fetchAlbumContent'])->name('album.fetch');

// Dynamic route hamesha sabse niche hona chahiye
Route::get('/{code}', [UserController::class, 'access'])
    ->where('code', '^(?!login|admin|dashboard|register|api|razorpay).*$');

// ADMIN ROUTES
Route::middleware(['auth', 'verified'])->group(function () {
    
    Route::get('/dashboard', function () { 
        return redirect()->route('admin.index'); 
    })->name('dashboard');

    Route::prefix('admin')->group(function () {

        Route::get('/', [StudioController::class, 'index'])->name('admin.index');
        Route::get('/credit', [StudioController::class, 'credit'])->name('admin.credit'); 
        Route::get('/smart-selection', [StudioController::class, 'smart'])->name('admin.smartselection');
        Route::get('/create-studio', [StudioController::class, 'studio'])->name('admin.studio'); 
        
        Route::post('/logout', [StudioController::class, 'logout'])->name('admin.logout');

        Route::get('/profile', [StudioController::class, 'profile'])->name('admin.profile');
        Route::post('/profile/update', [StudioController::class, 'update'])->name('admin.profile.update');

        Route::get('/album-list', [AlbumController::class, 'index'])->name('admin.album.index');
        Route::post('/album/store', [AlbumController::class, 'store'])->name('admin.album.store');

        Route::get('/my-gallery/{id}', [AlbumController::class, 'edit'])->name('admin.my-gallery');
        Route::put('/my-gallery/{id}', [AlbumController::class, 'update'])->name('admin.gallery.update');
        Route::delete('/album/delete/{id}', [AlbumController::class, 'destroy'])->name('admin.album.destroy');

    });
});

require __DIR__ . '/auth.php';