<?php

namespace App\Http\Controllers\Back_End;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Product;
use App\Models\Store;
use App\Models\TbMenu; 
use App\Models\TbMenuData; 
use App\Models\User; // Ditambahkan: Import model User
use Illuminate\Support\Facades\Auth;

class AdminController extends Controller
{
    /**
     * Menampilkan Dashboard Admin/Operator dengan data statistik.
     */
    public function index()
    {
        // 1. Ambil Hitungan (Count) dari masing-masing Model
        $productCount = Product::count();
        $storeCount = Store::count();
        $menuCount = TbMenu::count(); 
        
        // Ditambahkan: Menghitung jumlah User
        $userCount = User::count(); 

        // --- PERUBAHAN UTAMA: Menghitung berdasarkan jenis_konten di TbMenu ---

        // Menghitung Berita: Mengambil data TbMenuData yang menu induknya berjenis 'dinamis'
        $beritaCount = TbMenuData::whereHas('menu', function ($query) {
            $query->where('jenis_konten', 'dinamis');
        })->count();

        // Menghitung Event: Mengambil data TbMenuData yang menu induknya berjenis 'statis'
        $eventCount = TbMenuData::whereHas('menu', function ($query) {
            $query->where('jenis_konten', 'statis');
        })->count();

        // Menghitung Galeri: Mengambil data TbMenuData yang menu induknya berjenis 'media'
        $galeriCount = TbMenuData::whereHas('menu', function ($query) {
            $query->where('jenis_konten', 'media');
        })->count();
        
        // Menghitung jumlah data Struktur Organisasi
        $organisasiCount = TbMenuData::whereHas('menu', function ($query) {
            $query->where('jenis_konten', 'organisasi');
        })->count();

        // 2. Kumpulkan data dalam array
        $stats = [
            'productCount' => $productCount,
            'storeCount' => $storeCount,
            'beritaCount' => $beritaCount,
            'eventCount' => $eventCount,
            'galeriCount' => $galeriCount,
            'menuCount' => $menuCount,
            'organisasiCount' => $organisasiCount,
            'userCount' => $userCount, // Ditambahkan: Statistik User
        ];
        
        // 3. Logika untuk memilih View berdasarkan Role
        $userRole = Auth::user()->role ?? 'guest'; // Ambil role user yang login

        if ($userRole === 'operator') {
            // Jika role adalah operator, kembalikan view operator (yang sudah kita filter card-nya)
            return view('operator.dashboard', compact('stats'));
        }
        
        // Default: Jika role adalah admin, kembalikan view admin
        return view('admin.dashboard.index', compact('stats'));
    }
}