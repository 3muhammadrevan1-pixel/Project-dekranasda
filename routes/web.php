<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\BeritaController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\EventController;
use App\Http\Controllers\OrganisasiController;
use App\Http\Controllers\GaleriController;

// Home route (semua tampilan: berita, galeri, program kerja, produk, dll)
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/home', [HomeController::class, 'index']);


// Route::get('/berita', [BeritaController::class, 'index'])->name('berita.index');
Route::get('/berita/{id}', [BeritaController::class, 'show'])->name('berita.show');

Route::get('/produk', [ProductController::class, 'index'])->name('produk.index');

// Galeri routes
Route::get('/galeri', [GaleriController::class, 'index'])->name('galeri.index');

Route::get('/event', [EventController::class, 'index'])->name('events.index');
Route::prefix('about')->group(function () {
    Route::view('/sejarah', 'about.sejarah')->name('about.sejarah');
    Route::resource('organisasi', OrganisasiController::class)->only(['index']);
});