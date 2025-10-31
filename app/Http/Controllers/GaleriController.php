<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\TbMenuData; // Menggunakan Model data pusat

class GaleriController extends Controller
{
    /**
     * Menampilkan daftar semua item galeri (Index).
     * Menggunakan scope ofJenis('galeri') untuk memfilter data.
     */
    public function index()
    {
        // Ambil semua data dengan jenis_konten = 'galeri' dan paginasi (24 item per halaman, cocok untuk galeri)
        $galeriList = TbMenuData::ofJenis('galeri')->latest()->paginate(24);

        // Mengirimkan variabel $galeriList ke view
        return view('galeri.index', compact('galeriList'))
            ->with('title', 'Galeri Dekranasda Kota Bogor'); // Tambahan title
    }
    
    /**
     * Menampilkan detail spesifik dari satu item galeri (Show).
     */
    public function show(string $id)
    {
        // Cari data berdasarkan ID, pastikan jenis_konten = 'galeri'.
        // Jika tidak ditemukan, otomatis melempar error 404.
        $galeri = TbMenuData::ofJenis('galeri')->findOrFail($id);

        // Mengirimkan variabel $galeri ke view
        return view('galeri.show', compact('galeri'))
             ->with('title', $galeri->title);
    }

}
