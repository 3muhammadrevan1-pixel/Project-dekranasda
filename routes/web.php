<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\BeritaController;
use App\Http\Controllers\ProductController; 
use App\Http\Controllers\EventController;
use App\Http\Controllers\OrganisasiController;
use App\Http\Controllers\GaleriController;
use App\Http\Controllers\StatisPageController;
use App\Http\Controllers\Back_End\AdminController;
use App\Http\Controllers\Back_End\AuthController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// ==========================================
// 1. ROUTE FRONT-END (PUBLIC ACCESS)
// ==========================================

// Home route publik
Route::get('/', [HomeController::class, 'index'])->name('home');

// Home alternatif (legacy / optional)
Route::get('/home', [HomeController::class, 'index']);

// Berita detail
Route::get('/berita/{id}', [BeritaController::class, 'show'])->name('berita.show');

// Produk front-end
Route::get('/produk', [ProductController::class, 'index'])->name('produk.index');

// Tambah click_count produk (AJAX)
Route::post('/product/click/{id}', [ProductController::class, 'addClick'])->name('product.addClick');

// Galeri
Route::get('/galeri', [GaleriController::class, 'index'])->name('galeri.index');

// Event
Route::get('/event', [EventController::class, 'index'])->name('events.index');

// Tentang Kami / About
Route::prefix('about')->group(function () {
    Route::get('/sejarah', [StatisPageController::class, 'sejarah'])->name('about.sejarah');
    Route::resource('organisasi', OrganisasiController::class)->only(['index']);
});

// ==========================================
// 2. LOGIN & LOGOUT (AUTH)
// ==========================================

Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.post');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// ==========================================
// 3. ROUTE ADMIN
// ==========================================
Route::prefix('admin')->middleware(['auth', 'check_role:admin'])->group(function () {

    Route::get('/dashboard', [AdminController::class, 'index'])->name('admin.dashboard');

    Route::resource('menu', \App\Http\Controllers\Back_End\MenuController::class)
        ->names('admin.menu');

    Route::resource('menu_data', \App\Http\Controllers\Back_End\MenuDataController::class)
        ->names('admin.menu_data')
        ->parameters(['menu_data' => 'menu_data']);

    Route::resource('toko', \App\Http\Controllers\Back_End\StoreController::class)
    ->names('admin.toko')
    ->parameters(['toko' => 'store']); // <-- tambahkan ini


    Route::resource('produk', \App\Http\Controllers\Back_End\ProductController::class)
        ->names('admin.produk')
        ->parameters(['produk' => 'product']);

    // Product Variant
    Route::get('produk/{product}/variant/create', [\App\Http\Controllers\Back_End\ProductController::class, 'createVariant'])
        ->name('admin.produk.createVariant');
    Route::post('produk/{product}/variant', [\App\Http\Controllers\Back_End\ProductController::class, 'storeVariant'])
        ->name('admin.produk.storeVariant');
    Route::get('variant/{variant}/edit', [\App\Http\Controllers\Back_End\ProductController::class, 'editVariant'])
        ->name('admin.produk.editVariant');
    Route::put('variant/{variant}', [\App\Http\Controllers\Back_End\ProductController::class, 'updateVariant'])
        ->name('admin.produk.updateVariant');
    Route::delete('variant/{variant}', [\App\Http\Controllers\Back_End\ProductController::class, 'destroyVariant'])
        ->name('admin.produk.destroyVariant');

    // Users
    Route::resource('users', \App\Http\Controllers\Back_End\UserController::class)
        ->names('user')
        ->except(['show']);
});

// ==========================================
// 4. ROUTE OPERATOR
// ==========================================
Route::prefix('operator')->middleware(['auth', 'check_role:operator'])->group(function () {
    Route::get('/dashboard', fn() => view('operator.dashboard'))->name('operator.dashboard');

    // === Toko (CRUD)
    Route::resource('toko', \App\Http\Controllers\Back_End\StoreController::class)
        ->names('operator.toko')
        ->parameters(['toko' => 'store']);

    // === Produk (CRUD)
    Route::resource('produk', \App\Http\Controllers\Back_End\ProductController::class)
        ->names('operator.produk')
        ->parameters(['produk' => 'product']);

    // === Variant Produk (CRUD)
    Route::get('produk/{product}/variant/create', [\App\Http\Controllers\Back_End\ProductController::class, 'createVariant'])
        ->name('operator.produk.createVariant');
    Route::post('produk/{product}/variant', [\App\Http\Controllers\Back_End\ProductController::class, 'storeVariant'])
        ->name('operator.produk.storeVariant');
    Route::get('variant/{variant}/edit', [\App\Http\Controllers\Back_End\ProductController::class, 'editVariant'])
        ->name('operator.produk.editVariant');
    Route::put('variant/{variant}', [\App\Http\Controllers\Back_End\ProductController::class, 'updateVariant'])
        ->name('operator.produk.updateVariant');
    Route::delete('variant/{variant}', [\App\Http\Controllers\Back_End\ProductController::class, 'destroyVariant'])
        ->name('operator.produk.destroyVariant');
});

