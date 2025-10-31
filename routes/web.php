<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\BeritaController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\EventController;
use App\Http\Controllers\OrganisasiController;
use App\Http\Controllers\GaleriController;
use App\Http\Controllers\StatisPageController;

// Home route (semua tampilan: berita, galeri, program kerja, produk, dll)
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/home', [HomeController::class, 'index']);


// Route::get('/berita', [BeritaController::class, 'index'])->name('berita.index');
Route::get('/berita/{id}', [BeritaController::class, 'show'])->name('berita.show');

Route::get('/produk', [ProductController::class, 'index'])->name('produk.index');

// Galeri routes
Route::get('/galeri', [GaleriController::class, 'index'])->name('galeri.index');

Route::get('/event', [EventController::class, 'index'])->name('events.index');
// Tentang Kami
Route::prefix('about')->group(function () {
    Route::get('/sejarah', [StatisPageController::class, 'sejarah'])->name('about.sejarah');
    Route::resource('organisasi', OrganisasiController::class)->only(['index']);
});
// Route::get('/statis-page/{slug}', [StatisPageController::class, 'index']);