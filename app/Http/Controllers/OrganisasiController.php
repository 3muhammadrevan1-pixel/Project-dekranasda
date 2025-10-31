<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\TbMenuData; // Menggunakan Model data pusat

class OrganisasiController extends Controller
{
    /**
     * Menampilkan data Struktur Organisasi (banyak anggota).
     * Data diambil dari TbMenuData dengan jenis_konten = 'organisasi'.
     */
    public function index()
    {
        // FIX: Mengambil SEMUA data anggota Organisasi (karena view menggunakan @foreach $organisasi)
        // Diurutkan berdasarkan tanggal terbaru atau urutan yang ditentukan.
        $organisasi = TbMenuData::ofJenis('organisasi')
                                    ->orderBy('date', 'desc') 
                                    ->get(); 
        
        // Mengirimkan variabel $organisasi ke view 'about.organisasi.index'
        return view('about.organisasi.index', compact('organisasi'));
    }
}
