<?php

namespace App\Http\Controllers\Back_End;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Product;
use App\Models\Store;
use App\Models\TbMenu; 
use App\Models\TbMenuData; 

class AdminController extends Controller
{
    /**
     * Menampilkan Dashboard Admin dengan data statistik.
     */
    public function index()
    {
        // 1. Ambil Hitungan (Count) dari masing-masing Model
        $productCount = Product::count();
        $storeCount = Store::count();
        $menuCount = TbMenu::count(); 

        // Menggunakan scope 'ofJenis' yang sudah didefinisikan di TbMenuData
        $beritaCount = TbMenuData::ofJenis('berita')->count();
        $eventCount = TbMenuData::ofJenis('event')->count();
        $galeriCount = TbMenuData::ofJenis('galeri')->count();
        
        //  Menghitung jumlah data Struktur Organisasi
        $organisasiCount = TbMenuData::ofJenis('organisasi')->count();

        // 2. Kumpulkan data dalam array
        $stats = [
            'productCount' => $productCount,
            'storeCount' => $storeCount,
            'beritaCount' => $beritaCount,
            'eventCount' => $eventCount,
            'galeriCount' => $galeriCount,
            'menuCount' => $menuCount,
            // Masukkan count Struktur Organisasi
            'organisasiCount' => $organisasiCount,
        ];
        
        return view('admin.dashboard.index', compact('stats'));
    }
}
