<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
// Front-end Controllers - Diasumsikan tetap di folder utama Controllers
use App\Http\Controllers\HomeController;
use App\Http\Controllers\BeritaController;
use App\Http\Controllers\ProductController; 
use App\Http\Controllers\EventController;
use App\Http\Controllers\OrganisasiController;
use App\Http\Controllers\GaleriController;
use App\Http\Controllers\StatisPageController;
use App\Http\Controllers\Back_End\AdminController;

/*
|--------------------------------------------------------------------------
| Web Routes
|-------------------------------------------------------------------------
*/

// ==========================================
// 1. ROUTE FRONT-END (PUBLIC ACCESS) & REDIRECT OTENTIKASI
// ==========================================

// Home route (semua tampilan: berita, galeri, program kerja, produk, dll)
Route::get('/', function () {
    // Cek apakah pengguna sudah login
    if (Auth::check()) {
        // Jika sudah login, redirect ke dashboard yang sesuai
        if (Auth::user()->role === 'admin') {
            return redirect()->route('admin.dashboard');
        } elseif (Auth::user()->role === 'operator') {
            return redirect()->route('operator.dashboard');
        }
    }
    
    // Jika belum login (atau role tidak dikenali), tampilkan halaman Home publik
    // Panggil method index dari HomeController
    return app(\App\Http\Controllers\HomeController::class)->index(request());
})->name('home');

Route::get('/home', [HomeController::class, 'index']);

// Berita routes
Route::get('/berita/{id}', [BeritaController::class, 'show'])->name('berita.show');

// Produk routes
// SEKARANG MEMANGGIL Controller FRONT-END (App\Http\Controllers\ProductController)
Route::get('/produk', [ProductController::class, 'index'])->name('produk.index');

// Galeri routes
Route::get('/galeri', [GaleriController::class, 'index'])->name('galeri.index');

// Event routes
Route::get('/event', [EventController::class, 'index'])->name('events.index');

// Tentang Kami (About) routes
Route::prefix('about')->group(function () {
    Route::get('/sejarah', [StatisPageController::class, 'sejarah'])->name('about.sejarah');
    Route::resource('organisasi', OrganisasiController::class)->only(['index']);
});
// Route::get('/statis-page/{slug}', [StatisPageController::class, 'index']);


// ==========================================
// 2. LOGIN & LOGOUT
// ==========================================
Route::get('/login', fn() => view('auth.login'))->name('login');
// Menggunakan namespace lengkap untuk AuthController Back-end
Route::post('/login', [\App\Http\Controllers\Back_End\AuthController::class, 'login'])->name('login.post');

Route::post('/logout', function (Request $request) {
    Auth::logout();
    $request->session()->invalidate();
    $request->session()->regenerateToken();
    return redirect('/login');
})->name('logout');


// ==========================================
// 4. ROUTE ADMIN
// ==========================================
Route::prefix('admin')->middleware(['auth', 'check_role:admin'])->group(function () {

    Route::get('/dashboard', [AdminController::class, 'index'])->name('admin.dashboard');

    // MENU
    Route::resource('menu', \App\Http\Controllers\Back_End\MenuController::class)->names('admin.menu');

    // MENU DATA
    Route::resource('menu_data', \App\Http\Controllers\Back_End\MenuDataController::class)
        ->names('admin.menu_data')
        ->parameters(['menu_data' => 'menu_data']);

    // TOKO
    Route::resource('toko', \App\Http\Controllers\Back_End\StoreController::class)->names('admin.toko');

    // PRODUK
    Route::resource('produk', \App\Http\Controllers\Back_End\ProductController::class) // Controller Back-end
        ->names('admin.produk')
        ->parameters(['produk' => 'product']);

    Route::post('produk/{product}/variant', [\App\Http\Controllers\Back_End\ProductController::class, 'storeVariant'])
        ->name('admin.produk.storeVariant');

    Route::delete('variant/{variant}', [\App\Http\Controllers\Back_End\ProductController::class, 'destroyVariant'])
        ->name('admin.produk.destroyVariant');

    // USERS
    Route::resource('users', \App\Http\Controllers\Back_End\UserController::class)
        ->names('user') // Diubah namanya menjadi 'admin.users' agar lebih jelas
        ->except(['show']);
});

// ==========================================
// 5. ROUTE OPERATOR
// ==========================================s
Route::prefix('operator')->middleware(['auth', 'check_role:operator'])->group(function () {
    Route::get('/dashboard', fn() => view('operator.dashboard'))->name('operator.dashboard');

    // PRODUK (pakai controller admin)
    Route::get('/produk', [\App\Http\Controllers\Back_End\ProductController::class, 'index'])->name('operator.produk.index');

    // TOKO (pakai controller admin)
    Route::get('/toko', [\App\Http\Controllers\Back_End\StoreController::class, 'index'])->name('operator.toko.index');
});
